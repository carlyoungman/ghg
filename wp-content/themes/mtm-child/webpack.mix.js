/**
 * Laravel Mix based WebPack setup
 *
 * @type {exports | Api}
 */

const mix = require('laravel-mix');

//file locations
const dist = './dist/assets/';
const src = {
	styles: './assets/scss/main.scss',
	scripts: './assets/js/main.js',
	favicons: './assets/favicons',
	svg: './assets/svg',
	image: './assets/images',
	fonts: './assets/fonts',
};

mix.options({ processCssUrls: false });

mix.setPublicPath('dist/')

mix.sass(src.styles, dist + '/css/');
mix.minify(dist + '/css/main.css');

//compile js, react inc for the admin
mix.js(src.scripts, dist + '/js/')
	.sourceMaps()
	.sourceMaps()
	.react();

//copy images to dist directory
mix.copy(src.image, dist + '/images/');

//copy favicons to dist directory
mix.copy(src.favicons, dist + '/favicons/');

// Copy fonts to dist directory
mix.copy(src.fonts, dist + '/fonts/');
