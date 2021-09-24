<?php


use Elementor\Controls_Manager;


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}



class DH_Template extends \Elementor\Widget_Base {

	public function get_name() {
		return 'dh-template';
	}

	public function get_title() {
		return __( 'Template', 'duurzaamthuis' );
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

	protected function register_controls() {
		$this->start_controls_section( 'dh_template_section_content', [
         'label' => __( 'Template', 'duurzaamthuis' ),
         'tab' => Elementor\Controls_Manager::TAB_CONTENT,
      ] );
			$this->add_control( 'dh_template_post_id', [
				'label' => __( 'Select Item', 'duurzaamthuis' ),
				'type' => ElementorPro\Modules\QueryControl\Module::QUERY_CONTROL_ID,
				'options' => [],
				'label_block' => true,
				'multiple' => false,
				'autocomplete' => [
					'object' => ElementorPro\Modules\QueryControl\Module::QUERY_OBJECT_LIBRARY_TEMPLATE,
				],
			] );
			$this->add_control( 'dh_template_button', [
				'type' => Elementor\Controls_Manager::RAW_HTML,
				'raw' => '<button class="elementor-button elementor-button-default dh-edit-template">Edit template</button>',
			] );
		$this->end_controls_section(); 
	}


	protected function render() { // php template
		$settings = $this->get_settings_for_display();

      echo \Elementor\Plugin::instance()->frontend->get_builder_content_for_display( esc_attr( $settings['dh_template_post_id'] ), true );
      // echo \Elementor\Plugin::instance()->frontend->get_builder_content( esc_attr( $settings['post_id'] ), true );
	}
	
}