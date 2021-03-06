<?php
   require_once("../db/Contrato.php");

   class M_Pedidos 
   {
    private $bd;
    
    public function __construct($bd)
    {
        $this->bd=ClassContrato::Contrato($bd);
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
            
            (:fecha,:cod_vendedora,:tipo_documento,:identificacion,:cliente,:direccion,
            :referencia,:contacto,:telefono,:entrega,:fcancelacion,:est_pedido,:observacion,:n_productos,
            :cod_distrito,:num_contrato,:cod_provincia,:telefono2,:contado)");

            $query1->bindParam("fecha",$fecha,PDO::PARAM_STR);
            $query1->bindParam("cod_vendedora",$cod_vendedora,PDO::PARAM_STR);
            $query1->bindParam("tipo_documento",$tipo_documento,PDO::PARAM_STR);
            $query1->bindParam("identificacion",$identificacion,PDO::PARAM_STR);
            $query1->bindParam("cliente",$cliente,PDO::PARAM_STR);
            $query1->bindParam("direccion",$direccion,PDO::PARAM_STR);
            $query1->bindParam("referencia",$referencia,PDO::PARAM_STR);
            $query1->bindParam("contacto",$contacto,PDO::PARAM_STR);
            $query1->bindParam("telefono",$telefono,PDO::PARAM_STR);
            $query1->bindParam("entrega",$entrega,PDO::PARAM_STR);
            $query1->bindParam("fcancelacion",$nuevaFecha,PDO::PARAM_STR);
            $query1->bindParam("est_pedido",$est_pedido,PDO::PARAM_STR);
            $query1->bindParam("observacion",$observacion,PDO::PARAM_STR);
            $query1->bindParam("n_productos",$n_productos,PDO::PARAM_INT);
            $query1->bindParam("cod_distrito",$cod_distrito,PDO::PARAM_STR);
            $query1->bindParam("num_contrato",$num_contrato,PDO::PARAM_STR);
            $query1->bindParam("cod_provincia",$cod_provincia,PDO::PARAM_STR);
            $query1->bindParam("telefono2",$telefono2,PDO::PARAM_STR);
            $query1->bindParam("contado",$contado,PDO::PARAM_STR);
            
            $query1->execute();
           
    
            $ultimocodigo = $this->UltimoRegistro($cod_vendedora);
    
            $query2 = $this->bd->prepare("INSERT INTO T_PPEDIDO_CANTIDAD(CODIGO,COD_PRODUCTO,
                                        CANTIDAD,BONO,PRECIO,CCAN,CBON) 
                                        VALUES(:codigo,:cod_producto,:cantidad,:bono,:precio,:ccan,:cbon)");
            foreach ($dataproductos->arrayproductos as $dato){
                if(isset($dato->cod_producto)){
                    $query2->bindParam("codigo",$ultimocodigo['CODIGO'],PDO::PARAM_STR); 
                    $query2->bindParam("cod_producto",$dato->cod_producto,PDO::PARAM_STR);
                    $query2->bindParam("cantidad",$dato->cantidad,PDO::PARAM_STR);
                    $query2->bindParam("bono",$dato->promocion,PDO::PARAM_STR);
                    $query2->bindParam("precio", $dato->precio,PDO::PARAM_INT);
                    $query2->bindParam("ccan",$dato->cantidad,PDO::PARAM_INT);
                    $query2->bindParam("cbon",$dato->promocion,PDO::PARAM_INT);
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
        $query = $this->bd->prepare("SELECT * FROM V_ULTIMO_REGISTRO WHERE COD_VENDEDORA = :codvendedora");
        $query->bindParam("codvendedora",$cod_vendedora,PDO::PARAM_STR); 
        $query->execute();
        $ultimoregistro =  $query->fetch(PDO::FETCH_ASSOC);
        return $ultimoregistro;
    }


    public function verificar($dni)
    {
        $query = $this->bd->prepare("SELECT * FROM V_VERIFICAR_PEDIDO WHERE IDENTIFICACION = :dni and (EST_PEDIDO = 'P'
        or EST_PEDIDO = 'R')"); 
        $query->bindParam("dni",$dni,PDO::PARAM_STR); 
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