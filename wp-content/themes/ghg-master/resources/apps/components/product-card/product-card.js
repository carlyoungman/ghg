const className = 'card-product';
const ProductCard = (props) => {
	const {
		title,
		image_url,
		permalink,
		short_description,
		price_width_vat,
		price_without_vat,
		product_type,
	} = props;
	let image_class = `${className}__image`;
	if (image_url && image_url.includes('fallback')) {
		image_class = `${className}__image--fallback`;
	}
	// Decoding HTML entities in the title
	const decodedTitle = title ? { __html: decodeHtmlEntities(title) } : null;
	return (
		<a href={permalink} className={className}>
			<div className={`${className}__image-wrap`}>
				<img className={image_class} alt={title} src={image_url} />
			</div>
			<article className={`${className}__article`}>
				<p
					className={`${className}__headline`}
					dangerouslySetInnerHTML={decodedTitle}
				></p>
				<h5 className={`${className}__price`}>
					<span
						dangerouslySetInnerHTML={{ __html: price_width_vat }}
					></span>
					<span
						dangerouslySetInnerHTML={{ __html: price_without_vat }}
					></span>
				</h5>

				<p className={`${className}__description`}>
					{short_description}
				</p>
			</article>
		</a>
	);
};

// Function to decode HTML entities
function decodeHtmlEntities(html) {
	const txt = document.createElement('textarea');
	txt.innerHTML = html;
	return txt.value;
}

export default ProductCard;
