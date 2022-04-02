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
            return array("Error al registrar cliente ".$e,'');  
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
            return array("Error al registrar molde ".$e,'');
        }
    }

    public function m_guardarformulacion($codform,$produc,$sltipoprod,$cliente,$molde,$cavidades,$pesouni,$ciclo,$procant,
        $tempera1,$tempera2,$tempera3,$tempera4,$tempera5,$presexplu1,$presexplu2,$velexplu1,
        $velexplu2,$pisiexplu1,$pisiexplu2,$cargapres1,$cargapres2,$cargapres3,
        $cargapresucc,$cargavel1,$cargavel2,$cargavel3,$cargavelsucc,$cargapisi1,$cargapisi2,$cargapisi3,$cargapisisucci,
        $inyecpres4,$inyecpres3,$inyecpres2,$inyecpres1,$inyecvelo4,$inyecvelo3,$inyecvelo2,$inyecvelo1,$inyecposi4,
        $inyecposi3,$inyecposi2,$inyecposi1,$inyectiemp,$velocidad3,$velocidad2,$velocidad1,$posicion3,$posicion2,
        $posicion1,$tiempo,$usu,$items,$cambios,$inicio,$fin,$txttemp6,$txttemp7,$txttemp8,$txttemp9,

        $txtcarriage,$txtclosedd,$txtcuter,$txthead,$txtblow,$txttotalblo,$txtblow1,$txtlf,$txtdefla,$txtunde,
        $txtcoolin,$txtlock,$txtbottle,$txtcarria,$txtopenmoul,$txtcuter1,$txthead1,$txtblowpin,$txttotalbl,
        $txtdeflati,$txtblopinS,$txtdeflation,$txtcamvaci1,$txtcooling,$txtcamvaci2,$txtcamvaci3,$modifiedLF,
        
        $slemodeexpul,$botadocant,$presexplu3,$presexplu4,$velexplu3,$velexplu4,
        $pisiexplu3,$pisiexplu4,$txtTieRetar1,$txtTieRetar2,$txtTiemActua1,$txtairposi1,$txtairposi2,$txtBTiemActua1,
        $txtBirposi1,$txtBTieRetar1,

        $slcModoActSucci,$carSuckBackDist,$carSuckBackTime,$carSKBkBefChg,$carTiemDesDEspC,$carPosFlujoMold,
        $carTiempFlujoMo,$carRetarEnfria,$carCoolTime,
        
        $txtempuPresi1,$txtempuPresi2,$txtempuPresi3,$txtempuPresi4,$txtempudelay1,$txtemputiemp1,$txtemputiemp2,$txtempupisici,
        $txtempucorreAtr,$txtempuveloc1,$txtempuveloc2,$txtempuveloc3,$txtempuveloc4,

        
        $txtprecieOpnStr,$txtprescierr_presio1 ,$txtprescierr_presio2 ,$txtprescierr_presio3 ,$txtprescierr_presio4 ,
        $txtprescierr_velo1 ,$txtprescierr_velo2 ,$txtprescierr_velo3,$txtprescierr_velo5 , $txtprescierr_posic1 ,
        $txtprescierr_posic2 ,$txtprescierr_posic3 ,$txtprescierr_posic4 ,$txtprescierr_presi5 ,$txtprescierr_presi6 ,
        $txtprescierr_presi7 ,$txtprescierr_presi8 ,$txtprescierr_veloc5 ,$txtprescierr_veloc6 ,$txtprescierr_veloc7 ,
        $txtprescierr_veloc8,$txtprescierr_posic5,$txtprescierr_posic6 ,
        $txtprescierr_posic7 ,$txtprescierr_posic8,$horas,$canxturno)
        {
           
            $fechage = retunrFechaSqlphp(date("Y-m-d"));
            $fecha_actual = retunrFechaSqlphp(date("Y-m-d",strtotime(date("Y-m-d")."+ 1 year")));
            $inicio = retunrFechaSqlphp($inicio);
            $fin = retunrFechaSqlphp($fin);
            $hora = gethora();
            $maquina = os_info();
            $this->bd->beginTransaction();
        try {
            $lote = $this->m_lote('lote','V_LISTAR_PRODUCCION',8,$produc);
            $produccion = $this->m_select_generarcodigo('COD_PRODUCCION','T_PRODUCCION',9);
            $n_produ_g = $this->n_produccion_g();
            if($sltipoprod == 'P'){$cliente = '000000';}
            $query = $this->bd->prepare("INSERT INTO T_PRODUCCION(COD_PRODUCCION,COD_PRODUCTO,COD_CLIENTE,
            ID_MOLDE,FEC_GENERADO,HOR_GENERADO,FEC_VENCIMIENTO,COD_CATEGORIA,NUM_PRODUCCION_LOTE,CAN_PRODUCCION,
            CAVIDADES,PESO_UNI,CICLO,EST_PRODUCCION,USU_REGISTRO,MAQUINA,EXTERNO,COD_ALMACEN,N_PRODUCCION_G,
            FEC_INICIO,FEC_FIN,COD_FORMULACION,HORAS,CANT_TURNO)
            VALUES('$produccion','$produc','$cliente','$molde','$fechage','$hora','$fecha_actual','00002','$lote','$procant','$cavidades',
            '$pesouni','$ciclo','0','$usu','$maquina','$sltipoprod','00002 ','$n_produ_g','$inicio','$fin','$codform',
            '$horas','$canxturno')");
           
            $query->execute();

            $query2 = $this->bd->prepare("INSERT INTO T_TEMPERATURA(COD_PRODUCCION,TEMPERATURA_1,TEMPERATURA_2,
            TEMPERATURA_3,TEMPERATURA_4,TEMPERATURA_5,EXPUL_PRESION_1,EXPUL_PRESION_2,EXPUL_VELOCI_1,EXPUL_VELOCI_2,
            EXPUL_PISICION_1,EXPUL_PISICION_2,CONTRAC_1,CONTRAC_2,CONTRAC_3,CONTRAC_4,CARGA_PRESION_1,CARGA_PRESION_2,
            CARGA_PRESION_3,CARGA_PRESION_SUCCI,CARGA_VELOC_1,CARGA_VELOC_2,CARGA_VELOC_3,CARGA_VELOC_SUCCI,CARGA_POSIC_1,
            CARGA_POSIC_2,CARGA_POSIC_3,CARGA_POSIC_SUCCI,TEMPERATURA_6,TEMPERATURA_7,TEMPERATURA_8,TEMPERATURA_9,
            
            MOD_EXPULSION,CAN_EXPULSION,EXPUL_PRESION_3,EXPUL_PRESION_4,EXPUL_VELOCI_3,EXPUL_VELOCI_4,
            EXPUL_PISICION_3,EXPUL_PISICION_4,EXPUL_TIERETAR_1,EXPUL_TIERETAR_2,EXPUL_A_TIEMACT,EXPUL_A_POSICION ,
            EXPUL_A_TIERETAR,EXPUL_B_TIEMACT,EXPUL_B_POSICION,EXPUL_B_TIERETAR,
            CARGA_MODOACT,CARGA_SUCKBACKDIS,CARGA_SUCKBATIME,CARGA_SKBKBEF,CARGA_TIEMDESDESP,CARGA_POSFLUJOMOL,
            CARGA_TEMPFLUJOM,CARGA_RETARENFRIA,CARGA_COOLTIME
            ) 
            VALUES('$produccion','$tempera1','$tempera2','$tempera3','$tempera4',
            '$tempera5','$presexplu1','$presexplu2','$velexplu1','$velexplu2','$pisiexplu1','$pisiexplu2','0','0',
            '0','0','$cargapres1','$cargapres2','$cargapres3','$cargapresucc','$cargavel1','$cargavel2','$cargavel3',
            '$cargavelsucc','$cargapisi1','$cargapisi2','$cargapisi3','$cargapisisucci','$txttemp6','$txttemp7','$txttemp8',
            '$txttemp9',
            '$slemodeexpul','$botadocant','$presexplu3','$presexplu4','$velexplu3','$velexplu4',
            '$pisiexplu3','$pisiexplu4','$txtTieRetar1','$txtTieRetar2','$txtTiemActua1','$txtairposi1','$txtairposi2','$txtBTiemActua1',
            '$txtBirposi1','$txtBTieRetar1','$slcModoActSucci','$carSuckBackDist','$carSuckBackTime','$carSKBkBefChg','$carTiemDesDEspC',
            '$carPosFlujoMold',
            '$carTiempFlujoMo','$carRetarEnfria','$carCoolTime')");

            $query2->execute();

            $query3 = $this->bd->prepare("INSERT INTO T_INYECCION(COD_PRODUCCION,INYECC_PRESION_1,INYECC_PRESION_2,
            INYECC_PRESION_3,INYECC_PRESION_4,INYECC_VELOCIDAD_1,INYECC_VELOCIDAD_2,INYECC_VELOCIDAD_3,INYECC_VELOCIDAD_4,
            INYECC_POSICION_1,INYECC_POSICION_2,INYECC_POSICION_3,INYECC_POSICION_4,INYECC_TIEMPO,PRES_VELOCIDAD_1,PRES_VELOCIDAD_2,
            PRES_VELOCIDAD_3,PRES_POSICION_1,PRES_POSICION_2,PRES_POSICION_3,PRES_TIEMPO,
            
            EMPUJE_PRESION_1,EMPUJE_PRESION_2,EMPUJE_PRESION_3,EMPUJE_PRESION_4,EMPUJE_DELEY_2,EMPUJE_TIEMPO_2,
            EMPUJE_TIEMPO_3,EMPUJE_PISICI_2,EMPUJE_CORRER_ATRA, 
            EMPUJE_VELOCIDAD_1,EMPUJE_VELOCIDAD_2,EMPUJE_VELOCIDAD_3,EMPUJE_VELOCIDAD_4,
            
            PRECIE_OPNSTROKE,PRECIE_PRESION_1,PRECIE_PRESION_2,PRECIE_PRESION_B,PRECIE_PRESION_A,PRECIE_VELO_1, 
            PRECIE_VELO_2,PRECIE_VELO_A,PRECIE_VELO_B,PRECIE_POSICI_1,PRECIE_POSICI_2,PRECIE_POSICI_A,PRECIE_POSICI_B,
            PRECIE_PRESION_4,PRECIE_PRESION_3,PRECIE_PRESION_2_1,PRECIE_PRESION_1_1,PRECIE_VELO_4,PRECIE_VELO_3,PRECIE_VELO_2_1,
            PRECIE_VELO_1_1,PRECIE_POSICI_4,PRECIE_POSICI_3,PRECIE_POSICI_2_1,PRECIE_POSICI_1_1 
            ) VALUES('$produccion','$inyecpres4'
            ,'$inyecpres3','$inyecpres2','$inyecpres1','$inyecvelo4','$inyecvelo3','$inyecvelo2','$inyecvelo1','$inyecposi4',
            '$inyecposi3','$inyecposi2','$inyecposi1','$inyectiemp','$velocidad3','$velocidad2','$velocidad1','$posicion3','$posicion2',
            '$posicion1','$tiempo',


            '$txtempuPresi1','$txtempuPresi2','$txtempuPresi3','$txtempuPresi4','$txtempudelay1','$txtemputiemp1',
            '$txtemputiemp2','$txtempupisici','$txtempucorreAtr','$txtempuveloc1','$txtempuveloc2','$txtempuveloc3', 
            '$txtempuveloc4',

            '$txtprecieOpnStr','$txtprescierr_presio1','$txtprescierr_presio2','$txtprescierr_presio3','$txtprescierr_presio4',
            '$txtprescierr_velo1','$txtprescierr_velo2','$txtprescierr_velo3','$txtprescierr_velo5','$txtprescierr_posic1',
            '$txtprescierr_posic2','$txtprescierr_posic3','$txtprescierr_posic4','$txtprescierr_presi5','$txtprescierr_presi6',
            '$txtprescierr_presi7' ,'$txtprescierr_presi8' ,'$txtprescierr_veloc5' ,'$txtprescierr_veloc6' ,'$txtprescierr_veloc7' ,
            '$txtprescierr_veloc8','$txtprescierr_posic5','$txtprescierr_posic6',
            '$txtprescierr_posic7' ,'$txtprescierr_posic8')");

            $query3->execute();


             $query8 = $this->bd->prepare("INSERT INTO T_TIMER_LP(COD_PRODUCCION,CARRIAGEUP_DELAYTIME,CLOSEDWOULD_DELAYTIME
             ,CUTER_DELAY_TUME,HEAD_UP_DELAY_TIME,
             BLOWPINGDOWN_DELAYTIME,TOTAL_BLOW_DELAY_TIME,BLOW_TIME,LF_TO_RG_TIME,DEFLATIONDELAY_TIME,
             UNDERCUTIN_DELAY,COOLING_BLOW_DELAY_TIME,LOCK_WOULD_DELAY,BOTTLE_COOLING_ET,CARRIAGEDOWN_DELAY_TIME
             ,OPEN_MOULD_DELAY_TIME,CUTER_TIME,
             HEAD_UP_TIME,BLOWPIN_DOWN_TIME,TOTAL_BLOW_TIME,DEFLATION_TIME,BLOWPIN_SHORTUP_TIME,
             DEFLATIONTIME,CAMPO_SIN_NOMBRE1,COOLING_BLOW_TIME,CAMPO_SIN_NOMBRE2,CAMPO_SIN_NOMBRE3)

             VALUES('$produccion','$txtcarriage','$txtclosedd'
             ,'$txtcuter','$txthead','$txtblow','$txttotalblo','$txtblow1','$txtlf','$txtdefla','$txtunde',
             '$txtcoolin','$txtlock','$txtbottle','$txtcarria','$txtopenmoul','$txtcuter1','$txthead1','$txtblowpin'
             ,'$txttotalbl','$txtdeflati','$txtblopinS','$txtdeflation','$txtcamvaci1','$txtcooling','$txtcamvaci2',
             '$txtcamvaci3')");

             $query8->execute();
            
            if($cambios == 1){
                $query4 = $this->bd->prepare("INSERT INTO T_TEMPERATURA_TEMP(COD_FORMULACION,COD_PRODUCCION,TEMPERATURA_1,TEMPERATURA_2,
                TEMPERATURA_3,TEMPERATURA_4,TEMPERATURA_5,EXPUL_PRESION_1,EXPUL_PRESION_2,EXPUL_VELOCI_1,EXPUL_VELOCI_2,
                EXPUL_PISICION_1,EXPUL_PISICION_2,CONTRAC_1,CONTRAC_2,CONTRAC_3,CONTRAC_4,CARGA_PRESION_1,CARGA_PRESION_2,
                CARGA_PRESION_3,CARGA_PRESION_SUCCI,CARGA_VELOC_1,CARGA_VELOC_2,CARGA_VELOC_3,CARGA_VELOC_SUCCI,CARGA_POSIC_1,
                CARGA_POSIC_2,CARGA_POSIC_3,CARGA_POSIC_SUCCI,USU_REGISTRO,TEMPERATURA_6,TEMPERATURA_7,TEMPERATURA_8,TEMPERATURA_9,
                
                MOD_EXPULSION,CAN_EXPULSION,EXPUL_PRESION_3,EXPUL_PRESION_4,EXPUL_VELOCI_3,EXPUL_VELOCI_4,
                EXPUL_PISICION_3,EXPUL_PISICION_4,EXPUL_TIERETAR_1,EXPUL_TIERETAR_2,EXPUL_A_TIEMACT,EXPUL_A_POSICION,
                EXPUL_A_TIERETAR,EXPUL_B_TIEMACT,EXPUL_B_POSICION,EXPUL_B_TIERETAR,
                CARGA_MODOACT,CARGA_SUCKBACKDIS,CARGA_SUCKBATIME,CARGA_SKBKBEF,CARGA_TIEMDESDESP,CARGA_POSFLUJOMOL, 
                CARGA_TEMPFLUJOM,CARGA_RETARENFRIA,CARGA_COOLTIME,CICLOS,CAVIDADES,HORAS,CANT_TURNO)
                 VALUES('$codform','$produccion','$tempera1','$tempera2','$tempera3','$tempera4',
                '$tempera5','$presexplu1','$presexplu2','$velexplu1','$velexplu2','$pisiexplu1','$pisiexplu2','0','0',
                '0','0','$cargapres1','$cargapres2','$cargapres3','$cargapresucc','$cargavel1','$cargavel2','$cargavel3',
                '$cargavelsucc','$cargapisi1','$cargapisi2','$cargapisi3','$cargapisisucci','$usu',
                '$txttemp6','$txttemp7','$txttemp8','$txttemp9',
                
                '$slemodeexpul','$botadocant','$presexplu3','$presexplu4','$velexplu3','$velexplu4',
                '$pisiexplu3','$pisiexplu4','$txtTieRetar1','$txtTieRetar2','$txtTiemActua1','$txtairposi1','$txtairposi2','$txtBTiemActua1',
                '$txtBirposi1','$txtBTieRetar1','$slcModoActSucci','$carSuckBackDist','$carSuckBackTime','$carSKBkBefChg','$carTiemDesDEspC','$carPosFlujoMold',
                '$carTiempFlujoMo','$carRetarEnfria','$carCoolTime','$ciclo','$cavidades','$horas','$canxturno')");
               
                $query4->execute();
    
                $query5 = $this->bd->prepare("INSERT INTO T_INYECCION_TEMP(COD_FORMULACION,COD_PRODUCCION,INYECC_PRESION_1,INYECC_PRESION_2,
                INYECC_PRESION_3,INYECC_PRESION_4,INYECC_VELOCIDAD_1,INYECC_VELOCIDAD_2,INYECC_VELOCIDAD_3,INYECC_VELOCIDAD_4,
                INYECC_POSICION_1,INYECC_POSICION_2,INYECC_POSICION_3,INYECC_POSICION_4,INYECC_TIEMPO,PRES_VELOCIDAD_1,PRES_VELOCIDAD_2,
                PRES_VELOCIDAD_3,PRES_POSICION_1,PRES_POSICION_2,PRES_POSICION_3,PRES_TIEMPO,USU_REGISTRO,
                
                EMPUJE_PRESION_1,EMPUJE_PRESION_2,EMPUJE_PRESION_3,EMPUJE_PRESION_4,EMPUJE_DELEY_2,EMPUJE_TIEMPO_2,
                EMPUJE_TIEMPO_3,EMPUJE_PISICI_2,EMPUJE_CORRER_ATRA, 
                EMPUJE_VELOCIDAD_1,EMPUJE_VELOCIDAD_2,EMPUJE_VELOCIDAD_3, EMPUJE_VELOCIDAD_4,

                PRECIE_OPNSTROKE,PRECIE_PRESION_1,PRECIE_PRESION_2,PRECIE_PRESION_B,PRECIE_PRESION_A,PRECIE_VELO_1, 
                PRECIE_VELO_2,PRECIE_VELO_A,PRECIE_VELO_B,PRECIE_POSICI_1,PRECIE_POSICI_2,PRECIE_POSICI_A,PRECIE_POSICI_B, 
                PRECIE_PRESION_4,PRECIE_PRESION_3,PRECIE_PRESION_2_1,PRECIE_PRESION_1_1,PRECIE_VELO_4,PRECIE_VELO_3,PRECIE_VELO_2_1,
                PRECIE_VELO_1_1,PRECIE_POSICI_4,PRECIE_POSICI_3,PRECIE_POSICI_2_1,PRECIE_POSICI_1_1 

                ) VALUES('$codform','$produccion','$inyecpres4'
                ,'$inyecpres3','$inyecpres2','$inyecpres1','$inyecvelo4','$inyecvelo3','$inyecvelo2','$inyecvelo1','$inyecposi4',
                '$inyecposi3','$inyecposi2','$inyecposi1','$inyectiemp','$velocidad3','$velocidad2','$velocidad1','$posicion3','$posicion2',
                '$posicion1','$tiempo','$usu',
                
                '$txtempuPresi1','$txtempuPresi2','$txtempuPresi3','$txtempuPresi4','$txtempudelay1','$txtemputiemp1',
                '$txtemputiemp2','$txtempupisici','$txtempucorreAtr','$txtempuveloc1','$txtempuveloc2','$txtempuveloc3', 
                '$txtempuveloc4',

                '$txtprecieOpnStr','$txtprescierr_presio1','$txtprescierr_presio2','$txtprescierr_presio3','$txtprescierr_presio4',
                '$txtprescierr_velo1','$txtprescierr_velo2','$txtprescierr_velo3','$txtprescierr_velo5','$txtprescierr_posic1',
                '$txtprescierr_posic2','$txtprescierr_posic3','$txtprescierr_posic4','$txtprescierr_presi5','$txtprescierr_presi6',
                '$txtprescierr_presi7' ,'$txtprescierr_presi8' ,'$txtprescierr_veloc5' ,'$txtprescierr_veloc6' ,'$txtprescierr_veloc7' ,
                '$txtprescierr_veloc8','$txtprescierr_posic5','$txtprescierr_posic6' ,
                '$txtprescierr_posic7' ,'$txtprescierr_posic8'
                )");
                $query5->execute();
            }

            if($modifiedLF == 1 || $cambios == 1){
                $query9 = $this->bd->prepare("INSERT INTO T_TIMER_LP_TEMPORAL(COD_FORMULACION,COD_PRODUCCION,CARRIAGEUP_DELAYTIME,CLOSEDWOULD_DELAYTIME
                ,CUTER_DELAY_TUME,HEAD_UP_DELAY_TIME,
                BLOWPINGDOWN_DELAYTIME,TOTAL_BLOW_DELAY_TIME,BLOW_TIME,LF_TO_RG_TIME,DEFLATIONDELAY_TIME,
                UNDERCUTIN_DELAY,COOLING_BLOW_DELAY_TIME,LOCK_WOULD_DELAY,BOTTLE_COOLING_ET,CARRIAGEDOWN_DELAY_TIME
                ,OPEN_MOULD_DELAY_TIME,CUTER_TIME,
                HEAD_UP_TIME,BLOWPIN_DOWN_TIME,TOTAL_BLOW_TIME,DEFLATION_TIME,BLOWPIN_SHORTUP_TIME,
                DEFLATIONTIME,CAMPO_SIN_NOMBRE1,COOLING_BLOW_TIME,CAMPO_SIN_NOMBRE2,CAMPO_SIN_NOMBRE3,USU_REGISTRO)
                VALUES('$codform','$produccion','$txtcarriage','$txtclosedd'
                ,'$txtcuter','$txthead','$txtblow','$txttotalblo','$txtblow1','$txtlf','$txtdefla','$txtunde',
                '$txtcoolin','$txtlock','$txtbottle','$txtcarria','$txtopenmoul','$txtcuter1','$txthead1','$txtblowpin'
                ,'$txttotalbl','$txtdeflati','$txtblopinS','$txtdeflation','$txtcamvaci1','$txtcooling','$txtcamvaci2',
                '$txtcamvaci3','$usu')");
                 $query9->execute();
            }
           
            foreach ($items->tds as $dato){
                if($dato != ''){
                    if($dato[3] == "P"){
                        $cadena = "COD_PRODUCTO = '$dato[1]'";
                        $c_propio = $this->m_buscar('T_ALMACEN_INSUMOS',$cadena);
                        $stockin = sprintf("%0.3f", $c_propio[0][4]);
                        $valodato = sprintf("%0.3f",  $dato[2]);
                        $stock =$stockin - $valodato;
                        $valodato = sprintf("%0.3f",$stock);
                        $query6 = $this->bd->prepare("UPDATE T_ALMACEN_INSUMOS SET STOCK_ACTUAL='$valodato',
                        FEC_MODIFICO = '$fechage' WHERE COD_PRODUCTO ='$dato[1]'"); 
                       $query6->execute();
                    }else if($dato[3] == "E"){
                       //$cadena = "COD_PRODUCTO = '$dato[1]'";
                       // $c_propio = $this->m_buscar('T_ALMACEN_EXTERNOS',$cadena);
                       // $stock = intval($c_propio[0][4]) - intval($dato[2]);
                       // $query4 = $this->bd->prepare("UPDATE T_ALMACEN_EXTERNOS SET STOCK_ACTUAL='$stock' 
                       // WHERE COD_PRODUCTO ='$dato[1]'");
                    }
                    
                    $query7 = $this->bd->prepare("INSERT INTO T_PRODUCCION_ITEM(COD_PRODUCCION,COD_PRODUCTO,
                    CAN_FORMULACION,TIPO_INSUMOS,USU_REGISTRO,MAQUINA) 
                    VALUES('$produccion','$dato[1]',$dato[2],'$dato[3]','$usu','$maquina')");
                    $query7->execute(); 
                    if($query7->errorCode()>0){	
                        $this->bd->rollBack();
                        return 0;
                        break;
                    }
                }
            }  
           $guardado = $this->bd->commit();
           return $guardado;
        } catch (Exception $e) {
            $this->bd->rollBack();
           print_r("Error al guardar la produccion " .$e); 
        }
    }

    public function n_produccion_g()
    {
         try {
             $fecha = retunrFechaSqlphp(date("Y-m-d"));
             $query = $this->bd->prepare("SELECT TOP 1 n_produccion FROM 
             V_LISTAR_PRODUCCION WHERE fecha < '$fecha' order by n_produccion desc");
             $results = $query->fetch();
             if($results[0] == NULL) $results[0] = '1';
             $res = str_pad($results[0],10,'0', STR_PAD_LEFT);
             return $res;
         } catch (Exception $e) {
             print_r("Error al generar correlativo de produccion - g ". $e);
         }   
    }

    public function m_lote($campo,$tabla,$cantidad,$codpro)
    {
            try {
            $query = $this->bd->prepare("SELECT MAX($campo)+1 as codigo FROM $tabla where producto = '$codpro'");
            $query->execute();
            $results = $query->fetch();
            if($results[0] == NULL) $results[0] = '1';
            $res = str_pad($results[0],$cantidad, '0', STR_PAD_LEFT);
            return $res;
            } catch (Exception $e) {
                print_r("Error al generar codigo " . $e);
            }
    }

    public function m_galmancen_exter($prod,$cantidad)
    {
        try {
            $columna = "COD_PRODUCTO = '$prod'";
            $dato = $this->m_buscar('T_ALMACEN_EXTERNOS',$columna);
            if(count($dato) > 0){
                /*$stock = intval($dato[0][4]) + intval($cantidad);
                $almaexte = $this->bd->prepare("UPDATE T_ALMACEN_EXTERNOS SET STOCK_ACTUAL = '$stock' WHERE  
                COD_PRODUCTO = '$prod'"); */   
            }else{
                $codalin = $this->m_select_generarcodigo('COD_ALIN','T_ALMACEN_EXTERNOS',6);
                $almaexte = $this->bd->prepare("INSERT INTO T_ALMACEN_EXTERNOS (COD_ALIN,COD_CLASE,COD_PRODUCTO,COD_ALMACEN,STOCK_ACTUAL)
                VALUES('$codalin','','$prod','','$cantidad')");    
            }
            $result = $almaexte->execute();
            return $result;
        } catch (Exception $e) {
            print_r("Error al registrar insumos externo" .$e);
        }
    }

    public function m_updateexteno($prod,$cantidad)
    {
        try {
            $columna = "COD_PRODUCTO = '$prod'";
            $dato = $this->m_buscar('T_ALMACEN_EXTERNOS',$columna);
            if(count($dato) > 0){
                $stock = intval($dato[0][4]) - intval($cantidad);
                $query = $this->bd->prepare("UPDATE T_ALMACEN_EXTERNOS SET STOCK_ACTUAL = '$stock' WHERE
                COD_PRODUCTO = '$prod'");
                $resul =$query->execute();
                return $resul; 
            }else{
                return "No se encontro el producto en almacen externo";
            }
        }catch (Exception $e) {
            print_r("Error al actualizar almacen externo" . $e);
        }
    }

    public function m_ultimoregistro($formula)
    {
        try {
            $query = $this->bd->prepare("SELECT TOP 1 * FROM V_PARAMETROS_PRODUCCION WHERE 
            COD_FORMULACION = '$formula' ORDER BY FEC_REGISTRO DESC");
            $query->execute();
            $resul = $query->fetchAll(PDO::FETCH_NUM);
            return $resul;
        } catch (Exception $e) {
            print_r("Error al seleccionar ultimos parametros " . $e);
        }
    }

    public function m_confirmacion($confirmacion)
    {
        $consulta = "ID_PARAM = '2'";
        $count1 = $this->m_buscar("T_PARAMETROS",$consulta);
        $cod =  $count1[0][1] * 4;
        if($cod != $confirmacion){
            return "Error codigo de autorización invalido";
        }else{
            return 1;
        }
    }

    public function generarxdiario()
    {
        $numero = rand(1,5000);
        $fecha = retunrFechaSqlphp(date("Y-m-d"));
        try {
            $consulta = "ID_PARAM = '2' AND CONVERT(DATE,FEC_CREADO) <> '$fecha'";
            $count1 = $this->m_buscar("T_PARAMETROS",$consulta);
            if(count($count1) > 0){
                $query = $this->bd->prepare("UPDATE T_PARAMETROS SET COD_BLOQUE = '$numero',
                FEC_CREADO = '$fecha' WHERE ID_PARAM = '2'");
                $resul = $query->execute();
                return $resul;
            }
        } catch (Exception $e) {
            print_r("Error al generar codigo" . $e);
        }
    }
}
?>