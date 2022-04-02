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
        url:  'c_kardex.php',
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
        url:  'c_kardex.php',
        data:{
            "accion" : 'filtrar',
            "fecini" : fecini,
            "fecfin" : fecfin,
            "id" : id
        } ,
        success:  function(response){
            obj = JSON.parse(response);
            if(obj['mensaje'] == 'success'){
                var arr = [];
                var total = 0;
                
                $.each(obj['dato'], function(i, f) {
                    if(i==0){
                        total = f[5]
                    }
                    else if(f[7] == 'I'){
                        total = Number(total) + Number(f[5]);
                       
                    }else if(f[7] == 'S'){
                        total = Number(total) - Number(f[5]);
                    }
                    fecha = f[4].split(" ");
                    var items = {};
                    items[0] = f[0];
                    items[1] = f[7];
                    items[2] = fecha[0];
                    items[3] = f[3];
                    if(f[7] == 'I'){items[4] = f[5];}else{items[4] = '0'}
                    if(f[7] == 'S'){items[5] =  f[5];}else{items[5] = '0'}
                    items[6] = Number.parseFloat(total).toFixed(3);
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