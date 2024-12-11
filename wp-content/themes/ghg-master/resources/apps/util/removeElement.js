// utils/removeElement.js
export const removeElementByClass = (className) => {
	const element = document.querySelector(`.${className}`);
	if (element) {
		element.remove();
	}
};
