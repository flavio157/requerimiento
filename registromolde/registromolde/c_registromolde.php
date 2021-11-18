<?php
    require_once("m_registromolde.php");
    require_once("../funciones/f_funcion.php");
    $accion = $_POST['accion'];
    if($accion == 'buscar'){
        c_registrarmolde::c_listarproductos();
    }else if($accion == 'guarmaterial'){
        $nombre = $_POST['txtnommolde'];
        $medida = $_POST['txtmedmolde'];
        $estado = $_POST['slcestado'];
        $usuario = $_POST['usuario'];
        $productos =json_decode($_POST['material']);
        c_registrarmolde::c_guardar($nombre,$medida,$estado,$productos,$usuario);
    }else if($accion == 'lstmolde'){
        c_registrarmolde::c_listarmoldes();
    }else if($accion == 'buscarmolde'){
        $idmolde = $_POST['molde'];
        c_registrarmolde::c_buscarmoldes($idmolde);
    }else if($accion == 'actmaterial'){
        $idmolde = $_POST['molde'];
        $codmaterial = $_POST['material'];
        $cantidad = $_POST['cantidad'];
        $usuario = $_POST['usuario'];
        c_registrarmolde::c_actualizarmoldemateriales($idmolde,$codmaterial,$cantidad,$usuario);
    }else if($accion == 'verimaterial'){
        $material = $_POST['material'];
        $nombre = $_POST['nombre'];
        $cantidad = $_POST['cantidad'];
        $unidad = $_POST['unidad'];
        $medidamaterial = $_POST['medidamat'];
        c_registrarmolde::c_verificamaterial($material,$nombre,$cantidad,$unidad,$medidamaterial);
    }else if($accion == 'elimimaterial'){
        $material = $_POST['material'];
        $idmolde = $_POST['molde'];
        c_registrarmolde::c_eliminarmaterial($idmolde,$material);
    }else if($accion == 'actualmater'){
        $idmolde = $_POST['txtcodmolde'];
        $nombre = $_POST['txtnommolde'];
        $medida = $_POST['txtmedmolde'];
        $estado = $_POST['slcestado'];
        $usuario = $_POST['usuario'];
       
        $productos =json_decode($_POST['material']);
        c_registrarmolde::c_actualizarmolde($idmolde,$nombre,$medida,$estado,$productos,$usuario);
    }

    class c_registrarmolde
    {
        static function c_guardar($nombre,$medida,$estado,$productos,$usuario)
        {
           if(strlen($nombre) == 0){print_r("Error ingrese nombre del molde"); return;} 
           if(strlen($nombre) < 5){print_r("Error nombre del molde minimo 5 caracteres"); return;}
           if(strlen($nombre) > 100){print_r("Error nombre del molde sobrepaso limite de 100 caracteres"); return;}
           if(strlen($medida) == 0){print_r("Error ingrese medidas del molde"); return;}  
           if(strlen($medida) > 50){print_r("Error campo medida sobrepaso el limite de 50 caracteres"); return;}  
           if(count($productos->tds)==0){print_r("Error ingrese productos"); return;}
           $m_molde = new m_registrarmolde();
           $c_molde = $m_molde->m_guardar(strtoupper($nombre),$medida,$estado,$productos,$usuario);
           print_r($c_molde);
        }

        static function c_listarproductos(){
            $producto = array();
            $m_producto = new m_registrarmolde();
            $cadena = "EST_PRODUCTO = '1'";
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

        static function c_listarmoldes(){
            $producto = array();
            $m_producto = new m_registrarmolde();
            $c_moldes = $m_producto->m_lstmoldes();
            for ($i=0; $i < count($c_moldes) ; $i++) { 
                array_push($producto,array(
                    "code" => $c_moldes[$i][0],
                    "label" => $c_moldes[$i][1],
                    "medi" => $c_moldes[$i][2]));
            }
            $dato = array(
                'dato' => $producto
            );
            echo json_encode($dato,JSON_FORCE_OBJECT);
        }

        static function c_buscarmoldes($idmolde){
            $m_producto = new m_registrarmolde();
            $cadena = "molde = '$idmolde'";
            $c_moldes = $m_producto->m_buscar("V_BUSCARMOLDE",$cadena);
            $dato = array(
                'dato' => $c_moldes
            );
            echo json_encode($dato,JSON_FORCE_OBJECT);
        }


        static function c_actualizarmoldemateriales($idmolde,$codmaterial,$cantidad,$usuario)
        {
            $m_molde = new m_registrarmolde();
            $c_molde = $m_molde->m_actualizarmoldemateriales($idmolde,$codmaterial,$cantidad,$usuario);
            print_r(1);
        }
        
        static function c_verificamaterial($material,$nombre,$cantidad,$unidad,$medidamaterial){
          
            if(strlen($material) == 0){print_r("Error material invalido"); return;}
            if(strlen($nombre) == 0){print_r("Error ingrese nombre del material"); return;}
            if(strlen($unidad) > 10){print_r("Error campo unidad medida maximo 10 caracteres");return;}
            if(strlen($cantidad) == 0){print_r("Error ingrese cantidad"); return;}
            if(strlen(str_replace('.','', $cantidad)) > 7){print_r("Error campo cantidad, maximo 7 digitos");return;}
            if(strlen($medidamaterial) > 30){print_r("Error campo medida material maximo 30 caracteres");return;} 
            $m_producto = new m_registrarmolde();
            $cadena = "EST_PRODUCTO = '1'";
            $c_producto = $m_producto->m_buscar('T_PRODUCTO',$cadena);
            if(count($c_producto) > 0){ print_r(1); return;}
            else{
                print_r("Error material invalido");
            }
        }

        static function c_eliminarmaterial($idmolde,$material)
        {   
            $m_material = new m_registrarmolde();
            $c_material =$m_material->m_eliminarmolde($idmolde,$material);
            print_r($c_material);
        }  
        
        static function c_actualizarmolde($idmolde,$nombre,$medida,$estado,$productos,$usuario)
        {
            if(strlen($nombre) == 0){print_r("Error ingrese nombre del molde"); return;} 
            if(strlen($nombre) < 5){print_r("Error nombre del molde minimo 5 caracteres"); return;}
            if(strlen($nombre) > 100){print_r("Error nombre del molde sobrepaso limite de 100 caracteres"); return;}
            if(strlen($medida) == 0){print_r("Error ingrese medidas del molde"); return;}  
            if(strlen($medida) > 50){print_r("Error campo medida sobrepaso el limite de 50 caracteres"); return;}  
            if(count($productos->tds)==0){print_r("Error ingrese productos"); return;}
            $m_material = new m_registrarmolde(); 
            $c_producto = $m_material->m_actualizamolde($idmolde,$nombre,$medida,$estado,$productos,$usuario);
            print_r($c_producto);
        }

        /*validar el numero del campo medida material y cantidad */
    }
?>