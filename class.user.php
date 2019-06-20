<?php
date_default_timezone_set("Africa/Nairobi");
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once 'dbconfig.php';

class USER
{

 private $conn;

 public function __construct()
 {
  $database = new Database();
  $db = $database->dbConnection();
  $this->conn = $db;
    }

 public function runQuery($sql)
 {
  $stmt = $this->conn->prepare($sql);
  return $stmt;
 }

 public function lasdID()
 {
  $stmt = $this->conn->lastInsertId();
  return $stmt;
 }

 public function register($uname,$ufname,$ulname,$email,$upass,$cpass,$uphone,$urole,$uActivateCode)
 {
  try
  {
     if($upass!==$cpass){
    ?>
        <script>
        alert('Your password and confirm password do not match');
        window.location.href='signup.php';
        </script>
        <?php
   }elseif($upass==$cpass){ 
   $password = password_hash($upass, PASSWORD_DEFAULT); // this function works only in PHP 5.5 or latest version
   $stmt = $this->conn->prepare("INSERT INTO tbl_users(userName,firstName,lastName,userEmail,userPass,userPhone,loginType,verifyCode)
    VALUES(:user_name,:user_fname,:user_lname,:user_mail,:user_pass,:user_phone,:user_type,:cActivateCode)");
   $stmt->bindparam(":user_name",$uname);
   $stmt->bindparam(":user_fname",$ufname);
   $stmt->bindparam(":user_lname",$ulname);
   $stmt->bindparam(":user_mail",$email);
   $stmt->bindparam(":user_pass",$password);
   $stmt->bindparam(":user_phone",$uphone);
   $stmt->bindparam(":user_type",$urole);
   $stmt->bindparam(":cActivateCode",$uActivateCode);
   $stmt->execute();
   return $stmt;
  }
}
  catch(PDOException $ex)
  {
   echo $ex->getMessage();
  }
 }

 public function login($email,$upass)
 {
  try
  {
   $stmt = $this->conn->prepare("SELECT * FROM tbl_users WHERE userEmail=:email_id");
   $stmt->execute(array(":email_id"=>$email));
   $userRow=$stmt->fetch(PDO::FETCH_ASSOC);

   if($stmt->rowCount() == 1)
   {
     if(password_verify($upass, $userRow['userPass']))
     {  
      if($userRow['verify']==1){
       if($userRow['loginType']=="admin"){
$_SESSION['userSession'] = $userRow['userID'];

$email = $userRow['userEmail'];
$username = $userRow['userName'];
$_SESSION['email'] = $email;
$_SESSION['username'] = $username; 

 $dee=$_SERVER['REMOTE_ADDR'];
 $_SESSION['REMOTE_ADDR']=$dee;
 $postDateFormat=date("y:m:d",time());
 $mergeDate="20";
 $postTime=date("h:i A.",time());
 $postDate=$mergeDate."".$postDateFormat;
   $stmt = $this->conn->prepare("INSERT INTO tbl_login(userName,loginTime,loginDate,loginUserIp)VALUES(:user_name,:postTime,:postDate,:user_address)");
   $stmt->bindparam(":user_name",$username);
   $stmt->bindparam(":postTime",$postTime);
   $stmt->bindparam(":postDate",$postDate);
   $stmt->bindparam(":user_address",$_SESSION['REMOTE_ADDR']);    
   $stmt->execute();

 $_SESSION['loginSession'] =$this->conn->lastInsertId();
 $sessionLogin=$_SESSION['loginSession'];
 $userStatus=1;
 $sessionEmail=$_SESSION['email'];
 $sql =$this->conn->prepare('UPDATE tbl_users SET user_status=:ustatus,user_login=:ulogin WHERE userEmail=:uemail');
      $sql->bindparam(':ustatus',$userStatus);
      $sql->bindparam(':ulogin',$sessionLogin);
      $sql->bindparam(':uemail',$sessionEmail);
      if($sql->execute()){
        $_SESSION['userSession'] = $userRow['userID'];
        echo "<script>window.location.assign('adhome.php')</script>";
      }
   
       }elseif($userRow['loginType']=="worker"){
$_SESSION['userSession'] = $userRow['userID'];

$email = $userRow['userEmail'];
$username = $userRow['userName'];
$_SESSION['email'] = $email;
$_SESSION['username'] = $username; 

 $dee=$_SERVER['REMOTE_ADDR'];
 $_SESSION['REMOTE_ADDR']=$dee;
 $postDateFormat=date("y:m:d",time());
 $mergeDate="20";
 $postTime=date("h:i A.",time());
 $postDate=$mergeDate."".$postDateFormat;
   $stmt = $this->conn->prepare("INSERT INTO tbl_login(userName,loginTime,loginDate,loginUserIp)VALUES(:user_name,:postTime,:postDate,:user_address)");
   $stmt->bindparam(":user_name",$username);
   $stmt->bindparam(":postTime",$postTime);
   $stmt->bindparam(":postDate",$postDate);
   $stmt->bindparam(":user_address",$_SESSION['REMOTE_ADDR']);    
   $stmt->execute();

 $_SESSION['loginSession'] =$this->conn->lastInsertId();
 $sessionLogin=$_SESSION['loginSession'];
 $userStatus=1;
 $sessionEmail=$_SESSION['email'];
 $sql =$this->conn->prepare('UPDATE tbl_users SET user_status=:ustatus,user_login=:ulogin WHERE userEmail=:uemail');
      $sql->bindparam(':ustatus',$userStatus);
      $sql->bindparam(':ulogin',$sessionLogin);
      $sql->bindparam(':uemail',$sessionEmail);
      if($sql->execute()){
        $_SESSION['userSession'] = $userRow['userID'];
        echo "<script>window.location.assign('home.php')</script>";
      }
       }
       }elseif ($userRow['verify']==0) {
         ?>
             <script>
        alert('Please Verify Your account before proceeding to login. Thanks');
        window.location.href='index.php';
        </script>
        <?php
       }
     }
     else
     {
      ?>
             <script>
        alert('Wrong login details.Please try again thanks.');
        window.location.href='index.php';
        </script>
        <?php
     }
   }
   else
   {
     ?>
             <script>
        alert('Error while logging in.');
        window.location.href='index.php';
        </script>
        <?php
   }
 }catch(PDOException $ex)
  {
   echo $ex->getMessage();
  }
 }


 public function is_logged_in()
 {
  if(isset($_SESSION['userSession']))
  {
   return true;
  }
 }

 public function redirect($url)
 {
  header("Location: $url");
 }

 public function logout()
 {
  session_destroy();
  $_SESSION['userSession'] = false;
 }
}
