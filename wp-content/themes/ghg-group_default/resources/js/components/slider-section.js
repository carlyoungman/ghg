import createSlider from '../utils/create-slider';

export default function sliderSection() {
	const slider = document.querySelectorAll('.slider-section__slider');

	const config = {
		type: 'carousel',
		autoplay: 5000,
		perView: 3,
		gap: 30,
		controls: true,
		focusAt: 'center',
		animationDuration: 600,
		breakpoints: {
			992: {
				perView: 2,
			},
			768: {
				perView: 1,
			}
		},
	};

	slider.forEach((el) => {
		createSlider(el, config);
	});
}
