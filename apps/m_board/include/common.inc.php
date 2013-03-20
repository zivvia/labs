<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);
set_magic_quotes_runtime(0);
define('LOVE_ROOT', substr(dirname(__FILE__), 0, -8).'/');
require_once LOVE_ROOT.'./include/global.func.php';
if (isset($_REQUEST['GLOBALS']) OR isset($_FILES['GLOBALS'])) {
	exit('Request tainting attempted.');
}
//Session保存路径
$sessSavePath = LOVE_ROOT."data/sessions/";
if(is_writeable($sessSavePath) && is_readable($sessSavePath))
{
	session_save_path($sessSavePath);
}
date_default_timezone_set (Singapore);
$timestamp = time();
require_once LOVE_ROOT.'./data/config.inc.php';
require_once LOVE_ROOT.'./data/db.inc.php';
require_once LOVE_ROOT.'./include/db_mysql.class.php';
require_once LOVE_ROOT.'./include/template.class.php';
if(defined('UC_KG')) {include_once TM_ROOT.'/uc_client/client.php';}
$PHP_SELF = $_SERVER['PHP_SELF'] ? $_SERVER['PHP_SELF'] : $_SERVER['SCRIPT_NAME'];
$SCRIPT_FILENAME = str_replace('\\', '/', ($_SERVER['PATH_TRANSLATED'] ? $_SERVER['PATH_TRANSLATED'] : $_SERVER['SCRIPT_FILENAME']));
//$homeurl = 'http://'.$_SERVER['HTTP_HOST'].preg_replace("//+(api|archiver|wap)?/*$/i", '', substr($PHP_SELF, 0, strrpos($PHP_SELF, '/'))).'/';

//实例化数据库操作
$db = new dbstuff;
$db->connect($dbhost, $dbuser, $dbpw, $dbname, $pconnect);
unset($dbhost, $dbuser, $dbpw, $dbname, $pconnect);
$db->query("set names gbk");
if(getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown')) {
	$onlineip = getenv('HTTP_CLIENT_IP');
} elseif(getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown')) {
	$onlineip = getenv('HTTP_X_FORWARDED_FOR');
} elseif(getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown')) {
	$onlineip = getenv('REMOTE_ADDR');
} elseif(isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')) {
	$onlineip = $_SERVER['REMOTE_ADDR'];
}

preg_match("/[\d\.]{7,15}/", $onlineip, $onlineipmatches);
$onlineip = $onlineipmatches[0] ? $onlineipmatches[0] : 'unknown';
unset($onlineipmatches);
?>