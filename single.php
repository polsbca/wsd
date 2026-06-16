<?php
/**
 * The template for displaying single posts
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
		while ( have_posts() ) {
			the_post();
			?>
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<header class="entry-header">
					<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

					<div class="entry-meta">
						<?php
						printf(
							esc_html__( 'Posted on %1$s by %2$s', 'wsd' ),
							'<time class="entry-date published updated" datetime="' . esc_attr( get_the_date( 'c' ) ) . '">' . esc_html( get_the_date() ) . '</time>',
							'<span class="entry-author"><a href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
						);
						?>
					</div>
				</header>

				<?php
				if ( has_post_thumbnail() ) {
					?>
					<div class="post-thumbnail">
						<?php the_post_thumbnail( 'large' ); ?>
					</div>
					<?php
				}
				?>

				<div class="entry-content">
					<?php
					the_content();

					wp_link_pages( array(
						'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'wsd' ),
						'after'  => '</div>',
					) );
					?>
				</div>

				<footer class="entry-footer">
					<?php
					$categories = get_the_category();
					if ( ! empty( $categories ) ) {
						echo '<div class="entry-categories">' . esc_html__( 'Categories:', 'wsd' ) . ' ';
						foreach ( $categories as $category ) {
							echo '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '">' . esc_html( $category->name ) . '</a> ';
						}
						echo '</div>';
					}

					$tags = get_the_tags();
					if ( ! empty( $tags ) ) {
						echo '<div class="entry-tags">' . esc_html__( 'Tags:', 'wsd' ) . ' ';
						foreach ( $tags as $tag ) {
							echo '<a href="' . esc_url( get_tag_link( $tag->term_id ) ) . '">' . esc_html( $tag->name ) . '</a> ';
						}
						echo '</div>';
					}
					?>
				</footer>
			</article>

			<?php
			// Comments
			if ( comments_open() || get_comments_number() ) {
				comments_template();
			}
		}
		?>

	</main>

	<?php get_sidebar(); ?>

<?php
get_footer();
