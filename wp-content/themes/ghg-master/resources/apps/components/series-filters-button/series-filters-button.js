import './series-filters-button.scss';
import { useContext, useState } from 'react';
import seriesContext from '../../context/seriesContext';

const SeriesFiltersButton = () => {
	const className = 'series-filters-button';
	const [seriesGlobal, setSeriesGlobal] = useContext(seriesContext);
	const [buttonActive, setButtonActive] = useState(false);

	const handleClick = () => {
		setButtonActive(true);
		setSeriesGlobal([]);
		fetchData();
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
					page_ID: seriesGlobal.additional_data.page_ID,
					page: 1,
					Tax: seriesGlobal.additional_data.tax,
					filters: JSON.stringify(seriesGlobal.filters),
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
				setButtonActive(false);
			}
		} catch (error) {
			console.error('Error fetching data:', error);
		}
	};

	return (
		<>
			<div className={className}>
				{buttonActive ? (
					<svg
						xmlns="http://www.w3.org/2000/svg"
						viewBox="0 0 100 100"
						preserveAspectRatio="xMidYMid"
					>
						<circle
							cx="50"
							cy="50"
							r="32"
							strokeWidth="8"
							strokeDasharray="50.26548245743669 50.26548245743669"
							fill="none"
							strokeLinecap="round"
						>
							<animateTransform
								attributeName="transform"
								type="rotate"
								repeatCount="indefinite"
								dur="1s"
								keyTimes="0;1"
								values="0 50 50;360 50 50"
							></animateTransform>
						</circle>
					</svg>
				) : (
					<button
						className={`${className}__button`}
						onClick={handleClick}
					>
						<span>Refine Search</span>
					</button>
				)}
			</div>
		</>
	);
};

export default SeriesFiltersButton;
