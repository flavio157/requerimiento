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
            //alert($('input:checkbox[name=colorfavorito]:checked').val());
            var checkParents = function (c)
            {
               //console.log(c.attr("data"));
                var parentLi = c.parents('ul:eq(0)').parents('li:eq(0)');
              
                if (parentLi.length)
                {
                    var siblingsChecked = parseInt($('input[type="checkbox"]:checked', c.parents('ul:eq(0)')).length),
                        rootCheckbox = parentLi.find('input[type="checkbox"]:eq(0)')
                    ;
                    
                    if (c.is(':checked'))
                        rootCheckbox.prop('checked', true)
                      
                     else if (siblingsChecked === 0)
                     //   console.log("des");  //evento que ocurre cuando desmarco checkbox
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
                   // console.log(childLi[i].getAttribute("data"));
                }

                if (childLi.length){
                    childLi.prop('checked', c.is(':checked'));
                } 
            }
        }

    });
})(jQuery);
