<?php



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

	<link href="./assets/img/v1.0/favicon.png" type="image/x-icon" rel="icon" />
	<link href="./assets/img/v1.0/favicon.png" type="image/x-icon" rel="shortcut icon" />
	<link href="./assets/img/v1.0/icon.png" rel="apple-touch-icon">

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
	<!-- <link href="./assets/fonte/1/css.css" rel="stylesheet"> -->

</head>

<body>


	<!-- ======= Hero Section ======= -->
	<section id="hero">
		<div class="hero-container">
			<img src="./assets/img/v1.0/logo-geral.svg" alt="logo">

			<!-- <h2 data-aos="zoom-in f2">GRUPO</h2>
			<a href="./" class="hero-logo" data-aos="zoom-in">
				<img src="./assets/img/logobranco.svg" alt="logo">
			</a>
			<h3 data-aos="fade-up sa">SISTEMAS AUTOMATIZADOS</h3>
-->
			<div class='space'></div>
			<div class="row btIndex">
				<div class="col">
					<a data-aos="fade-up" data-aos-delay="200" href="./home/#inicio"
						class="btn-get-started scrollto">Automação Industrial<br /> e de Saneamento
					</a>
				</div>
				<div class="col">
					<a data-aos="fade-up" data-aos-delay="200" href="https://evolumaseg.com.br"
						class="btn-get-started scrollto">Rastreamento Veicular<br />e Gestão de Frotas
					</a>
				</div>
			</div>
		</div>
	</section>
	<!-- End Hero -->




	

	<div id="preloader"></div>



	<!-- Vendor JS Files -->
	<script src="./assets/vendor/aos/aos.js"></script>
	<script src="./assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script src="./assets/vendor/glightbox/js/glightbox.min.js"></script>
	<script src="./assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
	<script src="./assets/vendor/swiper/swiper-bundle.min.js"></script>
	<!-- <script src="./assets/vendor/php-email-form/validate.js"></script> -->

	<!-- Template Main JS File -->
	<script src="./assets/js/main.js"></script>

</body>

</html>