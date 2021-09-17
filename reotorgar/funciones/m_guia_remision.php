<?php
    require_once("DataDinamica.php");
    require_once("f_funcion.php");
    require_once("cod_almacenes.php");
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
                $fecha_creacion = retunrFechaSql(date("d-m-Y"));
                $cod = $this->m_cod_guia_remision();
                $cod = generarcorrelativo($cod[0]['COD_GUIA'],1);
                $cod_almacen = oficiona($oficina);
                $query = $this->bd->prepare("INSERT INTO T_GUIA_REMISION (COD_GUIA,COD_PERSONAL,EST_GUIA,MOT_MOVI,COD_ALMACEN,FEC_CREACION)  
                VALUES('$cod','$cod_personal','P','PVTA','$cod_almacen',' $fecha_creacion')");
                //print_r($query);
                $crear = $query->execute();
              /*  if($crear){
                    $this->m_crear_item_guia($cod,$producto,$codebar);
                }*/
              
                $guardado = $this->bd->commit();

                return $guardado;
            } catch (Exception $e) {
                $this->bd->rollBack();
                echo $e;
            }
            





        }


        public function m_crear_item_guia($cod_guia,$cod_producto,$num_lote){
            $fecha_registro = retunrFechaSql(date("d-m-Y"));
            $query = $this->bd->prepare("INSERT INTO T_GUIA_REMISION_ITEM 
            (COD_GUIA,NUM_LOTE,COD_PRODUCTO,FEC_REGISTRO,EST_DET_PRODUCTO,EST_REG_PRODUCTO)
            VALUES ('$cod_guia', '$cod_producto' ,'$num_lote', '$fecha_registro','O','R')");
            $item = $query->execute();
            return $item;
        }



        public function m_cod_guia_remision(){
            $query = $this->bd->prepare("SELECT MAX(COD_GUIA)+1 as COD_GUIA FROM T_GUIA_REMISION");
            $query->execute();
            $cod = $query->fetchAll();
            return $cod;
        }
    


        public function m_guardar_noOrtogado($cod_personal,$oficina){
            $fecha = retunrFechaSql(date("d-m-Y"));
            $query = $this->bd->prepare("INSERT INTO TABLA(COD_PERSONAL,OFICINA,FECHA) 
            Values('$cod_personal','$oficina','$fecha')");
            $noOtorgado = $query->execute();
            return $noOtorgado;
        }

        public function m_verificar_item_guia($num_lote){
            $query = $this->bd->prepare("SELECT * FROM T_GUIA_REMISION_ITEM WHERE NUM_LOTE = '$num_lote'");
            $query->execute();
            $lote = $query->fetchAll();
            return $lote;
        }
    }
?>
