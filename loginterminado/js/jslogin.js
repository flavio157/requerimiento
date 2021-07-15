var tdtable;
$(document).ready(function(){
    tdtable = $('#tablacaja').DataTable({
        /*"columnDefs": [
            {
                "targets": [0,1],
                "visible": false,
                "searchable": false               
            }
        ], */
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

    $("#personalfalta").click(function(e){
        e.preventDefault();  
        personalfalta();
    });
    

});




function personalfalta(){
    $.ajax({
            dataType:'text',
            type: 'POST', 
            url:  '../pedido/C_personalenfalta.php',
            data:{
                "accion" : "guardar",
                "usuario" : '',
             } ,
            success: function(response){
                //console.log(response);
                lst_cuotabaja();
            }
    });
}


function lst_cuotabaja() {
    $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  '../pedido/C_personalenfalta.php',
        data:{
            "accion" : "lstpersonal",
            "usuario" : '',
         } ,
        success: function(response){
            obj = JSON.parse(response);
            var arr = [];
            $.each(obj['items'], function(i, item) {
                var items = {};
                items[0] = item.COD_PERSONAL;
                items[1] = item.NOM_PERSONAL;
                items[2] = item.PROMEDIO;
                items[3] = item.OFICINA;
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
               
               /* "columnDefs": [
                    {
                        "targets": [0,1],
                        "visible": false,
                        "searchable": false               
                    }
                ], */
                "order": [[ 0, 'asc' ]],
                "bProcessing": true,
                destroy: true,
                "data": dataSet,
               'aocolumns': [
                    { data: 'CODIGO' },
                    { data: 'NOMBRE' },
                    { data: 'CUOTA' },
                    { data: 'OFICINA' },
                  
                ]
            });              
        }
}); 
}





function formato(texto){
    return texto.replace(/^(\d{4})-(\d{2})-(\d{2})$/g,'$3-$2-$1');
  }