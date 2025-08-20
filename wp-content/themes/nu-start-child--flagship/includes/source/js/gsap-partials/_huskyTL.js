import { gsap } from "../../../../assets/gsap/umd/gsap";
import { ScrollTrigger } from "../../../../assets/gsap/umd/ScrollTrigger";
import { ScrollSmoother } from "../../../../assets/gsap/umd/ScrollSmoother";
import { DrawSVGPlugin } from "../../../../assets/gsap/umd/DrawSVGPlugin";
(function ($, window, document) {
	//
	// ... code out here will run immediately on load
	gsap.registerPlugin(ScrollTrigger);
	gsap.registerPlugin(ScrollSmoother);
	gsap.registerPlugin(DrawSVGPlugin);
	//

	const HuskyTimeline = {
		sliderEl: undefined,
		sliderInstance: undefined,
		sliderSettings: undefined,
		timeline: undefined,

		_init: function () {
			let huskyTL = $(
				".is-the-husky-timeline-container .wp-block-eedee-block-gutenslider"
			);

			if (!huskyTL.length) {
				return;
			}
			HuskyTimeline.sliderEl = $(huskyTL)[0].gutenslider;
			HuskyTimeline.sliderInstance = $(huskyTL)[0].gutenslider.swiperInstance;
			HuskyTimeline.sliderSettings = $(huskyTL)[0].gutenslider.swiperSettings;
			HuskyTimeline._create_timeline();
		},
		_create_timeline: function () {
			//
			let SliderSlides = HuskyTimeline.sliderInstance.slides;

			//
			let TLContainer = gsap.timeline({
				scrollTrigger: {
					trigger: ".is-the-husky-timeline-container",
					start: "top top", // start when section fully enters
					end: "+=" + SliderSlides.length + "25%", // this value feels very analog
					// pin: ".is-the-husky-timeline-container", // this is used rather than manually controlling anything
					pin: true,
					scrub: 1,
					onEnter: (progress, direction, isActive) => {
						console.log("Init Master Timeline");
					},
					onLeave: (progress, direction, isActive) => {
						console.log("End Master Timeline");
					},
				},
			});

			ScrollTrigger.batch(SliderSlides, {
				start: "top top",
				end: "+=100%",
				onLeave: () => {
					console.log("End Batch Item");
					HuskyTimeline.sliderInstance.slideNext();
				},
				onEnterBack: () => {
					console.log("Batch item entered back");
					HuskyTimeline.sliderInstance.slidePrev();
				},
			});
		},
	};

	$(function () {
		//
		// ? start of $.ready
		//

		HuskyTimeline._init();

		// ? end of $.ready
		//
	});
})(window.jQuery, window, document);
