<?php
require_once("../modelo/M_BuscarProductos.php");
    $db = "SMP2";
    $c_CodProducto= new C_BuscarProducto();
    $accion = $_POST["accion"];
    
    if($accion === "buscar"){

        $codproducto = $_POST['Codproducto'];
        $c_CodProducto->BuscaProducto($codproducto,$db);

    }else if($accion === "obtener"){
        $cod_producto = $_POST['Cod_producto'];
        $producto = $_POST['producto'];
        $cantidad = $_POST['cantidad'];
        $precio = $_POST['precio'];
        $promocion = $_POST['promocion'];
        $total = $_POST['total'];
        
        $c_CodProducto->ObtenerProducto($cod_producto,$producto,$cantidad,$precio,$promocion,$total);
    
    }else if ($accion = "politicaprecios"){
        $cantidad = $_POST['cantidad'];
        $c_CodProducto->PoliticaPrecios($cantidad,$db);
    }
   

class C_BuscarProducto
{
    
    public function BuscaProducto($cod_producto,$db)
    {
        $M_buscarproducto = new M_BuscarProductos($db);
       
        if($cod_producto !== ""){
            $c_cod = $M_buscarproducto->M_BuscarProducto($cod_producto);

            if($c_cod > 0){
                $buscarProducto = array(
                    'estado' => 'ok',
                    'descripcion'=> $c_cod['DES_PRODUCTO'],
                    'precio'=> $c_cod['PRE_PRODUCTO']
                );
                echo json_encode($buscarProducto,JSON_FORCE_OBJECT);
                
            }
            else{
                print_r('<div class="alert alert-warning alert-dismissible fade show" role="alert" id="">
                        <strong>Error: </strong> El codigo del producto no existe.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>');
            }
        }else{
             print_r('<div class="alert alert-warning alert-dismissible fade show" role="alert" id="">
                    <strong>Error: </strong> El codigo del producto no existe.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>');
        }
       
    }


    public function PoliticaPrecios($cantidad,$db){
        $M_politicaPrecio = new M_BuscarProductos($db);
        if($cantidad != ""){
            $Bono = $M_politicaPrecio->M_PoliticaProductos($cantidad);
            if($Bono > 0){
                $datos  = array(
                    'estado' => 'ok',
                    'bono' => $Bono['BONO'],
                    );
                    echo json_encode($datos,JSON_FORCE_OBJECT);
            }else{
                /*print_r('<div class="alert alert-warning alert-dismissible fade show" role="alert" id="">
                        <strong>Error: </strong> El BONO NO COINCIDE CON LA CANTIDAD INGRESADA
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>');*/
            }
        }else{
                /*print_r('<div class="alert alert-warning alert-dismissible fade show" role="alert" id="">
                        <strong>Error: </strong> El BONO NO COINCIDE CON LA CANTIDAD INGRESADA
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>');*/
        } 

    }


    public function ObtenerProducto($cod_producto,$producto,$cantidad,$precio,$promocion,$total)
    {
        
        echo   '<tr>
                <th scope="row"></th>
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