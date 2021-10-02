<?php
     require_once("../funciones/m_Login.php");

     $accion = $_POST['accion'];

     if($accion == 'listar'){
         c_menu::c_listarMenu();
     }   
     
    class c_menu 
    {   
        static function c_listarMenu()
        { 
            $i = 0;
            $html = "";
            $menu = new M_Login(); 
            $listado = $menu->m_listaMenuthree();
            $subitems = "";

            for ($i=0; $i < count($listado) ; $i++) { 
              $subitems = c_menu::c_listarSubmenus($listado[$i][0]);
                if($subitems == ""){
                    $html.= '<li>
                                <label class="font lblmenuthree">
                                    <input class="general menuthree nopadre form-check-input" type="checkbox" datamenu="'.$listado[$i][0].'" /> '
                                    .$listado[$i][1].
                                '</label>
                            </li>';
                }else{
                    $html .= '<li>
                                <label class="font lblmenuthree">
                                    <input class="general menuthree padre form-check-input" type="checkbox"  datamenu="'.$listado[$i][0].'" /> '
                                    .$listado[$i][1] .
                                '</label>'.
                                '<ul>'.
                                    $subitems .
                                '</ul>'.        
                            '</li>';
                }    
        }
        print_r($html);
    }


        static function c_listarSubmenus($idmenu){
            $menu = new M_Login(); 
            $listadosub = $menu->m_listasubmenusthree($idmenu);
            //print_r($listadosub);
            $html = "";
            for ($i=0; $i < Count($listadosub); $i++) { 
                if($listadosub[$i][3] != ""){
                    $subitems2 = c_menu::c_listarSubmenu2($idmenu,$listadosub[$i][2]);
                    // print_r($subitems2);
                      if($subitems2 == ""){
                          $html.='<li>
                              <label class="font lblsubmenu1">
                                  <input class="cls submenu1 nopadre form-check-input" type="checkbox" datamenu="'.$idmenu.'"  datasub="'.$listadosub[$i][2].'"/> '
                                  .$listadosub[$i][3].
                             '</label>
                              </li>';
                      }else{
                          $html.='<li>
                                  <label class="font lblsubmenu1">
                                      <input class="cls submenu1 padre form-check-input" type="checkbox"  datamenu="'.$idmenu.'" datasub="'.$listadosub[$i][2].'"/> '
                                      .$listadosub[$i][3].
                                  '</label>
                                  <ul>'
                                      .$subitems2.
                                  '</ul>
                              </li>';  
                      }
                }         
            }
           
            return $html;
        }


        static function c_listarSubmenu2($idmenu,$idsubmenu){
            $menu = new M_Login(); 
            $listadosub2 = $menu->m_listarSubmenus2three($idsubmenu);
            //print_r($listadosub2);
            $html = "";
                for ($i=0; $i < Count($listadosub2); $i++) { 
                    if($listadosub2[$i][1] == $idmenu){
                        $html.= '<li>
                            <label class="font lblsubmenu2">
                                <input class="cls submenu2 nopadre form-check-input" type="checkbox" datamenu="'.$idmenu.'" datasub="'.$idsubmenu.'" datasub2="'.$listadosub2[$i][6].'" /> '
                                    .$listadosub2[$i][7].
                            '</label>
                        </li>';
                    }
                }
            return $html;
        }
    }


?>