import { StrictMode, useEffect, useState } from 'react';
import ReactDOM from 'react-dom/client';
import productsContext from '../context/productsContext';
import UseWordPressData from '../services/useWordPressData';
import ProductGrid from '../components/product-grid/product-grid';
import ExtractID from '../util/extractID';
import 'react-toggle/style.css';
import LoadMoreButton from '../components/load-more-button/load-more-button';

const Products = () => {
	const page_ID = ExtractID('page-id') ?? ExtractID('postid');
	const tax = ExtractID('tax');
	const data = UseWordPressData('get_products', page_ID, 1);
	const [productsGlobal, setProductsGlobal] = useState([]);
	const [displayLoading] = useState(false);

	useEffect(() => {
		if (data.success) {
			const additional_data = {
				...data.data.additional_data,
				page_ID: page_ID,
				tax: tax,
				displayLoading: displayLoading,
				page: 1,
			};

			const combinedData = {
				data: [],
				additional_data: additional_data,
			};

			setProductsGlobal(combinedData);
		}
	}, [data]);

	if (!productsGlobal || productsGlobal.length === 0) {
		return <></>;
	}

	return (
		<StrictMode>
			<productsContext.Provider
				value={[productsGlobal, setProductsGlobal]}
			>
				<ProductGrid data={productsGlobal}></ProductGrid>
				<LoadMoreButton
					action="get_products"
					buttonText="Load more products"
					context={productsContext}
					ID={page_ID}
				/>
			</productsContext.Provider>
		</StrictMode>
	);
};
export default Products;

const rootElement = document.getElementById('products--react');
if (rootElement) {
	ReactDOM.createRoot(rootElement).render(<Products />);
}
