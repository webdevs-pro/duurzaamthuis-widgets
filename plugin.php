<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


// register icon font
add_action( 'elementor/editor/after_enqueue_styles', 'icons_font_styles' );
add_action( 'elementor/preview/enqueue_styles', 'icons_font_styles' );
function icons_font_styles() {
	wp_enqueue_style( 'dh-icons', plugin_dir_url( __FILE__ ) . '/assets/dh-icons-font/style.css', array(), DH_VERSION );
}




// // Widget builder ACF option page
// if( function_exists('acf_add_options_page') ) {
// 	acf_add_options_page(array(
// 		'page_title' 	=> 'Widget Builder',
// 		'menu_title'	=> 'Widget Builder',
// 		'menu_slug' 	=> 'duurzaamthuis-templates',
// 		'capability'	=> 'edit_posts',
// 		'icon_url' => 'dashicons-excerpt-view',
// 		'redirect'		=> false
// 	));
// }





add_action( 'admin_menu', function() {
	add_menu_page( 
		'DH Tools',
		'DH Tools',
		'manage_options', 
		'dh-tools', 
		false,
		'', 
		99
	);

	add_submenu_page(
		'dh-tools',
		'DH templates', 
		'DH templates', 
		'manage_options', 
		'edit-tags.php?taxonomy=dh_templates', 
		false,
		1
	);
	remove_submenu_page( 'edit.php', 'edit-tags.php?taxonomy=dh_templates' );
	remove_submenu_page( 'edit.php?post_type=page', 'edit-tags.php?taxonomy=dh_templates&amp;post_type=page' );

	// Widget builder ACF option page
	if( function_exists('acf_add_options_sub_page') ) {
		acf_add_options_sub_page(array(
			'page_title' 	=> 'Widget Builder',
			'menu_title'	=> 'Widget Builder',
			'parent_slug' 	=> 'dh-tools',
		));
	}

	remove_submenu_page('dh-tools','dh-tools');
}, 10 );
add_action( 'parent_file', function( $parent_file ) {
	global $current_screen;
	$taxonomy = $current_screen->taxonomy;
	if ( $taxonomy == 'dh_templates' )
		$parent_file = 'dh-tools';
	return $parent_file;
}, 10 );



// register widgets
class DH_Register_Widgets {
	public function __construct() {
		add_action( 'elementor/widgets/widgets_registered', [ $this, 'on_widgets_registered' ] );
		
		add_action( 'elementor/frontend/after_register_scripts', function() {
			// to do replace time() with plugin version
			wp_register_script( 'duurzaamthuis-widgets', plugins_url( '/assets/duurzaamthuis-widgets.js', __FILE__ ), array( 'jquery' ), DH_VERSION, true );
			wp_enqueue_script( 'sticky-sidebar', 'https://cdnjs.cloudflare.com/ajax/libs/sticky-sidebar/3.3.1/sticky-sidebar.min.js', array(), DH_VERSION, true );
		} );
		
		add_action( 'elementor/frontend/after_enqueue_styles', function() {
			// to do replace time() with plugin version
			wp_enqueue_style( 'duurzaamthuis-widgets', plugins_url( '/assets/duurzaamthuis-widgets.css', __FILE__ ), array(), DH_VERSION ); 
			wp_enqueue_style( 'dh-icons', plugins_url( '/assets/dh-icons-font/style.css', __FILE__ ), array(), DH_VERSION ); 
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
		// require __DIR__ . '/widgets/template.php';
		// require __DIR__ . '/widgets/template2.php';
		require __DIR__ . '/widgets/multiwidgets.php';
		require __DIR__ . '/widgets/author-box.php';
		require __DIR__ . '/widgets/product-review.php';
		require __DIR__ . '/widgets/how-to-faq.php';
		require __DIR__ . '/widgets/company-offer.php';
		require __DIR__ . '/widgets/page-navigation.php';
		require __DIR__ . '/widgets/menu-tree-navigation.php';

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
		// \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new DH_Template() );
		// \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new DH_Template2() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new DH_Author_Box() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new DH_Product_Review() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new DH_How_To_Faq() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new DH_Company_Offer() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new DH_Page_Navigation() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new DH_Menu_Tree_Navigation() );
		new DH_Multiwidgets();
	}
}
new DH_Register_Widgets();


// register custom DH elementor form fields 
add_action( 'elementor_pro/forms/fields/register', function( $module ) {
	require ( DH_PLUGIN_DIR . '/inc/modules/form-company-offer-fields.php' );
	$module->register( new DH_Companies_Offer_Emails_Field() );
	$module->register( new DH_Companies_Offer_Titles_Field() );
}, 10 );

add_action( 'elementor_pro/forms/validation', function ( $record, $ajax_handler ) {
	$form_fields = $record->get_form_settings( 'form_fields' );

	foreach ( $form_fields as $index => $form_field ) {
		if ( $form_field['field_type'] == 'dh-companies-offer-emails' ) {
			$min_emails = $form_fields[$index]['dh_min_companies_offer_emails'];
		} 
	}
	if ( ! isset( $min_emails ) ) return;

	// error_log( "min_emails\n" . print_r( $min_emails, true ) . "\n" );

	$emails_fields = $record->get_field( [
		'type' => 'dh-companies-offer-emails',
	] );
	$emails_field = $emails_fields[array_key_first( $emails_fields )];

	$emails = array_filter( explode( ',', $emails_field['value'] ) );

	if ( ! is_array( $emails ) || empty( $emails ) || $min_emails > count( $emails ) ) {
		$ajax_handler->add_error_message( 'Selecteer minimaal 1 bedrijf' );
	}
}, 10, 2 );



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
			// $post->add_control( 'vervuiling', [
			// 	'label' => __( 'Vervuiling', 'duurzaamthuis' ),
			// 	'type' => Elementor\Controls_Manager::TEXT,
			// 	'classes' => "dh-max-chars-restriction",
			// ] );
			$post->add_control( 'subsidie', [
				'label' => __( 'Subsidie', 'duurzaamthuis' ),
				'type' => Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Ja', 'duurzaamthuis' ),
				'label_off' => __( 'Nee', 'duurzaamthuis' ),
				'return_value' => 'yes',
			] );
			$post->add_control( 'subsidie_type2', [ // subsidie type
				'label' => __( 'Subsidie Type', 'duurzaamthuis' ),
				'type' => Elementor\Controls_Manager::SELECT,
				'default' => 'yes',
				'options' => [
					'yes2'  => __( 'Ja', 'duurzaamthuis' ), // strange bug so value is 'yes2'
					'no' => __( 'Nee', 'duurzaamthuis' ),
				],
				'classes' => "dh-max-chars-restriction",
				'condition' => [
					'subsidie' => 'yes'
				]
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
		update_post_meta( $post_id, 'subsidie_type', $settings['subsidie_type2'] ?? '' );
		// update_post_meta( $post_id, 'vervuiling', $settings['vervuiling'] ?? '' );
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
	$results = $post->post_title . ' (' . $post->post_type . ') - ' . str_replace( home_url(), '', get_the_permalink( $post->ID ) );
	return $results;
}, 10, 2);
add_filter( 'elementor/query/get_value_titles/display/dh_custom', function( $results, $data ) {
	$post = get_post($data);
	$results = $post->post_title . ' (' . $post->post_type . ') - ' . str_replace( home_url(), '', get_the_permalink( $post->ID ) );
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
add_filter( 'get_the_excerpt', 'dh_excerpt_filter', 1, 2 );
function dh_excerpt_filter( $excerpt, $post ) {

	$yoast_description = get_post_meta( $post->ID, '_yoast_wpseo_metadesc', true ); 
	
	if ( ! $yoast_description ) {
		$introduction = get_post_meta( $post->ID, 'intro-text', true );
		if ( ! $introduction ) {
			$post_excerpt = $post->post_excerpt;
			if ( ! $post_excerpt ) {
				$body_text = $post->post_content;
			}
		}
	}

	$excerpt = wp_trim_words( strip_tags( $yoast_description ?: ( $introduction ?: ( $excerpt ?: $body_text ) ) ), 25, '...' );

	return $excerpt;
}





class DH_Widgets_Content_Controls {

	public static function get_prefix_classes( $widget, $settings ) {
		$controls = $widget->get_controls();
		$class_settings = [];
		foreach ( $settings as $setting_key => $setting ) {
			if ( isset( $controls[ $setting_key ]['prefix_class'] ) && $setting ) {
				$class_settings[] = $controls[ $setting_key ]['prefix_class'] . $setting;
			}
		}
		return ' ' . implode( ' ', $class_settings );
	}

#region get_dh_anchor_navigation_controls
	public static function get_dh_anchor_navigation_controls( $widget ) {
		$widget->start_controls_section( 'dh_anchor_navigation_section_content', [
         'label' => __( 'Anchor Navigation', 'duurzaamthuis' ),
         'tab' => Elementor\Controls_Manager::TAB_CONTENT,
      ] );
			$widget->add_control( 'dh_anchor_navigation_heading', [ // heading
            'label' => __( 'Heading', 'duurzaamthuis' ),
            'type' => Elementor\Controls_Manager::TEXT,
            'default' => __( 'Op deze pagina', 'duurzaamthuis' ),
            'label_block' => true,
         ] );
			$widget->add_control( 'dh_anchor_navigation_show_index', [ // heading
            'label' => __( 'Show index', 'duurzaamthuis' ),
            'type' => Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'duurzaamthuis' ),
				'label_off' => __( 'No', 'duurzaamthuis' ),		
				'return_value' => 'yes',
				'default' => 'yes',	
         ] );
         $repeater = new \Elementor\Repeater();
         $repeater->add_control( 'dh_anchor_navigation_title', [ // title
            'label' => __( 'Title', 'duurzaamthuis' ),
            'type' => Elementor\Controls_Manager::TEXT,
            'label_block' => true,
         ] );
         $repeater->add_control( 'dh_anchor_navigation_anchor', [ // anchor
            'label' => __( 'Anchor', 'duurzaamthuis' ),
            'type' => Elementor\Controls_Manager::TEXT,
            'label_block' => true,
         ] );
         $repeater->add_control( 'dh_anchor_navigation_description', [ // description
            'raw' => __( 'Only Id without \'#\' sign', 'elementor-pro' ),
            'type' => Elementor\Controls_Manager::RAW_HTML,
            'content_classes' => 'elementor-descriptor',
         ] );
         $widget->add_control( 'dh_anchor_navigation_items', [ // items
            'label' => __( 'Items', 'duurzaamthuis' ),
            'type' => Elementor\Controls_Manager::REPEATER,
            'fields' => $repeater->get_controls(),
            'title_field' => '
					<span id="item-{{_id}}"></span>
					<#
					setTimeout( function() {
						var index = jQuery( "#item-" + _id ).closest( ".elementor-repeater-fields" ).index();
						jQuery( "#item-" + _id ).text( ( index + 1 ) + ". " + dh_anchor_navigation_title );
					}, 10 )
					#>
				',
         ] );
		$widget->end_controls_section(); 
	}
#endregion

#region get_dh_image_heading_text_controls
	public static function get_dh_image_heading_text_controls( $widget ) {
		$widget->start_controls_section( 'dh_image_heading_text_content_section', [
			'label' => __( 'Image with heading and text', 'duurzaamthuis' ),
			'tab' => Elementor\Controls_Manager::TAB_CONTENT,
		] );
			$widget->add_control( 'dh_image_heading_text_image_show_image', [
				'label' => __( 'Show Image', 'duurzaamthuis' ),
				'type' => Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'duurzaamthuis' ),
				'label_off' => __( 'No', 'duurzaamthuis' ),		
				'return_value' => 'yes',
				'default' => 'yes',		
			] );
			$widget->add_control( 'dh_image_heading_text_image', [
				'label' => __( 'Choose Image', 'duurzaamthuis' ),
				'type' => Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => Elementor\Utils::get_placeholder_image_src(),
				],
				'condition' => [
					'dh_image_heading_text_image_show_image' => 'yes',
				]
			] );
			$widget->add_control( 'dh_image_heading_text_image_align', [
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
				'render_type' => 'template', // mandatory if we use prefix_class
				'prefix_class' => 'dh-image-align-',
				'condition' => [
					'dh_image_heading_text_image_show_image' => 'yes',
				]
			] );
			$widget->add_control( 'dh_image_heading_text_image_width', [
				'label' => __( 'Image Column Width', 'duurzaamthuis' ),
				'type' => Elementor\Controls_Manager::SELECT,
				'default' => '50',
				'options' => [
					'33'  => __( '33%', 'duurzaamthuis' ),
					'50' => __( '50%', 'duurzaamthuis' ),
					'66' => __( '66%', 'duurzaamthuis' ),
					'100' => __( '100%', 'duurzaamthuis' ),
				],
				'render_type' => 'template', // mandatory if we use prefix_class
				'prefix_class' => 'dh-image-width-',
				'condition' => [
					'dh_image_heading_text_image_show_image' => 'yes',
				]
			] );
			$widget->add_control( 'dh_image_heading_text_image_reverse', [
				'label' => __( 'Mobile Columns Reverse', 'duurzaamthuis' ),
				'type' => Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'duurzaamthuis' ),
				'label_off' => __( 'No', 'duurzaamthuis' ),					
				'return_value' => 'columns',
				'render_type' => 'template', // mandatory if we use prefix_class
				'prefix_class' => 'dh-reverse-',
				'condition' => [
					'dh_image_heading_text_image_show_image' => 'yes',
				]
			] );
			$widget->add_control( 'dh_image_heading_text_image_show_heading', [
				'label' => __( 'Show Heading', 'duurzaamthuis' ),
				'type' => Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'duurzaamthuis' ),
				'label_off' => __( 'No', 'duurzaamthuis' ),		
				'return_value' => 'yes',
				'default' => 'yes',		
				'separator' => 'before',
			] );
			$widget->add_control( 'dh_image_heading_text_heading', [
				'label' => __( 'Heading', 'duurzaamthuis' ),
				'type' => Elementor\Controls_Manager::TEXT,
				'default' => __( 'Heading text', 'duurzaamthuis' ),
				'label_block' => true,
				'condition' => [
					'dh_image_heading_text_image_show_heading' => 'yes',
				]
			] );
			$widget->add_control( 'dh_image_heading_text_image_show_text', [
				'label' => __( 'Show Text', 'duurzaamthuis' ),
				'type' => Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'duurzaamthuis' ),
				'label_off' => __( 'No', 'duurzaamthuis' ),		
				'return_value' => 'yes',
				'default' => 'yes',		
				'separator' => 'before',
			] );
			$widget->add_control( 'dh_image_heading_text_content', [
				'label' => __( 'Content', 'duurzaamthuis' ),
				'type' => Elementor\Controls_Manager::WYSIWYG,
				'default' => __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', 'duurzaamthuis' ),
				'condition' => [
					'dh_image_heading_text_image_show_text' => 'yes',
				]
			] );
			$widget->add_control( 'dh_image_heading_text_image_show_button', [
				'label' => __( 'Show Button', 'duurzaamthuis' ),
				'type' => Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'duurzaamthuis' ),
				'label_off' => __( 'No', 'duurzaamthuis' ),		
				'return_value' => 'yes',
				'default' => '',		
				'separator' => 'before',
			] );
			$widget->add_control( 'dh_image_heading_text_button_text', [
				'label' => __( 'Text', 'duurzaamthuis' ),
				'type' => Elementor\Controls_Manager::TEXT,
				'default' => __( 'Button', 'duurzaamthuis' ),
				'label_block' => true,
				'condition' => [
					'dh_image_heading_text_image_show_button' => 'yes',
				]
			] );
			$widget->add_control( 'dh_image_heading_text_button_url', [
				'label' => __( 'Link', 'duurzaamthuis' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'plugin-domain' ),
				'show_external' => true,
				'default' => [
					'url' => '',
					'is_external' => true,
					'nofollow' => true,
				],
				'condition' => [
					'dh_image_heading_text_image_show_button' => 'yes',
				]
			] );

		$widget->end_controls_section(); 
	}
#endregion

#region get_dh_product_comparition_controls
	public static function get_dh_product_comparition_controls( $widget ) {
		ob_start(); ?>
		<# 
			( function( $ ) { 
				var timer = setTimeout(function() {
					$( '.dh-13-chars-max input' ).attr( 'maxlength', 13 ).attr( 'minlength', 13 );
					$( '.dh-numbers-only input' ).keypress(function (e) {
						if ( String.fromCharCode( e.keyCode ).match(/[^0-9]/g) ) return false;
					} );
				}, 100 );		
			} )( jQuery );
		#>
		<style>
			.dh-13-chars-max input:invalid {
				border: 2px dashed red;
			}
			.tab-like-switcher .elementor-choices-label {
				width: 33.333%;
			}
			.tab-like-switcher .elementor-screen-only {
				display: block;
				position: relative;
				height: unset;
				width: unset;
				top: unset;
			}
		</style>
		<?php $script = ob_get_clean();
		$widget->start_controls_section( 'dh_product_comparition_content', [
         'label' => __( 'Product Comparison', 'duurzaamthuis' ),
         'tab' => Elementor\Controls_Manager::TAB_CONTENT,
      ] );
         $widget->add_responsive_control( 'dh_product_comparition_columns_count', [ // columns_count
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
            $repeater->add_control( 'dh_product_comparition_title', [ // title
               'label' => __( 'Title', 'duurzaamthuis' ),
               'type' => Elementor\Controls_Manager::TEXT,
               'default' => __( 'Product title' , 'duurzaamthuis' ),
               'label_block' => true,
            ] );
				$repeater->add_control( 'dh_product_comparition_ean', [
					'label' => __( 'EAN Product ID (GTIN-13)', 'duurzaamthuis' ),
					'type' => Elementor\Controls_Manager::TEXT,
					'default' => __( '' , 'duurzaamthuis' ),
					'label_block' => true,
					'description' => 'For example: 9789000378937 (13 digits)',
					'classes' => "dh-13-chars-max dh-numbers-only",
				] );
				$repeater->add_control( 'dh_product_comparition_image', [ // image
					'label' => __( 'Image', 'duurzaamthuis' ),
					'type' => Elementor\Controls_Manager::MEDIA,
					'default' => [
						'url' => Elementor\Utils::get_placeholder_image_src(),
					],
				] );
				$repeater->add_control( 'dh_product_comparition_star_rating', [ // star_rating
					'label' => __( 'Rating', 'elementor' ),
					'type' => Elementor\Controls_Manager::NUMBER,
					'min' => 0,
					'max' => 5,
					'step' => 0.1,
					'default' => 5,
				] );
            $repeater->add_control( 'dh_product_comparition_order_by', [ // order_by
               'label' => __( 'Order By', 'duurzaamthuis' ),
               'type' => Elementor\Controls_Manager::TEXT,
               'default' => 'Voor 23:59 besteld',
            ] );
				$repeater->add_control( 'dh_product_comparition_custom_type', [
					'label' => esc_html__( 'Custom shortcode or button', 'duurzaamthuis' ),
					'type' => \Elementor\Controls_Manager::CHOOSE,
					'options' => [
						'ean' => [
							'title' => esc_html__( 'EAN', 'duurzaamthuis' ),
						],
						'shortcode' => [
							'title' => esc_html__( 'Shortcode', 'duurzaamthuis' ),
						],
						'button' => [
							'title' => esc_html__( 'Button', 'duurzaamthuis' ),
						],
					],
					'label_block' => true,
					'toggle' => false,
					'default' => 'ean',
					'classes' => 'tab-like-switcher',
					'separator' => 'before',
				] );
            $repeater->add_control( 'dh_product_comparition_shortcode', [
					'label' => esc_html__( 'Shortcode below overrides [dfrcs ean="XXX"]', 'duurzaamthuis' ),
					'type' => Elementor\Controls_Manager::TEXTAREA,
					'placeholder' => '[dfrcs name="Euphoria 110 Mono" filters="currency=EUR"]',
					'description' => 'HTML allowed. Find more shortcode parameters here <a target="_blank" href="https://wordpress.org/plugins/datafeedr-comparison-sets/">https://wordpress.org/plugins/datafeedr-comparison-sets/</a>',
					'default' => '',
					'condition' => [
						'dh_product_comparition_custom_type' => 'shortcode',
					],
				] );
            $repeater->add_control( 'dh_product_comparition_last_updated_text', [
               'label' => __( 'Last Updated Text', 'duurzaamthuis' ),
               'type' => Elementor\Controls_Manager::TEXT,
               'label_block' => true,
					'condition' => [
						'dh_product_comparition_custom_type' => 'shortcode',
					],
            ] );
				$repeater->add_control( 'dh_product_comparition_button_image', [
               'label' => __( 'Logo', 'duurzaamthuis' ),
               'type' => Elementor\Controls_Manager::MEDIA,
               'default' => [
                  'url' => Elementor\Utils::get_placeholder_image_src(),
               ],
            ] );
				$repeater->add_control( 'dh_product_comparition_price', [ // price
               'label' => __( 'Price', 'duurzaamthuis' ),
               'type' => Elementor\Controls_Manager::TEXT,
               'default' => '10',
					'condition' => [
						'dh_product_comparition_custom_type' => 'button',
					],
            ] );
				$repeater->add_control( 'dh_product_comparition_price_tooltip', [
               'label' => __( 'Price Tooltip', 'duurzaamthuis' ),
               'type' => Elementor\Controls_Manager::TEXT,
               'default' => '',
					'condition' => [
						'dh_product_comparition_custom_type' => 'button',
					],
            ] );
            $repeater->add_control( 'dh_product_comparition_button_text', [
               'label' => __( 'Button Text', 'duurzaamthuis' ),
               'type' => Elementor\Controls_Manager::TEXT,
               'label_block' => true,
					'default' => 'Button label',
					'condition' => [
						'dh_product_comparition_custom_type' => 'button',
					],
            ] );
            $repeater->add_control( 'dh_product_comparition_button_link', [
               'label' => __( 'Button Link', 'duurzaamthuis' ),
               'type' => Elementor\Controls_Manager::TEXT,
               'default' => '#',
               'label_block' => true,
					'condition' => [
						'dh_product_comparition_custom_type' => 'button',
					],
            ] );
            $repeater->add_control( 'dh_product_comparition_sponsored',[
               'label' => __( 'Sponsored', 'duurzaamthuis' ),
               'type' => Elementor\Controls_Manager::SWITCHER,
               'label_on' => __( 'Yes', 'duurzaamthuis' ),
               'label_off' => __( 'No', 'duurzaamthuis' ),
               'return_value' => 'yes',
               'default' => 'yes',
               'render_type' => 'ui',
					'condition' => [
						'dh_product_comparition_custom_type' => 'button',
					],
            ] );
				$repeater->add_control( 'dh_product_comparition_script', [
					'type' => Elementor\Controls_Manager::RAW_HTML,
					'raw' => $script,
				] );
         $widget->add_control( 'dh_product_comparition_products', [ // products
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
#endregion

#region get_dh_product_review_controls
	public static function get_dh_product_review_controls( $widget ) {
		ob_start(); ?>
		<# 
			( function( $ ) { 
				var timer = setTimeout(function() {
					$( '.dh-13-chars-max input' ).attr( 'maxlength', 13 ).attr( 'minlength', 13 );
					$( '.dh-numbers-only input' ).keypress(function (e) {
						if ( String.fromCharCode( e.keyCode ).match(/[^0-9]/g) ) return false;
					} );
				}, 100 );		
			} )( jQuery );
		#>
		<style>
			.dh-13-chars-max input:invalid {
				border: 2px dashed red;
			}
		</style>
		<?php $script = ob_get_clean();
		$widget->start_controls_section( 'dh_product_review_section_content', [
         'label' => __( 'Product Comparison Sustainability Score', 'duurzaamthuis' ),
         'tab' => Elementor\Controls_Manager::TAB_CONTENT,
      ] );
         $widget->add_control( 'dh_product_review_skin', [
            'label' => __( 'Skin', 'duurzaamthuis' ),
            'type' => Elementor\Controls_Manager::SELECT,
            'default' => 'skin_1',
            'options' => [
               'skin_1'  => __( 'Skin 1', 'duurzaamthuis' ),
            ],
         ] );
			$widget->add_control( 'dh_product_review_title', [ // title
				'label' => __( 'Title', 'duurzaamthuis' ),
				'type' => Elementor\Controls_Manager::TEXT,
				'default' => __( 'Product title' , 'duurzaamthuis' ),
				'label_block' => true,
			] );
			$widget->add_control( 'dh_product_review_brand', [ // title
				'label' => __( 'Brand', 'duurzaamthuis' ),
				'type' => Elementor\Controls_Manager::TEXT,
				'label_block' => true,
			] );
			$widget->add_control( 'dh_product_review_ean', [ // title
				'label' => __( 'EAN Product ID (GTIN-13)', 'duurzaamthuis' ),
				'type' => Elementor\Controls_Manager::TEXT,
				'default' => __( '' , 'duurzaamthuis' ),
				'label_block' => true,
				'description' => 'For example: 9789000378937 (13 digits)',
				'classes' => "dh-13-chars-max dh-numbers-only",
			] );
			$widget->add_control( 'dh_product_review_content', [
				'label' => __( 'Product review summary', 'duurzaamthuis' ),
				'type' => Elementor\Controls_Manager::WYSIWYG,
				'default' => 'De Buyer is een oud Frans merk van keukenartikelen. Vooral onder professionele koks is het een bekend merk. Ze hebben eigenlijk alle type pannen van RVS tot koper. Met beide hebben we veel ervaring dus wij zijn met name geïnteresseerd in de versie van staal. Hierin bieden ze twee soorten de Carbone en de B-element. Beide zijn eigenlijk identieke pannen. Alleen de B-element is netter afgewerkt met een laagje bijenwas. Dit is vooral ter voorkoming van oxidatie van de pan. Een standaard (Carbone) pan kan soms al roestachtige vlekjes vertonen in de winkel en de bijenwas gaat dit tegen. Ook zou de bijenwas het inbranden vergemakkelijken maar dat is ons inziens niet de bedoeling. Je kunt De Buyer Mineral-B element stalen pan die wij hebben getest hier vinden, we hebben maat 26, een heerlijk maatje trouwens!.',
			] );
         $widget->add_control( 'dh_product_review_logo_url', [
            'type' => Elementor\Controls_Manager::HIDDEN,
            'default' => DH_Product_Review::get_site_logo(),
         ] );
			$widget->add_control( 'dh_product_review_quality', [
				'label' => __( 'Quality', 'duurzaamthuis' ),
				'type' => Elementor\Controls_Manager::TEXT,
				'default' => '9,6',
			] );
			$widget->add_control( 'dh_product_review_quality_amount1', [
				'label' => __( 'Reviews Amount 1', 'duurzaamthuis' ),
				'type' => Elementor\Controls_Manager::TEXT,
				'placeholder' => '2000',
				'classes' => "dh-numbers-only",
			] );
			$widget->add_control( 'dh_product_review_quality_source1', [
				'label' => __( 'Reviews Source 1', 'duurzaamthuis' ),
				'type' => Elementor\Controls_Manager::TEXT,
				'placeholder' => 'Amazon',
			] );
			$widget->add_control( 'dh_product_review_quality_amount2', [
				'label' => __( 'Reviews Amount 2', 'duurzaamthuis' ),
				'type' => Elementor\Controls_Manager::TEXT,
				'placeholder' => '100',
				'classes' => "dh-numbers-only",
			] );
			$widget->add_control( 'dh_product_review_quality_source2', [
				'label' => __( 'Reviews Source 2', 'duurzaamthuis' ),
				'type' => Elementor\Controls_Manager::TEXT,
				'placeholder' => 'Bol.com',
			] );
			$widget->add_control( 'dh_product_review_quality_tooltip', [
				'label' => __( 'Tooltip', 'duurzaamthuis' ),
				'type' => Elementor\Controls_Manager::TEXT,
				'default' => '',
				'description' => 'only use to override automatic tooltip: "gebaseerd op [amount] reviews op [source]"',
				'separator' => 'after',
			] );
			$widget->add_control( 'dh_product_review_co2', [
				'label' => __( 'CO<sub>2</sub>-afdruk', 'duurzaamthuis' ),
				'type' => Elementor\Controls_Manager::TEXT,
				'default' => '150',
				] );
			$widget->add_control( 'dh_product_review_co2_custom_label', [
				'label' => __( 'Custom label', 'duurzaamthuis' ),
				'type' => Elementor\Controls_Manager::TEXT,
				'description' => 'Will be used instead "CO<sub>2</sub>-afdruk"',
			] );
			$widget->add_control( 'dh_product_review_co2_tooltip', [
				'label' => __( 'Tooltip', 'duurzaamthuis' ),
				'type' => Elementor\Controls_Manager::TEXT,
				'default' => '',
				'separator' => 'after',
			] );
			$widget->add_control( 'dh_product_review_price', [
				'label' => __( 'Price', 'duurzaamthuis' ),
				'type' => Elementor\Controls_Manager::TEXT,
				'default' => '26,50',
				'description' => 'If empty, the lowest price from datafeedr will be taken',
			] );
			$widget->add_control( 'dh_product_review_price_tooltip', [
				'label' => __( 'Tooltip', 'duurzaamthuis' ),
				'type' => Elementor\Controls_Manager::TEXT,
				'default' => '',
				'separator' => 'after',
			] );
			$widget->add_control( 'dh_product_review_rating', [
				'label' => __( 'Rating', 'elementor' ),
				'type' => Elementor\Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 10,
				'step' => 0.1,
				'default' => 8,
			] );
			$widget->add_control( 'dh_product_review_rating_tooltip', [
				'label' => __( 'Tooltip', 'duurzaamthuis' ),
				'type' => Elementor\Controls_Manager::TEXT,
				'default' => '',
				'separator' => 'after',
			] );
			$widget->add_control( 'dh_product_review_pros', [
				'label' => 'Pros',
				'label_block' => false,
				'button_title' => __( 'Edit Pros', 'duurzaamthuis' ),
				'type' => 'dh-table-control',
				'separator' => 'before',
				'allow_columns' => false,
				'table_classes' => 'repeater',
				'add_row_title' => __( 'Add Item', 'duurzaamthuis' ),
				'max' => 5,
				'default' => '[["Advantage 1"],["Advantage 2"],["Advantage 3"],["Advantage 4"]]',
			] );
			$widget->add_control( 'dh_product_review_cons', [
				'label' => 'Cons',
				'type' => 'dh-table-control',
				'label_block' => false,
				'button_title' => __( 'Edit Cons', 'duurzaamthuis' ),
				'allow_columns' => false,
				'table_classes' => 'repeater',
				'add_row_title' => __( 'Add Item', 'duurzaamthuis' ),
				'max' => 3,
				'default' => '[["Disadvantage 1"],["Disadvantage 2"]]',
			] );
			$widget->add_control( 'dh_product_review_description', [
				'label' => __( 'Product description summary', 'duurzaamthuis' ),
				'type' => Elementor\Controls_Manager::TEXTAREA,
				'rows' => 10,
				'default' => 'Productbeschrijving van rond de 3 zinnen',
			] );


			$widget->add_control( 'dh_product_review_image', [ // image
				'label' => __( 'Image', 'duurzaamthuis' ),
				'type' => Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => Elementor\Utils::get_placeholder_image_src(),
				],
			] );
			$widget->add_control( 'dh_product_review_shortcode', [
				'label' => esc_html__( 'Enter your shortcode or text', 'elementor' ),
				'type' => Elementor\Controls_Manager::TEXTAREA,
				'dynamic' => [
					'active' => true,
				],
				'placeholder' => '[dfrcs name="Euphoria 110 Mono" filters="currency=EUR"]',
				'description' => 'HTML allowed. Find more shortcode parameters here <a target="_blank" href="https://wordpress.org/plugins/datafeedr-comparison-sets/">https://wordpress.org/plugins/datafeedr-comparison-sets/</a>',
				'default' => '',
			] );
			$widget->add_control( 'dh_product_review_last_updated_text', [
				'label' => __( 'Last Updated Text', 'duurzaamthuis' ),
				'type' => Elementor\Controls_Manager::TEXT,
				'label_block' => true,
			] );
			$widget->add_control( 'dh_product_review_button_text', [
				'label' => __( 'Button Text', 'duurzaamthuis' ),
				'type' => Elementor\Controls_Manager::TEXT,
				'separator' => 'before',
				'label_block' => true,
			] );
			$widget->add_control( 'dh_product_review_button_link', [
				'label' => __( 'Button Link', 'duurzaamthuis' ),
				'type' => Elementor\Controls_Manager::TEXT,
				'default' => '#',
				'label_block' => true,
			] );
			$widget->add_control( 'dh_product_review_script', [
				'type' => Elementor\Controls_Manager::RAW_HTML,
				'raw' => $script,
			] );

		$widget->end_controls_section(); 
	}
#endregion

#region get_dh_impact_controls
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
			$widget->add_control( 'dh_impact_milieuwinst', [ // milieuwinst
				'label' => __( 'Milieuwinst', 'duurzaamthuis' ),
				'type' => Elementor\Controls_Manager::TEXT,
				'default' => '100',
				'classes' => "dh-max-chars-restriction",
			] );
			$widget->add_control( 'dh_impact_prijs', [ // prijs
				'label' => __( 'Prijs', 'duurzaamthuis' ),
				'type' => Elementor\Controls_Manager::TEXT,
				'classes' => "dh-max-chars-restriction",
			] );
			$widget->add_control( 'dh_impact_terugverdientijd', [ // terugverdientijd
				'label' => __( 'Terugverdientijd', 'duurzaamthuis' ),
				'type' => Elementor\Controls_Manager::TEXT,
				'classes' => "dh-max-chars-restriction",
			] );
			$widget->add_control( 'dh_impact_gemak', [ // gemak
				'label' => __( 'Gemak', 'duurzaamthuis' ),
				'type' => Elementor\Controls_Manager::TEXT,
				'classes' => "dh-max-chars-restriction",
			] );
			// $widget->add_control( 'dh_impact_vervuiling', [ // vervuiling
			// 	'label' => __( 'Vervuiling', 'duurzaamthuis' ),
			// 	'type' => Elementor\Controls_Manager::TEXT,
			// 	'classes' => "dh-max-chars-restriction",
			// ] );
			$widget->add_control( 'dh_impact_subsidie', [ // subsidie
				'label' => __( 'Subsidie', 'duurzaamthuis' ),
				'type' => Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Ja', 'duurzaamthuis' ),
				'label_off' => __( 'Nee', 'duurzaamthuis' ),
				'return_value' => 'yes',
			] );
			$widget->add_control( 'dh_impact_subsidie_type', [ // subsidie type
				'label' => __( 'Subsidie Type', 'duurzaamthuis' ),
				'type' => Elementor\Controls_Manager::SELECT,
				'default' => 'yes',
				'options' => [
					'yes'  => __( 'Ja', 'duurzaamthuis' ),
					'no' => __( 'Nee', 'duurzaamthuis' ),
				],
				'classes' => "dh-max-chars-restriction",
				'condition' => [
					'dh_impact_subsidie' => 'yes'
				]
			] );
			$widget->add_control( 'dh_impact_calculations_text', [ // calculations_text
				'label' => __( 'Toelichting', 'duurzaamthuis' ),
				'type' => Elementor\Controls_Manager::WYSIWYG,
			] );
			$widget->add_control( 'dh_impact_script', [
				'type' => Elementor\Controls_Manager::RAW_HTML,
				'raw' => $script,
			] );
		$widget->end_controls_section(); 
	}
#endregion

#region get_dh_mega_menu_controls
	public static function get_dh_mega_menu_controls( $widget ) {
		$widget->start_controls_section( 'dh_mega_menu_section_content', [
         'label' => __( 'Mega Menu', 'duurzaamthuis' ),
         'tab' => Elementor\Controls_Manager::TAB_CONTENT,
      ] );

			$menus = DH_Mega_Menu::get_available_menus();

			$widget->add_control( 'dh_mega_menu_menu', [
				'label' => __( 'Menu', 'duurzaamthuis' ),
				'type' => Elementor\Controls_Manager::SELECT,
				'options' => $menus,
				'default' => array_keys( $menus )[0] ?? '',
			] );
			$widget->add_control( 'dh_mega_menu_mobile_menu', [
				'label' => __( 'Mobile Menu', 'duurzaamthuis' ),
				'type' => Elementor\Controls_Manager::SELECT,
				'default' => array_keys( $menus )[0] ?? '',
				'options' => $menus,
			] );

		$widget->end_controls_section(); 

		$widget->start_controls_section( 'dh_mega_menu_section_style', [
         'label' => __( 'Desktop Menu', 'duurzaamthuis' ),
         'tab' => Elementor\Controls_Manager::TAB_STYLE,
      ] );
			$widget->add_control( 'dh_mega_menu_align_items', [
				'label' => __( 'Align', 'elementor-pro' ),
				'type' => Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'elementor-pro' ),
						'icon' => 'eicon-h-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'elementor-pro' ),
						'icon' => 'eicon-h-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'elementor-pro' ),
						'icon' => 'eicon-h-align-right',
					],
					'justify' => [
						'title' => __( 'Stretch', 'elementor-pro' ),
						'icon' => 'eicon-h-align-stretch',
					],
				],
				'toggle' => false,
				'default' => 'justify',
				'render_type' => 'template', // mandatory if we use prefix_class
				'prefix_class' => 'dh-menu-align-',
			] );
			$widget->add_control( 'dh_mega_menu_space_between', [
				'label' => __( 'Space Between', 'duurzaamthuis' ),
				'type' => Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 10,
				],
				'condition' => [
					'dh_mega_menu_align_items!' => 'justify',
				],
				'selectors' => [
					'{{WRAPPER}} .dh-menu-top-item:not(:last-child)' => 'margin-right: {{SIZE}}{{UNIT}};',
				],
			] );
			$widget->add_control( 'dh_mega_menu_icon_spacing', [
				'label' => __( 'Icon Spacing', 'duurzaamthuis' ),
				'type' => Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 5,
				],
				'selectors' => [
					'{{WRAPPER}} .dh-menu-top-item i' => 'margin-right: {{SIZE}}{{UNIT}};',
				],
			] );
			$widget->add_control( 'dh_mega_menu_offset', [
				'label' => __( 'Dropdown Offset', 'duurzaamthuis' ),
				'type' => Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 5,
				],
				'selectors' => [
					'{{WRAPPER}} .dh-megamenu .elementor-container' => 'top: {{SIZE}}{{UNIT}};',
				],
			] );
			$widget->add_control( 'dh_mega_menu_color', [
            'label' => __( 'Color', 'duurzaamthuis' ),
            'type' => Elementor\Controls_Manager::COLOR,
            'default' => '#515F70',
            'selectors' => [
               '{{WRAPPER}} .dh-menu-top-item' => 'color: {{VALUE}}',
            ],
				'separator' => 'after',
         ] );

		$widget->end_controls_section(); 

		$widget->start_controls_section( 'dh_mega_menu_section_style_mobile', [
         'label' => __( 'Mobile Menu', 'duurzaamthuis' ),
         'tab' => Elementor\Controls_Manager::TAB_STYLE,
      ] );
			$widget->add_control( 'dh_mega_menu_align_toggle', [
				'label' => __( 'Align Toggle', 'elementor-pro' ),
				'type' => Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'elementor-pro' ),
						'icon' => 'eicon-h-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'elementor-pro' ),
						'icon' => 'eicon-h-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'elementor-pro' ),
						'icon' => 'eicon-h-align-right',
					],
				],
				'toggle' => false,
				'default' => 'right',
				'render_type' => 'template', // mandatory if we use prefix_class
				'prefix_class' => 'dh-mobile-toggle-align-',
			] );
			$widget->add_control( 'dh_mega_menu_offset_mobile', [
				'label' => __( 'Dropdown Offset', 'duurzaamthuis' ),
				'type' => Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 30,
				],
				'selectors' => [
					'{{WRAPPER}} .dh-mobile-menu' => 'top: {{SIZE}}{{UNIT}};',
				],
			] );
		$widget->end_controls_section(); 
	}
#endregion

#region get_dh_numbered_list_controls
	public static function get_dh_numbered_list_controls( $widget ) {
		$widget->start_controls_section( 'dh_numbered_list_section_content', [
         'label' => __( 'Numbered List', 'duurzaamthuis' ),
         'tab' => Elementor\Controls_Manager::TAB_CONTENT,
      ] );
			$widget->add_control( 'dh_numbered_list_start', [
				'label' => __( 'Start from', 'duurzaamthuis' ),
				'type' => Elementor\Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 100,
				'step' => 1,
				'default' => 1,     
			] );
			$repeater = new \Elementor\Repeater();
				$repeater->add_control( 'dh_numbered_list_text', [
					'label' => __( 'Text', 'duurzaamthuis' ),
					'type' => Elementor\Controls_Manager::TEXTAREA,
					'rows' => 3,
					'default' => __( 'Item text' , 'duurzaamthuis' ),
					'label_block' => true,
				] );
			$widget->add_control( 'dh_numbered_list_items', [
				'label' => __( 'Items', 'duurzaamthuis' ),
				'type' => Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[],
					[],
				],
				// 'title_field' => '{{{ dh_numbered_list_text }}}',
				'title_field' => '
					<span id="item-{{_id}}"></span>
					<#
					setTimeout( function() {
						var index = jQuery( "#item-" + _id ).closest( ".elementor-repeater-fields" ).index();
						jQuery( "#item-" + _id ).text( ( index + 1 ) + ". " + dh_numbered_list_text );
					}, 10 )
					#>
				',
			] );
		$widget->end_controls_section(); 
	}
#endregion

#region get_dh_how_to_faq_controls
	public static function get_dh_how_to_faq_controls( $widget ) {
		ob_start(); ?>
		<# 
			( function( $ ) { 
				var timer = setTimeout(function() {
					$( '.dh-79-chars-max textarea' ).attr( 'maxlength', 79 );
				}, 100 );		
			} )( jQuery );
		#>
		<style>
			.dh-13-chars-max input:invalid {
				border: 2px dashed red;
			}
		</style>
		<?php $script = ob_get_clean();
		$widget->start_controls_section( 'dh_how_to_faq_section_content', [
         'label' => __( 'How to/FAQ list', 'duurzaamthuis' ),
         'tab' => Elementor\Controls_Manager::TAB_CONTENT,
      ] );
			$widget->add_control( 'dh_how_to_faq_name', [
				'label' => __( 'Heading', 'duurzaamthuis' ),
				'type' => Elementor\Controls_Manager::TEXT,
				'default' => __( 'Heading' , 'duurzaamthuis' ),
				'description' => 'Required for How To Schema markup',
				'label_block' => true,
			] );
			$widget->add_control( 'dh_how_to_faq_start', [
				'label' => __( 'Start from', 'duurzaamthuis' ),
				'type' => Elementor\Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 100,
				'step' => 1,
				'default' => 1,  
				'condition' => [
					'dh_how_to_faq_schema_type' => 'disabled',
				]      
			] );
			$repeater = new \Elementor\Repeater();
				$repeater->add_control( 'dh_how_to_faq_item_heading', [
					'label' => __( 'Heading', 'duurzaamthuis' ),
					'type' => Elementor\Controls_Manager::TEXTAREA,
					'rows' => 3,
					'default' => __( 'Item heading / question' , 'duurzaamthuis' ),
					'classes' => "dh-79-chars-max",
				] );
				$repeater->add_control( 'dh_how_to_faq_item_image', [
               'label' => __( 'Image', 'duurzaamthuis' ),
               'type' => Elementor\Controls_Manager::MEDIA,
					// 'label_block' => false,
            ] );
				$repeater->add_control( 'dh_how_to_faq_item_video_url', [
						'label' => 'YouTube video url',
						'type' => Elementor\Controls_Manager::URL,
						'autocomplete' => false,
						'options' => false,
						'label_block' => true,
						'show_label' => false,
						'placeholder' => 'Enter your URL',
					]
				);
				$repeater->add_control( 'dh_how_to_faq_item_text', [
					'label' => __( 'Text / answer', 'duurzaamthuis' ),
					'type' => Elementor\Controls_Manager::WYSIWYG,
					'rows' => 3,
					'default' => __( 'Lorem ipsum is placeholder text commonly used in the graphic, print, and publishing industries for previewing layouts and visual mockups.' , 'duurzaamthuis' ),
				] );
			$widget->add_control( 'dh_how_to_faq_items', [
				'label' => __( 'Items', 'duurzaamthuis' ),
				'type' => Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[],
					[],
				],
				// 'title_field' => '{{{ dh_how_to_faq_item_heading }}}',
				'title_field' => '
				<span id="item-{{_id}}"></span>
				<#
				setTimeout( function() {
					var index = jQuery( "#item-" + _id ).closest( ".elementor-repeater-fields" ).index();
					jQuery( "#item-" + _id ).text( ( index + 1 ) + ". " + dh_how_to_faq_item_heading );
				}, 10 )
				#>
			',
			] );
			$widget->add_control( 'dh_how_to_faq_schema_type', [
            'label' => __( 'Schema type', 'duurzaamthuis' ),
            'type' => Elementor\Controls_Manager::SELECT,
            'default' => 'disabled',
            'options' => [
               'disabled'  => __( 'Disabled', 'duurzaamthuis' ),
               'how_to' => __( 'How to', 'duurzaamthuis' ),
               'faq' => __( 'FAQ', 'duurzaamthuis' ),
            ],
         ] );
			$widget->add_control( 'dh_how_to_faq_duration_heading',
				[
					'label' => __( 'How To Duration', 'duurzaamthuis' ),
					'type' => \Elementor\Controls_Manager::HEADING,
					'separator' => 'before',
					'condition' => [
						'dh_how_to_faq_schema_type' => 'how_to',
					]  
				]
			);
			$widget->add_control( 'dh_how_to_faq_duration_days', [
				'label' => __( 'Days', 'duurzaamthuis' ),
				'type' => Elementor\Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 31,
				'step' => 1,
				'default' => 0,  
            'condition' => [
               'dh_how_to_faq_schema_type' => 'how_to',
            ]      
			] );
			$widget->add_control( 'dh_how_to_faq_duration_hours', [
				'label' => __( 'Hours', 'duurzaamthuis' ),
				'type' => Elementor\Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 23,
				'step' => 1,
				'default' => 0,  
            'condition' => [
               'dh_how_to_faq_schema_type' => 'how_to',
            ]      
			] );
			$widget->add_control( 'dh_how_to_faq_duration_minutes', [
				'label' => __( 'Minutes', 'duurzaamthuis' ),
				'type' => Elementor\Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 59,
				'step' => 1,
				'default' => 0,  
            'condition' => [
               'dh_how_to_faq_schema_type' => 'how_to',
            ]      
			] );
			$widget->add_control( 'dh_how_to_faq_script', [
				'type' => Elementor\Controls_Manager::RAW_HTML,
				'raw' => $script,
			] );
		$widget->end_controls_section(); 
	}
#endregion

#region get_dh_page_header_controls
	public static function get_dh_page_header_controls( $widget ) {
		$widget->start_controls_section( 'dh_page_header_section_content', [
         'label' => __( 'Page Header', 'duurzaamthuis' ),
         'tab' => Elementor\Controls_Manager::TAB_CONTENT,
      ] );
         $widget->add_control( 'dh_page_header_important_note',[
            'type' => Elementor\Controls_Manager::RAW_HTML,
            'raw' => __( 'This widget has no settings', 'duurzaamthuis' ),
            'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
         ] );
         $widget->add_control( 'dh_page_header_settings_button',[
            'type' => Elementor\Controls_Manager::RAW_HTML,
            'raw' => '<button class="elementor-button elementor-button-default" onclick="$e.route(\'panel/page-settings/settings\');jQuery(\'.elementor-control-dh_page_header_section_impact\').click();">Go to Impact settings</button>',
         ] );
		$widget->end_controls_section(); 

		$widget->start_controls_section( 'dh_page_header_section_style', [
         'label' => __( 'Style', 'duurzaamthuis' ),
         'tab' => Elementor\Controls_Manager::TAB_STYLE,
      ] );
         $widget->add_control( 'dh_page_header_text_color', [
            'label' => __( 'Text Color', 'duurzaamthuis' ),
            'type' => Elementor\Controls_Manager::COLOR,
            'default' => '#FFFFFF',
            'selectors' => [
               '{{WRAPPER}} .dh-page-header-title' => 'color: {{VALUE}}',
               '{{WRAPPER}} .dh-page-header-features-title' => 'color: {{VALUE}}',
               '{{WRAPPER}} .dh-page-header-feature-title' => 'color: {{VALUE}}',
               '{{WRAPPER}} .dh-page-header-feature-value' => 'color: {{VALUE}}',
               '{{WRAPPER}} .dh-page-header-meta' => 'color: {{VALUE}}',
               '{{WRAPPER}} .dh-page-header-calc-toggle .dh-open' => 'color: {{VALUE}}',
               '{{WRAPPER}} .dh-page-header-calc-toggle .dh-close' => 'color: {{VALUE}}',
               '{{WRAPPER}} .dh-page-header-calc-text' => 'color: {{VALUE}}',
               '{{WRAPPER}} .dh-page-header-tag a' => 'color: {{VALUE}}',
               '{{WRAPPER}} ..dh-page-header-breadcrumbs i' => 'color: {{VALUE}}',

            ],
         ] );
         $widget->add_control( 'dh_page_header_first_tag_background_color', [
            'label' => __( 'First Tag Background Color', 'duurzaamthuis' ),
            'type' => Elementor\Controls_Manager::COLOR,
            'default' => '#769179',
            'selectors' => [
               '{{WRAPPER}} .dh-page-header-tag:first-child' => 'color: {{VALUE}}',
            ],
         ] );
         $widget->add_control( 'dh_page_header_impact_icons_color', [
            'label' => __( 'Impact Icons Color', 'duurzaamthuis' ),
            'type' => Elementor\Controls_Manager::COLOR,
            'default' => '#54CC8B',
            'selectors' => [
               '{{WRAPPER}} .dh-page-header-feature-title i' => 'color: {{VALUE}}',
            ],
         ] );
         $widget->add_control( 'dh_page_header_meta_icons_color', [
            'label' => __( 'Meta Icons Color', 'duurzaamthuis' ),
            'type' => Elementor\Controls_Manager::COLOR,
            'default' => '#769179',
            'selectors' => [
               '{{WRAPPER}} .dh-page-header-meta-item i' => 'color: {{VALUE}}',
            ],
         ] );
		$widget->end_controls_section(); 
	}
#endregion

#region get_dh_product_comparition_sustainability_score_controls
	public static function get_dh_product_comparition_sustainability_score_controls( $widget ) {
		ob_start(); ?>
		<# 
			( function( $ ) { 
				var timer = setTimeout(function() {
					$( '.dh-13-chars-max input' ).attr( 'maxlength', 13 ).attr( 'minlength', 13 );
					$( '.dh-numbers-only input' ).keypress(function (e) {
						if ( String.fromCharCode( e.keyCode ).match(/[^0-9]/g) ) return false;
					} );
				}, 100 );		
			} )( jQuery );
		#>
		<style>
			.dh-13-chars-max input:invalid {
				border: 2px dashed red;
			}
			.tab-like-switcher .elementor-choices-label {
				width: 33.333%;
			}
			.tab-like-switcher .elementor-screen-only {
				display: block;
				position: relative;
				height: unset;
				width: unset;
				top: unset;
			}
		</style>
		<?php $script = ob_get_clean();
		$widget->start_controls_section( 'dh_product_comparition_sustainability_score_section_content', [
         'label' => __( 'Product Comparison Sustainability Score', 'duurzaamthuis' ),
         'tab' => Elementor\Controls_Manager::TAB_CONTENT,
      ] );
         $widget->add_control( 'dh_product_comparition_sustainability_score_skin', [
            'label' => __( 'Skin', 'duurzaamthuis' ),
            'type' => Elementor\Controls_Manager::SELECT,
            'default' => 'horizontal',
            'options' => [
               'horizontal'  => __( 'Horizontal', 'duurzaamthuis' ),
               'vertical' => __( 'Vertical', 'duurzaamthuis' ),
            ],
         ] );
         $widget->add_responsive_control( 'dh_product_comparition_sustainability_score_columns_count', [
				'label' => __( 'Columns', 'duurzaamthuis' ),
				'type' => Elementor\Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 6,
				'step' => 1,
				'default' => 3,
				'tablet_default' => 2,
				'mobile_default' => 1,
				'selectors' => [
					'{{WRAPPER}} .dh-products-score-grid' => 'grid-template-columns: repeat({{VALUE}}, 1fr);',
				],   
            'condition' => [
               'dh_product_comparition_sustainability_score_skin' => 'vertical',
            ]      
			] );
         $widget->add_control( 'dh_product_comparition_sustainability_score_logo_url', [
            'type' => Elementor\Controls_Manager::HIDDEN,
            'default' => DH_Product_Comparition_Sustainability_Score::get_site_logo(),
         ] );
         $repeater = new \Elementor\Repeater();
            $repeater->add_control( 'dh_product_comparition_sustainability_score_title', [
               'label' => __( 'Title', 'duurzaamthuis' ),
               'type' => Elementor\Controls_Manager::TEXT,
               'default' => __( 'Product title' , 'duurzaamthuis' ),
               'label_block' => true,
            ] );
				$repeater->add_control( 'dh_product_comparition_sustainability_score_brand', [
					'label' => __( 'Brand', 'duurzaamthuis' ),
					'type' => Elementor\Controls_Manager::TEXT,
					'label_block' => true,
				] );
				$repeater->add_control( 'dh_product_comparition_sustainability_score_ean', [
					'label' => __( 'EAN Product ID (GTIN-13)', 'duurzaamthuis' ),
					'type' => Elementor\Controls_Manager::TEXT,
					'default' => __( '' , 'duurzaamthuis' ),
					'label_block' => true,
					'description' => 'For example: 9789000378937 (13 digits)',
					'classes' => "dh-13-chars-max dh-numbers-only",
				] );
            $repeater->add_control( 'dh_product_comparition_sustainability_score_badge', [
               'label' => __( 'Badge', 'duurzaamthuis' ),
               'type' => Elementor\Controls_Manager::SELECT,
               'default' => 'none',
               'options' => [
                  'none'  => __( 'None', 'duurzaamthuis' ),
                  'best_price' => __( 'Beste prijs', 'duurzaamthuis' ),
                  'best_quality' => __( 'Beste Kwaliteit', 'duurzaamthuis' ),
                  'our_choice' => __( 'Onze keuze', 'duurzaamthuis' ),
                  'eco_choice' => __( 'Beste eco keuze', 'duurzaamthuis' ),
               ],
            ] );
            $repeater->add_control( 'dh_product_comparition_sustainability_score_image', [
               'label' => __( 'Image', 'duurzaamthuis' ),
               'type' => Elementor\Controls_Manager::MEDIA,
               'default' => [
                  'url' => Elementor\Utils::get_placeholder_image_src(),
               ],
               'separator' => 'after',
            ] );
            $repeater->add_control( 'dh_product_comparition_sustainability_score_quality', [
               'label' => __( 'Quality', 'duurzaamthuis' ),
               'type' => Elementor\Controls_Manager::TEXT,
               'default' => '9,6',
            ] );
				$repeater->add_control( 'dh_product_comparition_sustainability_score_quality_amount1', [
					'label' => __( 'Reviews Amount 1', 'duurzaamthuis' ),
					'type' => Elementor\Controls_Manager::TEXT,
					'placeholder' => '2000',
               'classes' => "dh-numbers-only",
				] );
				$repeater->add_control( 'dh_product_comparition_sustainability_score_quality_source1', [
					'label' => __( 'Reviews Source 1', 'duurzaamthuis' ),
					'type' => Elementor\Controls_Manager::TEXT,
					'placeholder' => 'Amazon',
				] );
				$repeater->add_control( 'dh_product_comparition_sustainability_score_quality_amount2', [
					'label' => __( 'Reviews Amount 2', 'duurzaamthuis' ),
					'type' => Elementor\Controls_Manager::TEXT,
					'placeholder' => '100',
               'classes' => "dh-numbers-only",
				] );
				$repeater->add_control( 'dh_product_comparition_sustainability_score_quality_source2', [
					'label' => __( 'Reviews Source 2', 'duurzaamthuis' ),
					'type' => Elementor\Controls_Manager::TEXT,
					'placeholder' => 'Bol.com',
				] );
            $repeater->add_control( 'dh_product_comparition_sustainability_score_quality_tooltip', [
               'label' => __( 'Tooltip', 'duurzaamthuis' ),
               'type' => Elementor\Controls_Manager::TEXT,
               'default' => '',
               'separator' => 'after',
            ] );
            $repeater->add_control( 'dh_product_comparition_sustainability_score_co2', [
					'label' => __( 'CO<sub>2</sub>-afdruk', 'duurzaamthuis' ),
               'type' => Elementor\Controls_Manager::TEXT,
               'default' => '150',
					] );
				$repeater->add_control( 'dh_product_comparition_sustainability_score_co2_custom_label', [
					'label' => __( 'Custom label', 'duurzaamthuis' ),
					'type' => Elementor\Controls_Manager::TEXT,
					'description' => 'Will be used instead "CO<sub>2</sub>-afdruk"',
				] );
            $repeater->add_control( 'dh_product_comparition_sustainability_score_co2_tooltip', [
               'label' => __( 'Tooltip', 'duurzaamthuis' ),
               'type' => Elementor\Controls_Manager::TEXT,
               'default' => '',
               'separator' => 'after',
            ] );
            $repeater->add_control( 'dh_product_comparition_sustainability_score_price', [
               'label' => __( 'Price', 'duurzaamthuis' ),
               'type' => Elementor\Controls_Manager::TEXT,
               'default' => '26,50',
               'description' => 'If empty, the lowest price from datafeedr will be taken',
            ] );
            $repeater->add_control( 'dh_product_comparition_sustainability_score_price_tooltip', [
               'label' => __( 'Tooltip', 'duurzaamthuis' ),
               'type' => Elementor\Controls_Manager::TEXT,
               'default' => '',
               'separator' => 'after',
            ] );
            $repeater->add_control( 'dh_product_comparition_sustainability_score_rating', [
               'label' => __( 'Rating', 'elementor' ),
               'type' => Elementor\Controls_Manager::NUMBER,
					'min' => 0,
					'max' => 10,
					'step' => 0.1,
					'default' => 8,
            ] );
            $repeater->add_control( 'dh_product_comparition_sustainability_score_rating_tooltip', [
               'label' => __( 'Tooltip', 'duurzaamthuis' ),
               'type' => Elementor\Controls_Manager::TEXT,
               'default' => '',
               'separator' => 'after',
            ] );
            $repeater->add_control( 'dh_product_comparition_sustainability_score_pros', [
               'label' => 'Pros',
               'label_block' => false,
               'button_title' => __( 'Edit Pros', 'duurzaamthuis' ),
               'type' => 'dh-table-control',
               'separator' => 'before',
               'allow_columns' => false,
               'table_classes' => 'repeater',
               'add_row_title' => __( 'Add Item', 'duurzaamthuis' ),
               'max' => 5,
               'default' => '[["Advantage 1"],["Advantage 2"],["Advantage 3"],["Advantage 4"]]',
               ] );
            $repeater->add_control( 'dh_product_comparition_sustainability_score_cons', [
               'label' => 'Cons',
               'type' => 'dh-table-control',
               'label_block' => false,
               'button_title' => __( 'Edit Cons', 'duurzaamthuis' ),
               'allow_columns' => false,
               'table_classes' => 'repeater',
               'add_row_title' => __( 'Add Item', 'duurzaamthuis' ),
               'max' => 3,
               'default' => '[["Disadvantage 1"],["Disadvantage 2"]]',
            ] );
            $repeater->add_control( 'dh_product_comparition_sustainability_score_description', [
               'label' => __( 'Description', 'duurzaamthuis' ),
               'type' => Elementor\Controls_Manager::TEXTAREA,
               'rows' => 10,
               'default' => __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. ', 'duurzaamthuis' ),
               'placeholder' => __( 'Type your description here', 'duurzaamthuis' ),
            ] );
				$repeater->add_control( 'dh_product_comparition_sustainability_score_custom_type', [
					'label' => esc_html__( 'Custom shortcode or button', 'duurzaamthuis' ),
					'type' => \Elementor\Controls_Manager::CHOOSE,
					'options' => [
						'ean' => [
							'title' => esc_html__( 'EAN', 'duurzaamthuis' ),
						],
						'shortcode' => [
							'title' => esc_html__( 'Shortcode', 'duurzaamthuis' ),
						],
						'button' => [
							'title' => esc_html__( 'Button', 'duurzaamthuis' ),
						],
					],
					'label_block' => true,
					'toggle' => false,
					'default' => 'ean',
					'classes' => 'tab-like-switcher',
					'separator' => 'before',
				] );
            $repeater->add_control( 'dh_product_comparition_sustainability_score_shortcode', [
					'label' => esc_html__( 'Shortcode below overrides [dfrcs ean="XXX"]', 'duurzaamthuis' ),
					'type' => Elementor\Controls_Manager::TEXTAREA,
					'placeholder' => '[dfrcs name="Euphoria 110 Mono" filters="currency=EUR"]',
					'description' => 'HTML allowed. Find more shortcode parameters here <a target="_blank" href="https://wordpress.org/plugins/datafeedr-comparison-sets/">https://wordpress.org/plugins/datafeedr-comparison-sets/</a>',
					'default' => '',
					'condition' => [
						'dh_product_comparition_sustainability_score_custom_type' => 'shortcode',
					],
				] );
            $repeater->add_control( 'dh_product_comparition_sustainability_score_last_updated_text', [
               'label' => __( 'Last Updated Text', 'duurzaamthuis' ),
               'type' => Elementor\Controls_Manager::TEXT,
               'label_block' => true,
					'condition' => [
						'dh_product_comparition_sustainability_score_custom_type' => 'shortcode',
					],
            ] );
            $repeater->add_control( 'dh_product_comparition_sustainability_score_button_text', [
               'label' => __( 'Button Text', 'duurzaamthuis' ),
               'type' => Elementor\Controls_Manager::TEXT,
               'label_block' => true,
					'default' => 'Button label',
					'condition' => [
						'dh_product_comparition_sustainability_score_custom_type' => 'button',
					],
            ] );
            $repeater->add_control( 'dh_product_comparition_sustainability_score_button_link', [
               'label' => __( 'Button Link', 'duurzaamthuis' ),
               'type' => Elementor\Controls_Manager::TEXT,
               'default' => '#',
               'label_block' => true,
					'condition' => [
						'dh_product_comparition_sustainability_score_custom_type' => 'button',
					],
            ] );
            $repeater->add_control( 'dh_product_comparition_sustainability_score_sponsored',[
               'label' => __( 'Sponsored', 'duurzaamthuis' ),
               'type' => Elementor\Controls_Manager::SWITCHER,
               'label_on' => __( 'Yes', 'duurzaamthuis' ),
               'label_off' => __( 'No', 'duurzaamthuis' ),
               'return_value' => 'yes',
               'default' => 'yes',
               'render_type' => 'ui',
					'condition' => [
						'dh_product_comparition_sustainability_score_custom_type' => 'button',
					],
            ] );
				$repeater->add_control( 'dh_product_comparition_sustainability_score_script', [
					'type' => Elementor\Controls_Manager::RAW_HTML,
					'raw' => $script,
				] );
         $widget->add_control( 'dh_product_comparition_sustainability_score_products', [
            'label' => __( 'Products', 'duurzaamthuis' ),
            'type' => Elementor\Controls_Manager::REPEATER,
            'fields' => $repeater->get_controls(),
            'default' => [
               [
                  'title' => __( 'Product title', 'duurzaamthuis' ),
               ],
            ],
            'title_field' => '{{{ dh_product_comparition_sustainability_score_title }}}',
         ] );
		$widget->end_controls_section(); 
	}
#endregion

#region get_dh_company_offer_controls
	public static function get_dh_company_offer_controls( $widget ) {
		ob_start(); ?>
		<# 
			( function( $ ) { 
				var timer = setTimeout(function() {
					$( '.dh-13-chars-max input' ).attr( 'maxlength', 13 ).attr( 'minlength', 13 );
					$( '.dh-numbers-only input' ).keypress(function (e) {
						if ( String.fromCharCode( e.keyCode ).match(/[^0-9]/g) ) return false;
					} );
				}, 100 );		
			} )( jQuery );
		#>
		<style>
			.dh-13-chars-max input:invalid {
				border: 2px dashed red;
			}
		</style>
		<?php $script = ob_get_clean();
		$widget->start_controls_section( 'dh_company_offer_section_content', [
         'label' => __( 'Companies', 'duurzaamthuis' ),
         'tab' => Elementor\Controls_Manager::TAB_CONTENT,
      ] );
         $widget->add_control( 'dh_company_offer_skin', [
            'label' => __( 'Skin', 'duurzaamthuis' ),
            'type' => Elementor\Controls_Manager::SELECT,
            'default' => 'horizontal',
            'options' => [
               'horizontal'  => __( 'Horizontal', 'duurzaamthuis' ),
               'vertical' => __( 'Vertical', 'duurzaamthuis' ),
            ],
         ] );
			$widget->add_control( 'dh_company_offer_form_id', [
				'label' => __( 'Form ID', 'duurzaamthuis' ),
				'type' => Elementor\Controls_Manager::TEXT,
			] );
			$widget->add_control( 'dh_company_offer_max', [
				'label' => __( 'Maximum companies to select', 'duurzaamthuis' ),
				'type' => Elementor\Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 6,
				'step' => 1,
				'default' => 3,
			] );
         $widget->add_responsive_control( 'dh_company_offer_columns_count', [
				'label' => __( 'Columns', 'duurzaamthuis' ),
				'type' => Elementor\Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 6,
				'step' => 1,
				'default' => 3,
				'tablet_default' => 2,
				'mobile_default' => 1,
				'selectors' => [
					'{{WRAPPER}} .dh-products-score-grid' => 'grid-template-columns: repeat({{VALUE}}, 1fr);',
				],   
            'condition' => [
               'dh_company_offer_skin' => 'vertical',
				]
			] );
         $widget->add_control( 'dh_company_offer_logo_url', [
            'type' => Elementor\Controls_Manager::HIDDEN,
            'default' => DH_company_offer::get_site_logo(),
         ] );
         $repeater = new \Elementor\Repeater();
            $repeater->add_control( 'dh_company_offer_title', [
               'label' => __( 'Title', 'duurzaamthuis' ),
               'type' => Elementor\Controls_Manager::TEXT,
               'default' => __( 'Product title' , 'duurzaamthuis' ),
               'label_block' => true,
            ] );
				$repeater->add_control( 'dh_company_offer_selected', [
					'label' => 'Preselected',
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => __( 'Yes', 'your-plugin' ),
					'label_off' => __( 'No', 'your-plugin' ),
					'return_value' => 'yes',
				] );
            $repeater->add_control( 'dh_company_offer_email', [
               'label' => __( 'Email', 'duurzaamthuis' ),
               'type' => Elementor\Controls_Manager::TEXT,
               'label_block' => true,
            ] );
				// $repeater->add_control( 'dh_company_offer_brand', [
				// 	'label' => __( 'Brand', 'duurzaamthuis' ),
				// 	'type' => Elementor\Controls_Manager::TEXT,
				// 	'label_block' => true,
				// ] );
				// $repeater->add_control( 'dh_company_offer_ean', [
				// 	'label' => __( 'EAN Product ID (GTIN-13)', 'duurzaamthuis' ),
				// 	'type' => Elementor\Controls_Manager::TEXT,
				// 	'label_block' => true,
				// 	'description' => 'For example: 9789000378937 (13 digits)',
				// 	'classes' => "dh-13-chars-max dh-numbers-only",
				// ] );
            $repeater->add_control( 'dh_company_offer_badge', [
               'label' => __( 'Badge', 'duurzaamthuis' ),
               'type' => Elementor\Controls_Manager::SELECT,
               'default' => 'none',
               'options' => [
                  'none'  => __( 'None', 'duurzaamthuis' ),
                  'best_price' => __( 'Beste prijs', 'duurzaamthuis' ),
                  'best_quality' => __( 'Beste Kwaliteit', 'duurzaamthuis' ),
                  'our_choice' => __( 'Onze keuze', 'duurzaamthuis' ),
                  'eco_choice' => __( 'Beste eco keuze', 'duurzaamthuis' ),
               ],
            ] );
            $repeater->add_control( 'dh_company_offer_image', [
               'label' => __( 'Image', 'duurzaamthuis' ),
               'type' => Elementor\Controls_Manager::MEDIA,
               'default' => [
                  'url' => Elementor\Utils::get_placeholder_image_src(),
               ],
               'separator' => 'after',
            ] );
            // $repeater->add_control( 'dh_company_offer_quality', [
            //    'label' => __( 'Quality', 'duurzaamthuis' ),
            //    'type' => Elementor\Controls_Manager::TEXT,
            //    'default' => '',
            // ] );
				// $repeater->add_control( 'dh_company_offer_quality_amount1', [
				// 	'label' => __( 'Reviews Amount 1', 'duurzaamthuis' ),
				// 	'type' => Elementor\Controls_Manager::TEXT,
				// 	'placeholder' => '2000',
            //    'classes' => "dh-numbers-only",
				// ] );
				// $repeater->add_control( 'dh_company_offer_quality_source1', [
				// 	'label' => __( 'Reviews Source 1', 'duurzaamthuis' ),
				// 	'type' => Elementor\Controls_Manager::TEXT,
				// 	'placeholder' => 'Amazon',
				// ] );
				// $repeater->add_control( 'dh_company_offer_quality_amount2', [
				// 	'label' => __( 'Reviews Amount 2', 'duurzaamthuis' ),
				// 	'type' => Elementor\Controls_Manager::TEXT,
				// 	'placeholder' => '100',
            //    'classes' => "dh-numbers-only",
				// ] );
				// $repeater->add_control( 'dh_company_offer_quality_source2', [
				// 	'label' => __( 'Reviews Source 2', 'duurzaamthuis' ),
				// 	'type' => Elementor\Controls_Manager::TEXT,
				// 	'placeholder' => 'Bol.com',
				// ] );
            // $repeater->add_control( 'dh_company_offer_quality_tooltip', [
            //    'label' => __( 'Tooltip', 'duurzaamthuis' ),
            //    'type' => Elementor\Controls_Manager::TEXT,
            //    'default' => '',
            //    'separator' => 'after',
            // ] );
            // $repeater->add_control( 'dh_company_offer_co2', [
				// 	'label' => __( 'CO<sub>2</sub>-afdruk', 'duurzaamthuis' ),
            //    'type' => Elementor\Controls_Manager::TEXT,
            //    'default' => '',
				// 	] );
				// $repeater->add_control( 'dh_company_offer_co2_custom_label', [
				// 	'label' => __( 'Custom label', 'duurzaamthuis' ),
				// 	'type' => Elementor\Controls_Manager::TEXT,
				// 	'description' => 'Will be used instead "CO<sub>2</sub>-afdruk"',
				// ] );
            // $repeater->add_control( 'dh_company_offer_co2_tooltip', [
            //    'label' => __( 'Tooltip', 'duurzaamthuis' ),
            //    'type' => Elementor\Controls_Manager::TEXT,
            //    'default' => '',
            //    'separator' => 'after',
            // ] );
            // $repeater->add_control( 'dh_company_offer_price', [
            //    'label' => __( 'Price', 'duurzaamthuis' ),
            //    'type' => Elementor\Controls_Manager::TEXT,
            //    'default' => '',
            //    'description' => 'If empty, the lowest price from datafeedr will be taken',
            // ] );
            // $repeater->add_control( 'dh_company_offer_price_tooltip', [
            //    'label' => __( 'Tooltip', 'duurzaamthuis' ),
            //    'type' => Elementor\Controls_Manager::TEXT,
            //    'default' => '',
            //    'separator' => 'after',
            // ] );
            $repeater->add_control( 'dh_company_offer_rating', [
               'label' => __( 'Rating', 'elementor' ),
               'type' => Elementor\Controls_Manager::NUMBER,
					'min' => 1,
					'max' => 10,
            ] );
            $repeater->add_control( 'dh_company_offer_rating_tooltip', [
               'label' => __( 'Tooltip', 'duurzaamthuis' ),
               'type' => Elementor\Controls_Manager::TEXT,
               'default' => '',
               'separator' => 'after',
            ] );
            $repeater->add_control( 'dh_company_offer_pros', [
               'label' => 'Pros',
               'label_block' => false,
               'button_title' => __( 'Edit Pros', 'duurzaamthuis' ),
               'type' => 'dh-table-control',
               'separator' => 'before',
               'allow_columns' => false,
               'table_classes' => 'repeater',
               'add_row_title' => __( 'Add Item', 'duurzaamthuis' ),
               'max' => 5,
               'default' => '[["Advantage 1"],["Advantage 2"],["Advantage 3"],["Advantage 4"]]',
               ] );
            $repeater->add_control( 'dh_company_offer_cons', [
               'label' => 'Cons',
               'type' => 'dh-table-control',
               'label_block' => false,
               'button_title' => __( 'Edit Cons', 'duurzaamthuis' ),
               'allow_columns' => false,
               'table_classes' => 'repeater',
               'add_row_title' => __( 'Add Item', 'duurzaamthuis' ),
               'max' => 3,
               'default' => '[["Disadvantage 1"],["Disadvantage 2"]]',
            ] );
            $repeater->add_control( 'dh_company_offer_description', [
               'label' => __( 'Description', 'duurzaamthuis' ),
               'type' => Elementor\Controls_Manager::TEXTAREA,
               'rows' => 10,
               'default' => __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. ', 'duurzaamthuis' ),
               'placeholder' => __( 'Type your description here', 'duurzaamthuis' ),
            ] );
            // $repeater->add_control( 'dh_company_offer_button_text', [
            //    'label' => __( 'Button Text', 'duurzaamthuis' ),
            //    'type' => Elementor\Controls_Manager::TEXT,
            //    'default' => 'Button text',
            //    'separator' => 'before',
            //    'label_block' => true,
            // ] );
            // $repeater->add_control( 'dh_company_offer_button_link', [
            //    'label' => __( 'Button Link', 'duurzaamthuis' ),
            //    'type' => Elementor\Controls_Manager::TEXT,
            //    'default' => '#',
            //    'label_block' => true,
            // ] );
				$repeater->add_control( 'dh_company_offer_script', [
					'type' => Elementor\Controls_Manager::RAW_HTML,
					'raw' => $script,
				] );
         $widget->add_control( 'dh_company_offer_products', [
            'label' => __( 'Products', 'duurzaamthuis' ),
            'type' => Elementor\Controls_Manager::REPEATER,
            'fields' => $repeater->get_controls(),
            'default' => [
               [
                  'title' => __( 'Product title', 'duurzaamthuis' ),
               ],
            ],
            'title_field' => '{{{ dh_company_offer_title }}}',
         ] );
		$widget->end_controls_section(); 
	}
#endregion

#region get_dh_related_content_controls
	public static function get_dh_related_content_controls( $widget, $is_multiwidget = false ) {
		ob_start(); ?>
			<# 
				(function($) { 
					var id = Math.floor(Math.random()*9000000) + 1000000; 
					print('<span id="dh-repeater-item-' + id + '"></span>'); 
					var counter = 0;
					var timer = setInterval(function() {
						var repeater_item = $('#dh-repeater-item-' + id).closest('.elementor-repeater-fields');
						if(repeater_item.length) {
							var title = $(repeater_item).find('.select2-selection__rendered').attr('title');
							if(title) {
								clearInterval(timer);
								$(repeater_item).find('.elementor-repeater-row-item-title').text(title);
							} else {
								counter++;
								if(counter > 30) {
									clearInterval(timer);
								}
							}
						}
					}, 100);		
				})(jQuery);
			#>
		<?php $script = ob_get_clean();
		$widget->start_controls_section( 'dh_related_content_section_content', [
         'label' => __( 'Related Content', 'duurzaamthuis' ),
         'tab' => Elementor\Controls_Manager::TAB_CONTENT,
      ] );
			if ( ! $is_multiwidget ) {
				$widget->add_control( 'dh_related_content_heading', [
					'label' => __( 'Heading', 'duurzaamthuis' ),
					'type' => Elementor\Controls_Manager::TEXT,
					'default' => 'Gerelateerde artikelen',
					'label_block' => true,
					'separator' => 'before'
				] );
			} 
			$widget->add_control( 'dh_related_content_type', [
            'label' => __( 'Query', 'duurzaamthuis' ),
            'type' => Elementor\Controls_Manager::SELECT,
            'default' => 'manual',
            'options' => [
               'manual'  => __( 'Manual', 'duurzaamthuis' ),
               'related' => __( 'Related', 'duurzaamthuis' ),
            ],
         ] );
         $widget->add_responsive_control( 'dh_related_content_columns_count', [
            'label' => __( 'Columns', 'duurzaamthuis' ),
            'type' => Elementor\Controls_Manager::NUMBER,
            'min' => 1,
            'max' => 6,
            'step' => 1,
            'default' => 3,
            'tablet_default' => 2,
            'mobile_default' => 1,
            'selectors' => [
               '{{WRAPPER}} .dh-related-content-grid' => 'grid-template-columns: repeat({{VALUE}}, 1fr);',
            ],         
         ] );
         $widget->add_control( 'dh_related_content_posts_count', [
            'label' => __( 'Posts Count', 'duurzaamthuis' ),
            'type' => Elementor\Controls_Manager::NUMBER,
            'min' => 1,
            'max' => 9,
            'step' => 1,
            'default' => 3,
            'condition' => [
               'dh_related_content_type' => 'related',
            ],         
         ] );
         $widget->add_control( 'dh_related_content_show_excerpt',[
            'label' => __( 'Show Exerpt', 'duurzaamthuis' ),
            'type' => Elementor\Controls_Manager::SWITCHER,
            'label_on' => __( 'Yes', 'duurzaamthuis' ),
            'label_off' => __( 'No', 'duurzaamthuis' ),
            'default' => 'yes',
            'return_value' => 'yes',
         ] );
         $repeater = new \Elementor\Repeater();
            $repeater->add_control( 'dh_related_content_id', [
               'label' => __( 'Search & Select', 'duurzaamthuis' ),
               'type' => ElementorPro\Modules\QueryControl\Module::QUERY_CONTROL_ID,
               'options' => [],
               'label_block' => true,
               'multiple' => false,
               'autocomplete' => [
                  'object' => ElementorPro\Modules\QueryControl\Module::QUERY_OBJECT_POST,
                  'display' => 'dh_custom',
                  'query' => [
                     'post_type' => ['post', 'page' ],
                     'post_status' => 'publish',
                  ],
               ],
            ] );

            $repeater->add_control( 'dh_related_content_badge', [
               'label' => __( 'Badge', 'duurzaamthuis' ),
               'type' => Elementor\Controls_Manager::SELECT,
               'default' => 'none',
               'options' => [
                  'none'  => __( 'None', 'duurzaamthuis' ),
                  'best_choise' => __( 'Beste Keuze', 'duurzaamthuis' ),
                  'reading_tip' => __( 'Leestip', 'duurzaamthuis' ),
               ],
            ] );
         $widget->add_control( 'dh_related_content_posts', [
            'label' => __( 'Posts', 'duurzaamthuis' ),
            'type' => Elementor\Controls_Manager::REPEATER,
            'fields' => $repeater->get_controls(),
				'title_field' => $script,
				'condition' => [
					'dh_related_content_type' => 'manual',
				],
				'show_label' => false,
				'prevent_empty' => false,
         ] );
			$widget->add_control( 'dh_related_content_posts_button', [
				'label' => __( 'Reload Template', 'duurzaamthuis' ),
				'description' => 'Click "Reload" button to see Related Content widget changes',
				'type' => \Elementor\Controls_Manager::BUTTON,
				'button_type' => 'success',
				'text' => __( '&nbsp;Reload&nbsp;', 'duurzaamthuis' ),
			] );
		$widget->end_controls_section(); 
	}
#endregion

#region get_dh_table_controls
	public static function get_dh_table_controls( $widget ) {
		$widget->start_controls_section( 'dh_table_section_content', [
         'label' => __( 'Table', 'duurzaamthuis' ),
         'tab' => Elementor\Controls_Manager::TAB_CONTENT,
      ] );
         $widget->add_control( 'dh_table_table', [
            'label' => 'Table',
            'label_block' => true,
            'type' => 'dh-table-control',
            'button_title' => 'Edit Table',
            'label_block' => false,
            'allow_columns' => true,
            'table_classes' => 'table',
            'add_row_title' => __( 'Add Row', 'duurzaamthuis' ),
            'add_column_title' => __( 'Add Column', 'duurzaamthuis' ),
            'default' => '[["Column 1 heading","Column 2 heading"],["Some text","Some text"]]',
         ] );
		$widget->end_controls_section(); 
	}
#endregion

#region get_dh_number_heading_controls
	public static function get_dh_number_heading_controls( $widget ) {
		$widget->start_controls_section( 'dh_number_heading_section_content', [
         'label' => __( 'Humber Heading', 'duurzaamthuis' ),
         'tab' => Elementor\Controls_Manager::TAB_CONTENT,
      ] );
			$widget->add_control( 'dh_number_heading_number', [
				'label' => __( 'Number', 'duurzaamthuis' ),
				'type' => Elementor\Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 100,
				'step' => 1,
				'default' => 1,
			] );
			$widget->add_control( 'dh_number_heading_heading', [
				'label' => __( 'Heading', 'duurzaamthuis' ),
				'type' => Elementor\Controls_Manager::TEXTAREA,
				'rows' => 3,
				'default' => __( 'Default heading', 'duurzaamthuis' ),
			] );
			$widget->add_control( 'dh_number_heading_badge', [
				'label' => __( 'Badge', 'duurzaamthuis' ),
				'type' => Elementor\Controls_Manager::SELECT,
				'default' => 'none',
				'options' => [
					'none'  => __( 'None', 'duurzaamthuis' ),
					'best_choise' => __( 'Beste Keuze', 'duurzaamthuis' ),
					'reading_tip' => __( 'Leestip', 'duurzaamthuis' ),
				],
			] );
			$widget->add_control( 'dh_number_heading_size', [
				'label' => __( 'Size', 'duurzaamthuis' ),
				'type' => Elementor\Controls_Manager::SELECT,
				'default' => 'h2',
				'options' => [
					'h1'  => __( 'H1', 'duurzaamthuis' ),
					'h2' => __( 'H2', 'duurzaamthuis' ),
					'h3' => __( 'H3', 'duurzaamthuis' ),
					'h4' => __( 'H4', 'duurzaamthuis' ),
				],
			] );
		$widget->end_controls_section(); 
	}
#endregion

	public static function is_multiwidget() {
		$start_time = microtime(true);
		$e = new Exception();
		$trace = $e->getTrace();
		if ( ! strpos( $trace[2]['file'], 'multiwidgets.php' ) ) {
			return true;
		}
		return false;
	}

}











// cleanup post dh-dfrcs-set cache
add_action( 'elementor/editor/after_save', function( $post_id, $editor_data ) {
	$post_meta = get_post_meta( $post_id );
	foreach ( $post_meta as $key => $value ) {
		if ( substr( $key, 0, 13 ) === "dh-dfrcs-set-" ) {
			delete_post_meta( $post_id, $key );
		}
	}
}, 10, 2 );





function dh_format_price( $price ) {
	$maybe_decimal_sign = substr( $price, -3, -2 );
	if ( $maybe_decimal_sign == '.' || $maybe_decimal_sign == ',' ) {
		$decimal = substr( $price, -2 );
		$price = str_replace( [',', '.'], '', substr( $price, 0, -2 ) ) . '.' . $decimal;
	}
	return $price;
}





// add sticky option for column
add_action( 'elementor/element/column/layout/before_section_end', function( $element ) {
	$element->add_responsive_control( 'dh_sticky_column', [
		'label' => 'DH Make column sticky',
		'type' => Elementor\Controls_Manager::SWITCHER,
		'label_on' => __( 'Yes', 'duurzaamthuis' ),
		'label_off' => __( 'No', 'duurzaamthuis' ),
		'return_value' => 'yes',
		'frontend_available' => true,
	] );
} );
