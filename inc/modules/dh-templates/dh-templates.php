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
		add_filter( 'manage_post_posts_columns', [ $this, 'misha_price_and_featured_columns' ] );
		add_action( 'manage_posts_custom_column', [ $this, 'misha_populate_both_columns' ], 10, 2);
		add_action( 'quick_edit_custom_box', [ $this, 'display_dh_template_select' ], 10, 2 );
		add_action( 'bulk_edit_custom_box', [ $this, 'display_dh_template_select' ], 10, 2 );
		add_action( 'save_post', [ $this, 'save_dh_template' ], 10, 2 );
		add_action( 'admin_enqueue_scripts', [ $this, 'misha_enqueue_quick_edit_population' ] );
		add_action( 'wp_ajax_misha_save_bulk', [ $this, 'misha_save_bulk_edit_hook' ] ); 
		add_action( 'elementor/element/wp-post/document_settings/after_section_end', [ $this, 'add_post_settings_controls' ], 10 );
		add_action( 'elementor/element/wp-page/document_settings/after_section_end', [ $this, 'add_page_settings_controls' ], 10 );
		add_action( 'elementor/document/before_save', [ $this, 'save_elementor_post_settings' ], 10, 2 );
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
			'show_in_quick_edit'    => false,
			'rewrite'               => true,
			'capabilities'          => array(),
			'meta_box_cb'           => null, // html метабокса. callback: `post_categories_meta_box` или `post_tags_meta_box`. false — метабокс отключен.
			// 'show_admin_column'     => true, // авто-создание колонки таксы в таблице ассоциированного типа записи. (с версии 3.5)
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



	public function misha_price_and_featured_columns( $column_array ) {
		$column_array['dh_template'] = 'DH Template';
		return $column_array;
	}


	public function misha_populate_both_columns( $column_name, $id ) {
		if ( $column_name == 'dh_template' ) {
			$current_term = get_the_terms( $id, 'dh_templates' );
			if ( empty( $current_term ) ) {
				echo '-';
			} else {
				echo $current_term[0]->name . ' (' . $current_term[0]->term_id . ')';
			}
		}
	}


	public function display_dh_template_select( $column_name, $post_type ) {
		if ( 'dh_template' === $column_name && 'post' === $post_type ): ?>
			<fieldset class="inline-edit-col-right">
				<div class="inline-edit-col">
					<div class="inline-edit-group wp-clearfix">
						<label class="inline-edit-group">
							<?php
							if ( $column_name === 'dh_template' ) {
								// $views = (int) get_post_meta( get_the_ID(), 'views', true );
								$templates = get_terms(
									array(
										'taxonomy' => 'dh_templates',
										'hide_empty' => false,
									)
								);
								$current_template = get_the_terms( get_the_ID(), 'dh_templates' );
								if ( ! empty( $current_template ) ) {
									$current_template = $current_template[0]->term_id;
								}
								?>
								<span class="title">DH Template</span>
								<select class="dh_template" name="dh_template">
									<?php foreach ( $templates as $template ) {
										if ( $template->term_id == $current_template ) {
											echo '<option selected value="' . $template->term_id . '">' . $template->name . '</option>';
										} else {
											echo '<option value="' . $template->term_id . '">' . $template->name . '</option>';
										}
									} ?>
								</select>
								<?php
							}
							?>
						</label>
					</div>
	
				</div>
			</fieldset>
		<?php endif;
	}


	public function save_dh_template( $post_id, $post ) {
		// Не работаем с автосохранением
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return $post_id;
		}
	
		// Не работаем с типа записей, отличными от post, а также, если пользоваль не имеет прав редактирования
		if ( 'post' !== $post->post_type || ! current_user_can( 'edit_post', $post_id ) ) {
			return $post_id;
		}
	
		// Проверяем защитный код
		if ( ! isset( $_REQUEST['_inline_edit'] ) || ! wp_verify_nonce( $_REQUEST['_inline_edit'], 'inlineeditnonce' ) ) {
			return $post_id;
		}
	
		// Обновляем поле
		if ( isset( $_POST['dh_template'] ) ) {
			wp_set_post_terms( $post_id, (int) $_POST['dh_template'], 'dh_templates', false);
		}
	
		return $post_id;
	}


	public function misha_enqueue_quick_edit_population( $pagehook ) {
		// do nothing if we are not on the target pages
		if ( 'edit.php' != $pagehook ) {
			return;
		}
		wp_enqueue_script( 'dh-templates', DH_PLUGIN_DIR_URL . 'inc/modules/dh-templates/assets/admin.js', array( 'jquery' ) );
	}


	public function misha_save_bulk_edit_hook() {
	
		if( empty( $_POST[ 'post_ids' ] ) ) {
			die();
		}
	
		// for each post ID
		foreach( $_POST[ 'post_ids' ] as $id ) {
	
			wp_set_post_terms( $id, (int) $_POST['dh_template'], 'dh_templates', false);
	
		}
	
		die();
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
					'content_classes' => 'dh-template-select',
            ]
			);
			$post->add_control(
				'current_dh_template',
				[
					'type' => \Elementor\Controls_Manager::TEXT,
					'default' => $this->get_current_template(),
					'content_classes' => 'dh-current-template-value',
				]
			);
			$post->add_control(
				'script',
				[
					'type' => \Elementor\Controls_Manager::RAW_HTML,
					'raw' => $this->get_elementor_script_string(),
				]
			);
		$post->end_controls_section(); 
	}



   public function get_elementor_script_string() {
      ob_start(); ?>
			<script>
				var current_template_id = jQuery('[data-setting="current_dh_template"]').val();
				console.log(current_template_id);
				if(current_template_id) {
					jQuery('[data-setting="dh_template"]').val(current_template_id);
				}
			</script>
		<?php return ob_get_clean();
   }



   public function get_templates() {
      $terms = get_terms(
         array(
            'taxonomy' => 'dh_templates',
            'hide_empty' => false,
         )
      );
      return ['0' => __( 'None', 'duurza' )] + array_column( $terms, 'name', 'term_id' );
   }



   public function get_current_template() {
      $current_term = get_the_terms( get_the_ID(), 'dh_templates' );
		if ( empty( $current_term ) ) return false;
      return $current_term[0]->term_id;
   }



   public function save_elementor_post_settings( $instance, $data ) {

		$post_id = $instance->get_post()->ID;

		if ( empty( $data) ) return;

		$settings = $data['settings'];

      error_log( "settings\n" . print_r($settings, true) . "\n" );

	}

}
new DH_Custom_Templates();



















