<?php
//Nemo Cache @ 2012-08-02 00:39:26
echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>'.$siteName.'</title>
<meta content="'.$siteName.'" name="Description" />
<style><!--@import url(inc/style.css);--></style>
</head>
<body>
<div style="display:none;" id="aspk" onclick="Hide();"></div>
<div id="header">
	<span style="float:left;"><a href="'.$PHP_SELF.'" target="_blank"><img src="images/logo.gif" alt="留言墙" /></a></span>
	
</div>
<div id="menu">
	<a href="'.$PHP_SELF.'"><img src="images/btn_index.gif" alt="首页" /></a>
	<a href="'.$PHP_SELF.'?a=add"><img src="images/btn_add.gif" alt="留言" /></a>
	<a href="'.$PHP_SELF.'?a=list"><img src="images/btn_list.gif" alt="字条列表" /></a>
	<input id="find" name="id" class="input" type="text" maxlength="10" size="15" value=" 请输入字条编号 " onclick="this.value=\'\';" />
	<input type="image" src="images/btn_search.gif" alt="搜索" onclick="find();" />
</div>
<script type="text/javascript">
<!--
function find(){
	var noStr = document.getElementById("find").value;
	var no = parseInt(noStr);
	if(isNaN(no)){
		alert("[字条编号]肯定是数字啊");
		return;
	}else if(no < 1){
		alert("[字条编号]肯定是整数啊");
		return;
	}else{
		window.location.href = "'.$PHP_SELF.'?a=so&id="+no;		
	}
}
//-->
</script>';
?>