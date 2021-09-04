<?php
    require_once("DataDinamica.php");
    class m_codigobarra
    {
        public function __construct($db) {
            $this->db=DatabaseDinamica::Conectarbd($db);
        }  
        
        public function m_auditoriaPendi(){
            $query = $this->db->prepare("SELECT TOP 1 * FROM T_CAB_AUDITORIA WHERE SITUACION != 1 ORDER BY COD_AUDITORIA DESC");
            $query->execute();
            return $query->fetchAll();
        }

        public function m_verificarcodebar($codproducto,$cod_auditoria){
            $query = $this->db->prepare("SELECT * FROM T_DETALLE_AUDITORIA where NUM_LOTE = '$codproducto'
            and COD_AUDITORIA = '$cod_auditoria'");
            $query->execute();
            //print_r($query);
            return $query->fetchAll();
        }

        public function m_actualizarcodebar($codlote,$fecha,$estado,$cod_auditoria_registro){
            date_default_timezone_set('America/Lima');
            $hora = getdate();
            $hora = $hora['hours'] .":". $hora['minutes'];
           
            $fechpistole = retunrFechaSqlphp(date("Y-m-d"));
            $query = $this->db->prepare("UPDATE T_DETALLE_AUDITORIA set EST_AUDITORIA = '$estado' 
            ,COD_AUDITOR_REGISTRO = '$cod_auditoria_registro',FECHA = '$fecha',FEC_PISTOLEO = '$fechpistole',
            HOR_PISTOLEO = '$hora' 
            where NUM_LOTE = '$codlote' AND (ESTADO = 'A' OR ESTADO = 'R')");
          
            $valor = $query->execute();
            if($valor){
                return $valor;
            }
          
        }

        public function m_guardarcodebar(){
            $query = $this->db->prepare();
            $valor = $query->execute();
            if($valor){
                return $valor;
            }
        }

        public function m_guardarlote($num_lote,$cod_registro,$cod_auditoria,$estado,$cod_producto,$est_auditoria){
            $query = $this->db->prepare("INSERT INTO T_CODIGOS_NINGR(NUM_LOTE,COD_REGISTRO,
            COD_AUDITORIA,ESTADO,COD_PRODUCTO,EST_AUDITORIA) 
            values('$num_lote','$cod_registro','$cod_auditoria','$estado','$cod_producto','$est_auditoria')");
            $valor = $query->execute();
            if($valor){
                return $valor;
            }
        }

        public function m_verificarNNIGR($num_lote){
            $query = $this->db->prepare("SELECT * FROM T_CODIGOS_NINGR WHERE NUM_LOTE = '$num_lote'");
            $query->execute();
            return $query->fetchAll();
        }

        
    }
    
?>