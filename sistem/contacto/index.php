<?php
	if(isset($_SESSION)){}else{ session_start(); }
	$rut='../';
	$rut2='../../';
	$pagina='contacto';
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
		$data = index($rut2,$location);
		//---------------------------------
		if (isset($data->inf)) {
			$inf = $data->inf;
		}else{
			header("Location: ".$rut);
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
			<div class="col-sm-3">
				<div class="dropdown">
				  <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					Acciones
				  </button>
				  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
					<a class="dropdown-item" href="<?= XCEL.$direc; ?>">Exportar Excel <i class="fa fa-file-excel-o"></i></a>
					<a class="dropdown-item" href="<?= PDFS.$direc; ?>">Exportar PDF <i class="fa fa-file-pdf-o"></i></a>
					<!--<a class="dropdown-item" href="#">Something else here</a>-->
				  </div>
				</div>
			</div>
			<div class="col-sm-6 text-center">
				<h2>Lista de <?= $pagina; ?></h2>
			</div>
			<div class="col-sm-3 text-right">
			</div>
		</div>

		<?php include_once($rut.'0error.php'); ?>

		<hr>

		<div class="row pb-5">
			<div class="col-sm-12">
				<table id="table1" class="table table-hover">
					<?= $inf; $inf=null; ?>
				</table>
			</div>
		</div>
	</div>
	<?php require_once($rut.'2java.php'); ?>
	<?php require_once($rut.'3toastr.php'); ?>
	<div class="modal fade" id="drop" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
				  	<p>¿Está seguro de <b>Eliminar el Registro: <em><label class="col-form-label" id="nombre_curso"></label></em></b>?</p>
				  </div>
			  </div>
			  <div class="modal-footer">
				<input type="hidden" name="pid" id="dropid">
				<input type="hidden" name="sid" value="<?= base64_encode($sid); ?>">
				<input type="hidden" name="url" value="<?= base64_encode($location); ?>">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
				<button type="submit" name="eliminar" class="btn btn-primary">Borrar el <?= substr($pagina, 0, -1); ?></button>
			  </div>
		  </form>
		</div>
	  </div>
	</div>
	<script type="text/javascript">
		function drop(datos){
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
			$('#nombre_curso').html(atob(infor[1]));
		}
	</script>
</body>
</html>
<?php
	if (isset($_SESSION['Mysqli_Error'])) { unset($_SESSION['Mysqli_Error']); }
	if (isset($_SESSION['stat'])) { unset($_SESSION['stat']); }
	if (isset($_SESSION['sql'])) { unset($_SESSION['sql']); }