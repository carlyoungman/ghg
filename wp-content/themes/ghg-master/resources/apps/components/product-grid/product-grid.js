import LoadingAnimation from '../loading-animation/loading-animation';
import AutProductCard from '../aut-product-card/aut-product-card';
import ProductCard from '../product-card/product-card';
import { useEffect, useState } from 'react';

const ProductGrid = (props) => {
	const { data, card = {} } = props;
	const className = 'products-grid';
	const [products, setProducts] = useState([]);
	const [displayLoading, setDisplayLoading] = useState(false);

	useEffect(() => {
		if (data.data) {
			setProducts(data.data);
			setDisplayLoading(data.additional_data.displayLoading);
		}
	}, [data]);

	if (displayLoading === false) {
		return <></>;
	}

	if (products.length === 0) {
		return (
			<>
				<LoadingAnimation type="products" />
			</>
		);
	}
	return (
		<>
			<div className={className}>
				{products.map((item, index) => {
					if (card === 'aut') {
						return (
							<AutProductCard
								key={index}
								title={item.content.title}
								series={item.content.series}
								image_url={item.image_url}
								permalink={item.permalink}
								description={item.content.description}
								button_text={item.button_text}
								tags={item.tags}
								fixing_type={item.content.fixing_type}
							/>
						);
					} else {
						return (
							<ProductCard
								key={index}
								title={item.title}
								image_url={item.image_url}
								permalink={item.permalink}
								short_description={item.short_description}
								price_width_vat={item.price_with_vat}
								price_without_vat={item.price_without_vat}
								product_type={item.product_type}
							/>
						);
					}
				})}
			</div>
		</>
	);
};

export default ProductGrid;
