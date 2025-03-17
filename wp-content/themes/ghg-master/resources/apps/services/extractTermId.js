const ExtractpageID = () => {
	// Ensure that document.body is not null
	if (document.body) {
		const bodyClass = document.body.className;
		const page_IDRegex = /term-(\d+)/;
		const match = page_IDRegex.exec(bodyClass);
		const extractedID = match ? parseInt(match[1]) : null;

		// Check if the page-id class is found
		if (match) {
			return extractedID;
		} else {
			// Handle the case when the page-id class is not found
			console.error('Term ID class not found on the body element');
			return null;
		}
	}

	return null;
};

export default ExtractpageID;
