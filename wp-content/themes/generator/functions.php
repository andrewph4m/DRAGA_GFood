<?php 
/*
 * Set up the content width value based on the theme's design.
 */
if ( ! function_exists( 'generator_setup' ) ) :
function generator_setup() {
	
	global $content_width;
	if ( ! isset( $content_width ) ) {
		$content_width = 745;
	}
	/*
	 * Make generator theme available for translation.
	 */
	load_theme_textdomain( 'generator', get_template_directory() . '/languages' );
	// This theme styles the visual editor to resemble the theme style.
	add_editor_style( array( 'css/editor-style.css', generator_font_url() ) );
	// Add RSS feed links to <head> for posts and comments.
	add_theme_support( 'automatic-feed-links' );
	// This theme uses wp_nav_menu() in two locations.
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 672, 372, true );
	add_image_size( 'generator-full-width', 1038, 576, true );
	add_theme_support( "title-tag" );
	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus( array(
		'primary'   => __( 'Top primary menu', 'generator' ),
	) );
	// Add theme support for Custom Logo.
	add_theme_support( 'custom-logo', array(
		'width'       => 250,
		'height'      => 250,
		'flex-width'  => true,
		'flex-height' => true,
		'header-text' => array( 'site-title', 'site-description' ),
	) );
	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list',
	) );
	add_theme_support( 'custom-background', apply_filters( 'generator_custom_background_args', array(
	'default-color' => 'f5f5f5',
	) ) );
	// Add support for featured content.
	add_theme_support( 'featured-content', array(
		'featured_content_filter' => 'generator_get_featured_posts',
		'max_posts' => 6,
	) );
	// This theme uses its own gallery styles.
	add_filter( 'use_default_gallery_style', '__return_false' );
}

endif; // generator_setup
add_action( 'after_setup_theme', 'generator_setup' );

/**
 * Register Lato Google font for generator.
 */
function generator_font_url() {
	$generator_font_url = '';
	/*
	 * Translators: If there are characters in your language that are not supported
	 * by Lato, translate this to 'off'. Do not translate into your own language.
	 */
	if ( 'off' !== _x( 'on', 'Lato font: on or off', 'generator' ) ) {
		$generator_font_url = add_query_arg( 'family', urlencode( 'Lato:300,400,700,900,300italic,400italic,700italic' ), "//fonts.googleapis.com/css" );
	}

	return $generator_font_url;
}
// Generator Pro Version Menu
add_action( 'admin_menu', 'generator_admin_menu');
function generator_admin_menu( ) {
    add_theme_page( __('Pro Feature','generator'), __('Generator Pro','generator'), 'manage_options', 'generator-pro-buynow', 'generator_buy_now', 300 );   
}
function generator_buy_now(){ ?>
<div class="generator_pro_version">
  <a href="<?php echo esc_url('https://fasterthemes.com/wordpress-themes/generator/'); ?>" target="_blank">    
    <img src ="<?php echo esc_url(get_template_directory_uri()); ?>/images/generator_pro_features.png" width="70%" height="auto" />
  </a>
</div>
<?php
}
function generator_change_excerpt_more( $more ) {
    return (is_front_page()) ? '' : '[...]';
}
add_filter('excerpt_more', 'generator_change_excerpt_more');
function generator_excerpt_length( $length ) {
    return (is_front_page()) ? 8 : get_theme_mod('post_content_limit', 25);
}
add_filter( 'excerpt_length', 'generator_excerpt_length', 999 );
/*** Enqueue css and js files ***/
require_once('functions/enqueue-files.php');

/*** Theme Default Setup ***/
require_once('functions/theme-default-setup.php');

/*** Breadcrumbs ***/
require_once('functions/breadcrumbs.php');

/*** Custom Header ***/
require_once('functions/custom-header.php');

/*** Theme Customizer Option ***/
require_once('functions/theme-customization.php');

/*** Theme Customizer Fonts ***/
require_once('functions/fontawasome.php');