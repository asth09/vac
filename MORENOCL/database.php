<?php
	/**
	 * 
	 */
	class database
	{
		protected $db_type = 'mysqli_';
		//private $db_ytpe = 'pg_';
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
			public function connect(){//mysqli
				//---------------------------------------------------------
				$con1 = mysqli_connect("localhost","root","");
				mysqli_select_db($con1,"vac");
				//---------------------------------------------------------
				return($con1);
			}
		//---------------------------------------------------------
			public function db_exec($sql){
				$fc_query=$this->db_query;$fc_error=$this->db_error;$fc_array=$this->db_array;$fc_object=$this->db_object;$fc_assoc=$this->db_assoc;$fc_num_r=$this->db_num_r;$fc_fre_r=$this->db_fre_r;$fc_close=$this->db_close;
				//---------------------------------------------------------
				$data = new stdClass();
				$error = NULL;
				//---------------------------------------------------------
				$res = $fc_query($this->connect(), $sql) OR $error = $fc_error($this->connect());
				if ($res) {
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
					$data->result = false;
					$data->cant = -1;
					$data->res = $res;
				}
				//---------------------------------------------------------
				$data->error = $error;
				//---------------------------------------------------------
				return $data;
			}
		//---------------------------------------------------------
			function muestra_mysqli(){//muestra_mysqli
				$con1 = mysqli_connect("HOST","USUARIO","CONTRASEÑA");
				mysqli_select_db($con1,"BASE DE DATOS");
				return($con1);
			}
			function muestra_sql(){//muestra_sqlsrv
				$serverName = "serverName\sqlexpress"; //serverName\instanceName
				//$serverName = "serverName\sqlexpress, 1542"; //serverName\instanceName, portNumber (por defecto es 1433)
				//$connectionInfo = array( "Database"=>"dbName");
				$connectionInfo = array( "Database"=>"dbName", "UID"=>"userName", "PWD"=>"password");
				$con1 = sqlsrv_connect($serverName, $connectionInfo);
				return($con1);
			}
			function muestra_pg(){//muestra_pgsql
				$con1 = mysqli_connect("host=127.0.0.1 port=1234 dbname=vac user=admin password=admin");
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
			function sum_fecha($campo,$fecha){
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
					// Sumar un año
					$fecha_obj->add(new DateInterval('P1Y'));
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
			public function get_sql(
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
								switch ($key) {
									case 'created_at':
									case 'id_created':
									case 'updated_at':
									case 'id_updated':
									case 'drop_at':
									case 'id_drop':
									case 'motivo_drop':
									case 'status':
									break;
									default:
										$sql .= $key."='".$value."' AND ";
									break;
								}
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
						$sql = "SELECT * FROM ".$this_table." WHERE ";
						//------------campos-adicionale------------
							if (!is_null($adic)) {
								$sql .= $adic." AND ";
							}
						//-----------fin-campos-adicionale---------
						$sql .= $this_tid."=".$json_pid.";";
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