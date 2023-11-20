<?php
	if(isset($_SESSION)){}else{ session_start(); }
	$rut='../../';
	$rut2='../../../';
	$pagina='Detalle del Contacto';
	$padre='Contacto';
	$direc='contacto.php';
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
			<div class="col-sm-3"></div>
			<div class="col-sm-6 text-center">
				<h3>Seguimiento al Cliente</h3>
			</div>
			<div class="col-sm-3 text-right">
				<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" >Nuevo Seguimiento <i class="fa fa-plus"></i></button>
			</div>
			<hr>
			<div class="col-sm-12">
				<table id="table1" class="table table-hover">
					<?= $data->seg; ?>
				</table>
			</div>
		</div>

		<hr>

		<div class="row">
			<div class="col-sm-1"></div>
			<div class="col-sm-10">
				<form class="col-sm-12" method="post" enctype="multipart/form-data" action="<?= ACTI.$direc; ?>">
					<div class="card">
					  <div class="card-header">
						Información del <?= $padre; ?>
					  </div>
					  <div class="card-body">
						<div class="form-group">
							<label for="recipient-name" class="col-form-label">Nombre:</label>
							<label class="form-control"><?= $inf->nombre; ?></label>
						  </div>
						  <div class="form-group">
							<label for="message-text" class="col-form-label">Correo:</label>
							<label class="form-control"><?= $inf->correo; ?></label>
						  </div>
						  <div class="form-group">
							<label for="message-text" class="col-form-label">Teléfono:</label>
							<label class="form-control"><?= $inf->telefono; ?></label>
						  </div>
						  <div class="form-group">
						  	<div class="card">
						  		<h4 class="title-card">Mensaje del Cliente:</h4>
						  		<div class="card-body">
						  			<?= $inf->mensaje; ?>
						  		</div>
						  	</div>
						  </div>
					  </div>
					</div>
				</form>
				<hr>
				<div class="row pb-4 mb-4">
					<div class="card bg-danger col-sm-12">
						<div class="card-header text-center">
							<h4 class="text-white">Datos de Seguridad</h4>
						</div>
						<div class="card-body">
							<div class="row">
								<div class="col-sm-4">
									<div class="form-group">
										<label class="form-control-label text-white">utm_id:</label>
										<label class="form-control"><?= $inf->utm_id; ?></label>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form-group">
										<label class="form-control-label text-white">utm_campaign:</label>
										<label class="form-control"><?= $inf->utm_campaign; ?></label>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form-group">
										<label class="form-control-label text-white">utm_source:</label>
										<label class="form-control"><?= $inf->utm_source; ?></label>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form-group">
										<label class="form-control-label text-white">utm_medium:</label>
										<label class="form-control"><?= $inf->utm_medium; ?></label>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form-group">
										<label class="form-control-label text-white">utm_content:</label>
										<label class="form-control"><?= $inf->utm_content; ?></label>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form-group">
										<label class="form-control-label text-white">utm_term:</label>
										<label class="form-control"><?= $inf->utm_term; ?></label>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form-group">
										<label class="form-control-label text-white">fbclid:</label>
										<label class="form-control"><?= $inf->fbclid; ?></label>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form-group">
										<label class="form-control-label text-white">gclid:</label>
										<label class="form-control"><?= $inf->gclid; ?></label>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-4">
									<div class="form-group">
										<label class="form-control-label text-white">IP del Cliente:</label>
										<label class="form-control"><?= $inf->ip_cli; ?></label>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form-group">
										<label class="form-control-label text-white">Navegador del Cliente:</label>
										<label class="form-control"><?= $inf->nav_cli; ?></label>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form-group">
										<label class="form-control-label text-white">Sistema O. del Cliente:</label>
										<label class="form-control"><?= $inf->sist_cli; ?></label>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-sm-1"></div>
		</div>
	</div>
	<?php require_once($rut.'2java.php'); ?>
	<?php require_once($rut.'3toastr.php'); ?>
	<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <form method="POST" enctype="multipart/form-data" action="<?= ACTI.$direc; ?>">
			  <div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Nuevo Seguimiento</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			  </div>
			  <div class="modal-body">
				  <div class="form-group">
					<label for="message-text" class="col-form-label">Respuesta:</label>
					<textarea class="form-control ckeditor" id="ckeditor" name="respuesta"></textarea>
				  </div>
			  </div>
			  <div class="modal-footer">
				<input type="hidden" name="pid" value="<?= base64_encode($pid); ?>">
			  	<input type="hidden" name="sid" value="<?= base64_encode($sid); ?>">
			  	<input type="hidden" name="url" value="<?= base64_encode($location); ?>">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
				<button type="submit" name="addSeg" class="btn btn-primary">Guardar Seguimiento</button>
			  </div>
		  </form>
		</div>
	  </div>
	</div>
	<div class="modal fade" id="dropSeg" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <form method="POST" action="<?= ACTI.$direc; ?>">
			  <div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Eliminar <?= substr($pagina, 0, -1); ?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			  </div>
			  <div class="modal-body">
				  <div class="form-group">
				  	<p>¿Está seguro de <b>Eliminar el Registro:</b>?</p>
				  </div>
			  </div>
			  <div class="modal-footer">
				<input type="hidden" id="dropid" name="pid">
			  	<input type="hidden" name="sid" value="<?= base64_encode($sid); ?>">
			  	<input type="hidden" name="url" value="<?= base64_encode($location); ?>">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
				<button type="submit" name="dropSeg" class="btn btn-primary">Borrar el <?= substr($pagina, 0, -1); ?></button>
			  </div>
		  </form>
		</div>
	  </div>
	</div>
	<script>
		function dropSeg(datos){
			var infor=datos.split("||");
			/*
			Divide la cadena a array por este caracter: ( || )
				'MQ==||Comunicación||'			cadena que recibe y la divide dentro de un array de la siguiente manera:
				$infor[0] = 'MQ=='				valor 0
				$infor[1] = 'Comunicación'		valor 1
				$infor[2] = ''					valor 2
			*/
			//--------------------------------
			$('#dropid').val(infor[0]);
			$('#nombre_curso').html(infor[1]);
		}
	</script>
</body>
</html>
<?php
	if (isset($_SESSION['Mysqli_Error'])) { unset($_SESSION['Mysqli_Error']); }
	if (isset($_SESSION['stat'])) { unset($_SESSION['stat']); }
	if (isset($_SESSION['sql'])) { unset($_SESSION['sql']); }