<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

date_default_timezone_set('America/Lima');
require_once("m_menu.php");
require_once("../funciones/f_funcion.php");


    $anexo = '9001';
    if ($anexo!="") {
        $usu = new c_permisosmenu();
        $usu->c_permisos($anexo);
    }else{
        return header("Location:  ../index.php");
    }


class c_permisosmenu
{
    public function c_permisos($anexo){
       
        $menu = array();
        $sub= array();
        $subSub = array();
        $contM = 0;
        $m_login = new m_menu();
        //$datosUsuario = $m_login->Login($cod_usuario);
        $contS = 0;
        $contS2 = 0;
        $Arrmenu = array();
        $ArrSubmenu = array();
        $ArrSubmenu2 = array();
      // if(count($datosUsuario)){
            $permisos = $m_login->m_permisos($anexo);
            if(count($permisos) > 0){
                for ($i=0; $i < count($permisos) ; $i++) { 
                    if(!in_array($permisos[$i][2], $Arrmenu)){
                        array_push($Arrmenu,$permisos[$i][2]);
                        $cabmenu = $m_login->m_listarmenu($permisos[$i][2]);
                        print_r($cabmenu);
                        for ($l=0; $l < count($cabmenu) ; $l++) {
                            $menu[$contM] = [$cabmenu[$l][0],$cabmenu[$l][1],$cabmenu[$l][2]];
                            $contM++;
                          }
                      }
    
                    if(!in_array(array($permisos[$i][2],$permisos[$i][3]), $ArrSubmenu)){
                       array_push($ArrSubmenu,array($permisos[$i][2],$permisos[$i][3]));
                       $submenu = $m_login->m_listasubmenus($permisos[$i][2],$permisos[$i][3]);
                       for ($k=0; $k < count($submenu); $k++) { 
                        $sub[$contS] = [$submenu[$k][1],$submenu[$k][3],$submenu[$k][4],$submenu[$k][2]];
                        $contS++;
    
                       }
                    }
    
                    if(!in_array(array($permisos[$i][2],$permisos[$i][3],$permisos[$i][4]), $ArrSubmenu2)){
                        array_push($ArrSubmenu2,array($permisos[$i][2],$permisos[$i][3],$permisos[$i][4]));
                        $submenu2 = $m_login->m_listasubmenus2($permisos[$i][2],$permisos[$i][3],$permisos[$i][4]);
                        
                        for ($j=0; $j <count($submenu2) ; $j++) { 
                            $subSub[$contS2] = [$submenu2[$j][0],$submenu2[$j][1],$submenu2[$j][1],$submenu2[$j][3],$submenu2[$j][4]];
                            $contS2++;
                        }
                    }
    
                }
              
                session_start();
               $_SESSION["menu"] = $menu;
               $_SESSION["submenu"] = $sub;
               $_SESSION["subsub"] = $subSub;
              
                header("Location: index.php");
                die();
            }else{
            print_r("Error");
        }
            
    }


}

?>