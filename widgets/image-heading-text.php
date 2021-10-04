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
		$image = $settings['dh_image_heading_image'];
		$heading = $settings['dh_image_heading_heading'];
		$content = $this->parse_text_editor( $settings['dh_image_heading_content'] );

		?>
         <div class="<?php echo 'dh-widget-' . $this->get_name() . DH_Widgets_Content_Controls::get_prefix_classes( $this, $settings ); ?>">
				<div class="dh-wrapper">
					<div class="dh-image-column">
						<img src="<?php echo $image['url']; ?>">
					</div>
					<div class="dh-gap-column"></div>
					<div class="dh-content-column">
						<h2>
							<?php echo $heading; ?>
						</h2>
						<div class="dh-content">
							<?php echo $content; ?>
						</div>
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
					if ( value.prefix_class && settings[index] && value.section == 'dh_image_heading_text_content' ) {
						classes.push( value.prefix_class + settings[index] );
					}
				} ); 
				classes = ' ' + classes.join( ' ' );
			#>
         <div class="<?php echo 'dh-widget-' . $this->get_name(); ?>{{{ classes }}}">
				<div class="dh-wrapper">
					<div class="dh-image-column">
						<img src="{{ settings.dh_image_heading_image.url }}">
					</div>
					<div class="dh-gap-column"></div>
					<div class="dh-content-column">
						<h2>
							{{{ settings.dh_image_heading_heading }}}
						</h2>
						<div class="dh-content">
							{{{ settings.dh_image_heading_content }}}
						</div>
					</div>
				</div>
			</div>
		<?php
	}
	
}