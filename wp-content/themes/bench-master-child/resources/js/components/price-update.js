export default function PriceUpdate(
	originalPriceSelector,
	vatRate,
	updateInterval
) {
	function checkOriginalPrices() {
		const originalPrices = document.querySelectorAll(originalPriceSelector);

		if (
			originalPrices.length > 0 &&
			Array.from(originalPrices).some(
				(element) => element.children.length > 0
			)
		) {
			originalPrices.forEach((originalPrice) => {
				if (!originalPrice.classList.contains('priceWithoutTax')) {
					const clonedPrice = originalPrice.cloneNode(true);
					originalPrice.classList.add('priceWithoutTax');
					clonedPrice.classList = 'priceWithTax';
					originalPrice.parentNode.insertBefore(
						clonedPrice,
						originalPrice.nextSibling
					);

					const updateClonedValue = () => {
						const originalValue = parseFloat(
							originalPrice.textContent.replace(/[^\d.]/g, '')
						);
						const newValue = originalValue * (1 + vatRate / 100); // Calculate VAT

						// Create a span element for (Inc. VAT)
						const incVATSpan = document.createElement('span');
						incVATSpan.textContent = ' (Inc. VAT)';

						// Append the span to the clonedPrice
						clonedPrice.textContent = '£' + newValue.toFixed(2);
						clonedPrice.appendChild(incVATSpan);
					};

					updateClonedValue();

					setInterval(updateClonedValue, updateInterval);
				}
			});
		}
	}

	checkOriginalPrices();

	setInterval(checkOriginalPrices, updateInterval);
}
