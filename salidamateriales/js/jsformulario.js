$(document).ready(function() {
    $(window).on("beforeunload", function() { 
      retornar();
    })
    $('#btnnuevo').on('click',function(params) {
        retornar()
        limpiar();
    })
    $("#aentrega").on('click',function() {
        sre = $("#txtseriematerial").val();
        filas = $("#tdmaterialentrega  tr");
        if(filas.length > 0){
            for (let l = 0; l <filas.length ; l++) {
                if($(filas[l]).find("td")[2].innerHTML != sre.toUpperCase().trim()){
                    _stock($("#txtcodmaterial").val(),$("#vroficina").val());
                }else{
                   Mensaje1("Nro de serie ya registrado",'error');
                }
            }
        }else{
            _stock($("#txtcodmaterial").val(),$("#vroficina").val());
        }
        $("#txtcanmaterial").val('');
    });
    
    $("#txtpersonal").on('keyup',function() {
        _buscarsugerencia($(this),'personal');
    })

    $("#txtmaterial").on('keyup',function() {
        _buscarsugerencia($(this),'material');
    })

    $("html").click(function(){
        $('#personal').fadeOut(0);
        $('#material').fadeOut(0); 
    });

    $("#btnAddpersonal").on('click',function () {
        if($("#txtcodpersonal").val() != '' && $("#txtpersonal").val() != ''){
            $("#txtnombrepersonal").val($("#txtpersonal").val());
            $("#txtcodigoper").val($("#txtcodpersonal").val());
            $('#tbmaterialsalida').find("tr:gt(0)").remove();
            _sindevolver($("#txtcodpersonal").val());
            $("#mdpersonal").modal('hide');
        }
    });

    $(document).on('click','#btneliminar',function() {
        cod = $("#tbmaterialentrega tr").find('td')[0].innerHTML;
        cant = $("#tbmaterialentrega tr").find('td')[3].innerHTML;
        _devolverStock(cod,cant,'');
        $(this).closest('tr').remove();
    });

    $(document).on('click','#btnmodificar',function() {
        cod = $("#tbmaterialentrega tr").find('td')[0].innerHTML;
              $("#txtcodmaterial").val($("#tbmaterialentrega tr").find('td')[0].innerHTML);
              $("#txtmaterial").val($("#tbmaterialentrega tr").find('td')[1].innerHTML);
              $("#txtseriematerial").val($("#tbmaterialentrega tr").find('td')[2].innerHTML);
              $("#txtcanmaterial").val($("#tbmaterialentrega tr").find('td')[3].innerHTML)
       cant = $("#tbmaterialentrega tr").find('td')[3].innerHTML
      
       _devolverStock(cod,cant,'');
       $(this).closest('tr').remove();
    });

    $(document).on('click','#btnupdatemat',function() {
        codmaterial = $(this).closest('tr').find("td:nth-child(1)").text();
        serie = $(this).closest('tr').find("td:nth-child(3)").text();
       _update(codmaterial,serie,$(this));
    });

    $("#btnguardar").on('click',function () {
        var td =  $("#tdmaterialentrega  tr");
        var tds = [];
        for (let l = 0; l < td.length; l++) {
            tds[l] =[
                $(td[l]).find("td")[0].innerHTML,
                $(td[l]).find("td")[2].innerHTML,
                $(td[l]).find("td")[3].innerHTML
            ]
        }
        _guardar(tds);
    })

    $("#txtcanmaterial").on("keydown",function(e) {
        return _numeros(e);
    });
});

function _devolverStock(cod,cant,l) {
    almacen = $("#vroficina").val();
    $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  '../materiales/c_materialesalida.php',
        data:{
            "accion" : 'destock',
            "cdmaterial" : cod,
            "almacen" : almacen,
            "cantidad" : cant,
        } ,
        success:  function(response){
            console.log(l);
            if(l ==''){
                $("#txtstckmaterial").val(Number(response).toFixed(2));
            } 
        }
    });  
}


function _sindevolver($campo) {
    $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  '../materiales/c_materialesalida.php',
        data:{
            "accion" : 'sindevolver',
            "dato" : $campo,
        } ,
        success:  function(response){
           obj = JSON.parse(response);
            var btn = "<a id='btnupdatemat' class='btn btn-primary btn-sm btnsin'>"+
                    "<i class='icon-check'></i>"+
                  "</a>"
            $.each(obj['dato'], function(i, item) {
                var fila="<tr><td style='display: none;'>"+obj['dato'][i][2]+
                "</td><td>"+obj['dato'][i][4]+ "</td><td>"+obj['dato'][i][3]+
                "</td><td style='padding: .25rem 1.5rem;'>"+btn+"</td></tr>";
                var elem = document.createElement("TR");
                elem.innerHTML=fila;
                document.getElementById("tbmaterial").appendChild(elem);
            });
        }
    });    
}

$(document).on('hide.bs.modal', '.modal', function () {
    $("#txtpersonal").val('');
});

function _stock(cdmaterial,almacen) {
   cantidad = $("#txtcanmaterial").val();
   serie = $("#txtseriematerial").val();
   nommaterial = $("#txtmaterial").val();
   codper = $("#txtcodigoper").val();
    $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  '../materiales/c_materialesalida.php',
        data:{
            "accion" : 'stock',
            "codper" : codper,
            "cdmaterial" : cdmaterial,
            "almacen" : almacen,
            "cantidad" : cantidad,
            "serie" : serie,
            "material" : nommaterial
        } ,
        success:  function(response){
            v = response.split("/");
            if(v[0] > 0.00) _entrega(v[0],v[1]);
            else
            Mensaje1(v[0],'error');
        }
    });  
}

function _entrega(stock,cantidad) {
    b1 =  "<a id='btneliminar' class='btn btn-danger btn-sm'>"+
    "<i class='icon-trash'></i>"+
  "</a>"+ "<a id='btnmodificar' class='btn btn-primary btn-sm' style='float: right;'>"+
    "<i class='icon-pencil'></i>"+
  "</a>"
    array = [
        a = [$("#txtcodmaterial").val(),'none'],
        b = [$("#txtmaterial").val().toUpperCase(),''],
        c = [$("#txtseriematerial").val().toUpperCase(),''],
        d = [cantidad,''],
        i = [b1,''],
     ]
  
  _createtable(array,'tdmaterialentrega');
    $("#txtseriematerial").val('');
    
    $("#txtstckmaterial").val(Number(stock).toFixed(2)); 
}

function _buscarsugerencia(elemt,idelemt) {
    if(elemt.val().length == 0)$('#'+idelemt).fadeOut(0); 
    else  buscarlike(idelemt,elemt.val()); 
}

function buscarlike($accion,$campo) {
    var oficina = $("#vroficina").val();
    $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  '../materiales/c_materialesalida.php',
        data:{
            "accion" : $accion,
            "dato" : $campo,
            "almacen" : oficina
        } ,
        success:  function(response){
            sugerecias(response,$accion);
        }
    });   
}
function sugerecias(response,id) {
    $("#"+id).fadeIn(0).html(response);
       if(response != ""){
            $("#"+id).height(300);
            $("#"+id).css('overflow','scroll');
        }else{
            $("#"+id).height(0);
        }
            $('#'+id).fadeIn(0).html(response);            
            $('.suggest-element').on('click', function(){
            $("#txtstck"+id).val($(this).attr('datstc'));
            if($(this).attr('datatip') == '00001'){
                $("#txtcan"+id).attr('disabled','true');
                $("#txtserie"+id).removeAttr('disabled');
            }else{
                $("#txtcan"+id).removeAttr('disabled');
                $("#txtserie"+id).attr('disabled','true');
            }
            $("#txtcan"+id).val('');
            $("#txtserie"+id).val('');
            $("#txtcod"+id).val($(this).attr('dataid'));
            $("#txt"+id).val($(this).attr('data'));
            $('#'+id).fadeOut(0);
    });
}

function _numeros(e) {
    var key = window.Event ? e.which : e.keyCode
    return ((key >= 48 && key <= 57) || (key==8))
}

function _createtable(td,idtbttabla) {
    var fila="<tr>";
    for (let i = 0; i < td.length; i++) {
        fila +="<td  style=display:"+td[i][1]+">"+td[i][0]+"</td>";
    }
    fila += "</tr>";
    var btn = document.createElement("TR");
    btn.innerHTML=fila;
    document.getElementById(idtbttabla).appendChild(btn);
}

function _guardar(tds) {
    console.log($("#txtdescripcion").val().trim().replace(/\s+/gi, ' ').split(' ').length < 10);

   /* var codig = $("#txtcodigoper").val();
    var descripcion = $("#txtdescripcion").val();
    var perregistro = $("#vrcodpersonal").val();
    var materiales = {tds};
    $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  '../materiales/c_materialesalida.php',
        data:{
            "accion" : 'guardar',
            "codigo" : codig,
            "descr" : descripcion,
            "perregistro" :perregistro,
            "items" : JSON.stringify(materiales)
            } ,
            success:  function(response){
                if(response == 1){
                     Mensaje1("Se registro Correctamente",'success')
                        limpiar();
                    }else{
                        Mensaje1("Error al registrar",'error')
                    }
                }
            });  */  
}

function limpiar() {
    $('#tbmaterialentrega').find("tr:gt(0)").remove();
    $('#tbmaterialsalida').find("tr:gt(0)").remove();
    document.getElementById("frmmatsalida").reset();
}

function _update(codigo,serie,tb) {
    var usumodifico = $("#vrcodpersonal").val();
    $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  '../materiales/c_materialesalida.php',
        data:{
            "accion" : 'update',
            "usumodifico" : usumodifico,
            "codigo" : codigo,
            "serie" : serie,
        } ,
        success:  function(response){
            console.log(response);
            if(response == 1)
            tb.closest('tr').remove();

        }
    }); 
  
}

function retornar() {
    filas = $("#tdmaterialentrega  tr");
    for (let l = 0; l <filas.length ; l++) {
        cod = $(filas[l]).find("td")[0].innerHTML;
        can = $(filas[l]).find("td")[3].innerHTML;
        _devolverStock(cod,can,'0');
    }
}


function Mensaje1(texto,icono){
 Swal.fire({
  icon: icono,
  title: texto,
  //padding:'1rem',
  //grow:'fullscreen',
  //backdrop: false,
  //toast:true,
  //position:'top'	
  });
}