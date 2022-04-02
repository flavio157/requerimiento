<?php
    date_default_timezone_set('America/Lima');
    require_once("../funciones/DataBasePlasticos.php");

    class m_registrarmolde 
    {
        private $bd;
        public function __construct()
        {
            $this->bd=DataBasePlasticos::Conectar();
        }   

        public function m_buscar($tabla,$dato)
        {
            try {
                $query = $this->bd->prepare("SELECT * FROM $tabla WHERE $dato");
                $query->execute();
                $datos = $query->fetchAll();
                return $datos;
            } catch (Exception $e) {
                print_r("Error al buscar ". $e);
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

        public function m_guardar($txtnommolde,$txtmedmolde,$slcestado,$usuario,$productos,$codcliente
                        ,$tipomolde,$slcestilo)
        { 
            if(strlen(trim($codcliente)) == 0){$codcliente = '000000';}
            try {
                $idmolde = $this->m_select_generarcodigo('ID_MOLDE','T_MOLDE',6);
                $query = $this->bd->prepare("INSERT INTO T_MOLDE(ID_MOLDE,NOM_MOLDE,MEDIDAS,ESTADO,USU_REGISTRO,TIPO_MOLDE,
                COD_CLIENTE,ESTI_MOLDE)
                VALUES('$idmolde','$txtnommolde','$txtmedmolde','$slcestado','$usuario','$tipomolde','$codcliente','$slcestilo')");
                $result = $query->execute();
                if($result == 1){
                  $dato = $this->m_guardarmatemolde($idmolde,$productos,$usuario);
                  return $dato;
                }
            } catch (Exception $e) {
                print_r("Error al guardar nuevo molde ". $e);
            }
        }


        public function m_lstmoldes()
        {
            try {
                $query = $this->bd->prepare("SELECT * FROM T_MOLDE");
                $query->execute();
                $datos = $query->fetchAll();
                return $datos;
            } catch (Exception $e) {
                print_r("Error listar moldes" . $e);
            }
        }

        public function m_guarproc($codpro,$nombre,$cantirec,$unidad,$cantxusar,$usuario,$cliente){
            try {
                $codprod =  $this->m_select_generarcodigo('COD_PRODUCTO','T_PRODUCTO',6);
                $query = $this->bd->prepare("INSERT INTO T_PRODUCTO(COD_PRODUCTO,
                        DES_PRODUCTO,UNI_MEDIDA,EST_PRODUCTO,USU_REGISTRO,FEC_REGISTRO) 
                        VALUES('$codprod','$nombre','$unidad','1','$usuario',GETDATE())");
                $result = $query->execute();
                
                if($result == 1){
                    $codalmins =  $this->m_select_generarcodigo('COD_ALIN','T_ALMACEN_EXTERNOS',6);
                    $query = $this->bd->prepare("INSERT INTO T_ALMACEN_EXTERNOS(COD_ALIN,
                    COD_CLASE,COD_PRODUCTO,COD_ALMACEN,STOCK_ACTUAL,'COD_CLIENTE') 
                    VALUES('$codalmins','','$codprod','','$cantirec','$cliente')");
                    $guardado = $query->execute();
                }
                return array($guardado,$codprod);
            } catch (Exception $e) {
                    print_r("Error al guardar materiales para el molde ". $e);  
            }              
        }

        public function m_guarfabricaionmaterial($idmolde,$codprod,$matexusar,$unidad,$usuario){
            try {
                $query = $this->bd->prepare("INSERT INTO T_MATERIALES_FABRICACION(ID_MOLDE,COD_PRODUCTO,
                CANT_MATERIALES,UNI_MEDIDA,USU_REGISTRO) 
                VALUES('$idmolde','$codprod','$matexusar','$unidad','$usuario')");
                $guardado = $query->execute();
                return $guardado; 
            } catch (Exception $e) {
               print_r("Error al registrar nuevos materiales" . $e);
            }
        }

     
        public function m_actualizamolde($idmolde,$nombre,$medida,$estado,$productos,$usuario,$cod_cliente,
        $slcestilo,$tipomolde)
        {
            $this->bd->beginTransaction();
            try {
                $query = $this->bd->prepare("UPDATE T_MOLDE SET NOM_MOLDE = '$nombre',MEDIDAS = '$medida',
                                ESTADO = '$estado',ESTI_MOLDE = '$slcestilo' WHERE ID_MOLDE = '$idmolde' AND COD_CLIENTE = '$cod_cliente'");
                $query->execute();
                foreach ($productos->tds as $dato){
                        $query2 = $this->bd->prepare("UPDATE T_MATERIALES_FABRICACION SET CANT_MATERIALES
                        ='$dato[2]',UNI_MEDIDA = '$dato[3]',USU_MODIFICO = '$usuario', FEC_MODIFICO = GETDATE() WHERE
                        ID_MOLDE = '$idmolde' AND COD_PRODUCTO = '$dato[0]'");
                        
                        $query2->execute(); 
                        if($query2->errorCode()>0){	
                            $this->bd->rollBack();
                            return 0;
                            break;
                        }

                        if($tipomolde == 'E'){
                            $query3 = $this->bd->prepare("UPDATE T_ALMACEN_EXTERNOS SET STOCK_ACTUAL = '$dato[4]' 
                            WHERE COD_PRODUCTO = '$dato[0]'");
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
                print_r("Error al actualizar materiales". $e);
                $this->bd->rollBack();   
            }
        }

        public function m_guardarmatemolde($idmolde,$productos,$usuario){
            $this->bd->beginTransaction();
            try {
                foreach ($productos->tds as $dato){
                    $query = $this->bd->prepare("INSERT INTO T_MATERIALES_FABRICACION(ID_MOLDE,COD_PRODUCTO,
                    CANT_MATERIALES,UNI_MEDIDA,USU_REGISTRO) 
                    VALUES('$idmolde','$dato[0]','$dato[2]','$dato[3]','$usuario')");
                    
                    $query->execute(); 
                    if($query->errorCode()>0){	
                        $this->bd->rollBack();
                        return 0;
                        break;
                    }      
                }
                $guardado = $this->bd->commit();
                return $guardado;
            } catch (Exception $e) {
                print_r("Error al guardar la fabricacion para el molde ". $e);
                $this->bd->rollBack();  
            }
        }


        public function m_eliminarmolde($idmolde,$material)
        {
            try {
                $query = $this->bd->prepare("DELETE T_MATERIALES_FABRICACION WHERE ID_MOLDE= '$idmolde'
                AND COD_PRODUCTO ='$material'");
                $respuesta = $query->execute();
                return $respuesta;
            } catch (Exception $e) {
                print_r("Error al eliminar materiales ". $e);
            } 
        }
    
        public function m_guardarcliente($nombre,$direccion,$identificacion,$telfono,$correo,$usuario)
        {
            $cod_cliente = $this->m_select_generarcodigo('COD_CLIENTE','T_CLIENTE_MOLDE',6);
            try {
                $query = $this->bd->prepare("INSERT INTO T_CLIENTE_MOLDE(COD_CLIENTE,NOM_CLIENTE,DIR_CLIENTE
                ,IDENTIFICACION , TEL_CLIENTE,CORREO,USU_REGISTRO) VALUES('$cod_cliente','$nombre','$direccion',
                '$identificacion','$telfono','$correo','$usuario')"); //se cambio
                $respuesta = $query->execute();
                return array($respuesta,$cod_cliente);
            } catch (Exception $e) {
                print_r("Error al guardar cliente ". $e);
            }  
        } 


        public function m_actualizarclien($codcli,$nombre,$direccion,$identificacion,$telefono,$correo,$usuario){
            try {
                $fech = retunrFechaSqlphp(date("Y-m-d"));
                $query = $this->bd->prepare("UPDATE T_CLIENTE_MOLDE SET NOM_CLIENTE = '$nombre',
                         DIR_CLIENTE ='$direccion',IDENTIFICACION = '$identificacion' ,TEL_CLIENTE ='$telefono',
                         CORREO = '$correo', USU_MODIFICO = '$usuario',FEC_MODIFICO = '$fech' WHERE COD_CLIENTE = '$codcli'");
                $respuesta = $query->execute();
                return $respuesta;
            } catch (Exception $e) {
                print_r("Error al actualizar cliente ". $e);
            }  
        }
    }
?>
