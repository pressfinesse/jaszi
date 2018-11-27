<?php
/**
 * Template part for displaying single posts
 *
 * @package WordPress
 * @subpackage Jazsi
 */
?>

<div class="blog-post">
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php the_post_thumbnail('post-thumbnail', ['class' => 'rounded mx-auto d-block img-fluid ', 'title' => 'Feature image']); ?><br>

	<div class="blog-post-title bg-white"><?php the_title( '<h1 class="display-4">', '</h1>' ); ?></div>

	<div class="entry-content bg-white">
		<?php
			the_content();

			wp_link_pages( array(
				'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'jazsi' ) . '</span>',
				'after'       => '</div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
				'pagelink'    => '<span class="screen-reader-text">' . __( 'Page', 'jazsi' ) . ' </span>%',
				'separator'   => '<span class="screen-reader-text">, </span>',
			) );

			 jazsi_entry_meta();
		?>
	</div>

	<div class="entry-header bg-white">
		<?php edit_post_link(
			sprintf(
				/* translators: %s: Name of current post */
				__( 'Edit <span class="screen-reader-text"> "%s"</span>', 'jazsi' ),
				get_the_title()
			),
			'<span class="edit-link">','</span>');
		?>
	</div>


	</article>
</div>
