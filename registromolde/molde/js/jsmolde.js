var supersonal = [];
var sumolde = [];
$(function() {

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
    lstmoldes();

    $("#txtdesmolde").autocomplete({
      source: sumolde,
        select: function (event, ui) {
          $("#txtcodmolde").val(ui.item.code);
          $("#txtmedmolde").val(ui.item.medida);
          $('#tbdmaterialmolde').find("tr").remove();
          lstmateriales(ui.item.code)
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
            d = [$("#txtfecfinpers").val(),''],
            e = [b1,''],
            f = [$("#texobservacion").val(),'none'],
            g = [$("#txthortrab").val(),'none'],
            h = [$("#txtcosthora").val(),'none'],
        ];
        validar(array);
       
    });

    $("#txtdesmolde").keydown(function(e){
      if(e.which == 8) {
         $('#tbmaterialmolde').find("tr:gt(0)").remove();
      }
    });

  
    $("#btng_molde").on('click',function () {
     
      if($("#tbdmaterialmolde  tr").length == 0){
        Mensaje1('No se ha espesificado materiales para el molde','error'); return;
      }else{
        var td =  $("#tbdmaterialmolde  tr");
        var codmat = [];
        for (let l = 0; l < td.length; l++) {
          codmat[l] =[
                $(td[l]).find("td")[0].innerHTML,
                $(td[l]).find("td")[2].innerHTML,
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
                $(td[l]).find("td")[2].innerHTML,
                $(td[l]).find("td")[3].innerHTML,
                $(td[l]).find("td")[5].innerHTML,
                $(td[l]).find("td")[6].innerHTML,
                $(td[l]).find("td")[7].innerHTML
            ]
        }
      }  
      _guardardatos($("#txtcodmolde").val(),$("#txtfechini").val(),$("#txtfechfin").val(),tds,codmat);
    });

    $(document).on('click','#btneliminarPer',function() {
        $(this).closest('tr').remove();
    })

    $(document).on('click','#btneliminarmate',function(){
        $(this).closest('tr').remove();
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
});


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
        "dato" : dato
    } ,
    success:  function(response){
      obj = JSON.parse(response);
      var color =''
      $.each(obj['dato'], function(i, item) {
        var fila="<tr>";
        if(Number(item[3]) > Number(item[5])){
            color = "'tdcontent table-danger'";
        }else{
          color = 'tdcontent'
        }
            fila +="<td class="+color+" style='display:none'>"+item[0]+"</td>";
            fila +="<td class="+color+">"+item[2]+"</td>";
            fila +="<td class="+color+">"+item[3]+"</td>";
            fila +="<td class="+color+">"+item[4]+"</td>";
            fila +="<td class="+color+">"+item[5]+"</td>";
            fila +="<td class="+color+"><a id='btneliminarmate' class='btn btn-danger  btn-sm'><i class='icon-trash'></i></a></td>"
            fila +="</tr>";
            var btn = document.createElement("TR");
            btn.innerHTML=fila;
            document.getElementById("tbdmaterialmolde").appendChild(btn);
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

function _guardardatos(idmolde,fecini,fecfin,tds,codmat) {
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
        "fecfin" :fecfin,
        "usuario" : usuario,
        "lstpersonal" :JSON.stringify(personal),
        "codmaterial" : JSON.stringify(codmate)
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
  document.getElementById("frmfabricacion").reset();
}

function validar(array){
 cod = $("#txtcodpermolde").val()
 nomper = $("#txtpersonalmolde").val()
 fecin =  $("#txtfechini").val();
 fecfin =  $("#txtfechfin").val();
 obser = $("#texobservacion").val()
 hora = $("#txthortrab").val()
 costo =  $("#txtcosthora").val()
  $.ajax({
    dataType:'text',
    type: 'POST', 
    url:  'c_moldes.php',
    data:{
        "accion" : 'validarpersonal',
        "cod" : cod,
        "nomper":nomper,
        "fecin" : fecin,
        "fecfin" :fecfin,
        "obser" : obser,
        "hora" : hora,
        "costo" : costo,
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
  $("#txtfecinipers").val('');
  $("#txtfecfinpers").val('');
  $("#texobservacion").val('');
  $("#texobservacion").val('');
  $("#txthortrab").val('');
  $("#txtcosthora").val('');
}
