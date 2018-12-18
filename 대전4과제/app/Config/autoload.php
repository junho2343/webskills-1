<?php

	function autoload($c){
		$c = str_replace("\\", "/", $c);
		require $c.".php";
	}

	date_default_timezone_set("Asia/Seoul");
	session_start();
	spl_autoload_register("autoload");