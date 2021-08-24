<?php
    require_once("M_ListarCiudades.php");


    
    $accion = $_POST['accion'];
    $oficina = $_POST['oficina'];

    if($accion == "provincia"){
        C_ListarCiudades::Listar_Provincia($oficina);
    }else if ($accion == "distrito"){
        $provincia = $_POST['provincia'];
        C_ListarCiudades::Listar_Distrito($provincia,$oficina);
    }else if($accion == "Bcliente"){
        $identificacion = $_POST['identificaion'];
        C_ListarCiudades::BuscarCLiente($identificacion,$oficina);
    }



    
    class C_ListarCiudades
    {
      
        static function Listar_Provincia($oficina){
            $M_listarProvincia = new M_ListarCiudades($oficina);
            $C_codProvincia = $M_listarProvincia->M_Provincia();
            if($C_codProvincia > 0){
                $provincia="";
                foreach ($C_codProvincia as $descripcion){
                    $provincia .= '<option  value="'.$descripcion['COD_PROVINCIA'].'">' . $descripcion['DES_PROVINCIA']  . '</option>';
                }
                echo $provincia;  
            }
        } 

    

        static function Listar_Distrito($Provincia,$oficina){
            $M_listarDistrito = new M_ListarCiudades($oficina);
            $C_codDistrito = $M_listarDistrito->M_Distrito($Provincia);
           if($C_codDistrito > 0){
                $Distrito="";
                foreach ($C_codDistrito as $descripcion){
                    $Distrito .='<option  value="'.$descripcion['COD_DISTRITO'].'">' . $descripcion['DES_DISTRITO']  . '</option>';
                }
              echo $Distrito;   
            }
        }

        static function BuscarCLiente($identificacion,$oficina){
            $M_listarDistrito = new M_ListarCiudades($oficina);
            $c_cliente = $M_listarDistrito->M_BuscarCLiente($identificacion);
            echo json_encode($c_cliente,JSON_FORCE_OBJECT);
      
            
        }
    }

?>