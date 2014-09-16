<?php
/**
 * Member Lite 2.0 functions and definitions
 *
 * @package Member Lite 2.0
 */

//enqueue additional stylesheets	 and javascript
function memberlite2_init_styles()
{
	if(!is_admin() )
	{
		wp_enqueue_script('jquery');
		wp_enqueue_style('memberlite2_fontawesome', get_template_directory_uri() . "/font-awesome/css/font-awesome.min.css", NULL, NULL, "all");
		wp_enqueue_style('memberlite2_1140', get_template_directory_uri() . "/css/1140.css", NULL, NULL, "all");
	}
}
add_action("init", "memberlite2_init_styles");	

function memberlite2_load_fonts()
{
	wp_register_style('googleFonts', 'http://fonts.googleapis.com/css?family=Noto+Sans:400,700|Fjalla+One');
	wp_enqueue_style( 'googleFonts');
}
add_action('wp_print_styles', 'memberlite2_load_fonts');

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 640; /* pixels */
}

if ( ! function_exists( 'memberlite2_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function memberlite2_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Member Lite 2.0, use a find and replace
	 * to change 'memberlite2' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'memberlite2', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );
	add_image_size('mini', 80, 80, true, array('center','center'));
	add_image_size('banner', 740, 200, true, array('center','center'));
	add_image_size('masthead', 1600, 300, true, array('center','center'));
	
	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'memberlite2' ),
		'meta' => __( 'Meta Menu', 'memberlite2' ),
	) );
	
	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
	) );

	/*
	 * Enable support for Post Formats.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'quote', 'link'
	) );

	// Setup the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'memberlite2_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
	
	// Declare WooCommerce theme support
    add_theme_support( 'woocommerce' );
}
endif; // memberlite2_setup
add_action( 'after_setup_theme', 'memberlite2_setup' );

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function memberlite2_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Pages', 'memberlite2' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	register_sidebar( array(
		'name'          => __( 'Posts and Archives', 'memberlite2' ),
		'id'            => 'sidebar-2',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	register_sidebar( array(
		'name'          => __( 'Header Right', 'memberlite2' ),
		'id'            => 'sidebar-3',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
	register_sidebar( array(
		'name'          => __( 'Footer Widgets', 'memberlite2' ),
		'id'            => 'sidebar-4',
		'description'   => 'Add up to 4 widgets in this area for best appearance',
		'before_widget' => '<aside id="%1$s" class="widget column3 %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	register_sidebar( array(
		'name'          => __( 'Mobile Menu Widgets', 'memberlite2' ),
		'id'            => 'sidebar-5',
		'description'   => 'The slide-out mobile menu area.',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
}
add_action( 'widgets_init', 'memberlite2_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function memberlite2_scripts() {
	wp_enqueue_style( 'memberlite2-style', get_stylesheet_uri() );

	wp_enqueue_script( 'memberlite2-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );

	wp_enqueue_script( 'memberlite2-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'memberlite2_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Custom widgets that act independently of the theme templates.
 */
require get_template_directory() . '/inc/widgets.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Custom shortcodes that act independently of the theme templates.
 */
require get_template_directory() . '/inc/shortcodes.php';