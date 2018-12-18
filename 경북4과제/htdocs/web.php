<?php

	use app\Core\Router;


	Router::get("/","Link@index"); //인덱스 페이지

	if(isMember()){
		Router::get("/logout","Member@logout");

		switch (isMember()['m_grade']) {
			case '관리자':
				Router::get("/adminpos","Link@adminpos"); //관리자 pos 페이지
				break;
			case '고객사':
				Router::get("/contract","Link@contract"); //물류배송신청 페이지
				Router::get("/truct-info","Link@tructInfo");//차량정보 페이지
				Router::get("/delivery","Link@delivery"); //물류 배송추적 페이지
				
				Router::post("/contract","Delivery@contract"); //물류배송신청 페이지
				break;
			case '지입차량주':
				Router::get("/manager","Link@manager"); //지입차량주 pos 페이지

				Router::get("/addInsu","Delivery@addInsu"); //인수하기
				Router::get("/start","Delivery@start"); //인수하기
				Router::get("/suc","Delivery@suc"); //인수하기
				break;
		}

	}else{
		Router::get("/login","Link@login");//로그인 페이지
		Router::get("/join","Link@join"); //회원가입 페이지
		Router::post("/login","Member@login");
		Router::post("/join","Member@join");
		Router::get("/delivery","Link@delivery"); //물류 배송추적 페이지
	}
	
	


	
	

	