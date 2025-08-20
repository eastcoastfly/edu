(function ($, window, document) {
	//
	// ... code out here will run immediately on load
	//

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

	const returnHashFromURL = function (url) {
		// check for hash in url
		var index = url.indexOf("#");

		// return hash if found
		if (index !== -1) {
			var hash = url.substring(index + 1);
			return hash;
		}

		// otherwise, oops
		return false;
	};

	$(function () {
		// ! OMG; how stop collapsing the damn nav menu
		$(".blocks--wrapper").on("click", function (e) {
			// e.stopPropagation();
		});

		//
		// ... code in here will run after jQuery says document is ready
		//

		const $nav_block_as_vertical_sidebar = {
			//
			//
			menu: undefined,
			menuItems: undefined,
			currentItem: undefined,
			currentParent: undefined,
			navIcon: undefined,

			//
			//
			//
			_init: function (menu) {
				// hoist!
				$nav_block_as_vertical_sidebar.menu = menu;
				// hoist!
				$nav_block_as_vertical_sidebar.menuItems = $(menu).find(
					".wp-block-navigation-item"
				);
				// hoist!
				$nav_block_as_vertical_sidebar.currentItem =
					$(menu).find("[aria-current]");
				// hoist!
				$nav_block_as_vertical_sidebar.currentParent = $(menu)
					.find("[aria-current]")
					.parents(".has-child");
				// hoist!
				//
				//
				// * Add 'is-opened' class to the 'has-child' parent of 'current-menu-item'
				$($nav_block_as_vertical_sidebar.currentParent).addClass("is-opened");
				//
				//
				//
				//

				// ? tag current page ancestor because wordpress hurts sometimes
				$nav_block_as_vertical_sidebar.currentParent.addClass(
					"current-page-ancestor"
				);

				// ? naturally expand using aria
				$nav_block_as_vertical_sidebar.currentParent
					.children("[aria-expanded]")
					.attr("aria-expanded", "true");

				$nav_block_as_vertical_sidebar.currentParent;

				// ?
				$nav_block_as_vertical_sidebar._hashHandler();

				//
				//
				//
				// * Dan working on this part
				// * MOBILE STUFF

				// * Get the navIcon (previous sibling of nav.wp-block-navigation)
				$nav_block_as_vertical_sidebar.navIcon = $(
					$nav_block_as_vertical_sidebar.menu
				).prev();

				// * Upon clicking the nav icon
				$nav_block_as_vertical_sidebar.navIcon.on("click", function (e) {
					console.log($nav_block_as_vertical_sidebar.navIcon);

					// * Toggle the previous sibling (p.is-the-sidebar-navicon)
					$($nav_block_as_vertical_sidebar.menu)
						.prev(".is-the-sidebar-navicon")
						.toggleClass("mobile-revealed");
				});
			},

			//
			//
			//
			//
			_hashHandler: function (hash = undefined) {
				//
				let $menu = $nav_block_as_vertical_sidebar.menu;
				//
				let $hash = window.location.hash;
				//
				if (hash) {
					$hash = hash;
				}
				//
				// ? remove active from all menu items
				$nav_block_as_vertical_sidebar.menuItems
					.children("a")
					.removeClass("is-active");
				//
				// ? add active to this menu item
				let $current = $($menu).find('a[href="' + $hash + '"');
				$current.addClass("is-active");

				// ? handle parents of this menu item
				if ($current.parents(".has-child").length) {
					let $currentParent = $current.parents(".has-child");
					$currentParent
						.children(".wp-block-navigation-submenu__toggle")
						.attr("aria-expanded", "true");
				}
			},
		};

		//
		// ? new sidebar instance for each sidebar
		$(".is-vertical.wp-block-navigation").each(function (i, el) {
			//
			//
			$nav_block_as_vertical_sidebar._init(el);

			//
			//
			$(window).on("hashchange", function (e) {
				//
				let newHash = "#" + returnHashFromURL(e.originalEvent.newURL);
				//
				$nav_block_as_vertical_sidebar._hashHandler(newHash);
			});
		});

		//
		//
		//
		const sidebar_layout_pattern_handler = {
			sidebar: undefined,
			content: undefined,
			menu: undefined,
			anchorLinkEls: undefined,
			anchorLinks: undefined,
			anchorPoints: [],

			_init: function (element) {
				// hoist sidebar element
				this.sidebar = $(element).find(
					".wp-block-columns > .wp-block-column.is-the-sidebar"
				);
				// hoist sidebar menu element (container including navicon)
				this.menu = $(this.sidebar).find(".is-the-sidebar-menu");

				// hoist content column element
				this.content = $(element).find(
					".wp-block-columns > .wp-block-column.is-the-content"
				);

				// menu handler
				if (this.menu.length) {
					this._menuHandler();
				}

				// ? spy on scroll and update the jump-links if they are there
				// ! this actually just runs and hits too much debounce it and conditional it please
				$(window).on("scroll load", function () {
					for (
						let index = 0;
						index < sidebar_layout_pattern_handler.anchorPoints.length;
						index++
					) {
						const pointEl = sidebar_layout_pattern_handler.anchorPoints[index];
						const linkEl = sidebar_layout_pattern_handler.anchorLinkEls[index];
						if (window.pageYOffset > $(pointEl).offset().top - 220) {
							$(sidebar_layout_pattern_handler.anchorLinkEls).removeClass(
								"is-active"
							);

							$(linkEl).addClass("is-active");

							// ? handle parents of this menu item
							$current = $(linkEl);

							if ($current.parents(".has-child").length) {
								let $allParents =
									sidebar_layout_pattern_handler.menu.find(".has-child");
								$allParents
									.children(".wp-block-navigation-submenu__toggle")
									.attr("aria-expanded", "false");
								//
								let $currentParent = $current.parents(".has-child");
								$currentParent
									.children(".wp-block-navigation-submenu__toggle")
									.attr("aria-expanded", "true");
							}
						}
					}
				});
				//
			},

			//
			_menuHandler: function () {
				// isolate the menu items for later
				let menuItems = $(this.menu).find(
					".wp-block-navigation.is-vertical .wp-block-navigation-link"
				);
				// isolate the href values of any anchor links found in the menu
				this.anchorLinkEls = $(this.menu).find('a[href^="#"');
				this.anchorLinks = $(this.menu)
					.find('a[href^="#"')
					.map(function () {
						return $(this).attr("href").replace("#", "");
					});
				//
				$(this.anchorLinks).each(function (i, element) {
					// the match if we found it
					let $match = $(sidebar_layout_pattern_handler.content).find(
						'[id="' + element + '"]'
					);
					// isolate all the matched elements by ID
					sidebar_layout_pattern_handler.anchorPoints.push($match);
				});
			},
		};

		$(".patterns--layouts--content-with-sidebar").each(function (
			index,
			element
		) {
			sidebar_layout_pattern_handler._init(element);
		});

		// * For opening and closing sidebar navigation on mobile
		if ($(document).width() <= 1024) {
			$(".is-the-sidebar-group")
				.find(".is-style-eyebrow")
				.click(function () {
					if ($(this).attr("data-content") != "close") {
						$(this).attr("data-content", "close");
						$(".is-the-sidebar-menu").show();
						$(".wp-block-navigation__responsive-container").show();
					} else {
						$(this).removeAttr("data-content");
						$(".is-the-sidebar-menu").hide();
					}
				});
			// * If a menu item is selected, collapse the menu
			$(".wp-block-navigation__container").click(function () {
				$(".is-the-sidebar-menu").hide();
				$(".is-the-sidebar-group")
					.find(".is-style-eyebrow")
					.removeAttr("data-content");
			});
		}

		// * For making sure resizing also triggers sidebar nav toggle
		$(window).resize(function () {
			if ($(document).width() > 1024) {
				$(".is-the-sidebar-menu").show();
			}

			if ($(document).width() < 1024) {
				// * Reset the menu
				$(this).removeAttr("data-content");
				$(".is-the-sidebar-menu").hide();
				//
				$(".is-the-sidebar-group")
					.find(".is-style-eyebrow")
					.click(function () {
						if ($(this).attr("data-content") != "close") {
							$(this).attr("data-content", "close");
							$(".is-the-sidebar-menu").show();
							$(".wp-block-navigation__responsive-container").show();
						} else {
							$(this).removeAttr("data-content");
							$(".is-the-sidebar-menu").hide();
						}
					});
			}
		});

		//
		// ? end of $.ready
		//
	});
})(window.jQuery, window, document);
