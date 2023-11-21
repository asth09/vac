<?php
	/**
	 * 
	 */
	class database
	{
		//-----------------------------
		private $db_prd = 'localhost';//IP SERVER prd
		private $db_qas = 'localhost';//IP SERVER qas
		private $db_port = '5489';
		private $db_name = 'vac';
		private $db_user = 'root';
		private $db_pass = '';
		//---------------------------------------
		protected $db_type = 'mysqli_';
		//protected $db_type = 'pg_';
		protected $db_query = NULL;
		protected $db_error = NULL;
		protected $db_array = NULL;
		protected $db_object = NULL;
		protected $db_assoc = NULL;
		protected $db_num_r = NULL;
		protected $db_fre_r = NULL;
		protected $db_close = NULL;
		//---------------------------------------------------------
		public function __construct(){
			$this->db_query = $this->db_type.'query';
			if ($this->db_type == 'mysqli_') {
				$this->db_error = $this->db_type.'error';
			} else {
				$this->db_error = $this->db_type.'last_error';
			}
			$this->db_array = $this->db_type.'fetch_array';
			$this->db_object = $this->db_type.'fetch_object'; // Corrección aquí
			$this->db_assoc = $this->db_type.'fetch_assoc';
			if ($this->db_type == 'mysqli_') {
				$this->db_num_r = 'num_rows';
			}else{
				$this->db_num_r = $this->db_type.'num_rows';
			}
			$this->db_fre_r = $this->db_type.'free_result';
			$this->db_close = $this->db_type.'close';
		}
		//---------------------------------------------------------
			function connect($schu=null){
				if (!is_null($schu)) { $name = "db".strtolower($schu); }else{ $name = "db".((isset(SCHU)) ? strtolower(SCHU) : '_qas'); }
				$db_host = $this->$name;
				//----------------------------------
				if ($this->db_type == 'mysqli_') {
					$con = mysqli_connect($db_host, $this->db_user, $this->db_pass);
					mysqli_select_db($con, $this->db_name);
				}else{
					$con = pg_connect("host=".$db_host." port=".$this->db_port." dbname=".$this->db_name." user=".$this->db_user." password=".$this->db_pass);
				}
				//----------------------------------
				return($con);
			}
		//---------------------------------------------------------
			public function db_exec($sql,$ret_res=true){
				$fc_query=$this->db_query;$fc_error=$this->db_error;$fc_array=$this->db_array;$fc_object=$this->db_object;$fc_assoc=$this->db_assoc;$fc_num_r=$this->db_num_r;$fc_fre_r=$this->db_fre_r;$fc_close=$this->db_close;
				//---------------------------------------------------------
				$data = new stdClass();
				$error = NULL;
				//---------------------------------------------------------
				$res = $fc_query($this->connect(), $sql) OR $error = $fc_error($this->connect());
				if ($res) {
					if ($ret_res) {
						if ((($this->db_type == 'mysqli_') ? $res->$fc_num_r : $fc_num_r($res)) > 0) {
							$data->result = true;
							$data->cant = (($this->db_type == 'mysqli_') ? $res->$fc_num_r : $fc_num_r($res));
							$data->res = $res;
						}else{
							$data->result = false;
							$data->cant = 0;
							$data->res = $res;
						}
					}else{
						$data->result = true;
						$data->mensaje = "Ejecutado exitosamente";
					}
				}else{
					$data->result = false;
					$data->cant = -1;
					if ($ret_res) {
						$data->res = $res;
					}
				}
				//---------------------------------------------------------
				$data->error = $error;
				//---------------------------------------------------------
				return $data;
			}
			public function db_exec_sql($sql,$ret_res=true){
				$fc_query=$this->db_query;$fc_error=$this->db_error;$fc_array=$this->db_array;$fc_object=$this->db_object;$fc_assoc=$this->db_assoc;$fc_num_r=$this->db_num_r;$fc_fre_r=$this->db_fre_r;$fc_close=$this->db_close;
				//---------------------------------------------------------
				$data = new stdClass();
				$error = NULL;
				//---------------------------------------------------------
				$res = $fc_query($this->connect(), $sql) OR $error = $fc_error($this->connect());
				if ($res) {
					if ($ret_res) {
						if ((($this->db_type == 'mysqli_') ? $res->$fc_num_r : $fc_num_r($res)) > 0) {
							$data->result = true;
							$data->cant = (($this->db_type == 'mysqli_') ? $res->$fc_num_r : $fc_num_r($res));
							while ($row = $fc_assoc($res)) {
								foreach ($row as $key => $value) {
									$data->$key = $value;
								}
							}
						}else{
							$data->result = false;
							$data->cant = 0;
							$data->res = null;
						}
					}else{
						$data->result = true;
						$data->mensaje = "Ejecutado exitosamente";
					}
				}else{
					$data->result = false;
					$data->cant = -1;
					if ($ret_res) {
						$data->res = $res;
					}
				}
				//---------------------------------------------------------
				$data->error = $error;
				//---------------------------------------------------------
				return $data;
			}
		//---------------------------------------------------------
			function muestra_sql(){//muestra_sqlsrv
				$serverName = "serverName\sqlexpress"; //serverName\instanceName
				//$serverName = "serverName\sqlexpress, 1542"; //serverName\instanceName, portNumber (por defecto es 1433)
				//$connectionInfo = array( "Database"=>"dbName");
				$connectionInfo = array( "Database"=>"dbName", "UID"=>"userName", "PWD"=>"password");
				$con1 = sqlsrv_connect($serverName, $connectionInfo);
				return($con1);
			}
		//---------------------------------------------------------
			function cal_fecha($fecha){
				$inf = '<span class="btn btn-outline-{COLOR} btn-xs">'.$fecha.'</span>';
				//-----------------------------
				if (!is_null($fecha)) {
					//-----------------------------
					$hoy = date('Y-m-d');
					//-----------------------------
					$diferencia = strtotime($fecha) - strtotime($hoy);
					 // Convertir la diferencia a días
					$diferencia_dias = $diferencia / 86400;
					//-----------------------------
					if ($diferencia_dias > 60){
						$inf = str_replace('{COLOR}', 'success '.$diferencia_dias, $inf);
					}else if($diferencia_dias <= 60 && $diferencia_dias >= 30){
						$inf = str_replace('{COLOR}', 'warning '.$diferencia_dias, $inf);
						$inf = str_replace('</span>', ' ALERTA</span>', $inf);
					}else if($diferencia_dias < 30){
					//}else{
						$inf = str_replace('{COLOR}', 'danger '.$diferencia_dias, $inf);
						$inf = str_replace('</span>', ' URGENTE</span>', $inf);
					}else{
						$inf = str_replace('{COLOR}', 'info '.$diferencia_dias, $inf);
					}
				}else{
					$inf = str_replace('{COLOR}', 'info '.$diferencia_dias, $inf);
				}
				//-----------------------------
				return $inf;
			}
			function sum_fecha($campo,$fecha,$time){
				if ($campo == 1 && !is_null($fecha)) {
					// Verificar si la fecha tiene el formato DD/MM/YYYY
					$fecha_formato_dmy = DateTime::createFromFormat('d/m/Y', $fecha);
					//-----------------------------------
					if ($fecha_formato_dmy !== false) {
						// Si es formato DD/MM/YYYY, convertir a YYYY-MM-DD
						$nueva_fecha = $fecha_formato_dmy->format('Y-m-d');
					} else {
						// Si no es formato DD/MM/YYYY, asumimos que es YYYY-MM-DD
						$nueva_fecha = $fecha;
					}
					//-----------------------------------
					// Convertir a objeto DateTime
					$fecha_obj = DateTime::createFromFormat('Y-m-d', $nueva_fecha);
					//-----------------------------------
					$tiempo = 'P';
					if (isset($time->años) && $time->años==true) { $tiempo .= $time->cant_años.'Y'; }
					if (isset($time->meses) && $time->meses==true) { $tiempo .= $time->cant_meses.'M'; }
					if (isset($time->semanas) && $time->semanas==true) { $tiempo .= $time->cant_semanas.'W'; }
					if (isset($time->dias) && $time->dias==true) { $tiempo .= $time->cant_dias.'D'; }
					if (isset($time->tiempo) && $time->tiempo==true) { $tiempo .= 'T'; }
					if (isset($time->hor) && $time->hor==true) { $tiempo .= $time->cant_hor.'H'; }
					if (isset($time->min) && $time->min==true) { $tiempo .= $time->cant_min.'M'; }
					if (isset($time->seg) && $time->seg==true) { $tiempo .= $time->cant_seg.'S'; }
					//-----------------------------------
					// Sumar un año
					$fecha_obj->add(new DateInterval($tiempo));
					//-----------------------------------
					// Obtener la nueva fecha en formato 'Y-m-d'
					$nueva_fecha = $fecha_obj->format('Y-m-d');
				}else{
					$nueva_fecha = NULL;
				}
				//-----------------------------------
				return $nueva_fecha;
			}
			function form_fecha($fecha){
				// Verificar si la fecha tiene el formato DD/MM/YYYY
				$fecha_formato_dmy = DateTime::createFromFormat('d/m/Y', $fecha);
				//-----------------------------------
				if ($fecha_formato_dmy !== false) {
					// Si es formato DD/MM/YYYY, convertir a YYYY-MM-DD
					$nueva_fecha = $fecha_formato_dmy->format('Y-m-d');
				} else {
					// Si no es formato DD/MM/YYYY, asumimos que es YYYY-MM-DD
					$nueva_fecha = $fecha;
				}
				//-----------------------------------
				return $nueva_fecha;
			}
		//---------------------------------------------------------
			function db_get_string($dt,$json){
				$fc_query=$this->db_query;$fc_error=$this->db_error;$fc_array=$this->db_array;$fc_object=$this->db_object;$fc_assoc=$this->db_assoc;$fc_num_r=$this->db_num_r;$fc_fre_r=$this->db_fre_r;$fc_close=$this->db_close;
				//---------------------------------------------------------
				$data = new stdClass(); $sql = null;
				$data->error = null;
				//----------------------------
				$er=1;
				if(is_null($json->tname)){ $er=0; }
				if(is_null($json->tid)){ $er=0; }
				if(is_null($json->pid)){ $er=0; }
				if($json->pid <= 0){ $er=0; }
				//----------------------------
				if ($er == 1) {
					$sql = $this->get_sql($json->tname, $dt, 8, $json->tid, $json->pid);//8 select por VSLOR STRING
					$res = $fc_query($this->connect(),$sql) OR $data->error = ($fc_error($this->connect()));
					if ($res) {
						if ((($this->db_type == 'mysqli_') ? $res->$fc_num_r : $fc_num_r($res)) > 0) {
							$data->result = true;
							$data->mensaje = "Registro encontrado exitosamente.";
							//----------------------------
							while ($row = $fc_assoc($res)) {
								foreach ($row as $key => $value) {
									$data->$key = $value;
								}
							}
							//----------------------------
							$row = null;
						}else{
							$data->result = false;
							$data->mensaje = "La repuesta está vacía.";
						}
						//----------------------------
						$fc_fre_r($res);
					}else{
						$data->result = false;
						$data->mensaje = "No se encontró coincidencia, para el ID: ".$json->pid.".";
					}
				}else{
					$data->result = false;
					$data->mensaje = "No existe el nombre de la tabla.";
				}
				//------------------
				//$data->sql = $sql;
				//$data->input = $json;
				//------------------
				$fc_close($this->connect());
				return $data;
			}
			function db_get_id($dt,$json){
				$fc_query=$this->db_query;$fc_error=$this->db_error;$fc_array=$this->db_array;$fc_object=$this->db_object;$fc_assoc=$this->db_assoc;$fc_num_r=$this->db_num_r;$fc_fre_r=$this->db_fre_r;$fc_close=$this->db_close;
				//---------------------------------------------------------
				$data = new stdClass(); $sql = null;
				$data->error = null;
				//----------------------------
				$er=1;
				if(is_null($json->tname)){ $er=0; }
				if(is_null($json->tid)){ $er=0; }
				if(is_null($json->pid)){ $er=0; }
				if($json->pid <= 0){ $er=0; }
				//----------------------------
				if ($er == 1) {
					$sql = $this->get_sql($json->tname, $dt, 8, $json->tid, $json->pid);//8 select por ID
					$res = $fc_query($this->connect(),$sql) OR $data->error = ($fc_error($this->connect()));
					if ($res) {
						if ((($this->db_type == 'mysqli_') ? $res->$fc_num_r : $fc_num_r($res)) > 0) {
							$data->result = true;
							$data->mensaje = "Registro encontrado exitosamente.";
							//----------------------------
							while ($row = $fc_assoc($res)) {
								foreach ($row as $key => $value) {
									$data->$key = $value;
								}
							}
							//----------------------------
							$row = null;
						}else{
							$data->result = false;
							$data->mensaje = "La repuesta está vacía.";
						}
						//----------------------------
						$fc_fre_r($res);
					}else{
						$data->result = false;
						$data->mensaje = "No se encontró coincidencia, para el ID: ".$json->pid.".";
					}
				}else{
					$data->result = false;
					$data->mensaje = "No existe el nombre de la tabla.";
				}
				//------------------
				//$data->sql = $sql;
				//$data->input = $json;
				//------------------
				$fc_close($this->connect());
				return $data;
			}
			function db_get_camp_id_array($dt,$json){
				$fc_query=$this->db_query;$fc_error=$this->db_error;$fc_array=$this->db_array;$fc_object=$this->db_object;$fc_assoc=$this->db_assoc;$fc_num_r=$this->db_num_r;$fc_fre_r=$this->db_fre_r;$fc_close=$this->db_close;
				//---------------------------------------------------------
				$data = new stdClass(); $sql = null; $datos = array();
				$data->error = null;
				//----------------------------
				$er=1;
				if(is_null($json->tname)){ $er=0; }
				if(is_null($json->tid)){ $er=0; }
				if(is_null($json->pid)){ $er=0; }
				if($json->pid <= 0){ $er=0; }
				//----------------------------
				if ($er == 1) {
					$sql = $this->get_sql($json->tname, $dt, 11, $json->tid, $json->pid, null, $json->adic);//8 select por ID
					$res = $fc_query($this->connect(),$sql) OR $data->error = ($fc_error($this->connect()));
					if ($res) {
						if ((($this->db_type == 'mysqli_') ? $res->$fc_num_r : $fc_num_r($res)) > 0) {
							$data->result = true;
							$data->mensaje = "Registro encontrado exitosamente.";
							//----------------------------
							while ($row = $fc_assoc($res)) {
								$datos[] = $row;
							}
							//----------------------------
							$row = null;
						}else{
							$data->result = false;
							$data->mensaje = "La repuesta está vacía.";
						}
						//----------------------------
						$fc_fre_r($res);
					}else{
						$data->result = false;
						$data->mensaje = "No se encontró coincidencia, para el ID: ".$json->pid.".";
					}
				}else{
					$data->result = false;
					$data->mensaje = "No existe el nombre de la tabla.";
				}
				//------------------
				$data->datos = $datos;
				//$data->sql = $sql;
				//$data->input = $json;
				//------------------
				$fc_close($this->connect());
				return $data;
			}
			function db_get_all($dt,$json){
				$fc_query=$this->db_query;$fc_error=$this->db_error;$fc_array=$this->db_array;$fc_object=$this->db_object;$fc_assoc=$this->db_assoc;$fc_num_r=$this->db_num_r;$fc_fre_r=$this->db_fre_r;$fc_close=$this->db_close;
				//---------------------------------------------------------
				$data = new stdClass(); $sql = null; $fila = array(); $inf = array();
				$data->error = null;$n=0;
				//----------------------------
				$er=1;
				if(is_null($json->tname)){ $er=0; }
				if(is_null($json->tid)){ $er=0; }
				if(is_null($json->pid)){ $er=0; }
				//----------------------------
				if ($er == 1) {
					$sql = $this->get_sql($json->tname, $dt, $json->type, $json->tid, $json->pid);//5 select por ID
					$res = $fc_query($this->connect(),$sql) OR $data->error = ($fc_error($this->connect()));
					if ($res) {
						if ((($this->db_type == 'mysqli_') ? $res->$fc_num_r : $fc_num_r($res)) > 0) {
							$data->result = true;
							$data->mensaje = "Registros encontrados exitosamente.";
							//----------------------------
							while ($row = $fc_assoc($res)) {
								$fila = array(
									"id"	=>	$row[$json->tid],
									//"name"	=>	mb_convert_encoding($row[$json->col_name], $this->codificacion_objetivo, $this->codificacion_original),
									//"name"	=>	htmlentities($row[$json->col_name], ENT_QUOTES, 'UTF-8'),
									"name"	=>	mb_convert_encoding($row[$json->col_name], $this->codificacion_original, $this->codificacion_objetivo),
								);
								//----------------------------
								array_push($inf, $fila);
								//----------------------------
								$n++;
							}
							//----------------------------
							$row = null;
						}else{
							$data->result = false;
							$data->mensaje = "La repuesta está vacía.";
						}
						//----------------------------
						$fc_fre_r($res);
					}else{
						$data->result = false;
						$data->mensaje = "No se encontró coincidencia, para el ID: ".$json->pid.".";
					}
				}else{
					$data->result = false;
					$data->mensaje = "No existe el nombre de la tabla.";
				}
				//------------------
				$data->rows = count($inf);
				$data->inf = $inf;
				//$data->sql = $sql;
				//$data->input = $json;
				//error_log("Result: ".$n);
				//------------------
				$fc_close($this->connect());
				//------------------
				return $data;
			}
		//---------------------------------------------------------
			function db_add($dt,$json){
				$fc_query=$this->db_query;$fc_error=$this->db_error;$fc_array=$this->db_array;$fc_object=$this->db_object;$fc_assoc=$this->db_assoc;$fc_num_r=$this->db_num_r;$fc_fre_r=$this->db_fre_r;$fc_close=$this->db_close;
				//---------------------------------------------------------
				$data = new stdClass(); $sql = null;
				$data->error = null;
				//----------------------------
				$er=1;
				if(is_null($json->tname)){ $er=0; }
				//----------------------------
				if ($er == 1) {
					$sql = $this->get_sql($json->tname, $dt, 1);
					try {
						$res = $fc_query($this->connect(),$sql) OR $data->error .= ($fc_error($this->connect()));
						if ($res) {
							$data->result = true;
							$data->inf = $json->success;
							$data->mensaje = "Registro agregado exitosamente.";
						}else{
							$data->result = false;
							$data->inf = $json->danger;
							$data->mensaje = "No se logró agregar los datos.";
						}
					} catch (Exception $e) {
						$data->result = false;
						$data->inf = $json->danger;
						$data->mensaje = "No se logró agregar, Ya existe un valor igual.";
					}
				}else{
					$data->result = false;
					$data->inf = 'null';
					$data->mensaje = "No existe el nombre de la tabla.";
				}
				//------------------
				$data->sql = $sql;
				//------------------
				$fc_close($this->connect());
				return $data;
			}
			function db_add_all($dt,$json){
				$fc_query=$this->db_query;$fc_error=$this->db_error;$fc_array=$this->db_array;$fc_object=$this->db_object;$fc_assoc=$this->db_assoc;$fc_num_r=$this->db_num_r;$fc_fre_r=$this->db_fre_r;$fc_close=$this->db_close;
				//---------------------------------------------------------
				$data = new stdClass(); $sql = null; $result = array(); $fila_res = array();
				$data->error = null;
				//----------------------------
				$er=1;$n=0;
				if(is_null($json->tname)){ $er=0; }
				//----------------------------
				if ($er == 1) {
					foreach ($dt as $fila) {
						$fila_res = array();
						//-----------------------------
						if (!is_null($fila[$json->t_camp])) {
							$sql = $this->get_sql($json->tname, $fila, 1);
							try {
								$res = $fc_query($this->connect(),$sql) OR $data->error .= ($fc_error($this->connect()));
								if ($res) {
									$fila_res = array(
										"result"	=>	true,
										"inf"	=>	$json->success,
										"mensaje"	=>	"Registro agregado exitosamente.",
									);
									//-----------------------------
									array_push($result, $fila_res);
								}else{
									$fila_res = array(
										"result"	=>	false,
										"inf"	=>	$json->danger,
										"mensaje"	=>	"No se logró agregar los datos.",
									);
									//-----------------------------
									array_push($result, $fila_res);
								}
							} catch (Exception $e) {
								$fila_res = array(
									"result"	=>	false,
									"inf"	=>	$json->danger,
									"mensaje"	=>	"No se logró agregar, Ya existe un valor igual.",
								);
								//-----------------------------
								array_push($result, $fila_res);
							}
						}else{
							$fila_res = array(
								"result"	=>	false,
								"inf"	=>	$json->danger,
								"mensaje"	=>	"El primer campo está vacío, por ello no se agregó la fila: ".$n,
							);
							//-----------------------------
							array_push($result, $fila_res);
						}
						//----------------------------
						$n++;
					}
				}else{
					$fila_res = array(
						"result"	=>	false,
						"inf"	=>	'null',
						"mensaje"	=>	"No existe el nombre de la tabla.",
					);
					//-----------------------------
					array_push($result, $fila_res);
				}
				//------------------
				//$data->sql = $sql;
				$data->res = (($n > 1000) ? $result[0] : $result);
				$data->rows = $n;
				//------------------
				$fc_close($this->connect());
				return $data;
			}
			function db_add_ret($dt,$json){
				$fc_query=$this->db_query;$fc_error=$this->db_error;$fc_array=$this->db_array;$fc_object=$this->db_object;$fc_assoc=$this->db_assoc;$fc_num_r=$this->db_num_r;$fc_fre_r=$this->db_fre_r;$fc_close=$this->db_close;
				//---------------------------------------------------------
				$data = new stdClass(); $sql = null;
				$data->error = null;
				$data->pid = 0;
				//----------------------------
				$er=1;
				if(is_null($json->tname)){ $er=0; }
				//----------------------------
				if ($er == 1) {
					$sql = $this->get_sql($json->tname, $dt, 1, $json->tid, $json->pid, true);
					try {
						$res = $fc_query($this->connect(),$sql) OR $data->error .= ($fc_error($this->connect()));
						if ($res) {
							if ((($this->db_type == 'mysqli_') ? $res->$fc_num_r : $fc_num_r($res)) > 0) {
								$data->result = true;
								$data->inf = $json->success;
								//----------------------------
								while ($row = $fc_assoc($res)) {
									$data->pid = $row[$json->tid];
								}
								//----------------------------
								$data->mensaje = "Registro agregado exitosamente.";
							}else{
								$data->result = false;
								$data->inf = $json->success;
								$data->mensaje = "Registro agregado, pero no se retorna ID.";
							}
						}else{
							$data->result = false;
							$data->inf = $json->danger;
							$data->mensaje = "No se logró agregar los datos.";
						}
					} catch (Exception $e) {
						$data->result = false;
						$data->inf = $json->danger;
						$data->mensaje = "No se logró agregar, Ya existe un valor igual.";
					}
				}else{
					$data->result = false;
					$data->inf = 'null';
					$data->mensaje = "No existe el nombre de la tabla.";
				}
				//------------------
				//$data->sql = $sql;
				//------------------
				$fc_close($this->connect());
				return $data;
			}
			function db_edit($dt,$json){
				$fc_query=$this->db_query;$fc_error=$this->db_error;$fc_array=$this->db_array;$fc_object=$this->db_object;$fc_assoc=$this->db_assoc;$fc_num_r=$this->db_num_r;$fc_fre_r=$this->db_fre_r;$fc_close=$this->db_close;
				//---------------------------------------------------------
				$data = new stdClass(); $sql = null;
				$data->error = null;
				//----------------------------
				switch ($json->success) {
					case "edit":
						$success = "modificado";
						$danger = "modificar";
					break;
					case "drop":
						$success = "eliminado";
						$danger = "eliminar";
					break;
					case "active":
						$success = "activado";
						$danger = "activar";
					break;
					case "desactive":
						$success = "desactivado";
						$danger = "desactivar";
					break;
					case "lock":
						$success = "bloquear";
						$danger = "bloquear";
					break;
					case "unlock":
						$success = "desbloquear";
						$danger = "desbloqueado";
					break;
					default:
						$success = "agregado";
						$danger = "agregar";
					break;
				}
				//----------------------------
				$er=1;
				if(is_null($json->tname)){ $er=0; }
				//----------------------------
				if ($er == 1) {
					$sql = $this->get_sql($json->tname, $dt, 2, $json->tid, $json->pid);
					try {
						$res = $fc_query($this->connect(),$sql) OR $data->error .= ($fc_error($this->connect()));
						if ($res) {
							$data->result = true;
							$data->inf = $json->success;
							$data->mensaje = "Registro ".$success." exitosamente.";
						}else{
							$data->result = false;
							$data->inf = $json->danger;
							$data->mensaje = "No se logró ".$danger." el registro.";
						}
					} catch (Exception $e) {
						$data->result = false;
						$data->inf = $json->danger;
						$data->mensaje = "No se logró agregar, Ya existe un valor igual.";
					}
				}else{
					$data->result = false;
					$data->inf = 'null';
					$data->mensaje = "No existe el nombre de la tabla.";
				}
				//------------------
				$data->sql = $sql;
				//------------------
				$fc_close($this->connect());
				return $data;
			}
			function db_edit_string($dt,$json){
				$fc_query=$this->db_query;$fc_error=$this->db_error;$fc_array=$this->db_array;$fc_object=$this->db_object;$fc_assoc=$this->db_assoc;$fc_num_r=$this->db_num_r;$fc_fre_r=$this->db_fre_r;$fc_close=$this->db_close;
				//---------------------------------------------------------
				$data = new stdClass(); $sql = null;
				$data->error = null;
				//----------------------------
				switch ($json->success) {
					case "edit":
						$success = "modificado";
						$danger = "modificar";
					break;
					case "drop":
						$success = "eliminado";
						$danger = "eliminar";
					break;
					case "active":
						$success = "activado";
						$danger = "activar";
					break;
					case "desactive":
						$success = "desactivado";
						$danger = "desactivar";
					break;
					case "lock":
						$success = "bloquear";
						$danger = "bloquear";
					break;
					case "unlock":
						$success = "desbloquear";
						$danger = "desbloqueado";
					break;
					default:
						$success = "agregado";
						$danger = "agregar";
					break;
				}
				//----------------------------
				$er=1;
				if(is_null($json->tname)){ $er=0; }
				//----------------------------
				if ($er == 1) {
					$sql = $this->get_sql($json->tname, $dt, 7, $json->tid, $json->pid);
					try {
						$res = $fc_query($this->connect(),$sql) OR $data->error .= ($fc_error($this->connect()));
						if ($res) {
							$data->result = true;
							$data->inf = $json->success;
							$data->mensaje = "Registro ".$success." exitosamente.";
						}else{
							$data->result = false;
							$data->inf = $json->danger;
							$data->mensaje = "No se logró ".$danger." el registro.";
						}
					} catch (Exception $e) {
						$data->result = false;
						$data->inf = $json->danger;
						$data->mensaje = "No se logró ".$danger.".";
					}
				}else{
					$data->result = false;
					$data->inf = 'null';
					$data->mensaje = "No existe el nombre de la tabla.";
				}
				//------------------
				//$data->sql = $sql;
				//------------------
				$fc_close($this->connect());
				return $data;
			}
		//---------------------------------------------------------
			function get_datos($pid,$type){
				$data = new stdClass();
				//---------------------------------------------------------
				switch ($type) {
					case 'user':
						$sql = "SELECT * FROM usuarios WHERE id_usuario=".$pid." LIMIT 1 ;";
					break;
					case 'placa':
						$sql = "SELECT * FROM unidades WHERE placa LIKE '".$pid."' LIMIT 1 ;";
					break;
					case 'clie':
						$sql = "SELECT * FROM clientes WHERE id_int LIKE '".$pid."' LIMIT 1 ;";
					break;
					default:
						$sql = null;
					break;
				}
				//---------------------------------------------------------
				if (!is_null($sql)) {
					$data = $this->db_exec_sql($sql);
				}
				//---------------------------------------------------------
				return $data;
			}
		//---------------------------------------------------------
			function get_sql(
				$this_table, //nombre de tabla
				$dt, //array con los datos. El nombre de las Key debe ser igual al nombre de los campos en la tabla
				$tipo=1, //Tipo de sentencia: 1 para INSERT / 2 para UPDATE / 3 para CALL
				$this_tid=null, //Nombre del campo Primary Key(PK) de la Tabla. Solo usar para UPDATE
				$json_pid=null, //valor del PK a editar. Solo usar para UPDATE
				$return=false, //este campo indica si se retorna o no el ID el insert
				$adic=null //campos adicionales en sentencia WHERE del UPDATE
			){
				switch ($tipo) {
					case 1://GENERAR SENTENCIA INSERT
						$sql = "INSERT INTO ".$this_table." ( ";
						//-----------campos----------------
							foreach ($dt as $key => $value) {
								$sql .= $key.", ";
							}
						//-----------fin-campos------------
						$sql = substr($sql, 0, -2).") VALUES (";
						//-----------valores----------------
							foreach ($dt as $key => $value) {
								$sql .= "'".$value."', ";
							}
						//-----------fin-valores------------
						$sql = substr($sql, 0, -2);
						$sql .= " )";
						//-----------return-ult-id----------
						if ($return) {
							$sql .= " RETURNING ".$this_tid;
						}
						$sql .= " ;";
					break;
					case 3://GENERRAR SENTENCIA PARA LLAMAR PROCEDIMIENTOS ALMACENADOS
						$sql = "SELECT ".$this_table." ( ";
						//-----------valores----------------
							foreach ($dt as $key => $value) {
								$sql .= "'".$value."', ";
							}
						//-----------fin-valores------------
						$sql = substr($sql, 0, -2);
						$sql .= " );";
					break;
					case 4://GENERRAR SENTENCIA PARA BUSCAR EN TABLA CON CAMPOS DADOS
						$sql = "SELECT * FROM ".$this_table." WHERE ";
						//-----------valores----------------
							foreach ($dt as $key => $value) {
								$sql .= $key."='".$value."', ";
							}
						//-----------fin-valores------------
						$sql = substr($sql, 0, -2);
						$sql .= " ;";
					break;
					case 5://GENERAR SENTENCIA UPDATE USANDO WHERE CON KEY_ID DISTINTO INT
						$sql = "UPDATE ".$this_table." SET ";
						//-----------campos-valores----------------
							foreach ($dt as $key => $value) {
								$sql .= $key."='".$value."', ";
							}
						//-----------fin-campos-valores------------
						$sql = substr($sql, 0, -2);
						$sql .= " WHERE ";
						//------------campos-adicionale------------
							if (!is_null($adic)) {
								$sql .= $adic." AND ";
							}
						//-----------fin-campos-adicionale---------
						$sql .= $this_tid."=".$json_pid.";";
					break;
					case 6://GENERRAR SENTENCIA PARA LISTAR TODO
						$sql = "SELECT * FROM ".$this_table." ;";
					break;
					case 7://GENERAR SENTENCIA UPDATE DONDE ID/CAMPO - VALOR (STRING)
						$sql = "UPDATE ".$this_table." SET ";
						//-----------campos-valores----------------
							foreach ($dt as $key => $value) {
								$sql .= $key."='".$value."', ";
							}
						//-----------fin-campos-valores------------
						$sql = substr($sql, 0, -2);
						$sql .= " WHERE ";
						//------------campos-adicionale------------
							if (!is_null($adic)) {
								$sql .= $adic." AND ";
							}
						//-----------fin-campos-adicionale---------
						$sql .= $this_tid." LIKE '".$json_pid."' ;";
					break;
					case 8://GENERRAR SENTENCIA PARA SELECT EN TABLA POR ID/CAMPO - VALOR (INT)
						$sql = "SELECT t1.*, c.nombre_u AS user_add, c.correo_u AS mail_add, e.nombre_u AS user_edit, e.correo_u AS mail_edit FROM ".$this_table." t1 ";
							$sql .= " LEFT JOIN usuarios c ON t1.id_created=c.id_usuario ";
							$sql .= " LEFT JOIN usuarios e ON t1.id_updated=e.id_usuario ";
						$sql .= " WHERE ";
						//------------campos-adicionale------------
							if (!is_null($adic)) {
								$sql .= "t1.".$adic." AND ";
							}
						//-----------fin-campos-adicionale---------
						$sql .= "t1.".$this_tid."=".$json_pid.";";
					break;
					case 9://GENERRAR SENTENCIA PARA SELECT EN TABLA POR ID/CAMPO - VALOR (STRING)
						$sql = "SELECT * FROM ".$this_table." WHERE ";
						//------------campos-adicionale------------
							if (!is_null($adic)) {
								$sql .= $adic." AND ";
							}
						//-----------fin-campos-adicionale---------
						$sql .= $this_tid." LIKE '".$json_pid."';";
					break;
					case 10://GENERRAR SENTENCIA PARA BUSCAR EN TABLA LOS CAMPOS DADOS
						$sql = "SELECT ";
						//-----------valores----------------
							foreach ($dt as $value) {
								$sql .= $value.", ";
							}
						//-----------fin-valores------------
						$sql = substr($sql, 0, -2);
						$sql .= " FROM ".$this_table." WHERE ";
						$sql .= $this_tid." LIKE '".$json_pid."' ;";
					break;
					case 11://GENERRAR SENTENCIA PARA SELECT EN TABLA PARA LLAMAR CAMPOS ESPECÍFICOS POR ID/CAMPO - VALOR (INT)
						$sql = "SELECT ";
						//------------campos-adicionale------------
							if (!is_null($dt)) {
								foreach ($dt as $value) {
									$sql .= $value.", ";
								}
							}else{
								$sql .= " * ";
							}
						//-----------fin-campos-adicionale---------
						$sql = substr($sql, 0, -2);
						$sql .= " FROM ".$this_table." WHERE ";
						//------------campos-adicionale------------
							if (!is_null($adic)) {
								$sql .= $adic." AND ";
							}
						//-----------fin-campos-adicionale---------
						$sql .= $this_tid."=".$json_pid.";";
					break;
					default://GENERAR SENTENCIA UPDATE
						$sql = "UPDATE ".$this_table." SET ";
						//-----------campos-valores----------------
							foreach ($dt as $key => $value) {
								$sql .= $key."='".$value."', ";
							}
						//-----------fin-campos-valores------------
						$sql = substr($sql, 0, -2);
						$sql .= " WHERE ";
						$sql .= $this_tid."=".$json_pid." ";
						//------------campos-adicionale------------
							if (!is_null($adic)) {
								$sql .= $adic." ";
							}
						//-----------fin-campos-adicionale---------
						$sql .= " ;";
					break;
				}
				//----------------------------------
				return $sql;
			}
		//---------------------------------------------------------
	}