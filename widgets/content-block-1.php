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
		return __( 'Image with heading <br>and text', 'duurzaamthuis' );
	}

	public function get_icon() {
		return 'duurzaamthuis-widgets-icon-content-1';
	}

	public function get_categories() {
		return [ 'duurzaamthuis-widgets' ];
	}

	protected function _register_controls() {

		// SECTION CONTENT
		$this->start_controls_section(
			'section_content',
			[
				'label' => __( 'Content', 'magnific-addons' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

			$this->add_control(
				'image',
				[
					'label' => __( 'Choose Image', 'plugin-domain' ),
					'type' => \Elementor\Controls_Manager::MEDIA,
					'default' => [
						'url' => \Elementor\Utils::get_placeholder_image_src(),
					],
				]
			);
			$this->add_control(
				'image_align',
				[
					'label' => __( 'Image Column Alignment', 'plugin-domain' ),
					'type' => \Elementor\Controls_Manager::CHOOSE,
					'options' => [
						'left' => [
							'title' => __( 'Left', 'plugin-domain' ),
							'icon' => 'eicon-h-align-left',
						],
						'right' => [
							'title' => __( 'Right', 'plugin-domain' ),
							'icon' => 'eicon-h-align-right',
						],
					],
					'default' => 'left',
					'toggle' => false,
					'prefix_class' => 'image-align-',
				]
			);
			$this->add_control(
				'image_width',
				[
					'label' => __( 'Image Column Width', 'plugin-domain' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => '50',
					'options' => [
						'33'  => __( '33%', 'plugin-domain' ),
						'50' => __( '50%', 'plugin-domain' ),
						'66' => __( '66%', 'plugin-domain' ),
					],
					'prefix_class' => 'image-width-',
				]
			);
			$this->add_control(
				'image_reverse',
				[
					'label' => __( 'Mobile Columns Reverse', 'plugin-domain' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => __( 'Yes', 'your-plugin' ),
					'label_off' => __( 'No', 'your-plugin' ),					
					'return_value' => 'columns',
					'prefix_class' => 'reverse-',
				]
			);
			$this->add_control(
				'heading',
				[
					'label' => __( 'Heading', 'plugin-domain' ),
					'type' => \Elementor\Controls_Manager::TEXT,
					'default' => __( 'Heading text', 'plugin-domain' ),
					'label_block' => true,
					'separator' => 'before'
				]
			);
			$this->add_control(
				'content',
				[
					'label' => __( 'Content', 'plugin-domain' ),
					'type' => \Elementor\Controls_Manager::WYSIWYG,
					'default' => __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', 'plugin-domain' ),
				]
			);

		$this->end_controls_section(); 



	}

	protected function render() { // php template

		$settings = $this->get_settings_for_display();

		$image = $settings['image'];
		$heading = $settings['heading'];
		$content = $this->parse_text_editor( $settings['content'] );


		?>
			<div class="wrapper">
				<div class="image-column">
					<img src="<?php echo $image['url']; ?>">
				</div>
				<div class="gap-column"></div>
				<div class="content-column">
					<h2>
						<?php echo $heading; ?>
					</h2>
					<div class="content">
						<?php echo $content; ?>
					</div>
				</div>
			</div>
		<?php
	}

	protected function content_template() {

		?>
			<div class="wrapper">
				<div class="image-column">
					<img src="{{ settings.image.url }}">
				</div>
				<div class="gap-column">
				<div class="content-column">
					<h2>
						{{{ settings.heading }}}
					</h2>
					<div class="content">
						{{{ settings.content }}}
					</div>
				</div>
			</div>
		<?php
	}
	
}