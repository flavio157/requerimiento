<?php
    require_once("../funciones/m_insumos.php");
      $accion = $_POST['accion'];
      if($accion == 'filtro'){
        $fech_ini = $_POST['fech_ini'];
        $fech_fin = $_POST['fech_fin'];  
        c_insumoventas::lstinsumos($fech_ini,$fech_fin);
      }

    class c_insumoventas 
    {

        static function lstinsumos($fech_ini,$fech_fin)
        {
            $insumos = array();
            $valo = array();
            $lstinsumos = new m_insumos();
            $insumo = $lstinsumos->m_lstinsumos('V_LISTA_INSUMOS');
            for ($i=0; $i < sizeof($insumo); $i++) { 
                $compra = c_insumoventas::comprainsumo($fech_ini,$fech_fin,$insumo[$i][0]);
                if(sizeof($compra) > 0){
                    for ($l=0; $l < sizeof($compra); $l++) { 
                        array_push($insumos,array($insumo[$i][1],$compra[$l][2]));
                    }
                }else{
                        array_push($insumos,array($insumo[$i][1],0));
                }
            }
            $dato = array(
                'insumo' => $insumos
            );
            echo json_encode($dato,JSON_FORCE_OBJECT);
        }





        static function ventainsumo($fech_ini,$fech_fin)
        {
          /*  $codformulacion = array();
            $cantenvase = array();
            $cod_prod  = array();
            $insumoV = array();
            $venta = new m_insumos();
            $productos = $venta->m_ProductoV('V_COMP_VENTA','FECHA_CPVE',$fech_ini,$fech_fin);
            for ($i=0; $i < sizeof($productos) ; $i++) {
                array_push($cod_prod,array($productos[$i][0],$productos[$i][1],$productos[$i][2],$productos[$i][3]));
                $insumo = $venta->m_insumosV('V_INSUMOS_USADOS','PRODUCTO',$productos[$i][0]); 
                for ($j=0; $j < sizeof($insumo) ; $j++) {
                   array_push($insumoV,array($insumo[$j][0],$insumo[$j][1],$insumo[$j][3],$insumo[$j][4],$insumo[$j][5]));
                    if(!in_array($insumo[$j][0],$codformulacion)){
                        array_push($codformulacion,$insumo[$j][0]);
                        $envases = $venta->m_insumosV('V_ENVASES','COD_FORMULACION',$insumo[$j][0]);
                        for ($l=0; $l < sizeof($envases) ; $l++) { 
                            array_push($cantenvase , array($envases[$l][0],$envases[$l][1],$envases[$l][3]));
                        }
                    }
                }  
            }
            $dato = array(
                'prod' => $cod_prod,
                'insumo'=> $insumoV,
                'envases' => $cantenvase
            );
            echo json_encode($dato,JSON_FORCE_OBJECT);*/
        }


        static function comprainsumo($fechini, $fechfin,$cod_prod)
        {
           $compraIn = new m_insumos();
           $compra = $compraIn->m_ProductoC($fechini, $fechfin,$cod_prod);
           return $compra; 
        }

    }
?>