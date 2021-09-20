<?php
    require_once("DataBase.php");
    require_once("cod_almacenes.php");
    class m_almacen_productos 
    {
        private $bd;
    
        public function __construct()
        {
            $this->bd=DataBase::Conectar();
        }

        public function m_buscar_Almacen($num_lote,$oficina)
        {
            $cod_almacen = trim(oficiona($oficina));
            $query= $this->bd->prepare("SELECT * FROM T_ALMACEN_PRODUCTOS WHERE NUM_LOTE = '$num_lote' 
                                AND COD_ALMACEN = '$cod_almacen'");
            $query->execute();
            $producto = $query->fetchAll();
            return $producto;
        }

        public function m_guardar_observacion_Proc($cod_personal,$oficina,$codebar){
            //print_r($cod_personal."/".$oficina."/".$codebar);
            $fecha = retunrFechaSql(date("d-m-Y"));
            $codebar = trim($codebar);
            $query = $this->bd->prepare("INSERT INTO T_PRODUCTO_OBSERVACION_GUIA(COD_PERSONAL,OFICINA,FECHA,NUM_LOTE)
            VALUES('$cod_personal','$oficina','$fecha','$codebar')");
           
            $observacion = $query->execute();
            return $observacion;
            //return;
        }


        public function m_actualizar_alamcen_proc($fec_emision,$oficina,$cod_personal,$cod_guia,
                                                  $num_lote){
            $cod_almacen = oficiona($oficina);
            $query = $this->bd->prepare("UPDATE T_ALMACEN_PRODUCTOS set FEC_EMISION = '$fec_emision',
            COD_ALMACEN='$cod_almacen',COD_PERSONAL = '$cod_personal',COD_GUIA='$cod_guia',COD_CONFIRMACION = '1',
            OBSERVACION ='PISTOLEADO POR WEB' where NUM_LOTE= '$num_lote'");

            $almacen = $query->execute();
            return $almacen;
        }
        
        
        public function m_buscarcombo_producto($cod_combo){
            $query = $this->bd->prepare("SELECT * FROM V_BUSCAR_ITEM_COMBO WHERE IDENTIFICADOR = '$cod_combo'");
            $query->execute();
            $combos = $query->fetchAll();
            return $combos;
        }

    }
    
?>