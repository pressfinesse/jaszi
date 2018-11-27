<?php
/**
 * The main template file
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Jazsi
 */
get_header(); ?>
<main id="main" role="main" class="site-main container-fluid">
	<div class="row">
	        <div class="col-sm-12 col-md-8 col-lg-8 col-xl-8 blog-main">

			<?php if ( have_posts() ) : ?>

			<?php if ( is_home() && ! is_front_page() ) : ?><h1><?php single_post_title(); ?></h1><?php endif; ?>

			<?php while ( have_posts() ) : the_post();

			get_template_part( 'template-parts/content', get_post_format() );

			endwhile; ?>

			<?php if ( function_exists('bampage') ) { bampage(); } ?>

			<?php else : get_template_part( 'template-parts/content', 'none' );

			endif; ?>

		</div>

		<div class="col-md-4 col-lg-4 col-xl-4 border-top-0 rounded-bottom border border-dark">
                        <br><?php get_sidebar(); ?>
		</div>
	</div>
</main>
<?php get_footer(); ?>
