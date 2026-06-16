<?php
/**
 * The template for displaying 404 pages
 *
 * @package wsd
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

	<main id="main" class="site-main">

		<section class="error-404 not-found">
			<header class="page-header">
				<h1 class="page-title"><?php esc_html_e( 'Page Not Found', 'wsd' ); ?></h1>
			</header>

			<div class="page-content">
				<p><?php esc_html_e( 'The page you are looking for does not exist.', 'wsd' ); ?></p>
				<?php get_search_form(); ?>
			</div>
		</section>

	</main>

	<?php get_sidebar(); ?>

<?php
get_footer();
