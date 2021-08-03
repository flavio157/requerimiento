package com.example.app;


import androidx.annotation.NonNull;
import androidx.appcompat.app.AppCompatActivity;
import androidx.core.app.ActivityCompat;
import androidx.core.content.ContextCompat;

import android.Manifest;
import android.app.ActivityManager;
import android.content.Context;
import android.content.Intent;
import android.content.pm.PackageManager;
import android.os.Bundle;
import android.provider.Settings;
import android.view.View;
import android.widget.Button;
import android.widget.TextView;
import android.widget.Toast;

public class latlng extends AppCompatActivity {
    Button btn_iniciar;
    Button btn_detener;
    TextView txtcodigoPersonal;
    TextView txtusuario;

    private static final int REQUEST_CODE_LOCATION_PERMISSION = 1;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_latlng);
        btn_iniciar = (Button) findViewById(R.id.btn_iniciar);
        btn_detener = (Button) findViewById(R.id.btn_detener);
        txtcodigoPersonal = (TextView) findViewById(R.id.tvcodigo);
        txtusuario = (TextView) findViewById(R.id.tvusuario);


        Bundle datos = this.getIntent().getExtras();
        String usuario = datos.getString("usuario");
        String codigoPersonal = datos.getString("codigoPersonal");

        txtusuario.setText(usuario);
        txtcodigoPersonal.setText(codigoPersonal);

        btn_iniciar.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                if(checkIfLocationOpened()){
                    if ((ContextCompat.checkSelfPermission(getApplicationContext(), android.Manifest.permission.ACCESS_FINE_LOCATION) != PackageManager.PERMISSION_GRANTED)) {
                        ActivityCompat.requestPermissions(latlng.this,new String[]{Manifest.permission.ACCESS_FINE_LOCATION, Manifest.permission.ACCESS_BACKGROUND_LOCATION},REQUEST_CODE_LOCATION_PERMISSION);
                    }else{
                        startLocationService();
                    }
                }else{
                    Toast.makeText(getApplicationContext(),"ERROR: POR FAVOR ACTIVAR EL GPS",Toast.LENGTH_SHORT).show();
                }

            }
        });


       btn_detener.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                stopLocationService();
            }
        });

    }



    private boolean islocationServiceRunnnig(){
        ActivityManager activityManager = (ActivityManager) getSystemService(Context.ACTIVITY_SERVICE);
        if(activityManager != null){
            for (ActivityManager.RunningServiceInfo service : activityManager.getRunningServices(Integer.MAX_VALUE)){
                if (LocationService.class.getName().equals(service.service.getClassName())){
                    if (service.foreground){
                        return true;
                    }
                }
            }
            return false;
        }
        return  false;
    }

    private void startLocationService(){
        if(!islocationServiceRunnnig()){
            Intent intent = new Intent(getApplicationContext(),LocationService.class);
            intent.setAction(Constante.ACTION_START_LOCATION_SERVICE);
            intent.putExtra("codPers", txtcodigoPersonal.getText());
            startService(intent);
            Toast.makeText(this,"PROCESO INICIADO",Toast.LENGTH_SHORT).show();
        }
    }

    private void stopLocationService(){
        if(islocationServiceRunnnig()){
            Intent intent = new Intent(getApplicationContext(),LocationService.class);
            intent.setAction(Constante.ACTION_STOP_LOCATION_SERVICE);
            startService(intent);
            Toast.makeText(this,"SE DETUVO EL PROCESO",Toast.LENGTH_SHORT).show();
        }
    }


    @Override
    public void onRequestPermissionsResult(int requestCode, @NonNull String[] permissions, @NonNull int[] grantResults) {
        super.onRequestPermissionsResult(requestCode, permissions, grantResults);
        if (requestCode ==REQUEST_CODE_LOCATION_PERMISSION && grantResults.length > 0 ){
            if(grantResults[0] == PackageManager.PERMISSION_GRANTED){
                startLocationService();
            }else{
                Toast.makeText(this,"SE NEGO EL PERMISO" ,Toast.LENGTH_SHORT).show();
            }
        }
    }

    private boolean checkIfLocationOpened() {
        String provider = Settings.Secure.getString(getContentResolver(), Settings.Secure.LOCATION_PROVIDERS_ALLOWED);
        //System.out.println("Provider contains=> " + provider);
        if (provider.contains("gps") || provider.contains("network")){
            return true;
        }
        return false;
    }

 }
