<?php

	namespace app\Controller;
	use app\Core\DB;

	class Delivery
	{
		public function contract()
		{	
			extract($_POST);
			if(trim($weight) == "" || trim($area) == "" || trim($date) == ""){
				$_SESSION['msg'] = "값이 누락 되었습니다.";
				back();
			}
			$no = DB::fetch("SELECT LPAD(count(*)+1,4,'0') as no FROM contract")['no'];
			$ab = date("H") > 12 ? 'B' : 'A';
			$code = date("Ymd-").$ab.date("his-").$no;
			$date = convertDate($date);
			$sql = "INSERT INTO contract SET c_member = ? , c_weight = ? , c_area = ?, c_date = ?, c_rdate = now() , c_code = ?";
			$arr = [isMember()['m_idx'],$weight,$area,$date,$code];
			DB::execute($sql,$arr);
			$_SESSION['msg'] = "신청 되었습니다.";
			back();
		}
		public function addInsu()
		{
			$idxs = explode("-",$_GET['idx']);
			$paths = explode("-",$_GET['path']);

			for($i = 0, $len = count($idxs); $i < $len ; $i++)
			{	
				if(!DB::fetch("SELECT * FROM contract WHERE c_idx = ? AND c_state = '접수대기'",[$idxs[$i]])){
					$_SESSION['msg'] = "이미 인수된 항목입니다.";
					back();
				}
			}

			$sql = "INSERT INTO delivery SET d_contract = ?, d_car = ?, d_path = ?, d_me = ?, d_max = ?,d_dis = ?,d_box = ?";
			$now = date("Y-m-d H:i:s");
			for($i = 0, $len = count($idxs); $i < $len ; $i++)
			{	
				DB::execute("UPDATE contract SET c_state = '배송대기' WHERE c_idx = ?",[$idxs[$i]]);
				$arr = [$idxs[$i],isMember()['m_idx'],$_GET['path'],$i,$_GET['max'],$_GET['dis'],$now];
				DB::execute($sql,$arr);
			}
			$_SESSION['msg'] = "인수되었습니다.";
			back();
		}

		public function start()
		{
			$list = DB::fetchAll("SELECT * FROM delivery WHERE d_box = ?",[$_GET['box']]);
			DB::execute("UPDATE delivery SET d_state = '배송중' WHERE d_box = ?",[$_GET['box']]);
			foreach($list as $value){
				DB::execute("UPDATE contract SET c_state = '배송중' WHERE c_idx = ?",[$value['d_contract']]);
			}
			back();
		}
		public function suc()
		{	
			extract($_GET);
			DB::execute("UPDATE delivery SET d_suc = 1 WHERE d_box = ? AND d_me = ?",[$box,$me]);
			$del = DB::fetch("SELECT * FROM delivery WHERE d_box = ? AND d_me = ?",[$box,$me]);

			DB::execute("UPDATE contract SET c_state = '배송완료' WHERE c_idx = ?",[$del['d_contract']]);
			$allsuc = DB::fetch("SELECT * FROM delivery WHERE d_box = ? AND d_suc = 0",[$box]);
			if(!$allsuc){
				DB::execute("UPDATE delivery SET d_state = '배송완료' WHERE d_box = ?",[$box]);
			}
			back();
		}
	}