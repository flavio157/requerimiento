<?php

require_once("M_BuscarProductos.php");


    $accion = $_POST["accion"];
    
    if($accion === "buscar"){
        $nomproducto = $_POST['producto'];
        $zona = $_POST['zona'];
        C_BuscarProducto::BuscaProducto($nomproducto,$zona);

    }else if ($accion == "politicaprecios"){
        $cantidad = $_POST['cantidad'];
        $cod_producto = $_POST['codproducto'];
        $zona = $_POST['zona'];
        C_BuscarProducto::PoliticaPrecios($cantidad,$cod_producto,$zona);
      
    }else if($accion == "politicabonos"){
        $dt = json_decode($_POST['datos']);
        $zona = $_POST['zona'];
        C_BuscarProducto::PoliticaBonos($dt,$zona);

    }else if($accion == "bonoitem"){
        $cod_bono = $_POST['codbono'];
        C_BuscarProducto::comboitem($cod_bono);

    }else if($accion == "productobono"){
        $cod_bono = $_POST['codbono'];
        C_BuscarProducto::comboProducto($cod_bono);

    }else if ($accion == "verificarprecio"){
        $cantidad = $_POST['cantidad'];
        $cod_producto = json_decode($_POST['codproducto']);
        $zona = $_POST['zona'];
        C_BuscarProducto::vrificarprecio($zona,$cantidad,$cod_producto);
    }
   

class C_BuscarProducto
{
    
    static function BuscaProducto($nomproducto,$zona)
    {   
        $M_buscarproducto = new M_BuscarProductos();
            if(substr($nomproducto, 0, 2) == "CM"){
                $c_cod = $M_buscarproducto->M_Combo($nomproducto);
                $html="";
                foreach($c_cod as $combo){
                    $html.= '<div><a class="suggest-element" data="'.$combo['PRECIO'].'"
                    class ="'.$combo['COD_COMBO'].'" id="'.$combo['NOM_COMPLETO'].'">'.$combo['NOM_COMPLETO'].'</a></div>';
                }
            }else{
               
                $c_cod = $M_buscarproducto->M_BuscarProducto($zona,$nomproducto);
                $html="";
                foreach($c_cod as $producto){
                    $html.= '<div><a class="suggest-element" data="'.$producto['DES_PRODUCTO'].'&'.$producto['PRECIO'].'"  
                            id="'.$producto['CODIGO'].'">'.$producto['DES_PRODUCTO'].'</a></div>';
                }

              
            }
            echo $html;
         
        
    }


    static function vrificarprecio($zona,$cantidad,$dt){
        $M_politicaPrecio = new M_BuscarProductos();
       // print_r($dt->arrayproductos);
       foreach ($dt->arrayproductos as $date){
           
           if($date != null){
            $precio = $M_politicaPrecio->M_PoliticaPrecios($zona,$date->cantidad,$date->cod_producto);
          
            $date->precioproducto = $precio['PRECIO'];
           
           }
            
        }
        
        echo json_encode($dt,JSON_FORCE_OBJECT);
    }




    static function PoliticaPrecios($cantidad,$cod_producto,$zona){
            $M_politicaPrecio = new M_BuscarProductos();
            $precio = $M_politicaPrecio->M_PoliticaPrecios($zona,$cantidad,$cod_producto);
            if($precio['PRECIO'] != null){
                $datos  = array(
                    'estado' => 'ok',
                    'precio' => $precio['PRECIO'],
                    'cod_producto' => $precio['COD_PRODUCTO']
                    );
                    echo json_encode($datos,JSON_FORCE_OBJECT);
            }
        
    }

    


    static function PoliticaBonos($dt,$zona)
    {
            $M_politicaBono = new M_BuscarProductos();
            $mensaje = "";
            $cantidad = 0;
            $promo = 0;
            $tipo=0;
            $dif= "";
           
            foreach ($dt->arrayproductos as $date){
                if($date != null){
                    $Bono = $M_politicaBono->M_PoliticaBono($zona,$date->cantidad);  
                    if($date->promocion <= $Bono['BONO'] && $date->promocion != 0){
                        break;
                    }else{
                        $tipo = 1;
                        break;
                    } 
                } 
            }

            if($tipo == 1){
                foreach ($dt->arrayproductos as $date){
                    if(isset($date->cod_producto)){
                        $cantidad += intval($date->cantidad);
                        $promo += intval($date->promocion);  
                    }
                }  

                $Bono = $M_politicaBono->M_PoliticaBono($zona,$cantidad);  

                if($cantidad >= 20){
                    $dato = intval(($cantidad / 20)) * $Bono['BONO'];
                    if($dato < $promo){
                        $estado = 'error';
                        $mensaje =  'La promocion no corresponde a la cantidad';
                    }else{
                        $estado = 'ok';
                        $dif = 'com';
                    }
                }else {
                   
                    if($promo > $Bono['BONO']){
                        $estado = 'error';
                        $mensaje = 'La promocion no corresponde a la cantidad';
                    }else{
                        $estado = 'ok';
                        $dif = 'com';
                    }
                }
            }else{
                foreach($dt->arrayproductos as $date){
                    if($date != null){
                        $Bono = $M_politicaBono->M_PoliticaBono($zona,$date->cantidad);  
                        if($Bono["BONO"] != null && $date->promocion > $Bono["BONO"]){
                            $estado = 'error';
                            $mensaje = 'La promocion no corresponde a la cantidad';
                            break; 
                        }else{
                            $estado = 'ok';
                            $dif = 'nor';
                        }
                    }
                }  
            }
            $datos  = array(
                'estado' => $estado,
                'mensaje' => $mensaje,
                'dif' => $dif,
                'tipo' => $tipo
            );
            
            echo json_encode($datos,JSON_FORCE_OBJECT);

    }


    static function comboitem($cod_combo)
    {
        $M_politicaPrecio = new M_BuscarProductos();
        $codigosProducto =   $M_politicaPrecio->M_ComboItem($cod_combo);
        print_r($codigosProducto);
    }

    static function comboProducto($cod_combo)
    {
        $M_politicaPrecio = new M_BuscarProductos();
        $codigosProducto =   $M_politicaPrecio->M_ComboProducto($cod_combo);
        $datos  = array(
            'estado' => 'ok',
            'datos' => $codigosProducto,
            );
            echo json_encode($datos,JSON_FORCE_OBJECT);
    }
}

?>
