<?php
    require_once("DataBase.php");
    require_once("f_funcion.php");
    class m_insumos 
    {
        private $bd;
        
        public function __construct()
        {
            $this->bd = DataBase::Conectar();       
        }

        public function m_formulaxProd($fech_ini,$fech_fin,$vista,$campo){ //para saber cuantos insumos se vendieron
            $fech_ini = retunrFechaSqlphp($fech_ini);
            $fech_fin = retunrFechaSqlphp($fech_fin);
            $query = $this->bd->prepare("SELECT MAX(CODIGO_CPVE) as CODIGO_CPVE , MAX(FECHA_CPVE) as FECHA_CPVE,
                                        COD_PRODUCTO , MAX(DES_PRODUCTO) as DES_PRODUCTO,
                                        SUM(CANTIDAD) as CANTIDAD , SUM(PRECIO) as PRECIO
                                        FROM $vista WHERE 
                                        $campo  >= '$fech_ini' and $campo <= '$fech_fin' group by COD_PRODUCTO");
           
            $query->execute(); 
            $venta = $query->fetchAll();
            return $venta;
        }


        public function m_insum_compra($fech_ini,$fech_fin,$tipo,$cod_producto){ //para saber que cantidad de producto se compraron
            $fech_ini = retunrFechaSqlphp($fech_ini);
            $fech_fin = retunrFechaSqlphp($fech_fin);
            if($tipo == '1'){
                $query = $this->bd->prepare("SELECT COD_PRODUCTO,MAX(DES_PRODUCTO) as DES_PRODUCTO,
                SUM(CANTIDAD) as CANTIDAD , SUM(PRECIO) as PRECIO FROM V_COMPROBANTE WHERE FEC_ENTREGA >='$fech_ini' AND
                FEC_ENTREGA <= '$fech_fin' AND COD_PRODUCTO = '$cod_producto' GROUP BY COD_PRODUCTO");
            }else{
                $query = $this->bd->prepare("SELECT COD_PRODUCTO,MAX(DES_PRODUCTO) as DES_PRODUCTO,
                SUM(CANTIDAD) as CANTIDAD , SUM(PRECIO) as PRECIO FROM V_COMPROBANTE WHERE FEC_ENTREGA >='$fech_ini' AND
                FEC_ENTREGA <= '$fech_fin' GROUP BY COD_PRODUCTO");
            }
            
            $query->execute(); 
            $formula = $query->fetchAll();
            return $formula;
        }
  


        public function m_insumosV($nombreVista,$nombrecol,$cod_prod)
        {
            $query = $this->bd->prepare("SELECT * FROM $nombreVista WHERE $nombrecol = '$cod_prod'");
            $query->execute();
            $insumos = $query->fetchAll();
            return $insumos;
        }

        public function m_lstinsumos($nombreVista)
        {
            $query = $this->bd->prepare("SELECT * FROM $nombreVista");
            $query->execute();
            $insumos = $query->fetchAll();
            return $insumos;
        }

      
    }
?>
