import React, { useContext, useEffect, useState } from 'react';
import './aut-product-sortby.scss';
import seriesContext from '../../context/seriesContext';
import LoadingAnimation from '../loading-animation/loading-animation';
import { removeElementByClass } from '../../util/removeElement';
import { resetToInitialURL } from '../../util/updateURL';

const AutProductSortby = () => {
	const [seriesGlobal, setSeriesGlobal] = useContext(seriesContext);
	const [selectedOption, setSelectedOption] = useState('');

	const [initialUrl, setInitialUrl] = useState('');

	// Capture the initial URL when the component mounts
	useEffect(() => {
		const currentUrl = window.location.pathname;
		setInitialUrl(currentUrl);
	}, []);
	const handleOptionChange = async (event) => {
		const optionValue = event.target.value;
		setSelectedOption(optionValue);

		// Set series data to empty and update only the displayLoading flag
		const additional_data = {
			...seriesGlobal.additional_data,
			displayLoading: true,
			show_button: false,
			page: 1,
		};

		const combined_data = {
			data: [],
			additional_data: additional_data,
		};
		setSeriesGlobal(combined_data);

		removeElementByClass('AUT-products__grid');
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
					action: 'get_aut_products',
					page_ID: seriesGlobal.additional_data.page_ID,
					page: 1,
					Tax: seriesGlobal.additional_data.tax,
					sort_by: selectedOption,
					filters: JSON.stringify(
						seriesGlobal.additional_data.filters
					),
				}),
			});

			const data = await response.json();

			if (data.success) {
				const combined_data = {
					data: data.data.data,
					additional_data: data.data.additional_data,
				};
				setSeriesGlobal(combined_data);
				resetToInitialURL(initialUrl);
			}
		} catch (error) {
			console.error('Error fetching data:', error);
		}
	};

	if (!seriesGlobal.additional_data) {
		return <LoadingAnimation type="display-number" />;
	}

	return (
		<select
			className="aut-product-sortby"
			value={selectedOption}
			onChange={handleOptionChange}
		>
			<option value="series">Sort by series</option>
			<option value="productName">Sort by product name</option>
		</select>
	);
};

export default AutProductSortby;
