<html lang="en"><head>
  <meta charset="UTF-8">
  
<link rel="apple-touch-icon" type="image/png" href="https://cpwebassets.codepen.io/assets/favicon/apple-touch-icon-5ae1a0698dcc2402e9712f7d01ed509a57814f994c660df9f7a952f3060705ee.png">
<meta name="apple-mobile-web-app-title" content="CodePen">
<link rel="shortcut icon" type="image/x-icon" href="https://cpwebassets.codepen.io/assets/favicon/favicon-aec34940fbc1a6e787974dcd360f2c6b63348d4b1f4e06c77743096d55480f33.ico">
<link rel="mask-icon" type="image/x-icon" href="https://cpwebassets.codepen.io/assets/favicon/logo-pin-8f3771b1072e3c38bd662872f6b673a722f4b3ca2421637d5596661b4e2132cc.svg" color="#111">
<title>CodePen - Collapse + Table with Bootstrap</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
.main{
    width:70%;
    margin:0 auto;
    padding:1em;
    border-radius: 8px;
}
body{
	padding-top:50px;
	background-color:#34495e;
}
.hiddenRow {
    padding: 0 !important;
}
</style>
  <script>
  window.console = window.console || function(t) {};
</script>

  <script>
  if (document.location.search.match(/type=embed/gi)) {
    window.parent.postMessage("resize", "*");
  }
</script>
</head>

<body translate="no">
        <div class="container">
            <div class="col-md-12">
                <div class="panel panel-default">
                        <div class="panel-heading">
                            Employee
                        </div>
                    <div class="panel-body">
                        <table class="table table-condensed table-striped">
                            <thead>
                                <tr>
                                <th>Oficina</th>
                                <th>Monto</th>
                                <!--<th>City</th>
                                <th>State</th>
                                <th>Status</th>-->
                                </tr>
                            </thead>
                            <tbody>
                                <tr data-toggle="collapse" data-target="#demo1" class="accordion-toggle collapsed" aria-expanded="false">
                                   <td>SMP</td>
                                   <td>2000</td>
                                   <!--  <td>Leme</td>
                                    <td>SP</td>
                                    <td>new</td>-->
                                </tr>
                                <tr>
                                    <td colspan="12" class="hiddenRow">
                                        <div class="accordian-body collapse" id="demo1" aria-expanded="false" style="height: 0px;"> 
                                            <table class="table table-striped">
                                                <!--
                                                <thead>
                                                    <tr class="info">
                                                        <th>Job</th>
                                                        <th>Company</th>
                                                        <th>Salary</th>		
                                                        <th>Date On</th>	
                                                        <th>Date off</th>	
                                                        <th>Action</th>	
                                                    </tr>
											    </thead>-->	
                                                <tbody>						
                                                    <tr data-toggle="collapse" class="accordion-toggle collapsed" data-target="#demo10" aria-expanded="false">
                                                        <td>Enginner Software</td>
                                                        <td>Google</td>
                                                       <!-- <td>U$8.00000 </td>
                                                        <td> 2016/09/27</td>
                                                        <td> 2017/09/27</td>-->
                                                    </tr>						
                                                    <tr>
                                                        <td colspan="12" class="hiddenRow">
                                                            <div class="accordian-body collapse" id="demo10" aria-expanded="false" style="height: 0px;"> 
                                                                <table class="table table-striped">
                                                                    <thead>
                                                                        <!--<tr>
                                                                            <td><a href="#"> XPTO 1</a></td>
                                                                            <td>XPTO 2</td>
                                                                            <td>Obs</td>
                                                                        </tr>-->
                                                                        <tr>
                                                                            <th>item 1</th>
                                                                            <th>item 2</th>
                                                                            <!--<th>item 3 </th>
                                                                            <th>item 4</th>
                                                                            <th>item 5</th>
                                                                            <th>Actions</th>-->
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td>item 1</td>
                                                                            <td>item 2</td>
                                                                            <!--<td>item 3</td>
                                                                            <td>item 4</td>
                                                                            <td>item 5</td>-->
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                        
                                                            </div> 
                                                        </td>
                                                    </tr>																		
                                                   <!-- <tr>
                                                        <td>Scrum Master</td>
                                                        <td>Google</td>
                                                        <td>U$8.00000 </td>
                                                        <td> 2016/09/27</td>
                                                        <td> 2017/09/27</td>
                                                    </tr>							
                                                    <tr>
                                                        <td>Back-end</td>
                                                        <td>Google</td>
                                                        <td>U$8.00000 </td>
                                                        <td> 2016/09/27</td>
                                                        <td> 2017/09/27</td>
                                                    </tr>							
                                                    <tr>
                                                        <td>Front-end</td>
                                                        <td>Google</td>
                                                        <td>U$8.00000 </td>
                                                        <td> 2016/09/27</td>
                                                        <td> 2017/09/27</td>
                                                    </tr>-->
                                                </tbody>
                                            </table>
                                        </div> 
                                    </td>
                                </tr>
                            
                                <tr data-toggle="collapse" data-target="#demo2" class="accordion-toggle collapsed" aria-expanded="false">
                                  
                                    <td>SMP2</td>
                                    <td>1000</td>
                                    <!--<td>São Paulo</td>
                                    <td>SP</td>
                                    <td> new</td>-->
                                </tr>
                                <tr>
                                    <td colspan="6" class="hiddenRow"><div id="demo2" class="accordian-body collapse" aria-expanded="false" style="height: 0px;">Demo2</div></td>
                                </tr>
                                <tr data-toggle="collapse" data-target="#demo3" class="accordion-toggle collapsed" aria-expanded="false">
                                   
                                    <td>SMP3</td>
                                    <td>3000</td>
                                    <!--<td>Dracena</td>
                                    <td>SP</td>
                                    <td> New</td>-->
                                </tr>
                                <tr>
                                    <td colspan="6" class="hiddenRow">
                                        <div id="demo3" class="accordian-body collapse" aria-expanded="false" style="height: 0px;">Demo3 sadasdasdasdasdas</div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div> 
            </div>
        </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </body>
</html>