<?php

namespace BOILERPLATE_THEME\Core\Module;

use Walker_Nav_Menu;

class Custom_Walker_Menu extends Walker_Nav_Menu
{
	// Start Element
	public function start_el(
		&$output,
		$item,
		$depth = 0,
		$args = null,
		$id = 0
	): void {
		if (isset($args->item_spacing) && 'discard' === $args->item_spacing) {
			$t = '';
			$n = '';
		} else {
			$t = "\t";
			$n = "\n";
		}
		$indent = $depth ? str_repeat($t, $depth) : '';

		// CSS classes
		$classes = empty($item->classes) ? [] : (array) $item->classes;
		$classes[] = 'menu-item-' . $item->ID;

		// Check if the current menu item has the 'mega-menu' class
		$has_mega_menu_class = in_array('mega-menu', $classes);

		// If the current item has children, add 'menu-item-has-children' class
		if (!empty($args->has_children) && $args->depth > 0) {
			$classes[] = 'menu-item-has-children';
		}

		// Construct the HTML output
		$output .=
			$indent .
			'<li class="' .
			implode(
				' ',
				apply_filters(
					'nav_menu_css_class',
					array_filter($classes),
					$item,
					$args,
					$depth
				)
			) .
			'">';

		// If it's a mega-menu item, add an additional class to its children
		if ($has_mega_menu_class && $args->depth > 0) {
			$output .= ' mega-menu-item';
		}

		// Link attributes
		$atts = [];
		$atts['title'] = !empty($item->attr_title) ? $item->attr_title : '';
		$atts['target'] = !empty($item->target) ? $item->target : '';
		$atts['rel'] = !empty($item->xfn) ? $item->xfn : '';
		$atts['href'] = !empty($item->url) ? $item->url : '';

		// Add class if the item is the current item
		if (in_array('current-menu-item', $classes)) {
			$atts['class'] = 'current-menu-item';
		}

		// Get the menu icon using Advanced Custom Fields
		$menu_icon = get_field('menu_icon', $item->ID);
		$icon_output = '';
		if ($menu_icon && is_array($menu_icon)) {
			$icon_output =
				'<img src="' .
				esc_url($menu_icon['url']) .
				'" alt="' .
				esc_attr($menu_icon['alt']) .
				'" />';
		}

		// Construct the link element
		$atts = apply_filters(
			'nav_menu_link_attributes',
			$atts,
			$item,
			$args,
			$depth
		);
		$attributes = '';
		foreach ($atts as $attr => $value) {
			if (!empty($value)) {
				$value = 'href' === $attr ? esc_url($value) : esc_attr($value);
				$attributes .= ' ' . $attr . '="' . $value . '"';
			}
		}

		$item_output = $args->before;
		$item_output .= '<a' . $attributes . '>';
		$item_output .= $icon_output; // Append the icon output
		$item_output .=
			$args->link_before .
			apply_filters('the_title', $item->title, $item->ID) .
			$args->link_after;
		$item_output .= '</a>';
		$item_output .= $args->after;

		// Output the menu item
		$output .= apply_filters(
			'walker_nav_menu_start_el',
			$item_output,
			$item,
			$depth,
			$args
		);
	}
}
