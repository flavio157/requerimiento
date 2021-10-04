
$(document).ready(function() {
    $("#aentrega").on('click',function() {
        b1 =  "<a id='btneliminar' class='btn btn-primary active btn-sm'>"+
        "<i class='icon-trash'></i>"+
      "</a>"+ "<a id='btnmodificar' class='btn btn-primary active btn-sm' style='float: right;'>"+
        "<i class='icon-pencil'></i>"+
      "</a>"
        array = [
            a = [$("#txtcodmaterial").val(),'none'],
            b = [$("#txtmaterial").val().toUpperCase(),''],
            c = [$("#txtnroserie").val().toUpperCase(),''],
            i = [b1,''],
         ]
        _createtable(array,'tdmaterialentrega')
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
        $("#txtnombrepersonal").val($("#txtpersonal").val());
        $("#txtcodigoper").val($("#txtcodpersonal").val());
        $("#mdpersonal").modal('hide');
    });

    $(document).on('click','#btneliminar',function() {
        $(this).closest('tr').remove();
    })

    $(document).on('click','#btnmodificar',function() {
       $("#txtcodmaterial").val($("#tbmaterialentrega tr").find('td')[0].innerHTML);
       $("#txtmaterial").val($("#tbmaterialentrega tr").find('td')[1].innerHTML);
       $("#txtnroserie").val($("#tbmaterialentrega tr").find('td')[2].innerHTML);
       $(this).closest('tr').remove();
    })

    $("#btnguardar").on('click',function () {
        _guardar();
    })

    $("#btnAddpersonal").on('click',function () {
        _sindevolver($("#txtcodpersonal").val());
    })
});

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
            var btn = "<a id='btnmodificar' class='btn btn-primary active btn-sm' style='float: right;'>"+
                    "<i class='icon-check'></i>"+
                  "</a>"
            $.each(obj['dato'], function(i, item) {
                var fila="<tr><td style='display: none;'>"+obj['dato'][i][2]+
                "</td><td>"+obj['dato'][i][4]+ "</td><td>"+obj['dato'][i][3]+
                "</td><td>"+btn+"</td></tr>";
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

function _buscarsugerencia(elemt,idelemt) {
    if(elemt.val().length == 0)$('#'+idelemt).fadeOut(0); 
    else  buscarlike(idelemt,elemt.val()); 
}

function buscarlike($accion,$campo) {
    $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  '../materiales/c_materialesalida.php',
        data:{
            "accion" : $accion,
            "dato" : $campo,
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
            //var cod =$(this).attr('dataid');
            $("#txtcod"+id).val($(this).attr('dataid'));
            $("#txt"+id).val($(this).attr('data'));
            $('#'+id).fadeOut(0);
    });
}

function limpiar() {
   $("#txtcodmatentrega").val('');
   $("#txtmatentrega").val('');
   $("#txtcantmatentrega").val('');
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
    limpiar() 
}

function validacion() {
    if(
        $("#txtcodmatentrega").val().length == 0 &&
        $("#txtmatentrega").val().length == 0 &&
        $("#txtcantmatentrega").val().length == 0
        ){
            mensajeSuccess("Error ingrese los datos correctamente","mensajesgenerales","alert-warning");
            return true;
    }
}

function mensajeSuccess(texto,id,tipo) {
    mensaje = '<div class="alert alert-warning alert-dismissible fade show" role="alert" id="">'+
    '<strong></strong>' + texto+
    '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>'+
    '</div>';
     $('#'+id).html(mensaje);
     window.scrollTo(0, 0);
}

function _guardar() {
    var codig = $("#txtcodigoper").val();
    var descripcion = $("#txtdescripcion").val();
    var td =  $("#tdmaterialentrega  tr");
    var tds = [];
    console.log(td.length);
    for (let l = 0; l < td.length; l++) {
        tds[l] =[
            $(td[l]).find("td")[0].innerHTML,
            $(td[l]).find("td")[2].innerHTML
        ]
    }
    console.log(tds);
  /*  $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  '../materiales/c_materialesalida.php',
        data:{
            "accion" : $accion,
            "codigo" : codig,
            "descr" : descripcion,
            "dato" : $campo,
        } ,
        success:  function(response){
            sugerecias(response,$accion);
        }
    }); */ 
}