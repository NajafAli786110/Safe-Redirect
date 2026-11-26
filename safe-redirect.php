<?php

/**
 * Plugin Name: Safe Redirect - 404 to 301 Manager
 * Description: This plugin allows you to manage 404 to 301 redirects safely and efficiently.
 * Version: 0.2.0
 * Author: Najaf Ali Balti
 * Author URI: https://najafbalti.com
 * Text Domain: safe-redirect
 *
 * @package EngineWP\SafeRedirect
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once __DIR__ . '/vendor/autoload.php';

define( 'SAFE_REDIRECT_MAIN', __FILE__ );
const SAFE_REDIRECT_VERSION = '0.2.0';

use EngineWP\SafeRedirect\Menu_Register;
use EngineWP\SafeRedirect\Database\LogTable;
use EngineWP\SafeRedirect\Logger\NotFoundLogger;
use EngineWP\SafeRedirect\Database\RedirectTable;
use EngineWP\SafeRedirect\Redirect\RedirectHandler;

$create_log_table      = new LogTable();
$create_redirect_table = new RedirectTable();

register_activation_hook( SAFE_REDIRECT_MAIN, array( $create_log_table, 'create_table' ) );
register_activation_hook( SAFE_REDIRECT_MAIN, array( $create_redirect_table, 'create_table' ) );

add_action(
	'plugins_loaded',
	function () use ( $create_log_table, $create_redirect_table ) {
		if ( SAFE_REDIRECT_VERSION !== get_option( 'safe_redirect_option' ) ) {
			$create_log_table->create_table();
			$create_redirect_table->create_table();
			update_option( 'safe_redirect_option', SAFE_REDIRECT_VERSION );
		}
	}
);

$redirect_found = new RedirectHandler();
add_action( 'template_redirect', array( $redirect_found, 'page_redirect' ) );

$not_found_logs = new NotFoundLogger();
add_action( 'template_redirect', array( $not_found_logs, 'log_404' ) );

new Menu_Register();
