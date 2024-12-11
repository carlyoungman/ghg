import PriceUpdate from './components/price-update';

PriceUpdate('.woocommerce-variation-price', 20, 1000);
const summaryPrices = document.querySelectorAll('.summary .prices');
console.log('Summary Prices:', summaryPrices);
const variationTemplate = document.getElementById('tmpl-variation-template');
const picker_pa_colour = document.getElementById('picker_pa_colour');
if (variationTemplate && !picker_pa_colour) {
	console.log('Check Elements:', variationTemplate);
	summaryPrices.forEach((element) => {
		element.style.display = 'none';
	});
	console.log('Summary prices hidden.');
} else {
	console.log('Variation template not found.');
}
