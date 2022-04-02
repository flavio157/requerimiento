var sugepersonal = [];
var sugematerial = [];
var clase = '';
var i = null; /// AQUI
var c = 0;
var usu;
$(document).ready(function() {
     usu = $("#vrcodpersonal").val();
    c = document.getElementsByClassName("menupadre").length;
    buscarpersonal();
    $("#txtpersonal").autocomplete({
      source: sugepersonal,
        select: function (event, ui) {
          $("#txtcodpersonal").val(ui.item.code);
        }
    });
    autocompletarMaterial();
  

    $(window).on("beforeunload", function() { 
      retornar();
    })
    $('#btnnuevo').on('click',function(params) {
        retornar()
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
        _stock($("#txtcodmaterial").val(),$("#vroficina").val());
        $("#txtcanmaterial").val('');
    });
    
    $("html").click(function(){
        $('#personal').fadeOut(0);
        $('#material').fadeOut(0); 
    });

    $("#btnAddpersonal").on('click',function () {
        if($("#txtcodpersonal").val() != '' && $("#txtpersonal").val() != ''){
            $("#txtnombrepersonal").val($("#txtpersonal").val());
            $("#txtcodigoper").val($("#txtcodpersonal").val());
            $('#tbmaterialsalida').find("tr:gt(0)").remove();
            _sindevolver($("#txtcodpersonal").val());
            $("#mdpersonal").modal('hide');
        }
    });

    $(document).on('click','#btneliminar',function() {
        cod = $(this).parents('tr').find('td:first-child').text();
        cant = $(this).parents('tr').find('td:nth-child(4)').text();
        $("#txtmaterial").val('');
        $("#txtstckmaterial").val('');
        _devolverStock(cod,cant,'1');
        $(this).closest('tr').remove();
    });

    $(document).on('click','#btnmodificar',function() {
        cod = $(this).parents('tr').find('td:first-child').text();
              $("#txtcodmaterial").val($(this).parents('tr').find('td:first-child').text());
              $("#txtmaterial").val($(this).parents('tr').find('td:nth-child(2)').text());
              $("#txtseriematerial").val($(this).parents('tr').find('td:nth-child(3)').text());
              $("#txtcanmaterial").val($(this).parents('tr').find('td:nth-child(4)').text());
       cant = $(this).parents('tr').find('td:nth-child(4)').text();
      
       _devolverStock(cod,cant,'');
       $(this).closest('tr').remove();
    });

    $(document).on('click','#btnupdatemat',function() {
        $("#txtmodnombpro").val($(this).closest('tr').find("td:nth-child(2)").text());
        $("#txtmodcodpro").val($(this).closest('tr').find("td:nth-child(1)").text());
        $("#txtmodcanpro").val($(this).closest('tr').find("td:nth-child(4)").text());
        $("#txtmodserie").val($(this).closest('tr').find("td:nth-child(3)").text())
        $("#txtmodtipo").val($(this).closest('tr').find("td:nth-child(7)").text());
        $("#codmatxdia").val($(this).closest('tr').find("td:nth-child(8)").text());
        $("#txtmodsalida").val($(this).closest('tr').find("td:nth-child(9)").text());
        $("#txtmodadescr").val('');
    });

    $("#btnguardar").on('click',function () {
        var td =  $("#tdmaterialentrega  tr");
        var tds = [];
        var dxd = [];
        for (let l = 0; l < td.length; l++) {
                tds[l] =[
                    $(td[l]).find("td")[0].innerHTML,
                    $(td[l]).find("td")[2].innerHTML,
                    $(td[l]).find("td")[3].innerHTML,
                    $(td[l]).find("td")[4].innerHTML
                ]
        }

        for (let i = 0; i < td.length; i++) {
            if($(td[i]).find("td")[4].innerHTML == '00004' || $(td[i]).find("td")[4].innerHTML == '00005'){
                dxd[i]=[
                    $(td[i]).find("td")[0].innerHTML,
                    $(td[i]).find("td")[2].innerHTML,
                    $(td[i]).find("td")[3].innerHTML,
                    $(td[i]).find("td")[4].innerHTML 
                ] 
            }
        }
        _guardar(tds,dxd);
    })

    $("#txtcanmaterial").bind('keypress', function(e) {
        return _numeros(e);
    });

    $("#txtdescripcion").keyup(function(e) {
        var input=  document.getElementById('txtdescripcion');
            input.addEventListener('input',function(){
                this.value = this.value.slice(0,500); 
        })
    })

    $("#modbtnguardar").on('click',function() {
       motivo = $("#modslcmotivo").val();
        if(motivo == 'R' || motivo == 'D'){
            _devolucion($("#txtmodcodpro").val(),$("#txtmodserie").val(),$("#txtmodtipo").val(),
            $("#codmatxdia").val(),$("#txtmodsalida").val(),$("#txtmodcanpro").val(),$("#txtmodadescr").val(),motivo);
        }
        if(motivo == 'P' || motivo == 'M'){
            reportarMaterial($("#txtcodigoper").val(),$("#txtmodcodpro").val(),$("#txtmodcanpro").val(),
            $("#txtmodadescr").val(),$("#txtmodsalida").val(),$("#codmatxdia").val(),$("#txtmodtipo").val(),motivo
            ,$("#txtmodserie").val())
        }
        
    })

    $("#modslcmotivo").change(function (params) {
        if($(this).val() != 'D')$("#txtmodadescr").removeAttr('disabled');
        else $("#txtmodadescr").attr('disabled','disabled');
        $("#txtmodadescr").val('');
    })

    $("#btnreingreso").on('click',function(){
        if($("#txtcodigoper").val().length > 0){
            document.getElementById('frmreingreso').reset();
            lstperdidos($("#txtcodigoper").val());
            $("#modalreingreso").modal('show');
        }else{
            Mensaje1("Error seleccione personal","error");
        }
        
    });

    $(document).on('click','#btnburperdido',function(){
        $("#txtreincodmat").val($(this).closest('tr').find("td:nth-child(2)").text());
        $("#txtreinmater").val($(this).closest('tr').find("td:nth-child(3)").text());
        $("#txtreincanper").val($(this).closest('tr').find("td:nth-child(4)").text());
        $("#txtreinserper").val($(this).closest('tr').find("td:nth-child(6)").text());
        $("#txtreinsalida").val($(this).closest('tr').find("td:nth-child(5)").text());
        $("#txtreintipo").val($(this).closest('tr').find("td:nth-child(7)").text())
        if($(this).closest('tr').find("td:nth-child(6)").text().trim().length == 0)
            $("#txtreinserie").attr('disabled','disabled')
        else $("#txtreinserie").removeAttr('disabled');
    });

    $("#btngreingreso").on('click',function(){
        mater = $('#txtreincodmat').val(); 
        salida = $('#txtreinsalida').val();
        cantida =  $('#txtreingcant').val(); 
        serie = $('#txtreinserie').val();
        observa=  $('#txtreinobservaion').val();
        tipo = $('#txtreintipo').val();
        serieperd = $('#txtreinserper').val();
        g_reingreso(mater,salida,cantida,serie,observa,tipo,serieperd);
    });

});

function _devolverStock(cod,cant,l) {
    almacen = $("#vroficina").val();
    $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  'c_materialesalida.php',
        data:{
            "accion" : 'destock',
            "cdmaterial" : cod,
            "almacen" : almacen,
            "cantidad" : cant,
        } ,
        success:  function(response){
            v = response.split("/");
            if(l == ""){
                if(v[1] == 0){
                    $("#txtseriematerial").removeAttr('disabled');
                    $("#txtcanmaterial").attr('disabled','true');  
                }else{
                    $("#txtcanmaterial").removeAttr('disabled');
                    $("#txtseriematerial").attr('disabled','true');  
                }
                $("#txtstckmaterial").val(Number(v[0]).toFixed(2));
            }
            autocompletarMaterial();
        }
    }); 
}


function _sindevolver($campo) {
    $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  'c_materialesalida.php',
        data:{
            "accion" : 'sindevolver',
            "dato" : $campo,
        } ,
        success:  function(response){
           var count = 0;
           var serie = '';
            obj = JSON.parse(response);
            var btn = "<a id='btnupdatemat' class='btn btn-primary btn-sm btnsin' data-bs-toggle='modal' data-bs-target='#modalrepor'>"+
                        "<i class='icon-new-message'></i>"+
                      "</a>";
                    
            $.each(obj['dato'], function(i, item) {
                
                if(obj['dato'][i][7] == '00003')
                {serie = ''}else{serie = obj['dato'][i][3]}
                    var fila="<tr><td style='display: none;'>"+obj['dato'][i][2]+
                    "</td><td>"+obj['dato'][i][4]+ "</td><td>"+serie+
                    "</td><td>"+obj['dato'][i][6]+ "</td>"+
                    "<td style='padding: .25rem 1.5rem;'>"+btn+"</td>"+
                    "<td style='display: none;'>"+obj['dato'][i][3]+
                    "</td><td style='display: none;'>"+obj['dato'][i][7]+"</td>"+
                    "<td style='display: none;'>"+''+"</td>"+
                    "<td style='display: none;'>"+obj['dato'][i][8]+"</td></tr>";
                    var elem = document.createElement("TR");
                    elem.innerHTML=fila;
                    document.getElementById("tbmaterial").appendChild(elem);
            });
                $.each(obj['dxd'], function(i, item) {
                        var fila="<tr><td style='display: none;'>"+obj['dxd'][i][8]+
                        "</td><td>"+obj['dxd'][i][4]+ "</td><td>"+obj['dxd'][i][10]+
                        "</td><td>"+obj['dxd'][i][5]+ "</td>"+
                        "<td style='padding: .25rem 1.5rem;'>"+btn+"</td>"+
                        "<td style='display: none;'>"+''+
                        "</td><td style='display: none;'>"+obj['dxd'][i][7]+"</td>"+
                        "<td style='display: none;'>"+obj['dxd'][i][3]+"</td>"+
                        "<td style='display: none;'>"+obj['dxd'][i][9]+"</td></tr>";
                        var elem = document.createElement("TR");
                        elem.innerHTML=fila;
                        document.getElementById("tbmaterial").appendChild(elem);  
                        fech1 = obj['dxd'][0][2].split(' ');
                        fech1 = fech1[0].replaceAll('-','/');
                        var fecha = new Date();
                        var diadelevento = new Date(fech1);
                        if (fecha.toLocaleDateString() > diadelevento.toLocaleDateString()) {
                            count++;
                        }
                });
                if(count == 0){
                    for (let i = 1; i < c ; i++) {
                        document.getElementById(i).onclick = function(){return true}; 
                    }
                }
           
            
        }
    });    
}

$(document).on('hide.bs.modal', '.modal', function () {
    $("#txtpersonal").val('');
});

function _stock(cdmaterial,almacen) {
   cantidad = $("#txtcanmaterial").val();
   serie = $("#txtseriematerial").val();
   nommaterial = $("#txtmaterial").val();
   codper = $("#txtcodigoper").val();
    $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  'c_materialesalida.php',
        data:{
            "accion" : 'stock',
            "codper" : codper,
            "cdmaterial" : cdmaterial,
            "almacen" : almacen,
            "cantidad" : cantidad,
            "serie" : serie,
            "material" : nommaterial
        } ,
        success:  function(response){
            if(response == 3){lstmaterialxdia(); return;}
            v = response.split("/");
            c = 0;
            if(v[2] == 2){
                c = datosrepetidos("tdmaterialentrega",v[3],v[1]);
            }
            if(c != 1){
                if(v[0] > 0.00) _entrega(v[3],v[1]);
                else
                Mensaje1(v[0],'error');  
            }
            autocompletarMaterial();
        }
    });  
}

function datosrepetidos(tabla,stock,cantidad) {
    filas = $("#"+tabla+" tr");
    for (let l = 0; l < filas.length; l++) {
        if($(filas[l]).find("td")[0].innerHTML == $("#txtcodmaterial").val()){
            $(filas[l]).find("td")[3].innerHTML = Number($(filas[l]).find("td")[3].innerHTML) + Number(cantidad);    
            $("#txtseriematerial").val('');
            $("#txtstckmaterial").val(Number(stock).toFixed(2)); 
            return 1;
        }
    }
    return 0;
}


function _entrega(stock,cantidad) {
    b1 = "<a id='btneliminar' class='btn btn-danger  btn-sm' style='margin-bottom: 1px'>"+
        "<i class='icon-trash'></i>"+
        "</a>"+ "<a id='btnmodificar' class='btn btn-primary btn-sm'>"+
            "<i class='icon-pencil'></i>"+
        "</a>" ;
    array = [
        a = [$("#txtcodmaterial").val(),'none'],
        b = [$("#txtmaterial").val().toUpperCase(),''],
        c = [$("#txtseriematerial").val().toUpperCase(),''],
        d = [cantidad,''],
        i = [clase,'none'],
        j = [b1,''],
     ]
  _createtable(array,'tdmaterialentrega');
    $("#txtseriematerial").val('');
    
    $("#txtstckmaterial").val(Number(stock).toFixed(2)); 
}

function buscarpersonal($accion,$campo) {
    var oficina = $("#vroficina").val();
    $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  'c_materialesalida.php',
        data:{
            "accion" : 'personal',
            "almacen" : oficina
        } ,
        success:  function(response){
            obj = JSON.parse(response);
            $.each(obj['dato'], function(i, item) {
                sugepersonal.push(item); 
            });
        }
    });   
}

function buscarmaterial($accion,$campo) {
    sugematerial = [];
    var oficina = $("#vroficina").val();
    $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  'c_materialesalida.php',
        data:{
            "accion" : 'material',
            "almacen" : oficina
        } ,
        success:  function(response){
            obj = JSON.parse(response);
            $.each(obj['dato'], function(i, item) {
                sugematerial.push(item); 
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

function _guardar(tds,dxd) {
    
    var codig = $("#txtcodigoper").val();
    var descripcion = $("#txtdescripcion").val();
    var perregistro = $("#vrcodpersonal").val();
    var materiales = {tds};
    var devolxdia = {dxd};
    $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  'c_materialesalida.php',
        data:{
            "accion" : 'guardar',
            "codigo" : codig,
            "descr" : descripcion,
            "perregistro" :perregistro,
            "items" : JSON.stringify(materiales),
            "dxdia" : JSON.stringify(devolxdia)
            } ,
            success:  function(response){
                if(response == 3){lstmaterialxdia(); return;}
                if(response == 1){
                     Mensaje1("Se registro Correctamente",'success')
                        limpiar();
                        autocompletarMaterial();
                    }else{
                        Mensaje1(response,'error')
                    }
                }
        });
}

function limpiar() {
    $('#tbmaterialentrega').find("tr:gt(0)").remove();
    $('#tbmaterialsalida').find("tr:gt(0)").remove();
    document.getElementById("frmmatsalida").reset();
}

function _devolucion(codigo,serie,tipodato,codmatxdia,salida,cantidad,descripcion,motivo) {
    var usumodifico = $("#vrcodpersonal").val();
    var ofi = $("#vroficina").val();
    var solicito = $("#txtcodigoper").val();
    $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  'c_materialesalida.php',
        data:{
            "accion" : 'update',
            "usumodifico" : usumodifico,
            "codigo" : codigo,
            "serie" : serie,
            "tipodato" : tipodato,
            "codmatxdia":codmatxdia,
            "ofi" : ofi,
            "salida" : salida,
            "cantidad" : cantidad,
            "descripcion":descripcion,
            "solicito" : solicito,
            "motivo":motivo
        },
        success:  function(response){
            if(response == 1){
                Mensaje1("Se registro la devolucion","success");
                $("#modalrepor").modal('hide');
            }else if(response == 2){
                Mensaje1("Se reotorgo el material","success");
                $("#modalrepor").modal('hide');
            }else{
                Mensaje1(response,"error");
            }
            $('#tbmaterialsalida').find("tr:gt(0)").remove();
            _sindevolver($("#txtcodpersonal").val()); 
        }
    });
}

function retornar() {
    filas = $("#tdmaterialentrega  tr");
    for (let l = 0; l <filas.length ; l++) {
        cod = $(filas[l]).find("td")[0].innerHTML;
        can = $(filas[l]).find("td")[3].innerHTML;
        _devolverStock(cod,can,'0');
    }
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

function letras(e) {
    var regex = new RegExp("^[a-zA-Z ]+$");
    var key = String.fromCharCode(!e.charCode ? e.which : e.charCode);
    if (!regex.test(key)) {
      e.preventDefault();
      return false;
    }
};

function _numeros(e) {
    var regex = new RegExp("^[0-9]+$");
    var key = String.fromCharCode(!e.charCode ? e.which : e.charCode);
    if (!regex.test(key)) {
      e.preventDefault();
      return false;
    }
}


function autocompletarMaterial() {
    buscarmaterial();
  
    $("#txtmaterial").autocomplete({
        source: sugematerial,
          select: function (event, ui) {
            $("#txtcodmaterial").val(ui.item.code);
            consultastock(ui.item.code) 
            clase = ui.item.clase;
            
           // $("#txtstckmaterial").val(ui.item.stock);
            if(ui.item.clase == '00001' || ui.item.clase == '00004'){
                $("#txtcanmaterial").attr('disabled','true');
                $("#txtseriematerial").removeAttr('disabled');
            }else{
                $("#txtcanmaterial").removeAttr('disabled');
                $("#txtseriematerial").attr('disabled','true');
            }
          }
    });
}

function consultastock(codpro) {
    $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  'c_materialesalida.php',
        data:{
            "accion" : 'consstock',
            "dato" : codpro
        } ,
        success:  function(response){
            $("#txtstckmaterial").val(response);
        }
    }); 
}

function reportarMaterial(personal,producto,cant,descripcion,codsalida,codmatxdia,tipo,motivo,serie) {
    var usu = $("#vrcodpersonal").val();
    $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  'c_materialesalida.php',
        data:{
            "personal":personal,
            "producto":producto,
            "cant":cant,
            "descripcion":descripcion,
            "codsalida":codsalida,
            "motivo":motivo,
            "usu":usu,
            "codmatxdia" :codmatxdia,
            "tipo" : tipo,
            "serie" : serie,
            "accion" : 'reportar',
        },
        success:  function(r){
            if(r == 1){
                Mensaje1("Se registro el material perdido","success");
                $("#modalrepor").modal('hide');
            }else{
                Mensaje1(r,"error");
            }
            $('#tbmaterialsalida').find("tr:gt(0)").remove();
            _sindevolver($("#txtcodpersonal").val());

        }
    }); 
}


//AQUI sujeta a cambios
function lstmaterialxdia() {
    $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  'c_materialesalida.php',
        data: {
            "accion": "lstmatexdia",
            "oficina":''
        },
        success: function(response){
            var mensaje = '';
            obj = JSON.parse(response);
            if(Object.keys(obj['dato']) != ''){
                $.each(obj['dato'], function(i, f) {
                    nombre = obj['dato'][i][1].split(' ');
                    mensaje +='<tr>'+
                                '<td class="font">'+nombre[0]+'</td>'+
                                '<td class="font">'+obj['dato'][i][5]+'</td>'+
                                '<td class="font">'+obj['dato'][i][4]+'</td>'+
                              '</tr>';
                });
                Mensaje2("Materiales sin devolver \n",'info',mensaje)
            }
        }
    });
}

function Mensaje2(texto,icono,tabla){
    Swal.fire({
     icon: icono,
     title: texto,
     html:  '<div class="table-responsive" style="overflow: scroll;height: 179px;">'+
                '<table class="table table-sm">'+
                    '<thead>'+
                        '<tr>'+
                            '<th class="thtitulo">Nombre</th>'+
                            '<th  class="thtitulo">Cantidad</th>'+
                            '<th  class="thtitulo" style="width: 31%;">Material</th>'+
                        '</tr>'+
                    '</thead>'+
                    '<tbody>'+
                        tabla+
                    '</tbody>'+
                '</table>'+
            '</div>'
     });
}
//AQUI

function lstperdidos(personal){
    $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  'c_materialesalida.php',
        data: {
            "accion": "lstperdidos",
            "personal":personal
        },
        success: function(response){
            $('#tbreingreso').find("tr:gt(0)").remove();
            b1 = "<a id='btnburperdido' class='btn btn-primary  btn-sm' style='margin-bottom: 1px'>"+
                    "<i class='icon-pencil'></i></a>";
            obj = JSON.parse(response);
            $.each(obj['r'], function(i, f) {
                var fila="<tr><td style='display: none;'>"+f[0]+
                "</td><td style='display: none;'>"+f[1]+"</td><td>"+f[2]+
                "</td><td>"+f[3]+"</td>"+
                "<td style='display: none;'>"+f[4]+ "</td>"+
                "<td>"+f[5]+"</td><td style='display: none;'>"+f[6]+"</td><td>"+b1+"</td></tr>";
                var elem = document.createElement("TR");
                elem.innerHTML=fila;
                document.getElementById("tdbreingreso").appendChild(elem);  
            });
           
        }
    });
}

function g_reingreso(mater,salida,cantida,serie,observa,tipo,serieperd){
    oficina = $("#vroficina").val();
    $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  'c_materialesalida.php',
        data:{
            "accion":'greingreso',
            "material":mater, 
            "salida":salida,
            "cantidad":cantida,
            "serie": serie,
            "observacion":observa ,
            "tipo" :tipo,
            "seirper" :serieperd,
            "oficina" : oficina,
            "usu":usu,
        },
        success: function(e){
            if(e!=1){
                Mensaje1(e,"error");
            }else{
                Mensaje1("Se registro la entrega del material perdido","success");
                document.getElementById('frmreingreso').reset();
                lstperdidos($("#txtcodigoper").val());
            }
        }
    })    
}
