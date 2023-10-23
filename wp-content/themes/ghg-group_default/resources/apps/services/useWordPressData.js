import {useEffect, useState} from 'react';

export default function useWordPressData($action, $pageID) {
	const [data, setData] = useState([]);

	const body = {
		action: $action,
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
				body: new URLSearchParams({
					action: body.action,
					pageID: $pageID
				}),
			});
			setData(await response.json());
		};
		fetchData();
	}, []);

	return data;
}
