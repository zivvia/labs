<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<link href="assets/styles/core.css" rel="stylesheet" type="text/css">
<title>难度1/5</title>
</head>
<body>
<p>这是一个新闻页。 </p>
<p>最新新闻。</p>
<p>&nbsp;</p>

<?php
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
        $sql = "select * from news where id=$s limit 1";
    
        $query = $mysql->query($sql);

        while($result = $mysql->fetch_array($query))
        {
            echo "<h2>".$result["title"]."</h2>\r\n";
            echo "<p>".$result["news"]."</p>";
    
        }

?>
<p>&copy; <a href="#">精弘网络团队</a>提供</p>
</body>
</html>
