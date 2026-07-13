<?php
/**
 * The template for displaying comments on blog detail pages.
 *
 * @package wsd
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( post_password_required() ) {
	return;
}

$comment_count = (int) get_comments_number();
$commenter     = wp_get_current_commenter();
$req           = (bool) get_option( 'require_name_email' );
$consent       = ! empty( $commenter['comment_author_email'] );
?>

<div id="comments" class="blog-detail-comments">

	<?php if ( have_comments() ) : ?>
		<h2 class="blog-detail-comments-count">
			<?php
			printf(
				/* translators: %s: number of comments */
				esc_html( _n( '%s Comment', '%s Comments', $comment_count, 'wsd' ) ),
				esc_html( number_format_i18n( $comment_count ) )
			);
			?>
		</h2>

		<ol class="blog-detail-comment-list">
			<?php
			wp_list_comments(
				array(
					'style'       => 'ol',
					'short_ping'  => true,
					'avatar_size' => 48,
				)
			);
			?>
		</ol>

		<?php
		the_comments_navigation(
			array(
				'prev_text' => esc_html__( 'Older comments', 'wsd' ),
				'next_text' => esc_html__( 'Newer comments', 'wsd' ),
			)
		);
		?>
	<?php else : ?>
		<h2 class="blog-detail-comments-count"><?php esc_html_e( 'No Comments', 'wsd' ); ?></h2>
	<?php endif; ?>

	<?php if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
		<p class="blog-detail-comments-closed"><?php esc_html_e( 'Comments are closed.', 'wsd' ); ?></p>
	<?php endif; ?>

	<?php
	if ( comments_open() ) {
		$fields = array(
			'author' => sprintf(
				'<p class="blog-detail-comment-field comment-form-author"><label class="screen-reader-text" for="author">%1$s</label><input id="author" name="author" type="text" value="%2$s" size="30" maxlength="245" placeholder="%1$s"%3$s /></p>',
				esc_attr__( 'Your Name', 'wsd' ),
				esc_attr( $commenter['comment_author'] ),
				$req ? ' required' : ''
			),
			'email'  => sprintf(
				'<p class="blog-detail-comment-field comment-form-email"><label class="screen-reader-text" for="email">%1$s</label><input id="email" name="email" type="email" value="%2$s" size="30" maxlength="100" placeholder="%1$s"%3$s /></p>',
				esc_attr__( 'Your Email', 'wsd' ),
				esc_attr( $commenter['comment_author_email'] ),
				$req ? ' required' : ''
			),
			'url'    => sprintf(
				'<p class="blog-detail-comment-field comment-form-url"><label class="screen-reader-text" for="url">%1$s</label><input id="url" name="url" type="url" value="%2$s" size="30" maxlength="200" placeholder="%1$s" /></p>',
				esc_attr__( 'Your Website', 'wsd' ),
				esc_attr( $commenter['comment_author_url'] )
			),
		);

		if ( has_action( 'set_comment_cookies', 'wp_set_comment_cookies' ) && get_option( 'show_comments_cookies_opt_in' ) ) {
			$fields['cookies'] = sprintf(
				'<p class="blog-detail-comment-cookies comment-form-cookies-consent"><input id="wp-comment-cookies-consent" name="wp-comment-cookies-consent" type="checkbox" value="yes"%1$s /> <label for="wp-comment-cookies-consent">%2$s</label></p>',
				$consent ? ' checked="checked"' : '',
				esc_html__( 'Save my name, email, and website in this browser for the next time I comment.', 'wsd' )
			);
		}

		comment_form(
			array(
				'title_reply'          => __( 'Post A Comment', 'wsd' ),
				'title_reply_to'       => __( 'Post A Comment', 'wsd' ),
				'title_reply_before'   => '<h3 id="reply-title" class="blog-detail-comment-form-title">',
				'title_reply_after'    => '</h3>',
				'cancel_reply_before'  => '<span class="blog-detail-cancel-reply">',
				'cancel_reply_after'   => '</span>',
				'class_form'           => 'blog-detail-comment-form',
				'class_submit'         => 'blog-detail-comment-submit',
				'label_submit'         => __( 'SUBMIT', 'wsd' ),
				'submit_button'        => '<button name="%1$s" type="submit" id="%2$s" class="%3$s"><span>%4$s</span></button>',
				'submit_field'         => '<div class="blog-detail-comment-submit-wrap">%1$s %2$s</div>',
				'comment_notes_before' => '',
				'comment_notes_after'  => '',
				'fields'               => $fields,
				'comment_field'        => sprintf(
					'<p class="blog-detail-comment-textarea comment-form-comment"><label class="screen-reader-text" for="comment">%1$s</label><textarea id="comment" name="comment" cols="45" rows="4" maxlength="65525" required placeholder="%2$s"></textarea></p>',
					esc_html__( 'Comment', 'wsd' ),
					esc_attr__( 'Write your comments here......', 'wsd' )
				),
			)
		);
	}
	?>

</div>
