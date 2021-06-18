var valorproducto = 0;
/*var precioproducto = 0;*/
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
        returnPrecio(temporalPrecios);
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

function returnPrecio(temporalPrecios) {
    for (let l = 0; l < temporalPrecios.length; l++) {
        if(temporalPrecios[l] != undefined && arrayproductos[l] != undefined){
            if(arrayproductos[l]['precio'] == "0"){
                arrayproductos[l]['precio'] = temporalPrecios[l]['precio'];
            }
        }
    }
    cumpliopromo = [];
    verificarRegalo(arrayproductos)
}



function buscarProducto(nombreproducto) {
    if(nombreproducto != ""){
        $.ajax({
            dataType:'text',
            type: 'POST', 
            url:  '../pedido/C_BuscarProducto.php',
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
        var zona = $("#vrzona").val();
        var unidad = 600; 
        var precio = 120.00;
        var productoRegalo = 0;
        var arrad = [];
        var temp = [];
        var _canregun = 0;
        var _canregdo = 0;
        var jungle = [];
        for (let i = 0; i < datos.length; i++) {
            if (datos[i] != undefined) { 
                if(datos[i]['gramos'] >= unidad || datos[i]['precio'] >= precio){
                    productoRegalo++ ;
                }else{
                    arrad.push(i);
                }  
            }      
        }    
        if(arrad.length > 0){
            jungle = [
                { regalo1: productoRegalo, gramo: datos[arrad[0]]['gramos']},
            ];    
        }       
       
        $.ajax({
            dataType:'text',
            type: 'POST', 
            url:  '../pedido/C_BuscarProducto.php',
            data: {
                "accion": "regalos",
                "cantidad" : productoRegalo,
                "zona" : zona,
                
            },
            success: function(response){
                var arr = [];
                var count = 0;
                var cantpro = 0;
                obj = JSON.parse(response);
                if(arrad.length >= 1){
                        $.each(obj['regalo'], function(i, item) {
                            console.log(item['3'].trim() +"=="+ jungle[0]['gramo']);
                            if(item['3'].trim() == jungle[0]['gramo'] ){
                                arr.push(obj['regalo'][i]);
                                cantpro = cantpro + 1;
                            }
                        });
                        
                    
                    if(cantpro >= 2){
                        if(arrad.length >= 2){
                            for (let i = 0; i < arr.length; i++) {
                                if(arr[i]['4'].trim() == datos[arrad[1]]['gramos']){
                                    temp = arr[1];
                                    console.log(arr[1]);
                                    count = 1;
                                    break;
                                }else if(arr[i]['4'] == 0){
                                    console.log(arr[i]);
                                    temp = arr[i];
                                    count = 1;
                                  
                                }
                            } 
                        } 
                    }else{
                        $.each(obj['regalo'], function(i, item) {
                            if(item['3'].trim() == jungle[0]['gramo'] ){
                                temp = obj['regalo'][i];
                                count = 1; 
                           }
                        });
                    }
                    if(temp != ""){
                        for (let i = 1; i <= arrad.length; i++) {
                            if(temp['3'].trim() == datos[arrad[i - 1]]['gramos']){
                               _canregun++;
                            }else if(temp['4'].trim() == datos[arrad[i - 1]]['gramos']){
                               _canregdo++;
                            }
                       }
                    }
                }
           
                if(count == 1){
                    for (let l = 1; l <= arrad.length; l++) {
                        if(temp[3].trim() == datos[arrad[l - 1]]['gramos'] &&  _canregun <= temp[5].trim()){
                            datos[arrad[l - 1]]["precio"] = 0;
                        }else if (temp[4].trim() == datos[arrad[l - 1]]['gramos'] && _canregdo <= temp[6].trim()){
                            datos[arrad[l - 1]]["precio"] = 0;
                        }
                    } 
                 } 
                agregarProductoRegalo(datos);                        
            } 
        });            
    }

    function agregarProductoRegalo(dat) {
        var fila = "";

        if(dat.length > 1){
            $("#productosMomento tbody tr").remove();
        };
       
        
       for (let j = 0; j < dat.length; j++) {
            if (dat[j] != undefined) { 
                fila="<tr><td style='display: none;'>"+dat[j]['cod_producto']+
                "</td><td>"+dat[j]['nombre']+ "</td><td>"+dat[j]['cantidad']+
                "</td><td>"+dat[j]['gramos']+"</td><td>"+dat[j].precio+"</td><td style='display: none;'>"+
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

  




