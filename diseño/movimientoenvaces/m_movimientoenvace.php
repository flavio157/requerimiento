<?php
require_once("../funciones/DataBasePlasticos.php");
require_once("../funciones/cod_almacenes.php");
require_once("../funciones/f_funcion.php");
require_once("../funciones/maquina.php");
class m_movimientoenvace
{
    private $bd;
    public function __construct() {
        $this->bd=DataBasePlasticos::Conectar();
    }

    public function m_buscar($tabla,$dato)
    {
        try {
            $query = $this->bd->prepare("SELECT * FROM $tabla WHERE $dato");
            $query->execute();
            $datos = $query->fetchAll(PDO::FETCH_NUM);
            return $datos;
        } catch (Exception $e) {
            print_r("Error en la consulta buscar ".$e);
        } 
    }

    public function m_select_generarcodigo($campo,$tabla,$cantidad)
    {
            try {
            $query = $this->bd->prepare("SELECT MAX($campo)+1 as codigo FROM $tabla");
            $query->execute();
            $results = $query->fetch();
            if($results[0] == NULL) $results[0] = '1';
            $res = str_pad($results[0],$cantidad, '0', STR_PAD_LEFT);
            return $res;
            } catch (Exception $e) {
                print_r("Error al generar codigo " . $e);
            }
    }

    public function m_guardar($cod_guia,$almacen,$fecha,$direccion,$observacion,$usu,$producto){
        $this->bd->beginTransaction();
        $maquina = os_info();
        try {
            $fecha = retunrFechaSql($fecha);
            $query = $this->bd->prepare("INSERT INTO T_MOVIM_ENVACE(COD_MOVIMIENTO,COD_CLIENTE,FECHA,DIRECCION,
            OBSERVACION,USU_REGISTRO,MAQUINA)VALUES('$cod_guia','$almacen','$fecha','$direccion','$observacion','$usu',
            '$maquina')");
             $query->execute();
            foreach ($producto->tds as $dato){
                if($dato != ''){
                    $query2 = $this->bd->prepare("INSERT INTO T_MOVIM_ENVACE_ITEM(COD_MOVIMIENTO,COD_PRODUCTO,
                    CANTIDAD,USU_REGISTRO,MAQUINA) 
                    VALUES('$cod_guia','$dato[0]',$dato[1],'$usu','$maquina')");
                     $query2->execute(); 
                    if($query2->errorCode()>0){	
                        $this->bd->rollBack();
                        return 0;
                        break;
                    }
                }
            }  
            $guardado = $this->bd->commit();
            return $guardado;  
        }catch (Exception $e) {
            $this->bd->rollBack();
           print_r("Error al guardar los datos " .$e);
        }
    }

    public function m_stock($cod_prod,$cantidad){
        try {
            $query = $this->bd->prepare("UPDATE T_ALMACEN_TERMINADO SET STOCK_ACTUAL = '$cantidad' WHERE 
            COD_PRODUCTO = '$cod_prod'");
            $datos = $query->execute();
            return $datos; 
        }catch(Exception $e){
            print_r("Error al restar productos de almacen" . $e);
        }
    }

    public function m_guardarclie($cliente,$direccion,$ruc,$usu){
        try {
            $codclien = $this->m_select_generarcodigo('COD_CLIENTE','T_CLIENTE_MOLDE',6);
            $query = $this->bd->prepare("INSERT INTO T_CLIENTE_MOLDE(COd_CLIENTE,NOM_CLIENTE,DIR_CLIENTE,
            IDENTIFICACION,USU_REGISTRO)VALUES('$codclien','$cliente','$direccion','$ruc','$usu')");
            $resul = $query->execute();
            return array($codclien,$resul);
        } catch (Exception $e) {
            print_r("Error al guardar el cliente " . $e);
        }
    }
}
?>