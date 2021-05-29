var i = null;
$(document).ready(function(){
  
    llamadasPendientes(); 

    $("#Selectprovincia").change(function(){
        var id = $('#Selectprovincia').val();
        if(id == "R"){
            StopInterval();
        }
    });

    $("#closed").on('click',function(){
        $("#modalPrueba").modal('hide');
        $('#Selectprovincia').val('1');
    });
})

/*llamadas pendientes */
function llamadasPendientes() {
    $.ajax({
        method: "POST",
        url: "../Pedido/C_Pen_LLamada.php", 
        data: {
            accion: "tiempo"
        },
        success: function name(c) {
            var o = JSON.parse(c);
            if(o == 1){
                StarInterval();
            } 
        }
    })
}



function StarInterval(){
    i = setInterval(function() {
          setTime();
       }, 60000); 
}


function setTime() {
    $.ajax({
        method: "POST",
        url: "../Pedido/C_Pen_LLamada.php", 
        data: {
            accion: "datos"
        },
        success: function name(e) {
            $("#txtcliente").val(e);
            console.log(e);
            var c = JSON.parse(e);
            if(c != "0"){
                $("#modalPrueba").modal('show');
            }
        }
    })
}



function StopInterval(){
    clearInterval(i);
}


