$(document).ready(function(){
    $("#prueba").on('click',function(e){
        e.preventDefault();
       login();
    });
});


function login() {
    var usu = $("#usuario").val();
    if(usu != ''){
        $.ajax({
            dataType:'text',
            type: 'POST', 
            url:  './menu/c_login.php',
            data: {
                "usuario":  usu,
            },
            success: function(response){
                console.log(response);
               /* console.log(response);
                if(response == 'echo'){*/
            //        window.location.replace('./menu/index.php'); este es mejor
        
            window.location.href = "./menu/index.php";
                   // $(location).replace('href',"./menu/index.php");
               /* }else{
                    mensajesError("Error usuario y/o contraseña incorrecto","mensajesgenerales");
                }*/
                
            }
        });   
    } else{
        mensajesError("Ingrese nombre de usuario","mensajesgenerales");
    }   
}


function mensajesError(texto,id) {
    mensaje = '<div class="alert alert-danger alert-dismissible fade show" role="alert" id="">'+
    '<strong>Advertencia: </strong>'+texto+
    '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>'+
    '</div>';
     $('#'+id).html(mensaje);
     window.scrollTo(0, 0);
 }