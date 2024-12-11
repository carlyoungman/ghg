import { StrictMode, useEffect, useState } from 'react';
import ReactDOM from 'react-dom/client';
import ExtractID from '../util/extractID';
import UseWordPressData from '../services/useWordPressData';
import LoadingAnimation from '../components/loading-animation/loading-animation';
import NewsAndEventsCard from '../components/news-and-media-card/news-and-media-card';

const CaseStudies = () => {
	const [caseStudies, setCaseStudies] = useState([]);
	const page_ID = ExtractID('page-id');
	const data = UseWordPressData('get_case_studies', page_ID, 1);

	useEffect(() => {
		if (data.posts) {
			setCaseStudies(data.posts);
		}
	}, [data]);

	if (!caseStudies.length > 0) {
		return (
			<>
				<LoadingAnimation type="news"></LoadingAnimation>
			</>
		);
	}

	return (
		<StrictMode>
			<div className="case-studies__grid">
				{caseStudies.map((study, index) => (
					<NewsAndEventsCard
						key={index}
						title={study.title}
						image_URL={study.image_URL}
						permalink={study.permalink}
						excerpt={study.excerpt}
						button_text={study.button_text}
					></NewsAndEventsCard>
				))}
			</div>
		</StrictMode>
	);
};
export default CaseStudies;

const rootElement = document.getElementById('case-studies--react');
if (rootElement) {
	ReactDOM.createRoot(rootElement).render(<CaseStudies />);
}
