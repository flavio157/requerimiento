var radion = 0;
var data = "";
$(document).ready(function() {

document.querySelector('#rdoficinas').checked = true;

 $("#btnfiltrar").on('click',function(){
    fechaini = $("#iniciodtfecha").val();
    if(fechaini == ''){Mensaje1("Ingrese fecha inicio","error"); return;};
    if(radion == 0){
        lstfurgon(fechaini);
    }else if(radion == 1){
        fechafin = $("#findtfecha").val();
        if(fechafin == ''){Mensaje1("Ingrese fecha fin","error"); return;};
        lstvenfurgon(fechaini,fechafin);
    }   
 });

$("input[id=rdvendedor]").change(function () {	 
    html =  "<div class='col-auto' id='divfechfin'>"+
                "<div class='input-group input-group mb-3'  style='margin-bottom: 0px !important;'>"+
                    "<span class='input-group-text' id='inputGroup-sizing-default'>F. Fin &nbsp&nbsp&nbsp</span>"+
                    "<input type='date' class='form-control' id='findtfecha' aria-label='Sizing example input' aria-describedby='inputGroup-sizing-sm'>"+
                "</div>"+
            "</div>";
  //  reiniciar();
    $("#divfechini").after(html);
    /*if($("#tbprincipal tr").length > 1){
        data
        .clear()
        .draw();
    };*/
    $('#tbprincipal').find("tr").remove();
    radion = 1;
    $("#iniciodtfecha").val('');
    $("#findtfecha").val();
   
   
});

$("input[id=rdoficinas]").change(function () {	 
    document.getElementById("divfechfin").remove();
    reiniciar();
   /* if($("#tbprincipal tr").length > 1){
        console.log($("#tbprincipal tr").length);
        data
        .clear()
        .draw();
    };*/
    $('#tbprincipal').find("tr").remove();
    radion = 0;
    $("#iniciodtfecha").val('');
    $("#findtfecha").val();
    
});

});

function lstvenfurgon(fecini,fecfin) {
    $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  'c_furgon.php',
        data:{
            "accion" : 'vendedor',
            "fechini" : fecini,
            "fechfin" : fecfin  
        } ,
        success:  function(response){
            obj = JSON.parse(response);
            var arr = [];
           $.each(obj['json'], function(i, f) {
            var items = {};
                items[0] = '';
                items[1] = f[1];
                items[2] = f[2];
                arr.push(items);
            });
            var dataSet = arr;
           data = $("#tbcabecera").DataTable({
                destroy: true,
                "paging": true,
                "data": dataSet,
                "searching": false,
                "bLengthChange": false,
                "bFilter": false,
                "bInfo": false,
                "ordering": false,
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
                if(a[3] != null && a[3].trim() == f[0].trim()){
                     c = "<tr>"+
                            "<td colspan='12' class='hiddenRow'>"+
                                "<div class='accordian-body collapse' id="+a[3]+" aria-expanded='false' style='height: 0px;'>"+
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
                                                                    "<td>"+a[5]+"</td>"+
                                                                    "<td>"+a[6]+"</td>"+
                                                                "</tr>"+
                                                                "<tr>"+
                                                                    "<td>"+a[8]+"</td>"+
                                                                    "<td>"+a[9]+"</td>"+
                                                                "</tr>"+
                                                                "<tr>"+
                                                                    "<td>"+a[11]+"</td>"+
                                                                    "<td>"+a[12]+"</td>"+
                                                                "</tr>"+
                                                                "<tr>"+
                                                                    "<td>"+a[14]+"</td>"+
                                                                    "<td>"+a[15]+"</td>"+
                                                                "</tr>"+
                                                                "<tr>"+
                                                                    "<td>"+a[17]+"</td>"+
                                                                    "<td>"+a[18]+"</td>"+
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

/* function tablanormal(idtbttabla ,fila) {
       var  fila ="<tr><td></td>"+
                    "<td>"+f[1]+"</td>"+
                    "<td>"+f[2]+"</td></tr>";
                    tablanormal("tbprincipal" ,fila);   
    var btn = document.createElement("TR");
    btn.innerHTML=fila;
    document.getElementById(idtbttabla).appendChild(btn);   
}*/ 


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

