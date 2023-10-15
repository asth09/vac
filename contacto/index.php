<?php
	if(isset($_SESSION)){}else{ session_start(); }
	$rut='../';
	$pagina='Contacto';
	$direc='contacto.php';
	require_once($rut.'config/0code.php');
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title><?= $pagina.TIT; ?></title>
	<?php include_once($rut.CONF.'1styles.php'); ?>

	<?php
		require_once($rut.'sistem/0mens.php');
	?>
</head>
<body>
	<!-- Header Section -->
		<?php include_once($rut.CONF.'2nav.php'); ?>
	<!-- Header Section end -->

	<!-- Hero Section -->
	<section class="contact__page">
		<div class="contact__warp">
			<div class="row">
				<div class="col-md-4">
					<h2>Contacto</h2>
					<div class="contact__social">
						<a href="<?= FACE; ?>"><i class="fa fa-facebook"></i></a>
						<a href="<?= TWIT; ?>"><i class="fa fa-twitter"></i></a>
						<!--<a href=""><i class="fa fa-linkedin"></i></a>-->
						<a href="<?= INST; ?>"><i class="fa fa-instagram"></i></a>
					</div>
				</div>
				<div class="col-md-8">
					<div class="contact__text">
						<p>Celular: <a href="https://wa.me/51924741703" target="_blank">+51 924 741 703</a></p>
						<p>Correo: <a href="mailto:informes@frankmorenoalburqueque.com" target="_blank">informes@frankmorenoalburqueque.com</a></p>
						<p>Ubicación: Lima Lima Perú</p>
					</div>
				</div>
			</div>
			<form method="post" action="<?= ACTI.$direc; ?>" class="contact__form">
				<input type="text" name="nombre" placeholder="Nombre Completo" required="required" />
				<input type="text" name="correo" placeholder="Correo electrónico" required="required" />
				<input type="text" name="telefono" placeholder="Teléfono" required="required" />
				<textarea placeholder="Message" class="ckeditor" id="ckeditor" name="mensaje" required="required"></textarea>
			  	<input type="hidden" name="sid" value="<?= base64_encode($sid); ?>" />
			  	<input type="hidden" name="utm_id" value="<?= $utm_id; ?>" />
			  	<input type="hidden" name="utm_campaign" value="<?= $utm_campaign; ?>" />
			  	<input type="hidden" name="utm_source" value="<?= $utm_source; ?>" />
			  	<input type="hidden" name="utm_medium" value="<?= $utm_medium; ?>" />
			  	<input type="hidden" name="utm_content" value="<?= $utm_content; ?>" />
			  	<input type="hidden" name="utm_term" value="<?= $utm_term; ?>" />
			  	<input type="hidden" name="fbclid" value="<?= $fbclid; ?>" />
			  	<input type="hidden" name="gclid" value="<?= $gclid; ?>" />
			  	<input type="hidden" name="url" value="<?= base64_encode($location); ?>" />
			  	<input type="hidden" name="ip_cli" value="<?= base64_encode($ip_cli); ?>" />
			  	<input type="hidden" name="nav_cli" value="<?= base64_encode($nav_cli); ?>" />
			  	<input type="hidden" name="sist_cli" value="<?= base64_encode($sist_cli); ?>" />
				<button type="submit" id="enviar" name="guardar" class="site-btn btn-block">Enviar Mensaje</button>
				<button type="button" id="enviando" class="btn btn-danger btn-btn-block" style="display: none;">Enviando Mensaje....</button>
			</form>
		</div>
	</section>
	<!-- Hero Section end -->

	<!-- Footer Section -->
		<?php include_once($rut.CONF.'3footer.php'); ?>
	<!-- Footer Section end -->

	<!--====== Javascripts & Jquery ======-->
		<?php include_once($rut.CONF.'4java.php'); ?>
		<?php require_once($rut.'sistem/3toastr.php'); ?>
		<script type="text/javascript">
			$(document).ready(function() {
				$('#enviar').click(function() {
					$('#enviar').hide();
					$('#enviando').show();
					//-----------------------------
					setTimeout(function() {
						$('#enviar').show();
						$('#enviando').hide();
					}, 5000);
				});
			});
		</script>
</html>
<?php
	if (isset($_SESSION['Mysqli_Error'])) { unset($_SESSION['Mysqli_Error']); }
	if (isset($_SESSION['stat'])) { unset($_SESSION['stat']); }
	if (isset($_SESSION['sql'])) { unset($_SESSION['sql']); }