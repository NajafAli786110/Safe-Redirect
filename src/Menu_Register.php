<?php
/**
 * Registers the admin menu for the Safe Redirect plugin.
 *
 * @package EngineWP\SafeRedirect
 */

namespace EngineWP\SafeRedirect;

/**
 * Register menu class
 */
class Menu_Register {

	/**
	 * Contructor function so runs register function without calling.
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'register_menu' ) );
	}

	/**
	 * Register the menu function.
	 *
	 * @return void
	 */
	public function register_menu() {
		$icon_url = plugin_dir_url( SAFE_REDIRECT_MAIN ) . 'assets/safe-redirect-icon.svg';
		add_menu_page( 'Safe Redirect | 404 to 301 redirect safely', 'Safe Redirect', 'manage_options', 'enginewp-safe-redirect', array( $this, 'render_custom_admin_page' ), $icon_url, 30 );
		add_submenu_page( 'enginewp-safe-redirect', 'Safe Redirect | 404 to 301 redirect safely', 'Need Fixes!', 'manage_options', 'enginewp-safe-redirect', array( $this, 'render_custom_admin_page' ) );
		add_submenu_page( 'enginewp-safe-redirect', 'Safe Redirect | 404 to 301 redirect safely', 'Redirects', 'manage_options', 'enginewp-safe-redirect-result', array( $this, 'render_redirect_page' ) );
	}

	/**
	 * Prints the admin page.
	 *
	 * @return void
	 */
	public function render_custom_admin_page() {
		?>
		<h1>This is admin page</h1>
		<p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Quia dolorum rem obcaecati temporibus nam dicta nostrum
			reprehenderit, fugit possimus culpa.</p>
		<?php
	}

	/**
	 * Prints the redirects admin page.
	 *
	 * @return void
	 */
	public function render_redirect_page() {
		?>
		<h1>This is Redirect page</h1>
		<p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Quia dolorum rem obcaecati temporibus nam dicta nostrum
			reprehenderit, fugit possimus culpa.</p>
		<?php
	}
}