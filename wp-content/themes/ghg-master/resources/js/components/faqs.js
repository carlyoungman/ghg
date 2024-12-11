export default function faqs() {
	const faqItems = document.querySelectorAll('.faqs__faq');

	faqItems.forEach((item) => {
		item.addEventListener('click', () => {
			item.classList.toggle('faqs__faq--open');
		});
	});
}
