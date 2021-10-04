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



class DH_Anchor_Navigation extends \Elementor\Widget_Base {

	public function get_name() {
		return 'dh-anchor-navigation';
	}

	public function get_title() {
		return __( 'Anchor navigation', 'duurzaamthuis' );
	}

	public function get_icon() {
		return 'dh-icon dh-icon-anchor-navigation';
	}

	public function get_categories() {
		return [ 'dh-widgets' ];
	}

	protected function register_controls() {
      DH_Widgets_Content_Controls::get_dh_anchor_navigation_controls( $this );
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		$heading = $settings['dh_anchor_navigation_heading'];
      $items = $settings['dh_anchor_navigation_items'] ?: array();

		?>
         <div class="<?php echo 'dh-widget-' . $this->get_name() . DH_Widgets_Content_Controls::get_prefix_classes( $this, $settings ); ?>">
            <h2 class="dh-heading">
               <?php echo $heading; ?>
            </h2>
            <div class="dh-repeater">
               <?php foreach ( $items as $item ) { ?>
                  <a class="dh-item" <?php echo $item['dh_anchor_navigation_anchor'] ? 'href="#' . $item['dh_anchor_navigation_anchor'] . '"' : ''; ?>>
                     <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12.2744 19.75V4.75" stroke="#515F70" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M18.2988 13.7002L12.2748 19.7502L6.24976 13.7002" stroke="#515F70" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                     </svg>
                     <?php echo $item['dh_anchor_navigation_title']; ?>
                  </a>
               <?php } ?>
            </div>
         </div>
		<?php
	}

	protected function content_template() {
      ?>
			<# 
				// console.log('dh-anchor-navigation', view.model.attributes.settings.controls);
				var classes = [];
				jQuery.each( view.model.attributes.settings.controls, function( index, value ) {
					if ( value.prefix_class && settings[index] && value.section == 'dh_anchor_navigation_section_content' ) {
						classes.push( value.prefix_class + settings[index] );
					}
				} ); 
				classes = ' ' + classes.join( ' ' );
			#>
         <div class="<?php echo 'dh-widget-' . $this->get_name(); ?>{{{ classes }}}">
            <h2 class="dh-heading">
               {{{ settings.dh_anchor_navigation_heading }}}
            </h2>
            <div class="dh-repeater">
               <# _.each( settings.dh_anchor_navigation_items, function( item ) { #>
                  <# if(item.dh_anchor_navigation_anchor) {
                     var href = 'href="#' + item.dh_anchor_navigation_anchor + '"';
                  } else {
                     var href = '';
                  } #>
                  <a class="dh-item" {{{ href }}}>
                     <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12.2744 19.75V4.75" stroke="#515F70" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M18.2988 13.7002L12.2748 19.7502L6.24976 13.7002" stroke="#515F70" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                     </svg>
                     {{{ item.dh_anchor_navigation_title }}}
                  </a>
               <# }); #>
            </div>
         </div>
		<?php
	}
	
}