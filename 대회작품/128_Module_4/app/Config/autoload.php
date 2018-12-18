<?php

	function autoload($c)
	{
		$c = str_replace("\\","/",$c);
		require $c.".php";
	}
	//세션 킴
	session_start();

	//시간 설정
	date_default_timezone_set("Asia/Seoul");
	
	//오토로드 등록
	spl_autoload_register("autoload");