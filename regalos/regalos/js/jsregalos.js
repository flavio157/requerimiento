var sugematerial = [];
b1 = "<a id='btneliminar' class='btn btn-danger  btn-sm' style='margin-bottom: 1px'>"+
"<i class='icon-trash'></i></a>"
$(document).ready(function(){
    autocompletarproducto();
    $(document).on('click','#btneliminar',function() { //para eliminar una fila
        $(this).closest('tr').remove();
    });


    $("#btnguardar").on('click',function() {
        var td =  $("#tbdregalo  tr");
        var tds = [];
        for (let l = 0; l < td.length; l++) {
                tds[l] =[
                    $(td[l]).find("td")[0].innerHTML,
                    $(td[l]).find("td")[2].innerHTML,
                    $(td[l]).find("td")[3].innerHTML,
                    l,
                    $(td[l]).find("td")[1].innerHTML,
                    /*$(td[l]).find("td")[4].innerHTML*/
                ]
        }
        console.log(tds);
        enviardatos(tds);
    })

})


function buscarproducto() {   //devuelve los productos en un array
    var zona = $('#vrzona').val();
    sugematerial = [];
    $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  'c_regalos.php',
        data:{
            "accion" : 'filtrar',
            "zona" : zona,
        } ,
        success:  function(response){
            obj = JSON.parse(response);
            $.each(obj['dato'], function(i, item) {
                sugematerial.push(item); 
            });
        }
    });   
}

function autocompletarproducto() {   //funcion para buscar el producto al escribir nombre
    buscarproducto();
    $("#txtproducto").autocomplete({
        source: sugematerial,
          select: function (event, ui) {
            agregartabla(ui.item.code,ui.item.label,ui.item.precio,ui.item.gramaje)
            $(this).val('');
            return false
          }
    });
}

function agregartabla(codigo,producto,precio,gramaje){     //crea la tabla un avez al hacero click en el producto
    var fila="<tr><td style='display: none;'>"+codigo+"</td>"+
        "<td>"+producto+"</td>"+
        "<td >"+precio+"</td>"+
        "<td style='display: none;'>"+gramaje+"</td>"+
        "<td style='padding: .25rem 1.5rem;'>"+b1+"</td></tr>";
        var elem = document.createElement("TR");
        elem.innerHTML=fila;
        document.getElementById("tbdregalo").appendChild(elem);
}

function enviardatos(tds) { /*envia los datos para evaluacion en php*/
    var productos = {tds};
    $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  'c_regalos.php',
        data:{
            "accion" : 'evaluar',
            "producto" : JSON.stringify(productos)
        } ,
        success:  function(response){
           console.log(response);
        }
    });  
}