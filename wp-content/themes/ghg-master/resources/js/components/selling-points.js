import createSlider from '../utils/create-slider';

export default function sellingPoints() {
	const slider = document.querySelectorAll('.selling-points__slider');

	const config = {
		type: 'carousel',
		autoplay: 5000,
		perView: 4,
		gap: 0,
		controls: false,

		animationDuration: 600,
		breakpoints: {
			992: {
				perView: 1,
			},
		},
	};

	slider.forEach((el) => {
		createSlider(el, config);
	});
}
