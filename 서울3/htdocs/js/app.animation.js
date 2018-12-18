// animation set
class Animation {

	constructor (op) { 
		this.delay = 30;

		this.obj = op.obj;
		this.reverse = op.reverse || false;
		this.cb = op.cb || function(){}

		this.time = [];		

		this.play();
		console.log(1)
	}

	play () {
		this.clear();
		const elem = this.reverse ? this.find(".reverse") : this.find(".animationBefore");		
		const _this = this;
		let delay = 0;

		elem.each(function(idx){
			let target = $(this);
			_this.time.push(setTimeout(() => {
				if(_this.reverse){
					let index = (elem.length-1) - idx;
					elem.eq(index).removeClass("reverse").addClass("type2 animationBefore");
				}else{
					target.removeClass("type2 animationBefore").addClass("reverse");
				}
			},delay += _this.delay))
		})
		this.time.push(setTimeout(this.cb,delay));
	}

	find (elem) { return this.obj.find(elem) }

	clear () { this.time.forEach(x => clearTimeout(x)) }

	static init () { 

		$(".childAnimation > *:not(.animation) ").each(function(){

			let target = $(this);
			let parent = target.parent();

			if(parent.data("type")){
				target.addClass(parent.data("type"));
			}
			target.addClass("animation");
		})

		$(".animation").addClass("animationBefore");

		Animation.styleSet();
	}

	static styleSet () { 
		let html = 
		`
			<style>
					
				.animation{opacity:1;transform:inherit;transition:1s}
				.animation.animationBefore{opacity:0;transform:scale(0);transition:0s}

				.animation.animationBefore.tb{transform:translateY(-100px)}
				.animation.animationBefore.bt{transform:translateY(100px)}
				.animation.animationBefore.lr{transform:translateX(-100px)}
				.animation.animationBefore.rl{transform:translateX(100px)}
				.animation.animationBefore.type2{transition:1s}

				.modal{width:100%;height:100%;position:fixed;left:0;top:0;background-color: rgba(0,0,0,0.5);z-index: 999;display:none;}
				.modal .popup{width:90%;height:auto;position: absolute;left:50%;top:20px;transform:translateX(-50%);background-color:#fff}
				.modal .popup .x{width:30px;height:30px;text-align: center;line-height: 30px;background-color:#888;color:#fff;transition:.5s;cursor:pointer;float:right}
				.modal .popup .contents{width:100%;padding:30px;box-sizing:border-box}
				
				.modal .popup .img_wrap{float:right}
				.modal .popup .name{font-size:23px}
				.modal .popup .real-content{line-height: 30px;}
				
				.modal .popup .x:hover{background-color:#00aeef}
				

				.tabActive{animation:tabView .5s forwards}

				@keyframes tabView{
					from{opacity: 0;transform:translateY(100px)};
					to{opacity: 1;transform:inherit};
				}

			</style>
		`;

		$("head").append(html);
	}
}