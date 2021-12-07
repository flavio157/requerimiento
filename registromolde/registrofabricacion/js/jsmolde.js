var supersonal = [];
var sumolde = [];
var material = [];
var celda = "";
$(function() {
  autocompletarmolde();
  $('body').on('keydown', function(e){
    if( e.which == 38 ||  e.which == 40) {
      return false;
    }
  });
    personal();
    $("#txtpersonalmolde").autocomplete({
      source: supersonal,
        select: function (event, ui) {
          $("#txtcodpermolde").val(ui.item.code);
        }
    });

    lstmateralesalmacen();
    $("#txtdesmater").autocomplete({
      source: material,
        select: function (event, ui) {
          $("#txtcodmater").val(ui.item.code);
          $("#txtunidadmater").val(ui.item.unidad)
        }
    });
   

    $("#addpersonal").click(function () {
        tabla = $("#tbdpersonalmolde  tr");
        for (let i = 0; i < tabla.length; i++) { 
          if($(tabla[i]).find("td")[0].innerHTML == $("#txtcodpermolde").val()){
            Mensaje1('Personal ya agregado','error'); return;
          }
        }
        if($("#txtfecinipers").val() == ''){
          Mensaje1('Seleccione fecha del personal','error'); return;}
      
        b1 = "<a id='btneliminarPer' class='btn btn-danger  btn-sm'>"+
              "<i class='icon-trash'></i></a>";
        array = [
            a = [$("#txtcodpermolde").val(),'none'],
            b = [$("#txtpersonalmolde").val().toUpperCase(),''],
            c = [$("#txtfecinipers").val(),''],
            e = [b1,''],
            f = [$("#texobservacion").val(),'none'],
        ];
        validar(array);
       
    });

    $("#txtdesmolde").keydown(function(e){
      if(e.which == 8) {
         $("#txtcodmolde").val('');
         $("#txttipomolde").val('');
         $('#tbmaterialmolde').find("tr:gt(0)").remove();
      }
    });
  
    $("#btng_molde").on('click',function () {
      molde = $("#txtcodmolde").val();
      fechini = $("#txtfechini").val();
      medida = $("#txtmedidas").val();
      nombre = $("#txtdesmolde").val()
      if($("#tbdmaterialmolde  tr").length == 0){
        Mensaje1('Error no hay materiales para el molde seleccionado','error'); return;
      }else{
        var td =  $("#tbdmaterialmolde  tr");
        var codmat = [];
        for (let l = 0; l < td.length; l++) {
          codmat[l] =[
                $(td[l]).find("td")[0].innerHTML,
                $(td[l]).find("td")[3].innerHTML,
                $(td[l]).find("td")[2].innerHTML,
                $(td[l]).find("td")[6].innerHTML,
            ]
        }
      }
      if($("#tbdpersonalmolde  tr").length == 0){
        Mensaje1('Ingrese personal Involucrado','error'); return;
      }else{
      var td =  $("#tbdpersonalmolde  tr");
        var tds = [];
        for (let l = 0; l < td.length; l++) {
            tds[l] =[
                $(td[l]).find("td")[0].innerHTML,
                $(td[l]).find("td")[1].innerHTML,
                $(td[l]).find("td")[2].innerHTML,
                $(td[l]).find("td")[4].innerHTML,
            ]
        }
      }
      _guardardatos(molde,fechini,tds,codmat,medida,nombre);
    });

    $(document).on('click','#btneliminarPer',function() {
        $(this).closest('tr').remove();
    })

    $(document).on('click','#btneliminarmate',function(){
        molde = $("#txtcodmolde").val();
        material = $(this).parents('tr').find('td:nth-child(1)').text();
        clase = $(this).parents('tr').find('td:nth-child(7)').text();
        Mensaje3(molde,material,this,clase);
    })

    $("#btnnuevo").on('click',function(){
      limpiar();
    });

    $("#txthortrab").bind('keypress',function(e){
      return _numeros(e);
    })

    $("#txtcosthora").bind('keypress',function(e){
      return _numeros(e);
    })


  $("#btnagregarmater").on('click',function(){
     material = $("#txtcodmater").val(); 
     unidad = $("#txtunidadmater").val(); 
     cantidad = $("#txtcantidadmaterial").val()
     repetido = datosrepetidos('tbdmaterialmolde',material);
     if(repetido == 0){
        gagregarmaterial(material,unidad,cantidad);
     }else{
        actualcantmaterial(material,repetido);
     } 
  });

  $(document).on('click',"#btnagregarserie",function name(params) {
    $("#txtmnuserie").val($(this).parents('tr').find('td:nth-child(3)').text());
    $(this).parents('tr').find('td:nth-child(3)').text('');
    celda = $(this).parents('tr').find('td:nth-child(3)');
    $("#modalserie").modal('show');
  })

  $("#btnagserie").on('click',function () {
    serie = $("#txtmnuserie").val();
    if(serie != ''){
      filas = $("#tbdmaterialmolde tr");
      for (let i = 0; i < filas.length ; i++) {
        if($.trim($(filas[i]).find("td")[2].innerHTML).replace(/-/g,"") == $.trim(serie).replace(/-/g, "")){
            Mensaje1("Error numero de serie ya agregado","error");
            return;
        }
      }
      verificarserie(serie);
    }
  })

  $("#btnlimpifrmateri").on('click',function() {
    document.getElementById("frmmaterialexterno").reset();
  }); 

  $("#btncancelar").on('click',function() {
    document.getElementById("frmregmoldemodal").reset();
  });

});

function verificarserie(serie) {
  $.ajax({
      dataType:'text',
      type: 'POST', 
      url:  'c_moldes.php',
      data:{
          "accion" : 'verificarserie',
          "serie" :serie
      } ,
      success:  function(e){
          if(e != 1){
            Mensaje1(e,"error");
          }else{
            $(celda).text(serie.toUpperCase());
            $("#modalserie").modal('hide');
          }
      }
  }); 
}


function personal() {
    $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  'c_moldes.php',
        data:{
            "accion" : 'personal',
        } ,
        success:  function(response){
            obj = JSON.parse(response);
            $.each(obj['dato'], function(i, item) {
              supersonal.push(item); 
            });
        }
    }); 
}

function lstmoldes() {
  $.ajax({
    dataType:'text',
    type: 'POST', 
    url:  'c_moldes.php',
    data:{
        "accion" : 'lstmoldes',
    } ,
    success:  function(response){
        obj = JSON.parse(response);
        $.each(obj['dato'], function(i, item) {
          sumolde.push(item); 
        });
    }
  }); 
}

function lstmateriales(dato) {
  $.ajax({
    dataType:'text',
    type: 'POST', 
    url:  'c_moldes.php',
    data:{
        "accion" : 'lstmateriales',
        "dato" : dato,
    } ,
    success:  function(response){
      obj = JSON.parse(response);

      $.each(obj['dato'], function(i, item) {
        if(item[6] != '00001' || item[6] == ''){
            var fila="<tr>";
            fila +="<td class='tdcontent' style='display:none'>"+item[0]+"</td>";
            fila +="<td class='tdcontent'>"+item[2]+"</td>";
            fila +="<td class='tdcontent'>"+''+"</td>";
            fila +="<td class='tdcontent'>"+item[3]+"</td>";
            fila +="<td class='tdcontent'  style='display:none'>"+item[4]+"</td>";
            fila +="<td class='tdcontent'>"+item[5]+"</td>";
            fila +="<td class='tdcontent' style='display:none'>00002</td>";
            fila +="<td class='tdcontent'>"+
            "<a id='btnagregarserie' class='btn btn-primary btn-sm disabled'  style='margin-right: 1px;"+
            "margin-bottom: 1px;'><i class='icon-edit'></i></a></td>";
            fila +="</tr>";
            var btn = document.createElement("TR");
            btn.innerHTML=fila;
            document.getElementById("tbdmaterialmolde").appendChild(btn);
        }else{
          for (let i = 0; i < item[3]; i++) {

            var fila="<tr>";
            fila +="<td class='tdcontent' style='display:none'>"+item[0]+"</td>";
            fila +="<td class='tdcontent'>"+item[2]+"</td>";
            fila +="<td class='tdcontent'>"+''+"</td>";
            cant = '1.000';
            stock = parseFloat(Number(item[5])  - Number(i)).toFixed(3);
            fila +="<td class='tdcontent'>"+cant+"</td>";
            fila +="<td class='tdcontent'  style='display:none'>"+item[4]+"</td>";
            fila +="<td class='tdcontent'>"+stock+"</td>";
            fila +="<td class='tdcontent' style='display:none'>00001</td>";
            fila +="<td class='tdcontent'>"+
            "<a id='btnagregarserie' class='btn btn-primary btn-sm' style='margin-right: 1px;"+
            "margin-bottom: 1px;'><i class='icon-edit'></i></a></td>";
            fila +="</tr>";
            var btn = document.createElement("TR");
            btn.innerHTML=fila;
            document.getElementById("tbdmaterialmolde").appendChild(btn);
          }
        }
       
      }) 
    }
  }); 
}

function _createtable(td,idtbttabla) {
    var fila="<tr>";
    for (let i = 0; i < td.length; i++) {
        fila +="<td class='tdcontent' style=display:"+td[i][1]+">"+td[i][0]+"</td>";
    }
    fila += "</tr>";
    var btn = document.createElement("TR");
    btn.innerHTML=fila;
    document.getElementById(idtbttabla).appendChild(btn);
}

function _guardardatos(idmolde,fecini,tds,codmat,medida,nombre) {
  usuario = $("#vrcodpersonal").val();
  var personal = {tds};
  var codmate = {codmat};
  $.ajax({
    dataType:'text',
    type: 'POST', 
    url:  'c_moldes.php',
    data:{
        "accion" : 'guardar',
        "idmolde" : idmolde,
        "fecini" : fecini,
        "usuario" : usuario,
        "lstpersonal" :JSON.stringify(personal),
        "codmaterial" : JSON.stringify(codmate),
        "medida" : medida,
        "nombre" : nombre
    } ,
    success:  function(response){
      if(response == 1){
       Mensaje1("Datos registrados correctamente","success");
       limpiar();
      
      }else{
        Mensaje1(response,"error");
      }
    }
  }); 
}

function limpiar() {
  $('#tbdmaterialmolde').find("tr").remove();
  $('#tbdpersonalmolde').find("tr").remove();
  $('#tbdlistamoldes').find("tr").remove();
  document.getElementById("frmfabricacion").reset();
}

function validar(array){
 cod = $("#txtcodpermolde").val()
 nomper = $("#txtpersonalmolde").val()
 fecin =  $("#txtfecinipers").val();
 obser = $("#texobservacion").val()
  $.ajax({
    dataType:'text',
    type: 'POST', 
    url:  'c_moldes.php',
    data:{
        "accion" : 'validarpersonal',
        "cod" : cod,
        "nomper":nomper,
        "fecin" : fecin,
        "obser" : obser,
    } ,
    success:  function(response){
      if(response == 1){
        _createtable(array,'tbdpersonalmolde');
        resetpersonal();
      }else{
        Mensaje1(response,"error")
      }
    }
}); 
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

function _numeros(e) {
  var regex = new RegExp("^[0-9]+$");
  var key = String.fromCharCode(!e.charCode ? e.which : e.charCode);
  if (!regex.test(key)) {
    e.preventDefault();
    return false;
  }
}

function _verifec(fecha1,fecha2){
  var date1 = new Date(fecha1);
  var date2 = new Date(fecha2);
  if(date1 > date2){
    return -1;
  }else{
    return 0;
  }
}

function resetpersonal(){
  $("#txtcodpermolde").val('');
  $("#txtpersonalmolde").val('');
  $("#texobservacion").val('');
  $("#texobservacion").val('');
  $("#txthortrab").val('');
  $("#txtcosthora").val('');
}


function Mensaje3(molde,material,tabla,clase) {
  Swal.fire({
    title: '¿Desea eliminar el material?',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Eliminar',
    cancelButtonColor: '#d33',
  }).then((result) => {
    if (result.isConfirmed) {
      eliminar(molde,material,tabla,clase)
    }
  })
}

function autocompletarmolde(){
  sumolde = [];
  lstmoldes();
  $("#txtdesmolde").autocomplete({
    source: sumolde,
      select: function (event, ui) {
        $("#txtcodmolde").val(ui.item.code);
        $("#txttipomolde").val(ui.item.tipo);
        $("#txtmedidas").val(ui.item.medida);
        $('#tbdmaterialmolde').find("tr").remove();
       
        lstmateriales(ui.item.code)
      }
  });
}

function lstmateralesalmacen(){
  $.ajax({
    dataType:'text',
    type: 'POST', 
    url:  'c_moldes.php',
    data:{
        "accion" : 'lstmaterial',
    } ,
    success:  function(response){
        obj = JSON.parse(response);
        $.each(obj['dato'], function(i, item) {
          material.push(item); 
        });
    }
  }); 
}


function gagregarmaterial(material,unidad,cantidad){
  molde = $("#txtcodmolde").val();
  usu = $("#vrcodpersonal").val();
  $.ajax({
    dataType:'text',
    type: 'POST', 
    url:  'c_moldes.php',
    data:{
      "accion" : 'agremater',
      "molde" : molde,
      "material":material,
      "unidad" : unidad,
      "cantidad":cantidad,
      "usu":usu
    },
    success:  function(e){
      if(e==1){
        Mensaje1("Se agrego el material","success");
        $('#tbdmaterialmolde').find("tr").remove();
        limpiarmaterial();
        lstmateriales(molde)
      }else{
        Mensaje1(e,"error");
      }
    }
  });
}

function limpiarmaterial(){
  $("#txtcodmater").val(''); $("#txtunidadmater").val('');
  $("#txtdesmater").val('');$("#txtmedidamaterial").val('');
  $("#txtcantidadmaterial").val('');
}

function eliminar(molde,material,tabla,clase) {
  usu = $("#vrcodpersonal").val();
  $.ajax({
    dataType:'text',
    type: 'POST', 
    url:  'c_moldes.php',
    data:{
        "accion" : 'eliminarmaterial',
        "molde" : molde,
        "material" : material,
        "clase": clase,
        "usu" : usu
    } ,
    success:  function(e){
        if(e == 1){
          Mensaje1("Se elimino el material","success");
          $("#tbmaterialmolde > tbody").empty();
          lstmateriales(molde);
        }else{
          Mensaje1(e,"error");
        }
    }
  }); 
}

function actualcantmaterial(material,cantidad) {
  molde = $("#txtcodmolde").val();
  usu = $("#vrcodpersonal").val();
  $.ajax({
    dataType:'text',
    type: 'POST', 
    url:  'c_moldes.php',
    data:{
      "accion" : 'actualmater',
      "molde" : molde,
      "material":material,
      "cantidad":cantidad,
      "usu":usu
    },
    success:  function(e){
      if(e == 1){
        Mensaje1("Se actualizo el material para el molde","success");
        $('#tbdmaterialmolde').find("tr").remove();
        limpiarmaterial();
        lstmateriales(molde);
      }else{
        Mensaje1(e,"error");
      }
    }
  });
}

function datosrepetidos(tabla,dato) {
  suma = 0.000;
  filas = $("#"+tabla+" tr");
  for (let l = 0; l < filas.length; l++) {
      if($(filas[l]).find("td")[0].innerHTML == dato){
          suma += Number($(filas[l]).find("td")[3].innerHTML);
      }
  }
  if(suma != 0.000){
    suma += Number($("#txtcantidadmaterial").val());
    return suma;
  }
  return 0;
}
