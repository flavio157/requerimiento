<?php

/*usuarios.php*/
class DataBase
{
   
 public static  function Usuarios(){
        try {
            $base_de_datos = new PDO("sqlsrv:server=DESKTOP-PCSH8QU;database=Almacenes", "", "sa");
            $base_de_datos->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $base_de_datos;
            } catch (Exception $e) {
            echo "Ocurrió un error con la base de datos: " . $e->getMessage();
        }
   }

}
?>