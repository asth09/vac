<?php
	/**
	 * 
	 */
	class cursos extends database
	{
		private $table ='cursos';
		private $action='cursos.php?met=';
		private $detail='detalle/?p=';
		private $tid= 'id';
		//---------------------------------------
		function listar($url){
			$fc_query=$this->db_query;$fc_error=$this->db_error;$fc_array=$this->db_array;$fc_object=$this->db_object;$fc_assoc=$this->db_assoc;$fc_num_r=$this->db_num_r;$fc_fre_r=$this->db_fre_r;$fc_close=$this->db_close;
			//---------------------------------------------------------
			$inf=null;$n=1;$cant=6;
			//----------------------------------
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
				$res = $this->db_exec($sql);
				if ($res->result==true && $res->cant > 0) {
					while ($row = $fc_assoc($res->res)) {
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
										$inf.='<a href="'.ACTI.$this->action.'acti&pid='.base64_encode($row[$this->tid]).'&url='.base64_encode($url).'" class="btn btn-outline-warning" title="Clic para Activar">';
											$inf.='<i class="fa fa-ban"></i>';
										$inf.='</a>';
									break;
									case 1:
										$inf.='<a href="'.ACTI.$this->action.'desact&pid='.base64_encode($row[$this->tid]).'&url='.base64_encode($url).'" class="btn btn-outline-success" title="Clic para Desactivar">';
											$inf.='<i class="fa fa-check"></i>';
										$inf.='</a>';
									break;
									default:
										$inf.='<a href="'.ACTI.$this->action.'acti&pid='.base64_encode($row[$this->tid]).'&url='.base64_encode($url).'" class="btn btn-outline-danger" title="Clic para Activar">';
											$inf.='<i class="fa fa-times"></i>';
										$inf.='</a>';
									break;
								}
								$inf.='<button type="button" class="btn btn-outline-danger" data-toggle="modal" data-target="#drop" onclick="drop('."'".base64_encode($row[$this->tid])."||".$row['nombre']."||'".');"><i class="fa fa-trash"></i></button>';
							$inf.='</td>';
						$inf.='</tr>';
						//----------------------------------
						$n++;
					}
					$fc_fre_r($res->res);//liberar memoria del resultado
				}else{
					if ($res->cant == 0) {
						$inf.='';
					}else{
						$inf.='<tr><td colspan="'.$cant.'"><div class="alert alert-danger">Error: '.$res->error.'</div></td></tr>';
					}
				}
			$inf.='</tbody>';
			//----------------------------------
			$fc_close($this->connect());
			return $inf;
		}
		function cliente(){
			$fc_query=$this->db_query;$fc_error=$this->db_error;$fc_array=$this->db_array;$fc_object=$this->db_object;$fc_assoc=$this->db_assoc;$fc_num_r=$this->db_num_r;$fc_fre_r=$this->db_fre_r;$fc_close=$this->db_close;
			//---------------------------------------------------------
			$inf=null;$n=1;
			//---------------------
			$inf.='<div class="hero-slider">';
				$sql = "SELECT nombre, imagen FROM ".$this->table." WHERE status=1;";
				$res = $this->db_exec($sql);
				if ($res->result==true && $res->cant > 0) {
					while ($row = $fc_assoc($res->res)) {
						$inf.='<div class="slide-item">';
							$inf.='<a class="fresco" href="'.IMG.'cursos/'.$row['imagen'].'" data-fresco-group="projects">';
								$inf.='<img src="'.IMG.'cursos/'.$row['imagen'].'" alt="'.$row['nombre'].'">';
							$inf.='</a>';
						$inf.='</div>';
					}
					$fc_fre_r($res->res);//liberar memoria del resultado
				}else{
					$inf.='<div class="alert alert-danger">Error: '.$res->error.'</div>';
				}
			$inf.='</div>';
			//---------------------
			$inf.='<div class="hero-text-slider">';
				$sql = "SELECT id, nombre FROM ".$this->table." WHERE status=1;";
				$res = $this->db_exec($sql);
				if ($res->result==true && $res->cant > 0) {
					while ($row = $fc_assoc($res->res)) {
						$inf.='<div class="text-item">';
							$inf.='<h2>'.$row['nombre'].'</h2>';
							$inf.='<p><a href="'.$this->detail.base64_encode($row[$this->tid]).'" class="btn btn-outline-info">Ver Curso</a></p>';
						$inf.='</div>';
					}
					$fc_fre_r($res->res);
				}else{
					if ($res->cant == 0) {
						$inf.='';
					}else{
						$inf.='<div class="alert alert-danger">Error: '.$res->error.'</div>';
					}
				}
			$inf.='</div>';
			//---------------------
			$fc_close($this->connect());
			return $inf;
		}
		function exportar($tip){
			$fc_query=$this->db_query;$fc_error=$this->db_error;$fc_array=$this->db_array;$fc_object=$this->db_object;$fc_assoc=$this->db_assoc;$fc_num_r=$this->db_num_r;$fc_fre_r=$this->db_fre_r;$fc_close=$this->db_close;
			//---------------------------------------------------------
			$inf=null;$n=1;$cant=10;
			//-------------------------------------
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
				$res = $this->db_exec($sql);
				if ($res->result==true && $res->cant > 0) {
					while ($row = $fc_assoc($res->res)) {
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
						//-------------------------------------
						$n++;
					}
					$fc_fre_r($res->res);//liberar memoria del resultado
				}else{
					if ($res->cant == 0) {
						$inf.='';
					}else{
						$inf.='<tr><td colspan="'.$cant.'"><div class="alert alert-danger">Error: '.$res->error.'</div></td></tr>';
					}
				}
			$inf.='</tbody>';
			//-------------------------------------
			$fc_close($this->connect());
			return $inf;
		}
	}