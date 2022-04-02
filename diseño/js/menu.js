var contador = 1;
var ventana_ancho;
var c = 0;
$(function() {
    c = document.getElementsByClassName("menupadre").length;
	bloq();
    bloquepro();
})


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

function bloquepro() {
    $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  '../menu/c_bloqueo.php',
        data: {
            "accion": "bloquepro",
        },
        success: function(e){
            console.log(e);
            if(e==1 && sessionStorage.getItem('codigo') == null){
                mensajeblopro();
            }
        }
    });
}

function bloq() {
    $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  '../menu/c_bloqueo.php',
        data: {
            "accion": "lstmatexdia",
            "oficina":''
        },
        success: function(response){
            var mensaje = '';
            obj = JSON.parse(response);
            if(Object.keys(obj['dato']) != ''){
                $.each(obj['dato'], function(i, f) {
                    nombre = obj['dato'][i][1].split(' ');
                    mensaje +='<tr>'+
                                '<td style="font-size: 15px">'+nombre[0]+'</td>'+
                                '<td style="font-size: 15px">'+obj['dato'][i][5]+'</td>'+
                                '<td style="font-size: 15px">'+obj['dato'][i][4]+'</td>'+
                              '</tr>';
                });
                mensjabloq("Materiales sin devolver \n",'info',mensaje)
               for (let i = 1; i < c ; i++) {
                //$("#"+i).addClass("disabled");// for 2nd li disable  
                //$("#"+i).removeClass("disabled");
                  // $("#"+i).prop(disabled,true)
                   document.getElementById(i).onclick = function(){return false}; 
               }
            }
        }
    });
}

function mensjabloq(texto,icono,tabla){
    Swal.fire({
     icon: icono,
     title: texto,
     html:  '<div class="table-responsive" style="overflow: scroll;height: 179px;">'+
                '<table class="table table-sm">'+
                    '<thead>'+
                        '<tr>'+
                            '<th class="thtitulo">Nombre</th>'+
                            '<th  class="thtitulo">Cantidad</th>'+
                            '<th  class="thtitulo" style="width: 31%;">Material</th>'+
                        '</tr>'+
                    '</thead>'+
                    '<tbody>'+
                        tabla+
                    '</tbody>'+
                '</table>'+
            '</div>'
     });
}

function mensajeblopro() {
    Swal.fire({
        title: 'Error no se llego a la producción estimada',
        text: "Ingrese codigo de desbloqueo",
        inputAttributes: {
          autocapitalize: 'off',
          autocomplete: 'off',
          id:'txtdesbloqueo'
        },
        input: 'text',
        icon: 'error',
        showCancelButton: false,
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'Confirmar',
        allowOutsideClick: false
      }).then((result) => {
        if (result.isConfirmed) {
            desbloqueo($("#txtdesbloqueo").val());
        }
    })
}

function desbloqueo(txtdesblo) {
    $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  '../menu/c_bloqueo.php',
        data: {
            "accion": "desbloqueo",
            "cod" : txtdesblo
        },
        success: function(e){
            if(e != 1){
                mensajeblopro()
            }else{
                sessionStorage.removeItem('codigo');
                sessionStorage.setItem('codigo',txtdesblo)
            }
        }
    });
}