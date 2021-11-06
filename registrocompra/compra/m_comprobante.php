<?php
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

    public function m_guardarprod($codpro,$codcateg,$despro,$unimedpro,$stockmin,$abre,$usuregi,$pesoneto,$codclase,$oficina)
    {        $this->bd->beginTransaction();
            try {
                $producto = strtoupper($despro);
                $abre = strtoupper($abre);
                $codpro = strtoupper($codpro);
                $unimedpro = strtoupper($unimedpro);
                $fech_registro = retunrFechaSqlphp(date("Y-m-d"));
                $query = $this->bd->prepare("INSERT INTO T_PRODUCTO (COD_PRODUCTO,COD_CATEGORIA
                ,DES_PRODUCTO,UNI_MEDIDA,STOCK_MINIMO,ABR_PRODUCTO,PRE_PRODUCTO,EST_PRODUCTO,USU_REGISTRO,
                FEC_REGISTRO,MAQUINA,PESO_NETO,COD_CLASE) 
                VALUES('$codpro','$codcateg','$producto','$unimedpro',
                $stockmin,'$abre',0,'A','$usuregi','$fech_registro','','$pesoneto','$codclase')");
            
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


    public  function m_guardarcompr($fechemision,$horaemision,$fechentrega,$codpersonal
                            ,$tipocomprob,$formapago,$tipomoneda,$tipocambio,$contiIGV,$observacio,
                            $usuregistro,$almacen,$productos,$totalcompro)
    { 
        $tipocambio = ($tipocambio == '') ? 0 : $tipocambio;
        $almacen = oficiona($almacen);
        $this->bd->beginTransaction();
        try {
            $fechentrega = retunrFechaSqlphp($fechentrega);
            $fechemision = retunrFechaSqlphp($fechemision);
            $codgenerado = $this->m_select_generarcodigo('COD_COMPROBANTE','T_COMPROBANTE');
            $query = $this->bd->prepare("INSERT INTO T_COMPROBANTE(COD_COMPROBANTE,COD_ORCO,COD_PERSONAL,FEC_EMISION,HOR_EMISION,
            FEC_ENTREGA,TIPO_COMPROBANTE,FORMA_PAGO,MONEDA,TIPO_CAMBIO,OBS_COMPROBANTE,EST_COMPROBANTE,
            COD_CONFIRMACION,CONFIRMACION_ALMACEN,FEC_CONFIRMACION,HOR_CONFIRMACION,OBS_CONFIRMACION,CON_IGV,
            MONTO_COMPROBANTE,FLETE_MERCADERIA,USU_REGISTRO,COD_ALMACEN) 
            VALUES('$codgenerado','C0000001','$codpersonal','$fechemision','$horaemision','$fechentrega','$tipocomprob',
            '$formapago','$tipomoneda',$tipocambio,'$observacio','P','','',Null,'','',
            '$contiIGV',$totalcompro,0,'$usuregistro','$almacen')");
        
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
          $codpersonal = $this->m_generar_codpers('COD_PERSONAL','T_PERSONAL');
          $query = $this->bd->prepare("INSERT INTO T_PERSONAL(COD_PERSONAL,NOM_PERSONAL1,DIR_PERSONAL,DNI_PERSONAL,COD_CARGO,
          SAL_BASICO,COD_AREA,COD_DEPARTAMENTO,COD_PROVINCIA,COD_DISTRITO,TEL_PERSONAL,CEL_PERSONAL,EST_PERSONAL,
          FEC_INGRESO,USU_REGISTRO,N_CUENTA,TITULAR) VALUES('$codpersonal','$nombre','$direccion','$dni','$cargo','$salario','$area',
          '$departamento','$provincia','$distrito',$telefono,$celular,'A','$fechaingreso','$usuario','$cuenta','$titular')");
          $personal =  $query->execute();
          return $personal;
          $codpersonal = $this->m_generar_codpers('COD_PERSONAL','T_PERSONAL');
          print_r($codpersonal);
      } catch (Exception $e) {
          print_r("Error al registrar nuevo personal ".$e);
      }
    }

    public function m_generar_codpers($campo,$tabla)
    {
        try {
            $query = $this->bd->prepare("SELECT MAX($campo)+1 as codigo FROM $tabla");
            $query->execute();
            $results = $query->fetch();
            if($results[0] == NULL) $results[0] = '1';
            $res = str_pad($results[0], strlen($results[0])+1, '0', STR_PAD_LEFT);
            return $res;
        } catch (Exception $e) {
            print_r("Error en la consulta generar codigo".$e);
        }
    }  


}

?>