<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


class DH_Numbered_List extends \Elementor\Widget_Base {

	public function get_name() {
		return 'dh-numbered-list';
	}

	public function get_title() {
		return __( 'Numbered List', 'duurzaamthuis' );
	}

	public function get_icon() {
		return 'dh-icon dh-icon-numbered-list';
	}

	public function get_categories() {
		return [ 'dh-widgets' ];
	}

	protected function _register_controls() {

		// SECTION CONTENT
		$this->start_controls_section( 'section_content', [
         'label' => __( 'Content', 'duurzaamthuis' ),
         'tab' => Elementor\Controls_Manager::TAB_CONTENT,
      ] );
			$repeater = new \Elementor\Repeater();

				$repeater->add_control( 'text', [
					'label' => __( 'Text', 'duurzaamthuis' ),
					'type' => Elementor\Controls_Manager::TEXTAREA,
					'rows' => 3,
					'default' => __( 'Item text' , 'duurzaamthuis' ),
					'label_block' => true,
				] );
			$this->add_control( 'items', [
				'label' => __( 'Products', 'duurzaamthuis' ),
				'type' => Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'text' => __( 'Item text', 'duurzaamthuis' ),
					],
					[
						'text' => __( 'Item text', 'duurzaamthuis' ),
					],
				],
				'title_field' => '{{{ text }}}',
			] );
		$this->end_controls_section(); 



	}

	protected function render() { // php template

		$settings = $this->get_settings_for_display();

		if ( $settings['items'] ) {
         echo '<div class="dh-numbered-list">';
            foreach (  $settings['items'] as $index => $item ) {
					echo '<div class="dh-numbered-list-item">';
						echo '<div class="dh-numbered-list-item-number">' . ( $index + 1 ) . '</div>';
						echo '<div class="dh-numbered-list-item-text">' . $item['text']. '</div>';
					echo '</div>';
				}
         echo '</div>';
		}

	}

	protected function content_template() { // php template

      ?>
		<# if ( settings.items ) { #>
         <div class="dh-numbered-list">
				<# _.each( settings.items, function( item, index ) { #>
					<div class="dh-numbered-list-item">
						<div class="dh-numbered-list-item-number">{{{ index + 1 }}}</div>
						<div class="dh-numbered-list-item-text">{{{ item.text }}}</div>
					</div>
				<# }); #>
         </div>
		<# } #>
      <?php

	}
	
}