import { StrictMode, useEffect, useState } from 'react';
import ReactDOM from 'react-dom/client';
import ProductCategoriesCard from '../components/product-categories-card/product-categories-card';
import LoadingAnimation from '../components/loading-animation/loading-animation';
import ExtractID from '../util/extractID';
import UseWordPressData from '../services/useWordPressData';

const ProductCategories = () => {
	const [categories, setCategories] = useState([]);
	const page_ID = ExtractID('page-id');
	const data = UseWordPressData('get_product_categories', page_ID, 0);

	useEffect(() => {
		if (data.data) {
			setCategories(data.data);
		}
	}, [data]);

	if (!categories.length > 0) {
		return (
			<>
				<LoadingAnimation type="news"></LoadingAnimation>
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
export default ProductCategories;

const rootElement = document.getElementById('product-categories--react');
if (rootElement) {
	ReactDOM.createRoot(rootElement).render(<ProductCategories />);
}
