<?php
    date_default_timezone_set('America/Lima');
    require_once("../funciones/DataBasePlasticos.php");
    require_once("../funciones/f_funcion.php");
    require_once("../funciones/cod_almacenes.php");
    class m_moldes 
    {
        private $bd;
        public function __construct()
        {
            $this->bd=DataBasePlasticos::Conectar();
        }   

        public function m_buscar($tabla,$dato)
        {
            $query = $this->bd->prepare("SELECT * FROM $tabla WHERE $dato");
            $query->execute();
            $datos = $query->fetchAll();
            return $datos;  
        }

        public function m_select_generarcodigo($campo,$tabla,$cantidad)
        {
            $query = $this->bd->prepare("SELECT MAX($campo)+1 as codigo FROM $tabla");
            $query->execute();
            $results = $query->fetch();
            if($results[0] == NULL) $results[0] = '1';
            $res = str_pad($results[0], $cantidad, '0', STR_PAD_LEFT);
            return $res;
        }


        public function m_guardar($idmolde,$fecini,$usuario,$personal,$material)
        {
            $fecini = retunrFechaSqlphp($fecini);
            $this->m_generadocusalida('',$usuario,"Salida de fabricacion para molde con codigo ".$idmolde.
            " /fecha ".$fecini."/ usuario ".$usuario ,$material);

           $this->bd->beginTransaction();
           try {
                $hora = gethora();
                $codigo = $this->m_select_generarcodigo('COD_FABRICACION','T_FABRICACION',6);
                $query = $this->bd->prepare("INSERT INTO T_FABRICACION (COD_FABRICACION,ID_MOLDE
                ,FEC_INICIO,USU_REGISTRO,HOR_REGISTRO,FAB_TERMINO) 
                VALUES('$codigo','$idmolde','$fecini',
                '$usuario','$hora','0')");
                $query->execute();  
                foreach ($personal->tds as $dato){
                    $fecini = retunrFechaSqlphp($dato[2]);
                    $query = $this->bd->prepare("INSERT INTO T_PERSONAL_INVOLUCRADO
                    (COD_FABRICACION,COD_PERSONAL,
                    OBSERVACION,FEC_INICIO,USU_REGISTRO) 
                    VALUES('$codigo','$dato[0]','$dato[3]','$fecini','$usuario')");
                  
                    $query->execute(); 
                            if($query->errorCode()>0){	
                                $this->bd->rollBack();
                                return 0;
                                    break;
                                }
                }  

                foreach ($material->codmat as $dato){
                        $cadena = "COD_PRODUCTO = '$dato[0]'";
                        $c_propio = $this->m_buscar('T_ALMACEN_INSUMOS',$cadena);
                        if(count($c_propio) != 0){
                            $stock = intval($c_propio[0][4]) - intval($dato[1]);
                   
                            $query2 = $this->bd->prepare("UPDATE T_ALMACEN_INSUMOS SET STOCK_ACTUAL='$stock' 
                                    WHERE COD_PRODUCTO ='$dato[0]'");
                            $query2->execute(); 
                            if($query2->errorCode()>0){	
                                $this->bd->rollBack();
                                return 0;
                                    break;
                            }
                        }
                       
                        $c_externo = $this->m_buscar('T_ALMACEN_EXTERNOS',$cadena);
                        if(count($c_externo) != 0){
                            $stock = intval($c_externo[0][4]) - intval($dato[1]);
                            $query3 = $this->bd->prepare("UPDATE T_ALMACEN_EXTERNOS SET STOCK_ACTUAL='$stock' 
                                    WHERE COD_PRODUCTO ='$dato[0]'");
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
                print_r("Error al registrar molde para la fabricacion". $e);
                echo $e;
            }
           
        }

        public function m_agregarmaterial($molde,$material,$unidad,$cantidad,$usuario){
            try {
                $query = $this->bd->prepare("INSERT INTO T_MATERIALES_FABRICACION
                (ID_MOLDE,COD_PRODUCTO,CANT_MATERIALES,UNI_MEDIDA,USU_REGISTRO)
                VALUES('$molde','$material','$cantidad','$unidad','$usuario')");
                $resultado = $query->execute();
                return $resultado;
            } catch (Exception $e) {
                print_r("Error al agregar nuevo materia " .$e);
            }
        }

        public function m_eliminar($molde,$producto){
            $this->bd->beginTransaction();
            try {
                $query = $this->bd->prepare("DELETE T_ALMACEN_EXTERNOS WHERE COD_PRODUCTO = '$producto'");
                $query->execute();
                $query2 = $this->bd->prepare("DELETE T_MATERIALES_FABRICACION WHERE ID_MOLDE ='$molde' AND 
                COD_PRODUCTO = '$producto'");
                $query2->execute();
                $guardado = $this->bd->commit();
                return $guardado;
            } catch (Exception $e) {
                $this->bd->rollBack();
                print_r("Error al eliminar materiales ".$e);
            }
        }

        public function m_actualmaterial($molde,$material,$cantidad,$usu){
            try {
                $fech_actualizo = retunrFechaSqlphp(date("Y-m-d"));
                $query = $this->bd->prepare("UPDATE T_MATERIALES_FABRICACION SET CANT_MATERIALES = '$cantidad', 
                USU_MODIFICO = '$usu',FEC_MODIFICO = '$fech_actualizo'
                WHERE COD_PRODUCTO = '$material' AND ID_MOLDE = '$molde'");
                $resultado = $query->execute();
                return $resultado;
            }catch(Exception $e){
                print_r("Error al actualizar material ".$e);
            }
        }

        public function m_finfabricion($molde,$fabricacion,$usuario)
        {
            try {
                $fech_fin = retunrFechaSqlphp(date("Y-m-d"));
                $query = $this->bd->prepare("UPDATE T_FABRICACION SET USU_REGI_FIN = '$usuario', 
                FEC_FIN = '$fech_fin',FAB_TERMINO = '1'
                WHERE COD_FABRICACION = '$fabricacion' AND ID_MOLDE = '$molde'");
                $resultado = $query->execute();
                return $resultado;
            }catch(Exception $e){
                print_r("Error al poner terminar la fabricacion ".$e);
            }
        }

        public function m_generadocusalida($codpersonal,$perregistro,$des,$items)
        {  
            $codsalida = '';
            $this->bd->beginTransaction();
            try {
                foreach ($items->codmat as $dato){
                    $consul = "COD_PRODUCTO = '$dato[0]'"; 
                    $resul = $this->m_buscar("T_ALMACEN_INSUMOS",$consul);
                    if(count($resul) > 0){
                        if($codsalida == ''){
                            $codsalida = $this->m_select_generarcodigo('CODIGO_SALIDA','T_MATERIALES_SALIDA',8);
                            $query = $this->bd->prepare("INSERT INTO T_MATERIALES_SALIDA (CODIGO_SALIDA,NUM_DOC_SALIDA
                            ,PERSONAL_SOLICITO,USUARIO_REGISTRO,FECH_REGISTRO,DESCRIPCION) 
                            VALUES('$codsalida','$codsalida','00000','$perregistro',
                            GETDATE(),'$des')");
                            $query->execute();  
                        }
                        if($codsalida != ''){
                            $query2 = $this->bd->prepare("INSERT INTO T_DETSALIDA(CODIGO_SALIDA,COD_PRODUCTO,
                            CAN_PRODUCTO,NUM_SERIE) 
                            VALUES('$codsalida','$dato[0]','$dato[1]','$dato[2]')");
                           
                            $query2->execute(); 
                                if($query2->errorCode()>0){	
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
                print_r("Error al generar documento de salida materiales " . $e);
            }
        }

    }
?>