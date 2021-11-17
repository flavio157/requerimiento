var sugepersonal = [];
var tipo = 1;
$(function() {
    
    autocompletarpersonal();

    $('body').on('keydown', function(e){
        if( e.which == 38 ||  e.which == 40) {
          return false;
        }
    });
   
  

    $("#btncancelar").on('click',function () {
        tipo = 1;  
        _lcform();
    })

    $("#btnguarpers").on('click',function() {
        var personal = $("#frmgudarpers").serialize();
        if(tipo == 1){
            _guardarpers(personal);
        }else if(tipo == 0){
            _actualizar(personal);
        }
      
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
                this.value = this.value.slice(0,9); 
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

    $("#txtcompobservacion").keyup(function(e) {
        var input=  document.getElementById('txtcompobservacion');
            input.addEventListener('input',function(){
                this.value = this.value.slice(0,500); 
        })
    })
    _lstarea();
    _lstcargo();
    _lstdepartamento();

    $("#sldeparpers").on('change',function() {
        $("#slprovpers").find('option').not(':first').remove();
        $("#sldistpers").find('option').not(':first').remove();
        _lstprovi($(this).val());
    });

    $("#slprovpers").on('change',function() {
        $("#sldistpers").find('option').not(':first').remove();
        _lstdistri($(this).val());
    });

   $("#btnbuscarper").on('click',function() {
     buscarpersonal($("#txtcodpersonal").val());
   })

   $("#btnbuscpers").on('click',function (params) {
       $("#txtcodpersonal").val('');
       $("#txtpersonal").val('');
   })

});

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
    document.getElementById("frmgudarpers").reset();
  
}

function _guardarpers(personal) {
    var usu = $("#vrcodpersonal").val();
    $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  'c_guardarpersonal.php',
        data:personal+"&accion=guardarperso&usuario="+usu,
        success:  function(response){
            if(response == 1){
                Mensaje1("Se registro el personal","success");
                _lcform();
                autocompletarpersonal();
            }else{
                Mensaje1(response,"error");
            }
        }
    }); 
}

function _actualizar(personal) {
    var usu = $("#vrcodpersonal").val();
    var codpersonal = $("#txtcodpersonal").val();
    $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  'c_guardarpersonal.php',
        data:personal+"&accion=actualizar&usuario="+usu+"&codpersonal="+codpersonal,
        success:  function(response){
            if(response == 1){
                Mensaje1("Se actualizo el registro","success");
                _lcform();
                tipo = 1;
                autocompletarpersonal();
            }else{
                Mensaje1(response,"error");
            }
        }
    }); 
}


function _lstarea() {
    $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  'c_guardarpersonal.php',
        data:{
            "accion" : 'area',
        } ,
        success:  function(response){
            obj = JSON.parse(response);
            $select = $("#slareaper");
            $.each(obj['area'], function(e, i) {
                $select.append('<option value=' +i[0]+ '>' + i[1] + '</option>');
            }); 
        }
    }); 
}

function _lstcargo() {
    $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  'c_guardarpersonal.php',
        data:{
            "accion" : 'cargo',
        } ,
        success:  function(response){
            obj = JSON.parse(response);
            $select = $("#slcargpers");
            $.each(obj['area'], function(e, i) {
                $select.append('<option value=' +i[0]+ '>' + i[1] + '</option>');
            }); 
        }
    }); 
}

function _lstdepartamento() {
    $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  'c_guardarpersonal.php',
        data:{
            "accion" : 'depa',
        } ,
        success:  function(response){
            obj = JSON.parse(response);
            $select = $("#sldeparpers");
            $.each(obj['area'], function(e, i) {
                $select.append('<option value=' +i[0]+ '>' + i[1] + '</option>');
            }); 
        }
    }); 
}

function _lstprovi(dato) {
    $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  'c_guardarpersonal.php',
        data:{
            "accion" : 'provi',
            "dato" : dato
        } ,
        success:  function(response){
            obj = JSON.parse(response);
            $select = $("#slprovpers");
            $.each(obj['area'], function(e, i) {
                $select.append('<option value=' +i[1]+ '>' + i[2] + '</option>');
            }); 
        }
    }); 
}

function _lstdistri(dato) {
    $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  'c_guardarpersonal.php',
        data:{
            "accion" : 'distri',
            "dato" : dato
        } ,
        success:  function(response){
            obj = JSON.parse(response);
            $select = $("#sldistpers");
            $.each(obj['area'], function(e, i) {
                $select.append('<option value=' +i[2]+ '>' + i[3] + '</option>');
            }); 
        }
    }); 
}


function lstpersonal(){
    $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  'c_guardarpersonal.php',
        data:{
            "accion" : 'lstpersonal',
        } ,
        success:  function(response){
            obj = JSON.parse(response);
            $.each(obj['dato'], function(i, item) {
                sugepersonal.push(item); 
            });
        }
    });   
}

function buscarpersonal(personal) {
    $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  'c_guardarpersonal.php',
        data:{
            "accion" : 'buscarpersonal',
            "personal":personal
        } ,
        success:  function(response){
            obj = JSON.parse(response);
            $.each(obj['personal'], function(i, item) {
                dato = formato(item[14]).split(" ");
                $("#mtxtfecingreso").val(dato[0]);
                $("#mtxtdniper").val(item[4]);
                $("#mtxtnomperson").val(item[5]);
                $("#mtxtdirper").val(item[7]);
                $("#slcargpers").val(item[2]);
                $("#slareaper").val(item[1]);
                $("#mtxtsalperso").val(item[6]);
                $("#sldeparpers").val(item[8]);
                $("#slprovpers").val(item[9]);
                $("#sldistpers").val(item[10]);
                $("#mtxttelpers").val(item[11]);
                $("#mtxtcelpers").val(item[12]);
                if(item[19] == 'NULL'){item[19] = ''}
                $("#mtxtcuenpers").val(item[19]);
                if(item[20] == 'NULL'){item[20] = ''}
                $("#mtxttitulpers").val(item[20]);
                $("#slcestado").val(item[13]);
                tipo = 0;   
            });
        }
    });   
}

function formato(texto){
    return texto.replace(/^(\d{4})-(\d{2})-(\d{2})$/g,'$1/$2/$3');
}

function autocompletarpersonal() {
    lstpersonal();
    $("#txtpersonal").autocomplete({
        source: sugepersonal,
          select: function (event, ui) {
            $("#txtcodpersonal").val(ui.item.code);
            _lstprovi(ui.item.prov);
            _lstdistri(ui.item.dist);
          }
      });
}


    