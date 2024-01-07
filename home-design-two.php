<?php
session_start();
require_once('includes/init.php');

if(!empty($_GET['cp']) && !empty($_GET['cge'])) {
    $_SESSION['cp'] = $_GET['cp'];
    $_SESSION['cge'] = $_GET['cge'];
}

if($_GET['app'] == 'main') {
	$_SESSION['main_app'] = "1";
}

$_SESSION['token'] = $_COOKIE['token'] ?? null;

if ( !isset($_SESSION['token']) ) {
	header('location: login.php?' . http_build_query($_GET));
}

$token = $_SESSION['token'];

$user_data = get_user_by_token($conn, $token);

if ( empty( $user_data ) ) header('location: login.php?' . http_build_query($_GET));
?>


<!DOCTYPE html>
<html>
<head>

<title>Dashboard</title>
	<meta charset="utf-8">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=false">
	<link rel="stylesheet" href="css/style-two.css" >
	
	<link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@500&display=swap" rel="stylesheet">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

	 <!-- <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
	 <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
	 <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script> -->

  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

 <!-- auto modal -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

	<style>
	
	<?php include 'css/classical-style.php' ?>
		
		#htw button {
		    border: none;
	        font-weight: bold;
	        border-radius: 5px;
	        padding: 5px;
	        height: 60px;
        	width: 240px;
	        color: white;
	        outline: none;
	        margin: 10px auto;
	        display: inline-block;
	        background: #e8e8e8;
	        box-shadow: 1px 1px 1px 1px rgba(0,0,0,0.2);
		}
	</style>



	<!-- <title>Dashboard</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=false">
	<link rel="stylesheet" href="css/style.css" >
	<link defer rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" >
	<style>
	
	</style> -->




</head>
<body  class="profile">
	
	<section >
		
		<div class="user-info">
			<h2 class="masque"><?= $user_data['fname'] ?></h2>
			<strong><?= $user_data['mobile'] ?></strong>
		</div>
		
		<div id="userData">
		
		<table class="user-data">
			<tr>
				<td>Balance<p><?= $user_data['balance'] ?></p>
				<td rowspan="2" class="divider"><p></p></td>
				<td>Invalid Click<p><?= $user_data['i_click'] ?></p></td>
			</tr>
			<tr>
				<td>Total Refer<p><?= $user_data['t_ref'] ?></p>
				<td>Refer Code<p><?= $user_data['mobile'] ?></p></td>
			</tr>
		</table>
		
		</div>
	</section>

	
	<div class="notice-container " id ="userData">
	<?= nl2br( text2link($home_notice) ) ?>
	</div>
	
	<?php if ( $button_container ) : ?>
		
		<section>
			<?php if( $user_data['i_click'] > $invalid_limit ) : ?>
				<button class="earn-btn-exodus">Account Blocked</button>
				<script>Android.blockAlert(1)</script>
			<?php else : ?>
				<div class="btn-container">
					<a href="<?= $task1_url ?? ''?>"><button>Job 1</button></a>
					<a href="<?= $task2_url ?? ''?>"><button>Job 2</button></a>
					<a href="<?= $task3_url ?? ''?>"><button>Job 3</button></a>
					<a href="<?= $task4_url ?? ''?>"><button>Job 4</button></a>
				</div>
			<?php endif ?>
		</section>
		
	<?php else : ?>
	
		<section class="earn-btns">
			<?php if( $user_data['i_click'] > $invalid_limit ) : ?>
			
				<button class="earn-btn-exodus">Account Blocked</button>
				<script>Android.blockAlert(1)</script>
			
			<?php elseif ( $task_enabled == 0 ) : ?>
			
				<button class="earn-btn-exodus">Task Closed</button>
			
			<?php else : ?>

                <button style="margin: 10px;" id="task-btn" class="earn-btn-exodus" onclick="location.href='<?= $htw_link ?? '#'?>'">How to Work</button>

			
				<button style="margin-top: 10px;" id="task-btn" class="earn-btn-exodus" onclick="Android.taskActivity()">Start Task</button>
		
			<?php endif ?>
		</section>

        
		
	<?php endif ?>


    
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script type="text/javascript">

		// $(document).ready(function() {
		// 	setInterval(function () {
		// 		$('#userData').load('user-data.php')
		// 	}, 4000);
		// });
		// Android.setUserAccount("<?= $mobile ?>");


	</script>
	
	<?php if ( $task_did == 1 ) : ?>
		<script type="text/javascript">
		
			if ( !window.Android ) {
				$('#task-btn').html('Unsupported device');
            	$('#task-btn').onclick = null;
			}
			
			var did = '<?= $user_data['did'] ?>';
            var did_app = Android.getDeviceId();
            
            if ( did_app == null || did_app != did ) {
            	$('#task-btn').html('Use registered device');
            	$('#task-btn').prop('disabled', true);
            }
        </script>
    <?php endif ?>


	<script>
		function updateUserStatus(){
			jQuery.ajax({
				url:'update_user_status.php',
				success:function(){
					
				}
			});
		}
		
		setInterval(function(){
			updateUserStatus();
		},3000);
        
	  </script>
    	
</body>
</html>