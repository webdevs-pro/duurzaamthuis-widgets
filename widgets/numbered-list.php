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

	protected function register_controls() {
      DH_Widgets_Content_Controls::get_dh_numbered_list_controls( $this );
	}

	protected function render() { // php template
		$settings = $this->get_settings_for_display();

		if ( $settings['dh_numbered_list_items'] ) {
         ?><div class="<?php echo 'dh-widget-' . $this->get_name() . DH_Widgets_Content_Controls::get_prefix_classes( $this, $settings ); ?>"><?php

         echo '<div class="dh-numbered-list">';
            foreach (  $settings['dh_numbered_list_items'] as $index => $item ) {
					echo '<div class="dh-numbered-list-item">';
						echo '<div class="dh-numbered-list-item-number">' . ( $index + 1 ) . '</div>';
						echo '<div class="dh-numbered-list-item-text">' . $item['dh_numbered_list_text']. '</div>';
					echo '</div>';
				}
         echo '</div>';

			?></div><?php
		}

	}

	protected function content_template() { // php template

      ?>
		<# if ( settings.dh_numbered_list_items ) { #>
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
				<div class="dh-numbered-list">
					<# _.each( settings.dh_numbered_list_items, function( item, index ) { #>
						<div class="dh-numbered-list-item">
							<div class="dh-numbered-list-item-number">{{{ index + 1 }}}</div>
							<div class="dh-numbered-list-item-text">{{{ item.dh_numbered_list_text }}}</div>
						</div>
					<# }); #>
				</div>
			</div>
		<# } #>
      <?php

	}
	
}