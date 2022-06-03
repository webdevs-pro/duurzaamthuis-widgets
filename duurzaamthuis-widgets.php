<?php
/**
 * Plugin Name: Duurzaamthuis Widgets
 * Description: Custom Elementor widgets
 * Plugin URI:  https://magnificsoft.com/
 * Version:     1.68
 * Author:      Alex Ischenko
 * Text Domain: duurzaamthuis
 */


if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
require_once ( ABSPATH . 'wp-admin/includes/plugin.php' );
define( 'DH_VERSION', get_plugin_data( __FILE__ )['Version'] );
define( 'DH_PLUGIN_DIR', dirname( __FILE__ ) ); // for php
define( 'DH_PLUGIN_DIR_URL', plugin_dir_url( __FILE__ ) ); // for assets


// includes
require_once ( DH_PLUGIN_DIR . '/inc/modules/dh-templates/dh-templates.php' );



final class Duurzaamthuis_Widgets {

	const MINIMUM_ELEMENTOR_VERSION = '3.4.0';
	const MINIMUM_PHP_VERSION = '7.3';

	public function __construct() {
		add_action( 'init', array( $this, 'i18n' ) );
		add_action( 'plugins_loaded', array( $this, 'init' ) );
	}

	public function i18n() {
		load_plugin_textdomain( 'duurzaamthuis' );
	}

	public function init() {
		// Check if Elementor installed and activated
		if ( ! did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', array( $this, 'admin_notice_missing_main_plugin' ) );
			return;
		}
		// Check for required Elementor version
		if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
			add_action( 'admin_notices', array( $this, 'admin_notice_minimum_elementor_version' ) );
			return;
		}
		// Check for required PHP version
		if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
			add_action( 'admin_notices', array( $this, 'admin_notice_minimum_php_version' ) );
			return;
		}
		// Once we get here, We have passed all validation checks so we can safely include our plugin
		require_once( 'plugin.php' );

		// register dh category
		add_action( 'elementor/elements/categories_registered', function( \Elementor\Elements_Manager $elements_manager ) {
			//https://github.com/elementor/elementor/issues/7445#issuecomment-692123467
			$categories = [];
			$categories['dh-widgets'] = [
            'title' =>  __( 'Duurzaamthuis Widgets', 'duurzaamthuis' ),
            'icon'  => 'fa fa-plug',
         ];
			$categories['dh-multiwidgets'] = [
            'title' =>  __( 'Duurzaamthuis Multiwidgets', 'duurzaamthuis' ),
            'icon'  => 'fa fa-plug',
         ];

			$old_categories = $elements_manager->get_categories();
			$categories = array_merge($categories, $old_categories);

			$set_categories = function ( $categories ) {
				$this->categories = $categories;
			};

			$set_categories->call( $elements_manager, $categories );
		} );
	}
	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have Elementor installed or activated.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function admin_notice_missing_main_plugin() {
		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}
		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor */
			esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'duurzaamthuis' ),
			'<strong>' . esc_html__( 'Duurzaamthuis Widgets', 'duurzaamthuis' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'duurzaamthuis' ) . '</strong>'
		);
		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}
	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required Elementor version.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function admin_notice_minimum_elementor_version() {
		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}
		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'duurzaamthuis' ),
			'<strong>' . esc_html__( 'Duurzaamthuis Widgets', 'duurzaamthuis' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'duurzaamthuis' ) . '</strong>',
			self::MINIMUM_ELEMENTOR_VERSION
		);
		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}
	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required PHP version.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function admin_notice_minimum_php_version() {
		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}
		$message = sprintf(
			/* translators: 1: Plugin name 2: PHP 3: Required PHP version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'duurzaamthuis' ),
			'<strong>' . esc_html__( 'Duurzaamthuis Widgets', 'duurzaamthuis' ) . '</strong>',
			'<strong>' . esc_html__( 'PHP', 'duurzaamthuis' ) . '</strong>',
			self::MINIMUM_PHP_VERSION
		);
		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}
}
// Instantiate AI_Blocks_Elementor.
new Duurzaamthuis_Widgets();



// plugin updates
require 'inc/vendor/plugin-update-checker/plugin-update-checker.php';
$myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
	'https://github.com/webdevs-pro/duurzaamthuis-widgets',
	__FILE__,
	'duurzaamthuis-widgets'
);
//Set the branch that contains the stable release.
$myUpdateChecker->setBranch('main');






// add_filter( 'dfrcs_products', function( $filtered_products, $compset ) {
// 	$filtered_products = array_slice( $filtered_products, 0, 5 );
// 	return $filtered_products;
// }, 10, 2);


// add_filter( 'body_class', function( $classes = [] ) {
// 	global $post;
// 	if ( Elementor\Plugin::$instance->preview->is_preview_mode() && $post->post_type == 'elementor_library' ) {
// 		$classes[] = 'test';
// 	}

// 	return $classes;
// }, 20 );






// add_filter( 'post_row_actions', 'filter_function_name_2859', 10, 2 );
// function filter_function_name_2859( $actions, $post ){
//     // Check for your post type.
// 	if ( in_array( $post->post_type, ['elementor_library', 'page', 'post'] ) ) {
// 		$url = esc_url( add_query_arg( array(
// 				'paged' => get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1,
// 				'post_type' => get_query_var( 'post_type' ) ? get_query_var( 'post_type' ) : '',
// 				'tabs_group' => get_query_var( 'tabs_group' ) ? get_query_var( 'tabs_group' ) : '',
// 				'update_controls' => $post->ID, 
// 			),
// 			admin_url( 'edit.php' )
// 		) );
// 		$actions['update_controls'] = sprintf( '<a href="%s">Update controls</a>', $url );
// 	}
	
// 	return $actions;
// }
// add_action('admin_init', function() {
// 	if( isset( $_GET['update_controls']) ) {
// 		$post_id = $_GET['update_controls'];
// 		$elementor_data = get_post_meta( $post_id, '_elementor_data', true );
// 		$elementor_data = json_decode( $elementor_data );
// 		if ( ! $elementor_data ) return;
// 		$new_elementor_data = dh_update_controls( $elementor_data );
// 		$json_value = wp_slash( wp_json_encode( $new_elementor_data ) );
// 		update_metadata( 'post', $post_id, '_elementor_data', $json_value );
// 	}
// });
// function dh_update_controls( $elements ) {
//    $new_elements = array();
//    foreach ( $elements as $element_index => $element ) {
      
//       foreach ( $element as $key => $value ) {

//          if ( $key == 'elements' && ! empty( $value ) ) {
//             $new_elements[$element_index][$key] = dh_update_controls( $value );
//          } else {
//             if ( $key == 'settings' ) {
//                $new_elements[$element_index][$key] = dh_update_settings( $value, $element );
//             } else {
//                $new_elements[$element_index][$key] = $value;
//             }
//          }
//       }


//    }
//    return $new_elements;
// }
// function dh_update_settings( $settings, $element ) {
//    $widgets = array(
//       'dh-anchor-navigation' => [
//          'heading',
//          'items',
//          'title',
//          'anchor'
//       ],
//       'dh-image-heading-text' => [
//          'image',
//          'image_align',
//          'image_width',
//          'image_reverse',
//          'heading',
//          'content'
//       ],
//       'dh-product-comparition' => [
//          'skin',
//          'controls_conditions',
//          'columns_count',
//          'title',
//          'badge',
//          'image',
//          'star_rating',
//          'text_rating',
//          'price',
//          'order_by',
//          'button_text',
//          'button_link',
//          'sponsored',
//          'pros',
//          'cons',
//          'description',
//          'products'
//       ],
//       'dh-impact' => [
//          'milieuwinst',
//          'prijs',
//          'terugverdientijd',
//          'gemak',
//          'vervuiling',
//          'subsidie',
//          'calculations_text',
//       ],
//       'dh-mega-menu' => [
//          'menu',
//          'mobile_menu',
//          'align_items',
//          'space_between',
//          'offset',
//          'color',
//          'align_toggle',
//          'offset_mobile',
//       ],
//       'dh-numbered-list' => [
//          'text',
//          'items',
//       ],
//       'dh-product-comparition-sustainability-score' => [
//          'skin',
//          'columns_count',
//          'logo_url',
//          'title',
//          'badge',
//          'image',
//          'quality',
//          'quality_tooltip',
//          'co2_custom_label',
//          'co2',
//          'co2_tooltip',
//          'price',
//          'price_tooltip',
//          'rating',
//          'rating_tooltip',
//          'pros',
//          'cons',
//          'description',
//          'shortcode',
//          'last_updated_text',
//          'button_text',
//          'button_link',
//          'sponsored',
//          'products',
//       ],
//       'dh-related-content' => [
//          'type',
//          'columns_count',
//          'posts_count',
//          'show_excerpt',
//          'id',
//          'badge',
//          'posts',
//       ],
//       'dh-table' => [
//          'table'
//       ],
//       'dh-number-heading' => [
//          'number',
//          'heading',
//          'badge',
//          'size'
//       ],
//       'dh-template' => [
//          'post_id',
//          'button'
//       ],
//    );

//    $config = array();
//    foreach ( $widgets as $widget => $controls ) {
//       foreach ( $controls as $control ) {
//          $config[$widget][$control] = array(
//             'old_name' => $control,
//             'new_name' => str_replace( '-', '_', $widget ) . '_' . $control
//          );
//       }
//    }

//    $new_settings = (object) array();
//    if ( $element->elType == 'widget' && array_key_exists( $element->widgetType ?? '', $config ) ) {
//       foreach ( $settings as $setting_name => $value ) { 
//          if ( is_array( $value ) ) {
//             foreach( $value as $index => $item ) {
//                @$new_settings->{$config[$element->widgetType][$setting_name]['new_name']}[$index] = dh_update_settings( $value[$index], $element );
//             }
//          } else {
//             if ( array_key_exists( $setting_name, $config[$element->widgetType] ) ) {
//                $new_settings->{$config[$element->widgetType][$setting_name]['new_name']} = $settings->{$config[$element->widgetType][$setting_name]['old_name']};
//             } else {
//                $new_settings->$setting_name = $settings->$setting_name;
//             }
//          }
//       }
//    } else {
//       $new_settings = $settings;
//    }

//    return $new_settings;
// }



// chanhe datafeedr template to custmo included in our plugin
if ( get_option( 'dfrcs_options' )['display_method'] != 'php' ) {
   add_filter( 'dfrcs_template', function( $template ) {
      return DH_PLUGIN_DIR . '/inc/datafeedr-template.php';
   }, 10 );
}





// hide expertise repeater for non admin
add_action( 'admin_footer', function() {
   if ( ! current_user_can( 'administrator' ) ) {
      echo '<style>.hide-non-admin{display:none;}</style>';
   }
} );







