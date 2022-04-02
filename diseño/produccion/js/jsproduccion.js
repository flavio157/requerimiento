var sugxformula =[]; canform = '';celda = '';codproitem = '';celdatipo =''; codprodsele ='';
var sugxmolde = []; sugxcli= [];usu=''; tbinsumos =[]; total = 0.000;nuedatos = [];modified = 0;
var modifidLF = 0; var estilomolde = 0;  var tds = [];
$(document).ready(function () {
    autocompletarformula();
    autocompletamolde('P','');autocompletarcli();
    usu = $("#vrcodpersonal").val();
    disabled();
    $("#tempSo").css('display','none');
    $("#contact-tab").css("display",'none');
    $("#tempsopla").css('display','none');
    $("#btntimelf").css('display','none');
    $("#txtprodcant").blur(function(){
        $("#tbpasadas > tbody").empty();
        var td =  $("#tbdmateiales tr");
        for (let l = 0; l < td.length; l++) {
            $(this).val(Number($(this).val()).toFixed(3));
            cant = $(td[l]).find("td")[3].innerHTML;
            /*110*16/120*/
            reglatres = parseFloat(Number($(this).val()) * Number(cant) /Number(canform)).toFixed(3)
            $(td[l]).find("td")[2].innerHTML = reglatres;
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
        fila +="<td >"+parseFloat($("#mdcantxusar").val()).toFixed(3)+"</td>";
        fila +="<td  style=display:none>"+$("#slcmdtipo").val()+"</td>";
        //fila +="<td>"+b+"</td>";
        var btn = document.createElement("TR");
        btn.innerHTML=fila;
        document.getElementById("tbdmdinsumosa").appendChild(btn);
        $("#txtnominsumo").val(''); $("#mdcantxusar").val('');tbinsumos = [];
    })

    $("#btnclose").on('click',function() {
        $('#tbmdinsumosa').find("tr:gt(0)").remove(); 
        $('#tbmdinsumos').find("tr:gt(0)").remove();   
    })

    $("#btncancelar").on('click',function() {
        $('#tbmdinsumosa').find("tr:gt(0)").remove();  
        $('#tbmdinsumos').find("tr:gt(0)").remove();  
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
        celdatipo = $(this).parents('tr').find('td:nth-child(5)');
        codproitem = $(this).parents('tr').find('td:nth-child(1)').text().trim();
        insumo = $(this).parents('tr').find('td:nth-child(2)').text().trim();
        $("#mdcant").val($(this).parents('tr').find('td:nth-child(3)').text().trim());
        $("#slcmdtipo").val($(this).parents('tr').find('td:nth-child(5)').text().trim());
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
                //fila +="<td>"+b+"</td>";
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
        if($(this).val() == 'P'){lmp();autocompletamolde($(this).val(),'');}
        else enabled();
    });

    $("#btngproduccion").on('click',function() {
        var td =  $("#tbdpasadas tr");
        for (let l = 0; l < td.length; l++) {
            tds[l] =[$(td[l]).find("td")[0].innerHTML,$(td[l]).find("td")[1].innerHTML,
            $(td[l]).find("td")[3].innerHTML,$(td[l]).find("td")[4].innerHTML]
        }
        var removebloq = ""
        guardarprod(removebloq);
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

    $("#frmparametros input").change(function () {   
		modified = 1;  
	}); 

    $("#frmparametros select").change(function () {   
		modified = 1;  
	}); 

    $("#frmtimelf input").change(function () {   
		modifidLF = 1;  
	}); 

    $("#btnconfirmacion").on('click',function() {
        codconfirma = $("#txtconfirmacod").val();
        confirmacion(codconfirma);
    })

    $("#txtciclo").keyup(function() {
        aproxcan = (3600/$(this).val()*$("#txtcavidades").val()*$("#txthoras").val())
        $("#txtcanturno").val(Math.round(aproxcan));     
    })

    $("#txtcavidades").keyup(function () {
        aproxcan = (3600/$("#txtciclo").val()*$(this).val()*$("#txthoras").val())
        $("#txtcanturno").val(Math.round(aproxcan));    
    })

    $("#txthoras").keyup(function() {
        aproxcan = (3600/$("#txtciclo").val()*$("#txtcavidades").val()*$("#txthoras").val())
        $("#txtcanturno").val(Math.round(aproxcan));     
    });

    $("#txtciclo").change(function(){
        modified = 1;  
    })
    $("#txtcavidades").change(function(){
        modified = 1;  
    })
    $("#txthoras").change(function(){
        modified = 1;  
    })
});

function autocompletarformula() {
    buscarxformula();
    $("#txtbformula").autocomplete({
        source: sugxformula,
        select: function (event, ui) {
          canform = ui.item.cant;
          $("#txtform").val(ui.item.code);
          $("#txtprod").val(ui.item.prod);
          $("#txtpesouni").val(ui.item.peso);
          lstitemsfor(ui.item.code)
          var firstTabEl = document.querySelector('#myTab li:first-child button')
          var firstTab = new bootstrap.Tab(firstTabEl)
          firstTab.show()
          parametros(ui.item.code);
          $("#txtprodcant").val(ui.item.cant);
          $("#txtbformula").val(ui.item.label);
          $("#txtbusmolde").val(ui.item.molde);
          $("#txtcodmolde").val(ui.item.idmolde)
          $("#slcestimolde").val(ui.item.estiM);
          estilomolde = ui.item.estiM;
          if(ui.item.estiM == "I"){
            $("#tempSo").css('display','revert')
            $("#contact-tab").css("display",'revert');
            $("#btntimelf").css('display','none');
            $("#profile-tab").css('display','revert')
            $("#tempsopla").css('display','none')
            $("#tbbotadores").css('display','revert')
            $("#lblbotador").css('display','revert');
            $("#tempsopla-tap").css('display','none');
            $("#empuje-tab").css('display','revert');
            $("#pres_cierre-tab").css('display','revert');
          }else if(ui.item.estiM == "S"){
            $("#tempSo").css('display','none')
            $("#btntimelf").css('display','revert');
            $("#profile-tab").css('display','none')
            $("#contact-tab").css('display','none')
            $("#tbbotadores").css('display','none')
            $("#lblbotador").css('display','none');
            $("#tempsopla").css('display','revert');
            $("#empuje-tab").css('display','none');
            $("#pres_cierre-tab").css('display','none');
            $("#tempsopla").css('display','revert')
          }
          modifidLF = 0; modified = 0;
        }
    });
}


function parametros(formulacod) {
    document.getElementById("frmparametros").reset();
    document.getElementById("frmtimelf").reset();
    $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  'c_produccion.php',
        data:{
            "accion" : 'parametros',"produccion":formulacod
        } ,
        success: function(r){
            obj = JSON.parse(r);
           if(obj['para'] == 1){
               console.log(obj['dato']);
            $.each(obj['dato'], function(i, item) {
                $("#txttemp1").val(item[5]);$("#txttemp2").val(item[6]);
                $("#txttemp3").val(item[7]);$("#txttemp4").val(item[8]);
                $("#txttemp5").val(item[9]);$("#txttemp6").val(item[34]);
                $("#txttemp7").val(item[35]);$("#txttemp8").val(item[36]);
                $("#txttemp9").val(item[37]);
                $("#presexplu1").val(item[10]);
                $("#presexplu2").val(item[11]);$("#velexplu1").val(item[12]);
                $("#velexplu2").val(item[13]);$("#pisiexplu1").val(item[14]);
                $("#pisiexplu2").val(item[15]);$("#contrac1").val(item[16]);
                $("#contrac2").val(item[17]);$("#contrac3").val(item[18]);
                $("#contrac4").val(item[19]);$("#cargapres1").val(item[20]);
                $("#cargapres2").val(item[21]);$("#cargapres3").val(item[22])
                $("#cargapresucc").val(item[23]);$("#cargavel1").val(item[24])
                $("#cargavel2").val(item[25]);$("#cargavel3").val(item[26])
                $("#cargavelsucc").val(item[27]);$("#cargapisi1").val(item[28]);
                $("#cargapisi2").val(item[29]);$("#cargapisi3").val(item[30])
                $("#cargapisisucci").val(item[31]);

                $("#slemodeexpul").val(item[38].trim());$("#botadocant").val(item[39])
                $("#presexplu3").val(item[40]);$("#presexplu4").val(item[41]);
                $("#velexplu3").val(item[42]);$("#velexplu4").val(item[43]);
                $("#pisiexplu3").val(item[44]);$("#pisiexplu4").val(item[45]);
                $("#txtTieRetar1").val(item[46]);$("#txtTieRetar2").val(item[47]);
                $("#txtTiemActua1").val(item[48]);$("#txtairposi1").val(item[49]);
                $("#txtairposi2").val(item[50]);$("#txtBTiemActua1").val(item[51]);
                $("#txtBirposi1").val(item[52]);$("#txtBTieRetar1").val(item[53]);

                $("#slcModoActSucci").val(item[54].trim()); $("#carSuckBackDist").val(item[55]);
                $("#carSuckBackTime").val(item[56]);$("#carSKBkBefChg").val(item[57]);
                $("#carTiemDesDEspC").val(item[58]);$("#carPosFlujoMold").val(item[59]);
                $("#carTiempFlujoMo").val(item[60]);$("#carRetarEnfria").val(item[61]);
                $("#carCoolTime").val(item[62]);


                $("#inyecpres4").val(item[63])
                $("#inyecpres3").val(item[64]);$("#inyecpres2").val(item[65])
                $("#inyecpres1").val(item[66]);$("#inyecvelo4").val(item[67])
                $("#inyecvelo3").val(item[68]);$("#inyecvelo2").val(item[69])
                $("#inyecvelo1").val(item[70]);$("#inyecposi4").val(item[71]);
                $("#inyecposi3").val(item[72]);$("#inyecposi2").val(item[73])
                $("#inyecposi1").val(item[74]);$("#inyectiemp").val(item[75])
                $("#velocidad3").val(item[76]);$("#velocidad2").val(item[77])
                $("#velocidad1").val(item[78]);$("#posicion3").val(item[79])
                $("#posicion2").val(item[80]);$("#posicion1").val(item[81])
                $("#tiempo").val(item[82])

                $("#txtempuPresi1").val(item[83]);$("#txtempuPresi2").val(item[84]);
                $("#txtempuPresi3").val(item[85]);$("#txtempuPresi4").val(item[86]);
                $("#txtempuveloc1").val(item[117]);$("#txtempuveloc2").val(item[118]);
                $("#txtempuveloc3").val(item[119]);$("#txtempuveloc4").val(item[120]);
                $("#txtempudelay1").val(item[87]);$("#txtemputiemp1").val(item[88]);
                $("#txtemputiemp2").val(item[89]);$("#txtempupisici").val(item[90]);
                $("#txtempucorreAtr").val(item[91].trim());

                $("#txtprecieOpnStr").val(item[92]);$("#txtprescierr_presio1").val(item[93]);
                $("#txtprescierr_presio2").val(item[94]);$("#txtprescierr_presio3").val(item[95]);
                $("#txtprescierr_presio4").val(item[96]);$("#txtprescierr_velo1").val(item[97]);
                $("#txtprescierr_velo2").val(item[98]);$("#txtprescierr_velo3").val(item[99]);
                $("#txtprescierr_velo4").val(item[100]);$("#txtprescierr_posic1").val(item[101]);
                $("#txtprescierr_posic2").val(item[102]);$("#txtprescierr_posic3").val(item[103]);
                $("#txtprescierr_posic4").val(item[104]);$("#txtprescierr_presi5").val(item[105]);
                $("#txtprescierr_presi6").val(item[106]);$("#txtprescierr_presi7").val(item[107]);
                $("#txtprescierr_presi8").val(item[108]);$("#txtprescierr_veloc5").val(item[109]);
                $("#txtprescierr_veloc6").val(item[110]);$("#txtprescierr_veloc7").val(item[111]);
                $("#txtprescierr_veloc8").val(item[112]);$("#txtprescierr_posic5").val(item[113]);
                $("#txtprescierr_posic6").val(item[114]);$("#txtprescierr_posic7").val(item[115]);
                $("#txtprescierr_posic8").val(item[116]);
                /*Timer lf */
                $("#txtcarriage").val(item[121]);$("#txtclosedd").val(item[122]);
                $("#txtcuter").val(item[123]);$("#txthead").val(item[124]);
                $("#txtblow").val(item[125]);$("#txttotalblo").val(item[126]);
                $("#txtblow1").val(item[127]);$("#txtlf").val(item[128]);
                $("#txtdefla").val(item[129]);$("#txtunde").val(item[130]);
                $("#txtcoolin").val(item[131]);$("#txtlock").val(item[132]);
                $("#txtbottle").val(item[133]);$("#txtcarria").val(item[134]);
                $("#txtopenmoul").val(item[135]);$("#txtcuter1").val(item[136]);
                $("#txthead1").val(item[137]);$("#txtblowpin").val(item[138]);
                $("#txttotalbl").val(item[139]);$("#txtdeflati").val(item[140]);
                $("#txtblopinS").val(item[141]);$("#txtdeflation").val(item[142]);
                $("#txtcamvaci1").val(item[143]);$("#txtcooling").val(item[144]);
                $("#txtcamvaci2").val(item[145]);$("#txtcamvaci3").val(item[146]);
                /*hasta aqui*/
                $("#txtciclo").val(item[147]);$("#txtcavidades").val(Math.round(item[148]));
                $("#txthoras").val(item[149].trim());$("#txtcanturno").val(item[150]);
            });
           } 
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
            $("#tbmdinsumos").find("tr:gt(0)").remove();
            fila = '';
            fila +="<td class='tdcontent' style=display:none>"+stock+"</td>";
            fila +="<td >"+insumo+"</td>";
            fila +="<td >"+obj['stock']+"</td>";
            var btn = document.createElement("TR");
            btn.innerHTML=fila;
            document.getElementById("tbdmdinsumos").appendChild(btn);
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
    $('#tbmateriales').find("tr:gt(0)").remove();    
    $('#tbpasadas').find("tr:gt(0)").remove(); 
    $.each(obj, function(i, item) {
        var fila='';
        fila +="<td class='tdcontent' style=display:none>"+item[1]+"</td>";
        fila +="<td >"+item[2]+"</td>";
        fila +="<td >"+Number(item[3]).toFixed(3)+"</td>";
        /*fila +="<td class='tdcontent'>"+Number(item[3]).toFixed(2)+"</td>";*/
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
                Mensaje1(obj['dato'].trim(),"error");
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
}//buscarmolde

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
        beforeSend: function () {
            $('.ajax-loader').css("visibility", "visible");
        },
        success:  function(r){
            obj = JSON.parse(r);
            if(obj['e'] == true){
                Mensaje1("Se registro el molde","success");
                $("#txtcodmolde").val(obj['c']);autocompletamolde(t,cli);
                $("#txtbusmolde").val(molde);
                $("#mdmolde").modal('hide');
                document.getElementById("frmmdmolde").reset();
            }
            else Mensaje1(obj['e'].trim(),"error");
        },complete: function(){
            $('.ajax-loader').css("visibility", "hidden");
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
        beforeSend: function () {
            $('.ajax-loader').css("visibility", "visible");
        },
        success:  function(e){
            obj = JSON.parse(e);
            
            if(obj['e'] == true){
                Mensaje1("Se registro el cliente","success");
                $("#txtcodclie").val(obj['c']);autocompletarcli();
                $("#txtbuscli").val(nomcli);
                $("#mdcliente").modal('hide');
                document.getElementById("frmmdcliente").reset();
            }
            else{
                Mensaje1(obj['e'].trim(),"error")
                $('.ajax-loader').css("visibility", "hidden");
            } 
        },complete: function(){
            $('.ajax-loader').css("visibility", "hidden");
        }
      });
}

function disabled() {
    $("#txtbuscli").attr('disabled','true');
    $("#txtbuscli").val('')
    $("#btnmdcliente").addClass('disabled');
    $("#btnmdmolde").addClass('disabled');
    $("#slcmdtipo").attr('disabled','true');
    $("#txtbusmolde").attr("disabled","disabled")
}

function enabled() {
    $("#txtbuscli").removeAttr('disabled','false');
    $("#btnmdcliente").removeClass('disabled');
    $("#btnmdmolde").removeClass('disabled');
    $("#slcmdtipo").removeAttr('disabled','true');
    $("#txtbusmolde").removeAttr("disabled");
    $("#txtcodmolde").val('');
    $("#txtbusmolde").val('');
}

function guardarprod(removebloq) {
    var frmprod = $("#frmproduccion").serialize();
    var frmtimelf = $("#frmtimelf").serialize();
    var materiales = {tds};
    var frmparame = $("#frmparametros").serialize();
    var cantxturno = $("#txtcanturno").val();
   $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  'c_produccion.php',
        data:frmprod+"&"+frmparame+"&accion=guardaprod&usu="+usu+"&items="+JSON.stringify(materiales)+
        "&modified="+modified+"&"+frmtimelf+"&modifiedLF="+modifidLF+"&estilomolde="+estilomolde+"&r="+removebloq+
        "&canxtuno="+cantxturno,
        beforeSend: function () {
            $('.ajax-loader').css("visibility", "visible");
        },
        success:  function(e){
            if(e == 1){
                Mensaje1("Se registro la fabricacion del plastico","success");
                lmp();
                para = 0;
               // $("#mdconfirmacion").modal("hide");
            }else if(e.trim() == "b"){
                //$("#mdconfirmacion").modal("show");
            }else{Mensaje1(e.trim(),"error")}
           
        },complete: function(){
            $('.ajax-loader').css("visibility", "hidden");
        }
    });
}

function lmp() {
    disabled();
    document.getElementById("frmproduccion").reset();
    document.getElementById("frmparametros").reset();
    document.getElementById("frmtimelf").reset();
    $('#tbmateriales').find("tr:gt(0)").remove();    
    $('#tbpasadas').find("tr:gt(0)").remove(); 
    modified = 0; modifidLF = 0; 
    tds = []; 
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
            fila +="<td>"+$("#slcmdtipo").val()+"</td>";
            var btn = document.createElement("TR");
            btn.innerHTML=fila;
            document.getElementById("tbdpasadas").appendChild(btn);
        }
        celda.text(total.toFixed(3));
        celdatipo.text($("#slcmdtipo").val());
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
    fila2 +="<td class='tdcontent'>"+Number(item3).toFixed(3)+"</td>";
    fila2 +="<td class='tdcontent'>"+'P'+"</td>";
    var btn = document.createElement("TR");
    btn.innerHTML=fila2;
    document.getElementById("tbdpasadas").appendChild(btn);
}

function confirmacion(codconfirma) {
    $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  'c_produccion.php',
        data:{
            "accion" :"confirmar",
            "codconfirmar" : codconfirma,
        },
        success:  function(e){ 
           o = JSON.parse(e);
           if(o['d'].trim() == 1){
               guardarprod(o['b'].trim());
           }else{Mensaje1(o['d'].trim(),"error")}
        }
    });  
}

