import './aut-product-grid.scss';
import { useContext } from 'react';
import seriesContext from '../../context/seriesContext';
import AutProductCard from '../aut-product-card/aut-product-card';

const AutProductGrid = () => {
	const className = 'aut-product-grid';
	const [seriesGlobal] = useContext(seriesContext);

	if (seriesGlobal.no_results === true) {
		return (
			<div className={className}>
				<p className={`${className}__no-results`}>
					Sorry we could not find a product to match your requirements
					but{' '}
					<a target="_blank" href="contact-us/">
						request a callback
					</a>{' '}
					and one of the team will be in touch.
				</p>
			</div>
		);
	}

	return (
		<div className={className}>
			{seriesGlobal.data.map((series, index) => (
				<AutProductCard
					key={index}
					title={series.content.title}
					series={series.content.series}
					image_url={series.image_url}
					permalink={series.permalink}
					description={series.content.description}
					button_text={series.button_text}
					tags={series.tags}
					fixing_type={series.content.fixing_type}
				></AutProductCard>
			))}
		</div>
	);
};

export default AutProductGrid;
