<?php
require_once("../modelo/M_BuscarProductos.php");
    $db = "SMP2";
    $c_CodProducto= new C_BuscarProducto();
    $accion = $_POST["accion"];
    
    if($accion === "buscar"){
        $nomproducto = $_POST['producto'];
        $c_CodProducto->BuscaProducto($nomproducto);

    }else if ($accion = "politicaprecios"){
        $cantidad = $_POST['cantidad'];
        $c_CodProducto->PoliticaPrecios($cantidad,$db);
    }
   

class C_BuscarProducto
{
    
    public function BuscaProducto($nomproducto)
    {
        $M_buscarproducto = new M_BuscarProductos();
       
        if($nomproducto !== ""){
            $c_cod = $M_buscarproducto->M_BuscarProducto($nomproducto);
            echo $c_cod;
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
        

        }
    }
}

?>