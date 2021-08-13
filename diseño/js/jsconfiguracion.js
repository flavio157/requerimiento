$(document).ready(function (params) {
   listarmenu();
   $("#btnmostrar").on('click',function name(e) {
      e.preventDefault();
      consultarAnexo();
   })


});

function listarmenu() {
   $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  '../menu/c_menu.php',
        data: {
            "accion" : 'listar',
        },
        success: function(response){
          $("#tree").html(response);   
        }
   });
}


function consultarAnexo() {

   var anexo = $("#txtanexo").val();   
   $.ajax({
      dataType:'text',
      type:'POST',
      url: '../menu/c_guardar_permisos.php',
      data:{
         "accion" : 'buscar',
         "anexo" : anexo
      },
      success:function (e) {
         console.log(e); 
      }
   });
}


function selectCheckbox(params) {
      
}