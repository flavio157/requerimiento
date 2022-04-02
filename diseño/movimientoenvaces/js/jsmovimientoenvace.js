var sugxproducto =[]; var sugxcliente = [];
tempo = []; id = 0;usu = "";
$(document).ready(function () {
    miStorage = window.localStorage;
    autocompletarproducto();
    recuperadato(); autocompletarcliente();
    guia()
    usu = $("#vrcodpersonal").val();
    $("#btnagregar").on('click',function() {
       estado = datosrepetidos("tbdenvaces");
       if(estado == 0){
            validarprod($("#txtcodenvace").val(),$("#txtenvaces").val(),$("#txtcantidad").val());
       }else{
           Mensaje1("Error ya se agrego el envace a la tabla","error");
           return;
       }
    });

    $(document).on('click','#btneliminar',function(e) {
        cod =  $(this).parents('tr').find('td:nth-child(1)').text();
        cantidad =  $(this).parents('tr').find('td:nth-child(3)').text();
        devolderStock(cod,cantidad,this);
    });

    $("#btnguarguia").on('click',function(){
        var frmmovi = $("#frmmovimiento").serialize();
        var td =  $("#tbdenvaces tr");
        console.log(td.length);
        var tds = [];
        for (let l = 0; l < td.length; l++) {
            if($(td[l]).find("td")[0] != undefined){
                tds[l] =[
                    $(td[l]).find("td")[0].innerHTML,
                    $(td[l]).find("td")[2].innerHTML,           
                ]
            }    
        }
        guardar(frmmovi,tds);
    });

    $("#btncancelar").on('click',function(){
        document.getElementById('frmmovimiento').reset();
        $("#txtenvaces").val('');
        $("#txtcodenvace").val('');
        $("#txtstock").val('');$("#txtcantidad").val('');
    });


    $("#btngcliemodle").on('click',function(){
        guardarcliente();
    });

});


function recuperadato() {
    empresa = miStorage.getItem('productos');
    if(empresa != null){
        ob = JSON.parse(empresa);
        for (let i = 0; i < ob.length; i++) {
            if(ob[i] != null){
                _createtable(ob[i],i)
            } 
        }
    }
}

function _createtable(dato) {
    tempo[id] =  [dato[0],dato[1],dato[2]]
    miStorage.setItem("productos", JSON.stringify(tempo));
    btn = "<button type='button' class='btn btn-danger btn-sm' id='btneliminar'><i class='icon-trash' title='Eliminar fila'></i></button>"
    var fila="<tr>";
    fila +="<td style='display:none'>"+dato[0]+"</td>";
    fila +="<td>"+dato[1]+"</td>";
    fila +="<td>"+dato[2]+"</td>";
    fila +="<td>"+btn+"</td>";
    fila += "</tr>";
    var btn = document.createElement("TR");
    btn.innerHTML=fila;
    id++;
    document.getElementById("tbdenvaces").appendChild(btn);
}

function autocompletarproducto() {
    buscarxproducto();
    $("#txtenvaces").autocomplete({
        source: sugxproducto,
        select: function (event, ui) {
            $("#txtenvaces").val(ui.item.label);
            $("#txtstock").val(ui.item.stock)
            $("#txtcodenvace").val(ui.item.code);
        }
    });  
}

function buscarxproducto() {
    sugxproducto = [];
    $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  'c_movimientoenvace.php',
        data:{"accion" : 'buscarxproducto',} ,
        success:  function(response){
            obj = JSON.parse(response);
            $.each(obj['dato'], function(i, item) {
                sugxproducto.push(item); 
            });
        }
    });       
}


function autocompletarcliente() {
    buscarcliente();
    $("#txtcliente").autocomplete({
        source: sugxcliente,
        select: function (event, ui) {
          $("#txtcodclie").val(ui.item.code);
          $("#txtcliente").val(ui.item.label);
          $("#txtdireccion").val(ui.item.direccion);
        }
    });  
}


function buscarcliente() {
    sugxcliente = [];
    $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  'c_movimientoenvace.php',
        data:{
            "accion" : 'buscarcli',
        },
        success:  function(response){
            obj = JSON.parse(response);
            $.each(obj['dato'], function(i, item) {
                sugxcliente.push(item); 
            });
        }
    }); 
}


function guia() {
    $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  'c_movimientoenvace.php',
        data:{"accion" : 'guia',},
        success:  function(e){
            $("#lblnroguia").text(e)
        }
    }); 
}

function guardar(frmmovi,tds){
    fecha = $("#txtfecha").val();
    lblguia = $("#lblnroguia").text();
    var productos = {tds};
    $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  'c_movimientoenvace.php',
        data : frmmovi+"&accion=guardargui&usuario="+usu+"&fecha="+fecha+"&lblguia="+lblguia+"&usu="+usu+
        "&producto="+JSON.stringify(productos)
        ,beforeSend: function () {
            $('.ajax-loader').css("visibility", "visible");
        },success:  function(e){
            if(e == 1){
                Mensaje1("Se guardaron los datos correctamente","success");
                guia();
                document.getElementById('frmmovimiento').reset();
                localStorage.removeItem('productos');
                $('#tbenvaces').find("tr:gt(0)").remove();
            }else{
                Mensaje1(e,"error");
            }
            $('.ajax-loader').css("visibility", "hidden");
        },complete: function(){
            $('.ajax-loader').css("visibility", "hidden");
        }
    });   
}

function Mensaje1(texto,icono){
    Swal.fire({icon: icono,title: texto,});
}

function validarprod(codenvace,nombreenva,cantidad){
    $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  'c_movimientoenvace.php',
        data : {
            "accion" : "validarpro",
            "codenvace" : codenvace,
            "nombreenva" : nombreenva,
            "cantidad" : cantidad,
        },beforeSend: function () {
            $('.ajax-loader').css("visibility", "visible");
        },success:  function(e){
           if(e == 1){
               cantidad = cantidad.split('.');
               datos =[codenvace,nombreenva,cantidad[0]+".00",] 
               _createtable(datos);
               autocompletarproducto();
               $("#txtenvaces").val('');
               $("#txtcodenvace").val('');
               $("#txtstock").val('');$("#txtcantidad").val('');
            }else{
                Mensaje1(e,"error");
            }   
            $('.ajax-loader').css("visibility", "hidden"); 
        },complete: function(){
            $('.ajax-loader').css("visibility", "hidden");
        }
    }); 
}

function devolderStock(codenvace,cantidad,data) {
    $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  'c_movimientoenvace.php',
        data : {
            "accion" : "devolver",
            "codenvace" : codenvace,
            "cantidad" : cantidad,
        },beforeSend: function () {
            $('.ajax-loader').css("visibility", "visible");
        },success:  function(e){
           if(e == 1){
                tempo = []
                localStorage.removeItem('productos');
                $(data).closest('tr').remove();
                var filas = $("#tbdenvaces  tr");
                for (let i = 0; i < filas.length; i++) {
                    tempo[i] =  [$(filas[i]).find("td")[0].innerHTML
                                    ,$(filas[i]).find("td")[1].innerHTML,
                                    $(filas[i]).find("td")[2].innerHTML]
                }
                miStorage.setItem("productos", JSON.stringify(tempo));
                $("#txtenvaces").val('');
                $("#txtcodenvace").val('');
                $("#txtstock").val('');$("#txtcantidad").val('');
                Mensaje1("Se devolvio el producto","success");
               autocompletarproducto();
            }else{
                Mensaje1(e,"error");
            }    
            $('.ajax-loader').css("visibility", "hidden");
        },complete: function(){
            $('.ajax-loader').css("visibility", "hidden");
        }
    });   
}

function datosrepetidos(tabla) {
    filas = $("#"+tabla+" tr");
    for (let l = 0; l < filas.length; l++) {
        if($(filas[l]).find("td")[0].innerHTML == $("#txtcodenvace").val()){
            return 1;
        }
    }
    return 0;
}

function guardarcliente() {
    var datosclie = $("#frmclientemolde").serialize();
    $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  'c_movimientoenvace.php',
        data:datosclie+"&accion=gcliente&usu="+usu,
        success:  function(r){
            console.log(r);
            r = JSON.parse(r)
            if(r[1] == 1){
                $("#txtcliente").val($("#txtnombcliente").val())
                Mensaje1("Se registraron los datos correctamente","success");
                document.getElementById('frmclientemolde').reset();
                autocompletarcliente()
                $("#txtcodclie").val(r[0]);
                $("#mdclientemolde").modal("hide")
            }else{
                Mensaje1(r[1],"error");
            }
        }
    });       
}