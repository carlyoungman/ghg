import { StrictMode, useEffect, useState } from 'react';
import ReactDOM from 'react-dom/client';
import ExtractID from '../util/extractID';
import UseWordPressData from '../services/useWordPressData';
import seriesContext from '../context/seriesContext';
import { createPortal } from 'react-dom';
import LoadMoreButton from '../components/load-more-button/load-more-button';
import ProductGrid from '../components/product-grid/product-grid';
import AutProductFilters from '../components/aut-product-filters/aut-product-filters';
import DisplayNumber from '../components/display-number/display-number';
import AutProductSortby from '../components/aut-product-sortby/aut-product-sortby';

const AUTProducts = () => {
	const page_ID = ExtractID('page-id') ?? ExtractID('postid');
	const single = ExtractID('single');
	const data = UseWordPressData('get_aut_products', page_ID, 1, '', single);
	const [seriesGlobal, setSeriesGlobal] = useState([]);
	const [displayLoading] = useState(false);

	useEffect(() => {
		if (data.success) {
			const additional_data = {
				...data.data.additional_data,
				page_ID: page_ID,
				displayLoading: displayLoading,
				page: 1,
			};

			const combined_data = {
				data: [],
				additional_data: additional_data,
			};

			setSeriesGlobal(combined_data);
		}
	}, [data]);

	return (
		<StrictMode>
			<seriesContext.Provider value={[seriesGlobal, setSeriesGlobal]}>
				{createPortal(
					<AutProductFilters></AutProductFilters>,
					document.getElementById('AUTProductFilters')
				)}

				{createPortal(
					<DisplayNumber></DisplayNumber>,
					document.getElementById('AUTProductsDetails')
				)}
				{createPortal(
					<AutProductSortby></AutProductSortby>,
					document.getElementById('AUTProductsDetails')
				)}

				<ProductGrid data={seriesGlobal} card={'aut'}></ProductGrid>

				{createPortal(
					<LoadMoreButton
						action="get_aut_products"
						buttonText="Load more products"
						context={seriesContext}
						ID={page_ID}
					/>,
					document.getElementById('AUTProductsLoadMoreButton')
				)}
			</seriesContext.Provider>
		</StrictMode>
	);
};
const rootElement = document.getElementById('AUT-products--react');
if (rootElement) {
	ReactDOM.createRoot(rootElement).render(<AUTProducts />);
}
