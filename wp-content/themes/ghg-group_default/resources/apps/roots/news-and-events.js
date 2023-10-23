import {StrictMode, useState} from 'react';
import ReactDOM from 'react-dom/client';
// import NewsAndEventsFilters from '../components/news-and-media-filters/news-and-events-filters';
import NewsAndEventsGrid from '../components/news-and-media-grid/news-and-media-grid';
import newsAndMediaContext from '../context/newsAndMediaContext';

const NewsAndEvents = () => {
	const [newsFiltersGlobal, setNewsFiltersGlobal] = useState([]);
	return (
		<StrictMode>
			<newsAndMediaContext.Provider
				value={[newsFiltersGlobal, setNewsFiltersGlobal]}
			>
				{/*<NewsAndEventsFilters></NewsAndEventsFilters>*/}
				<NewsAndEventsGrid></NewsAndEventsGrid>
			</newsAndMediaContext.Provider>
		</StrictMode>
	);
};
export default NewsAndEvents;

const rootElement = document.getElementById('news-and-events--react');
if (rootElement) {
	ReactDOM.createRoot(rootElement).render(<NewsAndEvents/>);
}
