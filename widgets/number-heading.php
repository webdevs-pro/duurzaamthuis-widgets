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

	protected function register_controls() {
      DH_Widgets_Content_Controls::get_dh_number_heading_controls( $this );
	}

	protected function render() { // php template
		$settings = $this->get_settings_for_display();
		?><div class="<?php echo 'dh-widget-' . $this->get_name() . DH_Widgets_Content_Controls::get_prefix_classes( $this, $settings ); ?>"><?php

			$add_class = $settings['dh_number_heading_badge'] != 'none' ? ' with-badge' : '';
			echo '<' . $settings['dh_number_heading_size'] . ' class="dh-number-heading' . $add_class . '">';
				echo '<div class="dh-number">' . $settings['dh_number_heading_number'] . '</div>';
				echo '<div class="dh-heading">' . $settings['dh_number_heading_heading'] . '</div>';
				if ( $settings['dh_number_heading_badge'] ) {
					switch ( $settings['dh_number_heading_badge'] ) {
						case 'best_choise':
							echo '<div class="dh-heading-badge dh-heading-choise-badge"><span>Beste keuze</span></div>';
							break;
						case 'reading_tip':
							echo '<div class="dh-heading-badge dh-heading-choise-badge"><span>Leestip</span></div>';
							break;
					}
				}
			echo '</' . $settings['dh_number_heading_size'] . '>';
		?></div><?php
	}

	protected function content_template() { // php template

      ?>
			<# 
				var classes = [];
				jQuery.each( view.model.attributes.settings.controls, function( index, value ) {
					if ( value.add_widget_class && settings[index] && value.section == 'dh_impact_content' ) {
						classes.push( value.add_widget_class + settings[index] );
					}
				} ); 
				classes = ' ' + classes.join( ' ' );
			#>
			<div class="<?php echo 'dh-widget-' . $this->get_name(); ?>{{{ classes }}}">
				<# var add_class = settings.dh_number_heading_badge != 'none' ? ' with-badge' : ''; #>
				<{{{ settings.dh_number_heading_size }}} class="dh-number-heading{{{ add_class }}}">
					<div class="dh-number">{{{ settings.dh_number_heading_number }}}</div>
					<div class="dh-heading">{{{ settings.dh_number_heading_heading }}}</div>
					<#
						if(settings.dh_number_heading_badge) {
							switch(settings.dh_number_heading_badge) {
								case 'best_choise': #>
									<div class="dh-heading-badge dh-heading-choise-badge"><span>Beste keuze</span></div>
									<# break;
								case 'reading_tip': #>
									<div class="dh-heading-badge dh-heading-choise-badge"><span>Leestip</span></div>
									<# break;
							}
						}
					#>
				</{{{ settings.dh_number_heading_size }}}>
			</div>
      <?php

	}
	
}