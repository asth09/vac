<?php
	/**
	 * 
	 */
	class db
	{
		function conect01(){//mysqli
			$con1 = mysqli_connect("localhost","root","");
			mysqli_select_db($con1,"vac");
			return($con1);
		}
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
			$con1 = pg_connect("host=127.0.0.1 port=1234 dbname=vac user=admin password=admin");
			return($con1);
		}
		function get_sql(
			$this_table, //nombre de tabla
			$dt, //array con los datos. El nombre de las Key debe ser igual al nombre de los campos en la tabla
			$tipo=1, //Tipo de sentencia: 1 para INSERT / 2 para UPDATE / 3 para CALL
			$this_tid=null, //Nombre del campo Primary Key(PK) de la Tabla. Solo usar para UPDATE
			$json_pid=null, //valor del PK a editar. Solo usar para UPDATE
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
					$sql .= " );";
				break;
				case 3://GENERRAR SENTENCIA PARA LLAMAR PROCEDIMIENTOS ALMACENADOS
					$sql = "CALL ".$this_table." ( ";
					//-----------valores----------------
						foreach ($dt as $key => $value) {
							$sql .= "'".$value."', ";
						}
					//-----------fin-valores------------
					$sql = substr($sql, 0, -2);
					$sql .= " );";
				break;
				case 4://GENERRAR SENTENCIA PARA BUSCAR FILA EN DATA BASE
					$sql = "SELECT * FROM ".$table." WHERE ";
					//-----------campos-valores----------------
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
					//-----------fin-campos-valores------------
					$sql = substr($sql, 0, -5);
					$sql .= ";";
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
					//------------campos-adicionale------------
						if (!is_null($adic)) {
							$sql .= $adic." AND ";
						}
					//-----------fin-campos-adicionale---------
					$sql .= $this_tid."=".$json_pid.";";
				break;
			}
			//----------------------------------
			return $sql;
		}
	}