<?php
date_default_timezone_set("Africa/Nairobi");
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once 'dbconfig.php';
require_once 'class.user.php';

$reg_user = new USER();

if($reg_user->is_logged_in()!="")
{
  $stmt = $reg_user->runQuery("SELECT * FROM tbl_users WHERE userID=:uid");
  $stmt->execute(array(":uid"=>$_SESSION['userSession']));
  $row = $stmt->fetch(PDO::FETCH_ASSOC);
  if($row['loginType']=="admin"){
    $reg_user->redirect('adhome.php');
  }else if($row['loginType']=="company"){
    $reg_user->redirect('home.php');
  }
}

if(isset($_POST['btn-signup']))
{

 $uname = trim($_POST['txtuname']);
 $ufname = trim($_POST['txtufname']);
 $ulname = trim($_POST['txtulname']);
 $email = trim($_POST['txtemail']);
 $upass = trim($_POST['txtpass']);
 $uphone = trim($_POST['txtphone']);
 $urole = trim($_POST['txtrole']);
 $cpass=trim($_POST['ctxtpass']);
 $uActivateCode=rand(1000, 9999);

 $stmt = $reg_user->runQuery("SELECT * FROM tbl_users WHERE userEmail=:email_id");
 $stmt->execute(array(":email_id"=>$email));
 $row = $stmt->fetch(PDO::FETCH_ASSOC);

 if($stmt->rowCount() > 0)
 {
     $errMSG = "User with that email already exists , Please Try another one";
 } else {
  
  if($reg_user->register($uname,$ufname,$ulname,$email,$upass,$cpass,$uphone,$urole,$uActivateCode)){
   
       $successMSG="Success! Message sent. You can now confirm Your account then login.";
       require_once __DIR__ . '/vendor/autoload.php';
$number=$row['userPhone'];
$messageFrom="CIT";
$messagee="Your Verification code is ".$uActivateCode;
$basic  = new \Nexmo\Client\Credentials\Basic('3d981e72','6X2ucIKjdQeynb8g');
$client = new \Nexmo\Client($basic);
try {
  
    $message = $client->message()->send([
    'to' => $number,
    'from' => $messageFrom,
    'text' =>  $messagee
    ]);
    $response = $message->getResponseData();
    if($response['messages'][0]['status'] == 0) {
       $successMSG = "The message was sent successfully\n";
    } else {
        $errMSG = "The message failed with status: " . $response['messages'][0]['status'] . "\n";
    }
} catch (Exception $e) {
    $errMSG ="The message was not sent. Error: " . $e->getMessage() . "\n";
}

// var_dump($message->getResponseData());
       //after successful login, lets take the worker to the login page
       header("refresh:3;index.php");
 }else  {
       $errMSG = "sorry , Query could no execute...";
  }
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

  <title>Palm | Register</title>

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
                       <a href="index.php" class="nav-link"><span class="fa fa-home"></span>Login</a>
                  </li>
               
            </ul>      
            </div>
    </div>
  </nav>

  <!-- Page Content -->
    <div class="row" style="margin-top: 70px;">
      <div class="container">
       <div class="card">
        <div class="panel panel-default">
                    <div class="panel-heading">
                        <center><h3 class="panel-title">Please Sign Up</h3></center>
                    </div>
                    <div class="panel-body">
                    <form role="form" method="post" style="margin: 10px;">
                            <fieldset>
                      <?php
  if(isset($errMSG)){
      ?>
            <div class="alert alert-danger">
              <span class="glyphicon glyphicon-info-sign"></span> <strong><?php echo $errMSG; ?></strong>
            </div>
            <?php
  }
  else if(isset($successMSG)){
    ?>
        <div class="alert alert-success">
              <strong><span class="glyphicon glyphicon-info-sign"></span> <?php echo $successMSG; ?></strong>
        </div>
        <?php
  }
  ?>   
              <div class="form-group">
                <input class="form-control" name="txtuname" type="text" id="txtuname" placeholder="Username" required="false">
              </div>
              <div class="form-group">
                <input class="form-control" name="txtufname" type="text" id="txtufname" placeholder="First Name" required="false">
              </div>
              <div class="form-group">
                <input class="form-control" name="txtulname" type="text" id="txtulname" placeholder="Last Name" required="false">
              </div>
              <div class="form-group">
                <input class="form-control" name="txtemail" type="text" id="txtemail" placeholder="Email" required="false">
              </div>
              <div class="form-group">
                <input class="form-control" name="txtphone" type="text" id="txtphone" placeholder="Phone" required="false">
              </div>
              <div class="form-group">
                <input class="form-control" placeholder="Password" name="txtpass" type="password" id="txtpass" required="false">
              </div>
              <div class="form-group">
                <input class="form-control" placeholder="Confirm Password" name="ctxtpass" type="password" id="txtpass" required="false">
              </div>
              <div class="form-group">
               <input name="txtrole" type="hidden" value="worker" required>
              </div>
              <button class="btn btn-lg btn-success btn-block" type="submit" name="btn-signup">Signup</button>
                            </fieldset>
                        </form>
                        
                    </div>
                </div>
          </div>
        </div>
      </div>
    <!-- /.row -->


  <!-- Footer -->
  <footer class="py-5 bg-dark">
    <div class="container">
      <p class="m-0 text-center text-white">Copyright &copy; Palm 2019</p>
    </div>
    <!-- /.container -->
  </footer>

 <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>


</body>

</html>
