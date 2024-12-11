import './series-grid.scss';
import { useContext } from 'react';
import seriesContext from '../../context/seriesContext';
import ProductSeriesCard from '../product-series-card/product-series-card';
import LoadingAnimation from '../loading-animation/loading-animation';

const SeriesGrid = () => {
	const className = 'series-grid';
	const [seriesGlobal] = useContext(seriesContext);

	if (seriesGlobal.no_results === true) {
		return (
			<div className={className}>
				<p className={`${className}__no-results`}>
					No results found. Please try adjusting your filters.
				</p>
			</div>
		);
	}

	if (!seriesGlobal?.series?.length) {
		return <LoadingAnimation type="news" />;
	}

	return (
		<div className={className}>
			{seriesGlobal.series.map((series, index) => (
				<ProductSeriesCard
					key={index}
					title={series.content.title}
					series={series.content.series}
					image_url={series.image_url}
					permalink={series.permalink}
					description={series.content.description}
					button_text={series.button_text}
					tags={series.tags}
				></ProductSeriesCard>
			))}
		</div>
	);
};

export default SeriesGrid;
