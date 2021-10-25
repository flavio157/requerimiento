var supersonal = [];
var sumolde = [];
$(function() {
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
          lstmateriales(ui.item.code)
        }
    });

    $("#addpersonal").click(function (params) {
        tabla = $("#tbdpersonalmolde  tr");
        for (let i = 0; i < tabla.length; i++) { 
          if($(tabla[i]).find("td")[0].innerHTML == $("#txtcodpermolde").val()){
            Mensaje1('Personal ya agregado','error'); return;
          }
        }
        var date1 = new Date($("#txtfecinipers").val());
        var date2 = new Date($("#txtfecfinpers").val());
        if($("#txtfecinipers").val() == '' || $("#txtfecfinpers").val() == '' ){
          Mensaje1('Seleccione fecha del personal','error'); return;}
        if($("#txtcodpermolde").val() == '' || $("#txtpersonalmolde").val() == ''){
          Mensaje1('Ingrese personal','error'); return;
        }  

        if(date1 > date2){Mensaje1('Error fecha de inicio no puede ser mayor a fecha fin','error'); return;}
        b1 = "<a id='btneliminarPer' class='btn btn-danger  btn-sm'>"+
                    "<i class='icon-trash'></i></a>";
        
        array = [
            a = [$("#txtcodpermolde").val(),'none'],
            b = [$("#txtpersonalmolde").val().toUpperCase(),''],
            c = [$("#txtfecinipers").val(),''],
            d = [$("#txtfecfinpers").val(),''],
           // e = ['',''],
            f = [b1,''],
        ];
        _createtable(array,'tbdpersonalmolde');
        $("#txtcodpermolde").val('');
        $("#txtpersonalmolde").val('');
        $("#txtfecinipers").val('');
        $("#txtfecfinpers").val('');
        $("#texobservacion").val('');
    });

    $("#txtdesmolde").keydown(function(e){
      if(e.which == 8) {
         $('#tbmaterialmolde').find("tr:gt(0)").remove();
      }
    });


    $("#btng_molde").on('click',function () {
      var date1 = new Date($("#txtfechini").val());
      var date2 = new Date($("#txtfechfin").val());
      if(date1 > date2){Mensaje1('Error fecha de inicio no puede ser mayor a fecha fin','error'); return;}
      if(date1 > date2){Mensaje1('Error fecha de inicio no puede ser mayor a fecha fin','error'); return;}
      if($("#txtfechini").val() == '' || $("#txtfechfin").val() == '' ){
        Mensaje1('Seleccione fecha de inicio y fin','error'); return;}
      if($("#txtcodmolde").val() == '' || $("#txtdesmolde").val() == '' || $("#txtmedmolde").val() == ''){
        Mensaje1('Ingrese datos del molde','error'); return;
      }  
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
                $(td[l]).find("td")[3].innerHTML
            ]
        }
      }  
      _guardardatos($("#txtcodmolde").val(),$("#txtfechini").val(),$("#txtfechfin").val(),tds,codmat);
    });

    $(document).on('click','#btneliminarPer',function() {
        $(this).closest('tr').remove();
    })


    $("#btnnuevo").on('click',function(){
      limpiar();
    });

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
       Mensaje1("Se registraron los datos correctamente","success");
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