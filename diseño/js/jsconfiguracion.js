$(document).ready(function (params) {
    
   // alert("configuracion");
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
            console.log(response);
           //$("#checbox").html(response);
           /* obj = JSON.parse(response);
            $.each(obj['dato'], function(i, item) {

                console.log(item[2])
            })*/

            
               
        }


   });
}