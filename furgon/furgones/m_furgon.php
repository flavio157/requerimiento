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
        
        public function m_lsfurgon($tabla,$columna,$fecha)
        {
            $fech = retunrFechaSqlphp($fecha);
            $query = $this->bd->prepare("SELECT * FROM $tabla WHERE $columna = '$fech'");
            $query->execute();
            $respuesta = $query->fetchAll();
            return $respuesta;
        }

        public function m_lst_vend_furgon($fecini,$fecfin,$select,$codVen,$nomVen,$canVen)
        {
            $fecini = retunrFechaSqlphp($fecini);
            $fecfin = retunrFechaSqlphp($fecfin);
            $query = $this->bd->prepare("SELECT $codVen , MAX($nomVen) as $nomVen,SUM($canVen) as $canVen 
            from V_LST_VEND_FURGON where FECHA >= '$fecini'
            and FECHA <= '$fecfin' and OFICINA = '$select'
            group by $codVen");
            $query->execute();
            $respuesta = $query->fetchAll();
            return $respuesta ;
        
        }

        public function m_lst_oficinaFurgon()
        {
            $query = $this->bd->prepare("SELECT OFICINA as OFI FROM T_CAMIONES_ITEM group by OFICINA");
            $query->execute();
            $respuesta = $query->fetchAll();
            return $respuesta;
        }

        public function m_guadarcomentario($comentario,$usuario)
        {
           
            $hora = gethora();
            $query = $this->bd->prepare("INSERT INTO T_COMENTARIOS_FURGON (COMENTARIO,USU_REGISTRO,HOR_REGISTRO)
                    VALUES('$comentario','$usuario','$hora')");
            $respuesta = $query->execute();
            return $respuesta;
        }

    }


?>