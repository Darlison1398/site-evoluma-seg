<?php

// error_reporting(E_ALL);
// ini_set('display_error', 1);

include_once(__DIR__ . '/../../core.php');
include_once(__DIR__ . '/../../db-adm.php');


$schema = file_get_contents(__DIR__ . '/../../../schema.js');

$schema = preg_replace("/^export\s+default\n+/", "", $schema, 1);

$schema = json_decode($schema, true);


Header('Access-Control-Allow-Origin: *');
Header('Content-Type: application/json');
Header('Access-Control-Allow-Method: POST');

$json = ['ok' => false, 'data' => [], 'err' => 'Ops, algo deu errado, tente atualizar a página.', 'total' => 0];

if (!logado(1)) {
    $json['err'] = "Não autenticado";
    echo json_encode($json);
    exit(1);
}

if (strtoupper($_SERVER['REQUEST_METHOD']) != "POST") {
    $json['err'] = 'Soment POST é permitido ';
    echo json_encode($json);
    exit(503);
}

if (!isset($_POST['_table']) || !isset($_POST['_fields'])) {
    $json['err'] = 'Faltando _';
    echo json_encode($json);
    exit(503);
}


foreach ($_POST as $k => $v) {
    $_POST[$k] = clean($_POST[$k]);
}


if (!logado($schema[$_POST['_table']]['permissao'])) {
    $json['err'] = "Você não tem permissão";
    echo json_encode($json);
    exit(403);
}


$offset = isset($_POST['offset']) ? intval($_POST['offset']) : 0;

$qtd = 5;

$campos = json_decode($_POST['_fields']);


foreach ($campos as $v) {

    if (!isset($schema[$_POST['_table']]['fields'][$v->name])) {
        $json['err'] = 'O campo ' . $v->name . ' não existe na tabela ' . $_POST['_table'];
        echo json_encode($json);
        exit(503);
    }


}


$erroPost = false;

foreach ($campos as $v) {
    if (!isset($_POST[$v->name])) {
        $erroPost = true;
        break;
    } else {
        $_POST[$v->name] = clean($_POST[$v->name]);
    }
}

if ($erroPost) {

    $json['err'] = 'Estão faltando campos. Necessários: ' . CAMPOS . print_r($_POST, true);
    echo json_encode($json);
    exit(503);
}


//pega dados da tabela//
$tabela = $schema[$_POST['_table']];
$table_name = $tabela['name'];
$ds = $tabela['ds'];
$id = $tabela['id'];

// if (count($id) != 1) {

//     $json['err'] = 'Essa tabela não possui apenas um id.';
//     echo json_encode($json);
//     exit(503);
// } else {
//     $id = $id[0];
// }



$db = new Db();


$select = [];

// $where = '
//  where  ' . $_POST['_table'] . '.' . $id . ' is not null ';
$where = '  where  ' . $_POST['_table'] . '.' . (implode(' is not null AND ' . $_POST['_table'] . '.', $id) . ' is not null ');

$join = '';

$values = [];

foreach ($campos as $v) {

    if ($v->ktype == 'img')
        continue;

    if ($_POST[$v->name] == 'null') {
        $where .= ' and ' . $table_name . '.' . $v->name . ' is null ';
        continue;
    }

    switch ($v->ktype) {

        case 'text':
        case 'textarea': {
                $where .= ' and ' . $table_name . '.' . $v->name . ' like :' . $v->name;
                $values[$v->name] = '%' . $_POST[$v->name] . '%';
            }
            break;
        default: {
                $where .= ' and ' . $table_name . '.' . $v->name . ' = :' . $v->name;
                $values[$v->name] = $_POST[$v->name];
            }
            break;

    }
}




$fks = [];

foreach ($tabela['fields'] as $c) {
    if ($c['foreignKey']) {
        $fks[$c['name']] = $c;
    }
}

$json['fks'] = $fks;


foreach ($fks as $k => $v) {
    $join .= '
    left join ' . $v['foreignKeyTable'] . ' on ' . $v['foreignKeyTable'] . '.' . $v['foreignKeyId'] . ' = ' . $table_name . '.' . $k;

    $select[] = ' ' . $v['foreignKeyTable'] . '.' . $v['foreignKeyFieldDs'];
}

$select[] = ' ' . $_POST['_table'] . '.*';

$select = implode(", ", $select);

$query = 'select ' . $select . '  from ' . $_POST['_table'];


$query .= '
' . $join;

$query .= '
' . $where;


// $query .= '
// order by ' . $_POST['_table'] . '.' . $ds;
$query .= '
order by ' . $_POST['_table'] . '.' . $id[0] . ' desc ';

$query .= '
limit ' . $offset . ',  ' . $qtd;



$json['join'] = $join;

$json['query'] = $query;

//var_dump($json);

try {

    $res = $db->json($query, $values);
    try {
        $json['data'] = $res;
        $json['ok'] = true;
        $json['err'] = '';

        $countReg = $db->json('select count(' . $_POST['_table'] . '.' . $id[0] . ') as total from  ' . $_POST['_table'] . '  ' . $join . ' ' . $where, $values);

        $json['total'] = $countReg[0]['total'];

        $json['count'] = count($res);
        $json['qtd'] = $qtd;
        $json['offset'] = $offset;

    } catch (Exception $e) {
        $json['err'] = $e;

    }


} catch (Exception $e) {
    $json['err'] = $e;

}


echo json_encode($json);

?>