var i = null;
var oficina ;
$(document).ready(function(){
   

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

    $("#sloficina").change(function() {
        oficina = $("#sloficina").val();
        if(oficina !== 'O'){
            llamadasPendientes(); 
        }else{
            StopInterval(i);
        }  
    })


})


/*llamadas pendientes */
function llamadasPendientes() {
    codigo = $("#vrcodpersonal").val();
    ofilogin = $("#vroficina").val();
   
    $.ajax({
        method: "POST",
        url: "../Pedido/C_Pen_LLamada.php", 
        data: {
            accion: "tiempo",
            cod : codigo,
            ofi : oficina,
            oficinalogin : ofilogin
        },
        success: function name(c) {
            console.log(c);
            var o = JSON.parse(c);
            console.log(o);
            if(o == 1){
                StarInterval();
            }else{
                StopInterval(i);
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
   ofilogin = $("#vroficina").val();
 
    $.ajax({
        method: "POST",
        url: "../Pedido/C_Pen_LLamada.php", 
        data: {
            accion: "datos",
            cod : codigo ,
            ofi : oficina,
            oficinalogin : ofilogin
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


