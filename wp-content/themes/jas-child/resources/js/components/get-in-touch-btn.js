export default function addGetInTouchButtons() {
	// Wait for the DOM content to fully load
	document.addEventListener('DOMContentLoaded', () => {
		// Get the get_in_touch_link element and its data-link attribute
		const getInTouchLinkElement =
			document.getElementById('get_in_touch_link');
		if (!getInTouchLinkElement) return;

		const getInTouchLink = getInTouchLinkElement.getAttribute('data-link');
		if (!getInTouchLink) return;

		// Select all elements with the class .single_add_to_cart_button
		const buttons = document.querySelectorAll('.single_add_to_cart_button');
		
		buttons.forEach((button) => {
			// Create a new anchor element
			const newLink = document.createElement('a');
			newLink.innerText = 'Get in Touch';
			newLink.href = getInTouchLink;
			newLink.classList.add('contact-button'); // Add the contact-button class

			// Insert the new link directly after the current .single_add_to_cart_button element
			button.parentNode.insertBefore(newLink, button.nextSibling);
		});
	});
}
