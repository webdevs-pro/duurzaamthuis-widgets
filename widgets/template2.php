<?php


use Elementor\Controls_Manager;


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}



class DH_Template2 extends \Elementor\Widget_Base {

	public function get_name() {
		return 'dh-template2';
	}

	public function get_title() {
		return __( 'Template2', 'duurzaamthuis' );
	}

	public function get_icon() {
		return 'eicon-single-page';
	}

	public function get_categories() {
		return [ 'dh-widgets' ];
	}
   
   public function get_script_depends() {
		return [ 'duurzaamthuis-widgets' ];
	}
   
   public function get_widgets() {
      return array(
         'dh-anchor-navigation' => 'DH_Anchor_Navigation',
         'dh-product-comparition' => 'DH_Product_Comparison',
         'dh-image-heading-text' => 'DH_Image_Heading_Text',
         'dh-impact' => 'DH_Impact',
         'dh-table' => 'DH_Table',
         'dh-number-heading' => 'DH_Number_Heading',
         'dh-mega-menu' => 'DH_Mega_Menu',
         'dh-numbered-list' => 'DH_Numbered_List',
         'dh-page-header' => 'DH_Page_Header',
         'dh-product-comparition-sustainability-score' => 'DH_Product_Comparition_Sustainability_Score',
         'dh-related-content' => 'DH_Related_Posts',
      );
   }

	protected function register_controls() {
      foreach ( $this->get_widgets() as $name => $class_name ) {
         $fn_name = str_replace( '-', '_', 'get_' . $name . '_controls' );
         DH_Widgets_Content_Controls::$fn_name( $this );
      }
	}

	protected function render() { // php template
		$settings = $this->get_settings_for_display();

      foreach ( $this->get_widgets() as $name => $class_name ) {
         $widget_config = array(
            'id'         => '',
            'elType'     => 'widget',
            'settings'   => $settings,
            'widgetType' => $name,
         );
         $widget = Elementor\Plugin::$instance->elements_manager->create_element_instance( $widget_config );
         $widget->render_content();
      }
	}

   protected function content_template() { // js template

      foreach ( $this->get_widgets() as $name => $class_name ) {
         echo '<div class="elementor-widget-container">';
            call_user_func( array( ( new $class_name ), 'content_template' ) );
         echo '</div>';
      }
	}
	
}