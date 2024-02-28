<?php


// error_reporting(E_ALL);
// ini_set('display_error', 1);



include_once(__DIR__ . '/../../core.php');
include_once(__DIR__ . '/../../db-adm.php');

//caminho para os uploads//
$PATH_IMGS = __DIR__ . '/../../../uploads/imgs/';


if (!file_exists($PATH_IMGS)) {
	mkdir($PATH_IMGS, 0777, true);
}
//


$schema = file_get_contents(__DIR__ . '/../../../schema.js');

$schema = preg_replace("/^export\s+default\n+/", "", $schema, 1);


$schema = json_decode($schema, true);

Header('Access-Control-Allow-Origin: *');
Header('Content-Type: application/json');
Header('Access-Control-Allow-Method: POST');

$json = ['ok' => false, 'data' => [], 'err' => 'Ops, algo deu errado, tente atualizar a página.'];

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

if (!isset($_POST['_table']) || !isset($_POST['_post']) || !isset($_POST['_id'])) {
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

$campos = json_decode($_POST['_post']);

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

	$json['err'] = 'Estão faltando campos. Necessários: ' . print_r($_POST, true);
	echo json_encode($json);
	exit(503);
}


//trata os files//
$camposFiles = json_decode($_POST['_files']);


foreach ($camposFiles as $v) {

	if (!isset($schema[$_POST['_table']]['fields'][$v->name])) {
		$json['err'] = 'O campo ' . $v->name . ' não existe na tabela ' . $_POST['_table'];
		echo json_encode($json);
		exit(503);
	}


}

$erroPost = false;

// foreach ($camposFiles as $v) {
//     if (!isset($_FILES[$v->name])) {
//         $erroPost = true;
//         break;
//     } else {
//         $_FILES[$v->name] = clean($_FILES[$v->name]);
//     }
// }

if ($erroPost) {

	$json['err'] = 'Estão faltando campos. Necessários: ' . print_r($_POST, true);
	echo json_encode($json);
	exit(503);
}



$tabela = $schema[$_POST['_table']];


$table_name = $tabela['name'];
$ds = $tabela['ds'];
$id = $tabela['id'];

$idsObj = json_decode($_POST['_id']);

$pa = [];

$whereids = array_map(
	function ($v) {
		global $pa;
		$pa[key((array) $v)] = intval(current((array) $v));
		//return key((array) $v) . ' = ' . current((array) $v);
		return '`' . key((array) $v) . '` = :' . key((array) $v);
		//return '`' . key((array) $v) . "` = " . current((array) $v) . "";
	}
	,
	$idsObj
);

// if (count($id) != 1) {

// 	$json['err'] = 'Essa tabela não possui apenas um id.';
// 	echo json_encode($json);
// 	exit(503);
// } else {
// 	$id = $id[0];
// }


$db = new Db();

$query = 'UPDATE `' . $_POST['_table'] . '` SET ';

function camposNames($v)
{
	if (@$_POST[$v->name] == 'null' || @$_FILES[$v->name] == 'null')
		return $v->name . ' = NULL ';
	else
		return '`' . $v->name . "` = :" . $v->name;

}


$query .= implode(', ', array_map('camposNames', $campos));
if (count($camposFiles))
	$query .= ', ' . implode(', ', array_map('camposNames', $camposFiles));

$query .= '  where  ' . implode(' AND ', $whereids);
$query .= ';';

$json['query'] = $query;



$values = [];

foreach ($campos as $v) {

	if ($_POST[$v->name] == 'null') {
		continue;
	}

	switch ($v->ktype) {

		case 'password': {
				$err = erroPass($_POST[$v->name]);
				if ($err) {
					$json['err'] = $err;
					echo json_encode($json);
					exit(406);

				}
				$values[$v->name] = md5($_POST[$v->name]);

				break;
			}
		default: {
				$values[$v->name] = $_POST[$v->name];
				break;
			}
	}
}

$values['_id'] = $_POST['_id'];

//echo "<h1>{$query}</h1>";
//var_dump($_POST);
//var_dump($_FILES,$camposFiles);
//var_dump($json);
//exit;
//echo "<h1>{$query}</h1>";
//var_dump($values);


if (count($camposFiles)) {

	unset($values['_id']);
	$valuesPa = (object) array_merge((array) $values, (array) $pa);

	foreach ($camposFiles as $v) {

		switch ($v->ktype) {
			default:
			case 'img': {

					$vals = (array)$valuesPa;

					if (!isset($_FILES[$v->name]) || count($_FILES[$v->name]) == 0) {
						$vals[$v->name] = null;
					} else
						foreach ($_FILES[$v->name]['name'] as $k => $vv) {
							//name,type,tmp_name,error,size

							$filename = kUid() . '.' . getT($_FILES[$v->name]['type'][$k]);
							$status = (boolean) move_uploaded_file($_FILES[$v->name]['tmp_name'][$k], $PATH_IMGS . $filename);



							if (!$status) {
								$json['err'] = 'Não pode fazer upload';
								echo json_encode($json);
								exit(503);
							}

							$vals[$v->name] = $filename;



						}




				}

		}
	}

	try {

		$res = $db->json($query, $vals);

		// echo "<h1>{$query}</h1>";
		// var_dump($vals);

		try {
			$json['data'] = $res;
			$json['err'] = '';
			$json['ok'] = true;

		} catch (Exception $e) {
			$json['err'] = switchErr($e);
			$json['data'] = [];
			$json['ok'] = false;
			echo json_encode($json);
			exit;
		}


	} catch (Exception $e) {
		$json['err'] = switchErr($e);
		$json['data'] = [];
		$json['ok'] = false;
		echo json_encode($json);
		exit;
	}

	echo json_encode($json);
	exit;

} else {
	// echo "<h1>{$query}</h1>";
	unset($values['_id']);
	$valuesPa = (object) array_merge((array) $values, (array) $pa);

	// var_dump($valuesPa);
	try {

		//$res = $db->json($query, $values);
		$res = $db->json($query, $valuesPa);

		try {
			$json['data'] = $res;
			$json['ok'] = true;
			$json['err'] = '';

		} catch (Exception $e) {
			$json['err'] = switchErr($e);
			echo json_encode($json);
			exit;

		}


	} catch (Exception $e) {
		$json['err'] = switchErr($e);
		echo $e;
		echo json_encode($json);
		exit;

	}


	echo json_encode($json);
	exit;
}



?>