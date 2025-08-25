<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta content="width=device-width, initial-scale=1.0" name="viewport">
	<title>Sistema de Reservas</title>
	<meta name="description" content="">
	<meta name="keywords" content="">

	<!-- Favicons -->
	<link href="dist/img/LogoChico.jpg" rel="icon">
	<link href="dist/img/LogoChico.jpg" rel="apple-touch-icon">

	<!-- Fonts -->
	<link href="https://fonts.googleapis.com" rel="preconnect">
	<link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

	<!-- Vendor CSS Files -->
	<link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
	<link href="assets/vendor/aos/aos.css" rel="stylesheet">
	<link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
	<link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
	<link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

	<!-- Main CSS File -->
	<link href="assets/css/main.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: Medilab
  * Template URL: https://bootstrapmade.com/medilab-free-medical-bootstrap-theme/
  * Updated: Aug 07 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body class="index-page">

	<header id="header" class="header sticky-top">

		<div class="topbar d-flex align-items-center">
			<div class="container d-flex justify-content-center justify-content-md-between">
				<div class="contact-info d-flex align-items-center">
					<i class="bi bi-envelope d-flex align-items-center"><a href="mailto:informecardioinfantil@gmail.com">informecardioinfantil@gmail.com</a></i>
					<i class="bi bi-telephone d-flex align-items-center ms-4"><span>(0342) 4565514</span></i>
					{{-- <i class="bi bi-whatsapp d-flex align-items-center ms-4"><span>+549 342 5482393</span></i> --}}
				</div>
			</div>
		</div><!-- End Top Bar -->

		<div class="branding d-flex align-items-center">

			<div class="container position-relative d-flex align-items-center justify-content-between">
				<a href="index.html" class="logo d-flex align-items-center me-auto">
					<!-- Uncomment the line below if you also wish to use an image logo -->
					<!-- <img src="assets/img/logo.png" alt=""> -->
					<h1 class="sitename">Centro de Cardiología</h1>
				</a>

				<nav id="navmenu" class="navmenu">
					<ul>
						<li><a href="#hero" class="active">Inicio<br></a></li>
						<li><a href="#contact">Contacto</a></li>
					</ul>
					<i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
				</nav>

				<a class="cta-btn d-none d-sm-block" href="{{url('login')}}">Administración</a>

			</div>
		</div>

	</header>

	<main class="main">

		<!-- Hero Section -->
		<section id="hero" class="hero section light-background">

			<img src="assets/img/hero-bg.jpg" alt="" data-aos="fade-in">

			<div class="container position-relative">

				<div class="welcome position-relative" data-aos="fade-down" data-aos-delay="100">
					<h2>Bienvenido</h2>
					<p>al Centro de Cardiología Infantil Santa Fe</p>
				</div><!-- End Welcome -->

				<div class="content row gy-4">
					<div class="col-lg-4 d-flex align-items-stretch">
						<div class="why-box" data-aos="zoom-out" data-aos-delay="200">
							<h3>Reserva tu turno</h3>
							<h4>Datos necesarios:</h4>
							<p>DNI, nombre y apellido completo, sexo, fecha de nacimiento, obra social y nro. afiliado.</p>
							<div class="text-center">
								<a href="{{url('login')}}" class="more-btn"><span>Reservar turno</span> <i class="bi bi-chevron-right"></i></a>
							</div>
						</div>
					</div><!-- End Why Box -->

					<div class="col-lg-8 d-flex align-items-stretch">
						<div class="d-flex flex-column justify-content-center">
							<div class="row gy-4">

								<div class="col-xl-4 d-flex align-items-stretch">
									<div class="icon-box" data-aos="zoom-out" data-aos-delay="300">
										<i class="bi bi-activity"></i>
										<h4>Electrocardiogramas</h4>
										<p>Un electrocardiograma (ECG o EKG) es una prueba que registra la actividad eléctrica del corazón, que se produce en cada latido. Esta prueba es rápida, indolora y se usa para evaluar la función cardíaca y detectar problemas como arritmias y ataques cardíacos.</p>
									</div>
								</div><!-- End Icon Box -->

								<div class="col-xl-4 d-flex align-items-stretch">
									<div class="icon-box" data-aos="zoom-out" data-aos-delay="400">
										<i class="bi bi-heart-pulse"></i>
										<h4>Estudios Holter</h4>
										<p>Un monitor Holter es un dispositivo electrónico pequeño y portátil que registra y almacena la actividad eléctrica del corazón, también conocida como electrocardiograma (ECG), durante un período de tiempo prolongado, generalmente 24 o 48 horas.</p>
									</div>
								</div><!-- End Icon Box -->

								<div class="col-xl-4 d-flex align-items-stretch">
									<div class="icon-box" data-aos="zoom-out" data-aos-delay="500">
										<i class="bi bi-clipboard2-pulse"></i>
										<h4>Ecocardiograma Doppler Color</h4>
										<p>Un ecocardiograma Doppler color es un examen de imagen que utiliza ultrasonido para evaluar la estructura y función del corazón, así como también el flujo sanguíneo a través de sus válvulas y cámaras. En esencia, es un ecocardiograma que añade la información del flujo de sangre a la imagen tradicional de la estructura cardíaca.</p>
									</div>
								</div><!-- End Icon Box -->

							</div>
						</div>
					</div>
				</div><!-- End  Content-->

			</div>

		</section><!-- /Hero Section -->

		<!-- Contact Section -->
		<section id="contact" class="contact section mt-5">

			<!-- Section Title -->
			<div class="container section-title" data-aos="fade-up">
				<h2>Contáctenos</h2>
			</div><!-- End Section Title -->

			<div class="mb-1" data-aos="fade-up" data-aos-delay="200">
				<iframe style="border:0; width: 100%; height: 270px;" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3396.675666530985!2d-60.71862122364483!3d-31.642729507231024!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x95b5a9b406c7e451%3A0x8fba90be81d1a27a!2sCatamarca%203373%2C%20S3000%20Santa%20Fe%20de%20la%20Vera%20Cruz%2C%20Santa%20Fe!5e0!3m2!1ses!2sar!4v1749510056966!5m2!1ses!2sar" frameborder="0" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
			</div><!-- End Google Maps -->

			<div class="container" data-aos="fade-up" data-aos-delay="100">

				<div class="row gy-2">

					<div class="col-lg-4">
						<div class="info-item d-flex" data-aos="fade-up" data-aos-delay="300">
							<i class="bi bi-geo-alt flex-shrink-0"></i>
							<div>
								<h3>Ubicación</h3>
								<p>Catamarca 3373 - (3000) Santa Fe</p>
							</div>
						</div><!-- End Info Item -->

						<div class="info-item d-flex" data-aos="fade-up" data-aos-delay="400">
							<i class="bi bi-telephone flex-shrink-0"></i>
							<div>
								<h3>Contáctenos al</h3>
								<p>(0342) 4565514</p>
							</div>
						</div><!-- End Info Item -->

						<div class="info-item d-flex" data-aos="fade-up" data-aos-delay="400">
							<i class="bi bi-whatsapp flex-shrink-0"></i>
							<div>
								<h3>WhatsApp al</h3>
								<p>+549 342 5482393</p>
							</div>
						</div><!-- End Info Item -->

						<div class="info-item d-flex" data-aos="fade-up" data-aos-delay="500">
							<i class="bi bi-envelope flex-shrink-0"></i>
							<div>
								<h3>Email</h3>
								<p>informecardioinfantil@gmail.com</p>
							</div>
						</div><!-- End Info Item -->

					</div>

					<div class="col-lg-8">
						<form action="forms/contact.php" method="post" class="php-email-form" data-aos="fade-up" data-aos-delay="200">
							<div class="row gy-4">

								<div class="col-md-6">
									<input type="text" name="name" class="form-control" placeholder="Apellido y Nombres" required="">
								</div>

								<div class="col-md-6 ">
									<input type="email" class="form-control" name="email" placeholder="Email" required="">
								</div>

								<div class="col-md-12">
									<input type="text" class="form-control" name="subject" placeholder="Asunto" required="">
								</div>

								<div class="col-md-12">
									<textarea class="form-control" name="message" rows="6" placeholder="Mensaje" required=""></textarea>
								</div>

								<div class="col-md-12 text-center">
									<div class="loading">Cargando</div>
									<div class="error-message"></div>
									<div class="sent-message">Su mensaje a sido enviado. Gracias...!</div>

									<button type="submit">Enviar Mensaje</button>
								</div>

							</div>
						</form>
					</div><!-- End Contact Form -->
				</div>
			</div>
		</section><!-- /Contact Section -->

	</main>

	<footer id="footer" class="footer">

		<div class="container copyright text-center">
			<p>© <span>Copyright -</span> <strong class="px-1 sitename">Centro de Cardiología Infantil Santa Fe</strong> <span> - Todos los derechos reservados</span></p>
			<div class="credits">
				<!-- All the links in the footer should remain intact. -->
				<!-- You can delete the links only if you've purchased the pro version. -->
				<!-- Licensing information: https://bootstrapmade.com/license/ -->
				<!-- Purchase the pro version with working PHP/AJAX contact form: [buy-url] -->
				<!-- Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a> -->
			</div>
		</div>

	</footer>

	<!-- Scroll Top -->
	<a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

	<!-- Preloader -->
	<div id="preloader"></div>

	<!-- Vendor JS Files -->
	<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script src="assets/vendor/php-email-form/validate.js"></script>
	<script src="assets/vendor/aos/aos.js"></script>
	<script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
	<script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
	<script src="assets/vendor/swiper/swiper-bundle.min.js"></script>

	<!-- Main JS File -->
	<script src="assets/js/main.js"></script>

</body>

</html>