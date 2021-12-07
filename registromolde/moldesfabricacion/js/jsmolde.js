var tabla = '';
$(function() {
 
  lstmoldesfabricacion();

    $(document).on('click','#btnteminarmolde',function(){
       molde = $(this).parents('tr').find('td:nth-child(1)').text();
       fabricacion = $(this).parents('tr').find('td:nth-child(2)').text();
       $(this).parents('tr').addClass('highlight').siblings().removeClass('highlight');
       tabla = this;
       Mensaje2(molde,fabricacion);
    });

    $(document).on('click','#btnvermolde',function() {
      lstmateriales($(this).parents('tr').find('td:nth-child(1)').text())
      lstpersonainvluc($(this).parents('tr').find('td:nth-child(2)').text())
      $('#txtdesmolde').val($(this).parents('tr').find('td:nth-child(3)').text());
      $('#txtmedidas').val($(this).parents('tr').find('td:nth-child(6)').text());
      lstcliente($(this).parents('tr').find('td:nth-child(8)').text());
      $(this).parents('tr').addClass('highlight').siblings().removeClass('highlight');

    });
});


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
      $("#tbmaterialmolde > tbody").empty();
      obj = JSON.parse(response);
      $.each(obj['dato'], function(i, item) {
            var fila="<tr>";
            fila +="<td class='tdcontent' style='display:none'>"+item[0]+"</td>";
            fila +="<td >"+item[2]+"</td>";
            fila +="<td class='tdcontent'>"+item[3]+"</td>";
            fila +="<td class='tdcontent'  style='display:none'>"+item[4]+"</td>";
            fila +="<td class='tdcontent'>"+item[5]+"</td>";
            fila +="</tr>";
            var btn = document.createElement("TR");
            btn.innerHTML=fila;
            document.getElementById("tbdmaterialmolde").appendChild(btn);
      }) 
    }
  }); 
}


function lstpersonainvluc(dato) {
  $.ajax({
    dataType:'text',
    type: 'POST', 
    url:  'c_moldes.php',
    data:{
        "accion" : 'lstpersinvolu',
        "dato" : dato,
    } ,
    success:  function(response){
      $("#tbpersonalmolde > tbody").empty();
      obj = JSON.parse(response);
      
      $.each(obj['dato'], function(i, item) {
            fecha = item[3].split(' ');
            var fila="<tr>";
            fila +="<td class='tdcontent' style='display:none'>"+item[0]+"</td>";
            fila +="<td class='tdcontent'>"+item[2]+"</td>";
            fila +="<td class='tdcontent'>"+fecha[0]+"</td>";
            fila +="<td class='tdcontent'  style='display:none'>"+item[4]+"</td>";
            fila +="<td class='tdcontent'>"+item[4]+"</td>";
            fila +="</tr>";
            var btn = document.createElement("TR");
            btn.innerHTML=fila;
            document.getElementById("tbdpersonalmolde").appendChild(btn);
      }) 
    }
  }); 
}

function lstcliente(dato) {

  $.ajax({
    dataType:'text',
    type: 'POST', 
    url:  'c_moldes.php',
    data:{
        "accion" : 'cliente',
        "dato" : dato,
    } ,
    success:  function(response){
      obj = JSON.parse(response);
      if(Object.keys(obj['dato']) != ''){
        $("#txtcliente").val(obj['dato'][0][1]);
        $("#txtdircli").val(obj['dato'][0][2]);
        $("#txtidencli").val(obj['dato'][0][3]);
        $("#txttelcli").val(obj['dato'][0][4]);
        $("#txtcorclie").val(obj['dato'][0][5]);
      }else{
        $("#txtcliente").val('Molde de la empresa');
        $("#txtdircli").val('');
        $("#txtidencli").val('');
        $("#txttelcli").val('');
        $("#txtcorclie").val('');
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

function lstmoldesfabricacion() {
  $.ajax({
    dataType:'text',
    type: 'POST', 
    url:  'c_moldes.php',
    data:{
        "accion" : 'lstfabricacion',
    } ,
    success:  function(response){
      obj = JSON.parse(response);
      $.each(obj['dato'], function(i, item) {
        fecha = item[3].split(" ");
        var fila="<tr>";
            fila +="<td style='display:none'>"+item[0]+"</td>"; //molde
            fila +="<td style='display:none'>"+item[5]+"</td>"; //fabricacion
            fila +="<td class='tdcontent'>"+item[1]+"</td>";
            fila +="<td class='tdcontent'>"+fecha[0]+"</td>";
            fila +="<td class='tdcontent' style='display:none'>"+item[4]+"</td>";
            fila +="<td class='tdcontent'>"+item[2]+"</td>";
            fila +="<td class='tdcontent'>"+item[4]+"</td>";
            fila +="<td class='tdcontent' style='display:none'>"+item[8]+"</td>";
            fila +="<td class='tdcontent'>"+
            "<a class='btn btn-success btn-sm' type='button' id='btnteminarmolde' style='margin-bottom: 1px;margin-right: 1px;'>"+
                "<i class='icon-check' title='registrar final de fabricación'></i></a>"+
            "<a class='btn btn-success btn-sm' type='button' id='btnvermolde' style='margin-bottom: 1px;margin-right: 1px;'>"+
                "<i class='icon-eye' title='listar materiales y personal de la fabricación'></i></a>"+
            "</td>";
            fila +="</tr>";
            var btn = document.createElement("TR");
            btn.innerHTML=fila;
            document.getElementById("tbdlistamoldes").appendChild(btn);
      }) 
    }
  }); 
}

function Mensaje2(molde,fabricacion) {
  Swal.fire({
      title: '¿Desea terminar la fabricación del molde?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Guardar',
      cancelButtonColor: '#d33',
      cancelButtonText: 'Cancelar',
    }).then((result) => {
      if (result.isConfirmed) {
        terminarfabricacion(molde,fabricacion);
      }
    })
}

function terminarfabricacion(molde,fabricacion){
  usuario = $("#vrcodpersonal").val();
  $.ajax({
    dataType:'text',
    type: 'POST', 
    url:  'c_moldes.php',
    data:{
        "accion" : 'terminomolde',
        "molde":molde,
        "fabricacion" : fabricacion,
        "usu" : usuario,
    } ,
    success: function (e) {
      if(e == 1){
        $(tabla).closest('tr').remove();
        document.getElementById('frmfabricacion').reset();
        $("#tbmaterialmolde > tbody").empty();
        $("#tbpersonalmolde > tbody").empty();
        Mensaje1('Se registro el fin de la fabricacion del molde','success');
      }else{
        Mensaje1(e,'error');
      }
    }
     
  });
  
}