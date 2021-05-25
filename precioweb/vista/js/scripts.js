var valorproducto = "";
var promocionbono = 0;
$(document).ready(function(){

    obtenerprovincia();
    $("#btnModiDescr").hide();
    $("#tablaproductos").hide();
    /*desabilita la tecla enter para evitar que se actualize la pagina */
    $("form").keypress(function(e) {
        if (e.which == 13) {
            return false;
        }
    });

    /*devuelve todos los formularios al estado inicial */
    $("#nuevo").click(function() {
        document.getElementById("frmpedidos").reset();
        document.getElementById("frmagregarProducto").reset();
        document.getElementById("frmactualizarproducto").reset();
        $("#tablaproductos").hide();
        $("#btnModiDescr").hide();
        $("#DescrPedido").show();
    });

    /* obtiene el valor de los input y los agrega a la tabla de pedidos */
    $("#agregar").click(function() {
        var Cod_producto = $("#cod_producto").val(); 
        var producto =  $("#Nombreproducto").val();
        var cantidad =  $("#G_cantidad").val();
        var promocion =  $("#G_promocion").val();
        var precio =  $("#precioproducto").val();
        var total =  $("#G_total").val();

        if(Cod_producto == "" || producto == "" || cantidad == ""|| 
            promocion=="" || precio=="" || total==""){
                $("#mensaje").html('<div class="alert alert-warning alert-dismissible fade show" ' + 
                'role="alert"><strong>Error:'+
                '</strong>Por favor Ingrese todos los datos'+ 
                '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button> </div>')
        }else{
            if(promocionbono === promocion){
                mostrarProducto(Cod_producto,producto,cantidad,promocion,precio,total);
            }else{
                $("#mensaje").html('<div class="alert alert-warning alert-dismissible fade show" ' + 
                'role="alert"><strong>Error:'+
                '</strong> La promocion no corresponde a la cantidad.  '+
                'Por esa cantidad la promoción es  : ' + promocionbono + 
                '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button> </div>')

                /*toastr.warning('la promoción  no corresponde a la cantidad.' +
                'Por esa cantidad la promoción es  : ' + promocionbono);*/
            }
        }
    });

    /* busca el producto al presionar enter*/
    $("#cod_producto").keypress(function(e) {  
        if(e.which == 13) {
            e.preventDefault();
            buscarProducto();
          }
    });

    /*busca el producto cuando se cambia de input*/
    $("#cod_producto").blur(function(){
            buscarProducto();
      });

     /* eliminar los resultados al borrar el codigo de producto*/
    $("#cod_producto").keydown(function(e){
        if(e.which == 8) {
           eliminarTotal("codigoProducto");
          }
    });
    
     /* calcula el total a pagar*/
    $("#G_cantidad").keypress(function(e){
        if(e.which == 13) {
            e.preventDefault();
            calcularTotal($("#G_cantidad").val(),"ingresar");
            var promo = $("#G_cantidad").val();
            if(promo != "" && promo !=0){
                politicaprecios(promo);
            }
          }
    });

    /*calcula el total a pagar cuando se quita el cursor del input */
    $("#G_cantidad").blur(function(){
        calcularTotal($("#G_cantidad").val(),"ingresar");
        var promo = $("#G_cantidad").val();
        if(promo != "" && promo !=0){
            politicaprecios(promo);
        }
      });

    /* elimina el total a pagar al borrar la cantidad que llevara*/
    $("#G_cantidad").keydown(function(e){
        if(e.which == 8) {
           eliminarTotal("cantidad");
          }
    });
   
    $("#Selectprovincia").change(function(){
            $('#Selectdistro').find('option').remove().end();
            var id = $('#Selectprovincia').val();
            obtenerDistrito(id);
    });

    /*llama a los datos de la tabla para modificar producto */
    $("#btnModiDescr").click(function() {
        $("#ModalProductoModificar").modal("show");
        ModificarProductos();
    });

    /* calcula el total a pagar si modifico el pedido*/
    $("#M_cantidad").keypress(function(e){
        if(e.which == 13) {
            e.preventDefault();
            calcularTotal($("#M_cantidad").val(),"modificar");
            var promo = $("#M_cantidad").val();
            if(promo != "" && promo !=0){
                politicaprecios(promo);
            }
          }
    });

    /* calcula el total a pagar al quitar el focus del input si modifico el pedido */
    $("#M_cantidad").blur(function(){
        calcularTotal($("#M_cantidad").val(),"modificar");
            var promo = $("#M_cantidad").val();
            if(promo != "" && promo !=0){
                politicaprecios(promo);
            }
    });

     /* elimina el total a pagar si modifica la cantidad que llevara*/
    $("#M_cantidad").keydown(function(e){
        if(e.which == 8) {
            $("#M_total").val("");
            $("#M_promocion").val('');
          }
    });

    /* eliminar los resultados al borrar el codigo de producto si modifica*/
    $("#M_cod_producto").keydown(function(e){
        if(e.which == 8) {
           eliminarTotal("modificarProducto");
          }
    });
    
    /* busca el producto al quitar el cursor del input*/
    $("#M_cod_producto").blur(function(){
        buscarProductoModificar();
      });

    /* busca el producto al presionar enter si desea modificar el pedido*/
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

        if(Cod_producto == "" || producto == "" || cantidad == "" || 
           promocion == "" || precio == "" || total== ""){
            $("#mensaje2").html('<div class="alert alert-warning alert-dismissible fade show" ' + 
            'role="alert"><strong>Error:'+
            '</strong>Por favor Ingrese todos los datos'+ 
            '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button> </div>')
        }else{
            if(promocionbono === promocion){
                ModificarProducto(Cod_producto,producto,cantidad,promocion,precio,total);
                $("#ModalProductoModificar").modal("hide");
            }else{
                $("#mensaje2").html('<div class="alert alert-warning alert-dismissible fade show" ' + 
                'role="alert"><strong>Error:'+
                '</strong> La promocion no corresponde a la cantidad.  '+
                'Por esa cantidad la promoción es  : ' + promocionbono + 
                '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button> </div>')
    
               /* toastr.warning('la promoción  no corresponde a la cantidad.' +
                'Por esa cantidad la promoción es  : ' + promocionbono);*/
            }
        }
       
    });

    /* guardar el pedido*/
    $("#grabar").click(function() {
        var slcdocumento = $("#slcdocumento").val();
        var numerodoc = $("#txtnumero").val();
        var nombrecli = $("#txtcliente").val();
        var slcciudad = $("#slcciudad").val();
        var slcdistrito = $("#slcdistrito").val();
        var direccion = $("#txtdireccion").val();
        var referencia = $("#txtreferencia").val();
        var contacto = $("txtcontacto").val();
        var telefono = $("txttelefono").val();
        var condicion = $("slccondicion").val();
        var entrega = $("#slcentrega").val();
        var fechapago = $("#dtfechapago").val();
        var contrato = $("#txtcontrato").val();
        var telefono = $("#txtTelefono2").val();
        var codigo = $("txtcodigo").val();
        var generado = $("txtgenereado").val();

        if(slcdocumento == ""){

        }

        guardarPedido();
    });



});

/* para mostrar el bono dependiendo la cantidad que desea llevar*/
function politicaprecios(cantidad) {
    $.ajax({
        dataType:'text',
            type: 'POST', 
            url:  '../controlador/C_BuscarProducto.php',
            data:{
                "accion" : "politicaprecios",
                "cantidad" : cantidad,
            } , 
            success: function(response){
                var obj = JSON.parse(response);
             
                if(obj["estado"] === "ok"){
                    promocionbono = obj['bono'];
                   
                    /*$("#G_promocion").val(obj['bono']);*/
                }else{
                    $("#mensaje").html(response);
                }
            }

    });
}


/*para mostrar el producto cuando ingresa por primera vez*/
function mostrarProducto(Cod_producto,producto,cantidad,promocion,precio,total){
    $.ajax({
            dataType:'text',
            type: 'POST', 
            url:  '../controlador/C_BuscarProducto.php',
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
                /*se muestra la tabla del Producto */
                $("#tablaproductos").show("slow");
                $("#tabla").html(response.replace(/[ '"]+/g, ' '));
                
                /*esconde el modal y muestra boton Modifica
                $("#ModalProducto").modal("hide");
                $("#DescrPedido").hide();
                $("#btnModiDescr").show();*/
            }
    });
}


/*para buscar el producto cuando ingresa por primera vez*/
function buscarProducto() { 
        var codigo = $('#cod_producto').val();
        $.ajax({
            dataType:'text',
            type: 'POST', 
            url:  '../controlador/C_BuscarProducto.php',
            data: 
            {
                "Codproducto" : codigo ,
                "accion" : 'buscar' , 
             },
            success: function(response){
                var obj = JSON.parse(response);

                if(obj["estado"] === "ok"){
                    $('#Nombreproducto').val(obj["descripcion"]);
                    $('#precioproducto').val(obj["precio"]);
                    valorproducto = obj["precio"];
    
                }else{
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
            url:  '../controlador/C_BuscarProducto.php',
            data: 
            {
                "Codproducto" : codigo.replace(/ /g, "") ,
                "accion" : 'buscar' , 
             },
            success: function(response){
                var obj = JSON.parse(response);
                
                if(obj["estado"]=== "ok"){
                    valorproducto = obj["precio"];
                    $('#M_Nombreproducto').val(obj["descripcion"]);
                    $('#M_precioproducto').val(obj["precio"]);
                }else{
                    $("#mensaje").html(response);
                    $("#mensaje2").html(response);
                }
            }
        });
}

/*para actualizar el pedido que ingreso*/
function ModificarProducto(Cod_producto ,producto,cantidad,promocion,precio,total){
    $.ajax({
            dataType:'text',
            type: 'POST', 
            url:  '../controlador/C_BuscarProducto.php',
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


function obtenerDistrito(id){
    var tipo = "distrito";        

    $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  '../controlador/C_ListarCiudades.php',
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
        url:  '../controlador/C_ListarCiudades.php',
        data: "accion=" + accion,
        success: function(response){
           $('#Selectprovincia').append(response);
        }
    });
}

function calcularTotal(cantidad,accion){
    if(accion === "ingresar"){
        if(valorproducto !== "" && cantidad !== ""){
            var total = Number(cantidad) * Number(valorproducto);
            $("#G_total").val(total.toFixed(3)); 
        }
    }else if(accion === "modificar"){
        if(valorproducto != "" && cantidad != ""){
            var total = Number(cantidad) * Number(valorproducto);
            $("#M_total").val(total.toFixed(3)); 
        }
        
    }
}

function eliminarTotal(valor){
    if(valor === "codigoProducto"){
        $("#Nombreproducto").val('');
        $("#precioproducto").val('');
        $("#G_promocion").val('');
        $("#G_cantidad").val('')
        $("#G_total").val('');
    }else if(valor === "cantidad"){
        $("#G_total").val('');
        $("#G_promocion").val('');
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
  

    $("#M_cod_producto").val(cod_producto.trim());
    $("#M_Nombreproducto").val(producto);
    $("#M_precioproducto").val(Number(precio).toFixed(3));
    
   
}


function guardarPedido() {

    var data = $("#frmpedidos");
    var cod_producto =  $("#tabladelProducto").find("td:eq(0)").text();
    var cantidad = $("#tabladelProducto").find("td:eq(2)").text();
    var promocion = $("#tabladelProducto").find("td:eq(4)").text();
    var total = $("#tabladelProducto").find("td:eq(5)").text();
  
    $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  '../controlador/C_Pedido.php',
        data:data.serialize()+"&accion=guardar&cod_producto="+cod_producto+
        "&cantidad="+cantidad+"&promocion="+promocion+"&total="+total,  
        success: function(response){
            console.log(response);
             toastr.success('Se Registro Correctamente el Pedido');

             $("#DescrPedido").show();
             $("#btnModiDescr").hide();
             document.getElementById("frmpedidos").reset();
             document.getElementById("frmagregarProducto").reset();
             document.getElementById("frmactualizarproducto").reset();
             $("#tablaproductos").hide();
             
        }
}); 
}


