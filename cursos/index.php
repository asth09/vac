<?php
	session_start();
	$rut='../';
	$pagina='Cursos';
	$direc='cursos.php';
	require_once($rut.'0code.php');
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title><?= $pagina.TIT; ?></title>
	<?php require_once($rut.'1styles.php'); ?>

	<?php
		$inf=null;

		require_once($rut.DIRACT.$direc);
		$inf = index($rut);

		//require_once($rut.'0mens.php');
	?>
</head>
<body>

	<div class="container">
		<div class="row pb-5">
			<?php if (isset($_SESSION['Mysqli_Error'])): ?>
				<div class="col-sm-12 text-center alert alert-danger"><?= $_SESSION['Mysqli_Error']; ?></div>
			<?php endif ?>
			<?php if (isset($_SESSION['stat'])): ?>
				<div class="col-sm-12 text-center alert alert-secondary"><?= $_SESSION['stat']; ?></div>
			<?php endif ?>
		</div>

		<hr>
		
		<div class="row">
			<div class="col-sm-3"></div>
			<div class="col-sm-6 text-center">
				<h2>Lista de <?= $pagina; ?></h2>
			</div>
			<div class="col-sm-3 text-right">
				<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" >Nuevo <?= substr($pagina, 0, -1); ?></button>
			</div>
		</div>
		
		<hr>

		<div class="row">
			<div class="col-sm-1"></div>
			<div class="col-sm-10">
				<table class="table table-dark">
					<?php echo $inf; $inf=null; ?>
				</table>
			</div>
			<div class="col-sm-1"></div>
		</div>
	</div>

	<?php require_once($rut.'2java.php'); ?>

	<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <form method="POST" action="<?= ACTI.$direc; ?>">
		      <div class="modal-header">
		        <h5 class="modal-title" id="exampleModalLabel">Nuevo <?= substr($pagina, 0, -1); ?></h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		      </div>
		      <div class="modal-body">
		          <div class="form-group">
		            <label for="recipient-name" class="col-form-label">Nombre:</label>
		            <input type="text" class="form-control" name="nombre" required="required">
		          </div>
		          <div class="form-group">
		            <label for="message-text" class="col-form-label">Descripción:</label>
		            <textarea class="form-control ckeditor" id="ckeditor" name="descrip"></textarea>
		          </div>
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
		        <button type="submit" name="guardar" class="btn btn-primary">Guardar <?= substr($pagina, 0, -1); ?></button>
		      </div>
	      </form>
	    </div>
	  </div>
	</div>

    <script>
        function drop(datos){
            var infor=datos.split("||");
            /*'MQ==||Comunicación||'
            $infor[0] = 'MQ=='
            $infor[1] = 'Comunicación'
            $infor[2] = ''*/

            $('#dropid').val(infor[0]);
            $('#nombre_curso').html(infor[1]);
        }
    </script>

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
		        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
		        <input type="hidden" name="pid" id="dropid">
		        <button type="submit" name="eliminar" class="btn btn-primary">Borrar el <?= substr($pagina, 0, -1); ?></button>
		      </div>
	      </form>
	    </div>
	  </div>
	</div>
</body>
</html>
<?php
	if (isset($_SESSION['Mysqli_Error'])) { unset($_SESSION['Mysqli_Error']); }
	if (isset($_SESSION['stat'])) { unset($_SESSION['stat']); }
?>