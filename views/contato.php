<?php
@session_start();
$_SESSION['captcha'] = $rand = substr(md5(microtime()), rand(0, 26), 5);





//error_reporting(E_ALL);
//ini_set('display_error', 1);


include_once(__DIR__ . '/../adm/php/core.php');
include_once(__DIR__ . '/../adm/php/db.php');



define('IMG_CLIENTE', './assets/img/v1.0/cliente.png');
define('IMG_SERVICO', './assets/img/v1.0/servico.jpg');
define('IMG_SOBRE', './assets/img/v1.0/sobre.jpg');

define('PATH_IMGS', './adm/uploads/imgs/');





?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
	<?php analytics(PUBLICACAO); ?>
	<meta property="og:image" content="<?php echo $META_PREVIEW; ?>" />
	<meta property="og:type" content="website" />
	<meta property="og:image:type" content="image/webp">
	<meta property="og:image:width" content="1200">
	<meta property="og:image:height" content="630">
	<meta property="og:image:alt" content="Evoluma Imagem" />
	<meta property="og:url" content="<?php echo $META_URL; ?>" />
	<meta property="og:title" content="<?php echo $META_TITLE; ?>" />
	<meta property="og:description" content="<?php echo $META_DESCRIPTION; ?>" />
	<meta property="og:site_name" content="<?php echo $META_AUTHOR; ?>" />
	<meta property="og:locale" content="pt_BR" />

	<meta name="twitter:card" content="summary_large_image">
	<meta name="twitter:site" content="@kelciocasemiro">
	<meta name="twitter:creator" content="@kelciocasemiro">
	<meta name="twitter:title" content="<?php echo $META_TITLE; ?>">
	<meta name="twitter:description" content="<?php echo $META_DESCRIPTION; ?>">
	<meta name="twitter:image" content="<?php echo $META_PREVIEW; ?>">

	<meta name="robots" content="index, follow" />
	<meta name="author" content="<?php echo $META_AUTHOR; ?>" />
	<meta name="keywords" content="<?php echo $META_KEYWORDS; ?>" />
	<meta name="description" content="<?php echo $META_DESCRIPTION; ?>" />
	<meta name="revisit-after" content="7 days" />

	<meta property="article:author" content="<?php echo $META_AUTHOR; ?>" />
	<meta property="article:section" content="SEO" />
	<meta property="article:tag" content="<?php echo $META_KEYWORDS; ?>" />

	<link href="../../assets/img/v1.0/favicon.png" type="image/x-icon" rel="icon" />
	<link href="../../assets/img/v1.0/favicon.png" type="image/x-icon" rel="shortcut icon" />
	<link href="../../assets/img/v1.0/icon.png" rel="apple-touch-icon">

	<meta charset="utf-8">
	<meta content="width=device-width, initial-scale=1.0" name="viewport">
	<meta name="X-UA-Compatible" content="IE=edge" />

	<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
	<meta http-equiv="Pragma" content="no-cache" />
	<meta http-equiv="Expires" content="0" />

	<title>
		<?php echo $META_PAGE_TITLE; ?>
	</title>

	<!-- Vendor CSS Files -->
	<link href="../../assets/vendor/aos/aos.css" rel="stylesheet">
	<link href="../../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link href="../../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
	<link href="../../assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
	<link href="../../assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
	<link href="../../assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

	<!-- Template Main CSS File -->

	<link href="../../assets/css/style.css" rel="stylesheet">
	<!-- <link href="../../assets/fonte/1/css.css" rel="stylesheet"> -->



</head>

<body>



	<!-- ======= Header ======= -->
	<header id="header" class="d-flex align-items-center">
		<div class="container d-flex align-items-center justify-content-between ">

			<div class="logo">
				<a href="../../"><img src="../../assets/img/v1.0/logo-branco.svg" alt="" class="img-fluid"></a>

			</div>

			<nav id="navbar" class="navbar navbar-expand-lg">
				<ul>
					<li><a class="nav-link scrollto " href="../../home/#inicio">Início</a></li>
					<li><a class="nav-link scrollto" href="../../sobre/<?php echo $META_URL_SUFIX; ?>">Quem Somos</a>
					</li>
					<li><a class="nav-link scrollto" href="../../produtos/">Produtos</a></li>
					<li><a class="nav-link scrollto" href="../../servicos/">Serviços</a></li>
					<li><a class="nav-link scrollto " href="../../clientes/<?php echo $META_URL_SUFIX; ?>">Clientes</a>
					</li>
					<li><a class="nav-link scrollto" href="../../noticias/<?php echo $META_URL_SUFIX; ?>">Notícias</a>
					</li>
					<li class="nav-item"><a class="nav-link scrollto" href="https://blog.evoluma.com.br"
							target="_blank"> Blog</a></li>

					<li><a class="nav-link scrollto" href="../../contato/<?php echo $META_URL_SUFIX; ?>">Contato</a>
					</li>
					<li><a class="nav-link scrollto " href="https://scada3.evoluma.com/login">Login</a></li>
				</ul>
				<i class="bi bi-list mobile-nav-toggle"></i>
			</nav><!-- .navbar -->

		</div>

	</header><!-- End Header -->


	<main id="main">


		<!-- ======= noticias Section ======= -->
		<section id="noticias" class="noticias">
			<div class="container">

				<div class="section-title" data-aos="fade-up">
					<h2><i class="bi bi-megaphone"></i> Contato</h2>
					<!-- <p>Fique por dentro da <strong>Tecnologia</strong></p> -->
				</div>




				<div class="row" data-aos="zoom-out">

					<form action="../../contato/a/b" method="post">

						<div class="row g-2 mb-2">
							<div class="col-md">
								<div class="form-floating">
									<input name='nome' type="search" class="form-control" id="floatingInputValue"
										placeholder="Nome" value="">
									<label for="floatingInputValue">Nome * </label>
								</div>
								<div class="m-1 text-danger text-start">
								</div>
							</div>
							<div class="col-md">
								<div class="form-floating">
									<input name='fone' type="search" class="form-control fone" id="floatingInputValue"
										placeholder="Telefone" value="">
									<label for="floatingInputValue">Telefone </label>
								</div>
								<div class="m-1 text-danger text-start">
								</div>
							</div>
							<div class="col-md">
								<div class="form-floating ">
									<input name='email' type="search" class="form-control" id="floatingInputInvalid"
										placeholder="Email" value="">
									<label for="floatingInputInvalid">Email</label>
								</div>
								<div class="m-1 text-danger text-start">
								</div>
							</div>
						</div>

						<div class="row g-2">

							<div class="form-floating my-2">
								<textarea name='msg' maxlength="1024" class="form-control .textarea"
									placeholder="Deixe aqui sua mensagem" id="floatingTextarea"></textarea>
								<label for="floatingTextarea"> Mensagem *</label>
							</div>
							<div class="m-1 text-danger text-start">
							</div>
						</div>


						<div class="row g-2 mb-2">

							<div class="col-md-3 col-xs-12 text-center">

								<canvas id='cap'></canvas>

								<div class="form-floating ">
									<input maxlength="5" name='cap' type="search" class="form-control"
										id="floatingInputValue" placeholder="Captcha" value="">
									<label for="floatingInputValue">Digite o texto acima * </label>
								</div>
								<div class="m-1 text-danger text-start">
								</div>
							</div>
						</div>


						<div class="row">

							<div class="form-floating my-2">
								<button type="submit" class="btn btn-primary">Enviar Contato</button>
							</div>
						</div>






					</form>

					<div class="row m-0">
						<div id='msg' class="col alert m-2" role="alert">
						</div>
					</div>

				</div>




				<div class='btContato'>
					<a class="nav-link scrollto" href="../../home/#inicio">
						<i class="bi bi-arrow-left-circle-fill"></i> Ir para página inicial
					</a>
				</div>

			</div>
		</section><!-- End noticias Section -->



	</main><!-- End #main -->

	<!-- ======= Footer ======= -->
	<footer id="footer">

		<div class="footer-top">

			<div class="container">

				<div class="row justify-content-center">
					<div class="col listaContato" data-aos="zoom-in">
						<div>
							<a href='tel:48988386788'>
								<img src="../../assets/img/v1.0/icon-telefone.svg" />
								+55 (48) 3052-4254
							</a>
						</div>
						<div>
							<a href='https://api.whatsapp.com/send?phone=5548988386788' target="_blank">
								<img src="../../assets/img/v1.0/icon-whatsapp.svg" />
								+55 (48) 9.8838-6788
							</a>
						</div>
						<div>
							<a href="mailto:contato@evoluma.com" target="_blank">
								<img src="../../assets/img/v1.0/icon-email.svg" />
								contato@evoluma.com
							</a>
						</div>
						<div>
							<a href="https://www.facebook.com/evoluma/" target="_blank" title='Facebook Evoluma'>
								<img src="../../assets/img/v1.0/icon-facebook.svg" />
								Evoluma
							</a>
						</div>
						<div>
							<a href="https://www.instagram.com/evoluma_sistemas/" target="_blank"
								title='Instagram Evoluma'>
								<img src="../../assets/img/v1.0/icon-instagram.svg" />
								evoluma_sistemas
							</a>
						</div>
						<div>
							<a href="https://goo.gl/maps/p2fYZhdGgChwtuxZ9" target="_blank">
								<img src="../../assets/img/v1.0/icon-maps.svg" />
								Nossa localização
							</a>

						</div>



					</div>
					<div class="col-3 contatoColImg" data-aos="zoom-out">
						<img id="adm" class="w80" src="../../assets/img/v1.0/logo-branco.svg" alt="">
					</div>
				</div>





			</div>
		</div>

		<div class="container footer-bottom clearfix">
			<div class="copyright">
				&copy; Copyright <strong><span>Grupo Evoluma</span></strong>. All
				Rights Reserved
			</div>
			<div class="credits">
				Designed by <a target='_blank' href="https://bootstrapmade.com/">BootstrapMade</a>
			</div>
		</div>
	</footer>
	<!-- End Footer -->

	<!-- <a title="Subir" href="#" class="back-to-top back-to-top-seta d-flex align-items-center justify-content-center"><i
			class="bi bi-arrow-up-short"></i></a> -->

	<a title="Entre em contato" class="back-to-top back-to-top-whatsapp"
		href="https://api.whatsapp.com/send?phone=5548988386788" target="_blank">
		<img src="../../assets/img/v1.0/icons8-whatsapp.svg" />
	</a>

	<?php lgpd(); ?>
	<div id="preloader"></div>



	<!-- Vendor JS Files -->
	<script src="../../assets/vendor/aos/aos.js"></script>
	<script src="../../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script src="../../assets/vendor/glightbox/js/glightbox.min.js"></script>
	<script src="../../assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
	<script src="../../assets/vendor/swiper/swiper-bundle.min.js"></script>
	<!-- <script src="../../assets/vendor/php-email-form/validate.js"></script> -->

	<!-- Template Main JS File -->
	<script src="../../assets/js/main.js"></script>

	<script>
		(function printCap() {
			const canvas = document.getElementById("cap");
			const ctx = canvas.getContext("2d");

			ctx.font = "50px Arial";

			//ctx.font = "30px Comic Sans MS";
			//ctx.fillStyle = "red";
			//ctx.textAlign = "center";

			ctx.strokeText("<?php echo $_SESSION['captcha']; ?>", 10, 50);
			ctx.beginPath();
			ctx.moveTo(10, 10);
			ctx.lineTo(20, 50);
			ctx.lineTo(70, 10);
			ctx.moveTo(100, 45);
			ctx.lineTo(0, 35);
			ctx.moveTo(140, 45);
			ctx.lineTo(40, 25);
			ctx.lineTo(150, 15);
			ctx.lineTo(0, 45);
			//ctx.strokeStyle = "red";
			ctx.stroke();

		})();

		async function sub(ev) {
			ev.preventDefault();

			ev.submitter.innerText = 'Enviando, por favor aguarde...';
			ev.submitter.disabled = true;


			for (let i = 0; i < form.length; i++) {

				form[i].classList.remove('is-invalid');
				if (form[i].parentElement.nextElementSibling)
					form[i].parentElement.nextElementSibling.innerHTML = '';
			};

			let data = new FormData(form);

			let msg = document.getElementById('msg');

			let r = await fetch('../../views/api/send_api.php', {
				method: 'POST',
				body: data
			});
			r = await r.json();
			//console.log(r);

			ev.submitter.innerText = 'Enviar Contato';
			ev.submitter.disabled = false;

			if (!r || !r.ok) {
				if (r.errVar) {
					form[r.errVar].classList.add('is-invalid');
					form[r.errVar].parentElement.nextElementSibling.innerHTML = r.err || 'Erro';
					form[r.errVar].value = r.errVarValue || '';
					form[r.errVar].focus();
					form[r.errVar].scrollIntoView({ behavior: 'smooth', block: 'center', inline: 'nearest' });

				}
				// msg.classList.remove('alert-success');
				// msg.classList.add('alert-warning');
				// msg.innerHTML = 'Foram encontrados erros, favor verificar o formulário.'
			} else {
				msg.classList.add('alert-success');
				msg.classList.remove('alert-warning');
				msg.innerHTML = '🫡 Sua mensagem foi enviada com sucesso. Agradecemos seu contato. Logo entraremos em contato com você. '
				form.remove();
				msg.scrollIntoView({ behavior: 'smooth', block: 'center', inline: 'nearest' });
			}


			//if (!err) form.submit();

		}

		let form = document.querySelector('form');
		//form.target = 'http://localhost/evoluma/send/a/b';

		form.addEventListener("submit", sub);

		const $input = document.querySelectorAll('.fone').forEach(e => {
			e.addEventListener('input', e => e.target.value = phoneMask(e.target.value), false)
		})


		function phoneMask(phone) {
			return phone.replace(/\D/g, '')
				.replace(/^(\d)/, '($1')
				.replace(/^(\(\d{2})(\d)/, '$1) $2')
				.replace(/(\d{4})(\d{1,5})/, '$1-$2')
				.replace(/(-\d{5})\d+?$/, '$1');
		}

	</script>

</body>

</html>