$(document).ready(function(){
    
    $("#btnfiltrar").on('click',function (params) {
        insumos($("#fech_ini").val(),$("#fech_fin").val());
    });
});

function insumos(fech_ini,fech_fin){
    $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  '../insumos/c_insumoventas.php',
        data: {
            'accion':'filtro',
            'fech_ini':fech_ini,
            'fech_fin':fech_fin
        },
        success: function(response){
            
            obj = JSON.parse(response);
           // console.log(obj['envases']);
                $.each(obj['prod'], function(i, it){
                        console.log("PRODUCTO : "+ it[1] + " CANTIDAD: "+ it[2] +" MONTO: " +it[3]);
                        $.each(obj['insumo'], function(i, a){
                            if(a[1] == it[0]){
                                console.log(a[3] +" - "+ a[4]);
                                $.each(obj['envases'], function(i, e){
                                    console.log(e[1] +"=="+ a[0]);
                                    if(e[1] == a[0]){
                                        console.log("envase:" + e[2]);
                                    }
                                }); 
                            }
                        });
            });
        }
    });
}