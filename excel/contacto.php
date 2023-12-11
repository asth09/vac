<?php
	if(isset($_SESSION)){}else{ session_start(); }
	$rut='../';
	$pagina='Contacto';
	$direc='contacto.php';
	require($rut.'config/constant.php');
	$inf=null;
	//-------------------------------------------
	if (isset($_SESSION['sid'])) {
		require($rut.DIRACT.$direc);
		$inf = exportar($rut);
		//-------------------------------------------
		header('Content-language: es');
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=".$pagina.date('His').".xls");
		//-------------------------------------------
		$html='';
		//-------------------------------------------
		$html.= '<meta charset="utf-8" />';
		$html.= '<br>';
		$html.= '<table border="1">';
			$html.= $inf; $inf=null;
		$html.= '</table>';
		//-------------------------------------------
		echo $html;
		//-------------------------------------------
		exit();
	}