<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}



class DH_Related_Posts extends \Elementor\Widget_Base {

	public function get_name() {
		return 'dh-related-posts';
	}

	public function get_title() {
		return __( 'Related Posts', 'duurzaamthuis' );
	}

	public function get_icon() {
		return 'eicon-gallery-grid';
	}

	public function get_categories() {
		return [ 'dh-widgets' ];
	}

	protected function register_controls() {
      
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

		// SECTION CONTENT
		$this->start_controls_section( 'section_content', [
         'label' => __( 'Content', 'duurzaamthuis' ),
         'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
      ] );
         $this->add_control( 'type', [
            'label' => __( 'Query', 'duurzaamthuis' ),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'manual',
            'options' => [
               'manual'  => __( 'Manual', 'duurzaamthuis' ),
               'related' => __( 'Related', 'duurzaamthuis' ),
            ],
         ] );
         $this->add_responsive_control( 'columns_count', [
            'label' => __( 'Columns', 'duurzaamthuis' ),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'min' => 1,
            'max' => 6,
            'step' => 1,
            'default' => 3,
            'tablet_default' => 2,
            'mobile_default' => 1,
            'selectors' => [
               '{{WRAPPER}} .dh-related-posts-grid' => 'grid-template-columns: repeat({{VALUE}}, 1fr);',
            ],         
         ] );
         $this->add_control( 'posts_count', [
            'label' => __( 'Posts Count', 'duurzaamthuis' ),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'min' => 1,
            'max' => 9,
            'step' => 1,
            'default' => 3,
            'condition' => [
               'type' => 'related',
            ],         
         ] );
         $this->add_control( 'show_excerpt',[
            'label' => __( 'Show Exerpt', 'duurzaamthuis' ),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => __( 'Yes', 'your-plugin' ),
            'label_off' => __( 'No', 'your-plugin' ),
            'return_value' => 'yes',
         ] );
         $repeater = new \Elementor\Repeater();
            $repeater->add_control( 'id', [
               'label' => __( 'Search & Select', 'elementor-pro' ),
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
            $repeater->add_control( 'badge', [
               'label' => __( 'Badge', 'duurzaamthuis' ),
               'type' => \Elementor\Controls_Manager::SELECT,
               'default' => 'none',
               'options' => [
                  'none'  => __( 'None', 'duurzaamthuis' ),
                  'best_choise' => __( 'Beste Keuze', 'duurzaamthuis' ),
                  'reading_tip' => __( 'Leestip', 'duurzaamthuis' ),
               ],
            ] );
         $this->add_control( 'posts', [
            'label' => __( 'Posts', 'duurzaamthuis' ),
            'type' => \Elementor\Controls_Manager::REPEATER,
            'fields' => $repeater->get_controls(),
				'title_field' => $script,
				'condition' => [
					'type' => 'manual',
				],
				'show_label' => false,
				'prevent_empty' => false,
         ] );



		$this->end_controls_section(); 

	}

   public function get_related_posts( $post_id, $related_count, $args = array() ) {
		$args = wp_parse_args( (array) $args, array(
			'orderby' => 'rand',
			'return'  => 'query', // Valid values are: 'query' (WP_Query object), 'array' (the arguments array)
		) );

		$related_args = array(
			'post_type'      => ['post', 'page'],
			'posts_per_page' => $related_count,
			'post_status'    => 'publish',
			'post__not_in'   => array( $post_id ),
			'orderby'        => $args['orderby'],
			'tax_query'      => array()
		);

		$post = get_post( $post_id );
		$taxonomies = get_object_taxonomies( $post, 'names' );

		foreach ( $taxonomies as $taxonomy ) {
			$terms = get_the_terms( $post_id, $taxonomy );
			if ( empty( $terms ) ) {
				continue;
			}
			$term_list = wp_list_pluck( $terms, 'slug' );
			$related_args['tax_query'][] = array(
				'taxonomy' => $taxonomy,
				'field'    => 'slug',
				'terms'    => $term_list
			);
		}

		if ( count( $related_args['tax_query'] ) > 1 ) {
			$related_args['tax_query']['relation'] = 'OR';
		}

		if ( $args['return'] == 'query' ) {
			return new WP_Query( $related_args );
		} else {
			return $related_args;
		}
	}

	protected function render() { // php template

		$settings = $this->get_settings_for_display();

      if ( $settings['type'] == 'manual' && ! empty( $settings['posts'] ) ) {
         $posts_ids = $settings['posts'];
      } 
      elseif ( $settings['type'] == 'related' ) {
         $posts = $this->get_related_posts( get_the_ID(), $settings['posts_count'] );
         $posts_ids = array();
         if ( ! empty( $posts->posts ) ) {
            foreach ( $posts->posts as $post ) {
               $posts_ids[] = array(
                  'id' => $post->ID,
               );
            }
         }
      }

      if ( isset( $posts_ids ) && ! empty( $posts_ids ) ) {
         echo '<div class="dh-related-posts-grid dh-related-posts-' . $settings['type'] . '-skin">';
            foreach ( $posts_ids as $post ) {
               echo '<a class="dh-related-post post-id-' . $post['id'] . '" href="' . get_the_permalink( $post['id'] ) . '">';
                  if ( $post['badge'] ) {
                     switch ( $post['badge'] ) {
                        case 'best_choise':
                           echo '<div class="dh-related-post-badge dh-heading-choise-badge"><span>Beste keuze</span></div>';
                           break;
                        case 'reading_tip':
                           echo '<div class="dh-related-post-badge dh-heading-choise-badge"><span>Leestip</span></div>';
                           break;
                     }
                  }
                  echo '<div class="dh-related-post-image">';
                     echo '<div class="dh-related-post-image-wrapper">';
                        echo '<img src="' . get_the_post_thumbnail_url( $post['id'], 'medium' ) . '">';
                     echo '</div>';
                  echo '</div>';
                  echo '<h3 class="dh-related-post-title">' . get_the_title( $post['id'] ) . '</h3>';
                  if ( $settings['show_excerpt'] ) {
                     // $exerpt = get_yoast_derfve
                     // inhinh
                     // EBML_ID_TARGETSetgb

                     echo '<div class="dh-related-post-exerpt">' . get_the_excerpt( $post['id'] ) . '</div>';
                  }
               echo '</a>';
            }
         echo '</div>';
      }

	}
	
}
