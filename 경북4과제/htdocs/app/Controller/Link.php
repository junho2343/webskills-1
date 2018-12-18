<?php

	namespace app\Controller;
	use app\Core\DB;

	class Link extends Controller
	{
		public function index()
		{
			$this->view("index",[]);
		}

		public function adminpos()
		{	
			$data = json_decode( file_get_contents(_PUBLIC."/distance.json") );

			$this->view("adminpos",["data" => $data]);
		}

		public function contract()
		{
			$this->view("contract",[]);
		}

		public function delivery()
		{	

			$sql = "SELECT * FROM contract c
					LEFT JOIN delivery d
					ON c_idx = d_contract
					WHERE c_member = ?
			";
			$list = DB::fetchAll($sql,[isMember()['m_idx']]);
			$arr = [];
			foreach($list as $value){
				echo "<br>";
				if(isset($value['d_idx'])){
					$now = DB::fetch("SELECT COUNT(*) as cnt FROM delivery WHERE d_box = ? AND d_suc = 1",[$value['d_box']])['cnt'];
					$path = explode("-",$value['d_path']);
					$temp = [];
					if($now > 0){
						$len = $value['d_suc'] == 1 ? $value['d_me'] : $now;
						for ($i=0; $i <= $len; $i++) { 
							array_push($temp,$path[$i]);
						}
					}
					$value['path'] = join("-",$temp);
					$value['now'] = $now > 0 ? $path[$now-1] : "";
				}

				array_push($arr,$value);
			}
			$this->view("delivery",["list" => $arr]);
		}

		public function manager()
		{	
			$date = isset($_GET['date']) ? convertDate($_GET['date']) : "";
			$sql = "SELECT * FROM contract c, member m
					WHERE c_member = m_idx AND c_date = ? AND c_state = '접수대기'
			";
			$list = DB::fetchAll($sql,[$date]);
			$this->findMax = 0;
			$this->findStack = [];
			$this->dis = json_decode( file_get_contents(_PUBLIC."/distance.json") );
			$this->find(isMember()['m_weight'],$list,[]);
			$this->findStack = array_map("unserialize",array_unique(array_map("serialize",$this->findStack)));

			$boxCount = DB::fetchAll("SELECT COUNT(*) as cnt, d_state as state FROM delivery d,contract c
			 WHERE d_contract = c_idx AND d_car = ? 
			 GROUP BY d_box 
			 ORDER BY c_date DESC, d_box DESC",
			 [isMember()['m_idx']]);

			$sql = "SELECT * FROM delivery d,contract c, member m
					WHERE d_contract = c_idx AND c_member = m_idx AND d_car = ?
					ORDER BY c_date DESC, d_box DESC";
			$list = DB::fetchAll($sql,[isMember()['m_idx']]);

			$this->view("manager",["find" => $this->findStack,"list" => $list, "boxCount" => $boxCount]);
		}

		public function tructInfo()
		{	
			$car = DB::fetch("SELECT * FROM member WHERE m_idx = ?",[$_GET['car']]);

			$this->view("truck-info",["car" => $car]);
		}

		public function login()
		{
			$this->view("login",[]);
		}

		public function join()
		{
			$this->view("join",[]);
		}

		public function find($max,$arr,$sel)
		{
			$weight = $this->getWeight($sel);
			$flag = true;

			for ($i=0; $i < count($arr); $i++) { 
				if(($arr[$i]['c_weight'] + $weight) <= $max){
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
				if($this->findMax < $weight){
					$this->findMax = $weight;
					$this->findStack = [$sel];
				}else if($this->findMax == $weight){
					$this->findStack = array_map("unserialize",array_unique(array_map("serialize",$this->findStack)));
					$this->findStack[] = $sel;
					$this->findStack = array_map("unserialize",array_unique(array_map("serialize",$this->findStack)));
				}
			}
		}

		public function getPath($level,$max,$arr,$dis){
			if($this->min < $dis) return;

			if($level == $max){
				if($this->min > $dis){
					$this->min = $dis;
					$this->minStack = [$this->path];
				}else if($this->min == $dis){
					$this->minStack[] = $this->path;
				}
			}

			for ($i=0; $i < count($arr); $i++) { 
				$this->path[$level] = $arr[$i];
				$tempArr = $arr;
				$tempDis = 0;
				array_splice($tempArr,$i,1);
				if($level != 0){
					$tempDis = $dis + $this->dis->{$this->path[$level-1]['c_area']}->{$this->path[$level]['c_area']};
				}
				$this->getPath($level+1,$max,$tempArr,$tempDis);
			}

		}

		public function getWeight($arr)
		{
			$sum = 0;
			foreach ($arr as $value) {
				$sum += $value['c_weight'];
			}
			return $sum;
		}

	}