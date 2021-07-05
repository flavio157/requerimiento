<?php
    require_once("DataBase.php");
    require_once("f_funcion.php");
    class M_Empresas
    {
       

        public function __construct() {
            $this->db=DataBase::Conectar();
        }

        public function m_guardargasto($codigo,$oficina,$fec_emision,$cod_personal,$tipo_comprobante,$serie_contabilidad,$comp_contabilidad,$identificacion,
        $cod_proveedor,$nombre,$direccion,$obs_comprovante,$monto_comprobante,$nro_correlativo,$usuario_registro,$caja,$contabilidad,$cod_empresa,$cod_concepto_caja,$concepto,$existepro)
        {
            $correlativo = $this->generarcodigo();
            $codigo = generarcorrelativo($correlativo,1);
            
            $this->db->beginTransaction();
            try{
                $query1 = $this->db->prepare("INSERT INTO T_TMP_GASTO(CODIGO,OFICINA,FEC_EMISION,COD_PERSONAL,
                TIPO_COMPROBANTE,SERIE_CONTABILIDAD,COMP_CONTABILIDAD,IDENTIFICACION,COD_PROVEEDOR,NOMBRE,DIRECCION,
                OBS_COMPROBANTE,MONTO_COMPROBANTE,NRO_CORRELATIVO,USU_REGISTRO,CAJA,CONTABILIDAD,COD_EMPRESA,COD_CONCEPTO_CAJA)
                VALUES('$codigo','$oficina','$fec_emision','$cod_personal','$tipo_comprobante','$serie_contabilidad','$comp_contabilidad',
                '$identificacion','$cod_proveedor','$nombre','$direccion','$obs_comprovante','$monto_comprobante','$nro_correlativo','$usuario_registro','$caja','$contabilidad','$cod_empresa','$cod_concepto_caja')");
                $query1->execute();
                

                $query2 = $this->db->prepare("INSERT INTO T_TMP_GASTO_ITEM (CODIGO,COD_PRODUCTO,CAN_PRODUCTO,PREC_PRODUCTO) 
                VALUES('$codigo','$concepto','1','$monto_comprobante')");
                $query2->execute();

                if($existepro == 0){
                   $this->m_guardarpro($nombre,$direccion,$identificacion);
                }
               
                $this->db->commit();
                $mensaje = "echo";
            } catch (Exception $e) {
                $this->db->rollBack();
                $mensaje = $e;
            }
            $array =array($mensaje);
            return $array;
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

        public function m_proveedor($ruc){
            $query = $this->db->prepare("SELECT * FROM T_PROVEEDOR where RUC_PROVEEDOR = '$ruc'");
            $query->execute();
            if($query){
                return $query->fetch();
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

        public function m_guardarpro($nombre,$direccion,$ruc)
        {   
            $correla = $this->generarcod_proveedor();
            $cod_proveedor = generarcorrelativo($correla,2);
            $query = $this->db->prepare("INSERT INTO T_PROVEEDOR(COD_PROVEEDOR,NOM_PROVEEDOR,DIR_PROVEEDOR
            ,RUC_PROVEEDOR)
            VALUES('$cod_proveedor','$nombre','$direccion','$ruc')");
            $pro =  $query->execute();
            return $pro;
        }
      

        public function m_verificardoc($seriedoc)
        {
            $query = $this->db->prepare("SELECT * FROM T_TMP_GASTO WHERE SERIE_CONTABILIDAD = $seriedoc");
            $serie = $query->execute();
            return $query->fetch();
        }

        public function generarcodigo()
        {
            $query = $this->db->prepare("SELECT MAX(CODIGO)+1 as codigo FROM T_TMP_GASTO");
            $query->execute();
            $results = $query->fetch();
            return $results[0];
        }

        public function generarcod_proveedor()
        {
            $query = $this->db->prepare("SELECT MAX(COD_PROVEEDOR)+1 as cod_proveedor  FROM T_PROVEEDOR");
            $query->execute();
            $results = $query->fetch();
            return $results[0];
        }
        
    }
    

 


?>