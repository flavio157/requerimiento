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
    $('#ModalProducto').modal({
        backdrop: 'static', keyboard: false
    })


    $("html").click(function(){
        $('#sugerencias').fadeOut(0); 
    });

    $("#txtcontrato").keyup(function(e) {
        var input=  document.getElementById('txtcontrato');
            input.addEventListener('input',function(){
                this.value = this.value.slice(0,9); 
            })
    })



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

    $("#txttelefono").keyup(function (e) {
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
                arraycodigos = [];
            }else{
                mensajesError("La Promoción no puede ser mayor a lo indicado: " + bono,"mensaje");
            }
        }
       
    });

    $("#nombreproducto").on('keyup',function () {
        var nombreproducto = $("#nombreproducto").val().toUpperCase();
        tipodeproducto = nombreproducto.substring(2,0).toUpperCase();
       
        if(tipodeproducto === "CM"){
            buscarProducto(nombreproducto);
        }else{
            buscarProducto(nombreproducto);
        }
        
     
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
        if(tipodeproducto === "CM"){
            total = precio * cantidad;
            $("#G_total").val(total.toFixed(2));
            if(e.which == 8) {
                $("#G_promocion").val('');
                $("#G_total").val('');
             }
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
        var id = $('#Selectprovincia').val().split("/");;

        obtenerDistrito(id[0],id[1]);
});

})



