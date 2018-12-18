<?php

	namespace app\Controller;

	use app\Core\DB;

	class Shop
	{
		public function addShop()
		{
			extract($_POST);
			$file = $_FILES['file'];
			$shop = DB::fetch("SELECT * FROM shop WHERE s_member = ? ",[isMember()['m_idx']]);

			if(!is_uploaded_file($file['tmp_name']) || trim($type) == "" || trim($name) == ""){
				alert("모두 채워 주세요.");
				back();
			}
				
			move_uploaded_file($file['tmp_name'],_UPLOAD."/".isMember()['m_idx'].".a");
			
			if($shop){
				$sql = "UPDATE shop SET s_name = ?, s_type = ? WHERE s_member = ?";
				DB::execute($sql,[$name, $type , isMember()['m_idx']]);
			}else{
				$sql = "INSERT INTO shop SET s_member = ?, s_type = ?, s_name = ?";
				DB::execute($sql,[isMember()['m_idx'], $type, $name]);
			}

			alert("완료되었습니다.");
			back();
		}

		public function addMenu()
		{
			extract($_POST);

			$shop = DB::fetch("SELECT * FROM shop WHERE s_member = ?",[isMember()['m_idx']]);

			if(!$shop){
				alert("가맹점이 없습니다.");
				back();
			}

			if(trim($name) == "" || trim($price) == ""){
				alert("누락된 값이 있습니다.");
				back();
			}

			$sql = "INSERT INTO menu SET me_shop = ?, me_name = ?, me_price = ?, me_date = now()";
			$arr = [$shop['s_idx'], $name, $price];
			DB::execute($sql,$arr);
			alert("메뉴가 등록되었습니다.");
			back();
		}

		public function deleteMenu()
		{
			extract($_GET);

			$orderlist = DB::fetch("SELECT * FROM orderlist WHERE o_menu = ? AND o_state = '배송중'",[$idx]);

			if($orderlist){
				alert("배송중인 메뉴 입니다.");
				back();
			}

			DB::execute("DELETE FROM menu WHERE me_idx = ?",[$idx]);
			alert("삭제 되었습니다.");
			back();
		}
	}