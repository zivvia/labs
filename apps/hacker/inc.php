<?php

require("config.php");

function  hint($content, $exit  = false){
	
	if($exit){
		exit("精弘网络团队: ".$content);
	}
    else
    {
        
	echo "精弘网络团队: ".$content."  <br>";
    }
}
