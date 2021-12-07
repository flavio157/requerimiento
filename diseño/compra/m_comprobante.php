<?php
date_default_timezone_set('America/Lima');
require_once("../funciones/DataBasePlasticos.php");
require_once("../funciones/cod_almacenes.php");
require_once("../funciones/f_funcion.php");
class m_comprobante
{
    private $bd;
    public function __construct() {
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
            print_r("Error en la consulta listar".$e);
        }
       
    }
    

    public function m_select_generarcodigo($campo,$tabla)
    {
        try {
            $query = $this->bd->prepare("SELECT MAX($campo)+1 as codigo FROM $tabla");
            $query->execute();
            $results = $query->fetch();
            if($results[0] == NULL) $results[0] = '1';
            $res = str_pad($results[0], 8, '0', STR_PAD_LEFT);
            return $res;
        } catch (Exception $e) {
            print_r("Error en la consulta generar codigo".$e);
        }
    }  

    public function m_guardarprod($codpro,$codcateg,$despro,$unimedpro,$stockmin,$abre,
                                  $usuregi,$pesoneto,$codclase,$oficina)
    {        $this->bd->beginTransaction();
            try {
                $producto = strtoupper($despro);
                $abre = strtoupper($abre);
                $codpro = strtoupper($codpro);
                $unimedpro = strtoupper($unimedpro);
                $fech_registro = retunrFechaSqlphp(date("Y-m-d"));
                $codpro = $this->m_generar_codpers("COD_PRODUCTO","T_PRODUCTO",6);
                $query = $this->bd->prepare("INSERT INTO T_PRODUCTO (COD_PRODUCTO,COD_CATEGORIA
                ,DES_PRODUCTO,UNI_MEDIDA,STOCK_MINIMO,ABR_PRODUCTO,PRE_PRODUCTO,EST_PRODUCTO,USU_REGISTRO,
                FEC_REGISTRO,MAQUINA,PESO_NETO,COD_CLASE) 
                VALUES('$codpro','$codcateg','$producto','$unimedpro',
                $stockmin,'$abre',0,'1','$usuregi','$fech_registro','','$pesoneto','$codclase')");
               
                $query->execute();  
                
                $oficina = oficiona($oficina);
                $correlativo = $this->m_select_generarcodigo('COD_ALIN','T_ALMACEN_INSUMOS');
                $query2 = $this->bd->prepare("INSERT INTO T_ALMACEN_INSUMOS (COD_ALIN,COD_ALMACEN,
                                   STOCK_ACTUAL,COD_PRODUCTO,COD_CLASE,STOCK_MINIMO) 
                VALUES('$correlativo','$oficina','0','$codpro','$codclase',$stockmin)");
                $query2->execute();
                
                $guardado = $this->bd->commit();
                return $guardado;
            } catch (Exception $e) {
                $this->bd->rollBack();
                print_r("Error al guardar".$e);
            }    
           
    
    }


    public  function m_guardarcompr($fechemision,$fechentrega,$codpersonal
                            ,$tipocomprob,$formapago,$tipomoneda,$tipocambio,$contiIGV,$observacio,
                            $usuregistro,$almacen,$productos,$totalcompro,$nrocompro,$correlcomp,$proveedor)
    { 
        $tipocambio = ($tipocambio == '') ? 0 : $tipocambio;
        $almacen = oficiona($almacen);
        $this->bd->beginTransaction();
        try {
            $hora = gethora();
            $fechentrega = retunrFechaSqlphp($fechentrega);
            $fechemision = retunrFechaSqlphp($fechemision);
            $codgenerado = $this->m_select_generarcodigo('COD_COMPROBANTE','T_COMPROBANTE');
            $query = $this->bd->prepare("INSERT INTO T_COMPROBANTE(COD_COMPROBANTE,COD_ORCO,COD_PERSONAL,FEC_EMISION,HOR_EMISION,
            FEC_ENTREGA,TIPO_COMPROBANTE,NRO_COMPROBANTE,CORREL_COMPROBANTE ,FORMA_PAGO,MONEDA,TIPO_CAMBIO,OBS_COMPROBANTE,EST_COMPROBANTE,
            COD_CONFIRMACION,CONFIRMACION_ALMACEN,FEC_CONFIRMACION,HOR_CONFIRMACION,OBS_CONFIRMACION,CON_IGV,
            MONTO_COMPROBANTE,FLETE_MERCADERIA,USU_REGISTRO,COD_ALMACEN,COD_PROVEEDOR) 
            VALUES('$codgenerado','C0000001','$codpersonal','$fechemision','$hora','$fechentrega','$tipocomprob',
            '$nrocompro','$correlcomp','$formapago','$tipomoneda',$tipocambio,'$observacio','P','','',Null,'','',
            '$contiIGV',$totalcompro,0,'$usuregistro','$almacen','$proveedor')");
        
            $query->execute();  
            foreach ($productos->tds as $dato){
                if(isset($dato['0'])){
                    $query2 = $this->bd->prepare("INSERT INTO T_DETACOMP(COD_COMPROBANTE,COD_PRODUCTO,
                    NUM_SERIE,CAN_PRODUCTO,PREC_PRODUCTO,USU_REGISTRO) 
                    VALUES('$codgenerado','$dato[0]','$dato[1]',$dato[2],$dato[3],'$usuregistro')");
                    
                    $query2->execute(); 
                    if($query2->errorCode()>0){	
                        $this->bd->rollBack();
                        return 0;
                        break;
                    }
                    $query3 = $this->bd->prepare("UPDATE T_ALMACEN_INSUMOS SET 
                    STOCK_ACTUAL = (STOCK_ACTUAL+$dato[2]) where COD_PRODUCTO = '$dato[0]'");
                     
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
            print_r("Error al ingresar datos " .$e);
            $this->bd->rollBack();   
        }
    }


    public function m_guardarpersonal($nombre,$direccion,$dni,$cargo,$salario,$area,$departamento,$provincia
    ,$distrito,$telefono,$celular,$cuenta,$titular,$usuario,$fechaingreso)
    {
      try {
         $fechaingreso = retunrFechaSqlphp($fechaingreso);
         $fech_registro = retunrFechaSqlphp(date("Y-m-d"));
          $codpersonal = $this->m_generar_codpers('COD_PERSONAL','T_PERSONAL',5);
          $query = $this->bd->prepare("INSERT INTO T_PERSONAL(COD_PERSONAL,NOM_PERSONAL1,DIR_PERSONAL,DNI_PERSONAL,COD_CARGO,
          SAL_BASICO,COD_AREA,COD_DEPARTAMENTO,COD_PROVINCIA,COD_DISTRITO,TEL_PERSONAL,CEL_PERSONAL,EST_PERSONAL,
          FEC_INGRESO,USU_REGISTRO,FEC_REGISTRO,N_CUENTA,TITULAR) VALUES('$codpersonal','$nombre','$direccion','$dni','$cargo','$salario','$area',
          '$departamento','$provincia','$distrito',$telefono,$celular,'1','$fechaingreso','$usuario','$fech_registro','$cuenta','$titular')");
          $personal =  $query->execute();
          return $personal;
          
      } catch (Exception $e) {
          print_r("Error al registrar nuevo personal ".$e);
      }
    }

    public function m_generar_codpers($campo,$tabla,$canitdad)
    {
        try {
            $query = $this->bd->prepare("SELECT MAX($campo)+1 as codigo FROM $tabla");
            $query->execute();
            $results = $query->fetch();
            if($results[0] == NULL) $results[0] = '1';
            $res = str_pad($results[0], $canitdad, '0', STR_PAD_LEFT);
            return $res;
        } catch (Exception $e) {
            print_r("Error en la consulta generar codigo".$e);
        }
    }  


    public function m_guardar_proeveedor($proveedor,$direccion,$ruc,$dni,$usu){
        try {
            $fech_registro = retunrFechaSqlphp(date("Y-m-d"));
            $cod_proveedor = $this->m_generar_codpers('COD_PROVEEDOR','T_PROVEEDOR',5);
            $query = $this->bd->prepare("INSERT INTO T_PROVEEDOR(COD_PROVEEDOR,NOM_PROVEEDOR,DIR_PROVEEDOR
            ,RUC_PROVEEDOR,DNI_PROVEEDOR,EST_PROVEEDOR,USU_REGISTRO,FEC_REGISTRO)
            VALUES('$cod_proveedor','$proveedor','$direccion','$ruc','$dni','1','$usu','$fech_registro')");
            $resul = $query->execute();
            return $resul;
        } catch (Exception $e) {
            print_r("Error al guardar nuevo proveedor" . $e);
        }
    }



}

?>