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
    }else if($accion == 'materialxmolde'){
        $idmolde = $_POST['molde'];
        c_registrarmolde::c_listarmateriales($idmolde);
    }else if($accion == 'buscarmolde'){
        c_registrarmolde::c_buscarmoldes();
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
        c_registrarmolde::c_verificamaterial($material,$nombre,$cantidad,$unidad);
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
    }else if($accion == 'lstmaterilas'){
        c_registrarmolde::c_lstmaterial();
    }

    class c_registrarmolde
    {
        static function c_guardar($nombre,$medida,$estado,$productos,$usuario)
        {  
           //$sincarecter = "/^[a-zA-Z0-9\^-']+$/";
           $vali = "/[0-9\^-]+(a|c|m|x|h|l)+$/"; 
           //$vali = "/^[a-zA-Z0-9\^-]+$/";
           if(strlen($nombre) == 0){print_r("Error ingrese nombre del molde"); return;} 
           if(strlen($nombre) < 5){print_r("Error nombre del molde minimo 5 caracteres"); return;}
           if(strlen($nombre) > 100){print_r("Error nombre del molde sobrepaso limite de 100 caracteres"); return;}
           if(strlen($medida) == 0){print_r("Error ingrese medidas del molde"); return;}  
           if(strlen($medida) > 50){print_r("Error campo medida sobrepaso el limite de 50 caracteres"); return;}
           if(preg_match($vali,$medida) == 0){print_r("Error campo medida del molde tiene formato incorrecto "); return;}
           if(count($productos->tds)==0){print_r("Error ingrese productos"); return;}
           $m_molde = new m_registrarmolde();
           $cadena = "NOM_MOLDE = '$nombre' and MEDIDAS = '$medida'";
           $c_buscar = $m_molde->m_buscar('T_MOLDE',$cadena);
           if(count($c_buscar)>0){
                print_r("Error ya existe un molde con el mismo nombre y medidas");
                return;
            }
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

        static function c_listarmateriales($idmolde){
            $m_producto = new m_registrarmolde();
            $dato = "molde = '$idmolde'";
            $c_material = $m_producto->m_buscar('V_MATERIALES_MOLDE',$dato);
            $dato = array(
                'dato' => $c_material
            );
            echo json_encode($dato,JSON_FORCE_OBJECT);
        }

        static function c_buscarmoldes(){
            $m_producto = new m_registrarmolde();
            $c_moldes = $m_producto->m_lstmoldes();
            $dato = array(
                'dato' => $c_moldes
            );
            echo json_encode($dato,JSON_FORCE_OBJECT);
        }


        static function c_actualizarmoldemateriales($idmolde,$codmaterial,$cantidad,$usuario)
        {
            $cant = explode(".", $cantidad);
            if(strlen($cant[0]) > 4){print_r("Error campo cantidad, maximo 4 digitos con 3 decimales");return;}
            $m_molde = new m_registrarmolde();
            $c_molde = $m_molde->m_actualizarmoldemateriales($idmolde,$codmaterial,$cantidad,$usuario);
            print_r(1);
        }
        
        static function c_verificamaterial($material,$nombre,$cantidad,$unidad){
            
            if(strlen($material) == 0){print_r("Error material invalido"); return;}
            if(strlen($nombre) == 0){print_r("Error ingrese nombre del material"); return;}
            if(strlen($unidad) > 10){print_r("Error campo unidad medida maximo 10 caracteres");return;}
            if(strlen($cantidad) == 0){print_r("Error ingrese cantidad por usar"); return;}
            
            $cant = explode(".", $cantidad);
            if(strlen($cant[0]) > 4){print_r("Error campo cantidad por usar, maximo 4 digitos con 3 decimales");return;}

           
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
            $vali = "/[0-9\^-]+(a|c|m|x|h|l)+$/"; 
            // $vali = "/^[a-zA-Z0-9\^-]+$/";
            if(strlen($nombre) == 0){print_r("Error ingrese nombre del molde"); return;} 
            if(strlen($nombre) < 5){print_r("Error nombre del molde minimo 5 caracteres"); return;}
            if(strlen($nombre) > 100){print_r("Error nombre del molde sobrepaso limite de 100 caracteres"); return;}
            if(strlen($medida) == 0){print_r("Error ingrese medidas del molde"); return;}  
            if(strlen($medida) > 50){print_r("Error campo medida sobrepaso el limite de 50 caracteres"); return;}  
                     
            if(preg_match($vali,$medida) == 0){print_r("Error campo medida del molde tiene formato incorrecto "); return;}
            
            if(count($productos->tds)==0){print_r("Error ingrese productos"); return;}
            $m_material = new m_registrarmolde(); 
            $c_producto = $m_material->m_actualizamolde($idmolde,$nombre,$medida,$estado,$productos,$usuario);
            print_r($c_producto);
        }

        static function c_lstmaterial(){
            $m_producto = new m_registrarmolde();
            $cadena = "EST_PRODUCTO = '1'";
            $c_producto = $m_producto->m_buscar('V_BUSCAR_MATERIALES',$cadena);
            $dato = array(
                'dato' => $c_producto
            );
            echo json_encode($dato,JSON_FORCE_OBJECT);
        }
    }
?>