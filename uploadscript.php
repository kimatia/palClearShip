<?php

date_default_timezone_set("Africa/Nairobi");
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once 'dbconfig.php';
if (isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST") {
//get the logged in user credentials and validate
require_once 'class.user.php';
$user_home = new USER();

if(!$user_home->is_logged_in())
{
 $user_home->redirect('login.php');
}

$stmt = $user_home->runQuery("SELECT * FROM tbl_users WHERE userID=:uid");
$stmt->execute(array(":uid"=>$_SESSION['userSession']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
//we can now access the users details from $row['appropriatedbfield']
$number=$row['userPhone'];

$BOL = $_POST['file'];
$IDF = $_POST['file'];
$KBS = $_POST['file'];
$ECert = $_POST['file'];
$Invoice = $_POST['file'];
$TReciept = $_POST['file'];
$Quadruplicate = $_POST['file'];
$LBook = $_POST['file'];
$Coc=$_POST['file'];
  if($_POST['file']=="BOL"){
       $path = "upload/"; //set your folder path
    //set the valid file extensions 
    $valid_formats = array("jpg", "png", "gif", "bmp", "jpeg", "GIF", "JPG", "PNG", "doc", "txt", "docx", "pdf", "xls", "xlsx"); //add the formats you want to upload

    $name = $_FILES['myfile']['name']; //get the name of the file
    
    $size = $_FILES['myfile']['size']; //get the size of the file

    if (strlen($name)) { //check if the file is selected or cancelled after pressing the browse button.
        list($txt, $ext) = explode(".", $name); //extract the name and extension of the file
        if (in_array($ext, $valid_formats)) { //if the file is valid go on.
            if ($size < 2098888) { // check if the file size is more than 2 mb
                $file_name = $_POST['filename']; //get the file name
                $tmp = $_FILES['myfile']['tmp_name'];

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
  $billofLading_file=$file_name.'.'.$ext;
  $SQL = $con->prepare("INSERT INTO tbl_billofLading(stackNumber, billofLadingNumber, shippername ,shipperadress ,shipperlocation ,consigneename ,consigneeadress ,consigneelocation,precariageBy,placeofReciept,vessel,voyno,loadingport,dischargeport,finalDestination, freightName,revenueTons,rate,per,prepaid,collect,markNumber,description,grossweight,measurement,packagesNo,freightPayable,numberOriginal,placeOfIssue,dateOfIssue ,billofLading_file, userId, postTime,postDate ) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

    if($SQL){
     $SQL->bind_param('ssssssssssssssssssssssssssssssssss',$stackNumber,$billofLadingNumber,$shippername ,$shipperadress  ,$shipperlocation ,$consigneename ,$consigneeadress ,$consigneelocation ,$precariageBy,$placeofReciept,$vessel,$voyno,$loadingport,$dischargeport,$finalDestination, $freightName, $revenueTons,$rate,$per,$prepaid,$collect,$markNumber,$description,$grossweight,$measurement,$packagesNo,$freightPayable,$numberOriginal,$placeOfIssue,$dateOfIssue ,$billofLading_file,$userId,$postTime,$postDate);
      if($SQL->execute()){
          if (move_uploaded_file($tmp, $path . $file_name.'.'.$ext)) { //check if it the file move successfully.
                    echo "File Uploaded";
                } else {
                    echo "failed";
                }
      }
        $finalDateFormat=date("y:m:d",time()); 
        $mergeDate="20";
        $finalTime=date("h:i A.",time());
        $finalDate=$mergeDate."".$finalDateFormat;
      $positive = "Yes";
      $sql = $con->prepare("UPDATE tbl_stacks SET bol=?,bolFinalTime=?,bolFinalDate=? WHERE stackNumber=?");
      $sql->bind_param("ssss",$positive,$finalTime,$finalDate,$stackNumber);
      $sql->execute();
      if(!$sql)
      {
       echo $con->error;
      }

      $file = "bol";
      $postDateFormat=date("y:m:d",time()); 
      $mergeDate="20";
      $postTime=date("h:i A.",time());
      $postDate=$mergeDate."".$postDateFormat;
      $SQL = $con->prepare("INSERT INTO tbl_logs(userId,stackNumber,file, postTime,postDate) VALUES(?,?,?,?,?)");
          $SQL->bind_param('issss',$userId,$stackNumber,$file,$postTime,$postDate);
          $SQL->execute();
          if(!$SQL){
            echo $con->error;
          }
          $userId = $_POST['userId'];
            $respFileMessage = $con->query("SELECT * FROM tbl_users WHERE userID='$userId'");
             $rowFileMessage=$respFileMessage->fetch_array();
             $file = "BILL OF LADING";
             $billofLadingNumber = $_POST['billofLadingNumber'];
             $postDateFormat=date("y:m:d",time()); 
             $mergeDate="20";
             $postTime=date("h:i A.",time());
             $postDate=$mergeDate."".$postDateFormat;
            $userMessage=$rowFileMessage['userName'];
            $action1="Lodging of new file No.";
            $action2=", file No.";
            $action3="owned by client";
            // select bol information to prove if file was instantiated with bol file
    $stmt_select_owner = $DB_con->prepare('SELECT fileOwner FROM tbl_stacks WHERE stackNumber=:stack');
    $stmt_select_owner->execute(array(':stack'=>$stackNumber));
    $bolSelect=$stmt_select_owner->fetch(PDO::FETCH_ASSOC);//retursn value as associative array.
    $fileOwner=$bolSelect['fileOwner'];
            $on="on";
            $postDateTime=$postDate." ".$postTime;
            $message=$action1." ".$stackNumber." ".$action3." ".$fileOwner." ".$on." ".$postDateTime;
             $sqlMessage = $con->prepare("INSERT INTO tbl_notifications(userName,stackNumber,file,message,postDate,postTime) VALUES(?,?,?,?,?,?)");
            $sqlMessage->bind_param('ssssss',$userMessage,$stackNumber,$file,$message,$postDate,$postTime);
            if(!$sqlMessage){
              echo $con->error;
            }elseif ($sqlMessage->execute()) {
$messagee=$action1." ".$stackNumber." ".$action3." ".$fileOwner." ".$on." ".$postDateTime;
require_once __DIR__ . '/vendor/autoload.php';
$messageFrom="PALM";
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
       $successMSG3 = "The message was sent successfully\n";
    } else {
        $errMSG3 = "The message failed with status: " . $response['messages'][0]['status'] . "\n";
    }
} catch (Exception $e) {
    $errMSG3 ="The message was not sent. Error: " . $e->getMessage() . "\n";
}
          }

  }
    else{
      echo $con->error;
    }   
            } else {
                echo "File size max 2 MB";
            }
        } else {
            echo "Invalid file format..";
        }
    } else {
        echo "Please select a file..!";
    }
    exit;
  }elseif($_POST['file']=='Coc'){
     $path = "upload/"; //set your folder path
    //set the valid file extensions 
    $valid_formats = array("jpg", "png", "gif", "bmp", "jpeg", "GIF", "JPG", "PNG", "doc", "txt", "docx", "pdf", "xls", "xlsx"); //add the formats you want to upload

    $name = $_FILES['myfile']['name']; //get the name of the file
    
    $size = $_FILES['myfile']['size']; //get the size of the file

    if (strlen($name)) { //check if the file is selected or cancelled after pressing the browse button.
        list($txt, $ext) = explode(".", $name); //extract the name and extension of the file
        if (in_array($ext, $valid_formats)) { //if the file is valid go on.
            if ($size < 2098888) { // check if the file size is more than 2 mb
                $file_name = $_POST['filename']; //get the file name
                $tmp = $_FILES['myfile']['tmp_name'];

  $cocNumber = $_POST['cocNumber'];
  $stackNumber = $_POST['stackNumber'];
  $userId = $_POST['userId'];
  $coc_file=$file_name.'.'.$ext;
  $postDateFormat=date("y:m:d",time());
  $mergeDate="20";
  $postTime=date("h:i A.",time());
  $postDate=$mergeDate."".$postDateFormat;
  $SQL = $con->prepare("INSERT INTO tbl_coc(stackNumber,cocNo, coc_file,userId, postTime,postDate) VALUES(?,?,?,?,?,?)");
 // select bol information to prove if file was instantiated with bol file
    $stmt_select = $DB_con->prepare('SELECT bol FROM tbl_stacks WHERE stackNumber=:stack');
    $stmt_select->execute(array(':stack'=>$stackNumber));
    $bolSelect=$stmt_select->fetch(PDO::FETCH_ASSOC);//retursn value as associative array.
    if($bolSelect['bol']=="No"){
      echo "<div class='alert alert-danger'>
              <button class='close' data-dismiss='alert'>&times;</button>
              <strong>Error!</strong>.Please insert Bill of Lading data first then proceed to Certificate of Conformity File.</div>";
    }elseif($bolSelect['bol']=="Yes"){
    if($SQL){
      $SQL->bind_param('sssiss',$stackNumber,$cocNumber, $coc_file, $userId,$postTime,$postDate);
      if($SQL->execute()){
          if (move_uploaded_file($tmp, $path . $file_name.'.'.$ext)) { //check if it the file move successfully.
                    echo "File Uploaded";
                } else {
                    echo "failed";
                }
      }
        $finalDateFormat=date("y:m:d",time()); 
        $mergeDate="20";
        $finalTime=date("h:i A.",time());
        $finalDate=$mergeDate."".$finalDateFormat;
      $positive = "Yes";
      $sql = $con->prepare("UPDATE tbl_stacks SET coc=?,cocFinalTime=?,cocFinalDate=? WHERE stackNumber=?");
      $sql->bind_param("ssss",$positive,$finalTime,$finalDate,$stackNumber);
      $sql->execute();
      if(!$sql)
      {
       echo $con->error;
      }

      $file = "coc";
  
      $postDateFormat=date("y:m:d",time()); 
      $mergeDate="20";
      $postTime=date("h:i A.",time());
      $postDate=$mergeDate."".$postDateFormat;
      $SQL = $con->prepare("INSERT INTO tbl_logs(userId,stackNumber,file, postTime,postDate) VALUES(?,?,?,?,?)");


          $SQL->bind_param('issss',$userId,$stackNumber,$file,$postTime,$postDate);
          $SQL->execute();
          if(!$SQL){
            echo $con->error;
          }
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
            $action1="posted COC document No.";
            $action2="of file No.";
            $action3="owned by client";
            // select bol information to prove if file was instantiated with bol file
    $stmt_select_owner = $DB_con->prepare('SELECT fileOwner FROM tbl_stacks WHERE stackNumber=:stack');
    $stmt_select_owner->execute(array(':stack'=>$stackNumber));
    $bolSelect=$stmt_select_owner->fetch(PDO::FETCH_ASSOC);//retursn value as associative array.
    $fileOwner=$bolSelect['fileOwner'];
            $on="on";
            $postDateTime=$postDate." ".$postTime;
            $message=$userMessage." ".$action1."".$cocNumber." ".$action2."".$stackNumber." ".$action3." ".$fileOwner." ".$on." ".$postDateTime;
             $sqlMessage = $con->prepare("INSERT INTO tbl_notifications(userName,stackNumber,file,message,postDate,postTime) VALUES(?,?,?,?,?,?)");

          
            $sqlMessage->bind_param('ssssss',$userMessage,$stackNumber,$file,$message,$postDate,$postTime);
            if(!$sqlMessage){
              echo $con->error;
            }elseif ($sqlMessage->execute()) {
$messagee=$userMessage." ".$action1."".$cocNumber." ".$action2."".$stackNumber." ".$action3." ".$fileOwner." ".$on." ".$postDateTime;
require_once __DIR__ . '/vendor/autoload.php';
$messageFrom="PALM";
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
       $successMSG3 = "The message was sent successfully\n";
    } else {
        $errMSG3 = "The message failed with status: " . $response['messages'][0]['status'] . "\n";
    }
} catch (Exception $e) {
    $errMSG3 ="The message was not sent. Error: " . $e->getMessage() . "\n";
}

// var_dump($message->getResponseData());

            }
    
    }

  }
    else{
      echo $con->error;
    }   
            } else {
                echo "File size max 2 MB";
            }
        } else {
            echo "Invalid file format..";
        }
    } else {
        echo "Please select a file..!";
    }
    exit;
}
elseif($_POST['file']=='IDF'){
  $path = "upload/"; //set your folder path
    //set the valid file extensions 
    $valid_formats = array("jpg", "png", "gif", "bmp", "jpeg", "GIF", "JPG", "PNG", "doc", "txt", "docx", "pdf", "xls", "xlsx"); //add the formats you want to upload

    $name = $_FILES['myfile']['name']; //get the name of the file
    
    $size = $_FILES['myfile']['size']; //get the size of the file

    if (strlen($name)) { //check if the file is selected or cancelled after pressing the browse button.
        list($txt, $ext) = explode(".", $name); //extract the name and extension of the file
        if (in_array($ext, $valid_formats)) { //if the file is valid go on.
            if ($size < 2098888) { // check if the file size is more than 2 mb
                $file_name = $_POST['filename']; //get the file name
                $tmp = $_FILES['myfile']['tmp_name'];

  $idfNumber = $_POST['idfNumber'];
  $stackNumber = $_POST['stackNumber'];
  $userId = $_POST['userId'];
  $idf_file=$file_name.'.'.$ext;
  $postDateFormat=date("y:m:d",time());
  $mergeDate="20";
  $postTime=date("h:i A.",time());
  $postDate=$mergeDate."".$postDateFormat;
  $SQL = $con->prepare("INSERT INTO tbl_idf(stackNumber,idfNo, idf_file,userId, postTime,postDate) VALUES(?,?,?,?,?,?)");
 // select bol information to prove if file was instantiated with bol file
    $stmt_select = $DB_con->prepare('SELECT bol FROM tbl_stacks WHERE stackNumber=:stack');
    $stmt_select->execute(array(':stack'=>$stackNumber));
    $bolSelect=$stmt_select->fetch(PDO::FETCH_ASSOC);//retursn value as associative array.
    if($bolSelect['bol']=="No"){
      echo "<div class='alert alert-danger'>
              <button class='close' data-dismiss='alert'>&times;</button>
              <strong>Error!</strong>.Please insert Bill of Lading data first then proceed to Import Declaration File.</div>";
    }elseif($bolSelect['bol']=="Yes"){
    if($SQL){
      $SQL->bind_param('sssiss',$stackNumber,$idfNumber, $idf_file, $userId,$postTime,$postDate);
      if($SQL->execute()){
          if (move_uploaded_file($tmp, $path . $file_name.'.'.$ext)) { //check if it the file move successfully.
                    echo "File Uploaded";
                } else {
                    echo "failed";
                }
      }
        $finalDateFormat=date("y:m:d",time()); 
        $mergeDate="20";
        $finalTime=date("h:i A.",time());
        $finalDate=$mergeDate."".$finalDateFormat;
      $positive = "Yes";
      $sql = $con->prepare("UPDATE tbl_stacks SET idf=?,idfFinalTime=?,idfFinalDate=? WHERE stackNumber=?");
      $sql->bind_param("ssss",$positive,$finalTime,$finalDate,$stackNumber);
      $sql->execute();
      if(!$sql)
      {
       echo $con->error;
      }

      $file = "idf";
      $postDateFormat=date("y:m:d",time()); 
      $mergeDate="20";
      $postTime=date("h:i A.",time());
      $postDate=$mergeDate."".$postDateFormat;
      $SQL = $con->prepare("INSERT INTO tbl_logs(userId,stackNumber,file, postTime,postDate) VALUES(?,?,?,?,?)");
          $SQL->bind_param('issss',$userId,$stackNumber,$file,$postTime,$postDate);
          $SQL->execute();
          if(!$SQL){
            echo $con->error;
          }
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
            $action1="Lodging IDF in file No.";
            $action2="of file No.";
            $action3="owned by client";
            // select bol information to prove if file was instantiated with bol file
    $stmt_select_owner = $DB_con->prepare('SELECT fileOwner FROM tbl_stacks WHERE stackNumber=:stack');
    $stmt_select_owner->execute(array(':stack'=>$stackNumber));
    $bolSelect=$stmt_select_owner->fetch(PDO::FETCH_ASSOC);//retursn value as associative array.
    $fileOwner=$bolSelect['fileOwner'];
            $on="on";
            $postDateTime=$postDate." ".$postTime;
            $message=$userMessage." ".$action1."".$stackNumber." ".$action3." ".$fileOwner." ".$on." ".$postDateTime;
             $sqlMessage = $con->prepare("INSERT INTO tbl_notifications(userName,stackNumber,file,message,postDate,postTime) VALUES(?,?,?,?,?,?)");

          
            $sqlMessage->bind_param('ssssss',$userMessage,$stackNumber,$file,$message,$postDate,$postTime);
            if(!$sqlMessage){
              echo $con->error;
            }elseif ($sqlMessage->execute()) {
$messagee=$userMessage." ".$action1."".$stackNumber." ".$action3." ".$fileOwner." ".$on." ".$postDateTime;
require_once __DIR__ . '/vendor/autoload.php';
$messageFrom="PALM";
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
       $successMSG3 = "The message was sent successfully\n";
    } else {
        $errMSG3 = "The message failed with status: " . $response['messages'][0]['status'] . "\n";
    }
} catch (Exception $e) {
    $errMSG3 ="The message was not sent. Error: " . $e->getMessage() . "\n";
}

// var_dump($message->getResponseData());

            }
    
    }

  }
    else{
      echo $con->error;
    }   
            } else {
                echo "File size max 2 MB";
            }
        } else {
            echo "Invalid file format..";
        }
    } else {
        echo "Please select a file..!";
    }
    exit;
}elseif($_POST['file']=="KBS"){
    $path = "upload/"; //set your folder path
    //set the valid file extensions 
    $valid_formats = array("jpg", "png", "gif", "bmp", "jpeg", "GIF", "JPG", "PNG", "doc", "txt", "docx", "pdf", "xls", "xlsx"); //add the formats you want to upload

    $name = $_FILES['myfile']['name']; //get the name of the file
    
    $size = $_FILES['myfile']['size']; //get the size of the file

    if (strlen($name)) { //check if the file is selected or cancelled after pressing the browse button.
        list($txt, $ext) = explode(".", $name); //extract the name and extension of the file
        if (in_array($ext, $valid_formats)) { //if the file is valid go on.
            if ($size < 2098888) { // check if the file size is more than 2 mb
                $file_name = $_POST['filename']; //get the file name
                $tmp = $_FILES['myfile']['tmp_name'];

  $kbsNumber = $_POST['kbsNumber'];
  $stackNumber = $_POST['stackNumber'];
  $userId = $_POST['userId'];
  $kbs_file=$file_name.'.'.$ext;
  $postDateFormat=date("y:m:d",time());
  $mergeDate="20";
  $postTime=date("h:i A.",time());
  $postDate=$mergeDate."".$postDateFormat;
  $SQL = $con->prepare("INSERT INTO tbl_kbs(stackNumber,kbsNo, kbs_file,userId, postTime,postDate) VALUES(?,?,?,?,?,?)");
 // select bol information to prove if file was instantiated with bol file
    $stmt_select = $DB_con->prepare('SELECT bol FROM tbl_stacks WHERE stackNumber=:stack');
    $stmt_select->execute(array(':stack'=>$stackNumber));
    $bolSelect=$stmt_select->fetch(PDO::FETCH_ASSOC);//retursn value as associative array.
    if($bolSelect['bol']=="No"){
      echo "<div class='alert alert-danger'>
              <button class='close' data-dismiss='alert'>&times;</button>
              <strong>Error!</strong>.Please insert Bill of Lading data first then proceed to Kenya Bureau Standards File.</div>";
    }elseif($bolSelect['bol']=="Yes"){
    if($SQL){
      $SQL->bind_param('sssiss',$stackNumber,$kbsNumber, $kbs_file, $userId,$postTime,$postDate);
      if($SQL->execute()){
          if (move_uploaded_file($tmp, $path . $file_name.'.'.$ext)) { //check if it the file move successfully.
                    echo "File Uploaded";
                } else {
                    echo "failed";
                }
      }
        $finalDateFormat=date("y:m:d",time()); 
        $mergeDate="20";
        $finalTime=date("h:i A.",time());
        $finalDate=$mergeDate."".$finalDateFormat;
      $positive = "Yes";
      $sql = $con->prepare("UPDATE tbl_stacks SET kbs=?,kbsFinalTime=?,kbsFinalDate=? WHERE stackNumber=?");
      $sql->bind_param("ssss",$positive,$finalTime,$finalDate,$stackNumber);
      $sql->execute();
      if(!$sql)
      {
       echo $con->error;
      }

      $file = "kbs";
      $postDateFormat=date("y:m:d",time()); 
      $mergeDate="20";
      $postTime=date("h:i A.",time());
      $postDate=$mergeDate."".$postDateFormat;
      $SQL = $con->prepare("INSERT INTO tbl_logs(userId,stackNumber,file, postTime,postDate) VALUES(?,?,?,?,?)");
          $SQL->bind_param('issss',$userId,$stackNumber,$file,$postTime,$postDate);
          $SQL->execute();
          if(!$SQL){
            echo $con->error;
          }
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
            $action1="posted KBS document No.";
            $action2="of file No.";
            $action3="owned by client";
            // select bol information to prove if file was instantiated with bol file
    $stmt_select_owner = $DB_con->prepare('SELECT fileOwner FROM tbl_stacks WHERE stackNumber=:stack');
    $stmt_select_owner->execute(array(':stack'=>$stackNumber));
    $bolSelect=$stmt_select_owner->fetch(PDO::FETCH_ASSOC);//retursn value as associative array.
    $fileOwner=$bolSelect['fileOwner'];
            $on="on";
            $postDateTime=$postDate." ".$postTime;
            $message=$userMessage." ".$action1."".$kbsNumber." ".$action2."".$stackNumber." ".$action3." ".$fileOwner." ".$on." ".$postDateTime;
             $sqlMessage = $con->prepare("INSERT INTO tbl_notifications(userName,stackNumber,file,message,postDate,postTime) VALUES(?,?,?,?,?,?)");
            $sqlMessage->bind_param('ssssss',$userMessage,$stackNumber,$file,$message,$postDate,$postTime);
            if(!$sqlMessage){
              echo $con->error;
            }elseif ($sqlMessage->execute()) {
$messagee=$userMessage." ".$action1."".$kbsNumber." ".$action2."".$stackNumber." ".$action3." ".$fileOwner." ".$on." ".$postDateTime;
require_once __DIR__ . '/vendor/autoload.php';
$messageFrom="PALM";
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
       $successMSG3 = "The message was sent successfully\n";
    } else {
        $errMSG3 = "The message failed with status: " . $response['messages'][0]['status'] . "\n";
    }
} catch (Exception $e) {
    $errMSG3 ="The message was not sent. Error: " . $e->getMessage() . "\n";
}
          }
    }

  }
    else{
      echo $con->error;
    }   
            } else {
                echo "File size max 2 MB";
            }
        } else {
            echo "Invalid file format..";
        }
    } else {
        echo "Please select a file..!";
    }
    exit;
}elseif($_POST['file']=="TReciept"){
     $path = "upload/"; //set your folder path
    //set the valid file extensions 
    $valid_formats = array("jpg", "png", "gif", "bmp", "jpeg", "GIF", "JPG", "PNG", "doc", "txt", "docx", "pdf", "xls", "xlsx"); //add the formats you want to upload

    $name = $_FILES['myfile']['name']; //get the name of the file
    
    $size = $_FILES['myfile']['size']; //get the size of the file

    if (strlen($name)) { //check if the file is selected or cancelled after pressing the browse button.
        list($txt, $ext) = explode(".", $name); //extract the name and extension of the file
        if (in_array($ext, $valid_formats)) { //if the file is valid go on.
            if ($size < 2098888) { // check if the file size is more than 2 mb
                $file_name = $_POST['filename']; //get the file name
                $tmp = $_FILES['myfile']['tmp_name'];

  $trecieptNumber = $_POST['trecieptNumber'];
  $stackNumber = $_POST['stackNumber'];
  $userId = $_POST['userId'];
  $treciept_file=$file_name.'.'.$ext;
  $postDateFormat=date("y:m:d",time());
  $mergeDate="20";
  $postTime=date("h:i A.",time());
  $postDate=$mergeDate."".$postDateFormat;
  $SQL = $con->prepare("INSERT INTO tbl_treciept(stackNumber,trecieptNo, treciept_file,userId, postTime,postDate) VALUES(?,?,?,?,?,?)");
 // select bol information to prove if file was instantiated with bol file
    $stmt_select = $DB_con->prepare('SELECT bol FROM tbl_stacks WHERE stackNumber=:stack');
    $stmt_select->execute(array(':stack'=>$stackNumber));
    $bolSelect=$stmt_select->fetch(PDO::FETCH_ASSOC);//retursn value as associative array.
    if($bolSelect['bol']=="No"){
      echo "<div class='alert alert-danger'>
              <button class='close' data-dismiss='alert'>&times;</button>
              <strong>Error!</strong>.Please insert Bill of Lading data first then proceed to Transaction Receipt File.</div>";
    }elseif($bolSelect['bol']=="Yes"){
    if($SQL){
      $SQL->bind_param('sssiss',$stackNumber,$trecieptNumber, $treciept_file, $userId,$postTime,$postDate);
      if($SQL->execute()){
          if (move_uploaded_file($tmp, $path . $file_name.'.'.$ext)) { //check if it the file move successfully.
                    echo "File Uploaded";
                } else {
                    echo "failed";
                }
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
      $postDateFormat=date("y:m:d",time()); 
      $mergeDate="20";
      $postTime=date("h:i A.",time());
      $postDate=$mergeDate."".$postDateFormat;
      $SQL = $con->prepare("INSERT INTO tbl_logs(userId,stackNumber,file, postTime,postDate) VALUES(?,?,?,?,?)");
          $SQL->bind_param('issss',$userId,$stackNumber,$file,$postTime,$postDate);
          $SQL->execute();
          if(!$SQL){
            echo $con->error;
          }
          $userId = $_POST['userId'];
            $respFileMessage = $con->query("SELECT * FROM tbl_users WHERE userID='$userId'");
             $rowFileMessage=$respFileMessage->fetch_array();
             $file = "TRANSACTION RECEIPT";
             $trecieptNumber = $_POST['trecieptNumber'];
             $postDateFormat=date("y:m:d",time()); 
             $mergeDate="20";
             $postTime=date("h:i A.",time());
             $postDate=$mergeDate."".$postDateFormat;
            $userMessage=$rowFileMessage['userName'];
            $action1="posted Transaction Receipt document No.";
            $action2="of file No.";
            $action3="owned by client";
            // select bol information to prove if file was instantiated with bol file
    $stmt_select_owner = $DB_con->prepare('SELECT fileOwner FROM tbl_stacks WHERE stackNumber=:stack');
    $stmt_select_owner->execute(array(':stack'=>$stackNumber));
    $bolSelect=$stmt_select_owner->fetch(PDO::FETCH_ASSOC);//retursn value as associative array.
    $fileOwner=$bolSelect['fileOwner'];
            $on="on";
            $postDateTime=$postDate." ".$postTime;
            $message=$userMessage." ".$action1."".$trecieptNumber." ".$action2."".$stackNumber." ".$action3." ".$fileOwner." ".$on." ".$postDateTime;
             $sqlMessage = $con->prepare("INSERT INTO tbl_notifications(userName,stackNumber,file,message,postDate,postTime) VALUES(?,?,?,?,?,?)");
            $sqlMessage->bind_param('ssssss',$userMessage,$stackNumber,$file,$message,$postDate,$postTime);
            if(!$sqlMessage){
              echo $con->error;
            }elseif ($sqlMessage->execute()) {
$messagee=$userMessage." ".$action1."".$trecieptNumber." ".$action2."".$stackNumber." ".$action3." ".$fileOwner." ".$on." ".$postDateTime;
require_once __DIR__ . '/vendor/autoload.php';
$messageFrom="PALM";
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
       $successMSG3 = "The message was sent successfully\n";
    } else {
        $errMSG3 = "The message failed with status: " . $response['messages'][0]['status'] . "\n";
    }
} catch (Exception $e) {
    $errMSG3 ="The message was not sent. Error: " . $e->getMessage() . "\n";
}
          }
    }

  }
    else{
      echo $con->error;
    }   
            } else {
                echo "File size max 2 MB";
            }
        } else {
            echo "Invalid file format..";
        }
    } else {
        echo "Please select a file..!";
    }
    exit;
}elseif($_POST['file']=="Invoice"){
  $path = "upload/"; //set your folder path
    //set the valid file extensions 
    $valid_formats = array("jpg", "png", "gif", "bmp", "jpeg", "GIF", "JPG", "PNG", "doc", "txt", "docx", "pdf", "xls", "xlsx"); //add the formats you want to upload

    $name = $_FILES['myfile']['name']; //get the name of the file
    
    $size = $_FILES['myfile']['size']; //get the size of the file

    if (strlen($name)) { //check if the file is selected or cancelled after pressing the browse button.
        list($txt, $ext) = explode(".", $name); //extract the name and extension of the file
        if (in_array($ext, $valid_formats)) { //if the file is valid go on.
            if ($size < 2098888) { // check if the file size is more than 2 mb
                $file_name = $_POST['filename']; //get the file name
                $tmp = $_FILES['myfile']['tmp_name'];

  $invoiceNumber = $_POST['invoiceNumber'];
  $stackNumber = $_POST['stackNumber'];
  $userId = $_POST['userId'];
  $invoice_file=$file_name.'.'.$ext;
  $postDateFormat=date("y:m:d",time());
  $mergeDate="20";
  $postTime=date("h:i A.",time());
  $postDate=$mergeDate."".$postDateFormat;
  $SQL = $con->prepare("INSERT INTO tbl_invoice(stackNumber,invoiceNo,  invoice_file,userId, postTime,postDate) VALUES(?,?,?,?,?,?)");
 // select bol information to prove if file was instantiated with bol file
    $stmt_select = $DB_con->prepare('SELECT bol FROM tbl_stacks WHERE stackNumber=:stack');
    $stmt_select->execute(array(':stack'=>$stackNumber));
    $bolSelect=$stmt_select->fetch(PDO::FETCH_ASSOC);//retursn value as associative array.
    if($bolSelect['bol']=="No"){
      echo "<div class='alert alert-danger'>
              <button class='close' data-dismiss='alert'>&times;</button>
              <strong>Error!</strong>.Please insert Bill of Lading data first then proceed to Invoice Form File.</div>";
    }elseif($bolSelect['bol']=="Yes"){
    if($SQL){
      $SQL->bind_param('sssiss',$stackNumber,$invoiceNumber, $invoice_file, $userId,$postTime,$postDate);
      if($SQL->execute()){
          if (move_uploaded_file($tmp, $path . $file_name.'.'.$ext)) { //check if it the file move successfully.
                    echo "File Uploaded";
                } else {
                    echo "failed";
                }
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
      $postDateFormat=date("y:m:d",time()); 
      $mergeDate="20";
      $postTime=date("h:i A.",time());
      $postDate=$mergeDate."".$postDateFormat;
      $SQL = $con->prepare("INSERT INTO tbl_logs(userId,stackNumber,file, postTime,postDate) VALUES(?,?,?,?,?)");
          $SQL->bind_param('issss',$userId,$stackNumber,$file,$postTime,$postDate);
          $SQL->execute();
          if(!$SQL){
            echo $con->error;
          }
          $userId = $_POST['userId'];
            $respFileMessage = $con->query("SELECT * FROM tbl_users WHERE userID='$userId'");
             $rowFileMessage=$respFileMessage->fetch_array();
             $file = "INVOICE FILE";
             $invoiceNumber = $_POST['invoiceNumber'];
             $postDateFormat=date("y:m:d",time()); 
             $mergeDate="20";
             $postTime=date("h:i A.",time());
             $postDate=$mergeDate."".$postDateFormat;
            $userMessage=$rowFileMessage['userName'];
            $action1="posted Invoice document No.";
            $action2="of file No.";
            $action3="owned by client";
            // select bol information to prove if file was instantiated with bol file
    $stmt_select_owner = $DB_con->prepare('SELECT fileOwner FROM tbl_stacks WHERE stackNumber=:stack');
    $stmt_select_owner->execute(array(':stack'=>$stackNumber));
    $bolSelect=$stmt_select_owner->fetch(PDO::FETCH_ASSOC);//retursn value as associative array.
    $fileOwner=$bolSelect['fileOwner'];
            $on="on";
            $postDateTime=$postDate." ".$postTime;
            $message=$userMessage." ".$action1."".$invoiceNumber." ".$action2."".$stackNumber." ".$action3." ".$fileOwner." ".$on." ".$postDateTime;
             $sqlMessage = $con->prepare("INSERT INTO tbl_notifications(userName,stackNumber,file,message,postDate,postTime) VALUES(?,?,?,?,?,?)");
            $sqlMessage->bind_param('ssssss',$userMessage,$stackNumber,$file,$message,$postDate,$postTime);
            if(!$sqlMessage){
              echo $con->error;
            }elseif ($sqlMessage->execute()) {
$messagee=$userMessage." ".$action1."".$invoiceNumber." ".$action2."".$stackNumber." ".$action3." ".$fileOwner." ".$on." ".$postDateTime;
require_once __DIR__ . '/vendor/autoload.php';
$messageFrom="PALM";
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
       $successMSG3 = "The message was sent successfully\n";
    } else {
        $errMSG3 = "The message failed with status: " . $response['messages'][0]['status'] . "\n";
    }
} catch (Exception $e) {
    $errMSG3 ="The message was not sent. Error: " . $e->getMessage() . "\n";
}
          }
    }

  }
    else{
      echo $con->error;
    }   
            } else {
                echo "File size max 2 MB";
            }
        } else {
            echo "Invalid file format..";
        }
    } else {
        echo "Please select a file..!";
    }
    exit;
}elseif($_POST['file']=="Quadruplicate"){
  $path = "upload/"; //set your folder path
    //set the valid file extensions 
    $valid_formats = array("jpg", "png", "gif", "bmp", "jpeg", "GIF", "JPG", "PNG", "doc", "txt", "docx", "pdf", "xls", "xlsx"); //add the formats you want to upload

    $name = $_FILES['myfile']['name']; //get the name of the file
    
    $size = $_FILES['myfile']['size']; //get the size of the file

    if (strlen($name)) { //check if the file is selected or cancelled after pressing the browse button.
        list($txt, $ext) = explode(".", $name); //extract the name and extension of the file
        if (in_array($ext, $valid_formats)) { //if the file is valid go on.
            if ($size < 2098888) { // check if the file size is more than 2 mb
                $file_name = $_POST['filename']; //get the file name
                $tmp = $_FILES['myfile']['tmp_name'];

  $quadruplicateNumber = $_POST['quadruplicateNumber'];
  $stackNumber = $_POST['stackNumber'];
  $userId = $_POST['userId'];
  $quadruplicate_file=$file_name.'.'.$ext;
  $postDateFormat=date("y:m:d",time());
  $mergeDate="20";
  $postTime=date("h:i A.",time());
  $postDate=$mergeDate."".$postDateFormat;
  $SQL = $con->prepare("INSERT INTO tbl_quadruplicate(stackNumber,quadruplicateNo,quadruplicate_file,userId, postTime,postDate) VALUES(?,?,?,?,?,?)");
 // select bol information to prove if file was instantiated with bol file
    $stmt_select = $DB_con->prepare('SELECT bol FROM tbl_stacks WHERE stackNumber=:stack');
    $stmt_select->execute(array(':stack'=>$stackNumber));
    $bolSelect=$stmt_select->fetch(PDO::FETCH_ASSOC);//retursn value as associative array.
    if($bolSelect['bol']=="No"){
      echo "<div class='alert alert-danger'>
              <button class='close' data-dismiss='alert'>&times;</button>
              <strong>Error!</strong>.Please insert Bill of Lading data first then proceed to Quadruplicate File.</div>";
    }elseif($bolSelect['bol']=="Yes"){
    if($SQL){
      $SQL->bind_param('sssiss',$stackNumber,$quadruplicateNumber, $quadruplicate_file, $userId,$postTime,$postDate);
      if($SQL->execute()){
          if (move_uploaded_file($tmp, $path . $file_name.'.'.$ext)) { //check if it the file move successfully.
                    echo "File Uploaded";
                } else {
                    echo "failed";
                }
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
      $postDateFormat=date("y:m:d",time()); 
      $mergeDate="20";
      $postTime=date("h:i A.",time());
      $postDate=$mergeDate."".$postDateFormat;
      $SQL = $con->prepare("INSERT INTO tbl_logs(userId,stackNumber,file, postTime,postDate) VALUES(?,?,?,?,?)");
          $SQL->bind_param('issss',$userId,$stackNumber,$file,$postTime,$postDate);
          $SQL->execute();
          if(!$SQL){
            echo $con->error;
          }
          $userId = $_POST['userId'];
            $respFileMessage = $con->query("SELECT * FROM tbl_users WHERE userID='$userId'");
             $rowFileMessage=$respFileMessage->fetch_array();
             $file = "QADRUPLICATE FILE";
             $quadruplicateNumber = $_POST['quadruplicateNumber'];
             $postDateFormat=date("y:m:d",time()); 
             $mergeDate="20";
             $postTime=date("h:i A.",time());
             $postDate=$mergeDate."".$postDateFormat;
            $userMessage=$rowFileMessage['userName'];
            $action1="posted Quadruplicate document No.";
            $action2="of file No.";
            $action3="owned by client";
            // select bol information to prove if file was instantiated with bol file
    $stmt_select_owner = $DB_con->prepare('SELECT fileOwner FROM tbl_stacks WHERE stackNumber=:stack');
    $stmt_select_owner->execute(array(':stack'=>$stackNumber));
    $bolSelect=$stmt_select_owner->fetch(PDO::FETCH_ASSOC);//retursn value as associative array.
    $fileOwner=$bolSelect['fileOwner'];
            $on="on";
            $postDateTime=$postDate." ".$postTime;
            $message=$userMessage." ".$action1."".$quadruplicateNumber." ".$action2."".$stackNumber." ".$action3." ".$fileOwner." ".$on." ".$postDateTime;
             $sqlMessage = $con->prepare("INSERT INTO tbl_notifications(userName,stackNumber,file,message,postDate,postTime) VALUES(?,?,?,?,?,?)");
            $sqlMessage->bind_param('ssssss',$userMessage,$stackNumber,$file,$message,$postDate,$postTime);
            if(!$sqlMessage){
              echo $con->error;
            }elseif ($sqlMessage->execute()) {
$messagee=$userMessage." ".$action1."".$quadruplicateNumber." ".$action2."".$stackNumber." ".$action3." ".$fileOwner." ".$on." ".$postDateTime;
require_once __DIR__ . '/vendor/autoload.php';
$messageFrom="PALM";
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
       $successMSG3 = "The message was sent successfully\n";
    } else {
        $errMSG3 = "The message failed with status: " . $response['messages'][0]['status'] . "\n";
    }
} catch (Exception $e) {
    $errMSG3 ="The message was not sent. Error: " . $e->getMessage() . "\n";
}
          }
    }

  }
    else{
      echo $con->error;
    }   
            } else {
                echo "File size max 2 MB";
            }
        } else {
            echo "Invalid file format..";
        }
    } else {
        echo "Please select a file..!";
    }
    exit;
}elseif($_POST['file']=="ECert"){
  $path = "upload/"; //set your folder path
    //set the valid file extensions 
    $valid_formats = array("jpg", "png", "gif", "bmp", "jpeg", "GIF", "JPG", "PNG", "doc", "txt", "docx", "pdf", "xls", "xlsx"); //add the formats you want to upload

    $name = $_FILES['myfile']['name']; //get the name of the file
    
    $size = $_FILES['myfile']['size']; //get the size of the file

    if (strlen($name)) { //check if the file is selected or cancelled after pressing the browse button.
        list($txt, $ext) = explode(".", $name); //extract the name and extension of the file
        if (in_array($ext, $valid_formats)) { //if the file is valid go on.
            if ($size < 2098888) { // check if the file size is more than 2 mb
                $file_name = $_POST['filename']; //get the file name
                $tmp = $_FILES['myfile']['tmp_name'];

  $ecertNo = $_POST['ecertNumber'];
  $stackNumber = $_POST['stackNumber'];
  $userId = $_POST['userId'];
  $ecert_file=$file_name.'.'.$ext;
  $postDateFormat=date("y:m:d",time());
  $mergeDate="20";
  $postTime=date("h:i A.",time());
  $postDate=$mergeDate."".$postDateFormat;
  $SQL = $con->prepare("INSERT INTO tbl_ecert(stackNumber,ecertNo,ecert_file,userId, postTime,postDate) VALUES(?,?,?,?,?,?)");
 // select bol information to prove if file was instantiated with bol file
    $stmt_select = $DB_con->prepare('SELECT bol FROM tbl_stacks WHERE stackNumber=:stack');
    $stmt_select->execute(array(':stack'=>$stackNumber));
    $bolSelect=$stmt_select->fetch(PDO::FETCH_ASSOC);//retursn value as associative array.
    if($bolSelect['bol']=="No"){
      echo "<div class='alert alert-danger'>
              <button class='close' data-dismiss='alert'>&times;</button>
              <strong>Error!</strong>.Please insert Bill of Lading data first then proceed to Export Certificate File.</div>";
    }elseif($bolSelect['bol']=="Yes"){
    if($SQL){
      $SQL->bind_param('sssiss',$stackNumber,$ecertNo, $ecert_file, $userId,$postTime,$postDate);
      if($SQL->execute()){
          if (move_uploaded_file($tmp, $path . $file_name.'.'.$ext)) { //check if it the file move successfully.
                    echo "File Uploaded";
                } else {
                    echo "failed";
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
      $postDateFormat=date("y:m:d",time()); 
      $mergeDate="20";
      $postTime=date("h:i A.",time());
      $postDate=$mergeDate."".$postDateFormat;
      $SQL = $con->prepare("INSERT INTO tbl_logs(userId,stackNumber,file, postTime,postDate) VALUES(?,?,?,?,?)");
          $SQL->bind_param('issss',$userId,$stackNumber,$file,$postTime,$postDate);
          $SQL->execute();
          if(!$SQL){
            echo $con->error;
          }
          $userId = $_POST['userId'];
            $respFileMessage = $con->query("SELECT * FROM tbl_users WHERE userID='$userId'");
             $rowFileMessage=$respFileMessage->fetch_array();
             $file = "EXPORT CERTIFICATE";
             $ecertNo = $_POST['ecertNo'];
             $postDateFormat=date("y:m:d",time()); 
             $mergeDate="20";
             $postTime=date("h:i A.",time());
             $postDate=$mergeDate."".$postDateFormat;
            $userMessage=$rowFileMessage['userName'];
            $action1="posted Export Certificate document No.";
            $action2="of file No.";
            $action3="owned by client";
            // select bol information to prove if file was instantiated with bol file
    $stmt_select_owner = $DB_con->prepare('SELECT fileOwner FROM tbl_stacks WHERE stackNumber=:stack');
    $stmt_select_owner->execute(array(':stack'=>$stackNumber));
    $bolSelect=$stmt_select_owner->fetch(PDO::FETCH_ASSOC);//retursn value as associative array.
    $fileOwner=$bolSelect['fileOwner'];
            $on="on";
            $postDateTime=$postDate." ".$postTime;
            $message=$userMessage." ".$action1."".$ecertNo." ".$action2."".$stackNumber." ".$action3." ".$fileOwner." ".$on." ".$postDateTime;
             $sqlMessage = $con->prepare("INSERT INTO tbl_notifications(userName,stackNumber,file,message,postDate,postTime) VALUES(?,?,?,?,?,?)");
            $sqlMessage->bind_param('ssssss',$userMessage,$stackNumber,$file,$message,$postDate,$postTime);
            if(!$sqlMessage){
              echo $con->error;
            }elseif ($sqlMessage->execute()) {
$messagee=$userMessage." ".$action1."".$ecertNo." ".$action2."".$stackNumber." ".$action3." ".$fileOwner." ".$on." ".$postDateTime;
require_once __DIR__ . '/vendor/autoload.php';
$messageFrom="PALM";
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
       $successMSG3 = "The message was sent successfully\n";
    } else {
        $errMSG3 = "The message failed with status: " . $response['messages'][0]['status'] . "\n";
    }
} catch (Exception $e) {
    $errMSG3 ="The message was not sent. Error: " . $e->getMessage() . "\n";
}
          }
    }

  }
    else{
      echo $con->error;
    }   
            } else {
                echo "File size max 2 MB";
            }
        } else {
            echo "Invalid file format..";
        }
    } else {
        echo "Please select a file..!";
    }
    exit;
}elseif($_POST['file']=="LBook"){
   $path = "upload/"; //set your folder path
    //set the valid file extensions 
    $valid_formats = array("jpg", "png", "gif", "bmp", "jpeg", "GIF", "JPG", "PNG", "doc", "txt", "docx", "pdf", "xls", "xlsx"); //add the formats you want to upload

    $name = $_FILES['myfile']['name']; //get the name of the file
    
    $size = $_FILES['myfile']['size']; //get the size of the file

    if (strlen($name)) { //check if the file is selected or cancelled after pressing the browse button.
        list($txt, $ext) = explode(".", $name); //extract the name and extension of the file
        if (in_array($ext, $valid_formats)) { //if the file is valid go on.
            if ($size < 2098888) { // check if the file size is more than 2 mb
                $file_name = $_POST['filename']; //get the file name
                $tmp = $_FILES['myfile']['tmp_name'];

  $lbookNumber = $_POST['lbookNumber'];
  $stackNumber = $_POST['stackNumber'];
  $userId = $_POST['userId'];
  $lbook_file=$file_name.'.'.$ext;
  $postDateFormat=date("y:m:d",time());
  $mergeDate="20";
  $postTime=date("h:i A.",time());
  $postDate=$mergeDate."".$postDateFormat;
  $SQL = $con->prepare("INSERT INTO tbl_lbook(stackNumber,lbookNo,lbook_file,userId, postTime,postDate) VALUES(?,?,?,?,?,?)");
 // select bol information to prove if file was instantiated with bol file
    $stmt_select = $DB_con->prepare('SELECT bol FROM tbl_stacks WHERE stackNumber=:stack');
    $stmt_select->execute(array(':stack'=>$stackNumber));
    $bolSelect=$stmt_select->fetch(PDO::FETCH_ASSOC);//retursn value as associative array.
    if($bolSelect['bol']=="No"){
      echo "<div class='alert alert-danger'>
              <button class='close' data-dismiss='alert'>&times;</button>
              <strong>Error!</strong>.Please insert Bill of Lading data first then proceed to Log Book File.</div>";
    }elseif($bolSelect['bol']=="Yes"){
    if($SQL){
      $SQL->bind_param('sssiss',$stackNumber,$lbookNumber, $lbook_file, $userId,$postTime,$postDate);
      if($SQL->execute()){
          if (move_uploaded_file($tmp, $path . $file_name.'.'.$ext)) { //check if it the file move successfully.
                    echo "File Uploaded";
                } else {
                    echo "failed";
                }
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
      $postDateFormat=date("y:m:d",time()); 
      $mergeDate="20";
      $postTime=date("h:i A.",time());
      $postDate=$mergeDate."".$postDateFormat;
      $SQL = $con->prepare("INSERT INTO tbl_logs(userId,stackNumber,file, postTime,postDate) VALUES(?,?,?,?,?)");
          $SQL->bind_param('issss',$userId,$stackNumber,$file,$postTime,$postDate);
          $SQL->execute();
          if(!$SQL){
            echo $con->error;
          }
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
            $action1="posted Log Book Document No.";
            $action2="of file No.";
            $action3="owned by client";
            // select bol information to prove if file was instantiated with bol file
    $stmt_select_owner = $DB_con->prepare('SELECT fileOwner FROM tbl_stacks WHERE stackNumber=:stack');
    $stmt_select_owner->execute(array(':stack'=>$stackNumber));
    $bolSelect=$stmt_select_owner->fetch(PDO::FETCH_ASSOC);//retursn value as associative array.
    $fileOwner=$bolSelect['fileOwner'];
            $on="on";
            $postDateTime=$postDate." ".$postTime;
            $message=$userMessage." ".$action1."".$lbookNumber." ".$action2."".$stackNumber." ".$action3." ".$fileOwner." ".$on." ".$postDateTime;
             $sqlMessage = $con->prepare("INSERT INTO tbl_notifications(userName,stackNumber,file,message,postDate,postTime) VALUES(?,?,?,?,?,?)");
            $sqlMessage->bind_param('ssssss',$userMessage,$stackNumber,$file,$message,$postDate,$postTime);
            if(!$sqlMessage){
              echo $con->error;
            }elseif ($sqlMessage->execute()) {
$messagee=$userMessage." ".$action1."".$lbookNumber." ".$action2."".$stackNumber." ".$action3." ".$fileOwner." ".$on." ".$postDateTime;
require_once __DIR__ . '/vendor/autoload.php';
$messageFrom="PALM";
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
       $successMSG3 = "The message was sent successfully\n";
    } else {
        $errMSG3 = "The message failed with status: " . $response['messages'][0]['status'] . "\n";
    }
} catch (Exception $e) {
    $errMSG3 ="The message was not sent. Error: " . $e->getMessage() . "\n";
}
          }
    }

  }
    else{
      echo $con->error;
    }   
            } else {
                echo "File size max 2 MB";
            }
        } else {
            echo "Invalid file format..";
        }
    } else {
        echo "Please select a file..!";
    }
    exit; 
}
elseif($_POST['file']=="editBol"){
    $path = "upload/"; //set your folder path
    //set the valid file extensions 
    $valid_formats = array("jpg", "png", "gif", "bmp", "jpeg", "GIF", "JPG", "PNG", "doc", "txt", "docx", "pdf", "xls", "xlsx"); //add the formats you want to upload

    $name = $_FILES['myfile']['name']; //get the name of the file
    
    $size = $_FILES['myfile']['size']; //get the size of the file

    if (strlen($name)) { //check if the file is selected or cancelled after pressing the browse button.
        list($txt, $ext) = explode(".", $name); //extract the name and extension of the file
        if (in_array($ext, $valid_formats)) { //if the file is valid go on.
            if ($size < 2098888) { // check if the file size is more than 2 mb
                $file_name = $_POST['filename']; //get the file name
                $tmp = $_FILES['myfile']['tmp_name'];

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
  $billofLading_file=$file_name.'.'.$ext;

  $stmt_select_unlink = $DB_con->prepare('SELECT billofLading_file FROM tbl_billoflading WHERE stackNumber =:ustack');
        $stmt_select_unlink->execute(array(':ustack'=>$stackNumber));
        $fileRow=$stmt_select_unlink->fetch(PDO::FETCH_ASSOC);//retursn value as associative array.
        unlink("upload/".$fileRow['billofLading_file']);

  $SQL = $con->prepare("UPDATE tbl_billofLading set  billofLadingNumber=?, shippername=? ,shipperadress=? ,shipperlocation=? ,consigneename=? ,consigneeadress=?,consigneelocation=?, precariageBy=?, placeofReciept=? ,vessel=?, voyno=?, loadingport=?, dischargeport=?, finalDestination=?, freightName=?, revenueTons=?, rate=?, per=?, prepaid=?,collect=?,markNumber=?,description=?,grossweight=?,measurement=?,packagesNo=?,freightPayable=?,numberOriginal=?,placeOfIssue=?,dateOfIssue=? ,billofLading_file=?, userId=?, postTime=?,postDate=? WHERE stackNumber=?");
   
     $SQL->bind_param('ssssssssssssssssssssssssssssssssss',$billofLadingNumber,$shippername ,$shipperadress  ,$shipperlocation ,$consigneename ,$consigneeadress ,$consigneelocation ,$precariageBy,$placeofReciept,$vessel,$voyno,$loadingport,$dischargeport,$finalDestination, $freightName, $revenueTons,$rate,$per,$prepaid,$collect,$markNumber,$description,$grossweight,$measurement,$packagesNo,$freightPayable,$numberOriginal,$placeOfIssue,$dateOfIssue ,$billofLading_file,$userId,$postTime,$postDate,$stackNumber);
      if($SQL->execute()){
        if (move_uploaded_file($tmp, $path . $file_name.'.'.$ext)) { //check if it the file move successfully.
                    echo "File Edited";
                } else {
                    echo "failed";
                }
            $userId = $_POST['userId'];
            $respFileMessage = $con->query("SELECT * FROM tbl_users WHERE userID='$userId'");
             $rowFileMessage=$respFileMessage->fetch_array();
             $file = "BILL OF LADING";
             $billofLadingNumber = $_POST['billofLadingNumber'];
             $postDateFormat=date("y:m:d",time()); 
             $mergeDate="20";
             $postTime=date("h:i A.",time());
             $postDate=$mergeDate."".$postDateFormat;
            $userMessage=$rowFileMessage['userName'];
            $action1="edited BOL document No.";
            $action2="of file No.";
            $action3="owned by client";
            // select bol information to prove if file was instantiated with bol file
    $stmt_select_owner = $DB_con->prepare('SELECT fileOwner FROM tbl_stacks WHERE stackNumber=:stack');
    $stmt_select_owner->execute(array(':stack'=>$stackNumber));
    $bolSelect=$stmt_select_owner->fetch(PDO::FETCH_ASSOC);//retursn value as associative array.
    $fileOwner=$bolSelect['fileOwner'];
            $on="on";
            $postDateTime=$postDate." ".$postTime;
            $message=$userMessage." ".$action1."".$billofLadingNumber." ".$action2."".$stackNumber." ".$action3." ".$fileOwner." ".$on." ".$postDateTime;
             $sqlMessage = $con->prepare("INSERT INTO tbl_notifications(userName,stackNumber,file,message,postDate,postTime) VALUES(?,?,?,?,?,?)");

          
            $sqlMessage->bind_param('ssssss',$userMessage,$stackNumber,$file,$message,$postDate,$postTime);
            if(!$sqlMessage){
              echo $con->error;
            }elseif ($sqlMessage->execute()) {
$messagee=$userMessage." ".$action1."".$billofLadingNumber." ".$action2."".$stackNumber." ".$action3." ".$fileOwner." ".$on." ".$postDateTime;
require_once __DIR__ . '/vendor/autoload.php';
$messageFrom="PALM";
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
       $successMSG3 = "The message was sent successfully\n";
    } else {
        $errMSG3 = "The message failed with status: " . $response['messages'][0]['status'] . "\n";
    }
} catch (Exception $e) {
    $errMSG3 ="The message was not sent. Error: " . $e->getMessage() . "\n";
}

// var_dump($message->getResponseData());

            }
  
        $finalDateFormat=date("y:m:d",time()); 
        $mergeDate="20";
       $finalTime=date("h:i A.",time());
        $finalDate=$mergeDate."".$finalDateFormat;
      $positive = "Yes";
      $sql = $con->prepare("UPDATE tbl_stacks SET bol=?,bolFinalTime=?,bolFinalDate=? WHERE stackNumber=?");
      $sql->bind_param("ssss",$positive,$finalTime,$finalDate,$stackNumber);
      $sql->execute();
      if(!$sql)
      {
       echo $con->error;
      }
      
      $file = "bol";
      $postTime=date("h:i A.",time());
      $postDate=date("d:m:y",time());
      $updateData = "Yes";
      $sqL = $con->prepare("INSERT INTO tbl_logs(userId,stackNumber,file, postTime,postDate,updateData) VALUES(?,?,?,?,?,?)");


          $sqL->bind_param('ssssss',$userId,$stackNumber,$file,$postTime,$postDate,$updateData);
          $sqL->execute();
          if(!$sqL){
            echo $con->error;
          }
    }else{
      echo $con->error;
    }   
            } else {
                echo "File size max 2 MB";
            }
        } else {
            echo "Invalid file format..";
        }
    } else {
        echo "Please select a file..!";
    }
    exit; 
}elseif($_POST['file']=="editLbook"){
   $path = "upload/"; //set your folder path
    //set the valid file extensions 
    $valid_formats = array("jpg", "png", "gif", "bmp", "jpeg", "GIF", "JPG", "PNG", "doc", "txt", "docx", "pdf", "xls", "xlsx"); //add the formats you want to upload

    $name = $_FILES['myfile']['name']; //get the name of the file
    
    $size = $_FILES['myfile']['size']; //get the size of the file

    if (strlen($name)) { //check if the file is selected or cancelled after pressing the browse button.
        list($txt, $ext) = explode(".", $name); //extract the name and extension of the file
        if (in_array($ext, $valid_formats)) { //if the file is valid go on.
            if ($size < 2098888) { // check if the file size is more than 2 mb
                $file_name = $_POST['filename']; //get the file name
                $tmp = $_FILES['myfile']['tmp_name'];

  $lbookNumber = $_POST['lbookNumber'];
  $stackNumber = $_POST['stackNumber'];
  $userId = $_POST['userId'];
  $lbook_file=$file_name.'.'.$ext;
  $postDateFormat=date("y:m:d",time());
  $mergeDate="20";
  $postTime=date("h:i A.",time());
  $postDate=$mergeDate."".$postDateFormat;
  $lbookNumber = $_POST['lbookNumber'];
  $stackNumber = $_POST['stackNumber'];
  $userId = $_POST['userId'];
   
        $postDateFormat=date("y:m:d",time()); 
        $mergeDate="20";
        $postTime=date("h:i A.",time());
        $postDate=$mergeDate."".$postDateFormat;

        $stmt_select_unlink = $DB_con->prepare('SELECT lbook_file FROM tbl_lbook WHERE stackNumber =:ustack');
        $stmt_select_unlink->execute(array(':ustack'=>$stackNumber));
        $fileRow=$stmt_select_unlink->fetch(PDO::FETCH_ASSOC);//retursn value as associative array.
        unlink("upload/".$fileRow['lbook_file']);
        
  $SQL = $con->prepare("UPDATE tbl_lbook set  lbookNo=?, lbook_file=?,userId=?, postTime=?,postDate=? where stackNumber=? ");

   
      $SQL->bind_param('ssisss',$lbookNumber, $lbook_file, $userId,$postTime,$postDate, $stackNumber);
      if($SQL->execute()){
        if (move_uploaded_file($tmp, $path . $file_name.'.'.$ext)) { //check if it the file move successfully.
                    echo "File Edited";
                } else {
                    echo "failed";
                }
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
            $action3="owned by client";
            // select bol information to prove if file was instantiated with bol file
    $stmt_select_owner = $DB_con->prepare('SELECT fileOwner FROM tbl_stacks WHERE stackNumber=:stack');
    $stmt_select_owner->execute(array(':stack'=>$stackNumber));
    $bolSelect=$stmt_select_owner->fetch(PDO::FETCH_ASSOC);//retursn value as associative array.
    $fileOwner=$bolSelect['fileOwner'];
            $on="on";
            $postDateTime=$postDate." ".$postTime;
            $message=$userMessage." ".$action1."".$lbookNumber." ".$action2."".$stackNumber." ".$action3." ".$fileOwner." ".$on." ".$postDateTime;
             $sqlMessage = $con->prepare("INSERT INTO tbl_notifications(userName,stackNumber,file,message,postDate,postTime) VALUES(?,?,?,?,?,?)");

          
            $sqlMessage->bind_param('ssssss',$userMessage,$stackNumber,$file,$message,$postDate,$postTime);
            if(!$sqlMessage){
              echo $con->error;
            }elseif ($sqlMessage->execute()) {
$messagee=$userMessage." ".$action1."".$lbookNumber." ".$action2."".$stackNumber." ".$action3." ".$fileOwner." ".$on." ".$postDateTime;
require_once __DIR__ . '/vendor/autoload.php';
$messageFrom="PALM";
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
       $successMSG3 = "The message was sent successfully\n";
    } else {
        $errMSG3 = "The message failed with status: " . $response['messages'][0]['status'] . "\n";
    }
} catch (Exception $e) {
    $errMSG3 ="The message was not sent. Error: " . $e->getMessage() . "\n";
}

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
      $sqL = $con->prepare("INSERT INTO tbl_logs(userId,stackNumber,file, postTime,postDate,updateData) VALUES(?,?,?,?,?,?)");


          $sqL->bind_param('ssssss',$userId,$stackNumber,$file,$postTime,$postDate,$updateData);
          $sqL->execute();
          if(!$sqL){
            echo $con->error;
          }
    }else{
      echo $con->error;
    }   
            } else {
                echo "File size max 2 MB";
            }
        } else {
            echo "Invalid file format..";
        }
    } else {
        echo "Please select a file..!";
    }
    exit; 
}elseif($_POST['file']=="editCoc"){
    $path = "upload/"; //set your folder path
    //set the valid file extensions 
    $valid_formats = array("jpg", "png", "gif", "bmp", "jpeg", "GIF", "JPG", "PNG", "doc", "txt", "docx", "pdf", "xls", "xlsx"); //add the formats you want to upload

    $name = $_FILES['myfile']['name']; //get the name of the file
    
    $size = $_FILES['myfile']['size']; //get the size of the file

    if (strlen($name)) { //check if the file is selected or cancelled after pressing the browse button.
        list($txt, $ext) = explode(".", $name); //extract the name and extension of the file
        if (in_array($ext, $valid_formats)) { //if the file is valid go on.
            if ($size < 2098888) { // check if the file size is more than 2 mb
                $file_name = $_POST['filename']; //get the file name
                $tmp = $_FILES['myfile']['tmp_name'];

  $cocNumber = $_POST['cocNumber'];
  $stackNumber = $_POST['stackNumber'];
  $userId = $_POST['userId'];
  $coc_file=$file_name.'.'.$ext;
  $postDateFormat=date("y:m:d",time());
  $mergeDate="20";
  $postTime=date("h:i A.",time());
  $postDate=$mergeDate."".$postDateFormat;
  $stackNumber = $_POST['stackNumber'];
  $userId = $_POST['userId'];
   
        $postDateFormat=date("y:m:d",time()); 
        $mergeDate="20";
        $postTime=date("h:i A.",time());
        $postDate=$mergeDate."".$postDateFormat;

        $stmt_select_unlink = $DB_con->prepare('SELECT coc_file FROM tbl_coc WHERE stackNumber =:ustack');
        $stmt_select_unlink->execute(array(':ustack'=>$stackNumber));
        $fileRow=$stmt_select_unlink->fetch(PDO::FETCH_ASSOC);//retursn value as associative array.
        unlink("upload/".$fileRow['coc_file']);

  $SQL = $con->prepare("UPDATE tbl_coc set  cocNo=?, coc_file=?,userId=?, postTime=?,postDate=? where stackNumber=? ");

   
      $SQL->bind_param('ssisss',$cocNumber, $coc_file, $userId,$postTime,$postDate, $stackNumber);
      if($SQL->execute()){
        if (move_uploaded_file($tmp, $path . $file_name.'.'.$ext)) { //check if it the file move successfully.
                    echo "File Edited";
                } else {
                    echo "failed";
                }
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
            $action3="owned by client";
            // select bol information to prove if file was instantiated with bol file
    $stmt_select_owner = $DB_con->prepare('SELECT fileOwner FROM tbl_stacks WHERE stackNumber=:stack');
    $stmt_select_owner->execute(array(':stack'=>$stackNumber));
    $bolSelect=$stmt_select_owner->fetch(PDO::FETCH_ASSOC);//retursn value as associative array.
    $fileOwner=$bolSelect['fileOwner'];
            $on="on";
            $postDateTime=$postDate." ".$postTime;
            $message=$userMessage." ".$action1."".$cocNumber." ".$action2."".$stackNumber." ".$action3." ".$fileOwner." ".$on." ".$postDateTime;
             $sqlMessage = $con->prepare("INSERT INTO tbl_notifications(userName,stackNumber,file,message,postDate,postTime) VALUES(?,?,?,?,?,?)");

          
            $sqlMessage->bind_param('ssssss',$userMessage,$stackNumber,$file,$message,$postDate,$postTime);
            if(!$sqlMessage){
              echo $con->error;
            }elseif ($sqlMessage->execute()) {
$messagee=$userMessage." ".$action1."".$cocNumber." ".$action2."".$stackNumber." ".$action3." ".$fileOwner." ".$on." ".$postDateTime;
require_once __DIR__ . '/vendor/autoload.php';
$messageFrom="PALM";
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
       $successMSG3 = "The message was sent successfully\n";
    } else {
        $errMSG3 = "The message failed with status: " . $response['messages'][0]['status'] . "\n";
    }
} catch (Exception $e) {
    $errMSG3 ="The message was not sent. Error: " . $e->getMessage() . "\n";
}

// var_dump($message->getResponseData());

            }
  
        $finalDateFormat=date("y:m:d",time()); 
        $mergeDate="20";
       $finalTime=date("h:i A.",time());
        $finalDate=$mergeDate."".$finalDateFormat;
      $positive = "Yes";
      $sql = $con->prepare("UPDATE tbl_stacks SET coc=?,cocFinalTime=?,cocFinalDate=? WHERE stackNumber=?");
      $sql->bind_param("ssss",$positive,$finalTime,$finalDate,$stackNumber);
      $sql->execute();
      if(!$sql)
      {
       echo $con->error;
      }
      
      $file = "coc";
      $postTime=date("h:i A.",time());
      $postDate=date("d:m:y",time());
      $updateData = "Yes";
      $sqL = $con->prepare("INSERT INTO tbl_logs(userId,stackNumber,file, postTime,postDate,updateData) VALUES(?,?,?,?,?,?)");


          $sqL->bind_param('ssssss',$userId,$stackNumber,$file,$postTime,$postDate,$updateData);
          $sqL->execute();
          if(!$sqL){
            echo $con->error;
          }
    }else{
      echo $con->error;
    }   
            } else {
                echo "File size max 2 MB";
            }
        } else {
            echo "Invalid file format..";
        }
    } else {
        echo "Please select a file..!";
    }
    exit; 
}elseif($_POST['file']=="editQuadruplicate"){
    $path = "upload/"; //set your folder path
    //set the valid file extensions 
    $valid_formats = array("jpg", "png", "gif", "bmp", "jpeg", "GIF", "JPG", "PNG", "doc", "txt", "docx", "pdf", "xls", "xlsx"); //add the formats you want to upload

    $name = $_FILES['myfile']['name']; //get the name of the file
    
    $size = $_FILES['myfile']['size']; //get the size of the file

    if (strlen($name)) { //check if the file is selected or cancelled after pressing the browse button.
        list($txt, $ext) = explode(".", $name); //extract the name and extension of the file
        if (in_array($ext, $valid_formats)) { //if the file is valid go on.
            if ($size < 2098888) { // check if the file size is more than 2 mb
                $file_name = $_POST['filename']; //get the file name
                $tmp = $_FILES['myfile']['tmp_name'];

  $quadruplicateNumber = $_POST['quadruplicateNumber'];
  $stackNumber = $_POST['stackNumber'];
  $userId = $_POST['userId'];
  $quadruplicate_file=$file_name.'.'.$ext;
  $postDateFormat=date("y:m:d",time());
  $mergeDate="20";
  $postTime=date("h:i A.",time());
  $postDate=$mergeDate."".$postDateFormat;
  $stackNumber = $_POST['stackNumber'];
  $userId = $_POST['userId'];
   
        $postDateFormat=date("y:m:d",time()); 
        $mergeDate="20";
        $postTime=date("h:i A.",time());
        $postDate=$mergeDate."".$postDateFormat;

        $stmt_select_unlink = $DB_con->prepare('SELECT quadruplicate_file FROM tbl_quadruplicate WHERE stackNumber =:ustack');
        $stmt_select_unlink->execute(array(':ustack'=>$stackNumber));
        $fileRow=$stmt_select_unlink->fetch(PDO::FETCH_ASSOC);//retursn value as associative array.
        unlink("upload/".$fileRow['quadruplicate_file']);

  $SQL = $con->prepare("UPDATE tbl_quadruplicate set  quadruplicateNo=?, quadruplicate_file=?,userId=?, postTime=?,postDate=? where stackNumber=? ");

   
      $SQL->bind_param('ssisss',$quadruplicateNumber, $quadruplicate_file, $userId,$postTime,$postDate, $stackNumber);
      if($SQL->execute()){
        if (move_uploaded_file($tmp, $path . $file_name.'.'.$ext)) { //check if it the file move successfully.
                    echo "File Edited";
                } else {
                    echo "failed";
                }
            $userId = $_POST['userId'];
            $respFileMessage = $con->query("SELECT * FROM tbl_users WHERE userID='$userId'");
             $rowFileMessage=$respFileMessage->fetch_array();
             $file = "QADRUPLICATE";
             $quadruplicateNumber = $_POST['quadruplicateNumber'];
             $postDateFormat=date("y:m:d",time()); 
             $mergeDate="20";
             $postTime=date("h:i A.",time());
             $postDate=$mergeDate."".$postDateFormat;
            $userMessage=$rowFileMessage['userName'];
            $action1="edited Quadruplicate document No.";
            $action2="of file No.";
            $action3="owned by client";
            // select bol information to prove if file was instantiated with bol file
    $stmt_select_owner = $DB_con->prepare('SELECT fileOwner FROM tbl_stacks WHERE stackNumber=:stack');
    $stmt_select_owner->execute(array(':stack'=>$stackNumber));
    $bolSelect=$stmt_select_owner->fetch(PDO::FETCH_ASSOC);//retursn value as associative array.
    $fileOwner=$bolSelect['fileOwner'];
            $on="on";
            $postDateTime=$postDate." ".$postTime;
            $message=$userMessage." ".$action1."".$quadruplicateNumber." ".$action2."".$stackNumber." ".$action3." ".$fileOwner." ".$on." ".$postDateTime;
             $sqlMessage = $con->prepare("INSERT INTO tbl_notifications(userName,stackNumber,file,message,postDate,postTime) VALUES(?,?,?,?,?,?)");

          
            $sqlMessage->bind_param('ssssss',$userMessage,$stackNumber,$file,$message,$postDate,$postTime);
            if(!$sqlMessage){
              echo $con->error;
            }elseif ($sqlMessage->execute()) {
$messagee=$userMessage." ".$action1."".$quadruplicateNumber." ".$action2."".$stackNumber." ".$action3." ".$fileOwner." ".$on." ".$postDateTime;
require_once __DIR__ . '/vendor/autoload.php';
$messageFrom="PALM";
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
       $successMSG3 = "The message was sent successfully\n";
    } else {
        $errMSG3 = "The message failed with status: " . $response['messages'][0]['status'] . "\n";
    }
} catch (Exception $e) {
    $errMSG3 ="The message was not sent. Error: " . $e->getMessage() . "\n";
}

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
      $sqL = $con->prepare("INSERT INTO tbl_logs(userId,stackNumber,file, postTime,postDate,updateData) VALUES(?,?,?,?,?,?)");


          $sqL->bind_param('ssssss',$userId,$stackNumber,$file,$postTime,$postDate,$updateData);
          $sqL->execute();
          if(!$sqL){
            echo $con->error;
          }
    }else{
      echo $con->error;
    }   
            } else {
                echo "File size max 2 MB";
            }
        } else {
            echo "Invalid file format..";
        }
    } else {
        echo "Please select a file..!";
    }
    exit; 
}elseif($_POST['file']=="editTreciept"){
    $path = "upload/"; //set your folder path
    //set the valid file extensions 
    $valid_formats = array("jpg", "png", "gif", "bmp", "jpeg", "GIF", "JPG", "PNG", "doc", "txt", "docx", "pdf", "xls", "xlsx"); //add the formats you want to upload

    $name = $_FILES['myfile']['name']; //get the name of the file
    
    $size = $_FILES['myfile']['size']; //get the size of the file

    if (strlen($name)) { //check if the file is selected or cancelled after pressing the browse button.
        list($txt, $ext) = explode(".", $name); //extract the name and extension of the file
        if (in_array($ext, $valid_formats)) { //if the file is valid go on.
            if ($size < 2098888) { // check if the file size is more than 2 mb
                $file_name = $_POST['filename']; //get the file name
                $tmp = $_FILES['myfile']['tmp_name'];

  $trecieptNumber = $_POST['trecieptNumber'];
  $stackNumber = $_POST['stackNumber'];
  $userId = $_POST['userId'];
  $treciept_file=$file_name.'.'.$ext;
  $postDateFormat=date("y:m:d",time());
  $mergeDate="20";
  $postTime=date("h:i A.",time());
  $postDate=$mergeDate."".$postDateFormat;
  $stackNumber = $_POST['stackNumber'];
  $userId = $_POST['userId'];
   
        $postDateFormat=date("y:m:d",time()); 
        $mergeDate="20";
        $postTime=date("h:i A.",time());
        $postDate=$mergeDate."".$postDateFormat;

        $stmt_select_unlink = $DB_con->prepare('SELECT treciept_file FROM tbl_treciept WHERE stackNumber =:ustack');
        $stmt_select_unlink->execute(array(':ustack'=>$stackNumber));
        $fileRow=$stmt_select_unlink->fetch(PDO::FETCH_ASSOC);//retursn value as associative array.
        unlink("upload/".$fileRow['treciept_file']);

  $SQL = $con->prepare("UPDATE tbl_treciept set  trecieptNo=?, treciept_file=?,userId=?, postTime=?,postDate=? where stackNumber=? ");

   
      $SQL->bind_param('ssisss',$trecieptNumber, $treciept_file, $userId,$postTime,$postDate, $stackNumber);
      if($SQL->execute()){
        if (move_uploaded_file($tmp, $path . $file_name.'.'.$ext)) { //check if it the file move successfully.
                    echo "File Edited";
                } else {
                    echo "failed";
                }
            $userId = $_POST['userId'];
            $respFileMessage = $con->query("SELECT * FROM tbl_users WHERE userID='$userId'");
             $rowFileMessage=$respFileMessage->fetch_array();
             $file = "TRANSACTION RECEIPT";
             $trecieptNumber = $_POST['trecieptNumber'];
             $postDateFormat=date("y:m:d",time()); 
             $mergeDate="20";
             $postTime=date("h:i A.",time());
             $postDate=$mergeDate."".$postDateFormat;
            $userMessage=$rowFileMessage['userName'];
            $action1="edited Transaction Receipt document No.";
            $action2="of file No.";
            $action3="owned by client";
            // select bol information to prove if file was instantiated with bol file
    $stmt_select_owner = $DB_con->prepare('SELECT fileOwner FROM tbl_stacks WHERE stackNumber=:stack');
    $stmt_select_owner->execute(array(':stack'=>$stackNumber));
    $bolSelect=$stmt_select_owner->fetch(PDO::FETCH_ASSOC);//retursn value as associative array.
    $fileOwner=$bolSelect['fileOwner'];
            $on="on";
            $postDateTime=$postDate." ".$postTime;
            $message=$userMessage." ".$action1."".$trecieptNumber." ".$action2."".$stackNumber." ".$action3." ".$fileOwner." ".$on." ".$postDateTime;
             $sqlMessage = $con->prepare("INSERT INTO tbl_notifications(userName,stackNumber,file,message,postDate,postTime) VALUES(?,?,?,?,?,?)");

          
            $sqlMessage->bind_param('ssssss',$userMessage,$stackNumber,$file,$message,$postDate,$postTime);
            if(!$sqlMessage){
              echo $con->error;
            }elseif ($sqlMessage->execute()) {
$messagee=$userMessage." ".$action1."".$trecieptNumber." ".$action2."".$stackNumber." ".$action3." ".$fileOwner." ".$on." ".$postDateTime;
require_once __DIR__ . '/vendor/autoload.php';
$messageFrom="PALM";
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
       $successMSG3 = "The message was sent successfully\n";
    } else {
        $errMSG3 = "The message failed with status: " . $response['messages'][0]['status'] . "\n";
    }
} catch (Exception $e) {
    $errMSG3 ="The message was not sent. Error: " . $e->getMessage() . "\n";
}

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
      $sqL = $con->prepare("INSERT INTO tbl_logs(userId,stackNumber,file, postTime,postDate,updateData) VALUES(?,?,?,?,?,?)");


          $sqL->bind_param('ssssss',$userId,$stackNumber,$file,$postTime,$postDate,$updateData);
          $sqL->execute();
          if(!$sqL){
            echo $con->error;
          }
    }else{
      echo $con->error;
    }   
            } else {
                echo "File size max 2 MB";
            }
        } else {
            echo "Invalid file format..";
        }
    } else {
        echo "Please select a file..!";
    }
    exit; 
}elseif($_POST['file']=="editInvoice"){
    $path = "upload/"; //set your folder path
    //set the valid file extensions 
    $valid_formats = array("jpg", "png", "gif", "bmp", "jpeg", "GIF", "JPG", "PNG", "doc", "txt", "docx", "pdf", "xls", "xlsx"); //add the formats you want to upload

    $name = $_FILES['myfile']['name']; //get the name of the file
    
    $size = $_FILES['myfile']['size']; //get the size of the file

    if (strlen($name)) { //check if the file is selected or cancelled after pressing the browse button.
        list($txt, $ext) = explode(".", $name); //extract the name and extension of the file
        if (in_array($ext, $valid_formats)) { //if the file is valid go on.
            if ($size < 2098888) { // check if the file size is more than 2 mb
                $file_name = $_POST['filename']; //get the file name
                $tmp = $_FILES['myfile']['tmp_name'];

  $invoiceNumber = $_POST['invoiceNumber'];
  $stackNumber = $_POST['stackNumber'];
  $userId = $_POST['userId'];
  $invoice_file=$file_name.'.'.$ext;
  $postDateFormat=date("y:m:d",time());
  $mergeDate="20";
  $postTime=date("h:i A.",time());
  $postDate=$mergeDate."".$postDateFormat;
  $stackNumber = $_POST['stackNumber'];
  $userId = $_POST['userId'];
   
        $postDateFormat=date("y:m:d",time()); 
        $mergeDate="20";
        $postTime=date("h:i A.",time());
        $postDate=$mergeDate."".$postDateFormat;

        $stmt_select_unlink = $DB_con->prepare('SELECT invoice_file FROM tbl_invoice WHERE stackNumber =:ustack');
        $stmt_select_unlink->execute(array(':ustack'=>$stackNumber));
        $fileRow=$stmt_select_unlink->fetch(PDO::FETCH_ASSOC);//retursn value as associative array.
        unlink("upload/".$fileRow['invoice_file']);

  $SQL = $con->prepare("UPDATE tbl_invoice set  invoiceNo=?, invoice_file=?,userId=?, postTime=?,postDate=? where stackNumber=? ");

   
      $SQL->bind_param('ssisss',$invoiceNumber, $invoice_file, $userId,$postTime,$postDate, $stackNumber);
      if($SQL->execute()){
        if (move_uploaded_file($tmp, $path . $file_name.'.'.$ext)) { //check if it the file move successfully.
                    echo "File Edited";
                } else {
                    echo "failed";
                }
            $userId = $_POST['userId'];
            $respFileMessage = $con->query("SELECT * FROM tbl_users WHERE userID='$userId'");
             $rowFileMessage=$respFileMessage->fetch_array();
             $file = "INVOICE DOCUMENT";
             $invoiceNumber = $_POST['invoiceNumber'];
             $postDateFormat=date("y:m:d",time()); 
             $mergeDate="20";
             $postTime=date("h:i A.",time());
             $postDate=$mergeDate."".$postDateFormat;
            $userMessage=$rowFileMessage['userName'];
            $action1="edited Invoice document No.";
            $action2="of file No.";
            $action3="owned by client";
            // select bol information to prove if file was instantiated with bol file
    $stmt_select_owner = $DB_con->prepare('SELECT fileOwner FROM tbl_stacks WHERE stackNumber=:stack');
    $stmt_select_owner->execute(array(':stack'=>$stackNumber));
    $bolSelect=$stmt_select_owner->fetch(PDO::FETCH_ASSOC);//retursn value as associative array.
    $fileOwner=$bolSelect['fileOwner'];
            $on="on";
            $postDateTime=$postDate." ".$postTime;
            $message=$userMessage." ".$action1."".$invoiceNumber." ".$action2."".$stackNumber." ".$action3." ".$fileOwner." ".$on." ".$postDateTime;
             $sqlMessage = $con->prepare("INSERT INTO tbl_notifications(userName,stackNumber,file,message,postDate,postTime) VALUES(?,?,?,?,?,?)");

          
            $sqlMessage->bind_param('ssssss',$userMessage,$stackNumber,$file,$message,$postDate,$postTime);
            if(!$sqlMessage){
              echo $con->error;
            }elseif ($sqlMessage->execute()) {
$messagee=$userMessage." ".$action1."".$invoiceNumber." ".$action2."".$stackNumber." ".$action3." ".$fileOwner." ".$on." ".$postDateTime;
require_once __DIR__ . '/vendor/autoload.php';
$messageFrom="PALM";
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
       $successMSG3 = "The message was sent successfully\n";
    } else {
        $errMSG3 = "The message failed with status: " . $response['messages'][0]['status'] . "\n";
    }
} catch (Exception $e) {
    $errMSG3 ="The message was not sent. Error: " . $e->getMessage() . "\n";
}

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
      $sqL = $con->prepare("INSERT INTO tbl_logs(userId,stackNumber,file, postTime,postDate,updateData) VALUES(?,?,?,?,?,?)");


          $sqL->bind_param('ssssss',$userId,$stackNumber,$file,$postTime,$postDate,$updateData);
          $sqL->execute();
          if(!$sqL){
            echo $con->error;
          }
    }else{
      echo $con->error;
    }   
            } else {
                echo "File size max 2 MB";
            }
        } else {
            echo "Invalid file format..";
        }
    } else {
        echo "Please select a file..!";
    }
    exit; 
}elseif($_POST['file']=="editEcert"){
    $path = "upload/"; //set your folder path
    //set the valid file extensions 
    $valid_formats = array("jpg", "png", "gif", "bmp", "jpeg", "GIF", "JPG", "PNG", "doc", "txt", "docx", "pdf", "xls", "xlsx"); //add the formats you want to upload

    $name = $_FILES['myfile']['name']; //get the name of the file
    
    $size = $_FILES['myfile']['size']; //get the size of the file

    if (strlen($name)) { //check if the file is selected or cancelled after pressing the browse button.
        list($txt, $ext) = explode(".", $name); //extract the name and extension of the file
        if (in_array($ext, $valid_formats)) { //if the file is valid go on.
            if ($size < 2098888) { // check if the file size is more than 2 mb
                $file_name = $_POST['filename']; //get the file name
                $tmp = $_FILES['myfile']['tmp_name'];

  $ecertNumber = $_POST['ecertNumber'];
  $stackNumber = $_POST['stackNumber'];
  $userId = $_POST['userId'];
  $ecert_file=$file_name.'.'.$ext;
  $postDateFormat=date("y:m:d",time());
  $mergeDate="20";
  $postTime=date("h:i A.",time());
  $postDate=$mergeDate."".$postDateFormat;
  $stackNumber = $_POST['stackNumber'];
  $userId = $_POST['userId'];
   
        $postDateFormat=date("y:m:d",time()); 
        $mergeDate="20";
        $postTime=date("h:i A.",time());
        $postDate=$mergeDate."".$postDateFormat;

        $stmt_select_unlink = $DB_con->prepare('SELECT ecert_file FROM tbl_ecert WHERE stackNumber =:ustack');
        $stmt_select_unlink->execute(array(':ustack'=>$stackNumber));
        $fileRow=$stmt_select_unlink->fetch(PDO::FETCH_ASSOC);//retursn value as associative array.
        unlink("upload/".$fileRow['ecert_file']);

  $SQL = $con->prepare("UPDATE tbl_ecert set  ecertNo=?, ecert_file=?,userId=?, postTime=?,postDate=? where stackNumber=? ");

   
      $SQL->bind_param('ssisss',$ecertNumber, $ecert_file, $userId,$postTime,$postDate, $stackNumber);
      if($SQL->execute()){
        if (move_uploaded_file($tmp, $path . $file_name.'.'.$ext)) { //check if it the file move successfully.
                    echo "File Edited";
                } else {
                    echo "failed";
                }
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
            $action3="owned by client";
            // select bol information to prove if file was instantiated with bol file
    $stmt_select_owner = $DB_con->prepare('SELECT fileOwner FROM tbl_stacks WHERE stackNumber=:stack');
    $stmt_select_owner->execute(array(':stack'=>$stackNumber));
    $bolSelect=$stmt_select_owner->fetch(PDO::FETCH_ASSOC);//retursn value as associative array.
    $fileOwner=$bolSelect['fileOwner'];
            $on="on";
            $postDateTime=$postDate." ".$postTime;
            $message=$userMessage." ".$action1."".$ecertNumber." ".$action2."".$stackNumber." ".$action3." ".$fileOwner." ".$on." ".$postDateTime;
             $sqlMessage = $con->prepare("INSERT INTO tbl_notifications(userName,stackNumber,file,message,postDate,postTime) VALUES(?,?,?,?,?,?)");

          
            $sqlMessage->bind_param('ssssss',$userMessage,$stackNumber,$file,$message,$postDate,$postTime);
            if(!$sqlMessage){
              echo $con->error;
            }elseif ($sqlMessage->execute()) {
$messagee=$userMessage." ".$action1."".$ecertNumber." ".$action2."".$stackNumber." ".$action3." ".$fileOwner." ".$on." ".$postDateTime;
require_once __DIR__ . '/vendor/autoload.php';
$messageFrom="PALM";
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
       $successMSG3 = "The message was sent successfully\n";
    } else {
        $errMSG3 = "The message failed with status: " . $response['messages'][0]['status'] . "\n";
    }
} catch (Exception $e) {
    $errMSG3 ="The message was not sent. Error: " . $e->getMessage() . "\n";
}

// var_dump($message->getResponseData());

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
      $sqL = $con->prepare("INSERT INTO tbl_logs(userId,stackNumber,file, postTime,postDate,updateData) VALUES(?,?,?,?,?,?)");


          $sqL->bind_param('ssssss',$userId,$stackNumber,$file,$postTime,$postDate,$updateData);
          $sqL->execute();
          if(!$sqL){
            echo $con->error;
          }
    }else{
      echo $con->error;
    }   
            } else {
                echo "File size max 2 MB";
            }
        } else {
            echo "Invalid file format..";
        }
    } else {
        echo "Please select a file..!";
    }
    exit; 
}elseif($_POST['file']=="editKbs"){
    $path = "upload/"; //set your folder path
    //set the valid file extensions 
    $valid_formats = array("jpg", "png", "gif", "bmp", "jpeg", "GIF", "JPG", "PNG", "doc", "txt", "docx", "pdf", "xls", "xlsx"); //add the formats you want to upload

    $name = $_FILES['myfile']['name']; //get the name of the file
    
    $size = $_FILES['myfile']['size']; //get the size of the file

    if (strlen($name)) { //check if the file is selected or cancelled after pressing the browse button.
        list($txt, $ext) = explode(".", $name); //extract the name and extension of the file
        if (in_array($ext, $valid_formats)) { //if the file is valid go on.
            if ($size < 2098888) { // check if the file size is more than 2 mb
                $file_name = $_POST['filename']; //get the file name
                $tmp = $_FILES['myfile']['tmp_name'];

  $kbsNumber = $_POST['kbsNumber'];
  $stackNumber = $_POST['stackNumber'];
  $userId = $_POST['userId'];
  $kbs_file=$file_name.'.'.$ext;
  $postDateFormat=date("y:m:d",time());
  $mergeDate="20";
  $postTime=date("h:i A.",time());
  $postDate=$mergeDate."".$postDateFormat;
  $stackNumber = $_POST['stackNumber'];
  $userId = $_POST['userId'];
   
        $postDateFormat=date("y:m:d",time()); 
        $mergeDate="20";
        $postTime=date("h:i A.",time());
        $postDate=$mergeDate."".$postDateFormat;

        $stmt_select_unlink = $DB_con->prepare('SELECT kbs_file FROM tbl_kbs WHERE stackNumber =:ustack');
        $stmt_select_unlink->execute(array(':ustack'=>$stackNumber));
        $fileRow=$stmt_select_unlink->fetch(PDO::FETCH_ASSOC);//retursn value as associative array.
        unlink("upload/".$fileRow['kbs_file']);

  $SQL = $con->prepare("UPDATE tbl_kbs set  kbsNo=?, kbs_file=?,userId=?, postTime=?,postDate=? where stackNumber=? ");

   
      $SQL->bind_param('ssisss',$kbsNumber, $kbs_file, $userId,$postTime,$postDate, $stackNumber);
      if($SQL->execute()){
        if (move_uploaded_file($tmp, $path . $file_name.'.'.$ext)) { //check if it the file move successfully.
                    echo "File Edited";
                } else {
                    echo "failed";
                }
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
            $action3="owned by client";
            // select bol information to prove if file was instantiated with bol file
    $stmt_select_owner = $DB_con->prepare('SELECT fileOwner FROM tbl_stacks WHERE stackNumber=:stack');
    $stmt_select_owner->execute(array(':stack'=>$stackNumber));
    $bolSelect=$stmt_select_owner->fetch(PDO::FETCH_ASSOC);//retursn value as associative array.
    $fileOwner=$bolSelect['fileOwner'];
            $on="on";
            $postDateTime=$postDate." ".$postTime;
            $message=$userMessage." ".$action1."".$kbsNumber." ".$action2."".$stackNumber." ".$action3." ".$fileOwner." ".$on." ".$postDateTime;
             $sqlMessage = $con->prepare("INSERT INTO tbl_notifications(userName,stackNumber,file,message,postDate,postTime) VALUES(?,?,?,?,?,?)");

          
            $sqlMessage->bind_param('ssssss',$userMessage,$stackNumber,$file,$message,$postDate,$postTime);
            if(!$sqlMessage){
              echo $con->error;
            }elseif ($sqlMessage->execute()) {
$messagee=$userMessage." ".$action1."".$kbsNumber." ".$action2."".$stackNumber." ".$action3." ".$fileOwner." ".$on." ".$postDateTime;
require_once __DIR__ . '/vendor/autoload.php';
$messageFrom="PALM";
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
       $successMSG3 = "The message was sent successfully\n";
    } else {
        $errMSG3 = "The message failed with status: " . $response['messages'][0]['status'] . "\n";
    }
} catch (Exception $e) {
    $errMSG3 ="The message was not sent. Error: " . $e->getMessage() . "\n";
}

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
      if(!$sql)
      {
       echo $con->error;
      }
      
      $file = "kbs";
      $postTime=date("h:i A.",time());
      $postDate=date("d:m:y",time());
      $updateData = "Yes";
      $sqL = $con->prepare("INSERT INTO tbl_logs(userId,stackNumber,file, postTime,postDate,updateData) VALUES(?,?,?,?,?,?)");


          $sqL->bind_param('ssssss',$userId,$stackNumber,$file,$postTime,$postDate,$updateData);
          $sqL->execute();
          if(!$sqL){
            echo $con->error;
          }
    }else{
      echo $con->error;
    }   
            } else {
                echo "File size max 2 MB";
            }
        } else {
            echo "Invalid file format..";
        }
    } else {
        echo "Please select a file..!";
    }
    exit; 
}
elseif($_POST['file']=="editIdf"){
    $path = "upload/"; //set your folder path
    //set the valid file extensions 
    $valid_formats = array("jpg", "png", "gif", "bmp", "jpeg", "GIF", "JPG", "PNG", "doc", "txt", "docx", "pdf", "xls", "xlsx"); //add the formats you want to upload

    $name = $_FILES['myfile']['name']; //get the name of the file
    
    $size = $_FILES['myfile']['size']; //get the size of the file

    if (strlen($name)) { //check if the file is selected or cancelled after pressing the browse button.
        list($txt, $ext) = explode(".", $name); //extract the name and extension of the file
        if (in_array($ext, $valid_formats)) { //if the file is valid go on.
            if ($size < 2098888) { // check if the file size is more than 2 mb
                $file_name = $_POST['filename']; //get the file name
                $tmp = $_FILES['myfile']['tmp_name'];

  $idfNumber = $_POST['idfNumber'];
  $stackNumber = $_POST['stackNumber'];
  $userId = $_POST['userId'];
  $idf_file=$file_name.'.'.$ext;
  $postDateFormat=date("y:m:d",time());
  $mergeDate="20";
  $postTime=date("h:i A.",time());
  $postDate=$mergeDate."".$postDateFormat;
  $stackNumber = $_POST['stackNumber'];
  $userId = $_POST['userId'];
   
        $postDateFormat=date("y:m:d",time()); 
        $mergeDate="20";
        $postTime=date("h:i A.",time());
        $postDate=$mergeDate."".$postDateFormat;

        $stmt_select_unlink = $DB_con->prepare('SELECT idf_file FROM tbl_idf WHERE stackNumber =:ustack');
        $stmt_select_unlink->execute(array(':ustack'=>$stackNumber));
        $fileRow=$stmt_select_unlink->fetch(PDO::FETCH_ASSOC);//retursn value as associative array.
        unlink("upload/".$fileRow['idf_file']);

  $SQL = $con->prepare("UPDATE tbl_idf set  idfNo=?, idf_file=?,userId=?, postTime=?,postDate=? where stackNumber=? ");

   
      $SQL->bind_param('ssisss',$idfNumber, $idf_file, $userId,$postTime,$postDate, $stackNumber);
      if($SQL->execute()){
        if (move_uploaded_file($tmp, $path . $file_name.'.'.$ext)) { //check if it the file move successfully.
                    echo "File Edited";
                } else {
                    echo "failed";
                }
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
            $action3="owned by client";
            // select bol information to prove if file was instantiated with bol file
    $stmt_select_owner = $DB_con->prepare('SELECT fileOwner FROM tbl_stacks WHERE stackNumber=:stack');
    $stmt_select_owner->execute(array(':stack'=>$stackNumber));
    $bolSelect=$stmt_select_owner->fetch(PDO::FETCH_ASSOC);//retursn value as associative array.
    $fileOwner=$bolSelect['fileOwner'];
            $on="on";
            $postDateTime=$postDate." ".$postTime;
            $message=$userMessage." ".$action1."".$idfNumber." ".$action2."".$stackNumber." ".$action3." ".$fileOwner." ".$on." ".$postDateTime;
             $sqlMessage = $con->prepare("INSERT INTO tbl_notifications(userName,stackNumber,file,message,postDate,postTime) VALUES(?,?,?,?,?,?)");

          
            $sqlMessage->bind_param('ssssss',$userMessage,$stackNumber,$file,$message,$postDate,$postTime);
            if(!$sqlMessage){
              echo $con->error;
            }elseif ($sqlMessage->execute()) {
$messagee=$userMessage." ".$action1."".$idfNumber." ".$action2."".$stackNumber." ".$action3." ".$fileOwner." ".$on." ".$postDateTime;
require_once __DIR__ . '/vendor/autoload.php';
$messageFrom="PALM";
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
       $successMSG3 = "The message was sent successfully\n";
    } else {
        $errMSG3 = "The message failed with status: " . $response['messages'][0]['status'] . "\n";
    }
} catch (Exception $e) {
    $errMSG3 ="The message was not sent. Error: " . $e->getMessage() . "\n";
}

// var_dump($message->getResponseData());

            }
  
        $finalDateFormat=date("y:m:d",time()); 
        $mergeDate="20";
       $finalTime=date("h:i A.",time());
        $finalDate=$mergeDate."".$finalDateFormat;
      $positive = "Yes";
      $sql = $con->prepare("UPDATE tbl_stacks SET idf=?,idfFinalTime=?,idfFinalDate=? WHERE stackNumber=?");
      $sql->bind_param("ssss",$positive,$finalTime,$finalDate,$stackNumber);
      $sql->execute();
      if(!$sql)
      {
       echo $con->error;
      }
      
      $file = "idf";
      $postTime=date("h:i A.",time());
      $postDate=date("d:m:y",time());
      $updateData = "Yes";
      $sqL = $con->prepare("INSERT INTO tbl_logs(userId,stackNumber,file, postTime,postDate,updateData) VALUES(?,?,?,?,?,?)");


          $sqL->bind_param('ssssss',$userId,$stackNumber,$file,$postTime,$postDate,$updateData);
          $sqL->execute();
          if(!$sqL){
            echo $con->error;
          }
    }else{
      echo $con->error;
    }   
            } else {
                echo "File size max 2 MB";
            }
        } else {
            echo "Invalid file format..";
        }
    } else {
        echo "Please select a file..!";
    }
    exit; 
}elseif($_POST['file']=="Pkl"){
     $path = "upload/"; //set your folder path
    //set the valid file extensions 
    $valid_formats = array("jpg", "png", "gif", "bmp", "jpeg", "GIF", "JPG", "PNG", "doc", "txt", "docx", "pdf", "xls", "xlsx"); //add the formats you want to upload

    $name = $_FILES['myfile']['name']; //get the name of the file
    
    $size = $_FILES['myfile']['size']; //get the size of the file

    if (strlen($name)) { //check if the file is selected or cancelled after pressing the browse button.
        list($txt, $ext) = explode(".", $name); //extract the name and extension of the file
        if (in_array($ext, $valid_formats)) { //if the file is valid go on.
            if ($size < 2098888) { // check if the file size is more than 2 mb
                $file_name = $_POST['filename']; //get the file name
                $tmp = $_FILES['myfile']['tmp_name'];

  $pklNumber = $_POST['pklNumber'];
  $stackNumber = $_POST['stackNumber'];
  $userId = $_POST['userId'];
  $pkl_file=$file_name.'.'.$ext;
  $postDateFormat=date("y:m:d",time());
  $mergeDate="20";
  $postTime=date("h:i A.",time());
  $postDate=$mergeDate."".$postDateFormat;
  $SQL = $con->prepare("INSERT INTO tbl_pkl(stackNumber,pklNo, pkl_file,userId, postTime,postDate) VALUES(?,?,?,?,?,?)");
 // select bol information to prove if file was instantiated with bol file
    $stmt_select = $DB_con->prepare('SELECT bol FROM tbl_stacks WHERE stackNumber=:stack');
    $stmt_select->execute(array(':stack'=>$stackNumber));
    $bolSelect=$stmt_select->fetch(PDO::FETCH_ASSOC);//retursn value as associative array.
    if($bolSelect['bol']=="No"){
      echo "<div class='alert alert-danger'>
              <button class='close' data-dismiss='alert'>&times;</button>
              <strong>Error!</strong>.Please insert Bill of Lading data first then proceed to Packaging List File.</div>";
    }elseif($bolSelect['bol']=="Yes"){
    if($SQL){
      $SQL->bind_param('sssiss',$stackNumber,$pklNumber, $pkl_file, $userId,$postTime,$postDate);
      if($SQL->execute()){
          if (move_uploaded_file($tmp, $path . $file_name.'.'.$ext)) { //check if it the file move successfully.
                    echo "File Uploaded";
                } else {
                    echo "failed";
                }
      }
        $finalDateFormat=date("y:m:d",time()); 
        $mergeDate="20";
        $finalTime=date("h:i A.",time());
        $finalDate=$mergeDate."".$finalDateFormat;
      $positive = "Yes";
      $sql = $con->prepare("UPDATE tbl_stacks SET pkl=?,pklFinalTime=?,pklFinalDate=? WHERE stackNumber=?");
      $sql->bind_param("ssss",$positive,$finalTime,$finalDate,$stackNumber);
      $sql->execute();
      if(!$sql)
      {
       echo $con->error;
      }

      $file = "pkl";
      $postDateFormat=date("y:m:d",time()); 
      $mergeDate="20";
      $postTime=date("h:i A.",time());
      $postDate=$mergeDate."".$postDateFormat;
      $SQL = $con->prepare("INSERT INTO tbl_logs(userId,stackNumber,file, postTime,postDate) VALUES(?,?,?,?,?)");
          $SQL->bind_param('issss',$userId,$stackNumber,$file,$postTime,$postDate);
          $SQL->execute();
          if(!$SQL){
            echo $con->error;
          }
          $userId = $_POST['userId'];
            $respFileMessage = $con->query("SELECT * FROM tbl_users WHERE userID='$userId'");
             $rowFileMessage=$respFileMessage->fetch_array();
             $file = "PACKAGING LIST";
             $pklNumber = $_POST['pklNumber'];
             $postDateFormat=date("y:m:d",time()); 
             $mergeDate="20";
             $postTime=date("h:i A.",time());
             $postDate=$mergeDate."".$postDateFormat;
            $userMessage=$rowFileMessage['userName'];
            $action1="posted Packaging List document No.";
            $action2="of file No.";
            $action3="owned by client";
            // select bol information to prove if file was instantiated with bol file
    $stmt_select_owner = $DB_con->prepare('SELECT fileOwner FROM tbl_stacks WHERE stackNumber=:stack');
    $stmt_select_owner->execute(array(':stack'=>$stackNumber));
    $bolSelect=$stmt_select_owner->fetch(PDO::FETCH_ASSOC);//retursn value as associative array.
    $fileOwner=$bolSelect['fileOwner'];
            $on="on";
            $postDateTime=$postDate." ".$postTime;
            $message=$userMessage." ".$action1."".$pklNumber." ".$action2."".$stackNumber." ".$action3." ".$fileOwner." ".$on." ".$postDateTime;
             $sqlMessage = $con->prepare("INSERT INTO tbl_notifications(userName,stackNumber,file,message,postDate,postTime) VALUES(?,?,?,?,?,?)");
            $sqlMessage->bind_param('ssssss',$userMessage,$stackNumber,$file,$message,$postDate,$postTime);
            if(!$sqlMessage){
              echo $con->error;
            }elseif ($sqlMessage->execute()) {
$messagee=$userMessage." ".$action1."".$pklNumber." ".$action2."".$stackNumber." ".$action3." ".$fileOwner." ".$on." ".$postDateTime;
require_once __DIR__ . '/vendor/autoload.php';
$messageFrom="PALM";
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
       $successMSG3 = "The message was sent successfully\n";
    } else {
        $errMSG3 = "The message failed with status: " . $response['messages'][0]['status'] . "\n";
    }
} catch (Exception $e) {
    $errMSG3 ="The message was not sent. Error: " . $e->getMessage() . "\n";
}
          }
    }

  }
    else{
      echo $con->error;
    }   
            } else {
                echo "File size max 2 MB";
            }
        } else {
            echo "Invalid file format..";
        }
    } else {
        echo "Please select a file..!";
    }
    exit;
}elseif($_POST['file']=="Coi"){
     $path = "upload/"; //set your folder path
    //set the valid file extensions 
    $valid_formats = array("jpg", "png", "gif", "bmp", "jpeg", "GIF", "JPG", "PNG", "doc", "txt", "docx", "pdf", "xls", "xlsx"); //add the formats you want to upload

    $name = $_FILES['myfile']['name']; //get the name of the file
    
    $size = $_FILES['myfile']['size']; //get the size of the file

    if (strlen($name)) { //check if the file is selected or cancelled after pressing the browse button.
        list($txt, $ext) = explode(".", $name); //extract the name and extension of the file
        if (in_array($ext, $valid_formats)) { //if the file is valid go on.
            if ($size < 2098888) { // check if the file size is more than 2 mb
                $file_name = $_POST['filename']; //get the file name
                $tmp = $_FILES['myfile']['tmp_name'];

  $coiNumber = $_POST['coiNumber'];
  $stackNumber = $_POST['stackNumber'];
  $userId = $_POST['userId'];
  $coi_file=$file_name.'.'.$ext;
  $postDateFormat=date("y:m:d",time());
  $mergeDate="20";
  $postTime=date("h:i A.",time());
  $postDate=$mergeDate."".$postDateFormat;
  $SQL = $con->prepare("INSERT INTO tbl_coi(stackNumber,coiNo, coi_file,userId, postTime,postDate) VALUES(?,?,?,?,?,?)");
 // select bol information to prove if file was instantiated with bol file
    $stmt_select = $DB_con->prepare('SELECT bol FROM tbl_stacks WHERE stackNumber=:stack');
    $stmt_select->execute(array(':stack'=>$stackNumber));
    $bolSelect=$stmt_select->fetch(PDO::FETCH_ASSOC);//retursn value as associative array.
    if($bolSelect['bol']=="No"){
      echo "<div class='alert alert-danger'>
              <button class='close' data-dismiss='alert'>&times;</button>
              <strong>Error!</strong>.Please insert Bill of Lading data first then proceed to Certificate of Inspection File.</div>";
    }elseif($bolSelect['bol']=="Yes"){
    if($SQL){
      $SQL->bind_param('sssiss',$stackNumber,$coiNumber, $coi_file, $userId,$postTime,$postDate);
      if($SQL->execute()){
          if (move_uploaded_file($tmp, $path . $file_name.'.'.$ext)) { //check if it the file move successfully.
                    echo "File Uploaded";
                } else {
                    echo "failed";
                }
      }
        $finalDateFormat=date("y:m:d",time()); 
        $mergeDate="20";
        $finalTime=date("h:i A.",time());
        $finalDate=$mergeDate."".$finalDateFormat;
      $positive = "Yes";
      $sql = $con->prepare("UPDATE tbl_stacks SET coi=?,coiFinalTime=?,coiFinalDate=? WHERE stackNumber=?");
      $sql->bind_param("ssss",$positive,$finalTime,$finalDate,$stackNumber);
      $sql->execute();
      if(!$sql)
      {
       echo $con->error;
      }

      $file = "coi";
      $postDateFormat=date("y:m:d",time()); 
      $mergeDate="20";
      $postTime=date("h:i A.",time());
      $postDate=$mergeDate."".$postDateFormat;
      $SQL = $con->prepare("INSERT INTO tbl_logs(userId,stackNumber,file, postTime,postDate) VALUES(?,?,?,?,?)");
          $SQL->bind_param('issss',$userId,$stackNumber,$file,$postTime,$postDate);
          $SQL->execute();
          if(!$SQL){
            echo $con->error;
          }
          $userId = $_POST['userId'];
            $respFileMessage = $con->query("SELECT * FROM tbl_users WHERE userID='$userId'");
             $rowFileMessage=$respFileMessage->fetch_array();
             $file = "CERTIFICATE OF INSPECTION";
             $coiNumber = $_POST['coiNumber'];
             $postDateFormat=date("y:m:d",time()); 
             $mergeDate="20";
             $postTime=date("h:i A.",time());
             $postDate=$mergeDate."".$postDateFormat;
            $userMessage=$rowFileMessage['userName'];
            $action1="posted Certificate of Inspection document No.";
            $action2="of file No.";
            $action3="owned by client";
            // select bol information to prove if file was instantiated with bol file
    $stmt_select_owner = $DB_con->prepare('SELECT fileOwner FROM tbl_stacks WHERE stackNumber=:stack');
    $stmt_select_owner->execute(array(':stack'=>$stackNumber));
    $bolSelect=$stmt_select_owner->fetch(PDO::FETCH_ASSOC);//retursn value as associative array.
    $fileOwner=$bolSelect['fileOwner'];
            $on="on";
            $postDateTime=$postDate." ".$postTime;
            $message=$userMessage." ".$action1."".$coiNumber." ".$action2."".$stackNumber." ".$action3." ".$fileOwner." ".$on." ".$postDateTime;
             $sqlMessage = $con->prepare("INSERT INTO tbl_notifications(userName,stackNumber,file,message,postDate,postTime) VALUES(?,?,?,?,?,?)");
            $sqlMessage->bind_param('ssssss',$userMessage,$stackNumber,$file,$message,$postDate,$postTime);
            if(!$sqlMessage){
              echo $con->error;
            }elseif ($sqlMessage->execute()) {
$messagee=$userMessage." ".$action1."".$coiNumber." ".$action2."".$stackNumber." ".$action3." ".$fileOwner." ".$on." ".$postDateTime;
require_once __DIR__ . '/vendor/autoload.php';
$messageFrom="PALM";
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
       $successMSG3 = "The message was sent successfully\n";
    } else {
        $errMSG3 = "The message failed with status: " . $response['messages'][0]['status'] . "\n";
    }
} catch (Exception $e) {
    $errMSG3 ="The message was not sent. Error: " . $e->getMessage() . "\n";
}
          }
    }

  }
    else{
      echo $con->error;
    }   
            } else {
                echo "File size max 2 MB";
            }
        } else {
            echo "Invalid file format..";
        }
    } else {
        echo "Please select a file..!";
    }
    exit;
}
elseif($_POST['file']=="editCoi"){
    $path = "upload/"; //set your folder path
    //set the valid file extensions 
    $valid_formats = array("jpg", "png", "gif", "bmp", "jpeg", "GIF", "JPG", "PNG", "doc", "txt", "docx", "pdf", "xls", "xlsx"); //add the formats you want to upload

    $name = $_FILES['myfile']['name']; //get the name of the file
    
    $size = $_FILES['myfile']['size']; //get the size of the file

    if (strlen($name)) { //check if the file is selected or cancelled after pressing the browse button.
        list($txt, $ext) = explode(".", $name); //extract the name and extension of the file
        if (in_array($ext, $valid_formats)) { //if the file is valid go on.
            if ($size < 2098888) { // check if the file size is more than 2 mb
                $file_name = $_POST['filename']; //get the file name
                $tmp = $_FILES['myfile']['tmp_name'];

  $coiNumber = $_POST['coiNumber'];
  $stackNumber = $_POST['stackNumber'];
  $userId = $_POST['userId'];
  $coi_file=$file_name.'.'.$ext;
  $postDateFormat=date("y:m:d",time());
  $mergeDate="20";
  $postTime=date("h:i A.",time());
  $postDate=$mergeDate."".$postDateFormat;
  $stackNumber = $_POST['stackNumber'];
  $userId = $_POST['userId'];
   
        $postDateFormat=date("y:m:d",time()); 
        $mergeDate="20";
        $postTime=date("h:i A.",time());
        $postDate=$mergeDate."".$postDateFormat;

        $stmt_select_unlink = $DB_con->prepare('SELECT coi_file FROM tbl_coi WHERE stackNumber =:ustack');
        $stmt_select_unlink->execute(array(':ustack'=>$stackNumber));
        $fileRow=$stmt_select_unlink->fetch(PDO::FETCH_ASSOC);//retursn value as associative array.
        unlink("upload/".$fileRow['coi_file']);

  $SQL = $con->prepare("UPDATE tbl_coi set  coiNo=?, coi_file=?,userId=?, postTime=?,postDate=? where stackNumber=? ");

   
      $SQL->bind_param('ssisss',$coiNumber, $coi_file, $userId,$postTime,$postDate, $stackNumber);
      if($SQL->execute()){
        if (move_uploaded_file($tmp, $path . $file_name.'.'.$ext)) { //check if it the file move successfully.
                    echo "File Edited";
                } else {
                    echo "failed";
                }
            $userId = $_POST['userId'];
            $respFileMessage = $con->query("SELECT * FROM tbl_users WHERE userID='$userId'");
             $rowFileMessage=$respFileMessage->fetch_array();
             $file = "CERTIFICATE OF INSPECTION";
             $coiNumber = $_POST['coiNumber'];
             $postDateFormat=date("y:m:d",time()); 
             $mergeDate="20";
             $postTime=date("h:i A.",time());
             $postDate=$mergeDate."".$postDateFormat;
            $userMessage=$rowFileMessage['userName'];
            $action1="edited COI document No.";
            $action2="of file No.";
            $action3="owned by client";
            // select bol information to prove if file was instantiated with bol file
    $stmt_select_owner = $DB_con->prepare('SELECT fileOwner FROM tbl_stacks WHERE stackNumber=:stack');
    $stmt_select_owner->execute(array(':stack'=>$stackNumber));
    $bolSelect=$stmt_select_owner->fetch(PDO::FETCH_ASSOC);//retursn value as associative array.
    $fileOwner=$bolSelect['fileOwner'];
            $on="on";
            $postDateTime=$postDate." ".$postTime;
            $message=$userMessage." ".$action1."".$coiNumber." ".$action2."".$stackNumber." ".$action3." ".$fileOwner." ".$on." ".$postDateTime;
             $sqlMessage = $con->prepare("INSERT INTO tbl_notifications(userName,stackNumber,file,message,postDate,postTime) VALUES(?,?,?,?,?,?)");

          
            $sqlMessage->bind_param('ssssss',$userMessage,$stackNumber,$file,$message,$postDate,$postTime);
            if(!$sqlMessage){
              echo $con->error;
            }elseif ($sqlMessage->execute()) {
$messagee=$userMessage." ".$action1."".$coiNumber." ".$action2."".$stackNumber." ".$action3." ".$fileOwner." ".$on." ".$postDateTime;
require_once __DIR__ . '/vendor/autoload.php';
$messageFrom="PALM";
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
       $successMSG3 = "The message was sent successfully\n";
    } else {
        $errMSG3 = "The message failed with status: " . $response['messages'][0]['status'] . "\n";
    }
} catch (Exception $e) {
    $errMSG3 ="The message was not sent. Error: " . $e->getMessage() . "\n";
}

// var_dump($message->getResponseData());

            }
  
        $finalDateFormat=date("y:m:d",time()); 
        $mergeDate="20";
       $finalTime=date("h:i A.",time());
        $finalDate=$mergeDate."".$finalDateFormat;
      $positive = "Yes";
      $sql = $con->prepare("UPDATE tbl_stacks SET coi=?,coiFinalTime=?,coiFinalDate=? WHERE stackNumber=?");
      $sql->bind_param("ssss",$positive,$finalTime,$finalDate,$stackNumber);
      $sql->execute();
      if(!$sql)
      {
       echo $con->error;
      }
      
      $file = "coi";
      $postTime=date("h:i A.",time());
      $postDate=date("d:m:y",time());
      $updateData = "Yes";
      $sqL = $con->prepare("INSERT INTO tbl_logs(userId,stackNumber,file, postTime,postDate,updateData) VALUES(?,?,?,?,?,?)");


          $sqL->bind_param('ssssss',$userId,$stackNumber,$file,$postTime,$postDate,$updateData);
          $sqL->execute();
          if(!$sqL){
            echo $con->error;
          }
    }else{
      echo $con->error;
    }   
            } else {
                echo "File size max 2 MB";
            }
        } else {
            echo "Invalid file format..";
        }
    } else {
        echo "Please select a file..!";
    }
    exit; 
}elseif($_POST['file']=="editPkl"){
    $path = "upload/"; //set your folder path
    //set the valid file extensions 
    $valid_formats = array("jpg", "png", "gif", "bmp", "jpeg", "GIF", "JPG", "PNG", "doc", "txt", "docx", "pdf", "xls", "xlsx"); //add the formats you want to upload

    $name = $_FILES['myfile']['name']; //get the name of the file
    
    $size = $_FILES['myfile']['size']; //get the size of the file

    if (strlen($name)) { //check if the file is selected or cancelled after pressing the browse button.
        list($txt, $ext) = explode(".", $name); //extract the name and extension of the file
        if (in_array($ext, $valid_formats)) { //if the file is valid go on.
            if ($size < 2098888) { // check if the file size is more than 2 mb
                $file_name = $_POST['filename']; //get the file name
                $tmp = $_FILES['myfile']['tmp_name'];

  $pklNumber = $_POST['pklNumber'];
  $stackNumber = $_POST['stackNumber'];
  $userId = $_POST['userId'];
  $pkl_file=$file_name.'.'.$ext;
  $postDateFormat=date("y:m:d",time());
  $mergeDate="20";
  $postTime=date("h:i A.",time());
  $postDate=$mergeDate."".$postDateFormat;
  $stackNumber = $_POST['stackNumber'];
  $userId = $_POST['userId'];
   
        $postDateFormat=date("y:m:d",time()); 
        $mergeDate="20";
        $postTime=date("h:i A.",time());
        $postDate=$mergeDate."".$postDateFormat;

        $stmt_select_unlink = $DB_con->prepare('SELECT pkl_file FROM tbl_pkl WHERE stackNumber =:ustack');
        $stmt_select_unlink->execute(array(':ustack'=>$stackNumber));
        $fileRow=$stmt_select_unlink->fetch(PDO::FETCH_ASSOC);//retursn value as associative array.
        unlink("upload/".$fileRow['pkl_file']);

  $SQL = $con->prepare("UPDATE tbl_pkl set  pklNo=?, pkl_file=?,userId=?, postTime=?,postDate=? where stackNumber=? ");

   
      $SQL->bind_param('ssisss',$pklNumber, $pkl_file, $userId,$postTime,$postDate, $stackNumber);
      if($SQL->execute()){
        if (move_uploaded_file($tmp, $path . $file_name.'.'.$ext)) { //check if it the file move successfully.
                    echo "File Edited";
                } else {
                    echo "failed";
                }
            $userId = $_POST['userId'];
            $respFileMessage = $con->query("SELECT * FROM tbl_users WHERE userID='$userId'");
             $rowFileMessage=$respFileMessage->fetch_array();
             $file = "PACKAGING LIST FORM";
             $pklNumber = $_POST['pklNumber'];
             $postDateFormat=date("y:m:d",time()); 
             $mergeDate="20";
             $postTime=date("h:i A.",time());
             $postDate=$mergeDate."".$postDateFormat;
            $userMessage=$rowFileMessage['userName'];
            $action1="edited PKL document No.";
            $action2="of file No.";
            $action3="owned by client";
            // select bol information to prove if file was instantiated with bol file
    $stmt_select_owner = $DB_con->prepare('SELECT fileOwner FROM tbl_stacks WHERE stackNumber=:stack');
    $stmt_select_owner->execute(array(':stack'=>$stackNumber));
    $bolSelect=$stmt_select_owner->fetch(PDO::FETCH_ASSOC);//retursn value as associative array.
    $fileOwner=$bolSelect['fileOwner'];
            $on="on";
            $postDateTime=$postDate." ".$postTime;
            $message=$userMessage." ".$action1."".$pklNumber." ".$action2."".$stackNumber." ".$action3." ".$fileOwner." ".$on." ".$postDateTime;
             $sqlMessage = $con->prepare("INSERT INTO tbl_notifications(userName,stackNumber,file,message,postDate,postTime) VALUES(?,?,?,?,?,?)");

          
            $sqlMessage->bind_param('ssssss',$userMessage,$stackNumber,$file,$message,$postDate,$postTime);
            if(!$sqlMessage){
              echo $con->error;
            }elseif ($sqlMessage->execute()) {
$messagee=$userMessage." ".$action1."".$pklNumber." ".$action2."".$stackNumber." ".$action3." ".$fileOwner." ".$on." ".$postDateTime;
require_once __DIR__ . '/vendor/autoload.php';
$messageFrom="PALM";
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
       $successMSG3 = "The message was sent successfully\n";
    } else {
        $errMSG3 = "The message failed with status: " . $response['messages'][0]['status'] . "\n";
    }
} catch (Exception $e) {
    $errMSG3 ="The message was not sent. Error: " . $e->getMessage() . "\n";
}

// var_dump($message->getResponseData());

            }
  
        $finalDateFormat=date("y:m:d",time()); 
        $mergeDate="20";
       $finalTime=date("h:i A.",time());
        $finalDate=$mergeDate."".$finalDateFormat;
      $positive = "Yes";
      $sql = $con->prepare("UPDATE tbl_stacks SET pkl=?,pklFinalTime=?,pklFinalDate=? WHERE stackNumber=?");
      $sql->bind_param("ssss",$positive,$finalTime,$finalDate,$stackNumber);
      $sql->execute();
      if(!$sql)
      {
       echo $con->error;
      }
      
      $file = "pkl";
      $postTime=date("h:i A.",time());
      $postDate=date("d:m:y",time());
      $updateData = "Yes";
      $sqL = $con->prepare("INSERT INTO tbl_logs(userId,stackNumber,file, postTime,postDate,updateData) VALUES(?,?,?,?,?,?)");


          $sqL->bind_param('ssssss',$userId,$stackNumber,$file,$postTime,$postDate,$updateData);
          $sqL->execute();
          if(!$sqL){
            echo $con->error;
          }
    }else{
      echo $con->error;
    }   
            } else {
                echo "File size max 2 MB";
            }
        } else {
            echo "Invalid file format..";
        }
    } else {
        echo "Please select a file..!";
    }
    exit; 
}
elseif($_POST['file']=="Entry"){
     $path = "upload/"; //set your folder path
    //set the valid file extensions 
    $valid_formats = array("jpg", "png", "gif", "bmp", "jpeg", "GIF", "JPG", "PNG", "doc", "txt", "docx", "pdf", "xls", "xlsx"); //add the formats you want to upload

    $name = $_FILES['myfile']['name']; //get the name of the file
    
    $size = $_FILES['myfile']['size']; //get the size of the file

    if (strlen($name)) { //check if the file is selected or cancelled after pressing the browse button.
        list($txt, $ext) = explode(".", $name); //extract the name and extension of the file
        if (in_array($ext, $valid_formats)) { //if the file is valid go on.
            if ($size < 2098888) { // check if the file size is more than 2 mb
                $file_name = $_POST['filename']; //get the file name
                $tmp = $_FILES['myfile']['tmp_name'];

  $entryNumber = $_POST['entryNumber'];
  $stackNumber = $_POST['stackNumber'];
  $userId = $_POST['userId'];
  $entry_file=$file_name.'.'.$ext;
  $postDateFormat=date("y:m:d",time());
  $mergeDate="20";
  $postTime=date("h:i A.",time());
  $postDate=$mergeDate."".$postDateFormat;
  $SQL = $con->prepare("INSERT INTO tbl_entry(stackNumber,entryNo, entry_file,userId, postTime,postDate) VALUES(?,?,?,?,?,?)");
 // select bol information to prove if file was instantiated with bol file
    $stmt_select = $DB_con->prepare('SELECT bol FROM tbl_stacks WHERE stackNumber=:stack');
    $stmt_select->execute(array(':stack'=>$stackNumber));
    $bolSelect=$stmt_select->fetch(PDO::FETCH_ASSOC);//retursn value as associative array.
    if($bolSelect['bol']=="No"){
      echo "<div class='alert alert-danger'>
              <button class='close' data-dismiss='alert'>&times;</button>
              <strong>Error!</strong>.Please insert Bill of Lading data first then proceed to Entry File.</div>";
    }elseif($bolSelect['bol']=="Yes"){
    if($SQL){
      $SQL->bind_param('sssiss',$stackNumber,$entryNumber, $entry_file, $userId,$postTime,$postDate);
      if($SQL->execute()){
          if (move_uploaded_file($tmp, $path . $file_name.'.'.$ext)) { //check if it the file move successfully.
                    echo "File Uploaded";
                } else {
                    echo "failed";
                }
      }
        $finalDateFormat=date("y:m:d",time()); 
        $mergeDate="20";
        $finalTime=date("h:i A.",time());
        $finalDate=$mergeDate."".$finalDateFormat;
      $positive = "Yes";
      $sql = $con->prepare("UPDATE tbl_stacks SET entry=?,entryFinalTime=?,entryFinalDate=? WHERE stackNumber=?");
      $sql->bind_param("ssss",$positive,$finalTime,$finalDate,$stackNumber);
      $sql->execute();
      if(!$sql)
      {
       echo $con->error;
      }

      $file = "entry";
      $postDateFormat=date("y:m:d",time()); 
      $mergeDate="20";
      $postTime=date("h:i A.",time());
      $postDate=$mergeDate."".$postDateFormat;
      $SQL = $con->prepare("INSERT INTO tbl_logs(userId,stackNumber,file, postTime,postDate) VALUES(?,?,?,?,?)");
          $SQL->bind_param('issss',$userId,$stackNumber,$file,$postTime,$postDate);
          $SQL->execute();
          if(!$SQL){
            echo $con->error;
          }
          $userId = $_POST['userId'];
            $respFileMessage = $con->query("SELECT * FROM tbl_users WHERE userID='$userId'");
             $rowFileMessage=$respFileMessage->fetch_array();
             $file = "ENTRY FORM";
             $entryNumber = $_POST['entryNumber'];
             $postDateFormat=date("y:m:d",time()); 
             $mergeDate="20";
             $postTime=date("h:i A.",time());
             $postDate=$mergeDate."".$postDateFormat;
            $userMessage=$rowFileMessage['userName'];
            $action1="posted Entry document No.";
            $action2="of file No.";
            $action3="owned by client";
            // select bol information to prove if file was instantiated with bol file
    $stmt_select_owner = $DB_con->prepare('SELECT fileOwner FROM tbl_stacks WHERE stackNumber=:stack');
    $stmt_select_owner->execute(array(':stack'=>$stackNumber));
    $bolSelect=$stmt_select_owner->fetch(PDO::FETCH_ASSOC);//retursn value as associative array.
    $fileOwner=$bolSelect['fileOwner'];
            $on="on";
            $postDateTime=$postDate." ".$postTime;
            $message=$userMessage." ".$action1."".$entryNumber." ".$action2."".$stackNumber." ".$action3." ".$fileOwner." ".$on." ".$postDateTime;
             $sqlMessage = $con->prepare("INSERT INTO tbl_notifications(userName,stackNumber,file,message,postDate,postTime) VALUES(?,?,?,?,?,?)");
            $sqlMessage->bind_param('ssssss',$userMessage,$stackNumber,$file,$message,$postDate,$postTime);
            if(!$sqlMessage){
              echo $con->error;
            }elseif ($sqlMessage->execute()) {
$messagee=$userMessage." ".$action1."".$entryNumber." ".$action2."".$stackNumber." ".$action3." ".$fileOwner." ".$on." ".$postDateTime;
require_once __DIR__ . '/vendor/autoload.php';
$messageFrom="PALM";
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
       $successMSG3 = "The message was sent successfully\n";
    } else {
        $errMSG3 = "The message failed with status: " . $response['messages'][0]['status'] . "\n";
    }
} catch (Exception $e) {
    $errMSG3 ="The message was not sent. Error: " . $e->getMessage() . "\n";
}
          }
    }

  }
    else{
      echo $con->error;
    }   
            } else {
                echo "File size max 2 MB";
            }
        } else {
            echo "Invalid file format..";
        }
    } else {
        echo "Please select a file..!";
    }
    exit;
}
elseif($_POST['file']=="editEntry"){
    $path = "upload/"; //set your folder path
    //set the valid file extensions 
    $valid_formats = array("jpg", "png", "gif", "bmp", "jpeg", "GIF", "JPG", "PNG", "doc", "txt", "docx", "pdf", "xls", "xlsx"); //add the formats you want to upload

    $name = $_FILES['myfile']['name']; //get the name of the file
    
    $size = $_FILES['myfile']['size']; //get the size of the file

    if (strlen($name)) { //check if the file is selected or cancelled after pressing the browse button.
        list($txt, $ext) = explode(".", $name); //extract the name and extension of the file
        if (in_array($ext, $valid_formats)) { //if the file is valid go on.
            if ($size < 2098888) { // check if the file size is more than 2 mb
                $file_name = $_POST['filename']; //get the file name
                $tmp = $_FILES['myfile']['tmp_name'];

  $entryNumber = $_POST['entryNumber'];
  $stackNumber = $_POST['stackNumber'];
  $userId = $_POST['userId'];
  $entry_file=$file_name.'.'.$ext;
  $postDateFormat=date("y:m:d",time());
  $mergeDate="20";
  $postTime=date("h:i A.",time());
  $postDate=$mergeDate."".$postDateFormat;
  $stackNumber = $_POST['stackNumber'];
  $userId = $_POST['userId'];
   
        $postDateFormat=date("y:m:d",time()); 
        $mergeDate="20";
        $postTime=date("h:i A.",time());
        $postDate=$mergeDate."".$postDateFormat;

        $stmt_select_unlink = $DB_con->prepare('SELECT entry_file FROM tbl_entry WHERE stackNumber =:ustack');
        $stmt_select_unlink->execute(array(':ustack'=>$stackNumber));
        $fileRow=$stmt_select_unlink->fetch(PDO::FETCH_ASSOC);//retursn value as associative array.
        unlink("upload/".$fileRow['entry_file']);

  $SQL = $con->prepare("UPDATE tbl_entry set  entryNo=?, entry_file=?,userId=?, postTime=?,postDate=? where stackNumber=? ");

   
      $SQL->bind_param('ssisss',$entryNumber, $entry_file, $userId,$postTime,$postDate, $stackNumber);
      if($SQL->execute()){
        if (move_uploaded_file($tmp, $path . $file_name.'.'.$ext)) { //check if it the file move successfully.
                    echo "File Edited";
                } else {
                    echo "failed";
                }
            $userId = $_POST['userId'];
            $respFileMessage = $con->query("SELECT * FROM tbl_users WHERE userID='$userId'");
             $rowFileMessage=$respFileMessage->fetch_array();
             $file = "Entry Form";
             $entryNumber = $_POST['entryNumber'];
             $postDateFormat=date("y:m:d",time()); 
             $mergeDate="20";
             $postTime=date("h:i A.",time());
             $postDate=$mergeDate."".$postDateFormat;
            $userMessage=$rowFileMessage['userName'];
            $action1="edited Entry document No.";
            $action2="of file No.";
            $action3="owned by client";
            // select bol information to prove if file was instantiated with bol file
    $stmt_select_owner = $DB_con->prepare('SELECT fileOwner FROM tbl_stacks WHERE stackNumber=:stack');
    $stmt_select_owner->execute(array(':stack'=>$stackNumber));
    $bolSelect=$stmt_select_owner->fetch(PDO::FETCH_ASSOC);//retursn value as associative array.
    $fileOwner=$bolSelect['fileOwner'];
            $on="on";
            $postDateTime=$postDate." ".$postTime;
            $message=$userMessage." ".$action1."".$entryNumber." ".$action2."".$stackNumber." ".$action3." ".$fileOwner." ".$on." ".$postDateTime;
             $sqlMessage = $con->prepare("INSERT INTO tbl_notifications(userName,stackNumber,file,message,postDate,postTime) VALUES(?,?,?,?,?,?)");

          
            $sqlMessage->bind_param('ssssss',$userMessage,$stackNumber,$file,$message,$postDate,$postTime);
            if(!$sqlMessage){
              echo $con->error;
            }elseif ($sqlMessage->execute()) {
$messagee=$userMessage." ".$action1."".$entryNumber." ".$action2."".$stackNumber." ".$action3." ".$fileOwner." ".$on." ".$postDateTime;
require_once __DIR__ . '/vendor/autoload.php';
$messageFrom="PALM";
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
       $successMSG3 = "The message was sent successfully\n";
    } else {
        $errMSG3 = "The message failed with status: " . $response['messages'][0]['status'] . "\n";
    }
} catch (Exception $e) {
    $errMSG3 ="The message was not sent. Error: " . $e->getMessage() . "\n";
}

// var_dump($message->getResponseData());

            }
  
        $finalDateFormat=date("y:m:d",time()); 
        $mergeDate="20";
       $finalTime=date("h:i A.",time());
        $finalDate=$mergeDate."".$finalDateFormat;
      $positive = "Yes";
      $sql = $con->prepare("UPDATE tbl_stacks SET entry=?,entryFinalTime=?,entryFinalDate=? WHERE stackNumber=?");
      $sql->bind_param("ssss",$positive,$finalTime,$finalDate,$stackNumber);
      $sql->execute();
      if(!$sql)
      {
       echo $con->error;
      }
      
      $file = "entry";
      $postTime=date("h:i A.",time());
      $postDate=date("d:m:y",time());
      $updateData = "Yes";
      $sqL = $con->prepare("INSERT INTO tbl_logs(userId,stackNumber,file, postTime,postDate,updateData) VALUES(?,?,?,?,?,?)");


          $sqL->bind_param('ssssss',$userId,$stackNumber,$file,$postTime,$postDate,$updateData);
          $sqL->execute();
          if(!$sqL){
            echo $con->error;
          }
    }else{
      echo $con->error;
    }   
            } else {
                echo "File size max 2 MB";
            }
        } else {
            echo "Invalid file format..";
        }
    } else {
        echo "Please select a file..!";
    }
    exit; 
}
}