<?php
/*public $contraseña = "sa";
public $usuario = "";
public $nombreBaseDeDatos = "SMP2";
public $rutaServidor = "DESKTOP-PCSH8QU";*/

class ClassConexion
{
 public static  function conexion(){
        try {
            $base_de_datos = new PDO("sqlsrv:server=DESKTOP-PCSH8QU;database=SMP2", "", "sa");
            $base_de_datos->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $base_de_datos;
           /* echo "conexion";*/
            } catch (Exception $e) {
            echo "Ocurrió un error con la base de datos: " . $e->getMessage();
        }
   }
 
}
?>