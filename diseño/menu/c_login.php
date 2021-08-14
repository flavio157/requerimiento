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
            $perusu = $m_login->m_permisos($datosUsuario[0]['3']);
            $permiso = C_Login::permisos($perusu,1);
            $cabmenu = $m_login->m_listaMenu();
           
           for ($i=0; $i < count($permiso) ; $i++) { 
               print_r($i);
                //print_r($permiso[$i]);
                for ($l=0; $l < count($cabmenu); $l++) { 
                   
                    if($permiso[$i]== $cabmenu[$l][0]){

                        $submenu = $m_login->m_listasubmenus($permiso[$i]);
                        C_Login::printe($submenu);
                        $Persubmenu =  C_Login::permisos($perusu,2);

                        for($j=0; $j < count($Persubmenu) ; $j++){

                            for ($k=0; $k < count($submenu); $k++) { 

                                if($Persubmenu[$j]== $submenu[$k][2]){

                                    $sub[$contS] = [$submenu[$k][1],$submenu[$k][3],$submenu[$k][4],$submenu[$k][2]];
                                    $contS++;
                                }
                               
                            } 
                        }
                        
                       
                        $menu[$contM] = [$cabmenu[$l][0],$cabmenu[$l][1],$cabmenu[$l][2]];
                        $contM++;

                    }
                    
                }
           }
          /*   $submenu2 = $m_login->m_listarSubmenus2($submenu[$l][5]);
                            for ($n=0; $n < count($submenu2); $n++) {
                                if($submenu[$k][2] == $submenu2[$n][5]){
                                     $subSub[$contS2] = [$submenu2[$n][5],$submenu2[$n][7],$submenu2[$n][8]];
                                     $contS2++;
                                 }
                            }*/
           $_SESSION["menu"] = $menu;
           $_SESSION["submenu"] = $sub;
           $_SESSION["subsub"] = $subSub;
        
         //header("Location: index.php");
          // die();
       }else{
          print_r("Error");
        }
    }


    static function permisos($permiso,$id)
    {
        $norepet = array();
        for ($i=0; $i < count($permiso); $i++) { 
           
            if(count($norepet) == 0)
              array_push($norepet,$permiso[$i][$id]);
            else{  
                if(!in_array($permiso[$i][$id], $norepet)){
                    array_push($norepet,$permiso[$i][$id]);
                }
            }    
        }
      //  print_r($norepet);
        return $norepet;
    }



    static function printe($array){
		echo('<pre>');
		print_r($array);
		echo('</pre>');
	}

}

?>