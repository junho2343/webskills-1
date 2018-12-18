<?php

	namespace app\Controller;

	use app\Core\DB;


	class Link extends Controller
	{
		public function index() //인덱스
		{	
			
			$this->view("index",["title" => "index"]);
		}

		public function login() //로그인
		{
			$this->view("login", ["title" => "login"]);
		}

		public function join() //회원가입
		{	
			$this->view("join", ["title" => "join"]);

		}

		public function my() //내 정보변경
		{
			$this->view("my", ["title" => "my"]);
		}

		public function order() //주문하기
		{	
			$type = isset($_GET['type']) ? $_GET['type'] : "";
			$order = isset($_GET['order']) ? $_GET['order'] : "";
			$search = isset($_GET['search']) ? $_GET['search'] : "";
			$where = "";
			
			$arr = [];
		

			if($type != ""){
				$where .= " AND s_type = '{$type}'";
			}

			if($search != ""){
				$search = str_replace("\\", "\\\\",$search);
				$arr = ["%{$search}%"]; 
				$where .= " AND s_name LIKE ?";
			}

			$sql = "SELECT * FROM shop s, menu me, member m
					WHERE s_idx = me_shop AND s_member = m_idx {$where}
					GROUP BY me_shop
					HAVING count(me_idx) > 0
			";

			
			$list = DB::fetchAll($sql,$arr);
			$arr = [];

			foreach($list as $value){
				$star = DB::fetch("SELECT AVG(r_cnt) as star FROM review WHERE r_shop = ?",[$value['s_idx']])['star']; 
				$value['star'] = number_format(round($star));
				$value['review'] = number_format(DB::rowCount("SELECT * FROM review WHERE r_shop = ?",[$value['s_idx']]));
				$value['dis'] = sqrt(pow( isMember()['m_x']-$value['m_x'] ,2) + pow( isMember()['m_y']-$value['m_y'] ,2));
				array_push($arr,$value);
			}

			$order2 = $order == "star" ? "review" : "star";

			if($order != "" && $order != "dis"){
				usort($arr, function($a,$b) use ($order,$order2) {
					if($a[$order] == $b[$order])
						return $b[$order2] - $a[$order2];
					return $b[$order] - $a[$order];
				});
			}

			if($order == "dis"){
				usort($arr, function($a,$b){
					return $a['dis'] - $b['dis'];
				});
			}

			GD($arr);

			$this->view("order", ["title" => "order","list" => $arr,"type" => $type, "order" => $order]);
		}

		public function det() //주문내역
		{	
			$member = isMember()['m_idx'];
			if(isMember()['m_grade'] == "관리자")
				$member = isset($_GET['member']) ? $_GET['member'] : "";

			$sql = "SELECT * FROM orderlist o, menu me, shop s
					WHERE o_menu = me_idx AND o_shop = s_idx AND o_member = ?
					ORDER BY o_date DESC,o_box DESC,o_shop DESC
			";
			$list = DB::fetchAll($sql,[$member]);
			$memberList = DB::fetchAll("SELECT * FROM member WHERE m_grade = '일반회원'");
			$dateCount = DB::fetchAll("SELECT COUNT(*) as cnt FROM orderlist WHERE o_member = ? GROUP BY o_date ORDER BY o_date DESC,o_box DESC,o_shop DESC",[$member]);
			$boxCount = DB::fetchAll("SELECT COUNT(*) as cnt,SUM(me_price * o_count) as sum FROM orderlist o ,menu m  WHERE o_menu = me_idx AND o_member = ? GROUP BY o_box ORDER BY o_date DESC,o_box DESC,o_shop DESC",[$member]);
			$shopCount = DB::fetchAll("SELECT COUNT(*) as cnt FROM orderlist WHERE o_member = ? GROUP BY o_box,o_shop ORDER BY o_date DESC,o_box DESC,o_shop DESC",[$member]);

			$this->view("det", ["title" => "det","list" => $list,"dateCount" => $dateCount, "boxCount" => $boxCount, "shopCount" => $shopCount,"memberList" => $memberList,"member" => $member]);
		}

		public function aff() //가맹회원
		{	
			$member = isMember()['m_idx'];

			if(isMember()['m_grade'] == "관리자")
				$member = isset($_GET['member']) ? $_GET['member'] : "";

			$shop = DB::fetch("SELECT * FROM shop WHERE s_member = ?",[$member]);
			$shopList = DB::fetchAll("SELECT * FROM shop");
			$menu = [];
			$rank = [];
			$boxCount = [];
			$order = [];

			$rank = DB::fetchAll("SELECT *,SUM(o_count) as cnt FROM menu m, orderlist o WHERE me_idx = o_menu GROUP BY o_menu LIMIT 5");
			
			if($shop){
				$menu = DB::fetchAll("SELECT * FROM menu WHERE me_shop = ?",[$shop['s_idx']]);
				$boxCount = DB::fetchAll("SELECT count(*) as cnt, sum(me_price * o_count) as sum FROM orderlist o, menu m WHERE o_shop = ? AND o_menu = me_idx GROUP BY o_box ORDER BY o_box DESC",[$shop['s_idx']]);
				$order = DB::fetchAll("SELECT * FROM orderlist o, menu m WHERE o_shop = ? AND o_menu = me_idx ORDER BY o_box DESC",[$shop['s_idx']]);				
			}

			$this->view("aff", ["title" => "aff","shop" => $shop, "menu" => $menu, "rank" => $rank, "boxCount" => $boxCount , "order" => $order,"shopList" => $shopList,"member" => $member]);
		}


		public function menu() //메뉴
		{	
			$shop = DB::fetch("SELECT * FROM shop WHERE s_idx = ?",[$_GET['idx']]);
			$review = DB::rowCount("SELECT * FROM review WHERE r_shop = ?",[$_GET['idx']]);
			$orderBox = DB::fetchAll("SELECT * FROM orderbox o, menu me WHERE ob_menu = me_idx AND ob_member = ?",[isMember()['m_idx']]);
			$menu = DB::fetchAll("SELECT * FROM menu WHERE me_shop = ?",[$_GET['idx']]);

			$this->view("menu",["shop" => $shop, "review" => $review, "orderBox" => $orderBox, "menu" => $menu]);
		} 

		public function detReview()
		{	
			extract($_GET);
			$review = DB::fetch("SELECT * FROM review WHERE r_box = ? AND r_shop = ? AND r_member = ?",[$box, $shop,isMember()['m_idx']]);

			if($review){
				alert("이미 리뷰를 작성하셨습니다.");
				location("/det");
			}

			$this->view("detReview",[]);
		}
		
		public function review()
		{	
			extract($_GET);
			$name = DB::fetch("SELECT * FROM shop WHERE s_idx = ?",[$shop])['s_name'];

			$sql = "SELECT * FROM review r, member m WHERE r_member = m_idx AND r_shop = ?";
			$list = DB::fetchAll($sql,[$shop]);

			$this->view("review",["name" => $name,"list" => $list]);
		}	
	}