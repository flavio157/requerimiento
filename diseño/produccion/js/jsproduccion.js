var sugxformula =[]; canform = '';celda = '';codproitem = '';celdatipo =''; sugxmolde = []; sugxcli= [];usu='';
$(document).ready(function () {
    autocompletarformula();
    autocompletamolde('P','');autocompletarcli();
    usu = $("#vrcodpersonal").val();
    disabled();
    $("#txtprodcant").blur(function(){
        var td =  $("#tbdmateiales tr");
        for (let l = 0; l < td.length; l++) {
            $(this).val(Number($(this).val()).toFixed(2));
            cant = $(td[l]).find("td")[4].innerHTML;
            //console.log(Number($(this).val()) +"*"+ Number(cant) +"/"+ Number(canform)); /*110*16/120*/
            $(td[l]).find("td")[2].innerHTML = parseFloat(Number($(this).val()) * Number(cant) /Number(canform)).toFixed(3)
            $(td[l]).find("td")[3].innerHTML = 0.00;
        }
    });

    $("#slcmdtipo").on('change',function () {
        if($(this).val() == 'P'){stock(codproitem)}
        else {$("#mdstock").val('');}
    });

    $("#btnactuitems").on('click',function () {
        veristock($("#mdcantxusar").val(),$("#mdcant").val(),codproitem,$("#slcmdtipo").val());
    });

    $(document).on('click','#btnactualizar',function () {
        $("#mdcantxusar").val('');
        celda = $(this).parents('tr').find('td:nth-child(4)');
        celdatipo = $(this).parents('tr').find('td:nth-child(6)');
        codproitem = $(this).parents('tr').find('td:nth-child(1)').text().trim();
        $("#mdinsumo").val($(this).parents('tr').find('td:nth-child(2)').text().trim());
        $("#mdcant").val($(this).parents('tr').find('td:nth-child(3)').text().trim());
        $("#slcmdtipo").val($(this).parents('tr').find('td:nth-child(6)').text().trim());
        if($("#slcmdtipo").val() == 'P')stock($(this).parents('tr').find('td:nth-child(1)').text().trim());
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
        if($(this).val() == 'P'){disabled();autocompletamolde($(this).val(),'');}
        else enabled();
    });

    $("#btngproduccion").on('click',function() {
        var td =  $("#tbdmateiales tr");
        var tds = [];
        for (let l = 0; l < td.length; l++) {
            tds[l] =[$(td[l]).find("td")[0].innerHTML,$(td[l]).find("td")[2].innerHTML,
            $(td[l]).find("td")[3].innerHTML,$(td[l]).find("td")[5].innerHTML]
        }
        guardarprod(tds);
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

    
});

function autocompletarformula() {
    buscarxformula();
    $("#txtbformula").autocomplete({
        source: sugxformula,
        select: function (event, ui) {
          canform = ui.item.cant;
          $("#txtprod").val(ui.item.prod);
          lstitemsfor(ui.item.code)
          $("#txtprodcant").val(ui.item.cant);
          $("#txtbformula").val(ui.item.label);
        }
    });
}

function stock(stock) {
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
              "<i class='icon-pencil' title='Modificar material'></i>";
    $("#tbmateriales > tbody").empty();
    $.each(obj, function(i, item) {
        var fila='';
        fila +="<td class='tdcontent' style=display:none>"+item[1]+"</td>";
        fila +="<td >"+item[2]+"</td>";
        fila +="<td >"+item[3]+"</td>";
        fila +="<td class='tdcontent'>"+0.00+"</td>";
        fila +="<td style=display:none>"+item[3]+"</td>";
        fila +="<td style=display:none>P</td>";
        fila +="<td class='tdcontent'>"+b2+"</td>";
        var btn = document.createElement("TR");
        btn.innerHTML=fila;
        document.getElementById("tbdmateiales").appendChild(btn);
    });
}

function Mensaje1(texto,icono){
    Swal.fire({icon: icono,title: texto,
     //padding:'1rem',//grow:'fullscreen',//backdrop: false,
     //toast:true,//position:'top'	
     });
}

function veristock(txtcant,cantxusar,codpro,tipo) {
    $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  'c_produccion.php',
        data:"accion=veristock&txtcant="+txtcant+"&cantxusar="+cantxusar+"&codpro="+codpro,
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
    $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  'c_produccion.php',
        data:frmprod+"&accion=guardaprod&usu="+usu+"&items="+JSON.stringify(materiales),
        success:  function(e){
            if(e == 1){
                Mensaje1("Se registro la fabricacion del plastico","success");
                lmp();
            }else{Mensaje1(e,"error")}
        }
    });  
}

function lmp() {
    disabled();
    document.getElementById("frmproduccion").reset();
    $('#tbmateriales').find("tr:gt(0)").remove();    
}