<?php
require_once("../funciones/DataBasePlasticos.php");
require_once("../funciones/cod_almacenes.php");
require_once("../funciones/f_funcion.php");
require_once("../funciones/maquina.php");
class m_produccion
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
    
    public function m_guardarocurrencia($produccion,$observacion,$usu)
    {
        try {
            $hora = gethora();
            $query = $this->bd->prepare("INSERT INTO T_OCURRENCIAS(COD_PRODUCCION,HOR_OCURRENCIA,OBS_OCURRENCIA,
            USU_REGISTRO) 
            VALUES('$produccion','$hora','$observacion','$usu')");
            $datos = $query->execute();
            return $datos;
        } catch (Exception $e) {
            print_r("Error en la consulta buscar ".$e);
        } 
    }

    public function m_guardarmerma($codproduccion,$fechmerma,$horamerma,$fechincidencia,$horaincidencia,
    $observacion,$usu,$items){
        $maquina = os_info();
        $fechmerma = retunrFechaSqlphp($fechmerma);
        $fechincidencia = retunrFechaSqlphp($fechincidencia);
        $fecha = retunrFechaSqlphp(date("Y-m-d"));
        $this->bd->beginTransaction();
        try {
            $codmerma = $this->m_select_generarcodigo('COD_MERMA','T_MERMAS',8);
            $query = $this->bd->prepare("INSERT INTO T_MERMAS(COD_MERMA,COD_PRODUCCION,FEC_MERMA,
            HOR_MERMA,FEC_INCIDENCIA,HOR_INCIDENCIA,OBS_INCIDENCIA,USU_REGISTRO,MAQUINA)VALUES('$codmerma','$codproduccion'
            ,'$fechmerma','$horamerma','$fechincidencia','$horaincidencia','$observacion','$usu','$maquina')");
            $query->execute();
                foreach ($items->r as $dato){ 
                    if($dato != ''){
                        $query2 = $this->bd->prepare("INSERT INTO T_MERMAS_ITEM(COD_MERMA,COD_PRODUCTO,CAN_PRODUCTO
                        ,TIPO_MERMA) 
                        VALUES('$codmerma','$dato[0]','$dato[1]','$dato[2]')");
                         $query2->execute(); 
                        if($query2->errorCode()>0){	
                            $this->bd->rollBack();
                            return 0;
                            break;
                        }

                        if($dato[2] == 'R'){
                            $cadena = "COD_PRODUCTO = '$dato[0]'";
                            $c_propio = $this->m_buscar('T_ALMACEN_INSUMOS',$cadena);
                            $stock =number_format(($c_propio[0][4] + $dato[1]),2, '.', '');
                            $query3 = $this->bd->prepare("UPDATE T_ALMACEN_INSUMOS SET STOCK_ACTUAL='$stock',
                            FEC_MODIFICO = '$fecha' WHERE COD_PRODUCTO ='$dato[0]'"); 
                            $query3->execute();
                            if($query3->errorCode()>0){	
                                $this->bd->rollBack();
                                return 0;
                                break;
                            }
    
                        }

                    }
                }        

            $guardado = $this->bd->commit();
            return $guardado;
        } catch (Exception $e) {
            $this->bd->rollBack();
            print_r("Error al guardar merma" .$e);
        }
    }

    public function m_guardarresiduos($codproduccion,
    $observacion,$usu,$items){
        $insumopasadas = ''; 
        $maquina = os_info();
        $this->bd->beginTransaction();$fecha = retunrFechaSqlphp(date("Y-m-d"));
        try {
            $codresiduos = $this->m_select_generarcodigo('COD_RESIDUOS','T_RESIDUOS',8);
            $query = $this->bd->prepare("INSERT INTO T_RESIDUOS(COD_RESIDUOS,COD_PRODUCCION,OBS_INCIDENCIA
            ,USU_REGISTRO,MAQUINA)VALUES('$codresiduos','$codproduccion','$observacion','$usu','$maquina')");
            $query->execute();
            foreach ($items->r as $dato){
                if($dato != ''){
                    $query2 = $this->bd->prepare("INSERT INTO T_RESIDUOS_ITEM(COD_RESIDUOS,COD_PRODUCTO,CAN_PRODUCTO) 
                    VALUES('$codresiduos','$dato[0]',$dato[1])");
                    $query2->execute(); 
                    if($query2->errorCode()>0){	
                        $this->bd->rollBack();
                        return 0;
                        break;
                    }
                    $cadena = "COD_PRODUCTO = '$dato[0]' or COD_INSUMO = '$dato[0]'"; //validar si es mayor a 5 no debe hhacer nada
                    $pasadas = $this->m_buscar('T_INSUMOS_PASADAS',$cadena);
                    $prod = $pasadas[0][0];$canpas = $pasadas[0][6];
                    if(count($pasadas) > 1){
                        $cadena = "COD_PRODUCTO = '$prod' AND TIPO_PASADA = '1'";
                        $pasadas = $this->m_buscar('T_INSUMOS_PASADAS',$cadena);
                        $insumopasadas = $pasadas[0][1];
                    }else{
                        (Int) $canpas =+ (Int)1;
                        $cadena = "COD_PRODUCTO = '$prod' AND TIPO_PASADA = '$canpas'";
                        $pasadas = $this->m_buscar('T_INSUMOS_PASADAS',$cadena);
                        $insumopasadas = $pasadas[0][1];
                    }
                   
                        $cadena = "COD_PRODUCTO = '$insumopasadas'";
                        $c_propio = $this->m_buscar('T_ALMACEN_INSUMOS',$cadena);
                        $stock =number_format(($c_propio[0][4] + $dato[1]),2, '.', '');
                        $query3 = $this->bd->prepare("UPDATE T_ALMACEN_INSUMOS SET STOCK_ACTUAL='$stock',
                        FEC_MODIFICO = '$fecha' WHERE COD_PRODUCTO ='$insumopasadas'"); 
                        $query3->execute();
                        if($query3->errorCode()>0){	
                            $this->bd->rollBack();
                            return 0;
                            break;
                        }
                }
            }  
            $guardado = $this->bd->commit();
            return $guardado;
        } catch (Exception $e) {
            $this->bd->rollBack();
            print_r("Error al guardar residuos" .$e);
        }
    }

    public function m_guardardesechos($codproduccion,$observacion,$usu,$items)
    {
        $maquina = os_info();
        $this->bd->beginTransaction();
        try {
            $coddesechos = $this->m_select_generarcodigo('COD_DESECHOS','T_DESECHOS',8);
            $query = $this->bd->prepare("INSERT INTO T_DESECHOS(COD_DESECHOS,COD_PRODUCCION,OBS_INCIDENCIA
            ,USU_REGISTRO,MAQUINA)VALUES('$coddesechos','$codproduccion','$observacion','$usu','$maquina')");
            $query->execute();
            foreach ($items->r as $dato){
                if($dato != ''){
                    $query2 = $this->bd->prepare("INSERT INTO T_DESECHOS_ITEM(COD_DESECHOS,COD_PRODUCTO,CAN_PRODUCTO) 
                    VALUES('$coddesechos','$dato[0]',$dato[1])");
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
        } catch (Exception $e) {
            $this->bd->rollBack();
            print_r("Error al guardar desechos" .$e);
        }
    }

    public function m_gvances($tara,$pesoneto,$cantxbolsa,$paquexsacar,$lote,$produccion,$usu,$total,$fin,$producto,
    $totalproduc)
    {
        $maquina = os_info();
        $fecha = retunrFechaSqlphp(date("Y-m-d"));
        $this->bd->beginTransaction();
        $cantalm = 0;
        try {
            $codavance = $this->m_select_generarcodigo('COD_AVANCE','T_AVANCE_PRODUCCION',9);
            $query = $this->bd->prepare("INSERT INTO T_AVANCE_PRODUCCION(COD_PRODUCCION,COD_AVANCE,TARA
            ,PESO_NETO,CANT_PAQUETE,CANT_BOLSA,NUM_LOTE,USU_REGISTRO,MAQUINA)/* CANT_PAQUETE es el total de cajas a sacar*/
            VALUES('$produccion','$codavance','$tara','$pesoneto','$total','$cantxbolsa','$lote','$usu','$maquina')");
            $query->execute();
            
            $query2 = $this->bd->prepare("INSERT INTO T_AVANCE_PRODUCCION_ITEM(COD_AVANCE,CANT_PAQUETE,OPERARIO,
            USU_REGISTRO,IMPRESO)VALUES('$codavance','$paquexsacar','$usu','$usu','0')");
            $query2->execute();

            if($fin == 0){
               $query3 = $this->bd->prepare("UPDATE T_PRODUCCION SET EST_PRODUCCION ='1' ,USU_MODIFICO ='$usu',
                FEC_MODIFICO ='$fecha' WHERE COD_PRODUCCION = '$produccion'");
                $query3->execute();
                if($totalproduc % $cantxbolsa != 0 ){$total = $cantxbolsa * ($paquexsacar - 1);}
                else{$total = $cantxbolsa * ($paquexsacar);}    
                $cantalm = $total + ($totalproduc % $cantxbolsa);
            }else{ 
                $cantalm =  $cantxbolsa * $paquexsacar ;
            }

            $r = $this->m_actualmacen($producto,$cantalm,$fecha);
            if($r != 1){	
                $this->bd->rollBack();
                print_r("Error al actualizar almacen");
                return;
            }   

            $guardado = $this->bd->commit();
            return $guardado;
        } catch (Exception $e) {
            $this->bd->rollBack();
            print_r("Error al guardar avances de la formulación" .$e);
        }
    }

    public function m_itemavance($cantavance,$usu,$prod,$fin,$producto){
        $this->bd->beginTransaction();
        $fecha = retunrFechaSqlphp(date("Y-m-d"));
        $cantalm = 0;
        try {
            $consulta = "COD_PRODUCCION = '$prod'";
            $avance = $this->m_buscar('T_AVANCE_PRODUCCION',$consulta);
            $codavace = $avance[0][1]; $produccion = $avance[0][0];
            $query1 = $this->bd->prepare("INSERT INTO T_AVANCE_PRODUCCION_ITEM(COD_AVANCE,CANT_PAQUETE,OPERARIO,
            USU_REGISTRO,IMPRESO)VALUES('$codavace','$cantavance','$usu','$usu','0')");
            $query1->execute();

            if($fin == 0){
                $query2 = $this->bd->prepare("UPDATE T_PRODUCCION SET EST_PRODUCCION ='1' ,USU_MODIFICO ='$usu',
                FEC_MODIFICO ='$fecha' WHERE COD_PRODUCCION = '$produccion'");
                $query2->execute();
                $cantalm = $this->m_verificaralmac($prod,$cantavance);
            }else{
                $cantalm =  $avance[0][5] * $cantavance;
            }
            $r = $this->m_actualmacen($producto,$cantalm,$fecha);
            if($r != 1){	
                $this->bd->rollBack();
                print_r("Error al actualizar almacen");
                return;
            }      

            $guardado = $this->bd->commit();
            return $guardado;
        } catch (Exception $e) {
            $this->bd->rollBack();
            print_r("Error al guardar avances de la formulacion items" .$e);
        }
    }

    public function m_actualizar_impresion($avance){
        try {
            $query = $this->bd->prepare("UPDATE T_AVANCE_PRODUCCION_ITEM SET IMPRESO = '1' 
            WHERE ID = '$avance'");
            $result = $query->execute();
            return $result;
        } catch (Exception $e) {
            print_r("Error al guardar impresion " . $e);
        }
    }
    
    public function m_verificaralmac($produccion,$paquetexsacar)
    {
        $cadena = "produccion = '$produccion'";
        $c_formula = $this->m_buscar('V_VIEW_AVANCES',$cadena);
        if(count($c_formula) > 0){ 
            if($c_formula[0][8] % $c_formula[0][7] != 0){ $total = $c_formula[0][7] * ($paquetexsacar - 1);}
            else{$total = $c_formula[0][7] * ($paquetexsacar);}
            $cantalm = $total + ($c_formula[0][8] % $c_formula[0][7]);
            return $cantalm;
        }
    }

    public function m_actualmacen($producto,$cantalm,$fecha){
        try {
            $cadena = "COD_PRODUCTO = '$producto'";
            $c_propio = $this->m_buscar('T_ALMACEN_INSUMOS',$cadena);
            $stock =number_format(($c_propio[0][4] + $cantalm),2, '.', '');
            $query4 = $this->bd->prepare("UPDATE T_ALMACEN_INSUMOS SET STOCK_ACTUAL='$stock',
            FEC_MODIFICO = '$fecha' WHERE COD_PRODUCTO ='$producto'"); 
            $result = $query4->execute();
            return $result;
        } catch (Exception $e) {
            return $e;
        }
       
    }

}
?>