var usu;
$(document).ready(function () {
    v_avance();
    usu = $("#vrcodpersonal").val();
    $(document).on('click',"#btnconfimar",function(){
      Mensaje2(
        $(this).parents('tr').find('td:nth-child(1)').text().trim(),
        $(this).parents('tr').find('td:nth-child(3)').text().trim(),
        $(this).parents('tr').find('td:nth-child(11)').text().trim(),
        $(this).parents('tr').find('td:nth-child(4)').text().trim(),
        $(this).parents('tr').find('td:nth-child(2)').text().trim(),
        $(this).parents('tr').find('td:nth-child(7)').text().trim());
    });
});

function v_avance(){
   $("#tbderivar > tbody").empty();
    $.ajax({
      dataType:'text',
      type: 'POST', 
      url:  'c_registroalmacen.php',
      data:{
        "accion" : 'view_avance',
      },
      success:  function(e){
        obj = JSON.parse(e);
        b2 = "<a id='btnconfimar' style='margin-right: 2px;margin-bottom: 1px;' class='btn btn-primary  btn-sm'>"+
              "<i class='icon-check' title='confirmar ingreso'></i>";
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
          fila +="<td class='tdcontent'>"+item[6]+"</td>"; 
          tara = item[9] * item[16] 
          fila +="<td class='tdcontent'>"+Number(item[6] * item[10] + tara).toFixed(3)+"</td>";
          fila +="<td class='tdcontent'>"+b2+"</td>"
          var btn = document.createElement("TR");
          btn.innerHTML=fila;
          document.getElementById("tbdderivar").appendChild(btn);
        });
      }
    });
}

function r_avance(produccion,producto,cantidad,codpersonal,codavance,fecha){
    $.ajax({
      dataType:'text',
      type: 'POST', 
      url:  'c_registroalmacen.php',
      data:{
          "accion" : 'r_produccion',
          "produccion" : produccion,
          "producto" : producto,
          "cantidad" : cantidad,
          "usu" : usu,
          "codpersonal" : codpersonal,
          "codavance" : codavance,
          "fecha":fecha
      },beforeSend: function () {
        $('.ajax-loader').css("visibility", "visible");
      },success:  function(e){
        console.log(e);
        if(e == 1){
            v_avance();
            Mensaje1("Se registro el ingreso al almacén general","success");
        }else{
            Mensaje1(e,"error"); 
        }
        $('.ajax-loader').css("visibility", "hidden");
      },complete: function(){
        $('.ajax-loader').css("visibility", "hidden");
      }
    });
}

function Mensaje1(texto,icono){
    Swal.fire({icon: icono,title: texto,});
}

function  Mensaje2(produccion,producto,cantidad,codpersonal,codavance,fecha) {
  Swal.fire({
    title: '¿Seguro que desea confirmar el ingreso?',
    text: "Esta acción no podra revertirse",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#28a745',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Confirmar',
    cancelButtonText: 'Cancelar'
  }).then((result) => {
    if (result.isConfirmed) {
      r_avance(produccion,producto,cantidad,codpersonal,codavance,fecha)  
    }
  })
}