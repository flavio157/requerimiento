$(document).ready(function () {
   listarmenu();
   lstmenu();
   $('#tbmenu').on('click', 'tbody tr', function(event) {
      $(this).addClass('highlight').siblings().removeClass('highlight');
      var dato =  $(this).find("td:eq(0)").text();
      $("#tbsubmenu > tbody").empty();
      $("#subsubmenu > tbody").empty();
      $("#txtmdurlmenu").css("display", "block");
     // $("#txturlmenu").prop('disabled', false);
      $("#txtidmenu").val(dato)
      lstsubmenu(dato);
   });

   $('#tbsubmenu').on('click', 'tbody tr', function(event) {
      $(this).addClass('highlight').siblings().removeClass('highlight');
      var idmenu =  $(this).find("td:eq(0)").text();
      var idsubmenu =  $(this).find("td:eq(1)").text();
      $("#txtidmenu2").val(idmenu);
      $("#txtidsubmenu").val(idsubmenu)
      $("#subsubmenu > tbody").empty();
      $("#txtmdurlsubmenu").css('display','block');
      //$("#txturlsubmenu").prop('disabled', false);
      lstsubsubmenu(idmenu,idsubmenu);
   });

   $('#subsubmenu').on('click', 'tbody tr', function(event) {
      $(this).addClass('highlight').siblings().removeClass('highlight');
   });

   $(document).on('click','#btnmenu',function () {
       id =  $(this).parents('tr').find('td:first-child').text();
       buscarmenu(id);
   
   });

   $(document).on('click','#btnsubmenu',function(){
      idmenu =  $(this).parents('tr').find('td:first-child').text();
      idsubmenu =  $(this).parents('tr').find('td:nth-child(2)').text();
      buscarsubmenu(idmenu,idsubmenu);
   });

   $(document).on('click','#btnsubsubmenu',function () {
      idmenu =  $(this).parents('tr').find('td:first-child').text();
      idsubmenu =  $(this).parents('tr').find('td:nth-child(2)').text();
      idsubsubmenu =  $(this).parents('tr').find('td:nth-child(3)').text();
      buscarsubsubmenu(idmenu,idsubmenu,idsubsubmenu);
  });

  $("#btnmdgmenus").on('click',function() {
    _actualizar($("#txtmdidmenu").val(),"","",
    $("#txtmdnommenu").val(),$("#txtmdurlmenu").val(),$("#txtmdestmenu").val());
    lstmenu();
  });

  $("input[id=rdmdactimenu]").change(function () {
      $("#txtmdestmenu").val(1);
  });

  $("input[id=rdmddescmenu]").change(function () {	
      $("#txtmdestmenu").val(0);
  });

  $("#btnmdgsubmenu").on('click',function(){
      $("#tbsubmenu > tbody").empty();
      _actualizar($("#txtmdidmenu2").val(),$("#txtidsubmenu").val(),"",
      $("#txtmdnomsubmenu").val(),$("#txtmdurlsubmenu").val(),$("#txtmdestsubmenu").val())
      lstsubmenu($("#txtmdidmenu2").val());
   })

  $("input[id=rdmdactisubmenu]").change(function () {
      $("#txtmdestsubmenu").val(1);
   });

   $("input[id=rdmddescsubmenu]").change(function () {	
      $("#txtmdestsubmenu").val(0);
   });

   $("#btnmdgsubsubmenu").on('click',function() {
      $("#subsubmenu > tbody").empty();
      _actualizar($("#txtmdidmenu3").val(),$("#txtmdsubidmenu2").val(),$("#txtmdidsubsubmenu").val(),
      $("#txtmdsubsubnombe").val(),$("#txtmdsubsuburl").val(),$("#txtmdestsubsubmenu").val()) 
      lstsubsubmenu($("#txtmdidmenu3").val(),$("#txtmdsubidmenu2").val())
   });

   $("input[id=rdmdactisubsubmenu]").change(function () {
      $("#txtmdestsubsubmenu").val(1);
   });

   $("input[id=rdmddescsubsubmenu]").change(function () {	
      $("#txtmdestsubsubmenu").val(0);
   });

   $("input[id=rdactimenu]").change(function() {
      $("#txtestmenu").val(1);
   });

   $("input[id=rddescmenu]").change(function() {
      $("#txtestmenu").val(0);
   });

   $("#btngmenus").on('click',function() {
       nombre = $("#txtnommenu").val();
       url = $("#txturlmenu").val();
       estado = $("#txtestmenu").val();
       guardarmenu(nombre,url,estado);
       removerclase();
   });

   $("input[id=rdactisubmenu]").change(function() {
      $("#txtestsubmenu").val(1);
   });

   $("input[id=rddescsubmenu]").change(function() {
      $("#txtestsubmenu").val(0);
   });
   $("#btngsubmenu").on('click',function() {
      idmenu = $("#txtidmenu").val();
      nombre = $("#txtnomsubmenu").val();
      url = $("#txturlsubmenu").val();
      estado = $("#txtestsubmenu").val();
    
      guardarsubmenu(idmenu,nombre,url,estado);
      removerclase();
  });

  $("input[id=rdactisubsubmenu]").change(function() {
   $("#txtestsubsubmenu").val(1);
});

$("input[id=rddescsubsubmenu]").change(function() {
   $("#txtestsubsubmenu").val(0);
});

  $("#btngsubsubmenu").on('click',function() {
   idmenu = $("#txtidmenu2").val();
   idsubmenu = $("#txtidsubmenu").val();
   nombre = $("#txtsubsubnombe").val();
   url = $("#txtsubsuburl").val();
   estado = $("#txtestsubsubmenu").val();
   guardarsubsubmenu(idmenu,idsubmenu,nombre,url,estado);
   removerclase();
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
         $("#tbmenu > tbody").empty();
         b1 = "<a id='btnmenu' class='btn btn-primary btn-sm' data-bs-toggle='modal' data-bs-target='#mdmenu' style='float:right;'><i class='icon-pencil'>"
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
         b1 = "<a id='btnsubmenu' class='btn btn-primary btn-sm' data-bs-toggle='modal' data-bs-target='#mdsubmenu' style='float:right;'><i class='icon-pencil'>"
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
            $("#txtmdurlmenu").css("display", "none");
            //$("#txturlmenu").prop('disabled', true);
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
         $("#subsubmenu > tbody").empty();
         b1 = "<a id='btnsubsubmenu' class='btn btn-primary btn-sm'  data-bs-toggle='modal' data-bs-target='#mdsubsubmenu' style='float:right;'><i class='icon-pencil'>"
         obj = JSON.parse(response);
         $.each(obj['dato'], function(i, item) {
            $("#txtmdurlsubmenu").css('display','none');
            //$("#txturlsubmenu").prop('disabled', true);
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
         listarmenu();
      }
 });
}

function guardarmenu(nombre,url,estado) {
   $.ajax({
      dataType:'text',
      type: 'POST', 
      url:  'c_guardar_permisos.php',
      data: {
          "accion" : 'guardarmenu',
          "nombre":nombre,
          "url":url,
          "estado":estado
      },
      success: function(response){
         if(response == 1){
            Mensaje1("Se guardo el registro","success");
            listarmenu();
            document.getElementById('frmpermisos').reset();
            lstmenu();
         }else{
            Mensaje1(response,"error");
         }
      }
   });
}

function guardarsubmenu(idmenu,nombre,url,estado) {
   $.ajax({
      dataType:'text',
      type: 'POST', 
      url:  'c_guardar_permisos.php',
      data: {
          "accion" : 'guardarsubmenu',
          "idmenu" : idmenu,
          "nombre":nombre,
          "url":url,
          "estado":estado
      },
      success: function(response){
         if(response == 1){
            Mensaje1("Se guardo el registro","success");
            listarmenu();
            document.getElementById('frmpermisos').reset();
            $("#tbsubmenu > tbody").empty();
            lstsubmenu(idmenu);
         }else{
            Mensaje1(response,"error");
         }
      }
   });
}

function guardarsubsubmenu(idmenu,idsubmenu,nombre,url,estado) {
   $.ajax({
      dataType:'text',
      type: 'POST', 
      url:  'c_guardar_permisos.php',
      data: {
          "accion" : 'guardarsubsubmenu',
          "idmenu" : idmenu,
          "idsubmenu" : idsubmenu,
          "nombre":nombre,
          "url":url,
          "estado":estado
      },
      success: function(response){
         if(response == 1){
            Mensaje1("Se guardo el registro","success");
            listarmenu();
            document.getElementById('frmpermisos').reset();
            $("#subsubmenu > tbody").empty();
            lstsubsubmenu(idmenu,idsubmenu)
         }else{
            Mensaje1(response,"error");
         }
      }
   });
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


function buscarmenu(idmenu) {
   $.ajax({
      dataType:'text',
      type: 'POST', 
      url:  'c_guardar_permisos.php',
      data: {
          "accion" : 'buscarmenu',
          "idmenu" : idmenu,
      },
      success: function(response){
        obj = JSON.parse(response);
        $.each(obj['dato'], function(i, item) {
            $("#txtmdnommenu").val(item[1]);
            $("#txtmdurlmenu").val(item[2]);
            $("#txtmdidmenu").val(item[0]);
            $("#txtmdestmenu").val(item[3]);
            if(item[3] == 1){document.querySelector('#rdmdactimenu').checked = true;}
            else{document.querySelector('#rdmddescmenu').checked = true;}
        })
       
      }
 });
}

function buscarsubmenu(idmenu,idsubmenu) {
   $.ajax({
      dataType:'text',
      type: 'POST', 
      url:  'c_guardar_permisos.php',
      data: {
          "accion" : 'buscarsubmenu',
          "idmenu" : idmenu,
          "idsubmenu" : idsubmenu,
      },
      success: function(response){
         obj = JSON.parse(response)
         $.each(obj['dato'], function(i, item) {
            $("#txtidmenu2").val(item[1]);
            $("#txtmdidmenu2").val(item[1]);
            $("#txtmdnomsubmenu").val(item[3]);
            $("#txtmdurlsubmenu").val(item[4]);
            $("#txtmdidsubmenu").val(item[2])
            $("#txtmdestsubmenu").val(item[9])
            if(item[9] == 1){document.querySelector('#rdmdactisubmenu').checked = true;}
            else{document.querySelector('#rdmddescsubmenu').checked = true;}
        })
       
      }
 });
}

function buscarsubsubmenu(idmenu,idsubmenu,idsubsubmenu) {
   $.ajax({
      dataType:'text',
      type: 'POST', 
      url:  'c_guardar_permisos.php',
      data: {
          "accion" : 'buscarsubsubmenu',
          "idmenu" : idmenu,
          "idsubmenu" : idsubmenu,
          "idsubsubmenu" : idsubsubmenu,
      },
      success: function(response){
         obj = JSON.parse(response)
         $.each(obj['dato'], function(i, item) {
            $("#txtmdidmenu3").val(item[1]);
            $("#txtmdsubidmenu2").val(item[5]);
            $("#txtmdsubsubnombe").val(item[7]);
            $("#txtmdsubsuburl").val(item[8]);
            $("#txtmdidsubsubmenu").val(item[6]);
            $("#txtmdestsubsubmenu").val(item[10]);
            if(item[10] == 1){document.querySelector('#rdmdactisubsubmenu').checked = true;}
            else{document.querySelector('#rdmddescsubsubmenu').checked = true;}
         });
      }
 });
}

function removerclase() {
   $("#tbdmenu  tr").removeClass('highlight');
   $("#tbdsubmenu tr").removeClass('highlight');
   $("#tbdsubsubmenu tr").removeClass('highlight');
}