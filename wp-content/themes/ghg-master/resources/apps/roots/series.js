import { StrictMode, useEffect, useState } from 'react';
import ReactDOM from 'react-dom/client';
import ExtractID from '../util/extractID';
import UseWordPressData from '../services/useWordPressData';
import seriesContext from '../context/seriesContext';
import DisplayNumber from '../components/display-number/display-number';
import LoadMoreButton from '../components/load-more-button/load-more-button';
import { createPortal } from 'react-dom';
import ProductGrid from '../components/product-grid/product-grid';

const AUTProducts = () => {
	const [seriesGlobal, setSeriesGlobal] = useState([]);
	const page_ID = ExtractID('page-id') || ExtractID('term');
	const tax = ExtractID('tax');
	const data = UseWordPressData('get_series', page_ID, 1, tax);
	const [displayLoading] = useState(false);

	useEffect(() => {
		if (data.success) {
			const additional_data = {
				...data.data.additional_data,
				page_ID: page_ID,
				tax: tax,
				displayLoading: displayLoading,
			};

			const combinedData = {
				data: [],
				additional_data: additional_data,
			};
			setSeriesGlobal(combinedData);
		}
	}, [data]);

	return (
		<StrictMode>
			<seriesContext.Provider value={[seriesGlobal, setSeriesGlobal]}>
				{createPortal(
					<DisplayNumber></DisplayNumber>,
					document.getElementById('AUTSeriesDetails')
				)}

				<ProductGrid data={seriesGlobal} card={'aut'}></ProductGrid>

				{createPortal(
					<LoadMoreButton
						action="get_series"
						buttonText="Load more series"
						context={seriesContext}
						ID={page_ID}
					/>,
					document.getElementById('AUTSeriesLoadMoreButton')
				)}
			</seriesContext.Provider>
		</StrictMode>
	);
};
export default AUTProducts;

const rootElement = document.getElementById('series--react');
if (rootElement) {
	ReactDOM.createRoot(rootElement).render(<AUTProducts />);
}
