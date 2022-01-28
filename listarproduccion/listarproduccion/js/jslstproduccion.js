var usu = '';t = 'm';produccion='';cantxinsumo = ''; tipobtn = 'a';color = '';
var cab = 0;totalpaquete = 0;cantidad=0;var qrcode = '';faltacaja = 0 ;sobra=0;
$(document).ready(function () {
    lstitemsfor();
    hora();
    disabletab();
    usu = $("#vrcodpersonal").val();

    $('#tbproduccion').on('click', 'tbody tr', function(event) {
        $(this).addClass('highlight').siblings().removeClass('highlight');
        produccion = $(this).find("td:eq(0)").text(); 
        color = $(this).find("td:eq(6)").text(); 
    });

    $("#btngocurrencia").on('click',function(){
        gocurrencia($("#txtocurrencias").val());   
    });

    $("#btnnuevo").on('click',function() {
        lmp();
    });

    $("#btnmerma").on('click',function() {
         t = 'm';enabled();
    })

    $("#btnresiduos").on('click',function() {
        t = 'r'; disabled();
    });

    $("#btndesecho").on('click',function() {
        t = 'd'; disabled();
    });

    $("#btnguardar").on('click',function(){
        fechincidencia = $("#fehincidencia").val();
        horaincidencia = $("#horincidencia").val();
        cantidad = $("#txtcantidad").val();
        observacion = $("#txtobservacion").val();
        tipomerma = $("#slctipomerma").val();
        falla = $("#txtprodfalla").val();
        guardar(fechincidencia,horaincidencia,observacion,tipomerma,cantidad,falla);
    });

    $("#btngavances").on('click',function() {
        if(faltacaja == 0 && tipobtn == 'f'){finproduccion($("#mdcodprod").val()); return;}
        if(faltacaja == 0 && tipobtn == 'a'){Mensaje1("Error no ya no hay avances que registrar","error");return;}
        
        if(t != 'r' && faltacaja != 0){
            $("#mdregiresiduo").modal('show');
        }else{
            verificarfinprod($("#mdcodprod").val(),$("#mdcajasxsacar").val(),$("#mdcantxcaja").val(),
            $("#mdtotal").val());
        }
    });

    $(document).on('click','#btnfinalizar',function() {
        inputavance(this,'t'); tipobtn = 'f';
    })

    $(document).on('click','#btnavances',function(){
        inputavance(this,'a'); tipobtn = 'a'
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
                $("#lblmensaje").text('Paquetes por sacar ' + totalpaquete);
            }
        }else{ $("#mdcajasxsacar").val('')}
    });

    $(document).on('click',"#btnocurencia",function(){
        lstocurrencia();
    });

    $(document).on('click',"#btnimprimir",function(){
        cant=  $("#mdcajasxsacar").val();var fin = 1;
        lote = $("#mdlote").val();
        fecha = date();
        peso = $("#mdpesoneto").val();
        cantidad = $("#mdcantxcaja").val();
        tara = $("#mdtara").val();
        total = $("#mdtotal").val();
        topaqu = (cantidad * cant + sobra);
        if(topaqu >= total){fin = 0}else{fin = 1}

        if(tipobtn == 'f' && cant == 0){
            lstavance($("#mdcodprod").val())
        }else if(tipobtn == 'f' && cant != 0){
            perdida($("#mdcodprod").val(),cant,lote,fecha,peso,cantidad,tara,total,fin)
          }

        if(tipobtn == 'a'){
            if(cant > totalpaquete){Mensaje1("Error paquetes a sacar es mayor a lo indicado","error");return;}
            perdida($("#mdcodprod").val(),cant,lote,fecha,peso,cantidad,tara,total,fin)
        }
    });

    $("#btncerragre").on('click',function() {
        if(t == 'd'){Mensaje1("Error registre desechos y sobrantes antes de cerrar","error")}
        else{$("#mdregiresiduo").modal('hide');}
    });

    $("#btnclose").on('click',function() {
        if(t == 'd'){Mensaje1("Error registre desechos y sobrantes antes de cerrar","error")}
        else{$("#mdregiresiduo").modal('hide');}
    })
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
    b2 ="<a id='btnfinalizar' style='margin-right: 2px;margin-bottom: 1px;' class='btn btn-primary  btn-sm' data-bs-toggle='modal' data-bs-target='#mdregisavances'>"+
        "<i class='icon-check' title='Registrar avances'></i></a>"+
        "<a id='btnavances' style='margin-right: 2px;margin-bottom: 1px;' class='btn btn-primary  btn-sm' data-bs-toggle='modal' data-bs-target='#mdregisavances'>"+
         "<i class='icon-edit' title='Registrar avances'></i></a>"+
         "<a id='btnocurencia' style='margin-right: 2px;margin-bottom: 1px;' class='btn btn-danger  btn-sm' data-bs-toggle='modal' data-bs-target='#mdocurrencia'>"+
         "<i class='icon-warning' title='Registrar avances'></i></a>";
    $("#tbproduccion > tbody").empty();
    $.each(obj, function(i, item) {
        cliente = (item[3] == null) ? '' : item[3];
        var fila='';
        fila +="<td class='tdcontent' style=display:none>"+item[0]+"</td>";
        fila +="<td >"+item[2]+"</td>";
        fila +="<td >"+cliente+"</td>";
        fila +="<td style=display:none>"+item[6]+"</td>";
        fila +="<td >"+item[9]+"</td>";
        fila +="<td class='tdcontent' style=display:none>"+item[1]+"</td>";
        fila +="<td class='tdcontent' style=display:none>"+item[11]+"</td>";
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
        data:"accion=ocurrencia&produccion="+produccion+"&ocurrencia="+ocurrencia+"&usu="+usu
        ,beforeSend: function () {
            $('.ajax-loader').css("visibility", "visible");
        },success: function(r) {
            if(r==1){Mensaje1("Se registro la observación","success");
            $("#txtocurrencias").val('');$("#mdocurrencia").modal('hide')}
            else{ Mensaje1(r.trim(),"error");} 
        },complete: function(){
            $('.ajax-loader').css("visibility", "hidden");
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
    $("#txtprodfalla").removeAttr('disabled');
}

function disabled() {
    $("#fechmerma").attr('disabled',true);
    $("#hormerma").attr('disabled',true);
    $("#fehincidencia").attr('disabled',true);
    $("#horincidencia").attr('disabled',true);
    $("#slctipomerma").attr('disabled',true);
    $("#txtprodfalla").attr('disabled',true);
}

function guardar(fechincidencia,horaincidencia,observacion,tipomerma,cantidad,falla) {
    mensaje = '';
    $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  'c_produccion.php',
        data:{
            "accion" : 'gdatos',
            "produccion" : produccion,
            "fechincidencia" : fechincidencia,
            "horaincidencia" : horaincidencia,
            "observacion" : observacion,
            "tipomerma" : tipomerma,
            "usu":usu,
            "t" : t,
            "cantidad":cantidad,
            "color" : color,
            "cantprofalla" : falla
        },beforeSend: function () {
            $('.ajax-loader').css("visibility", "visible");
        },success: function(e) {
            if(e==1){
                mensaje = (t == 'm') ? "la merma" : (t == 'd') ? "el desecho" : " los sobrantes";
                Mensaje1("Se registro correctamente "+mensaje,"success"); 
                if(t == 'm'){$("#btndesecho").removeAttr('disabled');$(".merma").removeClass('active');
                $(".desechos").addClass('active');disabled(); $("#btnmerma").removeAttr('checked');
                $("#btnmerma").attr('disabled',true); t='d'; 
                lmp();hora(); lstitemsfor(); return;}

                if(t == 'd'){$("#btnresiduos").removeAttr('disabled');
                $(".sobra").addClass('active');disabled();$("#btndesecho").removeAttr('checked');
                $("#btndesecho").attr('disabled',true);$(".desechos").removeClass('active'); 
                lmp();hora(); t='r'; return;}
                
                if(t == 'r'){$("#mdregiresiduo").modal('hide'); 
                disabletab(); enabled(); $("#btnmerma").removeAttr("disabled");lmp();hora()
                $(".sobra").removeClass('active');$(".merma").addClass('active');$("#btnmerma").attr('checked');}
            }else{
                Mensaje1(e,"error");
                $('.ajax-loader').css("visibility", "hidden");
            }
        },complete: function(){
            $('.ajax-loader').css("visibility", "hidden");
        }
      });
}


function hora(){
    var laHora = new Date();
    var horario = laHora.getHours();
    var minutero = laHora.getMinutes();
    if(minutero<10)minutero = "0" + minutero;
    if(horario<10) horario = "0" + horario;
    document.getElementById('horincidencia').value = horario+":"+minutero
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
        success:function(e){
            if(e == 1){
                if(cab == 0){ 
                    guardaravances($("#frmavances").serialize());
                }else if(cab == 1){
                    guardaravancesits($("#mdcodprod").val(),$("#mdcajasxsacar").val(),$("#mdproduc").val());
                } //cambiar el valor de e por otra variable
            }else{Mensaje1(e,"error");}
        }
      });
}

function guardaravances(frm){
    mdtotal = $("#mdtotal").val();
    $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  'c_produccion.php',
        data:frm+"&accion=gavances&usu="+usu+"&produccion="+produccion+
            "&total="+totalpaquete+"&mdtotal="+mdtotal
        ,beforeSend: function () {
            $('.ajax-loader').css("visibility", "visible");
        },success:function(re){
            obj = JSON.parse(re);
            if(obj['suc'] == 1){
                if(obj['termi'] == 1){faltacaja = 0}
                $("#lblmensaje").text('Paquetes restantes ' + (totalpaquete - $("#mdcajasxsacar").val()));
                Mensaje3("Se registron los datos" ,"success","Antes de cerrar la ventana imprima los tickes");
            }else{
                Mensaje1(obj['suc'],"error");
                $('.ajax-loader').css("visibility", "hidden");
                t = 'm';
            }
        },complete: function(){
            $('.ajax-loader').css("visibility", "hidden");
        }
    });
}  

function v_avances($produccion,inavance){
    $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  'c_produccion.php',
        data:"accion=v_avances&produccion="+$produccion,
        success:function(e){
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
                sobra = (obj['dato'][0][7] * obj['dato'][0][6]);
                totalpaquete = faltacaja = obj['falta']
                $("#lblmensaje").text('Paquetes restantes ' + obj['falta']);
                if(inavance == 't' || faltacaja == 0){$("#mdcajasxsacar").attr('disabled',true);}
                else{$("#mdcajasxsacar").removeAttr('disabled')}
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
                $("#mdcajasxsacar").removeAttr('disabled');
                faltacaja = 1;
                cab = 0;
                $("#lblmensaje").text('');
            }
        }
      }); 
}

function guardaravancesits(produ,avance,producto){
   $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  'c_produccion.php',
        data:"accion=gavancesitems&avance="+avance+"&usu="+usu+"&produ="+produ+
        "&mdproduc="+producto+"&faltante="+faltacaja
        ,beforeSend: function () {
            $('.ajax-loader').css("visibility", "visible");
        },
        success:function(res){
            obj = JSON.parse(res);
            if(obj['suc'] == 1){
               if(obj['termi'] == 1){faltacaja = 0;}
               if(obj['termi'] == 1 && tipobtn == 'f'){faltacaja = 0;
                 finproduccion($("#mdcodprod").val()); 
                 return;}
                 $("#lblmensaje").text('Paquetes restantes ' + (totalpaquete - $("#mdcajasxsacar").val()));
              Mensaje3("Se registron los datos" ,"success","Antes de cerrar la ventana imprima los tickes");
            }else{Mensaje1(obj['suc'],"error");
            $('.ajax-loader').css("visibility", "hidden");
                t = 'm';
            }
        },complete: function(){
            $('.ajax-loader').css("visibility", "hidden");
        }
    });
}  

function Mensaje3(title,icon,text) {
    $("#mdtara").attr('disabled',true);
    $("#mdpesoneto").attr('disabled',true);
    $("#mdcantxcaja").attr('disabled',true);
    $("#mdcanxbolsa").attr('disabled',true);
    t = 'm';
    Swal.fire({title: title,icon: icon,text: text,confirmButtonText: 'Aceptar',
    })
}

function lstavance(produccion){
    $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  'c_produccion.php',
        data:{"accion" : 'lstavance',"produccion" : produccion} ,
        success:function(e){
            obj = JSON.parse(e);
           if(obj['succ'] == 1){
            $.each(obj['dato'], function(i, item) {
                demoFromHTML(obj['cantidad'],item[3],obj['fecha'],item[10],item[7],item[9],item[8],obj['tipo'],obj['id'])
            }); 
           }else{
                Mensaje1("Error no hay datos que imprimir","error");
           }
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
        if(i % 2 == 0){x = 2; xr = 0; xx = 59 ; xqr = 32}else{x = 107 ;xr=105; xx = 59 * 2.78;xqr = 59 *2.30}
        if(tipo == 8){doc.addPage(); tipo = 0;}
        if(tipo == 0 || tipo == 1){
            doc.rect(xr, 74 * 0, 105, 74.20)
                doc.text('FECHA: '+fecha, x, 9); 
                doc.text('CANTIDAD: '+cantidad + " Uds.",  xx, 9); 
                doc.text('PESO NETO: ' + Number(peso).toFixed(2) +" Kg",x, 19); 
                doc.text('TARA: '+ Number(tara).toFixed(2) +" Kg",xx, 19); 
                doc.text('PESO TOTAL: '+(Number(peso)+ Number(tara)).toFixed(2) +" Kg",x, 29);
                doc.text('LOTE: '+lote, xx, 29);
                doc.addImage(base64Image,'JPEG', xqr, 33, 40, 40);
                tipo++;
        }else if(tipo  == 2 || tipo == 3){
            doc.rect(xr, 74 * 1, 105, 74.20)
                doc.text('FECHA: '+fecha, x, 83);
                doc.text('CANTIDAD: '+cantidad + " Uds.", xx, 83); 
                doc.text('PESO NETO: '+ Number(peso).toFixed(2) +" Kg",x, 93);
                doc.text('TARA: '+ Number(tara).toFixed(2) +" Kg", xx, 93);
                doc.text('PESO TOTAL: '+(Number(peso)+ Number(tara)).toFixed(2) +" Kg", x, 103);
                doc.text('LOTE: '+lote, xx, 103);
                doc.addImage(base64Image,'JPEG', xqr, 107, 40, 40);
                tipo++;

        }else if(tipo  == 4 || tipo == 5){
            doc.rect(xr, 74 * 2, 105, 74.20)
                doc.text('FECHA: '+fecha, x, 157);
                doc.text('CANTIDAD: '+cantidad + " Uds.", xx, 157);
                doc.text('PESO NETO: '+ Number(peso).toFixed(2) +" Kg", x, 167);
                doc.text('TARA: '+ Number(tara).toFixed(2) +" Kg", xx, 167);
                doc.text('PESO TOTAL: '+(Number(peso)+ Number(tara)).toFixed(2) +" Kg", x, 177);
                doc.text('LOTE: '+lote, xx, 177);
                doc.addImage(base64Image,'JPEG', xqr, 181, 40, 40);
                tipo++;

        }else if(tipo  == 6 || tipo == 7){
            doc.rect(xr, 74 * 3, 105, 74.20)
                doc.text('FECHA: '+fecha, x, 231);
                doc.text('CANTIDAD: '+cantidad + " Uds.",xx, 231);
                doc.text('PESO NETO: '+Number(peso).toFixed(2) +" Kg", x, 241);
                doc.text('TARA: '+ Number(tara).toFixed(2) +" Kg", xx, 241);
                doc.text('PESO TOTAL: '+(Number(peso)+ Number(tara)).toFixed(2) +" Kg", x, 251);
                doc.text('LOTE: '+lote, xx, 251);
                doc.addImage(base64Image,'JPEG', xqr, 255, 40, 40);
                tipo++;
        }
    }
    //updateimpresion(avance)
    window.open(doc.output('bloburl'), '_blank');
}

function updateimpresion(avance){
    $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  'c_produccion.php',
        data:{"accion" : 'updimpresion',"avance" : avance} ,
        success:  function(e){
           if(e != 1){Mensaje1(e,"error")};$("#mdregisavances").modal('hide');
           lstitemsfor();
        }
    });  
}

function lmp(){
    document.getElementById("mdregistroresi").reset();
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

function date(){
    n =  new Date();y = n.getFullYear();m = n.getMonth() + 1;d = n.getDate();
    if(m < 10) m = "0"+m;
    return d + "/" + m + "/" + y;
}

function disabletab() {
    $("#btndesecho").prop("disabled", true);
    $("#btnresiduos").prop("disabled",true);
}

function inputavance(tab,inavance) {
        $("#mdlote").val($(tab).parents('tr').find('td:nth-child(4)').text());
        $("#mdcodprod").val($(tab).parents('tr').find('td:nth-child(1)').text());
        $("#mdtotal").val($(tab).parents('tr').find('td:nth-child(5)').text());
        $("#mdproduc").val($(tab).parents('tr').find('td:nth-child(6)').text());
        v_avances($(tab).parents('tr').find('td:nth-child(1)').text(),inavance);/**/
}

function finproduccion(produccion){
    $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  'c_produccion.php',
        data:{
            "accion" : 'finproduc',
            "produccion" : produccion,
            "usu" : usu,
        },beforeSend: function () {
            $('.ajax-loader').css("visibility", "visible");
        },success:function(e){
            if(e == 1){ Mensaje1("Se finalizo la produccion","success");
            lstitemsfor(); $("#mdregisavances").modal('hide'); t = 'm'}
            else{
                mensaje(e,"error");
            }
        },complete: function(){
            $('.ajax-loader').css("visibility", "hidden");
        }
      });
}

function perdida(produccion,cant,lote,fecha,peso,cantidad,tara,total,fin) {
    $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  'c_produccion.php',
        data:{
            "accion" : 'perdida',
            "produccion" : produccion,
        },success:function(e){
            total = (total - e);
            demoFromHTML(cant,lote,fecha,peso,cantidad,tara,total,fin);
        }
      }); 
}