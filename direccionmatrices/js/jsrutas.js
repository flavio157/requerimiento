let map;
var  lng = ""; 
var  lat = "";
var array=[];
var html = '';
var lat = "";
var infowindow;
var txtcontrato = '';
const labels = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
let labelIndex = 0;

$(document).ready(function(){
    puntopartida();
  
  });


  function initMap(lat,lng) {
   
      map = new google.maps.Map(document.getElementById("map"), {
        center: { lat: Number(lat), lng: Number(lng)},
        zoom: 20,
      });
      infowindow = new google.maps.InfoWindow({
        minWidth: 400,
      });
      /*map.addListener("click", (e) => {
          addmarker(e.latLng, map);
      });*/
  };
  
 

  
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
            latlng = obj['items'][0].split(',');
            initMap(latlng[0],latlng[1]);
            dibujar(obj['items']);
          }
  
      });
  }
  
  
  /*$(document).on('click','#lstcoordenadas',function(e){
    e.preventDefault();
    lstLatLng();
    
  });*/
  
  
  function dibujar(lat){
    coordenadas =[];
    contrato = [];
   $.each(lat, function(i, item) {
      
      $latlng = lat[i].split(',');
      contrato.push(lat[i],$latlng[2]);
        coordenadas.push({location: { lat: Number($latlng[0]), lng: Number($latlng[1])}, stopover: true});
    })

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
            if(i % 2 == 0) {
              if((contrato.length / 2) != ((i/2) + 1)){
                letra = labels[i - (i / 2)]; 
                lng = contrato[i].split(',');
                const marker = new google.maps.Marker({
                    position:  new google.maps.LatLng(lng[0], lng[1]),
                    label: letra,
                    draggable:false,
                    map: map,
                    Title: lng[2],
                });
                modalmarkert(marker,lng[2]);
              }
            }
            
          
        } 
      } else {
        window.alert('fallo la comunicacion con el mapa: ' + status);
      }
    });
  
  }
  
   
  function modalmarkert(marker, mensaje) {
    if(mensaje != 0 ){
          marker.addListener("click", () => {
            consulobservacion(marker.getTitle());
            const frm = '<form>'+
            '<div class="form-group">'+
              '<label style="font-size: 15px;font-weight: 400;padding: 3px;">CONTRATO</label>'+
            '</div>'+
            '<div class="form-group">'+
            '<input class="form-control" id="txtcontrat" name="txtcontrat" type="text" value='+marker.getTitle()+' readonly></input>'+
            '</div>'+
            '<div class="form-group">'+
                '<label style="font-size: 15px;font-weight: 400;padding: 3px;">OBSERVACIÓN</label>'+
            '</div>'+
            '<div class="form-group">'+
              '<textarea class="form-control" id="txtobservacion" rows="15"></textarea>'+
            '</div>'+
            '<div class="d-grid gap-3 col-5 btnactobservacion mx-auto">'+
              '<botton class="btn btn-primary" id="btnactualizar">Registrar</botton>'+
            '</div>'+
          '</form>';
          txtcontrato = marker.getTitle(); 
          infowindow.setContent(frm);
            infowindow.open(
              marker.get("map"), marker
              );
          });
      }
  }
  
  
  $(document).on('click','#btnactualizar',function(e){
    e.preventDefault();
    txtobservacion = $("#txtobservacion").val();
    observacion(txtobservacion,txtcontrato);
  });
  
  
  function observacion(observacion,txtcontrato) {
    $.ajax({
      dataType:'text',
      type: 'POST', 
      url:  './c_direcciones.php',
      data: {
          "accion":  'obs',
          "txtobservacion":observacion,
          "txtcontrato" : txtcontrato
      },
        success: function(response){ 
          $("#btnactualizar").hide();
          
        }
    });
  }
  
  
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
  
  function closeInfoWindow() {
    infowindow.close();
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
          lstLatLng();
        }
    });
  }  

  function consulobservacion(contrato) {
    usuario = $("#vrcodpersonal").val();
    $.ajax({
      dataType:'text',
      type: 'POST', 
      url:  './c_direcciones.php',
      data: {
          "accion":  'consultarcontrato',
          "usuario": usuario,
          "contrato" : contrato
      },
        success: function(response){ 
         
            if(response != ''){
              $("#btnactualizar").hide();
              $("#txtobservacion").val(response);
            }
           

        }
    });
  }