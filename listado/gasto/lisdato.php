<?php
    require_once("m_listado.php");
    $accion = $_POST['accion'];
    if($accion == 'accion'){
        listado::listadopro();
    }else if($accion == 'mostrar'){
          $dato = $_POST['dato'];
        listado::buscar($dato);
    }


    class Listado
    {   
       
        static function listadopro(){
            $listado = new m_listado();
            $lista = $listado->listado();
            $html ="";
            for ($i=0; $i < sizeof($lista) ; $i++) { 
                $html .='<tr>'.
                '<td>'.$lista[$i]['COD_INGRESO'].'</td>'.
                '<td>'.$lista[$i]['COD_PRODUCTO'].'</td>'.
                '<td>'.$lista[$i]['COD_PRODUCTO'].'</td>'.
                '<td>'.$lista[$i]['COD_PRODUCTO'].'</td>'.
                '<td><button class="btn btn-primary" type="button" id="btlver">Aceptar</button></td>'.
                '</tr>';
            }
            print_r($html);
        }

        static function buscar($dato)
        {
            $listado = new m_listado();
            $lista = $listado->buscar($dato);
            $dato = array(
                'cod' => $lista[0]['COD_PRODUCTO'],
                'lote' => $lista[0]['NUM_LOTE'],
                'estado' => $lista[0]['EST_DET_PRODUCTO'],
                'alamcen' => $lista[0]['COD_ALMACEN']
            );
            echo json_encode($dato,JSON_FORCE_OBJECT);
        }
        
    }
    


?>