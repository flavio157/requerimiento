var sugepersonal = [];
var sugetarea = [];
var usu;
$(document).ready(function() {
    usu = $("#vrcodpersonal").val();
    buscarpersonal();
    autocompletarea();

    $('#btnnuevo').on('click',function() {
        limpiar();
    })
    
    $("#aentrega").on('click',function() {
        sre = $("#txtseriematerial").val();
        filas = $("#tdmaterialentrega  tr");
            for (let l = 0; l <filas.length ; l++) {
                if($(filas[l]).find("td")[2].innerHTML != ""){
                    if($(filas[l]).find("td")[2].innerHTML.replace('-', '') == sre.toUpperCase().trim().replace('-', '').replace(' ', '')){
                        Mensaje1("Nro de serie ya registrado",'error');
                        return;    
                    }
                }
            }
    });
    
    $(document).on('click','#btneliminar',function() {
        cod = $(this).parents('tr').find('td:first-child').text();
        cant = $(this).parents('tr').find('td:nth-child(4)').text();
        $(this).closest('tr').remove();
    });

    $(document).on('hide.bs.modal', '.modal', function () {
        $("#txtpersonal").val('');
    });

    $("#btngtarea").on('click',function () {
        gtareascreada($("#txtnombretarea").val(),$("#slctipotarea").val());
    })

    $("#btnapersonal").on('click',function(){
        $("#txtcodigoper").val($("#txtcodpersonal").val());
        $("#txtnombrepersonal").val($("#txtpersonal").val());
        _herramientas($("#txtcodpersonal").val())
    })

    $("#txtpersonal").autocomplete({
        source: sugepersonal,
          select: function (event, ui) {
            $("#txtcodpersonal").val(ui.item.code);
          }
    });

    $("#btnguardacab").on('click',function() {
        _guardar();
    });

    $("#btnagregartareas").on('click',function() {
        gitemstareas($("#txtcodtare").val(),$("#txtcabtarea").val(),$("#$thinicio").val(),
        $("#thfin").val(),$("#dtinicio").val(),$("#dtfin").val())
    })
});

function buscartarea() {
    $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  'c_tareas.php',
        data:{
            "accion" : 'sugtarea',
        } ,
        success:  function(response){
            obj = JSON.parse(response);
            $.each(obj['dato'], function(i, item) {
                sugetarea.push(item); 
            });
        }
    }); 
}

function autocompletarea(){
    buscartarea();
    $("#txnomtareas").autocomplete({
      source: sugetarea,
        select: function (event, ui) {
          $("#txtcodtare").val(ui.item.code);
        }
    });
}


function buscarpersonal() {
    $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  'c_tareas.php',
        data:{
            "accion" : 'personal',
        } ,
        success:  function(response){
            obj = JSON.parse(response);
            $.each(obj['dato'], function(i, item) {
                sugepersonal.push(item); 
            });
        }
    });   
}






function _createtable(td,idtbttabla) {
    var fila="<tr>";
    for (let i = 0; i < td.length; i++) {
        fila +="<td  style=display:"+td[i][1]+">"+td[i][0]+"</td>";
    }
    fila += "</tr>";
    var btn = document.createElement("TR");
    btn.innerHTML=fila;
    document.getElementById(idtbttabla).appendChild(btn);
}

function _guardar() {
    var codperson = $("#txtcodigoper").val();
    var dtincio = $("#dtinicio").val();
    var dtfin = $("#dtfin").val();
    var reprogramar = ($("#chreporgrama").is(':checked')) ? '1':'0'; 
    $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  'c_tareas.php',
        data:{
            "accion" : 'gcabecera',
            "codperson" : codperson,
            "dtincio" : dtincio,
            "dtfin" :dtfin,
            "reprogramar" : reprogramar,
            "usu":usu
            } ,
            success:function(e){
                console.log(e);
                obj = JSON.parse(e);
                if(obj['c'] != true) Mensaje1(obj['c'].trim(),"error");
                else {
                    $("#txtcabtarea").val(obj['e']);
                }
            }
        });
}

function limpiar() {
    $('#tbmaterialentrega').find("tr:gt(0)").remove();
    $('#tbmaterialsalida').find("tr:gt(0)").remove();
    document.getElementById("frmmatsalida").reset();
}


function Mensaje1(texto,icono){
 Swal.fire({icon: icono,title: texto,});
}

function gtareascreada(nomtarea,slctipotarea) {
    $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  'c_tareas.php',
        data:{
            "accion" : 'gnuevatarea',"nomtarea" : nomtarea,
            "slctipotarea" : slctipotarea,"usu" :usu,
        },
        success:function(r){
            obj = JSON.parse(r);
            if(obj['c'] != true) Mensaje1(obj['c'].trim(),"error");
            else {Mensaje1("Se registro la nueva tarea","success"); 
            $("#txnomtareas").val(nomtarea);
            $("#txtcodtare").val(obj['e']);
            $("#mdagregartarea").modal("hide");
            document.getElementById("frmtarea").reset();}
        }
    });
}

function _herramientas($campo) {
    $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  'c_tareas.php',
        data:{
            "accion" : 'sindevolver',
            "dato" : $campo,
        } ,
        success:  function(response){
            obj = JSON.parse(response);
            var btn = "<div class='form-check'><input class='form-check-input' type='checkbox' value='' id='chckherramienta'>"+
            "</div>";
            $.each(obj['dato'], function(i, item) {
                var fila="<tr><td style='display: none;'>"+obj['dato'][i][2]+
                "</td><td>"+obj['dato'][i][4]+ "</td>"+
                "<td style='padding: .25rem 1.5rem;'>"+btn+"</td></tr>";
                var elem = document.createElement("TR");
                elem.innerHTML=fila;
                document.getElementById("tbdherramienta").appendChild(elem);
            });
            $.each(obj['dxd'], function(i, item) {
                var fila="<tr><td style='display: none;'>"+obj['dxd'][i][3]+
                "</td><td>"+obj['dxd'][i][4]+"</td>"+
                "<td style='padding: .25rem 1.5rem;'>"+btn+"</td></tr>";
                var elem = document.createElement("TR");
                elem.innerHTML=fila;
                document.getElementById("tbdherramienta").appendChild(elem);  
            }); 
        }
    });    
    $("#mdpersonal").modal("hide");
    $('#tbherramienta').find("tr:gt(0)").remove();
}


function gitemstareas(codtarea,codtareprograma,horini,horfin,dtincio,dtfin) {
    $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  'c_tareas.php',
        data:{
            "accion" : 'gitemtarea',
            "codtarea" : codtarea,
            "codtareaprogramada" : codtareprograma,
            "horinicio" :horini,
            "horfin" : horfin,
            "dtincio" : dtincio,
            "dtfin" :dtfin,
            "usu":usu
            } ,
            success:function(e){
                obj = JSON.parse(e);
                if(obj['c'] != true) Mensaje1(obj['c'].trim(),"error");
                else {
                    $("#txtcabtarea").val(obj['e']);
                }
            }
    });
}
