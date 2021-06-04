<?php

class DatabaseDinamica
{
    /*DatabaseDinamica::Conectarbd($ofi)*/
    public static  function Conectarbd($database){
        try {
           
            $server = "DESKTOP-PCSH8QU";
            $base_de_datos = new PDO("sqlsrv:server=$server;database=$database", "", "sa");
            $base_de_datos->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $base_de_datos;
            } catch (Exception $e) {
            echo "Ocurrió un error con la base de datos: " . $e->getMessage();
        }
    }
}

?>