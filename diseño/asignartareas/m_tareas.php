<?php
date_default_timezone_set('America/Lima');
require_once("../funciones/DataBasePlasticos.php");
require_once("../funciones/f_funcion.php");
    class m_tareas 
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
                $datos = $query->fetchAll(PDO::FETCH_NUM);
                return $datos;
            } catch (Exception $e) {
                print_r("Error al seleccionar tabla ". $e);
            }
        }

    

        public function m_guardarcab($codperson,$dtincio,$dtfin,$reprogramar,$usu)
        {  
            try {
                $dtincio = retunrFechaSqlphp($dtincio);
                $dtfin = retunrFechaSqlphp($dtfin);
                $codtarea = $this->m_select_generarcodigo('COD_TAREA_PROGAMADA','T_TAREAS_PROGRAMADA',9);
                $query = $this->bd->prepare("INSERT INTO T_TAREAS_PROGRAMADA (COD_TAREA_PROGAMADA,
                COD_PERSONAL,FEC_INI,FEC_FIN,AUTO_REPROG,USU_REGISTRO) 
                VALUES('$codtarea','$codperson','$dtincio','$dtfin','$reprogramar','$usu')");
                $result = $query->execute();  
                return array($result,$codtarea);
            } catch (Exception $e) {
                print_r("Error al registrar Fecha de inicio y fin de la tarea " . $e);
            }
        }

    

        public function m_select_generarcodigo($campo,$tabla,$can)
        {
            try {
                $query = $this->bd->prepare("SELECT MAX($campo)+1 as codigo FROM $tabla");
                $query->execute();
                $results = $query->fetch();
                if($results[0] == NULL) $results[0] = '1';
                $res = str_pad($results[0], $can, '0', STR_PAD_LEFT);
                return $res;
            } catch (Exception $e) {
               print_r("Error al generar codigo " . $e);
            }
           
        }

        public function m_gnuevatarea($nomtarea,$tipotarea,$usu){
            try {
                $cod_tarea = $this->m_select_generarcodigo('COD_TAREA','T_TAREAS',9);
                $query = $this->bd->prepare("INSERT INTO T_TAREAS(COD_TAREA,NOM_TAREA,RETIRO_HERRAMIENTA,
                USU_REGISTRO)VALUES('$cod_tarea','$nomtarea','$tipotarea','$usu')");
                $result = $query->execute();
                return array($result,$cod_tarea);
            } catch (Exception $e) {
                print_r("Error al crear una nueva tarea " .$e);
            }
        }


    }

?>
