<?php get_header(); if ( is_home() ) { ?>
<main role="main">
	<div class="bg-trans text-muted">
		<div class="container">
			<div class="row homerow">
			<?php if ( have_posts() ) : ?>
				<?php if ( is_home() && ! is_front_page() ) : ?><h1><?php single_post_title(); ?></h1><?php endif; ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'template-parts/content', 'home' ); ?>
			<?php endwhile; ?>
				<?php if ( function_exists('bampage') ) { bampage(); } ?>
				<?php else : get_template_part( 'template-parts/content', 'none' ); ?>
			<?php endif; ?>
			</div>
		</div>
	</div>
</main>
<?php } get_footer(); ?>

