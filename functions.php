<?php if ( ! function_exists( 'jazsi_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * @since Jazsi .72
 */
function jazsi_setup() {

	load_theme_textdomain( 'jazsi' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );

	add_theme_support( 'custom-logo', array(
	    'height'      => 50,
	    'width'       => 50,
	    'flex-height' => true,
	    'flex-width'  => true,
	    'header-text' => array( 'site-title', 'site-description' ),
	) );

	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 1200, 9999 );

	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'jazsi' ),
		'secondary' => __( 'Secondary Menu', 'jazsi' ),
	) );

	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	add_theme_support( 'post-formats', array(
		'image',
		'video',
		'standard',
		'gallery',
	) );

	$jazbac = array(
	    'default-image' => '',
	    'default-preset' => 'default',
	    'default-position-x' => 'left',
	    'default-position-y' => 'top',
	    'default-size' => 'auto',
	    'default-repeat' => 'repeat',
	    'default-attachment' => 'scroll',
	    'default-color' => '',
	    'wp-head-callback' => '_custom_background_cb',
	    'admin-head-callback' => '',
	    'admin-preview-callback' => '',
	);
	add_theme_support( 'custom-background', $jazbac );

	add_theme_support( 'customize-selective-refresh-widgets' );
}
endif; // jazsi_setup
add_action( 'after_setup_theme', 'jazsi_setup' );

if ( ! function_exists( 'is_woocommerce_activated' ) ) {
        function is_woocommerce_activated() {
                if ( class_exists( 'woocommerce' ) ) { return true; } else { return false; }
        }
}

function jazsi_woocommerce_image_dimensions() {
        global $pagenow;

        if ( ! isset( $_GET['activated'] ) || $pagenow != 'themes.php' ) {
                return;
        }
        $catalog = array(
                'width'         => '400',       // px
                'height'        => '400',       // px
                'crop'          => 1            // true
        );
        $single = array(
                'width'         => '600',       // px
                'height'        => '600',       // px
                'crop'          => 1            // true
        );
        $thumbnail = array(
                'width'         => '120',       // px
                'height'        => '120',       // px
                'crop'          => 0            // false
        );
        // Image sizes
        update_option( 'shop_catalog_image_size', $catalog );           // Product category thumbs
        update_option( 'shop_single_image_size', $single );             // Single product image
        update_option( 'shop_thumbnail_image_size', $thumbnail );       // Image gallery thumbs
}
add_action( 'after_switch_theme', 'jazsi_woocommerce_image_dimensions', 1 );

add_filter( 'get_avatar' , 'jazsi_custom_avatar' );
function jazsi_custom_avatar( $avatar, $id_or_email, $size, $default, $alt ) {
    $user = false;
    $user = get_user_by( 'email', $id_or_email );

    if ( $user && is_object( $user ) ) {

            $avatar = 'YOUR_NEW_IMAGE_URL';
            $avatar = "<img alt='{$alt}' src='{$avatar}' class='avatar avatar-{$size} photo rounded-circle' height='{$size}' width='{$size}' />";

    }
    return $avatar;
}

/**
add_filter( 'woocommerce_enqueue_styles', '__return_false' );
function wp_enqueue_woocommerce_style(){
	wp_register_style( 'jazsi-woocommerce', get_template_directory_uri() . '/css/woocommerce.css' );

	if ( class_exists( 'woocommerce' ) ) {
		wp_enqueue_style( 'jazsi-woocommerce' );
	}
}
add_action( 'wp_enqueue_scripts', 'wp_enqueue_woocommerce_style' );
**/

//add_action('admin_menu', 'jazsi_menu');
function jazsi_menu() {
	add_theme_page('Jazsi Theme Opts', 'Jazsi Menu', 'edit_theme_options', 'jazsi-id', 'jazsi_function');
}

function bampage() {
global $wp_query;

	$big = 99999999;
	$paginate = paginate_links( array(
        'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
        'format' => '?paged=%#%',
        'type' => 'list',
        'add_args'           => true,
        'add_fragment'       => '',
        'before_page_number' => '',
        'after_page_number'  => '',
        'current' => max( 1, get_query_var('paged') ),
        'total' => $wp_query->max_num_pages
) );

	if ( $paginate ) {
	    echo '<div class="w-100 clearfix"></div><div class="pagination d-flex justify-content-center">';
	    echo $paginate;
	    echo '</div><!--// end .pagination -->';
	}

}
add_action( 'bampage', 'jazsi_setup' );


// Custom Walker for the Bootstrap 4 menu
class Main2 extends Walker_Nav_Menu {

    function start_lvl( &$output, $depth = 0, $args = array() ) {
        // Depth-dependent classes.
        $indent = ( $depth > 0  ? str_repeat( "\t", $depth ) : '' ); // code indent
        $display_depth = ( $depth + 1); // because it counts the first submenu as 0
        $classes = array(
            'dropdown-menu',
            ( $display_depth % 2  ? 'menu-odd' : 'menu-even' ),
            ( $display_depth >=2 ? 'sub-sub-menu' : '' ),
            'menu-depth-' . $display_depth
        );
        $class_names = implode( ' ', $classes );

        // Build HTML for output.
        $output .= "\n" . $indent . '<ul class="' . $class_names . 'bg-light p-2">' . "\n";
    }

    /**
     * Start the element output.
     *
     * Adds main/sub-classes to the list items and links.
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param object $item   Menu item data object.
     * @param int    $depth  Depth of menu item. Used for padding.
     * @param array  $args   An array of arguments. @see wp_nav_menu()
     * @param int    $id     Current item ID.
     */
    function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
        global $wp_query;
        $indent = ( $depth > 0 ? str_repeat( "\t", $depth ) : '' ); // code indent

        // Depth-dependent classes.
        $depth_classes = array(
            ( $depth == 0 ? 'nav-item d-inline' : 'sub-menu-item' ),
            ( $depth >=2 ? 'sub-sub-menu-item' : '' ),
            ( $depth % 2 ? 'menu-item-odd' : 'menu-item-even' ),
            'menu-item-depth-' . $depth
        );
        $depth_class_names = esc_attr( implode( ' ', $depth_classes ) );

        // Passed classes.
        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        $class_names = esc_attr( implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) ) );
        $class_names = str_replace( 'menu-item-has-children', 'menu-item-has-children dropdown', $class_names );

        // Build HTML.
        $output .= $indent . '<li id="nav-menu-item-'. $item->ID . '" class="' . $depth_class_names . ' ' . $class_names . '">';

        // Link attributes.
        $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
        $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
        $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
        $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
        $attributes .= ' class="' . ( $depth > 0 ? 'sub-menu-link' : 'main-menu-link nav-link text-dark' ) . '"';
	if ( $this->has_children ) {$attributes .= ' data-toggle="dropdown"';}

        // Build HTML output and pass through the proper filter.
        $item_output = sprintf( '%1$s<a%2$s>%3$s%4$s%5$s</a>%6$s',
            $args->before,
            $attributes,
            $args->link_before,
            apply_filters( 'the_title', $item->title, $item->ID ),
            $args->link_after,
            $args->after
        );

        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }

}

function jazsi_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Main SideBar', 'jazsi' ),
		'id'            => 'mainbar',
		'description'   => __( 'Add widgets here to appear in your sidebar.', 'jazsi' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="text-secondary">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'jazsi_widgets_init' );


function headclean() {
  // Originally from http://wpengineer.com/1438/wordpress-header/
  remove_action('wp_head', 'feed_links', 2);
  remove_action('wp_head', 'feed_links_extra', 3);
  remove_action('wp_head', 'rsd_link');
  remove_action('wp_head', 'wlwmanifest_link');
  remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
  remove_action('wp_head', 'wp_generator');
  remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);
  remove_action( 'wp_print_styles', 'print_emoji_styles');
  remove_action( 'wp_head', 'print_emoji_detection_script', 7);

  global $wp_widget_factory;
  remove_action('wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style'));

}
add_action( 'after_setup_theme', 'headclean' );



if ( ! function_exists( 'jazsi_entry_meta' ) ) :
function jazsi_entry_meta() {
	if ( 'post' === get_post_type() ) {
		$author_avatar_size = apply_filters( 'jazsi_author_avatar_size', 49 );
		printf( '<span class="byline"><span class="author vcard">%1$s<span class="screen-reader-text">%2$s </span> <a class="url fn n" href="%3$s">%4$s</a></span></span>',
			get_avatar( get_the_author_meta( 'user_email' ), $author_avatar_size ),
			_x( 'Author', 'Used before post author name.', 'jazsi' ),
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			get_the_author()
		);
	}

	if ( in_array( get_post_type(), array( 'post', 'attachment' ) ) ) {
		jazsi_entry_date();
	}

	$format = get_post_format();
	if ( current_theme_supports( 'post-formats', $format ) ) {
		printf( '<span class="entry-format">%1$s<a href="%2$s">%3$s</a></span>',
			sprintf( '<span class="screen-reader-text">%s </span>', _x( 'Format', 'Used before post format.', 'jazsi' ) ),
			esc_url( get_post_format_link( $format ) ),
			get_post_format_string( $format )
		);
	}

	if ( 'post' === get_post_type() ) {
		jazsi_entry_taxonomies();
	}

	if ( ! is_singular() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<span class="comments-link">';
		comments_popup_link( sprintf( __( 'Leave a comment<span class="screen-reader-text"> on %s</span>', 'jazsi' ), get_the_title() ) );
		echo '</span>';
	}
}
endif;

if ( ! function_exists( 'jazsi_entry_date' ) ) :
function jazsi_entry_date() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
//		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		get_the_date(),
		esc_attr( get_the_modified_date( 'c' ) ),
		get_the_modified_date()
	);

	printf( '<span class="posted-on"><span class="screen-reader-text">%1$s </span><a href="%2$s" rel="bookmark">%3$s</a></span>',
		_x( 'Posted on', 'Used before publish date.', 'jazsi' ),
		esc_url( get_permalink() ),
		$time_string
	);
}
endif;

if ( ! function_exists( 'jazsi_entry_taxonomies' ) ) :
function jazsi_entry_taxonomies() {
	$categories_list = get_the_category_list( _x( ', ', 'Used between list items, there is a space after the comma.', 'jazsi' ) );
	if ( $categories_list && jazsi_categorized_blog() ) {
		printf( '<span class="cat-links"><span class="screen-reader-text">%1$s </span>%2$s</span>',
			_x( 'Categories', 'Used before category names.', 'jazsi' ),
			$categories_list
		);
	}

	$tags_list = get_the_tag_list( '', _x( ', ', 'Used between list items, there is a space after the comma.', 'jazsi' ) );
	if ( $tags_list ) {
		printf( '<span class="tags-links"><span class="screen-reader-text">%1$s </span>%2$s</span>',
			_x( 'Tags', 'Used before tag names.', 'jazsi' ),
			$tags_list
		);
	}
}
endif;

if ( ! function_exists( 'jazsi_post_thumbnail' ) ) :
function jazsi_post_thumbnail() {
	if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
		return;
	}

	if ( is_singular() ) :
	?>

	<div class="post-thumbnail">
		<?php the_post_thumbnail(); ?>
	</div><!-- .post-thumbnail -->

	<?php else : ?>

	<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true">
		<?php the_post_thumbnail( 'post-thumbnail', array( 'alt' => the_title_attribute( 'echo=0' ) ) ); ?>
	</a>

	<?php endif;
}
endif;


if ( ! function_exists( 'jazsi_excerpt_more' ) && ! is_admin() ) :
function jazsi_excerpt_more() {
	$link = sprintf( '<a href="%1$s" class="more-link">%2$s</a>',
		esc_url( get_permalink( get_the_ID() ) ),
		/* translators: %s: Name of current post */
		sprintf( __( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'jazsi' ), get_the_title( get_the_ID() ) )
	);
	return ' &hellip; ' . $link;
}
add_filter( 'excerpt_more', 'jazsi_excerpt_more' );
endif;

if ( ! function_exists( 'jazsi_categorized_blog' ) ) :
function jazsi_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'jazsi_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'jazsi_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so jazsi_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so jazsi_categorized_blog should return false.
		return false;
	}
}
endif;

function jazsi_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	delete_transient( 'jazsi_categories' );
}
add_action( 'edit_category', 'jazsi_category_transient_flusher' );
add_action( 'save_post',     'jazsi_category_transient_flusher' );

if ( ! function_exists( 'jazsi_the_custom_logo' ) ) :
function jazsi_the_custom_logo() {
	if ( function_exists( 'the_custom_logo' ) ) {
		the_custom_logo();
	}
}
endif;
