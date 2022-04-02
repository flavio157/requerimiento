var sugematerial = [];
$(function() {
    $("#btnguarprovee").on('click',function () {
        guardarprovee();
    })
});


function guardarprovee() {
    var proveedor = $("#frmgudarproveedor").serialize();
    var usu = $("#vrcodpersonal").val();
    $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  'c_proveedor.php',
        data:proveedor+"&accion=gproveedor&usu="+usu,
        success:  function(e){
           if(e == 1){
               Mensaje1("Se registro el proveedor","success");
               document.getElementById("frmgudarproveedor").reset();
           }else{
               Mensaje1(e,"error");
           }
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