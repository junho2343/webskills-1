// page class
class Navigation {

	// instance Constructor
	constructor () { }

	// set static variable
	static init () {

		// jQuery selector minimization
		const param = new URL(location.href).searchParams;
		Navigation.main    = $('.main')
		Navigation.sub     = $('.sub')
		Navigation.page    = $('.page')
		Navigation.gnb     = $('.gnb')
		Navigation.len     = Navigation.gnb.find('li').length
		Navigation.section = Navigation.page.find('>section')
		Navigation.nowPage = param.get("page") != null ? param.get("page") * 1: -1;

		if (Navigation.nowPage != -1) {
			Navigation.main.removeClass('active')
			Navigation.sub.addClass('active')
			new Animation({
				obj : $(`.sub .page>section:eq(${Navigation.nowPage}), .arrow, .sub-default`)
			})
		}else{
			Navigation.main.addClass('active')
			Navigation.sub.removeClass('active')
			new Animation({
				obj : $(".main, .arrow")
			})
		}

		Navigation.goToPageReal(Navigation.nowPage);
	}

	// go to main page
	static goToMain () {
		
		let op = {
			obj : $(".sub"),
			reverse : true,
			cb: function(){
				$(".sub").fadeOut(500, () => {
					Navigation.nowPage = -1
					Navigation.sub.removeClass('active')
					Navigation.page.find('>section.active').removeClass('active')
					Navigation.main.addClass('active')
					$(".main").fadeIn(300, () => {
						new Animation({obj:$(".main")})
					})
				})
			}
		}

		new Animation(op)
		Navigation.setURL(-1);
	}

	static setURL (num) {
		history.pushState("","","?page="+num);
	}

	// go to selected sub page
	static goToPage () {
		Navigation.goToPageReal($(this).index())
	}

	// go to page
	static goToPageReal (num) {
		// variable set
		

		if(num == -1){
			Navigation.goToMain();
			return;
		}

		const main = Navigation.main,
			  sub  = Navigation.sub,
			  page = Navigation.page,
			  gnb  = Navigation.gnb,
			  prev = Navigation.nowPage,
			  now = num

		if (prev === -1) {
			new Animation({
				obj : $(".main"),
				reverse : true,
				cb : function(){
					$(".main").fadeOut(500,() => {
						main.removeClass('active')
						sub.addClass('active')
						page.find('>section.active').removeClass('active')
						page.find('>section').eq(now).addClass('active')
						page.find('>section').eq(now).removeAttr("style");
						$(".sub").fadeIn(300, () => {
							new Animation({
								obj : $(`.sub .page>section:eq(${num}), .sub-default`)
							})
						})

					})
				}
			})
		}else{
			new Animation({
				obj : $(`.sub .page>section:eq(${prev})`),
				reverse: true,
				cb : function(){
					$(`.sub .page>section:eq(${prev})`).fadeOut(500,() => {
						
						page.find('>section.active').removeClass('active')
						page.find('>section').eq(now).addClass('active')
						page.find('>section').eq(now).removeAttr("style");
						$(`.sub .page>section:eq(${now})`).fadeIn(300, () => {
							new Animation({obj:$(`.sub .page>section:eq(${now})`)})
						})
					})
				}
			})
		}
		gnb.find('li.active').removeClass('active')
		gnb.find('li').eq(num).addClass('active')

		Navigation.setURL(num);
		Navigation.nowPage = num
	}

	// go to selected sub page
	static goToArrow () {
		// variable set 
		const _this = $(this),
		      len   = Navigation.len
		let   num   = Navigation.nowPage
		num = _this.hasClass('left') ? num - 1 : num + 1
		if (num == -1 || num >= len) {
			num = -1;
		} else if (num < -1) {
			num = len - 1
		}
		Navigation.goToPageReal(num)
	}
}