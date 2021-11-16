var sugematerial = [];
$(function() {
    $('body').on('keydown', function(e){
        if( e.which == 38 ||  e.which == 40) {
          return false;
        }
    });
  
    _categoria('lstcategoria','slcategoria');
    _categoria('lstclase','slclase');

    $("#btnguardarprod").on('click',function() {
        _guardarProducto();
    })

    $("#mtxtstockmin").bind('keypress',function(e) {
        return _numeros(e);
    })
    $("#mtxtunimedida").bind('keypress',function(e) {
        return _letras(e);
    })
    $("#mtxtabreviatura").bind('keypress',function(e) {
        return _letras(e);
    })
    $("#mtxtneto").bind('keypress',function(e) {
        return _numeros(e);
    })
   
    $("#txtcomcantidad").bind('keypress',function(e) {
        return _numeros(e);
    })
  
    
    $("#btnatproduc").on('click',function() {
        validatos();
    })

});

function validatos() {
    var clase = $("#txtcompclase").val();
    var codigo = $("#txtcompcodPro").val();
    var produ = $("#txtcompprod").val();
    var cant = $("#txtcomcantidad").val();
    var precio = $("#txtcomprecio").val();
    var serie = $("#txtcomserie").val();
    $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  'c_guardarmaterial.php',
        data:{
            "accion":'verdatpro',"clase":clase,"codigo":codigo,"produ":produ,"cant":cant,
            "precio":precio,"serie":serie
        } ,
        success:  function(response){
            if(response == 1){
                b1 = "<a id='btneliminar' class='btn btn-danger  btn-sm'>"+
                "<i class='icon-trash'></i>"+
                "</a>";
                array = [
                    a = [codigo,'none',''],
                    b = [produ.toUpperCase(),'',''],
                    c = [serie.toUpperCase(),'',''],
                    d = [cant,'',''],
                    e = [precio,'','p'],
                    i = [b1,'',''],
                ]
                _createtable(array,'tbdmaterialcompro');
                totalcomp = ($("#txttotalcomp").val() == '') ? 0.00 : $("#txttotalcomp").val();
                total = parseFloat(totalcomp) + parseFloat(precio)
                $("#txttotalcomp").val(total);
            }else{
                Mensaje1(response,"error")
            }
        }
    }); 
}

function _categoria(accion,id) {
    $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  'c_guardarmaterial.php',
        data:{
            "accion" : accion,
        } ,
        success:  function(response){
            obj = JSON.parse(response);
            $.each(obj['dato'],function(i,item) {
               $('#'+id).append($("<option value="+item[0]+">"+item[1]+"</option>" ));  
            });
        }
    }); 
}

function _guardarProducto() {
    var producto = $("#mtxtnombreproducto").val();
    var codigopro = $("#mtxtcodigopro").val();
    var categoria =$("#slcategoria").val();
    var unidad = $("#mtxtunimedida").val();
    var sctockmin = $("#mtxtstockmin").val();
    var usuregis = $("#vrcodpersonal").val();
    var abre = $("#mtxtabreviatura").val();
    var neto = $("#mtxtneto").val();
    var clase = $("#slclase").val();
    var oficina = $("#vroficina").val();
     $.ajax({
         dataType:'text',
         type: 'POST', 
         url:  'c_guardarmaterial.php',
         data:{
             "accion" : 'guardarproc',
             "nomprod" : producto,
             "codigopro" :codigopro,
             "categoria" : categoria,
             "unidad" : unidad,
             "sctockmin":sctockmin,
             "abre" : abre,
             "neto" : neto,
             "clase" : clase,
             "usuregis" : usuregis,
             "oficina" : oficina
         } ,
             success:  function(response){
                 if(response == 1){
                      Mensaje1("Se registro Correctamente",'success');
                      _lcform();
                 }else{
                     Mensaje1(response,'error')
                 }
             }
     });
}

function _letras(e) {
    var regex = new RegExp("^[a-zA-Z ]+$");
    var key = String.fromCharCode(!e.charCode ? e.which : e.charCode);
    if (!regex.test(key)) {
      e.preventDefault();
      return false;
    }
};

function _numeros(e) {
    var regex = new RegExp("^[0-9]+$");
    var key = String.fromCharCode(!e.charCode ? e.which : e.charCode);
    if (!regex.test(key)) {
      e.preventDefault();
      return false;
    }
}

function Mensaje1(texto,icono){
    Swal.fire({
     icon: icono,
     title: texto,
     //text: texto,
     //padding:'1rem',
     //grow:'fullscreen',
     //backdrop: false,
     //toast:true,
     //position:'top'	
     });
}


function _lcform() {
    document.getElementById("frmguardaprod").reset();
}


function _lcform() {
    document.getElementById("frmguardaprod").reset();
}


