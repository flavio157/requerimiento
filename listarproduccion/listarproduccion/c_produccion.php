<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once("../funciones/f_funcion.php");
require_once("m_produccion.php");

    $accion = $_POST['accion'];  
    if($accion == 'lstproduccion'){
        c_produccion::c_itemsformula();
    }else if($accion == 'ocurrencia'){
        $produccion = $_POST['produccion'];
        $observacion = $_POST['ocurrencia'];
        $usu = $_POST['usu'];
        c_produccion::c_registrar_ocurrencia($produccion,$observacion,$usu);
    }else if($accion == 'gdatos'){
            $produccion = $_POST['produccion'];
            $fechmerma = $_POST['fechmerma'];
            $horamerma = $_POST['horamerma'];
            $fechincidencia = $_POST['fechincidencia'];
            $horaincidencia = $_POST['horaincidencia'];
            $observacion = $_POST['observacion'];
            $usu = $_POST['usu'];
            $t = $_POST['t'];
            $items = json_decode($_POST['items']);
            c_produccion::c_registrardatos($produccion,$fechmerma,$horamerma,$fechincidencia,$horaincidencia,
            $observacion,$usu,$t,$items);

    }else if($accion == 'insumo'){
        $produccion = $_POST['produccion'];
        c_produccion::c_buscarxinsumo($produccion);
    }else if($accion == 'gavances'){
        $tara = $_POST['mdtara'];
        $pesoneto = $_POST['mdpesoneto'];
        $cantxpaquete = $_POST['mdcantxcaja'];
        $paquexsacar = $_POST['mdcajasxsacar'];
        $lote = $_POST['mdlote'];
        $produccion= $_POST['mdcodprod'];
        $usu = $_POST['usu'];
        $total = $_POST['total'];
        $fin = $_POST['fin'];
        $producto = $_POST['mdproduc'];
        $totalproduc = $_POST['mdtotal'];
        c_produccion::c_gavances($tara,$pesoneto,$cantxpaquete,$paquexsacar,$lote,$produccion,$usu,$total,
        $fin,$producto,$totalproduc);
    }else if($accion == 'v_avances'){
        $produccion  = $_POST['produccion'];
        c_produccion::v_avances($produccion);
    }else if($accion == 'gavancesitems'){
        $cantavance = $_POST['avance'];
        $prod = $_POST['produ'];
        $usu = $_POST['usu'];
        $fin = $_POST['fin'];
        $producto = $_POST['mdproduc'];
        c_produccion::c_gitemsavance($cantavance,$usu,$prod,$fin,$producto);
    }else if($accion == 'validafinpro'){
        $codproduccion = $_POST['produccion'];
        $cantidad = $_POST['cantidad'];
        $cantxpa = $_POST['cantxpa'];
        $total = $_POST['total'];
        c_produccion::c_verifinpro($codproduccion,$cantidad,$cantxpa,$total);
    }else if($accion == 'lstavance'){
        $produccion = $_POST['produccion'];
        c_produccion::c_lstavance($produccion);
    }else if($accion == 'updimpresion'){
        $avance = $_POST['avance'];
        c_produccion::c_actualizar_impresion($avance);
    }else if($accion == 'lstocurrencia'){
        $produccion = $_POST['produccion'];
        c_produccion::c_ocurrencia($produccion);
    }


    class c_produccion
    {
        static function c_buscarxinsumo($produccion)
        {   
            $mensaje = '';$c_itemsform = '';
            if(strlen(trim($produccion)) == 0){$mensaje = 'Error seleccione la produccion';}
            $m_formula = new m_produccion();
            if($mensaje == ''){
                $cadena = "produccion = '$produccion'";
                $c_itemsform = $m_formula->m_buscar('V_INSUMOS_PRODUCCION',$cadena);
                $mensaje = '1';
            }
            $dato = array('dato' => $c_itemsform,'m' => $mensaje);
            echo json_encode($dato,JSON_FORCE_OBJECT);
        }

        static function c_itemsformula()
        {
            $m_formula = new m_produccion();
            $cadena = "estado = '0'";
            $c_formula = $m_formula->m_buscar('V_LISTAR_PRODUCCION',$cadena);
            $dato = array('dato' => $c_formula);
            echo json_encode($dato,JSON_FORCE_OBJECT);
        }


        static function c_ocurrencia($produccion)
        {
            $m_formula = new m_produccion();
            $cadena = "COD_PRODUCCION = '$produccion'";
            $c_ocurrencia = $m_formula->m_buscar('T_OCURRENCIAS',$cadena);
            $dato = array('dato' => $c_ocurrencia);
            echo json_encode($dato,JSON_FORCE_OBJECT);
        }



        static function c_registrar_ocurrencia($produccion,$observacion,$usu)
        {
            if(strlen(trim($produccion)) == 0){print_r("Error seleccione produccion");return;}
            if(strlen(trim($observacion)) == 0){print_r("Error ingrese datos del campo observación"); return;}
            if(is_numeric($observacion)){print_r("Error observación no puede ser solo numeros"); return;}
            $m_produccion = new m_produccion();
            $c_produccion = $m_produccion->m_guardarocurrencia($produccion,$observacion,$usu);
            print_r($c_produccion);
        }

        static function c_registrardatos($codproduccion,$fechmerma,$horamerma,$fechincidencia,$horaincidencia,
        $observacion,$usu,$t,$items)
        {
            $dato = c_produccion::c_validardatos($fechmerma,$horamerma,$fechincidencia,$horaincidencia,
            $observacion,$t);
            if(count($items->r)==0){print_r("Error ingrese material"); return;}
            $m_produccion = new m_produccion();
            if($dato == ''){
                if($t == 'm'){
                    $merma = $m_produccion->m_guardarmerma($codproduccion,
                    $fechmerma,$horamerma,$fechincidencia,$horaincidencia,$observacion,$usu,$items);
                    print_r($merma);
                }else if($t == 'r'){
                    $merma = $m_produccion->m_guardarresiduos($codproduccion,$observacion,$usu,$items);
                    print_r($merma);
    
                }else if ($t == 'd'){
                    $merma = $m_produccion->m_guardardesechos($codproduccion,$observacion,$usu,$items);
                    print_r($merma);
                }
            }else{
                print_r($dato);
            }
            
        }

        static function c_validardatos($fechmerma,$horamerma,$fechincidencia,$horaincidencia,
        $observacion,$t)
        {
            if($t == 'm'){
                if(strlen(trim($fechmerma)) == 0){return "Error seleccione fecha merma";}
                if(strlen(trim($horamerma)) == 0){return "Error ingrese hora merma";}
                if($horamerma == '00:00'){return "Error la hora merma no puede ser 00:00";}
               
                if(strlen(trim($fechincidencia)) == 0){return "Error seleccione fecha incidencia";}
                if(strlen(trim($horaincidencia)) == 0){return "Error ingrese hora merma";}
                if($horaincidencia == '00:00'){return "Error la hora incidencia no puede ser 00:00";}
            }
            if(strlen(trim($observacion)) == 0){return "Error ingrese observación";}
            return '';
        }

        static function c_gavances($tara,$pesoneto,$cantxbolsa,$paquexsacar,$lote,$produccion,$usu,$total,$fin,
        $producto,$totalproduc){
            $resul = c_produccion::c_validarfinrprod($tara,$pesoneto,$cantxbolsa,$paquexsacar,$lote);
            if($resul == ""){
               $m_produccion = new m_produccion();
                $c_produccion = $m_produccion->m_gvances($tara,$pesoneto,$cantxbolsa,$paquexsacar,$lote,
                $produccion,$usu,$total,$fin,$producto,$totalproduc); /**/
                print_r($c_produccion);
            }else{print_r($resul);}
        }   

        static function c_gitemsavance($cantavance,$usu,$prod,$fin,$producto)
        {
            $m_produccion = new m_produccion();
            $c_produccion = $m_produccion->m_itemavance($cantavance,$usu,$prod,$fin,$producto);
            print_r($c_produccion);
        }

        static function v_avances($produccion){
            $faltante = 0;
            $c_avances = c_produccion::c_buscaravance($produccion);
            if(count($c_avances) > 0){
                for ($i=0; $i < count($c_avances); $i++) { 
                      $faltante += $c_avances[$i][6];     
                }
                $faltante = $c_avances[0][5] - $faltante;
                $dato = array('t' => '1', 'dato' => $c_avances ,'falta' => $faltante);
            }else{
                $dato = array('t' => '0');
            }
            echo json_encode($dato,JSON_FORCE_OBJECT);
        }

        static function c_validarfinrprod($tara,$pesoneto,$cantxbolsa,$paquexsacar,$lote)
        {
            if(strlen(trim($tara)) == 0){return "Error ingrese tara";}
            if(!is_numeric($tara)){return "Error tara solo numeros";}
            if(strlen(trim($pesoneto)) == 0){return "Error ingrese peso total";}
            if(!is_numeric($pesoneto)){return "Error solo numeros en peso total";}
            if(strlen(trim($pesoneto)) == 0){return "Error ingrese peso total";}
            if(!is_numeric($pesoneto)){return "Error solo numeros en peso total";}
            if($paquexsacar ==0 ){return "Error paquete por sacar no puede ser 0";}
            return "";
        }

        static function c_verifinpro($codproduccion,$cantidad,$cantxpa,$total)
        {
            if($cantxpa > $total){print_r("Error cantidad es mayor a la actual fabricación"); return;}
            if($cantxpa == '0'){print_r("Error cantidad  no puede ser cero"); return;}
            if(strlen(trim($cantxpa)) == 0){print_r("Error ingrese cantidad"); return;}
            $faltante = 0;
            $c_avance = c_produccion::c_buscaravance($codproduccion);
            if(count($c_avance) == 0){
                if(($cantxpa * $cantidad) >= $total){print_r(0);}else{print_r(1);}
            }else{
                for ($i=0; $i < count($c_avance); $i++) { 
                    $faltante += $c_avance[$i][6];     
                }
                $faltante += $cantidad;
                if($faltante == $c_avance[0][5]){print_r(0);}
                else print_r(1);
            }
        }

        static function c_lstavance($produccion)
        {   
            $faltante = 0;$tipo = 0;
            $c_avance = c_produccion::c_buscaravance($produccion);
            $m_producto = new m_produccion();
            $cadena = "produccion = '$produccion' AND impreso = '0'";
            $c_produccion = $m_producto->m_buscar('V_VIEW_AVANCES',$cadena);
            for ($i=0; $i < count($c_avance); $i++) { 
                $faltante += $c_avance[$i][6];     
            }
            $fecha = convFecSistema($c_produccion[0][4]);
            if($faltante == $c_produccion[0][5]){$tipo = 0;}else{$tipo = 1;}
            $dato = array('dato' => $c_produccion,'tipo' => $tipo,'id' => $c_produccion[0][0],
            'fecha' => $fecha);
            echo json_encode($dato,JSON_FORCE_OBJECT);
        }

        static function c_buscaravance($codproduccion){
            $m_produccion = new m_produccion();
            $consulta = "produccion = '$codproduccion'";
            $c_avance = $m_produccion->m_buscar('V_VIEW_AVANCES',$consulta);
            return $c_avance;
        }


        static function c_actualizar_impresion($avance){
            $m_producto = new m_produccion();
            $c_produccion = $m_producto->m_actualizar_impresion($avance);
            print_r($c_produccion);
        }

    }
?>