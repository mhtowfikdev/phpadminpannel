<?php
require_once( __DIR__ . '/constants.php' );
/* ============================================ */

$servername = "localhost";

$database = "osdevelo_superpoint";

$username = "osdevelo_superpoint";

$password = '0!a9QAxm!+t5';


/* ============================================ */

$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>