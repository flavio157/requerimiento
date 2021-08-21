$(document).ready(function name(params) {
    nro_reclamo();
   
    $("#btnguardar").on('click',function name(e) {
        guardarReclamo();
        e.preventDefault();
    });

    $("#btnnuevo").on('click',function name(e) {
        document.getElementById("frmreclamos").reset();
        nro_reclamo();
        $("#alerta").alert("close");
        e.preventDefault();
        
    });

    $("#txtruc").keypress(function(e) {
       
        var input=  document.getElementById('txtruc');
            input.addEventListener('input',function(){
                this.value = this.value.slice(0,11);
            });
            return soloNumeros(e);    
    })

    $("#txtdni").keypress(function(e) {
        var input=  document.getElementById('txtdni');
            input.addEventListener('input',function(){
                this.value = this.value.slice(0,8);
            });
            return soloNumeros(e);        
    })
    
    $("#txtcedula").keypress(function(e) {
        var input=  document.getElementById('txtcedula');
            input.addEventListener('input',function(){
                this.value = this.value.slice(0,12);
            })
            return soloNumeros(e);        
    })

    $("#txttelefono").keypress(function(e) {
       
        var input=  document.getElementById('txttelefono');
            input.addEventListener('input',function(){
                this.value = this.value.slice(0,11);
            })
            return soloNumeros(e);    
    })

    $('#txtmonto').keypress(function(e) {
       return soloNumeros(e);
    });

    $("#txtdiarespuesta").keypress(function (e) {
        var input=  document.getElementById('txtdiarespuesta');
            input.addEventListener('input',function(){
                this.value = this.value.slice(0,2);
            })
        return soloNumeros(e);  
    });

    $("#txtmesrespuesta").keypress(function (e) {
        var input=  document.getElementById('txtmesrespuesta');
            input.addEventListener('input',function(){
                this.value = this.value.slice(0,2);
            })
        return soloNumeros(e);
    });

    $("#txtanorespuesta").keypress(function (e) {
        var input=  document.getElementById('txtanorespuesta');
        input.addEventListener('input',function(){
            this.value = this.value.slice(0,4);
        })
        return soloNumeros(e);
    });
});





function guardarReclamo() {
    var data = $("#frmreclamos");
    var nro_reclamo = $('#nroreclamo').html();
    dia = $("#txtdiareclamo").val();
    mes = $("#txtmesreclamo").val();
    ano = $("#txtanoreclamo").val();
    console.log(data.serialize());
      $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  './reclamacion/c_reclamos.php',
        data:data.serialize()+"&accion=guardar&nroreclamo="+nro_reclamo+"&txtdiareclamo="+dia+"&txtmesreclamo="+mes+"&txtanoreclamo="+ano,
        success: function(response){
            console.log(response);
            if(response == 1)
            mensajeSuccess("SE REGISTRO LOS DATOS CORRECTAMENTE","mensaje");
            else
            mensajesError(response,"mensaje");
        }
      });
}

function nro_reclamo() {
       $.ajax({
         dataType:'text',
         type: 'POST', 
         url:  './reclamacion/c_reclamos.php',
         data:{
             "accion":"nroreclamo"
         },
         success: function(response){
             $('#nroreclamo').html(response);
         }
       });
}


function soloNumeros(e){
    var key = window.Event ? e.which : e.keyCode
    return ((key >= 48 && key <= 57) || (key==8))
}

function mensajesError(texto,id) {
    mensaje = '<div class="alert alert-warning alert-dismissible fade show" role="alert" id="alerta">'+
    '<strong>Advertencia: </strong>'+texto+
    '<button type="button" class="btn-close" id="btncerrar" data-bs-dismiss="alert" aria-label="Close"></button>'+
    '</div>';
     $('#'+id).html(mensaje);
     window.scrollTo(0, 0);
 }
 


 function mensajeSuccess(texto,id) {
    mensaje = '<div class="alert alert-success alert-dismissible fade show" role="alert" id="alerta">'+
    '<strong></strong>' + texto+
    '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>'+
    '</div>';
     $('#'+id).html(mensaje);
     window.scrollTo(0, 0);
}