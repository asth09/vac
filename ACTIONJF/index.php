<?php
	$ru0='./';
	$cls = array(
		"dbs"	=>	"database",
		"cl1"	=>	"cursos",
	);
	$dir1='./';
	$dir2='./detalle.php?p=';
	//------------------------------
	$_json = new stdClass();
	$_json->tname = $cls['cl1'];
	$_json->tid = 'id';
	$_json->pid = 0;
	//-----------------------------
	function index($rut){
		global $cls;
		require_once($rut.DIRMOR.$cls['dbs'].'.php');
		require_once($rut.DIRMOR.$cls['cl1'].'.php');
		$_dbs = new $cls['dbs']();
		$_cl1 = new $cls['cl1']();
		$data = new stdClass();
		//----------------------------------------
		$data->inf = $_cl1->cliente();
		//----------------------------------------
		return $data;
	}
	function detalle($rut,$pid){
		global $cls, $_json;
		require_once($rut.DIRMOR.$cls['dbs'].'.php');
		require_once($rut.DIRMOR.$cls['cl1'].'.php');
		$_dbs = new $cls['dbs']();
		$_cl1 = new $cls['cl1']();
		$data = new stdClass();
		//----------------------------------------
		$_json->pid = $pid;
		//----------------------------------------
		$data->inf = $_dbs->db_get_id(NULL, $_json);
		//----------------------------------------
		return $data;
	}