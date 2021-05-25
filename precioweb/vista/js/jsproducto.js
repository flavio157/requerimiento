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




    $("#agregar").on('click',function() {
        if(Object.keys(arrayproductos) != "" && arraycodigos.length != 0){
            $('#tabladelProducto').find("tr:gt(0)").remove();
                    for (let i = 0; i < arrayproductos.length; i++) {
                        if (arrayproductos[i] != undefined) {
                                    var fila="<tr><td style='display: none;'>"+arrayproductos[i]['cod_producto']+
                                    "</td><td>"+arrayproductos[i]['nombre']+ "</td><td>"+arrayproductos[i]['cantidad']+
                                    "</td><td>"+arrayproductos[i]['precio']+"</td><td>"+arrayproductos[i]['gramos']+"</td><td style='display: none;'>"+
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
                    arraycodigos=[];
        }else{
            mensajesError("Ingrese un Producto","mensaje");
        }
       
    });  







    $(document).on('click', '#btneliminar',function (e) {
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


