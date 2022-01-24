var produc = ''; usu = '';t = 'm';produccion='';cantxinsumo = '';
var cab = 0;totalpaquete = 0;cantidad=0;var qrcode = '';faltacaja = 0 ;
$(document).ready(function () {
    lstitemsfor();
    hora();
    usu = $("#vrcodpersonal").val();

    $('#tbproduccion').on('click', 'tbody tr', function(event) {
        $(this).addClass('highlight').siblings().removeClass('highlight');
        produccion = $(this).find("td:eq(0)").text();
    });

    $("#btngocurrencia").on('click',function(){
        gocurrencia($("#txtocurrencias").val());   
    });

    $("#btnnuevo").on('click',function() {
        lmp();
    });

    $("#btnmerma").on('click',function() {
         t = 'm'
         enabled();
    })

    $("#btnresiduos").on('click',function() {
        t = 'r'; disabled();
    });

    $("#btndesecho").on('click',function() {
        t = 'd'; disabled();
    });

    $("#btnguardar").on('click',function(){
        fechmerma = $("#fechmerma").val();
        horamerma = $("#hormerma").val();
        fechincidencia = $("#fehincidencia").val();
        horaincidencia = $("#horincidencia").val();
        r = itemstabla();
        observacion = $("#txtobservacion").val();
        tipomerma = $("#slctipomerma").val();
        guardar(fechmerma,horamerma,fechincidencia,horaincidencia,observacion,tipomerma,r);
    });

    $("#btnagregarmater").on('click',function() {
        var t = datosrepetidos('tbdreportinsu',$("#txtcodpro").val().trim());
        if(!t){Mensaje1("Error ya se agrego el material","error") ; return};
        b2 = "<a  style='margin-right: 2px;margin-bottom: 1px;' class='btn btn-primary  btn-sm'>"+
        "<i class='icon-pencil' title='Modificar material'></i></a>"+
        "<a id='btneliminar' style='margin-right: 2px;margin-bottom: 1px;' class='btn btn-danger  btn-sm'>"+
        "<i class='icon-trash' title='Eliminar material'></i></a>";
        if($("#txtcodpro").val().trim().length == 0 ){Mensaje1("Error seleccione insumo","error");}
        if($("#txtcantidad").val().trim().length == 0 ){Mensaje1("Error ingrese cantidad","error");}
        if($("#txtcantidad").val() > cantidad){Mensaje1("Error la cantidad no puede se mayor a la insumo utilizados","error");return;}
        if($("#txtcantidad").val() == 0){Mensaje1("Errro ingrese cantidad","error");}
        
        array = [
            a = [$("#txtcodpro").val(),'none',''],
            b = [$("#txtinsumos").val(),'',''],
            c = [$("#txtcantidad").val(),'',''],
            d = [$("#slctipomerma").val(),'none',''],
            i = [b2,'',''],
        ]
        _createtable2(array,'tbdreportinsu');
        
        $("#txtcodpro").val('');
        $("#txtinsumos").val('');
        $("#txtcantidad").val('');
    });

    $(document).on('click','#btneliminar',function() {
        $(this).closest('tr').remove();
    });

    $("#btngavances").on('click',function() {
        verificarfinprod($("#mdcodprod").val(),$("#mdcajasxsacar").val(),$("#mdcantxcaja").val(),
        $("#mdtotal").val());
     
    });

    $(document).on('click','#btnavances',function(){
        $("#mdlote").val($(this).parents('tr').find('td:nth-child(4)').text());
        $("#mdcodprod").val($(this).parents('tr').find('td:nth-child(1)').text());
        $("#mdtotal").val($(this).parents('tr').find('td:nth-child(5)').text());
        $("#mdproduc").val($(this).parents('tr').find('td:nth-child(6)').text());
        v_avances($(this).parents('tr').find('td:nth-child(1)').text());/**/
    });

    $('#mdcantxcaja').keyup(function(e) {
        sobras = $("#mdtotal").val() %  $(this).val();
        paquete = Math.trunc($("#mdtotal").val() / $(this).val()) + 1;
        if($(this).val().trim().length != 0 && $(this).val() != 0){
            if(sobras > 0){
                totalpaquete = paquete;
                $("#mdcajasxsacar").val(paquete);
                $("#lblmensaje").text("De los "+paquete+" paquete(s) uno contendra solo "+ sobras +" unidades");
            }else{
                totalpaquete = paquete - 1;
                $("#mdcajasxsacar").val(paquete - 1);
                $("#lblmensaje").text("");
            }
        }else{ $("#mdcajasxsacar").val('')}
    });

    $("#btnmdinsumo").on('click',function(){
        lstinsumo()
    });

    $(document).on('click','#btnselectmate',function(){
        cantxinsumo = $(this).parents('tr').find('td:nth-child(4)').text();
        $("#txtcodpro").val($(this).parents('tr').find('td:nth-child(2)').text());
        $("#txtinsumos").val($(this).parents('tr').find('td:nth-child(3)').text());
        cantidad = $(this).parents('tr').find('td:nth-child(4)').text();
        $("#sltipoinsum").val($(this).parents('tr').find('td:nth-child(5)').text().trim());
        $("#mdlstinsumos").modal('hide');
    });

    $(document).on('click',"#btnocurencia",function(){
        lstocurrencia();
    });

});

function lstocurrencia() {
    $.ajax({
      dataType:'text',
      type: 'POST', 
      url:  'c_produccion.php',
      data:"accion=lstocurrencia&produccion="+produccion,
      success: function(r) {
          obj = JSON.parse(r);
          $("#tbocurrencia > tbody").empty();
          $.each(obj['dato'], function(i, item) {
            fecha = item[4].split(' '); 
            var fila = '';
            fila +="<td class='tdcontent'>"+item[2]+"</td>";
            fila +="<td>"+fecha[0].replace(/^(\d{4})-(\d{2})-(\d{2})$/g,'$3/$2/$1')+"</td>";
            var btn = document.createElement("TR");
            btn.innerHTML=fila;
            document.getElementById("tbdocurrencia").appendChild(btn);
          });
      }
    });
}

function lstitemsfor() {
    $.ajax({
      dataType:'text',
      type: 'POST', 
      url:  'c_produccion.php',
      data:"accion=lstproduccion",
      success: function(r) {
        obj = JSON.parse(r);createtable(obj['dato']);
      }
    });
}

function createtable(obj) {
    b2 ="<a id='btnavances' style='margin-right: 2px;margin-bottom: 1px;' class='btn btn-primary  btn-sm' data-bs-toggle='modal' data-bs-target='#mdregisavances'>"+
         "<i class='icon-edit' title='Registrar avances'></i></a>"+
         "<a id='btnocurencia' style='margin-right: 2px;margin-bottom: 1px;' class='btn btn-danger  btn-sm' data-bs-toggle='modal' data-bs-target='#mdocurrencia'>"+
         "<i class='icon-warning' title='Registrar avances'></i></a>";
    $("#tbproduccion > tbody").empty();
    $.each(obj, function(i, item) {
        cliente = (item[3] == null) ? '' : item[3];
        produc = item[0];
        var fila='';
        fila +="<td class='tdcontent' style=display:none>"+item[0]+"</td>";
        fila +="<td >"+item[2]+"</td>";
        fila +="<td >"+cliente+"</td>";
        fila +="<td style=display:none>"+item[6]+"</td>";
        fila +="<td >"+item[9]+"</td>";
        fila +="<td class='tdcontent' style=display:none>"+item[1]+"</td>";
        fila +="<td class='tdcontent'>"+b2+"</td>";
        var btn = document.createElement("TR");
        btn.innerHTML=fila;
        document.getElementById("tbdproduccion").appendChild(btn);
    });
}

function gocurrencia(ocurrencia){
    $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  'c_produccion.php',
        data:"accion=ocurrencia&produccion="+produccion+"&ocurrencia="+ocurrencia+"&usu="+usu,
        success: function(r) {
            if(r==1){Mensaje1("Se registro la observación","success");
            $("#txtocurrencias").val('');$("#mdocurrencia").modal('hide')}
            else{ Mensaje1(r.trim(),"error");} 
        }
      }); 
}

function Mensaje1(texto,icono){
    Swal.fire({icon: icono,title: texto,});
}

function enabled() {
    $("#fechmerma").removeAttr('disabled');
    $("#hormerma").removeAttr('disabled');
    $("#fehincidencia").removeAttr('disabled');
    $("#horincidencia").removeAttr('disabled');
    $("#slctipomerma").removeAttr('disabled');
}

function disabled() {
    $("#fechmerma").attr('disabled',true);
    $("#hormerma").attr('disabled',true);
    $("#fehincidencia").attr('disabled',true);
    $("#horincidencia").attr('disabled',true);
    $("#slctipomerma").attr('disabled',true);
}

function guardar(fechmerma,horamerma,fechincidencia,horaincidencia,observacion,tipomerma,r) {
    var materiales = {r};
    mensaje = '';
    $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  'c_produccion.php',
        data:{
            "accion" : 'gdatos',
            "produccion" : produc,
            "fechmerma" : fechmerma,
            "horamerma" : horamerma,
            "fechincidencia" : fechincidencia,
            "horaincidencia" : horaincidencia,
            "observacion" : observacion,
            "tipomerma" : tipomerma,
            "usu":usu,
            "t" : t,
            "items":JSON.stringify(materiales)
        } ,
        success: function(e) {
            if(e==1){
                mensaje = (t == 'm') ? "la merma" : (t == 'd') ? "el desecho" : "el residuo";
                Mensaje1("Se registro correctamente "+mensaje,"success"); 
                lmp(); enabled();t = 'm';hora();
            }else{
                Mensaje1(e,"error");
            }
        }
      });
}

function _createtable2(td,idtbttabla) {
    var total = 0;var fila='';
    for (let i = 0; i < td.length; i++) {
        fila +="<td class='tdcontent' style=display:"+td[i][1]+">"+td[i][0]+"</td>";
        if(td[i][2] == 'p'){total =Number(total + td[i][0])}
    }
    var btn = document.createElement("TR");
    btn.innerHTML=fila;
    document.getElementById(idtbttabla).appendChild(btn);
}

function datosrepetidos(tabla,dato) {
    filas = $("#"+tabla+" tr");
    for (let l = 0; l < filas.length; l++) {
        if($(filas[l]).find("td")[0].innerHTML == dato){
            return false;
        }
    }
  return true;
}

function itemstabla() {
    var td =  $("#tbdreportinsu tr");
    var tds = [];
    for (let l = 0; l < td.length; l++) {
        tds[l] =[$(td[l]).find("td")[0].innerHTML,$(td[l]).find("td")[2].innerHTML
        ,$(td[l]).find("td")[3].innerHTML]
    }
    return tds;
}

function hora(){
    var laHora = new Date();
    var horario = laHora.getHours();
    var minutero = laHora.getMinutes();
    if(minutero<10)minutero = "0" + minutero;
    if(horario<10) horario = "0" + horario;
    document.getElementById('hormerma').value = horario+":"+minutero
    document.getElementById('horincidencia').value = horario+":"+minutero
} 

function lstinsumo(){
    $.ajax({
      dataType:'text',
      type: 'POST', 
      url:  'c_produccion.php',
      data:{"accion" : 'insumo',"produccion" : produccion} ,
      success:  function(response){
          obj = JSON.parse(response);
          if(obj['m'] == 1){
            $("#tblmdinsumo > tbody").empty();
            b2 ="<a id='btnselectmate' style='margin-right: 2px;margin-bottom: 1px;' class='btn btn-primary  btn-sm'>"+
            "<i class='icon-edit' title='Registrar avances'></i></a>";
            $.each(obj['dato'], function(i, item) {
                var fila = '';
                fila +="<td class='tdcontent' style=display:none>"+item[0]+"</td>";
                fila +="<td style=display:none>"+item[1]+"</td>";
                fila +="<td >"+item[2]+"</td>";
                fila +="<td >"+item[3]+"</td>";
                fila +="<td style=display:none>"+item[4]+"</td>";
                fila +="<td class='tdcontent'>"+b2+"</td>";
                var btn = document.createElement("TR");
                btn.innerHTML=fila;
                document.getElementById("tbdlmdinsumo").appendChild(btn);
            });
            $("#mdlstinsumos").modal('show');
          }else
          Mensaje1(obj['m'],"error");
         
      }
    });
}

function guardaravances(frm,e){
    mdtotal = $("#mdtotal").val();
    $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  'c_produccion.php',
        data:frm+"&accion=gavances&usu="+usu+"&produccion="+produccion+
            "&total="+totalpaquete+"&fin="+e+"&mdtotal="+mdtotal,
        success:  function(e){
            if(e == 1){
                Mensaje3("Se registron los datos" ,"success","Antes de cerrar la ventana imprima los tickes");
            }else{Mensaje1(e,"error");}
        }
    });
}  

function v_avances($produccion){
    $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  'c_produccion.php',
        data:"accion=v_avances&produccion="+$produccion,
        success:  function(e){
            obj = JSON.parse(e);
            if(obj['t'] == 1){
                $("#mdtara").val(obj['dato'][0][9]);
                $("#mdpesoneto").val(obj['dato'][0][10]);
                $("#mdcantxcaja").val(obj['dato'][0][7]);
                $("#mdtara").attr('disabled',true);
                $("#mdpesoneto").attr('disabled',true);
                $("#mdcantxcaja").attr('disabled',true);
                $("#mdcanxbolsa").attr('disabled',true);
                $("#mdcajasxsacar").val(obj['falta']);
                faltacaja = obj['falta']
                cab = 1;
            }else{
                $("#mdtara").val('');
                $("#mdpesoneto").val('');
                $("#mdcantxcaja").val('');
                $("#mdcajasxsacar").val('');
                $("#mdtara").removeAttr('disabled');
                $("#mdpesoneto").removeAttr('disabled');
                $("#mdcantxcaja").removeAttr('disabled');
                $("#mdcanxbolsa").removeAttr('disabled');
                cab = 0;
            }
        }
      }); 
}

function guardaravancesits(produ,avance,e,producto){
   $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  'c_produccion.php',
        data:"accion=gavancesitems&avance="+avance+"&usu="+usu+"&produ="+produ+"&fin="+e+
        "&mdproduc="+producto+"&faltante="+faltacaja,
        success:  function(e){
            if(e == 1){
               Mensaje3("Se registron los datos" ,"success","Antes de cerrar la ventana imprima los tickes");
            }else{Mensaje1(e,"error");}
        }
    });
}  

function Mensaje3(title,icon,text) {
    Swal.fire({title: title,icon: icon,text: text,showCancelButton: true,
        confirmButtonText: 'Imprimir',cancelButtonColor: '#d33',cancelButtonText: "Cerrar"
      }).then((result) => {
        if (result.isConfirmed) {
            lstavance($("#mdcodprod").val());
        }
      })
}

function verificarfinprod(produccion,cantidad,cantxpa,total){
    $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  'c_produccion.php',
        data:{
            "accion" : 'validafinpro',
            "produccion" : produccion,
            "cantidad" : cantidad,
            "cantxpa" :cantxpa,"total":total,
        } ,
        success:  function(e){
           if(e == 0){
                Mensaje2("Se terminara la produccion",'info','¿Desea continuar?',e);
           }else if(e == 1){
                if(cab == 0){ 
                    guardaravances($("#frmavances").serialize(),e);
                }else if(cab == 1){
                    guardaravancesits($("#mdcodprod").val(),$("#mdcajasxsacar").val(),e,$("#mdproduc").val())
                }
           }else{
               Mensaje1(e,"error");
           }
        }
      });
}

function Mensaje2(title,icon,text,e) {
    Swal.fire({title: title,icon: icon,text: text,showCancelButton: true,
        confirmButtonText: 'Aceptar',cancelButtonColor: '#d33',cancelButtonText: "Cerrar"
      }).then((result) => {
        if (result.isConfirmed) {
            if(cab == 0){ 
                guardaravances($("#frmavances").serialize(),e);
             }else if(cab == 1){
                guardaravancesits($("#mdcodprod").val(),$("#mdcajasxsacar").val(),e,$("#mdproduc").val())
             }
        }
      })
}

function lstavance(produccion){
    $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  'c_produccion.php',
        data:{"accion" : 'lstavance',"produccion" : produccion} ,
        success:  function(e){
            obj = JSON.parse(e);
            $.each(obj['dato'], function(i, item) {
               demoFromHTML(item[6],item[3],obj['fecha'],item[10],item[7],item[9],item[8],obj['tipo'],obj['id'])
            }); 
        }
    });
}

function demoFromHTML(cant,lote,fecha,peso,cantidad,tara,total,fin,avance) {
    qr(fecha,lote);
    let base64Image = $('#codigo').attr('src');
    count = 0; tipo = 0;
    var doc = new jsPDF();doc.setFontSize(14);doc.setFontType('normal');
    var hojas = 0;
    if(Math.floor(cant / 8) == 0){hojas = 1}else{hojas = Math.floor(cant / 8)}
    if(cant % 8 != 0){hojas += 1}
    for (let i = 0; i < cant; i++) {
        if(fin == 0 && (i+1) == cant && (total % cantidad) != 0 ){
            cantidad = total % cantidad; peso = (peso / cantidad)}
        if(i % 2 == 0){x = 2; xr = 0; xx = 59}else{x = 107 ;xr=105; xx = 59 * 2.78}
        if(tipo == 8){doc.addPage(); tipo = 0;}
        if(tipo == 0 || tipo == 1){
            doc.rect(xr, 74 * 0, 105, 74.20)
                doc.text('FECHA: '+fecha, x, 9); 
                doc.text('CANTIDAD: '+cantidad + " Uds.",  xx, 9); 

                doc.text('PESO NETO: ' + Number(peso).toFixed(2) +" Kg",x, 19); //29
                doc.text('TARA: '+ Number(tara).toFixed(2) +" Kg",xx, 19); //49
     
                
                doc.text('PESO TOTAL: '+(Number(peso)+ Number(tara)).toFixed(2) +" Kg",x, 29); //59
                doc.text('LOTE: '+lote, xx, 29);
                
                doc.addImage(base64Image,'JPEG', xx, 33, 40, 40);
                
                tipo++;
        }else if(tipo  == 2 || tipo == 3){
            doc.rect(xr, 74 * 1, 105, 74.20)
                doc.text('FECHA: '+fecha, x, 83);
                doc.text('CANTIDAD: '+cantidad + " Uds.", xx, 83); //103

                doc.text('PESO NETO: '+ Number(peso).toFixed(2) +" Kg",x, 93);
                doc.text('TARA: '+ Number(tara).toFixed(2) +" Kg", xx, 93);

                
                doc.text('PESO TOTAL: '+(Number(peso)+ Number(tara)).toFixed(2) +" Kg", x, 103);
                doc.text('LOTE: '+lote, xx, 103);


                doc.addImage(base64Image,'JPEG', xx, 107, 40, 40);
                tipo++;

        }else if(tipo  == 4 || tipo == 5){
            doc.rect(xr, 74 * 2, 105, 74.20)
                doc.text('FECHA: '+fecha, x, 157);
                doc.text('CANTIDAD: '+cantidad + " Uds.", xx, 157);

                doc.text('PESO NETO: '+ Number(peso).toFixed(2) +" Kg", x, 167);
                doc.text('TARA: '+ Number(tara).toFixed(2) +" Kg", xx, 167);
                

                doc.text('PESO TOTAL: '+(Number(peso)+ Number(tara)).toFixed(2) +" Kg", x, 177);
                doc.text('LOTE: '+lote, xx, 177);

                doc.addImage(base64Image,'JPEG', xx, 181, 40, 40);
                tipo++;

        }else if(tipo  == 6 || tipo == 7){
            doc.rect(xr, 74 * 3, 105, 74.20)
                doc.text('FECHA: '+fecha, x, 231);
                doc.text('CANTIDAD: '+cantidad + " Uds.",xx, 231);
                
                doc.text('PESO NETO: '+Number(peso).toFixed(2) +" Kg", x, 241);
                doc.text('TARA: '+ Number(tara).toFixed(2) +" Kg", xx, 241);
                
                doc.text('PESO TOTAL: '+(Number(peso)+ Number(tara)).toFixed(2) +" Kg", x, 251);
                doc.text('LOTE: '+lote, xx, 251);

                doc.addImage(base64Image,'JPEG', xx, 255, 40, 40);
                tipo++;
        }
    }
    updateimpresion(avance)
    window.open(doc.output('bloburl'), '_blank');
}

function updateimpresion(avance){
    $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  'c_produccion.php',
        data:{"accion" : 'updimpresion',"avance" : avance} ,
        success:  function(e){
           if(e != 1){Mensaje1(e,"error")}
           $("#mdregisavances").modal('hide');
           lstitemsfor();
        }
    });  
}

function lmp(){
    document.getElementById("frmfabricacion").reset();
    $('#tbreportinsu').find("tr:gt(0)").remove();
}

function qr(fecha,lote){
    new QRious({
        element: document.querySelector("#codigo"),
        value: "Lote: "+ lote + " Fecha: "+fecha, 
        size: 200,
        backgroundAlpha: 0, 
        foreground: "#000", 
        level: "H", 
    });
    
}