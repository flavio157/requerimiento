<?php
require_once("../funciones/DataBasePlasticos.php");
require_once("../funciones/cod_almacenes.php");
require_once("../funciones/f_funcion.php");
require_once("../funciones/maquina.php");
class m_formulacion
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
    
    public function m_buscarformulacion()
    {
        try {
            $query = $this->bd->prepare("SELECT * FROM  V_CABECERA_FORMULACION");
            $query->execute();
            $datos = $query->fetchAll(PDO::FETCH_NUM);
            return $datos;
        } catch (Exception $e) {
            print_r("Error en la consulta buscar ".$e);
        } 
    }

    public function m_guardarformulacion($nomfor,$codproducto,$cantxformula
    ,$unidamedida,$items,$usu){
        $maquina = os_info();
        $hora = gethora();
        $this->bd->beginTransaction();
        try {
            $codform = $this->m_select_generarcodigo('COD_FORMULACION','T_FORMULACION',5);
            $query = $this->bd->prepare("INSERT INTO T_FORMULACION(COD_FORMULACION,NOM_FORMULACION,
            COD_PRODUCTO,COD_CATEGORIA,HOR_GENERADO,CAN_FORMULACION,UNI_MEDIDA,USU_REGISTRO) 
            VALUES('$codform','$nomfor','$codproducto','00001','$hora','$cantxformula',
            '$unidamedida','$usu')");
            $query->execute();
            
            foreach ($items->tds as $dato){
                if($dato != ''){
                    $query2 = $this->bd->prepare("INSERT INTO T_FORMULACION_ITEM(COD_FORMULACION,COD_PRODUCTO,
                    CAN_FORMULACION,EST_FORMULACION,USU_REGISTRO,MAQUINA,CAN_FIJA) 
                    VALUES('$codform','$dato[0]',$dato[1],'1','$usu','$maquina','$dato[2]')");
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
            print_r("Error al guardar formulacion " . $e); 
        }

    }

    public function m_additems($codform,$prod,$canti,$usu)
    {
       $maquina = os_info();
       try {
        $query = $this->bd->prepare("INSERT INTO T_FORMULACION_ITEM(COD_FORMULACION,COD_PRODUCTO,
        CAN_FORMULACION,EST_FORMULACION,USU_REGISTRO,MAQUINA) 
        VALUES('$codform','$prod',$canti,'1','$usu','$maquina')");
        $result = $query->execute(); 
        return $result;
       } catch (Exception $e) {
           print_r("Error al agregar materiales ". $e);
       }
    }

    public function m_modificar_items($codform,$codprod,$cant,$usu,$fijo)
    {
        $fecha = retunrFechaSqlphp(date("Y-m-d"));
        try {
            $query = $this->bd->prepare("UPDATE T_FORMULACION_ITEM SET CAN_FORMULACION = '$cant',
            USU_MODIFICO = '$usu' , FEC_MODIFICO = '$fecha',CAN_FIJA = '$fijo' WHERE
            COD_FORMULACION ='$codform' AND COD_PRODUCTO = '$codprod'");
            $result = $query->execute();
            return $result;
        } catch (Exception $e) {
            print_r("Error al actualizar material " . $e);
        }
    }

    public function m_deletemate($codform,$codpro)
    {
        try {
           $query = $this->bd->prepare("DELETE T_FORMULACION_ITEM WHERE COD_FORMULACION = '$codform' 
           AND COD_PRODUCTO = '$codpro'");
           $result = $query->execute();
           return $result;
        } catch (Exception $e) {
            print_r("Error al eliminar el material" . $e);
        }
    }

    public function m_modificar_formu($codform,$nombre,$codprod,$uni,$canformula,$usumodi)
    {
        $fecha = retunrFechaSqlphp(date("Y-m-d"));
        try {
            $query = $this->bd->prepare("UPDATE T_FORMULACION SET NOM_FORMULACION = '$nombre', 
            COD_PRODUCTO ='$codprod',CAN_FORMULACION = '$canformula' ,UNI_MEDIDA = '$uni', USU_MODIFICO ='$usumodi',
            FEC_MODIFICO = '$fecha' WHERE COD_FORMULACION = '$codform'");
            $result = $query->execute();
            return $result;
        } catch (Exception $e) {
            print_r("Error al actualizar la formula " . $e);
        }
    }
}
?>