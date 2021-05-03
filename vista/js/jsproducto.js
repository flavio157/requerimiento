var valorproducto = 0;
var precioproducto = 0;
var arrayproductos = [];
var contador = 0;
var arraycodigos = [];
var arraytemporal = [];
$(document).ready(function(){
    $("#tablaproductos").hide();

    $('#ModalProducto').on('shown.bs.modal', function (e) {
        $('#nombreproducto').focus();
    })

    $("#agregarProducto").on('click',function(){
        agregarproductos();
        document.getElementById("frmagregarProducto").reset();
        arraycodigos = [];
       
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
           politicaprecios(cantidad,codproducto);
            politicabonos(cantidad,codproducto);
        }
        
      });

    $("#agregar").on('click',function() {
        $('#tabladelProducto').find("tr:gt(0)").remove();
        for (let i = 0; i < arrayproductos.length; i++) {
            if (arrayproductos[i] != undefined) {
                var fila="<tr><td>"+arrayproductos[i]['cod_producto']+
                    "</td><td>"+arrayproductos[i]['nombre']+ "</td><td>"+arrayproductos[i]['cantidad']+
                    "</td><td>"+arrayproductos[i]['precio']+"</td><td>"+arrayproductos[i]['promocion']+"</td><td>"+
                    arrayproductos[i]['total'] +"</td>"
                    +"<td><button type='button' id='btneliminar' class='btn btn-primary btn-sm'>ELIMINAR</button></td></tr>";
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
        /*console.log(arraycodigos);
        $("#modaladvertencia").modal("show");

        $("#cancelar").on('click',function() {
            $("#modaladvertencia").modal("hide");
            
        })*/

        /* $("#aceptar").on('click',function() {})*/
            /*document.getElementById("frmagregarProducto").reset();*/
            
            /*$("#modaladvertencia").modal("hide");
            $("#ModalProducto").modal("hide");*/
            for (let i = 0; i < arrayproductos.length; i++) {
                for (let l = 0; l <= arraytemporal.length; l++) {
                    console.log(arraytemporal[0]);
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

    $("#nombreproducto").keydown(function(e){
        if(e.which == 8) {
            $("#cod_producto").val('')
            $("#G_cantidad").val('');
            $("#G_promocion").val('');
            $("#precioproducto").val(''); 
            $("#G_total").val('');
          }
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
                $('#sugerencias').fadeIn(0).html(response)
                
                var altura = $("#sugerencias").height();   
               
                    if(response !== ""){
                        $("#sugerencias").height(300);
                        $("#sugerencias").css('overflow','scroll');;
                      
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
                    valorproducto = array[1];    
            });
            }
        });

    }

    function calcularTotal(cantidad,accion){
        if(accion === "ingresar"){
            if(valorproducto !== "" && cantidad !== "" && cantidad != 0){
                var total = Number(cantidad) * Number(valorproducto);
                $("#G_total").val(total.toFixed(3)); 
            }else{
                mensajes('Ingrese una cantidad valida');
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
                        console.log(response);
                        var obj = JSON.parse(response);
                        if(obj["estado"] === "ok"){
                            precioproducto = obj['precio'];  
                            $("#precioproducto").val(precioproducto);
                        }
                    }
            });
        }else{
            mensajes("Ingrese una cantidad validad");
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
            mensajes("Ingrese una cantidad validad");
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
                            mensajes('Ya existe el Producto en la tabla');
                            return estado = 0;
                            break;
                        }else{
                            estado = 1
                        }  
                    }
                }
                if (estado === 1) {
                    arrayproductos[contador] = {cod_producto,nombre,cantidad,promocion,precio,total};
                    var fila="<tr><td>"+cod_producto+
                        "</td><td>"+nombre+ "</td><td>"+cantidad+
                        "</td><td>"+precio+"</td><td>"+promocion+"</td><td>"+
                        total +"</td>"
                        +"<td><button type='button' id='btneliminar' class='btn btn-primary btn-sm'>ELIMINAR</button></td></tr>";
                        var btn = document.createElement("TR");
                        btn.innerHTML=fila;
                        document.getElementById("tablaModal").appendChild(btn);
                        contador++;
                    arraycodigos.push(cod_producto); 
                    arraytemporal.push(cod_producto);
                }
            }
        }else{
            mensajes('Ingrese los datos correctamente');
        }
    }


    function mensajes(texto) {
       mensaje = '<div class="alert alert-warning alert-dismissible fade show" role="alert" id="">'+
       '<strong>Error: </strong>'+texto+
       '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>'+
       '</div>';

        $('#mensaje').html(mensaje);

    }

   