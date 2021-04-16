<?php

class ClassConexionSMP2
{
    public static  function conexionSMP2(){
        try {
            $base_de_datos = new PDO("sqlsrv:server=DESKTOP-PCSH8QU;database=SMP2", "", "sa");
            $base_de_datos->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $base_de_datos;
            } catch (Exception $e) {
            echo "Ocurrió un error con la base de datos: " . $e->getMessage();
        }
    }
}

?>