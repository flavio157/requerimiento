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
        $contM = 0;
        $m_login = new M_Login();
        $datosUsuario = $m_login->Login($cod_usuario);
        $contS = 0;
     
       if(count($datosUsuario)){
            $permiso = $m_login->m_permisos($datosUsuario[0]['3']);
            $cabmenu = $m_login->m_listaMenu();
         for ($i=0; $i < count($permiso[0]) ; $i++) { 
            for ($l=0; $l < count($cabmenu); $l++) { 
               if($permiso[0][$i] == $cabmenu[$l][1] && $i != 0){
                   $submenu = $m_login->m_listasubmenus($cabmenu[$l][0]);
                   //print_r(count($submenu));
                   for ($k=0; $k < count($submenu); $k++) { 
                      
                         // print_r($submenu[$k][4]);
                      $sub[$contS] = [$submenu[$k][1],$submenu[$k][3],$submenu[$k][4]];
                      $contS++;
                   }
                   $menu[$contM] = [$cabmenu[$l][0],$cabmenu[$l][2],$cabmenu[$l][3]];
                 $contM++;
               }
            } 
           } 
          
            //print_r($menu);
            //print_r($sub);
           session_start();
           $_SESSION["menu"] = $menu;
           $_SESSION["submenu"] = $sub;
       }else{
          print_r("Error");
        }

       
    }


}

?>