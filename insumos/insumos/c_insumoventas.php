<?php
    require_once("../funciones/m_insumos.php");
      $accion = $_POST['accion'];
      if($accion == 'filtro'){
        $fech_ini = $_POST['fech_ini'];
        $fech_fin = $_POST['fech_fin'];  
        if($fech_ini != "" || $fech_fin != "")
        c_insumoventas::lstinsumos($fech_ini,$fech_fin);
        else
        print_r("error");
      }else if($accion == 'envaces'){
        $fech_ini = $_POST['fech_ini'];
        $fech_fin = $_POST['fech_fin'];  
        if($fech_ini != "" || $fech_fin != "")
        c_insumoventas::c_envaces($fech_ini,$fech_fin);
        else
        print_r("error");
      }

    class c_insumoventas 
    {

        static function lstinsumos($fech_ini,$fech_fin)
        {  
           $insarray = array();
           $insucod= array();
           $lstinsumos = new m_insumos();
           $prodvent = $lstinsumos->m_formulaxProd($fech_ini,$fech_fin,'V_COMP_VENTA','FECHA_CPVE');
         
           for ($i=0; $i <sizeof($prodvent) ; $i++) { 
               $insumXproc =c_insumoventas::insumoXproduc($prodvent[$i][2]);
              
               for ($l=0; $l < sizeof($insumXproc); $l++) { 
                    array_push($insucod,$insumXproc[$l][3]);
                    $compra_insu = $lstinsumos->m_insum_compra($fech_ini,$fech_fin,'1',$insumXproc[$l][3]);
                    $totalinsu = $insumXproc[$l][2] * $insumXproc[$l][5] / $prodvent[$i][4];
                        
                   if(sizeof($compra_insu) > 0){ 
                        array_push($insarray,array($insumXproc[$l][3],$insumXproc[$l][4],round($totalinsu,2),$compra_insu[0][2]));  
                   }else{
                    array_push($insarray,array($insumXproc[$l][3],$insumXproc[$l][4],round($totalinsu,2),0)); 
                   }
               }
           }
           $compra_insu = $lstinsumos->m_insum_compra($fech_ini,$fech_fin,'0','');
           
           for ($k=0; $k < sizeof($compra_insu); $k++) { //si no esta en el primer for es por que no se vendio ningun producto que nesecite el insumo
                if(!in_array($compra_insu[$k][0],$insucod)){
                    
                    array_push($insarray,array($compra_insu[$k][0],$compra_insu[$k][1],0,$compra_insu[$k][2]));
                } 
            } 

            
           $agrupado = c_insumoventas::agrupar($insarray);
           
           $dato = array(
                'insumo' => $agrupado,
            );
            echo json_encode($dato,JSON_FORCE_OBJECT);
        }

     

        static function c_envaces($fech_ini,$fech_fin){
            $envases = array();
            $insumos = new m_insumos();
            $cod_for = array();
            $prodvent = $insumos->m_formulaxProd($fech_ini,$fech_fin,'V_COMP_VENTA','FECHA_CPVE');
            for ($i=0; $i < sizeof($prodvent) ; $i++) { 
                $insumXproc =c_insumoventas::insumoXproduc($prodvent[$i][2]);
                for ($l=0; $l <  sizeof($insumXproc); $l++) { 
                    if(!in_array($insumXproc[$l][0],$cod_for)){
                        array_push($cod_for,$insumXproc[$l][0]); 
                        $envece = $insumos->m_insumosV('V_ENVASES','COD_FORMULACION',$insumXproc[$l][0]);
                        for ($k=0; $k < sizeof($envece); $k++) { 
                            array_push($envases,array($envece[$k][0],$envece[$k][3],$prodvent[$i][4],0));
                        }
                    }
                }
            }   
          
           $agrupado =  c_insumoventas::agrupar($envases);
            $dato = array(
                'envases' => $agrupado,
            );
            echo json_encode($dato,JSON_FORCE_OBJECT);
        }

        static function insumoXproduc($Codproducto)
        {
            $insumos = new m_insumos();
            $insumo = $insumos->m_insumosV('V_INSUMOS_USADOS','PRODUCTO',$Codproducto);
            return $insumo; 
        }

        static function agrupar($original)
        {
            $result = array();
            foreach($original as $t) {
                $repeat=false;
                for($i=0;$i<count($result);$i++)
                {
                    if($result[$i]['id']==$t[0])
                    {
                        $result[$i]['salida']+=$t[2];
                        $result[$i]['ingreso']+=$t[3];
                        $repeat=true;
                        break;
                    }
                }
                if($repeat==false)
                    $result[] = array('id' => $t[0],'nombre' => $t[1],'salida' => round($t[2],2) ,
                    'ingreso' => round($t[3],2));
            }
            return $result;     
        }
    }
?>