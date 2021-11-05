<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class DH_Multiwidgets {

	public function __construct() {
		$this->register_multiwidgets();
	}

   public function get_templates() {
      if ( ! function_exists( 'get_field' ) ) return array();

      $templates = get_field( 'templates', 'option' );
      if ( ! $templates ) return array();

      $temp = array();
      foreach ( $templates as $template ) {
         $key = strtolower( str_replace( array( ' ', '-' ), '_', $template['label'] ) );
         $temp[$key] = array(
            'label' => $template['label'],
         );
         foreach ( $template['widgets'] as $widget ) {
            $temp[$key]['widgets'][$widget['widget']] = $this->get_widget_class_name( $widget['widget'] );
         }
      }
      return $temp;
   }

   public function get_widget_class_name( $widget_name ) {
      $widgets = array(
         'dh-anchor-navigation' => 'DH_Anchor_Navigation',
         'dh-image-heading-text' => 'DH_Image_Heading_Text',
         'dh-impact' => 'DH_Impact',
         'dh-mega-menu' => 'DH_Mega_Menu',
         'dh-number-heading' => 'DH_Number_Heading',
         'dh-numbered-list' => 'DH_Numbered_List',
         'dh-page-header' => 'DH_Page_Header',
         'dh-product-comparition' => 'DH_Product_Comparison',
         'dh-product-comparition-sustainability-score' => 'DH_Product_Comparition_Sustainability_Score',
         'dh-product-review' => 'DH_Product_Review',
         'dh-related-content' => 'DH_Related_Posts',
         'dh-table' => 'DH_Table',
      );
      return $widgets[$widget_name];
   }

	public function register_multiwidgets() {
		foreach ( $this->get_templates() as $index => $template_widget ) {
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
                  return [ 'dh-multiwidgets' ];
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