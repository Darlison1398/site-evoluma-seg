<?php


// error_reporting(E_ALL);
// ini_set('display_error', 1);

const CAMPOS = "tabela";
const METHOD = 'GET';

include_once(__DIR__ . '/../../core.php');
include_once(__DIR__ . '/../../db-adm.php');


$schema = file_get_contents(__DIR__ . '/../../../schema.js');

$schema = preg_replace("/^export\s+default\n+/", "", $schema, 1);


$schema = json_decode($schema, true);


$params = METHOD == 'GET' ? $_GET : $_POST;



Header('Access-Control-Allow-Origin: *');
Header('Content-Type: application/json');
Header('Access-Control-Allow-Method: '.METHOD);

$json = ['ok' => false, 'data' => [], 'err' => null];

if (!logado(1)) {
    $json['err'] = "Não autenticado";
    echo json_encode($json);
    exit(1);
}

if (strtoupper($_SERVER['REQUEST_METHOD']) != METHOD) {
    $json['err'] = 'Soment ' . METHOD . ' é permitido ';
    echo json_encode($json);
    exit(503);
}

//limpar todos campos//
foreach ($params as $v) {
    if (isset($params[$v]))
        $params[$v] = clean($params[$v]);
}


//testar campos
$campos = explode(",", CAMPOS);


$erroPost = false;

foreach ($campos as $v) {


    if (!isset($params[$v])) {
        $erroPost = true;
        break;
    } else
        $params[$v] = clean($params[$v]);
}

if ($erroPost) {

    $json['err'] = 'Estão faltando campos. Necessários: ' . CAMPOS . print_r($params, true);
    echo json_encode($json);
    exit(503);
}

$tabela = $schema[$params['tabela']];


$table_name = $tabela['name'];
$ds = $tabela['ds'];
$id = $tabela['id'];


if (count($id) != 1) {

    $json['err'] = 'Essa tabela não possui apenas um id.';
    echo json_encode($json);
    exit(503);
} else {
    $id = $id[0];
}


$query = 'select t.' . $id . ' as \'key\' ,  t.' . $ds . ' as \'label\' from ' . $table_name . ' t order by t.' . $ds;


$db = new Db();
$res = $db->json($query, null);

try {
    $json['data'] = $res;
    $json['ok'] = true;

} catch (Exception $e) {
    $json['err'] = $e;
}


echo json_encode($json);

?>