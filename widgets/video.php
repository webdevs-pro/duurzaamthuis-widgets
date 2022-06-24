<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


class DH_Video extends \Elementor\Widget_Base {

	public function get_name() {
		return 'dh-video';
	}

	public function get_title() {
		return __( 'Video', 'duurzaamthuis' );
	}

	public function get_icon() {
		return 'eicon-play';
	}

	public function get_categories() {
		return [ 'dh-widgets' ];
	}

	protected function register_controls() {
      DH_Widgets_Content_Controls::get_dh_video_controls( $this );
	}

	protected function render() { // php template
		$settings = $this->get_settings_for_display();

	}
	
}