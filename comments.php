<?php
/**
 * The template for displaying comments.
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Checathlon
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">

	<?php
	// You can start editing here -- including this comment!
	if ( have_comments() ) : ?>
	
		<div class="comments-wrapper">
	
			<h2 class="comments-title">
				<?php
					printf( // WPCS: XSS OK.
						esc_html( _nx( 'One comment %2$s', '%1$s comments %2$s', get_comments_number(), 'comments title', 'checathlon' ) ),
						number_format_i18n( get_comments_number() ),
						'<span class="screen-reader-text">' . get_the_title() . '</span>'
					);
				?>
			</h2>

			<?php
				if ( checathlon_is_amp() ) {
					?>
					<amp-live-list
						id="amp-live-comments-list-<?php the_ID(); ?>"
						<?php echo ( 'asc' === get_option( 'comment_order' ) ) ? ' sort="ascending" ' : ''; ?>
						data-poll-interval="<?php echo esc_attr( MINUTE_IN_SECONDS * 1000 ); ?>"
						data-max-items-per-page="<?php echo esc_attr( get_option( 'page_comments' ) ? (int) get_option( 'comments_per_page' ) : 10000 ); ?>"
					>
					<?php
					add_filter( 'navigation_markup_template', 'checathlon_filter_add_amp_live_list_pagination_attribute' );
				}

				the_comments_navigation( array(
					'next_text' => esc_html__( 'Newer comments', 'checathlon' ) . checathlon_get_svg( array( 'icon' => 'arrow-circle-right' ) ),
					'prev_text' => checathlon_get_svg( array( 'icon' => 'arrow-circle-left' ) ) . esc_html__( 'Older comments', 'checathlon' ),
				) );
			?>

			<ol class="comment-list"<?php echo checathlon_is_amp() ? ' items' : ''; ?>>
				<?php
					wp_list_comments( array(
						'style'       => 'ol',
						'short_ping'  => true,
						'avatar_size' => 50,
					) );
				?>
			</ol><!-- .comment-list -->

			<?php
				the_comments_navigation( array(
					'next_text' => esc_html__( 'Newer comments', 'checathlon' ) . checathlon_get_svg( array( 'icon' => 'arrow-circle-right' ) ),
					'prev_text' => checathlon_get_svg( array( 'icon' => 'arrow-circle-left' ) ) . esc_html__( 'Older comments', 'checathlon' ),
				) );

				if ( checathlon_is_amp() ) {
					remove_filter( 'navigation_markup_template', 'checathlon_filter_add_amp_live_list_pagination_attribute' );
					?>
						<div update>
							<button class="button" on="tap:amp-live-comments-list-<?php the_ID(); ?>.update"><?php esc_html_e( 'New comment(s)', 'wp-rig' ); ?></button>
						</div>
					</amp-live-list>
					<?php
				}
			
			// If comments are closed and there are comments, let's leave a little note, shall we?
			if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
				<p class="no-comments no-margin-bottom"><?php esc_html_e( 'Comments are closed.', 'checathlon' ); ?></p>
			<?php
				endif;
			?>
		
		</div><!-- .comments-wrapper -->

	<?php endif; // Check for have_comments(). ?>
	
	<?php
		comment_form();
	?>

</div><!-- #comments -->
