<?php
date_default_timezone_set('America/Lima');
require_once("../funciones/DataBasePlasticos.php");
require_once("../funciones/f_funcion.php");
    class m_materiasalida 
    {
        private $bd;

        public function __construct()
        {
            $this->bd=DataBasePlasticos::Conectar();
        }

        public function m_buscar($tabla,$cadena)
        {
            try {
                $query = $this->bd->prepare("SELECT * FROM $tabla WHERE $cadena");
                $query->execute();
                $datos = $query->fetchAll();
                return $datos;
            } catch (Exception $e) {
                print_r("Error al seleccionar tabla ". $e);
            }
        }

        public function m_update_stock($tabla,$cadena)
        {
            try {
                $query = $this->bd->prepare("UPDATE $tabla $cadena");
                $resp = $query->execute();
                return $resp;
            } catch (Exception $e) {
               print_r("Error al actualizar ". $e);
            } 
        }


        public function m_guardar($codpersonal,$perregistro,$des,$items)
        {  
            $this->bd->beginTransaction();
            try {
                $codsalida = $this->m_select_generarcodigo('CODIGO_SALIDA','T_MATERIALES_SALIDA');
                $fech_registro = retunrFechaSqlphp(date("Y-m-d"));
                $query = $this->bd->prepare("INSERT INTO T_MATERIALES_SALIDA (CODIGO_SALIDA,NUM_DOC_SALIDA
                ,PERSONAL_SOLICITO,USUARIO_REGISTRO,FECH_REGISTRO,DESCRIPCION) 
                VALUES('$codsalida','$codsalida','$codpersonal','$perregistro',
                GETDATE(),'$des')");
                $query->execute();  
                foreach ($items->tds as $dato){
                    if($dato != ''){
                        $query2 = $this->bd->prepare("INSERT INTO T_DETSALIDA(CODIGO_SALIDA,COD_PRODUCTO,
                        CAN_PRODUCTO,COD_PRODUCTO_DEV,CANTIDAD_DEV,NUM_SERIE) 
                        VALUES('$codsalida','$dato[0]',$dato[2],'','0','$dato[1]')");
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
                echo $e;
            }
        }

        public function m_select_generarcodigo($campo,$tabla)
        {
            try {
                $query = $this->bd->prepare("SELECT MAX($campo)+1 as codigo FROM $tabla");
                $query->execute();
                $results = $query->fetch();
                if($results[0] == NULL) $results[0] = '1';
                $res = str_pad($results[0], 8, '0', STR_PAD_LEFT);
                return $res;
            } catch (Exception $e) {
               print_r("Error al generar codigo " . $e);
            }
           
        }


        /*Funcion sujeta a cambio */
        public function m_material_x_dia(){
            try {
                $fechactual = retunrFechaSqlphp(date("Y-m-d"));
                $query = $this->bd->prepare("SELECT * FROM V_MATERIALES_X_DIA WHERE 
                CAST(fecha as date) < '$fechactual' AND cantidad != 0");
                $query->execute();
                $datos = $query->fetchAll();
                return $datos;
            } catch (Exception $e) {
                print_r("Error al listar materiales por dia" .$e);
            }
            
        }

        public function m_guarda_mater_x_dia($dxdia,$per_solici,$usuario)
        {
            try {
                $cod = $this->ultimoregistro();
                foreach ($dxdia->dxd as $dato){
                   // for ($i=0; $i < $dato[2] ; $i++) {
                       // $ = (strlen($dato['1']) == 0) ? '' :$dato['1']; 
                       if($dato != ''){
                            $query2 = $this->bd->prepare("INSERT INTO T_DEVOL_X_DIA(COD_PERSONAL,COD_PRODUCTO,
                            CANT_PRODUCTO,NUM_SERIE,USU_REGISTRO,EST_DEVOLUCION,CANT_DEVUELTO,CODIGO_SALIDA) 
                            VALUES('$per_solici','$dato[0]','$dato[2]','$dato[1]','$usuario','0','0','$cod[0]')");
                            $estado = $query2->execute();  
                       }
                             
                        
                    ///}
                } 
               return $estado;
            } catch (Exception $e) {
                print_r("Error al registrar los materiales de salida ". $e);
            }
                  
        }

        public function ultimoregistro()
        {
            try {
                $query = $this->bd->prepare("SELECT MAX(CODIGO_SALIDA) as codigo FROM T_DETSALIDA");
                $query->execute();
                $results = $query->fetch();
                return  $results;
            } catch (Exception $e) {
               print_r("Error al seleccionar la ultima fila" . $e);
            }
           
        }

        public function actualidetallesalida($salida,$producto,$usuario,$serie,$cantidad){
                $fecha = retunrFechaSqlphp(date("Y-m-d"));
            try {
                $cadena = "CODIGO_SALIDA = '$salida' AND COD_PRODUCTO = '$producto' AND NUM_SERIE = '$serie'";
                $dato = $this->m_buscar('T_DETSALIDA',$cadena);
                
                $devo =  $dato[0][2] - $dato[0][4];
                if($cantidad > $devo){ print_r("Error la cantidad no puede ser mayor a lo mostrado"); return;}

                $cantida = $dato[0][4] + $cantidad;
                
                $cadena = "SET COD_PRODUCTO_DEV = '$producto' ,CANTIDAD_DEV = '$cantida', 
                USU_MODIFICO = '$usuario',FEC_MODIFICO = '$fecha' WHERE CODIGO_SALIDA = '$salida' 
                AND COD_PRODUCTO = '$producto' AND NUM_SERIE = '$serie'";
                $query = $this->bd->prepare("UPDATE T_DETSALIDA $cadena");
                $resp = $query->execute();
                return $resp;

            } catch (Exception $e) {
               print_r("Error al actualizar devolucion de producto x dia" . $e);
            }
        }

       

        public function m_reotorgar($codpersonal,$perregistro,$des,$codmaterial,$cantidad,$serie)
        {  
            $this->bd->beginTransaction();
            try {
                $codsalida = $this->m_select_generarcodigo('CODIGO_SALIDA','T_MATERIALES_SALIDA');
                $query = $this->bd->prepare("INSERT INTO T_MATERIALES_SALIDA (CODIGO_SALIDA,NUM_DOC_SALIDA
                ,PERSONAL_SOLICITO,USUARIO_REGISTRO,FECH_REGISTRO,DESCRIPCION) 
                VALUES('$codsalida','$codsalida','$codpersonal','$perregistro',
                GETDATE(),'$des')");
                $query->execute();  
               
                $query2 = $this->bd->prepare("INSERT INTO T_DETSALIDA(CODIGO_SALIDA,COD_PRODUCTO,
                            CAN_PRODUCTO,COD_PRODUCTO_DEV,CANTIDAD_DEV,NUM_SERIE) 
                            VALUES('$codsalida','$codmaterial','$cantidad','','0','$serie')");
                $query2->execute(); 

                $query3 = $this->bd->prepare("INSERT INTO T_DEVOL_X_DIA(COD_PERSONAL,COD_PRODUCTO,
                CANT_PRODUCTO,NUM_SERIE,USU_REGISTRO,EST_DEVOLUCION,CANT_DEVUELTO,CODIGO_SALIDA) 
                VALUES('$codpersonal','$codmaterial','$cantidad','$serie','$perregistro','0','0','$codsalida')");
                $query3->execute();     

                $guardado = $this->bd->commit();
                return $guardado;  
            } catch (Exception $e) {
                $this->bd->rollBack();
                print_r("Error al reotorgar" . $e);
            }
        }
     
        public function m_devol_x_dia($cantidad,$usuario,$id,$codmaterial,$ofi,$tipo){
            try {
                $cadena = "ID_MATERIAL = '$id'";
                $dato = $this->m_buscar('T_DEVOL_X_DIA',$cadena);
                $devo =  $dato[0][3] - $dato[0][7];
                if($cantidad > $devo){return "Error la cantidad no puede ser mayor a lo mostrado";}
                
                $cantida = $dato[0][7] + $cantidad;
                
                $estado = ($dato[0][3] == $cantida ) ? 1:0;
                $fecha = retunrFechaSqlphp(date("Y-m-d"));
                $query2 = $this->bd->prepare("UPDATE T_DEVOL_X_DIA SET CANT_DEVUELTO ='$cantida',USU_MODIFICO = '$usuario',
                        FEC_MODIFICO = '$fecha', EST_DEVOLUCION = '$estado' WHERE ID_MATERIAL = '$id'");
                $guardado = $query2->execute(); 
                if($tipo != 'R'){
                    $this->m_return_stock($codmaterial,$ofi,$cantidad);
                }
                return $guardado;  
            } catch (Exception $e) {
                print_r("Error al actualizar devolucion por dia ". $e);
            }
        }

//sacar cod_almacen
        public function m_return_stock($codmaterial,$codalmacen,$cant)
        {   try {
                $codalmacen = oficiona($codalmacen);
                $materiales = c_materialesalida::materialAlmacen($codmaterial,$codalmacen);
                $stock =  intval($materiales[0][4])  + intval($cant);
                $material = new m_materiasalida();
                $almacen = trim($codalmacen);
                $cadena = "SET STOCK_ACTUAL = '$stock'  WHERE COD_PRODUCTO ='$codmaterial'";
                $result = $this->m_update_stock('T_ALMACEN_INSUMOS',$cadena);
                return $result;
            }catch(Exception $e) {
                print_r("Error al retornar el stock ". $e);
            } 
        }


        public function m_materialreporte($personal,$producto,$cant,$descripcion,$codsalida,$motivo,$usu,$serie)
        {
            try {
                $query = $this->bd->prepare("INSERT INTO T_REPORTAR_MATERIAL(COD_PERSONAL,COD_PRODUCTO,
                CANT_PRODUCTO,DESCRIPCION,CODIGO_SALIDA,MOTIVO,USU_REGISTRO,NUM_SERIE)
                VALUES('$personal','$producto','$cant','$descripcion','$codsalida','$motivo','$usu','$serie')");
                /*print_r($query);*/
                $resul = $query->execute();
                return $resul;
            } catch (Exception $e) {
                print_r("Error al reportar material" . $e);
            }
        }


        public function m_lstmaterial($cod_personal)
        {
            try {
                $query = $this->bd->prepare("SELECT * FROM V_MATERIAL_PERDIDO WHERE COD_PERSONAL = '$cod_personal'");
                $query->execute();
                $resul = $query->fetchAll(PDO::FETCH_NUM);
                return $resul;
            } catch (Exception $e) {
                print_r("Error al lista material perdidos por usuarios" . $e);
            }
        }

        public function m_guardarreingreso($material,$codsalida,$cantidad,$serie,$serieperd,$observacion,$tipo,$usu,$almacen){
           
            $fecha = retunrFechaSqlphp(date("Y-m-d"));
            $this->bd->beginTransaction();
            try {

                $query = $this->bd->prepare("INSERT INTO T_MATERIAL_DEVUELTOS(COD_PRODUCTO,CANTIDAD,NRO_SERIE,
                OBSERVACION,USUARIO) VALUES('$material',$cantidad,'$serie','$observacion','$usu')");
                $query->execute();
            
                $devo = $this->m_consultartablas('T_DETSALIDA',$material,trim($serieperd),$codsalida,2,4);
                if($cantidad > $devo[0]){ print_r("Error la cantidad no puede ser mayor a lo mostrado p"); return;}
                $cantsalida = $devo[1] + $cantidad;
                $cadena = "SET COD_PRODUCTO_DEV = '$material' ,CANTIDAD_DEV = '$cantsalida', 
                USU_MODIFICO = '$usu',FEC_MODIFICO = '$fecha', NUM_SERIE ='$serie' WHERE CODIGO_SALIDA = '$codsalida' 
                AND COD_PRODUCTO = '$material' AND NUM_SERIE = '$serieperd'";
                $query2 = $this->bd->prepare("UPDATE T_DETSALIDA $cadena");
                $query2->execute();

                $devo = $this->m_consultartablas('T_REPORTAR_MATERIAL',$material,trim($serieperd),$codsalida,3,10);
                if($cantidad > $devo[0]){return "Error la cantidad no puede ser mayor a lo mostrado i";}
                $cantrepor =  $devo[1] + $cantidad;
                $query4 = $this->bd->prepare("UPDATE T_REPORTAR_MATERIAL SET CANT_REPUESTO ='$cantrepor',USU_MODIFICO = '$usu',
                        FEC_MODIFICO = '$fecha' 
                        WHERE COD_PRODUCTO = '$material' AND NUM_SERIE = '$serieperd' AND CODIGO_SALIDA = '$codsalida'");
                $query4->execute(); 
               
                if($tipo == '00004'  || $tipo == '00005'){
                    
                    $devo = $this->m_consultartablas('T_DEVOL_X_DIA',$material,trim($serieperd),$codsalida,3,7);
                   
                    if($cantidad > $devo[0]){return "Error la cantidad no puede ser mayor a lo mostrado u";}
                    $cantida = $devo[1] + $cantidad;
                    $estado = ($devo[2] == $cantida ) ? 1:0;
                    $query3 = $this->bd->prepare("UPDATE T_DEVOL_X_DIA SET CANT_DEVUELTO ='$cantida',USU_MODIFICO = '$usu',
                            FEC_MODIFICO = '$fecha' ,EST_DEVOLUCION ='$estado'
                            WHERE COD_PRODUCTO = '$material' AND NUM_SERIE = '$serieperd' AND CODIGO_SALIDA = '$codsalida'");
                    $query3->execute(); 

                    //quitar el COD_ALMACEN
                    $almacen = oficiona($almacen);
                    $stock = $this->bd->prepare("SELECT * FROM T_ALMACEN_INSUMOS WHERE COD_PRODUCTO = '$material'");
                    $stock->execute(); 
                    $materiales = $stock->fetchAll(PDO::FETCH_NUM);
                    $stock =  intval($materiales[0][4])  + intval($cantidad);
                    $cadena = "SET STOCK_ACTUAL = '$stock'  WHERE COD_PRODUCTO ='$material'";
                    $query5 = $this->bd->prepare("UPDATE T_ALMACEN_INSUMOS $cadena");
                    $query5->execute();
                }
                $guardado = $this->bd->commit();
                return $guardado;      
            }catch (Exception $e) {
                $this->bd->rollBack();
                print_r("Error al registrar reingreso de material" .$e);
            }
        }


        public function m_consultartablas($tabla,$material,$serie,$salida,$c1,$c2)
        {
            try {
                $cadena = "COD_PRODUCTO = '$material' AND NUM_SERIE = '$serie' AND CODIGO_SALIDA = '$salida'";
                $dato = $this->m_buscar($tabla,$cadena);
                $val2 =($dato[0][$c2] == Null) ? 0.000 : $dato[0][$c2];
                $devo =  $dato[0][$c1] - $val2;
                return array($devo,$val2, $dato[0][$c1]);
            } catch (Exception $e) {
                print_r("Error al consultar tablas" . $e);
            }
          
        }
    }
?>
