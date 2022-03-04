<?php
date_default_timezone_set('America/Lima');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once("../funciones/f_funcion.php");
require_once("m_produccion.php");

    $accion = $_POST['accion'];  
  
   if($accion == 'lstproduccion'){
        $usu = $_POST['usu'];
        c_produccion::c_itemsformula($usu);
    }else if($accion == 'ocurrencia'){
        $produccion = $_POST['produccion'];
        $observacion = $_POST['ocurrencia'];
        $detepro = $_POST['detepro'];
        $usu = $_POST['usu'];
        $ocu = $_POST['ocu'];
        $id = $_POST['id'];
        c_produccion::c_registrar_ocurrencia($produccion,$observacion,$usu,$detepro,$ocu,$id);
    }else if($accion == 'gdatos'){
            $produccion = $_POST['produccion'];
            $fechincidencia = $_POST['fechincidencia'];
            $horaincidencia = $_POST['horaincidencia'];
            $observacion = $_POST['observacion'];
            $usu = $_POST['usu'];
            $t = $_POST['t'];
            $cantidad = $_POST['cantidad'];
            $tipomerma = $_POST['tipomerma'];
            $color = $_POST['color'];
            $falla = $_POST['cantprofalla'];
            c_produccion::c_registrardatos($produccion,$fechincidencia,$horaincidencia,
            $observacion,$usu,$t,$cantidad,$tipomerma,$color,$falla);
    }else if($accion == 'gavances'){
        $tara = $_POST['mdtara'];
        $pesoneto = $_POST['mdpesoneto'];
        $cantxpaquete = $_POST['mdcantxcaja'];
        $paquexsacar = $_POST['mdcajasxsacar'];
        $lote = $_POST['mdlote'];
        $produccion= $_POST['mdcodprod'];
        $usu = $_POST['usu'];
        $total = $_POST['total'];
        $producto = $_POST['mdproduc'];
        $totalproduc = $_POST['mdtotal'];
        $turno = $_POST['slcmdturno'];
        $maquinista = $_POST['mdcodmaquinista'];
        c_produccion::c_gavances($tara,$pesoneto,$cantxpaquete,$paquexsacar,$lote,$produccion,$usu,$total,
        $producto,$totalproduc,$turno,$maquinista);
    }else if($accion == 'v_avances'){
        $produccion  = $_POST['produccion'];
        c_produccion::v_avances($produccion);
    }else if($accion == 'gavancesitems'){
        $cantavance = $_POST['avance'];
        $prod = $_POST['produ'];
        $usu = $_POST['usu'];
        $producto = $_POST['mdproduc'];
        $faltante = $_POST['faltante'];
        $turno = $_POST['turno'];
        $maquinista = $_POST['maquinista'];
        $tara = $_POST['mtara'];
        c_produccion::c_gitemsavance($cantavance,$usu,$prod,$producto,$turno,$maquinista,$tara);
    }else if($accion == 'validafinpro'){
        $codproduccion = $_POST['produccion'];
        $cantidad = $_POST['cantidad'];
        $cantxpa = $_POST['cantxpa'];
        $total = $_POST['total'];
        c_produccion::c_verifinpro($codproduccion,$cantidad,$cantxpa,$total);
    }else if($accion == 'lstavance'){
        $produccion = $_POST['produccion'];
        c_produccion::c_lstavance($produccion);
    }else if($accion == 'updimpresion'){
        $avance = $_POST['avance'];
        c_produccion::c_actualizar_impresion($avance);
    }else if($accion == 'lstocurrencia'){
        $produccion = $_POST['produccion'];
        c_produccion::c_ocurrencia($produccion);
    }else if($accion == 'finproduc'){
        $produccion = $_POST['produccion'];
        $usu = $_POST['usu'];
        c_produccion::c_terminarproduccion($produccion,$usu);
    }else if($accion =='perdida'){
        $produccion = $_POST['produccion'];
        $maquinista = $_POST['maquinista'];
        $turno = $_POST['turno'];
        c_produccion::c_perdida($produccion,$maquinista,$turno);
    }else if($accion == 'lstmodificar'){
        $tipo = $_POST['tipo'];
        $produccion = $_POST['produccion'];
        c_produccion::c_lstresiduos($tipo,$produccion);
    }else if($accion == 'frmmodificar'){
      
        $tipo = $_POST['tipo'];
        $merma = $_POST['merma'];
        $observacion = $_POST['txtmdobservacion'];
        $txtmdpesAnter = $_POST['txtmdpeso'];
        $txtmdpesomodifi = $_POST['txtmdcantidad'];
        $slcmdtipoAnt = $_POST['slcmdtipo'];
            
        if(isset($_POST['txtmdprodfalla']) == 1)
        {  $cantfalla = $_POST['txtmdprodfalla'];}else{
            $cantfalla = '';
        }
        
        if(isset($_POST['slcmdtipomerma']) == 1)
        { $slcmdtipomodi = $_POST['slcmdtipomerma'];}else{
            $slcmdtipomodi = '';
        }
      
        $usu = $_POST['usu'];
        c_produccion::c_actualizar($merma,$observacion,$cantfalla,$txtmdpesAnter,$txtmdpesomodifi
        ,$slcmdtipoAnt,$slcmdtipomodi,$tipo,$usu);
    }else if($accion == 'lstpersonal'){
        $usu = $_POST['usu'];
        c_produccion::c_buscarpersonal($usu);
    }else if($accion == 'controlcali'){
        $usu  = $_POST['usu'];
        c_produccion::bloqueox($usu);
    }else if($accion == 'gcontrol'){
        $color =$_POST['color'];
        $pureza = $_POST['pureza'];
        $rebaba = $_POST['rebaba'];
        $peso = $_POST['peso'];
        $observacion = $_POST['observacion'];
        $establidad = $_POST['establidad'];
        $usu = $_POST['usu'];
        $tcalid = $_POST['tcalid'];
        $txtpro = $_POST['txtpro'];
        $txtprodu = $_POST['txtprodu'];
        c_produccion::c_gcontrol($color,$pureza,$rebaba,$peso,$observacion,$establidad,$usu,$tcalid,$txtpro,$txtprodu);
    }else if($accion == 'modalcontrol'){
        c_produccion::c_controlcalidad();
    }else if($accion == 'params'){
        c_produccion::c_bloqueo();
    }else if($accion == 'desbloq'){
        $coddesblo = $_POST['codigo'];
        c_produccion::c_desbloqueo($coddesblo);
    }
    
   

    class c_produccion
    {
        static function c_buscarpersonal($usu)
        {   
            $personal = [];$nombre = '';
            $m_formula = new m_produccion();
            $cadena = "''= ''";
            $c_personal = $m_formula->m_buscar('T_PERSONAL',$cadena);
            for ($i=0; $i < count($c_personal) ; $i++) {
                array_push($personal,array(
                    "code" => $c_personal[$i][0],
                    "label" => $c_personal[$i][5],
                ));
                if($usu ==trim($c_personal[$i][0])){
                    $nombre = $c_personal[$i][5];
                }
            }
            $dato = array('dato' => $personal, 'nombre' => $nombre);
            echo json_encode($dato,JSON_FORCE_OBJECT);
        }

        static function c_itemsformula($usu)
        {
            $m_formula = new m_produccion();
            $cadena = "estado = '0'";
            $c_formula = $m_formula->m_buscar('V_LISTAR_PRODUCCION',$cadena);
            $dato = array('dato' => $c_formula);
            echo json_encode($dato,JSON_FORCE_OBJECT);
        }

        static function c_ocurrencia($produccion)
        {
            $obs="0" ; $id="0";
            $m_formula = new m_produccion();
            $cadena = "COD_PRODUCCION = '$produccion'";
            $c_ocurrencia = $m_formula->m_buscar('T_OCURRENCIAS',$cadena);

            $cadena = "COD_PRODUCCION = '$produccion' AND PRODU_DETENIDO = '1'";
            $c_ocurrencia2 = $m_formula->m_buscar('T_OCURRENCIAS',$cadena);
            if(count($c_ocurrencia2) > 0){
                $obs = $c_ocurrencia2[0][2];
                $id = $c_ocurrencia2[0][8];
            }
            $dato = array('dato' => $c_ocurrencia,
            'obs' => $obs,'o'=>$id);
            echo json_encode($dato,JSON_FORCE_OBJECT);
        }

        static function c_registrar_ocurrencia($produccion,$observacion,$usu,$detepro,$ocu,$id)
        {
            if(strlen(trim($produccion)) == 0){print_r("Error seleccione produccion");return;}
            if(strlen(trim($observacion)) == 0){print_r("Error ingrese datos del campo observación"); return;}
            if(is_numeric($observacion)){print_r("Error observación no puede ser solo numeros"); return;}
            $m_produccion = new m_produccion();
            if($ocu == "0"){
              $c_produccion = $m_produccion->m_guardarocurrencia($produccion,$observacion,$usu,$detepro);
            }else{
                if($detepro == "true"){print_r("Error desmarque el check para reanudar la produccion");return;}
                $c_produccion = $m_produccion->m_actualizaocurencia($usu,$id);
            }
            print_r($c_produccion);
        }

        static function c_registrardatos($codproduccion,$fechincidencia,$horaincidencia,
        $observacion,$usu,$t,$cantidad,$tipomerma,$color,$falla)
        {
            $falla = (strlen(trim($falla)) == 0) ? 0 : $falla;
            $residuos = '';
            $dato = c_produccion::c_validardatos($fechincidencia,$horaincidencia,
            $observacion,$t,$cantidad);
            $m_produccion = new m_produccion();
            if($dato == '0'){
                if($t == 'm'){
                    $residuos = $m_produccion->m_guardarmerma($codproduccion,
                    $fechincidencia,$horaincidencia,$observacion,$usu,$cantidad,$tipomerma,$falla);
                    print_r($residuos);
                }else if($t == 'r'){
                    $residuos = $m_produccion->m_guardarresiduos($codproduccion,$observacion,$usu,$cantidad
                    ,$color);
                    print_r($residuos);
    
                }else if ($t == 'd'){
                    $residuos = $m_produccion->m_guardardesechos($codproduccion,$observacion,$usu,$cantidad);
                    print_r($residuos);
                }
            }else{
                print_r($dato);
            }
        }

        static function c_validardatos($fechincidencia,$horaincidencia,
        $observacion,$t,$cantidad)
        {
            if($t == 'm'){
                if(strlen(trim($fechincidencia)) == 0){return "Error seleccione fecha incidencia";}
                if(strlen(trim($horaincidencia)) == 0){return "Error ingrese hora merma";}
                if($horaincidencia == '00:00'){return "Error la hora incidencia no puede ser 00:00";}
            }
            if(strlen(trim($observacion)) == 0){return "Error ingrese observación";}
            if(!is_numeric($cantidad)){return "Error solo numero en cantidad";}
            return '0';
        }

        static function c_gavances($tara,$pesoneto,$cantxbolsa,$paquexsacar,$lote,$produccion,$usu,$total,
        $producto,$totalproduc,$turno,$maquinista){
            $temi = 0;$dato = "";$c_produccion = '';$respuesta = '0'; 
           
            if($paquexsacar == $total){
                $temi = 1;
            }
            $resul = c_produccion::c_validarfinrprod($tara,$pesoneto,$cantxbolsa,$paquexsacar,$lote,$total,
            $turno,$maquinista);
            if($resul == "1"){
                if($respuesta == '0'){
                    $m_produccion = new m_produccion();
                    $c_produccion = $m_produccion->m_gvances($tara,$pesoneto,$cantxbolsa,$paquexsacar,$lote,
                    $produccion,$usu,$total,$temi,$producto,$totalproduc,$turno,$maquinista);
                }else{
                    $c_produccion = $respuesta;
                }

                $dato = array( 
                    "suc" => $c_produccion,
                    "termi" => $temi    
                ); 
            }else{$dato = array("suc" => $resul);}
            
            echo json_encode($dato,JSON_FORCE_OBJECT);
        }   
       
        static function c_gitemsavance($cantavance,$usu,$prod,$producto,$turno,$maquinista,$tara)
        {
            
            $respuesta = '0'; $c_produccion = '';
            $m_produccion = new m_produccion();
            $cantpaquete = 0;$temi = 0;
            $avance = c_produccion::c_buscaravance($prod);
            
            for ($i=0; $i < count($avance) ; $i++) { 
                 $cantpaquete += $avance[$i][6];                 
            }
            if($avance[0][5] == ($cantpaquete + $cantavance)){
                $temi = 1;
            }
            
             if(strlen(trim($turno)) == 0){$respuesta = "Error seleccione turno";}
             if(strlen(trim($maquinista)) == 0){$respuesta = "Error seleccione maquinista";}

            if(($cantpaquete + $cantavance) > $avance[0][5]){
                $c_produccion = "Error paquetes a sacar es mayor a lo indicado"; $c_produccion = 0;}
            else{
                if($respuesta == '0'){
                   $c_produccion = $m_produccion->m_itemavance($cantavance,$usu,$prod,$temi,$producto,$turno,$maquinista,
                $tara);
                }else{
                    $c_produccion = $respuesta;
                }
            }
            $dato = array( 
                "suc" => $c_produccion,
                "termi" => $temi    
            );
            echo json_encode($dato,JSON_FORCE_OBJECT);
        }

        static function v_avances($produccion){
            $faltante = 0;
            $c_avances = c_produccion::c_buscaravance($produccion);
            if(count($c_avances) > 0){
                for ($i=0; $i < count($c_avances); $i++) { 
                      $faltante += $c_avances[$i][6];     
                }
                $faltante = $c_avances[0][5] - $faltante;
                $dato = array('t' => '1', 'dato' => $c_avances ,'falta' => $faltante);
            }else{
                $dato = array('t' => '0');
            }
            echo json_encode($dato,JSON_FORCE_OBJECT);
        }

        static function c_validarfinrprod($tara,$pesoneto,$cantxbolsa,$paquexsacar,$lote,$total,$turno,$maquinista)
        {
            if(strlen(trim($turno)) == 0){return "Error seleccione turno";}
            if(strlen(trim($maquinista)) == 0){return "Error seleccione maquinista";}
            if(strlen(trim($tara)) == 0){return "Error ingrese tara";}
            if(!is_numeric($tara)){return "Error tara solo numeros";}
            if(strlen(trim($pesoneto)) == 0){return "Error ingrese peso total";}
            if(!is_numeric($pesoneto)){return "Error solo numeros en peso total";}
            if(strlen(trim($pesoneto)) == 0){return "Error ingrese peso total";}
            if(!is_numeric($pesoneto)){return "Error solo numeros en peso total";}
            if($paquexsacar == 0 ){return "Error paquete por sacar no puede ser 0";}
            if($paquexsacar > $total){return "Error los paquetes a sacar no puede ser mayor a lo indicado";}
            return "1";
        }

        static function c_verifinpro($codproduccion,$cantidad,$cantxpa,$total)
        {
            if($cantxpa > $total){print_r("Error la cantidad es mayor a la actual fabricación"); return;}
            if($cantxpa == '0'){print_r("Error cantidad por paquete no puede ser cero"); return;}
            if(strlen(trim($cantxpa)) == 0){print_r("Error ingrese por paquete cantidad"); return;}
            print_r(1);
        }

        static function c_lstavance($produccion)
        {   
            $faltante = 0;$tipo = 0; $dato =''; 
            $c_avance = c_produccion::c_buscaravance($produccion);
            $m_producto = new m_produccion();
            $cadena = "produccion = '$produccion'";
            $c_produccion = $m_producto->m_buscar('V_VIEW_AVANCES',$cadena);
            
            if(count($c_produccion) > 0){
                for ($l=0; $l < count($c_produccion) ; $l++) { 
                    $c_produccion[$l][4] = convFecSistema($c_produccion[$l][4]);
                }
                for ($i=0; $i < count($c_avance); $i++) { 
                    $faltante += $c_avance[$i][6];
                }
                
               
                if($faltante == $c_produccion[0][5]){$tipo = 0;}else{$tipo = 1;}
                $produc = $c_produccion[0][1];
                $cadena2 = "COD_PRODUCCION = '$produc'";
                $c_mermas = $m_producto->m_buscar('V_LISTAR_MERMA',$cadena2);
                for ($i=0; $i < count($c_mermas) ; $i++) { 
                    if($c_mermas[$i][15] != '0'){
                        $c_produccion[0][8] = ($c_produccion[0][8]- $c_mermas[$i][15]);
                    }
                }
                $dato = array('dato' => $c_produccion,'tipo' => $tipo,'id' => $c_produccion[0][0],
                'cantidad' => $faltante ,'succ' => '1','fila' => count($c_produccion));
            }else{
                $dato = array('succ' => '0');
            }
            
            echo json_encode($dato,JSON_FORCE_OBJECT);
        }

        static function c_buscaravance($codproduccion){
            $m_produccion = new m_produccion();
            $consulta = "produccion = '$codproduccion'";
            $c_avance = $m_produccion->m_buscar('V_VIEW_AVANCES',$consulta);
            return $c_avance;
        }


        static function c_actualizar_impresion($avance){
            $m_producto = new m_produccion();
            $c_produccion = $m_producto->m_actualizar_impresion($avance);
            print_r($c_produccion);
        }

        static function c_terminarproduccion($produccion,$usu)
        {   
           $m_produccion = new m_produccion();
           $respuesta = c_produccion::verificartotal($produccion,'f');
           if($respuesta == "0"){
                $c_terminar = $m_produccion->m_finalizarproduccion($produccion,$usu);
                print_r($c_terminar);
           }else{
                print_r($respuesta);
           }
        }

        static function verificartotal($produccion,$tipo)
        {
            $cantidad = 0; $totalxprod = 0; $totalinsumo = 0;
            $m_produccion = new m_produccion();
            $consulta = "COD_PRODUCCION = '$produccion'";
            $itempro = $m_produccion->m_buscar('T_PRODUCCION_ITEM',$consulta);
            for ($i=0; $i <count($itempro) ; $i++) { 
                $insumo = $itempro[$i][1];
                $consulta2 = "COD_PRODUCTO = '$insumo' OR COD_INSUMO = '$insumo'";
                $insumoplas = $m_produccion->m_buscar('T_INSUMOS_PASADAS',$consulta2);
                //print_r($insumo);   
                if(count($insumoplas) > 0){
                    $cantidad += $itempro[$i][2];
                    $consulta2 = "COD_PRODUCCION = '$produccion'"; 
                    $merma = $m_produccion->m_buscar('V_LISTAR_MERMA',$consulta2);
                    if(count($merma) > 0){
                        for ($a=0; $a < count($merma) ; $a++) { 
                            if($merma[$a][15] == 0){
                                $totalxprod = $totalxprod + $merma[$a][13];
                            }
                        }
                    }
                    $consulta3 = "COD_PRODUCCION = '$produccion' AND insumo = '$insumo'"; 
                    $residuos = $m_produccion->m_buscar('V_LISTAR_RESIDUOS',$consulta3);
                    if(count($residuos) > 0){
                        for ($l=0; $l < count($residuos) ; $l++) { 
                            $totalxprod = $totalxprod + $residuos[$l][9];
                        }
                    }

                    $consulta4 = "COD_PRODUCCION = '$produccion'"; 
                    $desecho = $m_produccion->m_buscar('V_LISTAR_DESECHOS',$consulta4);
                    if(count($desecho) > 0){
                        for ($j =0; $j < count($desecho) ; $j++) {
                            $totalxprod = $totalxprod +  $desecho[$j][9];
                        }
                    }
                }
            }

            $consulta4 = "COD_PRODUCCION = '$produccion'"; 
            $produc = $m_produccion->m_buscar('T_PRODUCCION',$consulta4);
            if(count($produc) > 0){
                //cantidad * peso unitario en gramos 
                $totalinsumo = $produc[0][9] * $produc[0][11]; 
                // suma de los insumo usados mas la merma desechos y residuos
                 $totalinsumo = intval($totalinsumo + $totalxprod);
                // se convierte a kilos
                $totalinsumo = $totalinsumo / 1000;
            }   

            $cantidad =  number_format($cantidad,3,'.', ' ');
            $totalinsumo = number_format($totalinsumo,3,'.', ' ');

            if($totalinsumo > $cantidad){ 
                return "El peso total del producto es mayor al peso total de los insumos usados";
            }
           
            if($cantidad > $totalinsumo){ 
                return "El peso total del producto es menor al peso total de los insumos usados";
            }
            return '0';
        }


        static function c_perdida($produccion,$maquinista,$turno){
            $mensaje = 0;
            if(strlen(trim($turno)) == 0){$mensaje = "Error seleccione turno";}
            if(strlen(trim($maquinista)) == 0){$mensaje = "Error seleccione maquinista";}
            $suma = 0;
            if($mensaje == 0){
                $m_produccion = new m_produccion();
                $consulta = "COD_PRODUCCION = '$produccion'";
                $c_avance = $m_produccion->m_buscar('V_LISTAR_MERMA',$consulta);
                if(count($c_avance) > 0){
                    for ($i=0; $i < count($c_avance); $i++) { 
                        $suma += $c_avance[$i][15];
                    }
                }
            }
           
            $fecha = retunrFechaActual();
            $dato = array('e' => $suma ,'fecha' => $fecha,'mensaje' =>$mensaje);
            echo json_encode($dato,JSON_FORCE_OBJECT);
           
        }

        static function c_lstresiduos($tipo,$codproduccion)
        {
            $m_formula = new m_produccion();
            $cadena = "COD_PRODUCCION = '$codproduccion'";

            if($tipo == 'm') $c_formula = $m_formula->m_buscar('V_LISTAR_MERMA',$cadena);
            else if($tipo == 'r')  $c_formula = $m_formula->m_buscar('V_LISTAR_RESIDUOS',$cadena);
            else if($tipo == 'd')  $c_formula = $m_formula->m_buscar('V_LISTAR_DESECHOS',$cadena);
            $dato = array('dato' => $c_formula);
            echo json_encode($dato,JSON_FORCE_OBJECT);
        }

        static function c_actualizar($merma,$observacion,$cantfalla,$txtmdpesAnter,$txtmdpesomodifi
        ,$slcmdtipoAnt,$slcmdtipomodi,$tipo,$usu)
        {
            $m_formula = new m_produccion();
            if($tipo == 'm'){
                $resul =$m_formula->m_actualizarmerma($txtmdpesomodifi,$observacion,$usu,$merma,$txtmdpesAnter,$txtmdpesomodifi,$cantfalla,$slcmdtipoAnt,$slcmdtipomodi);
                print_r($resul);
            }else if($tipo == 'd'){
                $resul =$m_formula->m_actdesechos($txtmdpesomodifi,$observacion,$usu,$merma);
                print_r($resul);
            }else if($tipo == 'r'){
                $resul =$m_formula->m_actresiduos($txtmdpesomodifi,$observacion,$usu,$merma,$txtmdpesAnter,$txtmdpesomodifi);
                print_r($resul);
            }
        }

        static function bloqueox($usu)
        {
            $cons = "''=''"; $arrda = [];
            $fecha = date("Y-m-d");
            $m_produccion = new m_produccion();
            $cadena = "estado = '0' AND Convert(DATE, fec_inicio) <= '$fecha' AND detenido = '0'";
            $control = $m_produccion->m_buscar('V_CONTROL_CALIDAD',$cadena);
            if(count($control) > 0){
                $codprod = $control[0][0];
                $cadn = "COD_PRODUCCION ='$codprod' AND PRODU_DETENIDO = '1'";
                $ocur = $m_produccion->m_buscar('T_OCURRENCIAS',$cadn);
                if(Count($ocur) == 0){
                    $horas = $m_produccion->m_buscar("T_HRA_CONTROL",$cons);
                    if(count($control) > 0){
                        $dir = diferenciaFechas($control[0][4],$fecha);
                        for ($i=0; $i <= $dir ; $i++) {
                           $f = restarfecha($fecha,$i); 
                           if($f != ""){
                                for ($l=0; $l <count($horas); $l++) { 
                                    $exh = explode(":",$control[0][5]);
                                    $exh2 = explode(":", $horas[$l][1]);
                                    $hora = $horas[$l][1];
                                    $fecpro1 = retunrFechaSql($f);
                                    $fecact = retunrFechaSqlphp($fecha);
                                    $fecact1 = retunrFechaSqlphp($control[0][4]);
                                   if($fecpro1 == $fecact1){
                                        $horac = explode(":", date('H'));
                                        if($exh2[0] >= $exh[0]){
                                            if($horac[0] > $exh2[0]  && $fecact == $fecact1){
                                                $consul = "FEC_REGISTRO = '$f' AND HORA_CONTROL = '$hora'";
                                                $g = $m_produccion->m_buscar('V_HRA_CONTROL',$consul);
                                                if(count($g) == 0){
                                                    array_push($arrda,array($f,$hora));
                                                }
                                            }else if($fecact != $fecact1){
                                                $consul = "FEC_REGISTRO = '$f' AND HORA_CONTROL = '$hora'";
                                                $g = $m_produccion->m_buscar('V_HRA_CONTROL',$consul);
                                                if(count($g) == 0){
                                                    array_push($arrda,array($f,$hora));
                                                }
                                            }
                                        }
                                    }else if($fecpro1 != $fecact1){
                                        $consul = "FEC_REGISTRO = '$f' AND HORA_CONTROL = '$hora'";
                                        $g = $m_produccion->m_buscar('V_HRA_CONTROL',$consul);
                                        if(count($g) == 0){
                                            if($fecpro1 == $fecact && $hora > date('H')){
                                               // array_push($arrda,array($f , $hora));
                                            }else{
                                                array_push($arrda,array($f,$hora));
                                            }
                                        }
                                    }
                                }
                           }
                        }
                    }
                    $clav = (!isset($_COOKIE['clave'])) ? "": $_COOKIE['clave'];
                    $datos = array(
                        "blo" => $arrda,
                        "c" => count($arrda),
                        "cl" => $clav
                    );
                   echo json_encode($datos,JSON_FORCE_OBJECT);
                }else{
                    echo json_encode("",JSON_FORCE_OBJECT);
                }
            }else{
                echo json_encode("",JSON_FORCE_OBJECT);
            }
        }

        static function c_controlcalidad()
        {
            $horacom = date('H').':00';
            $fecha = date("Y-m-d");
            $m_produccion = new m_produccion();
            $cadena = "estado = '0' AND Convert(DATE, fec_inicio) <= '$fecha'";
            $control = $m_produccion->m_buscar('V_CONTROL_CALIDAD',$cadena);
            $caden = "HORA_CONTROL='$horacom'";
            $hora = $m_produccion->m_buscar('T_HRA_CONTROL',$caden);
            $feactu = retunrFechaSqlphp($fecha);
            if(count($control) > 0){
                $feinici = retunrFechaSqlphp($control[0][4]);
                $horini = explode(':',$control[0][5]);
                $hora2 = explode(':',$hora[0][1]);
               if($feactu == $feinici){
                    //si la fecha es igual buscar la hora que estamos y sumarle los minutos de la hora de registro;
                    if($hora2[0] == "14"){
                        $ho = date('H:i', strtotime($hora[0][1] .'+ 1 hours +'.$horini[1] .'minutes'));
                        $hm = date('H:i', strtotime($ho.'+ 0 hours - 20 minutes'));
                        $hd = date('H:i', strtotime($hora[0][1] .'+ 1 hours + 20 minutes'));
                    }else{
                        $ho = date('H:i', strtotime($hora[0][1] .'+ 0 hours +'.$horini[1] .'minutes'));
                        $hm = date('H:i', strtotime($ho.'+ 1 hours - 20 minutes'));
                        $hd = date('H:i', strtotime($hora[0][1] .'+ 0 hours + 20 minutes'));
                    }
                   
                }else if($feactu > $feinici){
                   //si la fecha es mayor buscar la hora en la que estamos y sumar 40 minutos
                    if($hora2[0] == "14"){
                        $ho = date('H:i', strtotime($hora[0][1] .'+ 1 hours + 00 minutes'));
                        $hm = date('H:i', strtotime($hora[0][1] .'+ 0 hours + 40 minutes'));
                        $hd = date('H:i', strtotime($hora[0][1] .'+ 1 hours + 20 minutes'));
                    }else{
                        $ho = date('H:i', strtotime($hora[0][1] .'+ 1 hours + 00 minutes'));
                        $hm = date('H:i', strtotime($hora[0][1] .'+ 0 hours + 40 minutes'));
                        $hd = date('H:i', strtotime($hora[0][1] .'+ 0 hours + 20 minutes'));
                    }
                   
               }
               $dato = array(
                "d" => $control,
                "h" => $ho,
                "hm" => $hm,
                "hd" => $hd
               ); 
            }else{
                $dato = array(
                    "hm" => "",
                   ); 
            }
           echo json_encode($dato,JSON_FORCE_OBJECT);
        }

        static function c_gcontrol($color,$pureza,$rebaba,$peso,$observacion,$establidad,$usu,$tcalid,
        $txtpro,$txtprodu){
            $m_produccion = new m_produccion();
            if($tcalid == 'i'){
                if(strlen(trim($color)) == 0){ print_r("Error ingrese color"); return;}
                if(strlen(trim($pureza)) == 0){ print_r("Error ingrese pureza"); return;}
               $c_control = $m_produccion->m_controlInyeccion($color,$pureza,$rebaba,$usu,
               $txtpro,$txtprodu);
               print_r($c_control);
            }else if($tcalid == 's'){
               if(strlen(trim($color)) == 0){ print_r("Error ingrese color"); return;}
               if(strlen(trim($peso)) == 0){ print_r("Error ingrese peso"); return;}
               if(strlen(trim($observacion)) == 0){ print_r("Error ingreser una observación"); return;}
               if(strlen($observacion) > 100){print_r("Error observacion solo 100 caracteres");return;}
               $c_control = $m_produccion->m_controlSoplado($color,$peso,$establidad,$observacion,$usu,
               $txtpro,$txtprodu);
               print_r($c_control);
            }
        }

        static function c_bloqueo(){
            $m_produccion = new m_produccion();
            $c_bloque = $m_produccion->m_bloqueo();
            print_r($c_bloque);
        }

        static function c_desbloqueo($coddesbloqu){
            $m_produccion = new m_produccion();
            $c_bloque = $m_produccion->m_desbloque($coddesbloqu);
            print_r($c_bloque);
        }
    }
?>