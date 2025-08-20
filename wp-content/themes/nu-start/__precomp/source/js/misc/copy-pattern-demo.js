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
		async function copyCode(event) {
			let code = event.delegateTarget.parentElement.nextElementSibling;
			let text = code.innerText;
			await navigator.clipboard.writeText(text);
			alert("Pattern copied to clipboard, now paste it into your page!");
		}
		$(".wp-block-button.js__copyPattern").on("click", function (e) {
			if (!e.delegateTarget.parentElement.nextElementSibling) {
				return;
			}
			copyCode(e);
		});
	});
})(window.jQuery, window, document);
