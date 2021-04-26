<?php
 require_once('../db/Usuarios.php');

 class Almacenes 
 {
    private $db;

    public function __construct()
    {
        $this->db=ClassUsuario::Usuario();   
    }

    public function QuincenaAlmacen($cod_vendedor)
    {
        $hoy = getdate();
        $dia = $hoy['mday'];
        $mes = $hoy['mon'];
        $ano = $hoy['year'];
        $m = intval($mes) - intval(1);


        /* primer if se cuenta la quincena del 27 al 11  pero como el mensaje sale durante de tres dias
        es decir desde el 12 al 15 se verifica cuanto a echo desde el 27 hasta el dia actual
        que es menor o igual a 15*/
        if($hoy['mday'] >= '12' && $hoy['mday'] <= '16'){
           
            $fecha_quincena = '27'.'/'. $m .'/'.$ano;
            $fecha_actual = $hoy['mday'].'/'.$mes.'/'.$ano;
           
         }else if ($hoy['mday'] >= '27' && $hoy['mday']<='30'){
             /*este if se cuenta la quincena del 12 al 26 pero como el mensaje sale durante de tres dias 
             es decir desde el 27 al 30 se verifica cuanto a echo desde el 12 hasta el dia actual 
             que es menor o igual a 30*/
             $fecha_quincena = '12'.'/' . $mes .'/'.$ano;
             $fecha_actual = $hoy['mday'].'/'.$mes.'/'.$ano;
 
         }


        $query = $this->db->prepare("SELECT c.NUM_CONTRATO ,c.COD_VENDEDOR , 
        c.CUOTAS ,c.FEC_GENERADO FROM T_CALL_CENTER as c 
        LEFT JOIN T_CALL_CENTER_ITEM as ci
        ON c.NUM_CONTRATO = ci.NUM_CONTRATO
        WHERE c.COD_VENDEDOR = :cod_vendedor AND c.FEC_GENERADO >= :fecha_quincena
        AND c.FEC_GENERADO <= :fecha_actual");
        $query->bindParam('cod_vendedor',$cod_vendedor,PDO::PARAM_STR);
        $query->bindParam('fecha_quincena',$fecha_quincena,PDO::PARAM_STR);
        $query->bindParam('fecha_actual',$fecha_actual,PDO::PARAM_STR);
        $query->execute();
        if($query){
            return $query;
            $query->closeCursor();
            $query = null;
        }


    }

 }
 



?>