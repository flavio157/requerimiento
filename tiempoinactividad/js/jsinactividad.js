var tiempo = 121;
var _SecondsCounter = tiempo;
var TIMEOUT = 0; /*s*/

$(document).ready(function(){
    eventos();
  
    $("#devolverVal").on("click",function(){
        $("#modalinactivo").modal('hide');
    });
})




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