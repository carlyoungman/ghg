import './aut-product-filters-button.scss';
import { useContext, useState } from 'react';
import seriesContext from '../../context/seriesContext';
import { removeElementByClass } from '../../util/removeElement';

const AutProductFiltersButton = () => {
	const className = 'aut-product-filters-button';
	const [seriesGlobal, setSeriesGlobal] = useContext(seriesContext);
	const [buttonActive, setButtonActive] = useState(false);

	const handleClick = () => {
		setButtonActive(true);
		const additional_data = {
			...seriesGlobal.additional_data,
			displayLoading: true,
			show_button: false,
		};

		const combined_data = {
			data: [],
			additional_data: additional_data,
		};
		setSeriesGlobal(combined_data);

		removeElementByClass('AUT-products__grid');
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
					action: 'get_aut_products',
					page_ID: seriesGlobal.additional_data.page_ID,
					page: 1,
					Tax: seriesGlobal.additional_data.tax,
					filters: JSON.stringify(seriesGlobal.filters),
				}),
			});

			const data = await response.json();

			if (data.success) {
				const combined_data = {
					data: data.data.data,
					additional_data: data.data.additional_data,
				};

				setSeriesGlobal(combined_data);
				setButtonActive(false);

				// updateURLParams(seriesGlobal.filters, 1);
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

export default AutProductFiltersButton;
