import { StrictMode, useEffect, useState } from 'react';
import ReactDOM from 'react-dom/client';
import ExtractID from '../util/extractID';
import UseWordPressData from '../services/useWordPressData';
import LoadingAnimation from '../components/loading-animation/loading-animation';
import NewsAndEventsCard from '../components/news-and-media-card/news-and-media-card';

const Sectors = () => {
	const [sectors, setSectors] = useState([]);
	const page_ID = ExtractID('page-id');
	const data = UseWordPressData('get_sector', page_ID, 0);

	useEffect(() => {
		if (data.posts) {
			setSectors(data.posts);
		}
	}, [data]);

	if (!sectors.length > 0) {
		return (
			<>
				<LoadingAnimation type="news"></LoadingAnimation>
			</>
		);
	}

	return (
		<StrictMode>
			<div className="sectors__grid">
				{sectors.map((sector, index) => (
					<NewsAndEventsCard
						key={index}
						title={sector.title}
						image_URL={sector.image_URL}
						permalink={sector.permalink}
						excerpt={sector.excerpt}
						button_text={sector.button_text}
					></NewsAndEventsCard>
				))}
			</div>
		</StrictMode>
	);
};
export default Sectors;

const rootElement = document.getElementById('sectors--react');
if (rootElement) {
	ReactDOM.createRoot(rootElement).render(<Sectors />);
}
