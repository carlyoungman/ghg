import './load-more-button.scss';
import { useContext, useEffect, useState } from 'react';

const LoadMoreButton = (props) => {
	const { action, buttonText, context, ID } = props;
	const className = 'load-more-button';
	const [globalState, setGlobalState] = useContext(context);
	const [buttonActive, setButtonActive] = useState(false);
	const [showButton, setShowButton] = useState(false);
	const [initialUrl, setInitialUrl] = useState('');

	// Capture the initial URL when the component mounts
	useEffect(() => {
		const currentUrl = window.location.pathname;
		setInitialUrl(currentUrl);
	}, []);

	useEffect(() => {
		if (globalState?.additional_data) {
			const show_button = globalState.additional_data.show_button ?? true;

			setShowButton(show_button);

			if (globalState?.no_results) {
				setShowButton(false);
			}
		}
	}, [globalState]);

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
					action: action,
					page_ID: ID,
					page: globalState.additional_data.page + 1,
					tax: globalState.additional_data.tax,
					filters: JSON.stringify(
						globalState.additional_data.filters
					),
				}),
			});

			const data = await response.json();

			if (data.success) {
				const fetchedItems = data.data.data;
				setGlobalState((prevState) => ({
					...prevState,
					data: [...prevState.data, ...fetchedItems],
					additional_data: {
						...data.data.additional_data,
						page: globalState.additional_data.page + 1,
					},
				}));
				setButtonActive(false);
				// updateURLParams([], globalState.additional_data.page + 1);
			}
		} catch (error) {
			console.error('Error fetching data:', error);
		}
	};

	return (
		<>
			{showButton && (
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
							<span>{buttonText}</span>
						</button>
					)}
				</div>
			)}
		</>
	);
};

export default LoadMoreButton;
