var i = null;
var tiempo = 121;
var _SecondsCounter = tiempo;
var TIMEOUT = 0; /*s*/

$(document).ready(function(){
    eventos();
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

    $("#devolverVal").on("click",function(){
        $("#modalinactivo").modal('hide');
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
/*----------*/


/*tiempo inactividad*/
window.setInterval(CheckIdleTime, 1000);

function CheckIdleTime() {
    _SecondsCounter--;
    $("#txtcontador").val(_SecondsCounter); 
    if(_SecondsCounter == 10){
        $("#modalinactivo").modal("show");
    }
    if(_SecondsCounter <= 10){
        $("#txtcontador").val(_SecondsCounter); 
    }

    if (_SecondsCounter <= TIMEOUT) { 
        document.location.href = "../index.php";
    }
    window.clearInterval();
}


function eventos(){
    document.onclick = function() {
        _SecondsCounter = tiempo;
    };
    document.onmousemove = function() {
        _SecondsCounter = tiempo;
    };
    document.onkeypress = function() {
        _SecondsCounter = tiempo;
    };

    document.onscroll = function(){
        _SecondsCounter = tiempo;
    }
    document.keydown = function(){
        _SecondsCounter = tiempo;
    }
}
/*------------*/