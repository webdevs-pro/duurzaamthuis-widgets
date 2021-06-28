<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


// register icon font
add_action( 'elementor/editor/after_enqueue_styles', 'icons_font_styles' );
add_action( 'elementor/preview/enqueue_styles', 'icons_font_styles' );
function icons_font_styles() {
	wp_enqueue_style( 'dh-icons', plugin_dir_url( __FILE__ ) . '/assets/dh-icons-font/style.css', array(), DH_VERSION );
}




// register widgets
class DH_Register_Widgets {
	public function __construct() {
		$this->add_actions();
	}
	private function add_actions() {
		
		add_action( 'elementor/widgets/widgets_registered', [ $this, 'on_widgets_registered' ] );
		
		add_action( 'elementor/frontend/after_register_scripts', function() {
			// to do replace time() with plugin version
			wp_register_script( 'duurzaamthuis-widgets', plugins_url( '/assets/duurzaamthuis-widgets.js', __FILE__ ), array( 'jquery' ), time(), true );
		});
		
		add_action( 'elementor/frontend/after_enqueue_styles', function() {
			// to do replace time() with plugin version
			wp_enqueue_style( 'duurzaamthuis-widgets', plugins_url( '/assets/duurzaamthuis-widgets.css', __FILE__ ), array(), time() ); 
			wp_enqueue_style( 'dh-icons', plugins_url( '/assets/dh-icons-font/style.css', __FILE__ ), array(), time() ); 
		});

	}
	public function on_widgets_registered() {
		$this->includes();
		$this->register_widget();
	}
	private function includes() {
		require __DIR__ . '/widgets/image-heading-text.php';
		require __DIR__ . '/widgets/anchor-navigation.php';
		require __DIR__ . '/widgets/table.php';
		require __DIR__ . '/widgets/page-header.php';
		require __DIR__ . '/widgets/product-comparison.php';
		require __DIR__ . '/widgets/number-heading.php';
		require __DIR__ . '/widgets/impact.php';
		require __DIR__ . '/widgets/numbered-list.php';
		require __DIR__ . '/widgets/related-posts.php';
	}
	private function register_widget() {
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new DH_Image_Heading_Text() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new DH_Anchor_Navigation() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new DH_Table() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new DH_Page_Header() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new DH_Product_Comparison() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new DH_Number_Heading() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new DH_Impact() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new DH_Numbered_List() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new DH_Related_Posts() );
	}
}
new DH_Register_Widgets();






// register controls
add_action( 'elementor/controls/controls_registered', 'dh_register_controls' );
function dh_register_controls() {
	require __DIR__ . '/inc/modules/controls/popup-control.php';
	\Elementor\Plugin::$instance->controls_manager->register_control( 'dh-table-control', new DH_Popup_Control() );
	// require __DIR__ . '/inc/modules/controls/repeater-conrol.php';
	// \Elementor\Plugin::$instance->controls_manager->register_control( 'dh-repeater-conrol', new DH_Repeater_Control() );
}
// enqueue editor assets
add_action( 'elementor/editor/after_enqueue_scripts', function() {
   wp_register_script( 'dh-editor', DH_PLUGIN_DIR_URL . 'inc/assets/editor.js', array( 'jquery' ), time() );
   wp_enqueue_script( 'dh-editor' );
   wp_enqueue_style( 'dh-editor', DH_PLUGIN_DIR_URL . 'inc/assets/editor.css', array(), time() ); 
});






// disable pannel widgets for non admin
$user = wp_get_current_user();
if ( ! in_array( 'administrator', (array) $user->roles ) ) {
	add_filter( 'elementor/editor/localize_settings', 'disable_panel_widgets' );
}
function disable_panel_widgets( $settings ) {
	$user = wp_get_current_user();
	if ( in_array( 'administrator', (array) $user->roles ) ) return;

	$editor_allowed_widgets = array(
		'dh-image-heading-text',
		'dh-anchor-navigation',
		'dh-table',
		'dh-page-header',
		'dh-product-comparition',
		'heading',
	);

	foreach ( $settings['initial_document']['widgets'] as $widget_name => $widget_settings ) {

		if ( ! in_array( $widget_name, $editor_allowed_widgets ) ) {
			$settings['initial_document']['widgets'][$widget_name]['show_in_panel'] = false;
		}
	}

	return $settings;

}



// add_action(
// 	'elementor/element/before_section_end',
// 	function($section, $section_id, $args) {
// 		 if( $section->get_name() == 'heading' && $section_id == 'section_style' ) 
// 		 {
// 			  $section->remove_control('typography_typography');
// 		 }
// 	}, 10, 3
// );



function post_read_time( $post_id ) {
	$content = get_post_field( 'post_content', $post_id );
	$word_count = str_word_count( strip_tags( $content ) );
	$readingtime = ceil( $word_count / 200);
	return $readingtime;
}














/**
 * 
 * class for adding Impact meta section to Elementor page/post settings
 * 
 */
class DH_Impact_Fields {
	public function __construct() {
		add_action( 'elementor/element/wp-post/document_settings/after_section_end', [ $this, 'add_post_settings_controls' ] );
		add_action( 'elementor/element/wp-page/document_settings/after_section_end', [ $this, 'add_page_settings_controls' ] );
		add_action( 'elementor/document/after_save', [ $this, 'save_settings' ], 10, 2 );
	}
	public function add_post_settings_controls( \Elementor\Core\DocumentTypes\Post $post ) {
		$this->add_controls( $post );
	}
	public function add_page_settings_controls( \Elementor\Core\DocumentTypes\Page $page ) {
		$this->add_controls( $page );
	}
	public function add_controls( $post ) {
		$post->start_controls_section( 'section_impact', [
			'label' => __( 'Impact', 'duurzaamthuis' ),
			'tab' => \Elementor\Controls_Manager::TAB_SETTINGS, // https://developers.elementor.com/elementor-element-panel-tabs/
		] );
			$post->add_control( 'milieuwinst', [
				'label' => __( 'Milieuwinst', 'duurzaamthuis' ),
				'type' => \Elementor\Controls_Manager::TEXT,
			] );
			$post->add_control( 'prijs', [
				'label' => __( 'Prijs', 'duurzaamthuis' ),
				'type' => \Elementor\Controls_Manager::TEXT,
			] );
			$post->add_control( 'terugverdientijd', [
				'label' => __( 'Terugverdientijd', 'duurzaamthuis' ),
				'type' => \Elementor\Controls_Manager::TEXT,
			] );
			$post->add_control( 'gemak', [
				'label' => __( 'Gemak', 'duurzaamthuis' ),
				'type' => \Elementor\Controls_Manager::TEXT,
			] );
			$post->add_control( 'subsidie', [
				'label' => __( 'Subsidie', 'duurzaamthuis' ),
				'type' => \Elementor\Controls_Manager::TEXT,
			] );
			$post->add_control( 'vervuiling', [
				'label' => __( 'Vervuiling', 'duurzaamthuis' ),
				'type' => \Elementor\Controls_Manager::TEXT,
			] );
			$post->add_control( 'advies', [
				'label' => __( 'Advies', 'duurzaamthuis' ),
				'type' => \Elementor\Controls_Manager::TEXT,
			] );
			$post->add_control( 'calculations_text', [
				'label' => __( 'Calculations', 'duurzaamthuis' ),
				'type' => \Elementor\Controls_Manager::WYSIWYG,
			] );
			$post->add_control( 'impact_button', [
				'type' => \Elementor\Controls_Manager::RAW_HTML,
				'raw' => '<button class="elementor-update-preview-button elementor-button elementor-button-success" onclick="elementor.saver.update.apply().then(function(){elementor.reloadPreview();});">Update And Reload Preview</button>',
			] );
		$post->end_controls_section(); 
	}
	public function save_settings( $instance, $data ) {
		$post_id = $instance->get_post()->ID;

		if ( empty( $data) ) return;

		$settings = $data['settings'];

		update_post_meta( $post_id, 'milieuwinst', $settings['milieuwinst'] ?? '' );
		update_post_meta( $post_id, 'prijs', $settings['prijs'] ?? '' );
		update_post_meta( $post_id, 'terugverdientijd', $settings['terugverdientijd'] ?? '' );
		update_post_meta( $post_id, 'gemak', $settings['gemak'] ?? '' );
		update_post_meta( $post_id, 'subsidie', $settings['subsidie'] ?? '' );
		update_post_meta( $post_id, 'vervuiling', $settings['vervuiling'] ?? '' );
		update_post_meta( $post_id, 'advies', $settings['advies'] ?? '' );
		update_post_meta( $post_id, 'calculations-text', $settings['calculations_text'] ?? '' );
	}
}
new DH_Impact_Fields();


/**
 * 
 * class for adding Impact meta section to Elementor page/post settings
 * 
 */
class DH_Intro_Field {
	public function __construct() {
		add_action( 'elementor/element/wp-post/document_settings/after_section_end', [ $this, 'add_post_settings_controls' ] );
		add_action( 'elementor/element/wp-page/document_settings/after_section_end', [ $this, 'add_page_settings_controls' ] );
		add_action( 'elementor/document/after_save', [ $this, 'save_settings' ], 10, 2 );
	}
	public function add_post_settings_controls( \Elementor\Core\DocumentTypes\Post $post ) {
		$this->add_controls( $post );
	}
	public function add_page_settings_controls( \Elementor\Core\DocumentTypes\Page $page ) {
		$this->add_controls( $page );
	}
	public function add_controls( $post ) {
		$post->start_controls_section( 'section_intro', [
			'label' => __( 'Introduction', 'duurzaamthuis' ),
			'tab' => \Elementor\Controls_Manager::TAB_SETTINGS, // https://developers.elementor.com/elementor-element-panel-tabs/
		] );
			$post->add_control(
				'intro_text',
				[
					'label' => __( 'Introduction Text', 'duurzaamthuis' ),
					'type' => \Elementor\Controls_Manager::WYSIWYG,
				]
			);
			$post->add_control(
				'intro_button',
				[
					'type' => \Elementor\Controls_Manager::RAW_HTML,
					'raw' => '<button class="elementor-update-preview-button elementor-button elementor-button-success" onclick="elementor.saver.update.apply().then(function(){elementor.reloadPreview();});">Update And Reload Preview</button>',
				]
			);
		$post->end_controls_section(); 
	}
	public function save_settings( $instance, $data ) {
		$post_id = $instance->get_post()->ID;

		if ( empty( $data) ) return;

		$settings = $data['settings'];

		update_post_meta( $post_id, 'intro-text', $settings['intro_text'] ?? '' );

	}
}
new DH_Intro_Field();




add_filter( 'elementor/query/get_autocomplete/display/dh_custom', function( $results, $data ) {
	$post = get_post($data);
	$results = '(' . $post->post_type . ') ' . $post->post_title;
	return $results;
}, 10, 2);
add_filter( 'elementor/query/get_value_titles/display/dh_custom', function( $results, $data ) {
	$post = get_post($data);
	$results = '(' . $post->post_type . ') ' . $post->post_title;
	return $results;
}, 10, 2);