var sugxformula =[]; canform = '';celda = '';codproitem = '';celdatipo =''; codprodsele ='';
var sugxmolde = []; sugxcli= [];usu=''; tbinsumos =[]; total = 0.000;nuedatos = [];modified = false;
$(document).ready(function () {
    autocompletarformula();lstalmacen();
    autocompletamolde('P','');autocompletarcli();
    usu = $("#vrcodpersonal").val();
    disabled();
    $("#txtprodcant").blur(function(){
        $("#tbpasadas > tbody").empty();
        var td =  $("#tbdmateiales tr");
        for (let l = 0; l < td.length; l++) {
            $(this).val(Number($(this).val()).toFixed(2));
            cant = $(td[l]).find("td")[4].innerHTML;
            /*110*16/120*/
            reglatres = parseFloat(Number($(this).val()) * Number(cant) /Number(canform)).toFixed(2)
            $(td[l]).find("td")[2].innerHTML = reglatres;
            $(td[l]).find("td")[3].innerHTML = reglatres;
            createparams($(td[l]).find("td")[0].innerHTML,$(td[l]).find("td")[1].innerHTML,reglatres);
        }
    });

    $('#tbmdinsumos').on('click', 'tbody tr', function(event) {
        codprodsele = $(this).find("td:eq(0)").text();
        tbinsumos = [];
        $(this).addClass('highlight').siblings().removeClass('highlight');
        $("#txtnominsumo").val($(this).find("td:eq(1)").text());
        tbinsumos.push([$(this).find("td:eq(0)").text(),$(this).find("td:eq(1)").text(),
        $("#slcmdtipo").val(),$(this).find("td:eq(2)").text()]);
    });

    $('#tbmdinsumosa').on('click', 'tbody tr', function(event) {
        $(this).addClass('highlight').siblings().removeClass('highlight');
        $("#slcmdtipo").val($(this).find("td:eq(3)").text());
    });

    $("#btnmdcantxusar").on('click',function() {
        if(tbinsumos.length == 0){Mensaje1("Error seleccion insumos","error");return;}
        if($("#mdcantxusar").val().length == 0 || $("#mdcantxusar").val() == 0){Mensaje1("Error ingrese cantidad","error");return;}
        repetido = datosrepetidos('tbdmdinsumosa',tbinsumos[0][0],$("#slcmdtipo").val()) 
        if(!repetido){Mensaje1("Error ya se agrego el insumos","error");return;}
        if($("#slcmdtipo").val() != 'E'){
            ret = decimal($("#mdcantxusar").val(),tbinsumos[0][3])
            if(!ret){Mensaje1("Error stock insuficiente","error");return}
        }
        ret = decimal($("#mdcantxusar").val(),$("#mdcant").val())
        if(!ret){Mensaje1("Error cantidad por usar no puede ser mayor a cantidad","error");return;}
        
        if($("#sltipoprod").val() == 'E'){
            if(codprodsele != codproitem ){Mensaje1("Error no puede seleccionar insumo diferente","error");return};
            if($("#slcmdtipo").val() == 'E')
            insertexter(tbinsumos[0][0],$("#mdcantxusar").val(),$("#slcmdtipo").val())
        }
        
        var fila='';
        b = "<a id='btnmdinsumo' style='margin-right: 2px;margin-bottom: 1px;' class='btn btn-danger  btn-sm'>"+
          "<i class='icon-trash' title='reiniciar cantidad'></i></a>";
        fila +="<td class='tdcontent' style=display:none>"+tbinsumos[0][0]+"</td>";
        fila +="<td >"+tbinsumos[0][1]+"</td>";
        fila +="<td >"+parseFloat($("#mdcantxusar").val()).toFixed(2)+"</td>";
        fila +="<td  style=display:none>"+$("#slcmdtipo").val()+"</td>";
        fila +="<td>"+b+"</td>";
        var btn = document.createElement("TR");
        btn.innerHTML=fila;
        document.getElementById("tbdmdinsumosa").appendChild(btn);
        $("#txtnominsumo").val(''); $("#mdcantxusar").val('');tbinsumos = [];
    })

    $("#btnclose").on('click',function() {
        $("#tbmdinsumosa > tbody").empty();
    })

    $("#btncancelar").on('click',function() {
        $("#tbmdinsumosa > tbody").empty();
    });

    $(document).on('click',"#btnmdinsumo",function() {
        $(this).closest('tr').remove();
    })

    $("#btnactuitems").on('click',function () {
        lppasadas();
    });

    $(document).on('click','#btnactualizar',function () {
        filas = $("#tbdpasadas tr");
        $("#mdcant").val('');
        celda = $(this).parents('tr').find('td:nth-child(4)');
        celdatipo = $(this).parents('tr').find('td:nth-child(6)');
        codproitem = $(this).parents('tr').find('td:nth-child(1)').text().trim();
        insumo = $(this).parents('tr').find('td:nth-child(2)').text().trim();
        $("#mdcant").val($(this).parents('tr').find('td:nth-child(3)').text().trim());
        $("#slcmdtipo").val($(this).parents('tr').find('td:nth-child(6)').text().trim());
        if($("#slcmdtipo").val() == 'P')
        stock($(this).parents('tr').find('td:nth-child(1)').text().trim(),insumo);

        for (let i = 0; i < filas.length; i++) {
            if(codproitem == $(filas[i]).find("td")[0].innerHTML){
                var fila='';
                b = "<a id='btnmdinsumo' style='margin-right: 2px;margin-bottom: 1px;' class='btn btn-danger  btn-sm'>"+
                  "<i class='icon-trash' title='reiniciar cantidad'></i></a>";
                fila +="<td class='tdcontent' style=display:none>"+$(filas[i]).find("td")[1].innerHTML+"</td>";
                fila +="<td >"+$(filas[i]).find("td")[2].innerHTML+"</td>";
                fila +="<td >"+$(filas[i]).find("td")[3].innerHTML+"</td>";
                fila +="<td  style=display:none>"+$(filas[i]).find("td")[4].innerHTML+"</td>";
                fila +="<td>"+b+"</td>";
                var btn = document.createElement("TR");
                btn.innerHTML=fila;
                document.getElementById("tbdmdinsumosa").appendChild(btn);
                //$(filas[i]).remove();
            }
        }
    })
    
    $('#mdcliente').on('hidden.bs.modal', function() {
        document.getElementById("frmmdcliente").reset();
    })

    $('#mdmolde').on('hidden.bs.modal', function() {
        document.getElementById("frmmdmolde").reset();
    })

    $("#btnmdgmolde").on('click',function() {
        cli = $("#txtcodclie").val();
        guardarmolde(cli,$("#txtnommolde").val(),'E');
    });

    $("#btnmdgcliente").on('click',function() {
        guardarclie($("#txtnombcliente").val());
    });

    $("#sltipoprod").on('change',function() {
        var td =  $("#tbdpasadas tr");
        for (let l = 0; l < td.length; l++) {
            if($(td[l]).find("td")[4].innerHTML == 'E'){
                Mensaje1("Error para cambiar tipo de produccion elimine todas los items","error");
                $(this).val($.data(this, 'current')); 
                return false;   
            }
        }
        $.data(this, 'current', $(this).val()); 
        if($(this).val() == 'P'){disabled();autocompletamolde($(this).val(),'');}
        else enabled();
    });

    $("#btngproduccion").on('click',function() {
        if(modified == true){
            console.log("cambio");
        }
      /*  var td =  $("#tbdpasadas tr");
        var tds = [];
        for (let l = 0; l < td.length; l++) {
            tds[l] =[$(td[l]).find("td")[0].innerHTML,$(td[l]).find("td")[1].innerHTML,
            $(td[l]).find("td")[3].innerHTML,$(td[l]).find("td")[4].innerHTML]
        }
        guardarprod(tds);*/
    })

    $('#txtbuscli').keydown(function(e) {
        if (e.keyCode == 8) $('#txtcodclie').val('');
    });

    $('#txtbusmolde').keydown(function(e) {
        if (e.keyCode == 8) $('#txtcodmolde').val('');
    });

    $("#btnnuevo").on('click',function() {
        lmp();   
    });

    $("input, select").change(function () {   
		modified = true;  
	}); 
});

function autocompletarformula() {
    buscarxformula();
    $("#txtbformula").autocomplete({
        source: sugxformula,
        select: function (event, ui) {
          canform = ui.item.cant;
          $("#txtform").val(ui.item.code);
          $("#txtprod").val(ui.item.prod);
          lstitemsfor(ui.item.code)
          parametros(ui.item.code);
          $("#txtprodcant").val(ui.item.cant);
          $("#txtbformula").val(ui.item.label);
        }
    });
}


function parametros(produccion) {
    console.log(produccion);
    $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  'c_produccion.php',
        data:{
            "accion" : 'parametros',"produccion":produccion
        } ,
        success:  function(r){
            obj = JSON.parse(r)
            $.each(obj['dato'], function(i, item) {
                $("#txttemp1").val(item[5]);$("#txttemp2").val(item[6]);
                $("#txttemp3").val(item[7]);$("#txttemp4").val(item[8]);
                $("#txttemp5").va(item[9]);$("#presexplu1").val(item[10]);
                $("#presexplu2").val(item[6]);$("#velexplu1").val(item[6]);
                $("#velexplu2").val(item[6]);$("#pisiexplu1").val(item[6]);
                $("#pisiexplu2").val(item[6]);$("#contrac1").val(item[6]);
                $("#contrac2").val(item[6]);$("#contrac3").val(item[6]);
                $("#contrac4").val(item[6]);$("#cargapres1").val(item[6]);
                $("#cargapres2").val(item[6]);$("#cargapres3").val(item[6])
                $("#cargapresucc").val(item[6]);$("#cargavel1").val(item[6])
                $("#cargavel2").val(item[6]);$("#cargavel3").val(item[6])
                $("#cargavelsucc").val(item[6]);$("#cargapisi1").val(item[6]);
                $("#cargapisi2").val(item[6]);$("#cargapisi3").val(item[6])
                $("#cargapisisucci").val(item[6]);$("#inyecpres4").val(item[6])
                $("#inyecpres3").val(item[6]);$("#inyecpres2").val(item[6])
                $("#inyecpres1").val(item[6]);$("#inyecvelo4").val(item[6])
                $("#inyecvelo3").val(item[6]);$("#inyecvelo2").val(item[6])
                $("#inyecvelo1").val(item[6]);$("#inyecposi4").val(item[6]);
                $("#inyecposi3").val(item[6]);$("#inyecposi2").val(item[6])
                $("#inyecposi1").val(item[6]);$("#inyectiemp").val(item[6])
                $("#velocidad3").val(item[6]);$("#velocidad2").val(item[6])
                $("#velocidad1").val(item[6]);$("#posicion3").val(item[6])
                $("#posicion2").val(item[6]);$("#posicion1").val(item[6])
                $("#tiempo").val(item[6])
                
            });
        }
    });    
}



function stock(stock,insumo) {
    $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  'c_produccion.php',
        data:{
            "accion" : 'stock',"stoc":stock
        } ,
        success:  function(r){
            obj = JSON.parse(r)
            $("#mdstock").val(obj['stock']);
            buscarpasadas(stock,insumo,obj['stock']);
        }
    });   
}

function buscarxformula(){
    $.ajax({
      dataType:'text',
      type: 'POST', 
      url:  'c_produccion.php',
      data:{
          "accion" : 'buscarxformula',
      } ,
      success:  function(response){
          obj = JSON.parse(response);
          $.each(obj['dato'], function(i, item) {
            sugxformula.push(item);
          });
      }
    });
}

function lstitemsfor(form) {
    $.ajax({
      dataType:'text',
      type: 'POST', 
      url:  'c_produccion.php',
      data:"accion=lstitemformula&form="+form,
      success: function(r) {
        obj = JSON.parse(r);
        createtable(obj['dato']);
      }
    });
}

function createtable(obj) {
    b2 = "<a id='btnactualizar' style='margin-right: 2px;margin-bottom: 1px;' class='btn btn-primary  btn-sm' data-bs-toggle='modal' data-bs-target='#mditemformula'>"+
          "<i class='icon-pencil' title='Modificar material'></i></a>";
    $("#tbmateriales > tbody").empty();
    $("#tbpasadas > tbody").empty();
    $.each(obj, function(i, item) {
        var fila='';
        fila +="<td class='tdcontent' style=display:none>"+item[1]+"</td>";
        fila +="<td >"+item[2]+"</td>";
        fila +="<td >"+Number(item[3]).toFixed(2)+"</td>";
        fila +="<td class='tdcontent'>"+Number(item[3]).toFixed(2)+"</td>";
        fila +="<td style=display:none>"+item[3]+"</td>";
        fila +="<td style=display:none>P</td>";
        fila +="<td class='tdcontent'>"+b2+"</td>";
        var btn = document.createElement("TR");
        btn.innerHTML=fila;
        document.getElementById("tbdmateiales").appendChild(btn);

        createparams(item[1],item[2],item[3]);
    });
}

function Mensaje1(texto,icono){
    Swal.fire({icon: icono,title: texto,});
}

function veristock(txtcant,cantxusar,codpro,tipo) {
    $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  'c_produccion.php',
        data:"accion=veristock&txtcant="+txtcant+"&cantxusar="+cantxusar+"&codpro="+codpro+"&tipo="+tipo,
        success: function(r) {
            obj = JSON.parse(r);
            if(obj['tipo'] == 1){
                Mensaje1(obj['dato'],"error");
            }else{
                $(celda).text(Number.parseFloat(obj['dato']).toFixed(3));
                $(celdatipo).text(tipo);
                $("#mditemformula").modal('hide');
            }
        }
    });
}

function autocompletarcli() {
    sugxcli = [];
    buscarxcli();
    $("#txtbuscli").autocomplete({
        source: sugxcli,
        select: function (event, ui) {
          $("#txtcodclie").val(ui.item.code);
          $("#txtbuscli").val(ui.item.label);
          autocompletamolde('P',ui.item.code);
        }
    });
}

function autocompletamolde(t,code) {
    sugxmolde = [];
    buscarxmolde(t,code);
    $("#txtbusmolde").autocomplete({
        source: sugxmolde,
        select: function (event, ui) {
          $("#txtcodmolde").val(ui.item.code);  
          $("#txtbusmolde").val(ui.item.label);
        }
    });
}

function buscarxmolde(t,code){
    $.ajax({
      dataType:'text',
      type: 'POST', 
      url:  'c_produccion.php',
      data:{
          "accion" : 'buscarmolde',"t" : t,"code":code
      } ,
      success:  function(response){
          obj = JSON.parse(response);
          $.each(obj['dato'], function(i, item) {
            sugxmolde.push(item);
          });
      }
    });
}

function buscarxcli(){
    $.ajax({
      dataType:'text',
      type: 'POST', 
      url:  'c_produccion.php',
      data:{
          "accion" : 'buscarclie',
      } ,
      success:  function(response){
          obj = JSON.parse(response);
          $.each(obj['dato'], function(i, item) {
            sugxcli.push(item);
          });
      }
    });
}

function guardarmolde(cli,molde,t) {
    var frmmolde = $("#frmmdmolde").serialize();
    $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  'c_produccion.php',
        data:frmmolde+"&accion=guardamolde&usu="+usu+"&codcli="+cli,
        success:  function(r){
            obj = JSON.parse(r);
            if(obj['e'] == true){
                $("#txtcodmolde").val(obj['c']);autocompletamolde(t,cli);
                $("#txtbusmolde").val(molde);
                $("#mdmolde").modal('hide');
                document.getElementById("frmmdmolde").reset();
            }
            else  Mensaje1(obj['e'],"error");
        }
      });    
}

function guardarclie(nomcli) {
    var frmcli = $("#frmmdcliente").serialize();
    $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  'c_produccion.php',
        data:frmcli+"&accion=guardaclie&usu="+usu,
        success:  function(e){
            obj = JSON.parse(e);
            if(obj['e'] == true){
                Mensaje1("Se registro el cliente","success");
                $("#txtcodclie").val(obj['c']);autocompletarcli();
                $("#txtbuscli").val(nomcli);
                $("#mdcliente").modal('hide');
                document.getElementById("frmmdcliente").reset();
            }
            else Mensaje1(obj['e'],"error")
        }
      });
}

function disabled() {
    $("#txtbuscli").attr('disabled','true');
    $("#txtbuscli").val('')
    $("#btnmdcliente").addClass('disabled');
    $("#btnmdmolde").addClass('disabled');
    $("#slcmdtipo").attr('disabled','true');
}

function enabled() {
    $("#txtbuscli").removeAttr('disabled','false');
    $("#btnmdcliente").removeClass('disabled');
    $("#btnmdmolde").removeClass('disabled');
    $("#slcmdtipo").removeAttr('disabled','true');
}

function guardarprod(tds) {
    var frmprod = $("#frmproduccion").serialize();
    var materiales = {tds};
   var frmparame = $("#frmparametros").serialize();
    $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  'c_produccion.php',
        data:frmprod+"&"+frmparame+"&accion=guardaprod&usu="+usu+"&items="+JSON.stringify(materiales),
        beforeSend: function () {
            $('.ajax-loader').css("visibility", "visible");
        },
        success:  function(e){
            if(e == 1){
                Mensaje1("Se registro la fabricacion del plastico","success");
                lmp();
            }else{Mensaje1(e,"error")}
        },complete: function(){
            $('.ajax-loader').css("visibility", "hidden");
        }
    });
}

function lmp() {
    disabled();
    document.getElementById("frmproduccion").reset();
    $('#tbmateriales').find("tr:gt(0)").remove();    
    $('#tbpasadas').find("tr:gt(0)").remove(); 
}

function insertexter(insumo,stocks,tipo) {
    $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  'c_produccion.php',
        data:{
            "accion" :"externo",
            "insumo" : insumo,
            "stocks" : stocks,
        },
        success:  function(e){ 
        }
    });       
}

function buscarpasadas(insumo,material,cantidad) {
    $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  'c_produccion.php',
        data:{
            "accion" :"pasadas","insumo" : insumo,
        },
        success:  function(e){
            var fila=''; obj = JSON.parse(e);
            $("#tbmdinsumos > tbody").empty();
            fila +="<td class='tdcontent' style=display:none>"+insumo+"</td>";
            fila +="<td >"+material+"</td>";
            fila +="<td >"+cantidad+"</td>";
            var btn = document.createElement("TR");
            btn.innerHTML=fila;
            document.getElementById("tbdmdinsumos").appendChild(btn);
            $.each(obj['dato'], function(i, item) {
                var fila='';
                fila +="<td class='tdcontent' style=display:none>"+item[1]+"</td>";
                fila +="<td >"+item[2]+"</td>";
                fila +="<td >"+item[3]+"</td>";
                var btn = document.createElement("TR");
                btn.innerHTML=fila;
                document.getElementById("tbdmdinsumos").appendChild(btn);
            })    
            
        }
    });  
}

function datosrepetidos(tabla,dato,tipo) {
    filas = $("#"+tabla+" tr");
    for (let l = 0; l < filas.length; l++) {
        if($(filas[l]).find("td")[0].innerHTML == dato && $(filas[l]).find("td")[3].innerHTML == tipo){
            return false;
        }
    }
    return true;
}

function lppasadas() {
        pasada = $("#tbdpasadas tr");
        for (let j = 0; j < pasada.length; j++) {
            if($(pasada[j]).find("td")[0].innerHTML == codproitem){ $(pasada[j]).remove(); }
        }
        total = 0;
        filas = $("#tbdmdinsumosa tr");
        for (let l = 0; l < filas.length; l++) {
            total =Number(total) + Number($(filas[l]).find("td")[2].innerHTML)
        }
        ret = decimal(total ,$("#mdcant").val())
        if(!ret){Mensaje1("Error la cantidad total de insumo no es igual a la requerida","error"); return}
       
        for (let i = 0; i < filas.length; i++) {
             $(filas[i]).remove();
            var fila = '';
            fila +="<td>"+codproitem+"</td>";
            fila +="<td>"+$(filas[i]).find("td")[0].innerHTML+"</td>";
            fila +="<td>"+$(filas[i]).find("td")[1].innerHTML+"</td>";
            fila +="<td>"+$(filas[i]).find("td")[2].innerHTML+"</td>";
            fila +="<td>"+$(filas[i]).find("td")[3].innerHTML+"</td>";
            var btn = document.createElement("TR");
            btn.innerHTML=fila;
            document.getElementById("tbdpasadas").appendChild(btn);
        }
        celda.text(total.toFixed(2));
        $('#tbmdinsumosa').find("tr:gt(0)").remove();
        $('#mditemformula').modal('hide');
        $('#txtnominsumo').val('');$("#mdcantxusar").val('')
    $("#txtnominsumo").val('');
    $("#mdcantxusar").val('');
    $("#tbmdinsumos > tbody").empty();
}
  
function decimal(valor1 ,valor2) {
    valor1 = parseFloat(valor1)
    valor2 = parseFloat(valor2)
    if(valor1 > valor2){return false;}
    return true; 
}

function createparams(codigo,item2,item3) {
    var fila2 ='';
    fila2 +="<td class='tdcontent'>"+codigo+"</td>";
    fila2 +="<td class='tdcontent'>"+codigo+"</td>";
    fila2 +="<td >"+item2+"</td>";
    fila2 +="<td class='tdcontent'>"+Number(item3).toFixed(2)+"</td>";
    fila2 +="<td class='tdcontent'>"+'P'+"</td>";
    var btn = document.createElement("TR");
    btn.innerHTML=fila2;
    document.getElementById("tbdpasadas").appendChild(btn);
}

function lstalmacen() {
    $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  'c_produccion.php',
        data:{
            "accion" :"lstalmacen",
        },
        success:  function(e){ 
            obj = JSON.parse(e);
            $.each(obj['dato'],function(i,item) {
                $('#slctipoalmacen').append($("<option value="+item[0]+">"+item[1]+"</option>" ));  
            });
        }
    });  
}

