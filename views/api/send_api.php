<?php

//error_reporting(E_ALL);
//ini_set('display_error', 0);


@session_start();
//$_SESSION['captcha'] = $rand = substr(md5(microtime()), rand(0, 26), 5);

date_default_timezone_set('America/Sao_Paulo');

$ip = "";
if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    $ip = $_SERVER['HTTP_CLIENT_IP'];
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
    $ip = $_SERVER['REMOTE_ADDR'];
}

$porta = @$_SERVER['REMOTE_PORT'];

$agente = @$_SERVER['HTTP_USER_AGENT'];

foreach ($_POST as $k => $v) {
    $_POST[$k] = htmlspecialchars(trim($v));
}

include_once(__DIR__ . '/../../adm/php/core.php');
include_once(__DIR__ . '/../../adm/php/db.php');




Header('Access-Control-Allow-Origin: *');
Header('Content-Type: application/json');
Header('Access-Control-Allow-Method: POST');

$json = ['ok' => false, 'data' => [], 'err' => 'Ops, algo deu errado, tente atualizar a página.'];
$json['post'] = $_POST;
$json['capServ'] = $_SESSION['captcha'];

if (strtoupper($_SERVER['REQUEST_METHOD']) != "POST") {
    $json['err'] = 'Soment POST é permitido ';
    echo json_encode($json);
    exit(503);
}


$temp = 'nome';
if (!isset($_POST[$temp]) || strlen($_POST[$temp]) < 3) {
    $json['err'] = 'Você precisa informar pelo menos 3 caracteres.';
    $json['errVar'] = $temp;
    $json['errVarValue'] = $_POST[$temp];
    echo json_encode($json);
    exit(503);
}




$temp = 'email';

if (
    (!isset($_POST[$temp]) || strlen($_POST[$temp]) < 3)
    &&
    (!isset($_POST['fone']) || strlen($_POST['fone']) < 14)
) {
    $json['err'] = 'Você precisa informar um email ou telefone';
    $json['errVar'] = 'fone';
    $json['errVarValue'] = $_POST['fone'];
    echo json_encode($json);
    exit(503);
}


$temp = 'email';
if (
    (isset($_POST[$temp]) && strlen($_POST[$temp]) > 0)
    &&
    (!filter_var(($_POST[$temp]), FILTER_VALIDATE_EMAIL))
) {
    $json['err'] = 'Formato de Email inválido.';
    $json['errVar'] = $temp;
    $json['errVarValue'] = $_POST[$temp];
    echo json_encode($json);
    exit(503);
}

$temp = 'msg';
if (!isset($_POST[$temp]) || strlen($_POST[$temp]) < 10) {
    $json['err'] = 'Você precisa informar pelo menos 10 caracteres.';
    $json['errVar'] = $temp;
    $json['errVarValue'] = $_POST[$temp];
    echo json_encode($json);
    exit(503);
}

$temp = 'cap';

if ($_SESSION['captcha'] && strtolower($_POST[$temp]) == strtolower($_SESSION['captcha']))
    $_SESSION['captcha'] = null;
else {
    $json['err'] = 'Captcha errado.';
    $json['errVar'] = $temp;
    $json['errVarValue'] = '';
    $json['errVarValue'] = $_POST[$temp];
    echo json_encode($json);
    exit(503);
}


$db = new Db();

$query = "INSERT INTO contato (id_contato, ds_contato, dt_contato, email_contato, telefone_contato, obs_contato, ip_contato, porta_contato, local_contato) VALUES (NULL, :nome, '" . date("Y-m-d H:i:s") . "', :email, :fone, :msg, :ip, :porta, :agente)";

//$query = 'insert into contato (ds_contato, obs_contato) values (:nome,:msg)';

$json['query'] = $query;


$vals = [
    "nome" => ($_POST['nome']),
    "email" => ($_POST['email']),
    "fone" => ($_POST['fone']),
    "msg" => ($_POST['msg']),
    "ip" => ($ip),
    "porta" => ($porta),
    "agente" => ($agente),
];


try {

    $res = $db->json($query, $vals);
    try {
        $json['data'] = $res;
        $json['ok'] = true;
        $json['err'] = '';
        // try {
        //     sendMessage(
        //         "sendMessage",
        //         array(
        //             'chat_id' => CHAT,
        //             "parse_mode" => "html",
        //             "text" =>
        //             "\n\n🌎 Chegou uma nova solicitação de contato pelo site:\n"
        //             // . "<pre>"
        //             . "\nNome: " . html_entity_decode($_POST['nome'])
        //             . "\nEmail: " . html_entity_decode($_POST['email'])
        //             . "\nFone: " . html_entity_decode($_POST['fone'])
        //             . "\nMensagem: " . html_entity_decode($_POST['msg'])
        //             . "\nIP:   http://demo.ip-api.com/" . ($ip)
        //             . "\nPorta: " . ($porta)
        //             . "\nAgente:  " . ($agente)
        //             // . "</pre>"
        //             . "\n\n"
        //         )
        //     );
        // } catch (e) {
        // }



        $Q = PHP_EOL;

        sendEmail(
            'contato.kelcio@gmail.com',
            'selhteickgizhhid',
            'contato@evoluma.com',
            'Novo contato registrado', 'Você recebeu uma nova solicitação de contado de site.'
            . $Q
            . 'Site:' . $META_URL
            . $Q
            . 'Nome: ' . $_POST['nome']
            . $Q
            . 'Email: ' . $_POST['email']
            . $Q
            . 'Telefone: ' . $_POST['fone']
            . $Q
            . 'Mensagem: ' . $_POST['msg']

        );


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








?>