<?php
    require_once("../menu/index.php");
?>

<script>
        var url = "../js/jsconfiguracion.js";
        $.getScript(url);
</script>
<style>
.child-check{
  margin-left: 15px;
  display: none;
}

.child-check.active{
  display: block;
}



</style>
    <form>
    <div class='container' style="padding:1em ;">
            <div class="row g-3 align-items-center" style="float: right;">
                <div class="col-auto">
                    <input type="email" class="form-control form-control" id="colFormLabelSm2" >
                </div>
                <div class="col-auto">
                    <button class="btn btn-primary" id="btnmostrar">Buscar</button>
                </div>
                <div class="col-auto">
                
                </div>
            </div>

             <center style="padding-top: 4em;padding-bottom: 2em;"><label>MENUS</label></center>


<div class="contenedorbs">
        <div class="parent-check">
                <input type="checkbox"><label>Level 1</label>
                <div class="child-check">
                    <input type="checkbox"><label>Level 1.1</label>
                    <div class="child-check">
                    <input type="checkbox"><label>Level 1.1.1</label>
                    </div>
                </div>
                <div class="child-check">
                    <input type="checkbox"><label>Level 1.2</label>
                </div>
                </div>
                <div class="parent-check">
                <input type="checkbox"><label>Level 2</label>
                    <div class="child-check">
                    <input type="checkbox"><label>Level 2.1</label>
                </div>
 </div>




<!--    <div class="mb-3" style="float: left;">
                            <input type="email" class="form-control form-control" id="colFormLabelSm2" >
                    </div>
                    <div class="contenedorboton">
                        <div class="mb-3">
                            <div class="divbtn mx-auto">
                                    <div class="col divbtnmostrar">
                                        <button class="btn btn-primary" id="btnmostrar">Buscar</button>
                                    </div>
                            </div>
                        </div>
                    </div>
                    </div>   
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                        <label class="form-check-label" for="flexCheckDefault">
                            Default checkbox
                        </label>
                    </div>-->
         
           
                    <div id='checbox' class="col-auto row mb-3">
                    </div>
               
            </div>
         </div>     
    </form>
   
  

  