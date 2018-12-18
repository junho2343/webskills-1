<?php

	namespace app\Controller;

	use app\Core\DB;


	class Link extends Controller
	{	

		//인덱스 페이지
		public function index()
		{
			$this->view("index",[]);
		}
		//로그인 페이지
		public function login()
		{
			$this->view("login",[]);
		}
		//배송신청 페이지
		public function contract()
		{
			$this->view("contract",[]);
		}
		//배송추적 페이지
		public function delivery()
		{	
			$list;
			//검색을 했을경우
			if(isset($_GET['type'])){
				if($_GET['type'] == "배송번호"){
					$sql = "SELECT * FROM contract c
						LEFT JOIN insu i
						ON c_idx = i_contract
						WHERE c_code = ?
						ORDER BY c_rdate DESC
					";
					$list = DB::fetchAll($sql,[$_GET['search']]);
				}
			}else{ //검색을 안했을경우
				$sql = "SELECT * FROM contract c
						LEFT JOIN insu i
						ON c_idx = i_contract
						WHERE c_member = ?
						ORDER BY c_rdate DESC
				";
				$list = DB::fetchAll($sql,[isMember()['m_idx']]);
			}

			$arr = [];



			foreach ($list as $key => $value) {
				if(isset($value['i_idx'])){
					$now = DB::rowCount("SELECT * FROM insu WHERE i_box = ? AND i_suc = 1",[$value['i_box']]) - 1;
					$path = explode("-",$value['i_path']);
					$mypath = [];
					for($i = 0; $i <= $value['i_me'];$i++){
						$mypath[] = $path[$i];
					}
					$value['now'] = $now >= $value['i_me'] ? $path[$value['i_me']] : "";
					$value['now'] = $now < 0 ? "" : $value['now'];
					$value['myPath'] = join("-",$mypath);
				}
				$arr[] = $value;
			}

			if(isset($_GET['type'])){
				$a = DB::fetch("SELECT * FROM insu WHERE i_contract = ?",[$arr[0]['c_idx']]);
				if($a){
					$n = DB::rowCount("SELECT * FROM insu WHERE i_box = ? AND i_suc = 1",[$a['i_box']])-1;
					
					$p = explode("-",$a['i_path']);

					$now = $n < 0 ? "" : $p[$n];

					$arr[0]['myPath'] = $a['i_path'];
					$arr[0]['now'] = $now;
				}else{
					$arr[0]['i_idx'] = -1;
					$arr[0]['myPath'] = "";
					$arr[0]['now'] = "";
				}
			}

			$this->view("delivery",["list" => $arr]);
		}
		//지입차량주 pos 페이지
		public function manager()
		{	
			$date = isset($_GET['date']) ? cdate($_GET['date']) : ""; 

			$sql = "SELECT * FROM contract c , member m 
					WHERE c_member = m_idx AND c_date = ? AND c_state = '접수대기'
			";

			$list = DB::fetchAll($sql,[$date]);

			$this->max = 0;
			$this->findStack = [];
			$this->dis = json_decode( file_get_contents(_PUBLIC."/distance.json") );
			$this->find(isMember()['m_weight'],$list,[]);
			$this->findStack = array_map("unserialize", array_unique(array_map("serialize", $this->findStack)));

			$arr = [];

			foreach ($this->findStack as $key => $value) {
				$this->min = 999999;
				$this->stack = [];
				$this->minStack = [];
				$this->getPath(0,count($value),$value,0);
				$value['path'] = $this->minStack;
				$value['min'] = $this->min;

				$arr[] = $value;
			}
			usort($arr,function($a,$b){
				return $a['min']-$b['min'];
			});


			$sql = "SELECT * FROM insu i, contract c, member m
					WHERE i_contract = c_idx AND c_member = m_idx AND i_car = ?
					ORDER BY c_date DESC, i_box DESC
			";
			$boxSql = "SELECT count(*) as cnt FROM insu i, contract c 
					   WHERE i_contract = c_idx AND i_car = ?
					   GROUP BY i_box
					   ORDER BY c_date DESC, i_box DESC
			";

			$myList = DB::fetchAll($sql,[isMember()['m_idx']]);
			$boxCount = DB::fetchAll($boxSql,[isMember()['m_idx']]);


			$this->view("manager",["date" => $date,"list" => $arr,"myList" => $myList, "boxCount" => $boxCount]);
		}
		//어드민 pos 페이지
		public function adminpos()
		{	
			$data = json_decode( file_get_contents(_PUBLIC."/distance.json") );
			$this->view("adminpos",["data" => $data]);
		}
		//차량 정보 페이지
		public function truckInfo()
		{	
			extract($_GET);
			$member = DB::fetch("SELECT * FROM member WHERE m_idx = ?",[$car]);
			$insu = DB::fetch("SELECT * FROM insu WHERE i_box = ?",[$box]);
			$n = DB::rowCount("SELECT * FROM insu WHERE i_box = ? AND i_suc = 1",[$box])-1;
			$path = $insu['i_path'];
			$p = explode("-",$insu['i_path']);
			$now = $n < 0 ? "" : $p[$n];
			$this->view("truct-info",["member" => $member,"path" => $path,"now" => $now]);
		}
		//최적의 물류배송 찾기
		public function find($max,$arr,$sel)
		{
			$weight = $this->getWeight($sel);
			$flag = true;

			for ($i=0; $i < count($arr); $i++) { 
				if( ($arr[$i]['c_weight'] + $weight) <= $max ){
					$flag = false;
					$tempArr = $arr;
					$tempSel = $sel;
					$tempSel[] = $arr[$i];

					array_splice($tempArr,$i,1);
					$this->find($max,$tempArr,$tempSel);
				}
			}

			if($flag){
				usort($sel,function($a,$b){
					return $a['c_idx'] - $b['c_idx'];
				});

				if($this->max < $weight){
					$this->max = $weight;
					$this->findStack = [$sel];
				}else if($this->max == $weight){
					$this->findStack[] = $sel;
				}

			}
		}
		//최단경로 찾기
		public function getPath($level, $max , $arr , $dis){
			if($this->min < $dis) return;

			if($level == $max){
				if($this->min > $dis){
					$this->min = $dis;
					$this->minStack = [$this->stack];
				}else if($this->min == $dis){
					$this->minStack[] = $this->stack;
				}
			}

			for ($i=0; $i < count($arr); $i++) { 
				$this->stack[$level] = $arr[$i];
				$tempArr = $arr;
				array_splice($tempArr, $i,1);
				$tempDis = 0;

				if($level != 0){
					$tempDis = $dis + $this->dis->{$this->stack[$level]['c_area']}->{$this->stack[$level-1]['c_area']};
				}
				$this->getPath($level+1,$max,$tempArr,$tempDis);
			}

		}

		//무게 구하기
		public function getWeight($arr)
		{
			$sum = 0;
			foreach($arr as $value){
				$sum += $value['c_weight'];
			}
			return $sum;
		}
	}