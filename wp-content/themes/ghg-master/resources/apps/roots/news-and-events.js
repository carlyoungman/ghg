import { StrictMode, useEffect, useState } from 'react';
import ReactDOM from 'react-dom/client';
import ExtractID from '../util/extractID';
import UseWordPressData from '../services/useWordPressData';
import newsAndMediaContext from '../context/newsAndMediaContext';
import NewsAndMediaGrid from '../components/news-and-media-grid/news-and-media-grid';
import LoadMoreButton from '../components/load-more-button/load-more-button';

const NewsAndEvents = () => {
	const page_ID = ExtractID('page-id');
	const data = UseWordPressData('get_news_and_events', page_ID, 1);
	const [newsGlobal, setNewsGlobal] = useState([]);

	useEffect(() => {
		if (data.success) {
			const additional_data = {
				...data.data.additional_data,
				page_ID: page_ID,
			};
			const combinedData = {
				data: [],
				additional_data: additional_data,
			};
			setNewsGlobal(combinedData);
		}
	}, [data]);

	if (!newsGlobal || newsGlobal.length === 0) {
		return <></>;
	}

	return (
		<StrictMode>
			<newsAndMediaContext.Provider value={[newsGlobal, setNewsGlobal]}>
				<NewsAndMediaGrid></NewsAndMediaGrid>
				<LoadMoreButton
					action="get_news_and_events"
					buttonText="Load more content"
					context={newsAndMediaContext}
					ID={page_ID}
				/>
			</newsAndMediaContext.Provider>
		</StrictMode>
	);
};
export default NewsAndEvents;

const rootElement = document.getElementById('news-and-events--react');
if (rootElement) {
	ReactDOM.createRoot(rootElement).render(<NewsAndEvents />);
}
