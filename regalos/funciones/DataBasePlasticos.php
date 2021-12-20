<?php

/*usuarios.php*/
class DataBasePlasticos
{
     /*Database::Conectar()*/
    public static  function Conectar(){
            try {
              //  $base_de_datos = new PDO("sqlsrv:server=vpnsmp.ddns.net;database=PLASTICOS", "flavio", "flavio2021");
                $base_de_datos = new PDO("sqlsrv:server=DESKTOP-PCSH8QU;database=Plasticos", "", "pla");
                $base_de_datos->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                return $base_de_datos;
                } catch (Exception $e) {
                echo "Ocurrió un error con la base de datos: " . $e->getMessage();
            }
    }
}
?>