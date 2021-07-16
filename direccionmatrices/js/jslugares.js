let map;
let geocoder;
let marker;
let latlng;

$(document).ready(function(){
    puntopartida();
  });

function initMap(lat,lng) {
    map = new google.maps.Map(document.getElementById("map"), {
      zoom: 20,
      center: {lat: Number(lat), lng: Number(lng)},
      gestureHandling: 'greedy'
    });
    geocoder = new google.maps.Geocoder();
    marker =  new google.maps.Marker();
    google.maps.event.addListener(marker, 'dragend', function(e) {
        latlng = {
            lat: parseFloat(e.latLng.lat()),
            lng: parseFloat(e.latLng.lng()),
          };
          latlngdirecciones(latlng);
      });
  }
  

  $(document).on('click','#btnobtenerdireccions',function (e) {
    e.preventDefault();
    geocodeAddress(geocoder, map);
  })

  function geocodeAddress(geocoder, resultsMap) {
    const address = document.getElementById("txtcontrato").value;
    geocoder
      .geocode({ address: address })
      .then(({ results }) => {
        resultsMap.setCenter(results[0].geometry.location);
        marker.setMap(resultsMap);
        marker.setDraggable(true);
        marker.setPosition(results[0].geometry.location);
      })
      .catch((e) =>
        alert("Error al obtener la direccion" + e)
      );
  }


  function latlngdirecciones(latlng) {
        geocoder.geocode({
            'latLng': latlng
        }, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                console.log(results[0].formatted_address);
            }
        });
        latlng = {};
  }


  function puntopartida() {
    oficina = $("#vroficina").val();
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
          initMap(latlng[0],latlng[1]);
         
        }
    });
  }  