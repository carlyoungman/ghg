import './display-number.scss';
import React, { useContext, useState } from 'react'; // Added useState
import seriesContext from '../../context/seriesContext';
import LoadingAnimation from '../loading-animation/loading-animation';

const DisplayNumber = () => {
	const [seriesGlobal] = useContext(seriesContext);
	const [count] = useState(1);

	if (!seriesGlobal.additional_data) {
		return <LoadingAnimation type="display-number" />;
	}

	return (
		<>
			<p className="display-number">
				Items <span className="display-number__count">{count}</span>-
				<span className="display-number__product_number">
					{seriesGlobal.additional_data.show_product_number}
				</span>{' '}
				of{' '}
				<span className="display-number__total_product_number">
					{seriesGlobal.additional_data.total_product_number}
				</span>
			</p>
		</>
	);
};

export default DisplayNumber;
