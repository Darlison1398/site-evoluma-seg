<?php

//error_reporting(E_ALL);
//ini_set('display_error', 1);





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





// foreach(json_decode($_POST['_files']) as $cfs) {

//   //  var_dump($_FILES[$cfs['name']]);

//   var_dump($_FILES[$cfs->name]);
// }


// echo "schema: <br>";
// var_dump($schema);

// $campoFileLoop = [];

// foreach ($schema as $k => $t) {
//     var_dump($t);
//     echo '<br>';

// }


// echo "POST: <br>";
// var_dump($_POST);
// echo "FILES: <br>";
// var_dump($_FILES);





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

if (!isset($_POST['_table']) || !isset($_POST['_post'])) {

	if (count($_POST) == 0)
		$json['err'] = 'Limite de POST exedido, você pode configurar em php.ini em post_max_size ';
	else
		$json['err'] = 'Faltando _' . print_r($_POST, true);
	echo json_encode($json);
	exit(503);
}


$_POST['_table'] = clean($_POST['_table']);
$_POST['_post'] = clean($_POST['_post']);



if (!logado($schema[$_POST['_table']]['permissao'])) {
	$json['err'] = "Você não tem permissão";
	echo json_encode($json);
	exit(403);
}


//trata os posts//
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



$db = new Db();

$query = 'insert into ' . $_POST['_table'];

function camposNames($v)
{
	return $v->name;
}



$query .= ' ( ';
$query .= implode(', ', array_map('camposNames', $campos));
if (count($camposFiles))
	$query .= ', ' . implode(', ', array_map('camposNames', $camposFiles));
$query .= ' ) ';
$query .= ' values ';
$query .= ' ( ';
$query .= ' :' . implode(', :', array_map('camposNames', $campos));
if (count($camposFiles))
	$query .= ', :' . implode(', :', array_map('camposNames', $camposFiles));
$query .= ' ) ';

$json['query'] = $query;


$values = [];

foreach ($campos as $v) {

	switch ($v->ktype) {

		case 'password': {
				$err = erroPass($_POST[$v->name]);
				if ($err) {
					$json['err'] = $err;
					echo json_encode($json);
					exit(503);

				}
				$values[$v->name] = md5($_POST[$v->name]);

				break;
			}

		case 'checkbox': {
				$values[$v->name] = intval($_POST[$v->name]);
				break;
			}

		default: {
				$values[$v->name] = $_POST[$v->name];
				break;
			}
	}
}



if (count($camposFiles)) {
	foreach ($camposFiles as $v) {

		switch ($v->ktype) {
			default:
			case 'img': {

					$vals = $values;



					foreach ($_FILES[$v->name]['name'] as $k => $vv) {
						//name,type,tmp_name,error,size

						$filename = kUid() . '.' . getT($_FILES[$v->name]['type'][$k]);
						$status = (boolean) move_uploaded_file($_FILES[$v->name]['tmp_name'][$k], $PATH_IMGS . $filename);



						if (!$status && !file_exists($PATH_IMGS . $filename)) {
							$json['err'] = 'Não pode fazer upload';
							echo json_encode($json);
							exit(503);
						}

						$vals[$v->name] = $filename;


						//echo "<h1>{$query}</h1>";

						//var_dump($vals);

						try {

							$res = $db->json($query, $vals);
							try {
								$json['data'] = $res;
								$json['err'] = '';
								$json['ok'] = true;

							} catch (Exception $e) {
								$json['err'] = switchErr($e);
								$json['data'] = [];
								$json['ok'] = false;
								$json['vals'] = $vals;
								$json['schema'] = $schema[$_POST['_table']];
								echo json_encode($json);
								exit(503);
							}


						} catch (Exception $e) {
							$json['err'] = switchErr($e);
							$json['data'] = [];
							$json['ok'] = false;
							$json['vals'] = $vals;
							$json['schema'] = $schema[$_POST['_table']];
							echo json_encode($json);
							exit(503);
						}

					}




				}

		}
	}

	echo json_encode($json);
	exit;

} else {
	try {

		$res = $db->json($query, $values);
		try {
			$json['data'] = $res;
			$json['ok'] = true;
			$json['err'] = '';

		} catch (Exception $e) {
			$json['err'] = switchErr($e);
			echo json_encode($json);
			exit(503);

		}


	} catch (Exception $e) {
		$json['err'] = switchErr($e);
		echo json_encode($json);
		exit(503);

	}


	echo json_encode($json);
	exit(503);
}







?>