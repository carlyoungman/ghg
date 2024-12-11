const className = 'product-categories-card';
const ProductCategoriesCard = (props) => {
	const { title, image_url, permalink, short_description, button_text } =
		props;
	let image_class = `${className}__image`;
	if (image_url && image_url.includes('fallback')) {
		image_class = `${className}__image--fallback`;
	}
	return (
		<div className={className}>
			<div className={`${className}__image-wrap`}>
				<a href={permalink}>
					<img className={image_class} alt={title} src={image_url} />
				</a>
			</div>
			<article className={`${className}__article`}>
				<h5
					className={`${className}__headline`}
					dangerouslySetInnerHTML={{ __html: title }}
				></h5>
				<p
					className={`${className}__description`}
					dangerouslySetInnerHTML={{ __html: short_description }}
				></p>
				<a href={permalink} className={`${className}__button`}>
					{button_text}
				</a>
			</article>
		</div>
	);
};
export default ProductCategoriesCard;
