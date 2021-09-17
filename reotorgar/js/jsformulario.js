$(document).ready(function(){

    _buscarremision();
});

function _buscarremision(){
    oficina = $("#vroficina").val();
    codpersonal = $("#vrcodpersonal").val();
    $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  '../lectorcode/c_guias.php',
        data: {
            'accion':'buscar',
            'oficina':oficina,
            'codpersonal':codpersonal,
            'tipo' : 0
        },
        success: function(response){
            if(response != ""){
                obj = JSON.parse(response);
                $("#nroguia").val(obj['1']);
            }
        }
    });
}