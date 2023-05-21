<?php
	/**
	 * 
	 */
	class cursos extends db
	{
		private $table ='cursos';
		private $action='cursos.php?met=';
		private $detail='detalle/?p=';
		private $tid= 'id';
		//---------------------------------------
		function listar($c1){
			$inf=null;$n=1;$cant=6;
			//--------------------
			$inf.='<thead>';
				$inf.='<tr>';
					$inf.='<th>#</th>';
					$inf.='<th>Imagen</th>';
					$inf.='<th>Nombre</th>';
					$inf.='<th>Descripción</th>';
					$inf.='<th>Creado</th>';
					$inf.='<th>Gestión</th>';
				$inf.='</tr>';
			$inf.='</thead>';
			$inf.='<tbody>';
				$sql = "SELECT * FROM ".$this->table." WHERE status <> 2 ORDER BY ".$this->tid." DESC;";
				$res = mysqli_query($c1,$sql) OR $_SESSION['Mysqli_Error'] = (mysqli_error($c1));
				if ($res) {
					if ($res->num_rows > 0) {
						while ($row = mysqli_fetch_array($res)) {
							$inf.='<tr>';
								$inf.='<td scope="row">'.$n.'</td>';
								$inf.='<td>';
									if (strlen($row['imagen']) > 5) {
										$inf.='<img style="max-width: 100px; max-height: 100px;" src="'.IMG.'cursos/'.$row['imagen'].'" />';
									}else{
										$inf.='No imagen';
									}
								$inf.='</td>';
								$inf.='<td>'.$row['nombre'].'</td>';
								$inf.='<td>'.$row['descrip'].'</td>';
								$inf.='<td>'.$row['created_at'].'</td>';
								$inf.='<td>';
									$inf.='<a href="'.$this->detail.base64_encode($row[$this->tid]).'" class="btn btn-outline-warning" title="Editar">';
										$inf.='<i class="fa fa-edit"></i>';
									$inf.='</a>';
									switch ($row['status']) {
										case 0:
											$inf.='<a href="'.ACTI.$this->action.'acti&p='.base64_encode($row[$this->tid]).'" class="btn btn-outline-warning" title="Clic para Activar">';
												$inf.='<i class="fa fa-ban"></i>';
											$inf.='</a>';
										break;
										case 1:
											$inf.='<a href="'.ACTI.$this->action.'desact&p='.base64_encode($row[$this->tid]).'" class="btn btn-outline-success" title="Clic para Desactivar">';
												$inf.='<i class="fa fa-check"></i>';
											$inf.='</a>';
										break;
										default:
											$inf.='<a href="'.ACTI.$this->action.'acti&p='.base64_encode($row[$this->tid]).'" class="btn btn-outline-danger" title="Clic para Activar">';
												$inf.='<i class="fa fa-times"></i>';
											$inf.='</a>';
										break;
									}
									$inf.='<button type="button" class="btn btn-outline-danger" data-toggle="modal" data-target="#drop" onclick="drop('."'".base64_encode($row[$this->tid])."||".$row['nombre']."||'".');"><i class="fa fa-trash"></i></button>';
								$inf.='</td>';
							$inf.='</tr>';

							$n++;
						}
						mysqli_free_result($res);//liberar memoria del resultado
					}else{
						$inf.='<tr><td colspan="'.$cant.'"><div class="alert alert-warning">No se encontró ningún registro</div></td></tr>';
					}
				}else{
					$inf.='<tr><td colspan="'.$cant.'"><div class="alert alert-danger">Error: '.$_SESSION['Mysqli_Error'].'</div></td></tr>';
				}
			$inf.='</tbody>';
			//--------------------
			mysqli_close($c1);
			return $inf;
		}
		function exportar($c1,$tip){
			$inf=null;$n=1;$cant=8;
			//--------------------
			$inf.='<thead>';
				$inf.='<tr>';
					$inf.='<th>#</th>';
					$inf.='<th>Nombre</th>';
					$inf.='<th>Descripción</th>';
					$inf.='<th>Creado</th>';
					$inf.='<th>Editado</th>';
					$inf.='<th>Eliminado</th>';
					$inf.='<th>Estado</th>';
					$inf.='<th>Imagen</th>';
				$inf.='</tr>';
			$inf.='</thead>';
			$inf.='<tbody>';
				$sql = "SELECT * FROM ".$this->table." ;";
				$res = mysqli_query($c1,$sql) OR $_SESSION['Mysqli_Error'] = (mysqli_error($c1));
				if ($res) {
					if ($res->num_rows > 0) {
						while ($row = mysqli_fetch_array($res)) {
							$inf.='<tr>';
								$inf.='<th>'.$n.'</th>';
								$inf.='<td>'.$row['nombre'].'</td>';
								$inf.='<td>'.$row['descrip'].'</td>';
								$inf.='<td>'.$row['created_at'].'</td>';
								$inf.='<td>'.$row['updated_at'].'</td>';
								$inf.='<td>'.$row['drop_at'].'</td>';
								$inf.='<td>';
									switch ($row['status']) {
										case 0:
											$inf.='Inactivo';
										break;
										case 1:
											$inf.='Activo';
										break;
										case 2:
											$inf.='Eliminado';
										break;
									}
								$inf.='</td>';
								$inf.='<td>';
									if (strlen($row['imagen']) > 5) {
										if ($tip==1) {
											$inf.='<img style="max-width: 100px; max-height: 100px;" src="'.IMG.'cursos/'.$row['imagen'].'" />';
										}else{
											$inf.='<img style="max-width: 100px; max-height: 100px;" src="'.__DIRIMG__.'cursos/'.$row['imagen'].'" />';
										}
									}else{
										$inf.='No imagen';
									}
								$inf.='</td>';
							$inf.='</tr>';

							$n++;
						}
						mysqli_free_result($res);//liberar memoria del resultado
					}else{
						$inf.='<tr><td colspan="'.$cant.'">No se encontró ningún registro</td></tr>';
					}
				}else{
					$inf.='<tr><td colspan="'.$cant.'">Error: '.$_SESSION['Mysqli_Error'].'</td></tr>';
				}
			$inf.='</tbody>';
			//--------------------
			mysqli_close($c1);
			return $inf;
		}
		function cliente($c1,$c2){
			$inf=null;$n=1;
			//---------------------
			$inf.='<div class="hero-slider">';
				$sql = "SELECT nombre, imagen FROM ".$this->table." WHERE status=1;";
				$res = mysqli_query($c1,$sql) OR $_SESSION['Mysqli_Error'] = (mysqli_error($c1));
				if ($res) {
					if ($res->num_rows > 0) {
						while ($row = mysqli_fetch_array($res)) {
							$inf.='<div class="slide-item">';
								$inf.='<a class="fresco" href="'.IMG.'cursos/'.$row['imagen'].'" data-fresco-group="projects">';
									$inf.='<img src="'.IMG.'cursos/'.$row['imagen'].'" alt="'.$row['nombre'].'">';
								$inf.='</a>';
							$inf.='</div>';
						}
						mysqli_free_result($res);//liberar memoria del resultado
					}else{
						$inf.='<div class="alert alert-warning">No se encontró ningún registro</div>';
					}
				}else{
					$inf.='<div class="alert alert-danger">Error: '.$_SESSION['Mysqli_Error'].'</div>';
				}
			$inf.='</div>';
			//---------------------
			$inf.='<div class="hero-text-slider">';
				$sql = "SELECT id, nombre FROM ".$this->table." WHERE status=1;";
				$res = mysqli_query($c1,$sql) OR $_SESSION['Mysqli_Error'] = (mysqli_error($c1));
				if ($res) {
					if ($res->num_rows > 0) {
						while ($row = mysqli_fetch_array($res)) {
							$inf.='<div class="text-item">';
								$inf.='<h2>'.$row['nombre'].'</h2>';
								$inf.='<p><a href="'.$this->detail.base64_encode($row[$this->tid]).'" class="btn btn-outline-info">Ver Curso</a></p>';
							$inf.='</div>';
						}
						mysqli_free_result($res);//liberar memoria del resultado
					}else{
						$inf.='<div class="alert alert-warning">No se encontró ningún registro</div>';
					}
				}else{
					$inf.='<div class="alert alert-danger">Error: '.$_SESSION['Mysqli_Error'].'</div>';
				}
			$inf.='</div>';
			//---------------------
			mysqli_close($c1);
			return $inf;
		}
		function callID($c1,$pid){
			$data= new stdClass();
			//-------------------------
			$sql = "SELECT * FROM ".$this->table." WHERE ".$this->tid."=".$pid." ;";
			$res = mysqli_query($c1,$sql) OR $_SESSION['Mysqli_Error'] = (mysqli_error($c1));
			if ($res) {
				if ($res->num_rows > 0) {
					$data->result = 1;
					$data->mensaje = 'Registro encontrado.';
					while ($row = mysqli_fetch_array($res)) {
						$data->nombre = $row['nombre'];
						$data->descrip = $row['descrip'];
						$data->imagen = $row['imagen'];
					}
					mysqli_free_result($res);//liberar memoria del resultado
				}else{
					$data->result = 2;
					$data->mensaje = 'No se encontraron coincidencias.';
				}
			}else{
				$data->result = 3;
				$data->mensaje = 'No se ejecutó la consulta. Error: '.$_SESSION['Mysqli_Error'];
			}
			//-------------------------
			mysqli_close($c1);
			return $data;
		}
		function add($c1,$dt){
			$data = new stdClass(); $sql=null;
			//-------------------------------------
			$er=1;
			if(is_null($dt['nombre'])){ $er=0; }
			if(is_null($dt['imagen'])){ $er=0; }
			//-------------------------------------
			if ($er == 1) {
				$sql = $this->get_sql($this->table, $dt, 1);
				$res = mysqli_query($c1,$sql) OR $data->error = (mysqli_error($c1));
				if ($res) {
					$data->result = true;
					$data->inf = 'add';
				}else{
					$data->result = false;
					$data->inf = 'noadd';
				}
			}else{
				$data->result = false;
				$data->inf = 'null';
			}
			//------------------
			$data->sql = $sql;
			//------------------
			mysqli_close($c1);
			return $data;
		}
		function edit($c1,$dt,$pid){
			$data = new stdClass(); $sql=null;
			function validarEdit($pid,$dt){
				$er=1;
				if(is_null($pid)){ $er=0; }
				if($pid <= 0){ $er=0; }
				if(is_null($dt['nombre'])){ $er=0; }
				if(is_null($dt['imagen'])){ $er=0; }
				return $er;
			}
			if (validarEdit($pid,$dt) == 1) {
				$sql = $this->get_sql($this->table, $dt, 2, $this->tid, $pid);
				$res = mysqli_query($c1,$sql) OR $_SESSION['Mysqli_Error'] = (mysqli_error($c1));
				if ($res) {
					$data->result = true;
					$data->inf='edit';
				}else{
					$data->result = false;
					$data->inf='noedit';
				}
			}else{
				$data->result = false;
				$data->inf = 'null';
			}
			//------------------
			$data->sql = $sql;
			//------------------
			mysqli_close($c1);
			return $data;
		}
		function estado($c1,$dt,$pid){
			$data = new stdClass(); $sql=null;
			function validarEst($pid){
				$er=1;
				if(is_null($pid)){ $er=0; }
				if($pid <= 0){ $er=0; }
				return $er;
			}
			if (validarEst($pid)==1) {
				$sql = $this->get_sql($this->table, $dt, 2, $this->tid, $pid);
				$res=mysqli_query($c1,$sql) or $_SESSION['Mysqli_Error'] = (mysqli_error($c1));
				if ($res) {
					$data->result = true;
					switch ($dt['status']) {
						case 0:
							$data->inf = 'desact';
						break;
						case 1:
							$data->inf = 'acti';
						break;
						default:
							$data->inf = 'drop';
						break;
					}
				}else{
					$data->result = false;
					switch ($dt['status']) {
						case 0:
							$data->inf = 'nodesact';
						break;
						case 1:
							$data->inf = 'noacti';
						break;
						default:
							$data->inf = 'nodrop';
						break;
					}
				}
			}else{
				$data->result = false;
				$data->inf="null";
			}
			//------------------
			$data->sql = $sql;
			//------------------------------------
			mysqli_close($c1);
			return $data;
		}
	}