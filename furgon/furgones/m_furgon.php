<?php
require_once("../funciones/DataBase.php");
require_once("../funciones/f_funcion.php");
    class m_furgon
    {
        private $bd;
        public function __construct()
        {
            $this->bd = DataBase::Conectar();
        }
        
        public function m_lsfurgon($fecha)
        {
            try {
                $query = $this->bd->prepare("SELECT C.OFICINA,C.PLACA,V.* from T_CAMIONES as C
                left join V_LST_FURGON_VACIO as V on V.PLACA = C.PLACA 
                and CAST(V.FECHA as date) = '$fecha' order by c.OFICINA asc");
                $query->execute();
                $respuesta = $query->fetchAll();
                return $respuesta;
            } catch (Exception $e) {
                print_r("Error en la consulta listar furgon" . $e);
            }
        }

        public function m_lsfurgonvacio(){
            try {
                $query = $this->bd->prepare("SELECT * FROM  V_LST_FURGON_VACIO");
                $query->execute();
                $respuesta = $query->fetchAll();
                return $respuesta;
            } catch (Exception $e) {
                print_r("Error en la consulta listar furgones vacios" . $e);
            }
        }
      

        public function m_lst_vend1_furgon($fecini,$fecfin,$select)
        {
            try {
                $query = $this->bd->prepare("SELECT COD_VEN1 , MAX(NOM_VEN1) as NOM_VEN1,SUM(CAN_VEN1) as CAN_VEN1
                from V_LST_VEND_FURGON WHERE FECHA >= '$fecini' and FECHA <= '$fecfin' and OFICINA = '$select' group by COD_VEN1");
                $query->execute();
                $respuesta = $query->fetchAll();
                return $respuesta ;
            } catch (Exception $e) {
                print_r("Error en la consulta listar vendendor 1" .$e);
            }
        }

        public function m_lst_vend2_furgon($fecini,$fecfin,$select)
        {
            try {
                $query = $this->bd->prepare("SELECT COD_VEN2 , MAX(NOM_VEN2) as NOM_VEN2,SUM(CAN_VEN2) as CAN_VEN2
                from V_LST_VEND_FURGON WHERE FECHA >= '$fecini' and FECHA <= '$fecfin' and OFICINA = '$select' group by COD_VEN2");
                $query->execute();
                $respuesta = $query->fetchAll();
                return $respuesta ;
            } catch (Exception $e) {
                print_r("Error en la consulta listar vendendor 2".$e);
            }
           
        }

        public function m_lst_vend3_furgon($fecini,$fecfin,$select)
        {
            try {
                $query = $this->bd->prepare("SELECT COD_VEN3 , MAX(NOM_VEN3) as NOM_VEN3,SUM(CAN_VEN3) as CAN_VEN3
                from V_LST_VEND_FURGON WHERE FECHA >= '$fecini' and FECHA <= '$fecfin' and OFICINA = '$select' group by COD_VEN3");
                $query->execute();
                $respuesta = $query->fetchAll();
                return $respuesta ;
            } catch (Exception $e) {
                print_r("Error en la consulta listar vendendor 3".$e);
            }
        }
        

        public function m_listar_cometario($fecha)
        {
            try {
                $query = $this->bd->prepare("SELECT * FROM T_COMENTARIOS_FURGON WHERE  CAST(FEC_COMENTARIO as date)  = '$fecha'");
                $query->execute();
                $respuesta = $query->fetchAll();
                return $respuesta;
            } catch (Exception $e) {
                print_r("Error en la consulta listar comentario".$e);
            }
            
        }


        public function m_guadarcomentario($comentario,$usuario,$fecha)
        {
           try {
                $hora = gethora();
                $fecha = date_create($fecha);
                $fecha = date_format($fecha, 'd/m/Y H:i:s');
                $query = $this->bd->prepare("INSERT INTO T_COMENTARIOS_FURGON (COMENTARIO,USU_REGISTRO,HOR_REGISTRO,FEC_COMENTARIO)
                        VALUES('$comentario','$usuario','$hora','$fecha')");
                $respuesta = $query->execute();
                return $respuesta;
           } catch (Exception $e) {
             print_r("Error en la consulta guardar comentario".$e);
           }   
        }

        public function m_verificar_fech_furgon($fecha)
        {
            try {
                $query = $this->bd->prepare("SELECT MAX(FECHA) from T_AVANCE_FURGON
                where CAST(FECHA as date) = '$fecha'");
                $query->execute();
                $respuesta = $query->fetchAll();
                return $respuesta;
            } catch (Exception $e) {
                print_r("Error en la consulta verificar furgon x fecha".$e);
            }
        }
    }


?>