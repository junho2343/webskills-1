<?php

 namespace app\Controller;

 use app\Core\DB;

 class Controller
 {
 	public function view($page,$data){
 		extract($data);

 		if(!DB::fetch("SELECT * FROM member")){
 			DB::execute("INSERT INTO member SET m_id = ?, m_pw = ?, m_grade = ?",["master","1234","관리자"]);
 		}

 		require _VIEW."/header.php";
 		require _VIEW."/{$page}.php";
 	}
 }