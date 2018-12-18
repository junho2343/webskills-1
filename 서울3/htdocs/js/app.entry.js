// slide animation
function slide () {

	let left = $(this).hasClass("left");
	let wrap = $(".slide-wrap > div");

	if(left){

		wrap.find("article").last().prependTo(".slide-wrap > div");
		wrap.css("margin-left","-20%");
		wrap.stop().animate({"margin-left":0},300);	

	}else{

		wrap.stop().animate({"margin-left":"-20%"},300,function(){
			wrap.find("article").first().appendTo(".slide-wrap > div");
			wrap.css({"margin-left":"0"});
		});		

	}
}

// tab menu
function tabView () {
	let index = $(this).index();

	$(".tab li a").removeClass("active");
	$(this).find("a").addClass("active");
	$(".tab-content article").removeClass("active tabActive");
	$(".tab-content article").eq(index).addClass("active tabActive");
}

// application init
function init () {
	Animation.init()
	Navigation.init()
	Layer.init()
	Path.init()
}

// event register
$(init)
	.on('click', '.toMain', Navigation.goToMain)
	.on('click', '.site-menu li', Navigation.goToPage)
	.on('click', '.arrow a', Navigation.goToArrow)
	.on("submit",".short-path",Path.getPath)
	.on("click",".tab li",tabView)
	.on("click",".slide-arrow",slide)
	.on("click",".modal .x",Layer.close)
	.on("click",".time-table",Layer.tableOpen)
	.on("click",".slide-wrap > div > article,.food > article",Layer.open)