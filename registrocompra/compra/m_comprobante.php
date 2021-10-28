<?php
require_once("../funciones/DataBasePlasticos.php");
require_once("../funciones/cod_almacenes.php");
require_once("../funciones/f_funcion.php");
class m_comprobante
{
    private $bd;
    public function __construct() {
        $this->bd=DataBasePlasticos::Conectar();
    }

    public function m_buscar($tabla,$dato)
    {
        $query = $this->bd->prepare("SELECT * FROM $tabla WHERE $dato");
        $query->execute();
        $datos = $query->fetchAll();
        return $datos;
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

    public function m_guardarprod($codpro,$codcateg,$despro,$unimedpro,$stockmin,$abre,$usuregi,$pesoneto,$codclase,$oficina)
    {        $this->bd->beginTransaction();
            try {
                $producto = strtoupper($despro);
                $abre = strtoupper($abre);
                $codpro = strtoupper($codpro);
                $unimedpro = strtoupper($unimedpro);
                $fech_registro = retunrFechaSqlphp(date("Y-m-d"));
                $query = $this->bd->prepare("INSERT INTO T_PRODUCTO (COD_PRODUCTO,COD_CATEGORIA
                ,DES_PRODUCTO,UNI_MEDIDA,STOCK_MINIMO,ABR_PRODUCTO,PRE_PRODUCTO,EST_PRODUCTO,USU_REGISTRO,
                FEC_REGISTRO,MAQUINA,PESO_NETO,COD_CLASE) 
                VALUES('$codpro','$codcateg','$producto','$unimedpro',
                $stockmin,'$abre',0,'A','$usuregi','$fech_registro','','$pesoneto','$codclase')");
            
                $query->execute();  
                
                $oficina = oficiona($oficina);
                $correlativo = $this->m_select_generarcodigo('COD_ALIN','T_ALMACEN_INSUMOS');
                $query2 = $this->bd->prepare("INSERT INTO T_ALMACEN_INSUMOS (COD_ALIN,COD_ALMACEN,
                                            COD_PRODUCTO,COD_CLASE,STOCK_MINIMO) 
                VALUES('$correlativo','$oficina','$codpro','$codclase',$stockmin)");
                $query2->execute();

                $guardado = $this->bd->commit();
                return $guardado;
            } catch (Exception $e) {
                $this->bd->rollBack();
                echo $e;
            }    
           
    
    }
}

?>