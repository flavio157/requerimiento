package com.example.app;

import android.Manifest;
import android.app.Notification;
import android.app.NotificationChannel;
import android.app.NotificationManager;
import android.app.PendingIntent;
import android.app.Service;
import android.content.BroadcastReceiver;
import android.content.Context;
import android.content.Intent;
import android.content.IntentFilter;
import android.content.SharedPreferences;
import android.content.pm.PackageManager;
import android.location.Location;
import android.location.LocationListener;
import android.os.BatteryManager;
import android.os.Build;
import android.os.Bundle;
import android.os.IBinder;
import android.os.Looper;
import android.util.Log;
import android.widget.Toast;

import androidx.annotation.Nullable;
import androidx.core.app.ActivityCompat;
import androidx.core.app.NotificationCompat;

import com.google.android.gms.location.LocationCallback;
import com.google.android.gms.location.LocationRequest;
import com.google.android.gms.location.LocationResult;
import com.google.android.gms.location.LocationServices;

import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;
import java.text.SimpleDateFormat;
import java.util.Date;
import java.util.Locale;

public class LocationService extends Service {
    int bateria;
    public static final String usuario = "usuariokey";
    String codigoPersonal;
    String date;
    Connection cn;
    int reset;
    private LocationCallback locationCallback = new LocationCallback() {
        @Override
        public void onLocationResult(LocationResult locationResult) {
            super.onLocationResult(locationResult);
            if (locationResult != null && locationResult.getLastLocation() != null) {
                double Latitud = locationResult.getLastLocation().getLatitude();
                double longitud = locationResult.getLastLocation().getLongitude();
                //Toast.makeText(getApplicationContext(),"latitud"+Latitud + "longitud" + longitud, Toast.LENGTH_SHORT).show();
                agregar(Latitud,longitud,bateria,codigoPersonal,date);
            }
        }
    };


    @Nullable
    @Override
    public IBinder onBind(Intent intent) {
        throw new UnsupportedOperationException("not yet implemented");
    }


    private void startlocationService() {
        String channelId = "location_notification_channel";
        NotificationManager notificationManager =
                (NotificationManager) getSystemService(Context.NOTIFICATION_SERVICE);
        Intent resultIntent = new Intent();
        PendingIntent pendingIntent = PendingIntent.getActivity(
                getApplicationContext(),
                0,
                resultIntent,
                PendingIntent.FLAG_UPDATE_CURRENT
        );

        NotificationCompat.Builder builder = new NotificationCompat.Builder(
                getApplicationContext(),
                channelId
        );

        builder.setSmallIcon(R.mipmap.ic_launcher);
        builder.setContentTitle("Location service");
        builder.setDefaults(NotificationCompat.DEFAULT_ALL);
        builder.setContentText("Running");
        builder.setContentIntent(pendingIntent);
        builder.setAutoCancel(false);
        builder.setPriority(NotificationCompat.PRIORITY_MAX);

        if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.O) {
            if (notificationManager != null && notificationManager.getNotificationChannel(channelId) == null) {
                NotificationChannel notificationChannel = new NotificationChannel(
                        channelId,
                        "Location service",
                        NotificationManager.IMPORTANCE_HIGH
                );
                notificationChannel.setDescription("Este canal es usado para location service");
                notificationManager.createNotificationChannel(notificationChannel);

            }
        }
        //Toast.makeText(getApplicationContext(),"velocidad" +reset,Toast.LENGTH_SHORT).show();
        LocationRequest locationRequest = new LocationRequest();
        // locationRequest.setInterval(60000 * reset);
        // locationRequest.setFastestInterval(60000 * reset);
         locationRequest.setInterval(60000 * reset);
        locationRequest.setFastestInterval(60000);
        locationRequest.setPriority(LocationRequest.PRIORITY_BALANCED_POWER_ACCURACY);

        if (ActivityCompat.checkSelfPermission(this, Manifest.permission.ACCESS_FINE_LOCATION) != PackageManager.PERMISSION_GRANTED && ActivityCompat.checkSelfPermission(this, Manifest.permission.ACCESS_COARSE_LOCATION) != PackageManager.PERMISSION_GRANTED) {
            return;
        }
        LocationServices.getFusedLocationProviderClient(this).requestLocationUpdates(locationRequest, locationCallback, Looper.getMainLooper());
        startForeground(Constante.LOCATION_SERVICE_ID,builder.build());
    }

    private void stopLocationService(){
        LocationServices.getFusedLocationProviderClient(this)
        .removeLocationUpdates(locationCallback);
        stopForeground(true);
        stopSelf();
    }

    @Override
    public int onStartCommand(Intent intent, int flags, int startId) {
        if (intent!=null){
            String action= intent.getAction();
            if(action!=null){
                if(action.equals(Constante.ACTION_START_LOCATION_SERVICE)){
                    date = new SimpleDateFormat("yyyy-MM-dd", Locale.getDefault()).format(new Date());
                    codigoPersonal = intent.getStringExtra("codPers");
                    conexion conn = new conexion();
                    cn = conn.conexionsql();
                    bateria();
                    consultar();
                    startlocationService();

                }else if(action.equals(Constante.ACTION_STOP_LOCATION_SERVICE)){
                        stopLocationService();
                }
            }
        }
        return super.onStartCommand(intent, flags, startId);
    }


    public void agregar(Double latitud,Double longitud,int bateria,String codigoPersonal,String fecha) {

        try {
            PreparedStatement pst = cn.prepareStatement("insert into android values(?,?,?,?,?)");
            pst.setDouble(1, latitud);
            pst.setDouble(2, longitud);
            pst.setInt(3, bateria);
            pst.setString(4, codigoPersonal);
            pst.setString(5, fecha);
           // Toast.makeText(getApplicationContext(),latitud + " " +
           //         " "+longitud+" " + bateria + " " + codigoPersonal + " " +fecha,Toast.LENGTH_SHORT).show();

            pst.executeUpdate();

           // Toast.makeText(getApplicationContext(),"REGISTRO el DATO",Toast.LENGTH_SHORT).show();
        }catch (SQLException e) {
            Toast.makeText(getApplicationContext(),"Error" +e.getMessage(),Toast.LENGTH_SHORT).show();
            Log.i("error", e.getMessage());
        }
    }


    public void consultar(){
        try {
            Statement stm = cn.createStatement();
            ResultSet rst = stm.executeQuery("select * from T_PARAMETRO");
            while (rst.next()){
                reset = rst.getInt("TIEMPO_RESET");
            }
        }catch (SQLException e){
            Log.i("error",e.getMessage());
            Toast.makeText(getApplicationContext(),e.getMessage(),Toast.LENGTH_SHORT).show();
        }
    }

    public void bateria() {
        BroadcastReceiver bateriaReciever = new BroadcastReceiver() {
            @Override
            public void onReceive(Context context, Intent intent) {

                context.unregisterReceiver(this);
                int currentLevel = intent.getIntExtra(BatteryManager.EXTRA_LEVEL, -1);
                int scale = intent.getIntExtra(BatteryManager.EXTRA_SCALE, -1);
                int level = -1;
                if (currentLevel >= 0 && scale > 0) {
                    level = (currentLevel * 100) / scale;
                }
                bateria = level;
                // txtbateria.setText("Batería: " + level + "%");

            }
        };
        IntentFilter batteryFilter = new IntentFilter(Intent.ACTION_BATTERY_CHANGED);
        registerReceiver(bateriaReciever, batteryFilter);
    }

}