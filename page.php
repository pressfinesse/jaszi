<?php
/**
 * Template for displaying pages
 *
 *
 * @package WordPress
 * @subpackage Jazsi
 */
get_header(); ?>
<main id="main" role="main" class="site-main container-fluid bg-white">
        <div class="row pt-3 pb-5">
                <div class="col-sm-12 col-md-8 col-lg-8 col-xl-8 blog-main">
			<?php while ( have_posts() ) : the_post();
				get_template_part( 'template-parts/content', 'page' );
				if ( comments_open() || get_comments_number() ) { comments_template(); }
			endwhile; ?>
		</div>

                <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 blog-main">
			<?php get_sidebar(); ?>
		</div>
        </div>
</main>
<?php get_footer(); ?>
