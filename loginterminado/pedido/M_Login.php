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
            $query=$this->db->prepare("SELECT * FROM T_USUARIO_CALL WHERE COD_PERSONAL = $cod_usuario");
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


  /*  public function VerificarCallCenter($cod_vendedor,$diaseval,$fec_ingreso,$oficina,$inasistenticias,$cuotas)
    {   $arraydato = '';
        $diarestriccion = diasrestriccion($diaseval);
       var_dump($diarestriccion);
        if($diarestriccion != ''){
            $fec = explode(" ",$fec_ingreso);
            $fechas = nuevfech($diarestriccion,$fec[0]);
            
            if(!is_string($fechas[0])){
                $fech1 =  $fechas[0]->format("d-m-Y");
            }else{
                $fech1 = $fechas[0];
            }
            
            $fech2 = $fechas[1];
         
            $dias =  $diarestriccion - $inasistenticias;
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
            
            $promedio = ($dias != 0 ) ? $promedio = round($montoTotal / ($dias-1),2) : 0; 
            $cuota = (intval($cuotas) * intval($dias)) - $montoTotal;
            $arraydato = array($fech1,$promedio,$diarestriccion,$cod_vendedor,$cuota);  
           // echo (intval($cuotas) * intval($dias)) - $montoTotal;

          //echo $montoTotal ."   ". ($dias-1);
        }
        var_dump($fech1,$fech2);
            //print_r($arraydato);
        //return $arraydato;
    }*/

    public function verificar_couta($cod_vendedor,$oficina,$cuotas,$inasistenticias){
        $fechaActual = date("d")."-".date("m")."-".date("Y");
        $fechaPriquin = '12'."-".date("m")."-".date("Y");
        $fechaSegquincena = CrearFechaSegQuin();
        $fechaPriquicena = new DateTime($fechaPriquin);
        $fecAct = new DateTime($fechaActual);
    
        if($fecAct >= $fechaPriquicena && $fechaActual <= '26'."-".date("m")."-".date("Y")){
            $direfencia = $fechaPriquicena->diff($fecAct);
            $fech1 = $fechaPriquin;
        }else if($fecAct >= $fechaSegquincena){
            $direfencia = $fechaSegquincena->diff($fecAct);
            $fech1 = CrearFechaSegQuin()->format("d-m-Y");
        }

           $query=$this->db->prepare("SELECT * FROM V_CALL_CENTER  
            WHERE VENDEDOR = $cod_vendedor AND FECHA_GENERADO >= '$fech1'
            AND FECHA_GENERADO <= '$fechaActual' AND OFICINA = '$oficina'");
            $query->execute();
            $montoTotal=0;
            
            while ($result = $query->fetch()) {
                if($result['MONTO'] != ""){
                   $montoTotal += $result['MONTO'];
                }
            }
            
            //se muestra cuanto le falta al usuario es decir cuota se tiene que guardar

            $dias =  intval($direfencia->days) - intval($inasistenticias);
            $promedio = ($dias != 0 ) ? $promedio = round($montoTotal / ($dias-1),2) : 0; 
            $cuota = (intval($cuotas) * intval($dias)) - $montoTotal;
            $arraydato = array($fech1,$promedio,$cod_vendedor,$cuota);  
           // echo (intval($cuotas) * intval($dias)) - $montoTotal;

          //echo $montoTotal ."   ". ($dias-1);
       
            //print_r($arraydato);
           return $arraydato;
    }


  public function Asistencia($cod_personal){
        $fechaActual = date("d")."-".date("m")."-".date("Y");
        $fechaPriquin = '12'."-".date("m")."-".date("Y");
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
        $query=$this->db->prepare("SELECT * FROM T_ASISTENCIAS WHERE FECHA >= '$fech' AND FECHA < '$fechaActual' 
        AND COD_PERSONAL = '$cod_personal'");
        $query->execute();
        $m_asistecia = $query->fetchAll();
        return array($m_asistecia,$tipo);
    }



    public function G_Personal_CuotaBaja($personal,$cuota,$oficina){
            $cod_personal = $personal[0];
            $nom_personal = $personal[5];
            $query=$this->db->prepare("INSERT INTO T_PERSONAL_ENFALTA(COD_PERSONAL,NOM_PERSONAL,PROMEDIO,OFICINA)
            values('$cod_personal','$nom_personal',$cuota,'$oficina')");
            $query->execute();
            return $query;
    }

    public function lst_personal_cuotabaja(){
        $query=$this->db->prepare("SELECT * FROM T_PERSONAL_ENFALTA");
        $query->execute();
        if ($query) {
                return $query->fetchAll();
            }
         
    }

    public function VerificarListado_Cuotabaja($hoy){
        $nuevafecha = retunrFechaSql($hoy);
        $query=$this->db->prepare("SELECT * FROM T_PERSONAL_ENFALTA WHERE FECH_REGISTRO >= '$nuevafecha'");
        $query->execute();
        if ($query) {
            return $query->fetchAll();
        }
    }

  

       public function VerificarCallCenter($personal,$fechaIni,$fechaFin,$oficina)
    {   /*$arraydato = '';
        $diarestriccion = diasrestriccion($diaseval);
       var_dump($diarestriccion);
        if($diarestriccion != ''){
            $fec = explode(" ",$fec_ingreso);
            $fechas = nuevfech($diarestriccion,$fec[0]);
            
            if(!is_string($fechas[0])){
                $fech1 =  $fechas[0]->format("d-m-Y");
            }else{
                $fech1 = $fechas[0];
            }
            
            $fech2 = $fechas[1];*/
         
            //$dias =  $diarestriccion - $inasistenticias;
            $query=$this->db->prepare("SELECT * FROM V_CALL_CENTER  
            WHERE VENDEDOR = $personal AND FECHA_GENERADO >= '$fechaIni'
            AND FECHA_GENERADO < '$fechaFin' AND OFICINA = '$oficina'");
            $query->execute();
            $montoTotal=0;
            
            while ($result = $query->fetch()) {
                if($result['MONTO'] != ""){
                   $montoTotal += $result['MONTO'];
                }
            }
            
            /*$promedio = ($dias != 0 ) ? $promedio = round($montoTotal / ($dias-1),2) : 0; 
            $cuota = (intval($cuotas) * intval($dias)) - $montoTotal;
            $arraydato = array($fech1,$promedio,$diarestriccion,$cod_vendedor,$cuota);*/  
           // echo (intval($cuotas) * intval($dias)) - $montoTotal;

          //echo $montoTotal ."   ". ($dias-1);
        //}
       // var_dump($fech1,$fech2);
            //print_r($arraydato);
        return $montoTotal;
    }


}
?>
