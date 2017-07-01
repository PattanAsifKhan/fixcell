<?php
/**
 * cosimo functions and definitions
 *
 * @package cosimo
 */

if ( ! function_exists( 'cosimo_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function cosimo_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on cosimo, use a find and replace
	 * to change 'cosimo' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'cosimo', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );
	add_image_size( 'cosimo-normal-post' , 1920, 9999);
	add_image_size( 'cosimo-masonry-w1' , 350, 9999);
	add_image_size( 'cosimo-masonry-w2' , 700, 9999);

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary Menu', 'cosimo' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'audio', 'video', 'gallery',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'cosimo_custom_background_args', array(
		'default-color' => 'f2f2f2',
		'default-image' => '',
	) ) );
}
endif; // cosimo_setup
add_action( 'after_setup_theme', 'cosimo_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function cosimo_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'cosimo_content_width', 940 );
}
add_action( 'after_setup_theme', 'cosimo_content_width', 0 );

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function cosimo_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'cosimo' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
}
add_action( 'widgets_init', 'cosimo_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function cosimo_scripts() {
	wp_enqueue_style( 'cosimo-style', get_stylesheet_uri() );
	wp_enqueue_style( 'font-awesome', get_template_directory_uri() .'/css/font-awesome.min.css');
	$query_args = array(
		'family' => 'Oswald:400,700%7CRoboto:400,700'
	);
	wp_enqueue_style( 'cosimo-googlefonts', add_query_arg( $query_args, "//fonts.googleapis.com/css" ), array(), null );

	wp_enqueue_script( 'cosimo-custom', get_template_directory_uri() . '/js/jquery.cosimo.js', array('jquery', 'jquery-masonry'), '1.0', true );
	wp_enqueue_script( 'cosimo-nanoScroll', get_template_directory_uri() . '/js/jquery.nanoscroller.min.js', array('jquery'), '1.0', true );
	wp_enqueue_script( 'cosimo-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );
	wp_enqueue_script( 'cosimo-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );
	wp_enqueue_script( 'cosimo-smoothScroll', get_template_directory_uri() . '/js/SmoothScroll.min.js', array('jquery'), '1.0', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'cosimo_scripts' );

/**
 * Custom Excerpt Length
 */
if ( ! function_exists( 'cosimo_custom_excerpt_length' ) ) {
	function cosimo_custom_excerpt_length( $length ) {
		if ( ! is_admin() ) {
			return 20;
		} else {
			return $length;
		}
	}
}
add_filter( 'excerpt_length', 'cosimo_custom_excerpt_length', 999 );

/**
 * Replace Excerpt More
 */
if ( ! function_exists( 'cosimo_new_excerpt_more' ) ) {
	function cosimo_new_excerpt_more( $more ) {
		if ( is_admin() ) {
			return $more;
		}
		return '&hellip;';
	}
}
add_filter('excerpt_more', 'cosimo_new_excerpt_more');

 /**
 * Delete font size style from tag cloud widget
 */
if ( ! function_exists( 'cosimo_fix_tag_cloud' ) ) {
	function cosimo_fix_tag_cloud($tag_string){
	   return preg_replace('/ style=("|\')(.*?)("|\')/','',$tag_string);
	}
}
add_filter('wp_generate_tag_cloud', 'cosimo_fix_tag_cloud',10,1);

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Custom Header
 */
require get_template_directory() . '/inc/custom-header.php';

/* Calling in the admin area for the Welcome Page */
if ( is_admin() ) {
	require get_template_directory() . '/inc/admin/cosimo-admin-page.php';
}

/**
 * Load PRO Button in the customizer
 */
require_once( trailingslashit( get_template_directory() ) . 'inc/pro-button/class-customize.php' );
