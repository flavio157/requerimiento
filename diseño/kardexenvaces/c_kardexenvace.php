<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once("m_kardexenvace.php");

    $accion = $_POST['accion'];
    if($accion == 'producto'){
        $codalmacen = oficiona($_POST['oficina']);
        c_kardesenvacex::c_listarproductos($codalmacen);
    }else if($accion == 'filtrar'){
        $fecini = $_POST['fecini'];
        $fecfin = $_POST['fecfin'];
        $id = $_POST['id'];
        $check = $_POST['check'];
        c_kardesenvacex::c_filtrarkardexI($fecini,$fecfin,$id,$check);
    }
    class c_kardesenvacex
    {
        static function c_listarproductos($codproduco){
            $producto = array();
            $m_producto = new m_kardesenvaces();
            $cadena = "'' = ''";
            $c_producto = $m_producto->m_buscar('V_STOCK_TERMINADO',$cadena);
            
            for ($i=0; $i < count($c_producto) ; $i++) { 
                array_push($producto,array(
                    "code" => $c_producto[$i][0],
                    "label" => $c_producto[$i][1],
                    "stock" => $c_producto[$i][5],)
                );    
            }
            $dato = array(
                'dato' => $producto
            );
            echo json_encode($dato,JSON_FORCE_OBJECT);
        }

        static function c_filtrarkardexI($fecini,$fecfin,$id,$check){
            date_default_timezone_set('America/Lima');
            $inicio = strtotime($fecini);
            $fin  = strtotime($fecfin);
            $Stockini = 0;
            $mensaje ="";
            $c_kardex="";
            if($fecini == "" && $check == 1){$mensaje = "Error seleccione fecha inicio";}
            else if($fecfin == "" && $check == 1){$mensaje = "Error seleccione fecha fin";}
            else if($inicio > $fin && $check == 1){ $mensaje = "Error fecha fin no puede ser menor a fecha inicio";}
            else if($id == ""){$mensaje = "Error producto invalido";}
            else{
                $m_producto = new m_kardesenvaces();
                //$cadena = "CAST(fecha as date) >= '$fecini' AND CAST(fecha as date) <= '$fecfin' AND codigo = '$id' ORDER BY fecha ASC";
                //$c_kardex = $m_producto->m_buscar('V_KARDEX_ENVACE',$cadena);
                if($check == 1){
                    $c_kardex = $m_producto->m_kardex_confecha($fecini,$fecfin,$id);
                }else{
                    $c_kardex = $m_producto->m_kardex_sinfecha($id);
                }
                
                if(count($c_kardex) == 0){
                    $mensaje = "No hay movimientos con el producto seleccionado";
                }
                else{
                   $inicial = $m_producto->m_ingreso($id);
                    if(count($inicial) > 0){
                        $Stockini = $inicial[0][2];
                        $cadena = "CAST(fecha as date) < '$fecini' AND codigo = '$id' ORDER BY fecha ASC";
                        $c_kardex1 = $m_producto->m_buscar('V_KARDEX_ENVACE',$cadena);
                        for ($i=0; $i <count($c_kardex1) ; $i++) { 
                            if($i != 0){
                                if($c_kardex1[$i][5] = 'I'){
                                    $Stockini = $Stockini + $c_kardex1[$i][2];
                                }else{
                                    $Stockini = $Stockini - $c_kardex1[$i][2];
                                }
                            }
                        }
                       
                    }
                    $mensaje = "success";   
                }
            }
            $dato = Array(
                'mensaje' =>$mensaje,
                'dato' => $c_kardex,
                'stockini' => $Stockini
            );
            echo json_encode($dato,JSON_FORCE_OBJECT);
        }
    }
?>