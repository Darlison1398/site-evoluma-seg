<?php

//error_reporting(E_ALL);
//ini_set('display_error', 0);


@session_start();
$_SESSION['lgpd'] = true;


Header('Access-Control-Allow-Origin: *');
Header('Content-Type: application/json');
Header('Access-Control-Allow-Method: POST');

$json = ['ok' => $_SESSION['lgpd']];

echo json_encode($json);
?>