<?php
    require_once("../funciones/m_insumos.php");
      $accion = $_POST['accion'];
      if($accion == 'filtro'){
        $fech_ini = $_POST['fech_ini'];
        $fech_fin = $_POST['fech_fin'];  
        c_insumoventas::ventainsumo($fech_ini,$fech_fin);
      }

    class c_insumoventas 
    {
        static function ventainsumo($fech_ini,$fech_fin)
        {
            $codformulacion = array();
            $envase = "";
            $cod_prod  = array();
            $insumoV = array();
            $venta = new m_insumos();
            $productos = $venta->m_ProductoV($fech_ini,$fech_fin);
            for ($i=0; $i < sizeof($productos) ; $i++) {
                array_push($cod_prod,array($productos[$i][0],$productos[$i][1],$productos[$i][2],$productos[$i][3]));
                $insumo = $venta->m_insumosV('V_INSUMOS_USADOS','PRODUCTO',$productos[$i][0]);       
                for ($j=0; $j < sizeof($insumo) ; $j++) {
                    array_push($insumoV,array($insumo[$j][0],$insumo[$j][1],$insumo[$j][3],$insumo[$j][4],$insumo[$j][5]));
                    if(!in_array($insumo[$j][0],$codformulacion)){
                        array_push($codformulacion,$insumo[$j][0]);
                        $envases =c_insumoventas::c_envases($insumo[$j][0]);
                    }
                }  
            }
            $dato = array(
                'prod' => $cod_prod,
                'insumo'=> $insumoV,
                'envases' => $envases
            );
            echo json_encode($dato,JSON_FORCE_OBJECT);
        }

        static function c_envases($cod_formulacion)
        {
            $venta = new m_insumos();
            $cantenvase = array();
            $envases = $venta->m_insumosV('V_ENVASES','COD_FORMULACION',$cod_formulacion);
            for ($i=0; $i < sizeof($envases) ; $i++) { 
                array_push($cantenvase , array($envases[$i][0],$envases[$i][1],$envases[$i][3]));
            }
            return $cantenvase;
        }
    }
?>