<?php
	$ru0='../';
	$cls = array(
		"dbs"	=>	"db",
		"cl0"	=>	"correo",
		"cl1"	=>	"contacto",
	);
	$di1=$cls['cl1'].'/';
	$di2=$di1.'detalle/?p=';
	$dt = array();$json = new stdClass();
	//-------------------------------
	function index($rut){
		global $cls;
		require_once($rut.DIRMOR.$cls['dbs'].'.php');
		require_once($rut.DIRMOR.$cls['cl1'].'.php');
		$_dbs = new $cls['dbs']();
		$_cl1 = new $cls['cl1']();
		$data = new stdClass();
		//-------------------------------
		$data->inf = $_cl1->listar($_dbs->conect01());
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
		$data->inf = $_cl1->exportar($_dbs->conect01());
		//-------------------------------
		return $data;
	}
	function detalle($rut,$pid){
		global $cls;
		require_once($rut.DIRMOR.$cls['dbs'].'.php');
		require_once($rut.DIRMOR.$cls['cl1'].'.php');
		$_dbs = new $cls['dbs']();
		$_cl1 = new $cls['cl1']();
		$data = new stdClass();
		//-------------------------------
		$data->inf = $_cl1->callID($_dbs->conect01(),$pid);
		$data->seg = $_cl1->listarSeg($_dbs->conect01(),$pid);
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
			$json->table = 1;//contacto
			$json->success = 'add';
			$json->danger = 'noadd';
			//----------------------------------------
			$dt = array(
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
			$resp = $_cl1->add($_dbs->conect01(),$dt, $json);
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
						$html .= '<li>Nombre: <b>'.$dt['nombre'].'</b></li>';
						$html .= '<li>Correo: <b>'.$dt['correo'].'</b></li>';
						$html .= '<li>Teléfono: <b>'.$dt['telefono'].'</b></li>';
					$html .= '</ul>';
				$html .= '</div>';
				$html .= '<div>';
					$html .= '<h4>Su mensaje es:</h4>';
					$html .= '<p>'.$dt['mensaje'].'</p>';
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
			$json->table = 2;//seg_contacto
			$json->success = 'add';
			$json->danger = 'noadd';
			//----------------------------------------
			$dt = array(
				"id"	=>	base64_decode($_POST['pid']),
				"respuesta"	=>	str_replace("'", '´', $_POST['respuesta']),
				"created_at"	=>	date('Y-m-d H:i:s')
			);
			//----------------------------------------
			$url = base64_decode($_POST['url']);
			//----------------------------------------
			$resp = $_cl1->add($_dbs->conect01(), $dt, $json);
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
			require_once($ru0.DIRMOR.$cls['cl1'].'.php');
			$_dbs = new $cls['dbs']();
			$_cl1 = new $cls['cl1']();
			//----------------------------------------
			$json->table = 1;//contacto
			$json->pid = base64_decode($_REQUEST['p']);
			//----------------------------------------
			$dt = array(
				"status"	=>	(($_REQUEST['met'] == 'acti') ?  1 : 0),
				"updated_at"	=>	date('Y-m-d H:i:s')
			);
			//----------------------------------------
			$resp = $_cl1->estado($_dbs->conect01(),$dt,$json);
			$_SESSION['stat'] = $resp->inf;
			$_SESSION['sql'] = $resp->sql;
			//----------------------------------------
			$_REQUEST = null;
			//----------------------------------------
			header("Location: ".SIST.$di1);
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
			require_once($ru0.DIRMOR.$cls['cl1'].'.php');
			$_dbs = new $cls['dbs']();
			$_cl1 = new $cls['cl1']();
			//----------------------------------------
			$json->table = 1;//contacto
			$json->pid = base64_decode($_POST['pid']);
			//----------------------------------------
			$dt = array(
				"status"	=>	2,
				"drop_at"	=>	date('Y-m-d H:i:s')
			);
			//----------------------------------------
			$url = base64_decode($_POST['url']);
			//----------------------------------------
			$resp = $_cl1->estado($_dbs->conect01(),$dt,$json);
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
			require_once($ru0.DIRMOR.$cls['cl1'].'.php');
			$_dbs = new $cls['dbs']();
			$_cl1 = new $cls['cl1']();
			//----------------------------------------
			$json->table = 2;//seg_contacto
			$json->pid = base64_decode($_POST['pid']);
			//----------------------------------------
			$dt = array(
				"status"	=>	2,
				"drop_at"	=>	date('Y-m-d H:i:s')
			);
			//----------------------------------------
			$url = base64_decode($_POST['url']);
			//----------------------------------------
			$resp = $_cl1->estado($_dbs->conect01(),$dt,$json);
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