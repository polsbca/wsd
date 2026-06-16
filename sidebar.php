<?php
/**
 * The sidebar containing the main widget area
 *
 * @package wsd
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( is_active_sidebar( 'primary-sidebar' ) ) {
	?>
	<aside id="secondary" class="widget-area">
		<?php dynamic_sidebar( 'primary-sidebar' ); ?>
	</aside>
	<?php
}
