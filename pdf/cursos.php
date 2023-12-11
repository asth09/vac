<?php
	if(isset($_SESSION)){}else{ session_start(); }
	$rut='../';
	$pagina='Cursos';
	$direc='cursos.php';
	require($rut.'config/constant.php');
	$inf=null;
	//-------------------------------------------
	require_once '../plugins/dompdf/autoload.inc.php';
	//-------------------------------------------
	use Dompdf\Dompdf;
	//-------------------------------------------
	if (isset($_SESSION['sid'])) {
		require_once($rut.DIRACT.$direc);
		$inf = exportar($rut,2);
		//-------------------------------------------
		$paper_size=array(0,0,1080,720);
		//$paper_size='"letter","landscape"';
		$html="";
		//-------------------------------------------
		$html.='<meta charset="utf-8">';
		//-------------------------------------------
		$html.='<table width="100%" style="vertical-align: middle;">';
			$html.='<tr>';
				$html.='<th width="20%">';
				$html.='</th>';
				$html.='<th width="60%" align="center" style="font-size: 2em;">';
		    		$html.='Lista de '.$pagina;
				$html.='</th>';
				$html.='<th width="20%">';
				$html.='</th>';
			$html.='</tr>';
		$html.='</table>';
		$html.='<br>';
		$html.='<br>';
	    $html.='<table border="1" width="100%">';
		    $html.=$inf->inf; $inf->inf=null;
		$html.='</table>';
		$html.='<br>';
		//-------------------------------------------
		$inf=null;
		ob_start();
		$dompdf = new DOMPDF();
		$dompdf->set_paper($paper_size);
		$dompdf->load_html($html);
		$dompdf->render();
		$dompdf->stream($pagina.date('His').".pdf");
		//-------------------------------------------
		exit();
	}