var guia;
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
  });


  function activarcodebar(codeReader,selectedDeviceId){
   
     codeReader.decodeFromVideoDevice(selectedDeviceId, 'video', (e, err) => {
        if (e) {
          
          document.getElementById('result').textContent = e.text.trim();
      
        
          if($("#nroguia").val() == "" && e.text != ""){
            _agregar(e.text)
          }else{
             _readcodebar(e.text);
          }
          
        }
        if (err && !(err instanceof ZXing.NotFoundException)) {
            alert('error al obtener codigo de barra');   
            document.getElementById('result').textContent = err
        }
      })
  }

  function _agregar($codebar){
    oficina = $("#vroficina").val();
    codpersonal = $("#vrcodpersonal").val();

    $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  '../lectorcode/c_guias.php',
        data: {
            'accion':'buscar',
            'oficina':oficina,
            'codpersonal':codpersonal,
            'tipo' : 1,
            'codebar' : $codebar
        },
        success: function(response){
          alert(response);
          obj =JSON.parse(response);
          if(obj[1] != ''){
            alert(obj['msj']);
            $("#nroguia").val(obj[1]);
          }  
        }
    });
}


  function _readcodebar(codebar){
      oficina = $('#vroficina').val();
      personal = $('#vrcodpersonal').val();
      codguia = $('#nroguia').val();
   
      $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  '../lectorcode/c_guias.php',
        data: {
            "accion":  'insertItem',
            "oficina" : oficina,
            "codguia" : codguia,
            "codebar": codebar,
            "codpersonal" : personal
        },
          success: function(response){
            alert(response);
            obj =JSON.parse(response);
            if(obj['msj'] != ''){
              alert(obj['msj']);
            }
          }
    });


  }

  