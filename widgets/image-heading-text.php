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
		return 'eicon-featured-image';
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
         <?php 
				$e = new Exception(); 
				$is_multiwidget = strpos( $e->getTrace()[2]['file'], 'multiwidgets.php' ) ? true : false;
				echo sprintf( '<div class="%s"%s>',
					( $is_multiwidget ? 'elementor-element elementor-widget elementor-widget-' . $this->get_name() : '' ) . ' dh-widget-' . $this->get_name() . DH_Widgets_Content_Controls::get_prefix_classes( $this, $settings ),
					$is_multiwidget ? ' data-widget_type="' . $this->get_name() . '.default" data-element_type="widget"' : ''
				); 
			?>
				<div class="dh-wrapper">
					<?php if ( $settings['dh_image_heading_text_image_show_image'] == 'yes' ) { ?>
						<div class="dh-image-column">
							<div class="dh-image-wrapper">
								<div class="dh-image">
									<?php
										if ( $image['id'] ) {
											echo wp_get_attachment_image( $image['id'], 'large' );
										} else if ( $image['url'] && ! $image['id'] ) {
											echo '<img src="' . $image['url'] . '">';
										}
									?>
								</div>
							</div>
						</div>
						<div class="dh-gap-column"></div>
					<?php } ?>
					<div class="dh-content-column">
						<?php if ( $settings['dh_image_heading_text_image_show_heading'] == 'yes' ) { ?>
							<h2>
								<?php echo $heading; ?>
							</h2>
						<?php } ?>
						<?php if ( $settings['dh_image_heading_text_image_show_text'] == 'yes' ) { 
							$uid = uniqid();
						?>
							<div class="dh-content uid-<?php echo $uid; ?>">
								<?php echo $content; ?>
								<?php if ( $settings['dh_image_heading_text_image_style_numbers'] == 'yes' ) { ?>
									<style>
										.uid-<?php echo $uid; ?> ol {
											list-style: none;
											counter-reset: item;
										}
										.uid-<?php echo $uid; ?> ol li {
											counter-increment: item;
											margin-bottom: 1.5em;
											margin-left: 0.8em;
											position: relative;
										}
										.uid-<?php echo $uid; ?> ol li:before {
											margin-right: 10px;
											content: counter(item);
											background: #EADECC;
											border-radius: 50%;
											width: 2em;
											height: 2em;
											display: inline-flex;
											justify-content: center;
											align-items: center;
											flex-shrink: 0;
											font-weight: 700;
											color: #515F70;
											position: absolute;
											left: -3.1em;
											top: -0.2em;
										}
									</style>
								<?php } ?>
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
							<div class="dh-image-wrapper">
								<div class="dh-image">
									<img src="{{ settings.dh_image_heading_text_image.url }}" width="{{{width}}}" height="{{{height}}}" onload="javascript: sessionStorage.setItem('{{{id}}}', JSON.stringify({ 'width': this.naturalWidth, 'height': this.naturalHeight }));">
								</div>
							</div>
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
							<#
							function uniqid (prefix, more_entropy) {
								if (typeof prefix === 'undefined') {
									prefix = "";
								}
								var retId;
								var formatSeed = function (seed, reqWidth) {
									seed = parseInt(seed, 10).toString(16); // to hex str
									if (reqWidth < seed.length) { // so long we split
										return seed.slice(seed.length - reqWidth);
									}
									if (reqWidth > seed.length) { // so short we pad
										return Array(1 + (reqWidth - seed.length)).join('0') + seed;
									}
									return seed;
								};
								if (!this.php_js) {
									this.php_js = {};
								}
								if (!this.php_js.uniqidSeed) { // init seed with big random int
									this.php_js.uniqidSeed = Math.floor(Math.random() * 0x75bcd15);
								}
								this.php_js.uniqidSeed++;
								retId = prefix; // start with prefix, add current milliseconds hex string
								retId += formatSeed(parseInt(new Date().getTime() / 1000, 10), 8);
								retId += formatSeed(this.php_js.uniqidSeed, 5); // add seed hex string
								if (more_entropy) {
									// for more entropy we add a float lower to 10
									retId += (Math.random() * 10).toFixed(8).toString();
								}
								return retId;
							}

							var uid = uniqid();
							#>
								<div class="dh-content uid-{{{uid}}}">
									{{{ settings.dh_image_heading_text_content }}}


									<# if ( settings.dh_image_heading_text_image_style_numbers == 'yes' ) { #>
										<style>
											.uid-{{{ uid }}} ol {
												list-style: none;
												counter-reset: item;
											}
											.uid-{{{ uid }}} ol li {
												counter-increment: item;
												margin-bottom: 1.5em;
												margin-left: 0.8em;
												position: relative;
											}
											.uid-{{{ uid }}} ol li:before {
												margin-right: 10px;
												content: counter(item);
												background: #EADECC;
												border-radius: 50%;
												width: 2em;
												height: 2em;
												display: inline-flex;
												justify-content: center;
												align-items: center;
												flex-shrink: 0;
												font-weight: 700;
												color: #515F70;
												position: absolute;
												left: -3.1em;
												top: -0.2em;
											}
										</style>
									<# } #>
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