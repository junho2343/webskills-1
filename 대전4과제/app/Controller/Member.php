<?php

	namespace app\Controller;

	use app\Core\DB;

	class Member
	{
		public function login()
		{
			extract($_POST);
			$member = DB::fetch("SELECT * FROM member WHERE m_id = ? AND m_pw = ?",[$id, $pw]);

			if(!$member){
				alert("없는 아이디 또는 비밀번호 입니다.");
				back();
			}

			$_SESSION['member'] = $member;
			alert("로그인이 완료되었습니다.");
			location("/");
		}

		public function logout()
		{
			unset($_SESSION['member']);
			alert("로그아웃이 완료되었습니다.");
			location("/");
		}

		public function join()
		{	

			$check = $this->check($_POST);
			extract($_POST);
			$member = DB::fetch("SELECT * FROM member WHERE m_id = ?",[$id]);
		
			if($check != ""){
				alert($check);
				back();
			}else if($member){
				alert("이미 있는 아이디 입니다.");
				back();
			}



			$x = explode(",",$location)[0];
			$y = explode(",",$location)[1];
			$arr= [$id, $name, $pw, $grade, $phone, trim($x), trim($y)]; 
			DB::execute("INSERT INTO member SET m_id = ?, m_name = ?, m_pw = ?, m_grade = ?, m_phone = ?, m_x = ?, m_y = ?",$arr);
			alert("회원가입이 완료되었습니다.");
			location("/login");
		}

		public function update()
		{
			$_POST['pw'] = $_POST['pw'] != "" ? $_POST['pw'] : isMember()['m_pw'];
			$check = $this->check($_POST);
			extract($_POST);
			if($check != ""){
				alert($check);
				back();
			}

			$x = explode(",",$location)[0];
			$y = explode(",",$location)[1];

			$arr = [$pw, $phone, trim($x), trim($y),isMember()['m_idx']];
			DB::execute("UPDATE member SET m_pw = ?, m_phone = ?, m_x = ?, m_y = ? WHERE m_idx = ?",$arr);
			$_SESSION['member'] = DB::fetch("SELECT * FROM member WHERE m_idx = ?",[isMember()['m_idx']]);

			alert("수정되었습니다.");
			back();
		}

		public function check($data)
		{
			$flag = [
				"id" => '/^[a-zA-Z]{4,12}$/',
				"name" => '/^[가-힣ㄱ-ㅎㅏ-ㅣ]{2,4}$/u',
				"pw" => '/^(?=.*[a-zA-Z])(?=.*[0-9])[a-zA-Z0-9]{4,8}$/',
				"phone" => '/^[0-9]{4}-[0-9]{4}-[0-9]{4}$/'
			];

			$names = [
				"id" => "아이디 형식이 잘못되었습니다.\\n",
				"name" => "이름 형식이 잘못되었습니다.\\n",
				"pw" => "비밀번호 형식이 잘못되었습니다.\\n",
				"grade" => "회원구분이 누락 되었습니다.\\n",
				"phone" => "전화번호 형식이 잘못되었습니다.\\n",
				"location" => "위치정보가 누락 되었습니다.\\n"
			];

			$msg = "";

			foreach ($data as $key => $value) {
				if(isset($flag[$key])){
					if(!preg_match($flag[$key], $value)){
						$msg .= $names[$key];
					}
				}else{
					if(trim($value) == ""){
						$msg .= $names[$key];	
					}
				}
			}

			return $msg;
		}
	}