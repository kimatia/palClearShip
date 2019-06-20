<?php
date_default_timezone_set("Africa/Nairobi");
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once 'dbconfig.php';
require_once 'class.user.php';

if (isset($_POST['btn-verify'])) {
    $verifyCode=$_POST['verify'];
    $email=$_POST['email'];
  // select image from db to delete
        $stmt_select = $DB_con->prepare('SELECT verifyCode FROM tbl_users WHERE userEmail =:umail');
        $stmt_select->execute(array(':umail'=>$email));
        $selectRow=$stmt_select->fetch(PDO::FETCH_ASSOC);//retursn value as associative array.
        $selectCode=$selectRow['verifyCode'];
        if($selectCode==$verifyCode){
$verify=1;
$stmt = $DB_con->prepare('UPDATE tbl_users SET verify=:vrify WHERE userEmail=:uemail');
$stmt->bindParam(':vrify',$verify);
$stmt->bindParam(':uemail',$email);
$stmt->execute();
$successMSG1="Successfuly verified...You can Sign in.";
header("refresh:2; index.php");
        }else{

session_start();
if( isset( $_SESSION['counter']))
{
$_SESSION['counter'] += 1;
}
else
{
$_SESSION['counter'] = 1;
}
if($_SESSION['counter']==3 || $_SESSION['counter']>3){
  $verify=rand(1000,9999);
$stmt = $DB_con->prepare('UPDATE tbl_users SET verifyCode=:vrify WHERE userEmail=:uemail');
$stmt->bindParam(':vrify',$verify);
$stmt->bindParam(':uemail',$email);
$stmt->execute();
if($stmt->execute()){
  $errMSG1="You have tried Verification ".$_SESSION['counter']." times in this session. A new code has been sent";
  $number=$selectCode['userPhone'];
  $messageFrom="CIT";
  $messagee="Your Verification code is ".$verify;
require_once __DIR__ . '/vendor/autoload.php';
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
}

session_destroy();  
}else{
 $errMSG1="You Verification code is wrong, please try again"; 
}
   
 }
}
if(isset($_POST['btn-call'])){
 require_once "vendor/autoload.php";

$keypair = new \Nexmo\Client\Credentials\Keypair(
  file_get_contents('private.key'),
    'a7836a29-1b76-4a1b-83f3-b57c297e8955'
);

$client = new \Nexmo\Client($keypair);
$ncco = [
  [
    'action' => 'talk',
    'voiceName' => 'Salli',
    'text' => 'This is a text to speech call from Nexmo'
  ]
];
$call = new \Nexmo\Call\Call();
$call->setTo('254710805424')
  ->setFrom('8613122358023')
  ->setNcco($ncco);

$response = $client->calls()->create($call);
echo $response->getId();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Palm | Verify</title>

 
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
                       <a href="signup.php" class="nav-link"><span class="fa fa-home"></span>Signup</a>
                  </li>
               
            </ul>      
            </div>
    </div>
  </nav>

  <!-- Page Content -->
    <div class="row" style="margin-top: 110px;">
       <div class="container">
       <div class="card">
        <div class="panel panel-default">
                    <div class="panel-heading">
                        <center><h3 class="panel-title">Please Verify Your Account</h3></center>
                    </div>
                    <div class="panel-body" style="margin: 10px;">
                    
                     <form role="form" method="post">
                            <fieldset>
                      <?php
  if(isset($errMSG1)){
      ?>
            <div class="alert alert-danger">
              <span class="glyphicon glyphicon-info-sign"></span> <strong><?php echo $errMSG1; ?></strong>
            </div>
            <?php
  }
  else if(isset($successMSG1)){
    ?>
        <div class="alert alert-success">
              <strong><span class="glyphicon glyphicon-info-sign"></span> <?php echo $successMSG1; ?></strong>
        </div>
        <?php
  }
  ?>        
              <div class="form-group">
                <input class="form-control" name="email" type="email" id="email" placeholder="Email" required="false">
              </div>
              <div class="form-group">
                <input class="form-control" placeholder="Verification code" name="verify" type="text" id="password" required="false">
              </div>
             
              <div class="row">
                <div class="col-md-6">
                  <button class="btn btn-lg btn-success btn-block" type="submit" name="btn-verify">Verify send Code</button></br>
                  <a href="signup.php">Dont have an account yet?</a>
                </div>
                <div class="col-md-6">
                  <button class="btn btn-lg btn-success btn-block" type="submit" name="btn-call">Verify via Call</button></br>
                  <a href="recover.php">Forgot your password?</a>
                </div>
              </div></br>
                            </fieldset>
                        </form> 
                    </div>
                    <div class="panel-footer">
                        <div class="row">
                          <div class="col-md-12">
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
  }else{
  ?>
<p>Status: In verification process.</p>
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
    <!-- /.row -->
<br><br><br>

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
