<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly



add_action( 'elementor/editor/after_enqueue_styles', 'icons_font_styles' );
add_action( 'elementor/preview/enqueue_styles', 'icons_font_styles' );
function icons_font_styles() {
	wp_enqueue_style( 'elements-font', plugin_dir_url( __FILE__ ) . '/assets/css/icons.css' );
}





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














// disable pannel widgets for non admin
add_filter( 'elementor/editor/localize_settings', function( $settings ) {

	if ( current_user_can('administrator') ) return;

	$editor_alowed_widgets = array(
		'heading',
		'duurzaamthuis-content-1',
	);

	foreach ( $settings['initial_document']['widgets'] as $widget_name => $widget_settings ) {

		if ( ! in_array( $widget_name, $editor_alowed_widgets ) ) {
			$settings['initial_document']['widgets'][$widget_name]['show_in_panel'] = false;
		}
	}

	return $settings;

}, 100 );