var sugexnombre = [];  sugexmaterial = [];cod='';select = 0 //not select;
var usu = ''; tipo = ''; codpro = '';codfor ='';celda1 = ''; estado = 0;//0 save 
celdafijo='';
$(document).ready(function () {
  autocompletarproducto();
  autocompletarinsumo();
  usu = $("#vrcodpersonal").val();
  $("#btnagregarmater").on('click',function(){
    if(estado == 0){
      agregmaterial(cod,$("#txtmaterial").val(),$("#txtcantxusar").val(),$("#slctipoinsumo").val());
    }else{
      var t = datosrepetidos('tbdmateiales',cod);
      if(t){
        additems(codfor,cod,$("#txtcantxusar").val(),$("#slcestadomater").val(),$("#txtmaterial").val(),$("#slctipoinsumo").val())
      }else{Mensaje1("Error ya se agrego el material","error");}
    }
  });

  $("#txtformulacion").bind('keypress',function(e){
    return _numeros(e)
  });

  $(document).on('click','#btndelemater',function() {
      $(this).closest('tr').remove();
  })

  $("#btngformula").on('click',function(e) {
    if(select == 0){Mensaje1("Error no selecciono el producto","error"); return;}
    if(estado == 0){
      formulario = $("#frmformulacion").serialize();
      var td =  $("#tbdmateiales tr");
      var tds = [];
        for (let l = 0; l < td.length; l++) {
          tds[l] =[$(td[l]).find("td")[0].innerHTML,$(td[l]).find("td")[2].innerHTML,
          $(td[l]).find("td")[5].innerHTML]
        }
      guardarfor(formulario,tds);
    }else{
      actuaformula($("#txtnombformula").val(),$("#txtunimedida").val(),$("#txtformulacion").val())
    }
  });
  
  $(document).on('click',"#lstitemsfor",function(e) {
    select = 1;
    codfor = $(this).parents('tr').find('td:nth-child(1)').text().trim();
    $("#txtnombformula").val($(this).parents('tr').find('td:nth-child(2)').text().trim());
    $("#txtproducto").val($(this).parents('tr').find('td:nth-child(5)').text().trim());
    $("#txtformulacion").val($(this).parents('tr').find('td:nth-child(3)').text().trim());
    $("#txtunimedida").val($(this).parents('tr').find('td:nth-child(7)').text().trim());
    codpro = $(this).parents('tr').find('td:nth-child(6)').text().trim();
    lstitemsfor(codfor);
  })

  $("#btnlstformula").on('click',function() {
    lstformula();
  }) 

  $(document).on('click','#btnactualizar',function() {
    $("#mdcodmate").val($(this).parents('tr').find('td:nth-child(1)').text().trim());
    $("#mdmaterial").val($(this).parents('tr').find('td:nth-child(2)').text().trim());
    $("#mdcantxusar").val($(this).parents('tr').find('td:nth-child(3)').text().trim()); 
    $("#slcmdtipoinsumo").val($(this).parents('tr').find('td:nth-child(6)').text().trim()); 
    celda1 = $(this).parents('tr').find('td:nth-child(3)');
    celdafijo =  $(this).parents('tr').find('td:nth-child(6)');
  })

  $("#btnactuitems").on('click',function() {
    if(estado == 1){
      updateitems(codfor,$("#mdcodmate").val(),$("#mdcantxusar").val(),$("#slcmdtipoinsumo").val())
    }else{
      if($("#mdcantxusar").val().trim().length == 0){Mensaje1("Error ingrese cantidad del insumo","error"); return;}
      if($("#mdcantxusar").val() == 0){Mensaje1("Error cantidad del insumo no puede ser 0","error");return}
      $(celda1).text(Number.parseFloat($("#mdcantxusar").val()).toFixed(3));
      $(celdafijo).text($("#slcmdtipoinsumo").val());
      $("#mditemformula").modal('hide');
    }
  });

  $(document).on('click','#btndelete',function() {
    if(estado == 1){
      codprod = $(this).parents('tr').find('td:nth-child(1)').text().trim()
      Mensaje2(codfor,codprod)
    }else{
      $(this).closest('tr').remove();
    }
  });

  $('#btnnuevo').on('click',function() {
      limpiar();
     
  });

  $('#txtproducto').keydown(function(e) {
    if (e.keyCode == 8) {
      select = 0;
    }
  });
}); 

function buscarxnombreprod(){
    $.ajax({
      dataType:'text',
      type: 'POST', 
      url:  'c_formulacion.php',
      data:{
          "accion" : 'buscarxnombre',
      } ,
      success:  function(response){
          obj = JSON.parse(response);
          $.each(obj['dato'], function(i, item) {
            sugexnombre.push(item);
          });
      }
    });
}


function autocompletarproducto() {
    buscarxnombreprod();
    $("#txtproducto").autocomplete({
        source: sugexnombre,
        select: function (event, ui) {
          codpro = ui.item.code;
          $("#txtnombformula").val(ui.item.label);
          $("#txtproducto").val(ui.item.label);
          $("#txtunimedida").val(ui.item.uni);
          select = 1;
        }
    });
}

function buscarxinsumo(){
    $.ajax({
      dataType:'text',
      type: 'POST', 
      url:  'c_formulacion.php',
      data:{
          "accion" : 'insumo',
      } ,
      success:  function(response){
          obj = JSON.parse(response);
          $.each(obj['dato'], function(i, item) {
            sugexmaterial.push(item);
          });
      }
    });
}

function autocompletarinsumo() {
  buscarxinsumo();
  $("#txtmaterial").autocomplete({
    source: sugexmaterial,
      select: function (event, ui) {
        cod = ui.item.code;$("#txtmaterial").val(ui.item.label);
      }
  });
}

function _createtable(td,idtbttabla) {
  var fila='';
  for (let i = 0; i < td.length; i++) {
      fila +="<td class='tdcontent' style=display:"+td[i][1]+">"+td[i][0]+"</td>"; 
  }
  var btn = document.createElement("TR");
  btn.innerHTML=fila;
  document.getElementById(idtbttabla).appendChild(btn);
}

function _numeros(e) {
  var regex = new RegExp("^[0-9]+$");
  var key = String.fromCharCode(!e.charCode ? e.which : e.charCode);
  if (!regex.test(key)) {e.preventDefault();return false;}
}

function Mensaje1(texto,icono){
  Swal.fire({icon: icono,title: texto,
   //padding:'1rem',//grow:'fullscreen',//backdrop: false,
   //toast:true,//position:'top'	
   });
}

function datosrepetidos(tabla,dato) {
  filas = $("#"+tabla+" tr");
  for (let l = 0; l < filas.length; l++) {
      if($(filas[l]).find("td")[0].innerHTML == dato){
          return false;
      }
  }
  return true;
}

function agregmaterial(cod,nom,cantxusar,fija) {
  $.ajax({
    dataType:'text',
    type: 'POST', 
    url:  'c_formulacion.php',
    data:{
      "accion":'prod',"cod":cod,"nom":nom,"cantxusar":cantxusar,"usu" :usu,"fija":fija
    },
    success:  function(response){
      obj = JSON.parse(response);
      cod = obj['cod'];
      generar(obj,cod,nom,cantxusar,fija)
    }
  });
}

function guardarfor(f,tds){
  var materiales = {tds};
  unidad = $("#txtunimedida").val();
  nombrefor = $("#txtnombformula").val();
  $.ajax({
      dataType:'text',
      type: 'POST', 
      url:  'c_formulacion.php',
      data:f+"&accion=guardarform&usu="+usu+"&codpro="+codpro+
      "&items="+JSON.stringify(materiales)+"&txtunimedida="+unidad+"&txtnombformula="+nombrefor,
      success: function(r) {
        if(r == 1){Mensaje1("Se registro la formula","success");
        limpiar();}
        else{Mensaje1(r,"error");}
      }
  });
}

function limpiar() {
  cod = '';
  document.getElementById("frmformulacion").reset();
  $('#tbmateriales').find("tr:gt(0)").remove();
  estado = 0;
}

function lstformula() {
  $.ajax({
    dataType:'text',
    type: 'POST', 
    url:  'c_formulacion.php',
    data:"accion=lstformula",
    success: function(r) {
      obj = JSON.parse(r);
      b2 = "<a id='lstitemsfor' style='margin-right: 2px;margin-bottom: 1px;' class='btn btn-primary btn-sm'>"+
      "<i class='icon-check' title='Buscar materiales'></i>"+
      "</a>";
      $("#tbformula > tbody").empty();
      $.each(obj['dato'], function(i, item) {
        var fila='';
        fila +="<td class='tdcontent' style=display:none>"+item[0]+"</td>";
        fila +="<td >"+item[1]+"</td>";
        fila +="<td class='tdcontent'>"+item[4]+"</td>";
        fila +="<td class='tdcontent'>"+b2+"</td>";
        fila +="<td class='tdcontent' style=display:none>"+item[3]+"</td>";
        fila +="<td class='tdcontent' style=display:none>"+item[2]+"</td>";
        fila +="<td class='tdcontent' style=display:none>"+item[5]+"</td>";
        var btn = document.createElement("TR");
        btn.innerHTML=fila;
        document.getElementById("tbdformula").appendChild(btn);
      });
    }
});
}

function lstitemsfor(form) {
  $.ajax({
    dataType:'text',
    type: 'POST', 
    url:  'c_formulacion.php',
    data:"accion=lstitemformula&for="+form,
    success: function(r) {
      obj = JSON.parse(r);
      b2 = "<a id='btnactualizar' style='margin-right: 2px;margin-bottom: 1px;' class='btn btn-primary  btn-sm' data-bs-toggle='modal' data-bs-target='#mditemformula'>"+
            "<i class='icon-pencil' title='Modificar material'></i>"+
            "</a><a id='btndelete' style='margin-right: 2px;margin-bottom: 1px;' class='btn btn-danger btn-sm'>"+
            "<i class='icon-trash' title='Eliminar materiales'></i>"+
            "</a>";
      $("#tbmateriales > tbody").empty();
      $.each(obj['dato'], function(i, item) {
        var fila='';
        fila +="<td class='tdcontent' style=display:none>"+item[1]+"</td>";
        fila +="<td >"+item[2]+"</td>";
        fila +="<td class='tdcontent'>"+item[3]+"</td>";
        fila +="<td class='tdcontent' style=display:none>"+item[4]+"</td>";
        fila +="<td class='tdcontent'>"+b2+"</td>";
        fila +="<td class='tdcontent' style=display:none>"+item[5]+"</td>";
        var btn = document.createElement("TR");
        btn.innerHTML=fila;
        document.getElementById("tbdmateiales").appendChild(btn);
      });
      $("#mdformula").modal('hide');
      estado = 1;
    }
});
}

function additems(form,codpro,cant,estmat,nom,fija) {
  $.ajax({
    dataType:'text',
    type: 'POST', 
    url:  'c_formulacion.php',
    data:{
      "accion":'additems',"form":form,"cod":codpro,"cantxusar":cant,"estmat":estmat,"usu" :usu
    },
    success:  function(r){
      obj = JSON.parse(r);
      if(obj['dato']==1){
        generar(obj,codpro,nom,cant,fija)
      }else{
        Mensaje1(obj['dato'],"error")
      }
      
    }
  });
}

function generar(obj,codprod,nom,cant,fija) {
  if(obj['dato'] == 1){
    var b1 = "<a id='btnactualizar' style='margin-right: 2px;margin-bottom: 1px;' class='btn btn-primary  btn-sm' data-bs-toggle='modal' data-bs-target='#mditemformula'>"+
    "<i class='icon-pencil' title='Modificar material'></i>"+
    "</a><a id='btndelete' class='btn btn-danger  btn-sm'>"+
    "<i class='icon-trash' title='Eliminar material'></i></a>";
    r = datosrepetidos('tbdmateiales',cod);
    if(r){
      array = [
        a = [codprod,'none',''],b = [nom,'',''],c = [Number.parseFloat(cant).toFixed(3),'',''],
        d = [$("#slcestadomater").val(),'none',''],e = [b1,'',''],
        f = [fija,'none','']
      ]
      _createtable(array,'tbdmateiales');cod = '';
      $("#txtmaterial").val('');$("#txtcantxusar").val('');$("#slcestadomater").val('1');
    }else{
      Mensaje1("Error ya se agrego el material","error");
    }
  }else{
    Mensaje1(obj['cod'],"error");
  } 
}

function updateitems(form,codpro,cant,fijo) {
  $.ajax({
    dataType:'text',
    type: 'POST', 
    url:  'c_formulacion.php',
    data:{
      "accion":'updateitems',"form":form,"cod":codpro,"cantxusar":cant,"usu" :usu,"fijo":fijo
    },
    success:  function(r){
      if(r == 1){
        Mensaje1("Se actualizo el material","success");
        lstitemsfor(form);
        $("#mditemformula").modal('hide');
      }else{
        Mensaje1(r,"error");
      }
    }
  });
}

function deletematei(form,codpro) {
  $.ajax({
    dataType:'text',
    type: 'POST', 
    url:  'c_formulacion.php',
    data:{
      "accion":'delete',"form":form,"cod":codpro,
    },
    success:  function(r){
      if(r == 1){
        Mensaje1("Se elimino el material","success");
        lstitemsfor(form);
      }else{
        Mensaje1(r,"error");
      }
    }
  });  
}

function Mensaje2(form,codpro) {
  Swal.fire({
      title: '??Desea eliminar el material?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Eliminar',
      cancelButtonColor: '#d33',
    }).then((result) => {
      if (result.isConfirmed) {
        deletematei(form,codpro)
      }
    })
}

function actuaformula(nombre,uni,cant) {
  producto = $("#txtproducto").val();
  $.ajax({
    dataType:'text',
    type: 'POST', 
    url:  'c_formulacion.php',
    data:{
      "accion":'updateform',"formu":codfor,"cod":codpro,
      "nomb":nombre,"uni":uni,"cantfor":cant,"usu":usu,"produ":producto
    },
    success:  function(r){
      if(r == 1){
        Mensaje1("Se actualizo el registro","success");
        limpiar();
        
      }else{
        Mensaje1(r,"error");
      }
    }
  });
}
