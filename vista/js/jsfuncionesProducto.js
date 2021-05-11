function buscarProducto(nombreproducto) {
    if(nombreproducto.substring(2,0) === "CM"){
        $.ajax({
            dataType:'text',
            type: 'POST', 
            url:  '../controlador/C_BuscarProducto.php',
            data:{
                "accion" : "buscar",
                "producto" : nombreproducto,
            } ,
            success:  function(response){
               if(response != ""){
                    var obj = JSON.parse(response);
                     if(obj['combo'] !== ""){
                        $("#sugerencias").height(300);
                        $("#sugerencias").css('overflow','scroll');
                    }else{
                        $("#sugerencias").height(0);
                    }
                }

                $('#sugerencias').fadeIn(0).html(obj['combo']);
                $('.suggest-element').on('click', function(){
                    var id =  $(this).attr('id');
                    var precio =$(this).attr('data-')
                    $("#nombreproducto").val(id);
                    $("#precioproducto").val(precio)
                    valorproducto = precio;
                    $('#sugerencias').fadeOut(0); 
                    $("#G_promocion").attr('disabled','true');
                    var l = id.split("-");
                        BuscarBonoItem(l[0]);
                });
            }
        });

    }else if(nombreproducto != ""){
        $.ajax({
            dataType:'text',
            type: 'POST', 
            url:  '../controlador/C_BuscarProducto.php',
            data:{
                "accion" : "buscar",
                "producto" : nombreproducto,
            } ,
            success: function name(response) {
                if(response != ""){
                    var obj = JSON.parse(response);
                     if(obj['producto'] !== "" ){
                        $("#sugerencias").height(300);
                        $("#sugerencias").css('overflow','scroll');
                    }else{
                        $("#sugerencias").height(0);
                    }
                }
                    $('#sugerencias').fadeIn(0).html(obj['producto']);
                    $('.suggest-element').on('click', function(){
                        var id =  $(this).attr('id');
                        var datos = $('#'+id).attr('data-');
                        array = datos.split("&");
                        $('#nombreproducto').val(array[0]);
                        $("#precioproducto").val(array[1]);
                        $('#sugerencias').fadeOut(0); 
                        $("#cod_producto").val(id);
                        $("#G_promocion").removeAttr('disabled');
                    });
            }
        });
    }

}



function BuscarBonoItem(cod_bono) {
    $.ajax({
        dataType:'text',
            type: 'POST', 
            url:  '../controlador/C_BuscarProducto.php',
            data:{
                "accion" : "bonoitem",
                "codbono" : cod_bono,
            } , 
            success: function(response){ 
              $("#cod_producto").val(response);
            }
    });
}

function ProductosCombo(idcombo) {
    $.ajax({
        dataType:'text',
            type: 'POST', 
            url:  '../controlador/C_BuscarProducto.php',
            data:{
                "accion" : "productobono",
                "codbono" : idcombo,
            } , 
            success: function(response){
                var obj = JSON.parse(response);
               agregarcombos(obj['datos']);
            }   
    });
}

function agregarcombos(dato) {
    var cantidad = $("#G_cantidad").val();
    var nombreproducto = $("#nombreproducto").val().split(' ');
    var promocion = 0;
    var total = 0;
    var combo = "";
     if(cantidad !== ''){
        var estado = 1;
        if (contador >= 0) {
            for (let j = 0; j < arrayproductos.length; j++) {
                if (arrayproductos[j] != undefined) {
                    if (arrayproductos[j]['combo'] === nombreproducto[0]) {
                        mensajesError("Ya existe el Combo en la tabla","mensaje");
                        return estado = 0;
                        break;
                    }else{
                        estado = 1
                    }  
                }
            }
            if (estado === 1) {
                $.each(dato, function(i, item) {
                    combo = dato[i].combo
                    var cod_producto =dato[i].cod_producto;
                    var nombre = dato[i].nombre;
                    var precio =  dato[i].precio;
                    arrayproductos[contador] = {
                        combo,cod_producto,nombre,cantidad,promocion,precio,total
                    };

                    var fila="<tr><td style='display: none;'>"+combo+
                    "</td><td>"+nombre+ "</td><td>"+cantidad+
                    "</td><td>"+precio+"</td><td>"+promocion+"</td><td style='display: none;'>"+
                    total +"</td>"
                    +"<td><button type='button' id='btneliminar' class='btn btn-primary btn-sm'>-</button></td></tr>";
                    var btn = document.createElement("TR");
                    btn.setAttribute('id', combo);
                    btn.innerHTML=fila;
                    document.getElementById("tablaModal").appendChild(btn);
                    contador++;
                    
                 });
                
                  
                arraycodigos.push(cod_producto); 
                arraytemporal.push(combo);
                document.getElementById("frmagregarProducto").reset();
              
            }
        }
}else{
    mensajesError("Ingrese los datos correctamente","mensaje");
}




}

function agregarproductos() {
    var cod_producto =$("#cod_producto").val();
    var nombre = $("#nombreproducto").val();
    var cantidad = $("#G_cantidad").val();
    var promocion = $("#G_promocion").val();
    var precio =$("#precioproducto").val();
    var total = $("#G_total").val();
    
    if(nombre !== '' & cantidad !== '' && promocion !== ''){
                var estado = 1;
                if (contador >= 0) {
                    for (let j = 0; j < arrayproductos.length; j++) {
                        if (arrayproductos[j] != undefined) {
                            if (arrayproductos[j]['cod_producto'] === cod_producto) {
                                mensajesError("Ya existe el Producto en la tabla","mensaje");
                                return estado = 0;
                                break;
                            }else{
                                estado = 1
                            }  
                        }
                    }
                    if (estado === 1) {
                        arrayproductos[contador] = {cod_producto,nombre,cantidad,promocion,precio,total};
                        var fila="<tr><td style='display: none;'>"+cod_producto+
                            "</td><td>"+nombre+ "</td><td>"+cantidad+
                            "</td><td>"+precio+"</td><td>"+promocion+"</td><td style='display: none;'>"+
                            total +"</td>"
                            +"<td><button type='button' id='btneliminar' class='btn btn-primary btn-sm'>-</button></td></tr>";
                            var btn = document.createElement("TR");
                            btn.innerHTML=fila;
                            document.getElementById("tablaModal").appendChild(btn);
                            contador++;
                        arraycodigos.push(cod_producto); 
                        arraytemporal.push(cod_producto);
                        document.getElementById("frmagregarProducto").reset();
                    }
                }
        }else{
            mensajesError("Ingrese los datos correctamente","mensaje");
        }
       
}

function calcularTotal(cantidad,accion){
    if(accion === "ingresar" && valorproducto !== "" && cantidad !== "" && cantidad != 0 ){
        var total = Number(cantidad) * Number(valorproducto);
        $("#G_total").val(total.toFixed(2)); 
    }
}


function politicaprecios(cantidad,codproducto) {
    if(cantidad != 0){
        $.ajax({
            dataType:'text',
                type: 'POST', 
                url:  '../controlador/C_BuscarProducto.php',
                data:{
                    "accion" : "politicaprecios",
                    "cantidad" : cantidad,
                    "codproducto" : codproducto,
                } , 
                success: function(response){ 
                    var obj = JSON.parse(response);
                    if(obj["estado"] === "ok"){
                        precioproducto = obj['precio'];  
                        $("#precioproducto").val(precioproducto);
                        valorproducto = precioproducto;
                    }
                }
        });
    }else{
        mensajesError("Ingrese una cantidad validad","mensaje");
    }
}


function politicabonos(cantidad,codproducto) { 
    if(cantidad != 0){
        $.ajax({
            dataType:'text',
                type: 'POST', 
                url:  '../controlador/C_BuscarProducto.php',
                data:{
                    "accion" : "politicabonos",
                    "cantidad" : cantidad,
                    "codproducto" : codproducto,
                } , 
                success: function(response){ 
                    var obj = JSON.parse(response);
                    if(obj["estado"] === "ok"){
                        bono = obj['bono'];  
                        $("#G_promocion").val(bono);
                    }
                }
        });
    }else{
        mensajesError("Ingrese una cantidad validad","mensaje");
    }
}



function mensajesError(texto,id) {
   mensaje = '<div class="alert alert-warning alert-dismissible fade show" role="alert" id="">'+
   '<strong>Advertencia: </strong>'+texto+
   '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>'+
   '</div>';
    $('#'+id).html(mensaje);
    window.scrollTo(0, 0);
}

function mensajeSuccess(texto,id) {
    mensaje = '<div class="alert alert-success alert-dismissible fade show" role="alert" id="">'+
    '<strong></strong>' + texto+
    '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>'+
    '</div>';
     $('#'+id).html(mensaje);
     window.scrollTo(0, 0);
}


function reiniciarFrm() {
    arrayproductos = [];
    arraycodigos = [];
    arraytemporal = [];
    document.getElementById("frmpedidos").reset();
    $('#tablaproductos').find("tr:gt(0)").remove();
    $("#tablaproductos").hide();
}


function obtenerDistrito(provincia,departamento){
    var accion = "distrito";        

    $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  '../controlador/C_ListarCiudades.php',
        data: {
           "accion" : accion ,
           "departamento" : departamento , 
           "provincia" : provincia,
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



function validacionFrm() {
    if($("#txtnumero").val().length == 0){
        mensajesError("Ingrese el DNI del cliente");
        $('#txtcliente').focus();
    }else if($("#txtcliente").val().length == 0){
        mensajesError("Ingrese nombre del Cliente","mensajesgenerales");
        $('#txtcliente').focus();
    }else if ($("#txtdireccion").val().length == 0){
        mensajesError("Ingrese una Direccion","mensajesgenerales");
       
        $('#txtdireccion').focus();
    }else if($("#Selectprovincia").val() === "s"){
        mensajesError("Seleccione una Ciudad","mensajesgenerales");

    }else if($("#txtreferencia").val().length == 0){
        mensajesError("Ingrese una Referencia","mensajesgenerales");
        
        $('#txtreferencia').focus();
    }else if($("#txtcontacto").val().length == 0){
        mensajesError("Ingrese un contacto","mensajesgenerales");
        
        $('#txtcontacto').focus();
    }else if($("#txttelefono").val().length < 9 ){
        mensajesError("El telefono no puede ser mayor o menor de 9 digitos","mensajesgenerales");
        
        $('#txttelefono').focus();
    }else if($("#condicion").val() === "n"){
        console.log($("#condicion").val() );
        mensajesError("Seleccione una condicion","mensajesgenerales");

    }else if($("#turno").val() === "n"){
        mensajesError("Seleccione un Turno","mensajesgenerales");

    }else if(arrayproductos.length == 0){
        mensajesError("No puede guardar sin seleccionar un producto","mensajesgenerales");
       
    }else if (Object.keys(arrayproductos) == "") {
        mensajesError("vuelva a seleccionar un producto","mensajesgenerales");
    }else if($("#txtcliente").val().length > 0){
        verificar = $("#txtcliente").val().split(" ");
        if(verificar.length < 3){
            mensajesError("se necesita un nombre y los dos apellidos","mensajesgenerales");
          $('#txtcliente').focus();

        }else{
            guardarPedido();
        }
    }
    
    
}



function guardarPedido() {
        var datosproductos ={arrayproductos}
        var data = $("#frmpedidos");
          $.ajax({
            dataType:'text',
            type: 'POST', 
            url:  '../controlador/C_Pedido.php',
            data:data.serialize()+"&accion=guardar&array="+JSON.stringify(datosproductos), 
            success: function(response){
                console.log(response);
                var obj = JSON.parse(response);
               
                if(obj["estado"] === "error"){
                    mensajesError(obj['mensaje'],"mensajesgenerales")
                  
                }else{
                    mensajeSuccess(obj['mensaje'],"mensajesgenerales")
                    
                    reiniciarFrm();
                }
            }
        });
       
}

