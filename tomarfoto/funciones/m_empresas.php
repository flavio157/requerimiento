<?php
    require_once("DataBase.php");
    class M_Empresas
    {
        private $bd;

        public function __construct() {
            $this->db=DataBase::Conectar();
        }

        public function m_guardargasto($codigo,$oficina,$fec_emision,$cod_personal,$tipo_comprobante,$serie_contabilidad,$comp_contabilidad,$identificacion,
        $cod_proveedor,$nombre,$direccion,$obs_comprovante,$monto_comprobante,$nro_correlativo,$usuario_registro,$caja,$contabilidad,$cod_empresa,$cod_concepto_caja)
        {
            $this->db->beginTransaction();
            try{
                $query1 = $this->db->prepare("INSERT INTO T_TMP_GASTO(CODIGO,OFICINA,FEC_EMISION,COD_PERSONAL,
                TIPO_COMPROBANTE,SERIE_CONTABILIDAD,COMP_CONTABILIDAD,IDENTIFICACION,COD_PROVEEDOR,NOMBRE,DIRECCION,
                OBS_COMPROBANTE,MONTO_COMPROBANTE,NRO_CORRELATIVO,USU_REGISTRO,CAJA,CONTABILIDAD,COD_EMPRESA,COD_CONCEPTO_CAJA)
                VALUES('000000001','$oficina','$fec_emision','$cod_personal','$tipo_comprobante','$serie_contabilidad','$comp_contabilidad',
                '$identificacion','$cod_proveedor','$nombre','$direccion','$obs_comprovante','$monto_comprobante','$nro_correlativo','$usuario_registro','$caja','$contabilidad','$cod_empresa','$cod_concepto_caja')");
                $query1->execute();
                

                $query2 = $this->db->prepare("INSERT INTO T_TMP_GASTO_ITEM (CODIGO,COD_PRODUCTO,CAN_PRODUCTO,PREC_PRODUCTO) 
                VALUES('000000001','$cod_concepto_caja','1','$monto_comprobante')");
                $query2->execute();


                $guardado = $this->db->commit();
                return $guardado;
            } catch (Exception $e) {
                $this->db->rollBack();
                return  $e;
                
            }
        }

        public function m_guardarfoto($nombre,$foto)
        {
            $query = $this->db->prepare("INSERT INTO T_IMAGEN(CODIGO,IMAGEN)VALUES('$nombre','$foto')");
            $foto = $query->execute();
            if($query){
                return $foto;
            }
        }


        public function m_listarempresa()
        {
                $query=$this->db->prepare("SELECT * FROM T_EMPRESA");
                $query->execute();
                if($query){
                    return $query->fetchAll();
                }
        }

        public function m_proveedor($proveedor){
            $query = $this->db->prepare("SELECT * FROM T_PROVEEDOR where NOM_PROVEEDOR LIKE '%$proveedor%'");
            $query->execute();
            if($query){
                return $query->fetchAll();
            }
        }


        public function m_mostrarimg($nombreimg)
        {
            $query = $this->db->prepare("SELECT * FROM T_IMAGEN WHERE CODIGO ='$nombreimg'");
            $query->execute();
            if($query){
                return $query->fetch();
            }
        }

        public function m_buscarpersonal($personal){
           
            $query = $this->db->prepare("SELECT * FROM T_PERSONAL WHERE EST_PERSONAL = 'A' AND COD_PERSONAL LIKE '%$personal%' OR  NOM_PERSONAL1 LIKE '%$personal%'");
            $query->execute();
            if($query){
                return $query->fetchAll();
            }
        }
        
    }
    

 


?>