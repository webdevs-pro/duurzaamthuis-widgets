<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


/**
 * 
 * class for adding custom page/post templates functionality
 * 
 */
class DH_Custom_Templates {
	public function __construct() {
		add_action( 'init', [ $this, 'register_taxonomy' ] );
		add_action( 'init', [ $this, 'register_terms' ] );
		add_filter( 'manage_post_posts_columns', [ $this, 'add_post_column' ] );
		add_filter( 'manage_page_posts_columns', [ $this, 'add_post_column' ] );
		add_action( 'manage_posts_custom_column', [ $this, 'print_post_column' ], 10, 2);
		add_action( 'manage_page_posts_custom_column', [ $this, 'print_post_column' ], 10, 2);
		add_action( 'quick_edit_custom_box', [ $this, 'add_quick_edit_control' ], 10, 2 );
		add_action( 'bulk_edit_custom_box', [ $this, 'add_quick_edit_control' ], 10, 2 );
		add_action( 'load-post.php',     array( $this, 'init_metabox' ) );
		add_action( 'load-post-new.php', array( $this, 'init_metabox' ) );
		add_action( 'admin_print_footer_scripts-edit.php', [ $this, 'print_admin_script' ] );
		add_action( 'save_post', [ $this, 'save_quick_edit_control' ], 10, 2 );
		add_action( 'wp_ajax_dh_template_save_bulk', [ $this, 'seve_bulk_edit_control' ] ); 
		add_action( 'elementor/element/wp-post/document_settings/after_section_end', [ $this, 'add_elementor_post_settings_controls' ], 10 );
		add_action( 'elementor/element/wp-page/document_settings/after_section_end', [ $this, 'add_elementor_page_settings_controls' ], 10 );
		add_action( 'elementor/document/before_save', [ $this, 'save_elementor_post_settings' ], 10, 2 );
	}


	public function register_taxonomy() {
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


	public function add_post_column( $column_array ) {
		$column_array['dh_template'] = 'DH Template';
		return $column_array;
	}


	public function print_post_column( $column_name, $id ) {
		if ( $column_name == 'dh_template' ) {
			$current_term = get_the_terms( $id, 'dh_templates' );
			if ( empty( $current_term ) ) {
				echo '—';
			} else {
				echo $current_term[0]->name . ' (' . $current_term[0]->term_id . ')';
			}
		}
	}


	public function add_quick_edit_control( $column_name, $post_type ) {
		if ( $column_name === 'dh_template' && ( $post_type === 'post' || $post_type === 'page' ) ) { ?>
			<fieldset class="inline-edit-col-right">
				<div class="inline-edit-col">
					<div class="inline-edit-group wp-clearfix">
						<label class="inline-edit-group">
							<?php
							if ( $column_name === 'dh_template' ) {
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
									<option value="0"><?php echo __( 'None', 'duurzaamthuis' ); ?></option>
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
		<?php }
	}


	public function save_quick_edit_control( $post_id, $post ) {
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return $post_id;
		}
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return $post_id;
		}
		if ( ! isset( $_REQUEST['_inline_edit'] ) || ! wp_verify_nonce( $_REQUEST['_inline_edit'], 'inlineeditnonce' ) ) {
			return $post_id;
		}
		if ( isset( $_POST['dh_template'] ) ) {
			wp_set_post_terms( $post_id, (int) $_POST['dh_template'], 'dh_templates', false);
		}
		return $post_id;
	}


	public function init_metabox() {
		add_action( 'add_meta_boxes', [ $this, 'add_metabox' ] );
		add_action( 'save_post', [ $this, 'save_metabox' ], 10, 2 );
	}


	public function add_metabox() {
		add_meta_box(
			'dh-template',
			__( 'DH Template', 'duurzaamthuis' ),
			[ $this, 'render_metabox' ],
			[ 'post', 'page' ],
			'side',
			'high',
			[ '__back_compat_meta_box' => false ]
		);
	}


	public function render_metabox( $post ) {
		wp_nonce_field( 'dh_template_nonce_action', 'dh_template_nonce' );
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
		<select class="dh_template" name="dh_template">
			<option value="0"><?php echo __( 'None', 'duurzaamthuis' ); ?></option>
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


	public function save_metabox( $post_id, $post ) {
		// Add nonce for security and authentication.
		$nonce_name = isset( $_POST['dh_template_nonce'] ) ? $_POST['dh_template_nonce'] : '';
		$nonce_action = 'dh_template_nonce_action';
		if ( ! wp_verify_nonce( $nonce_name, $nonce_action ) ) {
			return;
		}
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}
		if ( wp_is_post_autosave( $post_id ) ) {
			return;
		}
		if ( wp_is_post_revision( $post_id ) ) {
			return;
		}
		wp_set_post_terms( $post_id, (int) $_POST['dh_template'], 'dh_templates', false);
	}


	public function print_admin_script() {
		$current_screen = get_current_screen();
		if ( $current_screen->id != 'edit-post' && $current_screen->id != 'edit-page' ) return;
		?>
		<script>
			jQuery(function($){
				var wp_inline_edit_function = inlineEditPost.edit;
				inlineEditPost.edit = function(post_id) {
					wp_inline_edit_function.apply(this, arguments);
					var id = 0;
					if(typeof(post_id) == 'object' ) { 
						id = parseInt(this.getId(post_id));
					}
					if(id > 0) {
						var specific_post_edit_row = $('#edit-' + id);
						var specific_post_row = $('#post-' + id);
						var term = $('.dh_template', specific_post_row ).text().match(/\(([^)]+)\)/);
						if(term) {
							$('select[name="dh_template"]', specific_post_edit_row ).val(term[1]);
						}
						
					}
				}

				$('body').on('click', 'input[name="bulk_edit"]', function() {
					$(this).after('<span class="spinner is-active"></span>');
					var bulk_edit_row = $( 'tr#bulk-edit' );
					var post_ids = new Array();
					var template = bulk_edit_row.find( '.dh_template' ).val();
					bulk_edit_row.find( '#bulk-titles' ).children().each( function() {
						post_ids.push( $( this ).attr( 'id' ).replace( /^(ttle)/i, '' ) );
					});
					$.ajax({
						url: ajaxurl,
						type: 'POST',
						async: false,
						data: {
							action: 'dh_template_save_bulk',
							post_ids: post_ids, 
							dh_template: template,
						}
					});
				});
			});
		</script>
		<?php
	}


	public function seve_bulk_edit_control() {
		if( empty( $_POST[ 'post_ids' ] ) ) {
			die();
		}
		foreach( $_POST[ 'post_ids' ] as $id ) {
			wp_set_post_terms( $id, (int) $_POST['dh_template'], 'dh_templates', false);
		}
		die();
	}


	public function add_elementor_post_settings_controls( \Elementor\Core\DocumentTypes\Post $post ) {
		$this->add_controls( $post );
	}



	public function add_elementor_page_settings_controls( \Elementor\Core\DocumentTypes\Page $page ) {
		$this->add_controls( $page );
	}


	public function add_controls( $post ) {
		$post->start_controls_section( 'section_dh_template', [
			'label' => __( 'DH Template', 'duurzaamthuis' ),
			'tab' => \Elementor\Controls_Manager::TAB_SETTINGS, // https://developers.elementor.com/elementor-element-panel-tabs/
		]);
			$post->add_control(
				'dh_template',
            [
               'label' => __( 'Select Template', 'duurzaamthuis' ),
               'type' => \Elementor\Controls_Manager::SELECT,
               'options' => $this->get_templates(),
               'default' => $this->get_current_template(),
            ]
			);
			$post->add_control(
				'current_dh_template',
				[
					'type' => \Elementor\Controls_Manager::HIDDEN,
					'default' => $this->get_current_template(),
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
      return ['0' => __( 'None', 'duurzaamthuis' )] + array_column( $terms, 'name', 'term_id' );
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
      // error_log( "settings template\n" . print_r($settings, true) . "\n" );
		if ( isset( $settings['dh_template'] ) ) {
			wp_set_post_terms( $post_id, (int) $settings['dh_template'], 'dh_templates', false );
		}
	}

}
new DH_Custom_Templates();











