<?php 
if(!defined('IN_LOVE')) {exit('Access Denied');}
$submit = getgpc('submit');
if(!$submit)
{
	include template('add.htm');
	exit;
}
elseif(submitcheck())
{

	$pick = getgpc('pick');
	$send = getgpc('send');
	$info = getgpc('info');
	$icon = getgpc('icon');
	$face = getgpc('face');
	//ÅÐ¶Ï·Ç·¨×Ö·û
	if(preg_match("/$badkey/i",$info) or preg_match("/$badkey/i",$send) or preg_match("/$badkey/i",$pick))
	{
		$messageid = 2;
		include template('message.htm');
		exit;
	}
	else
	{
		//Ð´¿â
		$res = $db->query("INSERT INTO {$tablepre}love (info,send,pick,ip,postdate,icon,face) VALUES ('$info','$send','$pick','$onlineip','$timestamp','$icon','$face')");
		if(!$res)
		{
			$messageid = 9999;
			include template('message.htm');
			exit;
		}
		$messageid = 1;
		include template('message.htm');
		exit;
	}	
}
else
{
	$messageid = 9999;
	include template('message.htm');
	exit;
}
?>
