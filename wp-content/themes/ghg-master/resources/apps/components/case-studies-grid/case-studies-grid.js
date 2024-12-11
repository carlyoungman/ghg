import './news-and-media-grid.scss';
import LoadingAnimation from '../loading-animation/loading-animation';
import { useState } from 'react';
import NewsAndEventsCard from '../news-and-media-card/news-and-media-card';

const className = 'news-and-events-grid';

const NewsAndEventsGrid = () => {
	const [posts, setPosts] = useState([]);

	if (!posts.length > 0) {
		return (
			<>
				<LoadingAnimation type="news"></LoadingAnimation>
			</>
		);
	}

	return (
		<>
			<div className={className}>
				{posts.map((post, index) => (
					<NewsAndEventsCard
						key={index}
						title={post.title}
						image_URL={post.image_URL}
						post_date={post.post_date}
						permalink={post.permalink}
						excerpt={post.excerpt}
						categories={post.categories}
					></NewsAndEventsCard>
				))}
			</div>
		</>
	);
};

export default NewsAndEventsGrid;
