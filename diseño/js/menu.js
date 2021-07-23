var contador = 1;

$(document).ready(function (params) {
    main();


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

	// Mostramos y ocultamos submenus
	$('.menupadre').click(function(){
		$(this).children('.children').slideToggle();
	});
}



