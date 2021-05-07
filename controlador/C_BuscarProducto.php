<?php
session_start();
require_once("../modelo/M_BuscarProductos.php");


    $accion = $_POST["accion"];
    
    if($accion === "buscar"){
        $nomproducto = $_POST['producto'];
        C_BuscarProducto::BuscaProducto($nomproducto);

    }else if ($accion == "politicaprecios"){
        $cantidad = $_POST['cantidad'];
        $cod_producto = $_POST['codproducto'];
        C_BuscarProducto::PoliticaPrecios($cantidad,$cod_producto);
      
    }else if($accion == "politicabonos"){
        $cantidad = $_POST['cantidad'];
        $cod_producto = $_POST['codproducto'];
        C_BuscarProducto::PoliticaBonos($cantidad,$cod_producto);
    }else if($accion == "bonoitem"){
        $cod_bono = $_POST['codbono'];
        C_BuscarProducto::comboitem($cod_bono);
    }else if($accion == "productobono"){
        $cod_bono = $_POST['codbono'];
        C_BuscarProducto::comboProducto($cod_bono);
    }
   

class C_BuscarProducto
{
    
    static function BuscaProducto($nomproducto)
    {   
        $M_buscarproducto = new M_BuscarProductos();
        if($nomproducto !== ""){
            if($nomproducto == "cm"){
                $c_cod = $M_buscarproducto->M_Combo($nomproducto);
                $datos  = array(
                    'estado' => 'combo',
                    'combo' => $c_cod,
                    );
                    echo json_encode($datos,JSON_FORCE_OBJECT);
            }else{
                $c_cod = $M_buscarproducto->M_BuscarProducto($_SESSION['zona'],$nomproducto);
                $datos  = array(
                    'estado' => 'productos',
                    'producto' => $c_cod,
                    );
                    echo json_encode($datos,JSON_FORCE_OBJECT);
            }
           
        }
    }


    static function PoliticaPrecios($cantidad,$cod_producto){
        $M_politicaPrecio = new M_BuscarProductos();
        if($cantidad != ""){
            $precio = $M_politicaPrecio->M_PoliticaPrecios($_SESSION['zona'],$cantidad,$cod_producto);
           
            if($precio['PRECIO'] != null){
                $datos  = array(
                    'estado' => 'ok',
                    'precio' => $precio['PRECIO'],
                    );
                    echo json_encode($datos,JSON_FORCE_OBJECT);
            }
        }
    }


   
    static function PoliticaBonos($cantidad,$cod_producto)
    {
            $M_politicaBono = new M_BuscarProductos();

            $Bono = $M_politicaBono->M_PoliticaBono($_SESSION['zona'],$cantidad,$cod_producto);
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