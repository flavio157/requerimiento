<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once("m_formulacion.php");

    $accion = $_POST['accion'];
    if($accion == 'buscarxnombre'){
       c_formulacion::c_buscarxprod();     
    }else if($accion == 'insumo'){
        c_formulacion::c_buscarxinsumo();
    }else if($accion == 'prod'){
        $cod =  $_POST['cod'];
        $nom = $_POST['nom'];
        $cantxusar = $_POST['cantxusar'];
        $usu = $_POST['usu'];
       
        c_formulacion::c_productoexterno($cod,$nom,$cantxusar,$usu);
    }else if($accion == 'guardarform'){ //agregar tipo de material si el material cambia de cantidad o no
        $nomfor = $_POST['txtnombformula'];
        $nomproducto = $_POST['txtproducto'];
        $codproducto =$_POST['codpro']; 
        $cantxformula = $_POST['txtformulacion'];
        $unidamedida = $_POST['txtunimedida'];
        $idmolde = $_POST['txtidmolde'];
        $manana = $_POST['txtmanana'];
        $tarde = $_POST['txttarde'];
        $items =json_decode($_POST['items']);
        $usu = $_POST['usu'];
        c_formulacion::c_guardarformula($nomfor,$codproducto,$cantxformula
        ,$unidamedida,$items,$usu,$nomproducto,$idmolde,$manana,$tarde);   
    }else if($accion == 'lstformula'){
        c_formulacion::c_lstformulas();
    }else if($accion == 'lstitemformula'){
        $codformula = $_POST['for'];
        c_formulacion::c_itemsformula($codformula);
    }else if($accion == 'additems'){
        $codformula = $_POST['form'];
        $codpro = $_POST['cod'];
        $cant = $_POST['cantxusar'];
        $usu = $_POST['usu'];
        $items =json_decode($_POST['items']);
        $idprod = $_POST['idpro'];
        c_formulacion::c_additems($codformula,$codpro,$cant,$usu,$idprod,$items);
    }else if($accion == 'updateitems'){
        $codform = $_POST['form'];
        $codprod = $_POST['cod'];
        $cant = $_POST['cantxusar'];
        $usu = $_POST['usu'];
       c_formulacion::c_actualizar_items($codform,$codprod,$cant,$usu);
    }else if($accion == 'delete'){
        $codform = $_POST['form'];
        $codprod = $_POST['cod'];
        c_formulacion::c_deletemate($codform,$codprod);
    }else if($accion == 'updateform'){
        $codform = $_POST['formu'];
        $nombre = $_POST['nomb'];
        $codprod = $_POST['cod'];
        $uni = $_POST['uni'];
        $canformula = $_POST['cantfor'];
        $usumodi = $_POST['usu'];
        $produ = $_POST['produ'];
        $molde = $_POST['molde'];
        $manana = $_POST['manana'];
        $tarde = $_POST['tarde'];
        c_formulacion::c_actualizarform($codform,$nombre,$codprod,$uni,$canformula,$usumodi,$produ,$molde,
        $manana,$tarde);
    }else if($accion == 'buscarxmolde'){
        c_formulacion::c_buscarxmolde();     
    }else if($accion == 'guardarmolde'){
        $nombre = $_POST['molde'];
        $medidas = $_POST['medidas'];
        $usu = $_POST['usu'];
        c_formulacion::c_guardarmolde($nombre,$medidas,$usu);     
    }

    class c_formulacion
    {



        static function c_buscarxmolde()
        {
            $producto = array();
            $m_producto = new m_formulacion();
            $cadena = "ESTADO = '1' AND TIPO_MOLDE = 'P'";
            $c_molde = $m_producto->m_buscar('T_MOLDE',$cadena);
            for ($i=0; $i < count($c_molde) ; $i++) { 
                array_push($producto,array(
                    "code" => $c_molde[$i][0],
                    "label" => trim($c_molde[$i][1])));
            }
            $dato = array(
                'dato' => $producto
            );
            echo json_encode($dato,JSON_FORCE_OBJECT);
        }


        static function c_buscarxprod()
        {
            $producto = array();
            $m_producto = new m_formulacion();
            $cadena = "EST_PRODUCTO = '1' AND COD_CATEGORIA = '00002'";
            $c_producto = $m_producto->m_buscar('T_PRODUCTO',$cadena);
            for ($i=0; $i < count($c_producto) ; $i++) { 
                array_push($producto,array(
                    "code" => $c_producto[$i][0],
                    "label" => trim($c_producto[$i][2]),
                    "uni" => $c_producto[$i][3]));
            }
            $dato = array(
                'dato' => $producto
            );
            echo json_encode($dato,JSON_FORCE_OBJECT);
        }

        static function c_buscarxinsumo()
        {
            $producto = array();
            $m_producto = new m_formulacion();
            $cadena = "EST_PRODUCTO = '1' AND COD_CATEGORIA = '00001'";
            $c_producto = $m_producto->m_buscar('T_PRODUCTO',$cadena);
            for ($i=0; $i < count($c_producto) ; $i++) { 
                array_push($producto,array(
                    "code" => $c_producto[$i][0],
                    "label" => $c_producto[$i][2],
                    "uni" => $c_producto[$i][3]));
            }
            $dato = array(
                'dato' => $producto
            );
            echo json_encode($dato,JSON_FORCE_OBJECT);
        }

        static function c_productoexterno($cod,$nom,$cantxusar,$usu)
        {  
            $dato = '';
            $resut = c_formulacion::c_verificamateri($cod,$nom,$cantxusar);
            if($resut == ''){
                $dato = array('dato' => 1,'cod' => $cod);
            }else{
                $dato = array('dato' => 0,'cod' => $resut);
            }
            echo json_encode($dato,JSON_FORCE_OBJECT);
        }

        static function c_verificamateri($cod,$nombre,$cantxusar)
        {
            $c_guarmolde = '';
            $cantidad = "/^[0-9\.]+$/";
            if(strlen($cod) == 0){$c_guarmolde = "Error no selecciono el insumo"; return $c_guarmolde;}
            if(strlen(trim($nombre)) == 0){$c_guarmolde = "Error seleccione nombre del insumo"; return $c_guarmolde;}
            if(strlen($cantxusar) == 0){$c_guarmolde = "Error cantidad del insumo es invalido"; return $c_guarmolde;}
            $decimal = explode(".", $cantxusar);
            if($cantxusar == 0){$c_guarmolde = "Error campo cantidad del insumo no puede ser 0";return $c_guarmolde;}
            if(strlen($decimal[0]) > 4){$c_guarmolde = "Error campo cantidad del insumo, maximo 6 digitos";return $c_guarmolde;}
            if(preg_match($cantidad,$cantxusar) == 0){$c_guarmolde = "Error solo numeros en cantidad del insumo"; return $c_guarmolde;}
            return  $c_guarmolde;
        }

        static function c_lstformulas()
        {
            $m_producto = new m_formulacion();
            $c_producto = $m_producto->m_buscarformulacion();
            $dato = array(
                'dato' => $c_producto
            );
            echo json_encode($dato,JSON_FORCE_OBJECT);
        }

        static function c_itemsformula($formula)
        {
            $m_formula = new m_formulacion();
            $cadena = "formula = '$formula'";
            $c_formula = $m_formula->m_buscar('V_ITEMS_FORMULACION',$cadena);
            $dato = array(
                'dato' => $c_formula
            );
            echo json_encode($dato,JSON_FORCE_OBJECT);
        }

        static function c_additems($codform,$codprod,$cant,$usu,$idprod,$items)
        {   
            $dato = '';
            $mensaje = '';
            $igual = c_formulacion::c_comparaform($idprod,$items);
            if($igual == "1"){$mensaje = "Error ya existe una formula con los mismo insumos";}
            $m_formula = new m_formulacion();
            if($cant == '0'){$mensaje = "Error cantidad del insumo no puede ser 0";}
            if(strlen(trim($cant)) == 0){$mensaje = "Error ingrese cantidad para el insumo";}
            if(strlen(trim($codprod)) == 0){$mensaje = "Error seleccione insumo";}
            if($mensaje == ''){
                $c_additems = $m_formula->m_additems($codform,$codprod,$cant,$usu);
                $dato = array('dato' => $c_additems,);
            }else{
                $dato = array('dato' => $mensaje);
            }
            echo json_encode($dato,JSON_FORCE_OBJECT);
        }


        static function c_guardarformula($nomfor,$codproducto,$cantxformula
        ,$unidamedida,$items,$usu,$nomproducto,$idmolde,$manana,$tarde)
        {   
              
             $m_formula = new m_formulacion();
             if(is_numeric($nomfor)){print_r("Error nombre de la formula no puede ser solo numeros");return;} 
             if(count(count_chars($nomfor, 1)) < 4){print_r("Error nombre de la formula es invalido");return;}
             if(strlen(trim($nomfor)) == 0){print_r("Error ingrese nombre de la formulacion"); return;}
             if(strlen(trim($idmolde)) == 0){print_r("Error seleccione molde"); return;}
             if(strlen(trim($codproducto)) == 0){print_r("Error no selecciono el producto"); return;}
             if(strlen(trim($nomproducto)) == 0){print_r("Error seleccione nombre del producto"); return;}
             if(strlen(trim($cantxformula)) == 0){print_r("Error ingrese cantidad de la formula"); return;}
             if(!is_numeric($cantxformula)){print_r("Error cantidad de la formula solo numeros"); return;}
             
             if(strlen(trim($manana)) == 0){print_r("Error ingrese produccion estimada para el turno mañana"); return;}
             if(strlen(trim($tarde)) == 0){print_r("Error ingrese produccion estimada para el turno tarde"); return;}
             if(!is_numeric($manana)){print_r("Error produccion estima por turno solo numeros"); return;}
             if(!is_numeric($tarde)){print_r("Error produccion estima por turno solo numeros"); return;}
             if($manana == 0 && $tarde == 0) {print_r("Error produccion estima no puede ser cero"); return;}
             $suma = Intval($manana + $tarde);
             if($suma > $cantxformula){
              print_r("Error la produccion estimada no puede ser mayor a lo produccion"); return;
             }
             $decimal = explode(".", $cantxformula);
             if(strlen($decimal[0]) > 5){print_r("Error cantidad de la formula, maximo 5 digitos");return;}
             if($cantxformula == 0){print_r("Error cantidad de la formula no puede ser 0"); return;}
             if(count($items->tds)==0){print_r("Error ingrese material"); return;}
             $igual = c_formulacion::c_comparaform($codproducto,$items);
            
             if($igual == "1"){print_r("Error ya existe una formulacion del producto con los mismo insumos"); return;}
            // $buscar = c_formulacion::c_verinombformula('',$nomfor,0);
            // if(count($buscar) == 0){
                $c_formulacion = $m_formula->m_guardarformulacion(strtoupper($nomfor),$codproducto,$cantxformula
                ,$unidamedida,$items,$usu,$idmolde,$manana,$tarde);
                print_r($c_formulacion);     
             /*}else{
                 print_r("Error ya existe una formula para el producto");return;
             }*/
        }

        static function c_actualizar_items($codform,$codprod,$cant,$usu)
        {
            if(strlen(trim($cant)) == 0){print_r("Error ingrese cantidad del insumo");return;}
            if($cant == 0){print_r("Error cantidad del insumo no puede se 0");return;}
            $m_formula = new m_formulacion();
            $c_actualizar = $m_formula->m_modificar_items($codform,$codprod,$cant,$usu);
            print_r($c_actualizar);
        }

        static function c_deletemate($codform,$codpro){
            $m_formula = new m_formulacion();
            $c_actualizar = $m_formula->m_deletemate($codform,$codpro);
            print_r($c_actualizar);
        }

        static function c_actualizarform($codform,$nombre,$codprod,$uni,$canformula,$usumodi,$produ,$molde,
        $manana,$tarde)
        {
           if(is_numeric($nombre)){print_r("Error nombre de la formula no puede ser solo numeros");return;} 
           if(count(count_chars($nombre, 1)) < 4){print_r("Error nombre de la formula es invalido");return;}
           if(strlen(trim($nombre)) == 0){print_r("Error ingrese nombre de la formula"); return;}
           if(strlen(trim($molde)) == 0){print_r("Error seleccione molde"); return;}
           if(strlen(trim($codprod)) == 0){print_r("Error ingrese producto de la formula"); return;}
           if(strlen(trim($produ)) == 0){print_r("Error seleccione nombre del producto"); return;}
           if(strlen(trim($canformula)) == 0){print_r("Error ingrese cantidad para la formula"); return;}
           if(!is_numeric($canformula)){print_r("Error cantidad de la formula solo numeros"); return;}
           
            
           if(strlen(trim($manana)) == 0){print_r("Error ingrese produccion estimada para el turno mañana"); return;}
           if(strlen(trim($tarde)) == 0){print_r("Error ingrese produccion estimada para el turno tarde"); return;}
           if(!is_numeric($manana)){print_r("Error produccion estima por turno solo numeros"); return;}
           if(!is_numeric($tarde)){print_r("Error produccion estima por turno solo numeros"); return;}
           if($manana == 0 && $tarde == 0) {print_r("Error produccion estima no puede ser cero"); return;}
           
           $suma = Intval($manana + $tarde);
           if($suma > $canformula){
            print_r("Error la produccion estimada por turno no puede ser mayor a lo produccion total"); return;
           }

           $decimal = explode(".", $canformula);
           if(strlen($decimal[0]) > 5){print_r("Error cantidad de la formula, maximo 5 digitos");return;}
           if($canformula == 0){print_r("Error cantidad de la formula no puede ser 0"); return;}
           //$buscar = c_formulacion::c_verinombformula($codform,$nombre,1);
           //if(count($buscar) == 0){
                $m_formula = new m_formulacion();
                $c_actualizar = $m_formula->m_modificar_formu($codform,strtoupper($nombre),$codprod,$uni,
                $canformula,$usumodi,$molde,$manana,$tarde);
                print_r($c_actualizar);
           /*}else{
            print_r("Error ya existe una formula con el mismo nombre");return;
           }*/
        }

        static function c_verinombformula($codform,$nombreformu,$tipo)
        {
            $m_formula = new m_formulacion();
            if($tipo == 1){
            $string = "REPLACE(NOM_FORMULACION,' ','')   = REPLACE('$nombreformu',' ','') AND 
            COD_FORMULACION <> '$codform'";}
            else{
                $string = "REPLACE(NOM_FORMULACION,' ','')   = REPLACE('$nombreformu',' ','')";
            };
            $buscar = $m_formula->m_buscar('T_FORMULACION',$string);
            return $buscar;
        }

        static function c_guardarmolde($nombre,$medidas,$usu)
        {
            $mensaje = '';
            $m_formula = new m_formulacion();
            if(strlen(trim($nombre)) == 0){$mensaje = "Error ingrese nombre del molde";}
            if(strlen(trim($medidas)) == 0){$mensaje = "Error ingrese medidas del molde";}
            if(strlen(trim($mensaje)) == 0){
                $c_actualizar = $m_formula->m_guardarmolde(strtoupper($nombre),$medidas,$usu);
                $datos = array(
                    "succ" => $c_actualizar[0], "molde" => $c_actualizar[1]
                );
            }else{
                $datos = array("succ" => $mensaje,);
            }
            echo json_encode($datos,JSON_FORCE_OBJECT);
        }

        static function c_comparaform($idproducto,$items){
            $cont = 0;
            $m_producto = new m_formulacion();
            $cadena = "COD_PRODUCTO = '$idproducto'";
            $c_molde = $m_producto->m_buscar('T_FORMULACION',$cadena);
            for ($i=0; $i < count($c_molde); $i++) { 
                $idfor = $c_molde[$i][0];
                if(count($c_molde) > 0){
                    foreach ($items->tds as $dato){
                        $cadena = "COD_FORMULACION = '$idfor'";
                        $insumos = $m_producto->m_buscar('T_FORMULACION_ITEM',$cadena);
                        for($i=0; $i < count($insumos); $i++) { 
                           if($insumos[$i][1] == $dato[0]){
                                $cont++;   
                           }  
                        }
                    }
                   
                    if(count($items->tds) == $cont)
                    {return "1";} else {return "0";}
                } 
            }
            return '0';
        }
    }




?>