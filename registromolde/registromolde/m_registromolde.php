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
                print_r("Error al buscar");
            }
           
        }

        public function m_select_generarcodigo($campo,$tabla)
        {
            try {
            $query = $this->bd->prepare("SELECT MAX($campo)+1 as codigo FROM $tabla");
            $query->execute();
            $results = $query->fetch();
            if($results[0] == NULL) $results[0] = '1';
            $res = str_pad($results[0], 6, '0', STR_PAD_LEFT);
            return $res;
            } catch (Exception $e) {
                print_r("Error al generar codigo");
            }
        }


        public function m_guardar($nombre,$medida,$estado,$productos,$usuario)
        { 
            $this->bd->beginTransaction();
            try {
                $idmolde = $this->m_select_generarcodigo('ID_MOLDE','T_MOLDE');
                $query = $this->bd->prepare("INSERT INTO T_MOLDE(ID_MOLDE,NOM_MOLDE,MEDIDAS,ESTADO,USU_REGISTRO)
                VALUES('$idmolde','$nombre','$medida','$estado','$usuario')");
                $query->execute();
                foreach ($productos->tds as $dato){
                        $query2 = $this->bd->prepare("INSERT INTO T_MATERIALES_FABRICACION(ID_MOLDE,COD_PRODUCTO,
                        CANT_MATERIALES,MEDIDA_MATERIALES,UNI_MEDIDA,USU_REGISTRO) 
                        VALUES('$idmolde','$dato[0]','$dato[1]','$dato[2]','$dato[3]','$usuario')");
                        $query2->execute(); 
                        if($query2->errorCode()>0){	
                            $this->bd->rollBack();
                            return 0;
                            break;
                        }   
                }
                $guardado = $this->bd->commit();
                return $guardado;
            } catch (Exception $e) {
                print_r("Erro al guardar nuevo molde ". $e);
                $this->bd->rollBack();   
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
                print_r("Error listar moldes");
            }
            
        }

        public function m_actualizarmoldemateriales($idmolde,$codmaterial,$cantidad,$usuario)
        {
            $cantidad = ($cantidad=='')?'':$cantidad;
            try {
                $query = $this->bd->prepare("INSERT INTO T_MATERIALES_FABRICACION(ID_MOLDE,COD_PRODUCTO,CANT_MATERIALES
                ,USU_REGISTRO)
                VALUES('$idmolde','$codmaterial','$cantidad','$usuario')");
                $query->execute();
            } catch (Exception $e) {
                print_r("Error al actualiza agregar materiales ". $e);
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
        
        public function m_actualizamolde($idmolde,$nombre,$medida,$estado,$productos,$usuario)
        {
            $this->bd->beginTransaction();
            try {
                $query = $this->bd->prepare("UPDATE T_MOLDE SET NOM_MOLDE = '$nombre',MEDIDAS = '$medida',
                                ESTADO = '$estado' WHERE ID_MOLDE = '$idmolde'");
                $query->execute();
                foreach ($productos->tds as $dato){
                        $query2 = $this->bd->prepare("UPDATE T_MATERIALES_FABRICACION SET CANT_MATERIALES
                        ='$dato[1]',MEDIDA_MATERIALES = '$dato[2]',UNI_MEDIDA = '$dato[3]',USU_MODIFICO = '$usuario', FEC_MODIFICO = GETDATE() WHERE
                        ID_MOLDE = '$idmolde' AND COD_PRODUCTO = '$dato[0]'");
                        $query2->execute(); 
                        if($query2->errorCode()>0){	
                            $this->bd->rollBack();
                            return 0;
                            break;
                        }   
                }
                $guardado = $this->bd->commit();
                return $guardado;
            } catch (Exception $e) {
                print_r("Erro al actualizar materiales". $e);
                $this->bd->rollBack();   
            }
        }
    }
?>
