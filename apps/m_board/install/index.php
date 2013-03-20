<?php

/*------------------------
初始化系统环境
function _0_InitEnv()
------------------------*/
// 	设定错误信息的报告等级
error_reporting(E_ALL & ~E_NOTICE);
define('ROOTDIR', substr(dirname(__FILE__), 0, -8));
// 	定义一个变量$cfg_needFilter并赋值flase
$cfg_needFilter = false;
// 	探测服务器php.ini文件中magic_quotes_gpc选项的设置情况,将结果存储在变量$cfg_isMagic中
$cfg_isMagic = ini_get("magic_quotes_gpc");
/* 
   	如果$cfg_isMagic变量的值是0,说明php.ini文件中magic_quotes_gpc=off
   	则加载'/include/config_rglobals_magic.php'文件
   	否则$cfg_isMagic变量的值是1,说明php.ini文件中magic_quotes_gpc=on
	此时,探测服务器php.ini文件中register_globals选项的设置情况,将结果存储在变量$cfg_registerGlobals中
  	如果$cfg_registerGlobals变量的值是0,说明php.ini文件中register_globals=off
  	则加载'/include/config_rglobals.php'文件
*/
if(!$cfg_isMagic){
  require_once("includes/config_rglobals_magic.php");
}else{
	$cfg_registerGlobals = ini_get("register_globals");
	if(!$cfg_registerGlobals) require_once("includes/config_rglobals.php");
}
// 	如果$step变量的值为空,则说明安装刚刚开始,设置当前为'安装步骤1'
if(empty($step)) $step = 1;
// 	加载'./inc_install.php'文件
require_once("includes/inc_install.php");

// 	定义变量$gototime并赋值为2000
$gototime = 2000;
if ( $step == 1 )
{
	if(file_exists(ROOTDIR.'./data/install.lock')) exit('您已经安装过PHPK,如果需要重新安装，请删除 ./data/install.lock 文件！');
	include_once( "./templates/s1.html" );
	exit( );
}
if ( $step == 2 )
{
	$phpv = @phpversion( );
	$sp_os = $_ENV['OS'];
	$sp_gd = @gdversion( );
	$sp_server = $_SERVER['SERVER_SOFTWARE'];
	$sp_host = empty( $_SERVER['SERVER_ADDR'] ) ? $_SERVER['SERVER_HOST'] : $_SERVER['SERVER_ADDR'];
	$sp_name = $_SERVER['SERVER_NAME'];
	$sp_max_execution_time = ini_get( "max_execution_time" );
	$sp_allow_reference = ini_get( "allow_call_time_pass_reference" ) ? "<font color=green>[√]On</font>" : "<font color=red>[×]Off</font>";
	$sp_allow_url_fopen = ini_get( "allow_url_fopen" ) ? "<font color=green>[√]On</font>" : "<font color=red>[×]Off</font>";
	$sp_safe_mode = ini_get( "safe_mode" ) ? "<font color=red>[×]On</font>" : "<font color=green>[√]Off</font>";
	$sp_gd = 0 < $sp_gd ? "<font color=green>[√]On</font>" : "<font color=red>[×]Off</font>";
	$sp_mysql = function_exists( "mysql_connect" ) ? "<font color=green>[√]On</font>" : "<font color=red>[×]Off</font>";
	if ( $sp_mysql == "<font color=red>[×]Off</font>" )
	{
		$sp_mysql_err = true;
	}
	else
	{
		$sp_mysql_err = false;
	}
	$sp_testdirs = array( "/", "/data", "/install", "/template" );
	include_once( "./templates/s2.html" );
	exit( );
}
if ( $step == 3 )
{
	if ( !empty( $_SERVER['REQUEST_URI'] ) )
	{
		$scriptName = $_SERVER['REQUEST_URI'];
	}
	else
	{
		$scriptName = $_SERVER['PHP_SELF'];
	}
	$rootpath = ereg_replace( "/install/index\\.php(.*)\$", "", $scriptName );
	if ( empty( $_SERVER['HTTP_HOST'] ) )
	{
		$domain = $_SERVER['HTTP_HOST'];
	}
	else
	{
		$domain = $_SERVER['SERVER_NAME'];
	}
	$domain = eregi_replace( "^www.", "", $domain );
	$rnd_cookieEncode = chr( mt_rand( ord( "A" ), ord( "Z" ) ) ).chr( mt_rand( ord( "a" ), ord( "z" ) ) ).chr( mt_rand( ord( "A" ), ord( "Z" ) ) ).chr( mt_rand( ord( "A" ), ord( "Z" ) ) ).chr( mt_rand( ord( "a" ), ord( "z" ) ) ).mt_rand( 1000, 9999 ).chr( mt_rand( ord( "A" ), ord( "Z" ) ) );
	include_once( "./templates/s3.html" );
	exit( );
}
if ( $step == 5 )
{
	if ( empty( $setupsta ) )
	{
		$setupsta = 0;
	}
	if ( $setupsta == 0 )
	{
		$setupinfo = "";
		$gotourl = "";
		$gototime = 2000;
		$conn = @mysql_connect( $dbHost, $dbUser, $dbPwd );
		if ( !$conn )
		{
			echo getbackalert( "数据库服务器或登录密码无效，\\n\\n无法连接数据库，请重新设定！" );
			exit( );
		}
		$rs = mysql_select_db( $dbName, $conn );
		if ( !$rs )
		{
			$rs = mysql_query( " CREATE DATABASE `".$dbName."`; ", $conn );
			if ( !$rs )
			{
				$errstr = getbackalert( "数据库 ".$dbName." 不存在，也没权限创建新的数据库！" );
				echo $errstr;
				exit( );
			}
			$rs = mysql_select_db( $dbName, $conn );
			if ( !$rs )
			{
				$errstr = getbackalert( "你对数据库 ".$dbName." 没权限！" );
				echo $errstr;
				exit( );
			}
		}
		$errstr = getbackalert( "读取配置 _config.php 失败，请检查data/conf/_config.php是否可读取！" );
		if ( !( $fp = fopen( ROOTDIR."/data/conf/_config.php", "r" ) ) )
		{
			exit( $errstr );
		}
		$strConfig = fread( $fp, filesize( ROOTDIR."/data/conf/_config.php" ) );
		fclose( $fp );
		$strConfig = str_replace( "~`~SITENAME~`~", $siteName, $strConfig );
		$strConfig = str_replace( "~`~SITEDOMAIN~`~", $siteDomain, $strConfig );
		$strConfig = str_replace( "~`~SITEKEYWORDS~`~", $siteKeywords, $strConfig );
		$strConfig = str_replace( "~`~SITEDESCRIPTION~`~", $siteDescription, $strConfig );

		$strConfig = str_replace( "~`~ADMINEMAIL~`~", $adminmail, $strConfig );
		$strConfig = str_replace( "~`~DATE~`~", date( "Y-m-d" ), $strConfig );
		$strConfig = str_replace( "~`~USER~`~", $adminName, $strConfig );
		$strConfig = str_replace( "~`~BADKEY~`~", $badkey, $strConfig );
		$errstr = getbackalert( "写入配置 data/config.inc.php 失败，请检查 data 文件夹是否可读写！" );
		if ( !( $fp = fopen( ROOTDIR."/data/config.inc.php", "w+" ) ) )
		{
			exit( $errstr );
		}
		flock( $fp, 2 );
		fwrite( $fp, $strConfig );
		fclose( $fp );
		//配置数据库
		
		$errstr = getbackalert( "读取配置 _db.php 失败，请检查data/conf/_db.php是否可读取！" );
		if ( !( $fp = fopen( ROOTDIR."/data/conf/_db.php", "r" ) ) )
		{
			exit( $errstr );
		}
		$strConfig = fread( $fp, filesize( ROOTDIR."/data/conf/_db.php" ) );
		fclose( $fp );
		$strConfig = str_replace( "~`~DBHOST~`~", $dbHost, $strConfig );
		$strConfig = str_replace( "~`~DBUSER~`~", $dbUser, $strConfig );
		$strConfig = str_replace( "~`~DBPWD~`~", $dbPwd, $strConfig );
		$strConfig = str_replace( "~`~DBNAME~`~", $dbName, $strConfig );
		$strConfig = str_replace( "~`~DBPREFIX~`~", $dbPrefix, $strConfig );
		$strConfig = str_replace( "~`~DATE~`~", date( "Y-m-d" ), $strConfig );
		$strConfig = str_replace( "~`~USER~`~", $adminName, $strConfig );
		$errstr = getbackalert( "写入配置 data/db.inc.php 失败，请检查 data 文件夹是否可读写！" );
		if ( !( $fp = fopen( ROOTDIR."/data/db.inc.php", "w+" ) ) )
		{
			exit( $errstr );
		}
		flock( $fp, 2 );
		fwrite( $fp, $strConfig );
		fclose( $fp );
		
		
		mysql_query( "SET NAMES 'GBK';", $conn );
		$rs = mysql_query( "SELECT VERSION();", $conn );
		$row = mysql_fetch_array( $rs );
		$mysql_version = $row[0];
		$mysql_versions = explode( ".", trim( $mysql_version ) );
		$mysql_version = $mysql_versions[0].".".$mysql_versions[1];
		$adminPwd = md5( $adminPwd );
		if ( $mysql_version < 4.1 )
		{
			$fp = fopen( ROOTDIR."/data/conf/_db.sql", "r" );
		}
		else
		{
			$fp = fopen( ROOTDIR."/data/conf/_db.sql", "r" );
		}
		$query = "";
		while ( !feof( $fp ) )
		{
			$line = trim( fgets( $fp, 1024 ) );
			
			if ( ereg( ";\$", $line ) )
			{
				$query .= $line;
				$query = str_replace( "love_", $dbPrefix, $query );
				$query = str_replace( "~ADMINNAME~", $adminName, $query );
				$query = str_replace( "~ADMINPWD~", $adminPwd, $query );
				if ( $mysql_version < 4.1 )
				{
					mysql_query( str_replace( "ENGINE=MyISAM  DEFAULT CHARSET=gbk", "TYPE=MyISAM", $query ), $conn );
				}
				else
				{
					
					mysql_query( $query, $conn );
				}
				$query = "";
			}
			else if ( !ereg( "^(//|--)", $line ) )
			{
				$query .= $line;
			}
		}
		fclose( $fp );
		mysql_close( $conn );
		$setupmodules = "";
		if ( is_array( $moduls ) )
		{
			foreach ( $moduls as $m )
			{
				if ( trim( $m ) != "" )
				{
					$setupmodules .= $setupmodules == "" ? $m : ",".$m;
				}
			}
		}
		$gotourl = "index.php?step=5&setupsta=1";
		$setupinfo = "\r\n            \t    数据库安装成功。<br />请稍候……<br />\r\n            \t    如果系统太长时间没有反应，请点击<a href='".$gotourl."'>这里</a>。\r\n            \t  ";
		include_once( "./templates/s4.html" );
		exit( );
	}
	$adminDir = "index.php?a=admin";
	$fp = fopen( ROOTDIR."/data/install.lock", "w+" );
	fwrite( $fp, "ok" );
	fclose( $fp );
	$gototime = 3000;
	$gotourl = "../".$adminDir;
	$setupinfo = "\r\n            \t        已完成所有项目的安装。<br />\r\n            \t        现在转入管理员登录页面(<a href='".$gotourl."'>/{$adminDir}</a>)，请稍候……<br />\r\n            \t        如果系统太长时间没有反应，请点击<a href='{$gotourl}'>这里</a>。\r\n            \t      ";
	include_once( "./templates/s4.html" );
	exit( );
}
if ( $step == 10 )
{
	header( "Pragma:no-cache\r\n" );
	header( "Cache-Control:no-cache\r\n" );
	header( "Expires:0\r\n" );
	header( "Content-Type: text/html; charset=gb2312" );
	$conn = @mysql_connect( $dbHost, $dbUser, $dbPwd );
	if ( $conn )
	{
		$rs = mysql_select_db( $dbName, $conn );
		if ( !$rs )
		{
			$rs = mysql_query( " CREATE DATABASE `".$dbName."`; ", $conn );
			if ( $rs )
			{
				mysql_query( " DROP DATABASE `".$dbName."`; ", $conn );
				echo "<font color='green'>[√] 信息正确</font>";
			}
			else
			{
				echo "<font color='red'>[×] 数据库不存在，也没权限创建新的数据库！</font>";
			}
		}
		else
		{
			echo "<font color='green'>[√] 信息正确</font>";
		}
	}
	else
	{
		echo "<font color='red'>[×] 数据库连接失败！</font>";
	}
	@mysql_close( $conn );
	exit( );
}
?>
