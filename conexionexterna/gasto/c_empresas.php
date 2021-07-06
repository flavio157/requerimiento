<?php
    require_once("../funciones/m_empresas.php");
    require_once("../funciones/m_personal.php");
    $tipo = $_POST['tipo'];

    if($tipo == 'listarempresa'){
        C_Empresas::c_listarempresas();
    }else if($tipo == 'buscarpro'){
        $proveedor = $_POST['proveedor'];
        C_Empresas::c_proveedor($proveedor);
    }else if($tipo == 'mostrarimg'){
        $mostrarimg = $_POST['nombreimg'];
        C_Empresas::mostrarimg($mostrarimg);
    }else if($tipo == 'buscarper'){
        $personal = $_POST['personal'];
        $oficina = $_POST['oficina'];
        C_Empresas::c_buscarpersonal($oficina,$personal);
    }

    class C_Empresas
    {
        static function c_listarempresas()
        {
            $m_listarempresa = new M_Empresas();
            $c_listarempresa = $m_listarempresa->m_listarempresa(); 
            if($c_listarempresa > 0){
                $select="";
                foreach ($c_listarempresa as $empresas){
                    $select .= '<option  value="'.$empresas['COD_EMPRESA'].'"data-ruc="'.$empresas['RUC'].'">'.$empresas['NOMBRE']. '</option>';
                }
                echo $select;  
            }
        }


        static function c_proveedor($proveedor)
        {
            $m_proveedor = new M_Empresas();
            $c_buscarproveedor = $m_proveedor->m_proveedor($proveedor); 
            if($c_buscarproveedor > 0){
                echo json_encode($c_buscarproveedor,JSON_FORCE_OBJECT);
            }
        }

    

        static  function mostrarimg($codigo)
        {
            
            $m_foto = new M_Empresas();
            $c_mostrarimg = $m_foto->m_mostrarimg($codigo);
            print_r(base64_encode($c_mostrarimg['IMAGEN']));
            
        }


        static function c_buscarpersonal($oficina,$personal){
            $m_personal = new M_buscarpersonal();/*$oficina parametro */
            $c_buscarpersonal = $m_personal->m_buscarpersonal($personal); 
            if($c_buscarpersonal > 0){
                $html="";
                foreach($c_buscarpersonal as $proveedor){
                    $html.= '<div><a class="element-per" data-val="'.$proveedor['NOM_PERSONAL'].'"id="'.$proveedor['COD_PERSONAL'].'">'.$proveedor['NOM_PERSONAL'].'</a></div>';
                }
                echo $html; 
            }
        }

        static function c_guardargasto($codigo,$oficina,$fec_emision,$cod_personal,$tipo_comprobante,$serie_contabilidad,$comp_contabilidad,$identificacion,
        $cod_proveedor,$nombre,$direccion,$obs_comprovante,$monto_comprobante,$nro_correlativo,$usuario_registro,$caja,$contabilidad,$cod_empresa,$cod_concepto_caja,$concepto,$existepro)
        {
            $m_guardar = new M_Empresas();
            $c_guardargastos = $m_guardar->m_guardargasto($codigo,$oficina,$fec_emision,$cod_personal,$tipo_comprobante,$serie_contabilidad,$comp_contabilidad,$identificacion,
            $cod_proveedor,$nombre,$direccion,$obs_comprovante,$monto_comprobante,$nro_correlativo,$usuario_registro,$caja,$contabilidad,$cod_empresa,$cod_concepto_caja,$concepto,$existepro);
            return $c_guardargastos;
        }

      
        static function verificardoc($seriedoc,$tipocompro,$seriecontab,$identificacion)
        {
            $m_doc = new M_Empresas();
            $c_verificardoc = $m_doc->m_verificardoc($seriedoc,$tipocompro,$seriecontab,$identificacion); 
            return $c_verificardoc;
        }

       static function nombreimgn()
        {
            $m_img = new M_Empresas();
            $nombreimg = $m_img -> Generarcodigo();
            $codigo = generarcorrelativo($nombreimg,1);
            return $codigo;
        }
        
    }
    

?>