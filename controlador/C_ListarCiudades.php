<?php
    require_once("../modelo/M_ListarCiudades.php");
    

    
    $accion = isset($_POST['accion']);
 
    if($accion == "provincia"){
        C_ListarCiudades::Listar_Provincia();
    }else{
        $departamento = $_POST['departamento'];
        $provincia = $_POST['provincia'];
        $distrito = $_POST['distrito'];
        C_ListarCiudades::Listar_Distrito($departamento,$provincia);
    }



    
    class C_ListarCiudades
    {
        static function Listar_Provincia(){
            $bd="SMP2";
            $M_listarProvincia = new M_ListarCiudades($bd);
            $C_codProvincia = $M_listarProvincia->M_Provincia();
           
            if($C_codProvincia > 0){
                $provincia="";
                
                foreach ($C_codProvincia as $descripcion){
                    $provincia = $provincia . '<option  value="'.$descripcion['COD_PROVINCIA'].'">' . $descripcion['DES_PROVINCIA']  . '</option>';
                }
                echo $provincia;  
            }
        } 

    

        static function Listar_Distrito($departamento,$Provincia){
            $bd="SMP2";
            $M_listarDistrito = new M_ListarCiudades($bd);
            $C_codDistrito = $M_listarDistrito->M_Distrito($departamento,$Provincia);
            if($C_codDistrito > 0){
                $Distrito="";
                foreach ($C_codDistrito as $descripcion){
                    $Distrito = $Distrito . '<option selected>SELECCIONE</option>
                    <option  value="'.$descripcion['COD_DISTRITO'].'">' . $descripcion['DES_DISTRITO']  . '</option>';
                }
              echo $Distrito;   
            }
        }
    }

?>