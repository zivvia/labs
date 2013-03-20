<?php 
if(!defined('IN_LOVE')) {exit('Access Denied');}
$id = getgpc('id');
if(!$id)
{
	$sql = "SELECT * FROM {$tablepre}love ORDER BY `id` DESC LIMIT 0 , {$love_size}";
}
else
{
	$sql = "SELECT * FROM {$tablepre}love WHERE id<='$id'  ORDER BY `id` DESC LIMIT 0 , {$love_size}";
}
$lovelist = $db->fetch_all($sql);
$a = 'Y/m/d H:i';
include template('index.htm');
?>