<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Main Plugin Class
 *
 * Register new elementor widget.
 *
 * @since 1.0.0
 */

new Content_Block_1();
class Content_Block_1 {
	public function __construct() {
		$this->add_actions();
	}
	private function add_actions() {

		add_action( 'elementor/widgets/widgets_registered', [ $this, 'on_widgets_registered' ] );

		add_action( 'elementor/frontend/after_register_scripts', function() {
			wp_register_script( 'duurzaamthuis-widgets', plugins_url( '/assets/js/duurzaamthuis-widgets.js', __FILE__ ), [ 'jquery' ], false, true );
		});

		add_action( 'elementor/frontend/after_enqueue_styles', function() {
			wp_enqueue_style( 'duurzaamthuis-widgets', plugins_url( '/assets/css/duurzaamthuis-widgets.css', __FILE__ ) );
		});

	}
	public function on_widgets_registered() {
		$this->includes();
		$this->register_widget();
	}
	private function includes() {
		require __DIR__ . '/widgets/content-block-1.php';
	}
	private function register_widget() {
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Content_Block_1_Widget() );
	}
}
