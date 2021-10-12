var availableTags = [];
$( function() {
    personal();
    $( "#tags" ).autocomplete({
      source: availableTags
    });
  } );


  function personal() {
    $.ajax({
        dataType:'text',
        type: 'POST', 
        url:  '../materiales/c_moldes.php',
        data:{
            "accion" : 'personal',
        } ,
        success:  function(response){
            obj = JSON.parse(response);
            $.each(obj['dato'], function(i, item) {
               availableTags.push(item); 
            });
        }
    }); 
  }