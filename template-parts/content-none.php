<?php
/**
 * Template part for displaying a message that posts cannot be found
 *
 * @package WordPress
 * @subpackage Jazsi
 */
?>
<div class="no-results not-found">
	<header class="alert alert-warning" id="page-header"><h1 class="display-4"><?php _e( 'Nothing Found', 'jazsi' ); ?></h1></header>
		<div class="page-content">
		<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>
			<p><?php printf( __( 'Ready to publish? <a href="%1$s">Get Started</a>.', 'jazsi' ), esc_url( admin_url( 'post-new.php' ) ) ); ?></p>
		<?php elseif ( is_search() ) : ?>
			<p><?php _e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'jazsi' ); ?></p>
		<?php else : ?>
			<p><?php _e( 'It seems we can’t find what you’re looking for. Perhaps searching can help.', 'jazsi' ); ?></p>
		<?php endif; ?>
		</div>
</div>
