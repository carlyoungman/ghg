import { StrictMode, useEffect, useState } from 'react';
import ReactDOM from 'react-dom/client';
import productsContext from '../context/productsContext';
import UseWordPressData from '../services/useWordPressData';
import ProductGrid from '../components/product-grid/product-grid';
import ProductLoadMoreButton from '../components/product-load-more-button/product-load-more-button';
import ProductToggle from '../components/product-toggle/product-toggle';
import ExtractID from '../util/extractID';
import 'react-toggle/style.css';

const TaxProducts = () => {
	const termID = ExtractID('term');
	const data = UseWordPressData('get_tax_products', termID, 1);
	const [productsGlobal, setProductsGlobal] = useState([]);
	const [displayLoading] = useState(false);

	useEffect(() => {
		if (data.success) {
			const additional_data = {
				...data.data.additional_data,
				page_ID: termID,
				displayLoading: displayLoading,
				page: 1,
			};

			const combinedData = {
				data: data.data.data,
				additional_data: additional_data,
			};

			setProductsGlobal(combinedData);
		}
	}, [data]);

	return (
		<StrictMode>
			<productsContext.Provider
				value={[productsGlobal, setProductsGlobal]}
			>
				<>
					<ProductToggle></ProductToggle>
					<ProductGrid
						data={productsGlobal}
						card={'aut'}
					></ProductGrid>
					<ProductLoadMoreButton action="get_tax_products"></ProductLoadMoreButton>
				</>
			</productsContext.Provider>
		</StrictMode>
	);
};
export default TaxProducts;

const rootElement = document.getElementById('tax-product--react');
if (rootElement) {
	ReactDOM.createRoot(rootElement).render(<TaxProducts />);
}
