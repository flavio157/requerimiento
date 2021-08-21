


$(document).ready(function (params) {
    $("#agregarProducto").click(function (params) {
        primeratabla();
        limpiar();
    });

    $("#G_cantidad").keyup(function(e) {
        precio = $("#precioproducto").val();
        cantidad = $("#G_cantidad").val();
        total = precio * cantidad;
        $("#G_total").val(total.toFixed(2));
    })

   /* $("#agregar").click(function(params) {
        $("#tablaproductos").show();
        segundatabla("tablaModal","tabla");
        //tabla
    })*/

    $("#aceptar").click(function(e) {
        $("#tablaproductos").show();
        verificarPrecio("tablaModal","tablaModal");
        e.preventDefault();
        //tabla
    })
  

});


function primeratabla() {
    var fila="<tr><td class='tdproducto' style='display: none;'>"+$("#cod_producto").val()+
    "</td><td>"+$("#nombreproducto").val()+ "</td><td>"+$("#G_cantidad").val()+
    "</td><td>"+ $("#G_total").val()+"</td><td>"+$("#G_promocion").val()+
    "</td><td style='display: none;'>"+
    $("#precioproducto").val() +"</td>"+
    "<td style='display: none;'>"+gramo+"</td>"
    +"<td><a class='btn btn-primary btn-sm ' id='btneliminar'>"+
    "<i class='icon-trash' title='Align Right'></i>"+
    "</a>"+
    "</td></tr>";
    var btn = document.createElement("TR");
    btn.innerHTML=fila;
    document.getElementById("tablaModal").appendChild(btn);
    
}


//zona = 1


function verificarPrecio(idtbody1 , idtbody2){
    let arraygramos = [300,140];
    var regalocobrado = false;
    var arraynuevatabla = [];
    var zona = $("#vrzona").val();
    var filas = $("#"+idtbody1 +"  tr");
    var productoRegalo = 0;
    var total = 0.00;
    for (let l = 0; l <filas.length ; l++) {
        if($(filas[l]).find("td")[6].innerHTML >= 600 || $(filas[l]).find("td")[5].innerHTML >= 120.00)
            productoRegalo = Number(productoRegalo) + Number($(filas[l]).find("td")[2].innerHTML);
    }

    $("#"+idtbody1).empty();
   for (let i = 0; i < filas.length; i++) {   
        $.ajax({
            dataType:'text',
            type: 'POST', 
            url:  '../pedido/C_BuscarProducto.php',
            data:{
                "accion" : "politicaprecios",
                "codproducto" : $(filas[i]).find("td")[0].innerHTML,
                "cantidad" : $(filas[i]).find("td")[2].innerHTML,
                "zona" : zona,
            },
            success: function(response){
                obj = JSON.parse(response);
                codproducto = obj["codproducto"]
                nombreproducto = $(filas[i]).find("td")[1].innerHTML;
                cantidad = obj["cantidad"];
                bono = ($(filas[i]).find("td")[4].innerHTML == '') ? 0 : $(filas[i]).find("td")[4].innerHTML;
                if(obj['cantidad'] >= 6){
                     precio = obj["precio"];
                        if(Number(obj['bono']) >= Number(bono)){
                            totalnoregalo = (Number(obj["precio"]) * Number(obj["cantidad"]));
                            arraynuevatabla[i] = {codproducto,nombreproducto,cantidad,precio,bono,totalnoregalo}
                        }else{
                            arraynuevatabla[i] = {codproducto,nombreproducto,cantidad,precio,bono,totalnoregalo}
                        }
                }else{
                        if($(filas[i]).find("td")[6].innerHTML != arraygramos[0] && $(filas[i]).find("td")[6].innerHTML != arraygramos[1]){
                            precio = $(filas[i]).find("td")[3].innerHTML;
                            totalnoregalo = (Number(total) * Number(obj["cantidad"]));
                            arraynuevatabla[i] = {codproducto,nombreproducto,cantidad,precio,bono,totalnoregalo}
                        }else{
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
                                    regalo = JSON.parse(response);
                                 
                                        $.each(regalo['regalo'], function(r, item) {
                                            
                                            if(regalocobrado == false){
                                                
                                                if(regalo['regalo'][r]['3'].trim() == arraygramos[0] || regalo['regalo'][r]['3'].trim() == arraygramos[1]){

                                                        console.log(regalo['regalo'][r]['3'].trim() +"=="+ $(filas[i]).find("td")[6].innerHTML);
                                                        
                                                        if(regalo['regalo'][r]['3'].trim() == $(filas[i]).find("td")[6].innerHTML){
                                                            totalnoregalo =  (Number(total) * Number(obj["cantidad"]));
                                                            precio = Number($(filas[i]).find("td")[3].innerHTML) - (regalo['regalo'][r]['5'].trim() * Number($(filas[i]).find("td")[5].innerHTML));
                                                           
                                                         
                                                            arraynuevatabla[i] = {codproducto,nombreproducto,cantidad,precio,bono,totalnoregalo}
                                                            regalocobrado = true;
                                                       
                                                        }else if(regalo['regalo'][r]['4'].trim() == $(filas[i]).find("td")[6].innerHTML){
                                                            totalnoregalo =  (Number(total) * Number(obj["cantidad"]));
                                                            precio = Number($(filas[i]).find("td")[3].innerHTML) - (regalo['regalo'][r]['5'].trim() * Number($(filas[i]).find("td")[5].innerHTML));
                                                            console.log("r");
                                                            console.log(codproducto,nombreproducto,cantidad,precio,bono,totalnoregalo)
                                                            arraynuevatabla[i] = {codproducto,nombreproducto,cantidad,precio,bono,totalnoregalo}
                                                            regalocobrado = true;   
                                                        }
                                                    }else if (regalo['regalo'][r]['4'].trim() ==  arraygramos[0] || regalo['regalo'][r]['4'].trim() ==  arraygramos[1]){
                                                        
                                                        if(regalo['regalo'][r]['4'].trim() == $(filas[i]).find("td")[6].innerHTML){
                                                            totalnoregalo =  (Number(total) * Number(obj["cantidad"]));
                                                            precio =Number($(filas[i]).find("td")[3].innerHTML) - (regalo['regalo'][r]['6'].trim() * Number($(filas[i]).find("td")[5].innerHTML));
                                                            console.log("j");
                                                            arraynuevatabla[i] = {codproducto,nombreproducto,cantidad,precio,bono,totalnoregalo}
                                                            regalocobrado = true;

                                                        }else if(regalo['regalo'][r]['3'].trim() == $(filas[i]).find("td")[6].innerHTML){
                                                            totalnoregalo =  (Number(total) * Number(obj["cantidad"]));
                                                            precio = Number($(filas[i]).find("td")[3].innerHTML) - (regalo['regalo'][r]['6'].trim() * Number($(filas[i]).find("td")[5].innerHTML));
                                                            console.log("h");
                                                            console.log(codproducto,nombreproducto,cantidad,precio,bono,totalnoregalo)
                                                            arraynuevatabla[i] = {codproducto,nombreproducto,cantidad,precio,bono,totalnoregalo}
                                                            regalocobrado = true;
                                                       
                                                        }
                                                    }    
                                               
                                            }

                                        });
                                             
                                            console.log("v");
                                              console.log(codproducto,nombreproducto,cantidad,precio,bono,totalnoregalo);
                                                totalnoregalo = (Number(total) * Number(obj["cantidad"])) 
                                                 precio  = $(filas[i]).find("td")[3].innerHTML;
                                                arraynuevatabla[i] = {codproducto,nombreproducto,cantidad,precio,bono,totalnoregalo}
                                        
                                }
                            });
                        }         
                }
                
                
            },
       }); 
       
   }
   regalocobrado == false;
   $.each(arraynuevatabla, function(r, item) {
        console.log(item);    
    //arraynuevatabla
   });
 
   console.log(arraynuevatabla);
  
   for (let i = 0; i < arraynuevatabla.length; i++) {
       console.log(arraynuevatabla.length);
        var fila="<tr><td class='tdproducto' style='display: none;'>"+arraynuevatabla[i]['codproducto']+
            "</td><td>"+arraynuevatabla[i]['nombreproducto']+ "</td><td>"+arraynuevatabla[i]['cantidad']+
            "</td><td>"+ arraynuevatabla[i]['precio']+"</td><td>"+arraynuevatabla[i]['bono']+
            "</td><td style='display: none;'>"+
            arraynuevatabla[i]['totalnoregalo'] +"</td>" +"<td><a class='btn btn-primary btn-sm ' id='btneliminar'>"+
            "<i class='icon-trash' title='Align Right'></i>"+
            "</a>"+
            "</td></tr>";
            var btn = document.createElement("TR");
            btn.innerHTML=fila;
            document.getElementById("#"+idtbody2).appendChild(btn);
        console.log(arraynuevatabla[i]['total']); 
   }

}


function limpiar() {
    $("#nombreproducto").val('');
    $("#cod_producto").val('');
    $("#G_cantidad").val('');
    $("#precioproducto").val('');
    $("#G_promocion").val('');
    $("#G_total").val('');
}



