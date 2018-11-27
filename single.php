<?php
/**
 * Template for displaying all single posts and attachments
 *
 * @package WordPress
 * @subpackage Jazsi
 */

get_header(); ?>
<main id="main" role="main" class="site-main container-fluid bg-white">
	<div class="row pt-3">
	        <div class="col-sm-12 col-md-8 col-lg-8 col-xl-8 blog-main bg-white">
		<?php while ( have_posts() ) : the_post(); ?>
			<?php get_template_part( 'template-parts/content', 'single' );

			if ( is_singular( 'attachment' ) ) {
				the_post_navigation( array(
					'prev_text' => _x( '<span class="meta-nav">Published in</span><span class="post-title">%title</span>', 'Parent post link', 'jazsi' ),
				) );
			}

			if ( comments_open() || get_comments_number() ) {comments_template();}

		endwhile; ?>
                </div>

                <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 blog-main bg-white">
                        <?php get_sidebar(); ?>
                </div>

	</div>
</main>
<?php get_footer(); ?>
