<?php


//error_reporting(E_ALL);
//ini_set('display_error', 1);


include_once(__DIR__ . '/../../core.php');
include_once(__DIR__ . '/../../db-adm.php');

Header('Access-Control-Allow-Origin: *');
Header('Content-Type: application/json');
Header('Access-Control-Allow-Method: POST');

$json = ['ok' => true, 'data' => [], 'err' => '', 'msg' => '', 'id_usuario' => 0, 'nivel_usuario' => 0];



if (isset($_SESSION['id_usuario']) && isset($_SESSION['email_usuario']) && isset($_SESSION['nivel_usuario'])) {
    $json['id_usuario'] = $_SESSION['id_usuario'];
    $json['email_usuario'] = $_SESSION['email_usuario'];
    $json['nivel_usuario'] = $_SESSION['nivel_usuario'];
} else {
    $json['ok'] = false;
    $json['err'] = 'Você não está logado.';
}

echo json_encode($json);
exit(202);
?>