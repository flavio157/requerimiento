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

    public function m_guardarmerma($codproduccion,$fechincidencia,$horaincidencia,
    $observacion,$usu,$canmerma,$tipomer,$falla){
        $maquina = os_info();
        $fechincidencia = retunrFechaSqlphp($fechincidencia);
        $fecha = retunrFechaSqlphp(date("Y-m-d"));
        $hora = gethora();
        $this->bd->beginTransaction();
        try {
            $codmerma = $this->m_select_generarcodigo('COD_MERMA','T_MERMAS',8);
            $query = $this->bd->prepare("INSERT INTO T_MERMAS(COD_MERMA,COD_PRODUCCION,FEC_MERMA,
            HOR_MERMA,FEC_INCIDENCIA,HOR_INCIDENCIA,OBS_INCIDENCIA,USU_REGISTRO,MAQUINA)VALUES('$codmerma','$codproduccion'
            ,'$fecha','$hora','$fechincidencia','$horaincidencia','$observacion','$usu','$maquina')");
            $query->execute();
                        $query2 = $this->bd->prepare("INSERT INTO T_MERMAS_ITEM(COD_MERMA,COD_PRODUCTO,CAN_PRODUCTO
                        ,TIPO_MERMA,CANT_PROD_MALOG) 
                        VALUES('$codmerma','000046','$canmerma','$tipomer','$falla')");
                         $query2->execute();
                        if($tipomer == 'R'){
                            $cadena = "COD_PRODUCTO = '000046'";//    000055   cambia el codigo del producto solo es prueba
                            $c_propio = $this->m_buscar('T_ALMACEN_INSUMOS',$cadena);
                            $stock =number_format(($c_propio[0][4] + $canmerma),2, '.', '');
                            $query3 = $this->bd->prepare("UPDATE T_ALMACEN_INSUMOS SET STOCK_ACTUAL='$stock',
                            FEC_MODIFICO = '$fecha' WHERE COD_PRODUCTO ='000046'"); 
                            $query3->execute();
                        }
            $guardado = $this->bd->commit();
            return $guardado;
        } catch (Exception $e) {
            $this->bd->rollBack();
            print_r("Error al guardar merma" .$e);
        }
    }

    public function m_guardarresiduos($codproduccion,
    $observacion,$usu,$cantidad,$color){
        $insumoar = array();
        $maquina = os_info();
        $this->bd->beginTransaction();$fecha = retunrFechaSqlphp(date("Y-m-d"));
        try {
            $codresiduos = $this->m_select_generarcodigo('COD_RESIDUOS','T_RESIDUOS',8);
            $query = $this->bd->prepare("INSERT INTO T_RESIDUOS(COD_RESIDUOS,COD_PRODUCCION,OBS_INCIDENCIA
            ,USU_REGISTRO,MAQUINA)VALUES('$codresiduos','$codproduccion','$observacion','$usu','$maquina')");
            $query->execute();
                $cadena = "COD_PRODUCCION ='$codproduccion'";
                $item = $this->m_buscar('T_PRODUCCION_ITEM',$cadena);
                if(count($item) > 0){
                    for ($i=0; $i <count($item) ; $i++) { 
                        $cod = $item[$i][1];
                        $cadena1 = "COLOR_INSUMO = '$color' AND COD_PRODUCTO = '$cod' OR COD_INSUMO = '$cod'";
                        $item1 = $this->m_buscar('T_INSUMOS_PASADAS',$cadena1);

                        if(count($item1) > 1){                                                                                          
                            array_push($insumoar,array($item1[0][0],$item1[0][0],0));
                        }else if(count($item1) == 1){
                            array_push($insumoar,array($item1[0][0],$item1[0][1],$item1[0][6]));
                        }

                        if(count($item1) > 0)
                        for ($l=0; $l <count($insumoar) ; $l++) { 
                            if($insumoar[$l][0] == $item1[0][0] && count($item) > 1){
                                if($insumoar[$l][2] < $item1[0][6]){
                                       if(count($insumoar) > 1){
                                        $insumoar[$l][1] = $item1[0][1];
                                        unset($insumoar[$i]);}
                                        else if(count( $item1) == 1){
                                            $insumoar[$l][2] = $item1[0][6] ;   
                                        }  
                                }
                            }
                        }
                    }
                }

                  
                    for ($j=0; $j < count($insumoar); $j++) { 
                        $codinsumo = $insumoar[$j][0];
                        $query2 = $this->bd->prepare("INSERT INTO T_RESIDUOS_ITEM(COD_RESIDUOS,COD_PRODUCTO,CAN_PRODUCTO) 
                        VALUES('$codresiduos','$codinsumo',$cantidad)");
                        $query2->execute(); 
                        if($query2->errorCode()>0){	
                            $this->bd->rollBack();
                            return 0;
                            break;
                        }
                        $pasada =  ((int)$insumoar[0][2] + (int)1);
                      
                        if($pasada < 5)
                        $cadena = "COD_PRODUCTO = '$codinsumo' AND TIPO_PASADA = '$pasada' AND COLOR_INSUMO = '$color'";
                        $pasadas = $this->m_buscar('T_INSUMOS_PASADAS',$cadena);
                     
                        $prod = $pasadas[0][1];
                        
                        $cadena = "COD_PRODUCTO = '$prod'";
                        $c_propio = $this->m_buscar('T_ALMACEN_INSUMOS',$cadena);
                        $codinsumo = $c_propio[0][2];
                        $stock =number_format(($c_propio[0][4] + $cantidad),2, '.', '');
                        $query3 = $this->bd->prepare("UPDATE T_ALMACEN_INSUMOS SET STOCK_ACTUAL='$stock',
                        FEC_MODIFICO = '$fecha' WHERE COD_PRODUCTO ='$codinsumo'"); 
                        
                        $query3->execute();
                       if($query3->errorCode()>0){	
                            $this->bd->rollBack();
                            return 0;
                            break;
                        }
                    }
            $guardado = $this->bd->commit();
            return $guardado;
        } catch (Exception $e) {
            $this->bd->rollBack();
            print_r("Error al guardar residuos" .$e);
        }
    }

    public function m_guardardesechos($codproduccion,$observacion,$usu,$cantidad)
    {
        $fecha = retunrFechaSqlphp(date("Y-m-d"));
        $maquina = os_info();
        $this->bd->beginTransaction();
        try {
            $coddesechos = $this->m_select_generarcodigo('COD_DESECHOS','T_DESECHOS',8);
            $query = $this->bd->prepare("INSERT INTO T_DESECHOS(COD_DESECHOS,COD_PRODUCCION,OBS_INCIDENCIA
            ,USU_REGISTRO,MAQUINA)VALUES('$coddesechos','$codproduccion','$observacion','$usu','$maquina')");
            $query->execute();
            $query2 = $this->bd->prepare("INSERT INTO T_DESECHOS_ITEM(COD_DESECHOS,COD_PRODUCTO,CAN_PRODUCTO) 
                      VALUES('$coddesechos','000047',$cantidad)");
            $query2->execute(); 

            $cadena = "COD_PRODUCTO = '000047'";//    000055   cambia el codigo del producto solo es prueba
            $c_propio = $this->m_buscar('T_ALMACEN_INSUMOS',$cadena);
            $stock =number_format(($c_propio[0][4] + $cantidad),2, '.', '');
            $query3 = $this->bd->prepare("UPDATE T_ALMACEN_INSUMOS SET STOCK_ACTUAL='$stock',
            FEC_MODIFICO = '$fecha' WHERE COD_PRODUCTO ='000047'"); 
            $query3->execute();

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

            if($fin == 1){
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
           return "Error al guardar avances de la formulación" .$e;
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

            if($fin == 1){
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
            return "Error al guardar avances de la formulacion items" .$e;
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

    public function m_finalizarproduccion($produccion,$usu){
        try {
            $fecha = retunrFechaSqlphp(date("Y-m-d"));
            $query3 = $this->bd->prepare("UPDATE T_PRODUCCION SET EST_PRODUCCION ='1' ,USU_MODIFICO ='$usu',
            FEC_MODIFICO ='$fecha' WHERE COD_PRODUCCION = '$produccion'");
            $result = $query3->execute();
            return $result;
        } catch (Exception $e) {
           print_r("Error al terminar produccion  " . $e);
        }
    }


    public function m_actualizarmerma($cantmerma,$descripcion,$usu,$merma,$cantidadAnter,$cantidadnueva,$cantfalla,$slcmdtipoAnt,$slcmdtipomodi)
    {  
       
        $fecha = retunrFechaSqlphp(date("Y-m-d"));
        $this->bd->beginTransaction();
        try {
            if($slcmdtipoAnt == 'R' && $slcmdtipomodi == 'P'){
                $consul = "COD_MERMA = '$merma'";
                $result = $this->m_buscar("T_MERMAS_ITEM",$consul);
                $producto = $result[0][1];
                $consul = "COD_PRODUCTO = '$producto'";
                $almacen = $this->m_buscar("T_ALMACEN_INSUMOS",$consul);
                $stock = number_format(($almacen[0][4] - $cantidadAnter),2, '.', '');
                $query4 = $this->bd->prepare("UPDATE T_ALMACEN_INSUMOS SET STOCK_ACTUAL='$stock',
                FEC_MODIFICO = '$fecha' WHERE COD_PRODUCTO ='$producto'"); 
                $result = $query4->execute();
            }
            else if($slcmdtipoAnt == 'P' && $slcmdtipomodi == 'R' || $slcmdtipoAnt == 'R' && $slcmdtipomodi == 'R'){
                $consul = "COD_MERMA = '$merma'";
                $result = $this->m_buscar("T_MERMAS_ITEM",$consul);
                $producto = $result[0][1];
                $consul = "COD_PRODUCTO = '$producto'";
                $almacen = $this->m_buscar("T_ALMACEN_INSUMOS",$consul);
                $stock = number_format(($almacen[0][4] - $cantidadAnter),2, '.', '');
                $stock = number_format(($stock + $cantidadnueva),2, '.', '');
                $query4 = $this->bd->prepare("UPDATE T_ALMACEN_INSUMOS SET STOCK_ACTUAL='$stock',
                FEC_MODIFICO = '$fecha' WHERE COD_PRODUCTO ='$producto'"); 
                $result = $query4->execute();
            }

            $query = $this->bd->prepare("UPDATE T_MERMAS SET OBS_INCIDENCIA='$descripcion',
            FEC_MODIFICO = '$fecha',USU_MODIFICO = '$usu' WHERE COD_MERMA ='$merma'"); 
            $query->execute();

            $query1 = $this->bd->prepare("UPDATE T_MERMAS_ITEM SET CAN_PRODUCTO = '$cantmerma',
            TIPO_MERMA ='$slcmdtipomodi',CANT_PROD_MALOG = '$cantfalla'
            WHERE COD_MERMA = '$merma'");
            $query1->execute();

            $guardado = $this->bd->commit();
            return $guardado;
        } catch (Exception $e) {
            $this->bd->rollBack();
            print_r("Error al actualizar merma ". $e);
        }
    }

    public function m_actdesechos($cantdesecho,$descripcion,$usu,$coddesecho)
    {
        $fecha = retunrFechaSqlphp(date("Y-m-d"));
        $this->bd->beginTransaction();
        try {
            $query = $this->bd->prepare("UPDATE T_DESECHOS SET OBS_INCIDENCIA='$descripcion',
            FEC_MODIFICO = '$fecha',USU_MODIFICO = '$usu' WHERE COD_DESECHOS ='$coddesecho'"); 
            $query->execute();

          
            $query1 = $this->bd->prepare("UPDATE T_DESECHOS_ITEM SET CAN_PRODUCTO = $cantdesecho
            WHERE COD_DESECHOS = '$coddesecho'");
             
            $query1->execute();

            $guardado = $this->bd->commit();
            return $guardado;
        } catch (Exception $e) {
            $this->bd->rollBack();
            print_r("Error al actualizar desechos ". $e);
        }
    }
    
    public function m_actresiduos($canresiduos,$descripcion,$usu,$codresiduos,$cantidadAnter,$cantidadnueva){
        $fecha = retunrFechaSqlphp(date("Y-m-d"));
        $this->bd->beginTransaction(); // primero busca el insumo a actualizar una vez encontrado, resta la cantidad anterior y luego suma la cantidad actual que actulizo
        try { 
           
            $query = $this->bd->prepare("UPDATE T_RESIDUOS SET OBS_INCIDENCIA='$descripcion',
            FEC_MODIFICO = '$fecha',USU_MODIFICO = '$usu' WHERE COD_RESIDUOS ='$codresiduos'"); 
            $query->execute();

            $query1 = $this->bd->prepare("UPDATE T_RESIDUOS_ITEM SET CAN_PRODUCTO = '$canresiduos'
            WHERE COD_RESIDUOS = '$codresiduos'");
            $query1->execute();

            $consul = "COD_RESIDUOS = '$codresiduos'";
            $result = $this->m_buscar("T_RESIDUOS_ITEM",$consul);
            $producto = $result[0][1];
            $consul = "COD_PRODUCTO = '$producto'";
            $almacen = $this->m_buscar("T_ALMACEN_INSUMOS",$consul);
            $stock = number_format(($almacen[0][4] - $cantidadAnter),2, '.', '');
            $stock = number_format(($stock + $cantidadnueva),2, '.', '');
            
            $query4 = $this->bd->prepare("UPDATE T_ALMACEN_INSUMOS SET STOCK_ACTUAL='$stock',
            FEC_MODIFICO = '$fecha' WHERE COD_PRODUCTO ='$producto'"); 
            $result = $query4->execute();


            $guardado = $this->bd->commit();
            return $guardado;
        } catch (Exception $e) {
            $this->bd->rollBack();
            print_r("Error al actualizar residuos ". $e);
        }
    }

    public function regresaStock($columna,$dato,$cantidadAnter,$tabla,$cantidadnueva)
    {
        try {
            $fecha = retunrFechaSqlphp(date("Y-m-d"));
            $consul = "$columna = '$dato'";
            $result = $this->m_buscar("$tabla",$consul);
            $producto = $result[0][1];
            $consul = "COD_PRODUCTO = '$producto'";
            $almacen = $this->m_buscar("T_ALMACEN_INSUMOS",$consul);

            
            $stock = number_format(($almacen[0][4] - $cantidadAnter),2, '.', '');
            
            $stock = number_format(($stock + $cantidadnueva),2, '.', '');
            
            $query4 = $this->bd->prepare("UPDATE T_ALMACEN_INSUMOS SET STOCK_ACTUAL='$stock',
            FEC_MODIFICO = '$fecha' WHERE COD_PRODUCTO ='$producto'"); 
            $result = $query4->execute();
            return $result;
        } catch (Exception $e) {
           print_r("Error al cambiar el almacen ". $e);
        }
        
    }
}
?>