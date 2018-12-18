<?php

	function autoload($c){
		$cname = str_replace("\\", "/", $c);
		require $cname.".php";
	}

	session_start();
	date_default_timezone_set("Asia/Seoul");
	spl_autoload_register("autoload");