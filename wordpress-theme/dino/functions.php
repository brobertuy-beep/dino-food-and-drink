<?php
/**
 * Dino Food & Drink theme functions.
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

define( 'DINO_VERSION', '1.0.0' );

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

	// menu.js holds the fallback menu; site.js renders it or the Google Sheet.
	wp_enqueue_script( 'dino-menu', get_theme_file_uri( 'js/menu.js' ), array(), DINO_VERSION, true );
	wp_enqueue_script( 'dino-site', get_theme_file_uri( 'js/site.js' ), array( 'dino-menu' ), DINO_VERSION, true );

	// A sheet link set in the Customizer wins over the one inside menu.js.
	$sheet = dino_opt( 'dino_sheet_url', '' );
	if ( $sheet ) {
		wp_add_inline_script( 'dino-menu', 'window.DINO_SHEET_URL = ' . wp_json_encode( esc_url_raw( $sheet ) ) . ';', 'after' );
	}
}
add_action( 'wp_enqueue_scripts', 'dino_assets' );

/** Appearance > Customize > Dino Food & Drink */
function dino_customize( $wp_customize ) {
	$wp_customize->add_section( 'dino_settings', array(
		'title'       => __( 'Dino Food & Drink', 'dino' ),
		'priority'    => 30,
		'description' => __( 'Menu prices come from the Google Sheet link below. Leave it empty to use the menu stored in the theme.', 'dino' ),
	) );

	$fields = array(
		'dino_sheet_url' => array( 'Google Sheet CSV link', '', 'esc_url_raw' ),
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
