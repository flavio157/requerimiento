function buscarProducto(nombreproducto,zona) {
    if(nombreproducto.substring(2,0) === "CM"){
        $.ajax({
            dataType:'text',
            type: 'POST', 
            url:  '../controlador/C_BuscarProducto.php',
            data:{
                "accion" : "buscar",
                "producto" : nombreproducto,
                "zona" : zona
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
                "zona" : zona
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
                        /*valorproducto = array[1];*/           /*descometar para mostrar el precio aotumaticamente */
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
    var estado = 1;
     if(cantidad !== ''){
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
                
                  
                arraycodigos.push(combo); 
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
    
    if(nombre !== '' & cantidad !== '' && promocion !== '' && cod_producto !== '' ){
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
    var zona = $("#vrzona").val();
    if(cantidad != 0){
        $.ajax({
            dataType:'text',
                type: 'POST', 
                url:  '../controlador/C_BuscarProducto.php',
                data:{
                    "accion" : "politicaprecios",
                    "cantidad" : cantidad,
                    "codproducto" : codproducto,
                    "zona" : zona,
                } , 
                success: function(response){ 
                    if(response != ''){
                        var obj = JSON.parse(response);
                        if(obj["estado"] === "ok"){
                            precioproducto = obj['precio'];  
                            $("#precioproducto").val(precioproducto);
                            valorproducto = precioproducto;
                        }
                    }
                }
        });
    }else{
        mensajesError("Ingrese una cantidad validad","mensaje");
    }
}


function politicabonos(cantidad,codproducto) { 
    var zona = $("#vrzona").val();
    if(cantidad != 0){
        $.ajax({
            dataType:'text',
                type: 'POST', 
                url:  '../controlador/C_BuscarProducto.php',
                data:{
                    "accion" : "politicabonos",
                    "cantidad" : cantidad,
                    "codproducto" : codproducto,
                    "zona" : zona,
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


function obtenerDistrito(provincia){
    var accion = "distrito";        

    $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  '../controlador/C_ListarCiudades.php',
        data: {
           "accion" : accion ,
           "provincia" : provincia,
        },
        success: function(response){
            $('#Selectdistro').append(response);
           
        }
    });
}



function obtenerprovincia(){
    var oficina = $("#vroficina").val();
    var accion = "provincia";
    $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  '../controlador/C_ListarCiudades.php',
        data: {
            "accion": accion,
             "oficina" :  oficina  
        },
        success: function(response){
            $('#Selectprovincia').append(response);
        }
    });
}



function validacionFrm() {
    telefono = document.getElementById("txttelefono").value
    telefono2 = document.getElementById("txtTelefono2").value
    tlfvalidacion = validarTelefono(telefono);
    tlf2validacion = validarTelefono(telefono2);
    exprecion = new RegExp(/([0-9])\1{6,}/);
   
    if($("#txtnumero").val().length == 0){
        mensajesError("Ingrese el DNI del cliente","mensajesgenerales");
        $('#txtnumero').focus();

    }else if($("#slcdocumento").val() == "DNI" && $("#txtnumero").val().length < 8){
        mensajesError("El DNI no puede ser menor a 8 digitos","mensajesgenerales");
        $('#txtnumero').focus();

    }else if($("#slcdocumento").val() == "RUC" && $("#txtnumero").val().length < 11){
        mensajesError("El RUC no puede ser menor a 11 digitos","mensajesgenerales");
        $('#txtnumero').focus();

    }else if($("#txtcliente").val().length == 0){
        mensajesError("Ingrese nombre del Cliente","mensajesgenerales");
        $('#txtcliente').focus();

    }else if($("#Selectprovincia").val() === "s"){
        mensajesError("Seleccione una Ciudad","mensajesgenerales");

    }else if($("#txtdireccion").val().length == 0){
        mensajesError("Ingrese una Dirección","mensajesgenerales");
        $('#txtdireccion').focus();

    }else if($("#txtreferencia").val().length == 0){
        mensajesError("Ingrese una Referencia","mensajesgenerales");
        $('#txtreferencia').focus();

    }else if($("#txtcontacto").val().length == 0){
        mensajesError("Ingrese un contacto","mensajesgenerales");
        $('#txtcontacto').focus();

    }else if(telefono.length < 9){
        mensajesError("El telefono no puede menor de 9 digitos","mensajesgenerales");
        $('#txttelefono').focus();

    }else if(exprecion.test(telefono) || tlfvalidacion){
        mensajesError("ingrese un numero telefonico valido","mensajesgenerales");
        $('#txttelefono').focus();

    }else if(telefono2.length != 0 && exprecion.test(telefono2) || tlf2validacion) {
        mensajesError("ingrese un numero telefonico valido","mensajesgenerales");
        $('#txtTelefono2').focus();

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

        if( verificar[2] === undefined && verificar.length < 2 || verificar[2].length === 0 ) {
            mensajesError("se necesita un nombre y los dos apellidos","mensajesgenerales");
          $('#txtcliente').focus();

        }else if ($("#txtdireccion").val().length > 0){
                verificar = $("#txtdireccion").val().split(" ");
                if( verificar[1] === undefined || verificar[1].length === 0 ) {
                   mensajesError("se necesitan mas datos en la dirección","mensajesgenerales");
                   $('#txtdireccion').focus();
                }else{
          /*  console.log("se registro ");*/
            guardarPedido();
            }
            
        }
    }
}



function guardarPedido() {
        var codpersonal =$("#vrcodpersonal").val();
        var oficina = $("#vroficina").val();
        var datosproductos ={arrayproductos}
        var data = $("#frmpedidos");
          $.ajax({
            dataType:'text',
            type: 'POST', 
            url:  '../controlador/C_Pedido.php',
            data:data.serialize()+"&accion=guardar&array="+JSON.stringify(datosproductos)+
                "&codPersonal="+codpersonal+"&oficina="+oficina, 
            success: function(response){
              
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



function validarTelefono(telefono) {
    var numeros = ['012345678','123456789','987654321','876543210'];
    for (let i = 0; i < numeros.length; i++) {
        if(telefono == numeros[i]){
            console.log(numeros[i]);
            return true;
        } 
        
    }
}


function mostrarPedido(mostrarpedido,tipo,codpersonal,oficina) {
    var accion = mostrarpedido;
    $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  '../controlador/C_ListarPedidos.php',
        data: {
            "accion":  accion,
            "tipo": tipo,
            "codpersonal" : codpersonal,
            "oficina" : oficina
        },
        success: function(response){
            if(tipo == "c"){
                $('#acordionresponsive').html(response);
            }else{
                $('#tbmostrarpedidos').html(response);
            }
            
        }
    });  

}


