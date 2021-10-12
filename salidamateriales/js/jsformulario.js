
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
            for (let l = 0; l <filas.length ; l++) {
                if($(filas[l]).find("td")[2].innerHTML != ""){
                    if($(filas[l]).find("td")[2].innerHTML == sre.toUpperCase().trim()){
                        Mensaje1("Nro de serie ya registrado",'error');
                        return;    
                    }
                }
            }
        _stock($("#txtcodmaterial").val(),$("#vroficina").val());
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
        cod = $(this).parents('tr').find('td:first-child').text();
        cant = $(this).parents('tr').find('td:nth-child(4)').text();
        $("#txtmaterial").val('');
        $("#txtstckmaterial").val('');
        _devolverStock(cod,cant,'1');
        $(this).closest('tr').remove();
    });

    $(document).on('click','#btnmodificar',function() {
        cod = $(this).parents('tr').find('td:first-child').text();
              $("#txtcodmaterial").val($(this).parents('tr').find('td:first-child').text());
              $("#txtmaterial").val($(this).parents('tr').find('td:nth-child(2)').text());
              $("#txtseriematerial").val($(this).parents('tr').find('td:nth-child(3)').text());
              $("#txtcanmaterial").val($(this).parents('tr').find('td:nth-child(4)').text());
       cant = $(this).parents('tr').find('td:nth-child(4)').text();
      
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

    $("#txtcanmaterial").bind('keypress', function(e) {
        return _numeros(e);
    });

    $("#txtdescripcion").bind('keypress', function(e) {
        return letras(e)    
    });

    $("#btnguardarprod").on('click',function () {
        guardarProducto();
    })

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
            console.log(response);
            v = response.split("/");
            console.log(v);
            if(l == ""){
                if(v[1] == 0){
                    $("#txtseriematerial").removeAttr('disabled');
                    $("#txtcanmaterial").attr('disabled','true');  
                }else{
                    $("#txtcanmaterial").removeAttr('disabled');
                    $("#txtseriematerial").attr('disabled','true');  
                }
                $("#txtstckmaterial").val(Number(v[0]).toFixed(2));
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
            c = 0;
            if(v[2] == 2){
                c = datosrepetidos("tdmaterialentrega",v[0],v[1]);
            }
            if(c != 1){
                if(v[0] > 0.00) _entrega(v[0],v[1]);
                else
                Mensaje1(v[0],'error');
            }
        }
    });  
}

function datosrepetidos(tabla,stock,cantidad) {
    console.log(cantidad);
    filas = $("#"+tabla+" tr");
    for (let l = 0; l < filas.length; l++) {
        if($(filas[l]).find("td")[0].innerHTML == $("#txtcodmaterial").val()){
            $(filas[l]).find("td")[3].innerHTML = Number($(filas[l]).find("td")[3].innerHTML) + Number(cantidad);    
            $("#txtseriematerial").val('');
            $("#txtstckmaterial").val(Number(stock).toFixed(2)); 
            return 1;
        }
    }
    return 0;
}


function _entrega(stock,cantidad) {
    b1 = "<a id='btneliminar' class='btn btn-danger  btn-sm' style='float: right;'>"+
        "<i class='icon-trash'></i>"+
        "</a>"+ "<a id='btnmodificar' class='btn btn-primary btn-sm'>"+
            "<i class='icon-pencil'></i>"+
        "</a>" ;
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
    if($("#txtdescripcion").val().trim().split(' ').length < 10){
        Mensaje1('Campo descripcion debe tener almenos 10 palabras','error')
        return;
    };
    var codig = $("#txtcodigoper").val();
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
                console.log(response);
                if(response == 1){
                     Mensaje1("Se registro Correctamente",'success')
                        limpiar();
                    }else{
                        Mensaje1(response,'error')
                    }
                }
        });
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
            if(response == 1){
                tb.closest('tr').remove();
                Mensaje1("Se registro la devolucion","success");
            }else{
                Mensaje1("Error al registrar","error");
            }
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

function letras(e) {
    var regex = new RegExp("^[a-zA-Z ]+$");
    var key = String.fromCharCode(!e.charCode ? e.which : e.charCode);
    if (!regex.test(key)) {
      e.preventDefault();
      return false;
    }
};

function _numeros(e) {
    var regex = new RegExp("^[0-9]+$");
    var key = String.fromCharCode(!e.charCode ? e.which : e.charCode);
    if (!regex.test(key)) {
      e.preventDefault();
      return false;
    }
}

function guardarProducto() {
   var perregistro = $("#vrcodpersonal").val();
   var producto = $("#mtxtnombreproducto").val();
   var unidad = $("#mtxtunimedida").val();
   var codigopro = $("#mtxtcodigopro").val();
   var stock = $("#mtxtstock").val();
   var abre = $("#mtxtabreviatura").val();
   var contable = $("#mtxtcontable").val();
   var neto = $("#mtxtneto").val();
   var clase = $("#slclase").val();
    $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  '../materiales/c_materialesalida.php',
        data:{
            "accion" : 'guardarproc',
            "producto" : producto,
            "unidad" : unidad,
            "codigopro" :codigopro,
            "abre" : abre,
            "contable" :contable,
            "neto" : neto,
            "stock" : stock,
            "clase" : clase,
            "personal" : perregistro
        } ,
            success:  function(response){
                console.log(response);
                if(response == 1){
                     Mensaje1("Se registro Correctamente",'success');
                     document.getElementById("frmagregarProducto").reset();
                }else{
                    Mensaje1("Error ingrese los datos correctamente",'error')
                }
            }
    });
}