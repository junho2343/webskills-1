<?php

	use app\Core\Router;

	Router::get("/","Link@index");

	Router::post("/saveJson","Member@saveJson"); //json data 저장
	Router::post("/addContract","Contract@addContract"); //물류배송 신청
	Router::get("/addInsu","Contract@addInsu"); //인수
	Router::get("/start","Contract@start"); //배송시작
	Router::get("/truck-info","Link@truckInfo"); //차량정보
	Router::get("/suc","Contract@suc"); //차량정보

	if(isMember()){ //회원 권한
		Router::get("/logout","Member@logout");		
		switch (isMember()['m_grade']) {
			case '고객사': //고객사 권한
				Router::get("/contract","Link@contract");	//물류배송 신청 페이지	
				Router::get("/delivery","Link@delivery");	//물류배송 추적 페이지
				break;
			case '지입차량주': //지입차량주 권한
				Router::get("/manager","Link@manager");	//지입차량주 pos 페이지
				break;
			case '관리자': //관리자 권한
				Router::get("/adminpos","Link@adminpos");	//지입차량주 pos 페이지
				break;
		}

	}else{ //비회원 권한
		Router::get("/login","Link@login"); //로그인 페이지
		Router::get("/delivery","Link@delivery"); //물류배송 추적 페이지
		Router::post("/login","Member@login");
	}