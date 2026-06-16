<?php
/**
 * The template for displaying search results
 *
 * @package wsd
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

	<main id="main" class="site-main">

		<?php
		if ( have_posts() ) {
			?>
			<header class="page-header">
				<h1 class="page-title">
					<?php
					printf(
						esc_html__( 'Search Results for: %s', 'wsd' ),
						'<span>' . get_search_query() . '</span>'
					);
					?>
				</h1>
			</header>

			<?php
			while ( have_posts() ) {
				the_post();
				?>
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<header class="entry-header">
						<?php the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '">', '</a></h2>' ); ?>
					</header>

					<div class="entry-content">
						<?php the_excerpt(); ?>
					</div>

					<footer class="entry-footer">
						<a href="<?php echo esc_url( get_permalink() ); ?>" class="read-more"><?php esc_html_e( 'Read More', 'wsd' ); ?></a>
					</footer>
				</article>
				<?php
			}

			// Posts pagination
			the_posts_pagination( array(
				'prev_text' => esc_html__( 'Previous', 'wsd' ),
				'next_text' => esc_html__( 'Next', 'wsd' ),
			) );
		} else {
			?>
			<p><?php esc_html_e( 'Nothing found for your search.', 'wsd' ); ?></p>
			<?php
		}
		?>

	</main>

	<?php get_sidebar(); ?>

<?php
get_footer();
