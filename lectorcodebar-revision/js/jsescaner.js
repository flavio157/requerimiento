$(document).ready(function(){
    let selectedDeviceId;
    const codeReader = new ZXing.BrowserMultiFormatReader()
    console.log('ZXing code reader initialized')
    codeReader.listVideoInputDevices()
      .then((videoInputDevices) => {
        const sourceSelect = document.getElementById('sourceSelect')
       // alert(videoInputDevices.length);
        selectedDeviceId = videoInputDevices[0].deviceId
       // console.log(selectedDeviceId);
        if (videoInputDevices.length >= 1) {
          videoInputDevices.forEach((element) => {
            const sourceOption = document.createElement('option')
            sourceOption.text = element.label
            sourceOption.value = element.deviceId
            sourceSelect.appendChild(sourceOption)
          })
        
          sourceSelect.selected = selectedDeviceId;
          sourceSelect.onchange = () => {
            selectedDeviceId = sourceSelect.value;
            codeReader.reset()
            activarcodebar(codeReader,selectedDeviceId);
          };
          const sourceSelectPanel = document.getElementById('sourceSelectPanel')
          sourceSelectPanel.style.display = 'block'
        }

      /*  document.getElementById('startButton').addEventListener('click', () => {
    
        })*/

      /*  document.getElementById('resetButton').addEventListener('click', () => {
          codeReader.reset()
          document.getElementById('result').textContent = '';
          console.log('Reset.')
        })
**/       activarcodebar(codeReader,selectedDeviceId);
      })
      .catch((err) => {
        console.error(err)
      })

     
     
      $("#startButton").on('click',function(){
        _readcodebar('CM1000055');
      });/**/
      
  });


  function activarcodebar(codeReader,selectedDeviceId){
    
     codeReader.decodeFromVideoDevice(selectedDeviceId, 'video', (e, err) => {
        if (e) {
            //alert(result);
          //console.log(result)
          document.getElementById('result').textContent = e.text.trim();
          alert(e.text.length);
          _readcodebar(e.text);
        }
        if (err && !(err instanceof ZXing.NotFoundException)) {
            alert('error al obtener codigo de barra');
          //console.error(err)
          document.getElementById('result').textContent = err
        }
      })
      //alert(`Started continous decode from camera with id ${selectedDeviceId}`)
  }

  function _readcodebar(codebar){
      oficina = $('#vroficina').val();
      usuario = $('#vrcodpersonal').val();
      $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  '../lectorcode/c_verificarcodebar.php',
        data: {
            "accion":  'verificar',
            "oficina" : oficina,
            "usuario" : usuario,
            "codebar": codebar 
        },
          success: function(response){
            alert(response);
            if(response == 1){
              //alert("Producto encontrado y actualizado");
            }else{
              //alert("Producto no encontrado");
            }
          }
    });


  }

  