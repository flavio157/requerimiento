<?php
require_once("../funciones/Database.php");
require_once("../funciones/f_funcion.php");
class M_Login
{
    
    private $db;
    
    public function __construct()
    {
        $this->db=DataBase::Conectar();
    }
    
    public function Login($cod_usuario)
    {   
            $query=$this->db->prepare("SELECT * FROM T_USUARIO_CALL WHERE COD_PERSONAL = $cod_usuario AND EST_USUARIO != 'A'");
            $query->execute();
            $cod_usuario = $query->fetch(PDO::FETCH_ASSOC);
            f_regSession($cod_usuario['ANEXO_USUARIO'],$cod_usuario['COD_PERSONAL'],$cod_usuario['NOM_USUARIO'],$cod_usuario['OFICINA'],$cod_usuario['ZONA']);
            return  $cod_usuario;
            
    }



    public function Administradores($cod_usuario){
        $query=$this->db->prepare("SELECT * FROM T_ADMINISTRADORES WHERE COD_PERSONAL = $cod_usuario");
            $query->execute();
            $cod_usuario = $query->fetch(PDO::FETCH_ASSOC);
            if($query){
                return  $cod_usuario;
            }
    }


    public function VerificarCallCenter($cod_vendedor,$diaseval,$fec_ingreso,$oficina,$inasistenticias)
    {  
        $arraydato = '';
        $sumardias = diasrestriccion($diaseval);
        // print_r($sumardias);
        if($sumardias != ''){
            $fec = explode(" ",$fec_ingreso);
            $fechas = nuevfech($sumardias,$fec[0]);
           
            if(!is_string($fechas[0])){
                $fech1 =  $fechas[0]->format("d-m-Y");
            }else{
                $fech1 = $fechas[0];
            }
            
            $fech2 = $fechas[1];
            $dias =  $fechas[2] - $inasistenticias;
            //echo nl2br($fech1.".\n".$fech2);
         

           $query=$this->db->prepare("SELECT * FROM V_CALL_CENTER  
            WHERE VENDEDOR = $cod_vendedor AND FECHA_GENERADO >= '$fech1'
            AND FECHA_GENERADO < '$fech2' AND OFICINA = '$oficina'");
            $query->execute();
            $montoTotal=0;
            
            while ($result = $query->fetch()) {
                if($result['MONTO'] != ""){
                   $montoTotal += $result['MONTO'];
                }
            }
                
            $promedio = ($dias != 0 ) ? $promedio = round($montoTotal / $dias,2) : 0; 
       
            $arraydato = array($fech1,$promedio,$sumardias);  
        }
           // print_r($arraydato);
           return $arraydato;
        
      
    }




    public function Asistencia($cod_personal){
        $fechaActual = date("d")."-".date("m")."-".date("Y");
        $fechaPriquin = '12'."-".date("m")."-".date("Y");
        $mes = (date("m") <= '9')? '0'.(date("m")-1) : (date("m")-1);
        $fechaSegquincena = CrearFechaSegQuin();
        $fechaPriquicena = new DateTime($fechaPriquin);
        $fecAct = new DateTime($fechaActual);
        $fech ='';
        $tipo = '';
        if($fecAct >= $fechaPriquicena && $fechaActual <= '26'."-".date("m")."-".date("Y")){
            $fech = $fechaPriquin;
            $tipo = '1';
        }else if($fecAct >= $fechaSegquincena){
            $fech = CrearFechaSegQuin()->format("d-m-Y");
            $tipo = '2';
        }
       
       // $fech = $fech->format("d-m-Y");

        $query=$this->db->prepare("SELECT * FROM T_ASISTENCIAS WHERE FECHA >= '$fech' AND FECHA < '$fechaActual' 
        AND COD_PERSONAL = '$cod_personal'");
        $query->execute();
        $m_asistecia = $query->fetchAll();
       //print_r($m_asistecia);
        //return $fech;
        return array($m_asistecia,$tipo);
    }
}
?>
