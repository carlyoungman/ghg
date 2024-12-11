import './product-toggle.scss';
import Toggle from 'react-toggle';
import { useContext, useState, useEffect } from 'react';
import productsContext from '../../context/productsContext';

const ProductToggle = () => {
	const [productsGlobal, setProductsGlobal] = useContext(productsContext);
	const [showVat, setShowVat] = useState(false);

	useEffect(() => {
		if (
			productsGlobal.additional_data &&
			typeof productsGlobal.additional_data === 'object'
		) {
			setShowVat(productsGlobal.additional_data.show_vat);
		}
	}, [productsGlobal]);

	const handleChange = () => {
		const newShowVat = !showVat;
		setShowVat(newShowVat);

		setProductsGlobal((prevProductsGlobal) => {
			return {
				...prevProductsGlobal,
				additional_data: {
					...prevProductsGlobal.additional_data,
					show_vat: newShowVat,
				},
			};
		});
	};

	return (
		<>
			<label className="product-toggle">
				<span>Inc VAT</span>
				<Toggle
					checked={showVat}
					onChange={handleChange}
					icons={false}
				/>
			</label>
		</>
	);
};

export default ProductToggle;
