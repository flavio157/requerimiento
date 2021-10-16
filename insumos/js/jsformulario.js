//archivo modificado js

var prod = "";
var ingreso = "";
var insu="";
$(document).ready(function(){
    $("#btnfiltrar").on('click',function (params) {
        $('#tbinsumo').find("tr:gt(0)").remove();
        insumos($("#fech_ini").val(),$("#fech_fin").val());
        //envaces($("#fech_ini").val(),$("#fech_fin").val());
    });
});

function insumos(fech_ini,fech_fin){
    $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  '../insumos/c_insumoventas.php',
        data: {
            'accion':'filtro',
            'fech_ini':fech_ini,
            'fech_fin':fech_fin
        },
        success: function(response){
            obj = JSON.parse(response);
            $.each(obj['insumo'] ,function name(i,e) {
                    total = Number(e['ingreso'] - e['salida']);
                __ins(e['id'],e['nombre'],Number(e['salida']).toFixed(3),Number(e['ingreso']).toFixed(3),total.toFixed(3))
            });
        }
    });
}

/*
function envaces(fech_ini,fech_fin){
    $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  '../insumos/c_insumoventas.php',
        data: {
            'accion':'envaces',
            'fech_ini':fech_ini,
            'fech_fin':fech_fin
        },
        success: function(response){
           console.log(response);
            obj = JSON.parse(response);
            $.each(obj['envases'] ,function name(i,e) {
                var total
                 total = Number(e['ingreso'] - e['salida'])
                __ins(e['id'],e['nombre'],e['salida'],e['ingreso'],total.toFixed(2))
            });
        }
    });
}*/

function __ins(cod_prod,nombre,salida,entrada,total) {
    var fila="<tr><td class='tdproducto' style='display: none;'>"+cod_prod+
    "</td><td>"+nombre+ "</td><td>"+salida+
    "</td><td>"+entrada+"</td>"+
    "<td>"+total+"</td></tr>";
    var btn = document.createElement("TR");
    btn.innerHTML=fila;
    document.getElementById("tdinsumo").appendChild(btn);
}
