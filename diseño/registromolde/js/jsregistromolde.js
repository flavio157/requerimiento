var usuario = '';
var b1 = "<a id='btnactualizar' style='margin-right: 2px;margin-bottom: 1px;' class='btn btn-primary  btn-sm'>"+
"<i class='icon-pencil' title='Modificar material'></i>"+
"</a></a><a id='btneliminar' style='margin-bottom: 1px;' class='btn btn-danger  btn-sm'>"+
"<i class='icon-trash' title='Eliminar material'></i>"+
"</a>";
var tipo = 1;  /*1 save , 0 update*/
var actutipo = 1; /*1 save 0 update */
var actuacli = 1; /*1 save 0 update */
var sugexnombre = [];
var sugexidenti = [];
var clase = 'P';  /*tipo de material*/
var clasemolde = 'P'; /*tipo de molde*/
$(function() {
  autocompletarxnombre();
  autocompletarxidentifi();
  desactivar();
  usuario = $("#vrcodpersonal").val();
  $("#txtcliente").attr('disabled',true);
  $("#txtidentificacion").attr('disabled',true);
  $("#slctipomaterial").attr('disabled',true);
  $("#btnbuscclien").addClass("disabled");
  
  $('body').on('keydown', function(e){
    if( e.which == 38 ||  e.which == 40) {
      return false;
    }
  });

  $("#txtuniextern").keyup(function(e) {
    var input=  document.getElementById('txtuniextern');
        input.addEventListener('input',function(){
            this.value = this.value.slice(0,3); 
    })
  })

  $("#btnagremater").click(function(){
      codpro = $("#txtcodmaterialexter").val();
      nombre =  $("#txtmaterialexter").val();
      cantirec = $("#txtcanexternorec").val();
      unidad = $("#txtuniextern").val();
      cantxusar = $("#txtcanexterno").val();
      molde = $("#txtcodmolde").val();
      cliente = $("#txtcodcliente").val();
      if(nombre.length == 0){Mensaje1("Error ingrese nombre del material","error");return;}
      if(unidad.length == 0){Mensaje1("Error ingrese unidad medida recibida","error");return;}
      if(cantxusar.length == 0){Mensaje1("Error ingrese cantidad por usar","error");return;}
      if(cantxusar > $("#txtcantidad").val()){Mensaje1("Error stock insuficiente","error");return;}

    if(clase == 'E'){
        cantirec = parseFloat(cantirec);
        cantxusar = parseFloat(cantxusar);
        if(cantirec.length == 0){Mensaje1("Error ingrese cantidad recibida","error");return;}
       
      if(tipo == 1){
        if(cantxusar > cantirec){Mensaje1("Error cantidad a usar no puede ser mayor a cantidad recibida","error");return;}
        guardar(codpro,nombre,cantirec,unidad,cantxusar,molde,clase,cliente);
      }
     
      if(tipo == 0){
        array = [
          a = [codpro,'none',''],
          b = [nombre.toUpperCase(),'',''],
          c = [Number.parseFloat(cantxusar).toFixed(3),'',''],
          e = [unidad.toUpperCase(),'none',''],
          f = [Number.parseFloat(cantirec).toFixed(3),'none',''],
          f = [clase,'none',''],
          g = [b1,'','']
        ]
        _createtable(array,'tbdmaterialmolde');
        limpimateri()
        tipo = 1
      }
    }
    if(clase == 'P' || slctipomolde == 'P'){
      repetido = datosrepetidos('tbdmaterialmolde',codpro);
      if(molde.length != 0 && !repetido && tipo == 1){
        guardar_materialpropio(codpro,nombre,unidad,cantxusar,molde,clase)
      }else{
        if(!repetido){
          if(codpro.length != 0){
            array = [
              a = [codpro,'none',''],
              b = [nombre.toUpperCase(),'',''],
              c = [Number.parseFloat(cantxusar).toFixed(3),'',''],
              e = [unidad.toUpperCase(),'none',''],
              f = ['0.000','none',''],
              f = [clase,'none',''],
              g = [b1,'','']
            ]
            _createtable(array,'tbdmaterialmolde');
          }else{
            Mensaje1("Error al agregar material","error");
            return;
          }
          
        }
      }
      limpimateri()
      tipo = 1
    }
  });

  $("#btng_molde").click(function() {
    
    if(clasemolde != 'P'){
      if($("#txtcodcliente").val().length == 0){Mensaje1("Error seleccione cliente","error");return;}
      if($("#txtcliente").val().length == 0){Mensaje1("Error seleccione cliente","error");return;}
      if($("#txtidentificacion").val().length == 0){Mensaje1("Error seleccione cliente","error");return;}
    }
    if($("#txtnommolde").val().length == 0){Mensaje1("Error ingrese nombre del molde","error");return;}
    if($("#txtmedmolde").val().length == 0){Mensaje1("Error ingrese medidas del molde","error");return;}
    if($("#slcestado").val() == ''){Mensaje1("Error seleccione estado","error");return;}
    if($("#slctipomolde").val() == ''){Mensaje1("Error seleccione tipo","error");return;}

    td = $("#tbdmaterialmolde tr");
    var tds = [];
    for (let l = 0; l < td.length; l++) {
        tds[l] =[
            $(td[l]).find("td")[0].innerHTML,
            $(td[l]).find("td")[1].innerHTML,
            $(td[l]).find("td")[2].innerHTML.trim(),
            $(td[l]).find("td")[3].innerHTML.trim(),
            $(td[l]).find("td")[4].innerHTML.trim(),
            $(td[l]).find("td")[5].innerHTML.trim(),
        ]
    }
    console.log(tipo , actuacli);
    if(tipo == 1 && actutipo == 1){
      guardarmoldecompleto(tds);
    }

    if(actutipo == 0){
      actualizar(tds)
    }
   
  });

  $("#btnbuscarmoldes").click(function() {
      buscarmolde('');
  })

  $("#btnbuscclien").click(function(params) {
    cliente = $("#txtcodcliente").val();
    if( cliente.length != 0){
      buscarcliente(cliente);
      actuacli = 0;
    }
  })

  $(document).on('click','#btnmodactualizar',function(){
      $("#txtcodcliente").val($(this).parents('tr').find('td:nth-child(6)').text().trim());
      $("#txtnommolde").val($(this).parents('tr').find('td:nth-child(2)').text());
      $("#txtmedmolde").val($(this).parents('tr').find('td:nth-child(3)').text());
      $("#slctipomolde").val($(this).parents('tr').find('td:nth-child(5)').text().trim());
      estilo = $(this).parents('tr').find('td:nth-child(7)').text().trim();
      if(estilo == "null"){
        estilo = "0";
      }
      $("#slcestilo").val(estilo);

      if($(this).parents('tr').find('td:nth-child(5)').text().trim() =='P'){
        moldep();
        clase = 'P';
      $("#slctipomolde").attr("disabled",'true');
      }else{
        moldeE();
        $("#slctipomolde").attr("disabled",'true');
        clase = 'E';
      }
      $("#txtcodmolde").val($(this).parents('tr').find('td:nth-child(1)').text());
      materialxmolde($(this).parents('tr').find('td:nth-child(1)').text(),$(this).parents('tr').find('td:nth-child(5)').text())
      buscarcliente($(this).parents('tr').find('td:nth-child(6)').text())
      
      actutipo = 0;
  });

  $(document).on('click',"#btnactualizar",function () { 
      $("#txtcodmaterialexter").val( $(this).parents('tr').find('td:nth-child(1)').text());
      $("#txtmaterialexter").val( $(this).parents('tr').find('td:nth-child(2)').text());
      $("#txtcanexterno").val($(this).parents('tr').find('td:nth-child(3)').text());
      $("#txtuniextern").val($(this).parents('tr').find('td:nth-child(4)').text().trim());
      $("#txtcanexternorec").val($(this).parents('tr').find('td:nth-child(5)').text());
      $("#txttipomat").val($(this).parents('tr').find('td:nth-child(6)').text());
     
      if($(this).parents('tr').find('td:nth-child(6)').text().trim() == 'P'){
        clase = 'P'
       $("#txtcanexternorec").val(''); $("#txtcanexternorec").attr('disabled','true');
       $("#btnlstmaterial").css('display','block');$("#slctipomaterial").val(clase);
      }else{
        $("#txtcanexternorec").removeAttr('disabled');$("#btnlstmaterial").css('display','none');
        clase = 'E' ;$("#slctipomaterial").val(clase);
      }
      $(this).closest('tr').remove();
      tipo = 0;
  });

  $(document).on('click',"#btneliminar",function() {
    eliminarmaterial($("#txtcodmolde").val(),$(this).parents('tr').find('td:nth-child(1)').text(),this);
   
  })

  $("#btngcliemodle").on('click',function() {
    if($("#txtnombcliente").val().length == 0){Mensaje1("Error ingrese nombre del cliente","error"); return;}
    if($("#txtdireccliente").val().length == 0){Mensaje1("Error ingrese dirección del cliente","error"); return;}
    if($("#txtidenticliente").val().length == 0){Mensaje1("Error ingrese identificación del cliente","error"); return;}
    if(actuacli == 1){
      guardarcliente();
    }else{
      actualizarcliente();
    }
  })

  $("#btnsalircli").on('click',function (){
      actuacli = 1
      document.getElementById('frmclientemolde').reset();
  })

  $("#btnnuevo").on('click',function() {
    tipo = 1; 
    actutipo = 1; 
    actuacli = 1;
    reset();
    clase = 'P';
    $('#tbmaterialmolde').find("tr:gt(0)").remove();
    document.getElementById('frmclientemolde').reset();
    $("#slctipomolde").removeAttr('disabled');
    moldep();
  })

  $("#txtcliente").on('keyup',function(e) {
    if(e.which == 8) {
      $("#txtidentificacion").val('');
      $("#txtcodcliente").val('');
    }
  })

  $("#slctipomolde").on('change',function() {
    clasemolde = $("#slctipomolde").val();
    //autocompletarxnombre();
    //autocompletarxidentifi();
    if($("#slctipomolde").val() == "P"){  
      clase = 'P';
      moldep();
      limpimateri();
    }else{
      clase = 'E';
      moldeE();
      limpimateri();
    }
  })
  

  $("#slctipomaterial").change(function(e) {
    clase = $("#slctipomaterial").val();
    if($("#slctipomaterial").val() == "E"){  
        $("#btnlstmaterial").css('display','none');
        $("#txtcodmaterialexter").val('');
        $("#txtmaterialexter").val('');
        $("#txtuniextern").val('');
        $("#txtcanexternorec").removeAttr('disabled');
    }else{
        $("#btnlstmaterial").css('display','block');
        desactivar();
    }
  })

  $("#btnlstmaterial").on('click',function() {
      lstmaterial('lstmaterilas','tbdmaterial');
  });

  $(document).on('click','#lstmaterial',function() {
      $("#txtcodmaterialexter").val($(this).parents('tr').find('td:nth-child(1)').text());
      $("#txtmaterialexter").val($(this).parents('tr').find('td:nth-child(2)').text());
      $("#txtuniextern").val($(this).parents('tr').find('td:nth-child(4)').text().trim());
      $("#txtcantidad").val($(this).parents('tr').find('td:nth-child(3)').text().trim())
      $("#txtcanexternorec").attr('disabled','true');
      $('#mdmaterial').modal('hide');
  });
});


function guardar(codpro,nombre,cantirec,unidad,cantxusar,molde,tipo,cliente){
  $.ajax({
    dataType:'text',
    type: 'POST', 
    url:  'c_registromolde.php',
    data:{
      'accion' : 'guardar',
      'codpro': codpro,
      'nombre': nombre,
      'cantirec': cantirec,
      'unidad': unidad,
      'cantxusar': cantxusar,
      'usuario' : usuario,
      'molde' : molde,
      'tipo': tipo,
      'cliente' : cliente
    },
    success:  function(e){
      
        obj = JSON.parse(e);
        if(obj['dato'][0] == 1){
          array = [
            a = [obj['dato'][1],'none',''],
            b = [nombre.toUpperCase(),'',''],
            c = [Number.parseFloat(cantxusar).toFixed(3),'',''],
            e = [unidad.toUpperCase(),'none',''],
            f = [Number.parseFloat(cantirec).toFixed(3),'none',''],
            f = [clase,'none',''],
            g = [b1,'','']
          ]
          _createtable(array,'tbdmaterialmolde');
          limpimateri()
        }else{
            Mensaje1(obj['dato'][1],"error");
        }
    }
  });
}


function actualizar(tds){
  datos = $("#frmregistromolde").serialize();
  slctipo =$("#slctipomolde").val();
  var materiales = {tds};
  $.ajax({
    dataType:'text',
    type: 'POST', 
    url:  'c_registromolde.php',
    data:datos+"&accion=actualizar&usuario="+usuario+"&material="+JSON.stringify(materiales)+
    "&slctipomolde="+slctipo,
    success:  function(e){
      if(e == 1){
        Mensaje1("Se actualizaron los datos del molde","success");
        reset();
        $('#tbmaterialmolde').find("tr:gt(0)").remove();
        $('#tbmaterialmolde').find("tr:gt(0)").remove();
        document.getElementById('frmclientemolde').reset();
        $("#slctipomolde").removeAttr('disabled');
        moldep();
        clase = 'P';  
        clasemolde = 'P'
        actutipo = 1
      }else{
        Mensaje1(e,"error");
      }
     
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
  //lcproductos();
}

function limpimateri() {
  $("#txtcodmaterialexter").val('');
  $("#txtmaterialexter").val('');
  $("#txtcanexternorec").val('');
  $("#txtuniextern").val('');
  $("#txtcanexterno").val('');
 // $("#txtmedidaexte").val('');
}

function guardarmoldecompleto(tds) {
  datos = $("#frmregistromolde").serialize();
  var materiales = {tds};
  $.ajax({
    dataType:'text',
    type: 'POST', 
    url:  'c_registromolde.php',
    data:datos+"&accion=guardarmolde&usuario="+usuario+"&material="+JSON.stringify(materiales),
    success:  function(e){
      if(e == 1){
        Mensaje1("Se registro los datos del molde correctamente","success");
        reset();
        $('#tbmaterialmolde').find("tr:gt(0)").remove();
        document.getElementById('frmclientemolde').reset();
        $("#slctipomolde").removeAttr('disabled');
        moldep();
        clase = 'P';  
        clasemolde = 'P'
      }else{
        Mensaje1(e,"error");
      }
      
     //actutipo = 1
    }
  });
}

function reset() {
  document.getElementById('frmregistromolde').reset();
  
} 

function buscarmolde(dato){
  $.ajax({
    dataType:'text',
    type: 'POST', 
    url:  'c_registromolde.php',
    data:{
        "accion" : 'buscarmolde',
        "dato" : dato
    } ,
    success:  function(response){
      b2 = "<a id='btnmodactualizar' style='margin-right: 2px;margin-bottom: 1px;' class='btn btn-primary  btn-sm'>"+
      "<i class='icon-pencil' title='Modificar molde'></i>"+
      "</a>";
      obj = JSON.parse(response);
      $("#tbmoldes > tbody").empty();
      $.each(obj['dato'], function(i, item) {
        var fila='';
        fila +="<td class='tdcontent' style=display:none>"+item[0]+"</td>";
        fila +="<td class='tdcontent'>"+item[1]+"</td>";
        fila +="<td class='tdcontent'>"+item[2]+"</td>";
        fila +="<td class='tdcontent' style=display:none>"+item[5]+"</td>";
        fila +="<td class='tdcontent'>"+item[6]+"</td>";
        fila +="<td class='tdcontent' style=display:none>"+item[7]+"</td>";
        fila +="<td class='tdcontent' style=display:none>"+item[8]+"</td>";
        fila +="<td class='tdcontent'>"+b2+"</td>";
        var btn = document.createElement("TR");
        btn.innerHTML=fila;
        document.getElementById('tbdmoldes').appendChild(btn);
      });
    }
  });
}

function materialxmolde(molde,tipomolde){
  $.ajax({
    dataType:'text',
    type: 'POST', 
    url:  'c_registromolde.php',
    data:{
        "accion" : 'materialxmolde',
        "molde" :molde,
        "tipo":tipomolde
    } ,
    success:  function(e){
      $('#tbmaterialmolde').find("tr:gt(0)").remove();
     
      obj = JSON.parse(e);
      $.each(obj['dato'], function(i, item) {
            var fila='';
            fila +="<td class='tdcontent' style=display:none>"+item[0]+"</td>";
            fila +="<td class='tdcontent'>"+item[2]+"</td>";
            fila +="<td class='tdcontent'>"+item[3]+"</td>";
            fila +="<td class='tdcontent' style=display:none>"+item[4]+"</td>";
            fila +="<td class='tdcontent' style=display:none>"+item[5]+"</td>";
            fila +="<td class='tdcontent' style=display:none>"+item[7]+"</td>";
            fila +="<td class='tdcontent'>"+b1+"</td>";
            var btn = document.createElement("TR");
            btn.innerHTML=fila;
            document.getElementById('tbdmaterialmolde').appendChild(btn);
      });
         $("#mdbusmolde").modal('hide');
         limpimateri();
    }
  });
}

function eliminarmaterial(molde,material,dato){
  $.ajax({
    dataType:'text',
    type: 'POST', 
    url:  'c_registromolde.php',
    data:{
        "accion" : 'elimimaterial',
        "material" : material,
        "molde" :molde,
    } ,
    success:  function(e){
      if(e != 1){
        Mensaje1(e,'error');
      }else{
        $(dato).closest('tr').remove();
      }
    }
  });
}

function guardarcliente() {
  datos = $("#frmclientemolde").serialize();
  $.ajax({
    dataType:'text',
    type: 'POST', 
    url:  'c_registromolde.php',
    data:datos+"&accion=guarcliente&usuario="+usuario,
    success:  function(e){
     
        obj = JSON.parse(e);
        if(obj['dato'][0]){
          Mensaje1("Se registro el nuevo cliente","success");
          $("#txtcodcliente").val(obj['dato'][1]);
          $("#txtcliente").val($("#txtnombcliente").val());
          $("#txtidentificacion").val($("#txtidenticliente").val());
          $("#mdclientemolde").modal('hide');
          document.getElementById('frmclientemolde').reset();
        }else{
          Mensaje1(obj['dato'][1],"error");
        }
    }
  });
}


function autocompletarxnombre() {
  buscarxnombre();
  $("#txtcliente").autocomplete({
    source: sugexnombre,
      select: function (event, ui) {
        $("#txtcodclientemolda").val(ui.item.code);
        $("#txtcodcliente").val(ui.item.code);
        $("#txtidentificacion").val(ui.item.identi);
      }
  });
}


function autocompletarxidentifi() {
  buscarxindetifi();
  $("#txtidentificacion").autocomplete({
    source: sugexnombre,
      select: function (event, ui) {
        $("#txtcodclientemolda").val(ui.item.code);
        $("#txtcodcliente").val(ui.item.code);
        $("#txtcliente").val(ui.item.nombre);
      }
  });
}

function buscarxnombre(){
  $.ajax({
    dataType:'text',
    type: 'POST', 
    url:  'c_registromolde.php',
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


function buscarxindetifi(){
  $.ajax({
    dataType:'text',
    type: 'POST', 
    url:  'c_registromolde.php',
    data:{
        "accion" : 'buscarxidentifi',
    } ,
    success:  function(response){
        obj = JSON.parse(response);
        $.each(obj['dato'], function(i, item) {
          sugexnombre.push(item); 
        });
    }
  });
}

function actualizarcliente() {
  datos = $("#frmclientemolde").serialize();
  $.ajax({
    dataType:'text',
    type: 'POST', 
    url:  'c_registromolde.php',
    data:datos+"&accion=actucliente&usuario="+usuario,
    success:  function(e){
        obj = JSON.parse(e);
        if(obj['dato'] == 1){
          Mensaje1("Se actualizo datos del cliente","success"); 
          $("#txtcliente").val('');
          $("#txtcodcliente").val('');
          $("#txtidentificacion").val('');
          $("#mdclientemolde").modal('hide');
          document.getElementById('frmclientemolde').reset();
          actuacli = 1;
        }else{
          Mensaje1(obj['dato'][1],"error");
        }
    }
  });
}

function buscarcliente(cod) {
  $.ajax({
    dataType:'text',
    type: 'POST', 
    url:  'c_registromolde.php',
    data:{
        "accion" : 'buscarcliente',
        "codigo" : cod
    } ,
    success:  function(response){
        obj = JSON.parse(response);
        if(obj['dato'][0] != undefined){
          $("#txtnombcliente").val(obj['dato'][0][1].trim());
          $("#txtdireccliente").val(obj['dato'][0][2].trim());
          $("#txtcorreocliente").val(obj['dato'][0][5].trim());
          $("#txtidenticliente").val(obj['dato'][0][3].trim());
          $("#txttecliente").val(obj['dato'][0][4].trim());
          $("#txtcliente").val(obj['dato'][0][1].trim());
          $("#txtidentificacion").val(obj['dato'][0][3].trim());
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

function lstmaterial(accion,tabla){
  $.ajax({
    dataType:'text',
    type: 'POST', 
    url:  'c_registromolde.php',
    data:{
        "accion" : accion,
    } ,
    success:  function(response){
      b2 = "<a id='lstmaterial' style='margin-right: 2px;margin-bottom: 1px;' class='btn btn-primary btn-sm'>"+
      "<i class='icon-check' title='Buscar materiales'></i>"+
      "</a>";
      obj = JSON.parse(response);
      $("#tbmaterial > tbody").empty();
      $.each(obj['dato'], function(i, item) {
        var fila='';
        fila +="<td class='tdcontent' style=display:none>"+item[0]+"</td>";
        fila +="<td >"+item[1]+"</td>";
        fila +="<td class='tdcontent'>"+item[5]+"</td>";
        fila +="<td class='tdcontent' style=display:none>"+item[8]+"</td>";
        fila +="<td class='tdcontent'>"+b2+"</td>";
        var btn = document.createElement("TR");
        btn.innerHTML=fila;
        document.getElementById(tabla).appendChild(btn);
      });
    }
  });
}

function desactivar() {
    $("#txtcanexternorec").attr('disabled','true');
}

function moldep() {
  $("#txtcliente").attr('disabled',true);
  $("#txtidentificacion").attr('disabled',true);
  $("#slctipomaterial").attr('disabled',true);
  $("#slctipomaterial").val('P');
  $("#txtcanexternorec").attr('disabled',true);
  $("#btnlstmaterial").css('display','block');
  $("#btnbuscclien").addClass("disabled");
  $("#txtcliente").val('');$("#txtidentificacion").val('');
}

function moldeE() {
  $("#txtcliente").removeAttr('disabled');
  $("#txtidentificacion").removeAttr('disabled');
  $("#slctipomaterial").removeAttr('disabled');
  $("#btnbuscclien").removeClass("disabled");
  $("#txtcanexternorec").removeAttr('disabled');
  $("#slctipomaterial").val('E');
  $("#btnlstmaterial").css('display','none');
}

function datosrepetidos(tabla,dato) {
  filas = $("#"+tabla+" tr");
  for (let l = 0; l < filas.length; l++) {
      if($(filas[l]).find("td")[0].innerHTML == dato){
          suma = Number($(filas[l]).find("td")[2].innerHTML) + Number($("#txtcanexterno").val());
          $(filas[l]).find("td")[2].innerHTML = Number.parseFloat(suma).toFixed(3);
          return true;
      }
  }
  return false;
}


  function guardar_materialpropio(codpro,nombre,unidad,cantxusar,molde,tipo){
    $.ajax({
      dataType:'text',
      type: 'POST', 
      url:  'c_registromolde.php',
      data:{
        'accion' : 'guardarmatepropio',
        'codpro': codpro,
        'nombre': nombre,
        'unidad': unidad,
        'cantxusar': cantxusar,
        'usuario' : usuario,
        'molde' : molde,
        'tipo':tipo
      },
      success:  function(e){
      
          obj = JSON.parse(e);
          if(obj['dato'][0] == 1){
            array = [
              a = [obj['dato'][1],'none',''],
              b = [nombre.toUpperCase(),'',''],
              c = [Number.parseFloat(cantxusar).toFixed(3),'',''],
              e = [unidad.toUpperCase(),'none',''],
              f = ['0.000','none',''],
              g = [b1,'','']
            ]
            _createtable(array,'tbdmaterialmolde');
            limpimateri()
          }else{
              Mensaje1(obj['dato'][1],"error");
          }
      }
    });
  }
