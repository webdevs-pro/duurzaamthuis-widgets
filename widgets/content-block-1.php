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



class Content_Block_1_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'duurzaamthuis-content-1';
	}

	public function get_title() {
		return __( 'Content block 1', 'duurzaamthuis' );
	}

	public function get_icon() {
		return 'duurzaamthuis-widgets-icon-content-1';
	}

	public function get_categories() {
		return [ 'duurzaamthuis-widgets' ];
	}

	protected function _register_controls() {






	}

	protected function render() { // php template

		
	}
	
}