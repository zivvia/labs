<?php 
if(!defined('IN_LOVE')) {exit('Access Denied');}
$page = getgpc('page');
// 获取当前页数 
if(isset($page)){ 
	$page = intval($page); 
}else{ 
	$page = 1; 
}
$sql = "SELECT * FROM `{$tablepre}love`";
$row = $db->num_rows($db->query($sql));
$mpurl =$PHP_SELF.'?a=list&';
$dispage =  page($row,$page_size,$page,$mpurl);
$page_get_start = page_get_start($page,$page_size,$row);
$sql = "SELECT * FROM {$tablepre}love LIMIT $page_get_start, $page_size";
$lovelist = $db->fetch_all($sql);
$a = 'Y/m/d H:i';
include template('list.htm');
$db->close();
exit;
?>