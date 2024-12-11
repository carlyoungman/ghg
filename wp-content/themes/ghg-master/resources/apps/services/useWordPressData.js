import { useEffect, useState } from 'react';

export default function UseWordPressData(
	$action,
	$page_ID,
	$page,
	$tax,
	$single
) {
	const [data, setData] = useState([]);

	const body = {
		action: $action || '',
		page_ID: $page_ID || '',
		page: $page || '',
		tax: $tax || '',
		single: $single || '',
	};

	useEffect(() => {
		const fetchData = async () => {
			const response = await fetch(ajax_params.ajaxurl, {
				method: 'POST',
				credentials: 'same-origin',
				headers: {
					'Content-Type': 'application/x-www-form-urlencoded',
					'Cache-Control': 'no-cache',
				},
				body: new URLSearchParams(body), // Use the modified body object
			});
			setData(await response.json());
		};
		fetchData();
	}, []);

	return data;
}
