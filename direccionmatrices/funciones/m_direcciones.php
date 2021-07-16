<?php
    require_once("DataBase.php");
    class  M_direcciones
    {
        public function __construct() {
            $this->db=DataBase::Conectar();
        }

        public function m_guardarLatlng($contrato,$lat,$lng,$usuario)
        {
            $query = $this->db->prepare("INSERT INTO T_LATLNG(NUM_CONTRATO,LATITUD,LONGITUD,USUARIO) 
            values('$contrato',$lat,$lng,'$usuario')");
            $resultado = $query->execute();
            if($resultado){
                return $resultado;
            }
        }

        public function m_listarLatLng($usuario)
        {
            $hoy = date("d-m-Y");
            $nuevafecha = retunrFechaSql($hoy);
            $query=$this->db->prepare("SELECT * FROM T_LATLNG where USUARIO = '$usuario' AND FECHA = '$nuevafecha' ");
            //print_r($query);
            $query->execute();
            if ($query) {
                return $query->fetchAll();
            }
        }

        public function m_actualizaobservacion($txtobservacion,$numcontrato){
            print_r($txtobservacion);
            print_r($numcontrato);
            $query = $this->db->prepare("UPDATE T_LATLNG SET OBSERVACION = '$txtobservacion' WHERE NUM_CONTRATO = '$numcontrato'");
            $resultado = $query->execute();
            if($resultado){
                return $resultado;
            } 
        }


        public function m_puntopartida($oficina)
        {
            $query=$this->db->prepare("SELECT * FROM T_PUNTOPARTIDA where OFICINA = '$oficina'");
            $query->execute();
            if ($query) {
                return $query->fetch();
            }
        }

        public function m_verificarobservacion($usuario,$contrato){
            $query=$this->db->prepare("SELECT * FROM T_LATLNG where NUM_CONTRATO = '$contrato' and USUARIO = '$usuario'");
            $query->execute();
            if ($query) {
                return $query->fetch();
            }
        }

    }
    


?>