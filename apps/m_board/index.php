<?php
define('LOVE_SERVER_VERSION', '1.0.0');
define('LOVE_SERVER_RELEASE', '20090921');

error_reporting(0);
set_magic_quotes_runtime(0);

$mtime = explode(' ', microtime());
$starttime = $mtime[1] + $mtime[0];

define('IN_LOVE', TRUE);
define('LOVE_ROOT', dirname(__FILE__).'/');
define('LOVE_API', strtolower(($_SERVER['HTTPS'] == 'on' ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'].substr($_SERVER['PHP_SELF'], 0, strrpos($_SERVER['PHP_SELF'], '/'))));
define('LOVE_DATADIR', LOVE_ROOT.'data/');
define('LOVE_DATAURL', LOVE_API.'/data');
define('MAGIC_QUOTES_GPC', get_magic_quotes_gpc());

if(!@include LOVE_DATADIR.'config.inc.php') 
{
	exit('The file <b>data/config.inc.php</b> does not exist, perhaps because of UCenter has not been installed, <a href="install/index.php"><b>Please click here to install it.</b></a>.');
}

include_once './include/common.inc.php';
include_once LOVE_ROOT.'./data/template.inc.php';
include_once LOVE_ROOT.'./data/seccode.inc.php';
define('_TPLPath_', _TPLPatha_.'/'._TPLPathb_.'/');
define("_TPLCachePath_",  'data/view/');
define('_TPLCacheLimit_', _TPLCacheLimitview_);
define("_FORMHASH_", formhash());

unset($GLOBALS, $_ENV, $HTTP_GET_VARS, $HTTP_POST_VARS, $HTTP_COOKIE_VARS, $HTTP_SERVER_VARS, $HTTP_ENV_VARS);

$_GET		= daddslashes($_GET, 1, TRUE);
$_POST		= daddslashes($_POST, 1, TRUE);
$_COOKIE	= daddslashes($_COOKIE, 1, TRUE);
$_SERVER	= daddslashes($_SERVER);
$_FILES		= daddslashes($_FILES);
$_REQUEST	= daddslashes($_REQUEST, 1, TRUE);

$a = getgpc('a');

$act = @in_array($a, array(
'add', 
'list', 
'so', 
'admin', 
'api')) ? $a : 'index';
include_once LOVE_ROOT.'./source/'.$act.'.php';

$mtime = explode(' ', microtime());
$endtime = $mtime[1] + $mtime[0];
//echo '<script>document.getElementById(\'debug_time\').innerHTML = \''.number_format($endtime - $starttime, 5).'\'</script>'."\n";
function daddslashes($string, $force = 0, $strip = FALSE) {
	if(!MAGIC_QUOTES_GPC || $force) {
		if(is_array($string)) {
			foreach($string as $key => $val) {
				$string[$key] = daddslashes($val, $force, $strip);
			}
		} else {
			$string = addslashes($strip ? stripslashes($string) : $string);
		}
	}
	return $string;
}

function getgpc($k, $var='R') {
	switch($var) {
		case 'G': $var = &$_GET; break;
		case 'P': $var = &$_POST; break;
		case 'C': $var = &$_COOKIE; break;
		case 'R': $var = &$_REQUEST; break;
	}
	return isset($var[$k]) ? $var[$k] : NULL;
}
?>

