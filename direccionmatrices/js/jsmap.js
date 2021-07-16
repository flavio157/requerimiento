let map;
var  lng = ""; 
var  lat = "";
var array=[];
var html = '';
var lat = "";
var infowindow;

$(document).ready(function(){
 // puntopartida();
  $("#txtcontrato").keyup(function(e) {
    var input=  document.getElementById('txtcontrato');
        input.addEventListener('input',function(){
            this.value = this.value.slice(0,8); 
    })
    $("#txtcontrato").val($("#txtcontrato").val().toUpperCase());
  })
});

//var marker =[];

function initMap() {
    map = new google.maps.Map(document.getElementById("map"), {
      center: { lat: -11.9712774, lng: -77.0711738},
      zoom: 20,
    });
    infowindow = new google.maps.InfoWindow({
      minWidth: 251,
    });
    map.addListener("click", (e) => {
        addmarker(e.latLng, map);
    });
};





$(document).on('click','#coordenadas',function(e){
  e.preventDefault();
  contrato = $('#txtcontrato').val().length;
    if ("geolocation" in navigator){ 
        navigator.geolocation.getCurrentPosition(function(position){
         if(contrato != 0){
            contrato = $('#txtcontrato').val()
            addcoordenadas(position.coords.latitude,position.coords.longitude,contrato);
         }else{
           console.log("ingrese numero de contrato");
          }
        });
    }else{
      alert("no su pudo obtener la hubicacion y no se guardaron los datos");
    }
});


function addcoordenadas(lat,lng,contrato){
  usuario = $("#vrcodpersonal").val();
  $.ajax({
    dataType:'text',
        type: 'POST', 
        url:  './c_direcciones.php',
        data: {
            "accion":  'guardar',
            "lat" : lat,
            "lng" : lng,
            "contrato" : contrato,
            "txtusuario":usuario
        },
        success: function(response){   
          if(response == 1){
              mensajeSuccess('Se registro la hubicación','mensajesgenerales')
          }else{
            mensajesError('Error al tratar de registrar la hubicación','mensajesgenerales')
          }
          
      }
  });
}

/*
function lstLatLng(){
  usuario = $('#vrcodpersonal').val();
  oficina = $('#vroficina').val();
    $.ajax({
      dataType:'text',
      type: 'POST', 
      url:  './c_direcciones.php',
      data: {
          "accion":  'lst',
          "txtusuario":usuario,
          "oficina":oficina,
      },
        success: function(response){ 
          console.log(response);
          obj = JSON.parse(response);  
          dibujar(obj['items']);
        }

    });
}


$(document).on('click','#lstcoordenadas',function(e){
  e.preventDefault();
  lstLatLng();
  initMap()
  
});*/

/*
function dibujar(lat){
  coordenadas =[];
  contrato = [];
 $.each(lat, function(i, item) {
   console.log(lat);
    $latlng = lat[i].split(',');
    contrato.push(lat[i],$latlng[2]);
      coordenadas.push({location: { lat: Number($latlng[0]), lng: Number($latlng[1])}, stopover: true});
  })

  console.log(coordenadas[0].location.lat);
  console.log(coordenadas[0].location.lng );

  var directionsService = new google.maps.DirectionsService;
  var directionsDisplay = new google.maps.DirectionsRenderer;
 
  directionsDisplay.setMap(map);

  directionsService
    .route({
      origin: { lat: coordenadas[0].location.lat, lng: coordenadas[0].location.lng },//db waypoint start
      destination: { lat: coordenadas[0].location.lat, lng: coordenadas[0].location.lng },//db waypoint end
      waypoints: coordenadas,
      travelMode: google.maps.TravelMode.DRIVING,
      optimizeWaypoints: true,
    }, function (response, status) {
    if (status === google.maps.DirectionsStatus.OK) {
        var my_route = response.routes[0];
        directionsDisplay.setDirections(response);
        directionsDisplay.setOptions({
          suppressMarkers: true,
          suppressInfoWindowsse : true,
        });
        
        for (var i = 0; i < contrato.length; i++) {
          lng = contrato[i].split(',');
          const marker = new google.maps.Marker({
              position:  new google.maps.LatLng(lng[0], lng[1]),
              draggable:false,
              map: map,
              Title: lng[2]
          });
          modalmarkert(marker,lng[2]);
      } 
    } else {
      window.alert('fallo la comunicacion con el mapa: ' + status);
    }
  });

}*/

 /*
function modalmarkert(marker, mensaje) {
  if(mensaje != 0 ){
        marker.addListener("click", () => {
          const frm = '<form>'+
          '<div class="form-group">'+
            '<label for="exampleFormControlInput1">CONTRATO</label>'+
            '<input class="form-control" id="txtcontrato" name="txtcontrato" type="text" value='+marker.getTitle()+'  style="display: none;"></input>'+
          '</div>'+
          '<div class="form-group">'+
          '<input class="form-control" id="txtcontrat" name="txtcontrat" type="text" value='+mensaje+' ></input>'+
          '</div>'+
          '<div class="form-group">'+
            '<label for="exampleFormControlSelect2">Observación</label>'+
          '</div>'+
          '<div class="form-group">'+
            '<textarea class="form-control" id="txtobservacion" rows="3"></textarea>'+
          '</div>'+
          '<div class="d-grid gap-3 col-5 btnactobservacion mx-auto">'+
            '<botton class="btn btn-primary" id="btnactualizar">Registrar</botton>'+
          '</div>'+
        '</form>';
        infowindow.setContent(frm);
          infowindow.open(
            marker.get("map"), marker
            );
        });
    }
}
*/

function addmarker(latLng, map,coordenadas) {
  new google.maps.Marker({
    position: latLng,
    map: map,
  });
  map.panTo(latLng);
  array.push(latLng.lat() +' '+ latLng.lng());
  console.log(latLng.lat()+""+latLng.lng());
}


/*

$(document).on('click','#btnactualizar',function(e){
  e.preventDefault();
  txtobservacion = $("#txtobservacion").val();
  contrato = $("#txtcontrat").val()
  
  observacion(txtobservacion,contrato);
});*/

/*
function observacion(observacion,contrato) {
  $.ajax({
    dataType:'text',
    type: 'POST', 
    url:  './c_direcciones.php',
    data: {
        "accion":  'obs',
        "txtobservacion":observacion,
        "txtcontrato" : contrato
    },
      success: function(response){ 
        console.log(response);
      }
  });
}*/


function mensajeSuccess(texto,id) {
  mensaje = '<div class="alert alert-success alert-dismissible fade show" role="alert" id="">'+
  '<strong></strong>' + texto+
  '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>'+
  '</div>';
   $('#'+id).html(mensaje);
   window.scrollTo(0, 0);
}


function mensajesError(texto,id) {
  mensaje = '<div class="alert alert-warning alert-dismissible fade show" role="alert" id="">'+
  '<strong>Advertencia: </strong>'+texto+
  '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>'+
  '</div>';
   $('#'+id).html(mensaje);
   window.scrollTo(0, 0);
}
/*
function closeInfoWindow() {
  infowindow.close();
}*/

/*
function puntopartida() {
  oficina = $("#vroficina").val();
  console.log(oficina);
  $.ajax({
    dataType:'text',
    type: 'POST', 
    url:  './c_direcciones.php',
    data: {
        "accion":  'puntopartida',
        "oficina": oficina,
    },
      success: function(response){ 
        latlng = response.split(',');
        console.log(latlng[0],latlng[1]);
        initMap(latlng[0],latlng[1]);
      }
  });
}*/