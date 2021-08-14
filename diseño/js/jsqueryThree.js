$(document).on('click','#btnmostrar',function (e) {
    e.preventDefault();
    

   
  
    consultarAnexo();
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
                    console.log(rootCheckbox);
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
                    console.log("marcar");
                }else{
                    console.log("desmarcar");
                } 
                for (let i = 0; i < childLi.length; i++) {
                    console.log(childLi[i].getAttribute("data"));
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
       url: '../menu/c_guardar_permisos.php',
       data:{
          "accion" : 'buscar',
          "anexo" : anexo
       },
       success:function (dato) {
           $(".padre").prop('checked',false);
           $(".submenu1").prop('checked',false);
           $(".submenu2").prop('checked',false);
           obj = JSON.parse(dato);
            $.each(obj["datos"], function(i, item) {
                $("#frmpermisos .padre").each(function (e) {
                    if(this.getAttribute("data") === item.MENU){
                        $(this).prop('checked', true);
                    }
                })

                $("#frmpermisos .submenu1").each(function (e) {
                    if(this.getAttribute("data") === item.SUB_MENU1){
                        $(this).prop('checked', true);
                        
                        $("#frmpermisos .submenu2").each(function (e) {
                            if(this.getAttribute("datasub")  == item.SUB_MENU1 
                                && this.getAttribute("data") === item.SUB_MENU2 ){
                                $(this).prop('checked', true);
                            }
                        })
                    }

                })
            });
      
         }
    });
 }
 