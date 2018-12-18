<?php

	namespace app\Core;

	class DB
	{
		private static $db = null;

		private static function getDB()
		{
			if(self::$db == null){
				self::$db = new \PDO("mysql:host=localhost;dbname=20180920;charset=utf8","root","");
			}
			return self::$db;
		}

		public static function execute($sql,$arr = [])
		{	
			$rs = self::getDB()->prepare($sql);
			$rs->execute($arr);
			return $rs;
		}

		public static function fetch($sql,$arr = [])
		{
			return self::execute($sql,$arr)->fetch();
		}

		public static function fetchAll($sql,$arr = [])
		{
			return self::execute($sql,$arr)->fetchAll();
		}

		public static function rowCount($sql,$arr = [])
		{
			return self::execute($sql,$arr)->rowCount();
		}
	}