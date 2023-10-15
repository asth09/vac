<?php
	if(isset($_SESSION)){}else{ session_start(); }
	$rut='../../';
	$rut2='../../../';
	$pagina='Detalle del Curso';
	$padre='Curso';
	$direc='cursos.php';
	require_once($rut.'0code.php');
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title><?= $pagina.TIT; ?></title>
	<?php
		require_once($rut.'1styles.php');
		//---------------------------------
		$data=null;$inf=null;
		//---------------------------------
		require_once($rut2.DIRACT.$direc);
		$data = detalle($rut2,$pid);
		//---------------------------------
		if (isset($data->inf)) {
			$inf = $data->inf;
		}else{
			header("Location: ../");
			exit();
		}
		//---------------------------------
		require_once($rut.'0mens.php');
	?>
</head>
<body>
	<?php include_once($rut.'nav.php'); ?>

	<div class="container">
		<div class="row pb-5">
			<br>
		</div>

		<hr>
		
		<div class="row">
			<div class="col-sm-3 text-left">
				<a href="../" class="btn btn-secondary">Regresar</a>
			</div>
			<div class="col-sm-6 text-center">
				<h2><?= $pagina; ?></h2>
			</div>
			<div class="col-sm-3 text-right">
			</div>
		</div>
		
		<?php include_once($rut.'0error.php'); ?>
		
		<hr>

		<div class="row">
			<div class="col-sm-1"></div>
			<div class="col-sm-10">
				<form class="col-sm-12" method="post" enctype="multipart/form-data" action="<?= ACTI.$direc; ?>">
					<div class="card">
					  <div class="card-header">
						Editar el <?= $padre; ?>
					  </div>
					  <div class="card-body">
						<div class="form-group">
							<label for="recipient-name" class="col-form-label">Nombre:</label>
							<input type="text" class="form-control" name="nombre" value="<?= $inf->nombre; ?>" required="required">
						  </div>
						  <div class="form-group">
							<label for="message-text" class="col-form-label">Descripción:</label>
							<textarea class="form-control ckeditor" id="ckeditor" name="descrip"><?= $inf->descrip; ?></textarea>
						  </div>
						  <div class="form-group">
						  	<input type="hidden" name="imagen_ant" value="<?= $inf->imagen; ?>">
						  	<?php if (strlen($inf->imagen) > 5): ?>
						  		<img  style="max-width: 350px; max-height: 400px;" src="<?= IMG; ?>cursos/<?= $inf->imagen; ?>">
						  	<?php endif ?>						  	
						  </div>						  
						  <div class="form-group">
							<label for="recipient-name" class="col-form-label">Foto:</label>
							<div class="custom-file">
							  <input type="file" class="custom-file-input" id="customFile" name="imagen">
							  <label class="custom-file-label" for="customFile">Seleccione foto para reemplazar la antigua</label>
							</div>
						  </div>
						  <hr>
						  <div class="form-group">
							<input type="hidden" name="pid" value="<?= base64_encode($pid); ?>">
			  				<input type="hidden" name="sid" value="<?= base64_encode($sid); ?>">
			  				<input type="hidden" name="url" value="<?= base64_encode($location); ?>">
							<a href="../" class="btn btn-secondary">Regresar</a>
							<button type="submit" name="editar" class="btn btn-primary">Editar <i class="fa fa-edit"></i></button>
						  </div>
					  </div>
					</div>
				</form>
			</div>
			<div class="col-sm-1"></div>
		</div>
	</div>

	<?php require_once($rut.'2java.php'); ?>
	<?php require_once($rut.'3toastr.php'); ?>
</body>
</html>
<?php
	if (isset($_SESSION['Mysqli_Error'])) { unset($_SESSION['Mysqli_Error']); }
	if (isset($_SESSION['stat'])) { unset($_SESSION['stat']); }
	if (isset($_SESSION['sql'])) { unset($_SESSION['sql']); }