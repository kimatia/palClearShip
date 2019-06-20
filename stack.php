


<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="postscript.js"></script>
<script type="text/javascript" src="postscriptt.js"></script>
<!-- africas API key -->
<!-- App Name: Sandbox
Username: sandbox -->
<!-- 464b294cf370f51a95a33ab22f9771fe5d046a1ebf08fcd10d2c0fd76dbfd63d -->
<?php
session_start();

require_once 'dbconfig.php';

//get the logged in user credentials and validate
require_once 'class.user.php';
$user_home = new USER();

if(!$user_home->is_logged_in())
{
 $user_home->redirect('index.php');
}

$stmt = $user_home->runQuery("SELECT * FROM tbl_users WHERE userID=:uid");
$stmt->execute(array(":uid"=>$_SESSION['userSession']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
//we can now access the users details from $row['appropriatedbfield']

//check user type
$admin = "admin";
if($row['loginType']==$admin){
  $type = "admin";
}else{
  $type = "worker";
}

//check out a particular file stack
if (isset($_GET['view'])){
  $_SESSION['view'] = $_GET['view'];
  header("location: stack.php");
}

$view = $_SESSION['view'];

$verified = 'Yes';
if($row['status']!==$verified){
  $notVerifiedMessage = "<div class='alert alert-danger'>
<button class='close' data-dismiss='alert'>&times;</button>
<strong>Allert!</strong>  You have no jurisdiction to manipulate forms. Kindly wait to get that priviledge or contact the admin.
</div>";
}

if(isset($_POST['btn-add-stack'])){

 $sNumber = $_POST['stackNumber'];

 $SQL = $con->prepare("INSERT INTO tbl_stacks(stackNumber, postDate) VALUES(?,now())");
 if(!$SQL){
  echo $con->error;
  $msgCreateStack = "<div class='alert alert-danger'>
    <button class='close' data-dismiss='alert'>&times;</button>
     <strong>Sorry!</strong>  Create failed.
     </div>
     ";
  header("refresh:5;adhome.php");
}else{

  $SQL->bind_param('s',$sNumber);
  $SQL->execute();
  header("location: adhome.php");
  $msgCreateStack = "<div class='alert alert-success'>
    <button class='close' data-dismiss='alert'>&times;</button>
     <strong>Success !</strong>  Create success.
     </div>
     ";
 }

}

//edit file  in that stack
if (isset($_GET['editbol'])){
  $_SESSION['editbol'] = $_GET['editbol'];
  $_SESSION['editfile'] = "bol";
  header("location: editFile.php");
}

if (isset($_GET['editidf'])){
  $_SESSION['editidf'] = $_GET['editidf'];
  $_SESSION['editfile'] = "idf";
  header("location: editFile.php");
}

if (isset($_GET['editkbs'])){
  $_SESSION['editkbs'] = $_GET['editkbs'];
  $_SESSION['editfile'] = "kbs";
  header("location: editFile.php");
}

if (isset($_GET['editecert'])){
  $_SESSION['editecert'] = $_GET['editecert'];
  $_SESSION['editfile'] = "ecert";
  header("location: editFile.php");
}

if (isset($_GET['editinvoice'])){
  $_SESSION['editinvoice'] = $_GET['editinvoice'];
  $_SESSION['editfile'] = "invoice";
  header("location: editFile.php");
}

if (isset($_GET['edittreciept'])){
  $_SESSION['edittreciept'] = $_GET['edittreciept'];
  $_SESSION['editfile'] = "treciept";
  header("location: editFile.php");
}

if (isset($_GET['editquadruplicate'])){
  $_SESSION['editquadruplicate'] = $_GET['editquadruplicate'];
  $_SESSION['editfile'] = "quadruplicate";
  header("location: editFile.php");
}

if (isset($_GET['editlbook'])){
  $_SESSION['editlbook'] = $_GET['editlbook'];
  $_SESSION['editfile'] = "lbook";
  header("location: editFile.php");
}
if (isset($_GET['editcoc'])){
  $_SESSION['editcoc'] = $_GET['editcoc'];
  $_SESSION['editfile'] = "coc";
  header("location: editFile.php");
}
if (isset($_GET['editcoi'])){
  $_SESSION['editcoi'] = $_GET['editcoi'];
  $_SESSION['editfile'] = "coi";
  header("location: editFile.php");
}
if (isset($_GET['editpkl'])){
  $_SESSION['editpkl'] = $_GET['editpkl'];
  $_SESSION['editfile'] = "pkl";
  header("location: editFile.php");
}

//check stack number to direct input of files in that stack
if (isset($_GET['addBOL'])){
  $_SESSION['stackNumber'] = $_GET['addBOL'];
  $_SESSION['file'] = "BOL";
  header("location: addFile.php");
}

if (isset($_GET['addIDF'])){
  $_SESSION['stackNumber'] = $_GET['addIDF'];
  $_SESSION['file'] = "IDF";
  header("location: addFile.php");
}

if (isset($_GET['addKBS'])){
  $_SESSION['stackNumber'] = $_GET['addKBS'];
  $_SESSION['file'] = "KBS";
  header("location: addFile.php");
}

if (isset($_GET['addECert'])){
  $_SESSION['stackNumber'] = $_GET['addECert'];
  $_SESSION['file'] = "ECert";
  header("location: addFile.php");
}

if (isset($_GET['addInvoice'])){
  $_SESSION['stackNumber'] = $_GET['addInvoice'];
  $_SESSION['file'] = "Invoice";
  header("location: addFile.php");
}

if (isset($_GET['addTReciept'])){
  $_SESSION['stackNumber'] = $_GET['addTReciept'];
  $_SESSION['file'] = "TReciept";
  header("location: addFile.php");
}

if (isset($_GET['addQuadruplicate'])){
  $_SESSION['stackNumber'] = $_GET['addQuadruplicate'];
  $_SESSION['file'] = "Quadruplicate";
  header("location: addFile.php");
}
if (isset($_GET['addPkl'])){
  $_SESSION['stackNumber'] = $_GET['addPkl'];
  $_SESSION['file'] = "Pkl";
  header("location: addFile.php");
}
if (isset($_GET['addCoi'])){
  $_SESSION['stackNumber'] = $_GET['addCoi'];
  $_SESSION['file'] = "Coi";
  header("location: addFile.php");
}
if (isset($_GET['addLBook'])){
  $_SESSION['stackNumber'] = $_GET['addLBook'];
  $_SESSION['file'] = "LBook";
  header("location: addFile.php");
}
 if (isset($_GET['download'])) {
$download = $_GET['download'];
if (file_exists($download) && is_readable($download) && preg_match('/\.pdf$/',$download)) {
 header('Content-Type: application/pdf');
 header("Content-Disposition: attachment; filename=\"$download\"");
 readfile($download);
}else {
 header("HTTP/1.0 404 Not Found");
 echo "<h1>Error 404: File Not Found: <br /><em>$download</em></h1>";
}
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Palm | Home</title>

  <!-- Bootstrap core CSS -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="css/blog-post.css" rel="stylesheet">
           <!--  <link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css"> -->
<script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<!------ Include the above in your HEAD tag ---------->
 <!-- Bootstrap Core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet"> 

    <!-- MetisMenu CSS -->
    <link href="vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="dist/css/sb-admin-2.css" rel="stylesheet">
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <!-- Custom CSS -->
    <!-- jQuery -->
    <script src="vendor/jquery/jquery.min.js"></script>

    <!-- Begin emoji-picker Stylesheets -->
    <link href="lib/css/emoji.css" rel="stylesheet">
    <!-- End emoji-picker Stylesheets -->

    <!-- jQuery -->
</head>

<body>

 <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
      <a class="navbar-brand" href="#">Palm Freighters Limited</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
                 <li>
                       <a href="adhome.php" class="nav-link"><span class="fa fa-home"></span>Home</a>
                  </li>
                <li>
                   <a class="nav-link" href="userView.php"><span class="fa fa-users"></span> Users</a>
                </li>
                <li class="dropdown get_tooltip" data-toggle="tooltip" data-placement="bottom" title="logout">
                    <a class="nav-link" class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i> Hello Admin <?php echo $row['userName'];?> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="logout.php"><i class="fa fa-sign-out fa-fw"> Logout</i></a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
            </ul>      
            </div>
    </div>
  </nav>
<?php
           
            $x = 0;
            $respstack = $con->query("SELECT * FROM tbl_stacks WHERE stackNumber='$view' ORDER BY id DESC");
            while($rowStack=$respstack->fetch_array()){
              $num = $rowStack['stackNumber'];
              ?>
              <?php
if($rowStack['stackType']=="Container"){
?>
<!-- Page Content -->
    <div class="row" style="margin-top: 80px;">
      <div class="container">
       <div class="card">
        <div class="col-md-12">
        <div class="panel panel-default">
               <div class="card-header">
               <center>

          <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
   <a href="#" class="btn btn-primary"><?php echo $rowStack['stackNumber']; ?></a>
    <pp style="color: orange;">Container: <?php echo $rowStack['fileOwner']; ?></pp>
     </button>
  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
    <a href="#" class="dropdown-item" data-toggle="modal" data-target="#infoDataFileCosts" data-whatever10=<?php echo $rowStack['id'];?> >Add Costs</a>
   <a href="#" class="dropdown-item" data-toggle="modal" data-target="#infoDataFileCostsView" data-whatever11=<?php echo $rowStack['id'];?> >View Costs</a>
   <a href="?merge_pdf=<?php echo $rowStack['stackNumber'];?>&type=vehicle" class="dropdown-item" >Download Merged Forms</a>
   <a href="?deleteStack=<?php echo $rowStack['id'];?>" class="dropdown-item" onclick="return confirm('sure to delete file <?php echo $rowStack['stackNumber']; ?> for client <?php echo $rowStack['fileOwner']; ?> ?')" >Delete file</a>
  </div>
</center>
        </div>
        <div class="row">

        <div  class="col-md-4">
        <div class="card my-4" style="min-height: 450px;">
    
          <div class="card-body">
             <?php
                  //get file image
                  $respFileImage = $con->query("SELECT * FROM tbl_billoflading WHERE stackNumber='$num'");
                  if($respFileImage){
                    $rowFileImage=$respFileImage->fetch_array();
                  }

                  $dee = $rowFileImage['userId'];
                  $respUserName = $con->query("SELECT userName FROM tbl_users WHERE userID='$dee'");
                  $rowUserName=$respUserName->fetch_array();

                   if($rowStack['bol']=="Yes"){
                    $str=$rowFileImage['billofLadingNumber'];
                    $strbol = strtoupper($str);
                    ?>
                     <div class="row">
                      <div class="col-md-6">
                         <h5 style="font-size: 13px;"><strong>Bill Of Lading</strong></h5>
                      </div>
                      <div class="col-md-6">
                         <h5 style="font-size: 13px;"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;No.<?php echo $strbol; ?></strong></h5>
                      </div>
                    </div>
                   
                    <a href="#"  data-toggle="modal" data-target="#displaybol<?php echo $x; ?>">
                       <!-- method 1 embed -->
                    <!-- <embed src="" alt="pdf" pluginspage="http://www.adobe.com/products/acrobat/readstep2.html"> -->
                    <!-- method 2 iframe -->
                    <iframe src="upload/<?php echo $rowFileImage['billofLading_file']; ?>" style="width:300px; height:320px;" frameborder="1"></iframe>
                    </a>
                    &nbsp;&nbsp;&nbsp;&nbsp;<span class="fa fa-user"><?php echo $rowUserName['userName'];?></span>
                 &nbsp;&nbsp;&nbsp;&nbsp;<span class="fa fa-clock-o"><?php echo $rowFileImage['postTime'];?></span>
<span class="pull-right"><a href="company_servlet/36/E45j/pdf_fmanifest/logsPrintOut.php?stackID=<?php echo $rowFileImage['stackNumber'];?>" > Info</a>&nbsp;<a href="?editbol=<?php echo $rowFileImage['id']; ?>" class="fa fa-pencil"> Edit</a>
</a></span>

                    <?php
                  }else{
                    ?><div class="row">
                      <div class="col-md-12">
                         <h5 style="font-size: 13px;">&nbsp;&nbsp;&nbsp;&nbsp;<strong>Bill Of Lading</strong></h5>
                      </div>
                     
                    </div>
                    <a href="?addBOL=<?php echo $rowStack['stackNumber'];?>" class="fa fa-file" style="font-size:345px"></a>
                    <?php
                  }?>
          </div>
        </div>
      </div>
      <div  class="col-md-4">
        <div class="card my-4" style="min-height: 450px;">
        
          <div class="card-body">
             <?php
                  //get file image
                  $respFileImage = $con->query("SELECT * FROM tbl_idf WHERE stackNumber='$num'");
                  if($respFileImage){
                    $rowFileImage=$respFileImage->fetch_array();
                  }

                  $dee = $rowFileImage['userId'];
                  $respUserName = $con->query("SELECT userName FROM tbl_users WHERE userID='$dee'");
                  $rowUserName=$respUserName->fetch_array();

                  if($rowStack['idf']=="Yes"){
                    $str=$rowFileImage['idfNo'];
                    $stridf = strtoupper($str);
                   ?>
                   <div class="row">
                      <div class="col-md-6">
                         <h5 style="font-size: 13px;"><strong>Import Decl Form</strong></h5>
                      </div>
                      <div class="col-md-6">
                         <h5 style="font-size: 13px;"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;No.<?php echo $stridf; ?></strong></h5>
                      </div>
                    </div>
                  
                   
                   <a href="#" data-toggle="modal" data-target="#displayidf<?php echo $x; ?>">
                   <!-- method 1 embed -->
                    <!-- <embed src="" alt="pdf" pluginspage="http://www.adobe.com/products/acrobat/readstep2.html"> -->
                    <!-- method 2 iframe -->
                    <iframe src="upload/<?php echo $rowFileImage['idf_file']; ?>" style="width:300px; height:320px;" frameborder="1"></iframe>
                 </a>
                 &nbsp;&nbsp;&nbsp;&nbsp;<span class="fa fa-user"><?php echo $rowUserName['userName'];?></span>

                   &nbsp;&nbsp;&nbsp;&nbsp;<span class="fa fa-clock-o"><?php echo $rowFileImage['postTime'];?></span>
<span class="pull-right"><a href="#" data-toggle="modal" data-target="#infoDataFileIdf" data-whatever2=<?php echo $rowFileImage['id'];?> class="fa fa-info-circle"> Info</a>&nbsp;<a href="?editidf=<?php echo $rowFileImage['id']; ?>" class="fa fa-pencil"> Edit</a>
</a></span>
         
                           <?php
                 }else{
                   ?>
                   <div class="row">
                      <div class="col-md-12">
                         <h5 style="font-size: 13px;">&nbsp;&nbsp;&nbsp;&nbsp;<strong>Import Declaration Form</strong></h5>
                      </div>
                     
                    </div>
                  <a href="?addIDF=<?php echo $rowStack['stackNumber'];?>" class="fa fa-file" style="font-size:345px"></a>
                  <?php }?>
          </div>
        </div>
      </div>
      <div  class="col-md-4">
        <div class="card my-4" style="min-height: 450px;">
        
          <div class="card-body">
             <?php
                  //get file image
                  $respFileImage = $con->query("SELECT * FROM tbl_invoice WHERE stackNumber='$num'");
                  if($respFileImage){
                    $rowFileImage=$respFileImage->fetch_array();
                  }


                  $dee = $rowFileImage['userId'];
                  $respUserName = $con->query("SELECT userName FROM tbl_users WHERE userID='$dee'");
                  $rowUserName=$respUserName->fetch_array();


                  if($rowStack['invoice']=="Yes"){
                     $str=$rowFileImage['invoiceNo'];
                    $strinvoice = strtoupper($str);
                    ?>
                     <div class="row">
                      <div class="col-md-6">
                         <h5 style="font-size: 13px;"><strong>&nbsp;&nbsp;&nbsp;&nbsp;Invoice Form</strong></h5>
                      </div>
                      <div class="col-md-6">
                         <h5 style="font-size: 13px;"><strong>No.<?php echo $strinvoice; ?></strong></h5>
                      </div>
                    </div>
                    
                   
                    <a href="#" data-toggle="modal" data-target="#displayinvoice<?php echo $x; ?>">
                    <!-- method 1 embed -->
                    <!-- <embed src="" alt="pdf" pluginspage="http://www.adobe.com/products/acrobat/readstep2.html"> -->
                    <!-- method 2 iframe -->
                    <iframe src="upload/<?php echo $rowFileImage['invoice_file']; ?>" style="width:300px; height:320px;" frameborder="1"></iframe>
                  </a>
                  &nbsp;&nbsp;&nbsp;&nbsp;<span class="fa fa-user"><?php echo $rowUserName['userName'];?></span>
                   &nbsp;&nbsp;&nbsp;&nbsp;<span class="fa fa-clock-o"><?php echo $rowFileImage['postTime'];?></span>
<span class="pull-right"><a href="#" data-toggle="modal" data-target="#infoDataFileInvoice" data-whatever5=<?php echo $rowFileImage['id'];?> class="fa fa-info-circle"> Info</a>&nbsp;<a href="?editinvoice=<?php echo $rowFileImage['id']; ?>" class="fa fa-pencil"> Edit</a>
</a></span>
              
                      <?php
                  }else{
                    ?>
                    <div class="row">
                      <div class="col-md-12">
                         <h5 style="font-size: 13px;">&nbsp;&nbsp;&nbsp;&nbsp;<strong>Invoice Form</strong></h5>
                      </div>
                     
                    </div>
                  <a href="?addInvoice=<?php echo $rowStack['stackNumber'];?>" class="fa fa-file" style="font-size:345px"></a>
                  <?php }?>
          </div>
        </div>
      </div>
      </div>
      <div class="row">
        <div  class="col-md-4">
        <div class="card my-4" style="min-height: 450px;">
        
          <div class="card-body">
             <?php
                  //get file image
                  $respFileImage = $con->query("SELECT * FROM tbl_pkl WHERE stackNumber='$num'");
                  if($respFileImage){
                    $rowFileImage=$respFileImage->fetch_array();
                  }

                  $dee = $rowFileImage['userId'];
                  $respUserName = $con->query("SELECT userName FROM tbl_users WHERE userID='$dee'");
                  $rowUserName=$respUserName->fetch_array();

                  if($rowStack['pkl']=="Yes"){
                    $str=$rowFileImage['pklNo'];
                    $strpkl = strtoupper($str);
                   ?>
                   <div class="row">
                      <div class="col-md-6">
                         <h5 style="font-size: 13px;"><strong>Packaging List</strong></h5>
                      </div>
                      <div class="col-md-6">
                         <h5 style="font-size: 13px;"><strong>No.<?php echo $strpkl; ?></strong></h5>
                      </div>
                    </div>
                  
                   
                   <a href="#" data-toggle="modal" data-target="#displaypkl<?php echo $x; ?>">
                   <!-- method 1 embed -->
                    <!-- <embed src="" alt="pdf" pluginspage="http://www.adobe.com/products/acrobat/readstep2.html"> -->
                    <!-- method 2 iframe -->
                    <iframe src="upload/<?php echo $rowFileImage['pkl_file']; ?>" style="width:300px; height:320px;" frameborder="1"></iframe>
                 </a>
                 &nbsp;&nbsp;&nbsp;&nbsp;<span class="fa fa-user"><?php echo $rowUserName['userName'];?></span>

                   &nbsp;&nbsp;&nbsp;&nbsp;<span class="fa fa-clock-o"><?php echo $rowFileImage['postTime'];?></span>
<span class="pull-right"><a href="#" data-toggle="modal" data-target="#infoDataFilepkl" data-whatever2=<?php echo $rowFileImage['id'];?> class="fa fa-info-circle"> Info</a>&nbsp;<a href="?editpkl=<?php echo $rowFileImage['id']; ?>" class="fa fa-pencil"> Edit</a>
</a></span>
             
                           <?php
                 }else{
                   ?>
                   <div class="row">
                      <div class="col-md-12">
                         <h5 style="font-size: 13px;">&nbsp;&nbsp;&nbsp;&nbsp;<strong>Packaging List Form</strong></h5>
                      </div>
                     
                    </div>
                  <a href="?addPkl=<?php echo $rowStack['stackNumber'];?>" class="fa fa-file" style="font-size:345px"></a>
                  <?php }?>
          </div>
        </div>
      </div>
      <div  class="col-md-4">
        <div class="card my-4" style="min-height: 450px;">
        
          <div class="card-body">
             <?php

                  //get file image
                  $respFileImage = $con->query("SELECT * FROM tbl_coc WHERE stackNumber='$num'");
                  if($respFileImage){
                    $rowFileImage=$respFileImage->fetch_array();
                  }

                  $dee = $rowFileImage['userId'];
                  $respUserName = $con->query("SELECT userName FROM tbl_users WHERE userID='$dee'");
                  $rowUserName=$respUserName->fetch_array();

                   if($rowStack['coc']=="Yes"){
                     $str=$rowFileImage['cocNo'];
                    $strcoc = strtoupper($str);
                    ?>
                     <div class="row">
                      <div class="col-md-6">
                         <h5 style="font-size: 13px;"><strong>COC</strong></h5>
                      </div>
                      <div class="col-md-6">
                         <h5 style="font-size: 13px;"><strong>No.<?php echo $strcoc; ?></strong></h5>
                      </div>
                    </div>
                    
                    
                    <a href="#" data-toggle="modal" data-target="#displaycoc<?php echo $x; ?>">
                    <!-- method 1 embed -->
                    <!-- <embed src="" alt="pdf" pluginspage="http://www.adobe.com/products/acrobat/readstep2.html"> -->
                    <!-- method 2 iframe -->
                    <iframe src="upload/<?php echo $rowFileImage['coc_file']; ?>" style="width:300px; height:320px;" frameborder="1"></iframe>
                    </a>
                    &nbsp;&nbsp;&nbsp;&nbsp;<span class="fa fa-user"><?php echo $rowUserName['userName'];?></span>
                   &nbsp;&nbsp;&nbsp;&nbsp;<span class="fa fa-clock-o"><?php echo $rowFileImage['postTime'];?></span>
<span class="pull-right"><a href="#" data-toggle="modal" data-target="#infoDataFileCoc" data-whatever9=<?php echo $rowFileImage['id'];?> class="fa fa-info-circle"> Info</a>&nbsp;<a href="?editcoc=<?php echo $rowFileImage['id']; ?>" class="fa fa-pencil"> Edit</a>
</a></span>
                  
                            <?php
                  }else{
                    ?>
                    <div class="row">
                      <div class="col-md-12">
                         <h5 style="font-size: 13px;">&nbsp;&nbsp;&nbsp;&nbsp;<strong>Certificate of conformity</strong></h5>
                      </div>
                     
                    </div>
                  <a href="?addCoc=<?php echo $rowStack['stackNumber'];?>" class="fa fa-file" style="font-size:345px"></a>

                  <?php }?>
          </div>
        </div>
      </div>
      <div  class="col-md-4">
        <div class="card my-4" style="min-height: 450px;">
        
          <div class="card-body">
             <?php
                  //get file image
                  $respFileImage = $con->query("SELECT * FROM tbl_treciept WHERE stackNumber='$num'");
                  if($respFileImage){
                    $rowFileImage=$respFileImage->fetch_array();
                  }

                  $dee = $rowFileImage['userId'];
                  $respUserName = $con->query("SELECT userName FROM tbl_users WHERE userID='$dee'");
                  $rowUserName=$respUserName->fetch_array();

                   if($rowStack['treciept']=="Yes"){
                    $str=$rowFileImage['trecieptNo'];
                    $strtreciept = strtoupper($str);
                    ?>
                     <div class="row">
                      <div class="col-md-6">
                         <h5 style="font-size: 13px;"><strong>Kenya Revenue Slip</strong></h5>
                      </div>
                      <div class="col-md-6">
                         <h5 style="font-size: 13px;"><strong>No.<?php echo $strtreciept; ?></strong></h5>
                      </div>
                    </div>
                     
                   
                    <a href="#" data-toggle="modal" data-target="#displaytreciept<?php echo $x; ?>">
                    <!-- method 1 embed -->
                    <!-- <embed src="" alt="pdf" pluginspage="http://www.adobe.com/products/acrobat/readstep2.html"> -->
                    <!-- method 2 iframe -->
                    <iframe src="upload/<?php echo $rowFileImage['treciept_file']; ?>" style="width:300px; height:320px;" frameborder="1"></iframe>
                  </a>
                  &nbsp;&nbsp;&nbsp;&nbsp;<span class="fa fa-user"><?php echo $rowUserName['userName'];?></span>
                  &nbsp;&nbsp;&nbsp;&nbsp;<span class="fa fa-clock-o"><?php echo $rowFileImage['postTime'];?></span>
<span class="pull-right"><a href="#" data-toggle="modal" data-target="#infoDataFileKra" data-whatever6=<?php echo $rowFileImage['id'];?> class="fa fa-info-circle"> Info</a>&nbsp;<a href="?edittreciept=<?php echo $rowFileImage['id']; ?>" class="fa fa-pencil"> Edit</a>
</a></span>

                            <?php
                  }else{
                    ?>
                    <div class="row">
                      <div class="col-md-12">
                         <h5 style="font-size: 13px;">&nbsp;&nbsp;&nbsp;&nbsp;<strong>KRA Bank Slip</strong></h5>
                      </div>
                     
                    </div>
                  <a href="?addTReciept=<?php echo $rowStack['stackNumber'];?>" class="fa fa-file" style="font-size:345px"></a>
                  <?php }?>
          </div>
        </div>
        </div>
      </div>
      </div>
    </div>
      </div>
      </div>
      </div>
     
    <!-- /.row -->
<?php
}elseif ($rowStack['stackType']=="Vehicle") {
 ?>
<!-- Page Content -->
    <div class="row" style="margin-top: 80px;">
      <div class="container">
       <div class="card">
        <div class="col-md-12">
        <div class="panel panel-default">
               <div class="card-header">
               <center>

          <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
   <a href="#" class="btn btn-primary"><?php echo $rowStack['stackNumber']; ?></a>
    <pp style="color: orange;">Vehicle: <?php echo $rowStack['fileOwner']; ?></pp>
     </button>
  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
    <a href="#" class="dropdown-item" data-toggle="modal" data-target="#infoDataFileCosts" data-whatever10=<?php echo $rowStack['id'];?> >Add Costs</a>
   <a href="#" class="dropdown-item" data-toggle="modal" data-target="#infoDataFileCostsView" data-whatever11=<?php echo $rowStack['id'];?> >View Costs</a>
   <a href="?merge_pdf=<?php echo $rowStack['stackNumber'];?>&type=vehicle" class="dropdown-item" >Download Merged Forms</a>
   <a href="?deleteStack=<?php echo $rowStack['id'];?>" class="dropdown-item" onclick="return confirm('sure to delete file <?php echo $rowStack['stackNumber']; ?> for client <?php echo $rowStack['fileOwner']; ?> ?')" >Delete file</a>
  </div>
</center>
        </div>
        <div class="row">

        <div  class="col-md-4">
        <div class="card my-4" style="min-height: 450px;">
    
          <div class="card-body">
             <?php
                  //get file image
                  $respFileImage = $con->query("SELECT * FROM tbl_billoflading WHERE stackNumber='$num'");
                  if($respFileImage){
                    $rowFileImage=$respFileImage->fetch_array();
                  }

                  $dee = $rowFileImage['userId'];
                  $respUserName = $con->query("SELECT userName FROM tbl_users WHERE userID='$dee'");
                  $rowUserName=$respUserName->fetch_array();

                   if($rowStack['bol']=="Yes"){
                    $str=$rowFileImage['billofLadingNumber'];
                    $strbol = strtoupper($str);
                    ?>
                     <div class="row">
                      <div class="col-md-6">
                         <h5 style="font-size: 13px;"><strong>Bill Of Lading</strong></h5>
                      </div>
                      <div class="col-md-6">
                         <h5 style="font-size: 13px;"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;No.<?php echo $strbol; ?></strong></h5>
                      </div>
                    </div>
                   
                    <a href="#"  data-toggle="modal" data-target="#displaybol<?php echo $x; ?>">
                       <!-- method 1 embed -->
                    <!-- <embed src="" alt="pdf" pluginspage="http://www.adobe.com/products/acrobat/readstep2.html"> -->
                    <!-- method 2 iframe -->
                    <iframe src="upload/<?php echo $rowFileImage['billofLading_file']; ?>" style="width:300px; height:320px;" frameborder="1"></iframe>
                    </a>
                    &nbsp;&nbsp;&nbsp;&nbsp;<span class="fa fa-user"><?php echo $rowUserName['userName'];?></span>
                 &nbsp;&nbsp;&nbsp;&nbsp;<span class="fa fa-clock-o"><?php echo $rowFileImage['postTime'];?></span>
<span class="pull-right"><a href="company_servlet/36/E45j/pdf_fmanifest/logsPrintOut.php?stackID=<?php echo $rowFileImage['stackNumber'];?>" > Info</a>&nbsp;<a href="?editbol=<?php echo $rowFileImage['id']; ?>" class="fa fa-pencil"> Edit</a>
</a></span>

                    <?php
                  }else{
                    ?><div class="row">
                      <div class="col-md-12">
                         <h5 style="font-size: 13px;">&nbsp;&nbsp;&nbsp;&nbsp;<strong>Bill Of Lading</strong></h5>
                      </div>
                     
                    </div>
                    <a href="?addBOL=<?php echo $rowStack['stackNumber'];?>" class="fa fa-file" style="font-size:345px"></a>
                    <?php
                  }?>
          </div>
        </div>
      </div>
      <div  class="col-md-4">
        <div class="card my-4" style="min-height: 450px;">
        
          <div class="card-body">
             <?php
                  //get file image
                  $respFileImage = $con->query("SELECT * FROM tbl_idf WHERE stackNumber='$num'");
                  if($respFileImage){
                    $rowFileImage=$respFileImage->fetch_array();
                  }

                  $dee = $rowFileImage['userId'];
                  $respUserName = $con->query("SELECT userName FROM tbl_users WHERE userID='$dee'");
                  $rowUserName=$respUserName->fetch_array();

                  if($rowStack['idf']=="Yes"){
                    $str=$rowFileImage['idfNo'];
                    $stridf = strtoupper($str);
                   ?>
                   <div class="row">
                      <div class="col-md-6">
                         <h5 style="font-size: 13px;"><strong>Import Decl Form</strong></h5>
                      </div>
                      <div class="col-md-6">
                         <h5 style="font-size: 13px;"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;No.<?php echo $stridf; ?></strong></h5>
                      </div>
                    </div>
                  
                   
                   <a href="#" data-toggle="modal" data-target="#displayidf<?php echo $x; ?>">
                   <!-- method 1 embed -->
                    <!-- <embed src="" alt="pdf" pluginspage="http://www.adobe.com/products/acrobat/readstep2.html"> -->
                    <!-- method 2 iframe -->
                    <iframe src="upload/<?php echo $rowFileImage['idf_file']; ?>" style="width:300px; height:320px;" frameborder="1"></iframe>
                 </a>
                 &nbsp;&nbsp;&nbsp;&nbsp;<span class="fa fa-user"><?php echo $rowUserName['userName'];?></span>

                   &nbsp;&nbsp;&nbsp;&nbsp;<span class="fa fa-clock-o"><?php echo $rowFileImage['postTime'];?></span>
<span class="pull-right"><a href="#" data-toggle="modal" data-target="#infoDataFileIdf" data-whatever2=<?php echo $rowFileImage['id'];?> class="fa fa-info-circle"> Info</a>&nbsp;<a href="?editidf=<?php echo $rowFileImage['id']; ?>" class="fa fa-pencil"> Edit</a>
</a></span>
         
                           <?php
                 }else{
                   ?>
                   <div class="row">
                      <div class="col-md-12">
                         <h5 style="font-size: 13px;">&nbsp;&nbsp;&nbsp;&nbsp;<strong>Import Declaration Form</strong></h5>
                      </div>
                     
                    </div>
                  <a href="?addIDF=<?php echo $rowStack['stackNumber'];?>" class="fa fa-file" style="font-size:345px"></a>
                  <?php }?>
          </div>
        </div>
      </div>
      <div  class="col-md-4">
        <div class="card my-4" style="min-height: 450px;">
        
          <div class="card-body">
             <?php

                  //get file image
                  $respFileImage = $con->query("SELECT * FROM tbl_coi WHERE stackNumber='$num'");
                  if($respFileImage){
                    $rowFileImage=$respFileImage->fetch_array();
                  }

                  $dee = $rowFileImage['userId'];
                  $respUserName = $con->query("SELECT userName FROM tbl_users WHERE userID='$dee'");
                  $rowUserName=$respUserName->fetch_array();

                   if($rowStack['coi']=="Yes"){
                     $str=$rowFileImage['coiNo'];
                    $strcoi = strtoupper($str);
                    ?>
                     <div class="row">
                      <div class="col-md-6">
                         <h5 style="font-size: 13px;"><strong>COI</strong></h5>
                      </div>
                      <div class="col-md-6">
                         <h5 style="font-size: 13px;"><strong>No.<?php echo $strcoi; ?></strong></h5>
                      </div>
                    </div>
                    
                    
                    <a href="#" data-toggle="modal" data-target="#displaycoi<?php echo $x; ?>">
                    <!-- method 1 embed -->
                    <!-- <embed src="" alt="pdf" pluginspage="http://www.adobe.com/products/acrobat/readstep2.html"> -->
                    <!-- method 2 iframe -->
                    <iframe src="upload/<?php echo $rowFileImage['coi_file']; ?>" style="width:300px; height:320px;" frameborder="1"></iframe>
                    </a>
                    &nbsp;&nbsp;&nbsp;&nbsp;<span class="fa fa-user"><?php echo $rowUserName['userName'];?></span>
                   &nbsp;&nbsp;&nbsp;&nbsp;<span class="fa fa-clock-o"><?php echo $rowFileImage['postTime'];?></span>
<span class="pull-right"><a href="#" data-toggle="modal" data-target="#infoDataFilecoi" data-whatever9=<?php echo $rowFileImage['id'];?> class="fa fa-info-circle"> Info</a>&nbsp;<a href="?editcoi=<?php echo $rowFileImage['id']; ?>" class="fa fa-pencil"> Edit</a>
</a></span>
                
                            <?php
                  }else{
                    ?>
                    <div class="row">
                      <div class="col-md-12">
                         <h5 style="font-size: 13px;">&nbsp;&nbsp;&nbsp;&nbsp;<strong>Certificate of Inspection</strong></h5>
                      </div>
                     
                    </div>
                  <a href="?addCoi=<?php echo $rowStack['stackNumber'];?>" class="fa fa-file" style="font-size:345px"></a>

                  <?php }?>
          </div>
        </div>
      </div>
      </div>
      <div class="row">
        <div  class="col-md-4">
        <div class="card my-4" style="min-height: 450px;">
        
          <div class="card-body">
             <?php //get file image
                  $respFileImage = $con->query("SELECT * FROM tbl_ecert WHERE stackNumber='$num'");
                  if($respFileImage){
                    $rowFileImage=$respFileImage->fetch_array();
                  }

                  $dee = $rowFileImage['userId'];
                  $respUserName = $con->query("SELECT userName FROM tbl_users WHERE userID='$dee'");
                  $rowUserName=$respUserName->fetch_array();


                  if($rowStack['ecert']=="Yes"){
                    $str=$rowFileImage['ecertNo'];
                    $strecert = strtoupper($str);
                    ?>
                    <div class="row">
                      <div class="col-md-6">
                         <h5 style="font-size: 13px;"><strong>&nbsp;&nbsp;&nbsp;&nbsp;Export Certificate</strong></h5>
                      </div>
                      <div class="col-md-6">
                         <h5 style="font-size: 13px;"><strong>No.<?php echo $strecert; ?></strong></h5>
                      </div>
                    </div>
                    
                    
                    <a href="#" data-toggle="modal" data-target="#displayecert<?php echo $x; ?>">
                    <!-- method 1 embed -->
                    <!-- <embed src="" alt="pdf" pluginspage="http://www.adobe.com/products/acrobat/readstep2.html"> -->
                    <!-- method 2 iframe -->
                    <iframe src="upload/<?php echo $rowFileImage['ecert_file']; ?>" style="width:300px; height:320px;" frameborder="1"></iframe>
                  </a>
                  &nbsp;&nbsp;&nbsp;&nbsp;<span class="fa fa-user"><?php echo $rowUserName['userName'];?></span>
                 &nbsp;&nbsp;&nbsp;&nbsp;<span class="fa fa-clock-o"><?php echo $rowFileImage['postTime'];?></span>
<span class="pull-right"><a href="#" data-toggle="modal" data-target="#infoDataFileEcert" data-whatever4=<?php echo $rowFileImage['id'];?> class="fa fa-info-circle"> Info</a>&nbsp;<a href="?editecert=<?php echo $rowFileImage['id']; ?>" class="fa fa-pencil"> Edit</a>
</a></span>
               
                            <?php
                  }else{
                    ?>
                    <div class="row">
                      <div class="col-md-12">
                         <h5 style="font-size: 13px;">&nbsp;&nbsp;&nbsp;&nbsp;<strong>Export Certificate</strong></h5>
                      </div>
                     
                    </div>
                  <a href="?addECert=<?php echo $rowStack['stackNumber'];?>" class="fa fa-file" style="font-size:345px"></a>
                  <?php }?>
          </div>
        </div>
      </div>
      <div  class="col-md-4">
        <div class="card my-4" style="min-height: 450px;">
        
          <div class="card-body">
             <?php
                  //get file image
                  $respFileImage = $con->query("SELECT * FROM tbl_treciept WHERE stackNumber='$num'");
                  if($respFileImage){
                    $rowFileImage=$respFileImage->fetch_array();
                  }

                  $dee = $rowFileImage['userId'];
                  $respUserName = $con->query("SELECT userName FROM tbl_users WHERE userID='$dee'");
                  $rowUserName=$respUserName->fetch_array();

                   if($rowStack['treciept']=="Yes"){
                    $str=$rowFileImage['trecieptNo'];
                    $strtreciept = strtoupper($str);
                    ?>
                     <div class="row">
                      <div class="col-md-6">
                         <h5 style="font-size: 13px;"><strong>KRA Slip</strong></h5>
                      </div>
                      <div class="col-md-6">
                         <h5 style="font-size: 13px;"><strong>No.<?php echo $strtreciept; ?></strong></h5>
                      </div>
                    </div>
                     
                   
                    <a href="#" data-toggle="modal" data-target="#displaytreciept<?php echo $x; ?>">
                    <!-- method 1 embed -->
                    <!-- <embed src="" alt="pdf" pluginspage="http://www.adobe.com/products/acrobat/readstep2.html"> -->
                    <!-- method 2 iframe -->
                    <iframe src="upload/<?php echo $rowFileImage['treciept_file']; ?>" style="width:300px; height:320px;" frameborder="1"></iframe>
                  </a>
                  &nbsp;&nbsp;&nbsp;&nbsp;<span class="fa fa-user"><?php echo $rowUserName['userName'];?></span>
                  &nbsp;&nbsp;&nbsp;&nbsp;<span class="fa fa-clock-o"><?php echo $rowFileImage['postTime'];?></span>
<span class="pull-right"><a href="#" data-toggle="modal" data-target="#infoDataFileKra" data-whatever6=<?php echo $rowFileImage['id'];?> class="fa fa-info-circle"> Info</a>&nbsp;<a href="?edittreciept=<?php echo $rowFileImage['id']; ?>" class="fa fa-pencil"> Edit</a></span>
             
                            <?php
                  }else{
                    ?>
                    <div class="row">
                      <div class="col-md-12">
                         <h5 style="font-size: 13px;">&nbsp;&nbsp;&nbsp;&nbsp;<strong>KRA Bank Slip</strong></h5>
                      </div>
                     
                    </div>
                  <a href="?addTReciept=<?php echo $rowStack['stackNumber'];?>" class="fa fa-file" style="font-size:345px"></a>
                  <?php }?>
          </div>
        </div>
      </div>
      <div  class="col-md-4">
        <div class="card my-4" style="min-height: 450px;">
        
          <div class="card-body">
             <?php

                  //get file image
                  $respFileImage = $con->query("SELECT * FROM tbl_lbook WHERE stackNumber='$num'");
                  if($respFileImage){
                    $rowFileImage=$respFileImage->fetch_array();
                  }

                  $dee = $rowFileImage['userId'];
                  $respUserName = $con->query("SELECT userName FROM tbl_users WHERE userID='$dee'");
                  $rowUserName=$respUserName->fetch_array();

                   if($rowStack['lbook']=="Yes"){
                    $str=$rowFileImage['lbookNo'];
                    $strlbook = strtoupper($str);
                    ?>
                     <div class="row">
                      <div class="col-md-6">
                         <h5 style="font-size: 13px;"><strong>&nbsp;&nbsp;&nbsp;&nbsp;Log Book</strong></h5>
                      </div>
                      <div class="col-md-6">
                         <h5 style="font-size: 13px;"><strong>No.<?php echo $strlbook; ?></strong></h5>
                      </div>
                    </div>
                    
                   
                    <a href="#" data-toggle="modal" data-target="#displaylbook<?php echo $x; ?>">
                    <!-- method 1 embed -->
                    <!-- <embed src="" alt="pdf" pluginspage="http://www.adobe.com/products/acrobat/readstep2.html"> -->
                    <!-- method 2 iframe -->
                    <iframe src="upload/<?php echo $rowFileImage['lbook_file']; ?>" style="width:300px; height:320px;" frameborder="1"></iframe>
                    </a>
                    &nbsp;&nbsp;&nbsp;&nbsp;<span class="fa fa-user"><?php echo $rowUserName['userName'];?></span>
                    &nbsp;&nbsp;&nbsp;&nbsp;<span class="fa fa-clock-o"><?php echo $rowFileImage['postTime'];?></span>
<span class="pull-right"><a href="#" data-toggle="modal" data-target="#infoDataFileLbook" data-whatever8=<?php echo $rowFileImage['id'];?> class="fa fa-info-circle"> Info</a>&nbsp;<a href="?editlbook=<?php echo $rowFileImage['id']; ?>" class="fa fa-pencil"> Edit</a></span>
     
                            <?php
                  }else{
                    ?>
                    <div class="row">
                      <div class="col-md-12">
                         <h5 style="font-size: 13px;">&nbsp;&nbsp;&nbsp;&nbsp;<strong>Log Book</strong></h5>
                      </div>
                     
                    </div>
                  <a href="?addLBook=<?php echo $rowStack['stackNumber'];?>" class="fa fa-file" style="font-size:345px"></a>

                  <?php }?>
          </div>
        </div>
        </div>
      </div>
      </div>
    </div>
      </div>
      </div>
      </div>
     
    <!-- /.row -->
<?php
}
}
?>
     <!-- search by atribute functionality client-->
<div class="modal fade" id="findClient" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
         <div class="modal-dialog" role="document">
             <div class="modal-content">
                 <div class="modal-header">
                   <h4><span class="fa fa-search fw"> Find Client</span></h4>
                 </div>
                 <div class="modal-body section">
                   <div class="">
                   <form action="" class="">
                   <div class="form-group input-group">
                           <input type="text" class="form-control" id="forms" onkeyup="mySearchClient()" placeholder="Search for a client..">
                           <span class="input-group-btn">
                               <button class="btn btn-default btn-info" type="button"><i class="fa fa-search"></i>
                               </button>
                           </span>
                       </div>
                   </form>

                   <table id="formsTable" class="table table-hover table-condensed" style="table-layout: fixed;">
                   <thead>
                    <tr>
                      <th style="width:75%;">Client</th>
                      <th style="width:75%;">File No.</th>
                      <th style="width:25%;">Action</th>
                    </tr>
                   </thead>
                   <tbody>
                    <?php
                    $respSearchForm1 = $con->query("SELECT * FROM tbl_stacks ORDER BY id DESC");
                    while($rowSearchForm1=$respSearchForm1->fetch_array()){
                      $joinIdSearchForm1 = $rowSearchForm1['id'];
                    ?>
                        <td><?php echo $rowSearchForm1['fileOwner']; ?></td>
                        <td><?php echo $rowSearchForm1['stackNumber']; ?></td>
                        <td><a href="?view=<?php echo $rowSearchForm1['stackNumber']?>" class="btn btn-info">View</a></td>

                      </tr>
                    <?php  } ?>
                    <tbody>
                   </table>
                 </div>
                 </div>
                 <div class="modal-footer">
                   <div class="form-group" >
                     <button type="button" class="btn btn-lg btn-default" data-dismiss="modal">Close</button>
                   </div>
                   </form>
                 </div>
            </div>
        </div>
        </div>
<!-- search by atribute functionality file-->
<div class="modal fade" id="findFile" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
         <div class="modal-dialog" role="document">
             <div class="modal-content">
                 <div class="modal-header">
                   <h4><span class="fa fa-search fw"> Find File</span></h4>
                 </div>
                 <div class="modal-body section">
                   <div class="">
                   <form action="" class="">
                   <div class="form-group input-group">
                           <input type="text" class="form-control" id="forms" onkeyup="mySearchFile()" placeholder="Search for a file..">
                           <span class="input-group-btn">
                               <button class="btn btn-default btn-info" type="button"><i class="fa fa-search"></i>
                               </button>
                           </span>
                       </div>
                   </form>

                   <table id="formsTable" class="table table-hover table-condensed" style="table-layout: fixed;">
                   <thead>
                    <tr>
                      <th style="width:75%;">Stack Number</th>
                      <th style="width:25%;">Action</th>
                    </tr>
                   </thead>
                   <tbody>
                    <?php
                    $respSearchForm1 = $con->query("SELECT * FROM tbl_stacks ORDER BY id DESC");
                    while($rowSearchForm1=$respSearchForm1->fetch_array()){
                      $joinIdSearchForm1 = $rowSearchForm1['id'];
                    ?>
                        <td><?php echo $rowSearchForm1['stackNumber']; ?></td>
                        <td><a href="?view=<?php echo $rowSearchForm1['stackNumber']?>" class="btn btn-info">View</a></td>

                      </tr>
                    <?php  } ?>
                    <tbody>
                   </table>
                 </div>
                 </div>
                 <div class="modal-footer">
                   <div class="form-group" >
                     <button type="button" class="btn btn-lg btn-default" data-dismiss="modal">Close</button>
                   </div>
                   </form>
                 </div>
            </div>
        </div>
        </div>

        <!-- search by atribute functionality-->
        <div class="modal fade" id="newStack" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                 <div class="modal-dialog" role="document">
                     <div class="modal-content">
                         <div class="modal-header">
                           <h4><span class="fa fa-folder-open fw"> Create New File</span></h4>
                         </div>
                         <div class="modal-body section">
                           <form method="post">
                           <div class="form-group">
                                 <label for="cost">File Type</label>
                                <select class="form-control" type="text" name="stackType" placeholder="Type of cost" required>
                                   <option value="Container">Container</option>
                                   <option value="Vehicle">Vehicle</option>
                                </select>
                             </div>
                             <div class="form-group">
                                 <label for="stackNumber">File Number</label>
                                 <input id="zipca" type="text" name="stackNumber" placeholder="XXX/XXX/XXX/XXXX" pattern="\w\w\w/\d\d\d/\w\w\w/\d\d\d\d" class="masked form-control" data-charset="___/XXX/___/XXXX" title="format of AAA/111/AAA/1111 e.g PAL/023/JUN/2019" style="text-transform: uppercase;">
                                 <div class="row">
                                   <div class="col-md-6">
                                   <label for="OwnnerName">Client's First Name</label>
                                  <input type="text" placeholder="First Name" name="ownerNameOne" class="form-control" onkeypress="return (event.charCode > 64 && 
event.charCode < 91) || (event.charCode > 96 && event.charCode < 123)"  autofocus required/>   
                                   </div>
                                   <div class="col-md-6">
                                    <label for="OwnnerName">Client's Second Name</label>
                                    <input type="text" placeholder="Second Name" name="ownerNameTwo" class="form-control" onkeypress="return (event.charCode > 64 && 
event.charCode < 91) || (event.charCode > 96 && event.charCode < 123)"  autofocus required/>  
                                   </div>
                                 </div>
                                 <div class="row">
                                   <div class="col-md-6">
                          <label for="OwnnerName">Client's Phone Number</label>
                                   <input type="text" name="ownerNumber" placeholder="File Owner Number" class="form-control" onkeypress="return (event.charCode > 48 && 
event.charCode < 57) || (event.charCode== 43)" autofocus required/>           
                                   </div>
                                   <div class="col-md-6">
                          <label for="OwnnerEmail">Client's Email Adress</label>
                                   <input type="email" name="ownerEmail" placeholder="File Owner Email" class="form-control"  autofocus required/>           
                                   </div>
                                 </div>
                              
                             </div>

                               <button class="btn btn-primary btn-outline" type="submit" name="btn-add-stack"> Create</button>
                             </form>
                         </div>
                         <div class="modal-footer">
                           <div class="form-group" >
                             <button type="button" class="btn btn-lg btn-default" data-dismiss="modal">Cancel</button>
                           </div>
                         </div>
                          </form>
                    </div>
                </div>
                </div>   

</body>
 <!-- search by atribute functionality-->
        <div class="modal fade" id="newStack" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                 <div class="modal-dialog" role="document">
                     <div class="modal-content">
                         <div class="modal-header">
                           <h4><span class="fa fa-folder-open fw"> Create New File</span></h4>
                         </div>
                         <div class="modal-body section">
                           <form method="post">
                           <div class="form-group">
                                 <label for="cost">File Type</label>
                                <select class="form-control" type="text" name="stackType" placeholder="Type of cost" required>
                                   <option value="Container">Container</option>
                                   <option value="Vehicle">Vehicle</option>
                                </select>
                             </div>
                             <div class="form-group">
                                 <label for="stackNumber">File Number</label>
                                 <input id="zipca" type="text" name="stackNumber" placeholder="XXX/XXX/XXX/XXXX" pattern="\w\w\w/\d\d\d/\w\w\w/\d\d\d\d" class="masked form-control" data-charset="___/XXX/___/XXXX" title="format of AAA/111/AAA/1111 e.g PAL/023/JUN/2019" style="text-transform: uppercase;">
                                 <div class="row">
                                   <div class="col-md-6">
                                   <label for="OwnnerName">Client's First Name</label>
                                  <input type="text" placeholder="First Name" name="ownerNameOne" class="form-control" onkeypress="return (event.charCode > 64 && 
event.charCode < 91) || (event.charCode > 96 && event.charCode < 123)"  autofocus required/>   
                                   </div>
                                   <div class="col-md-6">
                                    <label for="OwnnerName">Client's Second Name</label>
                                    <input type="text" placeholder="Second Name" name="ownerNameTwo" class="form-control" onkeypress="return (event.charCode > 64 && 
event.charCode < 91) || (event.charCode > 96 && event.charCode < 123)"  autofocus required/>  
                                   </div>
                                 </div>
                                 <div class="row">
                                   <div class="col-md-6">
                          <label for="OwnnerName">Client's Phone Number</label>
                                   <input type="text" name="ownerNumber" placeholder="File Owner Number" class="form-control" onkeypress="return (event.charCode > 48 && 
event.charCode < 57) || (event.charCode== 43)" autofocus required/>           
                                   </div>
                                   <div class="col-md-6">
                          <label for="OwnnerEmail">Client's Email Adress</label>
                                   <input type="email" name="ownerEmail" placeholder="File Owner Email" class="form-control"  autofocus required/>           
                                   </div>
                                 </div>
                              
                             </div>

                               <button class="btn btn-primary btn-outline" type="submit" name="btn-add-stack"> Create</button>
                             </form>
                         </div>
                         <div class="modal-footer">
                           <div class="form-group" >
                             <button type="button" class="btn btn-lg btn-default" data-dismiss="modal">Cancel</button>
                           </div>
                         </div>
                          </form>
                    </div>
                </div>
                </div>
                 <!-- modal statck costs-->
 <div class="modal fade" id="infoDataFileCosts" tabindex="-1" role="dialog1" aria-labelledby="memberModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
             <h4 class="modal-title" id="memberModalLabel"><center>Save Costs</center></h4>
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            </div>
            <div class="infoDisplayCosts">
               
            </div>

        </div>
    </div>
</div>
 <!-- modal view statck costs-->
 <div class="modal fade" id="infoDataFileCostsView" tabindex="-1" role="dialog1" aria-labelledby="memberModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h4 class="modal-title" id="memberModalLabel"><center>View Costs</center></h4>
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            </div>
            <div class="infoDisplayCostsView">
               
            </div>

        </div>
    </div>
</div>
<!-- modal view statck costs-->
 <div class="modal fade" id="infoDataFileMergeView" tabindex="-1" role="dialog1" aria-labelledby="memberModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h4 class="modal-title" id="memberModalLabel"><center>Merged Files</center></h4>
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            </div>
            <div class="infoDisplayMergedView">
               
            </div>

        </div>
    </div>
</div>
                <!-- modal Bol-->
 <div class="modal fade" id="infoDataFileBol" tabindex="-1" role="dialog1" aria-labelledby="memberModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="memberModalLabel">File Process Details for Bill of Lading</h4>
            </div>
            <div class="infoDisplayBol">

            </div>

        </div>
    </div>
</div>
 <!-- modal Idf-->
 <div class="modal fade" id="infoDataFileIdf" tabindex="-1" role="dialog1" aria-labelledby="memberModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="memberModalLabel">File Process Details for Import Declaration Form</h4>
            </div>
            <div class="infoDisplayIdf">

            </div>

        </div>
    </div>
</div>
 <!-- modal KBS-->
 <div class="modal fade" id="infoDataFileKbs" tabindex="-1" role="dialog1" aria-labelledby="memberModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="memberModalLabel">File Process Details for Kenya Bureau of Standards</h4>
            </div>
            <div class="infoDisplayKbs">

            </div>

        </div>
    </div>
</div>
<!-- modal Ecert-->
 <div class="modal fade" id="infoDataFileEcert" tabindex="-1" role="dialog1" aria-labelledby="memberModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="memberModalLabel">File Process Details for Export Certificate</h4>
            </div>
            <div class="infoDisplayEcert">

            </div>

        </div>
    </div>
</div>
<!-- modal Invoice-->
 <div class="modal fade" id="infoDataFileInvoice" tabindex="-1" role="dialog1" aria-labelledby="memberModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="memberModalLabel">File Process Details for Invoice Form</h4>
            </div>
            <div class="infoDisplayInvoice">

            </div>

        </div>
    </div>
</div>
<!-- modal KRA-->
 <div class="modal fade" id="infoDataFileKra" tabindex="-1" role="dialog1" aria-labelledby="memberModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="memberModalLabel">File Process Details for Kenya Revenue Authority</h4>
            </div>
            <div class="infoDisplayKra">

            </div>

        </div>
    </div>
</div>
<!-- modal Quadruplicate-->
 <div class="modal fade" id="infoDataFileQuadruplicate" tabindex="-1" role="dialog1" aria-labelledby="memberModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="memberModalLabel">File Process Details for Quadruplicate</h4>
            </div>
            <div class="infoDisplayQuadruplicate">

            </div>

        </div>
    </div>
</div>
<!-- modal Lbook-->
 <div class="modal fade" id="infoDataFileLbook" tabindex="-1" role="dialog1" aria-labelledby="memberModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="memberModalLabel">File Process Details for Log Book</h4>
            </div>
            <div class="infoDisplayLbook">

            </div>

        </div>
    </div>
</div>
<!-- modal COC-->
 <div class="modal fade" id="infoDataFileCoc" tabindex="-1" role="dialog1" aria-labelledby="memberModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="memberModalLabel">File Process Details for Certificate of Conformity</h4>
            </div>
            <div class="infoDisplayCoc">

            </div>

        </div>
    </div>
</div>
 <script type="text/javascript">
      
    $('#infoDataFileCosts').on('show.bs.modal', function (event) {
          var button = $(event.relatedTarget) // Button that triggered the modal17
          var recipient = button.data('whatever10') // Extract info from data-* attributes
          
          var modal10 = $(this);
          var dataString10 = 'id=' + recipient;
       
            $.ajax({
                type: "GET",
                url: "infoDataCosts.php",
                data: dataString10,
                cache: false,
                beforeSend: function (data) {
                    console.log('Retrieving Data....');
                },
                success: function (data) {
                    console.log(data);
                    modal10.find('.infoDisplayCosts').html(data);
                },
                error: function(err) {
                    console.log(err);
                }
            });

    })
</script>
<script type="text/javascript">
      
    $('#infoDataFileMergeView').on('show.bs.modal', function (event) {
          var button = $(event.relatedTarget) // Button that triggered the modal17
          var recipient = button.data('whatever11') // Extract info from data-* attributes
          
          var modal11 = $(this);
          var dataString11 = 'id=' + recipient;
       
            $.ajax({
                type: "GET",
                url: "infoDataMergedView.php",
                data: dataString11,
                cache: false,
                beforeSend: function (data) {
                    console.log('Retrieving Data....');
                },
                success: function (data) {
                    console.log(data);
                    modal11.find('.infoDisplayMergedView').html(data);
                },
                error: function(err) {
                    console.log(err);
                }
            });

    })
</script>
<script type="text/javascript">
      
    $('#infoDataFileCostsView').on('show.bs.modal', function (event) {
          var button = $(event.relatedTarget) // Button that triggered the modal17
          var recipient = button.data('whatever11') // Extract info from data-* attributes
          
          var modal11 = $(this);
          var dataString11 = 'id=' + recipient;
       
            $.ajax({
                type: "GET",
                url: "infoDataCostsView.php",
                data: dataString11,
                cache: false,
                beforeSend: function (data) {
                    console.log('Retrieving Data....');
                },
                success: function (data) {
                    console.log(data);
                    modal11.find('.infoDisplayCostsView').html(data);
                },
                error: function(err) {
                    console.log(err);
                }
            });

    })
</script>

    <script type="text/javascript">
      
    $('#infoDataFileBol').on('show.bs.modal', function (event) {
          var button = $(event.relatedTarget) // Button that triggered the modal17
          var recipient = button.data('whatever1') // Extract info from data-* attributes
          
          var modal1 = $(this);
          var dataString1 = 'id=' + recipient;
          var dataString2 = 'idd=' + "2";
       
            $.ajax({
                type: "GET",
                url: "infoDataBol.php",
                data: dataString1,
                cache: false,
                beforeSend: function (data) {
                    console.log('Retrieving Data....');
                },
                success: function (data) {
                    console.log(data);
                    modal1.find('.infoDisplayBol').html(data);
                },
                error: function(err) {
                    console.log(err);
                }
            });

    })
</script>
    <script type="text/javascript">
      
    $('#infoDataFileIdf').on('show.bs.modal', function (event) {
          var button = $(event.relatedTarget) // Button that triggered the modal17
          var recipient = button.data('whatever2') // Extract info from data-* attributes
          
          var modal2 = $(this);
          var dataString2 = 'id=' + recipient;
          var dataString3 = 'idd=' + "2";
       
            $.ajax({
                type: "GET",
                url: "infoDataIdf.php",
                data: dataString2,
                cache: false,
                beforeSend: function (data) {
                    console.log('Retrieving Data....');
                },
                success: function (data) {
                    console.log(data);
                    modal2.find('.infoDisplayIdf').html(data);
                },
                error: function(err) {
                    console.log(err);
                }
            });

    })
</script>
    <script type="text/javascript">
      
    $('#infoDataFileKbs').on('show.bs.modal', function (event) {
          var button = $(event.relatedTarget) // Button that triggered the modal17
          var recipient = button.data('whatever3') // Extract info from data-* attributes
          
          var modal3 = $(this);
          var dataString3 = 'id=' + recipient;
          var dataString2 = 'idd=' + "2";
       
            $.ajax({
                type: "GET",
                url: "infoDataKbs.php",
                data: dataString3,
                cache: false,
                beforeSend: function (data) {
                    console.log('Retrieving Data....');
                },
                success: function (data) {
                    console.log(data);
                    modal3.find('.infoDisplayKbs').html(data);
                },
                error: function(err) {
                    console.log(err);
                }
            });

    })
</script>
    <script type="text/javascript">
      
    $('#infoDataFileEcert').on('show.bs.modal', function (event) {
          var button = $(event.relatedTarget) // Button that triggered the modal17
          var recipient = button.data('whatever4') // Extract info from data-* attributes
          
          var modal4 = $(this);
          var dataString4 = 'id=' + recipient;
          var dataString2 = 'idd=' + "2";
       
            $.ajax({
                type: "GET",
                url: "infoDataEcert.php",
                data: dataString4,
                cache: false,
                beforeSend: function (data) {
                    console.log('Retrieving Data....');
                },
                success: function (data) {
                    console.log(data);
                    modal4.find('.infoDisplayEcert').html(data);
                },
                error: function(err) {
                    console.log(err);
                }
            });

    })
</script>
    <script type="text/javascript">
      
    $('#infoDataFileInvoice').on('show.bs.modal', function (event) {
          var button = $(event.relatedTarget) // Button that triggered the modal17
          var recipient = button.data('whatever5') // Extract info from data-* attributes
          
          var modal5 = $(this);
          var dataString5 = 'id=' + recipient;
          var dataString2 = 'idd=' + "2";
       
            $.ajax({
                type: "GET",
                url: "infoDataInvoice.php",
                data: dataString5,
                cache: false,
                beforeSend: function (data) {
                    console.log('Retrieving Data....');
                },
                success: function (data) {
                    console.log(data);
                    modal5.find('.infoDisplayInvoice').html(data);
                },
                error: function(err) {
                    console.log(err);
                }
            });

    })
</script>
    <script type="text/javascript">
      
    $('#infoDataFileKra').on('show.bs.modal', function (event) {
          var button = $(event.relatedTarget) // Button that triggered the modal17
          var recipient = button.data('whatever6') // Extract info from data-* attributes
          
          var modal6 = $(this);
          var dataString6 = 'id=' + recipient;
          var dataString2 = 'idd=' + "2";
       
            $.ajax({
                type: "GET",
                url: "infoDataKra.php",
                data: dataString6,
                cache: false,
                beforeSend: function (data) {
                    console.log('Retrieving Data....');
                },
                success: function (data) {
                    console.log(data);
                    modal6.find('.infoDisplayKra').html(data);
                },
                error: function(err) {
                    console.log(err);
                }
            });

    })
</script>
    <script type="text/javascript">
      
    $('#infoDataFileQuadruplicate').on('show.bs.modal', function (event) {
          var button = $(event.relatedTarget) // Button that triggered the modal17
          var recipient = button.data('whatever7') // Extract info from data-* attributes
          
          var modal7 = $(this);
          var dataString7 = 'id=' + recipient;
          var dataString2 = 'idd=' + "2";
       
            $.ajax({
                type: "GET",
                url: "infoDataQuadruplicate.php",
                data: dataString7,
                cache: false,
                beforeSend: function (data) {
                    console.log('Retrieving Data....');
                },
                success: function (data) {
                    console.log(data);
                    modal7.find('.infoDisplayQuadruplicate').html(data);
                },
                error: function(err) {
                    console.log(err);
                }
            });

    })
</script>
    <script type="text/javascript">
      
    $('#infoDataFileLbook').on('show.bs.modal', function (event) {
          var button = $(event.relatedTarget) // Button that triggered the modal17
          var recipient = button.data('whatever8') // Extract info from data-* attributes
          
          var modal8 = $(this);
          var dataString8 = 'id=' + recipient;
          var dataString2 = 'idd=' + "2";
       
            $.ajax({
                type: "GET",
                url: "infoDataLbook.php",
                data: dataString8,
                cache: false,
                beforeSend: function (data) {
                    console.log('Retrieving Data....');
                },
                success: function (data) {
                    console.log(data);
                    modal8.find('.infoDisplayLbook').html(data);
                },
                error: function(err) {
                    console.log(err);
                }
            });

    })
</script>
    <script type="text/javascript">
      
    $('#infoDataFileCoc').on('show.bs.modal', function (event) {
          var button = $(event.relatedTarget) // Button that triggered the modal17
          var recipient = button.data('whatever9') // Extract info from data-* attributes
          
          var modal9 = $(this);
          var dataString9 = 'id=' + recipient;
          var dataString2 = 'idd=' + "2";
       
            $.ajax({
                type: "GET",
                url: "infoDataCoc.php",
                data: dataString9,
                cache: false,
                beforeSend: function (data) {
                    console.log('Retrieving Data....');
                },
                success: function (data) {
                    console.log(data);
                    modal9.find('.infoDisplayCoc').html(data);
                },
                error: function(err) {
                    console.log(err);
                }
            });

    })
</script>
    <script>
    function mySearchClient() {

      // Declare variables
      var input, filter, table, tr, td, i;
      input = document.getElementById("forms");
      filter = input.value.toUpperCase();
      table = document.getElementById("formsTable");
      tr = table.getElementsByTagName("tr");
      // Loop through all table rows, and hide those who don't match the search query
      for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[0];
        if (td) {
          if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
            tr[i].style.display = "";
          } else {
            tr[i].style.display = "none";
          }
        }
      }
    }
    </script>
    <script>
    function mySearchClient() {

      // Declare variables
      var input, filter, table, tr, td, i;
      input = document.getElementById("forms");
      filter = input.value.toUpperCase();
      table = document.getElementById("formsTable");
      tr = table.getElementsByTagName("tr");
      // Loop through all table rows, and hide those who don't match the search query
      for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[0];
        if (td) {
          if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
            tr[i].style.display = "";
          } else {
            tr[i].style.display = "none";
          }
        }
      }
    }
    </script>
    <script>
    function mySearchFile() {

      // Declare variables
      var input, filter, table, tr, td, i;
      input = document.getElementById("forms");
      filter = input.value.toUpperCase();
      table = document.getElementById("formsTable");
      tr = table.getElementsByTagName("tr");
      // Loop through all table rows, and hide those who don't match the search query
      for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[0];
        if (td) {
          if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
            tr[i].style.display = "";
          } else {
            tr[i].style.display = "none";
          }
        }
      }
    }
    </script>
<!-- Bootstrap Core JavaScript -->
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="dist/js/sb-admin-2.js"></script>

<script src="js/lightbox-plus-jquery.min.js"></script>
<script src="js/masking-input.js" data-autoinit="true"></script>


  <!-- Footer -->
  <footer class="py-5 bg-dark">
    <div class="container">
      <p class="m-0 text-center text-white">Copyright &copy; Palm Freighters Limited 2019</p>
    </div>
    <!-- /.container -->
  </footer>

  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
   <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js'></script>

    <!-- <script src="js/index.js"></script> -->


</body>

</html>
