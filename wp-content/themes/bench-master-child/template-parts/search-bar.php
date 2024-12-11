<?php
if (!defined('ABSPATH')):
	exit();
endif;
$base = 'search-bar';
?>
<form class="<?php echo esc_attr($base); ?>" action="<?php echo esc_url(
	home_url('/')
); ?>"
	  method='GET'>
	<div class="<?php echo esc_attr($base); ?>__input-wrap">
		<label for="s">
			<input class="<?php echo esc_attr($base); ?>__input" name="s" type="search"
				   placeholder="Search"
				   value="<?php echo esc_attr(get_search_query()); ?>">
		</label>

		<button class="<?php echo esc_attr(
  	$base
  ); ?>__button" type="submit" aria-label="Submit Form">
			<svg class="<?php echo esc_attr(
   	$base
   ); ?>__icon" xmlns="http://www.w3.org/2000/svg" width="24"
				 height="24"
				 viewBox="0 0 24 24" fill="none"
				 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
				 title="Submit Form"
			>
				<circle cx="11" cy="11" r="8"/>
				<path d="m21 21-4.3-4.3"/>
			</svg>
		</button>
	</div>
</form>
