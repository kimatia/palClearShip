<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="postscripttt.js"></script>
<script>
  var timer=10;
  var view="";
  $(function (){
    function onTime(){
      setTimeout(onTime, 1000);
 
      if(timer==10){
       //alert("at 8")
  
       $.post("inbox.php",{viewing:view},function(data){
        $(".realTimeChat h5").html(data);
       })
       timer=11;
       clearTimeout(onTime); 
      }
      timer--;
    }

    onTime(); 
  });
</script>
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

//check File Number to direct input of files in that stack
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

/* code for data delete */
if(isset($_GET['deleteUser']))
{
  $negative = "No";

 $sql = $con->prepare("UPDATE tbl_users SET online=? WHERE userID=?");
 $sql->bind_param("ss",$negative,$_GET['deleteUser']);
 $sql->execute();

 header("Location: users.php");
}
/* code for data delete */

// grant user permision
if(isset($_GET['grantPermision']))
{

 $positive = "Yes";
 $sql = $con->prepare("UPDATE tbl_users SET status=? WHERE userID=?");
 $sql->bind_param("ss",$positive,$_GET['grantPermision']);
 $sql->execute();

 header("Location: users.php");
}

// limit user permision
if(isset($_GET['limitPermision']))
{

 $negative = "No";
 $sql = $con->prepare("UPDATE tbl_users SET status=? WHERE userID=?");
 $sql->bind_param("ss",$negative,$_GET['limitPermision']);
 $sql->execute();

 header("Location: users.php");
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

  <!-- Page Content -->
    <div class="row" style="margin-top: 80px;">
      <div class="container">
       <div class="card">
        <div class="col-md-12">
        <div class="panel panel-default">
          <div class="panel panel-body">
             <div class="col-md-12">
        <div class="panel panel-default">
          <div class="panel panel-body" style="overflow-y: scroll;max-height: 500px;">

            <div class="list-group">
            <?php
            $Yes = "Yes";
            $eyeD = $_GET['viewUser'];
            if(isset($_GET['viewUser'])){
              $respNameUserContrib = $con->query("SELECT * FROM tbl_users WHERE userID='$eyeD'");
                if($respNameUserContrib){
                  $rowNameContrib=$respNameUserContrib->fetch_array();
                }
                 ?>
              <h4 style="color: green;"><?php echo $rowNameContrib['userName']; ?> File Contributions <span class="pull-right"><a href="?logs">Logs</a></span></h4>
              <?php
              $respUser = $con->query("SELECT * FROM tbl_logs WHERE userId='$eyeD' ORDER BY id DESC");
              while($rowUser=$respUser->fetch_array()){
                //get user
                $respName = $con->query("SELECT * FROM tbl_users WHERE userID='$eyeD'");
                if($respName){
                  $rowName=$respName->fetch_array();
                }
            ?>
              <div class="list-group-item">
                <?php

                $negative = "No";
                if($rowName['online']==$negative){
                 ?>
                 <span style="color:red"><?php echo $rowName['userName'];?></span>
                 <?php
                }else{
                  ?>
                  <span><?php echo $rowName['userName'];?></span>
                  <?php
                }
                ?>
                <?php if($rowUser['updateData']===$Yes) { ?>
                  <span class="ribbon">
                      <div class="text">Edited</div>
                  </span>
                <?php }?>
                <span class="pull-right">File Number: <?php echo $rowUser['stackNumber'];?></span><br>
                <span class="fa fa-folder"><?php echo $rowUser['file'];?></span>
                <?php
            
               $postDate=$rowUser['postDate'];
               $postTime=$rowUser['postTime'];
               $postDateTime=$postDate." ".$postTime;
                 ?>
                <span class="pull-right">Post Date: <?php echo $postDateTime?></span>
              </div>
            <?php
              }
              ?>
              <?php
            }elseif(isset($_GET['logs'])){
             ?>
             <h4>Contribution Logs</h4>
             <?php
             $y = 0;
             $respUsers = $con->query("SELECT * FROM tbl_logs ORDER BY id DESC");
             while($rowUsers=$respUsers->fetch_array()){
                $d = $rowUsers['userId'];
                   //get user
                   $respFileImage = $con->query("SELECT * FROM tbl_users WHERE userID='$d'");
                   if($respFileImage){
                     $rowFileImage=$respFileImage->fetch_array();
                     ?>

                     <div class="list-group-item">
                       <?php
                       $negative = "No";
                       if($rowFileImage['online']==$negative){
                        ?>
                        <span style="color:red"><?php echo $rowFileImage['userName'];?></span>
                        <?php
                       }else{
                         ?>
                         <span><?php echo $rowFileImage['userName'];?></span>
                         <?php
                       }
                       ?>
                       <?php if($rowUsers['updateData']===$Yes) { ?>
                         <span class="ribbon">
                             <div class="text">Edited</div>
                         </span>
                       <?php }?>
                     <span class="pull-right">File Number: <?php echo $rowUsers['stackNumber'];?></span><br>
                     <span class="fa fa-folder"><?php echo $rowUsers['file'];?></span>
                     <?php
               $postDate=$rowUsers['postDate'];
               $postTime=$rowUsers['postTime'];
               $postDateTime=$postDate." ".$postTime;
                 ?>
                <span class="pull-right">Post Date: <?php echo $postDateTime?></span>
              </div>
                     <?php
                     }
                   }
                   ?>

             <?php
           }else{
            ?>
            <h4>Contribution Logs</h4>
            <?php
            $y = 0;
            $respUsers = $con->query("SELECT * FROM tbl_logs ORDER BY id DESC");
            while($rowUsers=$respUsers->fetch_array()){
               $d = $rowUsers['userId'];
                  //get user
                  $respFileImage = $con->query("SELECT * FROM tbl_users WHERE userID='$d'");
                  if($respFileImage){
                    $rowFileImage=$respFileImage->fetch_array();
                    ?>

                    <div class="list-group-item">
                      <?php
                      $negative = "No";
                      if($rowFileImage['online']==$negative){
                       ?>
                       <span style="color:red"><?php echo $rowFileImage['userName'];?></span>
                       <?php
                      }else{
                        ?>
                        <span><?php echo $rowFileImage['userName'];?></span>
                        <?php
                      }
                      ?>
                      <?php if($rowUsers['updateData']===$Yes) { ?>
                        <span class="ribbon">
                            <div class="text">Edited</div>
                        </span>
                      <?php }?>
                    <span class="pull-right">File Number: <?php echo $rowUsers['stackNumber'];?></span><br>
                    <span class="fa fa-folder"><?php echo $rowUsers['file'];?></span>
                    <?php
               $postDate=$rowUsers['postDate'];
               $postTime=$rowUsers['postTime'];
               $postDateTime=$postDate." ".$postTime;
                 ?>
                <span class="pull-right">Post Date: <?php echo $postDateTime?></span>
              </div>
                    <?php
                    }
                  }
                  ?>
            <?php
           }?>
            </div>
          </div>
        </div>
      </div>
        
        </div>
      </div>
    </div>

</div>


<!-- search by atribute functionality-->
<div class="modal fade" id="find" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
         <div class="modal-dialog" role="document">
             <div class="modal-content">
                 <div class="modal-header">
                   <h4><span class="fa fa-search fw"> Find Stack</span></h4>
                 </div>
                 <div class="modal-body section">
                   <div class="">
                   <form action="" class="">
                   <div class="form-group input-group">
                           <input type="text" class="form-control" id="forms" onkeyup="mySearch()" placeholder="Search for a form..">
                           <span class="input-group-btn">
                               <button class="btn btn-default btn-info" type="button"><i class="fa fa-search"></i>
                               </button>
                           </span>
                       </div>
                   </form>

                   <table id="formsTable" class="table table-hover table-condensed" style="table-layout: fixed;">
                   <thead>
                    <tr>
                      <th style="width:75%;">File Number</th>
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
                     <button type="button" class="btn btn-lg btn-default" data-dismiss="modal">Cancel</button>
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
                                 <label for="stackNumber">File Number</label>
                                 <input type="text" name="stackNumber" placeholder="File Number" class="form-control"  autofocus required/>
                             </div>

                               <button class="btn btn-primary btn-outline" type="submit" name="btn-add-stack"> Create</button></br>
                             </form>
                         </div>
                         <div class="modal-footer">
                           <div class="form-group" >
                             <button type="button" class="btn btn-lg btn-default" data-dismiss="modal">Cancel</button>
                           </div>
                           </form>
                         </div>
          </div>
        </div>
      </div>
    </div>
      </div>
      </div>
    <!-- /.row -->



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
