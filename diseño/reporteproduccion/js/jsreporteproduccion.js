var usu; var sugeproductos = [];
$(document).ready(function () {
    v_avance('','','');
    autocompletarMaterial();
    usu = $("#vrcodpersonal").val();
    
    $("#btnbuscaproduc").on('click',function () {
        codprodu = $("#txtcodpor").val();
        fechini = $("#txtfechini").val();
        fechfin = $("#txtfechfin").val();
        v_avance(codprodu,fechini,fechfin)
    })

});

function v_avance(codprodu,fechini,fechfin){
    $.ajax({
      dataType:'text',
      type: 'POST', 
      url:  'c_reporteproduccion.php',
      data:{
          "accion" : 'view_avance',
          "codprod" : codprodu,
          "fechini" : fechini,
          "fechfin" : fechfin
      },
      success:  function(e){
        obj = JSON.parse(e);
        if(obj['t'] == ""){
          $("#tbderivar > tbody").empty();
          $.each(obj['dato'], function(i, item) {
            var fila='';
            fila +="<td class='tdcontent' style=display:none>"+item[1]+"</td>";
            fila +="<td class='tdcontent' style=display:none>"+item[2]+"</td>";
            fila +="<td class='tdcontent' style=display:none>"+item[14]+"</td>";
            fila +="<td class='tdcontent' style=display:none>"+item[18]+"</td>";
            fila +="<td class='tdcontent'>"+item[12]+"</td>";
            fila +="<td class='tdcontent'>"+item[15]+"</td>";
            fila +="<td class='tdcontent'>"+item[4]+"</td>";
            fila +="<td class='tdcontent'>"+item[16]+"</td>";
            fila +="<td class='tdcontent'>"+item[7]+"</td>";
            fila +="<td class='tdcontent'>"+item[17]+"</td>";
            fila +="<td class='tdcontent'>"+parseInt(item[6])+"</td>"; 
            var btn = document.createElement("TR");
            btn.innerHTML=fila;
            document.getElementById("tbdderivar").appendChild(btn);
          });
        }else{
          Mensaje1(obj['t'],"error");
        }
      }
    });
}


function Mensaje1(texto,icono){
    Swal.fire({icon: icono,title: texto,});
}


function autocompletarMaterial() {
  buscarmaterial();
  $("#txtsugeprodu").autocomplete({
        source: sugeproductos,
        select: function (event, ui) {
          $("#txtcodpor").val(ui.item.code);
        }
  });
}

function buscarmaterial() {
  sugeproductos = [];
  $.ajax({
      dataType:'text',
      type: 'POST', 
      url:  'c_reporteproduccion.php',
      data:{"accion" : 'productos',},
      success:  function(e){
          obj = JSON.parse(e);
          $.each(obj['dato'], function(i, item) {
            sugeproductos.push(item); 
          });
      }
  });   
}
