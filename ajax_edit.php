<?php
date_default_timezone_set("Africa/Nairobi");
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once 'dbconfig.php';

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

  if(isset($_FILES["file"]["type"]) && isset($_POST['billofLadingNumber']))
  {

  $validextensions = array("jpeg", "jpg", "png", "JPEG", "JPG", "PNG");
  $temporary = explode(".", $_FILES["file"]["name"]);
  $file_extension = end($temporary);
  if ((($_FILES["file"]["type"] == "image/png") || ($_FILES["file"]["type"] == "image/JPG") || ($_FILES["file"]["type"] == "image/jpeg")
  ) && ($_FILES["file"]["size"] < 10000000)//Approx. 100000=100kb files can be uploaded.
  && in_array($file_extension, $validextensions)) {
  if ($_FILES["file"]["error"] > 0)
  {
  echo "Return Code: " . $_FILES["file"]["error"] . "<br/><br/>";
  }
  else
  {
  $sourcePath = $_FILES['file']['tmp_name']; // Storing source path of the file in a variable
  $targetPath = "upload/".$_FILES['file']['name']; // Target path where file is to be stored

  $billofLadingNumber = $_POST['billofLadingNumber'];

  $_SESSION['bol'] = $billofLadingNumber;

  $stackNumber = $_POST['stackNumber'];
  $shippername = $_POST['shippername'];
  $shipperadress  = $_POST['shipperadress'];
  $shipperlocation = $_POST['shipperlocation'];
  $consigneename = $_POST['consigneename'];
  $consigneeadress = $_POST['consigneeadress'];
  $consigneelocation = $_POST['consigneelocation'];
  $precariageBy = $_POST['precariageBy'];
  $placeofReciept = $_POST['placeofReciept'];
  $vessel  = $_POST['vessel'];
  $voyno  = $_POST['voyno'];
  $loadingport  = $_POST['loadingport'];
  $dischargeport = $_POST['dischargeport'];
  $finalDestination = $_POST['finalDestination'];
  $freightName = $_POST['freightName'];
  $revenueTons  = $_POST['revenueTons'];
  $rate = $_POST['rate'];
  $per = $_POST['per'];
  $prepaid  = $_POST['prepaid'];
  $collect  = $_POST['collect'];
  $markNumber = $_POST['markNumber'];
  $description  = $_POST['description'];
  $grossweight  = $_POST['grossweight'];
  $measurement  = $_POST['measurement'];
  $packagesNo  = $_POST['packagesNo'];
  $freightPayable = $_POST['freightPayable'];
  $numberOriginal = $_POST['numberOriginal'];
  $placeOfIssue  = $_POST['placeOfIssue'];
  $dateOfIssue = $_POST['dateOfIssue'];
  $userId = $_POST['userId'];

   
        $postDateFormat=date("y:m:d",time()); 
        $mergeDate="20";
        $postTime=date("h:i A.",time());
        $postDate=$mergeDate."".$postDateFormat;
  $billofLading_file=$_FILES["file"]["name"];
  $SQL = $con->prepare("UPDATE tbl_billofLading set  billofLadingNumber=?, shippername=? ,shipperadress=? ,shipperlocation=? ,consigneename=? ,consigneeadress=?,consigneelocation=?, precariageBy=?, placeofReciept=? ,vessel=?, voyno=?, loadingport=?, dischargeport=?, finalDestination=?, freightName=?, revenueTons=?, rate=?, per=?, prepaid=?,collect=?,markNumber=?,description=?,grossweight=?,measurement=?,packagesNo=?,freightPayable=?,numberOriginal=?,placeOfIssue=?,dateOfIssue=? ,billofLading_file=?, userId=?, postTime=?,postDate=? WHERE stackNumber=?");

  //$sql = $con->prepare("UPDATE tbl_stacks SET bol=? WHERE stackNumber=?");
  //$sql->bind_param("ss",$positive,$stackNumber);
  //$sql->execute();

    if(!$SQL)
    {
     echo $con->error;
   }else{
     $SQL->bind_param('ssssssssssssssssssssssssssssssssss',$billofLadingNumber,$shippername ,$shipperadress  ,$shipperlocation ,$consigneename ,$consigneeadress ,$consigneelocation ,$precariageBy,$placeofReciept,$vessel,$voyno,$loadingport,$dischargeport,$finalDestination, $freightName, $revenueTons,$rate,$per,$prepaid,$collect,$markNumber,$description,$grossweight,$measurement,$packagesNo,$freightPayable,$numberOriginal,$placeOfIssue,$dateOfIssue ,$billofLading_file,$userId,$postTime,$postDate,$stackNumber);
     
     if(!$SQL)
     {
      echo $con->error;
      
    }elseif($SQL->execute()){
      $userId = $_POST['userId'];
            $respFileMessage = $con->query("SELECT * FROM tbl_users WHERE userID='$userId'");
             $rowFileMessage=$respFileMessage->fetch_array();
             $file = "BILL OF LADING";
             $idfNumber = $_POST['billofLadingNumber'];
             $postDateFormat=date("y:m:d",time()); 
             $mergeDate="20";
             $postTime=date("h:i A.",time());
             $postDate=$mergeDate."".$postDateFormat;
            $userMessage=$rowFileMessage['userName'];
            $action1="edited BOL document No.";
            $action2="of file No.";
            $action3="owned by";
            // select bol information to prove if file was instantiated with bol file
    $stmt_select_owner = $DB_con->prepare('SELECT fileOwner FROM tbl_stacks WHERE stackNumber=:stack');
    $stmt_select_owner->execute(array(':stack'=>$stackNumber));
    $bolSelect=$stmt_select_owner->fetch(PDO::FETCH_ASSOC);//retursn value as associative array.
    $fileOwner=$bolSelect['fileOwner'];
            $on="on";
            $postDateTime=$postDate." ".$postTime;
            $message=$userMessage." ".$action1."".$billofLadingNumber." ".$action2."".$stackNumber." ".$action3." ".$fileOwner." ".$on." ".$postDateTime;
             $sqlMessage = $con->prepare("INSERT INTO tbl_notifications(userName,stackNumber,file,message,postDate,postTime) VALUES(?,?,?,?,?,?)");

          
            $sqlMessage->bind_param('isssss',$userMessage,$stackNumber,$file,$message,$postDate,$postTime);
            if(!$sqlMessage){
              echo $con->error;
            }elseif ($sqlMessage->execute()) {
$messagee=$userMessage." ".$action1."".$billofLadingNumber." ".$action2."".$stackNumber." ".$action3." ".$fileOwner." ".$on." ".$postDateTime;
require_once __DIR__ . '/vendor/autoload.php';

$basic  = new \Nexmo\Client\Credentials\Basic('4b81b8cc', 'BeoRcrJpN2IjeCR3');
$client = new \Nexmo\Client($basic);

$message = $client->message()->send([
    'to' => 254795511728,
    'from' => 'Kimatia',
    'text' =>  $messagee
]);

// var_dump($message->getResponseData());

            }
      move_uploaded_file($sourcePath,$targetPath) ; // Moving Uploaded file
        $positive = "Yes";
    
        $finalDateFormat=date("y:m:d",time()); 
        $mergeDate="20";
       $finalTime=date("h:i A.",time());
        $finalDate=$mergeDate."".$finalDateFormat;
        $sql = $con->prepare("UPDATE tbl_stacks SET bol=?,bolFinalTime=?,bolFinalDate=? WHERE stackNumber=?");
        $sql->bind_param("ssss",$positive,$finalTime,$finalDate,$stackNumber);
        $sql->execute();
        if(!$sql)
        {
         echo $con->error;
        }
        $postTime=date("h:i A.",time());
        $postDate=date("d:m:y",time());
        $file = "bol";
        $updateData = "Yes";
        $SQL = $con->prepare("INSERT INTO tbl_logs(userId,stackNumber,file, postTime,postDate,updateData) VALUES(?,?,?,?,?,?)");


            $SQL->bind_param('isssss',$userId,$stackNumber,$file,$postTime,$postDate,$updateData);
            $SQL->execute();
            if(!$SQL){
              echo $con->error;
            }

      echo "<div class='alert alert-success'>
              <button class='close' data-dismiss='alert'>&times;</button>
              <strong>Success!</strong>.File Edited</div>";
              header("refresh:5;addFile.php");
    }
   }
  }
  }
  else
  {
  echo "<div class='alert alert-danger'>
        <button class='close' data-dismiss='alert'>&times;</button>
        <strong>Sorry!</strong>Invalid file Size or Type
        </div>";
  }
  }

}elseif($_SESSION['editfile']==$IDF){

  if(isset($_FILES["file"]["type"]))
  {
  $validextensions = array("jpeg", "jpg", "png", "JPEG", "JPG", "PNG");
  $temporary = explode(".", $_FILES["file"]["name"]);
  $file_extension = end($temporary);
  if ((($_FILES["file"]["type"] == "image/png") || ($_FILES["file"]["type"] == "image/JPG") || ($_FILES["file"]["type"] == "image/jpeg")
  ) && ($_FILES["file"]["size"] < 10000000)//Approx. 100000=100kb files can be uploaded.
  && in_array($file_extension, $validextensions)) {
  if ($_FILES["file"]["error"] > 0)
  {
  echo "Return Code: " . $_FILES["file"]["error"] . "<br/><br/>";
  }
  else
  {
  $sourcePath = $_FILES['file']['tmp_name']; // Storing source path of the file in a variable
  $targetPath = "upload/".$_FILES['file']['name']; // Target path where file is to be stored

  $idfNumber = $_POST['idfNumber'];
  $stackNumber = $_POST['stackNumber'];
  $userId = $_POST['userId'];
  $idf_file=$_FILES["file"]["name"];
   
        $postDateFormat=date("y:m:d",time()); 
        $mergeDate="20";
        $postTime=date("h:i A.",time());
        $postDate=$mergeDate."".$postDateFormat;
  $SQL = $con->prepare("UPDATE tbl_idf set  idfNo=?, idf_file=?,userId=?, postTime=?,postDate=? where stackNumber=? ");

    if($SQL){
      $SQL->bind_param('ssisss',$idfNumber, $idf_file, $userId,$postTime,$postDate,$stackNumber);
      $SQL->execute();
  
        $finalDateFormat=date("y:m:d",time()); 
        $mergeDate="20";
       $finalTime=date("h:i A.",time());
        $finalDate=$mergeDate."".$finalDateFormat;
      $positive = "Yes";
      $sql = $con->prepare("UPDATE tbl_stacks SET idf=?,idfFinalTime=?,idfFinalDate=? WHERE stackNumber=?");
      $sql->bind_param("ssss",$positive,$finalTime,$finalDate,$stackNumber);
      if(!$sql)
      {
       echo $con->error;
      }elseif ($sql->execute()) {
       $userId = $_POST['userId'];
            $respFileMessage = $con->query("SELECT * FROM tbl_users WHERE userID='$userId'");
             $rowFileMessage=$respFileMessage->fetch_array();
             $file = "IMPORT DECLARATION FORM";
             $idfNumber = $_POST['idfNumber'];
             $postDateFormat=date("y:m:d",time()); 
             $mergeDate="20";
             $postTime=date("h:i A.",time());
             $postDate=$mergeDate."".$postDateFormat;
            $userMessage=$rowFileMessage['userName'];
            $action1="edited IDF document No.";
            $action2="of file No.";
            $action3="owned by";
            // select bol information to prove if file was instantiated with bol file
    $stmt_select_owner = $DB_con->prepare('SELECT fileOwner FROM tbl_stacks WHERE stackNumber=:stack');
    $stmt_select_owner->execute(array(':stack'=>$stackNumber));
    $bolSelect=$stmt_select_owner->fetch(PDO::FETCH_ASSOC);//retursn value as associative array.
    $fileOwner=$bolSelect['fileOwner'];
            $on="on";
            $postDateTime=$postDate." ".$postTime;
            $message=$userMessage." ".$action1."".$idfNumber." ".$action2."".$stackNumber." ".$action3." ".$fileOwner." ".$on." ".$postDateTime;
             $sqlMessage = $con->prepare("INSERT INTO tbl_notifications(userName,stackNumber,file,message,postDate,postTime) VALUES(?,?,?,?,?,?)");

          
            $sqlMessage->bind_param('isssss',$userMessage,$stackNumber,$file,$message,$postDate,$postTime);
            if(!$sqlMessage){
              echo $con->error;
            }elseif ($sqlMessage->execute()) {
$messagee=$userMessage." ".$action1."".$idfNumber." ".$action2."".$stackNumber." ".$action3." ".$fileOwner." ".$on." ".$postDateTime;
require_once __DIR__ . '/vendor/autoload.php';

$basic  = new \Nexmo\Client\Credentials\Basic('4b81b8cc', 'BeoRcrJpN2IjeCR3');
$client = new \Nexmo\Client($basic);

$message = $client->message()->send([
    'to' => 254795511728,
    'from' => 'Kimatia',
    'text' =>  $messagee
]);

// var_dump($message->getResponseData());

            }
      }

      $file = "idf";
      $postTime=date("h:i A.",time());
      $postDate=date("d:m:y",time());
      $updateData = "Yes";
      $SQL = $con->prepare("INSERT INTO tbl_logs(userId,stackNumber,file, postTime,postDate,updateData) VALUES(?,?,?,?,?,?)");


          $SQL->bind_param('isssss',$userId,$stackNumber,$file,$postTime,$postDate,$updateData);
          $SQL->execute();
          if(!$SQL){
            echo $con->error;
          }
      move_uploaded_file($sourcePath,$targetPath) ; // Moving Uploaded file
      echo "<div class='alert alert-success'>
              <button class='close' data-dismiss='alert'>&times;</button>
              <strong>Success!</strong>.File Uploaded</div>";
    }else{
      echo $con->error;
    }

  }
  }
  else
  {
  echo "<div class='alert alert-danger'>
          <button class='close' data-dismiss='alert'>&times;</button>
          <strong>Sorry!</strong>Invalid file Size or Type
           </div>";
  }
  }

}elseif($_SESSION['editfile']==$KBS){

  if(isset($_FILES["file"]["type"]))
  {
  $validextensions = array("jpeg", "jpg", "png", "JPEG", "JPG", "PNG");
  $temporary = explode(".", $_FILES["file"]["name"]);
  $file_extension = end($temporary);
  if ((($_FILES["file"]["type"] == "image/png") || ($_FILES["file"]["type"] == "image/JPG") || ($_FILES["file"]["type"] == "image/jpeg")
  ) && ($_FILES["file"]["size"] < 10000000)//Approx. 100000=100kb files can be uploaded.
  && in_array($file_extension, $validextensions)) {
  if ($_FILES["file"]["error"] > 0)
  {
  echo "Return Code: " . $_FILES["file"]["error"] . "<br/><br/>";
  }
  else
  {
  $sourcePath = $_FILES['file']['tmp_name']; // Storing source path of the file in a variable
  $targetPath = "upload/".$_FILES['file']['name']; // Target path where file is to be stored

  $kbsNumber = $_POST['kbsNumber'];
  $stackNumber = $_POST['stackNumber'];
  $userId = $_POST['userId'];
  $kbs_file=$_FILES["file"]["name"];
   
        $postDateFormat=date("y:m:d",time()); 
        $mergeDate="20";
        $postTime=date("h:i A.",time());
        $postDate=$mergeDate."".$postDateFormat;
  $SQL = $con->prepare("UPDATE tbl_kbs set  kbsNo=?, kbs_file=?,userId=?, postTime=?,postDate=? where stackNumber=? ");

  $SQL->bind_param('ssisss',$kbsNumber, $kbs_file, $userId,$postTime,$postDate,$stackNumber);
    if(!$SQL){
       echo $con->error;
    }elseif($SQL->execute()){
            $userId = $_POST['userId'];
            $respFileMessage = $con->query("SELECT * FROM tbl_users WHERE userID='$userId'");
             $rowFileMessage=$respFileMessage->fetch_array();
             $file = "KENYA BUREAU STANDARDS";
             $kbsNumber = $_POST['kbsNumber'];
             $postDateFormat=date("y:m:d",time()); 
             $mergeDate="20";
             $postTime=date("h:i A.",time());
             $postDate=$mergeDate."".$postDateFormat;
            $userMessage=$rowFileMessage['userName'];
            $action1="edited KBS document No.";
            $action2="of file No.";
            $action3="owned by";
            // select bol information to prove if file was instantiated with bol file
    $stmt_select_owner = $DB_con->prepare('SELECT fileOwner FROM tbl_stacks WHERE stackNumber=:stack');
    $stmt_select_owner->execute(array(':stack'=>$stackNumber));
    $bolSelect=$stmt_select_owner->fetch(PDO::FETCH_ASSOC);//retursn value as associative array.
    $fileOwner=$bolSelect['fileOwner'];
            $on="on";
            $postDateTime=$postDate." ".$postTime;
            $message=$userMessage." ".$action1."".$kbsNumber." ".$action2."".$stackNumber." ".$action3." ".$fileOwner." ".$on." ".$postDateTime;
             $sqlMessage = $con->prepare("INSERT INTO tbl_notifications(userName,stackNumber,file,message,postDate,postTime) VALUES(?,?,?,?,?,?)");

          
            $sqlMessage->bind_param('isssss',$userMessage,$stackNumber,$file,$message,$postDate,$postTime);
            if(!$sqlMessage){
              echo $con->error;
            }elseif ($sqlMessage->execute()) {
$messagee=$userMessage." ".$action1."".$kbsNumber." ".$action2."".$stackNumber." ".$action3." ".$fileOwner." ".$on." ".$postDateTime;
require_once __DIR__ . '/vendor/autoload.php';

$basic  = new \Nexmo\Client\Credentials\Basic('4b81b8cc', 'BeoRcrJpN2IjeCR3');
$client = new \Nexmo\Client($basic);

$message = $client->message()->send([
    'to' => 254795511728,
    'from' => 'Kimatia',
    'text' =>  $messagee
]);

// var_dump($message->getResponseData());

            }
  
        $finalDateFormat=date("y:m:d",time()); 
        $mergeDate="20";
       $finalTime=date("h:i A.",time());
        $finalDate=$mergeDate."".$finalDateFormat;
      $positive = "Yes";
      $sql = $con->prepare("UPDATE tbl_stacks SET kbs=?,kbsFinalTime=?,kbsFinalDate=? WHERE stackNumber=?");
      $sql->bind_param("ssss",$positive,$finalTime,$finalDate,$stackNumber);
      $sql->execute();

      $file = "kbs";
      $postTime=date("h:i A.",time());
      $postDate=date("d:m:y",time());
      $updateData = "Yes";
      $SQL = $con->prepare("INSERT INTO tbl_logs(userId,stackNumber,file, postTime,postDate,updateData) VALUES(?,?,?,?,?,?)");


          $SQL->bind_param('isssss',$userId,$stackNumber,$file,$postTime,$postDate,$updateData);
          $SQL->execute();
          if(!$SQL){
            echo $con->error;
          }

      if(!$sql)
      {
       echo $con->error;
      }


      move_uploaded_file($sourcePath,$targetPath) ; // Moving Uploaded file
      echo "<div class='alert alert-success'>
              <button class='close' data-dismiss='alert'>&times;</button>
              <strong>Success!</strong>.File Uploaded</div>";

    }

  }
  }
  else
  {
  echo "<div class='alert alert-danger'>
          <button class='close' data-dismiss='alert'>&times;</button>
          <strong>Sorry!</strong>Invalid file Size or Type
           </div>";
  }
  }

}
elseif($_SESSION['editfile']==$Coc){

  if(isset($_FILES["file"]["type"]))
  {
  $validextensions = array("jpeg", "jpg", "png", "JPEG", "JPG", "PNG");
  $temporary = explode(".", $_FILES["file"]["name"]);
  $file_extension = end($temporary);
  if ((($_FILES["file"]["type"] == "image/png") || ($_FILES["file"]["type"] == "image/JPG") || ($_FILES["file"]["type"] == "image/jpeg")
  ) && ($_FILES["file"]["size"] < 10000000)//Approx. 100000=100kb files can be uploaded.
  && in_array($file_extension, $validextensions)) {
  if ($_FILES["file"]["error"] > 0)
  {
  echo "Return Code: " . $_FILES["file"]["error"] . "<br/><br/>";
  }
  else
  {
  $sourcePath = $_FILES['file']['tmp_name']; // Storing source path of the file in a variable
  $targetPath = "upload/".$_FILES['file']['name']; // Target path where file is to be stored

  $cocNumber = $_POST['cocNumber'];
  $stackNumber = $_POST['stackNumber'];
  $userId = $_POST['userId'];
  $coc_file=$_FILES["file"]["name"];
   
        $postDateFormat=date("y:m:d",time()); 
        $mergeDate="20";
        $postTime=date("h:i A.",time());
        $postDate=$mergeDate."".$postDateFormat;
  $SQL = $con->prepare("UPDATE tbl_coc set  cocNo=?, coc_file=?,userId=?, postTime=?,postDate=? where stackNumber=? ");

    if(!$SQL){
       echo $con->error;
    }else{
      $SQL->bind_param('ssisss',$cocNumber, $coc_file, $userId,$postTime,$postDate,$stackNumber);
      $SQL->execute();
  
        $finalDateFormat=date("y:m:d",time()); 
        $mergeDate="20";
       $finalTime=date("h:i A.",time());
        $finalDate=$mergeDate."".$finalDateFormat;
      $positive = "Yes";
      $sql = $con->prepare("UPDATE tbl_stacks SET coc=?,cocFinalTime=?,cocFinalDate=? WHERE stackNumber=?");
      $sql->bind_param("ssss",$positive,$finalTime,$finalDate,$stackNumber);
      
      if($sql->execute()){
$userId = $_POST['userId'];
            $respFileMessage = $con->query("SELECT * FROM tbl_users WHERE userID='$userId'");
             $rowFileMessage=$respFileMessage->fetch_array();
             $file = "CERTIFICATE OF CONFORMITY";
             $cocNumber = $_POST['cocNumber'];
             $postDateFormat=date("y:m:d",time()); 
             $mergeDate="20";
             $postTime=date("h:i A.",time());
             $postDate=$mergeDate."".$postDateFormat;
            $userMessage=$rowFileMessage['userName'];
            $action1="edited COC document No.";
            $action2="of file No.";
            $action3="owned by";
            // select bol information to prove if file was instantiated with bol file
    $stmt_select_owner = $DB_con->prepare('SELECT fileOwner FROM tbl_stacks WHERE stackNumber=:stack');
    $stmt_select_owner->execute(array(':stack'=>$stackNumber));
    $bolSelect=$stmt_select_owner->fetch(PDO::FETCH_ASSOC);//retursn value as associative array.
    $fileOwner=$bolSelect['fileOwner'];
            $on="on";
            $postDateTime=$postDate." ".$postTime;
            $message=$userMessage." ".$action1."".$cocNumber." ".$action2."".$stackNumber." ".$action3." ".$fileOwner." ".$on." ".$postDateTime;
             $sqlMessage = $con->prepare("INSERT INTO tbl_notifications(userName,stackNumber,file,message,postDate,postTime) VALUES(?,?,?,?,?,?)");

          
            $sqlMessage->bind_param('isssss',$userMessage,$stackNumber,$file,$message,$postDate,$postTime);
            if(!$sqlMessage){
              echo $con->error;
            }elseif ($sqlMessage->execute()) {
$messagee=$userMessage." ".$action1."".$cocNumber." ".$action2."".$stackNumber." ".$action3." ".$fileOwner." ".$on." ".$postDateTime;
require_once __DIR__ . '/vendor/autoload.php';

$basic  = new \Nexmo\Client\Credentials\Basic('4b81b8cc', 'BeoRcrJpN2IjeCR3');
$client = new \Nexmo\Client($basic);

$message = $client->message()->send([
    'to' => 254795511728,
    'from' => 'Kimatia',
    'text' =>  $messagee
]);

// var_dump($message->getResponseData());

            }
      }else{
         echo "<div class='alert alert-danger'>
              <button class='close' data-dismiss='alert'>&times;</button>
              <strong>Error!</strong>.File not Uploaded</div>";
      }
      $file = "coc";
      $postTime=date("h:i A.",time());
      $postDate=date("d:m:y",time());
      $updateData = "Yes";
      $SQL = $con->prepare("INSERT INTO tbl_logs(userId,stackNumber,file, postTime,postDate,updateData) VALUES(?,?,?,?,?,?)");


          $SQL->bind_param('isssss',$userId,$stackNumber,$file,$postTime,$postDate,$updateData);
          $SQL->execute();
          if(!$SQL){
            echo $con->error;
          }

      if(!$sql)
      {
       echo $con->error;
      }


      move_uploaded_file($sourcePath,$targetPath) ; // Moving Uploaded file
      echo "<div class='alert alert-success'>
              <button class='close' data-dismiss='alert'>&times;</button>
              <strong>Success!</strong>.File Uploaded</div>";

    }

  }
  }
  else
  {
  echo "<div class='alert alert-danger'>
          <button class='close' data-dismiss='alert'>&times;</button>
          <strong>Sorry!</strong>Invalid file Size or Type
           </div>";
  }
  }

}elseif($_SESSION['editfile']==$ECert){

  if(isset($_FILES["file"]["type"]))
  {
  $validextensions = array("jpeg", "jpg", "png", "JPEG", "JPG", "PNG");
  $temporary = explode(".", $_FILES["file"]["name"]);
  $file_extension = end($temporary);
  if ((($_FILES["file"]["type"] == "image/png") || ($_FILES["file"]["type"] == "image/JPG") || ($_FILES["file"]["type"] == "image/jpeg")
  ) && ($_FILES["file"]["size"] < 10000000)//Approx. 100000=100kb files can be uploaded.
  && in_array($file_extension, $validextensions)) {
  if ($_FILES["file"]["error"] > 0)
  {
  echo "Return Code: " . $_FILES["file"]["error"] . "<br/><br/>";
  }
  else
  {
  $sourcePath = $_FILES['file']['tmp_name']; // Storing source path of the file in a variable
  $targetPath = "upload/".$_FILES['file']['name']; // Target path where file is to be stored
   
        $postDateFormat=date("y:m:d",time()); 
        $mergeDate="20";
        $postTime=date("h:i A.",time());
        $postDate=$mergeDate."".$postDateFormat;
  $ecertNumber = $_POST['ecertNumber'];
  $stackNumber = $_POST['stackNumber'];
  $userId = $_POST['userId'];
  $ecert_file=$_FILES["file"]["name"];

  $SQL = $con->prepare("UPDATE tbl_ecert set  ecertNo=?, ecert_file=?,userId=?, postTime=?,postDate=? where stackNumber=? ");

    if($SQL){
      $SQL->bind_param('ssisss',$ecertNumber, $ecert_file, $userId,$postTime,$postDate,$stackNumber);
    
  if($SQL->execute()){
$userId = $_POST['userId'];
            $respFileMessage = $con->query("SELECT * FROM tbl_users WHERE userID='$userId'");
             $rowFileMessage=$respFileMessage->fetch_array();
             $file = "EXPORT CERTIFICATE";
             $ecertNumber = $_POST['ecertNumber'];
             $postDateFormat=date("y:m:d",time()); 
             $mergeDate="20";
             $postTime=date("h:i A.",time());
             $postDate=$mergeDate."".$postDateFormat;
            $userMessage=$rowFileMessage['userName'];
            $action1="edited Export Certificate document No.";
            $action2="of file No.";
            $action3="owned by";
            // select bol information to prove if file was instantiated with bol file
    $stmt_select_owner = $DB_con->prepare('SELECT fileOwner FROM tbl_stacks WHERE stackNumber=:stack');
    $stmt_select_owner->execute(array(':stack'=>$stackNumber));
    $bolSelect=$stmt_select_owner->fetch(PDO::FETCH_ASSOC);//retursn value as associative array.
    $fileOwner=$bolSelect['fileOwner'];
            $on="on";
            $postDateTime=$postDate." ".$postTime;
            $message=$userMessage." ".$action1."".$ecertNumber." ".$action2."".$stackNumber." ".$action3." ".$fileOwner." ".$on." ".$postDateTime;
             $sqlMessage = $con->prepare("INSERT INTO tbl_notifications(userName,stackNumber,file,message,postDate,postTime) VALUES(?,?,?,?,?,?)");

          
            $sqlMessage->bind_param('isssss',$userMessage,$stackNumber,$file,$message,$postDate,$postTime);
            if(!$sqlMessage){
              echo $con->error;
            }elseif ($sqlMessage->execute()) {
$messagee=$userMessage." ".$action1."".$ecertNumber." ".$action2."".$stackNumber." ".$action3." ".$fileOwner." ".$on." ".$postDateTime;
require_once __DIR__ . '/vendor/autoload.php';

$basic  = new \Nexmo\Client\Credentials\Basic('4b81b8cc', 'BeoRcrJpN2IjeCR3');
$client = new \Nexmo\Client($basic);

$message = $client->message()->send([
    'to' => 254795511728,
    'from' => 'Kimatia',
    'text' =>  $messagee
]);

// var_dump($message->getResponseData());

            }
  }
        $finalDateFormat=date("y:m:d",time()); 
        $mergeDate="20";
       $finalTime=date("h:i A.",time());
        $finalDate=$mergeDate."".$finalDateFormat;
      $positive = "Yes";
      $sql = $con->prepare("UPDATE tbl_stacks SET ecert=?,ecertFinalTime=?,ecertFinalDate=? WHERE stackNumber=?");
      $sql->bind_param("ssss",$positive,$finalTime,$finalDate,$stackNumber);
      $sql->execute();
      if(!$sql)
      {
       echo $con->error;
      }


      $file = "ecert";
      $postTime=date("h:i A.",time());
      $postDate=date("d:m:y",time());
      $updateData = "Yes";
      $SQL = $con->prepare("INSERT INTO tbl_logs(userId,stackNumber,file, postTime,postDate,updateData) VALUES(?,?,?,?,?,?)");


          $SQL->bind_param('isssss',$userId,$stackNumber,$file,$postTime,$postDate,$updateData);
          $SQL->execute();
          if(!$SQL){
            echo $con->error;
          }

      move_uploaded_file($sourcePath,$targetPath) ; // Moving Uploaded file
      echo "<div class='alert alert-success'>
              <button class='close' data-dismiss='alert'>&times;</button>
              <strong>Success!</strong>.File Uploaded</div>";
    }else{
      echo $con->error;
    }

  }
  }
  else
  {
  echo "<div class='alert alert-danger'>
          <button class='close' data-dismiss='alert'>&times;</button>
          <strong>Sorry!</strong>Invalid file Size or Type
           </div>";
  }
  }

}elseif($_SESSION['editfile']==$Invoice){


  if(isset($_FILES["file"]["type"]))
  {
  $validextensions = array("jpeg", "jpg", "png", "JPEG", "JPG", "PNG");
  $temporary = explode(".", $_FILES["file"]["name"]);
  $file_extension = end($temporary);
  if ((($_FILES["file"]["type"] == "image/png") || ($_FILES["file"]["type"] == "image/JPG") || ($_FILES["file"]["type"] == "image/jpeg")
  ) && ($_FILES["file"]["size"] < 10000000)//Approx. 100000=100kb files can be uploaded.
  && in_array($file_extension, $validextensions)) {
  if ($_FILES["file"]["error"] > 0)
  {
  echo "Return Code: " . $_FILES["file"]["error"] . "<br/><br/>";
  }
  else
  {
  $sourcePath = $_FILES['file']['tmp_name']; // Storing source path of the file in a variable
  $targetPath = "upload/".$_FILES['file']['name']; // Target path where file is to be stored

  $invoiceNumber = $_POST['invoiceNumber'];
  $stackNumber = $_POST['stackNumber'];
  $userId = $_POST['userId'];
  $invoice_file=$_FILES["file"]["name"];
   
        $postDateFormat=date("y:m:d",time()); 
        $mergeDate="20";
        $postTime=date("h:i A.",time());
        $postDate=$mergeDate."".$postDateFormat;
  $SQL = $con->prepare("UPDATE tbl_invoice set  invoiceNo=?, invoice_file=?,userId=?, postTime=?,postDate=? where stackNumber=? ");

      $SQL->bind_param('ssisss',$invoiceNumber, $invoice_file, $userId,$postTime,$postDate, $stackNumber);
      if($SQL->execute()){

  $userId = $_POST['userId'];
            $respFileMessage = $con->query("SELECT * FROM tbl_users WHERE userID='$userId'");
             $rowFileMessage=$respFileMessage->fetch_array();
             $file = "INVOICE";
             $invoiceNumber = $_POST['invoiceNumber'];
             $postDateFormat=date("y:m:d",time()); 
             $mergeDate="20";
             $postTime=date("h:i A.",time());
             $postDate=$mergeDate."".$postDateFormat;
            $userMessage=$rowFileMessage['userName'];
            $action1="edited Invoice document No.";
            $action2="of file No.";
            $action3="owned by";
            // select bol information to prove if file was instantiated with bol file
    $stmt_select_owner = $DB_con->prepare('SELECT fileOwner FROM tbl_stacks WHERE stackNumber=:stack');
    $stmt_select_owner->execute(array(':stack'=>$stackNumber));
    $bolSelect=$stmt_select_owner->fetch(PDO::FETCH_ASSOC);//retursn value as associative array.
    $fileOwner=$bolSelect['fileOwner'];
            $on="on";
            $postDateTime=$postDate." ".$postTime;
            $message=$userMessage." ".$action1."".$invoiceNumber." ".$action2."".$stackNumber." ".$action3." ".$fileOwner." ".$on." ".$postDateTime;
             $sqlMessage = $con->prepare("INSERT INTO tbl_notifications(userName,stackNumber,file,message,postDate,postTime) VALUES(?,?,?,?,?,?)");

          
            $sqlMessage->bind_param('isssss',$userMessage,$stackNumber,$file,$message,$postDate,$postTime);
            if(!$sqlMessage){
              echo $con->error;
            }elseif ($sqlMessage->execute()) {
$messagee=$userMessage." ".$action1."".$invoiceNumber." ".$action2."".$stackNumber." ".$action3." ".$fileOwner." ".$on." ".$postDateTime;
require_once __DIR__ . '/vendor/autoload.php';

$basic  = new \Nexmo\Client\Credentials\Basic('4b81b8cc', 'BeoRcrJpN2IjeCR3');
$client = new \Nexmo\Client($basic);

$message = $client->message()->send([
    'to' => 254795511728,
    'from' => 'Kimatia',
    'text' =>  $messagee
]);

// var_dump($message->getResponseData());

            }
        $finalDateFormat=date("y:m:d",time()); 
        $mergeDate="20";
       $finalTime=date("h:i A.",time());
        $finalDate=$mergeDate."".$finalDateFormat;
      $positive = "Yes";
      $sql = $con->prepare("UPDATE tbl_stacks SET invoice=?,invoiceFinalTime=?,invoiceFinalDate=? WHERE stackNumber=?");
      $sql->bind_param("ssss",$positive,$finalTime,$finalDate,$stackNumber);
      $sql->execute();
      if(!$sql)
      {
       echo $con->error;
      }


      $file = "invoice";
      $postTime=date("h:i A.",time());
      $postDate=date("d:m:y",time());
      $updateData = "Yes";
      $SQL = $con->prepare("INSERT INTO tbl_logs(userId,stackNumber,file, postTime,postDate,updateData) VALUES(?,?,?,?,?,?)");


          $SQL->bind_param('isssss',$userId,$stackNumber,$file,$postTime,$postDate,$updateData);
          $SQL->execute();
          if(!$SQL){
            echo $con->error;
          }

      move_uploaded_file($sourcePath,$targetPath) ; // Moving Uploaded file
      echo "<div class='alert alert-success'>
              <button class='close' data-dismiss='alert'>&times;</button>
              <strong>Success!</strong>.File Uploaded</div>";
    }else{
      echo $con->error;
    }

  }
  }
  else
  {
  echo "<div class='alert alert-danger'>
          <button class='close' data-dismiss='alert'>&times;</button>
          <strong>Sorry!</strong>Invalid file Size or Type
           </div>";
  }
  }


}elseif($_SESSION['editfile']==$TReciept){


  if(isset($_FILES["file"]["type"]))
  {
  $validextensions = array("jpeg", "jpg", "png", "JPEG", "JPG", "PNG");
  $temporary = explode(".", $_FILES["file"]["name"]);
  $file_extension = end($temporary);
  if ((($_FILES["file"]["type"] == "image/png") || ($_FILES["file"]["type"] == "image/JPG") || ($_FILES["file"]["type"] == "image/jpeg")
  ) && ($_FILES["file"]["size"] < 10000000)//Approx. 100000=100kb files can be uploaded.
  && in_array($file_extension, $validextensions)) {
  if ($_FILES["file"]["error"] > 0)
  {
  echo "Return Code: " . $_FILES["file"]["error"] . "<br/><br/>";
  }
  else
  {
  $sourcePath = $_FILES['file']['tmp_name']; // Storing source path of the file in a variable
  $targetPath = "upload/".$_FILES['file']['name']; // Target path where file is to be stored

  $trecieptNumber = $_POST['trecieptNumber'];
  $stackNumber = $_POST['stackNumber'];
  $userId = $_POST['userId'];
  $treciept_file=$_FILES["file"]["name"];
   
        $postDateFormat=date("y:m:d",time()); 
        $mergeDate="20";
        $postTime=date("h:i A.",time());
        $postDate=$mergeDate."".$postDateFormat;
  $SQL = $con->prepare("UPDATE tbl_treciept set  trecieptNo=?, treciept_file=?,userId=?, postTime=?,postDate=? where stackNumber=? ");

   
      $SQL->bind_param('ssisss',$trecieptNumber, $treciept_file, $userId,$postTime,$postDate,$stackNumber);
      if($SQL->execute()){
  $userId = $_POST['userId'];
            $respFileMessage = $con->query("SELECT * FROM tbl_users WHERE userID='$userId'");
             $rowFileMessage=$respFileMessage->fetch_array();
             $file = "KRA RECEIPT";
             $trecieptNumber = $_POST['trecieptNumber'];
             $postDateFormat=date("y:m:d",time()); 
             $mergeDate="20";
             $postTime=date("h:i A.",time());
             $postDate=$mergeDate."".$postDateFormat;
            $userMessage=$rowFileMessage['userName'];
            $action1="edited KRA Receipt document No.";
            $action2="of file No.";
            $action3="owned by";
            // select bol information to prove if file was instantiated with bol file
    $stmt_select_owner = $DB_con->prepare('SELECT fileOwner FROM tbl_stacks WHERE stackNumber=:stack');
    $stmt_select_owner->execute(array(':stack'=>$stackNumber));
    $bolSelect=$stmt_select_owner->fetch(PDO::FETCH_ASSOC);//retursn value as associative array.
    $fileOwner=$bolSelect['fileOwner'];
            $on="on";
            $postDateTime=$postDate." ".$postTime;
            $message=$userMessage." ".$action1."".$trecieptNumber." ".$action2."".$stackNumber." ".$action3." ".$fileOwner." ".$on." ".$postDateTime;
             $sqlMessage = $con->prepare("INSERT INTO tbl_notifications(userName,stackNumber,file,message,postDate,postTime) VALUES(?,?,?,?,?,?)");

          
            $sqlMessage->bind_param('isssss',$userMessage,$stackNumber,$file,$message,$postDate,$postTime);
            if(!$sqlMessage){
              echo $con->error;
            }elseif ($sqlMessage->execute()) {
$messagee=$userMessage." ".$action1."".$trecieptNumber." ".$action2."".$stackNumber." ".$action3." ".$fileOwner." ".$on." ".$postDateTime;
require_once __DIR__ . '/vendor/autoload.php';

$basic  = new \Nexmo\Client\Credentials\Basic('4b81b8cc', 'BeoRcrJpN2IjeCR3');
$client = new \Nexmo\Client($basic);

$message = $client->message()->send([
    'to' => 254795511728,
    'from' => 'Kimatia',
    'text' =>  $messagee
]);

// var_dump($message->getResponseData());

            }
        $finalDateFormat=date("y:m:d",time()); 
        $mergeDate="20";
       $finalTime=date("h:i A.",time());
        $finalDate=$mergeDate."".$finalDateFormat;
      $positive = "Yes";
      $sql = $con->prepare("UPDATE tbl_stacks SET treciept=?,trecieptFinalTime=?,trecieptFinalDate=? WHERE stackNumber=?");
      $sql->bind_param("ssss",$positive,$finalTime,$finalDate,$stackNumber);
      $sql->execute();
      if(!$sql)
      {
       echo $con->error;
      }

      $file = "treciept";
      $postTime=date("h:i A.",time());
      $postDate=date("d:m:y",time());
      $updateData = "Yes";
      $SQL = $con->prepare("INSERT INTO tbl_logs(userId,stackNumber,file, postTime,postDate,updateData) VALUES(?,?,?,?,?,?)");


          $SQL->bind_param('isssss',$userId,$stackNumber,$file,$postTime,$postDate,$updateData);
          $SQL->execute();
          if(!$SQL){
            echo $con->error;
          }

      move_uploaded_file($sourcePath,$targetPath) ; // Moving Uploaded file
      echo "<div class='alert alert-success'>
              <button class='close' data-dismiss='alert'>&times;</button>
              <strong>Success!</strong>.File Uploaded</div>";
    }else{
      echo $con->error;
    }

  }
  }
  else
  {
  echo "<div class='alert alert-danger'>
          <button class='close' data-dismiss='alert'>&times;</button>
          <strong>Sorry!</strong>Invalid file Size or Type
           </div>";
  }
  }

}elseif($_SESSION['editfile']==$Quadruplicate){


  if(isset($_FILES["file"]["type"]))
  {
  $validextensions = array("jpeg", "jpg", "png", "JPEG", "JPG", "PNG");
  $temporary = explode(".", $_FILES["file"]["name"]);
  $file_extension = end($temporary);
  if ((($_FILES["file"]["type"] == "image/png") || ($_FILES["file"]["type"] == "image/JPG") || ($_FILES["file"]["type"] == "image/jpeg")
  ) && ($_FILES["file"]["size"] < 10000000)//Approx. 100000=100kb files can be uploaded.
  && in_array($file_extension, $validextensions)) {
  if ($_FILES["file"]["error"] > 0)
  {
  echo "Return Code: " . $_FILES["file"]["error"] . "<br/><br/>";
  }
  else
  {
  $sourcePath = $_FILES['file']['tmp_name']; // Storing source path of the file in a variable
  $targetPath = "upload/".$_FILES['file']['name']; // Target path where file is to be stored

  $quadruplicateNumber = $_POST['quadruplicateNumber'];
  $stackNumber = $_POST['stackNumber'];
  $userId = $_POST['userId'];
  $quadruplicate_file=$_FILES["file"]["name"];
   
        $postDateFormat=date("y:m:d",time()); 
        $mergeDate="20";
        $postTime=date("h:i A.",time());
        $postDate=$mergeDate."".$postDateFormat;
  $SQL = $con->prepare("UPDATE tbl_quadruplicate set  quadruplicateNo=?, quadruplicate_file=?,userId=?, postTime=?,postDate=? where stackNumber=? ");

  
      $SQL->bind_param('ssisss',$quadruplicateNumber, $quadruplicate_file, $userId,$postTime,$postDate,$stackNumber);
      if($SQL->execute()){
$userId = $_POST['userId'];
            $respFileMessage = $con->query("SELECT * FROM tbl_users WHERE userID='$userId'");
             $rowFileMessage=$respFileMessage->fetch_array();
             $file = "QUADRUPLICATE";
             $quadruplicateNumber = $_POST['quadruplicateNumber'];
             $postDateFormat=date("y:m:d",time()); 
             $mergeDate="20";
             $postTime=date("h:i A.",time());
             $postDate=$mergeDate."".$postDateFormat;
            $userMessage=$rowFileMessage['userName'];
            $action1="edited Quadruplicate document No.";
            $action2="of file No.";
            $action3="owned by";
            // select bol information to prove if file was instantiated with bol file
    $stmt_select_owner = $DB_con->prepare('SELECT fileOwner FROM tbl_stacks WHERE stackNumber=:stack');
    $stmt_select_owner->execute(array(':stack'=>$stackNumber));
    $bolSelect=$stmt_select_owner->fetch(PDO::FETCH_ASSOC);//retursn value as associative array.
    $fileOwner=$bolSelect['fileOwner'];
            $on="on";
            $postDateTime=$postDate." ".$postTime;
            $message=$userMessage." ".$action1."".$quadruplicateNumber." ".$action2."".$stackNumber." ".$action3." ".$fileOwner." ".$on." ".$postDateTime;
             $sqlMessage = $con->prepare("INSERT INTO tbl_notifications(userName,stackNumber,file,message,postDate,postTime) VALUES(?,?,?,?,?,?)");

          
            $sqlMessage->bind_param('isssss',$userMessage,$stackNumber,$file,$message,$postDate,$postTime);
            if(!$sqlMessage){
              echo $con->error;
            }elseif ($sqlMessage->execute()) {
$messagee=$userMessage." ".$action1."".$quadruplicateNumber." ".$action2."".$stackNumber." ".$action3." ".$fileOwner." ".$on." ".$postDateTime;
require_once __DIR__ . '/vendor/autoload.php';

$basic  = new \Nexmo\Client\Credentials\Basic('4b81b8cc', 'BeoRcrJpN2IjeCR3');
$client = new \Nexmo\Client($basic);

$message = $client->message()->send([
    'to' => 254795511728,
    'from' => 'Kimatia',
    'text' =>  $messagee
]);

// var_dump($message->getResponseData());

            }
  
        $finalDateFormat=date("y:m:d",time()); 
        $mergeDate="20";
       $finalTime=date("h:i A.",time());
        $finalDate=$mergeDate."".$finalDateFormat;
      $positive = "Yes";
      $sql = $con->prepare("UPDATE tbl_stacks SET quadruplicate=?,quadruplicateFinalTime=?,quadruplicateFinalDate=? WHERE stackNumber=?");
      $sql->bind_param("ssss",$positive,$finalTime,$finalDate,$stackNumber);
      $sql->execute();
      if(!$sql)
      {
       echo $con->error;
      }


      $file = "quadruplicate";
      $postTime=date("h:i A.",time());
      $postDate=date("d:m:y",time());
      $updateData = "Yes";
      $SQL = $con->prepare("INSERT INTO tbl_logs(userId,stackNumber,file, postTime,postDate,updateData) VALUES(?,?,?,?,?,?)");


          $SQL->bind_param('isssss',$userId,$stackNumber,$file,$postTime,$postDate,$updateData);
          $SQL->execute();
          if(!$SQL){
            echo $con->error;
          }

      move_uploaded_file($sourcePath,$targetPath) ; // Moving Uploaded file
      echo "<div class='alert alert-success'>
              <button class='close' data-dismiss='alert'>&times;</button>
              <strong>Success!</strong>.File Uploaded</div>";
    }else{
      echo $con->error;
    }

  }
  }
  else
  {
  echo "<div class='alert alert-danger'>
          <button class='close' data-dismiss='alert'>&times;</button>
          <strong>Sorry!</strong>Invalid file Size or Type
           </div>";
  }
  }

}elseif($_SESSION['editfile']==$LBook){


  if(isset($_FILES["file"]["type"]))
  {
  $validextensions = array("jpeg", "jpg", "png", "JPEG", "JPG", "PNG");
  $temporary = explode(".", $_FILES["file"]["name"]);
  $file_extension = end($temporary);
  if ((($_FILES["file"]["type"] == "image/png") || ($_FILES["file"]["type"] == "image/JPG") || ($_FILES["file"]["type"] == "image/jpeg")
  ) && ($_FILES["file"]["size"] < 10000000)//Approx. 100000=100kb files can be uploaded.
  && in_array($file_extension, $validextensions)) {
  if ($_FILES["file"]["error"] > 0)
  {
  echo "Return Code: " . $_FILES["file"]["error"] . "<br/><br/>";
  }
  else
  {
  $sourcePath = $_FILES['file']['tmp_name']; // Storing source path of the file in a variable
  $targetPath = "upload/".$_FILES['file']['name']; // Target path where file is to be stored

  $lbookNumber = $_POST['lbookNumber'];
  $stackNumber = $_POST['stackNumber'];
  $userId = $_POST['userId'];
  $lbook_file=$_FILES["file"]["name"];
   
        $postDateFormat=date("y:m:d",time()); 
        $mergeDate="20";
        $postTime=date("h:i A.",time());
        $postDate=$mergeDate."".$postDateFormat;
  $SQL = $con->prepare("UPDATE tbl_lbook set  lbookNo=?, lbook_file=?,userId=?, postTime=?,postDate=? where stackNumber=? ");

   
      $SQL->bind_param('ssisss',$lbookNumber, $lbook_file, $userId,$postTime,$postDate, $stackNumber);
      if($SQL->execute()){
$userId = $_POST['userId'];
            $respFileMessage = $con->query("SELECT * FROM tbl_users WHERE userID='$userId'");
             $rowFileMessage=$respFileMessage->fetch_array();
             $file = "LOG BOOK";
             $lbookNumber = $_POST['lbookNumber'];
             $postDateFormat=date("y:m:d",time()); 
             $mergeDate="20";
             $postTime=date("h:i A.",time());
             $postDate=$mergeDate."".$postDateFormat;
            $userMessage=$rowFileMessage['userName'];
            $action1="edited Log Book document No.";
            $action2="of file No.";
            $action3="owned by";
            // select bol information to prove if file was instantiated with bol file
    $stmt_select_owner = $DB_con->prepare('SELECT fileOwner FROM tbl_stacks WHERE stackNumber=:stack');
    $stmt_select_owner->execute(array(':stack'=>$stackNumber));
    $bolSelect=$stmt_select_owner->fetch(PDO::FETCH_ASSOC);//retursn value as associative array.
    $fileOwner=$bolSelect['fileOwner'];
            $on="on";
            $postDateTime=$postDate." ".$postTime;
            $message=$userMessage." ".$action1."".$lbookNumber." ".$action2."".$stackNumber." ".$action3." ".$fileOwner." ".$on." ".$postDateTime;
             $sqlMessage = $con->prepare("INSERT INTO tbl_notifications(userName,stackNumber,file,message,postDate,postTime) VALUES(?,?,?,?,?,?)");

          
            $sqlMessage->bind_param('isssss',$userMessage,$stackNumber,$file,$message,$postDate,$postTime);
            if(!$sqlMessage){
              echo $con->error;
            }elseif ($sqlMessage->execute()) {
$messagee=$userMessage." ".$action1."".$lbookNumber." ".$action2."".$stackNumber." ".$action3." ".$fileOwner." ".$on." ".$postDateTime;
require_once __DIR__ . '/vendor/autoload.php';

$basic  = new \Nexmo\Client\Credentials\Basic('4b81b8cc', 'BeoRcrJpN2IjeCR3');
$client = new \Nexmo\Client($basic);

$message = $client->message()->send([
    'to' => 254795511728,
    'from' => 'Kimatia',
    'text' =>  $messagee
]);

// var_dump($message->getResponseData());

            }
  
        $finalDateFormat=date("y:m:d",time()); 
        $mergeDate="20";
       $finalTime=date("h:i A.",time());
        $finalDate=$mergeDate."".$finalDateFormat;
      $positive = "Yes";
      $sql = $con->prepare("UPDATE tbl_stacks SET lbook=?,lbookFinalTime=?,lbookFinalDate=? WHERE stackNumber=?");
      $sql->bind_param("ssss",$positive,$finalTime,$finalDate,$stackNumber);
      $sql->execute();
      if(!$sql)
      {
       echo $con->error;
      }


      $file = "lbook";
      $postTime=date("h:i A.",time());
      $postDate=date("d:m:y",time());
      $updateData = "Yes";
      $SQL = $con->prepare("INSERT INTO tbl_logs(userId,stackNumber,file, postTime,postDate,updateData) VALUES(?,?,?,?,?,?)");


          $SQL->bind_param('isssss',$userId,$stackNumber,$file,$postTime,$postDate,$updateData);
          $SQL->execute();
          if(!$SQL){
            echo $con->error;
          }

      move_uploaded_file($sourcePath,$targetPath) ; // Moving Uploaded file
      echo "<div class='alert alert-success'>
            <button class='close' data-dismiss='alert'>&times;</button>
            <strong>Success!</strong>.File Uploaded</div>";
    }else{
      echo $con->error;
    }

  }
  }
  else
  {
  echo "<div class='alert alert-danger'>
          <button class='close' data-dismiss='alert'>&times;</button>
          <strong>Sorry!</strong>Invalid file Size or Type
           </div>";
  }
  }
}

?>
