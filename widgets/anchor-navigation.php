<?php

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Text_Shadow;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}



class DH_Anchor_Navigation extends \Elementor\Widget_Base {

	public function get_name() {
		return 'dh-anchor-navigation';
	}

	public function get_title() {
		return __( 'Anchor navigation', 'duurzaamthuis' );
	}

	public function get_icon() {
		return 'dh-icon dh-icon-anchor-navigation';
	}

	public function get_categories() {
		return [ 'dh-widgets' ];
	}

	protected function _register_controls() {

		// SECTION CONTENT
		$this->start_controls_section( 'section_content', [
         'label' => __( 'Content', 'duurzaamthuis' ),
         'tab' => Controls_Manager::TAB_CONTENT,
      ] );

			$this->add_control( 'heading', [
            'label' => __( 'Heading', 'duurzaamthuis' ),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => __( 'Heading text', 'duurzaamthuis' ),
            'label_block' => true,
            'separator' => 'before'
         ] );

         $repeater = new \Elementor\Repeater();

         $repeater->add_control( 'title', [
            'label' => __( 'Title', 'duurzaamthuis' ),
            'type' => \Elementor\Controls_Manager::TEXT,
            'label_block' => true,
         ] );
   
         $repeater->add_control( 'anchor', [
            'label' => __( 'Anchor', 'duurzaamthuis' ),
            'type' => \Elementor\Controls_Manager::TEXT,
            'label_block' => true,
         ] );
         
         $repeater->add_control( 'description', [
            'raw' => __( 'Only Id without \'#\' sign', 'elementor-pro' ),
            'type' => Controls_Manager::RAW_HTML,
            'content_classes' => 'elementor-descriptor',
         ] );
   
         $this->add_control( 'items', [
            'label' => __( 'Items', 'duurzaamthuis' ),
            'type' => \Elementor\Controls_Manager::REPEATER,
            'fields' => $repeater->get_controls(),
            'title_field' => '{{{ title }}}',
         ] );



		$this->end_controls_section(); 



	}

	protected function render() { // php template

		$settings = $this->get_settings_for_display();

		$heading = $settings['heading'];
      $items = $settings['items'] ?: array();

		?>
         <h2 class="dh-heading">
            <?php echo $heading; ?>
         </h2>
         <div class="dh-repeater">
            <?php foreach ( $items as $item ) { ?>
               <a class="dh-item" <?php echo $item['anchor'] ? 'href="#' . $item['anchor'] . '"' : ''; ?>>
                  <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                     <path d="M12.2744 19.75V4.75" stroke="#515F70" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                     <path d="M18.2988 13.7002L12.2748 19.7502L6.24976 13.7002" stroke="#515F70" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
                  <?php echo $item['title']; ?>
               </a>
            <?php } ?>
         </div>
		<?php
	}
	
}