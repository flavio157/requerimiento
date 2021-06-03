<?php
   require_once("../Funciones/DataDinamica.php");

   class M_Pedidos 
   {
    private $bd;
    
    public function __construct($bd)
    {
        $this->bd=DatabaseDinamica::Conectarbd($bd);
    }

    public function GuardarPedido($fecha,$cod_vendedora,$tipo_documento,$identificacion,
    $cliente,$direccion,$referencia,$contacto,$telefono,$entrega,$fcancelacion,$est_pedido,$observacion,
    $n_productos,$cod_distrito,$num_contrato,$cod_provincia,$telefono2,$contado,$dataproductos){
    $nuevaFecha = date("d-m-Y", strtotime($fcancelacion));
        
        try { 
            $this->bd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->bd->beginTransaction();
            $query1=$this->bd->prepare("INSERT INTO T_PPEDIDO(FECHA,COD_VENDEDORA,
            TIPO_DOCUMENTO,IDENTIFICACION,CLIENTE,DIRECCION,REFERENCIA,CONTACTO,TELEFONO,ENTREGA,
            FCANCELACION,EST_PEDIDO,OBSERVACION,N_PRODUCTOS,
            COD_DISTRITO,NUM_CONTRATO,COD_PROVINCIA,TELEFONO2,CONTADO) values 
            
            ('$fecha','$cod_vendedora','$tipo_documento','$identificacion','$cliente','$direccion',
            '$referencia','$contacto','$telefono','$entrega','$nuevaFecha','$est_pedido','$observacion',$n_productos,
            '$cod_distrito','$num_contrato','$cod_provincia','$telefono2','$contado')");
            $query1->execute();
           
    
            $ultimocodigo = $this->UltimoRegistro($cod_vendedora);
           
            foreach ($dataproductos->arrayproductos as $dato){
                if(isset($dato->cod_producto)){
                    
                    $query2 = $this->bd->prepare("INSERT INTO T_PPEDIDO_CANTIDAD(CODIGO,COD_PRODUCTO,
                    CANTIDAD,BONO,PRECIO,CCAN,CBON) 
                    VALUES($ultimocodigo[CODIGO],'$dato->cod_producto',$dato->cantidad,
                    $dato->promocion,$dato->precio,$dato->cantidad,$dato->promocion)");

                    $query2->execute(); 
                             if($query2->errorCode()>0){	
                                $this->bd->rollBack();
                                return 0;
                                    break;
                                }
                }         
            }

          $guardado = $this->bd->commit();

          return $guardado;
          
        } catch (Exception $e) {
            echo $e;
            $this->bd->rollBack();
        }
    }




    public function UltimoRegistro($cod_vendedora)
    {
        $query = $this->bd->prepare("SELECT * FROM V_ULTIMO_REGISTRO WHERE COD_VENDEDORA = '$cod_vendedora'"); 
        $query->execute();
        $ultimoregistro =  $query->fetch(PDO::FETCH_ASSOC);
        return $ultimoregistro;
    }


    public function verificar($dni)
    {
        $query = $this->bd->prepare("SELECT * FROM V_VERIFICAR_PEDIDO WHERE IDENTIFICACION = '$dni' and (EST_PEDIDO = 'P'
        or EST_PEDIDO = 'R')"); 
        $query->execute();
        $verificar = $query->fetch(PDO::FETCH_ASSOC);
       
        if($verificar){
            return $verificar;
            $query->closeCursor();
            $query = null;
        }
        
    }

   }
   




?>