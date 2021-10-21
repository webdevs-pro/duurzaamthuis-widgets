<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}



class DH_Related_Posts extends \Elementor\Widget_Base {

	public function get_name() {
		return 'dh-related-content';
	}

	public function get_title() {
		return __( 'Related Content', 'duurzaamthuis' );
	}

	public function get_icon() {
		return 'eicon-gallery-grid';
	}

	public function get_categories() {
		return [ 'dh-widgets' ];
	}

	protected function register_controls() {
      DH_Widgets_Content_Controls::get_dh_related_content_controls( $this );
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

      if ( $settings['dh_related_content_type'] == 'manual' && ! empty( $settings['dh_related_content_posts'] ) ) {
         $posts_ids = $settings['dh_related_content_posts'];
      } 
      elseif ( $settings['dh_related_content_type'] == 'related' ) {
         $posts = $this->get_related_posts( get_the_ID(), $settings['dh_related_content_posts_count'] );
         $posts_ids = array();
         if ( ! empty( $posts->posts ) ) {
            foreach ( $posts->posts as $post ) {
               $posts_ids[] = array(
                  'id' => $post->ID,
               );
            }
         }
      }

		?>
		<div class="<?php echo 'dh-widget-' . $this->get_name() . DH_Widgets_Content_Controls::get_prefix_classes( $this, $settings ); ?>">
			<?php if ( $settings['dh_related_content_heading'] ) { ?>
				<h2 class="dh-heading">
					<?php echo $settings['dh_related_content_heading']; ?>
				</h2>
			<?php
			}
      if ( isset( $posts_ids ) && ! empty( $posts_ids ) ) {
            echo '<div class="dh-related-content-grid dh-related-content-' . $settings['dh_related_content_type'] . '-skin">';
               foreach ( $posts_ids as $post ) {
						if ( $post['dh_related_content_id'] == 0 ) {
							echo '<a class="dh-related-post post-id-0" href=""><div class="dh-related-post-image"><div class="dh-related-post-image-wrapper"><img src="' . ELEMENTOR_ASSETS_URL . 'images/placeholder.png' . '"></div></div><h3 class="dh-related-post-title">Example Post</h3></a>';
						} else {
							echo '<a class="dh-related-post post-id-' . $post['dh_related_content_id'] . '" href="' . get_the_permalink( $post['dh_related_content_id'] ) . '">';
								if ( $post['dh_related_content_badge'] ) {
									switch ( $post['dh_related_content_badge'] ) {
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
										echo '<img src="' . get_the_post_thumbnail_url( $post['dh_related_content_id'], 'medium' ) . '">';
									echo '</div>';
								echo '</div>';
								echo '<h3 class="dh-related-post-title">' . get_the_title( $post['dh_related_content_id'] ) . '</h3>';
								if ( $settings['dh_related_content_show_excerpt'] ) {
									// $exerpt = get_yoast_derfve
									// inhinh
									// EBML_ID_TARGETSetgb

									echo '<div class="dh-related-post-exerpt">' . get_the_excerpt( $post['dh_related_content_id'] ) . '</div>';
								}
							echo '</a>';
						}
               }
					?></div><?php
            echo '</div>';
      }

	}

	protected function content_template() {
		?>
			<#
				var cache = jQuery(view.model.attributes.htmlCache);
				var related_content = cache.find('.dh-widget-dh-related-content');
				var content = '<div class="dh-related-content-grid"><a class="dh-related-post post-id-0" href=""><div class="dh-related-post-image"><div class="dh-related-post-image-wrapper"><img src="<?php echo ELEMENTOR_ASSETS_URL . 'images/placeholder.png'; ?>"></div></div><h3 class="dh-related-post-title">Example Post</h3></a><a class="dh-related-post post-id-0" href=""><div class="dh-related-post-image"><div class="dh-related-post-image-wrapper"><img src="<?php echo ELEMENTOR_ASSETS_URL . 'images/placeholder.png'; ?>"></div></div><h3 class="dh-related-post-title">Example Post</h3></a><a class="dh-related-post post-id-0" href=""><div class="dh-related-post-image"><div class="dh-related-post-image-wrapper"><img src="<?php echo ELEMENTOR_ASSETS_URL . 'images/placeholder.png'; ?>"></div></div><h3 class="dh-related-post-title">Example Post</h3></a></div>';
				if ( related_content.length > 0 ) {
					content = related_content[0].innerHTML;
				}
				jQuery('.elementor-control-dh_related_content_posts_button').on('click', function() {
					view.model.renderRemoteServer();
				});

			#>
			<div class="dh-widget-dh-related-content">{{{content}}}</div>
			
		<?php
	}
	
}
