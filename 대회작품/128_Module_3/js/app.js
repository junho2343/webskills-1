function App()
{
	let app;

	let Ani;

	let DB;

	let Gal;

	let Form;

	const doc = $(document);
	const win = $(window);

	function _App(){
		this.init = () => {
			return this
			.setStyle()
			.setElement()
			.setVal()
			.setEvent()
		}
		//style append
		this.setStyle = () => {
			const html = 
			`
				<style>
					.social-icon li a:hover{background-color: red;}
					.navbar-default .navbar-nav>li>a:hover{color:red !important}
					#team .row .col-md-3:hover{transform:translateY(-10px);opacity: 0.4;}
					#service .col-md-4:hover{background-color: #505050;}
					.show-gal:hover .portfolio-overlay{opacity:1 !important}
					.updown{animation: updown 1s}
					
					.animation{transition:1s;opacity: 1;transform:inherit}
					.animation.ab{transition:0s;opacity:0}
					.animation.ab.tb{transform:translateY(100px)}
					.animation.ab.bt{transform:translateY(-100px)}
					.animation.ab.rl{transform:translateX(-100px)}
					.animation.ab.lr{transform:translateX(100px)}
					.bounce{animation:bounce 1s forwards}
					
					@keyframes bounce{
						0%{transform:scale(0)}
						33.333%{transform:scale(1.1)}
						66.666%{transform:scale(0.8)}
						100%{transform:scale(1)}
					}

					@keyframes updown{
						0%{margin-top: 0;}
						50%{margin-top: 100%;}
						100%{margin-top: 0;}
					}
				</style>
			`;
			$("head").append(html);

			return this;
		}

		this.setElement = () => {
			Ani = new _Animation();
			Gal= new _Gallery();
			Form = new _Form();
			DB = new _DB();
			Ani.text();
			
			DB.init();
			let param = new URL(location.href).searchParams.get("page");
			if(param != null){
				$(".gallery-area").show();

			}
			$(".gallery-back > .close-btn").remove();

			setInterval(async () => {
				if(localStorage.reload == 1){
					if(param != null) return;
					localStorage.reload = 0;
					await DB.load();
				}
			})

			return this;
		}

		this.setVal = () => {
			localStorage.login = localStorage.login || 0;
			localStorage.reload = localStorage.reload || 0;
			this.loginDisplay();
			this.reload();
			
			return this;
		}
		//evnet setting
		this.setEvent = () => {
			doc
			.on("drop dragover",() => {event.preventDefault()})
			.on("scroll",Ani.scroll)
			.on("click",".modal-footer .login-btn",this.login)
			.on("click",".mb-btn .logout-btn",this.logout)
			.on("click",".nav li a",Ani.moveContent)
			.on("click",".show-gal",Gal.open)
			.on("click",".img-paging .prev,.img-paging .next",Gal.paging)
			.on("click",".gallery-remove",Gal.delete)
			.on("mouseover","#about .media-heading-wrapper .fa",this.updown)
			.on("submit","form",this.sendMessage)
			.on("input","#message",this.msgHeight)
			.on("drop",".gallery-area",Gal.drop)
			return this;
		}
		//icon down up animation
		this.updown = function() {
			$(this).addClass("updown");
			setTimeout(() => {$(this).removeClass("updown")},1200);
		}
		//member login
		this.login = () => {
			let id = $("#userid").val();
			let pw = $("#pw").val();
			if(id == "admin" && pw == "admin"){
				localStorage.login = 1;
				$(".modal-footer .btn-default").click();
				alert("로그인 되었습니다.");
				this.loginDisplay();
			}else{
				alert("아이디 또는 비밀번호가 틀렸습니다.");
			}
		}
		//member logout
		this.logout = () => {
			localStorage.login = 0;
			this.loginDisplay();
		}
		//login display setting
		this.loginDisplay = () => {
			if(localStorage.login == 1){
				$(".mb-btn .login-btn").hide();
				$(".mb-btn .join-btn").hide();
				$(".mb-btn .logout-btn").show();
			}else{
				$(".mb-btn .login-btn").show();
				$(".mb-btn .join-btn").show();
				$(".mb-btn .logout-btn").hide();
			}
		}
		//msg sned
		this.sendMessage = () => {
			event.preventDefault();
			let name = $("#fullname");
			let email = $("#email");
			let msg = $("#message");
			if(name.val() == "" || email.val() == "" || msg.val() == ""){
				alert("값을 모두 채워야 합니다.");
				return;
			}else{
				name.val("");
				email.val("");
				msg.val("");
				alert("메시지가 전송되었습니다.");
				$("html,body").animate({scrollTop:doc.height()},function(){
					$("html,body").animate({scrollTop:0})
				})
				this.msgHeight();
			}
		}
		//msg box height set
		this.msgHeight = () => {
			let msg = $("#message");
			let height = msg.val().split("\n").length;
			if(height > 4){
				msg.attr("rows",height);
			}else{
				msg.attr("rows",4);
			}
		}

		this.reload = () => {

			
		}
	}

	function _Gallery()
	{	

		//popup open
		this.open = function() {
		
			let a = document.createElement("a");
			let index = $(this).index() - 1;
			$(a).attr("href",`index.html?page=${index}`);
			$(a).attr("target","_blank")
			a.click();
		}
		//img drop add
		this.drop = async () => {

			if(localStorage.login != 1){
				alert("어드민만 업로드 가능합니다.");
				return;
			}

			let files = event.dataTransfer.files;
			for(let file of files){
				DB.add({img : await this.readFile(file)});
			}
			localStorage.reload = 1;
			clearInterval(this.time);
			await DB.readAll("0");
			this.now = 1;
			
		}
		// img delete
		this.delete = async function() {
			let id = $(this).data("id") * 1;
			DB.delete(id);
			
			await DB.readAll("0");
			clearInterval(this.time);
			this.now = 1;
		}
		//popup load
		this.load = () => {
			this.all = Math.ceil($(".now-img img").length / 8);
			this.now = this.all > 0 ? 1 : 0;
			$(".all").html(this.all);
			this.movePage();
		}
		//popup page show hide
		this.movePage = () => {
			$(".now").html(this.now);
			$(`.img-list li`).hide();
			$(`.img-list li[data-page=${this.now}]`).show();
		}
		// slide animation
		this.slide = (cc) => {
			clearInterval(this.time);
			let max = $(".now-img > img").length;
			let cnt = cc;
			$(".now-img img").fadeOut(0);
			$(".now-img img").eq(cnt).fadeIn(0);
			$(".img-list li").css({"border":"none"});
			$(".img-list li").eq(cnt).css({"border":"1px solid red"});

			function play2(){
				cnt++;
				if(cnt > (max-1)) cnt = 0;
				console.log(cc);
				Gal.now = Math.ceil((cnt + 1) / 8);
				Gal.movePage();
				$(".now-img img").fadeOut(300);
				$(".now-img img").eq(cnt).fadeIn(300);
				$(".img-list li").css({"border":"none"});
				$(".img-list li").eq(cnt).css({"border":"1px solid red"});
			}

			const play = () => {

				cnt++;
				if(cnt > (max-1)) cnt = 0;
				console.log(cc);
				this.now = Math.ceil((cnt + 1) / 8);
				this.movePage();
				$(".now-img img").fadeOut(300);
				$(".now-img img").eq(cnt).fadeIn(300);
				$(".img-list li").css({"border":"none"});
				$(".img-list li").eq(cnt).css({"border":"1px solid red"});
			}

			this.time = setInterval(play2,3000);
		}
		//popup paging
		this.paging = function(){
			let next = $(this).hasClass("next");
			if(next){
				if(Gal.now+1 > Gal.all){alert("다음 페이지는 없습니다.");return;}
				Gal.now++;
			}else{
				if(Gal.now-1 < 1){alert("이전 페이지는 없습니다.");return;}
				Gal.now--;
			}
			Gal.cnt = $(`.img-list li[data-page=${Gal.now}]`).eq(0).index();
			Gal.movePage();
			Gal.slide(Gal.cnt);
		}
		//drop file read
		this.readFile = (file) => {
			return new Promise((res,rej) => {
				let fs = new FileReader();
				fs.readAsDataURL(file);
				fs.onload = () => {
					res(fs.result);
				}
			})
		}

		this.setDefault = () => {
			localStorage.default = localStorage.default || 1;
			if(localStorage.default == 1){
				DB.add({img:"images/portfolio-img8.jpg"})
				DB.add({img:"images/portfolio-img7.jpg"})
				DB.add({img:"images/portfolio-img6.jpg"})
				DB.add({img:"images/portfolio-img5.jpg"})
				DB.add({img:"images/portfolio-img4.jpg"})
				DB.add({img:"images/portfolio-img3.jpg"})
				DB.add({img:"images/portfolio-img2.jpg"})
				DB.add({img:"images/portfolio-img1.jpg"})
				
				localStorage.default = 0;
			}
		}
	}
	//animation function
	function _Animation()
	{	
		//document scroll evnet function
		this.scroll = () => {
			let st = win.scrollTop();
			if(st > 0){
				$(".templatemo-nav").css({"position":"fixed","top":"0"});
			}else{
				$(".templatemo-nav").css({"position":"static"});
			}
			this.navColor(st);
			this.playAnimation(st);
		}
		//navigation color set
		this.navColor = (st) => {
			let index = 0;
			

			$("body > section").each(function(){
				if(st >= $(this).offset().top)
					index = $(this).index("body > section");
			})
			$(`.nav li a`).css({"color":"#777"});
			$(`.nav li:eq(${index}) a`).css({"color":"red"});
		}
		//메뉴 클릭시 해당 켄텐츠로 이동
		this.moveContent = function (st) {
			event.preventDefault();
			let move = win.scrollTop() > 0 ? 0 : -70;
			let target = $(this).attr("href");
			if(!$(target)[0]) return;
			move += $(target).offset().top;
			$("html,body").animate({scrollTop:move});
		}
		//메인 비쥬얼 텍스트 애니메이션
		this.text = () => {
			let data = []; //텍스트 데이터 
			let cnt = 0; //텍스트 한단어 단위
			let i = 0; //텍스트 한문장 단위

			$(".sub-element").each(function(){
				let t = $(this).text().split(" ");
				data.push(t);
			})
			$(".sub-element").hide();
			$(".element").append("<div class='view-element'></div>");
			let rtext = [];
			let text = "";

			//텍스트 함수 
			const play = () => {
				if(cnt < data[i].length){
					rtext.push(data[i][cnt]);
					text += `${data[i][cnt]} &nbsp;`; 
					cnt++;
				}else if(cnt >= data[i].length){
					rtext.pop();
					text = "";
					rtext.forEach(x => {
						text += `${x} &nbsp;`;
					})
				}

				if(cnt >= data[i].length && rtext.length == 0){
					cnt = 0;
					i++;
					if(i >= data.length) i = 0;
				}
				
				$(".view-element").html(text);
				setTimeout(play,500);
			}
			play();
		}
		//스크롤 시 노출된 컨텐츠 애니메이션
		this.playAnimation = (st) => {
			let sh = st + win.height();

			$(".wow").each(function(){
				let top = $(this).offset().top;
				let th = top + $(this).height();

				if(((top >= st && top <= sh)) || (th >= st && th <= sh)){
					let delay = $(this).data("delay") * 1000;
					setTimeout(()=>{
						$(this).removeClass("ab wow");

						if($(this).hasClass("bounceIn")){
							$(this).addClass("bounce");
						}

					},delay)
				}

			})

		}
		//애니메이션 세팅
		this.setAnimation = () => {
			$(".wow").each(function(){
				let delay = $(this).data("wow-delay").split("s")[0]*1;
				$(this).addClass("animation");
				$(this).attr("data-delay",delay);

				if($(this).hasClass("fadeInUp")){
					$(this).addClass("bt");
				}
				if($(this).hasClass("fadeInDown")){
					$(this).addClass("tb");
				}
				if($(this).hasClass("fadeInRight")){
					$(this).addClass("lr");
				}
				if($(this).hasClass("fadeInLeft")){
					$(this).addClass("rl");
				}
			})
			$(".animation").addClass("ab");
		}

	}
	//html 폼을 반환하는 기능
	function _Form()
	{	
		//갤러리 html 반환 매개 변수가 없을 시 no-image
		this.getGalleryForm = (data = false,cnt = false) => {
			let html = "";
			let arr = ['One','Two','Three','Four','Five','Six','Seven','Eight'];
			if(data){
				html = `<div class="col-md-3 col-sm-6 col-xs-12 wow fadeIn show-gal" data-wow-offset="50" data-wow-delay="0.6s">
                        <div class="portfolio-thumb">
                           <img src="${data.img}" class="img-responsive" alt="portfolio img 2">
                                <div class="portfolio-overlay">
                                    <h4>CITYTOUR ${arr[cnt]}</h4>
                                    <p>시민과 함께하는 해양 관광 휴양도시, 아름다운 여수의 밤바다와 힐링이 있는 그 곳. 오늘 여수는 당신에게 주는 선물입니다.</p>
                                    <a href="#" class="btn btn-default">DETAIL</a>
                                </div>
                        </div>
                    </div>`;
			}else{
				html = `<div class="col-md-3 col-sm-6 col-xs-12 wow fadeIn no-image" data-wow-offset="50" data-wow-delay="0.6s">
                        <div class="portfolio-thumb">
                           <h4>No Image</h4>
                        </div>
                    </div>`;
			}
			return html;

		}
	}
	//indexedDB 기능
	function _DB()
	{	
		//dbname 설정
		const dbname = "db20181007";
		//table 이름 설정
		const table = "table20181007";
		let db;

		this.init = () => {
			let req = window.indexedDB.open(dbname);

			req.onsuccess = async () => {
				db = req.result;
				Gal.setDefault();
				await this.readAll();
				Ani.setAnimation();
				Ani.scroll();
			}

			req.onupgradeneeded = () => {
				let rs = req.result;
				rs.createObjectStore(table,{keyPath:"id",autoIncrement:true});
			}

		}
		//db 데이터 추가
		this.add = (data) => {
			this.getStore().add(data);
		}
		//디비 데이터 삭제
		this.delete = (id) => {
			this.getStore().delete(id);
			localStorage.reload = 1;
		}
		//데이터 로드
		this.load = () => {
			let arr = [];
			return new Promise((res,rej) => {
				this.getStore().openCursor().onsuccess = () => {
					let cursor = event.target.result;
					
					if(cursor){
						arr.push(cursor.value);
						cursor.continue();
					}
					if(!cursor){
						$("#portfolio .col-md-3").remove();
						arr.sort((a,b) =>{
							return b.id - a.id;
						})

						for(let i = 0; i < 8 ; i++){

							if((arr.length-1) >= i){
								$("#portfolio .row").append(Form.getGalleryForm(arr[i],i));
							}else{
								$("#portfolio .row").append(Form.getGalleryForm())
							}
						}
						res(true);
					}
				}
			})
		} 
		//데이터 불러오기
		this.readAll = (slide = false) => {
			let arr = [];
			return new Promise((res,rej) => {
				this.getStore().openCursor().onsuccess = () => {
					let cursor = event.target.result;
					
					if(cursor){
						arr.push(cursor.value);
						cursor.continue();
					}
					if(!cursor){
						
						arr.sort((a,b) =>{
							return b.id - a.id;
						})
						$("#portfolio .col-md-3").remove();
						$(".now-img").empty();
						$(".img-list ul").empty();

						for(let i = 0; i < 8 ; i++){

							if((arr.length-1) >= i){
								$("#portfolio .row").append(Form.getGalleryForm(arr[i],i));
							}else{
								$("#portfolio .row").append(Form.getGalleryForm())
							}
						}

						arr.forEach((x,idx) => {
							let remove = localStorage.login == 1 ? ` <span class="gallery-remove" style="border-radius:0;width:40px;height:20px;border:1px solid blue"  data-id=${x.id}>삭제</span>` : "";	

							let page = Math.ceil( (idx+1) / 8 );
							$(".now-img").append(`<img src="${x.img}" alt="pt1" data-page=${page}>`);
							$(`.img-list ul`).append(`<li data-page=${page}>
                                    <img src="${x.img}" alt="pt1">
                                   	${remove}
                                </li>`)
						})

						Gal.load();
						let page = new URL(location.href).searchParams.get("page") * 1;

						if(slide){
							page = 0;
							Gal.now = 1;
						}
						console.log(1);
						Gal.slide(page);
						res(true)
					}
				}
			})
		}
		//오브젝트 스토어 반환
		this.getStore = () => {
			return db.transaction(table,"readwrite").objectStore(table);
		}
	}

	app = new _App();
	return app;
}

window.onload = () => {
	let app = new App();
	app.init();
}