const ExtractSingle = () => {
	// Ensure that document.body is not null
	if (document.body) {
		// Get the class name of the body element
		const bodyClass = document.body.className;

		// Define a regular expression to match the tax- prefix and capture the value after it
		const taxClassRegex = /single-([\w-]+)/;

		// Use the regular expression to find a match in the body class
		const match = bodyClass.match(taxClassRegex);

		// Check if the tax class is found
		if (match) {
			// Extracted value is in the first capturing group (index 1)
			const extractedValue = match[1];
			return extractedValue;
		}
	}
	// Return null if document.body is null
	return null;
};

// Export the ExtractTax function as the default export
export default ExtractSingle;
