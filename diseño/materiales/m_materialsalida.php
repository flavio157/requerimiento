<?php
date_default_timezone_set('America/Lima');
require_once("../funciones/DataBasePlasticos.php");
require_once("../funciones/f_funcion.php");
    class m_materiasalida 
    {
        private $bd;

        public function __construct()
        {
            $this->bd=DataBasePlasticos::Conectar();
        }

        public function m_buscar($tabla,$cadena)
        {
            $query = $this->bd->prepare("SELECT * FROM $tabla WHERE $cadena");
            $query->execute();
            $datos = $query->fetchAll();
            return $datos;
        }

        public function m_update_stock($tabla,$cadena)
        {
            $query = $this->bd->prepare("UPDATE $tabla $cadena");
            $resp = $query->execute();
            return $resp;
        }


        public function m_guardar($codpersonal,$perregistro,$des,$items)
        {  
            $this->bd->beginTransaction();
            try {
                $codsalida = $this->m_select_generarcodigo('CODIGO_SALIDA','T_MATERIALES_SALIDA');
                $fech_registro = retunrFechaSqlphp(date("Y-m-d"));
                $query = $this->bd->prepare("INSERT INTO T_MATERIALES_SALIDA (CODIGO_SALIDA,NUM_DOC_SALIDA
                ,PERSONAL_SOLICITO,USUARIO_REGISTRO,FECH_REGISTRO,DESCRIPCION) 
                VALUES('$codsalida','$codsalida','$codpersonal','$perregistro',
                GETDATE(),'$des')");
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

        public function m_select_generarcodigo($campo,$tabla)
        {
            $query = $this->bd->prepare("SELECT MAX($campo)+1 as codigo FROM $tabla");
            $query->execute();
            $results = $query->fetch();
            if($results[0] == NULL) $results[0] = '1';
            $res = str_pad($results[0], 8, '0', STR_PAD_LEFT);
            return $res;
        }
    }
?>