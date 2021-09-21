<?php
    require_once("DataBase.php");
    require_once("cod_almacenes.php");
    
    class m_verficiarproducto 
    {
        public function __construct() {
            $this->bd=DataBase::Conectar();
        }

        public function m_verificarProcAlmaXofi($num_lote,$oficina){
            $oficina = oficiona(trim($oficina));
            $query = $this->bd->prepare("SELECT * FROM T_ALMACEN_PRODUCTOS where NUM_LOTE = '$num_lote' AND COD_ALMACEN = '$oficina'");
            $query->execute();
            $valor = $query->fetchAll();
            return $valor;
        }

        public function m_verificarProcAlma($num_lote){
            $query = $this->bd->prepare("SELECT * FROM T_ALMACEN_PRODUCTOS where NUM_LOTE = '$num_lote'");
            $query->execute();
            $valor = $query->fetchAll();
            return $valor;
        }

        public function m_buscarcombo_producto($cod_combo){
            $query = $this->bd->prepare("SELECT * FROM V_BUSCAR_ITEM_COMBO WHERE IDENTIFICADOR = '$cod_combo'");
            $query->execute();
            $combos = $query->fetchAll();
            return $combos;
        }
    }
    

?>