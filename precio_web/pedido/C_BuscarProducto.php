<?php
require_once("M_BuscarProductos.php");


    $accion = $_POST["accion"];
    
    if($accion === "buscar"){
        $nomproducto = $_POST['producto'];
       C_BuscarProducto::BuscaProducto($nomproducto);
    }else if($accion === "regalos"){
        $cantidad = $_POST['cantidad'];
        C_BuscarProducto::VerificarProductoRegalo($cantidad);
    }
      
class C_BuscarProducto
{
    
    static function BuscaProducto($nomproducto)
    {   
        $M_buscarproducto = new M_BuscarProductos();
                $c_cod = $M_buscarproducto->M_BuscarProducto_WEB($nomproducto); /*retorna el producto con su precio web*/
                $datos  = array(
                    'estado' => 'productos',
                    'producto' => $c_cod,
                );
            echo json_encode($datos,JSON_FORCE_OBJECT);
        
    }

    static function VerificarProductoRegalo($cantidad){
            $reglaReg = new M_BuscarProductos();
            $regalo = $reglaReg->M_VerificarRegalo('600',$cantidad);
           
            $datos  = array(
                "regalo" =>  $regalo
            );

        echo json_encode($datos,JSON_FORCE_OBJECT);
    }
}

?>