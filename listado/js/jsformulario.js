var idpers = "";
var nompersonal = "";
var codproveedor = "";
var existeproveedor = 1;
var esta1 = 0;
var esta2 = 0;
$(document).ready(function(){
    listado();
});


$(document).on('click','#btlver',function name(e) {

    var total = $(this).parents("tr").find("td > font > font")[0].innerHTML;
    mostrardatos(total);
   
    $("#exampleModal").modal("show");
  
});

function listado() {
    $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  './gasto/lisdato.php',
        data:{
            "accion" : "accion",
        } ,
        success: function name(response) {
            $('#tbmaterial').html(response);
       
        }
    });
}


function mostrardatos(dato) {
    $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  './gasto/lisdato.php',
        data:{
            "accion" : "mostrar",
            "dato" : dato
        } ,
        success: function name(response) {
            console.log(response);
            obj = JSON.parse(response);
            $("#codproducto").val(obj['cod']);
            $("#numlote").val(obj['lote']);
            $("#estado").val(obj['estado']);
            $("#almacen").val(obj['alamcen']);
            
        }
    });
}

