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
							<a class="elementor-button-link elementor-button elementor-size-sm" href="<?php echo $button_link; ?>">
								<?php echo $button_text; ?>
							</a>
						<?php } ?>

					</div>
				</div>
			</div>
		<?php
	}

	protected function content_template() {
		?>
			<# 
				setTimeout(function() {
					var classes = [];
					jQuery.each( view.el.classList, function( index, value ) {
						if ( value.startsWith('dh-') ) {	
							classes.push( value );
						}
					} );
					classes = ' ' + classes.join( ' ' );
					view.$el.find( '.<?php echo 'dh-widget-' . $this->get_name(); ?>' ).addClass(classes);
					console.log('settings.dh_image_heading_text_image', settings.dh_image_heading_text_image);
				}, 10 );
			#>
         <div class="<?php echo 'dh-widget-' . $this->get_name(); ?>">
				<div class="dh-wrapper">
					<# if ( settings.dh_image_heading_text_image_show_image == 'yes' ) { #>
						<div class="dh-image-column">
							<img src="{{ settings.dh_image_heading_text_image.url }}">
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
								<a class="elementor-button-link elementor-button elementor-size-sm" href="{{{ settings.dh_image_heading_text_button_url }}}">
									{{{ settings.dh_image_heading_text_button_text }}}
								</a>
							<# } #>
					</div>
				</div>
			</div>
		<?php
	}
	
}