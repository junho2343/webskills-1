<?php

	namespace app\Controller;
	use app\Core\DB;


	class Member
	{	

		public function login()
		{
			extract($_POST);
			$member = DB::fetch("SELECT * FROM member WHERE m_id = ? AND m_pw = ?",[$id,$pw]);
			if(!$member){
				$_SESSION['msg'] = "없는 아이디 또는 비밀번호 입니다.";
				back();
			}
			$_SESSION['member'] = $member;
			location("/");
		}

		public function join()
		{	

			if(!$this->check($_POST)){
				$_SESSION['msg'] = "값이 누락 되거나 형식이 틀립니다.";
				back();
			}
			extract($_POST);
			if(DB::fetch("SELECT * FROM member WHERE m_id = ?",[$id])){
				$_SESSION['msg'] = "이미 있는 아이디 입니다.";
				back();	
			}
			$sql = "";
			$arr = [];
			if(isset($weight)){
				$sql = "INSERT INTO member SET m_id = ?, m_pw = ?, m_name = ?, m_phone = ?, m_weight = ?, m_grade = ?";
				$arr = [$id,$pw,$name,$phone,$weight,"지입차량주"];
			}else{
				$sql = "INSERT INTO member SET m_id = ?, m_pw = ?, m_name = ?, m_phone = ?, m_grade = ?";
				$arr = [$id,$pw,$name,$phone,"고객사"];
			}

			DB::execute($sql,$arr);
			location("/login");
		}

		public function logout()
		{
			unset($_SESSION['member']);
			location("/");
		}

		public function check($data)
		{
			$flag = [
				"id" => !filter_var($data['id'],FILTER_VALIDATE_EMAIL),
				"pw" => !preg_match('/^(?=.*[a-zA-Z])(?=.*[0-9]).{8,}$/',$data['pw']),
				"pw2" => preg_match('/(.)\1\1\1/',$data['pw']),
				"name" => !preg_match('/^[a-zA-Zㄱ-ㅎㅏ-ㅣ가-힣]+$/u',$data['name']),
				"phone" => !preg_match('/^[0-9]{2,3}-[0-9]{3,4}-[0-9]{4}$/',$data['phone'])
			];

			if(isset($data['weight'])){
				if(trim($data['weight']) == "")
					return false;
			}

			foreach($flag as $key => $value){
				if($value){
					return false;				
				}
			}

			return true;

		}
	}