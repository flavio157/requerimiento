var contador = 1;
var ventana_ancho;

$(document).ready(function (params) {
    main();
	ventana_ancho = $(window).width();
	if(ventana_ancho < 800){
		$('.menulateral .sub-menu').hide();
		$("ul").removeClass("dropdown-menu");
	}
});



function main () {
	$('.bt-menu').click(function(e){
        e.preventDefault();
		if (contador == 1) {
			$('nav').animate(
                {
				left: '0'
                },200    
            );
			contador = 0;
		} else {
			contador = 1;
			$('nav').animate(
                {
				left: '-100%',
                },200
			);
		}
	});

	
	$('.menulateral li a').click(function(event){
		if(ventana_ancho < 800){
			if ($(this).next('ul.sub-menu').children().length !== 0) {     
				event.preventDefault();
			}
			$(this).siblings('.sub-menu').slideToggle('slow');
		}
	});
}



