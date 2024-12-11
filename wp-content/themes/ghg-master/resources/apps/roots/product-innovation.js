import { StrictMode, useEffect, useState } from 'react';
import ReactDOM from 'react-dom/client';
import ExtractID from '../util/extractID';
import UseWordPressData from '../services/useWordPressData';
import LoadingAnimation from '../components/loading-animation/loading-animation';
import NewsAndEventsCard from '../components/news-and-media-card/news-and-media-card';

const ProductInnovation = () => {
	const [innovation, setInnovation] = useState([]);
	const page_ID = ExtractID('page-id');
	const data = UseWordPressData('get_product_innovation', page_ID, 0);

	useEffect(() => {
		if (data.posts) {
			setInnovation(data.posts);
		}
	}, [data]);

	if (!innovation.length > 0) {
		return (
			<>
				<LoadingAnimation type="news"></LoadingAnimation>
			</>
		);
	}

	return (
		<StrictMode>
			<div className="product-innovation__grid">
				{innovation.map((item, index) => (
					<NewsAndEventsCard
						key={index}
						title={item.title}
						image_URL={item.image_URL}
						permalink={item.permalink}
						excerpt={item.excerpt}
						button_text={item.button_text}
					></NewsAndEventsCard>
				))}
			</div>
		</StrictMode>
	);
};
export default ProductInnovation;

const rootElement = document.getElementById('product-innovation--react');
if (rootElement) {
	ReactDOM.createRoot(rootElement).render(<ProductInnovation />);
}
