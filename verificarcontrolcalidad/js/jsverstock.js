var sugematerial = [];tipo = "";
$(document).ready(function () {
    autocompletarformulas();

    $("#btnbuscclien").on('click',function(){
        produccion($("#mdtxtpro").val(),$("#dtiniciomd").val());
    });
  
});

function produccion(codformula,fecha) {
    $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  'c_stockproducto.php',
        data:{
            "accion" : 'buscar',
            "formula" : codformula,
            "fecha" : fecha,
        } ,
        success:  function(e){
           obj = JSON.parse(e);
           $("#tbproducto > tbody").empty();
           $.each(obj['dato'], function(i, item) {
                var fila='';
                var id = Number(i)+1;
                fila +="<td class='tdcontent' style=display:none>"+item[0]+"</td>";
                fila +="<td class='tdcontent'>"+id+"</td>";
                fila +="<td class='tdcontent'>"+item[2]+"</td>";
                fila +="<td class='tdcontent'>"+item[9]+"</td>";
                fila +="<td class='tdcontent'><a id='btncontrol' style='margin-right: 1px;margin-bottom: 1px;' class='btn btn-primary  btn-sm'>"+
                "<i class='icon-eye' title='Actualizar tareas'></i></a></td>";
                var btn = document.createElement("TR");
                btn.innerHTML=fila;
                document.getElementById('tbdproducto').appendChild(btn);
           });
        }
     });     
}

function autocompletarformulas() {
    sugematerial = []
    buscarformulas();
    $("#txtproduccion").autocomplete({
      source: sugematerial,
        select: function (event, ui) {
          $("#mdtxtpro").val(ui.item.code);
          $("#txtproduccion").val(ui.item.label);
         
        }
    });
}

function buscarformulas(){
    $.ajax({
      dataType:'text',
      type: 'POST', 
      url:  'c_stockproducto.php',
      data:{
          "accion" : 'lstmaterial',
      } ,
      success:  function(response){
          obj = JSON.parse(response);
          $.each(obj['dato'], function(i, item) {
            sugematerial.push(item);
          });
      }
    });
}

function Mensaje1(texto,icono){
    Swal.fire({
     icon: icono,
     title: texto,
     });
}

function controlcalidad(produccion) {
    $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  'c_stockproducto.php',
        data:{
            "accion" : 'lstmaterial',
            "produccion": produccion
        } ,
        success:  function(response){
            obj = JSON.parse(response);
            console.log(obj['d']);
        }
    });
}