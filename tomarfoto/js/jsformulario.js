var idpers = "";
var nompersonal = "";
var codproveedor = "";
$(document).ready(function(){
    listarempresa();
    
    //estado

    $("html").click(function(){
        $('#sugerencias').fadeOut(0); 
        $('#buscarpersonal').fadeOut(0);
    });

    $("#txtseriedocument").keyup(function(e) {
        var input=  document.getElementById('txtseriedocument');
            input.addEventListener('input',function(){
                this.value = this.value.slice(0,4); 
        })
    })

    $("#txtruc").keyup(function(e) {
        var input=  document.getElementById('txtruc');
            input.addEventListener('input',function(){
                this.value = this.value.slice(0,11); 
        })
    })

    $('#modalpersonal').on('shown.bs.modal', function (e) {
        $('#txtbuscarpers').focus();
    })

    $("#txtbuscarpers").on('keyup',function () {
        var personal = $("#txtbuscarpers").val();      
         buscarpersonal(personal);
     });

    $("#txtproveedor").on('keyup',function () {
       var proveedor = $("#txtproveedor").val();      
        buscarproveedor(proveedor);
    });

    $("#slcempresa").change(function name(params) {
        var ruc = $(this).find(':selected').data('ruc');
        $("#txtruc").val(ruc);
    });

    $(document).on('click','#mostaraimagen',function name() {
        var nombreimg = $(this).attr('data');
        buscaimg(nombreimg);
    });

    $("#grabar").click(function name(params) {
        $("#modalpersonal").modal("show");
    });

    $("#txtseriedocument").keypress(function (e) {
        return soloNumeros(e);
    })

    $("#agregarpersonal").click(function () {
        console.log("ds");
        $("#txtcodpersonal").val(idpers);
        $("#txtnombreper").val(nompersonal); 
        $("#modalpersonal").modal('hide')    
    });

    $(document).on('click','#verimg',function name() {
        var nombre = $(this).attr('data-img');
        alert(nombre);
        buscaimg(nombre);
    });
 
});


function buscarproveedor(proveedor) {
    $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  './seguimiento/c_empresas.php',
        data:{
            "tipo" : "buscarpro",
            "proveedor" : proveedor,
        } ,
        success: function name(response) {
           
          $("#sugerencias").fadeIn(0).html(response);
            if(response != ""){
                $("#sugerencias").height(200);
                $("#sugerencias").css('overflow','scroll');
            }else{
                $("#sugerencias").height(0);
            }

               $('.suggest-element').on('click', function(){
                    codproveedor =  $(this).attr('id');
                    var datos = $(this).attr('data');
                    var proveedor = $(this).attr('data-val');
                    $("#txtdirproveedor").val(datos);
                    $("#txtproveedor").val(proveedor);
                });  
        }
    });
}

function buscarpersonal(personal) {
    $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  './seguimiento/c_empresas.php',
        data:{
            "tipo" : "buscarper",
            "personal" : personal,
        } ,
        success: function name(response) {
           
          $("#buscarpersonal").fadeIn(0).html(response);
            if(response != ""){
                $("#buscarpersonal").height(200);
                $("#buscarpersonal").css('overflow','scroll');
            }else{
                $("#buscarpersonal").height(0);
            }

               $('.element-per').on('click', function(){
                    idpers =  $(this).attr('id');
                    nompersonal = $(this).attr('data-val');
                    $('#txtbuscarpers').val(nompersonal);
                });  
        }
    }); 
}


function listarempresa() {
 $.ajax({
    dataType:'text',
    type: 'POST', 
    url:  './seguimiento/c_empresas.php',
    data: {
        "tipo" : "listarempresa"
    },
    success: function(response){
        $("#slcempresa").append(response);
    }
 })
}

function validacion() {
   var idpersonal = $("#txtcodpersonal").val();
   var oficina = $("#vroficina").val();
   var usuarioregistro = $("#vrcodpersonal").val();
   var caja = $("#slcconcepto").find(':selected').data('caja');
   caja = (caja == undefined) ? ' ' : caja;
   var data = $("#frmcomprovante");
    $.ajax({
       dataType:'text',
       type: 'POST', 
       url:  './seguimiento/c_validacion.php',
       data: data.serialize()+"&idpersonal="+idpersonal+"&oficina="+oficina+"&usuario="+usuarioregistro+"&codproveedor="+codproveedor
       +"&tipo="+null+"&caja="+caja,
       success: function(response){
           console.log(response);
           obj = JSON.parse(response)
           console.log(obj['1']);
            if(obj['1'] == "error"){
                mensajesError(obj['0'],"mensajesgenerales");
            }else{
                mensajeSuccess(obj['0'],"mensajesgenerales");
                document.getElementById("frmcomprovante").reset();
            }
       }
    })
   }

   function buscaimg(nombreimg) {
    $.ajax({
       dataType:'text',
       type: 'POST', 
       url:  './seguimiento/c_empresas.php',
       data: {
           "tipo" : "mostrarimg",
           "nombreimg" : nombreimg
       },
       success: function(response){
        imgElem.setAttribute('src', "data:image/jpg;base64,"+response);
        $("#modalimg").modal('show');
       }
    }) 
   }

   function mensajesError(texto,id) {
        mensaje = '<div class="alert alert-warning alert-dismissible fade show" role="alert" id="">'+
        '<strong>Advertencia: </strong>'+texto+
        '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>'+
        '</div>';
        $('#'+id).html(mensaje);
        window.scrollTo(0, 0);
    }
 
    function mensajeSuccess(texto,id) {
        mensaje = '<div class="alert alert-success alert-dismissible fade show" role="alert" id="">'+
        '<strong></strong>' + texto+
        '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>'+
        '</div>';
        $('#'+id).html(mensaje);
        window.scrollTo(0, 0);
    }
 
    function soloNumeros(e)
    {
        var key = window.Event ? e.which : e.keyCode
        return ((key >= 48 && key <= 57) || (key==8))
    }

    function validacioninput() {
       
        if($("#slcempresa").val() == ""){
            mensajesError("Seleccione una EMPRESA","mensajesgenerales");
        }else if($("#txtcodpersonal").val() == ""){
            mensajesError("Ingrese codigo de personal","mensajesgenerales");
        }else if($("#slcdocumento").val() == ""){
            mensajesError("Seleccione TIPO DOCUMENTO","mensajesgenerales");
        }else if($("#txtruc").val().substr(0,2) == 20 && $("#slcdocumento").val() != 01){
            mensajesError("RUC 20 debe ser Factura","mensajesgenerales");
        }else if($("#txtseriedocument").val().length > 4 || $("#txtseriedocument").val().length == 0){
            mensajesError("SERIE DOCUMENTO no puede ser mayor a 4 digitos o estar vacio","mensajesgenerales");
        }else if(($("#txtseriedocument").val().length < 4)){
            mensajesError("SERIE DOCUMENTO no puede ser menor a 4 digitos","mensajesgenerales");
        }else{
            validacion();
        }
       
    }
