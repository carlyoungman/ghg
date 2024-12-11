import createSlider from '../utils/create-slider';

export default function imageWithContentSlider() {
	const sliders = document.querySelectorAll(
		'.image-with-content-slider__slider'
	);
	const config = {
		type: 'carousel',
		autoplay: 5000,
		perView: 1,
		gap: 30,
		controls: true,
		focusAt: 'center',
		animationDuration: 600,
	};

	let glide1, glide2; // Declare Glide instances

	sliders.forEach((el, index) => {
		const glide = createSlider(el, config);

		// Assign the first slider to glide1 and the second to glide2
		if (index === 0) {
			glide1 = glide;
		} else if (index === 1) {
			glide2 = glide;
		}
	});

	function syncGlide(master, slave) {
		master.on('run', function (e) {
			slave.go(e.direction);
		});
	}

	// Synchronize the sliders
	if (glide1 && glide2) {
		syncGlide(glide1, glide2);
		syncGlide(glide2, glide1);
	}
}
