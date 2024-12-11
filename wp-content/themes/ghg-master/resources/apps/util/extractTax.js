const ExtractTax = () => {
	// Ensure that document.body is not null
	if (document.body) {
		// Get the class name of the body element
		const bodyClass = document.body.className;

		// Define a regular expression to match the tax- prefix and capture the value after it
		const taxClassRegex = /tax-([\w-]+)/;

		// Use the regular expression to find a match in the body class
		const match = bodyClass.match(taxClassRegex);

		// Check if the tax class is found
		if (match) {
			// Extracted value is in the first capturing group (index 1)
			const extractedValue = match[1];
			return extractedValue;
		}
	}
	// Return an empty string if the tax class is not found or document.body is null
	return '';
};

// Export the ExtractTax function as the default export
export default ExtractTax;
