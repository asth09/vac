<?php
	$ru0='../';
	$cls = array(
		"dbs"	=>	"database",
		"cl1"	=>	"cursos",
	);
	$di1=$cls['cl1'].'/';
	$di2=$di1.'detalle/?p=';
	$destino= $ru0."img/cursos/";
	$dt = array();
	//------------------------------
	$_tbl = new stdClass();
	$_tbl->tname = $cls['cl1'];
	$_tbl->tid = 'id';
	$_tbl->pid = 0;
	//------------------------------
	function index($rut,$url){
		global $cls;
		require_once($rut.DIRMOR.$cls['dbs'].'.php');
		require_once($rut.DIRMOR.$cls['cl1'].'.php');
		$_dbs = new $cls['dbs']();
		$_cl1 = new $cls['cl1']();
		$data = new stdClass();
		//----------------------------------------
		$data->inf = $_cl1->listar($url);
		//----------------------------------------
		return $data;
	}
	function detalle($rut,$pid){
		global $cls, $_tbl;
		require_once($rut.DIRMOR.$cls['dbs'].'.php');
		require_once($rut.DIRMOR.$cls['cl1'].'.php');
		$_dbs = new $cls['dbs']();
		$_cl1 = new $cls['cl1']();
		$data = new stdClass();
		//----------------------------------------
		$_tbl->pid = $pid;
		//----------------------------------------
		$data->inf = $_dbs->db_get_id(NULL, $_tbl);
		//----------------------------------------
		return $data;
	}
	function exportar($rut){
		global $cls;
		require_once($rut.DIRMOR.$cls['dbs'].'.php');
		require_once($rut.DIRMOR.$cls['cl1'].'.php');
		$_dbs = new $cls['dbs']();
		$_cl1 = new $cls['cl1']();
		$data = new stdClass();
		//-------------------------------
		$data->inf = $_cl1->exportar();
		//-------------------------------
		return $data;
	}
	if (isset($_POST['guardar'])) {
		if(isset($_SESSION)){}else{ session_start(); }
		require_once($ru0.'config/constant.php');
		//----------------------------------------
		if (isset($_SESSION['sid'])) {
			require_once($ru0.DIRMOR.$cls['dbs'].'.php');
			$_dbs = new $cls['dbs']();
			//----------------------------------------
			$_tbl->success = 'add';
			$_tbl->danger = 'no'.$_tbl->success;
			//----------------------------------------
			$nombre = filter_var($_POST['nombre'], FILTER_SANITIZE_STRING);
			$descrip = str_replace("'", '´', $_POST['descrip']);
			//----------------------------------------
			if (is_uploaded_file($_FILES["imagen"]["tmp_name"])) {
				$nombfile=$_FILES["imagen"]["name"];
				$taman=$_FILES["imagen"]["size"];
				$type=$_FILES["imagen"]["type"];
				$imagen=date("YmdHis").str_replace(' ', '_', $nombfile);
				$sub_file = true;
			}else{
				$imagen='user.png';
				$sub_file = false;
			}
			//----------------------------------------
			$add = array(
				"nombre"	=>	$nombre,
				"descrip"	=>	$descrip,
				"imagen"	=>	$imagen,
				"created_at"	=>	date('Y-m-d H:i:s')
			);
			//----------------------------------------
			$url = base64_decode($_POST['url']);
			//----------------------------------------
			$resp = $_dbs->db_add($add,$_tbl);
			if ($resp->result) {
				if ($sub_file) {
					move_uploaded_file($_FILES["imagen"]["tmp_name"], $destino.$imagen);
				}
			}
			$_SESSION['stat'] = $resp->inf;
			$_SESSION['sql'] = $resp->sql;
			//----------------------------------------
			$_POST = null;
			//----------------------------------------
			header("Location: ".$url);
			exit();
		}else{
			include_once($ru0.'403.shtml');
		}
	}
	if (isset($_POST['editar'])) {
		if(isset($_SESSION)){}else{ session_start(); }
		require_once($ru0.'config/constant.php');
		//----------------------------------------
		if (isset($_SESSION['sid'])) {
			require_once($ru0.DIRMOR.$cls['dbs'].'.php');
			$_dbs = new $cls['dbs']();
			//----------------------------------------
			$_tbl->pid = base64_decode($_POST['pid']);
			$_tbl->success = 'edit';
			$_tbl->danger = 'no'.$_tbl->success;
			//----------------------------------------
			$nombre = filter_var($_POST['nombre'], FILTER_SANITIZE_STRING);
			$descrip = str_replace("'", '´', $_POST['descrip']);
			//----------------------------------------
			if (is_uploaded_file($_FILES["imagen"]["tmp_name"])) {
				$nombfile=$_FILES["imagen"]["name"];
				$taman=$_FILES["imagen"]["size"];
				$type=$_FILES["imagen"]["type"];
				$imagen=date("YmdHis").str_replace(' ', '_', $nombfile);
				$sub_file = true;
			}else{
				$imagen=$_POST['imagen_ant'];
				$sub_file = false;
			}
			//----------------------------------------
			$edit = array(
				"nombre"	=>	$nombre,
				"descrip"	=>	$descrip,
				"imagen"	=>	$imagen,
				"id_updated"	=>	1,
				"updated_at"	=>	date('Y-m-d H:i:s')
			);
			//----------------------------------------
			$url = base64_decode($_POST['url']);
			//----------------------------------------
			$resp = $_dbs->db_edit($edit,$_tbl);
			if ($resp->result) {
				if ($sub_file) {
					move_uploaded_file($_FILES["imagen"]["tmp_name"], $destino.$imagen);
				}
			}
			$_SESSION['stat'] = $resp->inf;
			$_SESSION['sql'] = $resp->sql;
			//----------------------------------------
			$_POST = null;
			//----------------------------------------
			header("Location: ".$url);
			exit();
		}else{
			include_once($ru0.'403.shtml');
		}
	}
	if (isset($_REQUEST['met'])) {
		if(isset($_SESSION)){}else{ session_start(); }
		require_once($ru0.'config/constant.php');
		//----------------------------------------
		if (isset($_SESSION['sid'])) {
			require_once($ru0.DIRMOR.$cls['dbs'].'.php');
			$_dbs = new $cls['dbs']();
			//----------------------------------------
			$_tbl->success = (($_REQUEST['met'] == 'acti') ?  'active' : 'desactive');
			$_tbl->danger = 'no'.$_tbl->success;
			$_tbl->pid = base64_decode($_REQUEST['pid']);
			//----------------------------------------
			$dt = array(
				"id_updated"	=>	1,
				"updated_at"	=>	date('Y-m-d H:i:s'),
				"status"	=>	(($_REQUEST['met'] == 'acti') ?  1 : 0)
			);
			//----------------------------------------
			$url = base64_decode($_REQUEST['url']);
			//----------------------------------------
			$resp = $_dbs->db_edit($dt,$_tbl);
			$_SESSION['stat'] = $resp->inf;
			$_SESSION['sql'] = $resp->sql;
			//----------------------------------------
			$_REQUEST = null;
			//----------------------------------------
			header("Location: ".$url);
			exit();
		}else{
			include_once($ru0.'403.shtml');
		}
	}
	if (isset($_POST['eliminar'])) {
		if(isset($_SESSION)){}else{ session_start(); }
		require_once($ru0.'config/constant.php');
		//----------------------------------------
		if (isset($_SESSION['sid'])) {
			require_once($ru0.DIRMOR.$cls['dbs'].'.php');
			$_dbs = new $cls['dbs']();
			//----------------------------------------
			$_tbl->success = 'drop';
			$_tbl->danger = 'no'.$_tbl->success;
			$_tbl->pid = base64_decode($_POST['pid']);
			//----------------------------------------
			$dt = array(
				"id_drop"	=>	1,
				"drop_at"	=>	date('Y-m-d H:i:s'),
				"status"	=>	2
			);
			//----------------------------------------
			$url = base64_decode($_POST['url']);
			//----------------------------------------
			$resp = $_dbs->db_edit($dt,$_tbl);
			$_SESSION['stat'] = $resp->inf;
			$_SESSION['sql'] = $resp->sql;
			//----------------------------------------
			$_POST = null;
			//----------------------------------------
			header("Location: ".$url);
			exit();
		}else{
			include_once($ru0.'403.shtml');
		}
	}