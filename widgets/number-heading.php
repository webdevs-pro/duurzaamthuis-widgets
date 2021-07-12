<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


class DH_Number_Heading extends \Elementor\Widget_Base {

	public function get_name() {
		return 'dh-number-heading';
	}

	public function get_title() {
		return __( 'Number Heading', 'duurzaamthuis' );
	}

	public function get_icon() {
		return 'dh-icon dh-icon-number-heading';
	}

	public function get_categories() {
		return [ 'dh-widgets' ];
	}

	protected function _register_controls() {

		// SECTION CONTENT
		$this->start_controls_section( 'section_content', [
         'label' => __( 'Content', 'duurzaamthuis' ),
         'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
      ] );
			$this->add_control( 'number', [
				'label' => __( 'Number', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 100,
				'step' => 1,
				'default' => 1,
			] );
			$this->add_control( 'heading', [
				'label' => __( 'Heading', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'rows' => 3,
				'default' => __( 'Default heading', 'plugin-domain' ),
			] );
			$this->add_control( 'badge', [
				'label' => __( 'Badge', 'duurzaamthuis' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'none',
				'options' => [
					'none'  => __( 'None', 'duurzaamthuis' ),
					'best_choise' => __( 'Beste Keuze', 'duurzaamthuis' ),
					'reading_tip' => __( 'Leestip', 'duurzaamthuis' ),
				],
			] );
			$this->add_control( 'size', [
				'label' => __( 'Size', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'h2',
				'options' => [
					'h1'  => __( 'H1', 'plugin-domain' ),
					'h2' => __( 'H2', 'plugin-domain' ),
					'h3' => __( 'H3', 'plugin-domain' ),
					'h4' => __( 'H4', 'plugin-domain' ),
				],
			] );
		$this->end_controls_section(); 



	}

	protected function render() { // php template
		$settings = $this->get_settings_for_display();
		$add_class = $settings['badge'] != 'none' ? ' with-badge' : '';
      echo '<' . $settings['size'] . ' class="dh-number-heading' . $add_class . '">';
         echo '<div class="dh-number">' . $settings['number'] . '</div>';
         echo '<div class="dh-heading">' . $settings['heading'] . '</div>';
			if ( $settings['badge'] ) {
				switch ( $settings['badge'] ) {
					case 'best_choise':
						echo '<div class="dh-heading-badge dh-heading-choise-badge"><span>Beste keuze</span></div>';
						break;
					case 'reading_tip':
						echo '<div class="dh-heading-badge dh-heading-choise-badge"><span>Leestip</span></div>';
						break;
				}
			}
      echo '</' . $settings['size'] . '>';
	}

	protected function content_template() { // php template

      ?>
			<# var add_class = settings.badge != 'none' ? ' with-badge' : ''; #>
         <{{{ settings.size }}} class="dh-number-heading{{{ add_class }}}">
            <div class="dh-number">{{{ settings.number }}}</div>
            <div class="dh-heading">{{{ settings.heading }}}</div>
				<#
					if(settings.badge) {
						switch(settings.badge) {
							case 'best_choise': #>
								<div class="dh-heading-badge dh-heading-choise-badge"><span>Beste keuze</span></div>
								<# break;
							case 'reading_tip': #>
								<div class="dh-heading-badge dh-heading-choise-badge"><span>Leestip</span></div>
								<# break;
						}
					}
				#>
         </{{{ settings.size }}}>
      <?php

	}
	
}