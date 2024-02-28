<?php



//error_reporting(E_ALL);
//ini_set('display_error', 1);
@session_start();

include_once(__DIR__ . '/../adm/php/core.php');
include_once(__DIR__ . '/../adm/php/db.php');





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
	<link href="./assets/vendor/aos/aos.css" rel="stylesheet">
	<link href="./assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link href="./assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
	<link href="./assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
	<link href="./assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
	<link href="./assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

	<!-- Template Main CSS File -->

	<link href="./assets/css/style.css" rel="stylesheet">
	<!-- <link href="../assets/fonte/2/css.css" rel="stylesheet"> -->


</head>

<body>


	<!-- ======= Header ======= -->
	<header id="header" class="d-flex align-items-center">
		<div class="container d-flex align-items-center justify-content-between ">

			<div class="logo">
				<a href="./#inicio"><img src="./assets/img/v1.0/logo-branco.svg" alt="" class="img-fluid"></a>

			</div>

			<nav id="navbar" class="navbar navbar-expand-lg">
				<ul>


					<li><a class="nav-link scrollto " href="./home/">Início</a></li>
					<li><a class="nav-link scrollto" href="./sobre/<?php echo $META_URL_SUFIX; ?>">Quem Somos</a></li>
					<li><a class="nav-link scrollto" href="./produtos/">Produtos</a></li>
					<li><a class="nav-link scrollto" href="./servicos/">Serviços</a></li>
					<li><a class="nav-link scrollto " href="./clientes/<?php echo $META_URL_SUFIX; ?>">Clientes</a>
					</li>
					<li><a class="nav-link scrollto" href="./noticias/<?php echo $META_URL_SUFIX; ?>">Notícias</a>
					</li>
					<li class="nav-item"><a class="nav-link scrollto" href="https://blog.evoluma.com.br"
							target="_blank"> Blog</a></li>

					<li><a class="nav-link scrollto" href="./contato/<?php echo $META_URL_SUFIX; ?>">Contato</a></li>
					<li><a class="nav-link scrollto " href="https://scada3.evoluma.com/login">Login</a></li>
				</ul>
				<i class="bi bi-list mobile-nav-toggle"></i>
			</nav><!-- .navbar -->

		</div>

	</header><!-- End Header -->

	<div id='inicio'></div>
	<main id="main">

		<!-- ======= inicio ======= -->


		<!-- <section id="inicio" class='imgsTop'>
			<div class="banner" data-aos="zoom-out">
				#evoluirsempre
			</div>
		</section> -->


		<section class='sobre'>
			<div class='container'>

				<h2>
					<a class="back-arrow" href="#" onclick="history.back()" title="Voltar">
						<i class="bi bi-arrow-left-circle-fill"></i>
					</a>
					Termos de Uso
				</h2>
				<h1></h1>

				<p>Bem-vindo(a) ao nosso site. Ao utilizar nossos serviços, você concorda com o seguinte:</p>

				<ol>
					<li><strong>Respeito às Leis:</strong> Não utilize nosso site para atividades ilegais ou
						prejudiciais.
					</li>
					<li><strong>Respeito à Comunidade:</strong> Seja cortês e respeitoso com outros usuários e não
						publique
						conteúdo ofensivo.</li>
					<li><strong>Privacidade:</strong> Respeitamos sua privacidade; consulte nossa <a
							href="/evoluma/politica-privacidade">Política de Privacidade</a> para mais
						detalhes.
					</li>
					<li><strong>Direitos Autorais:</strong> Não copie ou distribua nosso conteúdo sem permissão.</li>
					<li><strong>Segurança:</strong> Proteja sua conta e informações pessoais.</li>
					<li><strong>Alterações:</strong> Podemos modificar esta política; verifique periodicamente para
						atualizações.</li>
				</ol>

				<p>Obrigado por usar nossos serviços!</p>

				<div class='btContato'>
					<a class="nav-link scrollto" href="#" onclick="history.back()">
						<i class="bi bi-arrow-left-circle-fill"></i> Voltar para a página anterior
					</a>
				</div>
			</div>
		</section>





		<!-- ======= Footer ======= -->
		<footer id="footer">

			<div class="footer-top">

				<div class="container">

					<div class="row justify-content-center">
						<div class="col listaContato" data-aos="zoom-in">
							<div>
								<a href='tel:48988386788'>
									<img src="./assets/img/v1.0/icon-telefone.svg" />
									+55 (48) 3052-4254
								</a>
							</div>
							<div>
								<a href='https://api.whatsapp.com/send?phone=5548988386788' target="_blank">
									<img src="./assets/img/v1.0/icon-whatsapp.svg" />
									+55 (48) 9.8838-6788
								</a>
							</div>
							<div>
								<a href="mailto:contato@evoluma.com" target="_blank">
									<img src="./assets/img/v1.0/icon-email.svg" />
									contato@evoluma.com
								</a>
							</div>
							<div>
								<a href="https://www.facebook.com/evoluma/" target="_blank" title='Facebook Evoluma'>
									<img src="./assets/img/v1.0/icon-facebook.svg" />
									Evoluma
								</a>
							</div>
							<div>
								<a href="https://www.instagram.com/evoluma_sistemas/" target="_blank"
									title='Instagram Evoluma'>
									<img src="./assets/img/v1.0/icon-instagram.svg" />
									evoluma_sistemas
								</a>
							</div>
							<div>
								<a href="https://goo.gl/maps/p2fYZhdGgChwtuxZ9" target="_blank">
									<img src="./assets/img/v1.0/icon-maps.svg" />
									Nossa localização
								</a>

							</div>



						</div>
						<div class="col-3 contatoColImg" data-aos="zoom-out">
							<img id="adm" class="w80" src="./assets/img/v1.0/logo-branco.svg" alt="">
						</div>
					</div>




				</div>
			</div>

			<div class="container footer-bottom clearfix">
				<div class="copyright">
					<span>&copy;</span> Copyright <strong><span>Grupo Evoluma</span></strong>. All
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
			<img src="./assets/img/v1.0/icons8-whatsapp.svg" />
		</a>

		<div id="preloader"></div>



		<!-- Vendor JS Files -->
		<script src="./assets/vendor/aos/aos.js"></script>
		<script src="./assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
		<script src="./assets/vendor/glightbox/js/glightbox.min.js"></script>
		<script src="./assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
		<script src="./assets/vendor/swiper/swiper-bundle.min.js"></script>
		<!-- <script src="../assets/vendor/php-email-form/validate.js"></script> -->

		<!-- Template Main JS File -->
		<script src="./assets/js/main.js"></script>

</body>

</html>