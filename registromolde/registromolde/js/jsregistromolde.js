var sugematerial = [];
var sugemolde = [];
var tipo = 1;
var actualiza = 1;
var b1 = "<a id='btnactualizar' style='margin-right: 2px;margin-bottom: 1px;' class='btn btn-primary  btn-sm'>"+
"<i class='icon-pencil' title='Modificar material'></i>"+
"</a><a id='btneliminar' style='margin-bottom: 1px;' class='btn btn-danger  btn-sm'>"+
"<i class='icon-trash' title='Eliminar material'></i>"+
"</a>";
$(function() {

  autocompletarMolde()

  autocompletarMaterial();

  $("#btnagremater").on('click',function(){
    molde  = $("#txtcodmolde").val().trim();
    material = $("#txtcodmaterial").val().trim();
    nombre = $("#txtnombmaterial").val().trim();
    cantidad = $("#txtcantmaterial").val().trim();
    medidas = $("#txtmendidmater").val().trim();
    unidad = $("#txtunimaterial").val().trim();
    if($("#txtcodmaterial").val().trim() == 0){ Mensaje1("Error material invalido","error");return;}
    if($("#txtnombmaterial").val().trim() == 0){ Mensaje1("Error ingrese nombre material","error");return;}
    if($("#txtcantmaterial").val().trim() == 0){ Mensaje1("Error ingrese cantidad","error");return;}
    
    if(tipo == 1){
      e = datosrepetidos('tbdmaterialmolde',$("#txtcodmaterial").val());
      if(!e){
        verficarmateriales($("#txtcodmaterial").val(),$("#txtnombmaterial").val(),
                           $("#txtmendidmater").val(),$("#txtcantmaterial").val(),unidad)
      }
    }else{
      verficar(material,nombre,medidas,cantidad,unidad)

    }
  });


  $(document).on('click','#btnactualizar',function(){
      $("#txtcodmaterial").val($(this).parents('tr').find('td:nth-child(1)').text());
      $("#txtnombmaterial").val($(this).parents('tr').find('td:nth-child(2)').text());
      $("#txtcantmaterial").val($(this).parents('tr').find('td:nth-child(3)').text());
      $("#txtmendidmater").val($(this).parents('tr').find('td:nth-child(4)').text());    
      $("#txtunimaterial").val($(this).parents('tr').find('td:nth-child(5)').text());  
      $(this).closest('tr').remove();
      actualiza = 0;
  });

  $(document).on('click','#btneliminar',function(){
    $(this).closest('tr').remove();
    if(tipo != 1){
      material = $(this).parents('tr').find('td:nth-child(1)').text();
      molde = $("#txtcodmolde").val();
      eliminarmaterial(molde,material);
    }
  });
  
  $("#txtnombmaterial").keydown(function(e){
    if(e.which == 8) {
       $("#txtcodmaterial").val('');
    }
  });

  $("#btng_molde").on('click',function(){
    td = $("#tbdmaterialmolde tr");
      if($("#txtnommolde").val().trim() == 0){Mensaje1("Error ingrese nombre del molde","error");return;}
      if($("#txtmedmolde").val().trim() == 0){Mensaje1("Error ingrese medidas del molde","error");return;}
      if($("#tbdmaterialmolde tr").length == 0 ){Mensaje1("Error ingrese materiales para molde","error");return;}
      var tds = [];
      for (let l = 0; l < td.length; l++) {
          tds[l] =[
              $(td[l]).find("td")[0].innerHTML,
              $(td[l]).find("td")[2].innerHTML,
              $(td[l]).find("td")[3].innerHTML.trim(),
              $(td[l]).find("td")[4].innerHTML.trim(),
          ]
      }
    if(tipo == 1){
      guardar(tds)
    }else{
      actualizar(tds)
    }
  });

  $("#btnbusmolde").on('click',function () {
    buscarmolde($("#txtcodmolde").val());
    $('#tbmaterialmolde').find("tr:gt(0)").remove();
  })
  
  $("#txtmedmolde").keyup(function() {
    restriccion('txtmedmolde',50);
  })
  $("#txtmedmolde").keyup(function() {
    restriccion('txtnommolde',100);
  })

  $("#btnnuevo").on('click',function() {
      tipo = 1;
      limform();
  });

  $("#btnbuscpers").on('click',function() {
      $("#txtbuscmolde").val('');
  });

});


function guardar(tds){ 
  datos = $("#frmregistromolde").serialize();
  var materiales = {tds};
  usu = $("#vrcodpersonal").val() 
  $.ajax({
    dataType:'text',
    type: 'POST', 
    url:  'c_registromolde.php',
    data:datos+"&accion=guarmaterial&usuario="+usu+"&material="+JSON.stringify(materiales),
    success:  function(e){
      if(e == 1){
        Mensaje1('Se registraron correctamente lo datos','success');
        limform();
      } else{
        Mensaje1(e,'error')
      };
      autocompletarMolde();
    }
  });
}

function actualizar(tds){ 
  datos = $("#frmregistromolde").serialize();
  var materiales = {tds};
  usu = $("#vrcodpersonal").val() 
  $.ajax({
    dataType:'text',
    type: 'POST', 
    url:  'c_registromolde.php',
    data:datos+"&accion=actualmater&usuario="+usu+"&material="+JSON.stringify(materiales),
    success:  function(e){
      if(e == 1){
        Mensaje1('Se actualizaron correctamente los datos','success');
        limform();
        tipo = 1;
      } else{
        Mensaje1(e,'error')
      };
      autocompletarMolde();
    }
  });
}

function buscarpro(){
  $.ajax({
    dataType:'text',
    type: 'POST', 
    url:  'c_registromolde.php',
    data:{
        "accion" : 'buscar',
    } ,
    success:  function(response){
        obj = JSON.parse(response);
        $.each(obj['dato'], function(i, item) {
          sugematerial.push(item); 
        });
    }
  });
}

function autocompletarMaterial() {
  buscarpro();
  $("#txtnombmaterial").autocomplete({
    source: sugematerial,
      select: function (event, ui) {
        $("#txtcodmaterial").val(ui.item.code);
        $("#txtunimaterial").val(ui.item.uni);
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
  lcproductos();
}
function lcproductos(){
  $("#txtcodmaterial").val('');
  $("#txtnombmaterial").val('');
  $("#txtcantmaterial").val('');
  $("#txtunimaterial").val('');
  $("#txtmendidmater").val('');
}

function datosrepetidos(tabla,dato) {
  filas = $("#"+tabla+" tr");
  for (let l = 0; l < filas.length; l++) {
      if($(filas[l]).find("td")[0].innerHTML == dato){
          suma = Number($(filas[l]).find("td")[2].innerHTML) + Number($("#txtcantmaterial").val());
          $(filas[l]).find("td")[2].innerHTML = Number.parseFloat(suma).toFixed(3);
          lcproductos();
          return true;
      }
  }
  return false;
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


function lstmolde(){
  $.ajax({
    dataType:'text',
    type: 'POST', 
    url:  'c_registromolde.php',
    data:{
        "accion" : 'lstmolde',
    } ,
    success:  function(response){
        obj = JSON.parse(response);
        $.each(obj['dato'], function(i, item) {
          sugemolde.push(item); 
        });
    }
  });
}

function autocompletarMolde() {
  lstmolde();
  sugemolde = []
  $("#txtbuscmolde").autocomplete({
    source: sugemolde,
      select: function (event, ui) {
        $("#txtcodmolde").val(ui.item.code)
        $("#txtunimaterial").val(ui.item.uni)
      }
  });
}

function buscarmolde(molde){
  $.ajax({
    dataType:'text',
    type: 'POST', 
    url:  'c_registromolde.php',
    data:{
        "accion" : 'buscarmolde',
        "molde" : molde,
    } ,
    success:  function(response){
      obj = JSON.parse(response);
     
      $.each(obj['dato'], function(i, item) {
         $("#txtnommolde").val(item[1]);
         $("#txtmedmolde").val(item[2]);
         $("#slcestado").val(item[3]);
         var fila='';
         fila +="<td class='tdcontent' style=display:none>"+item[4]+"</td>";
         fila +="<td class='tdcontent'>"+item[5]+"</td>";
         fila +="<td class='tdcontent'>"+item[8]+"</td>";
         fila +="<td class='tdcontent'>"+item[6]+"</td>";
         fila +="<td class='tdcontent' style=display:none>"+item[7]+"</td>";
         fila +="<td class='tdcontent'>"+b1+"</td>";
         var btn = document.createElement("TR");
         btn.innerHTML=fila;
         document.getElementById('tbdmaterialmolde').appendChild(btn);
         $("#mdbusmolde").modal('hide');
         tipo = 0;
      });
    }
  });
}

function limform() {
    $("#txtcodmolde").val(' ');
    document.getElementById('frmregistromolde').reset();
    $('#tbmaterialmolde').find("tr:gt(0)").remove();
}

function restriccion(txt,cantidad) {
  var input=  document.getElementById(txt);
        input.addEventListener('input',function(){
           $("#"+txt).val($("#"+txt).val().slice(0,cantidad)) ; 
    })
}

function guardarnuevomaterial(molde,material,cantidad,medidas,nombre,unidad) {
  usu = $("#vrcodpersonal").val(); 
  $.ajax({
    dataType:'text',
    type: 'POST', 
    url:  'c_registromolde.php',
    data:{
      "accion":'actmaterial',
      "usuario":usu,
      "molde" : molde,
      "material":material,
      "cantidad":cantidad,
      "medidas":medidas
    },
    success:  function(e){
      if(e == 1){
       
        array = [
            a = [material,'none',''],
            b = [nombre.toUpperCase(),'',''],
            c = [Number.parseFloat(cantidad).toFixed(3),'',''],
            d = [medidas,'',''],
            d = [unidad.toUpperCase(),'none',''],
            i = [b1,'','']
        ]
        _createtable(array,'tbdmaterialmolde');
        Mensaje1('Se agregro el material','success');
      } else{
        Mensaje1(e,'error')
      };
    }
  });
}

function verficarmateriales(material,nombre,medidas,cantidad,unidad) {
    $.ajax({
      dataType:'text',
      type: 'POST', 
      url:  'c_registromolde.php',
      data:{
          "accion" : 'verimaterial',
          "material" : material,
          "nombre" : nombre,
          "cantidad" : cantidad,
          "unidad":unidad,
          "medidamat":medidas,
      } ,
      success:  function(response){
        if(response == 1){
          
            array = [
                a = [material,'none',''],
                b = [nombre.toUpperCase(),'',''],
                c = [Number.parseFloat(cantidad).toFixed(3),'',''],
                d = [medidas,'',''],
                d = [unidad.toUpperCase(),'none',''],
                i = [b1,'','']
            ]
            actualiza = 1;
            _createtable(array,'tbdmaterialmolde');
        }else{
          Mensaje1(response,"error");
        }
      }
    });
}


function eliminarmaterial(molde,material){
  $.ajax({
    dataType:'text',
    type: 'POST', 
    url:  'c_registromolde.php',
    data:{
        "accion" : 'elimimaterial',
        "material" : material,
        "molde" :molde
    } ,
    success:  function(e){
      /*if(e == 1){
        Mensaje1('Se elimino el material','success');
      }*/
    }
  });
}


function verficar(material,nombre,medidas,cantidad,unidad) {
  $.ajax({
    dataType:'text',
    type: 'POST', 
    url:  'c_registromolde.php',
    data:{
        "accion" : 'verimaterial',
        "material" : material,
        "nombre" : nombre,
        "cantidad" : cantidad,
        "unidad":unidad,
        "medidamat":medidas,
    } ,
    success:  function(response){
      if(response == 1){
        e = datosrepetidos('tbdmaterialmolde',material);
        if(!e && actualiza == 1){
          guardarnuevomaterial(molde,material,cantidad,medidas,nombre,unidad);
        }else if(actualiza == 0){
          verficarmateriales(material,nombre,medidas,cantidad,unidad)
        }
      }else{
        Mensaje1(response,"error");
      }
    }
  });
}