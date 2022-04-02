<?php
date_default_timezone_set('America/Lima');
require_once("../funciones/DataBasePlasticos.php");
require_once("../funciones/f_funcion.php");

class m_bloqueo
{
    private $db;
    
    public function __construct()
    {
        $this->db=DataBasePlasticos::Conectar();
    }

    public function m_buscar($tabla,$dato)
    {
        try {
            $query = $this->db->prepare("SELECT * FROM $tabla WHERE $dato");
            $query->execute();
            $datos = $query->fetchAll(PDO::FETCH_NUM);
            return $datos;
        } catch (Exception $e) {
            print_r("Error en la consulta buscar ".$e);
        } 
    }
    
    public function m_material_x_dia($usu){
        try {
            $fechactual = retunrFechaSqlphp(date("Y-m-d"));
            $query = $this->db->prepare("SELECT * FROM V_MATERIALES_X_DIA WHERE 
            CAST(fecha as date) < '$fechactual'  AND cantidad != 0 AND usu = '$usu'");
            $query->execute();
            $datos = $query->fetchAll();
            return $datos;
        } catch (Exception $e) {
            print_r("Error al buscar material x devolver" . $e);
        }
       
    }

    public function m_bloqueproduc($usu){
        $this->m_bloqueo();
        try {
            $fechactual = retunrFechaSqlphp(date("Y-m-d"));
            $query = $this->db->prepare("SELECT * FROM V_CONTROL_CALIDAD WHERE 
            detenido = '0' and usuario = '$usu'
            and completado = '0' AND CAST(fec_fin as date) < '$fechactual'");
            $query->execute();
            $datos = $query->fetchAll();
            return $datos; 
        } catch (Exception $e) {
            print_r("Error al buscar produccion" . $e);
        }     
    }

    public function m_desbloqueo($codigo){
        try {
            $query = $this->db->prepare("SELECT * FROM T_PARAMETROS WHERE 
            TIPO = 'P'");
            $query->execute();
            $datos = $query->fetchAll();
            if(count($datos)){
                $cod =  $datos[0][1] * 6;
            }
            if($cod != $codigo){
                return "Error codigo de desbloqueo invalido";
            }else{
                return 1;
            }
        } catch (Exception $e) {
            print_r("Error en el codigo de confirmación" . $e);
        }   
    }


    public function m_bloqueo()
    {
        try {
            $fecha = retunrFechaSqlphp(date("Y-m-d"));
            $numero = rand(1,5000); 
            $consulta = "TIPO = 'P'";
            $count = $this->m_buscar("T_PARAMETROS",$consulta);
            if(count($count) == 0){
                $query1 = $this->db->prepare("INSERT INTO T_PARAMETROS(COD_BLOQUE,TIPO) 
                VALUES('$numero','P')");
                $resul = $query1->execute();
                return $resul;
            }else{
                $consulta = "CONVERT(DATE,FEC_CREADO)  <> '$fecha'";
                $count1 = $this->m_buscar("T_PARAMETROS",$consulta);
                if(count($count1) > 0){
                    for ($i=0; $i < count($count1) ; $i++) {
                        $codpar = $count1[$i][0];
                        $numero2 = rand(1,5000);
                        $fecha = retunrFechaSqlphp(date("Y-m-d"));
                        $query = $this->db->prepare("UPDATE T_PARAMETROS SET COD_BLOQUE = '$numero2',
                        FEC_CREADO = '$fecha' WHERE ID_PARAM = '$codpar'");
                        $resul = $query->execute();
                    }
                    return $resul;
                }
            }
        } catch (Exception $e) {
            print_r("Error al generar numero " .$e);
        }
    }
}      
?>