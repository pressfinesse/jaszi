<?php
/**
 * The template for displaying search results pages
 *
 * @package WordPress
 * @subpackage Jazsi
 */

get_header(); ?>
<main id="main" role="main" class="site-main container-fluid pt-3 bg-white">
        <div class="row">
	        <div class="col-sm-12 col-md-12 col-lg-8 col-xl-8 blog-main mt-5">
			<?php if ( have_posts() ) : ?>

			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'template-parts/content', 'search' ); ?>
			<?php endwhile; ?>

			<?php if ( function_exists('bampage') ) { bampage(); } ?>

			<?php else : get_template_part( 'template-parts/content', 'none' ); endif; ?>
                </div>
			
			
                <div class="col-sm-12 col-md-12 col-lg-4 col-xl-4 blog-main">
                        <?php get_sidebar(); ?>
                </div>
			
        </div>
</main>
<?php get_footer(); ?>

