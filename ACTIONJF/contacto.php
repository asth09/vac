<?php
	$ru0='../';
	$cls = array(
		"dbs"	=>	"database",
		"cl0"	=>	"correo",
		"cl1"	=>	"contacto",
	);
	$di1=$cls['cl1'].'/';
	$di2=$di1.'detalle/?p=';
	$dt = array();$json = new stdClass();
	//------------------------------
	$_tbl = new stdClass();
	$_tbl->tname = $cls['cl1'];
	$_tbl->tid = 'id';
	$_tbl->pid = 0;
	//-------------------------------
	function index($rut,$url){
		global $cls;
		require_once($rut.DIRMOR.$cls['dbs'].'.php');
		require_once($rut.DIRMOR.$cls['cl1'].'.php');
		$_dbs = new $cls['dbs']();
		$_cl1 = new $cls['cl1']();
		$data = new stdClass();
		//-------------------------------
		$data->inf = $_cl1->listar($url);
		//-------------------------------
		return $data;
	}
	function detalle($rut,$pid){
		global $cls,$_tbl;
		require_once($rut.DIRMOR.$cls['dbs'].'.php');
		require_once($rut.DIRMOR.$cls['cl1'].'.php');
		$_dbs = new $cls['dbs']();
		$_cl1 = new $cls['cl1']();
		$data = new stdClass();
		//----------------------------------------
		$_tbl->pid = $pid;
		//-------------------------------
		$data->inf = $_dbs->db_get_id(NULL,$_tbl);
		$data->seg = $_cl1->listarSeg($pid);
		//-------------------------------
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
			require_once($ru0.DIRMOR.$cls['cl1'].'.php');
			$_dbs = new $cls['dbs']();
			$_cl1 = new $cls['cl1']();
			//----------------------------------------
			$_tbl->success = 'add';
			$_tbl->danger = 'no'.$_tbl->success;
			//----------------------------------------
			$nombre = filter_var($_POST['nombre'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
			$correo = filter_var($_POST['correo'], FILTER_SANITIZE_EMAIL);
			$telefono = filter_var($_POST['telefono'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
			$mensaje = str_replace("'", '´', $_POST['mensaje']);
			$ip_cli = filter_var(base64_decode($_POST['ip_cli']), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
			$nav_cli = filter_var(base64_decode($_POST['nav_cli']), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
			$sist_cli = filter_var(base64_decode($_POST['sist_cli']), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
			$utm_id = filter_var($_POST['utm_id'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
			$utm_campaign = filter_var($_POST['utm_campaign'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
			$utm_source = filter_var($_POST['utm_source'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
			$utm_medium = filter_var($_POST['utm_medium'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
			$utm_content = filter_var($_POST['utm_content'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
			$utm_term = filter_var($_POST['utm_term'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
			$fbclid = filter_var($_POST['fbclid'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
			$gclid = filter_var($_POST['gclid'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
			//----------------------------------------
			$add = array(
				"nombre"	=>	$nombre,
				"correo"	=>	$correo,
				"telefono"	=>	$telefono,
				"mensaje"	=>	$mensaje,
				"ip_cli"	=>	$ip_cli,
				"nav_cli"	=>	$nav_cli,
				"sist_cli"	=>	$sist_cli,
				"utm_id"	=>	$utm_id,
				"utm_campaign"	=>	$utm_campaign,
				"utm_source"	=>	$utm_source,
				"utm_medium"	=>	$utm_medium,
				"utm_content"	=>	$utm_content,
				"utm_term"	=>	$utm_term,
				"fbclid"	=>	$fbclid,
				"gclid"	=>	$gclid,
				"created_at"	=>	date('Y-m-d H:i:s')
			);
			//----------------------------------------
			$url = base64_decode($_POST['url']);
			//----------------------------------------
			$resp = $_dbs->db_add($add, $_tbl);
			if ($resp->result) {
				$html = null;
				//----------------------------------------
				$para = 'Informes - Frank Moreno <informes@frankmorenoalburqueque.com>';
				$asunto = 'Formulario de contacto VAC';
				//----------------------------------------
				$headers = 'From: '.$para."\r\n".'X-Mailer: PHP/'.phpversion();
				$headers .= 'Content-Type: text/html'."\r\n";
				$headers .= 'CharSet: utf-8'."\r\n";
				$headers .= 'X-Mailer: PHP/'.phpversion();
				//----------------------------------------
				$html .= '<div>';
					$html .= '<h3>Tienes un cliente interesado:</h3>';
				$html .= '</div>';
				$html .= '<div>';
					$html .= '<h4>Sus datos son:</h4>';
					$html .= '<ul>';
						$html .= '<li>Nombre: <b>'.$add['nombre'].'</b></li>';
						$html .= '<li>Correo: <b>'.$add['correo'].'</b></li>';
						$html .= '<li>Teléfono: <b>'.$add['telefono'].'</b></li>';
					$html .= '</ul>';
				$html .= '</div>';
				$html .= '<div>';
					$html .= '<h4>Su mensaje es:</h4>';
					$html .= '<p>'.$add['mensaje'].'</p>';
				$html .= '</div>';
				//----------------------------------------
				if (SCHU == '_qas') {
					//----------------------------------------
					$r_cor = mail($para, $asunto, $html, $headers);
					//----------------------------------------
					echo $_SESSION['mensjEmail'] = $r_cor;
				}else{
					//----------------------------------------
					require_once($ru0.DIRMOR.$cls['cl0'].'.php');
					$_cor = new $cls['cl0']();
					//----------------------------------------
					$json->asunto = $asunto;
					$json->cuerpo = $html;
					$json->fecha = $dt['created_at'];
					//----------------------------------------
					$r_cor = $_cor->sendMail($ru0, $json);
					//----------------------------------------
					echo $_SESSION['mensjEmail'] = $r_cor;
				}
			}
			$_SESSION['stat'] = $resp->inf;
			$_SESSION['sql'] = $resp->sql;
			//----------------------------------------
			$_POST = null;
			//----------------------------------------
			//header("Location: ".$url);
			//exit();
		}else{
			include_once($ru0.'403.shtml');
		}
	}
	if (isset($_POST['addSeg'])) {
		if(isset($_SESSION)){}else{ session_start(); }
		require_once($ru0.'config/constant.php');
		//----------------------------------------
		if (isset($_SESSION['sid'])) {
			require_once($ru0.DIRMOR.$cls['dbs'].'.php');
			require_once($ru0.DIRMOR.$cls['cl1'].'.php');
			$_dbs = new $cls['dbs']();
			$_cl1 = new $cls['cl1']();
			//----------------------------------------
			$_tbl->tname = 'seg_contacto';//seg_contacto
			$_tbl->success = 'add';
			$_tbl->danger = 'no'.$_tbl->success;
			//----------------------------------------
			$add = array(
				"id"	=>	base64_decode($_POST['pid']),
				"respuesta"	=>	str_replace("'", '´', $_POST['respuesta']),
				"created_at"	=>	date('Y-m-d H:i:s')
			);
			//----------------------------------------
			$url = base64_decode($_POST['url']);
			//----------------------------------------
			$resp = $_dbs->db_add($add, $_tbl);
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
	if (isset($_POST['dropSeg'])) {
		if(isset($_SESSION)){}else{ session_start(); }
		require_once($ru0.'config/constant.php');
		//----------------------------------------
		if (isset($_SESSION['sid'])) {
			require_once($ru0.DIRMOR.$cls['dbs'].'.php');
			$_dbs = new $cls['dbs']();
			//----------------------------------------
			$_tbl->tname = 'seg_contacto';//seg_contacto
			$_tbl->success = 'drop';
			$_tbl->danger = 'no'.$_tbl->success;
			$_tbl->pid = base64_decode($_POST['pid']);
			//----------------------------------------
			$drop = array(
				"id_drop"	=>	1,
				"drop_at"	=>	date('Y-m-d H:i:s'),
				"status"	=>	2
			);
			//----------------------------------------
			$url = base64_decode($_POST['url']);
			//----------------------------------------
			$resp = $_dbs->db_edit($drop,$_tbl);
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