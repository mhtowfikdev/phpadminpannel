<?php
session_start();
require_once('includes/init.php');

$mobile=$_SESSION['mobile'];
$time = time()+100;
$res=mysqli_query($conn,"update users set onlineStatus=$time where mobile=$mobile");

?>