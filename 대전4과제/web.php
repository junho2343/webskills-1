<?php

	use app\Core\Router;


	if(isMember()){

		switch (isMember()['m_grade']) {
			case '관리자':
				Router::get("/det","Link@det"); // 주문내역
				Router::get("/aff","Link@aff"); //가맹회원
				break;
			case '가맹회원':
				Router::get("/my","Link@my"); // 내 정보변경
				Router::get("/aff","Link@aff"); //가맹회원
				break;
			case '일반회원':
					Router::get("/my","Link@my"); // 내 정보변경
					Router::get("/order","Link@order"); // 주문하기
					Router::get("/det","Link@det"); // 주문내역
				break;
			default:
				# code...
				break;
		}

	}else{
		Router::get("/join","Link@join"); // 회원가입
		Router::get("/login","Link@login"); // 로그인

		Router::post("/join","Member@join"); // 회원가입
		Router::post("/login","Member@login"); // 로그인
	}

	Router::get("/","Link@index"); //인덱스

	
	
	Router::get("/detReview","Link@detReview"); // 리뷰작성
	Router::get("/menu","Link@menu"); // 메뉴목록

	
	Router::get("/review","Link@review"); // 리뷰보기

	Router::get("/logout","Member@logout"); // 로그아웃

	Router::get("/deleteMenu","Shop@deleteMenu"); // 메뉴삭제
	Router::get("/addOrderBox","Order@addOrderBox"); // 주문함담기

	Router::get("/clearOrderBox","Order@clearOrderBox"); // 주문함비우기
	Router::get("/deleteOrderBox","Order@deleteOrderBox"); // 주문함삭제
	Router::post("/addOrderList","Order@addOrderList"); // 결제하기

	Router::get("/delivery","Order@delivery"); // 배송완료
	
	Router::post("/addShop","Shop@addShop"); // 가맹점등록
	Router::post("/addMenu","Shop@addMenu"); // 메뉴등록

	Router::post("/update","Member@update"); // 회원수정
	Router::post("/addReview","Order@addReview"); // 리뷰작성



