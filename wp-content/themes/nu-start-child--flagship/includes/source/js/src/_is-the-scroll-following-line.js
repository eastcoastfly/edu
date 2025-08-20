import { gsap } from "../../../../assets/gsap/umd/gsap";
import { ScrollTrigger } from "../../../../assets/gsap/umd/ScrollTrigger";
import { ScrollSmoother } from "../../../../assets/gsap/umd/ScrollSmoother";
gsap.registerPlugin(ScrollSmoother);
gsap.registerPlugin(ScrollTrigger);
//
(function ($, window, document) {
	//
	// ... code out here will run immediately on load
	//
	$(function () {
		//

		// * Vertical scroll line
		// $(".blocks--wrapper").append('<div id="vertical-scroll-line"></div');
		$("body").append('<div id="vertical-scroll-line"></div');
		gsap.to("#vertical-scroll-line", {
			scrollTrigger: {
				trigger: "#vertical-scroll-line",
				start: "top 0%",
				end: "+=" + document.body.scrollHeight,
				scrub: true,
			},
			height: "100vh",
		});


		// ? end of $.ready
		//
	});
})(window.jQuery, window, document);
