<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class DH_Multiwidgets {

	const TEMPLATES = array(
		'template_1' => [
			'label' => 'Template 1',
			'widgets' => [
				'dh-anchor-navigation' => 'DH_Anchor_Navigation',
				'dh-image-heading-text' => 'DH_Image_Heading_Text',
			]
		],
		'template_2' => [
			'label' => 'Template 2',
			'widgets' => [
				'dh-numbered-list' => 'DH_Numbered_List',
				'dh-number-heading' => 'DH_Number_Heading',
			]
		],
	);

	public function __construct() {
		$this->register_multiwidgets();
	}

	public function register_multiwidgets() {
		foreach ( self::TEMPLATES as $index => $template_widget ) {
         $php = "
            class {$index} extends Elementor\Widget_Base {
               public function get_name() {
                  return '{$index}';
               }
               public function get_title() {
                  return __( '{$template_widget['label']}', 'duurzaamthuis' );
               }
               public function get_icon() {
                  return 'eicon-single-page';
               }
               public function get_categories() {
                  return [ 'dh-widgets' ];
               }
               public function get_widgets() {
                  return " . var_export( $template_widget['widgets'], true ) . ";
               }
               protected function register_controls() {
                  foreach ( \$this->get_widgets() as \$name => \$class_name ) {
                     \$fn_name = str_replace( '-', '_', 'get_' . \$name . '_controls' );
                     DH_Widgets_Content_Controls::\$fn_name( \$this );
                  }
               }
               protected function render() {
                  \$settings = \$this->get_settings_for_display();
                  foreach ( \$this->get_widgets() as \$name => \$class_name ) {
                     \$widget_config = array(
                        'id'         => '',
                        'elType'     => 'widget',
                        'settings'   => \$settings,
                        'widgetType' => \$name,
                     );
                     \$widget = Elementor\Plugin::\$instance->elements_manager->create_element_instance( \$widget_config );
                     \$widget->render_content();
                  }
               }
               protected function content_template() {
                  foreach ( \$this->get_widgets() as \$name => \$class_name ) {
                     echo '<div class=\"elementor-widget-container\">';
                        call_user_func( array( ( new \$class_name ), 'content_template' ) );
                     echo '</div>';
                  }
               }
            }
            Elementor\Plugin::instance()->widgets_manager->register_widget_type( new {$index}() );
         ";
         @eval( $php );
		}
	}

}