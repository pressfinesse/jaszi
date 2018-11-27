<?php
/**
 * Template for displaying search forms
 *
 * @package WordPress
 * @subpackage Jazsi
 */
?>

<form role="search" method="get" class="search-form form-inline my-2 my-lg-0" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label>
<input type="search" class="form-control mr-sm-2" placeholder="<?php echo esc_attr_x( 'Search &hellip;', 'placeholder', 'jazsi' ); ?>" value="<?php echo get_search_query(); ?>" name="s" />
	</label>
	<button type="submit" class="btn btn-outline-success my-2 my-sm-0"><?php echo _x( 'Go', 'submit button', 'jazsi' ); ?></button>
</form>
