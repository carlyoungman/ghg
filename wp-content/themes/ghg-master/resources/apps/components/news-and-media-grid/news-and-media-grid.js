import { useContext } from 'react';
import newsAndMediaContext from '../../context/newsAndMediaContext';
import NewsAndEventsCard from '../news-and-media-card/news-and-media-card';

const NewsAndMediaGrid = () => {
	const className = 'news-and-media__grid';
	const [newsGlobal] = useContext(newsAndMediaContext);
	return (
		<>
			<div className={className}>
				{newsGlobal.data.map((news, index) => (
					<NewsAndEventsCard
						key={index}
						title={news.title}
						image_URL={news.image_URL}
						permalink={news.permalink}
						excerpt={news.excerpt}
						button_text={news.button_text}
					></NewsAndEventsCard>
				))}
			</div>
		</>
	);
};

export default NewsAndMediaGrid;
