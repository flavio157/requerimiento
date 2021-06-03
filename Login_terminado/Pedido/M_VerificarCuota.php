<?php
date_default_timezone_set('America/Lima');
require_once("../Funciones/DataDinamica.php");
require_once("../Funciones/f_funcion.php");
class M_VerificarCuota
{
    private $db;
    
    public function __construct($basedatos)
    {
        $this->db=DatabaseDinamica::Conectarbd($basedatos);
    }

    public function VerificandoQuincena($cod_vendedor,$dias,$fec_ingreso)
    {  
        
        $fec = explode(" ",$fec_ingreso);
        $fechas = nuevfech($dias,$fec[0]);
        if($fechas[0] != ""){
            if(!is_string($fechas[0])){
                $fech1 = $fechas[0]->format("d-m-Y");
            }else{
                $fech1 = $fechas[0];
            }
        }
       
        $fech2 = $fechas[1];
        $dias =  $fechas[2];

         $query=$this->db->prepare("SELECT * FROM V_PEDIDO_MONTO WHERE VENDEDOR =$cod_vendedor AND
         FECHA >= '$fech1' and FECHA < '$fech2'");
         $query->execute();
         $montoTotal= 0;
         while ($result = $query->fetch()) {
             if($result['CANTIDAD'] != ""){
                $montoTotal += $result['CANTIDAD'];
             }
        }
        $promedio = ($dias != 0 ) ? $promedio = round($montoTotal / $dias,2) : 0;

        $arraydato = array($fech1,$promedio); 
      if($query){
          return $arraydato;
       } 
    }


    
    public function CuotaPersonal($cod_usuario){
        try {
            $query=$this->db->prepare("SELECT * FROM T_PERSONAL WHERE COD_PERSONAL =$cod_usuario");
            $query->execute();
            $d_usuario = $query->fetch(PDO::FETCH_ASSOC);
        return $d_usuario;
        } catch (Throwable $th) {
            print_r("El codigo de usuario no esxiste");
        }
       
    }

}

?>
