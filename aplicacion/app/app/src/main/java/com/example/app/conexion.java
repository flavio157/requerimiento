package com.example.app;

import android.os.StrictMode;
import android.util.Log;


import java.sql.Connection;
import java.sql.DriverManager;

public class conexion {
    public Connection conexionsql(){
        Connection cnn = null;
        try {
            StrictMode.ThreadPolicy polyce = new StrictMode.ThreadPolicy.Builder().permitAll().build();
            StrictMode.setThreadPolicy(polyce);
            Class.forName("net.sourceforge.jtds.jdbc.Driver").newInstance();
            cnn = DriverManager.getConnection("jdbc:jtds:sqlserver://192.168.1.23:1433;databaseName=Almacenes;user=sa;password=123;");
        }catch (Exception e){
            Log.i("error","error");
            Log.i("error",e.getMessage());
        }
        return  cnn;
    }
}
