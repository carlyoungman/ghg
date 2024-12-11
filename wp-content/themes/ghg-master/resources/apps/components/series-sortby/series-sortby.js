import React, { useContext, useState } from 'react';
import './series-sortby.scss';
import seriesContext from '../../context/seriesContext';

const SeriesSortby = () => {
	const [seriesGlobal, setSeriesGlobal] = useContext(seriesContext);
	const [selectedOption, setSelectedOption] = useState('');
	const handleOptionChange = async (event) => {
		const optionValue = event.target.value;
		setSelectedOption(optionValue);
		setSeriesGlobal([]);
		await fetchData(optionValue);
	};

	const fetchData = async (selectedOption) => {
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
					sort_by: selectedOption,
				}),
			});

			const data = await response.json();

			if (data && data.success) {
				const combined_data = {
					series: data.data.series,
					additional_data: data.data.additional_data,
				};
				setSeriesGlobal(combined_data);
			}
		} catch (error) {
			console.error('Error fetching data:', error);
		}
	};

	if (!seriesGlobal.additional_data) {
		return <></>;
	}

	return (
		<select
			className="series-sortby"
			value={selectedOption}
			onChange={handleOptionChange}
		>
			<option value="series">Sort by series</option>
			<option value="productName">Sort by product name</option>
		</select>
	);
};

export default SeriesSortby;
