var valorproducto = 0;
var valorPromocion = 0;
var otratabla = "";
var buscartabla = [];
var buscartablaModal = [];
$(document).ready(function(){
    $("#tablaproductos").hide();

    $("#agregarProdcuto").on('click',function(){
        agregarProductos();
    });

    $("#nombreproducto").on('keyup',function () {
        var nombreproducto = $("#nombreproducto").val();
        buscarProducto(nombreproducto);
    });

    $("#G_cantidad").blur(function(){
        cantidad = $("#G_cantidad").val();
        calcularTotal(cantidad,"ingresar");
        if(cantidad != ""){
            politicaprecios(cantidad);
        }
        
      });

    $("#agregar").on('click',function() {
        $("#tabla").html(otratabla);
        $("#tablaproductos").show("slow");
        $("#ModalProducto").modal("hide");
        document.getElementById("frmagregarProducto").reset();
        $('#productosMomento').find("tr:gt(0)").remove();
    });  

    $("#closemodal").on('click',function(){
        document.getElementById("frmagregarProducto").reset();
        $('#productosMomento').find("tr:gt(0)").remove();
    });

    $("#btneliminar").on('click',function() {
        $(this).closest('tr').remove();
        console.log("eliminar");
    })

})


    function agregarProductos() {
        var buscarcodigo = "";
        var cod_producto =$("#cod_producto").val();
        var nombre = $("#nombreproducto").val();
        var cantidad = $("#G_cantidad").val();
        var promocion = $("#G_promocion").val();
        var precio =$("#precioproducto").val();
        var total = $("#G_total").val();

        if(promocion <= valorPromocion ){
            tabladatos = document.getElementById('tabla');
            if(tabladatos.rows.length > 0){
                for (let i = 0; i < tabladatos.rows.length; i++) {
                    cellsrows = tabladatos.rows[i].getElementsByTagName('td');
                    buscartabla.push(cellsrows[0].innerHTML.toLowerCase()); 
                }

                buscarcodigo =  buscartabla.find(function name(element) {
                    return element === cod_producto;
                } );

                if(buscarcodigo === undefined){
                    var fila="<tr><td style='display:none;'>"+cod_producto+"</td><td>"+nombre+
                    "</td><td>"+cantidad +"</td><td>"+precio+"</td><td>"+promocion+"</td><td>"
                    +total +"</td><td><a id='btneliminar' class='btn btn-primary btn-sm'>ELIMINAR</a></td></tr>";
                    var btn = document.createElement("TR");
                    btn.innerHTML=fila;
                    document.getElementById("tablaModal").appendChild(btn);

                    otratabla +=fila; 
                }else{
                    toastr.warning('Ya existe el producto');
                }
            }else{
                var obtener = verificaDescripcion(cod_producto);
               
                if(obtener === "sinigualdad" || obtener === "sindatos"){
                    var fila="<tr><td style='display:none;'>"+cod_producto+"</td><td>"+nombre+"</td><td>"+cantidad +
                    "</td><td>"+precio+"</td><td>"+promocion+
                    "</td><td>"+total +"</td><td><a id='btneliminar' class='btn btn-primary btn-sm'>ELIMINAR</a></td></tr>";

                    var btn = document.createElement("TR");
                    btn.innerHTML=fila;
                    document.getElementById("tablaModal").appendChild(btn);
                }else{
                    toastr.warning('Ya existe el Producto en la tabla');
                }
                otratabla +=fila;
            }

            document.getElementById("frmagregarProducto").reset();

        }else{
            toastr.warning('La Promoción es mayor a lo indicado por esa cantidad corresponde  ' + valorPromocion);
        }
    }




    function verificaDescripcion(cod_producto) {
        buscarcodigomodal = "";
        tablamodal = document.getElementById('tablaModal');
     
        if(tablamodal.rows.length > 0){
            for (let i = 0; i < tablamodal.rows.length; i++) {
                cellsrows = tablamodal.rows[i].getElementsByTagName('td');
                buscartablaModal.push(cellsrows[0].innerHTML.toLowerCase()); 
            }
            buscarcodigomodal =  buscartablaModal.find(function name(element) {
                return element === cod_producto;
            } );

            if(buscarcodigomodal === undefined){
               return "sinigualdad"
            }else{
                return "igualdad"
            }
        }else{
            return "sindatos";
        }
    }


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
            if(valorproducto !== "" && cantidad !== ""){
                var total = Number(cantidad) * Number(valorproducto);
                $("#G_total").val(total.toFixed(3)); 
            }
        }
    }


    function politicaprecios(cantidad) {
        $.ajax({
            dataType:'text',
                type: 'POST', 
                url:  '../controlador/C_BuscarProducto.php',
                data:{
                    "accion" : "politicaprecios",
                    "cantidad" : cantidad,
                } , 
                success: function(response){
                    var obj = JSON.parse(response);
                    if(obj["estado"] === "ok"){
                        valorPromocion = obj['bono'];   
                    }
                }
        });
    }