<?php

	namespace app\Controller;

	use app\Core\DB;

	class Controller
	{
		public function view($page,$data)
		{
			extract($data);

			//데이터 저장
			if(!DB::fetch("SELECT * FROM member")){
				DB::execute("INSERT INTO member SET m_id = ?, m_pw = ?, m_name = ?, m_weight = ?, m_phone = ?,m_grade = ?",['user1','1234','고객사1',0,'000-0000-0001','고객사']);
				DB::execute("INSERT INTO member SET m_id = ?, m_pw = ?, m_name = ?, m_weight = ?, m_phone = ?,m_grade = ?",['user2','1234','고객사2',0,'000-0000-0002','고객사']);
				DB::execute("INSERT INTO member SET m_id = ?, m_pw = ?, m_name = ?, m_weight = ?, m_phone = ?,m_grade = ?",['user3','1234','고객사3',0,'000-0000-0003','고객사']);

				DB::execute("INSERT INTO member SET m_id = ?, m_pw = ?, m_name = ?, m_weight = ?, m_phone = ?,m_grade = ?",['zip1','1234','지입차량주1',1,'001-0000-0001','지입차량주']);
				DB::execute("INSERT INTO member SET m_id = ?, m_pw = ?, m_name = ?, m_weight = ?, m_phone = ?,m_grade = ?",['zip2','1234','지입차량주2',4,'001-0000-0002','지입차량주']);
				DB::execute("INSERT INTO member SET m_id = ?, m_pw = ?, m_name = ?, m_weight = ?, m_phone = ?,m_grade = ?",['zip3','1234','지입차량주3',8,'001-0000-0003','지입차량주']);
				DB::execute("INSERT INTO member SET m_id = ?, m_pw = ?, m_name = ?, m_weight = ?, m_phone = ?,m_grade = ?",['zip4','1234','지입차량주4',15,'001-0000-0004','지입차량주']);
				DB::execute("INSERT INTO member SET m_id = ?, m_pw = ?, m_name = ?, m_weight = ?, m_phone = ?,m_grade = ?",['zip5','1234','지입차량주5',24,'001-0000-0005','지입차량주']);

				DB::execute("INSERT INTO member SET m_id = ?, m_pw = ?, m_grade = ? ",['admin','1234','관리자']);
			}

			require _VIEW."/header.php";
			require _VIEW."/{$page}.php";
		}
	}