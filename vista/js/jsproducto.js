var valorproducto = 0;
var precioproducto = 0;
var arrayproductos = [];
var contador = 0;
var arraycodigos = [];
var arraytemporal = [];
var bono = 0;
var tipodeproducto = "";

$(document).ready(function(){
    obtenerprovincia();

    $("html").click(function(){
        $('#sugerencias').fadeOut(0); 
    });

    $("#tablaproductos").hide();

    $('#ModalProducto').on('shown.bs.modal', function (e) {
        $('#nombreproducto').focus();
    })

    $("#agregarProducto").on('click',function(){
        if(tipodeproducto === "CM"){
            if($("#nombreproducto").val() != ""){
                ProductosCombo($("#nombreproducto").val());
            }
        }else{
            var promocion = $("#G_promocion").val();
            if (promocion <= bono) {  
                agregarproductos();
                arraycodigos = [];
            }else{
                mensajesError("La Promoción no puede ser mayor a lo indicado: " + bono,"mensaje");
            }
        }
       
    });

    $("#nombreproducto").on('keyup',function () {
        var nombreproducto = $("#nombreproducto").val();
        tipodeproducto = nombreproducto.substring(3,0).toUpperCase();
        buscarProducto(nombreproducto);
     
    });

    $("#G_cantidad").blur(function(){
        cantidad = $("#G_cantidad").val();
        if(tipodeproducto === "CM"){
            calcularTotal(cantidad,"ingresar");  
        }else{
            codproducto = $("#cod_producto").val();
            calcularTotal(cantidad,"ingresar");
            if(cantidad != "" && cantidad != 0){
                politicabonos(cantidad,codproducto);
            }
        }
       
        
      });

    $("#agregar").on('click',function() {
        if(arrayproductos.length != 0){
            $('#tabladelProducto').find("tr:gt(0)").remove();
            for (let i = 0; i < arrayproductos.length; i++) {
                if (arrayproductos[i] != undefined) {
                        if(arrayproductos[i]['combo'] != undefined){
                            var fila="<tr><td style='display: none;'>"+arrayproductos[i]['combo']+
                            "</td><td>"+arrayproductos[i]['nombre']+ "</td><td>"+arrayproductos[i]['cantidad']+
                            "</td><td>"+arrayproductos[i]['precio']+"</td><td>"+arrayproductos[i]['promocion']+"</td><td style='display: none;'>"+
                            arrayproductos[i]['total'] +"</td>"
                            +"<td><button type='button' id='btneliminar' class='btn btn-primary btn-sm'>-</button></td></tr>";
                            var btn = document.createElement("TR");
                            btn.setAttribute('id', arrayproductos[i]['combo']);
                        }else{
                            var fila="<tr><td style='display: none;'>"+arrayproductos[i]['cod_producto']+
                            "</td><td>"+arrayproductos[i]['nombre']+ "</td><td>"+arrayproductos[i]['cantidad']+
                            "</td><td>"+arrayproductos[i]['precio']+"</td><td>"+arrayproductos[i]['promocion']+"</td><td style='display: none;'>"+
                            arrayproductos[i]['total'] +"</td>"
                            +"<td><button type='button' id='btneliminar' class='btn btn-primary btn-sm'>-</button></td></tr>";
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
        }
       
    });  

   $("#closemodal").on('click',function(){
        $("#ModalProducto").modal("hide");
        document.getElementById("frmagregarProducto").reset();
        $('#productosMomento').find("tr:gt(0)").remove();
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
            arraytemporal =[];
        arraycodigos = [];
        
    });

    $(document).on('click', '#btneliminar',function (e) {
        var valores = $(this).parents("tr").find("td")[0].innerHTML;
        for (let i = 0; i < arrayproductos.length; i++) {
            if (arrayproductos[i] != undefined) {
                if(arrayproductos[i]['combo'] != undefined ){
                    if (arrayproductos[i]['combo'] === valores) {
                        for (let l = 0; l < arrayproductos.length; l++) {
                            $("#"+arrayproductos[i]['combo']).remove();   
                        }
                        delete(arrayproductos[i]);
                     }
                     
                }else{
                    if (arrayproductos[i]['cod_producto'] === valores) {
                        delete(arrayproductos[i]);
                        $(this).closest('tr').remove();
                     }
                }
             
            }   
        }
        
    }); 

    $("#G_cantidad").keyup(function(e) {
        precio = $("#precioproducto").val();
        cantidad = $("#G_cantidad").val();
        total = precio * cantidad;
        $("#G_total").val(total.toFixed(2));
    })

    $("#G_cantidad").keydown(function(e){
        precio = $("#precioproducto").val();
        cantidad = $("#G_cantidad").val();
        if(tipodeproducto === "CM"){
            if(e.which == 8) {
                $("#G_promocion").val('');
                $("#G_total").val('');
             }
        }
    });

    $("#G_cantidad").on('keyup',function(){
        cantidad = $("#G_cantidad").val();
        codproducto = $("#cod_producto").val();
        if(tipodeproducto !== "CM"){
            if(cantidad != "" && cantidad != 0){ 
                politicaprecios(cantidad,codproducto);
            }
            $("#precioproducto").val('');
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
        var id = $('#Selectprovincia').val().split("/");;

        obtenerDistrito(id[0],id[1]);
});

})


    function buscarProducto(nombreproducto) {
        $.ajax({
            dataType:'text',
            type: 'POST', 
            url:  '../controlador/C_BuscarProducto.php',
            data:{
                "accion" : "buscar",
                "producto" : nombreproducto,
            } ,
            success: function(response){
                if(response != ""){
                    var obj = JSON.parse(response);

                     if(obj['combo'] !== "" || obj['producto'] !== "" ){
                        $("#sugerencias").height(300);
                        $("#sugerencias").css('overflow','scroll');
                    }else{
                        $("#sugerencias").height(0);
                    }

                     if(obj['estado'] === "combo"){
                        $('#sugerencias').fadeIn(0).html(obj['combo']);
                        $('.suggest-element').on('click', function(){
                            var id =  $(this).attr('id');
                            var datos = $('#'+id).attr('data-');
                            $("#nombreproducto").val(id);
                            $("#precioproducto").val(datos)
                            valorproducto = datos;
                            $('#sugerencias').fadeOut(0); 
                            $("#G_promocion").attr('disabled','true');
                             
                                BuscarBonoItem(id);
                        });

                        
                     }else if(obj['estado'] === "productos"){
                        $('#sugerencias').fadeIn(0).html(obj['producto']);
                        $('.suggest-element').on('click', function(){
                            //Obtenemos la id unica de la sugerencia pulsada
                            var id =  $(this).attr('id');
                            var datos = $('#'+id).attr('data-');
                            array = datos.split("&");
                            //Editamos el valor del input con data de la sugerencia pulsada
                            $('#nombreproducto').val(array[0]);
                            $("#precioproducto").val(array[1]);
                            $('#sugerencias').fadeOut(0); 
                            $("#cod_producto").val(id);
                            $("#G_promocion").removeAttr('disabled');
                        });
                     }
                    
                }
               
                    
            }
        });

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
        var nombreproducto = $("#nombreproducto").val();
        var promocion = 0;
        var total = 0;
        var combo = "";
         if(cantidad !== ''){
            var estado = 1;
            if (contador >= 0) {
                for (let j = 0; j < arrayproductos.length; j++) {
                    if (arrayproductos[j] != undefined) {
                        if (arrayproductos[j]['combo'] === nombreproducto) {
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
        if(accion === "ingresar"){
            if(valorproducto !== "" && cantidad !== "" && cantidad != 0){
                var total = Number(cantidad) * Number(valorproducto);
                $("#G_total").val(total.toFixed(2)); 
            }
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
        '<strong>Exito: </strong>' + texto+
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
        if($("#txtcliente").val().length == 0){
            mensajesError("Ingrese nombre del Cliente","mensajesgenerales");
            $('#txtcliente').focus();
        }else if ($("#txtdireccion").val().length == 0){
            mensajesError("Ingrese una Direccion","mensajesgenerales");
           
            $('#txtdireccion').focus();
        }else if($("#txtreferencia").val().length == 0){
            mensajesError("Ingrese una Referencia","mensajesgenerales");
            
            $('#txtreferencia').focus();
        }else if($("#txtcontacto").val().length == 0){
            mensajesError("Ingrese un contacto","mensajesgenerales");
            
            $('#txtcontacto').focus();
        }else if($("#txttelefono").val().length < 9 || $("#txttelefono").val().length > 9  ){
            mensajesError("El telefono no puede ser mayor o menor de 9 digitos","mensajesgenerales");
            
            $('#txttelefono').focus();
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
    
