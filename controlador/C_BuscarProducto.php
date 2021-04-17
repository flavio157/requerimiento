<?php
require_once("../modelo/M_BuscarProductos.php");
    $c_CodProducto= new C_BuscarProducto();
    
   
    $accion = $_POST["accion"];
    
    if($accion === "buscar"){

        $codproducto = $_POST['Codproducto'];
        $c_CodProducto->BuscaProducto($codproducto);

    }else if($accion === "obtener"){

        $producto = $_POST['producto'];
        $cantidad = $_POST['cantidad'];
        $precio = $_POST['precio'];
        $promocion = $_POST['promocion'];
        $total = $_POST['total'];
        
        $c_CodProducto->ObtenerProducto($producto,$cantidad,$precio,$promocion,$total);
    }
   
 

class C_BuscarProducto
{
    public function BuscaProducto($cod_producto)
    {
        $M_buscarproducto = new M_BuscarProductos();
       
        if($cod_producto != ""){
            $c_cod = $M_buscarproducto->M_BuscarProducto($cod_producto);
        }
       
        if($c_cod > 0){
            print_r("ok"."/".$c_cod['DES_PRODUCTO'] . "/" . $c_cod['PRE_PRODUCTO']);
        }
    }

    public function ObtenerProducto($producto,$cantidad,$precio,$promocion,$total)
    {
        
       /* echo "obtener";*/
        /*<th scope="row">1</th>*/
        echo   '<tr>
                <th scope="row"></th>
                <td>"' .$producto.'"</td>
                <td>"'.$cantidad.'"</td>
                <td>"'.$precio.'"</td>
                <td>"'.$promocion.'"</td>
                <td>"'.$total.'"</td>
              </tr>' ;  
    }

}

?>