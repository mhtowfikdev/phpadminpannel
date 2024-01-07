<?php
session_start();

require_once('functions.php');
require_once('dbconnection.php');
require_once('includes/init.php');

$password = $_SESSION['password'];
$admin_data = get_admin($conn, $password);
if ($password != $admin_data['password']) {
	header('location: login.php');
}
if ( !isset($_SESSION['password']) ) {
	header('location: login.php');
}
if ( empty( $admin_data ) ) header('location: login.php');
$pageTitle = 'Onesignal Notice';



if(isset($_POST['submit']))
{


    $content = array(
        "en" => "$_POST[one_msg]"
        );
    $headings = array(
        "en" => "$_POST[one_title]"
        );

    $fields = array(
        'app_id' => $onesignalappid,
        'headings' => $headings,
        'included_segments' => array('All'),
        'data' => array("foo" => "bar"),
        'large_icon' =>"ic_launcher_round.png",
        'contents' => $content
    );

    $fields = json_encode($fields);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
                                               'Authorization: Basic ' . $onesignalrestkey));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);    

    $response = curl_exec($ch);
    curl_close($ch);

    if(empty($onesignalrestkey) OR empty($onesignalappid)){
        
    snack ("error", "Failed");
    $success = true ;

        
    }else{
    snack ("success", "Success");
    $success = true ;
    }
    

}
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Panel</title>
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=false, shrink-to-fit=no">
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body class="bg-gray-200">
		<?php include("header.php") ?>
<main class="container">
<section class="fr-container fr-lg pb-0">
<section>
<form data-submit="true" id="form" class="mb-1" action="" autocomplete="off" method="POST">
<h4 class="py-2"><i>notifications</i>Send Onesignal Notice</h4>
<div class="form-group">
<label>Title</label>
<input type="text" rows=8 name="one_title" class="form-control" required>
</div>
<div class="form-group">
<label>Massage</label>
<textarea rows=8 name="one_msg" class="form-control" required></textarea>
</div>
<label>Launch URL</label>
<input type="text" rows=8 name="url" class="form-control">
</div>
<button id="btn-form-submit" name="submit" value="1" type="submit" class="fab bg-primary material-icons border-0 d-nonex">send</button>
</form>
</section></section>

</main>
<div id="ajax-div"></div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>