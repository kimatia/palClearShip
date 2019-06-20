 


    <script src="js/jquery-1.11.3.min.js"></script>
    <script src="js/scriptChat.js"></script>
<?php
date_default_timezone_set("Africa/Nairobi");
session_start();
require_once 'dbconfig.php'; 
//get the logged in user credentials and validate
require_once 'class.user.php';
$user_home = new USER();

if(!$user_home->is_logged_in())
{
 $user_home->redirect('index.php');
}
$stmtt = $user_home->runQuery("SELECT * FROM tbl_users WHERE userID=:uid");
$stmtt->execute(array(":uid"=>$_SESSION['userSession']));
$row = $stmtt->fetch(PDO::FETCH_ASSOC);

//we can now access the users details from $row['appropriatedbfield']


  $stmtChatInbox = $DB_con->prepare("SELECT * FROM tbl_palmmessages WHERE totalUniqueChatId=:uid");
    $stmtChatInbox->execute(array(":uid"=>$_SESSION['chatTotal']));
    if($stmtChatInbox->rowCount() > 0)
    {
        while($rowChat=$stmtChatInbox->fetch(PDO::FETCH_ASSOC))
        {
          
           
?>
<style type="text/css">
	

.msg_body{
	background:white;
	height:40px;
	font-size:12px;
	padding:15px;
	
}
.msg_a{
	position:relative;
	background:#FDE4CE;
	padding:10px;
	min-height:10px;
	margin-bottom:5px;
	margin-right:10px;
	border-radius:5px;
}
.msg_a:before{
	content:"";
	position:absolute;
	width:0px;
	height:0px;
	border: 10px solid;
	border-color: transparent #FDE4CE transparent transparent;
	left:-20px;
	top:7px;
}


.msg_b{
	background:#EEF2E7;
	padding:10px;
	min-height:15px;
	margin-bottom:5px;
	position:relative;
	margin-left:10px;
	border-radius:5px;
	word-wrap: break-word;
}
.msg_b:after{
	content:"";
	position:absolute;
	width:0px;
	height:0px;
	border: 10px solid;
	border-color: transparent transparent transparent #EEF2E7;
	right:-20px;
	top:7px;
}

</style>
	<div class="msg_wrap">
		<div class="msg_body">
<?php
$sidChat=$rowChat['sid'];
if($sidChat==$_SESSION['userSession']){
?>
<div class="msg_b"><?php echo $rowChat['message'];?></div>
<?php	
}else{
	?>
<div class="msg_a"><?php echo $rowChat['message'];?></div>
	<?php
}
?>	
			<div class="msg_push"></div>
			
		</div>
	
</div>

<?php
        
     }
}
    
    
?>