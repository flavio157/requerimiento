var sugerencias = [];
$( function() {
    personal();
    $("#txtpersonalmolde").autocomplete({
      source: sugerencias,
        select: function (event, ui) {
          console.log(ui);
          $("#txtcodpermolde").val(ui.item.code);
        }
    });

    $("#addpersonal").click(function (params) {
        b1 = "<a id='btneliminar' class='btn btn-danger  btn-sm'>"+
                    "<i class='icon-trash'></i></a>";
        array = [
            a = [$("#txtcodpermolde").val(),'none'],
            b = [$("#txtpersonalmolde").val().toUpperCase(),''],
            c = [b1,''],
        ];
        _createtable(array,'tbdpersonalmolde');
    });
});


  function personal() {
    $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  '../materiales/c_moldes.php',
        data:{
            "accion" : 'personal',
        } ,
        success:  function(response){
            obj = JSON.parse(response);
            $.each(obj['dato'], function(i, item) {
              sugerencias.push(item); 
            });
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