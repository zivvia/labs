<!DOCTYPE html>
<html>
<head>
<meta charset=utf-8" />
<link href="assets/styles/core.css" rel="stylesheet" type="text/css">
<title>难度3/5</title>
</head>
<body>
<p>这是一个新闻页。 </p>
<p>最新新闻。</p>
<p>&nbsp;</p>

<?
    session_start();
    require("inc.php");
    require("inc/Mysql.inc");
    $mysql = new Mysql($host, $user, $password, $database, false);

    if(isset($_GET['id']))
    {
        $s = $_GET["id"];
    }
    else
    {
        $s = 2;
    }
    if(strpos($s, " ") !== FALSE){
	    hint("这里会删除空格哦     ");
    }

    $s=str_replace(" ", "", $s);
    if(isset($_SESSION['a']))
    {
        echo "<h1>第三关</h1>";
        $sql = "select * from news where id=$s"; 
        $query = $mysql->query($sql);

        $result = $mysql->fetch_all($query);
        if(isset($result[1]))
        {
            echo "<h2>".$result[1]["title"]."</h2>\r\n";
            echo "<p>".$result[1]["news"]."</p>";
            echo "<h1>牛逼 ,可以进入<a href='./admin-auth/index2.php'>第四关</a>了,别损害服务器哦</h1>";
        }

   }
   else
   {
        echo "<h1>请先过前2关</h1>";
   }
?>
<p>&copy; <a href="#">精弘网络团队</a>提供</p>
</body>
</html>
