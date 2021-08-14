$(document).ready(function (params) {
   listarmenu();
 


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

