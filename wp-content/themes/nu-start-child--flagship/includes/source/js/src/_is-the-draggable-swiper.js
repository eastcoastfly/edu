(function ($, window, document) {
	//
	// ... code out here will run immediately on load



		// let DragTL = gsap.timeline({
		// 	scrollTrigger: {
		// 		trigger: ".swiper-scrollbar-custom-container",
		// 		start: "top 70%",
		// 		end: "bottom 15%",
		// 		scrub: 1,
		// 		onUpdate: (self) => {
		// 			window.nuSwipers.setProgress(self.progress.toFixed(3) * 0.1, 0.1);
		// 		},
		// 	},
		// });



	const Draggable_Swiper = {




		_init : function(){

			// check for window.Swiper
			const Swiper = window.Swiper;
			if( Swiper.length == 0 ){
				return
			}

			console.log(Swiper);
			// check for Swiper El
			// build instance

		}

	}
	// Draggable_Swiper._init();



	//
	$(function () {
		//
		// ? start of $.ready




		// ? end of $.ready
		//
	});
})(window.jQuery, window, document);
