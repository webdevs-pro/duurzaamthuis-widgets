<?php

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Text_Shadow;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}



class DH_Page_Navigation extends \Elementor\Widget_Base {

	public function get_name() {
		return 'dh-page-navigation';
	}

	public function get_title() {
		return __( 'Page navigation', 'duurzaamthuis' );
	}

	public function get_icon() {
		return 'eicon-bullet-list';
	}

	public function get_categories() {
		return [ 'dh-widgets' ];
	}

	protected function register_controls() {
      
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

      global $post;


		if ( $post->post_parent ) {
			$post_ancestors = get_post_ancestors( $post->ID );
			$top_level_page = array_pop( $post_ancestors ); 
		} else {
			$top_level_page = $post->ID;
		}

		$second_level_args = array(
			'post_parent' => $top_level_page,
			'post_type' => ['post', 'page'],
			'post_status' => 'publish',
			'numberposts' => -1,
			'fields' => 'ids',
			'orderby' => 'title',
			'order' => 'ASC'
		);
		$second_level_pages = get_children( $second_level_args );

		echo '<ul class="dh-top-level-pages">';

			echo '<li class="dh-top-level-page' . ( $top_level_page == $post->ID ? ' dh-current-page' : '' ) . ( in_array( $post->ID, $second_level_pages ?? [] ) || in_array( $post->ID, $third_level_pages ?? [] ) ? ' dh-has-current-page' : '' ) . ( ! empty( $second_level_pages ) ? ' dh-has-children dh-onload-opened dh-opened' : '' ) . '">';
				if ( ! empty( $second_level_pages ) ) {
					echo '<span class="dh-subpages-toggle"><i class="eicon-plus-square-o"></i></span>';
				}
				if ( $top_level_page == $post->ID ) {
					echo '<span>' . get_the_title( $top_level_page ) . '</span>';
				} else {
					echo '<a href="' . get_the_permalink( $top_level_page ) . '"><span>' . get_the_title( $top_level_page ) . '</span></a>';
				}

				echo '<ul class="dh-second-level-pages">';

					foreach( $second_level_pages as $second_level_page_id ) {
						$third_level_args = array(
							'post_parent' => $second_level_page_id,
							'post_type' => ['post', 'page'],
							'post_status' => 'publish',
							'numberposts' => -1,
							'fields' => 'ids',
							'orderby' => 'title',
							'order' => 'ASC'
						);
						$third_level_pages = get_children( $third_level_args );

						echo '<li class="dh-second-level-page' . ( $second_level_page_id == $post->ID ? ' dh-current-page' : '' ) . ( in_array( $post->ID, $third_level_pages ) ? ' dh-has-current-page' : '' ) . ( $second_level_page_id == $post->ID || in_array( $post->ID, $third_level_pages ) ? ' dh-onload-opened dh-opened' : '' ) .  ( ! empty( $third_level_pages ) ? ' dh-has-children' : '' ) . '">';
							if ( ! empty( $third_level_pages ) ) {
								echo '<span class="dh-subpages-toggle"><i class="eicon-plus-square-o"></i></span>';
							}
							if ( $second_level_page_id == $post->ID ) {
								echo '<span>' . get_the_title( $second_level_page_id ) . '</span>';
							} else {
								echo '<a href="' . get_the_permalink( $second_level_page_id ) . '"><span>' . get_the_title( $second_level_page_id ) . '</span></a>';
							}
				
							if ( ! empty( $third_level_pages ) ) {
								echo '<ul class="dh-third-level-pages">';
								foreach ( $third_level_pages as $third_level_page_id ) {
									echo '<li class="dh-third-level-page' . ( $third_level_page_id == $post->ID ? ' dh-current-page' : '' ) . '">';
									if ( $third_level_page_id == $post->ID ) {
										echo '<span>' . get_the_title( $third_level_page_id ) . '</span>';
									} else {
										echo '<a href="' . get_the_permalink( $third_level_page_id ) . '"><span>' . get_the_title( $third_level_page_id ) . '</span></a>';
									}
									echo '</li>';
								}
								echo '</ul>';
							}
						echo '</li>';

					}

				echo '</ul>';

			echo '</li>';

		echo '</ul>';

	}

	
}