
$(function() {
   

    $('body').on('keydown', function(e){
        if( e.which == 38 ||  e.which == 40) {
          return false;
        }
    });
  

    autocompletarMaterial();
    autocompletarpersonal();
    
    _categoria('lstcategoria','slcategoria');
    _categoria('lstclase','slclase');

    $("#slcmoneda" ).change(function() {
        if($(this).val() == "S"){$("#txttipocambio").attr('disabled','true');}
        else{$("#txttipocambio").removeAttr('disabled');}
        $("#txttipocambio").val('');
    });

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
    $("#mtxtnombreproducto").bind('keypress',function(e) {
        return _letras(e);
    })
    
    $("#btng_compro").on('click',function (params) {
        var oficina = $("#frmcomprobante").serialize();
        if($("#txtcomfecemision").val() == ''){Mensaje1("Error ingrese fecha de emision","error"); return}
        if($("#txtcomhoremision").val() == ''){Mensaje1("Error ingrese hora de emision","error"); return}
        if($("#txtcomfecentrega").val() == ''){Mensaje1("Error ingrese fecha de entrega","error"); return}
        if($("#txtcomcodpers").val() == ''){Mensaje1("Error ingrese personal","error"); return}
        if($("#txtcompersonal").val() == ''){Mensaje1("Error ingrese personal","error"); return}
        if($("#slctipocompr").val() == ''){Mensaje1("Error selecciones tipo de comprobante","error");return}
        if($("#slcformpago").val() == ''){Mensaje1("Error seleccione forma de pago","error");return}
        if($("#slcmoneda").val() == ''){Mensaje1("Error seleccione tipo de moneda","error");return}
        if($("#slcmoneda").val() == 'D' && $("#txttipocambio").val() == ''){Mensaje1("Error ingrese tipo de cambio","error");return}
        if(!$("#rdnsi").is(':checked') && !$("#rdnno").is(':checked')) {Mensaje1("seleccione","error");return;}
    
        var td =  $("#tbdmaterialcompro tr");
        var tds = [];
        for (let l = 0; l < td.length; l++) {
            tds[l] =[
                $(td[l]).find("td")[0].innerHTML,
                $(td[l]).find("td")[2].innerHTML,
                $(td[l]).find("td")[3].innerHTML,
                $(td[l]).find("td")[4].innerHTML
            ]
        }
        Mensaje2(oficina,tds);
    })

    $("#rdnsi").on('change',function() {
        $("#rdnsi").val('1');$("#rdnno").val('');
    });
    $("#rdnno").on('change',function() {
        $("#rdnsi").val('');$("#rdnno").val('0');
    });

    $("#btnatproduc").on('click',function() {
        validatos();
    })

    $(document).on('click','#btneliminar',function() {
        total = $("#txttotalcomp").val();
        total = parseFloat(total) - parseFloat($(this).closest('tr').find("td:nth-child(5)").text());
        $("#txttotalcomp").val(total);
        $(this).closest('tr').remove();
    })

    $("#btnnuevo").on('click',function() {
        _lcform();
    })

    $("#btnguarpers").on('click',function() {
        var personal = $("#frmgudarpers").serialize();
        _guardarpers(personal);
    });

    $("#mtxtdniper").keyup(function(e) {
        var input=  document.getElementById('mtxtdniper');
            input.addEventListener('input',function(){
                this.value = this.value.slice(0,8); 
        })
    })
    $("#mtxttelpers").keyup(function(e) {
        var input=  document.getElementById('mtxttelpers');
            input.addEventListener('input',function(){
                this.value = this.value.slice(0,11); 
        })
    })
    $("#mtxtcelpers").keyup(function(e) {
        var input=  document.getElementById('mtxtcelpers');
            input.addEventListener('input',function(){
                this.value = this.value.slice(0,9); 
        })
    })
    $("#mtxtcuenpers").keyup(function(e) {
        var input=  document.getElementById('mtxtcuenpers');
            input.addEventListener('input',function(){
                this.value = this.value.slice(0,14); 
        })
    })
});

function _guardarComprobante(oficina,tds) {
    var productos = {tds};
    var usuario = $("#vrcodpersonal").val();
    var almacen = $("#vroficina").val();
    $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  'c_comprobante.php',
        data:oficina+"&accion=guardarcom&productos="+JSON.stringify(productos)+
             "&usuario="+usuario+"&almacen="+almacen,
        success:function(response){
            if(response == 1){
                Mensaje1("Se registraron correctamente lo datos","success")
                _lcform();
            }else{
                Mensaje1(response,"error");
            }
        }
    }); 
}


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
        url:  'c_comprobante.php',
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

function _lstautocomplete(accion,array) {
    $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  'c_comprobante.php',
        data:{
            "accion" : accion,
        } ,
        success:  function(response){
            obj = JSON.parse(response);
            $.each(obj['dato'], function(i, item) {
                array.push(item); 
            });
        }
    }); 
}

function _categoria(accion,id) {
    $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  'c_comprobante.php',
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
         url:  'c_comprobante.php',
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
                      document.getElementById("frmguardaprod").reset();
                 }else{
                     Mensaje1(response,'error')
                 }
                 autocompletarMaterial()
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

function Mensaje2(oficina,tds) {
    Swal.fire({
        title: '??Desea guardar el comprobante?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Guardar',
        cancelButtonColor: '#d33',
      }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {
            _guardarComprobante(oficina,tds);
        }
      })
}

function autocompletarMaterial() {
    var suproducto =[];
    _lstautocomplete('producto',suproducto);
    $("#txtcompprod").autocomplete({
      source: suproducto,
        select: function (event, ui) {
          $("#txtcompcodPro").val(ui.item.code);
          $("#txtcompclase").val(ui.item.clase);
          $("#txtcomserie").val('');
          if(ui.item.clase != '00001'){
                $("#txtcomserie").attr('disabled','true');
            }else{
                $("#txtcomserie").removeAttr('disabled');
            }
          $("#txtcomserie").val('');  
        }
    });
}



function autocompletarpersonal() {
    var supersonal =[];
    _lstautocomplete('personal',supersonal);
    $("#txtcompersonal").autocomplete({
      source: supersonal,
        select: function (event, ui) {
          $("#txtcomcodpers").val(ui.item.code);
        }
    });
}


function _createtable(td,idtbttabla) {
    var total = 0;
    var fila='';
    for (let i = 0; i < td.length; i++) {
        fila +="<td class='tdcontent' style=display:"+td[i][1]+">"+td[i][0]+"</td>";
        if(td[i][2] == 'p'){total =Number(total + td[i][0])}
    }

    var btn = document.createElement("TR");
    btn.innerHTML=fila;
    document.getElementById(idtbttabla).appendChild(btn);
    _lcproductos();
}

function _lcproductos() {
    $("#txtcompclase").val('');
    $("#txtcompcodPro").val('');
    $("#txtcompprod").val('');
    $("#txtcomcantidad").val('');
    $("#txtcomprecio").val('');
    $("#txtcomserie").val('');
}

function _lcform() {
    document.getElementById("frmcomprobante").reset();
    $('#tbmaterialcompro').find("tr:gt(0)").remove();
}

function _guardarpers(personal) {
    var usu = $("#vrcodpersonal").val();
    $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  'c_comprobante.php',
        data:personal+"&accion=guardarperso&usuario="+usu,
        success:  function(response){
            if(response == 1){
                Mensaje1("Se registro el personal","success");
                autocompletarpersonal();
                document.getElementById("frmgudarpers").reset();
            }else{
                Mensaje1(response,"error");
            }
        }
    }); 
}