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
            $listado = $menu->m_listaMenu();
            $subitems = "";

            for ($i=0; $i < count($listado) ; $i++) { 
              $subitems = c_menu::c_listarSubmenus($listado[$i][0]);
                if($subitems == ""){
                    $html.= '<li>
                                <label>
                                    <input type="checkbox" data="'.$listado[$i][0].'" style="width: 18px;height: 18px;"/> '
                                    .$listado[$i][1].
                                '</label>
                            </li>';
                }else{
                    $html .= '<li>
                                <label>
                                    <input type="checkbox"  style="width: 18px;height: 18px;"/> '
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
            $listadosub = $menu->m_listasubmenus($idmenu);
            $html = "";
            for ($i=0; $i < Count($listadosub); $i++) { 
                $subitems2 = c_menu::c_listarSubmenu2($idmenu,$listadosub[$i][2]);
               
                if($subitems2 == ""){
                    $html.='<li>
                        <label>
                            <input type="checkbox" data="'.$listadosub[$i][2].'"  style="width: 18px;height: 18px;"/> '
                            .$listadosub[$i][3].
                       '</label>
                        </li>';
                }else{
                    $html.='<li>
                            <label>
                                <input type="checkbox" data="'.$listadosub[$i][2].'" style="width: 18px;height: 18px;"/> '
                                .$listadosub[$i][3].
                            '</label>
                            <ul>'.
                                $subitems2.
                            '</ul>
                        </li>';  
                }
                        
            }
           
            return $html;
        }


        static function c_listarSubmenu2($idmenu,$idsubmenu){
            $menu = new M_Login(); 
            $listadosub2 = $menu->m_listarSubmenus2($idmenu,$idsubmenu);
            $html = "";
                for ($i=0; $i < Count($listadosub2); $i++) { 
                    if($listadosub2[$i][1] == $idmenu){
                        $html.= '<li>
                            <label>
                                <input type="checkbox" data="precio"  style="width: 18px;height: 18px;"/> '
                                    .$listadosub2[$i][6].
                            '</label>
                        </li>';
                    }
                    
                }
            return $html;
        }
    }


?>