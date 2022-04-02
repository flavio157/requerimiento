var sugematerial = [];tipo = "";
$(document).ready(function () {
    autocompletarproducto();categoria();
    stock('','','');
    $("#rdtodos").change(function(){
        cate = $("#slccategoria").val();
        tipo = "";
        stock('','',cate);
    })

    $("#rdsinstock").change(function() {
        cate = $("#slccategoria").val();
        stock('s','',cate);tipo = 's'
    })

    $("#tdconstock").change(function(){
        cate = $("#slccategoria").val();
        stock('c','',cate);tipo = 'c'
    })

    $('#txtbuscarpro').keydown(function(e) {
        if (e.keyCode == 8) $('#mdtxtcod').val('');
        cate = $("#slccategoria").val()
        stock('','',cate); tipo = "";
    });

    $("#btnbuscclien").on('click',function(){
        cod = $("#mdtxtcod").val();
        if(cod == ""){Mensaje1("Seleccione un producto","error"); return}
        cate = $("#slccategoria").val();
        stock('p',cod,cate);
    });

    $("#slccategoria").on('change',function() {
        console.log(tipo);
        stock(tipo,'',$(this).val());
    })
});

function stock(filtro,cod,cate) {
    $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  'c_stockproducto.php',
        data:{
            "accion" : 'buscar',
            "filtro" : filtro,
            "cod" : cod,
            "categoria":cate
        } ,
        success:  function(e){
            console.log(e);
           obj = JSON.parse(e);
           $("#tbproducto > tbody").empty();
           $.each(obj['dato'], function(i, item) {
                var fila='';
                var id = Number(i)+1;
                fila +="<td class='tdcontent' style=display:none>"+item[0]+"</td>";
                fila +="<td class='tdcontent'>"+id+"</td>";
                fila +="<td class='tdcontent'>"+item[1]+"</td>";
                fila +="<td class='tdcontent'>"+item[5]+"</td>";
                var btn = document.createElement("TR");
                btn.innerHTML=fila;
                document.getElementById('tbdproducto').appendChild(btn);
           });
        }
     });     
}

function autocompletarproducto() {
    sugematerial = []
    buscarproducto();
    $("#txtbuscarpro").autocomplete({
      source: sugematerial,
        select: function (event, ui) {
          $("#mdtxtcod").val(ui.item.code);
          $("#txtbuscarpro").val(ui.item.label);
         
        }
    });
}

function buscarproducto(){
    $.ajax({
      dataType:'text',
      type: 'POST', 
      url:  'c_stockproducto.php',
      data:{
          "accion" : 'lstmaterial',
      } ,
      success:  function(response){
          obj = JSON.parse(response);
          $.each(obj['dato'], function(i, item) {
            sugematerial.push(item);
          });
      }
    });
}

function Mensaje1(texto,icono){
    Swal.fire({
     icon: icono,
     title: texto,
     });
}

function categoria(){
    $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  'c_stockproducto.php',
        data: {
            "accion": "slccategiria",
        },
        success: function(e){
          obj = JSON.parse(e);
         $.each(obj['dato'], function(i, item) {
            $("#slccategoria").append("<option value=" + item[0] + ">" + item[1]+ "</option>");
         })
        }
    });
}