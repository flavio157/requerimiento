<?php
require_once("../modelo/M_BuscarProductos.php");

    $codproducto = $_POST['Codproducto'];
   
    if($codproducto != ""){
        $c_CodProducto= new C_BuscarProducto();
        $c_CodProducto->BuscaProducto($codproducto);
    }

class C_BuscarProducto
{
    public function BuscaProducto($cod_producto)
    {
        $M_buscarproducto = new M_BuscarProductos();
        $c_cod = $M_buscarproducto->M_BuscarProducto($cod_producto);
        
        if($c_cod > 0){
            print_r("ok"."/".$c_cod['DES_PRODUCTO'] . "/" . $c_cod['PRE_PRODUCTO']);
         }
    }
}

?>