import './news-and-media-grid.scss';
import LoadingAnimation from '../loading-animation/loading-animation';
import {useContext, useEffect, useState} from 'react';
import NewsAndEventsCard from '../news-and-media-card/news-and-media-card';
import newsAndMediaContext from '../../context/newsAndMediaContext';

const className = 'news-and-events-grid';

const NewsAndEventsGrid = () => {
	const [posts, setPosts] = useState([]);
	const [ID, setID] = useState(0);
	const [newsFiltersGlobal] = useContext(newsAndMediaContext);
	const [preSetFilters, setPreSetFilters] = useState(0);
	const [initialLoad, setInitialLoad] = useState(true);

	// This useEffect gets the page id
	useEffect(() => {
		// Extract the value from the page-id class on the body element
		const bodyClass = document.body.className;
		const pageIdRegex = /page-id-(\d+)/;
		const match = pageIdRegex.exec(bodyClass);
		const extractedID = match ? parseInt(match[1]) : null;

		// Check if the page-id class is found
		if (match) {
			// Set the extracted ID to the state variable
			setID(extractedID);
		} else {
			// Handle the case when the page-id class is not found
			console.error('page-id class not found on the body element');
		}
	}, []);

	// This useEffect gets the initial load of posts after get the page id
	useEffect(() => {
		if (ID > 0) {
			fetchData();
		}
	}, [ID]);

	// This useEffect resets the posts when a new filter has been selected
	// useEffect(() => {
	// 	fetchData();
	// }, [newsFiltersGlobal]);

	// This useEffect finds preselected filters and applies an active class
	useEffect(() => {
		if (preSetFilters.length && initialLoad === true) {
			const filterIds = preSetFilters.split(',');
			const elements = document.querySelectorAll(
				'li.news-and-events-filters__item[data-id]'
			);
			elements.forEach((element) => {
				const dataId = element.getAttribute('data-id');
				if (filterIds.includes(dataId)) {
					element.classList.add(
						'news-and-events-filters__item--active'
					);
				}
			});

			setInitialLoad(false);
		}
	}, [preSetFilters, initialLoad]);

	const fetchData = async () => {
		const response = await fetch(ajax_params.ajaxurl, {
			method: 'POST',
			credentials: 'same-origin',
			headers: {
				'Content-Type': 'application/x-www-form-urlencoded',
				'Cache-Control': 'no-cache',
			},
			body: new URLSearchParams({
				action: 'get_news_and_events',
				filters: newsFiltersGlobal,
				ID,
			}),
		});
		const data = await response.json();
		setPosts(data.posts);
		setPreSetFilters(data.active_filters);
	};

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
