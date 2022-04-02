<?php
    require_once("../menu/index.php");
?>

<script>
        var url = "";
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

ul.checktree-root, ul#tree ul {
list-style: none;
}

</style>

<form id="frmpermisos">
    <div style="padding:1em ; padding-left: var(--bs-gutter-x,.75rem);">
            <div class="row g-3 align-items-center" style="float: right;">
                <div class="col-auto">
                    <input class="form-control form-control" id="txtanexo" >
                </div>
                <div class="col-auto">
                    <button class="btn btn-primary" id="btnmostrar">Buscar</button>
                </div>
                <div class="col-auto">
                
                </div>
            </div>

             <center style="padding-top: 4em;padding-bottom: 2em;"><label>MENUS</label></center>


        <div class="container-fluid">
            <ul id="tree">
            </ul>

        </div>
            
    </div>     
</form>
    <script src="../js/jsconfiguracion.js"></script>
    <script src="../js/jsqueryThree.js"></script>
       <script>
        $('#tree').checktree();
   </script>
  
                        
 