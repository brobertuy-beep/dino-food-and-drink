<?php
/**
 * Dino Food & Drink theme functions.
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

// Bump on every release: it is added to script and style URLs, so visitors and
// GoDaddy's cache fetch the new files instead of an old cached copy.
define( 'DINO_VERSION', '1.1.1' );

// Menu & Prices admin page, the menu data store and the public menu feed.
require_once get_template_directory() . '/inc/admin-menu.php';

/** Read a Customizer value, falling back to the default. */
function dino_opt( $key, $default = '' ) {
	$value = get_theme_mod( $key, $default );
	return ( '' === $value || null === $value ) ? $default : $value;
}

function dino_setup() {
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'html5', array( 'style', 'script' ) );
}
add_action( 'after_setup_theme', 'dino_setup' );

function dino_assets() {
	wp_enqueue_style(
		'dino-fonts',
		'https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500;9..144,600;9..144,700;9..144,900&family=Inter:wght@400;500;600;700&display=swap',
		array(),
		null
	);
	wp_enqueue_style( 'dino-style', get_stylesheet_uri(), array( 'dino-fonts' ), DINO_VERSION );

	// menu.js holds the backup menu; site.js fetches the live menu from Menu & Prices.
	wp_enqueue_script( 'dino-menu', get_theme_file_uri( 'js/menu.js' ), array(), DINO_VERSION, true );
	wp_enqueue_script( 'dino-site', get_theme_file_uri( 'js/site.js' ), array( 'dino-menu' ), DINO_VERSION, true );

	// Where site.js reads the menu saved in Menu & Prices.
	wp_add_inline_script(
		'dino-menu',
		'window.DINO_MENU_API = ' . wp_json_encode( esc_url_raw( rest_url( 'dino/v1/menu' ) ) ) . ';',
		'after'
	);
}
add_action( 'wp_enqueue_scripts', 'dino_assets' );

/** "Edit menu & prices" shortcut in the black bar at the top, for logged-in owners viewing the site. */
function dino_admin_bar_link( $bar ) {
	if ( is_admin() || ! current_user_can( 'edit_pages' ) ) {
		return;
	}
	$bar->add_node( array(
		'id'    => 'dino-menu',
		'title' => __( 'Edit menu & prices', 'dino' ),
		'href'  => admin_url( 'admin.php?page=dino-menu' ),
	) );
}
add_action( 'admin_bar_menu', 'dino_admin_bar_link', 80 );

/**
 * Send the temporary GoDaddy address to the real domain, so the site has one
 * address only. Runs on the front of the site, never in wp-admin, so the
 * dashboard stays reachable on the temporary address if the domain has trouble.
 */
function dino_redirect_temp_domain() {
	if ( is_admin() || wp_doing_ajax() ) {
		return;
	}
	if ( ( defined( 'DOING_CRON' ) && DOING_CRON ) || ( defined( 'WP_CLI' ) && WP_CLI ) ) {
		return;
	}
	if ( empty( $_SERVER['HTTP_HOST'] ) ) {
		return;
	}

	$host = strtolower( sanitize_text_field( wp_unslash( $_SERVER['HTTP_HOST'] ) ) );
	if ( substr( $host, -16 ) !== '.myftpupload.com' ) {
		return;
	}

	$home_host = wp_parse_url( home_url(), PHP_URL_HOST );
	// Only redirect when the real domain is set and differs, so this can never loop.
	if ( empty( $home_host ) || strtolower( $home_host ) === $host ) {
		return;
	}

	$path   = isset( $_SERVER['REQUEST_URI'] ) ? wp_unslash( $_SERVER['REQUEST_URI'] ) : '/';
	$target = esc_url_raw( 'https://' . $home_host . $path );
	if ( $target ) {
		wp_redirect( $target, 301 );
		exit;
	}
}
add_action( 'template_redirect', 'dino_redirect_temp_domain', 1 );

/** Appearance > Customize > Dino Food & Drink */
function dino_customize( $wp_customize ) {
	$wp_customize->add_section( 'dino_settings', array(
		'title'       => __( 'Dino Food & Drink', 'dino' ),
		'priority'    => 30,
		'description' => __( 'Dishes and prices are changed under Menu & Prices in the dashboard menu, not here.', 'dino' ),
	) );

	$fields = array(
		'dino_phone'     => array( 'Phone number', '0468 595 689', 'sanitize_text_field' ),
		'dino_uber_url'  => array( 'Uber Eats link', 'https://www.ubereats.com/au/store/dino-food-&-drink/Jf55f-nFShqsC2IZewn_hA', 'esc_url_raw' ),
		'dino_maps_url'  => array( 'Google Maps link', 'https://www.google.com/maps/place/Dino+Food+%26+Drink/@-27.4599475,153.0222981,17z', 'esc_url_raw' ),
	);

	foreach ( $fields as $key => $field ) {
		$wp_customize->add_setting( $key, array(
			'default'           => $field[1],
			'sanitize_callback' => $field[2],
			'transport'         => 'refresh',
		) );
		$wp_customize->add_control( $key, array(
			'label'   => $field[0],
			'section' => 'dino_settings',
			'type'    => 'text',
		) );
	}
}
add_action( 'customize_register', 'dino_customize' );
