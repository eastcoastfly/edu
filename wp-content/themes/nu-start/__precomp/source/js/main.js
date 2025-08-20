// ? cookies and other mandatory global scripting
import "./misc/nu-globals";
// ? scrolling animations with GSAP
// import "./scrolltrigger";
// ? hook into Swiper.JS instances created by Gutenslider
import "./blocks/gutenslider";
// ? extensions for the accordion block - working on the block itself is hard!
import "./blocks/accordion";
// ? extensions for the tabs block -- (ultimate blocks tabbed content)
// import "./blocks/tabs";
// ? extensions for the image/gallery blocks including magnific popup hooks
import "./blocks/image-and-gallery";
// ? experimental code temporarily held here
import "./misc/_experimental";
//
//
//
(function ($, window, document) {
	// ? throttling vs. debouncing is that throttle guarantees the execution of the function
	// * limits function calls to once per time delay / duration
	const debounce = function (func, delay) {
		let timer;
		return function () {
			//anonymous function
			const context = this;
			const args = arguments;
			clearTimeout(timer);
			timer = setTimeout(() => {
				func.apply(context, args);
			}, delay);
		};
	};
	// * limits function calls to wait until limit / timer
	const throttle = (func, limit) => {
		let inThrottle;
		return function () {
			const args = arguments;
			const context = this;
			if (!inThrottle) {
				func.apply(context, args);
				inThrottle = true;
				setTimeout(() => (inThrottle = false), limit);
			}
		};
	};

	/**
	 * mQHandler maps JS event onto our breakpoints nicely.
	 * use this to fire scripts when we cross over a breakpoint threshold
	 */
	const mqHandler = {
		//
		breakpoints: {
			phone: "600px",
			small: "780px",
			medium: "1024px",
			large: "1280px",
			xlarge: "1620px",
			huge: "1920px",
		},
		_instance: function () {
			// pass this into the window so other files can access it
			return (window.mqHandler = mqHandler);
		},

		_init: function (overFunction = {}, underFunction = {}) {
			for (const [key, value] of Object.entries(this.breakpoints)) {
				let listener = window.matchMedia("(max-width: " + value + ")");
				listener.addEventListener("change", (event) => {
					if (event.matches) {
						if (underFunction._init) {
							underFunction._init(event, key);
						}
					} else {
						if (overFunction._init) {
							overFunction._init(event, key);
						}
						//
					}
				});
			}
		},
	};


	// mqHandler._instance();

	$(function () {
		//
		// ... code in here will run after jQuery says document is ready
		//
	});
})(window.jQuery, window, document);
