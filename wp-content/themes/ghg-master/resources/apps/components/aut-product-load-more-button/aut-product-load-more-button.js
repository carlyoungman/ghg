import './aut-product-load-more-button.scss';
import { useContext, useEffect, useState } from 'react';
import seriesContext from '../../context/seriesContext';

const AutProductLoadMoreButton = () => {
	const className = 'aut-product-load-more-button';
	const [page, setPage] = useState(1);
	const [totalPages, setTotalPages] = useState(1);
	const [seriesGlobal, setSeriesGlobal] = useContext(seriesContext);
	const [buttonActive, setButtonActive] = useState(false);
	const [showButton, setShowButton] = useState(false);

	useEffect(() => {
		if (seriesGlobal.additional_data) {
			const total = seriesGlobal.additional_data.total_page;
			const show_button = seriesGlobal.additional_data.show_button;
			setTotalPages(total);
			setShowButton(show_button);
		}
	}, [seriesGlobal]);

	const handleClick = () => {
		setButtonActive(true);
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
					page: page + 1,
					Tax: seriesGlobal.additional_data.tax,
					filters: JSON.stringify(seriesGlobal.filters),
				}),
			});

			const data = await response.json();
			if (data && data.success) {
				const newSeries = data.data.series;
				const combined_data = {
					series: [...seriesGlobal.series, ...newSeries],
					additional_data: data.data.additional_data,
				};

				setSeriesGlobal((prevGlobal) => ({
					...prevGlobal,
					...combined_data,
				}));
				setPage((prevPage) => prevPage + 1);
				setButtonActive(false);
			}
		} catch (error) {
			console.error('Error fetching data:', error);
		}
	};

	return (
		<>
			{showButton && page < totalPages && (
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
							<span>Load more products</span>
						</button>
					)}
				</div>
			)}
		</>
	);
};

export default AutProductLoadMoreButton;
