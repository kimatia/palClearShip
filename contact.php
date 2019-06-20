


<?php
error_reporting( ~E_NOTICE ); // avoid notice
  
  require_once 'dbconfig.php';
  
  if(isset($_POST['btnsave']))
  {
    $username = $_POST['name'];// user name
    $email = $_POST['email'];// user email
    $message = $_POST['message'];// user message
    
    
    
    // if no error occured, continue ....
    if(!isset($errMSG))
    {
      $stmt = $DB_con->prepare('INSERT INTO tbl_message(name,email,message) VALUES(:uname, :umail, :utxt)');
      $stmt->bindParam(':uname',$username);
      $stmt->bindParam(':umail',$email);
      $stmt->bindParam(':utxt',$message);
      
      if($stmt->execute())
      {
        $successMSG = "Message sent...";
      }
      else
      {
        $errMSG = "Error while sending message....";
      }
    }
  }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Palm | Contact</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="css/coin-slider.css" />
<script type="text/javascript" src="js/cufon-yui.js"></script>
<script type="text/javascript" src="js/cufon-titillium-600.js"></script>
<script type="text/javascript" src="js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="js/script.js"></script>
<script type="text/javascript" src="js/coin-slider.min.js"></script>
<!-- Bootstrap Core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

</head>
<body>
<div class="main">
    <div class="header">
    <div class="header_resize">
      <div class="logo">
        <h1><a href="index.php">Palm Freighters<span></span> <small>Limited</small></a></h1>
      </div>
      <div class="searchform">
        <form id="formsearch" name="formsearch" method="post" action="#">
          <span>
          <input name="editbox_search" class="editbox_search" id="editbox_search" maxlength="80" value="Search our ste:" type="text" />
          </span>
          <input name="button_search" src="images/search.gif" class="button_search" type="image" />
        </form>
      </div>
      <div class="clr"></div>
      <div class="slider" >
        <div id="coin-slider">
         <a href="#"><img src="imgs/slide1.jpg" width="940" height="310" alt="" /> </a>
         <a href="#"><img src="imgs/slide2.jpg" width="940" height="310" alt="" /> </a>
         <a href="#"><img src="imgs/slide3.jpg" width="940" height="310" alt="" /> </a>
         <a href="#"><img src="imgs/slide4.jpg" width="940" height="310" alt="" /> </a>
         <a href="#"><img src="imgs/slide5.jpg" width="940" height="310" alt="" /> </a>
         </div>
        <div class="clr"></div>
      </div>
      <div class="clr"></div>
       <div class="menu_nav">
        <ul>
          <li class="active"><a href="index.php"><span>Home Page</span></a></li>
          <li><a href="support.php"><span>Support</span></a></li>
          <li><a href="about.php"><span>About Us</span></a></li>
          <li><a href="services.php"><span>Services</span></a></li>
          <li><a href="contact.php"><span>Contact Us</span></a></li>
          <li><a href="#"><span>Projects</span></a></li>
           <li><a href="login.php"><span>Login</span></a></li>
        </ul>
      </div>
      <div class="clr"></div>
    </div>
  </div>
  <div class="content">
    <div class="content_resize">
      <div class="mainbar">
        <div class="article">
          <h2><span>Contact</span></h2>
          <div class="clr"></div>
          <p>Nullapede laorem velit curabitudin enim in nibh ero leo in pede. Semperpurus nibh elit et convallis eu trices congue males monterdum elit.</p>
        </div>
        <div class="article">
          <h2><span>Send us</span> mail</h2>
          <div class="clr"></div>
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
  }
  ?> 
          <form method="post"  enctype="multipart/form-data" class="form-horizontal">
            <ol>
              <li>
                <label for="name">Name (required)</label>
                <input type="text" name="name" placeholder="Type your Name here">
              </li>
              <li>
                <label for="email">Email Address (required)</label>
               <input type="text" name="email" placeholder="Type your email id here"><br>
              </li>
              <li>
                <label for="message">Your Message</label>
                <textarea type="text" name="message" placeholder="Type your Message" rows="8" cols="50"></textarea>
                
              </li>
              <li>
                <input type="submit" name="btnsave" id="imageField" src="images/submit.gif" class="send" />
                <div class="clr"></div>
              </li>
            </ol>
          </form>
        </div>
      </div>
      <div class="sidebar">
        <div class="gadget">
          <h2 class="star"><span>Sidebar</span> Menu</h2>
          <div class="clr"></div>
         <ul class="sb_menu">
            <li><a href="index.php">Home</a></li>
            <li><a href="support.php">Support</a></li>
            <li><a href="about.php">About Us</a></li>
            <li><a href="services.php">Services</a></li>
            <li><a href="contact.php">Contact Us</a></li>
            <li><a href="login.php">Login</a></li>
          </ul>
        </div>
        
      </div>
      <div class="clr"></div>
    </div>
  </div>
 <div class="fbg">
    <div class="fbg_resize">
     <div class="col c1">
        <h2><span>Image</span> Gallery</h2>
        <a href="#"><img src="imgs/Albert.JPG" width="75" height="75" alt="" class="gal" /></a> <a href="#"><img src="imgs/container6.jpg" width="75" height="75" alt="" class="gal" /></a> <a href="#"><img src="imgs/container7.jpg" width="75" height="75" alt="" class="gal" /></a> <a href="#"><img src="imgs/palm.png" width="75" height="75" alt="" class="gal" /></a> <a href="#"><img src="imgs/palmjet.jpeg" width="75" height="75" alt="" class="gal" /></a> <a href="#"><img src="imgs/container8.jpg" width="75" height="75" alt="" class="gal" /></a> </div>
      <div class="col c2">
        <h2><span>Services</span> Overview</h2>
        <p>Palm Freighters Limited was incorporated and registered under the companies act of Kenya on 18 th March,
1998 and issued with certificate No. CPR/1998/80218. It was established to offer three major Services
namely Clearing & Forwarding of Cargo, Transportation and Warehousing.</p>
       
      </div>
      <div class="col c3">
        <h2><span>Contact</span> Us</h2>
      
        <p class="contact_info"> <span>Address:</span>Buzeki area off Moi Avenue and dock section near showroom<br />

          <span>Building:</span>Palm Building 1 & 2 ND Floor<br />
          <span>Location:</span> Buzeki<br />
          <span>Telephone:</span> +254725960603<br />
          <span>BOX:</span> 40512-80100<br />
          <span>County:</span> Mombasa Kenya<br />
          <span>E-mail:</span> <a href="#">palm2006@yahoo.com</a> </p>
      </div>
      <div class="clr"></div>
    </div>
  </div>
  <div class="footer">
   <div class="footer_resize">
      <p class="lf">&copy; Copyright <a href="http://www.palmlimited.co.ke">Palm Freighters Limited | All Rights Reserved</a>.</p>
      <p class="rf">Design by Dream <a href="http://www.dayshare.com">kimatia Daniel</a></p>
      <div style="clear:both;"></div>
    </div>
  </div>
</div>
</body>
</html>
