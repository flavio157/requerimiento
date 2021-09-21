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
            return $query->fetchAll();
        }

        public function m_actualizarcodebar($codlote,$fecha,$estado,$cod_auditoria_registro){
            $hora = gethora();
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

        public function m_actualizarNINGR($num_lote,$cod_usuario){
            $hora = gethora();
            $fechpistole = retunrFechaSqlphp(date("Y-m-d"));
            $query = $this->db->prepare("UPDATE T_CODIGOS_NINGR SET EST_AUDITORIA = '1',COD_USUARIO = '$cod_usuario',
            FEC_PISTOLEO = '$fechpistole',HOR_PISTOLEO = '$hora' WHERE NUM_LOTE ='$num_lote' ");
            $query->execute();
        }



        public function m_CerrarAuditoria($cod_auditoria)
        { 
            if($this->m_listarCodigosNing()[0] == 0 && $this->m_listarDetalleAud()[0] == 0 && $this->m_listar()[0] > 0){
                $query = $this->db->prepare("UPDATE T_CAB_AUDITORIA SET SITUACION = '1' where COD_AUDITORIA = '$cod_auditoria'");
                $query->execute();
            }
        }
        

        public function m_listarCodigosNing(){
            $query = $this->db->prepare("SELECT COUNT(*) FROM T_CODIGOS_NINGR WHERE EST_AUDITORIA = 0");
            $query->execute();
            return $query->fetch();
        }

        public function m_listarDetalleAud(){
            $query = $this->db->prepare("SELECT COUNT(*) FROM T_DETALLE_AUDITORIA WHERE EST_AUDITORIA = 0");
            $query->execute();
            return $query->fetch();
        }

        public function m_listar(){
            $query = $this->db->prepare("SELECT COUNT(*) FROM T_CODIGOS_NINGR");
            $query->execute();
            return $query->fetch();
        }
    }
    
?>