var tdtable;
let $tr;
var nro_correlativo;
var cod_personal ;
var monto;
var fec_gasto;
var fec_cobro;
var id;

$(document).ready(function(){
    
    tdtable = $('#tablacaja').DataTable({
    "columnDefs": [
        {
            "targets": [0,1],
            "visible": false,
            "searchable": false               
        }
    ], 
    language: {
        "decimal": "",
        "emptyTable": "No hay información",
        "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
        "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
        "infoFiltered": "(Filtrado de _MAX_ total entradas)",
        "infoPostFix": "",
        "thousands": ",",
        "lengthMenu": "Mostrar _MENU_ Entradas",
        "loadingRecords": "Cargando...",
        "processing": "Procesando...",
        "search": "Buscar:",
        "zeroRecords": "Sin resultados encontrados",
        "paginate": {
            "first": "Primero",
            "last": "Ultimo",
            "next": "Siguiente",
            "previous": "Anterior"
        }
    }
   });
//esto 
    $('#btnmostrar').on('click',function(e) {
        lstcomentariofalta();
        e.preventDefault();
        //var oficina = $("#sloficina").val();
        //if(oficina != "select")listarcaja(oficina)
    });  
   //hasta aqui 
    $(document).on('click','#verificarpedido',function(e) {
     if($("#tablacaja").closest('table').hasClass("collapsed")){
         var child = $(this).parents("tr.child");
         row = $(child).prevAll(".parent");
     }else{
        var row = tdtable.row($(this).parents('td'));
     }
        var vroficina = $("#vroficina").val();
        var cod_usuario = $("#vrcodpersonal").val();
        var oficina = $("#sloficina").val();

       // 
        verificar_escaneo(nro_correlativo,cod_personal,monto,fec_gasto,fec_cobro,vroficina,cod_usuario,oficina,row)
    })
    $("#sloficina").change(function(){
        $('#tablacaja').find("tr:gt(0)").remove();
    });

    $('#tablacaja tbody').on('click', 'tr', function () {
        var data = tdtable.row(this).data();
        if(data != undefined){
            nro_correlativo = data[0];
            cod_personal = data[1];
            monto = data[3];
            fec_gasto = data[4];
            fec_cobro = data[5];
            id =  $(this).attr('id');
        }
    });

    $("#btncomentarios").on('click',function (params) {
       if($("#iniciodtfecha").val() == "" ){Mensaje1("Error seleccion fecha","error");return; }
       lstcomentario($("#iniciodtfecha").val());
    });

    $("#btnactuestadocom").on('click',function() {
        actualiestado();
    });

});


function verificar_escaneo(nro_correlativo,cod_personal,monto,fec_gasto,fec_cobro,vroficina,cod_usuario,oficina,row) {
    $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  'c_listarcaja.php',
        data: {
            "accion": "verificar",
            "dato" : nro_correlativo,
            "oficina":oficina
        },
        success: function(response){
            if(response == 0){
                Mensaje1("Error imagen no escaneada","error")
            }else{
               registrarcaja(nro_correlativo,cod_personal,monto,fec_gasto,fec_cobro,vroficina,cod_usuario,oficina,row);
            }
        }
    });
}

function listarcaja(oficina){
    $.ajax({
            dataType:'text',
            type: 'POST', 
            url:  'c_listarcaja.php',
            data: {
                "accion": "listar",
                "oficina" : oficina
            },
            success: function(response){
                obj = JSON.parse(response);
                var arr = [];
                $.each(obj['items'], function(i, item) {
                    var items = {};
                    fecha2 = item.FEC_GASTO.split(" "); 
                    fecha = item.FEC_COBRO.split(" "); 
                    fecha1 = formato(fecha2[0]);
                    fecha2 = formato(fecha[0]);
                    items[0] = item.NRO_CORRELATIVO;
                    items[1] = item.COD_PERSONAL;
                    items[2] = item.PERSONAL;
                    items[3] = item.MON_COBRADO;
                    items[4] = fecha1;
                    items[5] = fecha2;
                    items[6] = '<td><a class="btn btn-primary btn-sm" id="verificarpedido"><i class="icon-check" title="Align Right"></i></a></td></tr>';
                    arr.push(items);

                });

                var dataSet = arr;
                
                tdtable =  $('#tablacaja').DataTable({
                    language: {
                        "decimal": "",
                        "emptyTable": "No hay información",
                        "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                        "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
                        "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                        "infoPostFix": "",
                        "thousands": ",",
                        "lengthMenu": "Mostrar _MENU_ Entradas",
                        "loadingRecords": "Cargando...",
                        "processing": "Procesando...",
                        "search": "Buscar:",
                        "zeroRecords": "Sin resultados encontrados",
                        "paginate": {
                            "first": "Primero",
                            "last": "Ultimo",
                            "next": "Siguiente",
                            "previous": "Anterior"
                        }
                    },   
                    "rowId":'0',
                    "columnDefs": [
                        {
                            "targets": [0,1],
                            "visible": false,
                            "searchable": false               
                        }
                    ], 
                    "order": [[ 1, 'asc' ]],
                    "bProcessing": true,
                    destroy: true,
                    "data": dataSet,
                    'aocolumns': [
                        { data: 'PERSONAL' },
                        { data: 'MONTO' },
                        { data: 'FEC_GASTO' },
                        { data: 'FEC_COBRO' },
                    ]
                });              
            }
    }); 
}


function registrarcaja(nro_correlativo,cod_personal,monto,fec_gasto,fec_cobro,vroficina,cod_usuario,oficina,row){
    $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  'c_listarcaja.php',
        data: {
            "accion": "guardar",
            "oficina" : oficina,
            "vroficina":vroficina,
            "correlativo" : nro_correlativo,
            "cod_personal" : cod_personal,
            "monto" : monto,
            "fec_gasto" : fec_gasto,
            "fec_cobro" : fec_cobro,
            "cod_usuario" : cod_usuario,
        },
        success: function(response){
            if(response != ""){
                listarcaja(oficina);
                tdtable.row(row).remove().draw();
            }
        }
    });
}

function formato(texto){
  return texto.replace(/^(\d{4})-(\d{2})-(\d{2})$/g,'$3-$2-$1');
}

//esto
function Mensaje1(texto,icono){
    Swal.fire({
     icon: icono,
     title: texto,
     //text: texto,
     //padding:'1rem',
     //grow:'fullscreen',
     //backdrop: false,
     //toast:true,
     //position:'top'	
     });
}


function lstcomentario(fecha) {
    $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  '/c_listarcaja.php',
        data: {
            "accion": "lstfecha",
            "fecha" : fecha,
            "oficina": ''
        },
        success: function(response){
            if(response == ""){return;}
            $("#txtcomentarioactua").attr("disabled","true") 
            obj = JSON.parse(response);
            $("#txtcomentarioactua").val(obj['comentario']);
            $("#cod_comentario").val(obj['nro']);
            $("#mverificarcomen").modal('show');
        }
    });
}

function actualiestado() {
    $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  'c_listarcaja.php',
        data: {
            "accion": "actualizar",
            "nro" : $("#cod_comentario").val(),
            "oficina": ''
        },
        success: function(response){
        }
    });
}

function lstcomentariofalta() {
    $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  'c_listarcaja.php',
        data: {
            "accion": "lstcomenfalta",
            "oficina":''
        },
        success: function(response){
            console.log(response);
            mensaje = "No se agregro comentario los dia(s)";
            obj = JSON.parse(response);
            $.each(obj['dato'], function(i, f) {
                mensaje += "\n"+obj['dato'][i][0];
            });
            Mensaje1(mensaje,"warning");
            if(obj['b']){
                var oficina = $("#sloficina").val();
                if(oficina != "select")listarcaja(oficina)
            }
        }
    });
}
//hasta aqui