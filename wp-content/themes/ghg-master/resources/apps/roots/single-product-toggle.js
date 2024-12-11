import React, { useState } from 'react';
import ReactDOM from 'react-dom/client';
import 'react-toggle/style.css';
import Toggle from 'react-toggle';

const SingleProductToggle = () => {
	const [isVatIncluded, setIsVatIncluded] = useState(false);

	const handleChange = (e) => {
		const isChecked = e.target.checked;
		setIsVatIncluded(isChecked);

		// Toggle "price-with-vat" class on the body
		if (isChecked) {
			document.body.classList.add('price-with-vat');
		} else {
			document.body.classList.remove('price-with-vat');
		}
	};

	return (
		<>
			<label className="product-toggle">
				<span>Inc VAT</span>
				<Toggle
					checked={isVatIncluded}
					onChange={handleChange}
					icons={false}
				/>
			</label>
		</>
	);
};

const rootElement = document.getElementById('single-product-toggle--react');
if (rootElement) {
	ReactDOM.createRoot(rootElement).render(<SingleProductToggle />);
}
