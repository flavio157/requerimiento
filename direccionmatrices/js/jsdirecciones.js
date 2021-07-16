let map;
var  lng = ""; 
var  lat = "";
var array=[];
var html = '';
var lat = "";
//var infowindow;
var geocoder ;
var marker;
function initMap() {
    
    map = new google.maps.Map(document.getElementById("map"), {
      center: { lat: -11.9712774, lng: -77.0711738},
      zoom: 20,
    });
    geocoder = new google.maps.Geocoder();
    marker = new google.maps.Marker();
    /*infowindow = new google.maps.InfoWindow({
      minWidth: 251,
    });*/
    map.addListener("click", (e) => {
      latlng = {
        lat: parseFloat(e.latLng.lat()),
        lng: parseFloat(e.latLng.lng()),
      };
      direccion(latlng);
    });

    google.maps.event.addListener(marker, 'dragend', function(e) {
      console.log(e.latLng.lat()); 
      latlng = {
        lat: parseFloat(e.latLng.lat()),
        lng: parseFloat(e.latLng.lng()),
      };
       direccion(latlng);
       //addcoordenadas(latlng,map,direccion)
    } );
};


function addmarker(latLng, map) {
  marker.setOptions({
    position : latlng,
    map : map,
    draggable : true
  });
  map.panTo(latLng);
    //array.push(latLng.lat() +' '+ latLng.lng());
    //console.log(latLng.lat()+""+latLng.lng());
  }
  
function addcoordenadas(latlng,map,direccion){
  contrato = '0';
  usuario = $("#vrcodpersonal").val();
  $.ajax({
    dataType:'text',
        type: 'POST', 
        url:  './c_direcciones.php',
        data: {
            "accion":  'guardar',
            "lat" : latlng.lat,
            "lng" : latlng.lng,
            "contrato" : contrato,
            "txtusuario":usuario,
            "direccion": direccion
        },
        success: function(response){   
          if(response == 1){
            alert("se registro la ubicacion");
            addmarker(latlng, map);
          ///  mensajeSuccess('Se registro la hubicación','mensajesgenerales')
          }else{
            alert("error al registrar la ubicacion");
            //mensajesError('Error al tratar de registrar la hubicación','mensajesgenerales')
          } 
      }
  });
}

function direccion(latlng) {
  //console.log(latlng.lat);
  geocoder.geocode({
    'latLng': latlng
}, function(results, status) {
    if (status == google.maps.GeocoderStatus.OK) {
      //addmarker(latlng, map);
      addcoordenadas(latlng,map,results[0].formatted_address);
        //console.log(results[0].formatted_address);
    }else{
      alert("Error al obtener la direccion, no se pudo registrar");
    }
});   
}