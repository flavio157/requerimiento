
var tdtable = '';
var nro = '';
$(document).ready(function(){
    filtrarkardex();

    $(document).on('click',"#verificarpedido",function(){
        var row = tdtable.row($(this).parents('td'));
        console.log(nro);
    });

    $('#tbrecibo tbody').on('click', 'tr', function () {
        var data = tdtable.row(this).data();
        buscadetalle(data[0])
    });
})



function filtrarkardex(){
    $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  'c_guias.php',
        data:{
            "accion" : 'filtrar',
        } ,
        success:  function(response){
            obj = JSON.parse(response);
            if(obj['mensaje'] == 'success'){
                var arr = [];
                var total = 0;
                $.each(obj['dato'], function(i, f) {
                    var items = {};
                    items[0] = f[0];
                    items[1] = f[7];
                    items[2] = f[8];
                    items[3] = f[6];
                    items[4] = f[12];
                    items[5] =  f[20];
                    items[6] =  '<td><a class="btn btn-primary btn-sm" id="verificarpedido" data-bs-toggle="modal" data-bs-target="#mddetalle"><i class="icon-eye" title="Align Right"></i></a></td></tr>';
                    arr.push(items);
                });
                dataSet = arr; 
                tdtable = $("#tbrecibo").DataTable({
                    responsive: true,
                   
                 
                   dom : 'lfrtipB',
                   dom: 'Bfrtip',
                   "order": [[2,'asc']],
                    destroy: true,
                    "pageLength": 12,
                    "paging": true,
                    "data": dataSet,
                    "searching": false,
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
                        {"className": "dt-center", "targets": "_all",
                        "targets": [0],
                        "visible": false,
                        "searchable": false}
                      ],
                });
            }else{
                Mensaje1(obj['mensaje'],"error");
            }
            $("#tbkardex").removeAttr('style');
        }
    }); 
}


function buscadetalle(nro){
    $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  'c_guias.php',
        data:{
            "accion" : 'buscar',
            "nro" : nro
        } ,
        success:  function(e){
           obj = JSON.parse(e);
           
           $("#tbdetalle > tbody").empty();
           $.each(obj['dato'], function(i, item) {
                var id = Number(i) + Number(1);
                var fila='';
                fila +="<td class='tdcontent' style=display:none>"+item[0]+"</td>";
                fila +="<td class='tdcontent'>"+id+"</td>";
                fila +="<td class='tdcontent'>"+item[1]+"</td>";
                fila +="<td class='tdcontent'>"+item[2]+"</td>";
                fila +="<td class='tdcontent'>"+item[3]+"</td>";
                fila +="<td class='tdcontent'>"+item[4]+"</td>";
                var btn = document.createElement("TR");
                btn.innerHTML=fila;
                document.getElementById('tbddetalle').appendChild(btn);
           });
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