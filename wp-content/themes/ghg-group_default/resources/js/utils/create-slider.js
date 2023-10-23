/**
 * Glide.js slider
 * config options can be found here: https://glidejs.com/docs/options/
 *
 * @param  selector
 * @param  config
 */
import Glide from '@glidejs/glide';
//This function is used to create a Glide.js slider. It accepts a selector and config
export default function createSlide(selector, config) {
	const glide = new Glide(selector, config);
	glide.mount();
	setTimeout(function () {
		glide.update();
	}, 1000);

	// Triggers a window resize to insure the slider has to correct widths
	setTimeout(() => {
		const evt = window.document.createEvent('UIEvents');
		evt.initUIEvent('resize', true, false, window, 0);
		window.dispatchEvent(evt);
	}, 1000);
	window.addEventListener(
		'resize',
		function () {
			glide.update();
		},
		true
	);
	return glide;
}
