<?php
/**
 * Travel One functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Travel_One
 */

if ( ! defined( 'TRAVEL_ONE_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( 'TRAVEL_ONE_VERSION', '1.0.3' );
}

if ( ! function_exists( 'travel_one_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function travel_one_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Travel One, use a find and replace
		 * to change 'travel-one' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'travel-one', get_template_directory() . '/languages' );

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
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			array(
				'primary' => esc_html__( 'Primary', 'travel-one' ),
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);

		// Set up the WordPress core custom background feature.
		add_theme_support(
			'custom-background',
			apply_filters(
				'travel_one_custom_background_args',
				array(
					'default-color' => 'ffffff',
					'default-image' => '',
				)
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 250,
				'width'       => 250,
				'flex-width'  => true,
				'flex-height' => true,
			)
		);

		add_theme_support( 'align-wide' );

		add_theme_support( 'wp-block-styles' );
	}
endif;
add_action( 'after_setup_theme', 'travel_one_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function travel_one_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'travel_one_content_width', 640 ); // phpcs:ignore WPThemeReview.CoreFunctionality.PrefixAllGlobals.NonPrefixedVariableFound
}
add_action( 'after_setup_theme', 'travel_one_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function travel_one_widgets_init() {
	$args = array(
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	);

	register_sidebar(
		array(
			'name'        => esc_html__( 'Footer', 'travel-one' ),
			'id'          => 'sidebar-2',
			'description' => esc_html__( 'Add widgets here to appear in your footer.', 'travel-one' ),
		) + $args
	);
}
add_action( 'widgets_init', 'travel_one_widgets_init' );

/**
 * Theme default options.
 *
 * @return array
 */
function travel_one_default_options() {
	return array(
		'site_primary_color'     => '#CA9D13',
		'site_brand_font_family' => 'praise-cursive',
		'global_primary_font'    => 'lato-helvetica',
	);
}

/**
 * Google font info
 *
 * @param mixed $font_name Font name.
 * @return array
 */
function travel_one_google_font_info( $font_name = false ) {
	$font_info = array(
		'praise-cursive' => array(
			'url'    => 'https://fonts.googleapis.com/css?family=Praise',
			'family' => '"Praise", cursive',
		),
		'lato-helvetica' => array(
			'url'    => 'https://fonts.googleapis.com/css?family=Lato:400,700,300',
			'family' => '"lato", Helvetica, sans-serif',
		),
	);
	if ( ! $font_name ) {
		return $font_info;
	}

	return ! empty( $font_info[ $font_name ] ) ? $font_info[ $font_name ] : false;
}

/**
 * Enqueue scripts and styles.
 */
function travel_one_scripts() {

	wp_dequeue_style( 'wp-travel-frontend' );
	wp_enqueue_style( 'wp-travel-frontend-v2' );

	wp_enqueue_style( 'ionicons', get_template_directory_uri() . '/css/ionicons.css', array(), TRAVEL_ONE_VERSION );
	$deps = array( 'ionicons' );

	$default_options = travel_one_default_options();
	$show_title      = ! get_theme_mod( 'hide_site_title', false );
	if ( $show_title && ! empty( $default_options['site_brand_font_family'] ) ) {
		$font_info              = travel_one_google_font_info( $default_options['site_brand_font_family'] );
		$handle                 = 'google-font-' . $default_options['site_brand_font_family'];
		$deps[]                 = $handle;
		$site_brand_font_family = $font_info['family'];
		wp_enqueue_style( $handle, $font_info['url'], array(), TRAVEL_ONE_VERSION );
	}

	if ( ! empty( $default_options['global_primary_font'] ) ) {
		$font_info           = travel_one_google_font_info( $default_options['global_primary_font'] );
		$handle              = 'google-font-' . $default_options['global_primary_font'];
		$deps[]              = $handle;
		$global_primary_font = $font_info['family'];
		wp_enqueue_style( $handle, $font_info['url'], array(), TRAVEL_ONE_VERSION );
	}

	wp_enqueue_style( 'travel-one-style', get_stylesheet_uri(), $deps, TRAVEL_ONE_VERSION );
	wp_style_add_data( 'travel-one-style', 'rtl', 'replace' );

	if ( has_nav_menu( 'primary' ) ) {
		wp_enqueue_script( 'travel-one-navigation', get_template_directory_uri() . '/js/navigation.js', array(), TRAVEL_ONE_VERSION, true );
	}

	$color      = get_theme_mod( 'site_primary_color', $default_options['site_primary_color'] ); // E.g. #FF0000
	$custom_css = '
	:root {
		--global-primary-color: ' . $color . ';
		--site-brand-font-family: ' . $site_brand_font_family . ';
		--global-primary-font: ' . $global_primary_font . ';
	}';
	wp_add_inline_style( 'travel-one-style', $custom_css );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'travel_one_scripts' );

/**
 * Enqueue editor scripts and styles.
 */
function travel_one_editor_scripts() {
	wp_enqueue_style( 'travel-one-block-editor-style', get_stylesheet_directory_uri() . '/block-editor.css', false, TRAVEL_ONE_VERSION, 'all' );
}
add_action( 'enqueue_block_editor_assets', 'travel_one_editor_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Load WP Travel compatibility file.
 */
if ( defined( 'WP_TRAVEL_VERSION' ) ) {
	require get_template_directory() . '/inc/wp-travel.php';
}

/**
 * Load TGM file.
 */
require_once get_template_directory() . '/inc/tgm/plugin-activation.php';
