<?php
require_once("../modelo/M_BuscarProductos.php");
    $c_CodProducto= new C_BuscarProducto();
    
   
    $accion = $_POST["accion"];
    
    if($accion === "buscar"){

        $codproducto = $_POST['Codproducto'];
        $c_CodProducto->BuscaProducto($codproducto);

    }else if($accion === "obtener"){
        $cod_producto = $_POST['Cod_producto'];
        $producto = $_POST['producto'];
        $cantidad = $_POST['cantidad'];
        $precio = $_POST['precio'];
        $promocion = $_POST['promocion'];
        $total = $_POST['total'];
        
        $c_CodProducto->ObtenerProducto($cod_producto,$producto,$cantidad,$precio,$promocion,$total);
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
        }else{
            print_r('<div class="alert alert-warning alert-dismissible fade show" role="alert" id="">
                    <strong>Error: </strong> El codigo del producto no existe.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>');
        }
    }

    public function ObtenerProducto($cod_producto,$producto,$cantidad,$precio,$promocion,$total)
    {
        echo   '<tr>
                <th scope="row">1</th>
                <td id = "cod_Prodcuto" style="display:none;" >"' .$cod_producto.'"</td>
                <td id = "producto">"' .$producto.'"</td>
                <td  id = "cantidad">"'.$cantidad.'"</td>
                <td  id = "precio">"'.$precio.'"</td>
                <td  id = "promocion">"'.$promocion.'"</td>
                <td  id = "total">"'.$total.'"</td>
              </tr>' ;  
    }

}

?>

?>