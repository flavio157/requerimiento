var valorproducto;
$(document).ready(function(){
   /* obtenerprovincia();*/
    $("#btnModiDescr").hide();
    $("#tablaproductos").hide();

    /* obtiene el valor de los input y los agrega a la tabla de pedidos */
    $("#agregar").click(function() { 
        var Cod_producto = $("#cod_producto").val(); 
        var producto =  $("#Nombreproducto").val();
        var cantidad =  $("#cantidad").val();
        var promocion =  $("#promocion").val();
        var precio =  $("#precioproducto").val();
        var total =  $("#total").val();
        mostrarProducto(Cod_producto,producto,cantidad,promocion,precio,total);
        /*se muestra la tabla del Producto */
        $("#tablaproductos").show("slow");
        /* */
      
        /*esconde el modal y muestra boton Modifica*/
        $("#ModalProducto").modal("hide");
        $("#DescrPedido").hide();
        $("#ModalProducto").hide();
        $("#btnModiDescr").show();
        /* */
    });

    /* busca el producto al presionar enter*/
    $("#cod_producto").keypress(function(e) {  
        if(e.which == 13) {
            e.preventDefault();
            buscarProducto();
          }
    });
    
     /* eliminar los resultados al borrar el codigo de producto*/
    $("#cod_producto").keydown(function(e){
        if(e.which == 8) {
           eliminarTotal("codigoProducto");
          }
    });
    
     /* calcula el total a pagar*/
    $("#cantidad").keypress(function(e){
        if(e.which == 13) {
            e.preventDefault();
            calcularTotal($("#cantidad").val(),"ingresar");
          }
    });

    /* elimina el total a pagar al borrar la cantidad que llevara*/
    $("#cantidad").keydown(function(e){
        if(e.which == 8) {
           eliminarTotal("cantidad");
          }
    });
   
    $("#Selectprovincia").change(function(){
            $('#Selectdistro').find('option').remove().end();
            var id = $('#Selectprovincia').val();
        obtenerDistrito(id);
    });
    
    $("#btnModiDescr").click(function() {/*llama a los datos de la tabla para modificar producto */
        $("#ModalProductoModificar").modal("show");
        ModificarProductos();
    });

    /* calcula el total a pagar si modifico el pedido*/
    $("#M_cantidad").keypress(function(e){
        if(e.which == 13) {
            e.preventDefault();
            calcularTotal($("#M_cantidad").val(),"modificar");
          }
    });

     /* elimina el total a pagar si modifica la cantidad que llevara*/
    $("#M_cantidad").keydown(function(e){
        if(e.which == 8) {
            $("#M_total").val("");
          }
    });

    /* busca el producto al presionar enter si desea modificar el pedido*/
    $("#M_cod_producto").keydown(function(e){
        if(e.which == 8) {
           eliminarTotal("modificarProducto");
          }
    });

     /* eliminar los resultados al borrar el codigo de producto si modifica*/
    $("#M_cod_producto").keypress(function(e) {  
        if(e.which == 13) {
            e.preventDefault();
            buscarProductoModificar();
          }
    });

    /* obtiene el valor de los input y los agrega a la tabla de pedidos si modifica */
    $("#M_agregar").click(function(e) {
        var Cod_producto = $("#M_cod_producto").val(); 
        var producto =  $("#M_Nombreproducto").val();
        var cantidad =  $("#M_cantidad").val();
        var promocion =  $("#M_promocion").val();
        var precio =  $("#M_precioproducto").val();
        var total =  $("#M_total").val();
        ModificarProducto(Cod_producto,producto,cantidad,promocion,precio,total);
        $("#ModalProductoModificar").modal("hide");
    });
});

/*para mostrar el producto cuando ingresa por primera vez*/
function mostrarProducto(Cod_producto ,producto,cantidad,promocion,precio,total){
    $.ajax({
            dataType:'text',
            type: 'POST', 
            url:  'http://localhost:8080/requerimiento/controlador/C_BuscarProducto.php',
            data:{
                "accion" : "obtener",
                "Cod_producto" : Cod_producto,
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


/*para buscar el producto cuando ingresa por primera vez*/
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
                var producto = response.split("/");
                if(producto[0]==="ok"){
                    valorproducto = producto[2].replace(/[ '"]+/g, ' ');
                    $('#Nombreproducto').val(producto[1].replace(/[ '"]+/g, ' '));
                    $('#precioproducto').val(producto[2].replace(/[ '"]+/g, ' '));
                }else{
                    console.log(response);
                    $("#mensaje").html(response);
                }
            }
        });
}

/*para buscar el producto cuando modifica el pedido */
function buscarProductoModificar() {
    var codigo = $('#M_cod_producto').val();
        $.ajax({
            dataType:'text',
            type: 'POST', 
            url:  'http://localhost:8080/requerimiento/controlador/C_BuscarProducto.php',
            data: 
            {
                "Codproducto" : codigo.replace(/ /g, "") ,
                "accion" : 'buscar' , 
             },
            success: function(response){
                var producto = response.split("/");
                if(producto[0]==="ok"){
                    valorproducto = producto[2].replace(/[ '"]+/g, ' ');
                    $('#M_Nombreproducto').val(producto[1].replace(/[ '"]+/g, ' '));
                    $('#M_precioproducto').val(producto[2].replace(/[ '"]+/g, ' '));
                }else{
                    $("#mensaje").html(response);
                }
            }
        });
}

/*para actualizar el pedido que ingreso*/
function ModificarProducto(Cod_producto ,producto,cantidad,promocion,precio,total){
    $.ajax({
            dataType:'text',
            type: 'POST', 
            url:  'http://localhost:8080/requerimiento/controlador/C_BuscarProducto.php',
            data:{
                "accion" : "obtener",
                "Cod_producto" : Cod_producto,
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

/*
function obtenerDistrito(id){
    var tipo = "distrito";        

    $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  'http://localhost:8080/requerimiento/controlador/C_ListarCiudades.php',
        data: {
           "accion" : tipo ,
           "id" : id , 
        },
        success: function(response){
            $('#Selectdistro').append(response);
        }
    });
}


function obtenerprovincia(){
    var accion = "provincia";
    $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  'http://localhost:8080/requerimiento/controlador/C_ListarCiudades.php',
        data: "accion=" + accion,
        success: function(response){
           $('#Selectprovincia').append(response);
        }
    });
}*/

function calcularTotal(cantidad,accion){
    if(accion==="ingresar"){
        var total = Number(cantidad) * Number(valorproducto);
        $("#total").val(total.toFixed(3)); 
    }else if(accion === "modificar"){
        var total = Number(cantidad) * Number(valorproducto);
        $("#M_total").val(total.toFixed(3)); 
    }
}

function eliminarTotal(valor){
    if(valor === "codigoProducto"){
        $("#Nombreproducto").val('');
        $("#precioproducto").val('');
        $("#promocion").val('');
        $("#cantidad").val('')
        $("#total").val('');
    }else if(valor === "cantidad"){
        $("#total").val('');
    }else if(valor === "modificarProducto"){
        $("#M_Nombreproducto").val('');
        $("#M_precioproducto").val('');
        $("#M_promocion").val('');
        $("#M_cantidad").val('')
        $("#M_total").val('');
    }
}


function ModificarProductos() {
    
    var cod_producto =  $("#tabladelProducto").find("td:eq(0)").text()
    var producto = $("#tabladelProducto").find("td:eq(1)").text();
    var cantidad = $("#tabladelProducto").find("td:eq(2)").text();
    var precio = $("#tabladelProducto").find("td:eq(3)").text();
    var promocion = $("#tabladelProducto").find("td:eq(4)").text();
    var total = $("#tabladelProducto").find("td:eq(5)").text();

    $("#M_cod_producto").val(cod_producto);
    $("#M_Nombreproducto").val(producto);
    $("#M_precioproducto").val(Number(precio).toFixed(3));
    $("#M_promocion").val(Number(promocion));
   
}











