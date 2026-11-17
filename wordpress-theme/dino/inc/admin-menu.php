<?php
/**
 * Menu & Prices: the owners' menu editor.
 *
 * The menu is stored in the WordPress database (option "dino_menu_sections"), so it
 * survives theme updates and theme re-uploads. The public page reads it through a
 * small feed at /wp-json/dino/v1/menu, fetched fresh on every visit, so a saved price
 * shows straight away even while GoDaddy caches the page itself.
 *
 * Every save keeps a copy of the previous menu, so any change can be undone.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'DINO_MENU_OPTION', 'dino_menu_sections' );
define( 'DINO_MENU_HISTORY', 'dino_menu_history' );
define( 'DINO_MENU_UPDATED', 'dino_menu_updated' );
define( 'DINO_MENU_CAP', 'edit_pages' ); // Editors and Administrators.
define( 'DINO_MENU_HISTORY_KEEP', 15 );

/* ------------------------------------------------------------------ data */

/** Every field a dish can have, with its empty value. */
function dino_menu_item_defaults() {
	return array(
		'dish'       => '',
		'vi'         => '',
		'desc'       => '',
		'price'      => '',
		'price2'     => '',
		'uber'       => '',
		'show'       => true,
		'featured'   => '',
		'card_label' => '',
		'card_desc'  => '',
		'card_note'  => '',
	);
}

/** The starting menu, generated from the theme's menu.js. */
function dino_menu_seed() {
	$seed = include get_template_directory() . '/inc/menu-seed.php';
	return is_array( $seed ) ? $seed : array();
}

/** The current menu: what the owners last saved, or the starting menu. */
function dino_menu_get() {
	$saved = get_option( DINO_MENU_OPTION );
	if ( is_array( $saved ) && ! empty( $saved ) ) {
		return $saved;
	}
	return dino_menu_seed();
}

/** Single line of plain text: no HTML, trimmed, length limited. */
function dino_menu_text( $source, $key, $max ) {
	$value = ( is_array( $source ) && isset( $source[ $key ] ) && is_scalar( $source[ $key ] ) ) ? (string) $source[ $key ] : '';
	$value = trim( sanitize_text_field( $value ) );
	return function_exists( 'mb_substr' ) ? mb_substr( $value, 0, $max ) : substr( $value, 0, $max );
}

/** Clean whatever the editor sent into the stored shape. Drops anything malformed. */
function dino_menu_sanitize( $raw ) {
	$clean = array();
	if ( ! is_array( $raw ) ) {
		return $clean;
	}

	foreach ( array_slice( array_values( $raw ), 0, 40 ) as $section ) {
		if ( ! is_array( $section ) ) {
			continue;
		}
		$title = dino_menu_text( $section, 'title', 80 );
		if ( '' === $title ) {
			continue;
		}

		$items     = array();
		$raw_items = ( isset( $section['items'] ) && is_array( $section['items'] ) ) ? array_values( $section['items'] ) : array();

		foreach ( array_slice( $raw_items, 0, 200 ) as $item ) {
			if ( ! is_array( $item ) ) {
				continue;
			}
			$dish = dino_menu_text( $item, 'dish', 120 );
			if ( '' === $dish ) {
				continue;
			}
			$featured = isset( $item['featured'] ) && is_scalar( $item['featured'] ) ? absint( $item['featured'] ) : 0;

			$items[] = array(
				'dish'       => $dish,
				'vi'         => dino_menu_text( $item, 'vi', 120 ),
				'desc'       => dino_menu_text( $item, 'desc', 200 ),
				'price'      => dino_menu_text( $item, 'price', 40 ),
				'price2'     => dino_menu_text( $item, 'price2', 40 ),
				'uber'       => dino_menu_text( $item, 'uber', 40 ),
				'show'       => ! empty( $item['show'] ),
				'featured'   => ( $featured >= 1 && $featured <= 6 ) ? (string) $featured : '',
				'card_label' => dino_menu_text( $item, 'card_label', 40 ),
				'card_desc'  => dino_menu_text( $item, 'card_desc', 300 ),
				'card_note'  => dino_menu_text( $item, 'card_note', 80 ),
			);
		}

		$clean[] = array(
			'title' => $title,
			'note'  => dino_menu_text( $section, 'note', 160 ),
			'tag'   => dino_menu_text( $section, 'tag', 40 ),
			'items' => $items,
		);
	}

	return $clean;
}

/** How many dishes a menu has. */
function dino_menu_count( $sections ) {
	$count = 0;
	foreach ( (array) $sections as $section ) {
		if ( isset( $section['items'] ) && is_array( $section['items'] ) ) {
			$count += count( $section['items'] );
		}
	}
	return $count;
}

/**
 * The menu as rows with a header, the same columns as the Google Sheet template,
 * so the page reuses one tested reader for both.
 */
function dino_menu_rows( $sections ) {
	$rows = array(
		array( 'Section', 'Dish', 'Price', 'Price 2', 'Uber Eats price', 'Show', 'Featured', 'Vietnamese name', 'Description', 'Card label', 'Card description', 'Card note', 'Section note', 'Section tag' ),
	);

	foreach ( (array) $sections as $section ) {
		if ( empty( $section['title'] ) || empty( $section['items'] ) || ! is_array( $section['items'] ) ) {
			continue;
		}
		$note = isset( $section['note'] ) ? $section['note'] : '';
		$tag  = isset( $section['tag'] ) ? $section['tag'] : '';

		foreach ( $section['items'] as $item ) {
			$item   = wp_parse_args( (array) $item, dino_menu_item_defaults() );
			$rows[] = array(
				$section['title'],
				$item['dish'],
				$item['price'],
				$item['price2'],
				$item['uber'],
				empty( $item['show'] ) ? 'No' : 'Yes',
				$item['featured'],
				$item['vi'],
				$item['desc'],
				$item['card_label'],
				$item['card_desc'],
				$item['card_note'],
				// On every row, so the heading note survives even when the first dish is hidden.
				$note,
				$tag,
			);
		}
	}

	return $rows;
}

/** Keep a copy of a menu in the undo history, newest first. */
function dino_menu_remember( $sections ) {
	$history = get_option( DINO_MENU_HISTORY, array() );
	if ( ! is_array( $history ) ) {
		$history = array();
	}
	$user = wp_get_current_user();

	array_unshift( $history, array(
		'time'     => time(),
		'user'     => ( $user && $user->exists() ) ? $user->display_name : '',
		'sections' => $sections,
	) );

	update_option( DINO_MENU_HISTORY, array_slice( $history, 0, DINO_MENU_HISTORY_KEEP ), false );
}

/* ------------------------------------------------------------- the feed */

function dino_menu_register_route() {
	register_rest_route( 'dino/v1', '/menu', array(
		'methods'             => 'GET',
		'callback'            => 'dino_menu_rest',
		'permission_callback' => '__return_true', // The menu is public anyway.
	) );
}
add_action( 'rest_api_init', 'dino_menu_register_route' );

function dino_menu_rest() {
	$response = new WP_REST_Response( array(
		'rows'    => dino_menu_rows( dino_menu_get() ),
		'updated' => (int) get_option( DINO_MENU_UPDATED, 0 ),
	) );
	// Never let a browser or cache keep an old menu.
	$response->header( 'Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0' );
	return $response;
}

/* -------------------------------------------------------- the admin page */

function dino_menu_admin_menu() {
	add_menu_page(
		__( 'Menu & Prices', 'dino' ),
		__( 'Menu & Prices', 'dino' ),
		DINO_MENU_CAP,
		'dino-menu',
		'dino_menu_page',
		'dashicons-food',
		3
	);
}
add_action( 'admin_menu', 'dino_menu_admin_menu' );

function dino_menu_admin_assets( $hook ) {
	if ( 'toplevel_page_dino-menu' !== $hook ) {
		return;
	}
	wp_enqueue_style( 'dino-menu-admin', get_theme_file_uri( 'css/admin-menu.css' ), array(), DINO_VERSION );
	wp_enqueue_script( 'dino-menu-admin', get_theme_file_uri( 'js/admin-menu.js' ), array(), DINO_VERSION, true );
	wp_add_inline_script(
		'dino-menu-admin',
		'window.DINO_MENU_ADMIN = ' . wp_json_encode( array( 'sections' => dino_menu_get() ) ) . ';',
		'before'
	);
}
add_action( 'admin_enqueue_scripts', 'dino_menu_admin_assets' );

function dino_menu_when( $timestamp ) {
	return wp_date( get_option( 'date_format' ) . ', ' . get_option( 'time_format' ), $timestamp );
}

function dino_menu_page() {
	if ( ! current_user_can( DINO_MENU_CAP ) ) {
		wp_die( esc_html__( 'You do not have permission to change the menu.', 'dino' ) );
	}

	$updated = (int) get_option( DINO_MENU_UPDATED, 0 );
	$history = get_option( DINO_MENU_HISTORY, array() );
	$history = is_array( $history ) ? $history : array();
	$notice  = isset( $_GET['dino_notice'] ) ? sanitize_key( wp_unslash( $_GET['dino_notice'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	$menu_url = home_url( '/#full-menu' );
	?>
	<div class="wrap dino-menu-admin">
		<h1><?php esc_html_e( 'Menu & Prices', 'dino' ); ?></h1>

		<?php if ( 'saved' === $notice ) : ?>
			<div class="notice notice-success is-dismissible"><p>
				<strong><?php esc_html_e( 'Menu saved.', 'dino' ); ?></strong>
				<?php esc_html_e( 'The website is showing the new menu now.', 'dino' ); ?>
				<a href="<?php echo esc_url( $menu_url ); ?>" target="_blank" rel="noopener"><?php esc_html_e( 'View the menu', 'dino' ); ?></a>
			</p></div>
		<?php elseif ( 'restored' === $notice ) : ?>
			<div class="notice notice-success is-dismissible"><p>
				<strong><?php esc_html_e( 'Earlier menu restored.', 'dino' ); ?></strong>
				<?php esc_html_e( 'The menu you had before restoring is kept below, in case you want it back.', 'dino' ); ?>
			</p></div>
		<?php elseif ( 'error' === $notice ) : ?>
			<div class="notice notice-error"><p>
				<strong><?php esc_html_e( 'Nothing was saved.', 'dino' ); ?></strong>
				<?php esc_html_e( 'The menu could not be read, or it had no dishes. Your previous menu is still live.', 'dino' ); ?>
			</p></div>
		<?php endif; ?>

		<p class="dino-intro">
			<?php esc_html_e( 'Change a dish or a price below, then press Save menu. The website updates straight away.', 'dino' ); ?>
		</p>
		<p class="dino-meta">
			<?php
			if ( $updated ) {
				/* translators: %s: date and time */
				echo esc_html( sprintf( __( 'Last saved %s.', 'dino' ), dino_menu_when( $updated ) ) );
			} else {
				esc_html_e( 'Not saved yet. This is the starting menu from the website.', 'dino' );
			}
			?>
			<a href="<?php echo esc_url( $menu_url ); ?>" target="_blank" rel="noopener"><?php esc_html_e( 'View the menu on the website', 'dino' ); ?></a>
		</p>

		<form id="dino-menu-form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
			<?php wp_nonce_field( 'dino_menu_save', 'dino_menu_nonce' ); ?>
			<input type="hidden" name="action" value="dino_menu_save">
			<input type="hidden" name="dino_menu_json" id="dino-menu-json" value="">

			<div id="dino-menu-editor"><p><?php esc_html_e( 'Loading the menu editor', 'dino' ); ?></p></div>
			<noscript><div class="notice notice-error"><p><?php esc_html_e( 'The menu editor needs JavaScript turned on in this browser.', 'dino' ); ?></p></div></noscript>

			<div class="dino-savebar">
				<span class="dino-savebar__status" id="dino-save-status"><?php esc_html_e( 'No changes yet', 'dino' ); ?></span>
				<button type="submit" class="button button-primary button-hero" id="dino-save"><?php esc_html_e( 'Save menu', 'dino' ); ?></button>
			</div>
		</form>

		<?php if ( $history ) : ?>
			<div class="dino-history">
				<h2><?php esc_html_e( 'Undo a change', 'dino' ); ?></h2>
				<p><?php esc_html_e( 'Every save keeps a copy of the menu from just before it. Restoring a copy also keeps the current menu here, so you can always switch back.', 'dino' ); ?></p>
				<table class="widefat striped">
					<thead><tr>
						<th><?php esc_html_e( 'Menu as it was on', 'dino' ); ?></th>
						<th><?php esc_html_e( 'Changed by', 'dino' ); ?></th>
						<th><?php esc_html_e( 'Dishes', 'dino' ); ?></th>
						<th></th>
					</tr></thead>
					<tbody>
					<?php foreach ( $history as $index => $entry ) : ?>
						<tr>
							<td><?php echo esc_html( dino_menu_when( isset( $entry['time'] ) ? (int) $entry['time'] : 0 ) ); ?></td>
							<td><?php echo esc_html( isset( $entry['user'] ) ? $entry['user'] : '' ); ?></td>
							<td><?php echo esc_html( (string) dino_menu_count( isset( $entry['sections'] ) ? $entry['sections'] : array() ) ); ?></td>
							<td>
								<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" onsubmit="return confirm('<?php echo esc_js( __( 'Replace the current menu with this earlier one?', 'dino' ) ); ?>');">
									<?php wp_nonce_field( 'dino_menu_restore', 'dino_menu_nonce' ); ?>
									<input type="hidden" name="action" value="dino_menu_restore">
									<input type="hidden" name="dino_index" value="<?php echo esc_attr( (string) $index ); ?>">
									<button type="submit" class="button"><?php esc_html_e( 'Restore this menu', 'dino' ); ?></button>
								</form>
							</td>
						</tr>
					<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		<?php endif; ?>
	</div>
	<?php
}

/* --------------------------------------------------------- save, restore */

function dino_menu_back( $notice ) {
	wp_safe_redirect( add_query_arg( 'dino_notice', $notice, admin_url( 'admin.php?page=dino-menu' ) ) );
	exit;
}

function dino_menu_handle_save() {
	if ( ! current_user_can( DINO_MENU_CAP ) ) {
		wp_die( esc_html__( 'You do not have permission to change the menu.', 'dino' ), '', array( 'response' => 403 ) );
	}
	check_admin_referer( 'dino_menu_save', 'dino_menu_nonce' );

	$json     = isset( $_POST['dino_menu_json'] ) ? wp_unslash( $_POST['dino_menu_json'] ) : ''; // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- decoded then sanitised field by field.
	$data     = json_decode( (string) $json, true );
	$sections = dino_menu_sanitize( ( is_array( $data ) && isset( $data['sections'] ) ) ? $data['sections'] : null );

	if ( ! dino_menu_count( $sections ) ) {
		dino_menu_back( 'error' );
	}

	$current = dino_menu_get();
	if ( maybe_serialize( $current ) !== maybe_serialize( $sections ) ) {
		dino_menu_remember( $current );
	}
	update_option( DINO_MENU_OPTION, $sections );
	update_option( DINO_MENU_UPDATED, time() );

	dino_menu_back( 'saved' );
}
add_action( 'admin_post_dino_menu_save', 'dino_menu_handle_save' );

function dino_menu_handle_restore() {
	if ( ! current_user_can( DINO_MENU_CAP ) ) {
		wp_die( esc_html__( 'You do not have permission to change the menu.', 'dino' ), '', array( 'response' => 403 ) );
	}
	check_admin_referer( 'dino_menu_restore', 'dino_menu_nonce' );

	$index   = isset( $_POST['dino_index'] ) ? absint( $_POST['dino_index'] ) : -1;
	$history = get_option( DINO_MENU_HISTORY, array() );

	if ( ! is_array( $history ) || ! isset( $history[ $index ]['sections'] ) ) {
		dino_menu_back( 'error' );
	}

	$restore = dino_menu_sanitize( $history[ $index ]['sections'] );
	if ( ! dino_menu_count( $restore ) ) {
		dino_menu_back( 'error' );
	}

	dino_menu_remember( dino_menu_get() );
	update_option( DINO_MENU_OPTION, $restore );
	update_option( DINO_MENU_UPDATED, time() );

	dino_menu_back( 'restored' );
}
add_action( 'admin_post_dino_menu_restore', 'dino_menu_handle_restore' );
