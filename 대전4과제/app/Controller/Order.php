<?php

	namespace app\Controller;

	use app\Core\DB;


	class Order
	{	
		
		public function addOrderBox()
		{
			extract($_GET);
			$sql = "INSERT INTO orderbox SET ob_member = ?, ob_menu = ?, ob_count = ?, ob_shop = ?";
			$arr = [isMember()['m_idx'], $menu, $count, $shop];
			DB::execute($sql,$arr);
			alert("주문함이 추가되었습니다.");
			back();
		}

		public function clearOrderBox()
		{
			DB::execute("DELETE FROM orderbox WHERE ob_member = ?",[isMember()['m_idx']]);
			back();
		}
		
		public function deleteOrderBox()
		{
			DB::execute("DELETE FROM orderbox WHERE ob_idx = ?",[$_GET['idx']]);
			alert("주문이 삭제 되었습니다.");
			back();
		}

		public function addOrderList()
		{	
			extract($_POST);
			$box = Date("Y-m-d H:i:s");
			$sql = "INSERT INTO orderlist SET o_member = ?, o_shop = ?, o_menu = ?, o_count = ?, o_date = now(), o_box = ?";

			for ($i=0; $i < count($menu); $i++) { 
				$arr = [isMember()['m_idx'], $shop[$i], $menu[$i], $count[$i], $box];
				DB::execute($sql,$arr);				
			}

			$this->clearOrderBox();

			alert("결제 되었습니다.");
			back();

		}

		public function delivery()
		{	
			extract($_GET);
			DB::execute("UPDATE orderlist SET o_state = '배송완료' WHERE o_box = ? AND o_shop = ? ",[$box,$shop]);
			back();
		}

		public function addReview()
		{
			extract($_POST);
			extract($_GET);

			if(trim($count) == "" || trim($content) == ""){
				alert("누락된 값이 있습니다.");
				back();
			}

			$sql = "INSERT INTO review SET r_shop = ?, r_member = ?, r_box = ?, r_cnt = ?, r_content = ?, r_date = now()";
			$arr = [$shop,isMember()['m_idx'],$box,$count,$content];
			DB::execute($sql,$arr);
			alert("작성되었습니다.");
			location("/det");
		}
	}