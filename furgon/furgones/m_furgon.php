<?php
require_once("../funciones/DataBase.php");
require_once("../funciones/f_funcion.php");
    class m_furgon
    {
        private $bd;
        public function __construct()
        {
            $this->bd = DataBase::Conectar();
        }
        
        public function m_lsfurgon($fecha)
        {
            $fech = retunrFechaSqlphp($fecha);
            $query = $this->bd->prepare("SELECT * FROM V_LST_FURGON WHERE FECHA = '$fech'");
            $query->execute();
            $respuesta = $query->fetchAll();
            return $respuesta;
        }

        public function m_lst_vend_furgon($fecini,$fecfin,$codVen,$nomVen,$canVen)
        {
            $fecini = retunrFechaSqlphp($fecini);
            $fecfin = retunrFechaSqlphp($fecfin);
            $query = $this->bd->prepare("SELECT $codVen , MAX($nomVen) as $nomVen,SUM($canVen) as $canVen 
            from V_LST_VEND_FURGON where FECHA >= '$fecini'
            and FECHA <= '$fecfin'
            group by $codVen");
            $query->execute();
            $respuesta = $query->fetchAll();
            return $respuesta ;
        
        }

    }
    

?>