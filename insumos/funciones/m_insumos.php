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

        public function m_ProductoC($fech_ini , $fech_fin,$cod_prod){
            $fech_ini = retunrFechaSqlphp($fech_ini);
            $fech_fin = retunrFechaSqlphp($fech_fin);

            $query = $this->bd->prepare("SELECT COD_PRODUCTO,MAX(DES_PRODUCTO) as DES_PRODUCTO,
            SUM(CANTIDAD) as CANTIDAD , SUM(PRECIO) as PRECIO FROM V_COMPROBANTE WHERE FEC_ENTREGA >='$fech_ini' AND
            FEC_ENTREGA <= '$fech_fin' AND COD_PRODUCTO = '$cod_prod' group by COD_PRODUCTO ");
           
            $query->execute(); 
            $venta = $query->fetchAll();
            return $venta;
            //FECHA_CPVE
        }


   /* SELECT 
 COD_PRODUCTO,MAX(DES_PRODUCTO) as DES_PRODUCTO,
SUM(CANTIDAD) as CANTIDAD, SUM(PRECIO) as PRECION
from V_COMPROBANTE where FEC_ENTREGA  >= '21/09/2021' and FEC_ENTREGA <= '22/09/2021'
group by COD_PRODUCTO*/

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
