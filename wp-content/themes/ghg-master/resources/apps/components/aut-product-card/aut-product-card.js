const className = 'aut-product-card';
const AutProductCard = (props) => {
	const {
		title,
		series,
		image_url,
		permalink,
		description,
		button_text,
		tags,
		fixing_type,
	} = props;
	let image_class = `${className}__image`;
	if (image_url && image_url.includes('fallback')) {
		image_class = `${className}__image--fallback`;
	}
	return (
		<div className={className}>
			<a href={permalink} className={`${className}__image-wrap`}>
				<img className={image_class} alt={title} src={image_url} />
			</a>
			<article className={`${className}__article`}>
				<h4
					className={`${className}__series`}
					dangerouslySetInnerHTML={{ __html: series }}
				/>
				{tags.length > 0 && (
					<ul className={`${className}__tags`}>
						{tags.map((tag, index) => (
							<li
								className={`${className}__tag`}
								key={index}
								dangerouslySetInnerHTML={{ __html: tag }}
							></li>
						))}
					</ul>
				)}
				<h6
					className={`${className}__title`}
					dangerouslySetInnerHTML={{ __html: title }}
				></h6>
				<p
					className={`${className}__description`}
					dangerouslySetInnerHTML={{ __html: description }}
				></p>
				<a className={`${className}__btn`} href={permalink}>
					{button_text}
				</a>
			</article>
			<a className={`${className}__fixing_type`} href={permalink}>
				<span>
					<p>Fixing type</p>
					<h5 dangerouslySetInnerHTML={{ __html: fixing_type }}></h5>
				</span>
			</a>
		</div>
	);
};
export default AutProductCard;
