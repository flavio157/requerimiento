var supersonal = [];
var sumolde = [];
$(function() {
    personal();
    $("#txtpersonalmolde").autocomplete({
      source: supersonal,
        select: function (event, ui) {
          console.log(ui);
          $("#txtcodpermolde").val(ui.item.code);
        }
    });
    lstmoldes();

    $("#txtdesmolde").autocomplete({
      source: sumolde,
        select: function (event, ui) {
          $("#txtmedmolde").val(ui.item.medida);
          lstmateriales(ui.item.code)
        }
    });

    $("#addpersonal").click(function (params) {
        b1 = "<a id='btneliminar' class='btn btn-danger  btn-sm'>"+
                    "<i class='icon-trash'></i></a>";
        array = [
            a = [$("#txtcodpermolde").val(),'none'],
            b = [$("#txtpersonalmolde").val().toUpperCase(),''],
            c = ['',''],
            d = ['',''],
            e = ['',''],
            f = [b1,''],
        ];
        _createtable(array,'tbdpersonalmolde');
    });

    $("#txtdesmolde").keydown(function(e){
      if(e.which == 8) {
         $('#tbmaterialmolde').find("tr:gt(0)").remove();
      }
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
        if(Number(item[2]) > Number(item[4])){
            color = 'table-danger';
        }else{
          color = ''
        }
            fila +="<td class="+color+">"+item[1]+"</td>";
            fila +="<td class="+color+">"+item[2]+"</td>";
            fila +="<td class="+color+">"+item[3]+"</td>";
            fila +="<td class="+color+">"+item[4]+"</td>";
            fila += "</tr>";
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
        fila +="<td  style=display:"+td[i][1]+">"+td[i][0]+"</td>";
    }
    fila += "</tr>";
    var btn = document.createElement("TR");
    btn.innerHTML=fila;
    document.getElementById(idtbttabla).appendChild(btn);
}