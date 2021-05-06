var valorproducto = 0;
var precioproducto = 0;
var arrayproductos = [];
var contador = 0;
var arraycodigos = [];
var arraytemporal = [];
var bono = 0;
$(document).ready(function(){
    obtenerprovincia();

    $("#tablaproductos").hide();

    $('#ModalProducto').on('shown.bs.modal', function (e) {
        $('#nombreproducto').focus();
    })

    $("#agregarProducto").on('click',function(){
        var promocion = $("#G_promocion").val();
        if (promocion <= bono) {  
            agregarproductos();
            arraycodigos = [];
        }else{
            mensajes("La Promoción no puede ser mayor a lo indicado: " + bono,"mensaje");
        }
    });

    $("#nombreproducto").on('keyup',function () {
        var nombreproducto = $("#nombreproducto").val();
        buscarProducto(nombreproducto);
    });

    $("#G_cantidad").blur(function(){
        cantidad = $("#G_cantidad").val();
        codproducto = $("#cod_producto").val();
        calcularTotal(cantidad,"ingresar");
        if(cantidad != "" && cantidad != 0){
            politicabonos(cantidad,codproducto);
        }
        
      });

    $("#agregar").on('click',function() {
        $('#tabladelProducto').find("tr:gt(0)").remove();
        for (let i = 0; i < arrayproductos.length; i++) {
            if (arrayproductos[i] != undefined) {
                var fila="<tr><td style='display: none;'>"+arrayproductos[i]['cod_producto']+
                    "</td><td>"+arrayproductos[i]['nombre']+ "</td><td>"+arrayproductos[i]['cantidad']+
                    "</td><td>"+arrayproductos[i]['precio']+"</td><td>"+arrayproductos[i]['promocion']+"</td><td style='display: none;'>"+
                    arrayproductos[i]['total'] +"</td>"
                    +"<td><button type='button' id='btneliminar' class='btn btn-primary btn-sm'>-</button></td></tr>";
                    var btn = document.createElement("TR");
                    btn.innerHTML=fila;
                    document.getElementById("tabla").appendChild(btn);
            }   
        }

        $("#tablaproductos").show("slow");
        $("#ModalProducto").modal("hide");
        document.getElementById("frmagregarProducto").reset();
        $('#productosMomento').find("tr:gt(0)").remove();
        arraytemporal =[];
    });  

   $("#closemodal").on('click',function(){
        $("#ModalProducto").modal("hide");
        document.getElementById("frmagregarProducto").reset();
        $('#productosMomento').find("tr:gt(0)").remove();
            for (let i = 0; i < arrayproductos.length; i++) {
                for (let l = 0; l <= arraytemporal.length; l++) {
                        if (arrayproductos[i]!= undefined) {
                            if (arrayproductos[i]['cod_producto'] === arraytemporal[l]) {
                                delete(arrayproductos[i]);
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
             if (arrayproductos[i]['cod_producto'] === valores) {
                delete(arrayproductos[i]);
                $(this).closest('tr').remove();
             }
            }   
        }
    }); 

    $("#G_cantidad").keydown(function(e){
        if(e.which == 8) {
           $("#G_promocion").val('');
           $("#G_total").val('');
          }
    });

    $("#G_cantidad").on('keyup',function(){
        cantidad = $("#G_cantidad").val();
        codproducto = $("#cod_producto").val();
        if(cantidad != "" && cantidad != 0){ 
             politicaprecios(cantidad,codproducto);
        }
        $("#precioproducto").val('');
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

    $("#txtnumero").keydown(function(e){
        tipo = $("#slcdocumento").val();
        var txt= document.getElementById('txtnumero'); 
       
       if(tipo === "DNI"){
             txt.addEventListener('input',function(){
            if (this.value.length > 8) 
                this.value = this.value.slice(0,8); 
            })
       }
        
       if(tipo === "RUC"){
            txt.addEventListener('input',function(){
            if (this.value.length > 8) 
                this.value = this.value.slice(0,8); 
            })
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
                $('#sugerencias').fadeIn(0).html(response);
                    if(response !== ""){
                        $("#sugerencias").height(300);
                        $("#sugerencias").css('overflow','scroll');
                    }else{
                        $("#sugerencias").height(0);
                    }
            
                $('.suggest-element').on('click', function(){
                    //Obtenemos la id unica de la sugerencia pulsada
                    var id =  $(this).attr('id');
                    var datos = $('#'+id).attr('data-');
                    array = datos.split("&");
                    //Editamos el valor del input con data de la sugerencia pulsada
                    $('#nombreproducto').val(array[0]);
                    $("#precioproducto").val(array[1]);
                    
                    $("#cod_producto").val(id);
                    //Hacemos desaparecer el resto de sugerencias
                    $('#sugerencias').fadeOut(0); 
            });
            }
        });

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
            mensajes("Ingrese una cantidad validad","mensaje");
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
            mensajes("Ingrese una cantidad validad","mensaje");
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
                                    mensajes("Ya existe el Producto en la tabla","mensaje");
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
                mensajes("Ingrese los datos correctamente","mensaje");
            }
           
    }


    function mensajes(texto,id) {
       mensaje = '<div class="alert alert-warning alert-dismissible fade show" role="alert" id="">'+
       '<strong>Advertencia: </strong>'+texto+
       '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>'+
       '</div>';
        $('#'+id).html(mensaje);
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
            $('#txtcliente').focus();
        }else if ($("#txtdireccion").val().length == 0){
            console.log("error direccion");
            $('#txtdireccion').focus();
        }else if($("#txtreferencia").val().length == 0){
            console.log("error referencia");
            $('#txtreferencia').focus();
        }else if($("#txtcontacto").val().length == 0){
            console.log("error txtcontacto");
            $('#txtcontacto').focus();
        }else if($("#txttelefono").val().length < 9 || $("#txttelefono").val().length > 9  ){
            console.log("error telefono");
            $('#txttelefono').focus();
        }else if($("#txtcontrato").val().length < 6){
            console.log("error contrato");
            $('#txtcontrato').focus();
        }else if(arrayproductos.length == 0){
            console.log("No puede guardar sin seleccionar un producto");
        }else if (Object.keys(arrayproductos) == "") {
            console.log("vuelva a seleccionar un producto");
        }else if($("#txtcliente").val().length > 0){
            verificar = $("#txtcliente").val().split(" ");
            if(verificar.length < 3){
              console.log("se necesita un nombre y los dos apellidos");
              $('#txtcliente').focus();
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
                }
            });
            reiniciarFrm();
    }
    
