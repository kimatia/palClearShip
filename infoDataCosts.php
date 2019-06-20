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
ini_set('display_errors', 1);
//db connection
require_once 'dbconfig.php';

//get the logged in user credentials and validate
require_once 'class.user.php';
$user_home = new USER();

if(!$user_home->is_logged_in())
{
 $user_home->redirect('login.php');
}

?>

                    
                     <div class="panel panel-primary">
                     <div class="col-md-12">
                      <form method="post">
                      <input type="hidden" value="<?php echo $_GET['id']; ?>" name="stackID">
                             <div class="form-group">
                                 <label for="cost">Type of Cost</label>
                                 <?php 
// select row from db to display
  $stmt_select_stack = $DB_con->prepare('SELECT DISTINCT stackNumber FROM tbl_stacks WHERE id =:uid');
  $stmt_select_stack->execute(array(':uid'=>$_GET['id']));
  $rowStackStack=$stmt_select_stack->fetch(PDO::FETCH_ASSOC);//retursn value as associative array.
  $stackNumber=$rowStackStack['stackNumber'];
  //select 
  $stmt_select_name = $DB_con->prepare('SELECT * FROM tbl_costs_name');
  $stmt_select_name->execute();
 
                                 ?>
        <select class="form-control" name="category">
        <?php while($rowStackName=$stmt_select_name->fetch(PDO::FETCH_ASSOC)){?>
          <?php
          $costID=$rowStackName['costID'];
// select row from db to display
  $stmt_select = $DB_con->prepare('SELECT * FROM tbl_costs WHERE stackNumber=:ustack');
  $stmt_select->execute(array(':ustack'=>$stackNumber));
  $rowStack=$stmt_select->fetch(PDO::FETCH_ASSOC);//retursn value as associative array. 
          ?>

<?php
if($rowStack['costType']!==$rowStackName['costID']){
?>
<option value="<?php echo $rowStackName['category']; ?>" style="color: black;">
        <?php echo $rowStackName['costID'].".".$rowStackName['costType']; ?>
        </option>
<?php
}elseif ($rowStack['costType']==$rowStackName['costID']) {
  ?>
<option value="<?php echo $rowStackName['category']; ?>" style="color: blue;">
        <?php echo $rowStackName['costID'].".".$rowStackName['costType']; ?>
        </option>
<?php
}
?>
        
        
        <?php } ?>
        </select>
                                
                              
                             </div>
                             <div class="form-group">
                                 <label for="cost">Description of Cost</label>
                                 <textarea class="form-control" id="zipca" type="text" name="costDesc" placeholder="Cost Description" ></textarea>
                             </div>
                             <div class="form-group">
                                 <label for="cost">Amount of Cost</label>
                                 <input class="form-control" type="text" name="costAmt" placeholder="KSH" >
                             </div>

                              <button class="btn btn-primary btn-outline" type="submit" name="btn-add-costs"> Save</button>
                          </form>
                          </div>
                          </div>
                          
</body>
</html>
                         
                        
