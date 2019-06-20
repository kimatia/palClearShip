<?php
session_start();
//db connection
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

if(isset($_POST['btn-add-stack'])){

 $sNumber = $_POST['stackNumber'];

 $SQL = $con->prepare("INSERT INTO tbl_stacks(stackNumber, postDate) VALUES(?,now())");
 if(!$SQL){
  echo $con->error;
  $msgCreateStack = "<div class='alert alert-danger'>
    <button class='close' data-dismiss='alert'>&times;</button>
     <strong>Sorry!</strong>  Post failed.
     </div>
     ";
  header("refresh:5;adhome.php");
}else{

  $SQL->bind_param('s',$sNumber);
  $SQL->execute();
  header("location: adhome.php");
  $msgCreateStack = "<div class='alert alert-success'>
    <button class='close' data-dismiss='alert'>&times;</button>
     <strong>Success !</strong>  Post success.
     </div>
     ";
 }
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

if (isset($_GET['addLBook'])){
  $_SESSION['stackNumber'] = $_GET['addLBook'];
  $_SESSION['file'] = "LBook";
  header("location: addFile.php");
}

if (isset($_SESSION["errMssg"])){
  $mssg = "<div class='alert alert-danger'>
          <button class='close' data-dismiss='alert'>&times;</button>
          <strong>Sorry!</strong>Bill of lading form reqired first to proceed to the next
           </div>";
}



$BOL = "bol";
$IDF = "idf";
$KBS = "kbs";
$ECert = "ecert";
$Invoice = "invoice";
$TReciept = "treciept";
$Quadruplicate = "quadruplicate";
$LBook = "lbook";
$Coc="coc";
$Coi="coi";
$Pkl="pkl";
$Entry="Entry";
if (isset($_SESSION['editfile'])){
if ($_SESSION['editfile']==$BOL){
  $file = $_SESSION['editfile'];
  $y = $_SESSION['editbol'];
  $respFile = $con->query("SELECT * FROM tbl_billoflading WHERE id='$y'");
  $rowFile=$respFile->fetch_array();

}else if ($_SESSION['editfile']==$IDF){
  $file = $_SESSION['editfile'];

  $y = $_SESSION['editidf'];
  $respFile = $con->query("SELECT * FROM tbl_idf WHERE id='$y'");
  $rowFile=$respFile->fetch_array();

}else if ($_SESSION['editfile']==$KBS){
  $file = $_SESSION['editfile'];

  $y = $_SESSION['editkbs'];
  $respFile = $con->query("SELECT * FROM tbl_kbs WHERE id='$y'");
  $rowFile=$respFile->fetch_array();

}else if ($_SESSION['editfile']==$ECert){
  $file = $_SESSION['editfile'];

  $y = $_SESSION['editecert'];
  $respFile = $con->query("SELECT * FROM tbl_ecert WHERE id='$y'");
  $rowFile=$respFile->fetch_array();

}else if ($_SESSION['editfile']==$Invoice){
  $file = $_SESSION['editfile'];

  $y = $_SESSION['editinvoice'];
  $respFile = $con->query("SELECT * FROM tbl_invoice WHERE id='$y'");
  $rowFile=$respFile->fetch_array();

}else if ($_SESSION['editfile']==$TReciept){
  $file = $_SESSION['editfile'];

  $y = $_SESSION['edittreciept'];
  $respFile = $con->query("SELECT * FROM tbl_treciept WHERE id='$y'");
  $rowFile=$respFile->fetch_array();

}else if ($_SESSION['editfile']==$Quadruplicate){
  $file = $_SESSION['editfile'];

  $y = $_SESSION['editquadruplicate'];
  $respFile = $con->query("SELECT * FROM tbl_quadruplicate WHERE id='$y'");
  $rowFile=$respFile->fetch_array();

}else if ($_SESSION['editfile']==$LBook){
  $file = $_SESSION['editfile'];

  $y = $_SESSION['editlbook'];
  $respFile = $con->query("SELECT * FROM tbl_lbook WHERE id='$y'");
  $rowFile=$respFile->fetch_array();
}else if ($_SESSION['editfile']==$Coc){
  $file = $_SESSION['editfile'];

  $y = $_SESSION['editcoc'];
  $respFile = $con->query("SELECT * FROM tbl_coc WHERE id='$y'");
  $rowFile=$respFile->fetch_array();
}else if ($_SESSION['editfile']==$Coi){
  $file = $_SESSION['editfile'];

  $y = $_SESSION['editcoi'];
  $respFile = $con->query("SELECT * FROM tbl_coi WHERE id='$y'");
  $rowFile=$respFile->fetch_array();
}else if ($_SESSION['editfile']==$Pkl){
  $file = $_SESSION['editfile'];

  $y = $_SESSION['editpkl'];
  $respFile = $con->query("SELECT * FROM tbl_pkl WHERE id='$y'");
  $rowFile=$respFile->fetch_array();
}
else if ($_SESSION['editfile']==$Entry){
  $file = $_SESSION['editfile'];

  $y = $_SESSION['editentry'];
  $respFile = $con->query("SELECT * FROM tbl_entry WHERE id='$y'");
  $rowFile=$respFile->fetch_array();
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

  <!-- Page Content -->
    <div class="row" style="margin-top: 80px;">
      <div class="container">
      <div class="card">
       <div class="col-md-12">
        <div class="panel panel-default">
          <div class="panel panel-body">
           <span><?php echo $_SESSION['editfile'];?><i class="pull-right tab"><?php echo $rowFile['stackNumber'];  ?></i></span>
           <hr>
           <?php
           $BOL = "bol";
           $IDF = "idf";
           $KBS = "kbs";
           $ECert = "ecert";
           $Invoice = "invoice";
           $TReciept = "treciept";
           $Quadruplicate = "quadruplicate";
           $LBook = "lbook";
           $Coc="coc";

           if($_SESSION['editfile']==$BOL){
            ?>
            <?php if (isset($mssg)){ echo $mssg; }?>
            <script>
            $(function () {
                $('#btn').click(function () {
                    $('.myprogress').css('width', '0');
                    $('.msg').text('');
                    var filename = $('#filename').val();
                    var myfile = $('#myfile').val();
                    var shippername = $('#shippername').val();
                    var shipperadress = $('#shipperadress').val();
                    var shipperlocation = $('#shipperlocation').val();
                    var consigneename = $('#consigneename').val();
                    var consigneeadress = $('#consigneeadress').val();
                    var consigneelocation = $('#consigneelocation').val();
                    var precariageBy = $('#precariageBy').val();
                    var placeofReciept = $('#placeofReciept').val();
                    var vessel = $('#vessel').val();
                    var voyno = $('#voyno').val();
                    var loadingport = $('#loadingport').val();
                    var dischargeport = $('#dischargeport').val();
                    var finalDestination = $('#finalDestination').val();
                    var freightName = $('#freightName').val();
                    var revenueTons = $('#revenueTons').val();
                    var rate = $('#rate').val();
                    var per = $('#per').val();
                    var prepaid = $('#prepaid').val();
                    var collect = $('#collect').val();
                    var markNumber = $('#markNumber').val();
                    var description = $('#description').val();
                    var grossweight = $('#grossweight').val();
                    var measurement = $('#measurement').val();
                    var packagesNo = $('#packagesNo').val();
                    var freightPayable = $('#freightPayable').val();
                    var numberOriginal = $('#numberOriginal').val();
                    var placeOfIssue = $('#placeOfIssue').val();
                    var dateOfIssue = $('#dateOfIssue').val();
                    var userId = $('#userId').val();
                    var file = $('#file').val();
                    var billofLadingNumber = $('#billofLadingNumber').val();
                    var stackNumber = $('#stackNumber').val();
                    var userId = $('#userId').val();
                    if (billofLadingNumber == '' || myfile == '') {
                        alert('Please select file');
                        return;
                    }
                    var formData = new FormData();
                    formData.append('myfile', $('#myfile')[0].files[0]);
                    formData.append('filename', filename);
                    formData.append('shippername', shippername);
                    formData.append('shipperadress', shipperadress);
                    formData.append('shipperlocation', shipperlocation);
                    formData.append('consigneename', consigneename);
                    formData.append('consigneeadress', consigneeadress);
                    formData.append('consigneelocation', consigneelocation);
                    formData.append('precariageBy', precariageBy);
                    formData.append('placeofReciept', placeofReciept);
                    formData.append('vessel', vessel);
                    formData.append('voyno', voyno);
                    formData.append('loadingport', loadingport);
                    formData.append('dischargeport', dischargeport);
                    formData.append('finalDestination', finalDestination);
                    formData.append('freightName', freightName);
                    formData.append('revenueTons', revenueTons);
                    formData.append('rate', rate);
                    formData.append('per', per);
                    formData.append('prepaid', prepaid);
                    formData.append('collect', collect);
                    formData.append('markNumber', markNumber);
                    formData.append('description', description);
                    formData.append('grossweight', grossweight);
                    formData.append('measurement', measurement);
                    formData.append('packagesNo', packagesNo);
                    formData.append('freightPayable', freightPayable);
                    formData.append('numberOriginal', numberOriginal);
                    formData.append('placeOfIssue', placeOfIssue);
                    formData.append('dateOfIssue', dateOfIssue);
                    formData.append('userId', userId);
                    formData.append('file', file);
                    formData.append('billofLadingNumber', billofLadingNumber);
                    formData.append('stackNumber', stackNumber);
                    formData.append('userId', userId);
                    $('#btn').attr('disabled', 'disabled');
                     $('.msg').text('Uploading in progress...');
                    $.ajax({
                        url: 'uploadscript.php',
                        data: formData,
                        processData: false,
                        contentType: false,
                        type: 'POST',
                        // this part is progress bar
                        xhr: function () {
                            var xhr = new window.XMLHttpRequest();
                            xhr.upload.addEventListener("progress", function (evt) {
                                if (evt.lengthComputable) {
                                    var percentComplete = evt.loaded / evt.total;
                                    percentComplete = parseInt(percentComplete * 100);
                                    $('.myprogress').text(percentComplete + '%');
                                    $('.myprogress').css(   'width', percentComplete + '%');
                                }
                            }, false);
                            return xhr;
                        },
                        success: function (data) {
                            $('.msg').text(data);
                            $('#btn').removeAttr('disabled');
                        }
                    });
                });
            });
        </script>
            <form id="myform" method="post">
            <?php if (isset($mssg)){ echo $mssg; }?>
           <div class="row">
           <div class="col-lg-3">
            <input type="hidden" id="file" value="editBol" placeholder="File Name" class="form-control"  autofocus required/>
                   <input type="hidden" id="stackNumber" value="<?php echo $rowFile['stackNumber']; ?>" required/>
                     
                <input type="hidden" id="userId" value="<?php echo $row['userID']; ?>" required/>
                <input type="hidden" id="filename" value="<?php echo rand(1000,9999); ?>" />

                    <div class="form-group">
                      <label for="billofLadingNumber"> Bill of Lading Number</label>
                        <input type="text"  id="billofLadingNumber" value="<?php echo $rowFile['billofLadingNumber']; ?>" placeholder="BOL Number" class="form-control"/>
                    </div>

                   <div class="form-group">
                     <label for="shippername"> Shipper Name</label>
                       <input type="text" id="shippername" value="<?php echo $rowFile['shippername']; ?>" placeholder="Shipper Name" class="form-control" required/>
                   </div>

                   <div class="form-group">
                     <label for="shipperadress">Shipper Adress</label>
                       <input type="text" id="shipperadress" value="<?php echo $rowFile['shipperadress']; ?>" placeholder="Shippers adress" class="form-control" required/>
                   </div>

                   <div class="form-group">
                     <label for="shipperlocation">Shipper Location</label>
                       <input type="text" id="shipperlocation" value="<?php echo $rowFile['shipperlocation']; ?>" placeholder="Shipper's Location" class="form-control" required/>
                   </div>

            </div>
            <!-- /.col-lg-8 -->
            <div class="col-lg-3">
                     <div class="form-group">
                       <label for="consigneename">Consignee Name</label>
                         <input type="text" id="consigneename" value="<?php echo $rowFile['consigneename']; ?>" placeholder="Consignee Name" class="form-control" required/>
                     </div>

                     <div class="form-group">
                       <label for="consigneeadress">Consignee Adress</label>
                         <input type="text" id="consigneeadress" value="<?php echo $rowFile['consigneeadress']; ?>" placeholder="Consignee adress" class="form-control" required/>
                     </div>

                     <div class="form-group">
                       <label for="consigneelocation">Consignee Location</label>
                         <input type="text" id="consigneelocation" value="<?php echo $rowFile['consigneelocation']; ?>" placeholder="consignee Location" class="form-control" required/>
                     </div>

            </div>
            <!-- /.col-lg-4 -->

            <div class="col-lg-3">
                      <div class="form-group">
                        <label for="precariageBy">Precariage By</label>
                          <input type="text" id="precariageBy" value="<?php echo $rowFile['precariageBy']; ?>" placeholder="Precariage By" class="form-control"/>
                      </div>

                        <div class="form-group">
                          <label for="placeofReciept">Place of Reciept</label>
                            <input type="text" id="placeofReciept" value="<?php echo $rowFile['placeofReciept']; ?>" placeholder="Place of Reciept" class="form-control"/>
                        </div>

                        <div class="form-group">
                          <label for="vessel">Vessel</label>
                            <input type="text" id="vessel" value="<?php echo $rowFile['vessel']; ?>" placeholder="Vessel" class="form-control"/>
                        </div>

                        <div class="form-group">
                          <label for="voyno">Voy No</label>
                            <input type="text" id="voyno" value="<?php echo $rowFile['voyno']; ?>" placeholder="Voy No" class="form-control"/>
                        </div>

            </div>

            <div class="col-lg-3">
              <div class="form-group">
                <label for="loadingport">Port of Loading</label>
                  <input type="text" id="loadingport" value="<?php echo $rowFile['loadingport']; ?>" placeholder="Port of Loading" class="form-control"/>
              </div>

              <div class="form-group">
                <label for="dischargeport">Port of Discharge</label>
                  <input type="text" id="dischargeport" value="<?php echo $rowFile['dischargeport']; ?>" placeholder="Port of Discharge" class="form-control"/>
              </div>

              <div class="form-group">
                <label for="finalDestination">Final Destination</label>
                  <input type="text" id="finalDestination" value="<?php echo $rowFile['finalDestination']; ?>" placeholder="Final Destination" class="form-control"/>
              </div>

              <div class="form-group">
                <label for="freightName">Freight & Charges</label>
                  <input type="text"  id="freightName" value="<?php echo $rowFile['freightPayable']; ?>" placeholder="Freight & Charges" class="form-control"/>
              </div>

          </div>
         </div>
          <br>
          <div class="row">
          <div class="col-md-3">

            <div class="form-group">
              <label for="revenueTons"> Revenue Tons</label>
                <input type="text"  id="revenueTons" value="<?php echo $rowFile['revenueTons']; ?>" placeholder="Revenue Tons" class="form-control"/>
            </div>

            <div class="form-group">
              <label for="rate"> Rate</label>
                <input type="text"  id="rate" value="<?php echo $rowFile['rate']; ?>" placeholder="Rate" class="form-control"/>
            </div>

            <div class="form-group">
              <label for="per"> Per</label>
                <input type="text"  id="per" value="<?php echo $rowFile['per']; ?>" placeholder="Per" class="form-control"/>
            </div>

            <div class="form-group">
              <label for="prepaid"> Prepaid</label>
                <input type="text"  id="prepaid" value="<?php echo $rowFile['prepaid']; ?>" placeholder="Collect" class="form-control"/>
            </div>

            <div class="form-group">
              <label for="collect"> Collect</label>
                <input type="text"  id="collect" value="<?php echo $rowFile['collect']; ?>" placeholder="" class="form-control"/>
            </div>

          </div>


          <div class="col-md-3">

            <div class="form-group">
              <label for="markNumber">Marks & Number</label>
                <input type="text" id="markNumber" value="<?php echo $rowFile['markNumber']; ?>" placeholder="Marks & Number" class="form-control"/>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea type="text" id="description" value="<?php echo $rowFile['description']; ?>" placeholder="Description" class="form-control"/></textarea>
            </div>

            <div class="form-group">
              <label for="grossweight">Gross Weight</label>
                <input type="text"  id="grossweight" value="<?php echo $rowFile['grossweight']; ?>" placeholder="Gross Weight" class="form-control"/>
            </div>

            <div class="form-group">
              <label for="measurement">Measurement(CBM)</label>
                <input type="text"  id="measurement" value="<?php echo $rowFile['measurement']; ?>" placeholder="Measurement(CBM)" class="form-control"/>
            </div>

          </div>

          <div class="col-md-3">

            <div class="form-group">
              <label for="packagesNo">Total Number of Packages</label>
                <input type="text"  id="packagesNo" value="<?php echo $rowFile['packagesNo']; ?>" placeholder="Packages No." class="form-control"/>
            </div>
            <div class="form-group">
              <label for="freightPayable"> Freight Payable</label>
                <input type="text"  id="freightPayable" value="<?php echo $rowFile['freightPayable']; ?>" placeholder="Freight Payable" class="form-control"/>
            </div>

            <div class="form-group">
              <label for="numberOriginal"> Number of Original BLs</label>
                <input type="text"  id="numberOriginal" value="<?php echo $rowFile['numberOriginal']; ?>" placeholder="Original BLs" class="form-control"/>
            </div>

            <div class="form-group">
              <label for="placeOfIssue"> Place of Issue</label>
                <input type="text"  id="placeOfIssue" value="<?php echo $rowFile['placeOfIssue']; ?>" placeholder="Place of Issue" class="form-control"/>
            </div>

            <div class="form-group">
              <label for="dateOfIssue"> Date of Issue</label>
                <input type="date"  id="dateOfIssue" value="<?php echo $rowFile['dateOfIssue']; ?>" placeholder="Date of Issue" class="form-control"/>
            </div>

          </div>

          <div class="col-md-3">
            <div id="image_preview" ><center><img id="previewing" src="//placehold.it/600x350/99223" class="img-responsive"/></center></div>
             <div class="form-group">
                        <label>Select file: </label>
                        <input class="form-control" type="file" id="myfile" />
                    </div>

                <div class="form-group">
                        <div class="progress">
                            <div class="progress-bar progress-bar-success myprogress" role="progressbar" style="width:0%">0%</div>
                        </div>

                        <div class="msg"></div>
                    </div>

                    <input type="button" id="btn" class="btn-success" value="Upload" />
                    </div>
                    </div>
              </form>
            <?php
          }elseif($_SESSION['editfile']==$IDF){
            ?>
            <script>
            $(function () {
                $('#btn').click(function () {
                    $('.myprogress').css('width', '0');
                    $('.msg').text('');
                    var filename = $('#filename').val();
                    var myfile = $('#myfile').val();
                    var file = $('#file').val();
                    var idfNumber = $('#idfNumber').val();
                    var stackNumber = $('#stackNumber').val();
                    var userId = $('#userId').val();
                    if (idfNumber == '' || myfile == '') {
                        alert('Please select file');
                        return;
                    }
                    var formData = new FormData();
                    formData.append('myfile', $('#myfile')[0].files[0]);
                    formData.append('filename', filename);
                    formData.append('file', file);
                    formData.append('idfNumber', idfNumber);
                    formData.append('stackNumber', stackNumber);
                    formData.append('userId', userId);
                    $('#btn').attr('disabled', 'disabled');
                     $('.msg').text('Uploading in progress...');
                    $.ajax({
                        url: 'uploadscript.php',
                        data: formData,
                        processData: false,
                        contentType: false,
                        type: 'POST',
                        // this part is progress bar
                        xhr: function () {
                            var xhr = new window.XMLHttpRequest();
                            xhr.upload.addEventListener("progress", function (evt) {
                                if (evt.lengthComputable) {
                                    var percentComplete = evt.loaded / evt.total;
                                    percentComplete = parseInt(percentComplete * 100);
                                    $('.myprogress').text(percentComplete + '%');
                                    $('.myprogress').css(   'width', percentComplete + '%');
                                }
                            }, false);
                            return xhr;
                        },
                        success: function (data) {
                            $('.msg').text(data);
                            $('#btn').removeAttr('disabled');
                        }
                    });
                });
            });
        </script>
            <form id="myform" method="post">
            <input type="hidden" id="file" value="editIdf" placeholder="File Name" class="form-control"  autofocus required/>
          <input type="hidden" id="filename" value="<?php echo rand(1000,9999); ?>" />
              <div class="form-group">
                  <label for="idfNumber">IDF Number</label>
                  <input type="text" id="idfNumber" value="<?php echo $rowFile['idfNo']; ?>" placeholder="IDF Number" class="form-control"  autofocus required/>
              </div>

             <input type="hidden" id="stackNumber" value="<?php echo $rowFile['stackNumber']; ?>" required/>

              <input type="hidden" id="userId" value="<?php echo $row['userID']; ?>" required/>

             <div class="form-group">
                        <label>Select file: </label>
                        <input class="form-control" type="file" id="myfile" />
                    </div>

                <div class="form-group">
                        <div class="progress">
                            <div class="progress-bar progress-bar-success myprogress" role="progressbar" style="width:0%">0%</div>
                        </div>

                        <div class="msg"></div>
                    </div>

                    <input type="button" id="btn" class="btn-success" value="Upload" />
              </form>
            <?php
           }elseif($_SESSION['editfile']==$KBS){
            ?>
            <script>
            $(function () {
                $('#btn').click(function () {
                    $('.myprogress').css('width', '0');
                    $('.msg').text('');
                    var filename = $('#filename').val();
                    var myfile = $('#myfile').val();
                    var file = $('#file').val();
                    var kbsNumber = $('#kbsNumber').val();
                    var stackNumber = $('#stackNumber').val();
                    var userId = $('#userId').val();
                    if (kbsNumber == '' || myfile == '') {
                        alert('Please select file');
                        return;
                    }
                    var formData = new FormData();
                    formData.append('myfile', $('#myfile')[0].files[0]);
                    formData.append('filename', filename);
                    formData.append('file', file);
                    formData.append('kbsNumber', kbsNumber);
                    formData.append('stackNumber', stackNumber);
                    formData.append('userId', userId);
                    $('#btn').attr('disabled', 'disabled');
                     $('.msg').text('Uploading in progress...');
                    $.ajax({
                        url: 'uploadscript.php',
                        data: formData,
                        processData: false,
                        contentType: false,
                        type: 'POST',
                        // this part is progress bar
                        xhr: function () {
                            var xhr = new window.XMLHttpRequest();
                            xhr.upload.addEventListener("progress", function (evt) {
                                if (evt.lengthComputable) {
                                    var percentComplete = evt.loaded / evt.total;
                                    percentComplete = parseInt(percentComplete * 100);
                                    $('.myprogress').text(percentComplete + '%');
                                    $('.myprogress').css(   'width', percentComplete + '%');
                                }
                            }, false);
                            return xhr;
                        },
                        success: function (data) {
                            $('.msg').text(data);
                            $('#btn').removeAttr('disabled');
                        }
                    });
                });
            });
        </script>
            <form id="myform" method="post">
            <input type="hidden" id="file" value="editKbs" placeholder="File Name" class="form-control"  autofocus required/>
           <input type="hidden" id="filename" value="<?php echo rand(1000,9999); ?>" />
              <div class="form-group">
                  <label for="kbsNumber">KBS Number</label>
                  <input type="text" id="kbsNumber" value="<?php echo $rowFile['kbsNo']; ?>" placeholder="KBS Number" class="form-control"  autofocus required/>
              </div>

             <input type="hidden" id="stackNumber" value="<?php echo $rowFile['stackNumber']; ?>" required/>

              <input type="hidden" id="userId" value="<?php echo $row['userID']; ?>" required/>

             <div class="form-group">
                        <label>Select file: </label>
                        <input class="form-control" type="file" id="myfile" />
                    </div>

                <div class="form-group">
                        <div class="progress">
                            <div class="progress-bar progress-bar-success myprogress" role="progressbar" style="width:0%">0%</div>
                        </div>

                        <div class="msg"></div>
                    </div>

                    <input type="button" id="btn" class="btn-success" value="Upload" />
              </form>
            <?php
           }elseif($_SESSION['editfile']==$ECert){
            ?>
            <script>
            $(function () {
                $('#btn').click(function () {
                    $('.myprogress').css('width', '0');
                    $('.msg').text('');
                    var filename = $('#filename').val();
                    var myfile = $('#myfile').val();
                    var file = $('#file').val();
                    var ecertNumber = $('#ecertNumber').val();
                    var stackNumber = $('#stackNumber').val();
                    var userId = $('#userId').val();
                    if (ecertNumber == '' || myfile == '') {
                        alert('Please select file');
                        return;
                    }
                    var formData = new FormData();
                    formData.append('myfile', $('#myfile')[0].files[0]);
                    formData.append('filename', filename);
                    formData.append('file', file);
                    formData.append('ecertNumber', ecertNumber);
                    formData.append('stackNumber', stackNumber);
                    formData.append('userId', userId);
                    $('#btn').attr('disabled', 'disabled');
                     $('.msg').text('Uploading in progress...');
                    $.ajax({
                        url: 'uploadscript.php',
                        data: formData,
                        processData: false,
                        contentType: false,
                        type: 'POST',
                        // this part is progress bar
                        xhr: function () {
                            var xhr = new window.XMLHttpRequest();
                            xhr.upload.addEventListener("progress", function (evt) {
                                if (evt.lengthComputable) {
                                    var percentComplete = evt.loaded / evt.total;
                                    percentComplete = parseInt(percentComplete * 100);
                                    $('.myprogress').text(percentComplete + '%');
                                    $('.myprogress').css(   'width', percentComplete + '%');
                                }
                            }, false);
                            return xhr;
                        },
                        success: function (data) {
                            $('.msg').text(data);
                            $('#btn').removeAttr('disabled');
                        }
                    });
                });
            });
        </script>
            <form id="myform" method="post">
            <input type="hidden" id="file" value="editEcert" placeholder="File Name" class="form-control"  autofocus required/>
           <input type="hidden" id="filename" value="<?php echo rand(1000,9999); ?>" />
              <div class="form-group">
                  <label for="ecertNumber">Export Certificate Number</label>
                  <input type="text" id="ecertNumber" value="<?php echo $rowFile['ecertNo']; ?>" placeholder="Export certificate Number" class="form-control"  autofocus required/>
              </div>

             <input type="hidden" id="stackNumber" value="<?php echo $rowFile['stackNumber']; ?>" required/>

              <input type="hidden" id="userId" value="<?php echo $row['userID']; ?>" required/>

             <div class="form-group">
                        <label>Select file: </label>
                        <input class="form-control" type="file" id="myfile" />
                    </div>

                <div class="form-group">
                        <div class="progress">
                            <div class="progress-bar progress-bar-success myprogress" role="progressbar" style="width:0%">0%</div>
                        </div>

                        <div class="msg"></div>
                    </div>

                    <input type="button" id="btn" class="btn-success" value="Upload" />
              </form>
            <?php
           }elseif($_SESSION['editfile']==$Invoice){
            ?>
             <script>
            $(function () {
                $('#btn').click(function () {
                    $('.myprogress').css('width', '0');
                    $('.msg').text('');
                    var filename = $('#filename').val();
                    var myfile = $('#myfile').val();
                    var file = $('#file').val();
                    var invoiceNumber = $('#invoiceNumber').val();
                    var stackNumber = $('#stackNumber').val();
                    var userId = $('#userId').val();
                    if (invoiceNumber == '' || myfile == '') {
                        alert('Please select file');
                        return;
                    }
                    var formData = new FormData();
                    formData.append('myfile', $('#myfile')[0].files[0]);
                    formData.append('filename', filename);
                    formData.append('file', file);
                    formData.append('invoiceNumber', invoiceNumber);
                    formData.append('stackNumber', stackNumber);
                    formData.append('userId', userId);
                    $('#btn').attr('disabled', 'disabled');
                     $('.msg').text('Uploading in progress...');
                    $.ajax({
                        url: 'uploadscript.php',
                        data: formData,
                        processData: false,
                        contentType: false,
                        type: 'POST',
                        // this part is progress bar
                        xhr: function () {
                            var xhr = new window.XMLHttpRequest();
                            xhr.upload.addEventListener("progress", function (evt) {
                                if (evt.lengthComputable) {
                                    var percentComplete = evt.loaded / evt.total;
                                    percentComplete = parseInt(percentComplete * 100);
                                    $('.myprogress').text(percentComplete + '%');
                                    $('.myprogress').css(   'width', percentComplete + '%');
                                }
                            }, false);
                            return xhr;
                        },
                        success: function (data) {
                            $('.msg').text(data);
                            $('#btn').removeAttr('disabled');
                        }
                    });
                });
            });
        </script>
            <form id="myform" method="post">
            <input type="hidden" id="file" value="editInvoice" placeholder="File Name" class="form-control"  autofocus required/>
           <input type="hidden" id="filename" value="<?php echo rand(1000,9999); ?>" />
              <div class="form-group">
                  <label for="invoiceNumber">Invoice Number</label>
                  <input type="text" id="invoiceNumber" placeholder="Quadruplicate Number" value="<?php echo $rowFile['invoiceNo']; ?>" class="form-control" class="form-control"  autofocus required/>
              </div>

             <input type="hidden" id="stackNumber" value="<?php echo $rowFile['stackNumber']; ?>" required/>

              <input type="hidden" id="userId" value="<?php echo $row['userID']; ?>" required/>

             <div class="form-group">
                        <label>Select file: </label>
                        <input class="form-control" type="file" id="myfile" />
                    </div>

                <div class="form-group">
                        <div class="progress">
                            <div class="progress-bar progress-bar-success myprogress" role="progressbar" style="width:0%">0%</div>
                        </div>

                        <div class="msg"></div>
                    </div>

                    <input type="button" id="btn" class="btn-success" value="Upload" />
              </form>
            <?php
          }elseif($_SESSION['editfile']==$TReciept){
            ?>
            <script>
            $(function () {
                $('#btn').click(function () {
                    $('.myprogress').css('width', '0');
                    $('.msg').text('');
                    var filename = $('#filename').val();
                    var myfile = $('#myfile').val();
                    var file = $('#file').val();
                    var trecieptNumber = $('#trecieptNumber').val();
                    var stackNumber = $('#stackNumber').val();
                    var userId = $('#userId').val();
                    if (trecieptNumber == '' || myfile == '') {
                        alert('Please select file');
                        return;
                    }
                    var formData = new FormData();
                    formData.append('myfile', $('#myfile')[0].files[0]);
                    formData.append('filename', filename);
                    formData.append('file', file);
                    formData.append('trecieptNumber', trecieptNumber);
                    formData.append('stackNumber', stackNumber);
                    formData.append('userId', userId);
                    $('#btn').attr('disabled', 'disabled');
                     $('.msg').text('Uploading in progress...');
                    $.ajax({
                        url: 'uploadscript.php',
                        data: formData,
                        processData: false,
                        contentType: false,
                        type: 'POST',
                        // this part is progress bar
                        xhr: function () {
                            var xhr = new window.XMLHttpRequest();
                            xhr.upload.addEventListener("progress", function (evt) {
                                if (evt.lengthComputable) {
                                    var percentComplete = evt.loaded / evt.total;
                                    percentComplete = parseInt(percentComplete * 100);
                                    $('.myprogress').text(percentComplete + '%');
                                    $('.myprogress').css(   'width', percentComplete + '%');
                                }
                            }, false);
                            return xhr;
                        },
                        success: function (data) {
                            $('.msg').text(data);
                            $('#btn').removeAttr('disabled');
                        }
                    });
                });
            });
        </script>
            <form id="myform" method="post">
            <input type="hidden" id="file" value="editTreciept" placeholder="File Name" class="form-control"  autofocus required/>
           <input type="hidden" id="filename" value="<?php echo rand(1000,9999); ?>" />
              <div class="form-group">
                  <label for="trecieptNumber">Transaction Receipt Number</label>
                  <input type="text" id="trecieptNumber" placeholder="Quadruplicate Number" value="<?php echo $rowFile['trecieptNo']; ?>" class="form-control"  autofocus required/>
              </div>

             <input type="hidden" id="stackNumber" value="<?php echo $rowFile['stackNumber']; ?>" required/>

              <input type="hidden" id="userId" value="<?php echo $row['userID']; ?>" required/>

             <div class="form-group">
                        <label>Select file: </label>
                        <input class="form-control" type="file" id="myfile" />
                    </div>

                <div class="form-group">
                        <div class="progress">
                            <div class="progress-bar progress-bar-success myprogress" role="progressbar" style="width:0%">0%</div>
                        </div>

                        <div class="msg"></div>
                    </div>

                    <input type="button" id="btn" class="btn-success" value="Upload" />
              </form>
            <?php
           }elseif($_SESSION['editfile']==$Quadruplicate){
            ?>
            <script>
            $(function () {
                $('#btn').click(function () {
                    $('.myprogress').css('width', '0');
                    $('.msg').text('');
                    var filename = $('#filename').val();
                    var myfile = $('#myfile').val();
                    var file = $('#file').val();
                    var quadruplicateNumber = $('#quadruplicateNumber').val();
                    var stackNumber = $('#stackNumber').val();
                    var userId = $('#userId').val();
                    if (quadruplicateNumber == '' || myfile == '') {
                        alert('Please select file');
                        return;
                    }
                    var formData = new FormData();
                    formData.append('myfile', $('#myfile')[0].files[0]);
                    formData.append('filename', filename);
                    formData.append('file', file);
                    formData.append('quadruplicateNumber', quadruplicateNumber);
                    formData.append('stackNumber', stackNumber);
                    formData.append('userId', userId);
                    $('#btn').attr('disabled', 'disabled');
                     $('.msg').text('Uploading in progress...');
                    $.ajax({
                        url: 'uploadscript.php',
                        data: formData,
                        processData: false,
                        contentType: false,
                        type: 'POST',
                        // this part is progress bar
                        xhr: function () {
                            var xhr = new window.XMLHttpRequest();
                            xhr.upload.addEventListener("progress", function (evt) {
                                if (evt.lengthComputable) {
                                    var percentComplete = evt.loaded / evt.total;
                                    percentComplete = parseInt(percentComplete * 100);
                                    $('.myprogress').text(percentComplete + '%');
                                    $('.myprogress').css(   'width', percentComplete + '%');
                                }
                            }, false);
                            return xhr;
                        },
                        success: function (data) {
                            $('.msg').text(data);
                            $('#btn').removeAttr('disabled');
                        }
                    });
                });
            });
        </script>
            <form id="myform" method="post">
            <input type="hidden" id="file" value="editQuadruplicate" placeholder="File Name" class="form-control"  autofocus required/>
          <input type="hidden" id="filename" value="<?php echo rand(1000,9999); ?>" />
              <div class="form-group">
                  <label for="quadruplicateNumber">Quadruplicate Number</label>
                  <input type="text" id="quadruplicateNumber" value="<?php echo $rowFile['quadruplicateNo']; ?>" placeholder="Quadruplicate Number" class="form-control"  autofocus required/>
              </div>

             <input type="hidden" id="stackNumber" value="<?php echo $rowFile['stackNumber']; ?>" required/>

              <input type="hidden" id="userId" value="<?php echo $row['userID']; ?>" required/>

             <div class="form-group">
                        <label>Select file: </label>
                        <input class="form-control" type="file" id="myfile" />
                    </div>

                <div class="form-group">
                        <div class="progress">
                            <div class="progress-bar progress-bar-success myprogress" role="progressbar" style="width:0%">0%</div>
                        </div>

                        <div class="msg"></div>
                    </div>

                    <input type="button" id="btn" class="btn-success" value="Upload" />
              </form>
            <?php
           }elseif($_SESSION['editfile']==$LBook){
            ?>
             <script>
            $(function () {
                $('#btn').click(function () {
                    $('.myprogress').css('width', '0');
                    $('.msg').text('');
                    var filename = $('#filename').val();
                    var myfile = $('#myfile').val();
                    var file = $('#file').val();
                    var lbookNumber = $('#lbookNumber').val();
                    var stackNumber = $('#stackNumber').val();
                    var userId = $('#userId').val();
                    if (lbookNumber == '' || myfile == '') {
                        alert('Please select file');
                        return;
                    }
                    var formData = new FormData();
                    formData.append('myfile', $('#myfile')[0].files[0]);
                    formData.append('filename', filename);
                    formData.append('file', file);
                    formData.append('lbookNumber', lbookNumber);
                    formData.append('stackNumber', stackNumber);
                    formData.append('userId', userId);
                    $('#btn').attr('disabled', 'disabled');
                     $('.msg').text('Uploading in progress...');
                    $.ajax({
                        url: 'uploadscript.php',
                        data: formData,
                        processData: false,
                        contentType: false,
                        type: 'POST',
                        // this part is progress bar
                        xhr: function () {
                            var xhr = new window.XMLHttpRequest();
                            xhr.upload.addEventListener("progress", function (evt) {
                                if (evt.lengthComputable) {
                                    var percentComplete = evt.loaded / evt.total;
                                    percentComplete = parseInt(percentComplete * 100);
                                    $('.myprogress').text(percentComplete + '%');
                                    $('.myprogress').css(   'width', percentComplete + '%');
                                }
                            }, false);
                            return xhr;
                        },
                        success: function (data) {
                            $('.msg').text(data);
                            $('#btn').removeAttr('disabled');
                        }
                    });
                });
            });
        </script>
            <form id="myform" method="post">
            <input type="hidden" id="file" value="editLbook" placeholder="File Name" class="form-control"  autofocus required/>
          <input type="hidden" id="filename" value="<?php echo rand(1000,9999); ?>" />
              <div class="form-group">
                  <label for="lbookNumber">Log Book Number</label>
                  <input type="text" id="lbookNumber" value="<?php echo $rowFile['lbookNo']; ?>" placeholder="Log Book Number" class="form-control"  autofocus required/>
              </div>

             <input type="hidden" id="stackNumber" value="<?php echo $rowFile['stackNumber']; ?>" required/>

              <input type="hidden" id="userId" value="<?php echo $row['userID']; ?>" required/>

             <div class="form-group">
                        <label>Select file: </label>
                        <input class="form-control" type="file" id="myfile" />
                    </div>

                <div class="form-group">
                        <div class="progress">
                            <div class="progress-bar progress-bar-success myprogress" role="progressbar" style="width:0%">0%</div>
                        </div>

                        <div class="msg"></div>
                    </div>

                    <input type="button" id="btn" class="btn-success" value="Upload" />
              </form>
            <?php
           }elseif($_SESSION['editfile']==$Coc){
            ?>
            <script>
            $(function () {
                $('#btn').click(function () {
                    $('.myprogress').css('width', '0');
                    $('.msg').text('');
                    var filename = $('#filename').val();
                    var myfile = $('#myfile').val();
                    var file = $('#file').val();
                    var cocNumber = $('#cocNumber').val();
                    var stackNumber = $('#stackNumber').val();
                    var userId = $('#userId').val();
                    if (cocNumber == '' || myfile == '') {
                        alert('Please select file');
                        return;
                    }
                    var formData = new FormData();
                    formData.append('myfile', $('#myfile')[0].files[0]);
                    formData.append('filename', filename);
                    formData.append('file', file);
                    formData.append('cocNumber', cocNumber);
                    formData.append('stackNumber', stackNumber);
                    formData.append('userId', userId);
                    $('#btn').attr('disabled', 'disabled');
                     $('.msg').text('Uploading in progress...');
                    $.ajax({
                        url: 'uploadscript.php',
                        data: formData,
                        processData: false,
                        contentType: false,
                        type: 'POST',
                        // this part is progress bar
                        xhr: function () {
                            var xhr = new window.XMLHttpRequest();
                            xhr.upload.addEventListener("progress", function (evt) {
                                if (evt.lengthComputable) {
                                    var percentComplete = evt.loaded / evt.total;
                                    percentComplete = parseInt(percentComplete * 100);
                                    $('.myprogress').text(percentComplete + '%');
                                    $('.myprogress').css(   'width', percentComplete + '%');
                                }
                            }, false);
                            return xhr;
                        },
                        success: function (data) {
                            $('.msg').text(data);
                            $('#btn').removeAttr('disabled');
                        }
                    });
                });
            });
        </script>
            <form id="myform" method="post">
            <input type="hidden" id="file" value="editCoc" placeholder="File Name" class="form-control"  autofocus required/>
           <input type="hidden" id="filename" value="<?php echo rand(1000,9999); ?>" />
              <div class="form-group">
                  <label for="lbookNumber">Coc Number</label>
                  <input type="text" id="cocNumber" value="<?php echo $rowFile['cocNo']; ?>" placeholder="Coc Number" class="form-control"  autofocus required/>
              </div>

             <input type="hidden" id="stackNumber" value="<?php echo $rowFile['stackNumber']; ?>" required/>

              <input type="hidden" id="userId" value="<?php echo $row['userID']; ?>" required/>

             <div class="form-group">
                        <label>Select file: </label>
                        <input class="form-control" type="file" id="myfile" />
                    </div>

                <div class="form-group">
                        <div class="progress">
                            <div class="progress-bar progress-bar-success myprogress" role="progressbar" style="width:0%">0%</div>
                        </div>

                        <div class="msg"></div>
                    </div>

                    <input type="button" id="btn" class="btn-success" value="Upload" />
              </form>
            <?php
           }elseif($_SESSION['editfile']==$Coi){
            ?>
            <script>
            $(function () {
                $('#btn').click(function () {
                    $('.myprogress').css('width', '0');
                    $('.msg').text('');
                    var filename = $('#filename').val();
                    var myfile = $('#myfile').val();
                    var file = $('#file').val();
                    var coiNumber = $('#coiNumber').val();
                    var stackNumber = $('#stackNumber').val();
                    var userId = $('#userId').val();
                    if (coiNumber == '' || myfile == '') {
                        alert('Please select file');
                        return;
                    }
                    var formData = new FormData();
                    formData.append('myfile', $('#myfile')[0].files[0]);
                    formData.append('filename', filename);
                    formData.append('file', file);
                    formData.append('coiNumber', coiNumber);
                    formData.append('stackNumber', stackNumber);
                    formData.append('userId', userId);
                    $('#btn').attr('disabled', 'disabled');
                     $('.msg').text('Uploading in progress...');
                    $.ajax({
                        url: 'uploadscript.php',
                        data: formData,
                        processData: false,
                        contentType: false,
                        type: 'POST',
                        // this part is progress bar
                        xhr: function () {
                            var xhr = new window.XMLHttpRequest();
                            xhr.upload.addEventListener("progress", function (evt) {
                                if (evt.lengthComputable) {
                                    var percentComplete = evt.loaded / evt.total;
                                    percentComplete = parseInt(percentComplete * 100);
                                    $('.myprogress').text(percentComplete + '%');
                                    $('.myprogress').css(   'width', percentComplete + '%');
                                }
                            }, false);
                            return xhr;
                        },
                        success: function (data) {
                            $('.msg').text(data);
                            $('#btn').removeAttr('disabled');
                        }
                    });
                });
            });
        </script>
            <form id="myform" method="post">
            <input type="hidden" id="file" value="editCoi" placeholder="File Name" class="form-control"  autofocus required/>
           <input type="hidden" id="filename" value="<?php echo rand(1000,9999); ?>" />
              <div class="form-group">
                  <label for="coiNumber">Coi Number</label>
                  <input type="text" id="coiNumber" value="<?php echo $rowFile['coiNo']; ?>" placeholder="Coi Number" class="form-control"  autofocus required/>
              </div>

             <input type="hidden" id="stackNumber" value="<?php echo $rowFile['stackNumber']; ?>" required/>

              <input type="hidden" id="userId" value="<?php echo $row['userID']; ?>" required/>

             <div class="form-group">
                        <label>Select file: </label>
                        <input class="form-control" type="file" id="myfile" />
                    </div>

                <div class="form-group">
                        <div class="progress">
                            <div class="progress-bar progress-bar-success myprogress" role="progressbar" style="width:0%">0%</div>
                        </div>

                        <div class="msg"></div>
                    </div>

                    <input type="button" id="btn" class="btn-success" value="Upload" />
              </form>
            <?php
           }elseif($_SESSION['editfile']==$Pkl){
            ?>
            <script>
            $(function () {
                $('#btn').click(function () {
                    $('.myprogress').css('width', '0');
                    $('.msg').text('');
                    var filename = $('#filename').val();
                    var myfile = $('#myfile').val();
                    var file = $('#file').val();
                    var pklNumber = $('#pklNumber').val();
                    var stackNumber = $('#stackNumber').val();
                    var userId = $('#userId').val();
                    if (pklNumber == '' || myfile == '') {
                        alert('Please select file');
                        return;
                    }
                    var formData = new FormData();
                    formData.append('myfile', $('#myfile')[0].files[0]);
                    formData.append('filename', filename);
                    formData.append('file', file);
                    formData.append('pklNumber', pklNumber);
                    formData.append('stackNumber', stackNumber);
                    formData.append('userId', userId);
                    $('#btn').attr('disabled', 'disabled');
                     $('.msg').text('Uploading in progress...');
                    $.ajax({
                        url: 'uploadscript.php',
                        data: formData,
                        processData: false,
                        contentType: false,
                        type: 'POST',
                        // this part is progress bar
                        xhr: function () {
                            var xhr = new window.XMLHttpRequest();
                            xhr.upload.addEventListener("progress", function (evt) {
                                if (evt.lengthComputable) {
                                    var percentComplete = evt.loaded / evt.total;
                                    percentComplete = parseInt(percentComplete * 100);
                                    $('.myprogress').text(percentComplete + '%');
                                    $('.myprogress').css(   'width', percentComplete + '%');
                                }
                            }, false);
                            return xhr;
                        },
                        success: function (data) {
                            $('.msg').text(data);
                            $('#btn').removeAttr('disabled');
                        }
                    });
                });
            });
        </script>
            <form id="myform" method="post">
            <input type="hidden" id="file" value="editPkl" placeholder="File Name" class="form-control"  autofocus required/>
           <input type="hidden" id="filename" value="<?php echo rand(1000,9999); ?>" />
              <div class="form-group">
                  <label for="pklNumber">Pkl Number</label>
                  <input type="text" id="pklNumber" value="<?php echo $rowFile['pklNo']; ?>" placeholder="Pkl Number" class="form-control"  autofocus required/>
              </div>

             <input type="hidden" id="stackNumber" value="<?php echo $rowFile['stackNumber']; ?>" required/>

              <input type="hidden" id="userId" value="<?php echo $row['userID']; ?>" required/>

             <div class="form-group">
                        <label>Select file: </label>
                        <input class="form-control" type="file" id="myfile" />
                    </div>

                <div class="form-group">
                        <div class="progress">
                            <div class="progress-bar progress-bar-success myprogress" role="progressbar" style="width:0%">0%</div>
                        </div>

                        <div class="msg"></div>
                    </div>

                    <input type="button" id="btn" class="btn-success" value="Upload" />
              </form>
            <?php
           }
           elseif($_SESSION['editfile']==$Entry){
            ?>
            <script>
            $(function () {
                $('#btn').click(function () {
                    $('.myprogress').css('width', '0');
                    $('.msg').text('');
                    var filename = $('#filename').val();
                    var myfile = $('#myfile').val();
                    var file = $('#file').val();
                    var entryNumber = $('#entryNumber').val();
                    var stackNumber = $('#stackNumber').val();
                    var userId = $('#userId').val();
                    if (entryNumber == '' || myfile == '') {
                        alert('Please select file');
                        return;
                    }
                    var formData = new FormData();
                    formData.append('myfile', $('#myfile')[0].files[0]);
                    formData.append('filename', filename);
                    formData.append('file', file);
                    formData.append('entryNumber', entryNumber);
                    formData.append('stackNumber', stackNumber);
                    formData.append('userId', userId);
                    $('#btn').attr('disabled', 'disabled');
                     $('.msg').text('Uploading in progress...');
                    $.ajax({
                        url: 'uploadscript.php',
                        data: formData,
                        processData: false,
                        contentType: false,
                        type: 'POST',
                        // this part is progress bar
                        xhr: function () {
                            var xhr = new window.XMLHttpRequest();
                            xhr.upload.addEventListener("progress", function (evt) {
                                if (evt.lengthComputable) {
                                    var percentComplete = evt.loaded / evt.total;
                                    percentComplete = parseInt(percentComplete * 100);
                                    $('.myprogress').text(percentComplete + '%');
                                    $('.myprogress').css(   'width', percentComplete + '%');
                                }
                            }, false);
                            return xhr;
                        },
                        success: function (data) {
                            $('.msg').text(data);
                            $('#btn').removeAttr('disabled');
                        }
                    });
                });
            });
        </script>
            <form id="myform" method="post">
            <input type="hidden" id="file" value="editEntry" placeholder="File Name" class="form-control"  autofocus required/>
           <input type="hidden" id="filename" value="<?php echo rand(1000,9999); ?>" />
              <div class="form-group">
                  <label for="entryNumber">Entry Number</label>
                  <input type="text" id="entryNumber" value="<?php echo $rowFile['entryNo']; ?>" placeholder="Entry Number" class="form-control"  autofocus required/>
              </div>

             <input type="hidden" id="stackNumber" value="<?php echo $rowFile['stackNumber']; ?>" required/>

              <input type="hidden" id="userId" value="<?php echo $row['userID']; ?>" required/>

             <div class="form-group">
                        <label>Select file: </label>
                        <input class="form-control" type="file" id="myfile" />
                    </div>

                <div class="form-group">
                        <div class="progress">
                            <div class="progress-bar progress-bar-success myprogress" role="progressbar" style="width:0%">0%</div>
                        </div>

                        <div class="msg"></div>
                    </div>

                    <input type="button" id="btn" class="btn-success" value="Upload" />
              </form>
            <?php
           }
           ?>
          </div>
        </div>
      </div>
    </div>
    </div>
    </div>
                </div>

    <!-- Bootstrap Core JavaScript -->
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="dist/js/sb-admin-2.js"></script>

    <script src="editscript.js"></script>

    <script>
    function mySearch() {

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


</body>

</html>
