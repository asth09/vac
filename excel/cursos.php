<?php
	session_start();
	$rut='../';
	$pagina='Cursos';
	$direc='cursos.php';
	require($rut.'constant.php');
	$inf=null;

	require($rut.DIRACT.$direc);
	$inf = exportar($rut,1);

	header('Content-language: es');
	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=".$pagina.date('His').".xls");

	$html='';
		
	$html.= '<meta charset="utf-8" />';
	$html.= '<br>';
	$html.= '<table border="1">';
		$html.= $inf; $inf=null;
	$html.= '</table>';

	echo $html;
	
	exit();
?>