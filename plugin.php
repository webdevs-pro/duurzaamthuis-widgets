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
		add_action( 'elementor/widgets/widgets_registered', [ $this, 'on_widgets_registered' ] );
		
		add_action( 'elementor/frontend/after_register_scripts', function() {
			// to do replace time() with plugin version
			wp_register_script( 'duurzaamthuis-widgets', plugins_url( '/assets/duurzaamthuis-widgets.js', __FILE__ ), array( 'jquery' ), time(), true );
		} );
		
		add_action( 'elementor/frontend/after_enqueue_styles', function() {
			// to do replace time() with plugin version
			wp_enqueue_style( 'duurzaamthuis-widgets', plugins_url( '/assets/duurzaamthuis-widgets.css', __FILE__ ), array(), time() ); 
			wp_enqueue_style( 'dh-icons', plugins_url( '/assets/dh-icons-font/style.css', __FILE__ ), array(), time() ); 
		} );
	}

	public function on_widgets_registered() {
		require __DIR__ . '/widgets/image-heading-text.php';
		require __DIR__ . '/widgets/anchor-navigation.php';
		require __DIR__ . '/widgets/table.php';
		require __DIR__ . '/widgets/page-header.php';
		require __DIR__ . '/widgets/product-comparison.php';
		require __DIR__ . '/widgets/number-heading.php';
		require __DIR__ . '/widgets/impact.php';
		require __DIR__ . '/widgets/numbered-list.php';
		require __DIR__ . '/widgets/related-content.php';
		require __DIR__ . '/widgets/mega-menu.php';
		require __DIR__ . '/widgets/product-comparition-sustainability-score.php';
		require __DIR__ . '/widgets/template.php';
		require __DIR__ . '/widgets/template2.php';

		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new DH_Image_Heading_Text() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new DH_Anchor_Navigation() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new DH_Table() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new DH_Page_Header() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new DH_Product_Comparison() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new DH_Number_Heading() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new DH_Impact() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new DH_Numbered_List() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new DH_Related_Posts() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new DH_Mega_Menu() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new DH_Product_Comparition_Sustainability_Score() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new DH_Template() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new DH_Template2() );
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
	// add_filter( 'elementor/editor/localize_settings', 'disable_panel_widgets' );
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
		ob_start(); ?>
      <# 
         (function($) { 
            setTimeout(function() {
               var text_input = $('.dh-max-chars-restriction').find('input').attr('maxlength', 22);
            }, 100);		
			})(jQuery);
      #>
		<?php $script = ob_get_clean();
		$post->start_controls_section( 'section_impact', [
			'label' => __( 'Impact', 'duurzaamthuis' ),
			'tab' => Elementor\Controls_Manager::TAB_SETTINGS, // https://developers.elementor.com/elementor-element-panel-tabs/
		] );
			$post->add_control( 'milieuwinst', [
				'label' => __( 'Milieuwinst', 'duurzaamthuis' ),
				'type' => Elementor\Controls_Manager::TEXT,
				'classes' => "dh-max-chars-restriction",
			] );
			$post->add_control( 'prijs', [
				'label' => __( 'Prijs', 'duurzaamthuis' ),
				'type' => Elementor\Controls_Manager::TEXT,
				'classes' => "dh-max-chars-restriction",
			] );
			$post->add_control( 'terugverdientijd', [
				'label' => __( 'Terugverdientijd', 'duurzaamthuis' ),
				'type' => Elementor\Controls_Manager::TEXT,
				'classes' => "dh-max-chars-restriction",
			] );
			$post->add_control( 'gemak', [
				'label' => __( 'Gemak', 'duurzaamthuis' ),
				'type' => Elementor\Controls_Manager::TEXT,
				'classes' => "dh-max-chars-restriction",
			] );
			$post->add_control( 'vervuiling', [
				'label' => __( 'Vervuiling', 'duurzaamthuis' ),
				'type' => Elementor\Controls_Manager::TEXT,
				'classes' => "dh-max-chars-restriction",
			] );
			$post->add_control( 'subsidie', [
				'label' => __( 'Subsidie', 'duurzaamthuis' ),
				'type' => Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Ja', 'your-plugin' ),
				'label_off' => __( 'Nee', 'your-plugin' ),
				'return_value' => 'yes',
			] );
			$post->add_control( 'calculations_text', [
				'label' => __( 'Toelichting', 'duurzaamthuis' ),
				'type' => Elementor\Controls_Manager::WYSIWYG,
			] );
			$post->add_control( 'impact_button', [
				'type' => Elementor\Controls_Manager::RAW_HTML,
				'raw' => $script . '<button class="elementor-update-preview-button elementor-button elementor-button-success" onclick="elementor.saver.update.apply().then(function(){elementor.reloadPreview();});">Update And Reload Preview</button>',
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
			'tab' => Elementor\Controls_Manager::TAB_SETTINGS, // https://developers.elementor.com/elementor-element-panel-tabs/
		] );
			$post->add_control(
				'intro_text',
				[
					'label' => __( 'Introduction Text', 'duurzaamthuis' ),
					'type' => Elementor\Controls_Manager::WYSIWYG,
				]
			);
			$post->add_control(
				'intro_button',
				[
					'type' => Elementor\Controls_Manager::RAW_HTML,
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



// scrolltop offset
add_action( 'wp_footer', function() {
	if ( ! defined( 'ELEMENTOR_VERSION' ) ) {
		return;
	}
	?>
	<script>
		jQuery( function( $ ) {
			// Add space for Elementor Menu Anchor link
			$( window ).on( 'elementor/frontend/init', function() {
				elementorFrontend.hooks.addFilter( 'frontend/handlers/menu_anchor/scroll_top_distance', function( scrollTop ) {
					return scrollTop - 100;
				} );
			} );
		} );
	</script>
	<?php
} );


// support exerpt for pages
add_post_type_support( 'page', 'excerpt' );



// custom field for menu item to set icon class
add_action( 'wp_nav_menu_item_custom_fields', 'duurza_menu_item_icon_classes', 10, 2 );
add_action( 'wp_update_nav_menu_item', 'duurza_save_menu_item_icon_classes', 10, 2 );
function duurza_menu_item_icon_classes( $item_id, $item ) {
	$menu_item_icon_classes = get_post_meta( $item_id, '_menu_item_icon_classes', true );
	?>
	<p class="description description-thin">
		<label for="menu_item_icon_classes[<?php echo $item_id ;?>]">
			Icon CSS classes<br>
			<input type="text" class="widefat code" name="menu_item_icon_classes[<?php echo $item_id ;?>]" id="menu-item-icon-classes-<?php echo $item_id ;?>" value="<?php echo esc_attr( $menu_item_icon_classes ); ?>" />
		</label>
	</p>
	<?php
}
function duurza_save_menu_item_icon_classes( $menu_id, $menu_item_db_id ) {
	if ( isset( $_POST['menu_item_icon_classes'][$menu_item_db_id]  ) ) {
		$sanitized_data = sanitize_text_field( $_POST['menu_item_icon_classes'][$menu_item_db_id] );
		update_post_meta( $menu_item_db_id, '_menu_item_icon_classes', $sanitized_data );
	} else {
		delete_post_meta( $menu_item_db_id, '_menu_item_icon_classes' );
	}
}


// filter excerpt
add_filter( 'get_the_excerpt', 'dh_excerpt_filter', 10, 2 );
function dh_excerpt_filter( $exerpt, $post ) {

	$yoast_description = get_post_meta( $post->ID, '_yoast_wpseo_metadesc', true ); 
	
	if ( ! $yoast_description ) {
		$introduction = get_post_meta( $post->ID, 'intro-text', true );
		if ( ! $introduction ) {
			$post_exerpt = $post->post_excerpt;
			if ( ! $post_exerpt ) {
				$body_text = $post->post_content;
			}
		}
	}

	$exerpt = strip_tags( $yoast_description ?: ( $introduction ?: ( $exerpt ?: $body_text ) ) );

	return $exerpt;
}


// add_action( 'elementor/widgets/widgets_registered', function() {
// 	$before = microtime(true);
// 	$cn = 'DH_Anchor_Navigation';
// 	$method = 'register_controls';

// 	$func = new ReflectionMethod($cn, $method);

// 	$f = $func->getFileName();
// 	$start_line = $func->getStartLine() - 1;
// 	$end_line = $func->getEndLine();
// 	$length = $end_line - $start_line;

// 	$source = file($f);
// 	$source = implode('', array_slice($source, 0, count($source)));
// 	// $source = preg_split("/(\n|\r\n|\r)/", $source);
// 	$source = preg_split("/".PHP_EOL."/", $source);

// 	$body = '';
// 	for($i=$start_line; $i<$end_line; $i++)
// 		$body.="{$source[$i]}\n";

// 	ob_start();
// 	echo $body;
// 	$var = ob_get_clean();

// 	$after = microtime(true);
// 	$time = $after - $before;
// 	error_log( "time\n" . print_r( $time, true ) . "\n" );
// 	error_log( "var\n" . print_r( $var, true ) . "\n" );

// }, 100 );



class DH_Widgets_Content_Controls {

	public static function get_prefix_classes( $widget, $settings ) {
		$controls = $widget->get_controls();
		$class_settings = [];
		foreach ( $settings as $setting_key => $setting ) {
			if ( isset( $controls[ $setting_key ]['add_widget_class'] ) && $setting ) {
				$class_settings[] = $controls[ $setting_key ]['add_widget_class'] . $setting;
			}
		}
		return ' ' . implode( ' ', $class_settings );
	}


	public static function get_dh_anchor_navigation_controls( $widget ) {
		$widget->start_controls_section( 'dh_anchor_navigation_section_content', [
         'label' => __( 'Anchor Navigation', 'duurzaamthuis' ),
         'tab' => Elementor\Controls_Manager::TAB_CONTENT,
      ] );
			$widget->add_control( 'dh_anchor_navigation_heading', [
            'label' => __( 'Heading', 'duurzaamthuis' ),
            'type' => Elementor\Controls_Manager::TEXT,
            'default' => __( 'Heading text', 'duurzaamthuis' ),
            'label_block' => true,
            'separator' => 'before'
         ] );
         $repeater = new \Elementor\Repeater();
         $repeater->add_control( 'dh_anchor_navigation_title', [
            'label' => __( 'Title', 'duurzaamthuis' ),
            'type' => Elementor\Controls_Manager::TEXT,
            'label_block' => true,
         ] );
         $repeater->add_control( 'dh_anchor_navigation_anchor', [
            'label' => __( 'Anchor', 'duurzaamthuis' ),
            'type' => Elementor\Controls_Manager::TEXT,
            'label_block' => true,
         ] );
         $repeater->add_control( 'dh_anchor_navigation_description', [
            'raw' => __( 'Only Id without \'#\' sign', 'elementor-pro' ),
            'type' => Elementor\Controls_Manager::RAW_HTML,
            'content_classes' => 'elementor-descriptor',
         ] );
         $widget->add_control( 'dh_anchor_navigation_items', [
            'label' => __( 'Items', 'duurzaamthuis' ),
            'type' => Elementor\Controls_Manager::REPEATER,
            'fields' => $repeater->get_controls(),
            'title_field' => '{{{ dh_anchor_navigation_title }}}',
         ] );
		$widget->end_controls_section(); 
	}

	public static function get_dh_image_heading_text_controls( $widget ) {
		$widget->start_controls_section( 'dh_image_heading_text_content', [
			'label' => __( 'Image with heading and text', 'duurzaamthuis' ),
			'tab' => Elementor\Controls_Manager::TAB_CONTENT,
		] );

			$widget->add_control( 'dh_image_heading_image', [
				'label' => __( 'Choose Image', 'duurzaamthuis' ),
				'type' => Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => Elementor\Utils::get_placeholder_image_src(),
				],
			] );
			$widget->add_control( 'dh_image_heading_image_align', [
				'label' => __( 'Image Column Alignment', 'duurzaamthuis' ),
				'type' => Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'duurzaamthuis' ),
						'icon' => 'eicon-h-align-left',
					],
					'right' => [
						'title' => __( 'Right', 'duurzaamthuis' ),
						'icon' => 'eicon-h-align-right',
					],
				],
				'default' => 'left',
				'toggle' => false,
				'add_widget_class' => 'dh-image-align-',
			] );
			$widget->add_control( 'dh_image_heading_image_width', [
				'label' => __( 'Image Column Width', 'duurzaamthuis' ),
				'type' => Elementor\Controls_Manager::SELECT,
				'default' => '50',
				'options' => [
					'33'  => __( '33%', 'duurzaamthuis' ),
					'50' => __( '50%', 'duurzaamthuis' ),
					'66' => __( '66%', 'duurzaamthuis' ),
				],
				'add_widget_class' => 'dh-image-width-',
			] );
			$widget->add_control( 'dh_image_heading_image_reverse', [
				'label' => __( 'Mobile Columns Reverse', 'duurzaamthuis' ),
				'type' => Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'your-plugin' ),
				'label_off' => __( 'No', 'your-plugin' ),					
				'return_value' => 'columns',
				'add_widget_class' => 'dh-reverse-',
			] );
			$widget->add_control( 'dh_image_heading_heading', [
				'label' => __( 'Heading', 'duurzaamthuis' ),
				'type' => Elementor\Controls_Manager::TEXT,
				'default' => __( 'Heading text', 'duurzaamthuis' ),
				'label_block' => true,
				'separator' => 'before'
			] );
			$widget->add_control( 'dh_image_heading_content', [
				'label' => __( 'Content', 'duurzaamthuis' ),
				'type' => Elementor\Controls_Manager::WYSIWYG,
				'default' => __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', 'duurzaamthuis' ),
			] );
		$widget->end_controls_section(); 
	}

	public static function get_dh_product_comparition_controls( $widget ) {
		$widget->start_controls_section( 'dh_product_comparition_content', [
         'label' => __( 'Product Comparison', 'duurzaamthuis' ),
         'tab' => Elementor\Controls_Manager::TAB_CONTENT,
      ] );
         $widget->add_control( 'dh_product_comparition_skin', [
            'label' => __( 'Skin', 'duurzaamthuis' ),
            'type' => Elementor\Controls_Manager::SELECT,
            'default' => 'simple',
            'options' => [
               'simple'  => __( 'Simple', 'duurzaamthuis' ),
               'extended' => __( 'Extended', 'duurzaamthuis' ),
            ],
            'classes' => "dh-skin-control",
         ] );
         $widget->add_control( 'dh_product_comparition_controls_conditions', [
            'type' => Elementor\Controls_Manager::RAW_HTML,
            'raw' => call_user_func( array( ( new DH_Product_Comparison() ), 'get_controls_conditions_script' ) ),
         ] );
         $widget->add_responsive_control( 'dh_product_comparition_columns_count', [
				'label' => __( 'Columns', 'duurzaamthuis' ),
				'type' => Elementor\Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 6,
				'step' => 1,
				'default' => 3,
				'tablet_default' => 2,
				'mobile_default' => 1,
				'selectors' => [
					'{{WRAPPER}} .dh-products-grid' => 'grid-template-columns: repeat({{VALUE}}, 1fr);',
				],         
			] );
         $repeater = new \Elementor\Repeater();
            $repeater->add_control( 'dh_product_comparition_title', [
               'label' => __( 'Title', 'duurzaamthuis' ),
               'type' => Elementor\Controls_Manager::TEXT,
               'default' => __( 'Product title' , 'duurzaamthuis' ),
               'label_block' => true,
            ] );
            $repeater->add_control( 'dh_product_comparition_badge', [
               'label' => __( 'Badge', 'duurzaamthuis' ),
               'type' => Elementor\Controls_Manager::SELECT,
               'default' => 'none',
               'options' => [
                  'none'  => __( 'None', 'duurzaamthuis' ),
                  'best_price' => __( 'Beste prijs', 'duurzaamthuis' ),
                  'best_quality' => __( 'Beste Kwaliteit', 'duurzaamthuis' ),
                  'eco_choice' => __( 'Beste eco keuze', 'duurzaamthuis' ),
               ],
               'classes' => "extended-skin-control",
            ] );
            $repeater->add_control( 'dh_product_comparition_image', [
               'label' => __( 'Image', 'duurzaamthuis' ),
               'type' => Elementor\Controls_Manager::MEDIA,
               'default' => [
                  'url' => Elementor\Utils::get_placeholder_image_src(),
               ],
            ] );
            $repeater->add_control( 'dh_product_comparition_star_rating', [
               'label' => __( 'Rating', 'elementor' ),
               'type' => Elementor\Controls_Manager::NUMBER,
               'min' => 0,
               'max' => 5,
               'step' => 0.1,
               'default' => 5,
            ] );
            $repeater->add_control( 'dh_product_comparition_product_text_rating', [
               'label' => __( 'Text Rating', 'duurzaamthuis' ),
               'type' => Elementor\Controls_Manager::TEXT,
               'classes' => "extended-skin-control",
               'label_block' => true,
               'default' => '9.5/10 van 26 reviews op cooiblue en Bol.com',
            ] );
            $repeater->add_control( 'dh_product_comparition_price', [
               'label' => __( 'Price', 'duurzaamthuis' ),
               'type' => Elementor\Controls_Manager::TEXT,
               'default' => '10',
            ] );
            $repeater->add_control( 'dh_product_comparition_order_by', [
               'label' => __( 'Order By', 'duurzaamthuis' ),
               'type' => Elementor\Controls_Manager::TEXT,
               'default' => 'Voor 23:59 besteld',
               'classes' => "simple-skin-control",
            ] );
            $repeater->add_control( 'dh_product_comparition_button_text', [
               'label' => __( 'Button Text', 'duurzaamthuis' ),
               'type' => Elementor\Controls_Manager::TEXT,
               'separator' => 'before',
               'default' => 'Button text',
               'label_block' => true,
            ] );
            $repeater->add_control( 'dh_product_comparition_button_link', [
               'label' => __( 'Button Link', 'duurzaamthuis' ),
               'type' => Elementor\Controls_Manager::TEXT,
               'default' => '#',
               'label_block' => true,
            ] );
            $repeater->add_control( 'dh_product_comparition_sponsored',[
               'label' => __( 'Sponsored', 'duurzaamthuis' ),
               'type' => Elementor\Controls_Manager::SWITCHER,
               'label_on' => __( 'Yes', 'your-plugin' ),
               'label_off' => __( 'No', 'your-plugin' ),
               'return_value' => 'yes',
               'default' => 'yes',
               'render_type' => 'ui',
            ] );
            $repeater->add_control( 'dh_product_comparition_pros', [
               'label' => 'Pros',
               'label_block' => false,
               'button_title' => __( 'Edit Pros', 'duurzaamthuis' ),
               'type' => 'dh-table-control',
               'separator' => 'before',
               'allow_columns' => false,
               'table_classes' => 'repeater',
               'add_row_title' => __( 'Add Item', 'duurzaamthuis' ),
               'max' => 5,
               'default' => '[["Advantage 1"],["Advantage 2"]]',
               'classes' => "extended-skin-control",
               ] );
            $repeater->add_control( 'dh_product_comparition_cons', [
               'label' => 'Cons',
               'type' => 'dh-table-control',
               'label_block' => false,
               'button_title' => __( 'Edit Cons', 'duurzaamthuis' ),
               'allow_columns' => false,
               'table_classes' => 'repeater',
               'add_row_title' => __( 'Add Item', 'duurzaamthuis' ),
               'max' => 3,
               'default' => '[["Disadvantage 1"],["Disadvantage 2"]]',
               'classes' => "extended-skin-control",
            ] );
            $repeater->add_control( 'dh_product_comparition_description', [
               'label' => __( 'Description', 'duurzaamthuis' ),
               'type' => Elementor\Controls_Manager::TEXTAREA,
               'rows' => 10,
               'default' => __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. ', 'duurzaamthuis' ),
               'placeholder' => __( 'Type your description here', 'duurzaamthuis' ),
               'classes' => "extended-skin-control",
            ] );
         $widget->add_control( 'dh_product_comparition_products', [
            'label' => __( 'Products', 'duurzaamthuis' ),
            'type' => Elementor\Controls_Manager::REPEATER,
            'fields' => $repeater->get_controls(),
            'default' => [
               [
                  'title' => __( 'Product title', 'duurzaamthuis' ),
               ],
            ],
            'title_field' => '{{{ dh_product_comparition_title }}}',
         ] );
		$widget->end_controls_section(); 
	}

	public static function get_dh_impact_controls( $widget ) {
		ob_start(); ?>
		<# 
			(function($) { 
				var timer = setTimeout(function() {
					var text_input = $('.dh-max-chars-restriction').find('input').attr('maxlength', 22);
				}, 100);		
			})(jQuery);
		#>
		<?php $script = ob_get_clean();
		$widget->start_controls_section( 'dh_impact_content', [
			'label' => __( 'Impact', 'duurzaamthuis' ),
			'tab' => Elementor\Controls_Manager::TAB_CONTENT,
		] );
			$widget->add_control( 'dh_impact_milieuwinst', [
				'label' => __( 'Milieuwinst', 'duurzaamthuis' ),
				'type' => Elementor\Controls_Manager::TEXT,
				'classes' => "dh-max-chars-restriction",
			] );
			$widget->add_control( 'dh_impact_prijs', [
				'label' => __( 'Prijs', 'duurzaamthuis' ),
				'type' => Elementor\Controls_Manager::TEXT,
				'classes' => "dh-max-chars-restriction",
			] );
			$widget->add_control( 'dh_impact_terugverdientijd', [
				'label' => __( 'Terugverdientijd', 'duurzaamthuis' ),
				'type' => Elementor\Controls_Manager::TEXT,
				'classes' => "dh-max-chars-restriction",
			] );
			$widget->add_control( 'dh_impact_gemak', [
				'label' => __( 'Gemak', 'duurzaamthuis' ),
				'type' => Elementor\Controls_Manager::TEXT,
				'classes' => "dh-max-chars-restriction",
			] );
			$widget->add_control( 'dh_impact_vervuiling', [
				'label' => __( 'Vervuiling', 'duurzaamthuis' ),
				'type' => Elementor\Controls_Manager::TEXT,
				'classes' => "dh-max-chars-restriction",
			] );
			$widget->add_control( 'dh_impact_subsidie', [
				'label' => __( 'Subsidie', 'duurzaamthuis' ),
				'type' => Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Ja', 'your-plugin' ),
				'label_off' => __( 'Nee', 'your-plugin' ),
				'return_value' => 'yes',
			] );
			$widget->add_control( 'dh_impact_calculations_text', [
				'label' => __( 'Toelichting', 'duurzaamthuis' ),
				'type' => Elementor\Controls_Manager::WYSIWYG,
			] );
			$widget->add_control( 'dh_impact_script', [
				'type' => Elementor\Controls_Manager::RAW_HTML,
				'raw' => $script,
			] );
		$widget->end_controls_section(); 
	}
}