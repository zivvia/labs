<?


$username = trim($_POST["username"]);

if(isset($_POST['password']))
{
    $spassword = $_POST["password"];
}
else
{
    $spassword ='';
}



require("../inc.php");
require("../inc/Mysql.inc");


$mysql = new Mysql($host, $user, $password, $database, false);

//$username ="'or'1';-- ";
//$spassword =Intval($spassword);
    

if($username == "\'or\'=\'or\'" || $username == "\'or\' = \'or\'" || $spassword  == "\'or\'=\'or\'" || $spassword  == "\'or\' = \'or\'"){
	hint("万能密钥对 php 来说一般不成功， 因为 php 默认对提交的文字转义。");	
} else if(strpos($username, "\'") !== FALSE) {
	hint(" php 会对' 转义");	
}


$sql = "select * from users where username='$username' and password='$spassword' limit 1";
//echo $sql."<br />";

$query = $mysql->query("select * from users where username='$username' and password='$spassword' limit 1");

//echo "2";
$result =  $mysql->fetch_array($query);
//$result="";
//exit;
if(!$result){
	echo "用户名或密码错误";
//	echo "<script>setTimeout(function(){ location.href='index.php'; }, 800)</script>";	
} else {
    session_start();
	$_SESSION["a"] =   $username;
    echo $username;
	echo "登陆成功! <a href='unset.php'>注销登录</a>";
    echo "<h1>接下来请看第3关和第四关</h1>";
	echo "第三关<a href='../news2.php?id=2'>注入网页</a>，让我们继续挖掘点数据,这是第四关的<a href='index2.php'>升级版后台</a>";
//	echo "<script>setTimeout(function(){ location.href='main.php'; }, 2000)</script>";
}
