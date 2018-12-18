<?php

	namespace app\Controller;
	use app\Core\DB;

	class Contract
	{	

		
		public function addContract()
		{
			extract($_POST);

			if(trim($phone) == "" || $weight == "" || $area == "" || $date == ""){
				alert("누락된 값이 있습니다.");
				back();
			}

			$no = sprintf("%04d",(DB::rowCount("SELECT * FROM contract") + 1));
			$code = Date("Ymd-").$no;
			$date = cdate($date);

			$sql = "INSERT INTO contract SET c_member = ? ,c_phone = ?, c_weight = ?, c_area = ?, c_date = ?, c_rdate = now(), c_code = ?";
			$arr = [isMember()['m_idx'], $phone, $weight, $area, $date, $code];

			DB::execute($sql,$arr);
			alert("신청 되었습니다.");
			location("/delivery");
		}

		public function addInsu()
		{
			extract($_GET);

			$idxs = explode("-",$idx);
			foreach ($idxs as $key => $value) {
				if(DB::fetch("SELECT * FROM insu WHERE i_contract = ?",[$value])){
					alert("이미 인수된 항목입니다.");
					back();
				}
			}
			$box = Date("Y-m-d H:i:s");
			$sql = "INSERT INTO insu SET i_car = ?, i_contract = ?, i_path = ?, i_min = ?, i_max = ?, i_me = ?, i_box = ?";
			foreach ($idxs as $key => $value) {
				DB::execute("UPDATE contract SET c_state = '배송대기' WHERE c_idx = ?",[$value]);
				$arr = [isMember()['m_idx'], $value, $path, $min, $max, $key, $box];
				DB::execute($sql,$arr);
			}

			alert("인수 되었습니다.");
			back();

		}

		public function start()
		{
			extract($_GET);

			$list = DB::fetchAll("SELECT * FROM insu WHERE i_box = ?",[$box]);
			DB::execute("UPDATE insu SET i_state = '배송중' WHERE i_box = ?",[$box]);

			foreach ($list as $key => $value) {
				DB::execute("UPDATE contract SET c_state = '배송중' WHERE c_idx = ?",[$value['i_contract']]);
			}
			alert("배송이 시작 되었습니다.");
			back();
		}
		public function suc()
		{
			extract($_GET);
			$my = DB::fetch("SELECT * FROM insu WHERE i_box = ? AND i_me = ?",[$box,$me]);
			
			DB::execute("UPDATE contract SET c_state = '배송완료' WHERE c_idx = ?",[$my['i_contract']]);
			DB::execute("UPDATE insu SET i_suc = 1 WHERE i_box = ? AND i_me = ?",[$box,$me]);

			if(!DB::fetch("SELECT * FROM insu WHERE i_box = ? AND i_suc = 0",[$box])){
				DB::execute("UPDATE insu SET i_state = '배송완료' WHERE i_box = ?",[$box]);
			}
			location("/manager");

		}
	}