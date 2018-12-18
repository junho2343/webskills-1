// Layer Class
class Layer {

	static init () { 

		let html = 
		`<div class="modal">
			<div class="popup">
				<div>
					<div class="x">X</div>
					<div class="contents">
						
					</div>
				</div>
			</div>
		 </div>`;

		$("body").prepend(html);

	}

	static open () {

		let html = $(this).html();

		$(".popup .contents").html(html);
		$(".modal").fadeIn();
	}

	static close () { 
		$(".popup .contents").empty();
		$(".modal").fadeOut();		
	}

	static tableOpen () {
		let html = Path.timeTable;

		$(".popup .contents").html(html);
		$(".modal").fadeIn();
	}

}