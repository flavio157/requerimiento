<?php
    require_once("M_Login.php");
    require_once("M_VerificarCuota.php");
    require_once("../funciones/f_funcion.php");


     $estado = $_POST['accion'];
    if($estado  == 'guardar'){
        C_personalenfalta::personalfaltacouta();
    }else if($estado  == 'lstpersonal'){
        C_personalenfalta::lst_personalfaltacuot();
    }


    class C_personalenfalta
    {
        
        static function personalfaltacouta(){
            $m_login = new M_Login();
          //  $arraydias = array('3','6','9');

            $oficinas = array('SMP3','SMP6');
            $datos = $m_login->VerificarListado_Cuotabaja(date("d-m-Y"));
            if(count($datos) == 0){
                for ($i=0; $i < count($oficinas)  ; $i++) { 
                            $m_login = new M_VerificarCuota($oficinas[$i]); 
                            $personalfalta = $m_login->personalfaltacouta();
                            for ($l=0; $l < count($personalfalta) ; $l++) { 
                                
                        $fecha = C_Asistenciadias($personalfalta[$l][0]);
                        $m_cuotaPersonal = new M_VerificarCuota($oficinas[$i]);
                        $montoSMP = $m_cuotaPersonal->CuotaPersonal($personalfalta[$l][0]);
                        $dias = diasfalto($fecha); 
                        $m_login = new M_Login(); 
                        $cu = $m_login->verificar_couta($personalfalta[$l][0],$oficinas[$i],$montoSMP['CUOTA'],count($dias));
                        
                        if($cu[3] >= 0){
                            $m_login->G_Personal_CuotaBaja($personalfalta[$l],$cu[1],$oficinas[$i]); 
                        }
                    }
                }
            }else{
                C_personalenfalta::lst_personalfaltacuot();
            }
        }

        static function lst_personalfaltacuot(){
            $m_login = new M_Login();
            $personal =   $m_login->lst_personal_cuotabaja();
            $datos  = array(
                'estado' => 'ok',
                'items' => $personal
                );
            echo json_encode($datos,JSON_FORCE_OBJECT); 
        }
    }
    
?>