<?php

$data_file = file_get_contents('../admin/app-data.json');
$dd = json_decode($data_file);


$onesignalrestkey = "ZDdhODg2Y2EtZWRmOC00NTQ1LWFmM2UtZWJiYmVhOGE3NmJk";

$onesignalappid = "afaf5f3b-e41e-4204-b1d2-de7e91a5b860";

$defaultpass = "osdvadmin";
$masterkey = "nayem";

define( '_COLOR_PRIMARY_', $dd->primary_color );
define( '_COLOR_GRADIENT_END_', $dd->gradient_color_end);