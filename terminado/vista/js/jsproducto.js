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
    generarCodigo();

    $("#cerrarmodalProducto").click(function name(params) {
        $("#ModalProducto").modal("hide");
        $('#productosMomento').find("tr:gt(0)").remove();
        arraytemporal =[];
        arraycodigos = [];
    })

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
            var promocion = $("#G_promocion").val();
            if (promocion <= bono) {  
                agregarproductos();
                /*arraycodigos = [];*/
            }else{
                mensajesError("La Promoción no puede ser mayor a lo indicado: " + bono,"mensaje");
            }
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

    $("#G_cantidad").blur(function(){
        cantidad = $("#G_cantidad").val();
        
            codproducto = $("#cod_producto").val();
            calcularTotal(cantidad,"ingresar");
            if(cantidad != "" && cantidad != 0){
                politicabonos(cantidad,codproducto);
            }
        /*comentar politicaBonos para filtrar producto por precio web */
      });


    $("#agregar").on('click',function() {
        if(Object.keys(arrayproductos) != "" && arraycodigos.length != 0){
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
                    arraycodigos=[];
        }else{
            mensajesError("Ingrese un Producto","mensaje");
        }
       
    });  

   $("#closemodal").on('click',function(){
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
                        var index = arraycodigos.indexOf(valores);
                        if ( index !== -1 ) {
                            arraycodigos.splice( index, 1 );
                        }
                        delete(arrayproductos[i]);
                     }
                     
                }else{
                    if (arrayproductos[i]['cod_producto'] === valores) {
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
        
    }); 

    $("#G_cantidad").keyup(function(e) {
        precio = $("#precioproducto").val();
        cantidad = $("#G_cantidad").val();
        if(tipodeproducto === "CM"){
            if(e.which == 8) {
                $("#G_promocion").val('');
                $("#G_total").val('');
             }
             total = precio * cantidad;
            $("#G_total").val(total.toFixed(2));
        }
    })

    $("#G_cantidad").keydown(function(e){
            if(e.which == 8) {
                $("#G_promocion").val('');
                $("#G_total").val('');
            }
        
    });

    $("#G_cantidad").on('keyup',function(){
        cantidad = $("#G_cantidad").val();
        codproducto = $("#cod_producto").val();
        
        if(tipodeproducto !== "CM"){
            if(cantidad != "" && cantidad != 0){ 
                politicaprecios(cantidad,codproducto);
            }
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
})


