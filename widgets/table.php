<?php

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Modules\DynamicTags\Module as TagsModule;


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}



class DH_Table extends \Elementor\Widget_Base {

	public function get_name() {
		return 'dh-table';
	}

	public function get_title() {
		return __( 'Table', 'duurzaamthuis' );
	}

	public function get_icon() {
		return 'dh-icon dh-icon-table';
	}

	public function get_categories() {
		return [ 'dh-widgets' ];
	}

	protected function _register_controls() {

		// SECTION CONTENT
		$this->start_controls_section( 'section_content', [
         'label' => __( 'Content', 'magnific-addons' ),
         'tab' => Controls_Manager::TAB_CONTENT,
      ]);

         $this->add_control( 'table', [
            'label' => 'Table',
            'label_block' => true,
            'type' => 'dh-table-control',
            'default' => '[["Column 1 heading","Column 2 heading"],["Some text","Some text"]]',
         ]);

		$this->end_controls_section(); 



	}

	protected function render() { // php template

		$settings = $this->get_settings_for_display();

		$rows = json_decode( $settings['table'] ) ?: array();

      $html = '<div class="dh-table-wrapper"><table>';
      foreach ( $rows as $index => $row ) {
         if ( $index == 0 ) {
            $tag = 'th';
         } else {
            $tag = 'td';
         }
         $html .= '<tr>';
         foreach ( $row as $cell ) {
            $html .= '<' . $tag . ' contenteditable>' . $cell . '</' . $tag . '>';
         }
         $html .= '</tr>';
      }
      $html .= '</table></div>';
      echo $html;


	}
	
}