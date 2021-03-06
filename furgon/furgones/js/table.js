var radion = 0;
var data = "";
$(document).ready(function() {

//lstvercomet();
$("#txtcomentarioactua").attr("disabled","true") 

document.querySelector('#rdoficinas').checked = true;

 $("#btnfiltrar").on('click',function(){
    fechaini = $("#iniciodtfecha").val();
    if(fechaini == ''){Mensaje1("Ingrese fecha inicio","error"); return;};
    if(radion == 0){
        lstfurgon(fechaini);
    }else if(radion == 1){
        fechafin = $("#findtfecha").val();
        if(fechafin == ''){Mensaje1("Ingrese fecha fin","error"); return;};
        if($("#selectofi").val() == ''){Mensaje1("Ingrese oficina","error"); return;}
        lstvenfurgon(fechaini,fechafin,$("#selectofi").val());
    }   
 });

$("input[id=rdvendedor]").change(function () {	 
    fech =  "<div class='col-auto' id='divfechfin'>"+
                "<div class='input-group input-group mb-3'  style='margin-bottom: 0px !important;'>"+
                    "<span class='input-group-text' id='inputGroup-sizing-default'>F. Fin &nbsp&nbsp&nbsp</span>"+
                    "<input type='date' class='form-control' id='findtfecha' aria-label='Sizing example input' aria-describedby='inputGroup-sizing-sm'>"+
                "</div>"+
            "</div>";
    selec = "<div class='col-auto' id='divselect'>"+
                "<div class='input-group input-group mb-3' style='margin-bottom: 0px !important;'>"+
                "<span class='input-group-text' id='inputGroup-sizing-default'>Oficina &nbsp</span>"+
                "<select class='form-select' id='selectofi' aria-label=''>"+
                    "<option value='' selected >Oficina</option>"+
                    "<option value='SMP'>SMP</option>"+
                    "<option value='SMP3'>SMP3</option>"+
                    "<option value='SMP4'>SMP4</option>"+
                    "<option value='SMP5'>SMP5</option>"+
                    "<option value='SMP6'>SMP6</option>"+
                    "<option value='SMP7'>SMP7</option>"+
                    "<option value='SMP8'>SMP8</option>"+
                    "<option value='SMP9'>SMP9</option>"+
                    "<option value='SMP10'>SMP10</option>"+
                "</select>"+
            "</div>"+
            "</div>";
    $("#divfechini").after(fech);
    $("#divfechfin").after(selec);

    
    $('#tbprincipal').find("tr").remove();
    radion = 1;
    $("#iniciodtfecha").val('');
    $("#findtfecha").val();
    document.getElementById("divcomentario").remove();
});

$("input[id=rdoficinas]").change(function () {	 
    document.getElementById("divfechfin").remove();
    document.getElementById("divselect").remove();
    reiniciar();
 
    $('#tbprincipal').find("tr").remove();
    radion = 0;
    $("#iniciodtfecha").val('');
    $("#findtfecha").val();
    divcomen = "<div class='row' id='divcomentario'>"+
                    "<div class='col g-4'>"+
                        "<button  type='button' id='btnmodalcomen' class='btn btn-primary mb-2'  style='float: right;'>"+
                        "<i class='icon-save' title='Guardar datos'></i>Comentario</button>"+
                    "</div>"+
                "</div>";
    $("#divtabla").after(divcomen);
});

$("#btnguarcomentario").on('click',function () {
    fecha = $("#iniciodtfecha").val();
    g_comentario($("#txtcomentario").val(),$("#vrcodpersonal").val(),fecha);
});

$(document).on('click','#btnmodalcomen',function (params) {
    if($("#iniciodtfecha").val() == ""){Mensaje1("Seleccione fecha", "error");return;}
 
    lstcomentario($("#iniciodtfecha").val());
})


$('#btnactuestadocom').on('click',function () {
    $("#txtcomentarioactua").val('');
})

$("#iniciodtfecha").change(function (params) {
    $('#tbprincipal').find("tr").remove();
});

});

function lstvenfurgon(fecini,fecfin,select) {
    $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  'c_furgon.php',
        data:{
            "accion" : 'vendedor',
            "fechini" : fecini,
            "fechfin" : fecfin,
            "select" : select  
        } ,
        success:  function(response){
            obj = JSON.parse(response);
            var arr = [];
           $.each(obj['json'], function(i, f) {
            var items = {};
                items[0] = '';
                items[1] = sindato(f[1]);
                items[2] = f[2];
                arr.push(items);
            });
            var dataSet = arr;
           data = $("#tbcabecera").DataTable({
                "order": [[2,'desc']],
                destroy: true,
                "paging": true,
                "data": dataSet,
                "searching": false,
                "bLengthChange": false,
                "bFilter": false,
                "bInfo": false,
                "ordering": true,
                language: {
                    "paginate": {
                        "first": "Primero",
                        "last": "Ultimo",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    }
                }    
            });
        }
    });    
}


function lstfurgon(fecha){
    $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  'c_furgon.php',
        data:{
            "accion" : 'furgon',
            "fecha" : fecha 
        } ,
        success:  function(response){
          obj = JSON.parse(response);
          $('#tbprincipal').find("tr:gt(0)").remove();
         
          tablacompleja(obj['furgon'],obj['agrupado']);
        }
    });   
}


/**funcion para crear la tabla */
//si cambia el id "tbprincipal" debe cambiar tambien el id al final de esta funcion
function tablacompleja(furgon,agrupado) {
    var tabla ="";
    var c = "";
    $.each(agrupado, function(i, f) {
            total = (f[1] == null) ? 0 : f[1];
            tabla +="<tr data-bs-toggle='collapse' data-bs-target=#"+f[0]+"  class='accordion-toggle collapsed' aria-expanded='false'>"+
                        "<td><button class='btn btn-default btn-xs icon' id=#"+f[0]+"></button></td>"+
                        "<td>"+f[0]+"</td>"+
                        "<td>"+total+"</td>"+
                    "</tr>";
             $.each(furgon,function(e,a){
                 //0                 //0
                if(a[0] != null && a[0].trim() == f[0].trim()){
                     c = "<tr>"+
                            "<td colspan='12' class='hiddenRow'>"+
                                "<div class='accordian-body collapse' id="+a[0]+" aria-expanded='false' style='height: 0px;'>"+
                                    "<table class='table' style='margin-bottom: 0px;'>"+ 
                                        "<tbody>"+
                                            "<tr data-bs-toggle='collapse' class='accordion-toggle collapsed' data-bs-target=#"+a[1]+" aria-expanded='false'>"+
                                                "<td><center><button class='btn btn-default btn-xs icon2'></button></center></td>"+
                                                "<td> PLACA:</td>"+
                                                "<td> "+a[1]+"</td>"+
                                            "</tr>"+

                                            "<tr>"+
                                                "<td colspan='12' class='hiddenRow'>"+
                                                     "<div class='accordian-body collapse' id="+a[1]+" aria-expanded='false' style='height: 0px;'>"+ 
                                                        "<table class='table' style='margin-bottom: 0px;'>"+
                                                            "<tbody>"+
                                                                "<tr>"+
                                                                    "<td>"+sindato(a[4])+"</td>"+
                                                                    "<td>"+sinvalors(a[5])+"</td>"+
                                                                "</tr>"+
                                                                "<tr>"+
                                                                    "<td>"+sindato(a[7])+"</td>"+
                                                                    "<td>"+sinvalors(a[8])+"</td>"+
                                                                "</tr>"+
                                                                "<tr>"+
                                                                    "<td>"+sindato(a[10])+"</td>"+
                                                                    "<td>"+sinvalors(a[11])+"</td>"+
                                                                "</tr>"+
                                                                "<tr>"+
                                                                    "<td>"+sindato(a[13])+"</td>"+
                                                                    "<td>"+sinvalors(a[14])+"</td>"+
                                                                "</tr>"+
                                                                "<tr>"+
                                                                    "<td>"+sindato(a[16])+"</td>"+
                                                                    "<td>"+sinvalors(a[17])+"</td>"+
                                                                "</tr>"+
                                                            "</tbody>"+
                                                        "</table>"+
                                                    "</div>"+	 
                                                "</td>"+
                                            "</tr>"+
                                        "</tbody>"+
                                    "</table>"+
                                "</div>"+
                            "</td>"+
                        "</tr>"; 
                        tabla +=c; 
                }
            });   
    });
 $('#tbprincipal').html(tabla);
}

function sindato(valor) {
    if(valor == null){
        dato = 'SIN DATO';
    }else if( valor == ''){
        dato = 'SIN NOMBRE ASIGNADO'
    }else{
        dato = valor;
    }
    return dato;
}

function sinvalors(valor) {
    emp = (valor == null) ? 0:valor;
    return emp;
}

function reiniciar() {
    $("#tbcabecera").DataTable({
        destroy: true,
        "paging": false,
        "searching": false,
        "bLengthChange": false,
        "bFilter": false,
        "bInfo": false,
        "ordering": false
    });

   
}

function Mensaje1(texto,icono){
    Swal.fire({
     icon: icono,
     title: texto,
     //padding:'1rem',
     //grow:'fullscreen',
     //backdrop: false,
     //toast:true,
     //position:'top'	
     });
}

function g_comentario(comentario,usuario,fecha) {
    $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  'c_furgon.php',
        data:{
            "accion" : 'guardar',
            "comen" : comentario,
            "usuario" : usuario,
            "fecha" : fecha
        } ,
        success:  function(response){
            if(response == 1){ 
                Mensaje1("Se guardo el registro","success");
                //$("#txtcomentario").val('');
                $("#txtcomentario").attr("disabled","true")  
            }else{
                Mensaje1(response,"error")
            };
        }
    });   
}

function lstcomentario(fecha) {
    $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  'c_furgon.php',
        data:{
            "accion" : 'lstcomentario',
            "fecha" : fecha
        } ,
        success:  function(response){
            obj = JSON.parse(response);
            if(obj['dato'][0] != undefined){
                 $("#txtcomentario").val(obj['dato'][0][1]);
                 $("#txtcomentario").attr("disabled","true");
                 $("#btnguarcomentario").attr("disabled","true");
            }else{
                $("#txtcomentario").removeAttr("disabled");
                $("#btnguarcomentario").removeAttr("disabled");
                $("#txtcomentario").val('');
               
            } 
            $("#modalcomentario").modal("show");
            
        }
    });   
}

