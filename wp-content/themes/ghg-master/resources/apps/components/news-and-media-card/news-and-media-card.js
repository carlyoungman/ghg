const className = 'news-and-media-card';
const NewsAndEventsCard = (props) => {
	const {
		title,
		image_URL,
		post_date,
		permalink,
		excerpt,
		categories,
		button_text,
	} = props;
	let image_class = `${className}__image`;
	if (image_URL && image_URL.includes('fallback')) {
		image_class = `${className}__image--fallback`;
	}
	return (
		<div className={className}>
			<div className={`${className}__image-wrap`}>
				<a href={permalink}>
					<img className={image_class} alt={title} src={image_URL} />
				</a>
				<svg
					className={`${className}__image-cut`}
					viewBox="0 0 78 84"
					fill="none"
					xmlns="http://www.w3.org/2000/svg"
				>
					<path d="M78 84L0 84L78 0L78 84Z" fill="#E8AF5F" />
				</svg>
			</div>
			<article className={`${className}__article`}>
				<h5
					className={`${className}__headline`}
					dangerouslySetInnerHTML={{ __html: title }}
				></h5>
				<p className={`${className}__excerpt`}>{excerpt}</p>
				<a href={permalink} className={`${className}__link`}>
					<span>{button_text}</span>
				</a>
			</article>
		</div>
	);
};
export default NewsAndEventsCard;
