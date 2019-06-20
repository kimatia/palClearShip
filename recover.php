<?php
date_default_timezone_set("Africa/Nairobi");
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once 'dbconfig.php';
require_once 'class.user.php';

if (isset($_POST['btn-reset'])) {
    $email=strip_tags($_POST['email']);
       // include phpmailer class
    require_once 'mailer/class.phpmailer.php';
    // creates object
    $verifyCode=rand(10000,99999);
    $mail = new PHPMailer(true);
      $subject   = "Password reset token";
      $title="Hello ".$email;
      $text_message    = "Your Verification code is ".$verifyCode." Alternatively follow this link to reset Your password <a href='www.palmfreighterslimited.co.ke/recovered.php?userEmail=".$email."' target='_blank'>Click this link</a>";
      require_once 'templates/body.php';
      try
      {

        $mail->IsSMTP();
        $mail->isHTML(true);
        $mail->SMTPDebug  = 0;
        $mail->SMTPAuth   = true;
        $mail->SMTPSecure = "ssl";
        $mail->Host= "smtp.gmail.com";
        $mail->Port       = 465;
        $mail->AddAddress($email);
        $mail->Username   ="namandajoshuadaniel";
        $mail->Password   ='namandadaniel199458';
        $mail->SetFrom('namandajoshuadaniel@gmail.com','Citrouille Global Ltd');
        $mail->Subject    = $subject;
        $mail->Body     = $message;
        $mail->AltBody    = $message;
        if($mail->Send())
        {
$stmt = $DB_con->prepare('UPDATE tbl_users SET verifyCode=:vrify WHERE userEmail=:uemail');
$stmt->bindParam(':vrify',$verifyCode);
$stmt->bindParam(':uemail',$email);
if($stmt->execute()){
 $successMSG1="We sent you an email with reset Code...."; 
}
        }
      }
      catch(phpmailerException $ex)
      {
        $msg = "<div class='alert alert-warning'>".$ex->errorMessage()."</div>";
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

  <title>Palm | Reset</title>

 
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
                        <center><h3 class="panel-title">Please Enter Your Email</h3></center>
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
              <div class="row">
                <div class="col-md-6">
                  <button class="btn btn-lg btn-success btn-block" type="submit" name="btn-reset">Send Reset Code</button></br>
                </div>
                
              </div></br>
                            </fieldset>
                        </form> 
                        <div class="col-md-6">
                  <a href="recovered.php">Received email? Reset Your password</a></br>
                </div>
                    </div>
                    <div class="panel-footer">
                        <div class="row">
                          <div class="col-md-12">
                      </div>  
                </div>
          </div>
        </div>
      </div>
    </div>
      </div>
    <!-- /.row -->
<br><br><br><br><br><br><br>

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
