(function ($, window, document) {
	/**
	 *   ... code out here will run immediately on load
	 */

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
	/**
	 *
	 *   ... code in here will run after jQuery says document is ready
	 */
	$(function () {
		//
		if ($(".page-sidebar-container").length != 0) {
			const sidebarWidth = $("body").css("--sidebar--width");
			$(".page-sidebar-container").on(
				"click",
				".page-sidebar-toggle",
				function (e) {
					$(e.delegateTarget).toggleClass("is-tucked-away");
					$("body").toggleClass("page-sidebar-is-tucked-away");
				}
			);
		}

		if ($(".jump-nav a").length) {
			$(".jump-nav a").click(function () {
				$(".jump-nav a.active").removeClass("active");
				$(this).addClass("active");
			});
		}

		let pie_chart_handler = {
			chartInstance: null,
			chartData: {},
			chartElement: undefined,
			chartType: "doughnut",
			//
			
			//
			//
			_get_chart_data: function () {
				//
				let data = {
					labels: [
						"Black Neutral U",
						"White",
						"Warm Grey 1 U",
						"Warm Grey 42 U",
						"405 U",
						"NU red",
						"Blue 2188 U",
						"Blue 631 U",
						"Green 001",
						"Green 003",
						"Yellow 7549 U",
						"Yellow 2004 U",
					],
					datasets: [
						{
							label: "NU Brand Colors",
							data: [31, 31, 9, 9, 9, 2, 1.5, 1.5, 1.5, 1.5, 1.5, 1.5],
							backgroundColor: [
								"#000000",
								"#FFFFFF",
								"#F4F2F0",
								"#D2CDCA",
								"#696158",
								"#C8102E",
								"#0C3354",
								"#62B6D0",
								"#609F80",
								"#BDE9C9",
								"#FFB838",
								"#FFD580",
							],
							hoverOffset: 4,
						},
					],
				};

				return data;
			},

			//
			//
			//
			_initiate_chart: function () {
				// pull chart object from window (custom HTML block passed in link to CDN)
				const Chart = window.Chart;

				// run the chart now; but only once...
				new Chart(this.chartElement, {
					type: this.chartType,
					data: this.chartData,
					options: {
						animation: {
							duration: 3000,
						},
						plugins: {
							legend: {
								display: false,
							},
							tooltip: {
								callbacks: {
									label: function (context) {
										let label = "";
										if (context.parsed.y !== null) {
											label += context.parsed + "%";
										}
										return label;
									},
								},
							},
						},
					},
				});
			},
			//
			_init: function (id) {
				// ? bail early...
				if (!window.Chart) {
					return;
				}
				// ? preparing this for when we may want to feed data in from the CMS
				this.chartData = this._get_chart_data();
				this.chartElement = document.getElementById(id).getContext("2d");
				this.chartType = $(document.getElementById(id)).data("chart-type");

				this._initiate_chart();
				// ?
			},
		};

		let chart_types_as_ids = ["color-balance-doughnut", "color-balance-pie"];
		chart_types_as_ids.forEach((id) => {
			pie_chart_handler._init(id);
		});

		// root is the browser viewport / screen
		var observer = new IntersectionObserver(
			function (entries) {
				entries.forEach((entry) => {
					if (entry["intersectionRatio"] === 1) {
						// console.log("More than 50% of target is visible in the screen");
						// let chartInstance = pie_chart_handler._init();
					}
				});
			},
			{ threshold: [0, 0.5, 1] }
		);
		// observer.observe(document.querySelector(".pie-chart-container"));

		//
	});
})(window.jQuery, window, document);
