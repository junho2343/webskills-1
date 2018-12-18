<?php

	namespace app\Core;

	class Router
	{
		private static $GET = [];
		private static $POST = [];

		public static function run()
		{
			$path = "/";
			$path .= isset($_GET['param']) ? explode("/",$_GET['param'])[0] : "";
			foreach(self::${$_SERVER['REQUEST_METHOD']} as $value){
				if($value[0] == $path){
					$action = explode("@",$value[1]);
					$c = "app\\Controller\\$action[0]";
					$c = new $c();
					$c->{$action[1]}();
					return;
				}
			}
			alert("잘못된 경로 입니다.");
			location("/");

		}

		public static function get($link,$action)
		{
			array_push(self::$GET, [ $link,$action ]);
		}
		public static function post($link,$action)
		{
			array_push(self::$POST, [ $link,$action ]);
		}
	}