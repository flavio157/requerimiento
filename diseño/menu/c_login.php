<?php
date_default_timezone_set('America/Lima');
require_once("../funciones/m_Login.php");
require_once("../funciones/f_funcion.php");


   $cod_usuario = $_POST['usuario'];
 
   
    if ($cod_usuario!="") {
        $usu = new C_Login();
        $usu->C_usuario($cod_usuario);
    }else{
        return header("Location:  ../index.php");
    }


class C_Login
{
    public function C_usuario($cod_usuario){
        $menu = array();
        $sub= array();
        $subSub = array();
        $contM = 0;
        $m_login = new M_Login();
        $datosUsuario = $m_login->Login($cod_usuario);
        $contS = 0;
        $contS2 = 0;
     
       if(count($datosUsuario)){
            $permiso = $m_login->m_permisos($datosUsuario[0]['3']);
            $cabmenu = $m_login->m_listaMenu();
         for ($i=0; $i < count($permiso[0]) ; $i++) { 
            for ($l=0; $l < count($cabmenu); $l++) {

               if($permiso[0][$i] == $cabmenu[$l][0] && $i != 0){
                
                    $submenu = $m_login->m_listasubmenus($cabmenu[$l][0]);
                   
                   for ($k=0; $k < count($submenu); $k++) { 
                       $submenu2 = $m_login->m_listarSubmenus2($submenu[0][5]);

                       for ($n=0; $n < count($submenu2); $n++) {
                           if($submenu[$k][2] == $submenu2[$n][5]){
                                $subSub[$contS2] = [$submenu2[$n][5],$submenu2[$n][6],$submenu2[$n][7]];
                                $contS2++;
                            }
                       }
                      $sub[$contS] = [$submenu[$k][1],$submenu[$k][3],$submenu[$k][4],$submenu[$k][2]];
                      $contS++;
                   }
                  
                   $menu[$contM] = [$cabmenu[$l][0],$cabmenu[$l][1],$cabmenu[$l][2]];
                 $contM++;
               }
            } 
           } 

           $_SESSION["menu"] = $menu;
           $_SESSION["submenu"] = $sub;
           $_SESSION["subsub"] = $subSub;
       }else{
          print_r("Error");
        }
    }


}

?>