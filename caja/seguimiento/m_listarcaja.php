<?php
    require_once("../funciones/DataDinamica.php");
    require_once("../funciones/f_funcion.php");
    class m_listarcaja 
    {
        private $db;
        
        public function __construct($db)
        {
            $this->db=DatabaseDinamica::Conectarbd($db);
        }
        
        public function m_mostraritems()
        {
           try {
                $query=$this->db->prepare("SELECT * FROM V_VERIFICAR_PAGO");
                $query->execute();
                if ($query) {
                        return $query->fetchAll();
                    }
           } catch (Exception $e) {
               print_r("Error al listar datos ". $e);
           }
        }   

        public function m_guardarcaja($nro_correlativo,$fec_gasto,$fec_cobro,$cod_personal,$cod_usuario,$oficina,$monto)
        {   
            try {
                //$fec_gasto = retunrFechaSqlphp($fec_gasto);
                //$fec_cobro = retunrFechaSqlphp($fec_cobro);
                $fec_actual = retunrFechaSqlphp(date("Y-m-d"));
    
                $query=$this->db->prepare("INSERT INTO T_CAJA_TEMPORAL(NRO_CORRELATIVO,DESCRIPCION,FEC_GASTO,FEC_COBRO,COD_PERSONAL,
                                         COD_USUARIO,OFICINA_USUARIO,MONTO,EST_CAJA,FEC_REGISTRO)  
                                         VALUES('$nro_correlativo','EFECTIVOS','$fec_gasto','$fec_cobro','$cod_personal','$cod_usuario','$oficina','$monto','1','$fec_actual')");
                $guardado = $query->execute();
                return $guardado;
            } catch (Exception $e) {
                print_r("Error al registrar los datos " . $e);
            }
            
        }

        public function m_verificar_escaneo($nro_correlativo){
            try {
                $query = $this->db->prepare("SELECT * FROM T_GASTOS_SCANEADOS WHERE NRO_CORRELATIVO = '$nro_correlativo'");
                $query->execute();
                $escanado = $query->fetchAll();
                return $escanado;
            } catch (Exception $e) {
                print_r("Error al busca el gasto scaneado ". $e);
            }
           
        }



        

    }

?>