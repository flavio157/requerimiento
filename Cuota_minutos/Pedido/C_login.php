<?php
date_default_timezone_set('America/Lima');
require_once("M_CDR.php");
require_once("../Funciones/f_funcion.php");


   $src = $_POST['src'];
   
    if ($src != "") {
        C_Login::C_usuario($src,$src);
    }else{
        return header("Location:  ../index.php");
    }


class C_Login
{
    static function C_usuario($src,$src1){   
        $minDisReque =[5,5]; /*dias y minutos */
        $segundos = 0;

        $dia = restarDias(new DateTime(),$minDisReque[0]);
        $dia = date("d-m-Y",strtotime(date("d-m-Y")."-".$dia."days"));

        $m_login = new M_CDR();
        $datoscdr = $m_login->CDR($dia,$src,$src1);

        
            foreach ($datoscdr as $datos){
                $segundos += $datos['duration'];
            }
    
            $minechos = seguMinu($segundos);
            $valor = verificarCuotaLlamadas($minechos,$minDisReque[1]);
        
            if($valor){
                echo "SIN RESTRICCIÓN";
            }else{
                echo "NO SE LLEGO A LA CUOTA EN MINUTOS";
            }
      
      
    }
}

?>