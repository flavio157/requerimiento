var contador = 1;
var ventana_ancho;

$(document).ready(function (params) {
    main();
	ventana_ancho = $(window).width();
	if(ventana_ancho < 800){
		$('.menulateral .sub-menu').hide();
		$("ul").removeClass("dropdown-menu");
		//console.log(ventana_ancho);
	}
	
/*$('.url').click(function name(e) {
	var href = $(this).attr('href');
	$("#central").load('../vista'+href);
	if(contador == 0){
		$('nav').animate(
			{
			left: '-100%'
			},300    
		);
		contador = 0;
	}
    e.preventDefault();
})*/


});



function main () {
	$('.bt-menu').click(function(e){
        e.preventDefault();
		if (contador == 1) {
			$('nav').animate(
                {
				left: '0'
                },180    
            );
			contador = 0;
		} else {
			contador = 1;
			$('nav').animate(
                {
				left: '-100%',
                },180
			);
		}
	});

	// Mostramos y ocultamos submenus
	/*$('.menupadre').click(function(){
		$(this).children('.children').slideToggle();
	});*/


	
	$('.menulateral li a').click(function(event){
		//console.log(ventana_ancho);
		if(ventana_ancho < 800){
		//	console.log(ventana_ancho);
			if ($(this).next('ul.sub-menu').children().length !== 0) {     
				event.preventDefault();
			}
			$(this).siblings('.sub-menu').slideToggle('slow');
		}
		
	});
}



