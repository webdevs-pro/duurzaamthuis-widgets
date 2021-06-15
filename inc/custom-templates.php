<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


/**
 * 
 * class for adding custom page/post templates functionality
 * 
 */
class DH_Custom_Templates {
	public function __construct() {
		add_action( 'init', [ $this, 'create_taxonomy' ] );
		add_action( 'init', [ $this, 'register_terms' ] );
		add_action( 'elementor/element/wp-post/document_settings/after_section_end', [ $this, 'add_post_settings_controls' ] );
		add_action( 'elementor/element/wp-page/document_settings/after_section_end', [ $this, 'add_page_settings_controls' ] );
		add_action( 'elementor/document/before_save', [ $this, 'save_settings' ], 10, 2 );
	}
	public function create_taxonomy() {
		register_taxonomy( 'dh_templates', [ 'post', 'page' ], [
			'label'                 => '', // определяется параметром $labels->name
			'labels'                => [
				'name'               => 'DH Templates',
				'singular_name'      => 'DH Template',
			],
			'description'           => '',
			'public'                => true,
			'show_ui'               => true, // равен аргументу public
			'hierarchical'          => true,
			'show_in_quick_edit'    => true,
			'rewrite'               => true,
			'capabilities'          => array(),
			'meta_box_cb'           => null, // html метабокса. callback: `post_categories_meta_box` или `post_tags_meta_box`. false — метабокс отключен.
			'show_admin_column'     => true, // авто-создание колонки таксы в таблице ассоциированного типа записи. (с версии 3.5)
			'show_in_rest'          => null, // добавить в REST API
			'rest_base'             => null, // $taxonomy
		] );

	}
	public function register_terms() {
		if ( ! term_exists( 'DH Template 1', 'dh_templates' ) ) {
			wp_insert_term(
				'Template 1',
				'dh_templates',
				array(
					'slug' => 'dh-template-1'
				)
			);
	  	}
		if ( ! term_exists( 'DH Template 2', 'dh_templates' ) ) {
			wp_insert_term(
				'Template 2',
				'dh_templates',
				array(
					'slug' => 'dh-template-2'
				)
			);
	  	}
		if ( ! term_exists( 'DH Template 3', 'dh_templates' ) ) {
			wp_insert_term(
				'Template 3',
				'dh_templates',
				array(
					'slug' => 'dh-template-3'
				)
			);
	  	}
	}
	public function add_post_settings_controls( \Elementor\Core\DocumentTypes\Post $post ) {
		$this->add_controls( $post );
	}
	public function add_page_settings_controls( \Elementor\Core\DocumentTypes\Page $page ) {
		$this->add_controls( $page );
	}
	public function add_controls( $post ) {
		$post->start_controls_section( 'section_dh_template', [
			'label' => __( 'DH Template', 'magnific-addons' ),
			'tab' => \Elementor\Controls_Manager::TAB_SETTINGS, // https://developers.elementor.com/elementor-element-panel-tabs/
		]);
			$post->add_control(
				'dh_template',
            [
               'label' => __( 'Select Template', 'plugin-domain' ),
               'type' => \Elementor\Controls_Manager::SELECT,
               'options' => $this->get_templates(),
               'default' => $this->get_current_template(),
            ]
			);
		$post->end_controls_section(); 
	}
   public function get_templates() {
      $terms = get_terms(
         array(
            'taxonomy' => 'dh_templates',
            'hide_empty' => false,
         )
      );
      return array_column( $terms, 'name', 'term_id' );
   }
   public function get_current_template() {
      $current_term = get_the_terms( get_the_ID(), 'dh_templates' )[0];
      return $current_term->term_id;
   }
   public function save_settings( $instance, $data ) {

		$post_id = $instance->get_post()->ID;

		if ( empty( $data) ) return;

		$settings = $data['settings'];

      error_log( "settings\n" . print_r($settings, true) . "\n" );

	}

}
new DH_Custom_Templates();





add_action( 'add_term_relationship', 'dh_allow_only_one_template_term', 10, 3 );
function dh_allow_only_one_template_term( $object_id, $term_id, $taxonomy ) {
	if ( $taxonomy == 'dh_templates' ) {
		$current_terms = array_column( get_the_terms( $object_id, $taxonomy ), 'term_id' );
		wp_remove_object_terms( $object_id, $current_terms, $taxonomy );
	}
};




// https://wordpress.stackexchange.com/questions/139269/wordpress-taxonomy-radio-buttons
add_filter( 'wp_terms_checklist_args', 'dh_templates_radioboxes' );
function dh_templates_radioboxes( $args ) {
	if ( ! empty( $args['taxonomy'] ) && $args['taxonomy'] === 'dh_templates' /* <== Change to your required taxonomy */ ) {
		if ( empty( $args['walker'] ) || is_a( $args['walker'], 'Walker' ) ) { // Don't override 3rd party walkers.
			class WPSE_139269_Walker_Category_Radio_Checklist extends Walker_Category_Checklist {
				function walk( $elements, $max_depth, ...$args ) {
					$output = parent::walk( $elements, $max_depth, ...$args );
					$output = str_replace(
							array( 'type="checkbox"', "type='checkbox'" ),
							array( 'type="radio"', "type='radio'" ),
							$output
					);
					return $output;
				}
			}
			$args['walker'] = new WPSE_139269_Walker_Category_Radio_Checklist;
		}
	}
	return $args;
}
