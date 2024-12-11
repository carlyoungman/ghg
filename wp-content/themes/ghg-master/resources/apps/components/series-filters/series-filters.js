import './series-filters.scss';
import UseWordPressData from '../../services/useWordPressData';
import { useContext, useEffect, useState } from 'react';
import LoadingAnimation from '../loading-animation/loading-animation';
import SeriesFiltersButton from '../series-filters-button/series-filters-button';
import seriesContext from '../../context/seriesContext';
import ExtractID from '../../util/extractID';

const SeriesFilters = () => {
	const data = UseWordPressData('get_series_filters');
	const [seriesFilters, setSeriesFilters] = useState([]);
	const [activeFilters, setActiveFilters] = useState([]);
	const [selectedFilters, setSelectedFilters] = useState([]);
	const [showAllTerms, setShowAllTerms] = useState({});
	const [showClear, setShowClear] = useState(false);
	const [seriesGlobal, setSeriesGlobal] = useContext(seriesContext);
	const page_ID = ExtractID('page-id');
	ExtractID('term');
	useEffect(() => {
		if (data.length > 0) {
			setSeriesFilters(data);
		}
	}, [data]);

	useEffect(() => {
		const combined_data = {
			series: seriesGlobal.series,
			additional_data: seriesGlobal.additional_data,
			filters: selectedFilters,
		};
		setSeriesGlobal(combined_data);

		setShowClear(!isEmptyObject(selectedFilters));
	}, [selectedFilters]);

	const activeFilter = (index) => {
		setActiveFilters((prevActiveFilters) => {
			if (prevActiveFilters.includes(index)) {
				return prevActiveFilters.filter((item) => item !== index);
			} else {
				return [...prevActiveFilters, index];
			}
		});
	};

	const toggleFilter = (tax, term) => {
		setSelectedFilters((prevSelectedFilters) => {
			const newSelectedFilters = { ...prevSelectedFilters };

			if (
				newSelectedFilters[tax] &&
				newSelectedFilters[tax].includes(term)
			) {
				newSelectedFilters[tax] = newSelectedFilters[tax].filter(
					(item) => item !== term
				);
			} else {
				newSelectedFilters[tax] = [
					...(newSelectedFilters[tax] || []),
					term,
				];
			}

			return newSelectedFilters;
		});
	};

	const clearFilters = () => {
		setActiveFilters([]);
		setSelectedFilters([]);
		setSeriesGlobal([]);
		fetchData();
	};

	const isEmptyObject = (obj) => {
		return Object.keys(obj).length === 0;
	};

	const fetchData = async () => {
		try {
			const response = await fetch(ajax_params.ajaxurl, {
				method: 'POST',
				credentials: 'same-origin',
				headers: {
					'Content-Type': 'application/x-www-form-urlencoded',
					'Cache-Control': 'no-cache',
				},
				body: new URLSearchParams({
					action: 'get_series',
					page_ID: page_ID,
					page: 1,
					Tax: tax,
					filters: JSON.stringify([]),
				}),
			});

			const data = await response.json();

			if (data && data.success) {
				const combined_data = {
					series: data.data.series,
					additional_data: data.data.additional_data,
					no_results: !data.data.series?.length,
				};

				setSeriesGlobal(combined_data);
			}
		} catch (error) {
			console.error('Error fetching data:', error);
		}
	};

	if (!seriesFilters.length > 0) {
		return (
			<>
				<span>
					<LoadingAnimation type="series-filters"></LoadingAnimation>
				</span>
			</>
		);
	}

	return (
		<span>
			<div className="series-filters">
				<h5 className="series-filters__headline">
					Filter by{' '}
					{showClear && (
						<a
							onClick={clearFilters}
							className="series-filters__clear"
						>
							Clear Filters
						</a>
					)}
				</h5>
				<ul className="series-filters__filters">
					{seriesFilters.map((filters, index) => (
						<li
							key={index}
							className={`series-filters__filters ${
								activeFilters.includes(index)
									? 'series-filters__filters--active'
									: ''
							}`}
						>
							<p
								className="series-filters__filters__title"
								onClick={() => activeFilter(index)}
							>
								{filters.title}
							</p>
							<ul className="series-filters__filters__options">
								{filters.terms
									.slice(
										0,
										showAllTerms[index]
											? filters.terms.length
											: 10
									)
									.map((filter_term, termIndex) => (
										<li
											key={termIndex}
											className="series-filters__filters__terms"
										>
											<label
												htmlFor={`filter_${index}_${termIndex}`}
												className="series-filters__checkbox-label"
											>
												{filter_term.title}
											</label>
											<label className="series-filters__checkbox-container">
												<input
													data-tax={filters.id}
													data-term={filter_term.id}
													type="checkbox"
													className="series-filters__checkbox-input"
													id={`filter_${index}_${termIndex}`}
													onChange={() =>
														toggleFilter(
															filters.id,
															filter_term.id
														)
													}
													checked={
														selectedFilters[
															filters.id
														]?.includes(
															filter_term.id
														) || false
													}
												/>
												<span className="series-filters__checkbox-custom">
													<span className="series-filters__checkbox-tick"></span>
												</span>
											</label>
										</li>
									))}
								{filters.terms.length > 10 && (
									<button
										className="series-filters__show-more"
										onClick={() =>
											setShowAllTerms({
												...showAllTerms,
												[index]: !showAllTerms[index],
											})
										}
									>
										{showAllTerms[index]
											? 'Show Less'
											: 'Show More'}
									</button>
								)}
							</ul>
						</li>
					))}
				</ul>
				<SeriesFiltersButton />
			</div>
		</span>
	);
};
export default SeriesFilters;
