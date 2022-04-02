<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once("m_registroalmacen.php");
require_once("../funciones/f_funcion.php");

    $accion = $_POST['accion'];  
    if($accion == 'view_avance'){
        c_registroalmacen::c_view_avances();
    }else if($accion == 'r_produccion'){
        $producto = $_POST['producto'];
        $usu = $_POST['usu'];
        $produccion = $_POST['produccion'];
        $cantidad = $_POST['cantidad'];
        $codpersonal = $_POST['codpersonal'];
        $codavance = $_POST['codavance'];
        $fecha = $_POST['fecha'];
        c_registroalmacen::c_r_avances($produccion,$producto,$cantidad,$usu,$codpersonal,$codavance,$fecha);
    }
 
    class c_registroalmacen
    { 
    static function c_r_avances($produccion,$producto,$cantidad,$usu,$codpersonal,$codavance,$fecha){
      $m_formula = new m_registroalmacen();
      $c_formula = $m_formula->m_r_avances($produccion,$producto,$cantidad,$usu,$codpersonal,$codavance,$fecha);
      print_r($c_formula);
    }
    
    static function c_view_avances()
    {
      $suma = 0;
      $m_formula = new m_registroalmacen();
      $cadena = "derivo = '0' order by avance desc";
      $c_formula = $m_formula->m_buscar('V_INGRE_ALMACEN',$cadena);
      for ($i=0; $i < count($c_formula) ; $i++) { 
        $c_formula[$i][4] = convFecSistema($c_formula[$i][4]);
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
      $dato = array('dato' => $c_formula);
      echo json_encode($dato,JSON_FORCE_OBJECT);
    }


}
?>