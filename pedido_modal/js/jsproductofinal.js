var precioproducto = 0;
var arrayproductos = [];
var contador = 0;
var arraycodigos = [];
var arraytemporal = [];
var bono = 0;
var tipodeproducto = "";
var modal_lv = 0;
var temporalPrecios = [];
var cumpliopromo = [];
var gramos;
var dt = 0;
$(document).ready(function(){
    obtenerprovincia();
    generarCodigo();

    $("#closepedido").click(function(){
        $('#tablaproductos').find("tr:gt(0)").remove();
        arrayproductos = [];
        arraycodigos = [];
        arraytemporal = [];
    });

    $('.modal').on('shown.bs.modal', function (e) {
        $('.modal-backdrop:last').css('zIndex',1051+modal_lv);
        $(e.currentTarget).css('zIndex',1052+modal_lv);
        modal_lv++
    });

    $('.modal').on('hidden.bs.modal', function (e) {
        modal_lv--
    });



    $("#dtfechapago").on("keydown",function () {
        return false;
    })

    $("#cerrarmodalProducto").click(function name() {
        eliminarArrayTemporal();
    })

    $('body').on('keydown', function(e){
        if( e.which == 38 ||  e.which == 40) {
        return false;
        }
    });

    $('#ModalProducto').modal({
        backdrop: 'static', keyboard: false
    })

    $('#modalpedido').modal({
        backdrop: 'static', keyboard: false
    })


    $("html").click(function(){
        $('#sugerencias').fadeOut(0); 
    });

    $("#txtcontrato").keyup(function(e) {
        var input=  document.getElementById('txtcontrato');
            input.addEventListener('input',function(){
                this.value = this.value.slice(0,8); 
        })
    })


    $('#txtcontrato').keydown(function(e) {
        if (e.keyCode == 32) {
            return false;
        }
    });


    $("#txtnumero").keyup(function(e) {
        var input=  document.getElementById('txtnumero');
            input.addEventListener('input',function(){
                var dato = $("#slcdocumento").val();
                if(dato === "RUC"){
                    this.value = this.value.slice(0,11); 
                }else if(dato === "DNI"){
                        this.value = this.value.slice(0,8); 
                }else{
                    if(e.which != 8) {
                        this.value = this.value.slice(0,0); 
                        mensajesError("Seleccione tipo de documento","mensajesgenerales");
                    }
                }   
            })
    })

    $("#txttelefono").keyup(function (e) {
        var input=  document.getElementById('txttelefono');
        input.addEventListener('input',function(){
            this.value = this.value.slice(0,9);
        });
        
    })

    $("#txtTelefono2").keyup(function (e) {
        var input=  document.getElementById('txtTelefono2');
        input.addEventListener('input',function(){
            this.value = this.value.slice(0,9);
        });
        
    })

    $("#tablaproductos").hide();

    $('#ModalProducto').on('shown.bs.modal', function (e) {
        $('#nombreproducto').focus();
    })

    $("#agregarProducto").on('click',function(){
        var cod = $("#nombreproducto").val().split("-")
        if(tipodeproducto === "CM"){
            if($("#nombreproducto").val() != ""){
                ProductosCombo(cod[0]);
            }
        }else{
            agregarproductos();
        }
    });

    $("#nombreproducto").on('keyup',function () {
        var zona = $("#vrzona").val();
        var nombreproducto = $("#nombreproducto").val().toUpperCase();
        tipodeproducto = nombreproducto.substring(2,0).toUpperCase();
       
        if(tipodeproducto === "CM"){
            buscarProducto(nombreproducto,zona);
        }else{
            buscarProducto(nombreproducto,zona);
        }
        
     
    });

  


    $("#agregar").on('click',function() {
        dt = arrayproductos.length;
        politicabonos(arrayproductos);
   
    });  

   $("#closemodal").on('click',function(){
        eliminarArrayTemporal();
    });

    $(document).on('click', '#btneliminar',function (e) {
        var cantidad;
        var valores = $(this).parents("tr").find("td")[0].innerHTML;
        for (let i = 0; i < arrayproductos.length; i++) {
            if (arrayproductos[i] != undefined) {
                if(arrayproductos[i]['combo'] != undefined ){
                    if (arrayproductos[i]['combo'] === valores) {
                        for (let l = 0; l < arrayproductos.length; l++) {
                            $("#"+arrayproductos[i]['combo']).remove();   
                           
                        }
                        var index = arraycodigos.indexOf(valores);
                        if ( index !== -1 ) {
                            arraycodigos.splice( index, 1 );
                        }
                        delete(arrayproductos[i]);
                     }
                     
                }else{
                    if (arrayproductos[i]['cod_producto'] === valores) {
                        cantidad = arrayproductos[i]['cantidad'];
                        var index = arraycodigos.indexOf(valores);
                        if ( index !== -1 ) {
                            arraycodigos.splice( index, 1 );
                        }

                        delete(arrayproductos[i]);
                        $(this).closest('tr').remove();
                     }
                }

                
             
            }   
        }
 

        if(cantidad < 6){
            for (let l = 0; l < temporalPrecios.length; l++) {
                if(temporalPrecios[l] != undefined && arrayproductos[l] != undefined){
                    if(arrayproductos[l]['precio'] == "0" && arrayproductos[l]['cantidad'] < 6){
                        arrayproductos[l]['precio'] = temporalPrecios[l]['precio'];
                    }
                }
            }
            cumpliopromo = [];
            verificarRegalo(arrayproductos);
        }
     
        
    }); 

  

   

    $("#G_cantidad").on('keyup',function(e){
        cantidad = $("#G_cantidad").val();
        codproducto = $("#cod_producto").val();
        precio = $("#precioproducto").val();
        
        if(tipodeproducto !== "CM"){
            if(cantidad != "" && cantidad != 0 && cantidad >= 6){ 
                $("#G_promocion").removeAttr('disabled');
                politicaprecios(cantidad,codproducto);
              
            }else if(cantidad != "" && cantidad != 0 && cantidad < 6){
                PrecioWeb(codproducto,cantidad);
                $("#G_promocion").attr('disabled','true');
            }
        }else if(tipodeproducto === "CM"){
             total = precio * cantidad;
             $("#G_total").val(total.toFixed(2));
            
        }

        if(e.which == 8) {
            $("#G_promocion").val('');
            $("#G_total").val('');
         }
    });




    $("#nombreproducto").keydown(function(e){
        if(e.which == 8) {
            $("#cod_producto").val('')
            $("#G_cantidad").val('');
            $("#G_promocion").val('');
            $("#precioproducto").val(''); 
            $("#G_total").val('');
          }
    });


    $("#grabar").on('click',function(e) {
       validacionFrm();
    })

    $("#nuevo").on('click',function() {
        reiniciarFrm();
    });

    $("#Selectprovincia").change(function(){
        $('#Selectdistro').find('option').remove().end();
        var id = $('#Selectprovincia').val();
        obtenerDistrito(id);
    });

    $("#verPedidos").on('click',function(params) {
        /*muestra el modal para vista en celular */
        var codpersonal = $("#vrcodpersonal").val();
        var oficina = $("#vroficina").val();
        $("#ModalMostrarPedidos").modal('show');
        mostrarPedido("mostrarPedidos","c",codpersonal,oficina);
    })

    $("#verPedidos2").on('click',function(params) {
        /*muestra el modal para vista en pc*/
        var codpersonal = $("#vrcodpersonal").val();
        var oficina = $("#vroficina").val();
        $("#ModalMostrarPedidos").modal('show');
        mostrarPedido("mostrarPedidos","p",codpersonal,oficina);
    })


    $("#cerrarmodal").on('click',function (params) {
        $("#ModalMostrarPedidos").modal('hide');
    })

    $("#txtcontrato").blur(function (e) {
        nr_contrato = $("#txtcontrato").val();
        if(nr_contrato.length >= 1){
            completarContrato(nr_contrato); 
        }  
    });

    $('#txtcontrato').on('input', function () { 
        this.value = this.value.replace(/[^0-9a-zA-Z]/g,'');
    });

   $('#txtnumero').keypress(function (e) {
        if(e.which == 13) {
            e.preventDefault();
            cliente =  $("#txtnumero").val();
            BuscarCLiente(cliente);
        }
   })



})


function buscarProducto(nombreproducto,zona) {
    if(nombreproducto.substring(2,0) === "CM"){
        $.ajax({
            dataType:'text',
            type: 'POST', 
            url:  '../seguimiento/C_BuscarProducto.php',
            data:{
                "accion" : "buscar",
                "producto" : nombreproducto,
                "zona" : zona
            } ,
            success:  function(response){
                $("#sugerencias").fadeIn(0).html(response);
                if(response != ""){
                        $("#sugerencias").height(300);
                        $("#sugerencias").css('overflow','scroll');
                }else{
                        $("#sugerencias").height(0);
                    }

                $('#sugerencias').fadeIn(0).html(response);
               
                
                $('.suggest-element').on('click', function(){
                    var id =  $(this).attr('id');
                    var precio =$(this).attr('data')
                    $("#nombreproducto").val(id);
                    $("#precioproducto").val(precio)
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
            url:  '../seguimiento/C_BuscarProducto.php',
            data:{
                "accion" : "buscar",
                "producto" : nombreproducto,
                "zona" : zona
            } ,
            success: function name(response) {
             
                $("#sugerencias").fadeIn(0).html(response);
                if(response != ""){
                    $("#sugerencias").height(300);
                    $("#sugerencias").css('overflow','scroll');
                }else{
                    $("#sugerencias").height(0);
                }

                    $('.suggest-element').on('click', function(){
                        var id =  $(this).attr('id');
                        var datos = $(this).attr('data');
                        array = datos.split("&");
                        $('#nombreproducto').val(array[0]);
                        gramos = array[1]
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
            url:  '../seguimiento/C_BuscarProducto.php',
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
            url:  '../seguimiento/C_BuscarProducto.php',
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
                    +"<td><a class='btn btn-primary btn-sm ' id='btneliminar'>"+
                        "<i class='icon-trash' title='Align Right'></i>"+
                    "</a>"+
                    "</td></tr>";
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
    
    if(nombre !== '' & cantidad !== ''  && cod_producto !== '' ){
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
                        if(promocion == ""){promocion = "0"}
                     
                        arrayproductos[contador] = {cod_producto,nombre,cantidad,promocion,precio,total,gramos};
                        temporalPrecios[contador] = {cod_producto,nombre,cantidad,promocion,precio,total,gramos};
                        if(cantidad < 6){
                            verificarRegalo(arrayproductos);
                        }else{
                            agregarProductoRegalo(arrayproductos);
                        }
                    
                        
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
                url:  '../seguimiento/C_BuscarProducto.php',
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
                            total = precioproducto * cantidad;
                            $("#G_total").val(total.toFixed(2));
                        }
                    }
                }
        });
        
       

    }else{
        mensajesError("Ingrese una cantidad validad","mensaje");
    }
}



function PrecioWeb(cod_producto,cantidad) {
        $.ajax({
            dataType:'text',
                type: 'POST', 
                url:  '../seguimiento/C_BuscarProducto.php',
                data:{
                    "accion" : "precioweb",
                    "cod_producto" : cod_producto,
                } , 
                success: function(response){ 
                    $("#precioproducto").val(response);
                    total = response * cantidad;
                    $("#G_total").val(total.toFixed(2));
                }
        });
}









function politicabonos(arrayproductos) {
    var zona = $("#vrzona").val();
    var datosproductos ={arrayproductos};
    if(cantidad != 0){
        $.ajax({
            dataType:'text',
                type: 'POST', 
                url:  '../seguimiento/C_BuscarProducto.php',
                data:{
                    "accion" : "politicabonos",
                    "datos" : JSON.stringify(datosproductos),
                    "zona" : zona,
                } , 
                success: function(response){ 
                   
                        obj = JSON.parse(response);
                    if(obj['estado'] === "ok"){
                        tablaprincipal(arrayproductos);
                    }else{
                        mensajesError(obj['mensaje'],"mensaje");
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




function obtenerDistrito(provincia,seleccDistrito){
    var accion = "distrito";        
    var oficina = $("#vroficina").val();
    $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  '../seguimiento/C_ListarCiudades.php',
        data: {
           "accion" : accion ,
           "provincia" : provincia,
           "oficina" :  oficina  
        },
        success: function(response){
            $('#Selectdistro').append(response);
            if(seleccDistrito){
                $("#Selectdistro").val(seleccDistrito);
            }
        }
    });
}



function obtenerprovincia(){
    var oficina = $("#vroficina").val();
    var accion = "provincia";
    $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  '../seguimiento/C_ListarCiudades.php',
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
   
    if($("#slcdocumento").val() != "DNI" && $("#slcdocumento").val() != "RUC" ){
        mensajesError("Seleccione el Tipo de Documento","mensajesgenerales");
     
    }else if($("#txtnumero").val().length == 0){
        mensajesError("Ingrese el DNI del cliente","mensajesgenerales");
        $('#txtnumero').focus();

    }else if($("#slcdocumento").val() == "DNI" && ($("#txtnumero").val().length < 8 || $("#txtnumero").val().length > 8)){
        mensajesError("El DNI no puede ser menor o mayor a 8 digitos","mensajesgenerales");
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
      
        mensajesError("Seleccione una condicion","mensajesgenerales");

    }else if($("#turno").val() === "n"){
        mensajesError("Seleccione un Turno","mensajesgenerales");

    }else if($("#txtcontrato").val() == "" || $("#txtcontrato").val().length < 5){
        mensajesError("Ingrese el numero de Contrato minimo 5 digitos","mensajesgenerales");
      

    }else if($("#txtcodigo").val() != $("#txtgenereado").val()){
        mensajesError("El codigo ingresado no es igual al Codigo Generado","mensajesgenerales");

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
            url:  '../seguimiento/C_Pedido.php',
            data:data.serialize()+"&accion=guardar&array="+JSON.stringify(datosproductos)+
                "&codPersonal="+codpersonal+"&oficina="+oficina, 
            success: function(response){
                var obj = JSON.parse(response);
                if(obj["estado"] === "error"){
                    mensajesError(obj['mensaje'],"mensajesgenerales")
                }else{
                    mensajeSuccess(obj['mensaje'],"mensajesgenerales")
                    reiniciarFrm();
                    generarCodigo();
                }
            }
        });
       
}



function validarTelefono(telefono) {
    var numeros = ['012345678','123456789','987654321','876543210'];
    for (let i = 0; i < numeros.length; i++) {
        if(telefono == numeros[i]){
            
            return true;
        } 
        
    }
}


function mostrarPedido(mostrarpedido,tipo,codpersonal,oficina) {
    var accion = mostrarpedido;
    $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  '../seguimiento/C_ListarPedidos.php',
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


function completarContrato(nr_contrato) {
    var accion = "contrato";
    $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  '../seguimiento/C_verificar.php',
        data: {
            "verificar":  accion,
            "nr_contrato": nr_contrato,    
        },
        success: function(response){
            $("#txtcontrato").val(response);
        }
    });  
    
}

function generarCodigo() {
    var accion = "generarcodigo";
    $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  '../seguimiento/C_verificar.php',
        data: {
            "verificar":  accion,
        },
        success: function(response){
            $("#txtgenereado").val(response);
        }
    });  
}


function eliminarArrayTemporal(){
    $("#ModalProducto").modal("hide");
    document.getElementById("frmagregarProducto").reset();
        for (let i = 0; i < arrayproductos.length; i++) {
            for (let l = 0; l <= arraytemporal.length; l++) {
                    if (arrayproductos[i]!= undefined) {
                            if(arrayproductos[i]['combo'] !== undefined){
                                if (arrayproductos[i]['combo'] === arraytemporal[l]) {
                                    delete(arrayproductos[i]);
                                }
                            }else{
                                if (arrayproductos[i]['cod_producto'] === arraytemporal[l]) {
                                    delete(arrayproductos[i]);
                                 }
                            }
                    }
            }
        }
        $('#productosMomento').find("tr:gt(0)").remove();
        arraytemporal =[];
    arraycodigos = [];
    temporalPrecios = [];
}

function reiniciarFrm() {
    arrayproductos = [];
    arraycodigos = [];
    arraytemporal = [];
    document.getElementById("frmpedidos").reset();
    $('#tablaproductos').find("tr:gt(0)").remove();
    $("#tablaproductos").hide();
    generarCodigo();
}


function tablaprincipal(arrayproductos){
    if(Object.keys(arrayproductos) != "" && arraycodigos.length != 0){
        $('#tabladelProducto').find("tr:gt(0)").remove();
                for (let i = 0; i < arrayproductos.length; i++) {
                    if (arrayproductos[i] != undefined) {
                            if(arrayproductos[i]['combo'] != undefined){
                                var fila="<tr><td style='display: none;'>"+arrayproductos[i]['combo']+
                                "</td><td>"+arrayproductos[i]['nombre']+ "</td><td>"+arrayproductos[i]['cantidad']+
                                "</td><td>"+arrayproductos[i]['precio']+"</td><td>"+arrayproductos[i]['promocion']+"</td><td style='display: none;'>"+
                                arrayproductos[i]['total'] +"</td></tr>";
                                var btn = document.createElement("TR");
                                btn.setAttribute('id', arrayproductos[i]['combo']);
                            }else{
                               
                                var fila="<tr><td style='display: none;'>"+arrayproductos[i]['cod_producto']+
                                "</td><td>"+arrayproductos[i]['nombre']+ "</td><td>"+arrayproductos[i]['cantidad']+
                                "</td><td>"+arrayproductos[i]['precio']+"</td><td>"+arrayproductos[i]['promocion']+"</td><td style='display: none;'>"+
                                arrayproductos[i]['total'] +"</td></tr>";
                                var btn = document.createElement("TR");
                            }
                            btn.innerHTML=fila;
                            document.getElementById("tabla").appendChild(btn);
                    }   
                }
                $("#tablaproductos").show("slow");
                $("#ModalProducto").modal("hide");
                document.getElementById("frmagregarProducto").reset();
                $('#productosMomento').find("tr:gt(0)").remove();
                arraytemporal =[];
                arraycodigos=[];
    }else{
        mensajesError("Ingrese un Producto","mensaje");
    }
}


function BuscarCLiente(identificacion) {
    var oficina = $("#vroficina").val();
    var accion = "Bcliente";
    $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  '../seguimiento/C_ListarCiudades.php',
        data: {
           "accion" : accion ,
           "identificaion" : identificacion,
           "oficina" :  oficina  
        },
        success: function(response){
            obj = JSON.parse(response);
            if(obj != null){
                $("#txtcliente").val(obj[0]['1']+" "+obj[0]['2']+" "+obj[0]['3']+" "+obj[0]['4']);
                $("#txtdireccion").val(obj[0]['8']);
                $("#txtreferencia").val(obj[0]['9']);
                $("#txttelefono").val(obj[0]['13']);
                $("#Selectprovincia").val(obj[0]['6']);
                obtenerDistrito(obj[0]['6'],obj[0]['7']);
            }
        }
    });
}


function verificarRegalo(datos) {

    var productoRegalo = 0;
    var zona = $("#vrzona").val();
    for (let i = 0; i < arrayproductos.length; i++) {
        if (arrayproductos[i] != undefined) { 
            if(arrayproductos[i]['gramos'] >= 600){
                productoRegalo++ ;
                $.ajax({
                    dataType:'text',
                    type: 'POST', 
                    url:  '../seguimiento/C_BuscarProducto.php',
                    data: {
                        "accion": "regalos",
                        "cantidad" : productoRegalo,
                        "zona" : zona
                    },
                    success: function(response){
                        obj = JSON.parse(response);
                       
                        $.each(obj['regalo'], function(i, item) {
                            for (let l = 0; l < arrayproductos.length; l++) {
                                    if (arrayproductos[l] != undefined && arrayproductos[l]['gramos'] != undefined ) { 
                                        if(item.REGALO_UNIDAD_MEDIDA.trim() === arrayproductos[l]['gramos']){
                                            if(cumpliopromo.indexOf(item.CANTIDAD) == -1){
                                                arrayproductos[l]["precio"] = 0;
                                                arrayproductos[l]["total"] = 0;
                                            }
                                              cumpliopromo.push(item.CANTIDAD);
                                        } 
                                      
                                    }
                                }
                        });
                        agregarProductoRegalo(arrayproductos);
                    } 
                });
            }else{
                agregarProductoRegalo(arrayproductos);
            }  
        }
    }
}


function agregarProductoRegalo(dat) {
    var fila = "";
   
    if(dat.length > 1){ 
        $("#productosMomento tbody tr").remove();
    }

    console.log(dt);
   for (let j = 0; j < dat.length; j++) {
      
       console.log(j);
        if (dat[j] != undefined && j >= dt) { 
            fila="<tr><td style='display: none;'>"+dat[j]['cod_producto']+
            "</td><td>"+dat[j]['nombre']+"</td><td>"+dat[j]['cantidad']+
            "</td><td>"+dat[j]['precio']+"</td><td>"+dat[j]['promocion']+"</td><td style='display: none;'>"+
            dat[j]['total'] +"</td>"
            +"<td><a class='btn btn-primary btn-sm ' id='btneliminar'>"+
            "<i class='icon-trash' title='Align Right'></i>"+
            "</a>"+
            "</td></tr>";

            var btn = document.createElement("TR");
            btn.innerHTML=fila;
            document.getElementById("tablaModal").appendChild(btn);
        }
    }
    document.getElementById("frmagregarProducto").reset();
  
}