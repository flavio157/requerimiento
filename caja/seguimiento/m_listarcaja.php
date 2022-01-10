<?php
    date_default_timezone_set('America/Lima');
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
                $query=$this->db->prepare("SELECT * FROM V_VERIFICAR_PAGO WHERE FEC_GASTO >= '07-01-2021'");
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
            $this->db->beginTransaction();
            try {
               
                $fec_gasto = retunrFechaSql($fec_gasto);
                $fec_cobro = retunrFechaSql($fec_cobro);
                
                $fec_actual = retunrFechaSqlphp(date("Y-m-d"));
    
                $query=$this->db->prepare("INSERT INTO T_CAJA_TEMPORAL(NRO_CORRELATIVO,DESCRIPCION,FEC_GASTO,FEC_COBRO,COD_PERSONAL,
                                         COD_USUARIO,OFICINA_USUARIO,MONTO,EST_CAJA,FEC_REGISTRO)  
                                         VALUES('$nro_correlativo','EFECTIVOS','$fec_gasto','$fec_cobro','$cod_personal','$cod_usuario','$oficina','$monto','1','$fec_actual')");
                $query->execute();
                
                $query2= $this->db->prepare("UPDATE T_CAJA_ITEM SET REVIZADO = '0' WHERE NRO_CORRELATIVO = '$nro_correlativo'");
                $query2->execute();

                $query3 = $this->db->prepare("UPDATE T_COPIA_CAJA SET VERIFICADO = '1' WHERE NRO_CORRELATIVO = '$nro_correlativo'");
                $query3->execute();

                $guardado = $this->db->commit();
                return $guardado;
            } catch (Exception $e) {
                $this->db->rollBack();
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