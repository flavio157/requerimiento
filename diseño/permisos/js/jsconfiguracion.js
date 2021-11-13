$(document).ready(function (params) {
   listarmenu();
   lstmenu();
   $('#tbmenu').on('click', 'tbody tr', function(event) {
      $(this).addClass('highlight').siblings().removeClass('highlight');
      var dato =  $(this).find("td:eq(0)").text();
      $("#tbsubmenu > tbody").empty();
      $("#subsubmenu > tbody").empty();
      $("#txturlmenu").prop('disabled', false);
      $("#txtidmenu").val(dato)
      lstsubmenu(dato);
   });

   $('#tbsubmenu').on('click', 'tbody tr', function(event) {
      $(this).addClass('highlight').siblings().removeClass('highlight');
      var idmenu =  $(this).find("td:eq(0)").text();
      var idsubmenu =  $(this).find("td:eq(1)").text();
      $("#txtidsubmenu").val(idsubmenu)
      $("#subsubmenu > tbody").empty();
      $("#txturlsubmenu").prop('disabled', false);
      lstsubsubmenu(idmenu,idsubmenu);
   });

   $(document).on('click','#btnmenu',function () {
       id =  $(this).parents('tr').find('td:first-child').text();
       nombre =  $(this).parents('tr').find('td:nth-child(2)').text();
       url =  $(this).parents('tr').find('td:nth-child(3)').text();
       estado =  $(this).parents('tr').find('td:nth-child(4)').text();
       $("#txtnommenu").val(nombre);
       $("#txturlmenu").val(url);
       $("#txtidmenu").val(id);
       $("#txtestmenu").val(estado);
       if(estado == 1){document.querySelector('#rdactimenu').checked = true;}
       else{document.querySelector('#rddescmenu').checked = true;}
   });

   $(document).on('click','#btnsubmenu',function(){
      idmenu =  $(this).parents('tr').find('td:first-child').text();
      idsubmenu =  $(this).parents('tr').find('td:nth-child(2)').text();
      nombre =  $(this).parents('tr').find('td:nth-child(3)').text();
      url =  $(this).parents('tr').find('td:nth-child(4)').text();
      estado =  $(this).parents('tr').find('td:nth-child(5)').text();
      $("#txtnomsubmenu").val(nombre);
      $("#txturlsubmenu").val(url);
      $("#txtidsubmenu").val(idsubmenu)
      if(estado == 1){document.querySelector('#rdactisubmenu').checked = true;}
      else{document.querySelector('#rddescsubmenu').checked = true;}
   });

   $(document).on('click','#btnsubsubmenu',function () {
      idmenu =  $(this).parents('tr').find('td:first-child').text();
      idsubmenu =  $(this).parents('tr').find('td:nth-child(2)').text();
      idsubsubmenu =  $(this).parents('tr').find('td:nth-child(3)').text();
      nombre =  $(this).parents('tr').find('td:nth-child(4)').text();
      url =  $(this).parents('tr').find('td:nth-child(5)').text();
      estado =  $(this).parents('tr').find('td:nth-child(6)').text();
      $("#txtsubsubnombe").val(nombre);
      $("#txtsubsuburl").val(url);
      $("#txtidsubsubmenu").val(idsubsubmenu);
      $("#txtestsubsubmenu").val(estado);
      console.log(estado);
      if(estado == 1){document.querySelector('#rdactisubsubmenu').checked = true;}
      else{document.querySelector('#rddescsubsubmenu').checked = true;}
  });

  $("#btngmenus").on('click',function() {
    _actualizar($("#txtidmenu").val(),"","",$("#txtnommenu").val(),$("#txturlmenu").val(),$("#txtestmenu").val())
  });

  $("input[id=rdactimenu]").change(function () {
      $("#txtestmenu").val(1);
  });

  $("input[id=rddescmenu]").change(function () {	
      $("#txtestmenu").val(0);
  });

  $("#btngsubmenu").on('click',function(){
      _actualizar($("#txtidmenu").val(),$("#txtidsubmenu").val(),"",$("#txtnomsubmenu").val(),$("#txturlsubmenu").val(),$("#txtestsubmenu").val())
  })

  $("input[id=rdactisubmenu]").change(function () {
      $("#txtestsubmenu").val(1);
   });

   $("input[id=rddescsubmenu]").change(function () {	
      $("#txtestsubmenu").val(0);
   });

   $("#btngsubsubmenu").on('click',function() {
      _actualizar($("#txtidmenu").val(),$("#txtidsubmenu").val(),$("#txtidsubsubmenu").val(),$("#txtsubsubnombe").val(),$("#txtsubsuburl").val(),$("#txtestsubsubmenu").val()) 
   });

   $("input[id=rdactisubsubmenu]").change(function () {
      $("#txtestsubsubmenu").val(1);
   });

   $("input[id=rddescsubsubmenu]").change(function () {	
      $("#txtestsubsubmenu").val(0);
   });

});

function listarmenu() {
   $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  'c_guardar_permisos.php',
        data: {
            "accion" : 'listar',
        },
        success: function(response){
          $("#tree").html(response);   
        }
   });
}

function lstmenu(){
   $.ajax({
      dataType:'text',
      type: 'POST', 
      url:  'c_guardar_permisos.php',
      data: {
          "accion" : 'lstmenu',
      },
      success: function(response){
         b1 = "<a id='btnmenu' class='btn btn-primary btn-sm' style='float:right;'><i class='icon-pencil'>"
         obj = JSON.parse(response);
         $.each(obj['dato'], function(i, item) {
            var fila="<tr>";
            fila += " <td style='display:none'>"+item[0]+"</td>"
            fila += " <td>"+item[1]+"</td>"
            fila += " <td style='display:none'>"+item[2]+"</td>"
            fila += " <td style='display:none'>"+item[3]+"</td>"
            fila += " <td >"+b1+"</td>"
            fila += "</tr>";
            var btn = document.createElement("TR");
            btn.innerHTML=fila;
            document.getElementById("tbdmenu").appendChild(btn);
         });
       
      }
 });
}


function lstsubmenu(idmenu){
   $.ajax({
      dataType:'text',
      type: 'POST', 
      url:  'c_guardar_permisos.php',
      data: {
          "accion" : 'lstsubmenu',
          "idmenu":idmenu
      },
      success: function(response){
         b1 = "<a id='btnsubmenu' class='btn btn-primary btn-sm' style='float:right;'><i class='icon-pencil'>"
         obj = JSON.parse(response);
         $.each(obj['dato'], function(i, item) {
            if(item[3] != ""){
               var fila="<tr>";
               fila += " <td style='display:none'>"+item[1]+"</td>"
               fila += " <td style='display:none'>"+item[2]+"</td>"
               fila += " <td>"+item[3]+"</td>"
               fila += " <td style='display:none'>"+item[4]+"</td>"
               fila += " <td style='display:none'>"+item[9]+"</td>"
               fila += " <td >"+b1+"</td>"
               fila += "</tr>";
               var btn = document.createElement("TR");
               btn.innerHTML=fila;
               document.getElementById("tbdsubmenu").appendChild(btn);
            }
            $("#txturlmenu").prop('disabled', true);
         });
      }
 });
}

function lstsubsubmenu(idmenu,idsubmenu){
   $.ajax({
      dataType:'text',
      type: 'POST', 
      url:  'c_guardar_permisos.php',
      data: {
          "accion" : 'lstsubmenu2',
          "idmenu":idmenu,
          "idsubmenu":idsubmenu
      },
      success: function(response){
         b1 = "<a id='btnsubsubmenu' class='btn btn-primary btn-sm' style='float:right;'><i class='icon-pencil'>"
         obj = JSON.parse(response);
         $.each(obj['dato'], function(i, item) {
            $("#txturlsubmenu").prop('disabled', true);
            if(item[7] != ""){
               var fila="<tr>";
               fila += " <td style='display:none'>"+item[1]+"</td>"
               fila += " <td style='display:none'>"+item[5]+"</td>"
               fila += " <td style='display:none'>"+item[6]+"</td>"
               fila += " <td>"+item[7]+"</td>"
               fila += " <td style='display:none'>"+item[8]+"</td>"
               fila += " <td style='display:none'>"+item[10]+"</td>"
               fila += " <td >"+b1+"</td>"
               fila += "</tr>";
               var btn = document.createElement("TR");
               btn.innerHTML=fila;
               document.getElementById("tbdsubsubmenu").appendChild(btn);
            }
         });
       
      }
   });
}


function _actualizar(idmenu,idsubmen,idsubsubmenu,nombre,url,estado) {
   $.ajax({
      dataType:'text',
      type: 'POST', 
      url:  'c_guardar_permisos.php',
      data: {
          "accion" : 'actualizar',
          "idmenu":idmenu,
          "idsubmen":idsubmen,
          "idsubsubmenu":idsubsubmenu,
          "nombre":nombre,
          "url":url,
          "estado":estado
      },
      success: function(response){
        console.log(response);   
        listarmenu();
      }
 });
}

function guardar(idmenu,idsubmen,idsubsubmenu,nombre,url,estado) {
   $.ajax({
      dataType:'text',
      type: 'POST', 
      url:  'c_guardar_permisos.php',
      data: {
          "accion" : 'guardar',
          "idmenu":idmenu,
          "idsubmen":idsubmen,
          "idsubsubmenu":idsubsubmenu,
          "nombre":nombre,
          "url":url,
          "estado":estado
      },
      success: function(response){
        console.log(response);
      }
   });
}