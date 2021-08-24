$(document).ready(function (params) {
    $("#agregarProducto").click(function (params) {
     /*   primeratabla();
        limpiar();*/
    });

   /* $("#G_cantidad").keyup(function(e) {
        precio = $("#precioproducto").val();
        cantidad = $("#G_cantidad").val();
        total = precio * cantidad;
        $("#G_total").val(total.toFixed(2));
    })
*/
    $("#aceptar").click(function(e) {
      /*  $("#tablaproductos").show();
        verificarPrecio("tablaModal","tablaModal");
        e.preventDefault();*/
        //tabla
    })

    $("#cancelar").click(function(e) {
        $("#tablaproductos").show();
        // 1 parametro : tabla de donde examinara los datos
        // 2 parametro : tabla donde se mostraran los datos ya examinados
        verificarPrecio("tablaModal","tablaModal"); 
        e.preventDefault();
        //tabla
    })

});

/*estructura de la tabla {CodigoProducto,NombreProducto,Cantidad,Precio,Promocion,Total,Gramos} */
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
    var arrayproductos = [];
    var boolencontro = false;
    var arraydatos = [];
    var count = 0;
    var count2 = 0;
    var cantproducto1 = 0;
    var cantproducto2 = 0;
    let arraygramos = [300,140];
    var codproducto = "";
    var nombreproducto= "";
    var cantidad = "";
    var bono = "";
    var zona = $("#vrzona").val();
    var filas = $("#"+idtbody1 +"  tr");
    var precioxproducto = 0;
    var total = 0.00;
    var productoRegalo = 0;
    var fila;
    var arraydife = [];
   
    for (let l = 0; l <filas.length ; l++) {
        if($(filas[l]).find("td")[6].innerHTML >= 600 || $(filas[l]).find("td")[5].innerHTML >= 120.00){
             productoRegalo = Number(productoRegalo) + Number($(filas[l]).find("td")[2].innerHTML);
        }else{
            arraydife.push($(filas[l]).find("td")[6].innerHTML);
        }      
    }

   $("#"+idtbody1).empty();
   for (let i = 0; i < filas.length; i++) {   
    nombreproducto = $(filas[i]).find("td")[1].innerHTML;
    var tabla = document.getElementById(idtbody2)
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
               
                cantidad = obj["cantidad"];
                bono = ($(filas[i]).find("td")[4].innerHTML == '') ? 0 : $(filas[i]).find("td")[4].innerHTML;
                if(obj['cantidad'] >= 6){
                    if(Number(obj['bono']) >= Number(bono)){
                        precioxproducto = obj["precio"];
                        var fila="<tr><td class='tdproducto' style='display: none;'>"+codproducto+
                        "</td><td>"+nombreproducto+ "</td><td>"+cantidad+
                        "</td><td>"+ precioxproducto+"</td><td>"+bono+
                        "</td><td style='display: none;'>"+
                        total +"</td>" +"<td><a class='btn btn-primary btn-sm ' id='btneliminar'>"+
                        "<i class='icon-trash' title='Align Right'></i>"+
                        "</a>"+
                        "</td></tr>";
                        var btn = document.createElement("TR");
                        btn.innerHTML=fila;
                        console.log("#"+idtbody2);
                        tabla.appendChild(btn); 

                    }else{
                        var fila="<tr><td class='tdproducto' style='display: none;'>"+codproducto+
                        "</td><td>"+nombreproducto+ "</td><td>"+cantidad+
                        "</td><td>"+ $(filas[i]).find("td")[3].innerHTML+"</td><td>"+bono+
                        "</td><td style='display: none;'>"+
                        total +"</td>" +"<td><a class='btn btn-primary btn-sm ' id='btneliminar'>"+
                        "<i class='icon-trash' title='Align Right'></i>"+
                        "</a>"+
                        "</td></tr>";
                        var btn = document.createElement("TR");
                        btn.innerHTML=fila;
                        console.log("#"+idtbody2);
                        tabla.appendChild(btn); 
                        console.log("ERROR BONO NO CORRESPONDE A LA CANTIDAD");
                    }
                    arrayproductos[i] = {codproducto,nombreproducto,cantidad,precioxproducto,bono,total}
                }else{
                    if($(filas[i]).find("td")[6].innerHTML != arraygramos[0] && $(filas[i]).find("td")[6].innerHTML != arraygramos[1]){
                            fila= "<tr><td class='tdproducto' style='display: none;'>"+codproducto+
                                "</td><td>"+$(filas[i]).find("td")[1].innerHTML+ "</td><td>"+cantidad+
                                "</td><td>"+ $(filas[i]).find("td")[3].innerHTML+"</td><td>"+bono+
                                "</td><td style='display: none;'>"+
                                total +"</td>" +"<td><a class='btn btn-primary btn-sm ' id='btneliminar'>"+
                                "<i class='icon-trash' title='Align Right'></i>"+
                                "</a>"+
                                "</td></tr>";
                                var btn = document.createElement("TR");
                                btn.innerHTML=fila;
                                console.log("#"+idtbody2);
                                tabla.appendChild(btn);
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
                                    obj = JSON.parse(response);
                                   
                                    if(boolencontro == false){
                                        if(boolencontro == false){
                                            $.each(obj['regalo'], function(r, item) {
                                                if(obj['regalo'][r][3].trim() == arraydife[0] && obj['regalo'][r][4].trim() == arraydife[1]){
                                                    arraydatos[0] = item;
                                                    boolencontro = true;
                                                    return false;
                                                }
                                            });
                                        }
                                        

                                        if(boolencontro == false){
                                            $.each(obj['regalo'], function(r, item) {
                                                if(obj['regalo'][r][4].trim() != arraydife[1]){
                                                    if(obj['regalo'][r][3].trim() == arraydife[0]) {
                                                        arraydatos[0] = item;
                                                        boolencontro = true;
                                                        return false;
                                                    }
                                                }
                                            });
                                        }

                                    }
                                    codproducto = $(filas[i]).find("td")[0].innerHTML;
                                    nombreproducto = $(filas[i]).find("td")[1].innerHTML;
                                    cantidad = $(filas[i]).find("td")[2].innerHTML;
                                    fila="<tr><td class='tdproducto' style='display: none;'>"+codproducto+
                                    "</td><td>"+nombreproducto+ "</td><td>"+cantidad+
                                    "</td>";
                                    //console.log(bono);

                                   
                                  for (let q = 0; q < arraydatos.length; q++) {
                                    //console.log(cantproducto1 +"!="+ arraydatos[q][5]);
                                      if(arraydatos[q][3].trim() == $(filas[i]).find("td")[6].innerHTML ){
                                        if(arraydatos[q][5] > $(filas[i]).find("td")[2].innerHTML && cantproducto1 != arraydatos[q][5]){
                                                precioxproducto = 0; 
                                                cantproducto1++;
                                                fila = fila + "<td>"+ precioxproducto+"</td>";
                                               // console.log(fila + "1");
                                        }else if(cantproducto1 != arraydatos[q][5]){
                                            cantproducto1 = arraydatos[q][5]
                                            precioxproducto = Number($(filas[i]).find("td")[3].innerHTML) - (arraydatos[q][5] * Number($(filas[i]).find("td")[5].innerHTML));
                                            fila = fila + "<td>"+ precioxproducto+"</td>";
                                            //console.log(fila + "2");
                                          }else{
                                            precioxproducto = $(filas[i]).find("td")[3].innerHTML;
                                            fila = fila + "<td>"+ precioxproducto+"</td>";
                                            //console.log(fila + "3");
                                          }
                                      }else{
                                        count = 1
                                      }

                                       // console.log("dato");
                                     // console.log(count +"=="+ 1 +"&&"+ count2 +"!="+ 1 );
                                      if(count == 1 && count2 != 1 ){
                                        if(arraydatos[q][4].trim() == $(filas[i]).find("td")[6].innerHTML){
                                            if(arraydatos[q][6] > $(filas[i]).find("td")[2].innerHTML  && cantproducto2 != arraydatos[q][6]){
                                                precioxproducto = 0; 
                                                cantproducto2++;
                                                fila = fila + "<td>"+ precioxproducto+"</td>";
                                                console.log("1");
                                                count2 = 1
                                               // break
                                          }else if(cantproducto2 != arraydatos[q][6]){
                                            cantproducto2 = arraydatos[q][6]
                                            precioxproducto = Number($(filas[i]).find("td")[3].innerHTML) - (arraydatos[q][6] * Number($(filas[i]).find("td")[5].innerHTML));
                                            fila = fila + "<td>"+ precioxproducto+"</td>";
                                            console.log("2");
                                            count2 = 1
                                           // console.log(precioxproducto);
                                            //break
                                          }else{
                                            precioxproducto = $(filas[i]).find("td")[3].innerHTML;
                                            fila =fila+"<td>"+ precioxproducto+"</td>";
                                            console.log("3");
                                            count2 = 1
                                          }
                                        }else if(count2 != 1){
                                            precioxproducto = $(filas[i]).find("td")[3].innerHTML;
                                            console.log(precioxproducto);
                                            fila =fila+"<td>"+ precioxproducto+"</td>";
                                            console.log(fila + "4");
                                            count2 = 1
                                        }
                                      }
                                  }

                                  
                                  fila = fila + "<td>"+bono+
                                  "</td><td style='display: none;'>"+
                                  total +"</td>" +"<td><a class='btn btn-primary btn-sm ' id='btneliminar'>"+
                                  "<i class='icon-trash' title='Align Right'></i>"+
                                  "</a>"+
                                  "</td></tr>";
                                  var btn = document.createElement("TR");
                                  btn.innerHTML=fila;
                                  tabla.appendChild(btn);
                                  arrayproductos[i] = {codproducto,nombreproducto,cantidad,precioxproducto,bono,total}
                                }
                            });
                              
                        }                  
                }
                
                
            },
       }); 
       
   }
   console.log(arrayproductos);
}


function limpiar() {
    $("#nombreproducto").val('');
    $("#cod_producto").val('');
    $("#G_cantidad").val('');
    $("#precioproducto").val('');
    $("#G_promocion").val('');
    $("#G_total").val('');
}



