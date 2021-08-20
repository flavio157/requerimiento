$(document).ready(function name(params) {
    nro_reclamo();
    $("#btnguardar").on('click',function name(e) {
        guardarReclamo();
        e.preventDefault();
    });

    $("#btnnuevo").on('click',function name(e) {
        document.getElementById("frmreclamos").reset();
        nro_reclamo();
        e.preventDefault();
        
    })
});


function guardarReclamo() {
    var data = $("#frmreclamos");
    var nro_reclamo = $('#nroreclamo').html();
      console.log(nro_reclamo);
      $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  './reclamacion/c_reclamos.php',
        data:data.serialize()+"&accion=guardar&nroreclamo="+nro_reclamo,
        success: function(response){
            console.log(response);
        }
      });
}

function nro_reclamo() {
       $.ajax({
         dataType:'text',
         type: 'POST', 
         url:  './reclamacion/c_reclamos.php',
         data:{
             "accion":"nroreclamo"
         },
         success: function(response){
             $('#nroreclamo').html(response);
         }
       });
}


    


