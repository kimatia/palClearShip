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

  <div class="panel panel-primary">
  <div class="col-md-12">
        <div class="panel panel-default">
                        
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th><p style="font-size: 12px;">Cost ID</p></th>
                                            <th><p style="font-size: 12px;">Cost Type</p></th>
                                            <th><p style="font-size: 12px;">Cost Description</p></th>
                                            <th><p style="font-size: 12px;">Cost Amount</p></th>
                                        </tr>
                                    </thead>
                                    <tbody>
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
  // select row from db to display
  $stmt_select = $DB_con->prepare('SELECT DISTINCT stackNumber FROM tbl_stacks WHERE id =:uid');
  $stmt_select->execute(array(':uid'=>$_GET['id']));
  $rowStack=$stmt_select->fetch(PDO::FETCH_ASSOC);//retursn value as associative array.                                  
  $stackNumber=$rowStack['stackNumber'];
  $stmt = $DB_con->prepare('SELECT * FROM tbl_costs WHERE stackNumber=:ustack ORDER BY id DESC');
  $stmt->execute(array(':ustack'=>$stackNumber));

  if($stmt->rowCount() > 0)
  {
    while($row=$stmt->fetch(PDO::FETCH_ASSOC))
    {
      extract($row);
      ?>
         <tr>
            <td><p style="font-size: 12px;"><?php echo $row['id']; ?></p></td>
            <td>
            <?php 
            $costType=$row['costType']; 
            if($costType==1){
            ?>
<h6 style="font-size: 12px;">Transport Costs</h6>
            <?php
            }elseif ($costType==2) {
            ?>
<h6 style="font-size: 12px;">Customs Costs</h6>
            <?php
            }elseif ($costType==3) {
           ?>
<h6 style="font-size: 12px;">Carrier Costs</h6>
            <?php
            }
            elseif ($costType==4) {
           ?>
<h6 style="font-size: 12px;">Full Container Load</h6>
            <?php
            }
            elseif ($costType==5) {
              ?>
<h6 style="font-size: 12px;">Less Container Load</h6>
          <?php
            }
            elseif ($costType==6) {
              ?>
<h6 style="font-size: 12px;">Cargo Insurance</h6>
          <?php
            }
            elseif ($costType==7) {
          ?>
<h6 style="font-size: 12px;">Currency Adjustment Factor</h6>
          <?php
            }
            elseif ($costType==8) {
           ?>
<h6 style="font-size: 12px;">Office Related</h6>
          <?php
            }
            elseif ($costType==9) {
            ?>
<h6 style="font-size: 12px;">Field Costs</h6>
          <?php
            }
            elseif ($costType==10) {
           ?>
<h6 style="font-size: 12px;">Misslaneous Costs</h6>
           <?php
            }
            ?>  
            </td>
            <td><p style="font-size: 12px;"><?php echo $row['costDescription']; ?></p></td>
            <td><p style="font-size: 12px;"><?php echo $row['costAmount']; ?></p></td>
         </tr>
      <?php
    }
  }
  else
  {
    ?>
        <div class="col-xs-12">
          <div class="alert alert-warning">
              <span class="glyphicon glyphicon-info-sign"></span> &nbsp; No Cost Data Found ...
            </div>
        </div>
        <?php
  }
  
?>
                                        
                                       
                                    </tbody>
                                    
                                </table>
                            </div>
                        </div>
                        <div class="panel-footer">
                        <?php
  $stmt_select_total = $DB_con->prepare('SELECT DISTINCT stackNumber FROM tbl_stacks WHERE id =:uidd');
  $stmt_select_total->execute(array(':uidd'=>$_GET['id']));
  $rowStack_total=$stmt_select_total->fetch(PDO::FETCH_ASSOC);//retursn value as associative array.                                  
  $stackNumberUnique=$rowStack_total['stackNumber'];
  $stmt_total = $DB_con->prepare('SELECT sum(costAmount) as total FROM tbl_costs WHERE stackNumber=:ustackk');
  $stmt_total->execute(array(':ustackk'=>$stackNumberUnique));
  $rowTotal=$stmt_total->fetch(PDO::FETCH_ASSOC);
   ?>
<strong style="font-size: 15px;">Total KES <pp style="color: orange;"><?php echo $rowTotal['total'] ?></pp></strong>
   <?php
  
?>
           
    </div>
                    </div>              
  </div>
  </div>
                          
</body>
</html>
                         
                        
