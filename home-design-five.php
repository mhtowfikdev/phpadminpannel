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
	<link rel="stylesheet" href="css/style.css" >
	
	<link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@500&display=swap" rel="stylesheet">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	 <!-- modal 
	 <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
	 <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
	 <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>-->
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

 <!-- auto modal -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

	<style>
	
		<?php include 'css/custom-style.php' ?>
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
	        background: #4CAF50;
	        box-shadow: 1px 1px 1px 1px rgba(0,0,0,0.2);
		}
	</style>

    
</head>
<body class="bg-primary">
   <div class="">
       <section class="profile" id="userData">
           <div class="user-block">
               <div class="icon">
                   <img src="https://invisiblelab.xyz/images/user.png" height="100px" width="100px"/>
               </div>
               <div class="userinfo">
                   <h4> <?= $user_data['fname'] ?? 'Shimul Ahmed' ;?></h4>
                   <h4 style="color : #e8e8e8"> <?= $user_data['mobile'] ?? '1234' ; ?></h4> <br>
                   <h4 style="color : #eee">Your Balance:</h4>
                   <h4><font style="font-family: 'Material Icons';">payments</font> <?= $user_data['balance'] ?? '1000' ;?></h4>
               </div>
           </div>
       </section>
       <section class="block-header">
           <div class="title">
               
           </div>
       </section>   
       <section class="block-main">
           <?php if( $multi_task == 1 ) : ?><center>
           <div class="line1">
               <div onclick="location.href='<?= $task1_url ?? '#'?>'" class="item">
                   <i class="material-icons icons">filter_1</i> <br>
                   App 1
               </div>
               <div onclick="location.href='<?= $task2_url ?? '#'?>'" class="item">
                   <i class="material-icons icons">filter_2</i> <br>
                   App 2
               </div>
               
                <div onclick="location.href='<?= $task3_url ?? '#'?>'" class="item">
             
                   <i class="material-icons icons">filter_3</i> <br>
                   App 3
               </div>
               
           </div></center>
           <?php endif ?>
           
           <center>
           <div class="line1">
               <?php if( $multi_task != 1 ) : ?>
               <?php if( $spin == 1 ) : ?>
               <?php if ( $spin_enabled == 0 ) : ?>
               <div class="item">
                   <i class="material-icons icons">assistant</i> <br>
                   <span id="">Spin Closed!</span></div>
               	<?php else : ?>
               <div id="vpn" onclick="Android.spinActivity()" class="item">
                   <i class="material-icons icons">assistant</i> <br>
                   <span id="off">Play Spin</span>
               </div>
               <?php endif ?>
               <?php endif ?>
               <?php if( $task == 1 ) : ?>
               <?php if ( $task_enabled == 0 ) : ?>
               <div class="item">
                   <i class="material-icons icons">assistant</i> <br>
                   <span id="">Task Closed!</span></div>
               	<?php else : ?>
               <div id="vpn" onclick="Android.taskActivity()" class="item">
                   <i class="material-icons icons">add_task</i> <br>
                   <span id="off">Start Task</span>
               </div>
               <?php endif ?>
               <?php endif ?>
               
               <?php else : ?>
               <div onclick="location.href='<?= $task4_url ?? '#'?>'" class="item">
             
                   <i class="material-icons icons">filter_4</i> <br>
                   App 4
               </div>
               <?php endif ?>
               <div onclick="Android.openWebActivity('Profile', 'profile')" class="item">
                   <i class="material-icons icons">account_box</i> <br>
                   Profile
               </div>
               
                <div id="d_succes" class="item">
             
                   <i class="material-icons icons">event_available</i> <br>
                   Daily Bonus
               </div>
               
           </div></center><center>
            <div class="line1">
               <div onclick="Android.openWebActivity('Leaderboard', 'leaderboard')" class="item">
                    <i class="material-icons icons">public</i> <br>
                   Leaderboard
               </div>
               <div onclick="Android.openWebActivity('Wallet', 'wallet')" class="item">
                  <i class="material-icons icons">account_balance</i> <br>
                   Withdraw
               </div>
               <div onclick="Android.openWebActivity('Payment History', 'payments')" class="item">
                   <i class="material-icons icons">pending_actions</i> <br>
                   History
               </div>
           </div></center>
           <center>
            <div class="line1">
                <?php if(empty($htw_link)) : ?>
                <div id="htw" class="item">
                <?php else : ?>
               <div onclick="location.href='<?= $htw_link ?? '#'?>'" class="item">
                 <?php endif ?>
                   <i class="material-icons icons">live_tv</i> <br>
                   How to Work
               </div>
               <div type="button" data-toggle="modal" data-target="#myModal" class="item">
                   <i class="material-icons icons">notifications_active</i> <br>
                   Notice
               </div>
               <div onclick="location.href='<?= $support_group ?>'" class="item">
                   <i class="material-icons icons">support_agent</i> <br>
                   Support
               </div>
           </div></center>
       </section>
       <?php include 'developer.php'; ?>
   </div>
<br>

<!--Home Notice Modal -->

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog modal-sm" role="document">
			<div class="modal-content">
				<div class="modal-body">
					<p class="lead">
		<?= nl2br( text2link($home_notice) ) ?></p>
				</div>
				<div class="modal-footer">
					<p class="btn btn-dialog" data-dismiss="modal" style="font-family: 'Hind Siliguri', sans-serif;text-align: left; color : black  ">Close</p>
					
				</div>
			</div>
		</div>
	</div>
	

<!--Button Notice Modal -->

<div class="modal fade" id="newModal" tabindex="-1" role="dialog">
		<div class="modal-dialog modal-sm" role="document">
			<div class="modal-content">
				<div class="modal-body">
					<p class="lead">
		<?= nl2br( text2link($important_notice) ) ?></p>
				</div>
				<div class="modal-footer">
					<p class="btn btn-dialog" data-dismiss="modal" style="font-family: 'Hind Siliguri', sans-serif;text-align: left; color : black  ">Close</p>
					
				</div>
			</div>
		</div>
	</div>




<?php if( $user_data['i_click'] > $invalid_limit ) : ?><script>Android.blockAlert(2)</script><?php endif ?>
<?php if($user_data['today_click'] == 0 || $user_data['today_spin'] == 0)  : ?>
<script>
$(document).ready(function(){
    $("#newModal").modal("show");  
});
</script>
<?php endif ?>

	
	<script type="text/javascript">
		$(document).ready(function() {
			setInterval(function () {
				$('#userData').load('user-data.php')
			}, 4000);
			
		});
		Android.setUserAccount("<?= base64_encode($token) ?>");
		
	</script>
    	<?php if( $req_vpn == 1 ) : ?>
    		<script> 
    	let allowedLocations = "<?= $cn_list ?>";

$.get("https://ipinfo.io?token=<?= $i_key ?>", function(response) {
  if(!allowedLocations.includes(response.country)) {
    $('#vpn').prop("onclick", null).off("click");
    $('#off').html('Connect VPN');
   
  };
}, "jsonp")
    	</script>
    	
    	
    	<?php endif ?>
	    
    	<?php if( $user_data['d_bonus'] == 1) :?>
    	<script>
    	   $(document).on('click', '#d_succes', function(e) {
			swal.fire(
				'Sorry!',
				'Already Claimed!',
				'error'
			)
		});

    	</script>
    	
    	<?php else :?>  
    	<script type="text/javascript">
        $(document).ready(function(){
            $("#d_succes").click(function(){

                    swal.fire({title:'Bonus', 
                        text:'Do you want to collect daily bonus?', 
                        icon:'warning', 
                        buttons: true, 
                        dangerMode: true,
                        allowOutsideClick: false
                    })
                    .then((willOUT) => {
                            if (willOUT) {
                                  window.location.href = 'dbtf.php', {
                                  icon: 'success',
                                }
                              }
                    });

            });
        });
    </script>
    
    <?php endif ?> 
    <script>
    	   $(document).on('click', '#htw', function(e) {
			swal.fire(
				'Opps!',
				'How to Work linked not Available!',
				'error'
			)
		});

    	</script>

  
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