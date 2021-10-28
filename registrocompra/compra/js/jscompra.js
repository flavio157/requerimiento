var supersonal =[];

$(function() {
  //  document.querySelector('#rdnsi').checked = true;

    $('body').on('keydown', function(e){
        if( e.which == 38 ||  e.which == 40) {
          return false;
        }
    });
    _lstautocomplete('personal',supersonal);
    $("#txtcompersonal").autocomplete({
      source: supersonal,
        select: function (event, ui) {
          $("#txtcomcodpers").val(ui.item.code);
        }
    });

    autocompletarMaterial();
    
    _categoria('lstcategoria','slcategoria');
    _categoria('lstclase','slclase');

    $("#btnguardarprod").on('click',function() {
        _guardarProducto();
    })

    $("#mtxtstockmin").bind('keypress',function(e) {
        return _numeros(e);
    })
    $("#mtxtunimedida").bind('keypress',function(e) {
        return _letras(e);
    })
    $("#mtxtabreviatura").bind('keypress',function(e) {
        return _letras(e);
    })
    $("#mtxtneto").bind('keypress',function(e) {
        return _numeros(e);
    })
    $("#mtxtnombreproducto").bind('keypress',function(e) {
        return _letras(e);
    })
    
    $("#btng_compro").on('click',function (params) {
        var oficina = $("#frmcomprobante").serialize();
        if($("#txtcomfecemision").val() == ''){Mensaje1("Ingrese fecha de emision","error"); return}
        if($("#txtcomhoremision").val() == ''){Mensaje1("Ingrese hora de emision","error"); return}
        if($("#txtcomfecentrega").val() == ''){Mensaje1("Ingrese fecha de entrega","error"); return}
        if($("#txtcomcodpers").val() == ''){Mensaje1("Ingrese personal","error"); return}
        if($("#txtcompersonal").val() == ''){Mensaje1("Ingrese personal","error"); return}
        if($("#slctipocompr").val() == ''){Mensaje1("Selecciones tipo comprobante","error");return}
        if($("#slcformpago").val() == ''){Mensaje1("Seleccione forma de pago","error");return}
        if($("#slcmoneda").val() == ''){Mensaje1("Seleccione moneda","error");return}
        if(!$("#rdnsi").is(':checked') && !$("#rdnno").is(':checked')) {Mensaje1("seleccione","error");return;}
    })

    $("#rdnsi").on('change',function() {
        $("#rdnsi").val('0');$("#rdnno").val('');
    });
    $("#rdnno").on('change',function() {
        $("#rdnsi").val('');$("#rdnno").val('1');
    });

    $("#btnatproduc").on('click',function() {
        validatos();
    })
});
function validatos() {
    var clase = $("#txtcompclase").val();
    var codigo = $("#txtcompcodPro").val();
    var produ = $("#txtcompprod").val();
    var cant = $("#txtcomcantidad").val();
    var precio = $("#txtcomprecio").val();
    var serie = $("#txtcomserie").val();
    $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  'c_comprobante.php',
        data:{
            "accion":'verdatpro',"clase":clase,"codigo":codigo,"produ":produ,"cant":cant,
            "precio":precio,"serie":serie
        } ,
        success:  function(response){
            Mensaje1(texto,icono)
        }
    }); 
}

function _lstautocomplete(accion,array) {
    $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  'c_comprobante.php',
        data:{
            "accion" : accion,
        } ,
        success:  function(response){
            obj = JSON.parse(response);
            $.each(obj['dato'], function(i, item) {
                array.push(item); 
            });
        }
    }); 
}

function _categoria(accion,id) {
    $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  'c_comprobante.php',
        data:{
            "accion" : accion,
        } ,
        success:  function(response){
            obj = JSON.parse(response);
            $.each(obj['dato'],function(i,item) {
               $('#'+id).append($("<option value="+item[0]+">"+item[1]+"</option>" ));  
            });
        }
    }); 
}

function _guardarProducto() {
    var producto = $("#mtxtnombreproducto").val();
    var codigopro = $("#mtxtcodigopro").val();
    var categoria =$("#slcategoria").val();
    var unidad = $("#mtxtunimedida").val();
    var sctockmin = $("#mtxtstockmin").val();
    var usuregis = $("#vrcodpersonal").val();
    var abre = $("#mtxtabreviatura").val();
    var neto = $("#mtxtneto").val();
    var clase = $("#slclase").val();
    var oficina = $("#vroficina").val();
     $.ajax({
         dataType:'text',
         type: 'POST', 
         url:  'c_comprobante.php',
         data:{
             "accion" : 'guardarproc',
             "nomprod" : producto,
             "codigopro" :codigopro,
             "categoria" : categoria,
             "unidad" : unidad,
             "sctockmin":sctockmin,
             "abre" : abre,
             "neto" : neto,
             "clase" : clase,
             "usuregis" : usuregis,
             "oficina" : oficina
         } ,
             success:  function(response){
                 if(response == 1){
                      Mensaje1("Se registro Correctamente",'success');
                      document.getElementById("frmguardaprod").reset();
                 }else{
                     Mensaje1(response,'error')
                 }
                 autocompletarMaterial()
             }
     });
}

function _letras(e) {
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

function Mensaje1(texto,icono){
    Swal.fire({
     icon: icono,
     title: texto,
     //text: texto,
     //padding:'1rem',
     //grow:'fullscreen',
     //backdrop: false,
     //toast:true,
     //position:'top'	
     });
}

function autocompletarMaterial() {
    var suproducto =[];
    _lstautocomplete('producto',suproducto);
    $("#txtcompprod").autocomplete({
      source: suproducto,
        select: function (event, ui) {
          $("#txtcompcodPro").val(ui.item.code);
          $("#txtcompclase").val(ui.item.clase);
        }
    });
}