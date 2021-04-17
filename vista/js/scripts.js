var valorproducto;
$(document).ready(function(){
   

    $("#agregar").click(function() {
       var producto =  $("#Nombreproducto").val();
       var cantidad =  $("#cantidad").val();
       var promocion =  $("#promocion").val();
       var precio =  $("#precioproducto").val();
       var total =  $("#total").val();

        mostrarProducto(producto,cantidad,promocion,precio,total);
    });

    $("#DescrPedido").click(function(){
        $("#tablaproductos").show("slow");
    });

    $("#cod_producto").keypress(function(e) {  
        if(e.which == 13) {
            e.preventDefault();
            buscarProducto();
          }
    });

    $("#cantidad").keypress(function(e){
        var cantidad = $("#cantidad").val();
        if(e.which == 13) {
            e.preventDefault();
            calcularTotal(cantidad);
          }
    });

    $("#cantidad").keydown(function(e){
        if(e.which == 8) {
           eliminarTotal("cantidad");
          }
    });

    $("#cod_producto").keydown(function(e){
        if(e.which == 8) {
           eliminarTotal("codigoProducto");
          }
    });

    $("#tablaproductos").hide();

});


function mostrarProducto(producto,cantidad,promocion,precio,total){
    $.ajax({
            dataType:'text',
            type: 'POST', 
            url:  'http://localhost:8080/requerimiento/controlador/C_BuscarProducto.php',
            data:{
                "accion" : "obtener",
                "producto" : producto, 
                "cantidad" : cantidad, 
                "promocion" : promocion, 
                "precio" : precio, 
                "total" : total
            } ,  
            beforeSend: function () {
                $("#tabla").html("Procesando, espere por favor...");
            }, 
            success: function(response){
                $("#tabla").html(response.replace(/[ '"]+/g, ' '));
            }
    });
}



function buscarProducto() { 
        var codigo = $('#cod_producto').val();
        $.ajax({
            dataType:'text',
            type: 'POST', 
            url:  'http://localhost:8080/requerimiento/controlador/C_BuscarProducto.php',
            data: 
            {
                "Codproducto" : codigo ,
                "accion" : 'buscar' , 
             },
            success: function(response){
                console.log(response);
                var producto = response.split("/");
                if(producto[0]==="ok"){
                    valorproducto = producto[2].replace(/[ '"]+/g, ' ');
                    $('#Nombreproducto').val(producto[1].replace(/[ '"]+/g, ' '));
                    $('#precioproducto').val(producto[2].replace(/[ '"]+/g, ' '));
                }
            }
        });
}



function calcularTotal(cantidad){
    var total = Number(cantidad) * Number(valorproducto);
    $("#total").val(total.toFixed(3)); 
}

function eliminarTotal(valor){
    if(valor === "codigoProducto"){
        $("#Nombreproducto").val("");
        $("#precioproducto").val("");
        $("#cantidad").val("")
        $("#total").val("");

    }else if(valor === "cantidad"){
        $("#total").val("");
    }
}





