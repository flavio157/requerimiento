var valorproducto = 0;
var precioproducto = 0;
var arrayproductos = [];
var contador = 0;
var arraycodigos = [];
var arraytemporal = [];
var temporalPrecios = [];



$(document).ready(function(){
    $("#cerrarmodalProducto").click(function name(params) {
        eliminarArrayTemporal();
    });

    $('body').on('keydown', function(e){
        if( e.which == 38 ||  e.which == 40) {
        return false;
        }
    });

    $('#ModalProducto').modal({
        backdrop: 'static', keyboard: false
    })


    $("html").click(function(){
        $('#sugerencias').fadeOut(0); 
    });


    $("#tablaproductos").hide();

    $('#ModalProducto').on('shown.bs.modal', function (e) {
        $('#nombreproducto').focus();
    })

    $("#agregarProducto").on('click',function(){
        agregarproductos();
    });

    $("#nombreproducto").on('keyup',function () {
        var nombreproducto = $("#nombreproducto").val().toUpperCase();
        buscarProducto(nombreproducto);
    });

    $("#closemodal").on('click',function(){
        eliminarArrayTemporal();
    });








    $(document).on('click', '#btneliminar',function (e) {            /*boton que se genera junto a los items de la tabla*/
        var valores = $(this).parents("tr").find("td")[0].innerHTML;
        for (let i = 0; i < arrayproductos.length; i++) {
            if (arrayproductos[i] != undefined) {
                    if (arrayproductos[i]['cod_producto'] === valores) {
                        var index = arraycodigos.indexOf(valores);
                        if (index !== -1 ) {
                            arraycodigos.splice(index,1);
                        }
                        delete(arrayproductos[i]);
                        delete(temporalPrecios[i]);
                        $(this).closest('tr').remove();
                     }
            }   
        }
        for (let l = 0; l < temporalPrecios.length; l++) {
            if(temporalPrecios[l] != undefined && arrayproductos[l] != undefined){
                if(arrayproductos[l]['precio'] == "0"){
                    arrayproductos[l]['precio'] = temporalPrecios[l]['precio'];
                    console.log( arrayproductos[l]['precio'] +"="+ temporalPrecios[l]['precio']);
                }
            }
        }
        verificarRegalo(arrayproductos)
    }); 

    $("#G_cantidad").on('keyup',function(e){
        if($("#G_cantidad").val() != 1){
            if(e.which != 8) {
                mensajesError("Solo se Puede ingresar un Producto","mensaje");
                $("#G_cantidad").val(1)
            }
        }
    })

    $("#G_cantidad").keyup(function(e) {
        precio = $("#precioproducto").val();
        cantidad = $("#G_cantidad").val();
       
            total = precio * cantidad;
            $("#G_total").val(total.toFixed(2));
       
       
      
    })

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
            $("#G_gramo").val('');
          }
    });



    $("#cerrarmodal").on('click',function (params) {
        $("#ModalMostrarPedidos").modal('hide');
    })


})


function buscarProducto(nombreproducto) {
    if(nombreproducto != ""){
        $.ajax({
            dataType:'text',
            type: 'POST', 
            url:  '../Pedido/C_BuscarProducto.php',
            data:{
                "accion" : "buscar",
                "producto" : nombreproducto,
            } ,
            success: function name(response) {
                var obj = JSON.parse(response);
                html = "";
                $.each(obj['producto'], function(i, item) {
                    html += "<div><a class='suggest-element' data='"+item.DESCRIPCION+'&'+item.PRECIO_WEB+'&'+item.PESO+"'  id="+item.CODIGO+">"+item.DESCRIPCION+"</a></div>";
                });
                $('#sugerencias').fadeIn(0).html(html);
                if(response != ""){
                    var obj = JSON.parse(response);
                     if(obj['producto'] !== "" ){
                        $("#sugerencias").html(html);
                        $("#sugerencias").height(300);
                        $("#sugerencias").css('overflow','scroll');
                    }else{
                        $("#sugerencias").height(0);
                    }
                }
                $('.suggest-element').on('click', function(){
                        var id =  $(this).attr('id');
                        var datos = $(this).attr('data');
                        array = datos.split("&");
                        $('#nombreproducto').val(array[0]);
                            valorproducto = array[1];  
                            $("#precioproducto").val(array[1]);
                        $("#G_gramo").val(array[2]);
                        $('#sugerencias').fadeOut(0); 
                        $("#cod_producto").val(id);
                      
                  });
                }
        });
    }
}

function agregarproductos() {
        var cod_producto =$("#cod_producto").val();
        var nombre = $("#nombreproducto").val();
        var cantidad = $("#G_cantidad").val();
        var gramos = $("#G_gramo").val();
        var precio =$("#precioproducto").val();
        var total = $("#G_total").val();

        if(nombre !== '' & cantidad !== '' && cod_producto !== '' ){
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
                            arrayproductos[contador] = {cod_producto,nombre,cantidad,gramos,precio,total};
                            temporalPrecios[contador] = {cod_producto,nombre,cantidad,gramos,precio,total};
                            verificarRegalo(arrayproductos);
                            contador++;
                            arraycodigos.push(cod_producto); 
                            arraytemporal.push(cod_producto);
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



    function eliminarArrayTemporal(){
        $("#ModalProducto").modal("hide");
        document.getElementById("frmagregarProducto").reset();
            for (let i = 0; i < arrayproductos.length; i++) {
                for (let l = 0; l <= arraytemporal.length; l++) {
                        if (arrayproductos[i]!= undefined) {
                                    if (arrayproductos[i]['cod_producto'] === arraytemporal[l]) {
                                        delete(arrayproductos[i]);
                                     }
                        }
                }
            }
            $('#productosMomento').find("tr:gt(0)").remove();
            arraytemporal =[];
        arraycodigos = [];
        temporalPrecios = [];
         
    }


    function verificarRegalo(datos) {
        var productoRegalo = 0;
      
        for (let i = 0; i < datos.length; i++) {
            if (datos[i] != undefined) { 
                if(datos[i]['gramos'] >= 600){
                    productoRegalo++ ;
                }
            }    
        }
        $.ajax({
            dataType:'text',
            type: 'POST', 
            url:  '../Pedido/C_BuscarProducto.php',
            data: {
                "accion": "regalos",
                "cantidad" : productoRegalo,
            },
            success: function(response){
                obj = JSON.parse(response);
                $.each(obj['regalo'], function(i, item) {
                    for (let l = 0; l < datos.length; l++) {
                        if (datos[l] != undefined && datos[l]['gramos'] != undefined) { 
                            if( item.REGALO_UNIDAD_MEDIDA.trim() === datos[l]['gramos']){
                                datos[l]['precio'] = 0;
                            } 
                        }
                    }
                });
            agregarProductoRegalo(datos);
            }
        });
    }


    function agregarProductoRegalo(datos) {
        var fila = "";
        if(datos.length > 1){
            $ ("#productosMomento tbody tr").remove();
        };
        for (let i = 0; i < datos.length; i++) {
            if (datos[i] != undefined) { 
                fila="<tr><td style='display: none;'>"+datos[i]['cod_producto']+
                "</td><td>"+datos[i]['nombre']+ "</td><td>"+datos[i]['cantidad']+
                "</td><td>"+datos[i]['gramos']+"</td><td>"+datos[i]['precio']+"</td><td style='display: none;'>"+
                datos[i]['total'] +"</td>"
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

  




