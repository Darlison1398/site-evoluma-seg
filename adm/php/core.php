<?php

@session_start();

date_default_timezone_set('America/Sao_Paulo');

include_once(__DIR__ . './PHPMailer-6.8.0/src/PHPMailer.php');
include_once(__DIR__ . './PHPMailer-6.8.0/src/SMTP.php');
include_once(__DIR__ . './PHPMailer-6.8.0/src/Exception.php');
//include_once(__DIR__ . '/db-conf-adm.php');
//include_once(__DIR__ . '/db-conf-adm.php');
//require_once('src/PHPMailer.php');
//require_once('src/SMTP.php');
//require_once('src/Exception.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


function logado($x)
{


	if (isset($_SESSION['nivel_usuario']) && $_SESSION['nivel_usuario'] >= $x)
		return true;
	else
		return false;
}


function clean($string)
{
	/*$string = preg_replace('/drop |update |insert |select |delete|script|<[^>]*?>/i', '', $string);*/
	$string = preg_replace('/drop |update |insert |select |delete |script/i', '', $string);
	return $string;
}

function nameToUrl($string)
{
	$string = preg_replace(array("/(á|à|ã|â|ä)/", "/(Á|À|Ã|Â|Ä)/", "/(é|è|ê|ë)/", "/(É|È|Ê|Ë)/", "/(í|ì|î|ï)/", "/(Í|Ì|Î|Ï)/", "/(ó|ò|õ|ô|ö)/", "/(Ó|Ò|Õ|Ô|Ö)/", "/(ú|ù|û|ü)/", "/(Ú|Ù|Û|Ü)/", "/(ñ)/", "/(Ñ)/", "/(ç)/", "/(Ç)/"), explode(" ", "a A e E i I o O u U n N c C"), $string);
	$string = preg_replace('/[^a-zA-Z0-9]+/i', '-', strtolower($string));
	return $string;
}

function switchErr($err)
{
	//var_dump($err);
	$str = $err->xdebug_message;

	$mt = preg_match("/Duplicate entry/i", $str);

	if ($mt > 0)
		return 'Dados duplicados';

	$mt = preg_match("/You have an error in your SQL/i", $str);
	if ($mt > 0)
		return 'Erro SQL';

	return $err;
}


function kUid()
{
	return hash('sha256', uniqid());
}

function getExt($s)
{
	return preg_replace('/.*\.(\S+)\s*$/', '$1', $s);
}

function getT($s)
{
	return preg_replace('/.*\\/(\S+)\s*$/', '$1', $s);
}


function erroPass($s)
{

	if (!preg_match('@[A-Z]@', $s))
		return 'A senha precisa ter pelo menos uma letra maiúscula';
	if (!preg_match('@[a-z]@', $s))
		return 'A senha precisa ter pelo menos uma letra minúscula';
	if (!preg_match('@[0-9]@', $s))
		return 'A senha precisa ter pelo menos um número';
	if (!preg_match('@[^\w]@', $s))
		return 'A senha precisa ter pelo menos um caractere especial';
	if (strlen($s) < 6)
		return 'A senha precisa ter no mínimo 6 caracteres';
	return false;
}


function strJsonToHtml($s)
{

	try {
		$json = json_decode($s);
	} catch (Exception $err) {
		return 'Erro json: ' . $err->getMessage();
	}



	if ($json == null)
		return "";

	$str = "";

	foreach ($json->blocks as $k => $v) {

		switch ($v->type) {

			case "header": {
					$str .= "<h5>" . $v->data->text . "</h5>";
				}
				break;

			case "paragraph": {
					$str .= "<p align='justify'>" . $v->data->text . "</p>";
				}
				break;

			case "image": {
					//withBackground
					//withBorder
					$style = "max-width: calc(100% - 8px);height:auto;width:auto;";
					if ($v->data->stretched)
						$style .= "width: calc(100% - 8px);height:auto;width:auto;";
					if ($v->data->withBorder)
						$style .= "border: 1px solid #ededed; padding: 5px; background: #fff;  border-radius: 5px; box-shadow: 0 0 4px #d3d3d3;";
					$str .= "<div style='display: flex;	justify-content: center;margin-bottom:1em;' >"
						. "<img src='" . $v->data->file->url . "' alt='" . $v->data->caption . "' title='" . $v->data->caption . "' style='" . $style . "' />"
						. "</div>";
				}
				break;

			case "quote": {
					//alignment
					//caption
					$str .= "<blockquote align='" . $v->data->alignment . "' title='" . $v->data->caption . "' cite='" . $v->data->caption . "'>\"" . $v->data->text . "\"</blockquote>";
				}
				break;

		}
	}


	return $str;
}


function sendMessage($method, $parameters)
{
	//return false;
	$options = array(
		'http' => array(
			'method' => 'POST',
			'content' => json_encode($parameters, true),
			'header' => "Content-Type: application/json\r\n" .
				"Accept: application/json\r\n"
		)
	);

	$context = stream_context_create($options);
	file_get_contents(API_URL . $method, false, $context);

}


/*
Go to your Google Account.
Select Security.
Under "Signing in to Google," select 2-Step Verification.
At the bottom of the page, select App passwords.
Enter a name that helps you remember where you’ll use the app password.
Select Generate.
To enter the app password, follow the instructions on your screen. The app password is the 16-character code that generates on your device.
Select Done.
*/
function sendEmail($de, $senha, $para, $titulo, $msg)
{

	/*
							$mail = new PHPMailer(true);
							try {
							//$mail->SMTPDebug = SMTP::DEBUG_SERVER;
							$mail->isSMTP();
							$mail->Host = 'smtp.gmail.com';
							$mail->SMTPAuth = true;
							$mail->Username = $de;
							$mail->Password = $senha;
							$mail->Port = 587;
							$mail->setFrom($de);
							$mail->addAddress($para);
							//$mail->addAddress('kelciopcsc@provedor.com.br');
							//$mail->addAddress('kelcio.br@provedor.com.br');
							$mail->isHTML(true);
							$mail->Subject = utf8_decode($titulo);
							$mail->Body = utf8_decode($msg);
							$mail->AltBody = 'Chegou o email';
							if ($mail->send()) {
							//echo 'Email enviado com sucesso';
							return true;
							} else {
							//echo 'Email nao enviado';
							return false;
							}
							} catch (Exception $e) {
							//echo "Erro ao enviar mensagem: {$mail->ErrorInfo}";
							return false;
							}
							*/

	ini_set('display_errors', 0);
	//error_reporting( E_ALL );
	$from = $de;
	$to = $para; //.",kelcio.br@gmail.com";
	$subject = $titulo;
	$message = $msg;
	$headers = "From:" . $from;
	mail($to, $subject, $message, $headers);
	//echo "The email message was sent.";

	return true;


	/*
						 define("MAIL_USER","contato.kelcio@gmail.com");
							 define("MAIL_SENHA","selhteickgizhhid");
							 
							 require_once(realpath(__DIR__).'/PHPMailer-master/src/PHPMailer.php');
							 
							 
							 function sendMail($de, $para, $assunto, $msg, $anexos = "")
							 {
								 $mail = new PHPMailer();  // create a new object
								 $mail->IsSMTP(); // enable SMTP
								 $mail->SMTPDebug = 0;  // debugging: 1 = errors and messages, 2 = messages only
								 $mail->SMTPAuth = true;  // authentication enabled
								 $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
								 $mail->Host = 'smtp.gmail.com';
								 $mail->Port = 587; 
								 
								 $mail->Username = MAIL_USER;  
								 $mail->Password = MAIL_SENHA;           
								 $mail->SetFrom(MAIL_USER, utf8_decode($de));
								 $mail->Subject = utf8_decode($assunto);
								 //$mail->Body = $msg;
								 $mail->MsgHTML($msg);
								 
								 $vpara = explode(";", $para);
								 foreach($vpara as $p)
								 $mail->AddAddress($p);
								 
								 if(strlen($anexos))
								 {
									 $vanexos = explode(";", $anexos);
									 foreach($vanexos as $i => $a)
									 $mail->AddAttachment($a, "Anexo ".($i+1)  );
								 }
								 
								 if(!$mail->Send()) {
									 print ('Mail error: '.$mail->ErrorInfo); 
									 return false;
									 } else {
									 return true;
								 }
								 
							 }
							 
							 $para = "kelciocasemiro@gmail.com;kelciopcsc@pc.sc.gov.br";
							 $anexos = "./exemplo.pdf;./exemplo.xlsx";
							 if(sendMail("Astíséico Feliz Cupuaçú", $para, "Assundo sigiloso(áéíóúç)", "Contéudo \n da <strong>Mensagem</strong>(áéíóúç).", $anexos ))
							 print ("Email enviado para com sucesso");
							 else
							 print "<hr/>Erro ao enviar email.<br/>Host:smtp.gmail.com<br/>Port: 465";
							 */

}

//homologacao 0 e produção 1
function analytics($tipo)
{
	if ($tipo == 0)
		print "
	<!-- Google tag (gtag.js) -->
<script async src=\"https://www.googletagmanager.com/gtag/js?id=G-EKZSBY2S77\"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-EKZSBY2S77');
</script>
	";
	else
		print "
	<!-- Google tag (gtag.js) -->
<script async src=\"https://www.googletagmanager.com/gtag/js?id=G-W74T9G8GWN\"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-W74T9G8GWN');
</script>
	";
}

function lgpd()
{


	if (!isset($_SESSION['lgpd']) || $_SESSION['lgpd'] != true) {

		print "
		<div style='position: fixed;bottom: 0px;background: #000000c7;width: 100vw;z-index: 100000;padding: 1rem 3rem;text-align: justify;color: #FFF;overflow: auto;font-size: 1rem;'>
			<div style='text-align: center;padding: 1rem;'>
				<input type='button' value=' Aceitar e Continuar ' id='lgpdOk' />
			</div>
			<div>
				<p>
					Bem-vindo ao Grupo Evoluma
				</p>
				<p>
					Antes de prosseguir, gostaríamos de informar que utilizamos cookies e outras tecnologias para melhorar a
					sua
					experiência em nosso site. Para entender como coletamos, usamos e protegemos seus dados pessoais, leia
					nossa
					<a href='/evoluma/politica-privacidade' target='_self'>Política de Privacidade</a> e <a
						href='/evoluma/termos-uso' target='_self'>Termos de Uso</a>. Ao
					continuar navegando em nosso site,
					você concorda com nossos
					termos e condições.
				</p>
			</div>

		</div>
		<script>
		document.querySelector('#lgpdOk').addEventListener('click', evt => {
			fetch('/evoluma/lgpd-ok')
				.then(r => r.json())
				.then(r => {
					if (r.ok)
					(evt.target || evt.srcElement).parentElement.parentElement.remove();
				})
				.catch(err => { console.log(err); })
				;

		});
		</script>
		";
	}
	?>
	<script>
		document.querySelector(".copyright").addEventListener("dblclick", evt => {

			fetch('/evoluma/lgpd-no')
				.then(r => r.json())
				.then(r => {
					if (!r.ok)
						alert("LGPD Cancelada");
				})
				.catch(err => { console.log(err); })
				;

		});


	</script>
	<?php
}


?>