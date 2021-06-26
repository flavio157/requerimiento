<?php
    require_once("DataDinamica.php");
    require_once("f_funcion.php");
    class m_listarcaja 
    {
       
        private $db;
        
        public function __construct($db)
        {
            $this->db=DatabaseDinamica::Conectarbd($db);
        }
        
        public function m_mostraritems()
        {
            $dia = restarDias(new DateTime(),7);
            $retufch =  date("d-m-Y",strtotime(date("d-m-Y")."-".$dia."days")); 
            $fecha1 = retunrFechaSql($retufch);
            $query=$this->db->prepare("SELECT * FROM V_VERIFICAR_PAGO WHERE FEC_GASTO >= '$fecha1' AND FEC_GASTO <= GETDATE()");
            $query->execute();
            if ($query) {
                    return $query->fetchAll();
                }
            }

        public function m_guardarcaja($nro_correlativo,$fec_gasto,$fec_cobro,$cod_personal,$cod_usuario,$oficina,$monto)
        {   
            $fec_gasto = retunrFechaSqlphp($fec_gasto);
            $fec_cobro = retunrFechaSqlphp($fec_cobro);
            $fec_actual = retunrFechaSqlphp(date("Y-m-d"));

            $query=$this->db->prepare("INSERT INTO T_CAJA_TEMPORAL(NRO_CORRELATIVO,DESCRIPCION,FEC_GASTO,FEC_COBRO,COD_PERSONAL,
                                     COD_USUARIO,OFICINA_USUARIO,MONTO,EST_CAJA,FEC_REGISTRO)  
                                     VALUES('$nro_correlativo','EFECTIVOS','$fec_gasto','$fec_cobro','$cod_personal','$cod_usuario','$oficina','$monto','1','$fec_actual')");
            $guardado = $query->execute();
            return $guardado;
        }
    }

?>