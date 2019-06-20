<!DOCTYPE html>
<html>
<head>
  <title></title>
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

<?php
date_default_timezone_set("Africa/Nairobi");
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 0);
//db connection
require_once 'dbconfig.php';

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
//info about file file  in that stack

$respFileStackActiveClosed = $con->query("SELECT * FROM tbl_stacks");
$rowFileStackActiveClosed=$respFileStackActiveClosed->fetch_array();
$actionFile=$rowFileStackActiveClosed['status'];
if($actionFile=="Yes"){
  if(isset($_GET['id'])){
$dataString1 = $_GET['id'];
$dataString2 = $_GET['idd'];

$_SESSION['infoIdf'] = $_GET['id'];
$y = $_SESSION['infoIdf'];
$respFileIdf = $con->query("SELECT * FROM tbl_idf WHERE id='$y'");
$rowFileIdf=$respFileIdf->fetch_array();
$bolFileStackNo=$rowFileIdf['stackNumber'];
$idfNumber=$rowFileIdf['idfNo'];
$idfPostTime=$rowFileIdf['postTime'];
$idfPostDate=$rowFileIdf['postDate'];
$idfPostedDate=$idfPostDate." ".$idfPostTime;
$z=$bolFileStackNo;
$respFileBol = $con->query("SELECT * FROM tbl_billoflading WHERE stackNumber='$z'");
$rowFileBol=$respFileBol->fetch_array();
$bolPostTime=$rowFileBol['postTime'];
$bolPostDate=$rowFileBol['postDate'];
$bolPostedDate=$bolPostDate." ".$bolPostTime;
$bolNumber=$rowFileBol['billofLadingNumber'];
$shipperName=$rowFileBol['shippername'];
$shipperAdress=$rowFileBol['shipperadress'];
$shipperLocation=$rowFileBol['shipperlocation'];
$consigneeName=$rowFileBol['consigneename'];
$consigneeAdress=$rowFileBol['consigneeadress'];
$consigneeLocation=$rowFileBol['consigneelocation'];
$precariageBy=$rowFileBol['precariageBy'];
$vessel=$rowFileBol['vessel'];
$voyageNo=$rowFileBol['voyno'];
$loadingPort=$rowFileBol['loadingport'];
$dischargePort=$rowFileBol['dischargeport'];
$finalDestination=$rowFileBol['finalDestination'];
$freightName=$rowFileBol['freightName'];
$revenueTons=$rowFileBol['revenueTons'];
$rate=$rowFileBol['rate'];
$per=$rowFileBol['per'];
$prepaid=$rowFileBol['prepaid'];
$collect=$rowFileBol['collect'];
$markNumber=$rowFileBol['markNumber'];
$description=$rowFileBol['description'];
$grossweight=$rowFileBol['grossweight'];
$measurement=$rowFileBol['measurement'];
$packagesNo=$rowFileBol['packagesNo'];
$freightPayable=$rowFileBol['freightPayable'];
$numberOriginal=$rowFileBol['numberOriginal'];
$placeOfIssue=$rowFileBol['placeOfIssue'];
$dateOfIssue=$rowFileBol['dateOfIssue'];
$userId=$rowFileBol['userId'];
$_SESSION['bolFileStackNo'] = $bolFileStackNo;
$z = $_SESSION['bolFileStackNo'];

$finalDateFormat=date("y:m:d",time()); 
$mergeDate="20";
$finalTimeUpdate=date("h:i A.",time());
$finalDateUpdate=$mergeDate."".$finalDateFormat;
$sql = $con->prepare("UPDATE tbl_stacks SET finalTimeNow=?,finalDateNow=? WHERE stackNumber=?");
$sql->bind_param("sss",$finalTimeUpdate,$finalDateUpdate,$z);
$sql->execute();
if(!$sql)
{
  echo $con->error;
}
$respFileStack = $con->query("SELECT * FROM tbl_stacks WHERE  stackNumber='$z'");
$rowFileStack=$respFileStack->fetch_array();
$stackFileNo=$rowFileStack['stackNumber'];
$fileOwner=$rowFileStack['fileOwner'];
$ownerNumber=$rowFileStack['ownerNumber'];
$ownerEmail=$rowFileStack['ownerEmail'];  
$bol=$rowFileStack['bol'];
$bolFinalTime=$rowFileStack['bolFinalTime'];
$bolFinalDate=$rowFileStack['bolFinalDate'];
$postTime=$rowFileStack['postTime'];
$postDate=$rowFileStack['postDate'];
$finalTime=$rowFileStack['finalTimeNow'];
$finalDate=$rowFileStack['finalDateNow'];
$status=$rowFileStack['status'];
$bolFile="Import Declaration";
if($status=="Yes"){
$fileStatus="Closed";  
}elseif($status=="No"){
$fileStatus="Active";  
}
$respFileStackUser = $con->query("SELECT * FROM tbl_users WHERE  userID='$userId'");
$rowFileStackUser=$respFileStackUser->fetch_array();
$stackFileNoUser=$rowFileStackUser['stackNumber']; 
$postUser=$rowFileStackUser['userName'];


$idd = $postUser;
$respLoginUser = $con->query("SELECT * FROM tbl_login WHERE  userName='$idd' order by id DESC");
$login_row=$respLoginUser->fetch_array();
        
        $loginTime=$login_row['loginTime'];
        $loginDate=$login_row['loginDate'];

$arrFrom = array("A","B",":","D","E",":","G","H"); 
$arrTo = array("E","F","-","H","I","-","K","L"); 
//post date time for stack file
// replace function for post date
$stringPostDate = $postDate;
$replacedPostDate=str_replace($arrFrom, $arrTo, $stringPostDate);
// replace function final date
$stringPostTime = $postTime;
if (strpos($stringPostTime, 'P') !== false) {
 // rtrim function for PM time
$stringTime = $postTime;
$trimmedPostTime=rtrim($stringTime, "PM.");
}elseif(strpos($stringPostTime,'A') !==false){
  // rtrim function for AM time
$stringTime = $postTime;
$trimmedPostTime=rtrim($stringTime, "AM.");
}
//final date time for stack file
// replace function for post date
$stringFinalDate = $finalDate;
$replacedFinalDate=str_replace($arrFrom, $arrTo, $stringFinalDate);
//check if AM or PM? then perform action.
$stringFinalTime = $finalTime;
if (strpos($stringFinalTime, 'P') !== false) {
 // rtrim function for PM time
$stringTime = $finalTime;
$trimmedFinalTime=rtrim($stringTime, "PM.");
}elseif(strpos($stringFinalTime,'A') !==false){
  // rtrim function for AM time
$stringTime = $finalTime;
$trimmedFinalTime=rtrim($stringTime, "AM.");
}
//final date time for idf file
// replace function for post date
$stringIdfFinalDate = $idfPostDate;
$replacedIdfFinalDate=str_replace($arrFrom, $arrTo, $stringIdfFinalDate);
//check if AM or PM? then perform action.
$stringIdfPostTime = $idfPostTime;
if (strpos($stringIdfPostTime, 'P') !== false) {
 // rtrim function for PM time
$stringIdfTime = $idfPostTime;
$trimmedIdfPostTime=rtrim($stringIdfTime, "PM.");
}elseif(strpos($stringIdfPostTime,'A') !==false){
  // rtrim function for AM time
$stringIdfTime = $idfPostTime;
$trimmedIdfPostTime=rtrim($stringIdfTime, "AM.");
}
// replace function for login date
$stringLoginDate = $loginDate;
$replacedLoginDate=str_replace($arrFrom, $arrTo, $stringLoginDate);
//check if AM or PM? then perform action.
$userLoginTime = $loginTime;
if (strpos($userLoginTime, 'P') !== false) {
 // rtrim function for PM time
$stringLoginTime = $loginTime;
$trimmedLoginTime=rtrim($stringLoginTime, "PM.");
}elseif(strpos($userLoginTime,'A') !==false){
  // rtrim function for AM time
$stringLoginTime = $loginTime;
$trimmedLoginTime=rtrim($stringLoginTime, "AM.");
}
//concatenating post date and post time
$startFullDateTime=$replacedPostDate." ".$trimmedPostTime;
$finalFullDateTime=$replacedFinalDate." ".$trimmedFinalTime;
$finalIdfFullDateTime=$replacedIfdFinalDate." ".$trimmedIfdPostTime;
$finalLoginFullDateTime=$replacedLoginDate." ".$trimmedLoginTime;
//real date/time without rtrim function ie AM/PM included
$startFullDateTimeReal=$replacedPostDate." ".$postTime;
$finalFullDateTimeReal=$replacedFinalDate." ".$finalTime;
//date finction to calculate difference
   $strStart = $startFullDateTime; 
   $strEnd   = $finalFullDateTime; 
   $dteStart = new DateTime($strStart); 
   $dteEnd   = new DateTime($strEnd);
   $dteDiff  = $dteStart->diff($dteEnd); 
   //difference date function for login
   $strStartLogin = $finalLoginFullDateTime; 
   $strEndLogin   = $finalFullDateTime; 
   $dteStartLogin = new DateTime($strStartLogin); 
   $dteEndLogin   = new DateTime($strEndLogin);
   $dteDiffLogin  = $dteStartLogin->diff($dteEndLogin); 
   //bol
   $strStartBol = $startFullDateTime; 
   $strEndBol   = $finalIdfFullDateTime; 
   $dteStartBol = new DateTime($strStartBol); 
   $dteEndBol   = new DateTime($strEndBol);
   $dteDiffBol  = $dteStartBol->diff($dteEndBol); 
   // echo $dteDiff->format("%Y yrs %Mmonths %Ddays  %H hours %Imins %Ssecs");
   $loginDateTime=$loginDate." ".$loginTime; 
   if($rowFileStackUser['user_status']==1){
  $onlineOffline="Online since ".$loginDateTime;
}elseif($rowFileStackUser['user_status']==0){
  $onlineOffline="Offline ".$dteDiffLogin->format( "%D dys %H Hrs %I mins ago");
}
    
?>
<div class="panel panel-primary">
 <div class="panel-heading">
 <i class="icon-bell"><center><?php echo $bolFile; ?> File for  Client <strong><?php echo $fileOwner; ?></strong> posted on <strong><?php echo $startFullDateTimeReal; ?></strong><strong></center></i> 
  </div>
 <div class="panel-body">
 <div class="list-group">
 <a href="#" class="list-group-item">
 <i class=" icon-comment"></i>File No.:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<em><hh style="color: grey;"><?php echo $stackFileNo;?></hh></em>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Posted:
 <span class="pull-right text-muted small"><em><?php echo $dteDiff->format("%Y Ys %M Mons %D dys %H Hrs %I mins ago")?></em>
 </span>
 </a>
 <a href="#" class="list-group-item">
 <i class="icon-twitter"></i>Client.:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<em><hh style="color: grey;"><?php echo $fileOwner;?></hh></em>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Client Email:
 <span class="pull-right text-muted small"><em><?php echo $ownerEmail ?></em>
 </span>
 </a>
  <a href="#" class="list-group-item">
 <i class="icon-tasks"></i>Client No.:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<em><hh style="color: grey;"><?php echo $ownerNumber;?></hh></em>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Document Closed:
 <span class="pull-right text-muted small"><em><?php echo $idfPostedDate ?></em>
 </span>
 </a>
 <a href="#" class="list-group-item">
 <i class="icon-envelope"></i>File Status.:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<em><hh style="color: grey;"><?php echo $fileStatus;?></hh></em>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Time Taken: 
 <span class="pull-right text-muted small"><em><?php echo $dteDiffBol->format("%D dys %H Hrs %I Mins")?></em>
 </span>
 </a>
 <a href="#" class="list-group-item">
 <i class="icon-upload"></i>Import Dec. No.:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<em><hh style="color: grey;"><?php echo $idfNumber;?></hh></em>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Shipper Name:
 <span class="pull-right text-muted small"><em><?php echo $shipperName ?></em>
 </span>
  </a>
  <a href="#" class="list-group-item">                         
  <i class="icon-upload"></i>Shipper Adress.:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<em><hh style="color: grey;"><?php echo $shipperAdress;?></hh></em>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Shipper Location:
 <span class="pull-right text-muted small"><em><?php echo $shipperLocation ?></em>
 </span>
  </a> 
 <a href="#" class="list-group-item">                         
  <i class="icon-upload"></i>Consignee Name.:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<em><hh style="color: grey;"><?php echo $consigneeName;?></hh></em>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Consignee Adress:
 <span class="pull-right text-muted small"><em><?php echo $consigneeAdress ?></em>
 </span>
  </a>
  <a href="#" class="list-group-item">                         
  <i class="icon-upload"></i>Consignee Location:&nbsp;&nbsp;&nbsp;<em><hh style="color: grey;"><?php echo $consigneeLocation;?></hh></em>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Measurement in CBM:
 <span class="pull-right text-muted small"><em><?php echo $measurement ?></em>
 </span>
  </a>
     <a href="#" class="list-group-item">                         
  <i class="icon-upload"></i>Loading Port.:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<em><hh style="color: grey;"><?php echo $loadingPort;?></hh></em>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Discharge Port.:
 <span class="pull-right text-muted small"><em><?php echo $dischargePort ?></em>
 </span>
  </a>
   <a href="#" class="list-group-item">
  <i class=" icon-money"></i>Personelle Incharge.:&nbsp;&nbsp;<em><hh style="color: grey;"><?php echo $postUser; ?></hh></em>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Status.:
<span class="pull-right text-muted small"><em><?php echo $onlineOffline; ?></em>
 </span>
  </a>
   </div>

  </div>
   </div>
<?php
}
}elseif ($actionFile=="No") {
 if(isset($_GET['id'])){
$dataString1 = $_GET['id'];
$dataString2 = $_GET['idd'];

$_SESSION['infoIdf'] = $_GET['id'];
$y = $_SESSION['infoIdf'];
$respFileIdf = $con->query("SELECT * FROM tbl_idf WHERE id='$y'");
$rowFileIdf=$respFileIdf->fetch_array();
$bolFileStackNo=$rowFileIdf['stackNumber'];
$idfNumber=$rowFileIdf['idfNo'];
$idfPostTime=$rowFileIdf['postTime'];
$idfPostDate=$rowFileIdf['postDate'];
$idfPostedDate=$idfPostDate." ".$idfPostTime;
$z=$bolFileStackNo;
$respFileBol = $con->query("SELECT * FROM tbl_billoflading WHERE stackNumber='$z'");
$rowFileBol=$respFileBol->fetch_array();
$bolPostTime=$rowFileBol['postTime'];
$bolPostDate=$rowFileBol['postDate'];
$bolPostedDate=$bolPostDate." ".$bolPostTime;
$bolNumber=$rowFileBol['billofLadingNumber'];
$shipperName=$rowFileBol['shippername'];
$shipperAdress=$rowFileBol['shipperadress'];
$shipperLocation=$rowFileBol['shipperlocation'];
$consigneeName=$rowFileBol['consigneename'];
$consigneeAdress=$rowFileBol['consigneeadress'];
$consigneeLocation=$rowFileBol['consigneelocation'];
$precariageBy=$rowFileBol['precariageBy'];
$vessel=$rowFileBol['vessel'];
$voyageNo=$rowFileBol['voyno'];
$loadingPort=$rowFileBol['loadingport'];
$dischargePort=$rowFileBol['dischargeport'];
$finalDestination=$rowFileBol['finalDestination'];
$freightName=$rowFileBol['freightName'];
$revenueTons=$rowFileBol['revenueTons'];
$rate=$rowFileBol['rate'];
$per=$rowFileBol['per'];
$prepaid=$rowFileBol['prepaid'];
$collect=$rowFileBol['collect'];
$markNumber=$rowFileBol['markNumber'];
$description=$rowFileBol['description'];
$grossweight=$rowFileBol['grossweight'];
$measurement=$rowFileBol['measurement'];
$packagesNo=$rowFileBol['packagesNo'];
$freightPayable=$rowFileBol['freightPayable'];
$numberOriginal=$rowFileBol['numberOriginal'];
$placeOfIssue=$rowFileBol['placeOfIssue'];
$dateOfIssue=$rowFileBol['dateOfIssue'];
$userId=$rowFileBol['userId'];
$_SESSION['bolFileStackNo'] = $bolFileStackNo;
$z = $_SESSION['bolFileStackNo'];

$finalDateFormat=date("y:m:d",time()); 
$mergeDate="20";
$finalTimeUpdate=date("h:i A.",time());
$finalDateUpdate=$mergeDate."".$finalDateFormat;
$sql = $con->prepare("UPDATE tbl_stacks SET finalTimeNow=?,finalDateNow=? WHERE stackNumber=?");
$sql->bind_param("sss",$finalTimeUpdate,$finalDateUpdate,$z);
$sql->execute();
if(!$sql)
{
  echo $con->error;
}
$respFileStack = $con->query("SELECT * FROM tbl_stacks WHERE  stackNumber='$z'");
$rowFileStack=$respFileStack->fetch_array();
$stackFileNo=$rowFileStack['stackNumber'];
$fileOwner=$rowFileStack['fileOwner'];
$ownerNumber=$rowFileStack['ownerNumber'];
$ownerEmail=$rowFileStack['ownerEmail'];  
$bol=$rowFileStack['bol'];
$bolFinalTime=$rowFileStack['bolFinalTime'];
$bolFinalDate=$rowFileStack['bolFinalDate'];
$postTime=$rowFileStack['postTime'];
$postDate=$rowFileStack['postDate'];
$finalTime=$rowFileStack['finalTimeNow'];
$finalDate=$rowFileStack['finalDateNow'];
$status=$rowFileStack['status'];
$bolFile="Import Declaration";
if($status=="Yes"){
$fileStatus="Closed";  
}elseif($status=="No"){
$fileStatus="Active";  
}
$respFileStackUser = $con->query("SELECT * FROM tbl_users WHERE  userID='$userId'");
$rowFileStackUser=$respFileStackUser->fetch_array();
$stackFileNoUser=$rowFileStackUser['stackNumber']; 
$postUser=$rowFileStackUser['userName'];


$idd = $postUser;
$respLoginUser = $con->query("SELECT * FROM tbl_login WHERE  userName='$idd' order by id DESC");
$login_row=$respLoginUser->fetch_array();
        
        $loginTime=$login_row['loginTime'];
        $loginDate=$login_row['loginDate'];

$arrFrom = array("A","B",":","D","E",":","G","H"); 
$arrTo = array("E","F","-","H","I","-","K","L"); 
//post date time for stack file
// replace function for post date
$stringPostDate = $postDate;
$replacedPostDate=str_replace($arrFrom, $arrTo, $stringPostDate);
// replace function final date
$stringPostTime = $postTime;
if (strpos($stringPostTime, 'P') !== false) {
 // rtrim function for PM time
$stringTime = $postTime;
$trimmedPostTime=rtrim($stringTime, "PM.");
}elseif(strpos($stringPostTime,'A') !==false){
  // rtrim function for AM time
$stringTime = $postTime;
$trimmedPostTime=rtrim($stringTime, "AM.");
}
//final date time for stack file
// replace function for post date
$stringFinalDate = $finalDate;
$replacedFinalDate=str_replace($arrFrom, $arrTo, $stringFinalDate);
//check if AM or PM? then perform action.
$stringFinalTime = $finalTime;
if (strpos($stringFinalTime, 'P') !== false) {
 // rtrim function for PM time
$stringTime = $finalTime;
$trimmedFinalTime=rtrim($stringTime, "PM.");
}elseif(strpos($stringFinalTime,'A') !==false){
  // rtrim function for AM time
$stringTime = $finalTime;
$trimmedFinalTime=rtrim($stringTime, "AM.");
}
//final date time for idf file
// replace function for post date
$stringIdfFinalDate = $idfPostDate;
$replacedIdfFinalDate=str_replace($arrFrom, $arrTo, $stringIdfFinalDate);
//check if AM or PM? then perform action.
$stringIdfPostTime = $idfPostTime;
if (strpos($stringIdfPostTime, 'P') !== false) {
 // rtrim function for PM time
$stringIdfTime = $idfPostTime;
$trimmedIdfPostTime=rtrim($stringIdfTime, "PM.");
}elseif(strpos($stringIdfPostTime,'A') !==false){
  // rtrim function for AM time
$stringIdfTime = $idfPostTime;
$trimmedIdfPostTime=rtrim($stringIdfTime, "AM.");
}
// replace function for login date
$stringLoginDate = $loginDate;
$replacedLoginDate=str_replace($arrFrom, $arrTo, $stringLoginDate);
//check if AM or PM? then perform action.
$userLoginTime = $loginTime;
if (strpos($userLoginTime, 'P') !== false) {
 // rtrim function for PM time
$stringLoginTime = $loginTime;
$trimmedLoginTime=rtrim($stringLoginTime, "PM.");
}elseif(strpos($userLoginTime,'A') !==false){
  // rtrim function for AM time
$stringLoginTime = $loginTime;
$trimmedLoginTime=rtrim($stringLoginTime, "AM.");
}
//concatenating post date and post time
$startFullDateTime=$replacedPostDate." ".$trimmedPostTime;
$finalFullDateTime=$replacedFinalDate." ".$trimmedFinalTime;
$finalIdfFullDateTime=$replacedIfdFinalDate." ".$trimmedIfdPostTime;
$finalLoginFullDateTime=$replacedLoginDate." ".$trimmedLoginTime;
//real date/time without rtrim function ie AM/PM included
$startFullDateTimeReal=$replacedPostDate." ".$postTime;
$finalFullDateTimeReal=$replacedFinalDate." ".$finalTime;
//date finction to calculate difference
   $strStart = $startFullDateTime; 
   $strEnd   = $finalFullDateTime; 
   $dteStart = new DateTime($strStart); 
   $dteEnd   = new DateTime($strEnd);
   $dteDiff  = $dteStart->diff($dteEnd); 
   //difference date function for login
   $strStartLogin = $finalLoginFullDateTime; 
   $strEndLogin   = $finalFullDateTime; 
   $dteStartLogin = new DateTime($strStartLogin); 
   $dteEndLogin   = new DateTime($strEndLogin);
   $dteDiffLogin  = $dteStartLogin->diff($dteEndLogin); 
   //bol
   $strStartBol = $startFullDateTime; 
   $strEndBol   = $finalIdfFullDateTime; 
   $dteStartBol = new DateTime($strStartBol); 
   $dteEndBol   = new DateTime($strEndBol);
   $dteDiffBol  = $dteStartBol->diff($dteEndBol); 
   // echo $dteDiff->format("%Y yrs %Mmonths %Ddays  %H hours %Imins %Ssecs");
   $loginDateTime=$loginDate." ".$loginTime; 
   if($rowFileStackUser['user_status']==1){
  $onlineOffline="Online since ".$loginDateTime;
}elseif($rowFileStackUser['user_status']==0){
  $onlineOffline="Offline ".$dteDiffLogin->format( "%D dys %H Hrs %I mins ago");
}
    
?>
<div class="panel panel-primary">
 <div class="panel-heading">
 <i class="icon-bell"><center><?php echo $bolFile; ?> File for  Client <strong><?php echo $fileOwner; ?></strong> posted on <strong><?php echo $startFullDateTimeReal; ?></strong><strong></center></i> 
  </div>
 <div class="panel-body">
 <div class="list-group">
 <a href="#" class="list-group-item">
 <i class=" icon-comment"></i>File No.:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<em><hh style="color: grey;"><?php echo $stackFileNo;?></hh></em>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Posted:
 <span class="pull-right text-muted small"><em><?php echo $dteDiff->format("%Y Ys %M Mons %D dys %H Hrs %I mins ago")?></em>
 </span>
 </a>
 <a href="#" class="list-group-item">
 <i class="icon-twitter"></i>Client.:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<em><hh style="color: grey;"><?php echo $fileOwner;?></hh></em>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Client Email:
 <span class="pull-right text-muted small"><em><?php echo $ownerEmail ?></em>
 </span>
 </a>
  <a href="#" class="list-group-item">
 <i class="icon-tasks"></i>Client No.:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<em><hh style="color: grey;"><?php echo $ownerNumber;?></hh></em>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Document Closed:
 <span class="pull-right text-muted small"><em><?php echo $idfPostedDate ?></em>
 </span>
 </a>
 <a href="#" class="list-group-item">
 <i class="icon-envelope"></i>File Status.:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<em><hh style="color: grey;"><?php echo $fileStatus;?></hh></em>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Time Taken: 
 <span class="pull-right text-muted small"><em><?php echo $dteDiffBol->format("%D dys %H Hrs %I Mins")?></em>
 </span>
 </a>
 <a href="#" class="list-group-item">
 <i class="icon-upload"></i>Import Dec. No.:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<em><hh style="color: grey;"><?php echo $idfNumber;?></hh></em>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Shipper Name:
 <span class="pull-right text-muted small"><em><?php echo $shipperName ?></em>
 </span>
  </a>
  <a href="#" class="list-group-item">                         
  <i class="icon-upload"></i>Shipper Adress.:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<em><hh style="color: grey;"><?php echo $shipperAdress;?></hh></em>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Shipper Location:
 <span class="pull-right text-muted small"><em><?php echo $shipperLocation ?></em>
 </span>
  </a> 
 <a href="#" class="list-group-item">                         
  <i class="icon-upload"></i>Consignee Name.:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<em><hh style="color: grey;"><?php echo $consigneeName;?></hh></em>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Consignee Adress:
 <span class="pull-right text-muted small"><em><?php echo $consigneeAdress ?></em>
 </span>
  </a>
  <a href="#" class="list-group-item">                         
  <i class="icon-upload"></i>Consignee Location:&nbsp;&nbsp;&nbsp;<em><hh style="color: grey;"><?php echo $consigneeLocation;?></hh></em>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Measurement in CBM:
 <span class="pull-right text-muted small"><em><?php echo $measurement ?></em>
 </span>
  </a>
     <a href="#" class="list-group-item">                         
  <i class="icon-upload"></i>Loading Port.:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<em><hh style="color: grey;"><?php echo $loadingPort;?></hh></em>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Discharge Port.:
 <span class="pull-right text-muted small"><em><?php echo $dischargePort ?></em>
 </span>
  </a>
   <a href="#" class="list-group-item">
  <i class=" icon-money"></i>Personelle Incharge.:&nbsp;&nbsp;<em><hh style="color: grey;"><?php echo $postUser; ?></hh></em>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Status.:
<span class="pull-right text-muted small"><em><?php echo $onlineOffline; ?></em>
 </span>
  </a>
   </div>

  </div>
   </div>
<?php
}
}


 ?>

</body>
</html>