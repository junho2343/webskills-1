function App(){

	let app;

	let DB;

	let Ani;

	let Img;

	let Drop;

	const doc = $(document);

	const win = $(window);

	let CT = []; //contents top & height

	let imgArr = [];

	function _App(){
		this.init = () => { //init 
			return this
			.setStyle()
			.setElement()
			.setVal()
			.setEvent()
		}
		this.setStyle = () => { //style setting
			const html = 
			`
				<style>
					.navbar li:hover a{color:#ff4e00 !important}
					#about .media-heading-wrapper .fa,
					header .social-icon li a,
					.social-icon li a,
					#service .fa{transition:.5s}
					
					#home .btn{transition:0s}
	

					.social-icon li a:hover{background-color:rgb(40, 167, 233);}
					
					header .social-icon li a:hover{background-color:rgb(40, 167, 233);}
					
					#home .btn:hover{background-color:rgb(40, 167, 233);}
					
					#service .fa:hover{background-color:rgb(40, 167, 233);}

					#about .media-heading-wrapper .fa:hover{background-color:rgb(40, 167, 233);margin-top:100%;animation:hover 1.5s infinite;}

					#portfolio .portfolio-thumb:hover .portfolio-overlay{opacity:1;background-color:rgba(40, 167, 233,0.5)}
					#team .team-wrapper:hover{opacity:0.4}
					.sani{visibility:visible;opacity:1 !important;transition:1.5s !important;transform:inherit}
					.ain.sani{visibility:visible;opacity:1;transition:1.5s;transform:inherit}
					.aup.sani{visibility:visible;opacity:1;transition:1.5s;transform:inherit}
					.aleft.sani{visibility:visible;opacity:1;transition:1.5s;transform:inherit}
					.aright.sani{visibility:visible;opacity:1;transition:1.5s;transform:inherit}

					#service .col-md-4:hover{background-color:#505050}

					.sunani{visibility:hidden;opacity:0;}
					
					.abounce{animation:bounce 1s;}
					.ain{opacity:0}
					.aup{transform:translateY(100px);opacity:0;}
					.aleft{transform:translateX(-100px);opacity:0}
					.aright{transform:translateX(100px);opacity:0}

					
					@keyframes bounce{
					 	0%{transform:scale(0.8);opacity:0;visibility:hidden}
					 	25%{transform:scale(1.2);opacity:1;visibility:visible}
					 	75%{transform:scale(0.9);opacity:1;visibility:visible}
					 	100%{transform:scale(1);opacity:1;visibility:visible}
					}
					@keyframes hover{
						0%{margin-top:0}
						50%{margin-top:100%}
						100%{margin-top:0}
					}

				</style>
			`;
			$("head").append(html);
			return this;
		}
		this.setElement = () => { //element setting
			$("#message").css({"resize":"vertical"});
			this.setLoading();
			this.loginDisplay();
			return this;
		}
		this.setVal = () => { //val setting
			Ani = new _Animation();
			Img = new _Img();
			DB = new _DB();
			Drop = new _Drop();
			DB.init();

			return this;
		}
		this.setEvent = () => { //event setting
			doc
			.on("selectstart dragstart drop dragover",()=>{event.preventDefault()})
			.on("scroll",Ani.scroll)
			.on("click",".gallery-remove",Img.remove)
			.on("click",".navbar li",Ani.clickNav)
			.on("click",".logout-btn",this.logout)
			.on("click",".prev, .next",Img.paging)
			.on("click","#portfolio .col-md-3",Img.show)
			.on("click",".close-btn",Img.hide)
			.on("click",".login-btn",() => {$("#login-modal").fadeIn(500)})
			.on("click","#login-modal .modal-footer .btn-success",this.login)
			.on("dblclick","#message",this.setAreaHeight)
			.on("submit","form",this.sendMessage)
			.on("drop",".gallery-area",Drop.drop)
			return this;
		}
		this.setCT = () => { //content top setting
			CT = [
				{top:0 ,height: $("#about").offset().top-1},
				{top:$("#about").offset().top ,height: $("#about").offset().top + $("#about").height()},
				{top:$("#team").offset().top ,height: $("#team").offset().top + $("#team").height()},
				{top:$("#service").offset().top ,height: $("#service").offset().top + $("#service").height()},
				{top:$("#portfolio").offset().top ,height: $("#portfolio").offset().top + $("#portfolio").height()},
				{top:$("#contact").offset().top ,height: $("#contact").offset().top + $("#contact").height()}
			]
		}

		this.login = () => { //login
			let id = $("#userid").val();
			let pw = $("#pw").val();

			if(id == "admin" && pw == "1234"){
				localStorage.member = 1;
				$("#userid").val("");
				$("#pw").val("");
				$("#login-modal").hide();
			}else{
				alert("아이디 또는 비밀번호가 틀립니다.");
				return;		
			}
			this.loginDisplay();
		}

		this.logout = () => { //logout
			localStorage.member = 0;
			this.loginDisplay();
		}

		this.loginDisplay = () => { //login btn & logout btn display 
			localStorage.member = localStorage.member != null ? localStorage.member : 0; 
			if(localStorage.member == 0){
				$(".login-btn").show();
				$(".join-btn").show();
				$(".logout-btn").hide();
			}else{
				$(".login-btn").hide();
				$(".join-btn").hide();
				$(".logout-btn").show();
			}
		}

		this.setAreaHeight = () => { //textarea height 
			let target = $(event.target);
			let text = target.val();
			let len = text.split("\n").length;

			if(text == ""){
				target.attr("rows",5);
			}else{
				target.attr("rows",len);
			}
		}

		this.sendMessage = () => { //send message
			event.preventDefault();
			let id = $("#fullname");
			let email = $("#email");
			let msg = $("#message");

			if(id.val() == "" || email.val() == "" || msg.val() == "" ){
				alert("빈값이 있습니다.");
			}else{
				id.val("");
				email.val("");
				msg.val("");
				$("html,body").animate({"scrollTop" : 0});
				alert("메시지가 전송되었습니다.");
			}

		}

		this.setLoading = () => { // preloader prepend
			let html = 
			`
				<div class="preloader">
					<div class="sk-spinner-wave sk-spinner">
						<div class="sk-rect1"></div>
						<div class="sk-rect2"></div>
						<div class="sk-rect3"></div>
						<div class="sk-rect4"></div>
						<div class="sk-rect5"></div>
					</div>
				</div>
			`;
			$("body").prepend(html);
		}
	}

	function _Drop(){ //Image drop
		this.drop = () => {
			if(localStorage.member == 0){
				alert("관리자만 업로드 가능합니다.");
				return;
			}
			let file = event.dataTransfer.files[0];
			let fs = new FileReader();
			fs.onload = async () => {
				let img = new Image();
				let data = {
					img : fs.result
				}
				DB.add(data);
				await DB.readAll();
				Img.slide();
			}
			fs.readAsDataURL(file);
		}
	}

	function _Img(){

		this.nowPage = 0;
		this.maxPage = 0;
		this.cnt = 0;
		this.interval;

		this.init = (data) => {
			$("#portfolio .col-md-3").remove();
			$(".now-img").empty();
			$(".img-list ul").empty();
			this.setList();
			this.setPopup();
			Ani.init();
		}

		this.setList = () => {
			for (let i = 0; i < 8; i++) {
				let html = "";
				if(!imgArr[i]){
					html = this.getListForm();
				}else{
					html = this.getListForm(imgArr[i]);
				}
				$("#portfolio .row").append(html);
			} //gallery list append
		}

		this.setPopup = () => {
			this.maxPage = Math.ceil(imgArr.length / 8);
			this.nowPage = imgArr.length > 0 ? 1 : 0;
			let cnt = 1;
			$(".now").text(this.nowPage);
			$(".all").text(this.maxPage);
			imgArr.forEach(x => {
				let box = Math.ceil(cnt / 8);
				$(".img-list ul").append(this.getPopupListForm(x,box));
				$(".now-img").append(this.getPopupImgForm(x,box));
				cnt++;
			})
			$(`.plist`).hide();
			$(".now-img img").hide();
			$(`*[data-box=${this.nowPage}]`).show(); //popup setting
		}

		this.paging = async function() {
			let flag = $(this).hasClass("prev"); // prev == true

			if(flag){
				Img.nowPage--;
				if(Img.nowPage < 1){
					alert("이전 페이지가 없습니다.")
					Img.nowPage++;
					return;
				}else{
					await Img.showPopup();
				}
			}else{
				Img.nowPage++;
				if(Img.nowPage > Img.maxPage){
					alert("다음 페이지가 없습니다.")
					Img.nowPage--;
					return;
				}else{
					await Img.showPopup();
				}
			} //popup paging
		}

		this.slide = () => { //slide
			clearTimeout(this.interval);
			let listTarget = $(`.plist[data-box=${this.nowPage}]`);
			let mainTarget = $(`img[data-box=${this.nowPage}]`);
			let len = listTarget.length;
			let cnt = this.cnt;

			mainTarget.eq(cnt).siblings().hide();
			mainTarget.eq(cnt).show();
			listTarget.eq(cnt).siblings().css({"border":"none"});
			listTarget.eq(cnt).css({"border":"1px solid red"});

			const start = () => {
				if(cnt >= len) cnt = 0;
				mainTarget.eq(cnt).siblings().fadeOut();
				mainTarget.eq(cnt).fadeIn();
				listTarget.eq(cnt).siblings().css({"border":"none"});
				listTarget.eq(cnt).css({"border":"1px solid red"});
				cnt++;
				this.interval = setTimeout(start,3000);	
			}
			start();
		}

		this.showPopup = () => { //paging 이후 팝업 세팅
			return new Promise((res,rej) => {
				this.cnt = 0;
				$(".now").text(this.nowPage);
				$(".all").text(this.maxPage);
				$(`.plist`).hide();
				$(".now-img img").hide();
				$(`*[data-box=${this.nowPage}]`).show();
				this.slide();
				res(true);
			})
		}
		this.show = function () { //선택한 이미지 팝업
			Img.cnt = $(this).index(".glist") == -1 ? 0 : $(this).index(".glist");
			$(".gallery-area").show();
			Img.slide();
		}
		this.hide = () => {
			$(".gallery-area").hide();
			clearTimeout(this.interval);
		}
		this.remove = function() {
			let id = $(this).data("id") * 1;
			DB.delete(id);
			DB.readAll(); //삭제
		}

		this.getPopupImgForm = (data,box) => {
			let html = `<img src="${data.img}" alt="pt1" data-box=${box}>`;
			return html;
		}

		this.getPopupListForm = (data,box) => {
			let x = "";

			if(localStorage.member != 0){
				x = `<span class="gallery-remove" data-id="${data.id}">x</span>`;
			}

			let html = 
			`
				<li class="plist" data-box="${box}">
                    <img src="${data.img}" alt="pt1">
					${x}
                </li>
			`;
			return html;
		}

		this.getListForm = (data = false) =>{
			let html = "";
			if(data){
				html = 
				`
					<div class="col-md-3 col-sm-6 col-xs-12 wow fadeIn glist" data-wow-offset="50" data-wow-delay="0.6s">
	                    <div class="portfolio-thumb">
	                       <img src="${data.img}" class="img-responsive" alt="portfolio img 2">
	                            <div class="portfolio-overlay">
	                                <h4>CITYTOUR Eight</h4>
	                                <p>시민과 함께하는 해양 관광 휴양도시, 아름다운 여수의 밤바다와 힐링이 있는 그 곳. 오늘 여수는 당신에게 주는 선물입니다.</p>
	                                <a href="#" class="btn btn-default">DETAIL</a>
	                            </div>
	                    </div>
	                </div>
				`;
			}else{
				html = 
				`
					<div class="col-md-3 col-sm-6 col-xs-12 wow fadeIn no-image" data-wow-offset="50" data-wow-delay="0.6s">
	                    <div class="portfolio-thumb">
	                       <h4>No Image</h4>
	                            <div class="portfolio-overlay">
	                            </div>
	                    </div>
	                </div>
				`;
			}
			return html;
		}
	}

	//animation 
	function _Animation(){
		this.init =  () => {
			this.setAnimation();
			this.text();
			this.scroll();
		}

		this.scroll = () =>{ //스크롤 이벤트
			let st = win.scrollTop();
			if(st <= 0){
				$(".navbar").css({"position":"static"});
				app.setCT();
			}else{
				$(".navbar").css({"position":"fixed","top" : "0"});
				app.setCT();
			}
			this.startAnimation(st);
			this.navColor(st);
		}
		
		this.navColor = (st) => { //set nav color
			$(".navbar li a").css({"color":"#777"});
			if(CT[0].top <= st && CT[0].height >= st){
				$(".navbar li:eq(0) a").css({"color" : "rgb(40,167,233)"});
			}else if(CT[1].top <= st && CT[1].height >= st){
				$(".navbar li:eq(1) a").css({"color" : "rgb(40,167,233)"});
			}else if(CT[2].top <= st && CT[2].height >= st){
				$(".navbar li:eq(2) a").css({"color" : "rgb(40,167,233)"});
			}else if(CT[3].top <= st && CT[3].height >= st){
				$(".navbar li:eq(3) a").css({"color" : "rgb(40,167,233)"});
			}else if(CT[4].top <= st && CT[4].height >= st){
				$(".navbar li:eq(4) a").css({"color" : "rgb(40,167,233)"});
			}else if(CT[5].top <= st && CT[5].height >= st){
				$(".navbar li:eq(5) a").css({"color" : "rgb(40,167,233)"});
			}
		}
		
		this.clickNav = function() { //section scrollTop
			event.preventDefault();
			let target = CT[$(this).index()].top
			if(win.scrollTop() <= 0) target-=70;
			$("html, body").animate({scrollTop : target});
		}

		this.startAnimation = (st) => { //element event start
			let h = st+win.height();

			$(".wow").each(function(){
				let target = $(this);
				let top = $(this).offset().top;
				let th = top+target.height();

				if((st <= top && h >= top) || (st <= th && h >= th)){
					let delay = target.data("wow-delay");
					let idelay = delay.split("s")[0] * 1000;
					target.removeClass("wow sunani");

					setTimeout(()=>{
						if(target.hasClass("bounceIn")){
							target.addClass("abounce");
						}
						target.addClass("sani");
					},idelay)
				}

			})

		}

		this.setAnimation = () => { //animation class setting
			$(".wow").each(function(){
				let target = $(this);
				target.addClass("sunani");
				if(target.hasClass("bounceIn")){
					target.css({"opacity":"0"});
				}else if(target.hasClass("fadeIn")){
					target.addClass("ain");
				}else if(target.hasClass("fadeInUp")){
					target.addClass("aup");
				}else if(target.hasClass("fadeInLeft")){
					target.addClass("aleft");
				}else if(target.hasClass("fadeInRight")){
					target.addClass("aright");
				}
			})
		}

		this.text = () => { //text animation
			let textData = []; //텍스트를 저장할 배열
			let i = 0; //문장
			let j = 0;// 글자 1글자 단위
			let max = 0;//문장의 길이
			let text = "";//화면에 보일 텍스트
			let flag = true;//문장을 처음 시작할때 true

			//.sub-element 긇어와서 배열에 저장
			$(".sub-element").each(function(){
				let target = $(this);
				let text = target.text();
				let len = text.length;
				textData.push({text : text, len : len}); 
			})
			//sub-element 숨김
			$(".sub-element").hide();
			//text-animation 보일 div append
			$(".element").append("<div class='view-element'></div>");
			
			//실행
			const start = () => {
				if(flag)
					max = textData[i].len; //문장의 길이 저장

				if(j >= max){ //문장을 모두 출력하면 뒤부터 잘라버림
					max--;
					text = text.slice(0,-1);
					if(max <= 0){i++;j=0;flag = true;} //max가 0이 되면 다음 문장 출력
					if(i >= textData.length) i = 0; //마지막 문장이라면 첫번째 문장으로
				}else{ //1글자씩 텍스트 추가
					flag = false;
					text += textData[i].text[j];
					j++;
				}
				$(".view-element").text(text);
				setTimeout(start,50);
			}
			setTimeout(start,100);
		}
	}
	//DB
	function _DB(){
		const dbname = "db20180906";

		let db;

		this.init = () => {
			let req = window.indexedDB.open(dbname);
			req.onsuccess = async () => {
				db = req.result;
				await this.readAll();
				
			}

			req.onupgradeneeded = () => {
				let rs = req.result;
				rs.createObjectStore("img",{keyPath:"id",autoIncrement:true});
			}
		}

		this.add = (data) => {
			this.getStore().add(data);
		}

		this.delete = (id) => {
			this.getStore().delete(id);
		}

		this.readAll = () => {
			return new Promise((res,rej) => {
				let data = [];
				this.getStore().openCursor().onsuccess = () => {
					let cursor = event.target.result;
					if(cursor){
						data.push(cursor.value);
						cursor.continue();
					}
					if(!cursor){
						data.sort((a,b)=>{
							return b.id - a.id;
						})
						imgArr = data;
						Img.init();
						res(true);
					}
				}
			})
		}

		this.getStore = () => {
			return db.transaction("img","readwrite").objectStore("img");
		}

	}

	app = new _App();
	return app;

}

window.onload = () => {
	const app = new App();
	app.init();
	$(".preloader").fadeOut();
}