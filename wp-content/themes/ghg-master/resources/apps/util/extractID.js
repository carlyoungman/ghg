const ExtractID = (type) => {
	// Ensure that document.body is not null
	if (document.body) {
		// Get the class name of the body element
		const bodyClass = document.body.className;

		// Define regular expressions to match the specified type
		const regexMap = {
			'page-id': /page-id-(\d+)/,
			term: /term-(\d+)/,
			postid: /postid-(\d+)/,
			tax: /tax-([\w-]+)/,
			single: /single-([\w-]+)/,
		};

		// Check if the type is valid
		if (!regexMap[type]) {
			console.error('Invalid type specified');
			return null;
		}

		// Use the regular expression to find a match in the body class
		const match = regexMap[type].exec(bodyClass);

		// Extract the value from the matched string (if any)
		const extractedValue = match ? match[1] : null;

		// Check if the class is found
		if (match) {
			// Return the extracted value, parsed as integer if the type is numeric
			return type === 'page-id' || type === 'term' || type === 'postid'
				? parseInt(extractedValue)
				: extractedValue;
		} else {
			// Handle the case when the class is not found
			return null;
		}
	}

	// Return null if document.body is null
	return null;
};

// Export the ExtractID function as the default export
export default ExtractID;
