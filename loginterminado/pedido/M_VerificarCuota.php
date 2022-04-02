<?php
date_default_timezone_set('America/Lima');
require_once("../funciones/DataDinamica.php");
require_once("../funciones/f_funcion.php");
class M_VerificarCuota
{
    private $db;
    
    public function __construct($basedatos)
    {
        $this->db=DatabaseDinamica::Conectarbd($basedatos);
    }

  /*  public function VerificandoQuincena($cod_vendedor,$diasrestriccion,$fec_ingreso,$inasistenticias,$cuotas)
    {  
        
        $fec = explode(" ",$fec_ingreso);
       
        $fechas = nuevfech($diasrestriccion,$fec[0]);
        if($fechas[0] != ""){
            if(!is_string($fechas[0])){
                $fech1 = $fechas[0]->format("d-m-Y");
            }else{
                $fech1 = $fechas[0];
            }
        }
       
        $fech2 = $fechas[1];
        $dias =  $fechas[2] - $inasistenticias ;
       
        var_dump($fech1,$fech2);
        
         $query=$this->db->prepare("SELECT * FROM V_PEDIDO_MONTO WHERE VENDEDOR =$cod_vendedor AND
         FECHA >= '$fech1' and FECHA < '$fech2'");
         $query->execute();
         $montoTotal= 0;
         while ($result = $query->fetch()) {
             if($result['CANTIDAD'] != ""){
                $montoTotal += $result['CANTIDAD'];
             }
        }
        if($dias > 1 ){ $dias = ($dias - 1);}
        
        $promedio = ($dias != 0 ) ? $promedio = round($montoTotal / ($dias),2) : 0; 
        $cuota = (intval($cuotas) * intval($dias)) - $montoTotal;
        $arraydato = array($fech1,$promedio,$diasrestriccion,$cod_vendedor,$cuota); 
        
      if($query){
        //  return $arraydato;
       }
    }*/


    
   /* public function CuotaPersonal($cod_usuario){
        try {
            $query=$this->db->prepare("SELECT * FROM T_PERSONAL WHERE COD_PERSONAL =$cod_usuario");
            $query->execute();
            $d_usuario = $query->fetch(PDO::FETCH_ASSOC);
        return $d_usuario;
        } catch (Throwable $th) {
            print_r("El codigo de usuario no esxiste");
        }
       
    }*/


    public function personalfaltacouta()
    {
        $query=$this->db->prepare("SELECT * FROM T_PERSONAL where COD_AREA = '00003' and EST_PERSONAL = 'A'");
        $query->execute();
        $d_usuario = $query->fetchAll();
        return $d_usuario;
    }


    public function CuotaPersonal($personal){
        try
        { 
         $stm = $this->db->prepare("SELECT CUOTA,FEC_INGRESO FROM T_PERSONAL WHERE COD_PERSONAL='$personal'");
         $stm->execute();
         $resul=$stm->fetchAll(); 
         return $resul;
        }
        catch(Exception $e)
        {
          die($e->getMessage());
        } 
    }

    public function VerificandoQuincena($personal,$fechaIni,$fechaFin)
    {  
        
       /* $fec = explode(" ",$fec_ingreso);
       
        $fechas = nuevfech($diasrestriccion,$fec[0]);
        if($fechas[0] != ""){
            if(!is_string($fechas[0])){
                $fech1 = $fechas[0]->format("d-m-Y");
            }else{
                $fech1 = $fechas[0];
            }
        }
       
        $fech2 = $fechas[1];
        $dias =  $fechas[2] - $inasistenticias ;
       
        var_dump($fech1,$fech2);*/
        
         $query=$this->db->prepare("SELECT * FROM V_PEDIDO_MONTO WHERE VENDEDOR =$personal AND
         FECHA >= '$fechaIni' and FECHA < '$fechaFin'");
         $query->execute();
         $montoTotal= 0;
         while ($result = $query->fetch()) {
             if($result['CANTIDAD'] != ""){
                $montoTotal += $result['CANTIDAD'];
             }
        }
       /* if($dias > 1 ){ $dias = ($dias - 1);}
        
        $promedio = ($dias != 0 ) ? $promedio = round($montoTotal / ($dias),2) : 0; 
        $cuota = (intval($cuotas) * intval($dias)) - $montoTotal;
        $arraydato = array($fech1,$promedio,$diasrestriccion,$cod_vendedor,$cuota); */
        
      if($query){
          return $montoTotal;
       }
    }

}

?>
