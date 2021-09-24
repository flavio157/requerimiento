var prod = "";
var ingreso = "";
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
            $.each(obj['insumo'] ,function name(i,e) {
                prod +="<div><strong>INSUMO: </strong>"+e[0]+"</div>"; 
                ingreso +="<div><strong>INGRESO: </strong>"+e[1]+"</div>"; 
            });
            
            __ins(prod,ingreso)
            //$('#prc').html(prod);
           /* obj = JSON.parse(response);
            var l = "";
            $.each(obj['prod'], function(i, it){
                prod += "<div>"+
                it[1]+" CANTIDAD: "+it[2];
                    $.each(obj['insumo'], function(i, a){
                        if(a[1] == it[0]){
                            prod +="<div id='insu'>"+a[3]+"----- CANTIDAD: "+a[4]+"</div>"
                        
                            $.each(obj['envases'], function(i, e){
                                if(e[1] == a[0] && l != it[0]){
                                    prod +="<div id='insu'>"+e[2]+"----- CANTIDAD: "+it[2]+"</div>"
                                }
                            });
                            l = it[0];
                        }
                    });
                    prod +="</div>" 
                
            });
            $('#prc').html(prod);  */ 
        }
    });
}

function __ins(producto,ingreso) {
   var insu = "<div id='prc' class='row align-items-start'>"+
                    "<div class='col'>"+
                        producto+
                    "</div>"+    
                    "<div class='col'>"+
                        ingreso+
                    "</div>"+  
            "</div>";
    $('#contenerdor').html(insu);
  
}

/*
function __det(id,ins,cant) {
   // console.log(id);
    insu +="<div>"+"<strong>INSUMO: </strong>"+
    ins+"<strong>CANTIDAD: </strong>"+cant+"</div>";
    //return insu;
    $('#'+id).html(insu);
}*/