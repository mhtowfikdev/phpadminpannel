<?php
session_start();
require_once('functions.php');

require_once('dbconnection.php');
require_once(__DIR__ . '/../dev-control.php');
require_once('includes/init.php');
$newpass = $_GET['new'];
$failed = false;
if ($newpass == 'new'){
    snack( 'success', 'Enter new password' );
    
}
if ( isset($_POST['admin-login']) ) {
    $userpass =  md5($_POST['pwd']);
    $query = "SELECT * FROM admins WHERE username='invisible' AND password='$userpass'";
    $results = mysqli_query($conn, $query);
     if (mysqli_num_rows($results) == 1) {
      $_SESSION['password'] = $userpass;
      start_admin_session($userpass);
  	  header('location: index.php');
	}
	
	else{
	snack( 'error', 'Incorrect password' );
}
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Admin Login</title>
		<meta name="theme-color" content="#f9fbfd">
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=false, shrink-to-fit=no">
		<link rel="stylesheet" href="css/style.css">
		<link rel="shortcut icon" href="icon.ico">
		<link defer rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
		
		<style>
			.login-form-container {
				max-width: 320px;
				margin: auto;
				padding: 1em;
				background: #FFF;
				color: #020202;
			}
			
			.login-form {
				text-align: center;
			}
			
			.admin-icon {
			    font-size: 1.4em;
			}
			
			.material-icons {
			    user-select: none;
			}
		</style>
		
	</head>
<body class="bg-gray-200">
		
		<main>
			
			<section class="login-form-container fr-container">
				<form class="login-form" class="text-center" action="" autocomplete="off" autocapitalize="off" method="POST">
					
					<h2 class="text-primary pt-1"><i class="admin-icon material-icons">local_police</i></h2>
					<h3 class="pb-3 pt-1">Admin Login</h3>
					
											
					<div class="input-group mb-3">
						<input id="pwd-input" class="form-control" name="pwd" type="password" required>
						<div class="input-group-append">
                            <span class="input-group-text py-0">
                                <i id="toggle-btn" class="material-icons" style="font-size: 22px">visibility_off</i>
                            </span>
    					</div>
    				</div>
					
					<button name="admin-login" type="submit" class="btn btn-block btn-primary btn-lg">Login</button>
				</form>
			</section>
		</main>
	<footer>
		            <div id="ajax-div"></div>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
		<script src="js/script.js"></script>		</footer>
		
		<script>
		    $('#toggle-btn').click(e => {
		        if($('#pwd-input').attr('type') == "password") {
		            $('#pwd-input').attr('type', "text");
		            $('#toggle-btn').html("visibility");
		        } else {
		            $('#pwd-input').attr('type', "password");
		            $('#toggle-btn').html("visibility_off");
		        }
		    })
		</script>
		
	</body>
</html>