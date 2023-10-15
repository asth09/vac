<?php
	/**
	 * 
	 */
	class contacto extends database
	{
		private $table ='contacto';
		private $table1='seg_contacto';
		private $action='contacto.php?met=';
		private $detail='detalle/?p=';
		private $tid = 'id';
		private $tid2= 'id_seg';
		//---------------------
		function listar($url){
			$fc_query=$this->db_query;$fc_error=$this->db_error;$fc_array=$this->db_array;$fc_object=$this->db_object;$fc_assoc=$this->db_assoc;$fc_num_r=$this->db_num_r;$fc_fre_r=$this->db_fre_r;$fc_close=$this->db_close;
			//---------------------------------------------------------
			$inf=null;$n=1;$cant=7;
			//-------------------------------------
			$inf.='<thead>';
				$inf.='<tr>';
					$inf.='<th>#</th>';
					$inf.='<th>Nombre</th>';
					$inf.='<th>Correo</th>';
					$inf.='<th>Teléfono</th>';
					$inf.='<th>Mensaje</th>';
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
							$inf.='<th scope="row">'.$n.'</th>';
							$inf.='<td>'.$row['nombre'].'</td>';
							$inf.='<td>'.$row['correo'].'</td>';
							$inf.='<td>'.$row['telefono'].'</td>';
							$inf.='<td>'.$row['mensaje'].'</td>';
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
								$inf.='<button type="button" class="btn btn-outline-danger" data-toggle="modal" data-target="#drop" onclick="drop('."'".base64_encode($row[$this->tid])."||".base64_encode($row['nombre'])."||'".');"><i class="fa fa-trash"></i></button>';
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
			//-----------------------------
			$fc_close($this->connect());
			return $inf;
		}
		function listarSeg($pid){
			$fc_query=$this->db_query;$fc_error=$this->db_error;$fc_array=$this->db_array;$fc_object=$this->db_object;$fc_assoc=$this->db_assoc;$fc_num_r=$this->db_num_r;$fc_fre_r=$this->db_fre_r;$fc_close=$this->db_close;
			//---------------------------------------------------------
			$inf=null;$n=1;$cant=7;
			//-------------------------------------
			$inf.='<thead>';
				$inf.='<tr>';
					$inf.='<th>#</th>';
					$inf.='<th>Respuesta</th>';
					$inf.='<th>Nombre Cliente</th>';
					$inf.='<th>Correo Cliente</th>';
					$inf.='<th>Teléfono Cliente</th>';
					$inf.='<th>Fecha de respuesta</th>';
					$inf.='<th>Gestión</th>';
				$inf.='</tr>';
			$inf.='</thead>';
			$inf.='<tbody>';
				$sql = "SELECT r.*, c.nombre, c.correo, c.telefono FROM ".$this->table1." r INNER JOIN ".$this->table." c ON r.".$this->tid."=c.".$this->tid." WHERE r.status=1 AND r.".$this->tid."=".$pid." ORDER BY r.".$this->tid2." DESC;";
				$res = $this->db_exec($sql);
				if ($res->result==true && $res->cant > 0) {
					while ($row = $fc_assoc($res->res)) {
						$inf.='<tr>';
							$inf.='<th scope="row">'.$n.'</th>';
							$inf.='<td>'.$row['respuesta'].'</td>';
							$inf.='<td>'.$row['nombre'].'</td>';
							$inf.='<td>'.$row['correo'].'</td>';
							$inf.='<td>'.$row['telefono'].'</td>';
							$inf.='<td>'.$row['created_at'].'</td>';
							$inf.='<td>';
								$inf.='<button type="button" class="btn btn-outline-danger" data-toggle="modal" data-target="#dropSeg" onclick="dropSeg('."'".base64_encode($row[$this->tid2])."||'".');"><i class="fa fa-trash"></i></button>';
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
			//-----------------------------
			$fc_close($this->connect());
			return $inf;
		}
		function exportar(){
			$fc_query=$this->db_query;$fc_error=$this->db_error;$fc_array=$this->db_array;$fc_object=$this->db_object;$fc_assoc=$this->db_assoc;$fc_num_r=$this->db_num_r;$fc_fre_r=$this->db_fre_r;$fc_close=$this->db_close;
			//---------------------------------------------------------
			$inf=null;$n=1;$cant=10;
			//-------------------------------------
			$inf.='<thead>';
				$inf.='<tr>';
					$inf.='<th>#</th>';
					$inf.='<th>Nombre</th>';
					$inf.='<th>Correo</th>';
					$inf.='<th>Teléfono</th>';
					$inf.='<th>Mensaje</th>';
					$inf.='<th>Respuesta</th>';
					$inf.='<th>Creado</th>';
					$inf.='<th>Editado</th>';
					$inf.='<th>Eliminado</th>';
					$inf.='<th>Estado</th>';
				$inf.='</tr>';
			$inf.='</thead>';
			$inf.='<tbody>';
				$sql = "SELECT * FROM ".$this->table." ;";
				$res = $fc_query($c1,$sql) OR $_SESSION['Mysqli_Error'] = (mysqli_error($this->connect()));
				if ($res->result==true && $res->cant > 0) {
					while ($row = $fc_assoc($res->res)) {
						$inf.='<tr>';
							$inf.='<th>'.$n.'</th>';
							$inf.='<td>'.$row['nombre'].'</td>';
							$inf.='<td>'.$row['correo'].'</td>';
							$inf.='<td>'.$row['telefono'].'</td>';
							$inf.='<td>'.$row['mensaje'].'</td>';
							$inf.='<td>'.$row['respuesta'].'</td>';
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