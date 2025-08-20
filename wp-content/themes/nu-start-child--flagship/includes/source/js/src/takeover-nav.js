(function ($, window, document) {
	//
	// ... code out here will run immediately on load
	//
	function getElementIndex(element) {
		return Array.from(element.parentNode.children).indexOf(element);
	}
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
	const takeover_Nav = {
		containerEl: "",
		menuEl: "",
		navlinks: "",
		toggleEl: "",
		submenu_parent_elems: "",
		searchFormToggle: "",
		searchFormEl: "",
		//
		//
		//
		_submenu_reset_handler: function () {
			takeover_Nav.submenu_parent_elems.removeClass("is-open");
		},
		//
		//
		_container_toggle_handler: function () {
			//
			takeover_Nav.toggleEl.on("click", function (e) {
				e.preventDefault();
				e.stopPropagation();

				takeover_Nav._submenu_reset_handler();
				$("body").toggleClass("has-revealed-takeover-nav");

				//
				let active_nav_item = takeover_Nav.navlinks.find(
					".current-page-ancestor"
				);
				//
				if (active_nav_item.length != 0) {
					active_nav_item.addClass("is-open");
					//
					// ? hacky answer to transition not working when the el has display: none;
					$("a", active_nav_item[0])
						.next(".sub-menu")
						.css("opacity", "0")
						.animate(
							{
								opacity: 1,
							},
							700
						);
				}
			});
		},

		//
		//
		_submenu_toggle_handler: function (e) {
			//
			//	? using display: none toggle
			takeover_Nav.submenu_parent_elems.removeClass("is-open");
			$(e.delegateTarget).addClass("is-open");
			// ? hacky answer to transition not working when the el has display: none;
			$(e.currentTarget).next(".sub-menu").css("opacity", "0").animate(
				{
					opacity: 1,
				},
				700
			);
		},
		//
		_featured_image_handler: function (e) {
			let elemIndex = getElementIndex(e.delegateTarget);
			let styleAttr =
				"background-image: url(" + window.takeoverNavImages[elemIndex] + ")";
			takeover_Nav.containerEl
				.find(".takeover-featured-story-container")
				.attr("style", styleAttr);
		},

		//
		_init: function () {
			//
			//
			//
			//
			takeover_Nav.containerEl = $(".takeover-menu-container");
			takeover_Nav.menuEl = $(
				".takeover-menu-container .takeover-nav-container"
			);
			takeover_Nav.navlinks = $(".takeover-nav-container .navlinks");
			takeover_Nav.toggleEl = $(".takeover-nav-toggle");
			takeover_Nav.searchFormEl = $(
				".takeover-nav-search .sitesearch-container"
			);
			takeover_Nav.searchFormToggle = $(".takeover-nav-search-button");
			takeover_Nav.submenu_parent_elems =
				takeover_Nav.navlinks.find(".menu > li");

			//

			takeover_Nav.searchFormToggle.on("click", function (e) {
				e.preventDefault();
				e.stopPropagation();
				$(e.delegateTarget).toggleClass("has-revealed-searchform");
			});

			//
			//
			takeover_Nav.submenu_parent_elems.on("click", ">a", function (e) {
				e.preventDefault();
				e.stopPropagation();
				if (window.takeoverNavImages) {
					takeover_Nav._featured_image_handler(e);
				}
			});

			//
			takeover_Nav._container_toggle_handler();
			//
			takeover_Nav.submenu_parent_elems.on("click", "a", function (e) {
				takeover_Nav._submenu_toggle_handler(e);
				//
			});

			$(document).on("click", function (event) {
				if ($(event.target).closest(".takeover-nav").length === 0) {
					takeover_Nav._submenu_reset_handler();
				}
			});

			$(document).keyup(function(e) {
				if (e.keyCode == 27) { // escape key maps to keycode `27`
					$('body').removeClass("has-revealed-takeover-nav");
				}
			});

			//
			window.takeover_Nav = takeover_Nav;
		},
	};

	$(function () {
		//
		// ? start of $.ready

		takeover_Nav._init();

		//
		var lastScrollTop = 0;

		//
		window.addEventListener(
			"scroll",
			throttle(function () {
				//
				var currentScroll =
					window.scrollY || document.documentElement.scrollTop;
				//
				if (currentScroll > lastScrollTop) {
					if (window.scrollY > 120) {
						$("body").addClass("is-using-minimal-header-view");
					}
				} else {
					if (window.scrollY < 120) {
						$("body").removeClass("is-using-minimal-header-view");
					}
				}
				lastScrollTop = currentScroll <= 0 ? 0 : currentScroll; // For Mobile or negative scrolling
			}, 10),
			false
		);

		// ? end of $.ready
		//
	});

	// * This is to close the takeover nav if the user tabs out of the last child of the Presidential menu
	$("#menu-presidential-banner > .menu-item:last-child").keydown(function(evt){
		if (evt.which === 9)
		{
			if(evt.shiftKey === true)
			{
				// user is tabbing backward
			}
			else
			{
				// User is tabbing forward
				$(".takeover-nav-toggle").click();

			}
		}
	});

})(window.jQuery, window, document);
