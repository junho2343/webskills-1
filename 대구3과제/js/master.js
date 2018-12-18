
function App(){
	
	let app;

	let DB;

	let Data;

	let Show;

	let Form;

	const doc = $(document);

	function _App(){
		this.init = () => {
			return this
			.setStyle()
			.setElement()
			.setVal()
			.setEvent()	
		}

		this.setElement = () => {
			$("body").prepend("<input type='file' class='addFile' hidden multiple/>")
			$("body").prepend(`<canvas id="canvas" width="330" height="420" style="display:none"></canvas>`)
			return this;
		}

		this.setVal = () => {
			DB = new _DB();
			Form = new _Form();
			Data = new _Data();
			Show = new _Show();

			this.select = false;

			DB.init();
			return this;
		}

		this.setEvent = () => {
			doc
			.on("click",".modal-button",Show.location)
			.on("click",".modal-close ",Show.close)
			.on("click",".addDelete ",Form.deleteAddList)
			.on("click",".panel-list",this.active)
			.on("click",".main-ex",Data.mainDownJson)
			.on("click",".selectDelete",Show.selectDelete)
			.on("click","#Export footer button",Data.selectDownJson)
			.on("click","#Initialization footer button",Data.clear)
			.on("click","#Delete footer button",Data.selectDelete)
			.on("click","#Download footer button",Data.selectDownImg)
			.on("click","#DetailDownload footer button",Data.mainDownImg)
			.on("click",".debutton",() => {$(".showDe").hide();$(".hideDe").show();})
			.on("click",".debutton2",() => {$(".showDe").show();$(".hideDe").hide();})
			.on("click",".search-button",() => {this.search();})
			.on("click","#Receipt footer button:eq(0)",() => {$(".addFile").click()})
			.on("click","#Receipt footer button:eq(1)",Data.addDB)
			.on("click",".main-delete",Data.mainDelete)
			.on("mousedown",".panel-list",this.focus)
			.on("mouseup",() => {clearTimeout(this.time)})
			.on("change",".addFile",Data.addFile)
			.on("keydown",".input", () => {
				if(event.keyCode == 13){
					this.search();
				}
			})
			return this;
		}

		this.setStyle = () => {
			const html = 
			`
				<style>
				</style>
			`;

			$("head").append(html);
			return this;
		}

		this.search = async () => {
			let search = $(".input").val();
			setTimeout(() => {
				if($(".dname").length > 0){
					let text = $(".dname").eq(0).text();
					text = text.replace(search,`<label style="background-color:#00d1b2;color:#fff">${search}</label>`);
					$(".dname").html(text);
				}
			},100)
			await DB.readAll(search);
		}

		this.active = function() {
			if(app.select) return;
			$(".is-active").removeClass("is-active");
			$(this).addClass("is-active");
			Show.isActive();
		}

		this.focus = function(){
			app.select = false;
			app.time = setTimeout(() => {
				app.select = true;
				$(this).toggleClass("is-focused");
			},2000);
		}

		this.getDay = (date) => {
			let arr = ['일','월','화','수','목','금','토'];
			let day = new Date(date).getDay();
			return arr[day];
		}

	}


	function _Data(){

		this.addFile = async () => {
			let files = $(".addFile")[0].files;
			for(let file of files){
				let type = file.type.split("/")[1];
				if(type != "json"){
					alert("json 파일이 아닙니다.");
					continue;
				}else{
					$("#Receipt table tr:eq(0)").hide();
					let data = {
						name : file.name,
						size : Math.ceil(file.size / 1024),
						json : await this.readFile(file)
					}
					$("#Receipt table").append(await Form.addListForm(data));
					$("#Receipt footer .is-success").prop("disabled",false);
				}

			}
			
		}

		this.selectDownJson = () => {
			$(".is-focused").each(async function(){
				let data = await DB.get($(this).data("id") * 1);
				Data.downJson(JSON.stringify(data.json),data.name)
			})
			Show.close();
		}

		this.selectDelete = () => {
			$(".is-focused").each(async function(){
				let id = $(this).data("id") * 1;
				Data.deleteData(id);
			})
			Show.close();
		}

		this.selectDownImg = () => {
			let type = $("#radio-png").prop("checked") ? "png" : "jpg";
			$(".is-focused").each(async function(){
				let data = await DB.get($(this).data("id") * 1);
				let url = Form.imgData(data);
				Data.downImg(url,type);
			})
			Show.close();
		}

		this.mainDownImg = async () => {
			let type = $("#radio-png2").prop("checked") ? "png" : "jpg";
			let data = await DB.get($(".is-active").data("id") * 1);
			let url = Form.imgData(data);
			this.downImg(url,type);
			Show.close();
		}

		this.mainDownJson = async () => {
			let data = await DB.get($(".is-active").data("id") * 1);
			this.downJson(JSON.stringify(data.json),data.name)
		}

		this.mainDelete = () => {
			let id = $(".is-active").data("id") * 1;
			this.deleteData(id)
		}

		this.downImg = (data,type) => {
			let c = document.getElementById("canvas");
			let ctx = c.getContext("2d");

			let img = new Image()
			img.onload = () => {
				ctx.drawImage(img,0,0,330,420);
				let href = c.toDataURL();
				this.download(href,`downd.${type}`);
			}
			img.src = data;
			Show.close();
			
		}

		this.downJson = (json,name) => {
			let href = "data:application/json,"+encodeURIComponent(json);
			this.download(href,name);
		}

		this.deleteData = async (id) => {
			DB.delete(id);
			await DB.readAll();
		}

		this.download = (href,name) => {
			let a = document.createElement("a");
			a.download = name;
			a.href = href;
			a.click();
		}

		this.clear = () => {
			$(".panel").empty();
			DB.clear();
			Show.isActive();
			Show.close();
		}

		this.readFile = (file) => {
			return new Promise((res,rej) => {
				let fs = new FileReader();
				fs.readAsText(file);
				fs.onload = () => {
					res(fs.result);
				}
			})
		}

		this.addDB = async () => {
			$(".addList").each(function(){
				let target = $(this);
				let data = {
					name : target.data("name"),
					size : target.data("size"),
					json : target.data("json")
				}
				DB.add(data);
			})
			Show.close();
			await DB.readAll();
		}

	}

	function _Form(){
		this.addListForm = (data) => {
			let html = 
			`
				<tr class="addList" data-name="${data.name}" data-size="${data.size}" data-json='${data.json}'>
                    <td>
                        <a>${data.name} <span class="tag is-info">${data.size}Kb</span></a>
                        <button class="delete is-pulled-right addDelete" aria-label="close"></button>
                    </td>
                </tr>
			`;
			return html;
		}

		this.imgData = (data) => {
			let m1 =data.json.transaction.amount * 0.05;
			let m2 = data.json.transaction.amount * 0.95;
			let html = 
			`
			<div style="margin: 0;padding: 20px;overflow: hidden;width:330px;height: 420px;background-color: #fff;box-sizing:border-box">
		<div style="margin: 10px 0;padding: 0;width: 100%;border-bottom:1px dashed #000;overflow: hidden;margin-top:10px;padding-bottom:10px">
			<h2 style="margin: 20px 0;padding: 0;text-align: center;">스마트 영수증</h2>
			<p style="font-size:13px;margin: 0;padding: 0;">사용처 : ${data.json.more.name}</p>
			<p style="font-size:13px;margin: 0;padding: 0;">가맹점번호 : ${data.json.more.number}</p>
			<p style="font-size:13px;margin: 0;padding: 0;">전화번호 : ${data.json.more.call}</p>
			<p style="font-size:13px;margin: 0;padding: 0;overflow: hidden;position: relative;">주소 : <span style="margin: 0;padding: 0;position: absolute;">${data.json.more.address}</span></p>
			
		</div>
		<div style="margin: 10px 0;padding: 0;width: 100%;border-bottom:1px dashed #000;overflow: hidden;margin-top:10px;padding-bottom:10px">
		<p style="font-size:13px;margin: 0;padding: 0;font-size:20px;text-align: center;margin-bottom:10px">[ ${data.json.transaction.type == "Offline" ? "오프라인" : "온라인"} 결제 ]</p>
		<p style="font-size:13px;margin: 0;padding: 0;">카드종류 : ${data.json.card.information == "VISA" ? "비자카드" : "마스터카드"}</p>
		<p style="font-size:13px;margin: 0;padding: 0;">카드번호 : ${data.json.card.number}</p>
		<p style="font-size:13px;margin: 0;padding: 0;">거래승인 : ${data.json.card.approval}</p>
		<p style="font-size:13px;margin: 0;padding: 0;">거래일시 : ${data.json.transaction.date} ${data.json.transaction.time}</p>
			
		</div>
		<div style="margin: 10px 0;padding: 0;width: 100%;border-bottom:1px dashed #000;overflow: hidden;margin-top:10px;padding-bottom:10px">
		<p style="font-size:13px;margin: 0;padding: 0;">거래금액 : <span style="float:right">${data.json.transaction.amount.toLocaleString()}원</span></p>		
		<p style="font-size:13px;margin: 0;padding: 0;">부가 : <span style="float:right">${m1.toLocaleString()}원</span></p>		
		<p style="font-size:13px;margin: 0;padding: 0;">합계 : <span style="float:right">${m2.toLocaleString()}원</span></p>		
			
		</div>
		<p style="font-size:13px;margin: 0;padding: 0;">감사합니다!</p>
	</div>
			`;
			let svg = 
			`
				<svg xmlns="http://www.w3.org/2000/svg" width="330" height="420">
					<foreignObject width="330" height="420">
						<div xmlns="http://www.w3.org/1999/xhtml">
							${html}
						</div>
					</foreignObject>
				</svg>
			`;
			return "data:image/svg+xml,"+encodeURIComponent(svg);
		}

		this.selectList = (data) => {
			let html = 
			`
				 <tr class="selectL" data-id="${data.id}">
                    <td>
                        <a>${data.name} <span class="tag is-info">${data.size}Kb</span></a>
                        <button class="delete is-pulled-right selectDelete" aria-label="close"></button>
                    </td>
                </tr>
			`;
			return html;
		}

		this.deleteAddList = () => {
			$(event.target).parents(".addList").remove();
			if($(".addList").length == 0){
				$("#Receipt table tr:eq(0)").show();
				$("#Receipt footer .is-success").prop("disabled",true);
			}
		}
		this.sideDate = (data) => {
			let date = data.json.transaction.date;
			let day = app.getDay(date);
			let html =
			`
				<a class="panel-block panel-date" data-date="${date}">
                    <span class="panel-icon">
                      <i class="far fa-calendar-alt" aria-hidden="true"></i>
                    </span>
                    <small>${date} (${day})</small>
                </a>
			`;
			return html;
		}

		this.sideList = (data) => {
			let card = data.json.card.information;
			let pay = data.json.transaction.classification;
			let icon = card == "VISA" ? "fab fa-cc-visa" : "fab fa-cc-mastercard";
			let plus = pay != "Payment" ? "+" : "-"; 
			let color = pay == "Payment" ? "has-text-danger" : "has-text-link"; 
			icon = pay != "Payment" ? "fas fa-undo" : icon;
			let html = 
			`
				<a class="panel-block panel-list" data-id="${data.id}">
                    <span class="panel-icon">
                      <i class="${icon}" aria-hidden="true"></i>
                    </span>
                    <small>${data.json.more.name} [${data.name}]</small>
                    <span class="panel-price is-pulled-right ${color}">
                        ${plus}${data.json.transaction.amount.toLocaleString()}<small>원</small>
                    </span>
                </a>
			`;
			return html;
		}

		this.activeForm = async () => {
			let data = await DB.get( $(".is-active").data("id") * 1 );
			let pay = data.json.transaction.classification;
			let card = data.json.card.information;
			let time = `${data.json.transaction.date} (${app.getDay(data.json.transaction.date)}) ${data.json.transaction.time}`;
			let cardSpan = "";

			if(card == "VISA"){
				cardSpan = `<span class="is-pulled-right card-visa">
                                <i class="fab fa-cc-visa"></i>&nbsp;비자카드
                            </span>`;
			}else{
				cardSpan = `<span class="is-pulled-right card-master">
                                <i class="fab fa-cc-mastercard"></i>&nbsp;마스터카드
                            </span>`;
			}

			let html = 
			`
				<div class="detail-content content">
                        <h1>결제
                            <!-- 일반보기 상태 -->
                            <a class="button is-pulled-right is-rounded hideDe debutton2">상세보기</a>

                            <a class="button is-pulled-right is-rounded showDe debutton" style="display:none">일반보기</a>
                        </h1>
                        <p>${time}</p>
                        <h3>
                        	<span class="dname">${data.json.more.name}</span>
                            ${cardSpan}
                        </h3>
                        <hr>
                        <h1 class="is-marginless has-text-right">
                            <span class="is-pulled-left">거래금액</span>
                            <span class="has-text-danger">${data.json.transaction.amount.toLocaleString()}<small>원</small></span>
                        </h1>

                        <p class="is-marginless has-text-right showDe" style="display:none">
                            <span class="is-pulled-left">거래시각</span>
                            <span>${time}</span>
                        </p>
                        <p class="is-marginless has-text-right showDe" style="display:none">
                            <span class="is-pulled-left">거래구분</span>
                            <span>${pay == "Payment" ? "결제" : "취소"}</span>
                        </p>
                        <p class="has-text-right showDe" style="display:none">
                            <span class="is-pulled-left">거래형태</span>
                            <span>${data.json.transaction.type == "Offline" ? "오프라인" : "온라인"}</span>
                        </p>
                        <p class="is-marginless has-text-right showDe" style="display:none">
                            <span class="is-pulled-left">카드정보</span>
                            <span>${card == "VISA" ? "비자카드" : "마스터카드"}</span>
                        </p>
                        <p class="is-marginless has-text-right showDe" style="display:none">
                            <span class="is-pulled-left">카드번호</span>
                            <span>${data.json.card.number}</span>
                        </p>
                        <p class="has-text-right showDe" style="display:none">
                            <span class="is-pulled-left">승인번호</span>
                            <span>${data.json.card.approval}</span>
                        </p>
                        <p class="is-marginless has-text-right showDe" style="display:none">
                            <span class="is-pulled-left">사용처</span>
                            <span><span class="dname">${data.json.more.name}</span></span>
                        </p>
                        <p class="is-marginless has-text-right showDe" style="display:none">
                            <span class="is-pulled-left">주소</span>
                            <span>${data.json.more.address}</span>
                        </p>
                        <p class="is-marginless has-text-right showDe" style="display:none">
                            <span class="is-pulled-left">전화번호</span>
                            <span>${data.json.more.call}</span>
                        </p>
                    </div>

                    <div class="field is-grouped is-pulled-right">
                        <p class="control">
                            <a class="button is-rounded main-ex">내보내기</a>
                        </p>
                        <p class="control">
                            <a class="button is-rounded modal-button" data-target="DetailDownload">다운로드</a>
                        </p>
                        <p class="control">
                            <a class="button is-rounded main-delete">삭제</a>
                        </p>
                    </div>
			`;
			return html;
		}

	}

	function _Show(){
		this.location = () => {
			let target = $(event.target).data("target");
			let modal = $(`#${target}`);
			switch(target){
				case "Initialization":
					modal.find("table tr:eq(0) strong").text($(".panel-list").length);
				break;
				case "DetailDownload":
					this.mainDownload();
				break;
				case "Delete":
				case "Download":
				case "Export":
					this.selectList(modal);
				break;
			}
			$(".addList").remove();
			modal.show();
		}

		this.mainDownload = async() => {
			let data = await DB.get($(".is-active").data("id") * 1);
			$("#DetailDownload td").html(`<a>${data.name} <span class="tag is-info">${data.size}Kb</span></a>`)
			$("#DetailDownload footer button").prop("disabled",false);
		}

		this.selectList = (modal) => {
			modal.find("table tr:eq(0)").show();
			$(".selectL").remove();
			if($(".is-focused").length <= 0) return;
			modal.find("table tr:eq(0)").hide();

			modal.find("footer .is-success").prop("disabled",false);

			modal.find("table").append(`<tr class="selectL">
                    <td class="has-text-centered">
                        <span>총 <strong>${$(".is-focused").length}</strong>개의 영수증이 선택되었습니다.</span>
                    </td>
                </tr>`);

			$(".is-focused").each(async function(){
				let data = await DB.get( $(this).data("id") * 1 );

				modal.find("table").append(Form.selectList(data));
			})
		}

		this.selectDelete = () => {
			let modal = $(event.target).parents(".modal");
			let id = $(event.target).parents("tr").data("id");
			$(`.is-focused[data-id="${id}"]`).removeClass("is-focused");
			this.selectList(modal);
		}

		this.isActive = async () => {
			$(".detail").empty();
			if($(".is-active").length <= 0) return;
			$(".detail").html(await Form.activeForm());
		}

		this.sideList = (arr) => {
			$(".panel").empty();
			arr.forEach(x => {
				if($(`.panel-date[data-date="${x.json.transaction.date}"]`).length <= 0)
					$(".panel").append(Form.sideDate(x));
				$(".panel").append(Form.sideList(x));

				if($(".panel-list").length >= 1){
					$(".panel-list").eq(0).addClass("is-active");
				}
			})
			this.isActive();
		}



		this.close = () => {
			$(".modal").hide();
			$(".addList").remove();
			$(".modal footer .is-success").prop("disabled",true);
			$("#DetailDownload footer .is-success").prop("disabled",true);
			$("#Receipt table tr:eq(0)").show();
			$(".selectL").remove();
		}

	}

	function _DB(){
		const dbname = "db20180920";
		const table = "table20180920";
		let db;

		this.init = () => {
			let req = window.indexedDB.open(dbname);
			req.onsuccess = async () => {
				db = req.result;
				await this.readAll();
			}
			req.onupgradeneeded = () => {
				let rs = req.result;
				rs.createObjectStore(table,{keyPath:"id",autoIncrement:true});
			}
		}

		this.add = (data) => {
			this.getStore().add(data);
		}

		this.delete = (id) => {
			this.getStore().delete(id);
		}

		this.clear = () => {
			this.getStore().clear();
		}

		this.get = (id) => {
			return new Promise((res,rej) => {
				this.getStore().get(id).onsuccess = () => {
					res(event.target.result);	
				}
			})
		}

		this.readAll = (search = false) => {
			let arr = [];
			return new Promise((res,rej) => {
				this.getStore().openCursor().onsuccess = () => {
					let cursor = event.target.result;
					if(cursor){
						if(search){
							if(cursor.value.json.more.name.indexOf(search) != -1){
								arr.push(cursor.value);	
							}
						}else{
							arr.push(cursor.value);
						}
						cursor.continue();
					}
					if(!cursor){
						arr.sort((a,b) => {
							let adate = a.json.transaction.date+" "+a.json.transaction.time;
							let bdate = b.json.transaction.date+" "+b.json.transaction.time;
							return new Date(bdate) - new Date(adate);
						})
						Show.sideList(arr);
					}
				}
			})
		}

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