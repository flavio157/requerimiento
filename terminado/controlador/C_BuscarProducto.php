<?php

require_once("../modelo/M_BuscarProductos.php");


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
        $cantidad = $_POST['cantidad'];
        $cod_producto = $_POST['codproducto'];
        $zona = $_POST['zona'];
        C_BuscarProducto::PoliticaBonos($cantidad,$cod_producto,$zona);

    }else if($accion == "bonoitem"){
        $cod_bono = $_POST['codbono'];
        C_BuscarProducto::comboitem($cod_bono);

    }else if($accion == "productobono"){
        $cod_bono = $_POST['codbono'];
        C_BuscarProducto::comboProducto($cod_bono);
    }
   

class C_BuscarProducto
{
    
    static function BuscaProducto($nomproducto,$zona)
    {   
        $M_buscarproducto = new M_BuscarProductos();
            if(substr($nomproducto, 0, 2) == "CM"){
                $c_cod = $M_buscarproducto->M_Combo($nomproducto);
                $datos  = array(
                    'estado' => "combo",
                    'combo' => $c_cod,
                    );
            }else{
               
                $c_cod = $M_buscarproducto->M_BuscarProducto($zona,$nomproducto);
                /*$c_cod = $M_buscarproducto->M_BuscarProducto_WEB($nomproducto);*/ /*retorna el producto con su precio web*/
                $datos  = array(
                    'estado' => 'productos',
                    'producto' => $c_cod,
                    );
            }
            echo json_encode($datos,JSON_FORCE_OBJECT);
        
    }


    static function PoliticaPrecios($cantidad,$cod_producto,$zona){
            $M_politicaPrecio = new M_BuscarProductos();
            $precio = $M_politicaPrecio->M_PoliticaPrecios($zona,$cantidad,$cod_producto);
            if($precio['PRECIO'] != null){
                $datos  = array(
                    'estado' => 'ok',
                    'precio' => $precio['PRECIO'],
                    );
                    echo json_encode($datos,JSON_FORCE_OBJECT);
            }
        
    }


    
    static function PoliticaBonos($cantidad,$cod_producto,$zona)
    {
            $M_politicaBono = new M_BuscarProductos();
            $Bono = $M_politicaBono->M_PoliticaBono($zona,$cantidad,$cod_producto);
            $dato = $Bono['BONO'];
            if($Bono!= 0){
                if($cantidad >= 20){
                    if(strlen($cantidad) == 2){
                        $cifra = $cantidad[0]; 
                    }else if (strlen($cantidad) == 3){
                        $cifra = $cantidad[0].''.$cantidad[1];
                    }else if(strlen($cantidad) == 4){
                        $cifra = $cantidad[0].''.$cantidad[1].''.$cantidad[2];
                    }
                    $dato = $Bono['BONO'] * ($cifra-1);
                }
            }else{
                $dato = 0;
            }
            $array  = array(
                'estado' => 'ok',
                'bono' =>  $dato,
                );
            echo json_encode($array,JSON_FORCE_OBJECT);
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