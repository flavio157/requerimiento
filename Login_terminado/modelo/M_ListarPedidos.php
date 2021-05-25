<?php
   require_once("../funciones/DataDinamica.php");
   date_default_timezone_set('America/Lima');

   class M_ListarPedidos 
   {
    private $bd;
    
    public function __construct($bd)
    {
        $this->bd=DataDinamica::Contrato($bd);
    }

    public function mostrarPedido($cod_vendedor,$fecha,$tipo)
    {
        $query = $this->bd->prepare("SELECT * FROM V_MOSTRAR_PEDIDO 
        WHERE COD_VENDEDORA = :cod_vendedor AND Fecha = :fecha_actual AND EST_PEDIDO != 'A'  ORDER BY CODIGO DESC"); 
        $query->bindParam("cod_vendedor",$cod_vendedor,PDO::PARAM_STR);
        $query->bindParam("fecha_actual",$fecha,PDO::PARAM_STR);  
        $query->execute();
        $html = "";

        if($tipo == "c"){
            while ($row = $query->fetch()) {         
                $cliente = str_replace(' ', '', $row['CLIENTE']);    
                $html .= '<div class="accordion-item">'.
                             '<button class="accordion-button collapsed" 
                                data-bs-toggle="collapse" data-bs-target="#'.$cliente.'" aria-expanded="false" id="btnMostaraPedido" aria-controls="'.$cliente.'">'.
                                'N° Contrato: '. $row['NUM_CONTRATO'].'<br>'.
                                'Cliente: ' . $row['CLIENTE'].
                             '</button>'.
                                '<div  id="'.$cliente.'"  class="accordion-collapse collapse" aria-labelledby="'.$cliente.'"  data-bs-parent="#acordionresponsive">'.
                                    '<div class="accordion-body" id="'.$row['CODIGO'].'">'.
                                        $this->mostrarPedidoItems($row['CODIGO'],$tipo) 
                                    .'</div>'.
                                '</div>'.
                            '</div>' ;
            }
        }else{
         
            while ($row = $query->fetch()) { 
                $cliente = str_replace(' ', '', $row['CLIENTE']);    
                $html .='<tr  data-bs-toggle="collapse" data-bs-target="#'.$cliente.'" class="collapse-row collapsed">'.
                           
                            '<td>'.$row['NUM_CONTRATO'].'</td>'.
                            '<td>'.$row['CLIENTE'].'</td>'.
                            '<td>'.$row['DIRECCION'].'</td>'.
                        '</tr>'.
                        '<tr>'.
                            '<td colspan="4">'.
                                '<div id="'.$cliente.'" class="collapse accordion-collapse">'.
                                     $this->mostrarPedidoItems($row['CODIGO'],$tipo) 
                                .'</div>'.    
                            '</td>'.
                        '</tr>'; 
            }
        }
        

        return $html ;
        $query->closeCursor();
        $query = null;
    }


    public function mostrarPedidoItems($idpedido)
    {
        $query = $this->bd->prepare("SELECT * FROM V_MOSTRAR_PEDIDO_ITEM 
        WHERE CODIGO =:idpedido"); 
        $query->bindParam("idpedido",$idpedido,PDO::PARAM_STR);
        $query->execute();
         $html = "";
            while ($row = $query->fetch()) {  
                    $html.='<ul style="font-size: 14px;">'.
                                '<li>'.$row['COD_PRODUCTO'].' : '.$row['DES_PRODUCTO'].' </li>'. '  CANTIDAD : '.$row['CANTIDAD'].                                
                            '</ul>';
            }
        return $html ;
        $query->closeCursor();
        $query = null;
    }
   }
   




?>