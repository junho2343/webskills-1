<?php

 	namespace app\Core;

 	class DB
 	{
 		private static $db = null;

 		private static function getDB()
 		{
 			if(self::$db == null){
 				self::$db = new \PDO("mysql:host=localhost;dbname=20181003;charset=utf8","root","");
 			}
 			return self::$db;
 		}

 		public function execute($sql, $arr = [])
 		{
 			$rs = self::getDB()->prepare($sql);
 			$rs->execute($arr);
 			return $rs;
 		}

 		public function fetch($sql ,$arr = [])
 		{
 			return self::execute($sql,$arr)->fetch();
 		}

 		public function fetchAll($sql ,$arr = [])
 		{
 			return self::execute($sql,$arr)->fetchAll();
 		}

 		public function rowCount($sql ,$arr = [])
 		{
 			return self::execute($sql,$arr)->rowCount();
 		}
 	}