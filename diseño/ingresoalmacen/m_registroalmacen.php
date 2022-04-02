<?php
require_once("../funciones/DataBasePlasticos.php");
require_once("../funciones/cod_almacenes.php");
require_once("../funciones/f_funcion.php");
require_once("../funciones/maquina.php");
class m_registroalmacen
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

      public function m_r_avances($produccion,$producto,$cantidad,$usu,$codpersonal,$codavance,$fechapro)
    {
        $hora = gethora();
        $maquina = os_info();
        $this->bd->beginTransaction();
        $fechapro = retunrFechaSqlphp($fechapro);
        try {
            $fecha = retunrFechaSqlphp(date("Y-m-d"));
            $cadena = "COD_PRODUCTO = '$producto'";
            $m_producto = $this->m_buscar('T_ALMACEN_TERMINADO',$cadena);
        if(count($m_producto) > 0){
            $cadena = "avance = '$codavance' and personal = '$codpersonal' and fecha ='$fechapro' and derivo = '0'";
            $m_avances = $this->m_buscar('V_VIEW_AVANCES',$cadena);
            if(count($m_avances) > 0){
                $query = $this->bd->prepare("INSERT INTO T_CONFIMACION_ALMACENG(COD_PRODUCCION,COD_PRODUCTO,CAN_PRODUCCION
                ,USU_REGISTRO,HOR_REGISTRO,MAQUINA)VALUES('$produccion','$producto','$cantidad','$usu','$hora','$maquina')");
                $query->execute();

                $stock =number_format(($m_producto[0][3] + $cantidad),2, '.', '');
                $query1 = $this->bd->prepare("UPDATE T_ALMACEN_TERMINADO SET STOCK_ACTUAL='$stock',
                FEC_MODIFICO = '$fecha' WHERE COD_PRODUCTO ='$producto'");         
                $query1->execute();

                for ($i=0; $i < count($m_avances) ; $i++) {
                    $codgen = $m_avances[$i][0]; 
                    $query2 = $this->bd->prepare("UPDATE T_AVANCE_PRODUCCION_ITEM SET DERIVO_AVANCE ='1'
                    WHERE id ='$codgen'");   
                    $resp = $query2->execute();
                    if($resp != 1 ){
                        $this->bd->rollBack();
                        return "Error al confirmar ingreso al almacen";
                    }    
                }
                $guardado = $this->bd->commit();
                return $guardado;

            }else{
                return "Error produccion no encontrada";
            }
        }else{
            return "Error no se encontro el producto en el almacen";
        }   
        } catch (Exception $e) {
            $this->bd->rollBack();
            print_r("Error al derivar los productos al almacen ". $e);
        }
      
    }   

    public function m_merma($produ){
        try {
            $query = $this->bd->prepare("SELECT MAX(COD_PRODUCCION) as produccion
            ,SUM(CANT_PROD_MALOG) malogrado FROM V_LISTAR_MERMA WHERE COD_PRODUCCION = '$produ'");
            $query->execute();
            $datos = $query->fetchAll(PDO::FETCH_NUM);
            return $datos;
        } catch (Exception $e) {
            print_r("Error en la consulta buscar ".$e);
        } 
        
    }
}
?>