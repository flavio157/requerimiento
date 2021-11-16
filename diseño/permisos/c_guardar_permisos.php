<?php
    require_once("m_guardar_permisos.php");

        $tipo = $_POST["accion"];
        if($tipo == 'guardar'){
            $dt = json_decode($_POST['permisos']);
            $anexo = $_POST["anexo"];
            c_guardar_permisos::c_guardar_datos($anexo,$dt);
        }else if($tipo == 'buscar'){
            $anexo = $_POST['anexo'];
            c_guardar_permisos::c_buscar_anexo($anexo);
        }else if($tipo == 'listar'){
            c_guardar_permisos::c_listarMenu();
        }else if($tipo == 'lstmenu'){
            c_guardar_permisos::c_lstmenu();
        }else if($tipo == 'lstsubmenu'){
            $idmenu = $_POST['idmenu'];
            c_guardar_permisos::c_lstsubmenu($idmenu);
        }else if($tipo == 'lstsubmenu2'){
            $idmenu = $_POST['idmenu'];
            $idsubmenu = $_POST['idsubmenu'];
            c_guardar_permisos::c_lstsubmenu2($idmenu,$idsubmenu);
        }else if($tipo == 'actualizar'){
            $idmenu = $_POST['idmenu'];
            $idsubmen = $_POST['idsubmen'];
            $idsubsubmenu = $_POST['idsubsubmenu'];
            $nombre =$_POST['nombre'];
            $url = $_POST['url'];
            $estado = $_POST['estado'];
            c_guardar_permisos::c_actualizar($idmenu,$idsubmen,$idsubsubmenu,$nombre,$url,$estado);
        }else if($tipo == 'guardarmenu'){
            $nombre =$_POST['nombre'];
            $url = $_POST['url'];
            $estado = $_POST['estado'];
            c_guardar_permisos::c_guardar($nombre,$url,$estado);
        }else if($tipo == 'guardarsubmenu'){
            $idmenu = $_POST['idmenu'];
            $nombre =$_POST['nombre'];
            $url = $_POST['url'];
            $estado = $_POST['estado'];
            c_guardar_permisos::c_guardarsubmenu($idmenu,$nombre,$url,$estado);
        } else if($tipo == 'guardarsubsubmenu'){
            $idmenu = $_POST['idmenu'];
            $idsubmenu = $_POST['idsubmenu'];
            $nombre =$_POST['nombre'];
            $url = $_POST['url'];
            $estado = $_POST['estado'];
            c_guardar_permisos::c_guardarsubmenu2($idmenu,$idsubmenu,$nombre,$url,$estado);
        }else if($tipo == 'buscarmenu'){
            $idmenu = $_POST['idmenu'];
            c_guardar_permisos::c_buscarmenu($idmenu);
        }else if($tipo == 'buscarsubmenu'){
            $idmenu = $_POST['idmenu'];
            $idsubmenu = $_POST['idsubmenu'];
            c_guardar_permisos::c_buscarsubmenu($idmenu,$idsubmenu);
        } else if($tipo == 'buscarsubsubmenu'){
            $idmenu = $_POST['idmenu'];
            $idsubmenu = $_POST['idsubmenu'];
            $idsubsubmenu = $_POST['idsubsubmenu'];
            c_guardar_permisos::c_buscarsubsubmenu($idmenu,$idsubmenu,$idsubsubmenu);
        }  

class c_guardar_permisos 
{
    static function c_guardar_datos($anexo,$dt)
    {
        $patron = "/^([0-9])*$/";
        if(strlen($anexo) <= 4){
            if($anexo != '' && preg_match($patron,$anexo)){
                $m_permisos = new m_guardar_permisos();
                if(count($dt->permisos) > 0){
                    $c_permisos = $m_permisos->m_guardar_permisos($anexo,$dt);
                    if($c_permisos == 1)
                        print_r("DATOS GUARDADOS");
                    else
                        print_r($c_permisos);    
                }else{
                    print_r("SELECCIONE PERMISOS");
                }
            }else{
                print_r("ANEXO INVALIDO");
            }
        }else{
            print_r("ANEXO INVALIDO");
        }
    }
    
    static function c_buscar_anexo($anexo){
        $m_permisos = new m_guardar_permisos();
        $c_permisos = $m_permisos->m_consultar_permisos($anexo);
        $dato = array(
            'estado' => 'ok',
            'datos' => $c_permisos,
            );
            echo json_encode($dato,JSON_FORCE_OBJECT);
    }

    static function c_listarMenu()
    { 
        $i = 0;
        $html = "";
        $menu = new m_guardar_permisos(); 
        $listado = $menu->m_listaMenuthree();
        $subitems = "";

        for ($i=0; $i < count($listado) ; $i++) { 
         
          $subitems = c_guardar_permisos::c_listarSubmenus($listado[$i][0]);
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
        $menu = new m_guardar_permisos(); 
        $listadosub = $menu->m_listasubmenusthree($idmenu);
       
        $html = "";
        for ($i=0; $i < Count($listadosub); $i++) { 
            if($listadosub[$i][3] != ""){
                $subitems2 = c_guardar_permisos::c_listarSubmenu2($idmenu,$listadosub[$i][2]);
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
        $menu = new m_guardar_permisos(); 
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

    static function c_lstmenu()
    {  
        $menu = new m_guardar_permisos(); 
        $listado = $menu->m_lstMenu();
        $dato = array(
            'dato' => $listado
        );
        echo json_encode($dato , JSON_FORCE_OBJECT);
    }

    static function c_lstsubmenu($idmenu)
    {
        $menu = new m_guardar_permisos(); 
        $listadosub = $menu->m_lstsubmenu($idmenu);
        $dato = array(
            'dato' => $listadosub
        );
        echo json_encode($dato , JSON_FORCE_OBJECT);
    }

    static function c_lstsubmenu2($idmenu,$idsubmenu)
    {
        $menu = new m_guardar_permisos(); 
        $listadosub2 = $menu->m_lstSubmenu2($idmenu,$idsubmenu);
        $dato = array(
            'dato' => $listadosub2
        );
        echo json_encode($dato , JSON_FORCE_OBJECT);
    }

    static function c_actualizar($idmenu,$idsubmen,$idsubsubmenu,$nombre,$url,$estado)
    {
        $menu = new m_guardar_permisos(); 
        if($idmenu != "" && $idsubmen == "" && $idsubsubmenu == ""){
            $datos = "NOMBRE ='$nombre' , URL = '$url'
            ,ESTADO = '$estado' WHERE ID_MENU = '$idmenu'";
            $tabla = "T_CAB_MENU";
            $listadosub = $menu->m_actualizar($tabla,$datos);
            print_r($listadosub);
        }

        if($idmenu != "" && $idsubmen != "" && $idsubsubmenu == ""){
            $datos = "SUB_NOMBRE1 ='$nombre' , URL1 = '$url'
            ,ESTADO1 = '$estado' WHERE ID_MENU = '$idmenu' AND ID_SUBMENU1 = '$idsubmen'";
            $tabla = "T_SUB_MENUS";
            $listadosub = $menu->m_actualizar($tabla,$datos);
            print_r($listadosub);
        }

        if($idmenu != "" && $idsubmen != "" && $idsubsubmenu != ""){
            $datos = "SUB_NOMBRE2 ='$nombre' , URL2 = '$url'
            ,ESTADO2 = '$estado' WHERE ID_MENU = '$idmenu' AND IDSUBMENU1 = '$idsubmen' 
            AND IDSUBMENU2 = '$idsubsubmenu'";
            $tabla = "T_SUB_MENUS";
            $listadosub = $menu->m_actualizar($tabla,$datos);
            print_r($listadosub);
        }
    }

    static function c_guardar($nombre,$url,$estado){
        if($nombre == ''){print_r("Error ingrese nombre del menu"); return;}
        if($estado == ''){print_r("Error seleccione estado"); return;}
        if(strlen($nombre) > 100){print_r("Error nombre mayor a lo permitido"); return;}
        $m_permisos = new m_guardar_permisos();
        $c_guardarmenu =$m_permisos->m_guardarmenu($nombre,$url,$estado);
        print_r($c_guardarmenu);
    }

    static function c_guardarsubmenu($idmenu,$nombre,$url,$estado){
        if($idmenu == ''){print_r("Error seleccione un menu"); return;}
        if($nombre == ''){print_r("Error ingrese nombre del menu"); return;}
        if($estado == ''){print_r("Error seleccione estado"); return;}
        if(strlen($nombre) > 100){print_r("Error nombre mayor a lo permitido"); return;}
        $m_permisos = new m_guardar_permisos();
        $c_guardarmenu =$m_permisos->m_guardarsubmenus($idmenu,$nombre,$url,$estado);
        print_r($c_guardarmenu);
    }

    static function c_guardarsubmenu2($idmenu,$idsubmenu,$nombre,$url,$estado){
        if($idmenu == ""){print_r("Error seleccione un menu"); return;}
        if($idsubmenu == ""){print_r("Error seleccione un Sub menu");return;}
        if($nombre == ''){print_r("Error ingrese nombre del menu"); return;}
        if($estado == ''){print_r("Error seleccione estado"); return;}
        if(strlen($nombre) > 100){print_r("Error nombre mayor a lo permitido"); return;}
        $m_permisos = new m_guardar_permisos();
        $c_guardarmenu =$m_permisos->m_guardarsubmenus2($idmenu,$idsubmenu,$nombre,$url,$estado);
        print_r($c_guardarmenu);
    }

    static function c_buscarmenu($idmenu)
    {
        $menu = new m_guardar_permisos();  
        $c_menu = $menu->m_buscarMenu($idmenu);
        $dato = array(
            'dato' => $c_menu,
        );
        echo json_encode($dato,JSON_FORCE_OBJECT);
    }

    static function c_buscarsubmenu($idmenu,$submenu)
    {
        $menu = new m_guardar_permisos();  
        $c_submenu = $menu->m_buscarsubMenu($idmenu,$submenu);
        $dato = array(
            'dato' => $c_submenu,
        );
        echo json_encode($dato,JSON_FORCE_OBJECT);
    }

    static function c_buscarsubsubmenu($idmenu,$submenu,$submenu2)
    {
        $menu = new m_guardar_permisos();  
        $c_subsubmenu = $menu->m_buscarsubsubMenu($idmenu,$submenu,$submenu2);
        $dato = array(
            'dato' => $c_subsubmenu,
        );
        echo json_encode($dato,JSON_FORCE_OBJECT);
    }
}


?>