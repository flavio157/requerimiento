<?php
require_once("../Funciones/f_funcion.php");


   $verificar = $_POST['verificar'];
 
   
    if ($verificar =="contrato") {
        $nr_contrato = $_POST['nr_contrato'];
        C_verificar::contrato($nr_contrato);
    }else if($verificar == "generarcodigo"){
        C_verificar::generarCodigo();
    }


class C_verificar
{   
    static function contrato($nr_contrato)
    {
      $nro_contrato = completarcontrato($nr_contrato);
      print_r($nro_contrato);
    }

    static function generarCodigo(){
        $codigogenerado=generarCodigo(6,4);;
        print_r($codigogenerado);
    }
}

?>