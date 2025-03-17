import { StrictMode, useEffect, useState } from 'react';
import ReactDOM from 'react-dom/client';
import UseWordPressData from '../services/useWordPressData';
import LoadingAnimation from '../components/loading-animation/loading-animation';
import ExtractpageID from '../services/ExtractpageID';
import AutProductCard from '../components/aut-product-card/aut-product-card';

const ProductsAUT = () => {
	const page_ID = ExtractpageID();
	const data = UseWordPressData('get_products', page_ID, 1);
	const [products, setProducts] = useState(false);

	useEffect(() => {
		if (data.data) {
			setProducts(data.data.products);
			// const additional_data = data.data.data;
		}
	}, [data]);

	if (!products.length > 0) {
		return (
			<>
				<LoadingAnimation type="news"></LoadingAnimation>
			</>
		);
	}
	return (
		<StrictMode>
			<div className="products__grid">
				{products.map((product, index) => (
					<AutProductCard
						key={index}
						title={product.title}
						image_url={product.image_url}
						permalink={product.permalink}
						description={product.description}
						series={product.description}
						button_text={product.button_text}
						tags={product.tags}
					></AutProductCard>
				))}
			</div>
		</StrictMode>
	);
};
export default ProductsAUT;

const rootElement = document.getElementById('products--react');
if (rootElement) {
	ReactDOM.createRoot(rootElement).render(<ProductsAUT />);
}
