<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once("../funciones/f_funcion.php");
require_once("m_reporteproduccion.php");

    $accion = $_POST['accion'];  
    if($accion == 'view_avance'){
      $codpro = $_POST['codprod'];
      $fechini = $_POST['fechini'];
      $fechfin = $_POST['fechfin'];
      c_reporteproduccion::c_view_avances($codpro,$fechini,$fechfin);
    }else if($accion == 'r_produccion'){
        $codgen = $_POST['codgen'];
        $producto = $_POST['producto'];
        $usu = $_POST['usu'];
        $produccion = $_POST['produccion'];
        $cantidad = $_POST['cantidad'];
        c_reporteproduccion::c_r_avances($codgen,$produccion,$producto,$cantidad,$usu);
    }else if($accion == 'productos'){
       C_reporteproduccion::c_view_producto();
    }
 
    class c_reporteproduccion
    { 
      static function c_r_avances($codgen,$produccion,$producto,$cantidad,$usu){
        $m_formula = new m_reporteproduccion();
        $c_formula = $m_formula->m_r_avances($codgen,$produccion,$producto,$cantidad,$usu);
        print_r($c_formula);
      }
      
      static function c_view_avances($codpro,$fechini,$fechfin)
      {
        $error ="";$suma = 0;
       
        $fechini == retunrFechaSql($fechini); $fechfin == retunrFechaSql($fechfin);
        if($fechfin < $fechini){
          $error = "Error la fecha fin no puede ser menor a fecha inicio";
        }
        if($codpro == "" && $fechfin == ""){
           $cadena = "''= ''";
        }else if($fechini != "" && $fechfin != "" && $codpro != ""){
          $cadena = "codprod= '$codpro' AND fecha >= '$fechini' AND fecha <= '$fechfin'";
        }else if($fechini != "" && $fechfin != "" && $codpro == ""){
          $cadena = "fecha >= '$fechini' AND fecha <= '$fechfin'";
        }else if($codpro != ""){
          $cadena = "codprod= '$codpro'";
        }
        if($error == ""){
          $cadena = $cadena . "order by avance desc";
          $m_formula = new m_reporteproduccion();
          $c_formula = $m_formula->m_buscar('V_INGRE_ALMACEN',$cadena);
          for ($i=0; $i < count($c_formula) ; $i++) { 
       
            if($c_formula[$i][19] == $c_formula[$i][5]){
              
              $produc = $c_formula[$i][1];
              $c_merma = $m_formula->m_merma($produc);
              if(count($c_merma) > 0){
               
                  for ($l=0; $l <count($c_merma); $l++) { 
                      $suma = $suma + $c_merma[$l][1];
                  }
                
                  $c_formula[$i][20] = $suma;
              }
            }
          }
          $dato = array('dato' => $c_formula,'t'=> $error);
        }else{
          $dato = array('dato' => '','t'=> $error);
        }
        echo json_encode($dato,JSON_FORCE_OBJECT);
      }

      static function c_view_producto()
      {
        $aproducto = [];
        $m_formula = new m_reporteproduccion();
        $cadena = "COD_CATEGORIA = '00002' AND EST_PRODUCTO = '1'";
        $c_producto = $m_formula->m_buscar('T_PRODUCTO',$cadena);
        for ($i=0; $i < count($c_producto) ; $i++) { 
          array_push($aproducto,array(
              "code" => trim($c_producto[$i][0]),
              "label" => trim($c_producto[$i][2]),
          ));
        }
        $dato = array(
            'dato' => $aproducto
        );
        echo json_encode($dato,JSON_FORCE_OBJECT);
      }
}
?>