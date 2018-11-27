<?php
/**
 * Template for the header
 *
 * @package WordPress
 * @subpackage Jazsi
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php endif; ?>
	<?php wp_head(); ?>
        <!-- CDN Bootstrap CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
	<!-- Custom styles for this template -->
	<link href="<?php echo get_template_directory_uri(); ?>/css/beta.css" rel="stylesheet">
	<link href="<?php echo get_template_directory_uri(); ?>/css/iconic/font/css/open-iconic-bootstrap.css" rel="stylesheet">
</head><body <?php body_class(); ?>><header>

<nav class="navbar fixed-top navbar-light bg-light">
	<div class="container d-flex flex-row-reverse">
		<?php if ( has_nav_menu( 'primary' ) ) :
			wp_nav_menu(array( 'menu' => 'primary', 'container' => 'nav', 'container_class' => '', 'container_id' => '', 'menu_class' => 'topmenu', 'menu_id' => '',
			'echo' => true, 'fallback_cb' => 'wp_page_menu', 'before' => '', 'after' => '', 'link_before' => '', 'link_after' => '', 'items_wrap' => '<ul class="nav d-flex align-items-stretch">%3$s</ul>', 'item_spacing' => 'preserve',
			'depth' => 0, 'walker' => new Main2(), 'theme_location' => 'primary' ));
		endif; ?>
	</div>
</nav></header>
