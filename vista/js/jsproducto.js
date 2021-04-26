$(document).ready(function(){

    $("#agregarProdcuto").on('click',function(){
        var cod_producto =$("#cod_producto").val();
        var nombre = $("#Nombreproducto").val();
        var cantidad = $("#G_cantidad").val();
        var promocion = $("#G_promocion").val();
        var precio =$("#precioproducto").val();
        var total = $("#G_total").val();
        
        console.log(nombre + " " + cantidad + " " + promocion + " " + precio +total);
        var fila="<tr><td></td><td>"+nombre+"</td><td>"+cantidad +"</td><td>"+promocion +"</td><td>"+precio+"</td><td>"+total +"</td></tr>";
    
        var btn = document.createElement("TR");
        btn.innerHTML=fila;
        document.getElementById("productosMomento").appendChild(btn);
    });


 






})