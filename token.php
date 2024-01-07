<?php
session_start();
require_once('includes/init.php');

$errors = array();

$_SESSION['token'] = null;
setcookie('token', '', time() - 3600);

if(isset($_POST['log_user']))
{
	$login_mobile = $_POST['mobile'];
	$login_password = $_POST['password'];
	$did = compactify($conn, $_POST['did']);
	
	# VALIDATE


	
	if (empty($login_mobile)) {
		array_push($errors, "Mobile is required");
	}
	
	if (empty($login_password)) {
		array_push($errors, "Password is required");
	}
	
	$mobile = compactify($conn, $login_mobile);
	$password = md5($login_password);
	
	if (count($errors) == 0) {
		$sql = "SELECT * FROM users WHERE mobile='$mobile'";
		$result = mysqli_query($conn, $sql);
		if (!mysqli_num_rows($result) == 1) {
			array_push($errors, "Mobile not found");
		}
	}
	

    if (count($errors) == 0) {
  	    $query = "SELECT * FROM users WHERE mobile='$mobile' AND password='$password'";
  	    $result = mysqli_query($conn, $query);
  	    if (mysqli_num_rows($result) == 1) {
			start_user_session(mysqli_fetch_assoc($result)['token']);
  	        header('location: index.php?' . http_build_query($_GET));
  	    } else {
  		    array_push($errors, "Incorrect password");
        }
    }
    
    $errors = array_slice($errors, 0, 2);
	
}

mysqli_close($conn);

?>
<!DOCTYPE html>
<html>
<head>
    <title>Log In</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=false">
    <link rel="stylesheet" href="css/style.css">
    <link defer rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
 <link href="https://fonts.googleapis.com/css?family=Nunito:600,700,900" rel="stylesheet">
    <style>
		<?php include 'css/custom-style.php' ?>
		#body {
  font-family: 'Nunito';
background-color:  #5d8fc9;
}
#login-card{
    width:350px;
    border-radius: 25px;
    margin:150px auto;
  
}

#email{
    border-radius:30px;
    background-color: #ebf0fc;
    border-color: #ebf0fc;
    color: #9da3b0;
    width: 60%;
}

#button{
    border-radius:30px;
    width: 60%;
    color:white;

}

#btn{
   position: absolute; 
   bottom: -35px; 
   padding: 5px;
   margin: 0px 55px;
   align-items: center;
   border-radius: 5px"
}
#container{
    margin-top:25px;
}

.btn-circle.btn-sm { 
            width: 40px; 
            height: 40px; 
            padding: 2px 0px; 
            border-radius: 25px; 
            font-size: 14px; 
            text-align: center;
            
            margin: 8px;
        }
.logoicon{
    position: absolute; 
   top: -50px; 
   margin: 0;
   align-items: center;
   display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
}    
.logoicon img{
   margin: 0;
   align-items: center;
   border-radius: 50%;
   border: 3px solid white;
   display: flex;
    justify-content: center;
    align-items: center;
}

	</style>
</head>
<body class="bg-primary">  
<section class="topbar">
   <br><br><br><br><br><br>
</section>
<div class="notice-bg">
<div class="notice-block">
  <div class="logoicon">
                   <img src="https://infinitylabbd.com/icon/pr.png" height="100px" width="100px"/>
               </div>

  <br><br><br><div class="box">
     <center>
  <form autocomplete="off" method="post" action="token.php">
      <?php foreach ($errors as $error) : ?>
  		  <p class="kalpurush gray"><?php echo $error ?></p>
       <?php endforeach ?>
       <input type="hidden" id="did" name="did">
            <script type="text/javascript">
                var did_app = Android.getDeviceId();
				document.getElementById("did").value = did_app;
            </script>
    <div class="form-group">
      <input type="number" class="form-control" id="email" placeholder="Enter Number" value="<?= $_POST['mobile'] ?? ''?>" name="mobile">
    </div>
    <div class="form-group">
      <input type="password" class="form-control" id="email" placeholder="Enter password" name="password">
    </div>
    
    <button  name="log_user" type="submit" id="button" class="btn bg-main deep-purple btn-block">LOGIN</button>
<br>
  </form>
  <div class=""><br>
 <font style="" onclick="Android.openWebActivity('Sign Up', 'sign-up')"> Don't have an account? Sign Up</font> 
</div><br>
  </center></div>
 </div>
<div>
  
  
  
  
   <!-- <div class="main">
        <form autocomplete="off" method="post" action="login.php">
            <h2>Sign In</h2>
<?php foreach ($errors as $error) : ?>
  		  <p class="message"><?php echo $error ?></p>
<?php endforeach ?>

            <input type="hidden" id="did" name="did">
            <script type="text/javascript">
                var did_app = Android.getDeviceId();
				document.getElementById("did").value = did_app;
            </script>
        
            <div class="input-container">
                <i class="fa fa-mobile icon"></i>
                <input class="input-field no-font" type="number" value="<?= $_POST['mobile'] ?? ''?>" placeholder="Mobile" name="mobile">
            </div>

            <div class="input-container">
                <i class="fa fa-lock icon"></i>
                <input class="input-field masque" type="password" placeholder="Enter password" name="password">
            </div>

            <button type="submit" name="log_user" class="exodus">Sign In</button>
        </form>
        <br />
        
        <button onclick="Android.openWebActivity('Sign Up', 'sign-up')" class="exodus">Sign Up</button>
        	
    </div>-->
    	  
  
    <section class="footer">
          <font onclick="Android.ctivity('Developer', 'INDEFINITE')"> Developed by INDEFINITE_LAb_BD</font>
       </section>	
	
</body>
</html>