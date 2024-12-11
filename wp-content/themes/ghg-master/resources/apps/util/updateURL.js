// utils/urlManager.js
export const updateURLParams = (filters = {}, page) => {
	const url = new URL(window.location);

	// Clear previous parameters for each category
	Object.keys(filters).forEach((category) => {
		url.searchParams.delete(category); // Remove old parameters
	});

	// Add new category-term_id pairs as hyphen-separated values
	for (const [category, termIds] of Object.entries(filters)) {
		if (Array.isArray(termIds) && termIds.length > 0) {
			const termIdsString = termIds.join('-'); // Join term IDs with hyphens
			url.searchParams.set(category, termIdsString); // Set the category with the joined term IDs
		}
	}

	// Ensure page is always the last parameter in the query string
	if (page) {
		url.searchParams.delete('results'); // Remove page temporarily to reorder it
		url.searchParams.append('results', page); // Append page so it appears last
	} else {
		url.searchParams.delete('results'); // Remove page if not provided
	}

	// Update the URL without reloading the page
	window.history.pushState({}, '', url);
};

export const resetToInitialURL = () => {
	const url = new URL(window.location);
	url.search = ''; // Clear all query parameters
	window.history.replaceState({}, '', url);
};
