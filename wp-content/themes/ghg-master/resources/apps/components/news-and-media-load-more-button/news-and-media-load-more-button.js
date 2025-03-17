import './news-and-media-load-more-button.scss';
import { useContext, useEffect, useState } from 'react';
import newsAndMediaContext from '../../context/newsAndMediaContext';
import ExtractID from '../../services/extractID';

const NewsAndMediaLoadMoreButton = (props) => {
	const { action } = props;
	const className = 'load-more-button';
	const [page, setPage] = useState(1);
	const [totalPages, setTotalPages] = useState(0);
	const [newsGlobal, setNewsGlobal] = useContext(newsAndMediaContext);
	const [buttonActive, setButtonActive] = useState(false);
	const page_ID = ExtractID('page-id');

	useEffect(() => {
		if (newsGlobal.totalPage) {
			const total = newsGlobal.totalPage;
			setTotalPages(total);
		}
	}, [newsGlobal.totalPages]);

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
					page_ID: page_ID,
					page: page + 1,
				}),
			});

			const data = await response.json();

			if (data) {
				const posts = data.posts;

				setNewsGlobal((prevnewsGlobal) => ({
					...prevnewsGlobal,
					posts: [...prevnewsGlobal.posts, ...posts],
				}));

				setPage(page + 1);
				setButtonActive(false);
			}
		} catch (error) {
			console.error('Error fetching data:', error);
		}
	};

	return (
		<>
			{page >= totalPages ? (
				<></>
			) : (
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
							<span>Load more content</span>
						</button>
					)}
				</div>
			)}
		</>
	);
};

export default NewsAndMediaLoadMoreButton;
