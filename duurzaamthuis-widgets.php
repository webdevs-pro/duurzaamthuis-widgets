<?php
/**
 * Plugin Name: Duurzaamthuis Widgets
 * Description: Custom Elementor widgets
 * Plugin URI:  https://magnificsoft.com/
 * Version:     0.4.11
 * Author:      Alex Ischenko
 * Text Domain: duurzaamthuis
 */


if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

define( 'DH_PLUGIN_DIR', dirname( __FILE__ ) ); // for php
define( 'DH_PLUGIN_DIR_URL', plugin_dir_url( __FILE__ ) ); // for assets


// includes
require_once ( DH_PLUGIN_DIR . '/inc/modules/dh-templates/dh-templates.php' );



final class Duurzaamthuis_Widgets {

	const MINIMUM_ELEMENTOR_VERSION = '3.0.0';
	const MINIMUM_PHP_VERSION = '7.0';

	public function __construct() {
		add_action( 'init', array( $this, 'i18n' ) );
		add_action( 'plugins_loaded', array( $this, 'init' ) );
	}

	public function i18n() {
		load_plugin_textdomain( 'duurzaamthuis' );
	}

	public function init() {
		// Check if Elementor installed and activated
		if ( ! did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', array( $this, 'admin_notice_missing_main_plugin' ) );
			return;
		}
		// Check for required Elementor version
		if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
			add_action( 'admin_notices', array( $this, 'admin_notice_minimum_elementor_version' ) );
			return;
		}
		// Check for required PHP version
		if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
			add_action( 'admin_notices', array( $this, 'admin_notice_minimum_php_version' ) );
			return;
		}
		// Once we get here, We have passed all validation checks so we can safely include our plugin
		require_once( 'plugin.php' );

		// register web devs category
		add_action( 'elementor/elements/categories_registered', function($elements_manager) {
			$elements_manager->add_category(
				'dh-widgets',
				[
					'title' => __( 'Duurzaamthuis Widgets', 'duurzaamthuis' ),
					'icon' => 'fa fa-plug',
				]
			);
		});
	}
	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have Elementor installed or activated.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function admin_notice_missing_main_plugin() {
		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}
		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor */
			esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'duurzaamthuis' ),
			'<strong>' . esc_html__( 'Duurzaamthuis Widgets', 'duurzaamthuis' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'duurzaamthuis' ) . '</strong>'
		);
		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}
	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required Elementor version.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function admin_notice_minimum_elementor_version() {
		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}
		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'duurzaamthuis' ),
			'<strong>' . esc_html__( 'Duurzaamthuis Widgets', 'duurzaamthuis' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'duurzaamthuis' ) . '</strong>',
			self::MINIMUM_ELEMENTOR_VERSION
		);
		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}
	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required PHP version.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function admin_notice_minimum_php_version() {
		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}
		$message = sprintf(
			/* translators: 1: Plugin name 2: PHP 3: Required PHP version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'duurzaamthuis' ),
			'<strong>' . esc_html__( 'Duurzaamthuis Widgets', 'duurzaamthuis' ) . '</strong>',
			'<strong>' . esc_html__( 'PHP', 'duurzaamthuis' ) . '</strong>',
			self::MINIMUM_PHP_VERSION
		);
		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}
}
// Instantiate AI_Blocks_Elementor.
new Duurzaamthuis_Widgets();



// plugin updates
require 'inc/vendor/plugin-update-checker/plugin-update-checker.php';
$myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
	'https://github.com/webdevs-pro/duurzaamthuis-widgets',
	__FILE__,
	'duurzaamthuis-widgets'
);
//Set the branch that contains the stable release.
$myUpdateChecker->setBranch('main');
