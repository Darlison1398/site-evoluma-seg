<?php

//error_reporting(E_ALL);
//ini_set('display_error', 1);

include_once(__DIR__ . '/../../core.php');
include_once(__DIR__ . '/../../db-adm.php');

Header('Access-Control-Allow-Origin: *');
Header('Content-Type: application/json');
Header('Access-Control-Allow-Method: POST');

$json = ['ok' => true, 'data' => [], 'err' => '', 'msg' => ''];



$_SESSION['id_usuario'] = 0;
unset($_SESSION['id_usuario']);

$_SESSION['email_usuario'] = 0;
unset($_SESSION['email_usuario']);

$_SESSION['nivel_usuario'] = 0;
unset($_SESSION['nivel_usuario']);

if (!isset($_SESSION['id_usuario']) && !isset($_SESSION['nivel_usuario']) && !isset($_SESSION['email_usuario'])) {
    $json['ok'] = true;
    $json['msg'] = 'Você não está mais logado.';
} else {
    $json['err'] = 'Ocorreu um erro';
}

echo json_encode($json);
exit(503);


?>