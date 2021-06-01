var i = null;
$(document).ready(function(){
    llamadasPendientes(); 

    $("#Selectprovincia").change(function(){   
        var id = $('#Selectprovincia').val();
        if(id == "R"){
            StopInterval();
        }else{
            StarInterval();
        }
    });

    $("#closed").on('click',function(){
        $("#modalPrueba").modal('hide');
        $('#Selectprovincia').val('1');
    });
})


/*llamadas pendientes */
function llamadasPendientes() {
    codigo = $("#vrcodpersonal").val();
    oficina = $("#vroficina").val();
    console.log(oficina);
    $.ajax({
        method: "POST",
        url: "../Pedido/C_Pen_LLamada.php", 
        data: {
            accion: "tiempo",
            cod : codigo,
            ofi : oficina,
        },
        success: function name(c) {
            console.log(c);
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
   codigo = $("#vrcodpersonal").val();
   oficina = $("#vroficina").val();
    $.ajax({
        method: "POST",
        url: "../Pedido/C_Pen_LLamada.php", 
        data: {
            accion: "datos",
            cod : codigo ,
            ofi : oficina,
        },
        success: function name(e) {
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


