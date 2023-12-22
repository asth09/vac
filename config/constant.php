<?php
define('HTTP', 'http://');
define('HTTPS', 'https://');
//-------------------------------------------
define('TIT', ' | Metedología VAC con PHP');
//-------------------------------------------
define('DIRMOR', 'MORENOCL/');
define('DIRACT', 'ACTIONJF/');
//-------------------------------------------
define('__DIRIMG__', $_SERVER['DOCUMENT_ROOT']."/vac/img/");
define('DIRERR', '/error');
define('CONF', 'config/');
//-------------------------------------------
define('SCHU', '_qas');//esquema
//define('SCHU', '_prd');
//-------------------------------------------
if (SCHU == '_qas') {
	define('DIR', '/vac/');
	//-------------------------------------------
	define('URL', HTTPS.'localhost'.DIR);
}else{
	define('DIR', '/');
	//-------------------------------------------
	define('URL', HTTPS.'vac.frankmorenoalburqueque.com'.DIR);
}
//-------------------------------------------
define('IMG', URL.'img/');
define('SIST', URL.'sistem/');
define('XCEL', URL.'excel/');
define('LOGI', URL.'login/');
define('PDFS', URL.'pdf/');
define('ACTI', URL.DIRACT);
define('PLUG', URL.'plugins/');
define('FMMA', 'https://www.frankmorenoalburqueque.com/');
define('LOGOF', FMMA.'images/logo.png');
define('FACE', 'https://www.facebook.com/fmorenoadmin/');
define('TWIT', 'https://www.facebook.com/fmorenoadmin/');
define('INST', 'https://www.facebook.com/fmorenoadmin/');
//-------------------------------------------
define('SECRET_KEY', '');