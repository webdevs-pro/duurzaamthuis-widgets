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
			// wp_enqueue_style( 'dh-icons', plugins_url( '/assets/dh-icons-font/style.css', __FILE__ ), array(), DH_VERSION ); 
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
		require __DIR__ . '/widgets/video.php';

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
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new DH_Video() );
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
		$ajax_handler->add_error( 'Selecteer minimaal 1 bedrijf' );
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
			$post->add_control( 'subsidie_switcher', [
				'label' => __( 'Toelichting', 'duurzaamthuis' ),
				'type' => Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Aan', 'duurzaamthuis' ),
				'label_off' => __( 'Uit', 'duurzaamthuis' ),
				'return_value' => 'yes',
			] );
			$post->add_control( 'calculations_text', [
				'type' => Elementor\Controls_Manager::WYSIWYG,
				'condition' => [
					'subsidie_switcher' => 'yes'
				]
			] );
			$post->add_control( 'subsidie', [
				'label' => __( 'Subsidie', 'duurzaamthuis' ),
				'type' => Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Aan', 'duurzaamthuis' ),
				'label_off' => __( 'Uit', 'duurzaamthuis' ),
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
			$post->add_control( 'subsidie_tooltip2', [ // subsidie type
				'label' => __( 'Subsidie Tooltip', 'duurzaamthuis' ),
				'type' => Elementor\Controls_Manager::WYSIWYG,
				'condition' => [
					'subsidie' => 'yes',
					'subsidie_type2' => 'yes2'
				]
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
		update_post_meta( $post_id, 'subsidie_tooltip', $settings['subsidie_tooltip2'] ?? '' );
		// update_post_meta( $post_id, 'vervuiling', $settings['vervuiling'] ?? '' );
		update_post_meta( $post_id, 'calculations-text', $settings['calculations_text'] ?? '' );
	}
}
new DH_Impact_Fields();





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

// custom field for menu item to set icon svg code
add_action( 'wp_nav_menu_item_custom_fields', 'duurza_menu_item_icon_svg', 10, 2 );
add_action( 'wp_update_nav_menu_item', 'duurza_save_menu_item_icon_svg', 10, 2 );
function duurza_menu_item_icon_svg( $item_id, $item ) {
	$menu_item_icon_svg = get_post_meta( $item_id, '_menu_item_icon_svg', true );
	?>
	<p class="description description-wide">
		<label for="menu_item_icon_svg[<?php echo $item_id ;?>]">
			Icon SVG<br>
			<textarea rows="6" class="widefat code" name="menu_item_icon_svg[<?php echo $item_id ;?>]" id="menu-item-icon-svg-<?php echo $item_id ;?>"><?php echo esc_attr( $menu_item_icon_svg ); ?></textarea>
		</label>
	</p>
	<?php
}
function duurza_save_menu_item_icon_svg( $menu_id, $menu_item_db_id ) {
	if ( isset( $_POST['menu_item_icon_svg'][$menu_item_db_id]  ) ) {
		// $sanitized_data = sanitize_text_field( $_POST['menu_item_icon_svg'][$menu_item_db_id] );
		$sanitized_data = $_POST['menu_item_icon_svg'][$menu_item_db_id];
		update_post_meta( $menu_item_db_id, '_menu_item_icon_svg', $sanitized_data );
	} else {
		delete_post_meta( $menu_item_db_id, '_menu_item_icon_svg' );
	}
}


// filter excerpt
add_filter( 'get_the_excerpt', 'dh_excerpt_filter', 1, 2 );
function dh_excerpt_filter( $excerpt, $post ) {

	$yoast_description = get_post_meta( $post->ID, '_yoast_wpseo_metadesc', true ); 
	
	if ( ! $yoast_description ) {
		$introduction = ''; // intro section removed with version 1.76
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
			$widget->add_control( 'dh_image_heading_text_image_height', [
				'label' => __( 'Image height', 'duurzaamthuis' ),
				'type' => Elementor\Controls_Manager::SELECT,
				'default' => 'ratio',
				'options' => [
					'auto'  => __( 'Auto', 'duurzaamthuis' ),
					'ratio' => __( 'Ratio Contain', 'duurzaamthuis' ),
					'ratio-cover' => __( 'Ratio Cover', 'duurzaamthuis' ),
				],
				'render_type' => 'template', // mandatory if we use prefix_class
				'prefix_class' => 'dh-image-height-',
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
			$widget->add_control( 'dh_image_heading_text_image_style_numbers', [
				'label' => __( 'Style list numbers', 'duurzaamthuis' ),
				'type' => Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'duurzaamthuis' ),
				'label_off' => __( 'No', 'duurzaamthuis' ),		
				'return_value' => 'yes',
				'default' => 'yes',		
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
            $repeater->add_control( 'dh_product_comparition_brand', [ // title
               'label' => __( 'Brand', 'duurzaamthuis' ),
               'type' => Elementor\Controls_Manager::TEXT,
               'default' => __( '' , 'duurzaamthuis' ),
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
				] );
				$repeater->add_control( 'dh_product_comparition_star_rating', [ // star_rating
					'label' => __( 'Rating', 'elementor' ),
					'type' => Elementor\Controls_Manager::NUMBER,
					'min' => 0,
					'max' => 5,
					'step' => 0.1,
					'default' => 5,
				] );
            // $repeater->add_control( 'dh_product_comparition_order_by', [ // order_by
            //    'label' => __( 'Order By', 'duurzaamthuis' ),
            //    'type' => Elementor\Controls_Manager::TEXT,
            //    'default' => 'Voor 23:59 besteld',
            // ] );
				$repeater->add_control( 'dh_product_comparition_description', [ // description
               'label' => __( 'Description', 'duurzaamthuis' ),
               'type' => Elementor\Controls_Manager::TEXTAREA,
               'default' => '',
            ] );
				// $repeater->add_control( 'dh_product_comparition_custom_type', [
				// 	'label' => esc_html__( 'Custom shortcode or button', 'duurzaamthuis' ),
				// 	'type' => \Elementor\Controls_Manager::CHOOSE,
				// 	'options' => [
				// 		'ean' => [
				// 			'title' => esc_html__( 'EAN', 'duurzaamthuis' ),
				// 		],
				// 		'name' => [
				// 			'title' => esc_html__( 'Name', 'duurzaamthuis' ),
				// 		],
				// 		'button' => [
				// 			'title' => esc_html__( 'Button', 'duurzaamthuis' ),
				// 		],
				// 		'shortcode' => [
				// 			'title' => esc_html__( 'Shortcode', 'duurzaamthuis' ),
				// 		],
				// 	],
				// 	'label_block' => true,
				// 	'toggle' => false,
				// 	'default' => 'ean',
				// 	'classes' => 'tab-like-switcher',
				// 	'separator' => 'before',
				// ] );
				$repeater->add_control( 'dh_product_comparition_custom_type', [
					'label' => esc_html__( 'Custom shortcode or button', 'duurzaamthuis' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'options' => [
						'ean' => esc_html__( 'EAN', 'duurzaamthuis' ),
						'name' => esc_html__( 'Name', 'duurzaamthuis' ),
						'button' => esc_html__( 'Button', 'duurzaamthuis' ),
						'shortcode' => esc_html__( 'Shortcode', 'duurzaamthuis' ),
						'eco' => esc_html__( 'eco-logisch.nl', 'duurzaamthuis' ),
					],
					'label_block' => true,
					'toggle' => false,
					'default' => 'ean',
					'classes' => 'tab-like-switcher',
					'separator' => 'before',
				] );
				$repeater->add_control( 'dh_product_comparition_name', [
					'label' => esc_html__( 'Product name', 'duurzaamthuis' ),
					'type' => Elementor\Controls_Manager::TEXT,
               'label_block' => true,
					'placeholder' => 'Bosch KGN33NLEB',
					'description' => 'Name attribute for [dfrcs name="XXXXXXXX""] shorcode',
					'default' => '',
					'condition' => [
						'dh_product_comparition_custom_type' => 'name',
					],
				] );
            // $repeater->add_control( 'dh_product_comparition_last_updated_text', [
            //    'label' => __( 'Last Updated Text', 'duurzaamthuis' ),
            //    'type' => Elementor\Controls_Manager::TEXT,
            //    'label_block' => true,
				// 	'condition' => [
				// 		'dh_product_comparition_custom_type' => 'name',
				// 	],
            // ] );
            $repeater->add_control( 'dh_product_comparition_shortcode', [
					'label' => esc_html__( 'Shortcode below overrides [dfrcs ean="XXX"]', 'duurzaamthuis' ),
					'type' => Elementor\Controls_Manager::TEXTAREA,
					'placeholder' => '[dfrcs name="Euphoria 110 Mono" filters="currency=EUR"]',
					'description' => 'HTML allowed. Find more shortcode parameters here <a target="_blank" href="https://wordpress.org/plugins/datafeedr-comparison-sets/">https://wordpress.org/plugins/datafeedr-comparison-sets/</a>',
					'default' => '[dfrcs name="Euphoria 110 Mono" filters="currency=EUR"]',
					'condition' => [
						'dh_product_comparition_custom_type' => 'shortcode',
					],
				] );
            // $repeater->add_control( 'dh_product_comparition_last_updated_text', [
            //    'label' => __( 'Last Updated Text', 'duurzaamthuis' ),
            //    'type' => Elementor\Controls_Manager::TEXT,
            //    'label_block' => true,
				// 	'condition' => [
				// 		'dh_product_comparition_custom_type' => 'shortcode',
				// 	],
            // ] );
				$repeater->add_control( 'dh_product_comparition_button_image', [
               'label' => __( 'Logo', 'duurzaamthuis' ),
               'type' => Elementor\Controls_Manager::MEDIA,
					'condition' => [
						'dh_product_comparition_custom_type' => 'button',
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
				$repeater->add_control( 'dh_product_comparition_eco_gtin8', [
					'label' => esc_html__( 'GTIN8', 'duurzaamthuis' ),
					'type' => Elementor\Controls_Manager::TEXT,
               'label_block' => true,
					// 'placeholder' => 'Bosch KGN33NLEB',
					'default' => '',
					'render_type' => 'ui',
					'condition' => [
						'dh_product_comparition_custom_type' => 'eco',
					],
				] );
				$repeater->add_control( 'dh_product_comparition_update_widget', [
					// 'label' => esc_html__( 'Apply', 'duurzaamthuis' ),
					'type' => \Elementor\Controls_Manager::BUTTON,
					'button_type' => 'success',
					'text' => '&nbsp;&nbsp;&nbsp;Apply&nbsp;&nbsp;&nbsp;',
					'event' => 'namespace:editor:submit',
					'condition' => [
						'dh_product_comparition_custom_type' => 'eco',
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
			$widget->add_control( 'dh_impact_subsidie_switcher', [
				'label' => __( 'Toelichting', 'duurzaamthuis' ),
				'type' => Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Aan', 'duurzaamthuis' ),
				'label_off' => __( 'Uit', 'duurzaamthuis' ),
				'return_value' => 'yes',
			] );
			$widget->add_control( 'dh_impact_calculations_text', [ // calculations_text
				'type' => Elementor\Controls_Manager::WYSIWYG,
				'condition' => [
					'dh_impact_subsidie_switcher' => 'yes'
				]
			] );
			$widget->add_control( 'dh_impact_subsidie', [ // subsidie
				'label' => __( 'Subsidie', 'duurzaamthuis' ),
				'type' => Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Aan', 'duurzaamthuis' ),
				'label_off' => __( 'Uit', 'duurzaamthuis' ),
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
			$widget->add_control( 'dh_impact_subsidie_tooltip', [ // subsidie tooltip
				'label' => __( 'Subsidie Tooltip', 'duurzaamthuis' ),
				'type' => Elementor\Controls_Manager::WYSIWYG,
				'rows' => 3,
				'condition' => [
					'dh_impact_subsidie' => 'yes',
					'dh_impact_subsidie_type' => 'yes'
				]
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
			$widget->add_responsive_control( 'dh_mega_menu_space_between', [
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
					'{{WRAPPER}} .dh-menu-top-item' => '--item-margin: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .dh-menu-top-item svg' => 'margin-right: {{SIZE}}{{UNIT}};',
				],
			] );
			$widget->add_responsive_control( 'dh_mega_menu_offset', [
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
					'{{WRAPPER}}' => '--menu-top-offset: {{SIZE}}{{UNIT}};',
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
				$repeater->add_control( 'dh_how_to_faq_item_image_height', [
					'label' => __( 'Image height', 'duurzaamthuis' ),
					'type' => Elementor\Controls_Manager::SELECT,
					'default' => 'ratio-cover',
					'options' => [
						'auto'  => __( 'Auto', 'duurzaamthuis' ),
						'ratio' => __( 'Ratio Contain', 'duurzaamthuis' ),
						'ratio-cover' => __( 'Ratio Cover', 'duurzaamthuis' ),
					],
					// 'prefix_class' => 'dh-image-height-',
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
               '{{WRAPPER}} .dh-page-header-feature-title svg *' => 'fill: {{VALUE}}',

            ],
         ] );
         $widget->add_control( 'dh_page_header_meta_icons_color', [
            'label' => __( 'Meta Icons Color', 'duurzaamthuis' ),
            'type' => Elementor\Controls_Manager::COLOR,
            'default' => '#769179',
            'selectors' => [
               '{{WRAPPER}} .dh-page-header-meta-item i' => 'color: {{VALUE}}',
               '{{WRAPPER}} .dh-page-header-meta-item svg *' => 'fill: {{VALUE}}',
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
						'name' => [
							'title' => esc_html__( 'Name', 'duurzaamthuis' ),
						],
						'button' => [
							'title' => esc_html__( 'Button', 'duurzaamthuis' ),
						],
						'shortcode' => [
							'title' => esc_html__( 'Shortcode', 'duurzaamthuis' ),
						],
					],
					'label_block' => true,
					'toggle' => false,
					'default' => 'ean',
					'classes' => 'tab-like-switcher',
					'separator' => 'before',
				] );
            $repeater->add_control( 'dh_product_comparition_sustainability_score_name', [
					'label' => esc_html__( 'Product name', 'duurzaamthuis' ),
					'type' => Elementor\Controls_Manager::TEXT,
               'label_block' => true,
					'placeholder' => 'Bosch KGN33NLEB',
					'description' => 'Name attribute for [dfrcs name="XXXXXXXX""] shorcode',
					'default' => '',
					'condition' => [
						'dh_product_comparition_sustainability_score_custom_type' => 'name',
					],
				] );
            // $repeater->add_control( 'dh_product_comparition_sustainability_score_name_last_updated_text', [
            //    'label' => __( 'Last Updated Text', 'duurzaamthuis' ),
            //    'type' => Elementor\Controls_Manager::TEXT,
            //    'label_block' => true,
				// 	'condition' => [
				// 		'dh_product_comparition_sustainability_score_custom_type' => 'name',
				// 	],
            // ] );
            $repeater->add_control( 'dh_product_comparition_sustainability_score_shortcode', [
					'label' => esc_html__( 'Shortcode', 'duurzaamthuis' ),
					'type' => Elementor\Controls_Manager::TEXTAREA,
					'description' => 'HTML allowed. Find more shortcode parameters here <a target="_blank" href="https://wordpress.org/plugins/datafeedr-comparison-sets/">https://wordpress.org/plugins/datafeedr-comparison-sets/</a>',
					'default' => '[dfrcs name="Euphoria 110 Mono" filters="currency=EUR"]',
					'condition' => [
						'dh_product_comparition_sustainability_score_custom_type' => 'shortcode',
					],
				] );
            // $repeater->add_control( 'dh_product_comparition_sustainability_score_last_updated_text', [
            //    'label' => __( 'Last Updated Text', 'duurzaamthuis' ),
            //    'type' => Elementor\Controls_Manager::TEXT,
            //    'label_block' => true,
				// 	'condition' => [
				// 		'dh_product_comparition_sustainability_score_custom_type' => 'shortcode',
				// 	],
            // ] );
				$repeater->add_control( 'dh_product_comparition_sustainability_score_button_image', [
               'label' => __( 'Logo', 'duurzaamthuis' ),
               'type' => Elementor\Controls_Manager::MEDIA,
					'condition' => [
						'dh_product_comparition_sustainability_score_custom_type' => 'button',
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
	public static function get_dh_video_controls( $widget ) {
		$widget->start_controls_section( 'dh_video_section_content', [
         'label' => __( 'Video', 'duurzaamthuis' ),
         'tab' => Elementor\Controls_Manager::TAB_CONTENT,
      ] );
			$widget->add_control( 'dh_video_link', [
				'label' => __( 'YouTube video link', 'duurzaamthuis' ),
				'type' => Elementor\Controls_Manager::TEXT,
			] );
			$widget->add_control( 'dh_video_show_title',[
            'label' => __( 'Show video title', 'duurzaamthuis' ),
            'type' => Elementor\Controls_Manager::SWITCHER,
            'label_on' => __( 'Yes', 'duurzaamthuis' ),
            'label_off' => __( 'No', 'duurzaamthuis' ),
            'default' => 'yes',
            'return_value' => 'yes',
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




function change_heading_widget_content2( $widget_content, $widget ) {

	$widgets = [
		'dh-product-comparition-sustainability-score',
		'dh-product-comparition',
		'dh-author-box',
		'dh-company-offer',
		'dh-impact',
		'dh-product-review',
		'dh-mega-menu',
		'dh-page-header',
		'dh-menu-tree-navigation',
	];

	if ( in_array( $widget->get_name(), $widgets ) ) {
		$paths = array(
			'info' => [
				'path' => '<path d="M16 515.999c0-271.69 220.255-492 492-492 271.693 0 492 220.307 492 492 0 271.75-220.307 492-492 492-271.741 0-492-220.256-492-492zM508 119.999c-218.719 0-396 177.322-396 396 0 218.726 177.277 396 396 396 218.675 0 396-177.28 396-396 0-218.675-177.325-396-396-396zM507.75 438.091c26.51 0 48 21.491 48 48v212.11c0 26.509-21.49 48-48 48s-48-21.491-48-48v-212.11c0-26.509 21.491-48 48-48zM443.76 333.792c0-35.347 28.653-64 64-64h0.48c35.346 0 64 28.653 64 64s-28.654 64-64 64h-0.48c-35.347 0-64-28.654-64-64z"></path>',
				'width' => '1024',
			],
			'benefit' => [
				'path' => '<path d="M1022.234 14.382c-3.584-8.703-12.102-14.383-21.504-14.383-903.215 0-1000.73 374.319-1000.73 535.272 0 57.903 12.847 111.992 38.215 160.721 3.91 7.539 11.636 12.333 20.108 12.525 8.005-0.237 16.431-4.237 20.666-11.642 60.975-105.377 233.658-365.474 518.844-503.666 11.684-5.585 25.647-0.792 31.185 10.707 5.586 11.59 0.744 25.553-10.797 31.139-21.504 10.427-42.17 21.784-62.418 33.558-7.725 4.515-15.22 9.31-22.806 14.010-11.404 7.076-22.667 14.289-33.652 21.738-10.938 7.355-21.738 14.895-32.35 22.621-3.305 2.419-6.468 4.887-9.729 7.355-283.835 211.501-457.263 548.907-457.263 666.392 0 12.845 10.427 23.27 23.273 23.27s23.273-10.426 23.273-23.27c0-37.517 25.554-113.568 73.913-204.288 70.191 57.389 164.632 87.923 275.178 87.923 298.87 0 361.475-284.393 395.075-437.201 45.242-205.639 144.806-325.772 226.445-407.459 6.707-6.657 8.659-16.619 5.075-25.322z"></path>',
				'width' => '1024',
			],
			'check' => [
				'path' => '<path d="M1352.693 33.324c44.43 44.433 44.43 116.473 0 160.907l-796.441 796.444c-21.338 21.337-50.277 33.324-80.453 33.324s-59.116-11.988-80.453-33.324l-362.020-362.020c-44.433-44.434-44.433-116.473 0-160.907 44.433-44.432 116.473-44.432 160.906 0l281.567 281.568 715.99-715.992c44.43-44.433 116.474-44.433 160.905 0z"></path>',
				'width' => '1479',
			],
			'times' => [
				'path' => '<path d="M990.676 33.324c44.432 44.433 44.432 116.473 0 160.906l-796.444 796.444c-44.434 44.432-116.474 44.432-160.906 0-44.433-44.434-44.433-116.473 0-160.907l796.444-796.444c44.434-44.433 116.473-44.433 160.907 0zM33.325 33.324c44.433-44.433 116.473-44.433 160.906 0l796.444 796.444c44.432 44.434 44.432 116.473 0 160.907-44.434 44.432-116.473 44.432-160.907 0l-796.444-796.444c-44.433-44.434-44.433-116.474 0-160.906z"></path>',
				'width' => '1024',
			],
			'arrow-up' => [
				'path' => '<path d="M481.83 332.496c16.662-16.662 43.678-16.662 60.34 0l298.665 298.668c16.663 16.663 16.663 43.674 0 60.336s-43.674 16.663-60.336 0l-268.498-268.495-268.497 268.495c-16.662 16.663-43.678 16.663-60.34 0s-16.662-43.674 0-60.336l298.667-298.668z"></path>',
				'width' => '1024',
			],
			'arrow-down' => [
				'path' => '<path d="M481.83 691.501c16.662 16.663 43.678 16.663 60.34 0l298.665-298.665c16.663-16.662 16.663-43.678 0-60.34s-43.674-16.662-60.336 0l-268.498 268.495-268.497-268.495c-16.662-16.662-43.678-16.662-60.34 0s-16.662 43.678 0 60.34l298.667 298.665z"></path>',
				'width' => '1024',
			],
			'arrow-right' => [
				'path' => '<path d="M691.502 542.169c16.663-16.662 16.663-43.678 0-60.34l-298.665-298.667c-16.662-16.662-43.678-16.662-60.34 0s-16.662 43.678 0 60.34l268.495 268.497-268.495 268.498c-16.662 16.663-16.662 43.674 0 60.336s43.678 16.663 60.34 0l298.665-298.665z"></path>',
				'width' => '1024',
			],
			'arrow-left' => [
				'path' => '<path d="M332.497 542.169c-16.662-16.662-16.662-43.678 0-60.34l298.668-298.667c16.663-16.662 43.674-16.662 60.336 0s16.663 43.678 0 60.34l-268.495 268.497 268.495 268.498c16.663 16.663 16.663 43.674 0 60.336s-43.674 16.663-60.336 0l-298.668-298.665z"></path>',
				'width' => '1024',
			],
			'facebook-f-brands' => [
				'path' => '<path d="M558.28 575.999l28.44-185.32h-177.82v-120.26c0-50.7 24.84-100.12 104.48-100.12h80.84v-157.78s-73.36-12.52-143.5-12.52c-146.44 0-242.16 88.76-242.16 249.44v141.24h-162.78v185.32h162.78v448h200.34v-448z"></path>',
				'width' => '640',
			],
			'instagram-brands' => [
				'path' => '<path d="M448.2 281.999c-127.2 0-229.8 102.6-229.8 229.8s102.6 229.8 229.8 229.8 229.8-102.6 229.8-229.8-102.6-229.8-229.8-229.8zM448.2 661.199c-82.2 0-149.4-67-149.4-149.4s67-149.4 149.4-149.4 149.4 67 149.4 149.4-67.2 149.4-149.4 149.4zM741 272.599c0 29.8-24 53.6-53.6 53.6-29.8 0-53.6-24-53.6-53.6s24-53.6 53.6-53.6 53.6 24 53.6 53.6zM893.2 326.999c-3.4-71.8-19.8-135.4-72.4-187.8-52.4-52.4-116-68.8-187.8-72.4-74-4.2-295.8-4.2-369.8 0-71.6 3.4-135.2 19.8-187.8 72.2s-68.8 116-72.4 187.8c-4.2 74-4.2 295.8 0 369.8 3.4 71.8 19.8 135.4 72.4 187.8s116 68.8 187.8 72.4c74 4.2 295.8 4.2 369.8 0 71.8-3.4 135.4-19.8 187.8-72.4 52.4-52.4 68.8-116 72.4-187.8 4.2-74 4.2-295.6 0-369.6zM797.6 775.999c-15.6 39.2-45.8 69.4-85.2 85.2-59 23.4-199 18-264.2 18s-205.4 5.2-264.2-18c-39.2-15.6-69.4-45.8-85.2-85.2-23.4-59-18-199-18-264.2s-5.2-205.4 18-264.2c15.6-39.2 45.8-69.4 85.2-85.2 59-23.4 199-18 264.2-18s205.4-5.2 264.2 18c39.2 15.6 69.4 45.8 85.2 85.2 23.4 59 18 199 18 264.2s5.4 205.4-18 264.2z"></path>',
				'width' => '896',
			],
			'linkedin-in-brands' => [
				'path' => '<path d="M200.56 895.999h-185.76v-598.2h185.76zM107.58 216.199c-59.4 0-107.58-49.2-107.58-108.6 0-59.415 48.165-107.58 107.58-107.58s107.58 48.165 107.58 107.58v0c0 59.4-48.2 108.6-107.58 108.6zM895.8 895.999h-185.36v-291.2c0-69.4-1.4-158.4-96.58-158.4-96.58 0-111.38 75.4-111.38 153.4v296.2h-185.56v-598.2h178.16v81.6h2.6c24.8-47 85.38-96.6 175.76-96.6 188 0 222.56 123.8 222.56 284.6v328.6z"></path>',
				'width' => '896',
			],
			'pinterest-p-brands' => [
				'path' => '<path d="M408 12.999c-205.2 0-408 136.8-408 358.2 0 140.8 79.2 220.8 127.2 220.8 19.8 0 31.2-55.2 31.2-70.8 0-18.6-47.4-58.2-47.4-135.6 0-160.8 122.4-274.8 280.8-274.8 136.2 0 237 77.4 237 219.6 0 106.2-42.6 305.4-180.6 305.4-49.8 0-92.4-36-92.4-87.6 0-75.6 52.8-148.8 52.8-226.8 0-132.4-187.8-108.4-187.8 51.6 0 33.6 4.2 70.8 19.2 101.4-27.6 118.8-84 295.8-84 418.2 0 37.8 5.4 75 9 112.8 6.8 7.6 3.4 6.8 13.8 3 100.8-138 97.2-165 142.8-345.6 24.6 46.8 88.2 72 138.6 72 212.4 0 307.8-207 307.8-393.6 0-198.6-171.6-328.2-360-328.2z"></path>',
				'width' => '768',
			],
			'twitter-brands' => [
				'path' => '<path d="M918.74 303.431c0.65 9.096 0.65 18.194 0.65 27.29 0 277.44-211.166 597.116-597.116 597.116-118.904 0-229.36-34.438-322.274-94.212 16.894 1.948 33.136 2.598 50.68 2.598 98.11 0 188.426-33.136 260.548-89.664-92.264-1.95-169.584-62.376-196.224-145.544 12.996 1.948 25.99 3.248 39.636 3.248 18.842 0 37.686-2.6 55.228-7.146-96.162-19.494-168.286-103.96-168.286-205.97v-2.598c27.938 15.594 60.428 25.34 94.862 26.638-56.528-37.686-93.562-102.010-93.562-174.782 0-38.984 10.394-74.72 28.588-105.908 103.31 127.35 258.6 210.516 432.73 219.614-3.248-15.594-5.198-31.836-5.198-48.080 0-115.656 93.564-209.868 209.868-209.868 60.426 0 115.004 25.34 153.34 66.274 47.43-9.096 92.912-26.64 133.198-50.68-15.596 48.732-48.732 89.666-92.264 115.654 42.234-4.546 83.168-16.244 120.852-32.486-28.584 41.582-64.322 78.616-105.256 108.506z"></path>',
				'width' => '1024',
			],
			'youtube-brands' => [
				'path' => '<path d="M1099.31 248.165c-12.562-47.3-49.574-84.552-96.568-97.194-85.18-22.972-426.742-22.972-426.742-22.972s-341.56 0-426.742 22.972c-46.994 12.644-84.006 49.894-96.568 97.194-22.824 85.734-22.824 264.61-22.824 264.61s0 178.876 22.824 264.61c12.562 47.3 49.574 83 96.568 95.642 85.182 22.972 426.742 22.972 426.742 22.972s341.56 0 426.742-22.972c46.994-12.642 84.006-48.342 96.568-95.642 22.824-85.734 22.824-264.61 22.824-264.61s0-178.876-22.824-264.61zM464.29 675.181v-324.812l285.478 162.41-285.478 162.402z"></path>',
				'width' => '1152',
			],
			'payback' => [
				'path' => '<path d="M879.283 973.125l-25.459-115.629c-1.446-6.797-5.082-11.891-10.912-15.27-6.304-3.398-12.608-3.872-18.906-1.446l-3.642 1.446-8.736 2.176c-3.885 0.96-8.371 2.061-13.459 3.27s-11.021 2.413-17.818 3.635c-6.765 1.21-13.949 2.31-21.446 3.277-7.512 0.954-15.62 1.811-24.355 2.547-8.737 0.717-17.455 1.082-26.189 1.082-61.58 0-116.979-16.602-166.186-49.811-49.215-33.222-85.458-78.195-108.728-134.912h281.446c5.344 0 10.191-1.818 14.54-5.459 4.379-3.629 7.046-8.109 7.996-13.459l17.454-81.458c1.462-7.252 0-13.807-4.351-19.63-4.848-5.823-10.923-8.737-18.186-8.737h-333.804c-1.455-32.968-1.455-58.421 0-76.364h354.909c13.104 0 20.852-6.298 23.277-18.904l17.453-82.911c1.446-6.787-0.23-13.084-5.094-18.906-4.346-5.818-10.406-8.74-18.163-8.74h-340.379c24.243-54.301 60.604-96.967 109.095-127.999 48.486-31.039 103.274-46.55 164.365-46.55 1.946-0.968 9.092-0.723 21.446 0.729 12.362 1.446 19.405 2.058 21.094 1.813 1.674-0.239 8.004 0.492 18.901 2.179 10.911 1.696 16.37 2.547 16.37 2.547l12.73 2.542c3.642 0.733 6.432 1.33 8.365 1.821l2.912 0.723c6.298 1.949 12.102 1.338 17.459-1.811 5.331-3.161 8.73-7.881 10.189-14.184l31.277-115.636c1.446-6.305 0.71-12.123-2.176-17.454-4.371-5.828-9.229-9.463-14.56-10.913-44.602-11.15-91.651-16.728-141.095-16.728-108.621 0-205.701 31.039-291.282 93.092-85.578 62.059-144.612 144.007-177.099 245.821h-71.267c-6.791 0-12.362 2.179-16.728 6.542-4.353 4.358-6.542 9.937-6.542 16.728v82.911c0 6.787 2.181 12.365 6.542 16.719 4.369 4.369 9.947 6.541 16.728 6.541h48.731c-1.465 23.28-1.697 48.721-0.733 76.372h-47.997c-6.302 0-11.756 2.3-16.362 6.906-4.603 4.604-6.908 10.060-6.908 16.354v82.189c0 6.31 2.305 11.75 6.908 16.371 4.608 4.602 10.059 6.886 16.362 6.886h69.094c30.545 107.155 88.248 192.378 173.097 255.642 84.855 63.296 184.008 94.918 297.457 94.918 9.221 0 18.55-0.224 28.008-0.73 9.476-0.486 18.308-1.222 26.554-2.176 8.236-0.96 16.364-2.042 24.364-3.264 7.994-1.216 15.27-2.413 21.811-3.642 6.547-1.203 12.73-2.413 18.541-3.622 5.824-1.222 11.034-2.541 15.648-4.006 4.608-1.44 8.467-2.534 11.629-3.251 3.155-0.73 5.702-1.594 7.629-2.547l3.648-0.73c5.331-1.939 9.453-5.459 12.358-10.56 2.912-5.056 3.629-10.522 2.176-16.339z"></path>',
				'width' => '1024',
			],
			'euro-sign-solid' => [
				'path' => '<path d="M621.412 827.529c-2.628-13.26-15.67-21.744-28.848-18.738-21.384 4.878-54.844 10.826-90.852 10.826-113.526 0-203.858-69.58-242.922-170.898h227.378c11.39 0 20.926-7.934 23.385-18.576l0.031-0.162 12.746-56.72c3.372-15.004-8.038-29.262-23.416-29.262h-268.474c-2.42-28.656-2.828-56.574 0.274-84.49h293.186c0 0 0.001 0 0.001 0 11.436 0 21.005-7.999 23.415-18.708l0.030-0.16 13.024-59.51c3.276-14.968-8.122-29.132-23.446-29.132h-276.556c41.266-89.982 125.38-150.060 235.238-150.060 28.972 0 57.128 4.5 75.702 8.29 12.432 2.536 24.694-4.996 28.004-17.246l23.982-88.736c3.644-13.482-4.93-27.232-18.652-29.834-24.208-4.59-63.222-10.414-105.372-10.414-194.368 0-351.21 120.504-409.12 288h-66.15c-13.254 0-24 10.746-24 24v59.51c0 13.254 10.746 24 24 24h43.138c-2.018 27.214-2.362 58.574-0.362 84.49h-42.776c-13.254 0-24 10.746-24 24v56.72c0 13.254 10.746 24 24 24h60.228c50.050 180.664 206.3 311.28 415.042 311.28 52.602 0 97.124-9.088 122.202-15.576 12.334-3.19 20.054-15.416 17.576-27.914l-17.636-88.98z"></path>',
				'width' => '640',
			],
			'clock-solid' => [
				'path' => '<path d="M512 15.999c-274 0-496 222-496 496s222 496 496 496 496-222 496-496-222-496-496-496zM696.98 641.999v0l-40 50c-5.914 7.349-14.907 12.012-24.99 12.012-7.592 0-14.566-2.644-20.052-7.060l0.062 0.048-134-99.44c-18.355-14.784-30-37.257-30-62.45 0-0.004 0-0.007 0-0.011v0.001-311.1c0-17.673 14.327-32 32-32v0h64c17.673 0 32 14.327 32 32v0 288l116 85c7.348 5.914 12.010 14.906 12.010 24.988 0 7.601-2.65 14.584-7.078 20.073l0.048-0.061z"></path>',
				'width' => '1024',
			],
			'chevron-circle-down-solid' => [
				'path' => '<path d="M1008 511.999c0 274-222 496-496 496s-496-222-496-496 222-496 496-496 496 222 496 496zM546 739.799l271-271c18.8-18.8 18.8-49.2 0-67.8l-34-34c-18.8-18.8-49.2-18.8-67.8 0l-203.2 203.2-203.2-203.2c-18.8-18.8-49.2-18.8-67.8 0l-34 34c-18.8 18.8-18.8 49.2 0 67.8l271 271c18.8 18.8 49.2 18.8 68 0z"></path>',
				'width' => '1024',
			],
			'convenience' => [
				'path' => '<path d="M896 127.999h-42.662v-85.336c0-23.547-19.117-42.664-42.675-42.664h-42.662c-23.552 0-42.662 19.117-42.662 42.664v85.336h-426.673v-85.336c0-23.547-19.11-42.664-42.664-42.664h-42.664c-23.555 0-42.671 19.117-42.671 42.664v85.336h-42.664c-70.57 0-128 57.43-128 128v640c0 70.573 57.43 128 128 128h768c70.573 0 128-57.427 128-128v-640c0-70.57-57.427-128-128-128zM938.662 895.999c0 23.507-19.155 42.662-42.662 42.662h-768c-23.508 0-42.664-19.155-42.664-42.662v-467.625h853.327v467.625zM753.843 523.801c18.048 16.483 18.963 44.097 2.042 61.679l-224.001 232.727c-8.47 8.8-20.3 13.792-32.684 13.792s-24.214-4.992-32.684-13.792l-134.399-139.635c-16.922-17.581-16.008-45.197 2.042-61.68s46.402-15.592 63.324 1.99l101.716 105.681 191.315-198.771c16.922-17.582 45.274-18.472 63.328-1.99z"></path>',
				'width' => '1024',
			],
			'subsidy' => [
				'path' => '<path d="M268.625 268.679v64.242c11.25-6.444 17.967-17.838 19.791-28.678 1.312-7.82 1.85-26.45-19.791-35.564zM217.977 183.719c-1.598 8.478 0.424 16.354 5.154 20.062 1.666 1.306 3.502 2.59 5.469 3.852v-41.824c-6.102 4.68-9.466 11.766-10.623 17.91zM250-0.001c-137.85 0-250 112.15-250 250s112.15 250 250 250c137.85 0 250-112.15 250-250s-112.15-250-250-250zM327.858 310.871c-4.706 27.99-26.006 56.376-59.238 64.806v14.322c0 11.044-8.956 20-20 20s-20-8.956-20-20v-12.404c-16.148-1.396-29.534-5.758-48.51-18.172-9.244-6.046-11.834-18.442-5.788-27.686 6.044-9.242 18.442-11.838 27.686-5.788 10.8 7.064 17.574 10.128 26.612 11.4v-84.461c-12.774-5.854-22.322-11.489-30.156-17.635-16.598-13.018-24.176-35.602-19.778-58.944 4.792-25.436 22.498-45.674 46.204-52.813 1.256-0.378 2.498-0.724 3.73-1.052v-12.444c0-11.044 8.956-20 20-20s20 8.956 20 20v10.254c19.418 3.362 33.142 12.922 39.79 20.554 7.256 8.328 6.384 20.963-1.944 28.216-8.284 7.214-20.826 6.398-28.102-1.81-0.456-0.462-3.634-3.522-9.744-5.776v64.624c3.55 1.318 7.098 2.596 10.58 3.828 35.156 12.426 54.71 44.972 48.658 80.982zM999.021 444.423l-104.314-17.716c-13.107-20.378-28.576-39.162-46.202-56.088 10.138-50.678 37.44-95.756 77.939-128.156l6.298-5.036c9.946-7.958 13.786-21.334 9.568-33.358s-15.571-20.070-28.314-20.070h-80c-70.784 0-135.565 40.022-168.064 101.724-10.765-1.146-21.446-1.724-31.933-1.724h-75.872c-16.988 154.998-148.682 276-308.128 276-87.102 0-165.912-36.122-222.28-94.156-18.128 39.932-27.72 83.584-27.72 128.156 0 95.786 44.58 186.128 120 244.746v155.251c0 16.57 13.432 30.003 30 30.003h120c12.912 0 24.376-8.262 28.46-20.512l33.164-99.488h280.755l33.164 99.488c4.083 12.25 15.546 20.512 28.454 20.512h120c16.57 0 30.003-13.434 30.003-30.003v-155.245c41.254-32.045 73.517-73.677 94.285-121.702l86.982-35.245c11.322-4.589 18.733-15.584 18.733-27.802v-180.003c0-14.63-10.554-27.126-24.979-29.576zM764 513.999c-16.57 0-29.997-13.432-29.997-30s13.427-30 29.997-30c16.57 0 29.997 13.432 29.997 30s-13.427 30-29.997 30z"></path>',
				'width' => '1024',
			],
			'price' => [
				'path' => '<path d="M1017.741 411.563l-85.331-85.333c-4.013-4.010-9.434-6.23-15.104-6.23h-21.331v-21.334c0-5.674-2.266-11.094-6.234-15.104l-170.662-170.664c-34.221-34.216-91.562-91.559-207.103-91.559-115.455 0-168.404 52.949-207.102 91.561-6.102 6.102-7.936 15.274-4.608 23.254 3.286 7.978 11.094 13.184 19.712 13.184 172.072 0 191.998 73.045 191.998 127.999 0 45.653-25.856 80.425-42.368 98.132l139.391 139.391c37.715-25.514 91.302-55.637 116.307-53.418v29.226c0 5.674 2.266 11.094 6.234 15.104l106.662 106.665c4.013 3.968 9.434 6.23 15.104 6.23h0.73c5.926-0.17 11.475-2.816 15.315-7.254l149.331-170.664c7.424-8.492 6.995-21.206-0.941-29.185zM32.256 812.242c-20.778 20.781-32.256 48.422-32.256 80.339 0 60.71 49.365 110.080 110.079 110.080 30.934 0 60.629-13.146 81.449-36.013l385.192-423.715-137.556-137.599-406.907 406.908z"></path>',
				'width' => '1024',
			],
			'user' => [
				'path' => '<path d="M824.268 822.776c0.745-41.735-15.651-81.98-44.716-111.79-27.575-27.575-62.603-47.697-99.866-58.876-40.99-12.67-82.725-21.613-124.46-25.339-47.697-4.472-95.394-6.707-143.092-6.707-46.952 0-94.649 2.236-141.601 6.707-42.48 3.726-84.215 11.924-124.46 24.594-38.009 11.179-72.291 31.301-100.611 58.876-29.066 29.811-45.461 69.31-45.461 111.045s16.396 81.234 44.716 111.79c28.32 26.83 62.603 47.697 100.611 58.876 40.245 12.67 81.98 20.868 124.46 25.339 47.697 4.472 95.394 6.707 142.346 6.707 47.697 0 95.394-2.236 142.346-6.707 42.48-3.726 84.215-11.924 124.46-25.339 38.009-10.434 72.291-30.556 101.357-58.876 28.32-29.811 44.716-69.31 43.971-110.3zM712.477 822.776c0.745 11.924-4.472 23.849-12.67 32.792-14.905 13.415-33.537 23.849-53.659 29.811-32.792 10.434-67.074 17.141-102.102 20.122-43.971 4.472-87.942 6.707-131.913 6.707s-87.942-2.236-131.167-6.707c-35.028-2.981-69.31-9.689-102.847-20.868-20.122-5.962-38.754-16.396-53.659-30.556-8.198-8.943-12.67-20.868-12.67-32.792s4.472-23.103 12.67-32.047c15.651-14.16 33.537-24.594 53.659-30.556 33.537-10.434 67.82-17.886 102.847-20.868 43.971-4.472 87.942-5.962 131.167-5.962 43.971 0 87.942 1.491 131.913 5.962 35.028 3.726 69.31 10.434 102.847 21.613 20.122 5.217 38.009 15.651 53.659 30.556 8.198 8.943 12.67 20.122 11.924 32.792zM410.643 563.423c0 0 0 0 0 0h1.491c0 0 0 0 0 0 75.272 0 146.818-29.811 199.732-82.725 52.169-52.914 81.98-124.46 81.98-198.987s-29.811-146.073-81.98-198.987c-52.914-52.914-124.46-82.725-199.732-82.725-74.527 0-146.073 29.811-198.987 82.725s-81.98 124.46-81.98 198.987v0.745c0 0 0 0 0 0 0 74.527 29.066 145.328 81.234 198.242 52.914 52.914 123.715 81.98 198.242 82.725zM236.996 282.456v-0.745c0 0 0 0 0 0 0-46.207 18.632-90.923 51.424-123.715s77.508-51.424 123.715-51.424c46.952 0 90.923 18.632 124.46 51.424 32.792 32.792 50.678 77.508 50.678 123.715s-17.886 90.923-50.678 123.715c-33.537 32.792-77.508 51.424-124.46 51.424h-1.491c-45.461 0-90.178-18.632-122.224-51.424-32.792-32.792-51.424-76.763-51.424-122.969z"></path>',
				'width' => '824',
			],
			'comments' => [
				'path' => '<path d="M1019.696 188.639c0-41.76-33.831-75.516-75.516-75.516h-755.162c-41.76 0-75.516 33.756-75.516 75.516v714.232c0 6.343 7.25 9.893 12.234 5.89l176.557-141.215h641.888c41.685 0 75.516-33.831 75.516-75.516v-503.391zM1132.743 188.79v502.938c0 50.596-19.634 98.171-55.127 133.664s-83.068 55.127-133.664 55.127h-601.864l-160.094 128.378-22.655 8.307c-12.083 4.531-24.92 6.796-37.758 6.796-32.472 0-63.434-12.838-86.088-35.493s-35.493-53.617-35.493-85.333c0 0 0 0 0 0v-714.383c0-50.596 20.389-98.171 55.127-133.664 35.493-35.493 83.823-55.127 133.664-55.127h755.162c50.596 0 98.171 19.634 133.664 55.127s55.127 83.068 55.127 133.664z"></path>',
				'width' => '1133',
			],
			'clock' => [
				'path' => '<path d="M511.994 115.832c-218.827 0-396.191 177.363-396.191 396.191 0 218.826 177.363 396.191 396.191 396.191s396.191-177.366 396.191-396.191c0-218.827-177.365-396.191-396.191-396.191zM6.089 512.022c0-279.422 226.484-505.905 505.905-505.905 279.419 0 505.906 226.483 505.906 505.905 0 279.419-226.487 505.906-505.906 505.906-279.421 0-505.905-226.487-505.905-505.906zM495.491 254.628c30.297 0 54.857 24.561 54.857 54.857v205.198l157.078 93.706c26.021 15.522 34.528 49.197 19.007 75.215s-49.197 34.529-75.216 19.007l-183.831-109.665c-16.591-9.898-26.753-27.792-26.753-47.111v-236.349c0-30.297 24.561-54.857 54.857-54.857z"></path>',
				'width' => '1024',
			],
			'star' => [
				'path' => '<path d="M536.129 1.509c15.401 0 29.466 8.744 36.283 22.554l143.442 290.657 320.764 46.609c15.24 2.214 27.902 12.89 32.66 27.536 4.759 14.648 0.79 30.726-10.238 41.476l-232.108 226.25 54.799 319.428c2.603 15.179-3.636 30.52-16.094 39.572-12.46 9.053-28.977 10.249-42.61 3.083l-286.899-150.801-286.894 150.801c-13.633 7.166-30.15 5.97-42.61-3.083s-18.698-24.393-16.094-39.572l54.801-319.428-232.11-226.25c-11.028-10.75-14.997-26.828-10.238-41.476 4.759-14.646 17.421-25.322 32.662-27.536l320.765-46.609 143.435-290.657c6.815-13.811 20.882-22.555 36.283-22.555z"></path>',
				'width' => '1071',
			],
			'thermostat' => [
				'path' => '<path d="M261.864 814.54c10.356 0 20.481-3.066 29.092-8.819s15.322-13.933 19.286-23.501c3.964-9.568 5-20.096 2.98-30.259-2.020-10.157-7.007-19.488-14.331-26.81s-16.653-12.307-26.811-14.33c-10.157-2.022-20.686-0.986-30.255 2.982-9.568 3.962-17.746 10.675-23.5 19.283-5.754 8.614-8.825 18.733-8.825 29.094 0 13.888 5.517 27.206 15.337 37.024s23.139 15.334 37.027 15.334zM418.909 552.726v-395.636c0-41.663-16.55-81.62-46.010-111.080s-69.418-46.011-111.080-46.011c-41.663 0-81.62 16.551-111.080 46.011s-46.011 69.417-46.011 111.080v395.636c-43.961 32.971-76.433 78.938-92.818 131.388-16.385 52.454-15.851 108.73 1.526 160.858 17.377 52.134 50.716 97.478 95.295 129.606s98.137 49.421 153.088 49.421c54.951 0 108.509-17.293 153.088-49.421s77.917-77.472 95.295-129.606c17.377-52.128 17.911-108.403 1.526-160.858-16.385-52.451-48.858-98.417-92.819-131.388zM314.182 157.090v456.954c34.938 12.353 64.384 36.656 83.134 68.624 18.75 31.962 25.597 69.523 19.331 106.048s-25.243 69.658-53.576 93.542c-28.332 23.885-64.196 36.986-101.253 36.986s-72.921-13.101-101.254-36.986c-28.332-23.885-47.308-57.018-53.575-93.542s0.58-74.086 19.331-106.048c18.75-31.968 48.196-56.271 83.134-68.624v-456.954c0-13.888 5.517-27.207 15.337-37.027s23.139-15.337 37.027-15.337c13.887 0 27.206 5.517 37.027 15.337s15.337 23.139 15.337 37.027z"></path>',
				'width' => '512',
			],
			'menu' => [
				'path' => '<path d="M60-0.001h1152v128h-1152v-128zM60 447.999h1152v128h-1152v-128zM60 895.999h1152v128h-1152v-128z"></path>',
				'width' => '1216',
			],
			'plug' => [
				'path' => '<path d="M146.285-0.001c-12.932 0-25.335 5.137-34.479 14.282s-14.282 21.547-14.282 34.48v97.524c0 12.932 5.137 25.336 14.282 34.48s21.547 14.282 34.479 14.282c12.932 0 25.336-5.137 34.48-14.282s14.282-21.548 14.282-34.48v-97.524c0-12.932-5.137-25.335-14.282-34.48s-21.548-14.282-34.48-14.282zM97.524 341.332h390.095v97.524c0 51.73-20.55 101.341-57.128 137.92s-86.189 57.128-137.919 57.128c-51.73 0-101.341-20.55-137.919-57.128s-57.128-86.19-57.128-137.92v-97.524zM341.333 727.378c68.181-11.52 130.077-46.822 174.708-99.64 44.631-52.816 69.112-119.733 69.102-188.882v-195.048h-585.143v195.048c-0.011 69.149 24.471 136.066 69.102 188.882 44.631 52.818 106.526 88.12 174.707 99.64v247.859c0 12.934 5.138 25.338 14.282 34.477 9.145 9.146 21.548 14.285 34.48 14.285s25.335-5.139 34.48-14.285c9.144-9.139 14.282-21.542 14.282-34.477v-247.859zM390.095 48.761c0-12.932 5.137-25.335 14.282-34.48s21.548-14.282 34.48-14.282c12.932 0 25.336 5.137 34.48 14.282s14.282 21.547 14.282 34.48v97.524c0 12.932-5.138 25.336-14.282 34.48s-21.548 14.282-34.48 14.282c-12.932 0-25.335-5.137-34.48-14.282s-14.282-21.548-14.282-34.48v-97.524z"></path>',
				'width' => '640',
			],
			'recycle' => [
				'path' => '<path d="M776.762 208.494l-43.923 163.92c-2.739 10.198-8.762 19.209-17.139 25.64s-18.637 9.924-29.197 9.94c-4.205 0.005-8.384-0.547-12.442-1.64l-163.92-43.92c-6.17-1.556-11.968-4.323-17.058-8.141s-9.371-8.609-12.593-14.095c-3.222-5.487-5.32-11.559-6.174-17.864s-0.446-12.717 1.201-18.863c1.647-6.146 4.499-11.903 8.39-16.937s8.745-9.244 14.278-12.385c5.533-3.141 11.636-5.151 17.953-5.912s12.722-0.26 18.844 1.476l53.919 14.44-101.72-176.16c-2.107-3.647-5.137-6.674-8.784-8.779s-7.785-3.213-11.996-3.213c-4.211 0-8.348 1.108-11.996 3.213s-6.676 5.132-8.784 8.779l-99.3 172c-6.365 11.025-16.849 19.070-29.146 22.365s-25.398 1.571-36.424-4.795c-11.025-6.365-19.070-16.849-22.365-29.146s-1.571-25.399 4.795-36.424l99.3-172c10.532-18.241 25.681-33.388 43.923-43.919s38.934-16.075 59.997-16.075c21.064 0 41.756 5.544 59.997 16.075s33.39 25.678 43.923 43.919l100.297 173.72 13.421-50.060c3.443-12.131 11.52-22.42 22.483-28.644s23.942-7.885 36.122-4.622c12.179 3.263 22.586 11.187 28.966 22.060 6.387 10.873 8.237 23.821 5.152 36.047zM916.819 779.993c-10.432 18.33-25.562 33.549-43.821 44.090-18.266 10.547-39.008 16.038-60.096 15.91h-196.541l38.058 38.061c4.518 4.448 8.109 9.741 10.573 15.578 2.458 5.837 3.738 12.109 3.763 18.445s-1.203 12.614-3.616 18.47c-2.413 5.862-5.958 11.187-10.438 15.667s-9.805 8.026-15.665 10.438c-5.859 2.413-12.138 3.642-18.474 3.616s-12.605-1.306-18.444-3.763c-5.839-2.464-11.133-6.054-15.577-10.573l-120.001-120c-8.991-9.005-14.040-21.21-14.040-33.939 0-12.723 5.050-24.928 14.040-33.939l120.001-119.998c9.027-8.881 21.196-13.835 33.859-13.784s24.79 5.105 33.744 14.059c8.954 8.952 14.010 21.080 14.061 33.745s-4.902 24.832-13.786 33.856l-38.058 38.061h196.541c4.211 0 8.352-1.107 12-3.213 3.648-2.112 6.675-5.139 8.781-8.787s3.213-7.789 3.213-12c0-4.211-1.107-8.352-3.213-12l-99.302-171.997c-3.29-5.463-5.459-11.527-6.374-17.837-0.922-6.311-0.576-12.741 1.018-18.916s4.403-11.97 8.262-17.048c3.859-5.077 8.691-9.335 14.214-12.524s11.622-5.245 17.952-6.050c6.323-0.804 12.749-0.339 18.893 1.366s11.885 4.62 16.896 8.57c5.005 3.951 9.171 8.859 12.262 14.438l99.315 171.997c10.65 18.208 16.262 38.912 16.262 60s-5.613 41.798-16.262 60zM370.417 791.993c-0.017 12.73-5.080 24.928-14.078 33.926s-21.197 14.061-33.922 14.074h-202.42c-21.064 0-41.757-5.542-59.999-16.077s-33.39-25.683-43.922-43.923c-10.532-18.24-16.076-38.938-16.076-60s5.545-41.754 16.077-60l100.44-173.959-45.68 12.241c-12.226 3.084-25.174 1.234-36.047-5.151s-18.797-16.791-22.060-28.97c-3.263-12.179-1.602-25.153 4.622-36.118s16.514-19.041 28.644-22.482l163.92-43.919c6.088-1.636 12.439-2.056 18.689-1.235s12.278 2.866 17.738 6.018c5.459 3.153 10.243 7.35 14.079 12.353s6.648 10.713 8.275 16.804l43.94 163.92c1.631 6.089 2.047 12.44 1.224 18.691s-2.87 12.276-6.022 17.736c-6.367 11.025-16.853 19.069-29.151 22.364s-25.401 1.568-36.426-4.799c-11.025-6.367-19.069-16.852-22.364-29.151l-15.62-58.3-105.060 181.959c-2.106 3.648-3.215 7.789-3.215 12s1.108 8.352 3.215 12c2.106 3.648 5.135 6.675 8.783 8.787 3.647 2.106 7.786 3.213 11.998 3.213h202.42c12.725 0.019 24.924 5.082 33.922 14.080s14.061 21.197 14.078 33.92z"></path>',
				'width' => '960',
			],
			'home' => [
				'path' => '<path d="M397.506 76.954c66.653-52.831 161.27-52.831 227.923 0l0.113 0.089 280.404 223.619c36.845 28.351 58.829 71.899 59.462 118.428l0.013 0.655-0.006 372.221c0 107.981-88.282 194.694-196.173 194.694l-83.2-0.013c-54.175-1.254-98.211-45.235-98.204-100 0-0.006 0 0.006 0 0v-131.251c0-6.477-5.438-12.55-13.159-12.55h-122.922c-7.627 0.102-12.966 6.131-12.966 12.55v130.848c0 4.192-0.538 8.262-1.548 12.134-6.040 50.080-48.995 88.282-100.223 88.282h-82.093c-107.889 0-196.177-86.714-196.177-194.694v-372.289c0.46-46.627 22.482-90.303 59.477-118.614l279.279-224.111zM342.791 877.356v-121.958c-0.001-60.109 48.877-108.154 108.429-108.55h123.459c59.834 0 109.161 48.147 109.161 108.55v131.251c0 1.683 1.427 3.821 4.147 4.013h81.254c55.782 0 100.173-44.64 100.173-98.694v-371.842c-0.314-16.931-8.378-32.966-22.176-43.505l-0.794-0.619-280.648-223.814c-0.017-0.014-0.035-0.028-0.052-0.041-31.683-25.075-76.81-25.087-108.507-0.038l-280.453 225.030c-13.781 10.442-21.807 26.428-22.035 43.288v371.541c0 54.054 44.394 98.694 100.177 98.694h82.093c3.192 0 4.95-2.432 4.95-4.416 0-3.034 0.282-6.010 0.821-8.89z"></path>',
				'width' => '1024',
			],
			'hummer' => [
				'path' => '<path d="M460.651 115.212c51.075 16.894 87.615 46.376 106.568 87.596 22.408 48.735 13.817 100.522-9.479 141.838l73.22 74.629c16.815-9.773 33.475-16.669 48.579-20.772 12.704-3.452 28.173-5.997 43.264-3.898 7.405 1.030 19.168 3.775 30.208 12.289 12.979 10.014 21.901 25.905 21.901 44.53 0 3.471-0.083 6.774-0.25 9.927l63.539 53.921 65.344-65.695-61.082-67.555c-5.626 1.101-11.379 1.692-17.184 1.567-10.47-0.225-23.123-2.84-34.886-10.998-12.058-8.361-19.136-19.735-22.771-30.369-5.67-16.58-3.526-32.531-1.427-42.078-40.23-49.848-100.371-112.278-187.908-178.282-35.834-27.019-71.746-26.099-107.359-11.319-3.465 1.437-6.893 3-10.277 4.668zM556.747 486.491l-62.769-63.978-379.913 427.393c-13.149 16.557-14.841 28.96-14.137 36.48 0.774 8.262 5.042 16.902 13.396 24.25 17.087 15.034 42.169 17.958 61.53 3.782l381.893-427.927zM660.218 520.77l-416.494 466.698-2.876 2.387c-63.126 52.41-144.527 39.13-193.234-3.718-24.908-21.914-43.555-53.216-47.033-90.349-3.536-37.754 9.116-75.923 36.764-110.048 0.481-0.595 0.975-1.178 1.482-1.747l416.155-468.161c0.622-0.699 1.263-1.381 1.923-2.044 23.221-23.345 27.666-51.644 19.738-68.884-7.044-15.319-35.677-46.128-134.516-46.128-19.179 0-36.66-11.052-44.968-28.431s-5.972-38.007 6.008-53.064c25.873-32.514 72.179-75.601 129.688-99.467 59.738-24.791 134.7-29.444 205.305 23.793 111.371 83.974 211.947 203.297 211.947 203.297 3.552 4.762-1.658 37.201 0 42.709 7.68 2.34 30.931-5.976 36.877 0l122.406 126.496c19.482 19.589 19.482 51.349 0 70.938l-133.050 133.761c-18.336 18.431-47.654 19.674-67.462 2.861 0 0-122.406-108.023-122.406-111.315s4.154-17.587 2.81-19.712c-6.15 3.689-22.618 24.667-29.062 30.129z"></path>',
				'width' => '1024',
			],
			'bag-of-cash' => [
				'path' => '<path d="M523.912 646.284h-120.936c7.122 36.174 20.227 62.739 39.315 79.697 19.373 16.575 42.306 24.87 68.801 24.87 19.373 0 37.891-4.335 55.553-13.005 17.949-9.039 35.042-23.545 51.281-43.52l21.367 33.915c-16.239 19.968-35.896 35.799-58.972 47.479s-47.576 17.517-73.501 17.517c-45.013 0-82.334-12.431-111.962-37.301-29.344-24.87-48.574-61.42-57.69-109.652h-44.016l4.273-39.565h34.614c-0.285-3.768-0.427-7.348-0.427-10.738 0-3.768 0-7.725 0-11.87s0-7.913 0-11.304c0-3.768 0.142-7.536 0.427-11.304h-34.614l4.273-39.565h35.469c4.558-23.738 11.68-44.651 21.367-62.738 9.686-18.463 21.651-33.912 35.896-46.347s30.483-21.855 48.716-28.26c18.233-6.406 38.033-9.609 59.4-9.609 25.925 0 50.425 5.84 73.501 17.521s42.734 27.507 58.972 47.477l-21.367 33.912c-16.239-19.97-33.332-34.289-51.28-42.955-17.663-9.043-36.181-13.565-55.553-13.565-24.786 0-46.58 8.478-65.382 25.435-18.518 16.956-31.338 43.332-38.46 79.129h133.756l-4.273 39.565h-134.183c-0.285 3.768-0.427 7.536-0.427 11.304 0 3.391 0 7.159 0 11.304s0 8.101 0 11.87c0 3.391 0.143 6.971 0.427 10.738h129.909l-4.273 39.565zM180.106-0.001h628.67l-16.916 57.689c-19.149 65.297-19.019 115.181-10.097 157.536 10.199 48.432 31.573 88.206 56.764 135.081 5.83 10.855 11.872 22.090 18.022 33.902 31.86 61.187 62.648 131.891 62.648 227.496 0 134.785-52.907 239.083-134.417 309.145-80.594 69.277-186.594 103.001-290.982 103.151s-210.445-33.266-291.096-102.516c-81.574-70.035-134.435-174.51-134.435-309.78 0-95.059 29.874-166.25 61.259-227.929 6.775-13.314 13.423-25.892 19.825-38.002 24.12-45.631 44.723-84.608 55.299-131.224 9.714-42.818 10.589-92.507-7.998-157.074l-16.546-57.475zM297.256 90.214c5.137 31.797 6.329 61.313 4.396 89.115h383.753c-1.531-27.762 0.046-57.278 5.492-89.115h-393.641zM702.058 269.545h-418.331c-14.761 45.021-36.338 85.645-56.118 122.882-5.807 10.932-11.459 21.572-16.738 31.947-28.751 56.504-51.513 112.825-51.513 187.329 0 110.072 42.118 189.33 103.014 241.616 61.819 53.084 145.722 80.589 231.293 80.466s169.531-27.88 231.406-81.067c60.958-52.401 103.031-131.557 103.031-241.015 0-74.446-23.245-129.933-52.511-186.144-4.902-9.41-10.11-19.043-15.456-28.929-20.574-38.071-43.173-79.884-58.077-127.085z"></path>',
				'width' => '1024',
			],
		);

		// $time = microtime( true );
		libxml_use_internal_errors(true); 

		$DOM = new DOMDocument();
		$DOM->loadHTML( mb_convert_encoding( $widget_content, 'HTML-ENTITIES', 'UTF-8' ) );
		$i_tags = $DOM->getElementsByTagName( 'i' );

		foreach ( $i_tags as $i_tag ) {
			$i_tag_classes = $i_tag->getAttribute('class');
			
			if ( strpos( $i_tag_classes, 'dh-icon' ) !== false ) {
				foreach ( explode( ' ', $i_tag_classes ) as $class ) {
					if ( strpos( $class, 'dh-icon-' ) !== false ) {
						$icon_name = str_replace( 'dh-icon-', '', $class );
					}
				}

				$svg = '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="' . ( $paths[$icon_name]['width'] / 1024 ) . 'em" height="1em" viewBox="0 0 ' . $paths[$icon_name]['width'] . ' 1024">' . ( $paths[$icon_name]['path'] ?? '' ) . '</svg>';
				$svg_fragment = $DOM->createDocumentFragment();
				$svg_fragment->appendXML( $svg );

				$i_tag->appendChild( $svg_fragment );

				$i_tag_classes .= ' svg-icon';
				$i_tag->setAttribute( 'class', $i_tag_classes );
			}
		}

		$widget_content = $DOM->saveHTML();
		// error_log( "time\n" . print_r( microtime( true ) - $time, true ) . "\n" );

	}


	return $widget_content;

}
add_filter( 'elementor/widget/render_content', 'change_heading_widget_content2', 10, 2 );


// reset video widget cache on page save
add_action( 'elementor/document/after_save', function( $instance, $data ) {
	$post_id = $instance->get_post()->ID;
	update_post_meta( $post_id, 'dh_page_video_cache', [] );
}, 10, 2 );