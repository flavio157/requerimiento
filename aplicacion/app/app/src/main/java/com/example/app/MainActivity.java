package com.example.app;

import androidx.appcompat.app.AppCompatActivity;

import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.preference.PreferenceManager;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;

import java.sql.Connection;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;

public class MainActivity extends AppCompatActivity {
    EditText txt_usuario;
    EditText txt_pass;
    Button btn_ingresar;
    SharedPreferences sharedpreferences;
    String usu ="" , cont ="" , cod_personal = "";
    Connection cn;
    public static final String usuario = "usuariokey";
    public static final String codpersonal = "codPersonalKey";
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        conexion conn = new conexion();
        cn = conn.conexionsql();

        sharedpreferences = getSharedPreferences("mypref",this.MODE_PRIVATE);
        btn_ingresar = (Button) findViewById(R.id.btn_login);

        if (sharedpreferences.contains(usuario)) {
            Intent intento = new Intent(this, latlng.class);
            intento.putExtra("usuario", sharedpreferences.getString("usuariokey",null ));
            intento.putExtra("codigoPersonal", sharedpreferences.getString("codPersonalKey", null));
            startActivity(intento);
            finish();
        }else{
            btn_ingresar.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View v) {
                    txt_usuario = (EditText)findViewById(R.id.txt_usuario);
                    String usuario = txt_usuario.getText().toString();
                    txt_pass = (EditText)findViewById(R.id.txt_password);
                    String pass = txt_pass.getText().toString();
                    login(usuario,pass);
                }
            });
        }

    }

    public static String getDefaultsPreference(String key, Context context) {
        SharedPreferences preferences = PreferenceManager.getDefaultSharedPreferences(context);
        return preferences.getString(key, null);
    }

    public void login(String usuario , String pass){

        try {
            Statement stm = cn.createStatement();
            ResultSet rst = stm.executeQuery("select * from T_USUARIO_CALL where NOM_USUARIO ='"+usuario.toString()+"'");
            while (rst.next()){
                usu = rst.getString("NOM_USUARIO");
                cont = rst.getString("PDW_USUARIO");
                cod_personal = rst.getString("COD_PERSONAL");
            }
            if(usuario.equals(usu) && pass.equals(cont)){
                GuardarCredenciales(cod_personal,usu);
                Toast.makeText(getApplicationContext(),"BIENVENIDO",Toast.LENGTH_SHORT).show();
                llamar();
            }else{
                Toast.makeText(getApplicationContext(),"ERROR AL INICIAR SESSION",Toast.LENGTH_SHORT).show();
            }
        }catch (SQLException e){
            Log.i("error",e.getMessage());
            Toast.makeText(getApplicationContext(),e.getMessage(),Toast.LENGTH_SHORT).show();
        }
    }

    public void GuardarCredenciales(String cod_personal,String usua) {
        SharedPreferences.Editor editor = sharedpreferences.edit();
        editor.putString(codpersonal, cod_personal);
        editor.putString(usuario, usua);
        editor.commit();
    }


    public void llamar(){
        Intent intento1 = new Intent(this, latlng.class);
        intento1.putExtra("usuario", usu);
        intento1.putExtra("codigoPersonal", cod_personal);
        startActivity(intento1);
        finish();
    }

    @Override
    protected void onDestroy() {

        super.onDestroy();
    }
}