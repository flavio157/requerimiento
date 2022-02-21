$(document).ready(function () {
    mostrarfila();
    $("#btnfiltrar").on('click',function () {
        inicio = $("#txtinicio").val();
        fin = $("#txtfin").val();
        filtrar(inicio,fin);
    });
});

function filtrar(inicio,fin) {
    $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  'c_avances.php',
        data:{
            "accion" : 'filtrar',
            "inicion" :inicio ,
            "fin" : fin,
        } ,
        success:  function(response){
            obj = JSON.parse(response);
            createtable(obj["dato"])
        }
      });   
}


function mostrarfila() {
    $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  'c_avances.php',
        data:{
            "accion" : 'produccion',
        } ,
        success:  function(response){
            obj = JSON.parse(response);
            createtable(obj["dato"])
        }
      });   
}

function createtable(obj) {
    b2 ="<a id='btnfinalizar' style='margin-right: 1px;margin-bottom: 1px;' class='btn btn-primary  btn-sm' data-bs-toggle='modal' data-bs-target='#mdregisavances'>"+
        "<i class='icon-check' title='Finalizar Produccion'></i></a>"+
        "<a id='btnavances' style='margin-right: 1px;margin-bottom: 1px;' class='btn btn-primary  btn-sm' data-bs-toggle='modal' data-bs-target='#mdregisavances'>"+
         "<i class='icon-edit' title='Registrar avances'></i></a>"+
         "<a id='btnocurencia' style='margin-right: 1px;margin-bottom: 1px;' class='btn btn-danger  btn-sm' data-bs-toggle='modal' data-bs-target='#mdocurrencia'>"+
         "<i class='icon-warning' title='Registrar Ocurrencias'></i></a>"+
         "<a id='btnmodificar' style='margin-right: 1px;margin-bottom: 1px;' class='btn btn-primary  btn-sm' data-bs-toggle='modal' data-bs-target='#mdmodacregiresidu'>"+
         "<i class='icon-list' title='Modificar residuos'></i></a>";
    $("#tbavances > tbody").empty();
    $.each(obj, function(i, item) {
        cliente = (item[3] == null) ? '' : item[3];
        estado = '';
        estado = (item[10] == '0') ? 'P' : 'T' ;
        var fila='';
        fila +="<td class='tdcontent' style=display:none>"+item[0]+"</td>";
        fila +="<td >"+item[2]+"</td>";
        fila +="<td >"+item[9]+"</td>";
        fila +="<td style=display:none>"+item[6]+"</td>";
        fila +="<td >"+estado+"</td>";
        /*fila +="<td class='tdcontent'>"+b2+"</td>";*/
        var btn = document.createElement("TR");
        btn.innerHTML=fila;
        document.getElementById("tbdavances").appendChild(btn);
    });
}