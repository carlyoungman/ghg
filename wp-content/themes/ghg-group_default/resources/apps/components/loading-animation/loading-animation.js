import './loading-animation.scss';

const LoadingAnimation = (props) => {
	const {type} = props;
	const cards = [];
	let numCards;
	let numItems;

	if ('news' === type) {
		numCards = 3;
		numItems = 5;
	}
	for (let i = 0; i < numCards; i++) {
		const items = [];
		for (let j = 0; j < numItems; j++) {
			items.push(<li key={j}></li>);
		}
		cards.push(
			<div key={i} className="loading-animation__card">
				<div className="loading-animation__image"></div>
				<ul className="loading-animation__article">{items}</ul>
			</div>
		);
	}

	return (
		<div className={`loading-animation loading-animation--${type}`}>
			{cards}
		</div>
	);
};

export default LoadingAnimation;
