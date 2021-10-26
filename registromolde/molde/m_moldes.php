<?php
    require_once("../funciones/DataBasePlasticos.php");

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

        public function m_select_generarcodigo($campo,$tabla)
        {
            $query = $this->bd->prepare("SELECT MAX($campo)+1 as codigo FROM $tabla");
            $query->execute();
            $results = $query->fetch();
            if($results[0] == NULL) $results[0] = '1';
            $res = str_pad($results[0], 8, '0', STR_PAD_LEFT);
            return $res;
        }


        public function m_guardar($idmolde,$fecini,$fecfin,$usuario,$personal,$material)
        {
            $this->bd->beginTransaction();
           try {
                $fecini = retunrFechaSqlphp($fecini);
                $fecfin = retunrFechaSqlphp($fecfin);
                $hora = gethora();
                $codigo = $this->m_select_generarcodigo('COD_FABRICACION','T_FABRICACION');
                $query = $this->bd->prepare("INSERT INTO T_FABRICACION (COD_FABRICACION,ID_MOLDE
                ,FEC_INICIO,FEC_FIN,USU_REGISTRO,HOR_REGISTRO) 
                VALUES('$codigo','$idmolde','$fecini','$fecfin',
                '$usuario','$hora')");
                 $query->execute();  
                foreach ($personal->tds as $dato){
                    $fecini = retunrFechaSqlphp($dato[1]);
                    $fecfin = retunrFechaSqlphp($dato[2]);

                    $query2 = $this->bd->prepare("INSERT INTO T_PERSONAL_INVOLUCRADO
                    (COD_FABRICACION,COD_PERSONAL,
                    OBSERVACION,FEC_INICIO,FEC_FIN,HORAS_TRABAJADAS,COSTO_HORA) 
                    VALUES('$codigo','$dato[0]','$dato[3]','$fecini','$fecfin','$dato[4]',$dato[5])");
                    $query2->execute(); 
                            if($query2->errorCode()>0){	
                                $this->bd->rollBack();
                                return 0;
                                    break;
                                }
                }  

                foreach ($material->codmat as $dato){
                    $cadena = "COD_PRODUCTO = '$dato[0]'";
                    $c_material = $this->m_buscar('T_ALMACEN_INSUMOS',$cadena);
                    $stock = intval($c_material[0][4]) - intval($dato[1]);
                    $query3 = $this->bd->prepare("UPDATE T_ALMACEN_INSUMOS SET STOCK_ACTUAL='$stock' 
                              WHERE COD_PRODUCTO ='$dato[0]'");
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
                echo $e;
            }
           
        }
    }
?>