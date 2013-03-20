<?php
    session_start();
    if(isset($_SESSION['a']))
    {
        unset($_SESSION['a']);
        echo "<p>注销成功<a href='./'>返回</a></p>";
    }
    else
   echo "<p><a href='./'>返回</a></p>";
