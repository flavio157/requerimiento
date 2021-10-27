var supersonal =[];
var suproducto =[];
$(function() {
    $('body').on('keydown', function(e){
        if( e.which == 38 ||  e.which == 40) {
          return false;
        }
    });
    _lstautocomplete('personal',supersonal);
    $("#txtcomppersonal").autocomplete({
      source: supersonal,
        select: function (event, ui) {
          $("#txtcompcodpers").val(ui.item.code);
        }
    });

    _lstautocomplete('producto',suproducto);
    $("#txtcompprod").autocomplete({
      source: suproducto,
        select: function (event, ui) {
          $("#txtcompcodPro").val(ui.item.code);
        }
    });
    
    _categoria('lstcategoria','slcategoria');
    _categoria('lstclase','slclase');

});

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
               $('#'+id).append($("<option values="+item[0]+">"+item[1]+"</option>" ));  
            });
        }
    }); 
}


function guardarProducto() {
    var perregistro = $("#vrcodpersonal").val();
    var producto = $("#mtxtnombreproducto").val();
    var unidad = $("#mtxtunimedida").val();
    var codigopro = $("#mtxtcodigopro").val();
    var abre = $("#mtxtabreviatura").val();
    var neto = $("#mtxtneto").val();
    var clase = $("#slclase").val();
    var oficina = $("#vroficina").val();
     $.ajax({
         dataType:'text',
         type: 'POST', 
         url:  'c_materialesalida.php',
         data:{
             "accion" : 'guardarproc',
             "producto" : producto,
             "unidad" : unidad,
             "codigopro" :codigopro,
             "abre" : abre,
             "neto" : neto,
             "clase" : clase,
             "personal" : perregistro,
             "oficina" : oficina
         } ,
             success:  function(response){
                 if(response == 1){
                      Mensaje1("Se registro Correctamente",'success');
                      document.getElementById("frmagregarProducto").reset();
                 }else{
                     Mensaje1("Error ingrese los datos correctamente",'error')
                 }
                 autocompletarMaterial()
             }
     });
 }