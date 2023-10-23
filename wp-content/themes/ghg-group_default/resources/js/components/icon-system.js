//This JS file is responsible for the SVG sprite system. This method insures the SVG sprite gets cached
export default function iconSystem() {
	const baseURL = '/wp-content/themes/ghg-group_default/dist/svg/svg-sprite.svg';
	const div = document.createElement('div');
	div.className += 'master-svg';
	// eslint-disable-next-line no-undef
	fetch(baseURL)
		.then((response) => response.text())
		.then((svg) => (div.innerHTML = svg));
	document.body.insertBefore(div, document.body.childNodes[0]);
}
