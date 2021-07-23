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

            for ($i=0; $i < count($listado) ; $i++) { 
              
                // print_r($i);
                //if(count($listado) - 2!= $i){
                    $html.= '<div class="row g-3 mb-3">'.
                        '<div class="col-4">'.
                            '<div class="form-check">'.
                                    '<input class="form-check-input" type="checkbox" value="" id="defaultCheck1">'.
                                    '<label class="form-check-label" for="defaultCheck1">'.
                                        $listado[$i][2].
                                    '</label>'.
                            '</div>'.
                        '</div>'.
                    '</div>';
                   
                   
                   
               // }
                }
         
       

           /* $dato = array(
                'dato' => $listado
            );

            echo json_encode($dato,JSON_FORCE_OBJECT);*/
         // echo $html;
        }

    }
    



?>