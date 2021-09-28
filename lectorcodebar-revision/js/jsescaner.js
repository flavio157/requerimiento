var dt = [];
var tipo = 0;
var codbar=[];
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

      $('#mdbar').modal({
        backdrop: 'static', keyboard: false
    })
     
      /*$("#startButton").on('click',function(){
        codigo = ' CM1000028 '
        _readcodebar(codigo,'-1');
      });
      */

      $("#btaceptar").click(function (params) {
         $("#mdbar").modal('hide');
      });

      $("#btcancelar").click(function (params) {
         $('#tablacodebar').find("tr:gt(0)").remove();
      });

      $("#close").click(function () {
         $('#tablacodebar').find("tr:gt(0)").remove();
      });
  });


  function activarcodebar(codeReader,selectedDeviceId){
    
     codeReader.decodeFromVideoDevice(selectedDeviceId, 'video', (e, err) => {
        if (e) {
         
          var filas = $("#tbbar  tr");
          if(filas.length < 9){
            if(codbar.indexOf(e.text.trim()) == -1){
                var fila="<tr><td>"+e.text+ "</td></tr>";
                var btn = document.createElement("TR");
                btn.innerHTML=fila;
                document.getElementById("tbbar").appendChild(btn);
                
                document.getElementById('result').textContent = e.text.trim();
    
                tipo = dt.indexOf(e.text.trim()); 
                if(dt.indexOf(e.text.trim()) == -1){
                  dt.push(e.text.trim());
                }
              _readcodebar(e.text,tipo);
              codbar.push(e.text.trim());
            }else{
              alert("codigo ya pistoleado");
            }
           
          }else{
              $("#mdbar").modal('show');
          }
          
          
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
            
             //alert(response);
            if(response == 1){
              //alert("Producto encontrado y actualizado");
            }else{
              //alert("Producto no encontrado");
            }
          }
    });


  }

  