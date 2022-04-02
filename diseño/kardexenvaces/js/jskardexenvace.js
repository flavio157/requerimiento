var chec = 1;
$(document).ready(function(){
autocompletarMaterial();

$("#btnkarfiltro").on('click',function(){
        fecini = $("#fecini").val();
        fecfin = $("#fecfin").val();
        id = $("#txtidpro").val();
        filtrarkardex(fecini,fecfin,id)
});


$("#txtkarproducto").keydown(function(e){
    if(e.which == 8) {
        $("#txtidpro").val('');
    }
});

$("#chktipofitro").on('change', function() {
    if ($(this).is(':checked')) {
        chec = 1;
    } else{
        chec = 0;
    }
});


})

function autocompletarMaterial() {
    var suproducto =[];
    _lstautocomplete('producto',suproducto);
    $("#txtkarproducto").autocomplete({
      source: suproducto,
        select: function (event, ui) {
            $("#txtidpro").val(ui.item.code);
        }
    });
}

function _lstautocomplete(accion,array) {
    $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  'c_kardexenvace.php',
        data:{
            "accion" : accion,
            "oficina": $("#vroficina").val(),
        } ,
        success:  function(response){
            console.log(response);
            obj = JSON.parse(response);
            $.each(obj['dato'], function(i, item) {
                array.push(item); 
            });
        }
    }); 
}

function filtrarkardex(fecini,fecfin,id){
    $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  'c_kardexenvace.php',
        data:{
            "accion" : 'filtrar',
            "fecini" : fecini,
            "fecfin" : fecfin,
            "id" : id,
            "check" : chec
        } ,
        success:  function(response){
            obj = JSON.parse(response);
            console.log(obj['stockini']);
            if(obj['mensaje'] == 'success'){
                var arr = [];
                var total = 0;
                $.each(obj['dato'], function(i, f) {
                    if(i==0){
                        total = f[2]
                    }
                    else if(f[5] == 'I'){
                        total = Number(total) + Number(f[2]);
                    }else if(f[5] == 'S'){
                        total = Number(total) - Number(f[2]);
                    }
                    fecha = f[3].split(" ");
                    var items = {};
                    items[0] = f[0];
                    items[1] = f[5];
                    items[2] = f[4];
                    items[3] = f[1] ;
                    items[4] = fecha[0]
                    if(f[5] == 'I'){items[5] = Number.parseFloat(f[2]);}else{items[5] = '0'}
                    if(f[5] == 'S'){items[6] =  Number.parseFloat(f[2]);}else{items[6] = '0'}
                    items[7] = Number.parseFloat(total);
                    arr.push(items);
                });
                dataSet = arr; 
                var tabla = $("#tbkardex").DataTable({
                    responsive: true,
                    buttons: [
                        {
                            extend: 'excel',
                            text:'<i class="icon-uninstall" title="Importar a Excel">',
                            title: 'Kardex'
                        },
                        {
                            extend: 'print',
                            text:'<i class="icon-print" title="Imprimir">',
                            title: 'Reporte Kardex'
                        }                       
                   ],
                 
                   dom : 'lfrtipB',
                   dom: 'Bfrtip',
                   "order": [[2,'asc']],
                    destroy: true,
                    "pageLength": 12,
                    "paging": true,
                    "data": dataSet,
                    "searching": false,
                   // "bInfo": true,
                    "ordering": false,
                    
                    language: {
                        "emptyTable": "No hay información",
                        "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                        "infoEmpty": "Mostrando 0 a 0 de 0 Entradas",
                        "lengthMenu": "Mostrar _MENU_ Entradas",
                        "zeroRecords": "Sin resultados encontrados",
                        "paginate": {
                            "first": "Primero",
                            "last": "Ultimo",
                            "next": "Siguiente",
                            "previous": "Anterior"
                        }
                    },
                    "columnDefs": [
                        {"className": "dt-center", "targets": "_all"}
                      ],
                });
            }else{
                Mensaje1(obj['mensaje'],"error");
                $('#tbkardex').find("tr:gt(0)").remove();
            }
            $("#tbkardex").removeAttr('style');
        }
    }); 
}

function Mensaje1(texto,icono){
    Swal.fire({icon: icono,title: texto,});
}