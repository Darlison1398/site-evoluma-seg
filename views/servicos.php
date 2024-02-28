<?php



//error_reporting(E_ALL);
//ini_set('display_error', 1);
@session_start();

include_once(__DIR__ . '/../adm/php/core.php');
include_once(__DIR__ . '/../adm/php/db.php');



define('IMG_CLIENTE', './assets/img/v1.0/cliente.png');
define('IMG_SERVICO', './assets/img/v1.0/servico.jpg');
define('IMG_SOBRE', './assets/img/v1.0/sobre.jpg');

define('PATH_IMGS', './adm/uploads/imgs/');





$db = new Db();

$servicos = $db->json(
	'
	select s.*, f.img_foto as servico_img from servico s
	left JOIN foto f on f.id_servico = s.id_servico and f.capa = "1"
	GROUP BY s.id_servico
	order by  s.ordem_servico,  f.dt_foto desc
	'
	,
	null
);
//var_dump($servicos);



$fotos = $db->json(
	'
	SELECT ds_foto as ds, img_foto as data from foto
	where home = 1
	order by ordem_foto asc
	limit 10
	'
	,
	null
);
// $fotos = $db->json(
// 	' 
// 	SELECT ds_foto as ds, img_foto as data from foto
// 	where id_servico is not null
// 	order by id_servico, ordem_foto asc
// 	limit 20
// 	'
// 	,
// 	null
// );

//var_dump($fotos);


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

	<link href="../assets/img/v1.0/favicon.png" type="image/x-icon" rel="icon" />
	<link href="../assets/img/v1.0/favicon.png" type="image/x-icon" rel="shortcut icon" />
	<link href="../assets/img/v1.0/icon.png" rel="apple-touch-icon">

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
	<link href="../assets/vendor/aos/aos.css" rel="stylesheet">
	<link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
	<link href="../assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
	<link href="../assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
	<link href="../assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

	<!-- Template Main CSS File -->

	<link href="../assets/css/style.css" rel="stylesheet">
	<!-- <link href="../assets/fonte/2/css.css" rel="stylesheet"> -->



</head>

<body>


	<!-- ======= Header ======= -->
	<header id="header" class="d-flex align-items-center">
		<div class="container d-flex align-items-center justify-content-between ">

			<div class="logo">
				<a href="../#inicio"><img src="../assets/img/v1.0/logo-branco.svg" alt="" class="img-fluid"></a>

			</div>

			<nav id="navbar" class="navbar navbar-expand-lg">
				<ul>
					<li><a class="nav-link scrollto " href="../home/">Início</a></li>
					<li><a class="nav-link scrollto" href="../sobre/<?php echo $META_URL_SUFIX; ?>">Quem Somos</a></li>
					<li><a class="nav-link scrollto" href="../produtos/">Produtos</a></li>
					<li><a class="nav-link scrollto" href="../servicos/">Serviços</a></li>
					<li><a class="nav-link scrollto " href="../clientes/<?php echo $META_URL_SUFIX; ?>">Clientes</a>
					</li>
					<li><a class="nav-link scrollto" href="../noticias/<?php echo $META_URL_SUFIX; ?>">Notícias</a>
					</li>
					<li class="nav-item"><a class="nav-link scrollto" href="https://blog.evoluma.com.br"
							target="_blank"> Blog</a></li>

					<li><a class="nav-link scrollto" href="../contato/<?php echo $META_URL_SUFIX; ?>">Contato</a></li>
					<li><a class="nav-link scrollto " href="https://scada3.evoluma.com/login">Login</a></li>
				</ul>
				<i class="bi bi-list mobile-nav-toggle"></i>
			</nav><!-- .navbar -->

		</div>

	</header><!-- End Header -->

	<div id='inicio'></div>
	<main id="main">

		<!-- ======= inicio ======= -->
		<section>

			<div data-aos="zoom-out" class="portfolio-details-slider swiper carrossel">
				<div class="swiper-wrapper align-items-center text-center ">


					<?php

					if (count($fotos)) {

						foreach ($fotos as $v) {
							?>
							<div class="swiper-slide " style="margin-x: 500px;">
								<img src="../<?php echo $v['data'] ? PATH_IMGS . $v['data'] : IMG_CLIENTE; ?>"
									alt="<?php echo $v['ds']; ?>" class="img-fluid img-cover" />
							</div>
							<?php
						}
					} else {
						?>
						<div class="swiper-slide ">
							<img src="../<?php echo IMG_SOBRE; ?>" alt="<?php echo IMG_SOBRE; ?>"
								class="img-fluid img-cover" />
						</div>
						<?php
					}
					?>


				</div>
				<!-- <div class="swiper-pagination"></div> -->
				<div class="swiper-button-next"></div>
				<div class="swiper-button-prev"></div>
			</div>
		</section>





		<!-- ======= servicos ======= -->
		<section id="servicos" class="servicos">
			<div class="container">

				<div class="section-title" data-aos="fade-left">
					<h2>
						<a class="back-arrow" href="#" onclick="history.back()" title="Voltar">
							<i class="bi bi-arrow-left-circle-fill"></i>
						</a>
						Conheça nossos serviços
						<a class="back-arrow share" href="#" text="Conheça nossos serviços" title="Compartilhar">
							<i class="bi bi-share-fill" ></i>
						</a>
					</h2>
				</div>

				<div class="row botoes">
					<?php
					foreach ($servicos as $k => $v) {
						?>
						<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6  d-flex justify-content-center botaoProduto"
							data-aos="zoom-in">
							<a
								href="/evoluma/servico/<?php echo $v['id_servico']; ?>/<?php echo nameToUrl($v['ds_servico']); ?>">
								<div>

									<?php



									if ($v['servico_img']) {

										?>

										<img src="../<?php echo PATH_IMGS . $v['servico_img'] ?>"
											alt="<?php echo $v['servico_img']; ?>" class="w100" />

										<?php

									} else {
										?>

										<img src="../<?php echo IMG_SOBRE; ?>" alt="<?php echo IMG_SOBRE; ?>" class="w100" />

										<?php
									}
									?>

								</div>
								<h3>
									<?php echo $v['ds_servico']; ?>
								</h3>
								<div class='det'>
									<?php echo $v['resumo_servico']; ?>
								</div>
							</a>
						</div>

						<?php
					} ?>



				</div>

				<div class='btContato'>
					<a href='https://api.whatsapp.com/send?phone=5548988386788' target="_blank">
						<img src="../assets/img/v1.0/contato.svg" />
					</a>
				</div>


				<div class='btContato'>
					<a href='https://scada3.evoluma.com/login' target="_blank">
						<img src="../assets/img/v1.0/cliente-evoluma.png" />
					</a>
				</div>

				<div class='shareDiv share' text='Conheça nossos serviços'>
					<a class="back-arrow" href="#" title="Compartilhar">
						<i class="bi bi-share-fill"></i>
						Compartilhar
					</a>
				</div>
				<div class='btContato'>
					<a class="nav-link scrollto" href="#" onclick="history.back()">
						<i class="bi bi-arrow-left-circle-fill"></i> Voltar para a página anterior
					</a>
				</div>

			</div>
		</section>
		<!-- ======= servicos ======= -->




	</main><!-- End #main -->

	<!-- ======= Footer ======= -->
	<footer id="footer">

		<div class="footer-top">

			<div class="container">

				<div class="row justify-content-center">
					<div class="col listaContato" data-aos="zoom-in">
						<div>
							<a href='tel:48988386788'>
								<img src="../assets/img/v1.0/icon-telefone.svg" />
								+55 (48) 3052-4254
							</a>
						</div>
						<div>
							<a href='https://api.whatsapp.com/send?phone=5548988386788' target="_blank">
								<img src="../assets/img/v1.0/icon-whatsapp.svg" />
								+55 (48) 9.8838-6788
							</a>
						</div>
						<div>
							<a href="mailto:contato@evoluma.com" target="_blank">
								<img src="../assets/img/v1.0/icon-email.svg" />
								contato@evoluma.com
							</a>
						</div>
						<div>
							<a href="https://www.facebook.com/evoluma/" target="_blank" title='Facebook Evoluma'>
								<img src="../assets/img/v1.0/icon-facebook.svg" />
								Evoluma
							</a>
						</div>
						<div>
							<a href="https://www.instagram.com/evoluma_sistemas/" target="_blank"
								title='Instagram Evoluma'>
								<img src="../assets/img/v1.0/icon-instagram.svg" />
								evoluma_sistemas
							</a>
						</div>
						<div>
							<a href="https://goo.gl/maps/p2fYZhdGgChwtuxZ9" target="_blank">
								<img src="../assets/img/v1.0/icon-maps.svg" />
								Nossa localização
							</a>

						</div>



					</div>
					<div class="col-3 contatoColImg" data-aos="zoom-out">
						<img id="adm" class="w80" src="../assets/img/v1.0/logo-branco.svg" alt="">
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
		<img src="../assets/img/v1.0/icons8-whatsapp.svg" />
	</a>

	<?php lgpd(); ?>

	<div id="preloader"></div>


	<!-- Vendor JS Files -->
	<script src="../assets/vendor/aos/aos.js"></script>
	<script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script src="../assets/vendor/glightbox/js/glightbox.min.js"></script>
	<script src="../assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
	<script src="../assets/vendor/swiper/swiper-bundle.min.js"></script>
	<!-- <script src="../assets/vendor/php-email-form/validate.js"></script> -->

	<!-- Template Main JS File -->
	<script src="../assets/js/main.js"></script>

</body>

</html>