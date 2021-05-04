<?php
session_start();
require_once("../modelo/M_BuscarProductos.php");


    $c_Producto= new C_BuscarProducto();
    $accion = $_POST["accion"];
    
    if($accion === "buscar"){
        $nomproducto = $_POST['producto'];
        $c_Producto->BuscaProducto($nomproducto);

    }else if ($accion == "politicaprecios"){
        $cantidad = $_POST['cantidad'];
        $cod_producto = $_POST['codproducto'];
        $c_Producto->PoliticaPrecios($cantidad,$cod_producto);
      

    }else if($accion == "politicabonos"){
        $cantidad = $_POST['cantidad'];
        $cod_producto = $_POST['codproducto'];
        $c_Producto->PoliticaBonos($cantidad,$cod_producto);
       
    }
   

class C_BuscarProducto
{
    
    public function BuscaProducto($nomproducto)
    {
        $M_buscarproducto = new M_BuscarProductos();
        if($nomproducto !== ""){
            $c_cod = $M_buscarproducto->M_BuscarProducto($_SESSION['zona'],$nomproducto);
            echo $c_cod;
        }
    }


    public function PoliticaPrecios($cantidad,$cod_producto){
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


    public function PoliticaBonos($cantidad,$cod_producto)
    {
        $M_politicaBono = new M_BuscarProductos();
        $dato = "";
        if($cantidad != ""){
            $Bono = $M_politicaBono->M_PoliticaBono($_SESSION['zona'],$cantidad,$cod_producto);
            $dato = $Bono['BONO'];
            if($Bono!= 0){
                if($cantidad >= 20){
                    if(strlen($cantidad) == 2){
                        $dato = $Bono['BONO'] * ($cantidad[0]-1);
                    }else if (strlen($cantidad) == 3){
                        $dosCifras = $cantidad[0].''.$cantidad[1];
                        $dato = $Bono['BONO'] * ($dosCifras-1);
                    }else if(strlen($cantidad) == 4){
                        $tresCifras = $cantidad[0].''.$cantidad[1].''.$cantidad[2];
                        $dato = $Bono['BONO'] * ($tresCifras-1);
                    }
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

    }
}

?>