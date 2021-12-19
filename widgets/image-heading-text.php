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



class DH_Image_Heading_Text extends \Elementor\Widget_Base {

	public function get_name() {
		return 'dh-image-heading-text';
	}

	public function get_title() {
		return __( 'Image with heading <br>and text', 'duurzaamthuis' );
	}

	public function get_icon() {
		return 'dh-icon dh-icon-image-heading-text';
	}

	public function get_categories() {
		return [ 'dh-widgets' ];
	}

	protected function register_controls() {
      DH_Widgets_Content_Controls::get_dh_image_heading_text_controls( $this );
	}

	protected function render() { // php template
		$settings = $this->get_settings_for_display();
		$image = $settings['dh_image_heading_text_image'];
		$heading = $settings['dh_image_heading_text_heading'];
		$content = $this->parse_text_editor( $settings['dh_image_heading_text_content'] );
		$button_text = $settings['dh_image_heading_text_button_text'];
		$button_link = $settings['dh_image_heading_text_button_url'];

		?>
         <div class="<?php echo 'dh-widget-' . $this->get_name() . DH_Widgets_Content_Controls::get_prefix_classes( $this, $settings ); ?>">
				<div class="dh-wrapper">
					<?php if ( $settings['dh_image_heading_text_image_show_image'] == 'yes' ) { ?>
						<div class="dh-image-column">
							<img src="<?php echo $image['url']; ?>">
						</div>
						<div class="dh-gap-column"></div>
					<?php } ?>
					<div class="dh-content-column">
						<?php if ( $settings['dh_image_heading_text_image_show_heading'] == 'yes' ) { ?>
							<h2>
								<?php echo $heading; ?>
							</h2>
						<?php } ?>
						<?php if ( $settings['dh_image_heading_text_image_show_text'] == 'yes' ) { ?>
							<div class="dh-content">
								<?php echo $content; ?>
							</div>
						<?php } ?>
						<?php if ( $settings['dh_image_heading_text_image_show_button'] == 'yes' ) { ?>
							<div class="dh-image-heading-text-button-wrapper">
								<a class="elementor-button-link elementor-button elementor-size-sm" href="<?php echo $button_link['url']; ?>">
									<?php echo $button_text; ?>
								</a>
							</div>
						<?php } ?>

					</div>
				</div>
			</div>
		<?php
	}

	protected function content_template() {
		?>
			<# 
				var classes = [];
				jQuery.each( view.model.attributes.settings.controls, function( index, value ) {
					if ( value.prefix_class && settings[index] && value.section == 'dh_image_heading_text_content_section' ) {
						if ( value.condition ) {
							var condition = Object.entries(value.condition)[0];
							if ( settings[condition[0]] ) {
								classes.push( value.prefix_class + settings[index] );
							}
						} else {
							classes.push( value.prefix_class + settings[index] );
						}
					}
				} ); 
				classes = ' ' + classes.join( ' ' );

				var width;
				var height;
				var img_dimensions = sessionStorage.getItem(id);
				if ( img_dimensions !== null ) {
					img_dimensions = JSON.parse( img_dimensions );
					width = img_dimensions.width;
					height = img_dimensions.height;
				} 


			#>
         <div class="<?php echo 'dh-widget-' . $this->get_name(); ?>{{{ classes }}}">
				<div class="dh-wrapper">
					<# if ( settings.dh_image_heading_text_image_show_image == 'yes' ) { #>
						<div class="dh-image-column">
							<img src="{{ settings.dh_image_heading_text_image.url }}" width="{{{width}}}" height="{{{height}}}" onload="javascript: sessionStorage.setItem('{{{id}}}', JSON.stringify({ 'width': this.naturalWidth, 'height': this.naturalHeight }));">
						</div>
						<div class="dh-gap-column"></div>
					<# } #>
					<div class="dh-content-column">
						<# if ( settings.dh_image_heading_text_image_show_heading == 'yes' ) { #>
							<h2>
								{{{ settings.dh_image_heading_text_heading }}}
							</h2>
							<# } #>
							
							<# if ( settings.dh_image_heading_text_image_show_text == 'yes' ) { #>
								<div class="dh-content">
									{{{ settings.dh_image_heading_text_content }}}
								</div>
							<# } #>

							<# if ( settings.dh_image_heading_text_image_show_button == 'yes' ) { #>
								<div class="dh-image-heading-text-button-wrapper">
									<a class="elementor-button-link elementor-button elementor-size-sm" href="{{{ settings.dh_image_heading_text_button_url.url }}}">
										{{{ settings.dh_image_heading_text_button_text }}}
									</a>
								</div>
							<# } #>
					</div>
				</div>
			</div>
		<?php
	}
	
}