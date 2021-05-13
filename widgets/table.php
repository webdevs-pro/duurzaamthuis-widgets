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
		return 'dh-icons-table';
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
            'label' => 'Test',
            'label_block' => true,
            'type' => 'dh-table-control',
            'default' => '[["Column 1 heading","Column 2 heading"],["Some text","Some text"]]',
         ]);

		$this->end_controls_section(); 



	}

	protected function render() { // php template

		$settings = $this->get_settings_for_display();

		$rows = json_decode( $settings['table'] ) ?: array();

      $html = '';
      foreach ( $rows as $index => $row ) {
         $html .= '<tr>';
         foreach ( $row as $cell ) {
            $html .= '<td contenteditable>' . $cell . '</td>';
         }
         $html .= '</tr>';
      }
      echo '<table>' . $html . '</table>';

      /*
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
      */
	}
	
}