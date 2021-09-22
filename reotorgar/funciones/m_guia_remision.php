<?php
    date_default_timezone_set('America/Lima');
    require_once("DataDinamica.php");
    require_once("f_funcion.php");
    require_once("cod_almacenes.php");
    require_once("m_almacen_producto.php");
    class m_guia_remision 
    {
        private $bd;
        public function __construct($oficina){
            $this->bd=DatabaseDinamica::Conectarbd($oficina);
        }


        public function m_verificar_guia_remision($cod_personal)
        {
           $fecha_creacion = retunrFechaSql(date("d-m-Y"));
           
           $query = $this->bd->prepare("SELECT * FROM T_GUIA_REMISION WHERE COD_PERSONAL = '$cod_personal' AND FEC_CREACION = '$fecha_creacion'");
           $query->execute();
           $remision = $query->fetchAll();
           return $remision;
        } 
        
        public function m_crear_guia_remision($codebar,$cod_personal,$oficina,$producto){
            $this->bd->beginTransaction();
            try {
                $fecha_emision = sumarfecha(1);
                $fecha_emision = retunrFechaSql($fecha_emision);
                $fecha_creacion = retunrFechaSql(date("d-m-Y"));
                $cod = $this->m_cod_guia_remision();
                $cod = generarcorrelativo($cod[0]['COD_GUIA'],1);
                $cod_almacen = oficiona($oficina);
                $query = $this->bd->prepare("INSERT INTO T_GUIA_REMISION (COD_GUIA,COD_PERSONAL,EST_GUIA,FEC_EMISION,MOT_MOVI,COD_ALMACEN,ALMA,COD_REGISTRO,FEC_REGISTRO,FEC_CREACION)  
                VALUES('$cod','$cod_personal','P','$fecha_emision','PVTA','$cod_almacen','$cod_almacen','$cod_personal','$fecha_creacion','$fecha_creacion')");
                
                $crear = $query->execute();
                if($crear){
                    $this->m_crear_item_guia($cod,$codebar,trim($producto),$cod_personal,$oficina);
                }
              
                $guardado = $this->bd->commit();

                return $cod;
            } catch (Exception $e) {
                $this->bd->rollBack();
                echo $e;
            }
        }


        public function m_crear_item_guia($cod_guia,$num_lote,$cod_producto,$cod_personal,$oficina){
            try {
                $fecha_registro = retunrFechaSql(date("d-m-Y"));
                $num_lote = trim($num_lote);
                $cod_producto = trim($cod_producto);
                $query = $this->bd->prepare("INSERT INTO T_GUIA_REMISION_ITEM 
                (COD_GUIA,NUM_LOTE,COD_PRODUCTO,FEC_REGISTRO,EST_DET_PRODUCTO,EST_REG_PRODUCTO)
                VALUES ('$cod_guia','$num_lote' ,'$cod_producto' , '$fecha_registro','O','R')");
             
                $item = $query->execute();
                if($item){
                    $almacen = new m_almacen_productos();
                    $almacen->m_actualizar_alamcen_proc($oficina,$cod_personal,$cod_guia,$num_lote);
                }
                return $item; 
            } catch (Exception $e) {
                $this->bd->rollBack();
                echo $e;
            }
        }

        public function m_cod_guia_remision(){
            $query = $this->bd->prepare("SELECT MAX(COD_GUIA)+1 as COD_GUIA FROM T_GUIA_REMISION");
            $query->execute();
            $cod = $query->fetchAll();
            return $cod;
        }

        public function m_verificar_item_guia($num_lote){
            $query = $this->bd->prepare("SELECT * FROM T_GUIA_REMISION_ITEM WHERE NUM_LOTE = '$num_lote'");
            $query->execute();
            $lote = $query->fetchAll();
            return $lote;
        }


        public function m_guardar_observacion_Proc($cod_personal,$oficina,$codebar){
            $fecha = retunrFechaSql(date("d-m-Y"));
            $codebar = trim($codebar);
            $hora =date("H:i:s"); 
            $query = $this->bd->prepare("INSERT INTO T_PRODUCTO_OBSERVACION_GUIA(COD_PERSONAL,OFICINA,
            FECHA,NUM_LOTE,HOR_REGISTRO)
            VALUES('$cod_personal','$oficina','$fecha','$codebar','$hora')");
            $observacion = $query->execute();
            return $observacion;
        }
    }
?>
