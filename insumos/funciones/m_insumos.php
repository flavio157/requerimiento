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

        public function m_ProductoV($fech_ini , $fech_fin){
            $fech_ini = retunrFechaSqlphp($fech_ini);
            $fech_fin = retunrFechaSqlphp($fech_fin);

            $query = $this->bd->prepare("SELECT MAX(COD_PRODUCTO),MAX(DES_PRODUCTO) as DES_PRODUCTO,
            SUM(CANTIDAD) as CANTIDAD , SUM(PRECIO) as PRECIO FROM V_COMP_VENTA WHERE FECHA_CPVE >='$fech_ini' AND
            FECHA_CPVE <= '$fech_fin' group by COD_PRODUCTO ");
           
            $query->execute(); 
            $venta = $query->fetchAll();
            return $venta;
        }


        public function m_insumosV($nombreVista,$nameColumn,$cod_prod)
        {
            $query = $this->bd->prepare("SELECT * FROM $nombreVista WHERE $nameColumn = '$cod_prod'");
            $query->execute();
            $insumos = $query->fetchAll();
            return $insumos;
        }

    }
?>
