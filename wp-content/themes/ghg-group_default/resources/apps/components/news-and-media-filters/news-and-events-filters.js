import {Filter} from 'lucide-react';
import {useContext, useEffect, useState} from 'react';
import newsAndMediaContext from '../../context/newsAndMediaContext';
import useWordPressData from '../../services/useWordPressData';
import LoadingAnimation from '../loading-animation/loading-animation';
import './news-and-events-filters.scss';

const className = 'news-and-events-filters';
const NewsAndEventsFilters = () => {
	const [filters, setFilters] = useState([]);
	const [activeFilters, setActiveFilters] = useState([]);
	const [newsFiltersGlobal, setNewsFiltersGlobal] =
		useContext(newsAndMediaContext);

	const data = useWordPressData('get_news_and_events_filters');

	useEffect(() => {
		if (data.data) {
			const filtersArray = Object.values(data.data);
			setFilters(filtersArray);
		}
	}, [data]);

	useEffect(() => {
		setNewsFiltersGlobal(activeFilters);
	}, [activeFilters]);

	const handleFilterClick = (term_id) => {
		const index = activeFilters.indexOf(term_id);

		if (index > -1) {
			// Filter is already active, remove it
			const updatedFilters = [...activeFilters];
			updatedFilters.splice(index, 1);
			setActiveFilters(updatedFilters);
		} else {
			// Filter is not active, add it
			setActiveFilters([...activeFilters, term_id]);
		}
	};

	if (!filters.length > 0) {
		return (
			<>
				<div className={`${className}__headline-wrap`}>
					<h6 className={`${className}__headline`}>
						<span>
							<Filter
								className={`${className}__icon`}
								color="var( --c-theme-secondary)"
								size={25}
							/>
							News & Media Filters
						</span>
					</h6>
				</div>
				<LoadingAnimation type="filters"></LoadingAnimation>
			</>
		);
	}

	return (
		<>
			<div className={`${className}__headline-wrap`}>
				<h6 className={`${className}__headline`}>
					<span>
						<Filter
							className={`${className}__icon`}
							color="var( --c-theme-secondary)"
							size={25}
						/>
						News & Media Filters
					</span>
				</h6>
			</div>
			<ul className={className}>
				{filters.map((filter, index) => (
					<li
						className={`${className}__item ${
							activeFilters.includes(filter.term_id)
								? `${className}__item--active`
								: ''
						}`}
						key={index}
						data-id={filter.term_id}
						onClick={() => handleFilterClick(filter.term_id)}
					>
						{filter.name}
					</li>
				))}
			</ul>
		</>
	);
};

export default NewsAndEventsFilters;
