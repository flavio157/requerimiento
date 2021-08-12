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
            $subitems = '';

            for ($i=0; $i < count($listado) ; $i++) { 
              $subitems = c_menu::c_listarSubmenus($listado[$i][0]);
              if($subitems == ''){
                
                    $html.=  '<div class="col-6 " >'.
                                '<div class="form-check ">'.
                                        '<input class="form-check-input" type="checkbox" value="" >'.
                                        '<label class="form-check-label">'.
                                            $listado[$i][1].
                                        '</label>'.
                                '</div>'.
                            '</div>';
                }else{
                    $html.= '<div class="col-6 " >'.
                    '<div class="form-check ">'.
                            '<input class="form-check-input" type="checkbox" value="" >'.
                            '<label class="form-check-label collapsed" data-bs-toggle="collapse" data-bs-target="#checke'.$i.'">'.
                                $listado[$i][1].
                            '</label>'.
                    '</div>'
                        .'<div class="accordion-body accordion-collapse collapse "  id="checke'.$i.'">'.
                            $subitems.
                        '</div>'.
                       //style="padding-left: 50px" 
                    '</div>';
                }
                   
            }
               
                print_r($html);
        }

        static function c_listarSubmenus($idmenu){
            $menu = new M_Login(); 
            $listadosub = $menu->m_listasubmenus($idmenu);
            $html = "";
            for ($i=0; $i < Count($listadosub); $i++) { 
                $html.= '<div class="form-check ">'.
                            '<input class="form-check-input" type="checkbox" value="" >'.
                            '<label class="form-check-label">'.
                                $listadosub[$i][3].
                            '</label>'.
                        '</div>';
            }
            return $html;
        }

    }
    



?>