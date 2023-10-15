<?php
require_once($rut.'config/constant.php');
//------------------------------------
$_SESSION['location'] = $location = HTTPS.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
//------------------------------------
if ($_SERVER['REQUEST_URI'] == DIRERR) {
}else if ($_SERVER['REQUEST_URI'] == DIR) {
}else{
	/*
	if (!isset($_SESSION['user_id'])) {
		$_SESSION['_dir_url'] = base64_encode($_SERVER['REQUEST_URI']);
		//-----------------------------------------------------------------------
		header("Location: ".LOGI);
		exit();
	}
	*/
}
//------------------------------------
$pid=0;$nav=null;$sist=null;
$ip_cli = $_SERVER['REMOTE_ADDR'];
$bot=' <button type="button" class="close" data-dismiss="alert" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>';
//------------------------------------
if (isset($_REQUEST['sid'])) { $sid = $_SESSION['sid']; }else{ $sid = $_SESSION['sid'] = session_id(); }
if (isset($_REQUEST['p'])) { $pid = base64_decode($_REQUEST['p']); }
//------------------------------------
require_once($rut.'Seguridad.php');
$_seg = new Seguridad();
//------------------------------------
$nav_cli = $_seg->getBrowser($_SERVER['HTTP_USER_AGENT']);
$sist_cli = $_seg->getPlatform($_SERVER['HTTP_USER_AGENT']);
//------------------------------------
if(isset($_REQUEST['utm_id'])){
	$utm_id = $_SESSION['utm_id'] = $_REQUEST['utm_id'];
}else if(isset($_SESSION['utm_id'])){
	$utm_id = $_SESSION['utm_id'];
}else{
	$utm_id = null;
}
//------------------------------------
if(isset($_REQUEST['utm_campaign'])){
	$utm_campaign = $_SESSION['utm_campaign'] = $_REQUEST['utm_campaign'];
}else if(isset($_SESSION['utm_campaign'])){
	$utm_campaign = $_SESSION['utm_campaign'];
}else{
	$utm_campaign = null;
}
//------------------------------------
if(isset($_REQUEST['utm_source'])){
	$utm_source = $_SESSION['utm_source'] = $_REQUEST['utm_source'];
}else if(isset($_SESSION['utm_source'])){
	$utm_source = $_SESSION['utm_source'];
}else{
	$utm_source = 'google';
}
//------------------------------------
if(isset($_REQUEST['utm_medium'])){
	$utm_medium = $_SESSION['utm_medium'] = $_REQUEST['utm_medium'];
}else if(isset($_SESSION['utm_medium'])){
	$utm_medium = $_SESSION['utm_medium'];
}else{
	$utm_medium = 'Web';
}
//------------------------------------
if(isset($_REQUEST['utm_content'])){
	$utm_content = $_SESSION['utm_content'] = $_REQUEST['utm_content'];
}else if(isset($_SESSION['utm_content'])){
	$utm_content = $_SESSION['utm_content'];
}else{
	$utm_content = null;
}
//------------------------------------
if(isset($_REQUEST['utm_term'])){
	$utm_term = $_SESSION['utm_term'] = $_REQUEST['utm_term'];
}else if(isset($_SESSION['utm_term'])){
	$utm_term = $_SESSION['utm_term'];
}else{
	$utm_term = null;
}
//------------------------------------
if(isset($_REQUEST['fbclid'])){
	$fbclid = $_SESSION['fbclid'] = $_REQUEST['fbclid'];
}else if(isset($_SESSION['fbclid'])){
	$fbclid = $_SESSION['fbclid'];
}else{
	$fbclid = null;
}
//------------------------------------
if(isset($_REQUEST['gclid'])){
	$gclid = $_SESSION['gclid'] = $_REQUEST['gclid'];
}else if(isset($_SESSION['gclid'])){
	$gclid = $_SESSION['gclid'];
}else{
	$gclid = null;
}
//------------------------------------