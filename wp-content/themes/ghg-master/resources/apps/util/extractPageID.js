const ExtractpageID = () => {
	// Ensure that document.body is not null
	if (document.body) {
		// Get the class name of the body element
		const bodyClass = document.body.className;

		// Define regular expressions to match the page-id, term, or postid class
		const page_IDRegex1 = /page-id-(\d+)/;
		const page_IDRegex2 = /term-(\d+)/;
		const page_IDRegex3 = /postid-(\d+)/;

		// Use the regular expressions to find a match in the body class
		const match1 = page_IDRegex1.exec(bodyClass);
		const match2 = page_IDRegex2.exec(bodyClass);
		const match3 = page_IDRegex3.exec(bodyClass);

		// Extract the numeric part of the matched string (if any)
		const extractedID = match1
			? parseInt(match1[1])
			: match2
			? parseInt(match2[1])
			: match3
			? parseInt(match3[1])
			: null;

		// Check if any of the page-id, term, or postid class is found
		if (match1 || match2 || match3) {
			return extractedID;
		} else {
			// Handle the case when none of the classes is found
			console.error(
				'page-id, term, or postid class not found on the body element'
			);
			return null;
		}
	}

	// Return null if document.body is null
	return null;
};

// Export the ExtractpageID function as the default export
export default ExtractpageID;
