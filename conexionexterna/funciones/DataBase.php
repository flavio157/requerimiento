<?php
 /*Database::Conectar()*/
class DataBase 
{
    

    public static  function Conectar(){
            try {
                //sqlsrv:server=vpnprevilife.ddns.net;database=ALMACENES", "Flavio", "Flavio2021
                $base_de_datos = new PDO("sqlsrv:server=vpnprevilife.ddns.net;database=ALMACENES", "Flavio", "Flavio2021");
                $base_de_datos->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                return $base_de_datos;
                } catch (Exception $e) {
                echo "Ocurrió un error con la base de datos: " . $e->getMessage();
            }
    }



}
?>