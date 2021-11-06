$(document).ready(function(){
    var tabla = $("#tbkardex").DataTable({
        responsive: true,
        buttons: [
            {
                extend: 'excel',
                text:'EXCEL <i class="fas fa-file-excel">'
            }
       ],
      // dom : 'lfrtipB',
       dom: 'Bfrtip',
       "order": [[0,'asc']],
        destroy: true,
        "pageLength": 12,
        "paging": true,
      //  "data": dataSet,
        "searching": false,
        "bLengthChange": false,
        "bFilter": false,
        "bInfo": true,
        "ordering": true,
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
    
    });

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
        } ,
        success:  function(response){
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
            Mensaje1(response,"error");
            console.log(response);
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