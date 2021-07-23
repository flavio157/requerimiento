<?php
    require_once("../menu/index.php");
?>

<script>
        var url = "../js/jsconfiguracion.js";
        $.getScript(url);
</script>
    <form>
        <div class='container'>
            
            <div class="contenedorbs">
               <div class="mb-3 contenerdorslc">
                    <input type="email" class="form-control form-control" id="colFormLabelSm2" >
               </div>
               <div class="contenedorboton">
                   <div class="mb-3">
                       <div class="gap-2 divbtn col-6 mx-auto">
                               <div class="col divbtnmostrar">
                                   <button class="btn btn-primary" id="btnmostrar">Buscar</button>
                               </div>
                       </div>
                   </div>
               </div>
            </div>   
           
         
            
            <div id='checbox'>
               <div class="row g-3 mb-3">
                    <div class="col-4">
                        <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                                <label class="form-check-label" for="defaultCheck1">
                                    REG. VISITA
                                </label>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="defaultCheck2">
                                <label class="form-check-label" for="defaultCheck2">
                                    Default checkbox
                                </label>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="defaultCheck3">
                                <label class="form-check-label" for="defaultCheck3">
                                    Default checkbox
                                </label>
                        </div>
                    </div>
                </div>
                

               <!--     <div class="row g-2 mb-3">
                    <div class="col-sm-10">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                            <label class="form-check-label" for="defaultCheck1">
                                REG. VISITA
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row g-2 mb-3">
                    <div class="col-sm-10">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                            <label class="form-check-label" for="defaultCheck1">
                                Default checkbox
                            </label>
                        </div>
                    </div>
                </div>
            </div>   -->
           
        
         </div>
         
    </form>
   
  

