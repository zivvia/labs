<?php 
if(!defined('IN_LOVE')) {exit('Access Denied');}
session_start(); //要验证SESSION，看是不是管理员
if($_SESSION["admin"]!="ok")
{
	if(empty($_POST['Submit'])) 
	{
		include template('login.htm');
	} 
	else 
	{
		$username = getgpc('username');
		$password = getgpc('password');
		$seccode = getgpc('seccode');
		if(empty($username) or empty($password) or empty($seccode))
		{
			$messageid = 7;
			include template('message.htm');
			exit;
		}
		elseif(submitcheck())
		{
			$password = md5($password);
			$row_num = $db->num_rows($db->query("SELECT * FROM {$tablepre}admin where username='{$username}' AND password='{$password}'"));
			if($row_num > 0)
			{
 				$query = $db->query("SELECT username, id FROM {$tablepre}admin WHERE username='$username'");
 				$admin = $db->fetch_array($query);
 				$sql = "UPDATE {$tablepre}admin set oltime='$timestamp',lastip='$onlineip' where id='{$admin[id]}'";
				$db->query($sql);
 				$_SESSION['admin']="ok";
 				$_SESSION['adminuser']=$username;
 				$messageid = 6;
				include template('message.htm');
 				exit;
 			}
 			else
 			{
 				$messageid = 5;
				include template('message.htm');
			}
		}
		else
		{
			$messageid = 9998;
			include template('message.htm');
		}
	}
}
else
{	
	$m = getgpc('m');
	if($m=='editpass')
	{
		if(empty($_POST['Submit'])) 
		{
			$master = 1;
			include template('login.htm');
			exit;
		} 
		else 
		{
			if(submitcheck())
			{
				$pass = getgpc('pass');
				$password = getgpc('password');
				if($pass != $password)
				{
					$messageid = 8;
					include template('message.htm');
					exit;
				}
				else
				{
					$username = $_SESSION['adminuser'];
					$pass = md5($password);
					$res = $db->query("UPDATE `{$tablepre}admin` SET `password` = '$pass' WHERE `username` ='$username';");
					if($res)
					{
						$messageid = 4;
						include template('message.htm');
						exit;
					}
					else
					{
						$messageid = 9;
						include template('message.htm');
						exit;
					}
				}
			}
		}
	}
	elseif($m=='del')
	{
		$id = getgpc('id');
		$res = $db->query("DELETE FROM {$tablepre}love WHERE id = {$id}");
		if($res)
		{
			$messageid = 3;
			include template('message.htm');
  	  		exit;
		}
	}
	else
	{
		$page = getgpc('page');
		// 获取当前页数 
		if(isset($page))
		{ 
			$page = intval($page); 
		}
		else
		{ 
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
		$master = 1;
		include template('list.htm');
		$db->close();
		exit;
	}
}
?>