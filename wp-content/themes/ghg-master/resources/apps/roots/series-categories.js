import { StrictMode, useEffect, useState } from 'react';
import ReactDOM from 'react-dom/client';
import ProductCategoriesCard from '../components/product-categories-card/product-categories-card';
import LoadingAnimation from '../components/loading-animation/loading-animation';
import ExtractID from '../util/extractID';
import UseWordPressData from '../services/useWordPressData';

const SeriesCategories = () => {
	const [categories, setCategories] = useState([]);
	const page_ID = ExtractID('page-id') ?? ExtractID('postid');
	const data = UseWordPressData('get_series_categories', page_ID);

	useEffect(() => {
		if (data.data) {
			setCategories(data.data);
		}
	}, [data]);

	if (!categories.length > 0) {
		return (
			<>
				<LoadingAnimation type="series"></LoadingAnimation>
			</>
		);
	}

	return (
		<StrictMode>
			<div className="product-categories__grid">
				{categories.map((category, index) => (
					<ProductCategoriesCard
						key={index}
						title={category.title}
						image_url={category.image_url}
						permalink={category.permalink}
						short_description={category.short_description}
						button_text={category.button_text}
					></ProductCategoriesCard>
				))}
			</div>
		</StrictMode>
	);
};
export default SeriesCategories;

const rootElement = document.getElementById('series-categories--react');
if (rootElement) {
	ReactDOM.createRoot(rootElement).render(<SeriesCategories />);
}
