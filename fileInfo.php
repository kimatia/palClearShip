<?php

date_default_timezone_set("Africa/Nairobi");
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once 'dbconfig.php';
if ($_SESSION['file']==$Coc) {

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
  $idf_file=$_FILES["file"]["name"];
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
      $SQL->execute();
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
            $action1="posted IDF document No.";
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
      if (move_uploaded_file($tmp, $path . $file_name.'.'.$ext)) { //check if it the file move successfully.
                    echo "<div class='alert alert-success'>
              <button class='close' data-dismiss='alert'>&times;</button>
              <strong>Success!</strong>.File Uploaded</div>";
                } else {
                    echo "failed";
                }
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