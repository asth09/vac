<?php
require_once($rut2.'config/constant.php');
//------------------------------------
$location = HTTP.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
//------------------------------------
/*if ($_SERVER['REQUEST_URI'] == DIRERR) {
}else if ($_SERVER['REQUEST_URI'] == DIR) {
}else{
	if (!isset($_SESSION['user_id'])) {
		$_SESSION['_dir_url'] = base64_encode($_SERVER['REQUEST_URI']);
		//-----------------------------------------------------------------------
		header("Location: ".LOGI);
		exit();
	}
}*/
//------------------------------------
$pid=0;
//------------------------------------
if (isset($_SESSION['sid'])) { $sid = $_SESSION['sid']; }else{ $sid = $_SESSION['sid'] = session_id(); }
if (isset($_REQUEST['p'])) { $pid = base64_decode($_REQUEST['p']); }