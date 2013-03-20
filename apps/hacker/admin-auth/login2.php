<?


$username = trim($_POST["username"]);


$spassword = $_POST["password"];




require("../inc.php");
require("../inc/Mysql.inc");


$mysql = new Mysql($host, $user, $password, $database, false);

//$username ="'or'1';-- ";
$spassword =Intval($spassword);
if(strpos($username, " ") !== FALSE){
	hint("这里会删除空格哦",true);
}
if($username == "\'or\'=\'or\'" || $username == "\'or\' = \'or\'" || $spassword  == "\'or\'=\'or\'" || $spassword  == "\'or\' = \'or\'"){
	hint("万能密钥对 php 来说一般不成功， 因为 php 默认对提交的文字转义。");	
} else if(strpos($username, "\'") !== FALSE) {
	hint(" php 会对' 转义");	
}


//$sql = "select * from users where username='$username' and password='$spassword' limit 1";
//echo $sql."<br />";

//$query = $mysql->query("select * from users where username='$username' and password='$spassword' limit 1");

//echo "2";
//$result =  $mysql->fetch_array($query);
//$result="";
//exit;
//if(!$result){
//	echo "用户名或密码错误";
//	echo "<script>setTimeout(function(){ location.href='index.php'; }, 800)</script>";	
//} else {
  //  session_start();
	//$_SESSION["a"] =   $username;
  //  echo $username;
  if($username=="suzie" && $spassword =="123456")
  {
	echo "<h1>登陆成功!</h1>";
	echo "你的SQL注入能力已经过关,更多关卡敬请期待<a href='../'>返回首页</a>";
  }
  else
  {
    echo "<a href='./index2.php'>返回</a>";
  }
//	echo "<script>setTimeout(function(){ location.href='main.php'; }, 2000)</script>";
//}
