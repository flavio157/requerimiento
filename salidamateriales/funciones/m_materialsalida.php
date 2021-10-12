<?php
date_default_timezone_set('America/Lima');
require_once("DataBase.php");
require_once("f_funcion.php");
    class m_materiasalida 
    {
        private $bd;

        public function __construct()
        {
            $this->bd=DataBase::Conectar();
        }

        public function m_buscarlike($tabla,$columna2,$valores,$dato){
            $query = $this->bd->prepare("SELECT * FROM $tabla where 
            $columna2 LIKE '%$dato%' AND $valores");
            $query->execute();
            $datos = $query->fetchAll();
            return $datos;
        }

        public function m_buscar($tabla,$dato)
        {
            $query = $this->bd->prepare("SELECT * FROM $tabla WHERE $dato");
            $query->execute();
            $datos = $query->fetchAll();
            return $datos;
        }

        public function m_update($tabla,$valores,$where)
        {
            $query = $this->bd->prepare("UPDATE $tabla SET $valores WHERE $where");
            $resp = $query->execute();
            return $resp;
        }

        public function m_guardar($codpersonal,$perregistro,$des,$items)
        {  
            $this->bd->beginTransaction();
            try {
                $codsalida = $this->m_select_generarcodigo();
                $fech_registro = retunrFechaSqlphp(date("Y-m-d"));
                $query = $this->bd->prepare("INSERT INTO T_MATERIALES_SALIDA (CODIGO_SALIDA,NUM_DOC_SALIDA
                ,PERSONAL_SOLICITO,USUARIO_REGISTRO,FECH_REGISTRO,DESCRIPCION) 
                VALUES('$codsalida','$codsalida','$codpersonal','$perregistro',
                '$fech_registro','$des')");
                $query->execute();  
                foreach ($items->tds as $dato){
                    $query2 = $this->bd->prepare("INSERT INTO T_DETSALIDA(CODIGO_SALIDA,COD_PRODUCTO,
                    CAN_PRODUCTO,COD_PRODUCTO_DEV,NUM_SERIE) 
                    VALUES('$codsalida','$dato[0]',$dato[2],'','$dato[1]')");
                    $query2->execute(); 
                            if($query2->errorCode()>0){	
                                $this->bd->rollBack();
                                return 0;
                                    break;
                                }
                }  
                $guardado = $this->bd->commit();
                return $guardado;  
            } catch (Exception $e) {
                $this->bd->rollBack();
                echo $e;
            }
        }

        public function m_select_generarcodigo()
        {
            $query = $this->bd->prepare("SELECT MAX(CODIGO_SALIDA)+1 as codigo FROM T_MATERIALES_SALIDA");
            $query->execute();
            $results = $query->fetch();
            if($results[0] == NULL) $results[0] = '1';
            $res = str_pad($results[0], 8, '0', STR_PAD_LEFT);
            return $res;
        }

        public function m_guardarprod($producto,$unidad,$codigopro,$abre,$contable,$neto,$clase,$personal,$stock)
        {
            /*cambiar esta haci solo por el momento*/
            $producto = strtoupper($producto);
            $fech_registro = retunrFechaSqlphp(date("Y-m-d"));
            $query = $this->bd->prepare("INSERT INTO T_PRODUCTO (COD_PRODUCTO,COD_CATEGORIA
            ,DES_PRODUCTO,UNI_MEDIDA,STOCK_MINIMO,ABR_PRODUCTO,PRE_PRODUCTO,EST_PRODUCTO,USU_REGISTRO,
            FEC_REGISTRO,MAQUINA,COD_EMPRESA,COD_CONTABLE,PESO_NETO,COD_CLASE) 
            VALUES('$codigopro','00003','$producto','$unidad',
            $stock,'$abre',0,'A','$personal','$fech_registro','','00001','$contable','$neto','$clase')");
            $resp  = $query->execute();  

            $query2 = $this->bd->prepare("INSERT INTO T_ALMACEN_INSUMOS (COD_ALIN,COD_ALMACEN,COD_PRODUCTO,STOCK_ACTUAL,COD_CLASE) 
            VALUES('7','00028','$codigopro',$stock,'$clase')");
            $resp2  = $query2->execute();
            return $resp2;
        }


    }
?>