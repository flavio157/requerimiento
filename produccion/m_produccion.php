<?php
require_once("../funciones/DataBasePlasticos.php");
require_once("../funciones/cod_almacenes.php");
require_once("../funciones/f_funcion.php");
require_once("../funciones/maquina.php");
class m_produccion
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
            $datos = $query->fetchAll(PDO::FETCH_NUM);
            return $datos;
        } catch (Exception $e) {
            print_r("Error en la consulta buscar ".$e);
        } 
    }

    public function m_select_generarcodigo($campo,$tabla,$cantidad)
    {
            try {
            $query = $this->bd->prepare("SELECT MAX($campo)+1 as codigo FROM $tabla");
            $query->execute();
            $results = $query->fetch();
            if($results[0] == NULL) $results[0] = '1';
            $res = str_pad($results[0],$cantidad, '0', STR_PAD_LEFT);
            return $res;
            } catch (Exception $e) {
                print_r("Error al generar codigo " . $e);
            }
    }
    
    public function m_buscarformulacion()
    {
        try {
            $query = $this->bd->prepare("SELECT * FROM  V_CABECERA_FORMULACION");
            $query->execute();
            $datos = $query->fetchAll(PDO::FETCH_NUM);
            return $datos;
        } catch (Exception $e) {
            print_r("Error en la consulta buscar ".$e);
        } 
    }
  
    public function m_guardarcliente($nombre,$dire,$correo,$dni,$tel,$usu){
        try {
             $cliente = $this->m_select_generarcodigo('COD_CLIENTE','T_CLIENTE_MOLDE',6);
             $query = $this->bd->prepare("INSERT INTO T_CLIENTE_MOLDE(COD_CLIENTE,NOM_CLIENTE,DIR_CLIENTE,
             IDENTIFICACION,TEL_CLIENTE,CORREO,USU_REGISTRO)
             VALUES('$cliente','$nombre','$dire','$dni','$tel','$correo','$usu')");   
             $result = $query->execute();   
             return array($result,$cliente);      
        } catch (Exception $e) {
            print_r("Error al registrar cliente ".$e);
        }
    }
    public function m_guardarmolde($nombre,$medidas,$usu,$codcliente){
        try {
             $molde = $this->m_select_generarcodigo('ID_MOLDE','T_MOLDE',6);
             $query = $this->bd->prepare("INSERT INTO T_MOLDE(ID_MOLDE,NOM_MOLDE,MEDIDAS,USU_REGISTRO,ESTADO
             ,TIPO_MOLDE,COD_CLIENTE)
             VALUES('$molde','$nombre','$medidas','$usu','1','E','$codcliente')");
             $result = $query->execute();     
             return array($result,$molde);            
        } catch (Exception $e) {
            print_r("Error al registrar molde ".$e);
        }
    }

    public function m_guardarformulacion($produc,$sltipoprod,$cliente,$molde,$cavidades,$pesouni,$ciclo,$procant,
        $tempera1,$tempera2,$tempera3,$tempera4,$tempera5,$presexplu1,$presexplu2,$velexplu1,
        $velexplu2,$pisiexplu1,$pisiexplu2,$contrac1,$contrac2,$contrac3,$contrac4,$cargapres1,$cargapres2,$cargapres3,
        $cargapresucc,$cargavel1,$cargavel2,$cargavel3,$cargavelsucc,$cargapisi1,$cargapisi2,$cargapisi3,$cargapisisucci,
        $inyecpres4,$inyecpres3,$inyecpres2,$inyecpres1,$inyecvelo4,$inyecvelo3,$inyecvelo2,$inyecvelo1,$inyecposi4,
        $inyecposi3,$inyecposi2,$inyecposi1,$inyectiemp,$velocidad3,$velocidad2,$velocidad1,$posicion3,$posicion2,
        $posicion1,$tiempo,$usu,$items){
            $fechage = retunrFechaSqlphp(date("Y-m-d"));
            $hora = gethora();
            $maquina = os_info();
            $this->bd->beginTransaction();
        try {
            $produccion = $this->m_select_generarcodigo('COD_PRODUCCION','T_PRODUCCION',9);
            $query = $this->bd->prepare("INSERT INTO T_PRODUCCION(COD_PRODUCCION,COD_PRODUCTO,COD_CLIENTE,
            ID_MOLDE,FEC_GENERADO,HOR_GENERADO,FEC_VENCIMIENTO,COD_CATEGORIA,NUM_PRODUCCION_LOTE,CAN_PRODUCCION,
            CAVIDADES,PESO_UNI,CICLO,EST_PRODUCCION,USU_REGISTRO,MAQUINA,EXTERNO,COD_ALMACEN,N_PRODUCCION_G)
            VALUES('$produccion','$produc','$cliente','$molde','$fechage','$hora','','00002','','$procant','$cavidades',
            '$pesouni','$ciclo','','$usu','$maquina','$sltipoprod','','')");

            $query->execute();

            $query2 = $this->bd->prepare("INSERT INTO T_TEMPERATURA(COD_PRODUCCION,TEMPERATURA_1,TEMPERATURA_2,
            TEMPERATURA_3,TEMPERATURA_4,TEMPERATURA_5,EXPUL_PRESION_1,EXPUL_PRESION_2,EXPUL_VELOCI_1,EXPUL_VELOCI_2,
            EXPUL_PISICION_1,EXPUL_PISICION_2,CONTRAC_1,CONTRAC_2,CONTRAC_3,CONTRAC_4,CARGA_PRESION_1,CARGA_PRESION_2,
            CARGA_PRESION_3,CARGA_PRESION_SUCCI,CARGA_VELOC_1,CARGA_VELOC_2,CARGA_VELOC_3,CARGA_VELOC_SUCCI,CARGA_POSIC_1,
            CARGA_POSIC_2,CARGA_POSIC_3,CARGA_POSIC_SUCCI) VALUES('$produccion','$tempera1','$tempera2','$tempera3','$tempera4',
            '$tempera5','$presexplu1','$presexplu2','$velexplu1','$velexplu2','$pisiexplu1','$pisiexplu2','$contrac1','$contrac2',
            '$contrac3','$contrac4','$cargapres1','$cargapres2','$cargapres3','$cargapresucc','$cargavel1','$cargavel2','$cargavel3',
            '$cargavelsucc','$cargapisi1','$cargapisi2','$cargapisi3','$cargapisisucci')");
           
            $query2->execute();

            $query3 = $this->bd->prepare("INSERT INTO T_INYECCION(COD_PRODUCCION,INYECC_PRESION_1,INYECC_PRESION_2,
            INYECC_PRESION_3,INYECC_PRESION_4,INYECC_VELOCIDAD_1,INYECC_VELOCIDAD_2,INYECC_VELOCIDAD_3,INYECC_VELOCIDAD_4,
            INYECC_POSICION_1,INYECC_POSICION_2,INYECC_POSICION_3,INYECC_POSICION_4,INYECC_TIEMPO,PRES_VELOCIDAD_1,PRES_VELOCIDAD_2,
            PRES_VELOCIDAD_3,PRES_POSICION_1,PRES_POSICION_2,PRES_POSICION_3,PRES_TIEMPO) VALUES('$produccion','$inyecpres4'
            ,'$inyecpres3','$inyecpres2','$inyecpres1','$inyecvelo4','$inyecvelo3','$inyecvelo2','$inyecvelo1','$inyecposi4',
            '$inyecposi3','$inyecposi2','$inyecposi1','$inyectiemp','$velocidad3','$velocidad2','$velocidad1','$posicion3','$posicion2',
            '$posicion1','$tiempo')");
            $query3->execute();

            foreach ($items->tds as $dato){
                if($dato != ''){
                    if($dato[3] == "P"){
                        $cadena = "COD_PRODUCTO = '$dato[0]'";
                        $c_propio = $this->m_buscar('T_ALMACEN_INSUMOS',$cadena);
                        $stock = intval($c_propio[0][4]) - intval($dato[2]);
                        $query4 = $this->bd->prepare("UPDATE T_ALMACEN_INSUMOS SET STOCK_ACTUAL='$stock' 
                        WHERE COD_PRODUCTO ='$dato[0]'");
                        $query4->execute(); 
                    }

                    $query5 = $this->bd->prepare("INSERT INTO T_PRODUCCION_ITEM(COD_PRODUCCION,COD_PRODUCTO,
                    CAN_FORMULACION,TIPO_INSUMOS,USU_REGISTRO,MAQUINA) 
                    VALUES('$produccion','$dato[0]',$dato[2],'$dato[3]','$usu','$maquina')");
                     $query5->execute(); 
                    if($query5->errorCode()>0){	
                        $this->bd->rollBack();
                        return 0;
                        break;
                    }
                }
            }  

            $guardado = $this->bd->commit();
            return $guardado;
        } catch (Exception $e) {
           print_r("Error al guardar la produccion " .$e); 
        }
    }
}
?>
