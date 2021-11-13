menu = [];
contador = 0;
$(document).on('click','#btnmostrar',function (e) {
    e.preventDefault();
    consultarAnexo();
});

$(document).on('keypress','#txtanexo',function (e) {
    return soloNumeros(e);
})


$(document).on('click','#btnguardar',function (e) {
    menu = [];
    contador = 0;
    e.preventDefault();
    $("input:checkbox:checked").each(function() {
        datos = $(this).attr("class").split(" ");
        if(datos[2] == "nopadre"){
          sub1 = ($(this).attr("datasub") == undefined) ? "" : $(this).attr("datasub");
          sub2 = ($(this).attr("datasub2") == undefined) ? "" : $(this).attr("datasub2");
          menu[contador] = [$(this).attr("datamenu"),sub1 , sub2];
          contador++;
        }
   });
      guardarPermisos(menu);
});


$(document).on('keyup','#txtanexo',function (e) {
    var input = document.getElementById('txtanexo');
    input.addEventListener('input',function(){
        this.value = this.value.slice(0,4);
    }); 
});




(function($){
    $.fn.extend({

        checktree: function(){
            $(this)
                .addClass('checktree-root')
                .on('change', 'input[type="checkbox"]', function(e){
                    e.stopPropagation();
                    e.preventDefault();

                    checkParents($(this));
                    checkChildren($(this));
                })
            ;
           
            var checkParents = function (c)
            {
                var parentLi = c.parents('ul:eq(0)').parents('li:eq(0)');
                
                if (parentLi.length)
                {
                    var siblingsChecked = parseInt($('input[type="checkbox"]:checked', c.parents('ul:eq(0)')).length),
                        rootCheckbox = parentLi.find('input[type="checkbox"]:eq(0)')
                    ;
               
                    if (c.is(':checked'))
                        rootCheckbox.prop('checked', true)
                      
                     else if (siblingsChecked === 0)
                   
                        rootCheckbox.prop('checked', false);
                    
                    checkParents(rootCheckbox);
                }
            }

            var checkChildren = function (c)
            {
                var childLi = $('ul li input[type="checkbox"]', c.parents('li:eq(0)'));
                if(c.is(':checked')){
                  
                }else{
                  
                } 

                for (let i = 0; i < childLi.length; i++) {
                  
                }

               
                if (childLi.length){
                    childLi.prop('checked', c.is(':checked'));
                } 
            }
        }

    });
})(jQuery);



function consultarAnexo() {
    var anexo = $("#txtanexo").val();   
    $.ajax({
       dataType:'text',
       type:'POST',
       url: 'c_guardar_permisos.php',
       data:{
          "accion" : 'buscar',
          "anexo" : anexo
       },
       success:function (dato) {
           $(".padre").prop('checked',false);
           $(".submenu1").prop('checked',false);
           $(".submenu2").prop('checked',false);

           obj = JSON.parse(dato);
           if(Object.keys(obj["datos"]).length != 0){
             
                $.each(obj["datos"], function(i, item) {
                   
                    $("#frmpermisos .general").each(function (e) {
                      
                        if(this.getAttribute("datamenu") === item.MENU){
                            $(this).prop('checked', true);
                        }
                    })
                    $("#frmpermisos .submenu1").each(function (e) {
                        if(this.getAttribute("datasub") === item.SUB_MENU1 &&
                            this.getAttribute("datamenu") === item.MENU){

                            $(this).prop('checked', true);
                            
                            $("#frmpermisos .submenu2").each(function (e) {
                                if(this.getAttribute("datasub")  == item.SUB_MENU1 
                                    && this.getAttribute("datasub2") === item.SUB_MENU2 ){
                                    $(this).prop('checked', true);
                                }
                            })
                        }
                    })
                });
           }else{
            alert("ANEXO NO VALIDO");
           }
         }
    });
 }
 

 function guardarPermisos(permisos) {
    anexo = $("#txtanexo").val(); 
    if(anexo != ""){
        if(menu.length > 0){
            var datospermisos ={permisos};
            $.ajax({
                dataType:'text',
                type:'POST',
                url: 'c_guardar_permisos.php',
                data:{
                "accion" : 'guardar',
                "permisos" : JSON.stringify(datospermisos),
                "anexo" : anexo 
                },
                success:function (dato) {
                    console.log(dato);
                    menu = [];
                    alert(dato);
                }
            })
        }else{
            alert("SELECCIONE PERMISOS");
        }
        
    }else{
       alert("ANEXO INVALIDO");
    }
 }



function soloNumeros(e){
    var key = window.Event ? e.which : e.keyCode
    return ((key >= 48 && key <= 57) || (key==8))
}