<?php
    require_once("../funciones/M_ListarPedidos.php");

    date_default_timezone_set('America/Lima');

    $accion = $_POST["accion"];
      
    if($accion == "mostrarPedidos"){
        $tipo = $_POST['tipo'];
        $codvendedor = $_POST['codpersonal'];
        $oficina = $_POST['oficina'];
        C_ListarPedidos::mostrarPedido($codvendedor,$tipo,$oficina);
    }


    class C_ListarPedidos
    { 
        static function mostrarPedido($cod_vendedor,$tipo,$oficina){
            $c_mostrarpedido = new M_ListarPedidos($oficina);
            $datos = $c_mostrarpedido->mostrarPedido($cod_vendedor,date("d-m-Y"),$tipo);
            $html ="";
            if($datos != "")
            {
                if($tipo == "c"){
                    foreach ($datos as $cabecera) {
                        $cliente = str_replace(' ', '', $cabecera['CLIENTE']);    
                        $html .= '<div class="accordion-item"> <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#'.$cliente.'" aria-expanded="false" id="btnMostaraPedido" aria-controls="'.$cliente.'">'.'N° Contrato: '. strtoupper($cabecera['NUM_CONTRATO']).'<br>'.
                                 'Cliente: '. $cabecera['CLIENTE'].'</button> <div id="'.$cliente.'"class="accordion-collapse collapse" aria-labelledby="'.$cliente.'"  data-bs-parent="#acordionresponsive"><div class="accordion-body" id="'.$cabecera['CODIGO'].'">'.C_ListarPedidos::ItemsPedidios($cabecera['CODIGO'],$tipo,$oficina) .'</div>'.'</div>'.'</div>' ;
                    }
                }else{
                    foreach ($datos as $cabecera) {
                        $cliente = str_replace(' ', '', $cabecera['CLIENTE']);    
                        $html .='<tr  data-bs-toggle="collapse" data-bs-target="#'.$cliente.'" class="collapse-row collapsed">'.
                                    '<td>'.strtoupper($cabecera['NUM_CONTRATO']).'</td>'.
                                    '<td>'.$cabecera['CLIENTE'].'</td>'.
                                    '<td>'.$cabecera['DIRECCION'].'</td>'.
                                '</tr>'.
                                '<tr>'.
                                    '<td colspan="4">'.
                                        '<div id="'.$cliente.'" class="collapse accordion-collapse">'.
                                        C_ListarPedidos::ItemsPedidios($cabecera['CODIGO'],$tipo,$oficina)
                                        .'</div>'.    
                                    '</td>'.
                                '</tr>'; 
                    }
                }
                
            }
            echo $html;
        }


        static function ItemsPedidios($codigo,$tipo,$oficina){
            $c_mostraritems = new M_ListarPedidos($oficina);
            $datos = $c_mostraritems->mostrarPedidoItems($codigo);
                  $html = "";
            foreach ($datos as $row) {
                    $html.='<ul style="font-size: 14px;">'.
                                '<li>'.$row['COD_PRODUCTO'].' : '.$row['DES_PRODUCTO'].' </li>'. '  CANTIDAD : '.$row['CANTIDAD'].                                
                            '</ul>';
            }
        return $html;
        }

    }

?>