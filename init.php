<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

define( 'BASE_URL' , __DIR__ . '/../..' );
define( 'APP_ROOT' , BASE_URL . '/app' );
define( 'ADMIN_ROOT' , BASE_URL . '/admin' );

$data_file = BASE_URL . "/admin/app-data.json";
$app_data = json_decode(file_get_contents($data_file), true);

foreach( $app_data as $key => $val ) {
	$$key = $val;
}

$registration = $reg_status == 1;
$payment = $withdraw_status == 1;
$vpn_required = $req_vpn == 1;

$cn_list = str_replace(' ', '', $cn_list);
$ALLOWED_LOCATIONS = explode(',', $cn_list);