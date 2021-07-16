let map;
var  lng = ""; 
var  lat = "";
var array=[];
var html = '';
var lat = "";
var infowindow;

function initMap() {
    var geocoder = new google.maps.Geocoder();
    map = new google.maps.Map(document.getElementById("map"), {
      center: { lat: -11.9712774, lng: -77.0711738},
      zoom: 20,
    });
    infowindow = new google.maps.InfoWindow({
      minWidth: 251,
    });
    map.addListener("click", (e) => {
      console.log(e.latLng.lat());

      latlng = {
        lat: parseFloat(e.latLng.lat()),
        lng: parseFloat(e.latLng.lng()),
      };

        geocoder.geocode({
            'latLng': latlng
        }, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                console.log(results[0].formatted_address);
            }
        });


        addmarker(e.latLng, map);
    });

    

};


function addmarker(latLng, map,coordenadas) {
    new google.maps.Marker({
      position: latLng,
      map: map,
    });
    map.panTo(latLng);
    array.push(latLng.lat() +' '+ latLng.lng());
    console.log(latLng.lat()+""+latLng.lng());
  }
  


  
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
