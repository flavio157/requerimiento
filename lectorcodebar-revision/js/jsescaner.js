var dt = [];
var tipo = 0;
$(document).ready(function(){
    let selectedDeviceId;
    const codeReader = new ZXing.BrowserMultiFormatReader()
    console.log('ZXing code reader initialized')
    codeReader.listVideoInputDevices()
      .then((videoInputDevices) => {
        const sourceSelect = document.getElementById('sourceSelect')
        selectedDeviceId = videoInputDevices[0].deviceId
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

     
     
      /*$("#startButton").on('click',function(){
        codigo = ' CM1000028 '
        _readcodebar(codigo,'-1');
      });
      */
  });


  function activarcodebar(codeReader,selectedDeviceId){
    
     codeReader.decodeFromVideoDevice(selectedDeviceId, 'video', (e, err) => {
        if (e) {
          document.getElementById('result').textContent = e.text.trim();

          tipo = dt.indexOf(e.text.trim()); 
          if(dt.indexOf(e.text.trim()) == -1){
            dt.push(e.text.trim());
          }

          _readcodebar(e.text,tipo);
        }
        if (err && !(err instanceof ZXing.NotFoundException)) {
            alert('error al obtener codigo de barra');
         
            document.getElementById('result').textContent = err
        }
      })
  }

  function _readcodebar(codebar,tipo){
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
            "codebar": codebar,
            "tipo" : tipo 

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

  