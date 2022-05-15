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



class DH_Author_Box extends \Elementor\Widget_Base {

	public function get_name() {
		return 'dh-author-box';
	}

	public function get_title() {
		return __( 'Author Box', 'duurzaamthuis' );
	}

	public function get_icon() {
		return 'eicon-person';
	}

	public function get_categories() {
		return [ 'dh-widgets' ];
	}

	protected function register_controls() {
		$this->start_controls_section( 'author_controls_section', [
			'label' => __( 'Author', 'duurzaamthuis' ),
			'tab' => Elementor\Controls_Manager::TAB_CONTENT, // https://developers.elementor.com/elementor-element-panel-tabs/
		] );
		$this->end_controls_section(); 
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

      if ( is_author() ) {
         $author = get_queried_object();
         if ( ! isset( $author->ID ) ) return;
         $author_id = $author->ID;
      } else {
         $author_id = get_the_author_meta( 'ID' );
      }

      $avatar_id = get_user_meta( $author_id, 'dh-user-avatar', true );
      if ( $avatar_id ) {
         $avatar_img = wp_get_attachment_image( $avatar_id, 'thumbnail' );
      } else  {
         $avatar_img = '<img src="' . DH_PLUGIN_DIR_URL . 'assets/duurzaamthuis-logo-small.png">';
      }

      $name = get_the_author_meta( 'first_name', $author_id ) . ' ' . get_the_author_meta( 'last_name', $author_id );

      if ( function_exists( 'get_field' ) ) {
         $expertises = get_field( 'dh-user-expertise', 'user_' . $author_id );
      } else {
         $expertises = array();
      }

      $description = get_the_author_meta( 'user_description', $author_id );



      ?>
         <div class="dh-author-box">
            <div class="dh-author-box-image">
               <?php echo $avatar_img; ?>
            </div>
            
            <h3 class="dh-author-box-name">
               <?php 
                  if ( is_author() ) {
                     echo $name; 
                  } else {
                     echo '<a href="' . get_author_posts_url( $author_id ) . '">' . $name . '</a>'; 
                  }
               ?>
            </h3>

            <div class="dh-author-box-expertises">
               <?php
                  if ( is_array( $expertises ) ) {
                     if ( count( $expertises ) > 1 ) {
                        echo 'Expertises:&nbsp;';
                     } else {
                        echo 'Expertise:&nbsp;';
                     }
                     foreach ( $expertises as $index => $expertise ) {
                        echo '<a class="dh-author-box-expertise" href="' . $expertise['link'] . '">' . $expertise['label'] . ( $index < count( $expertises ) - 1 ? ',' : '' ) . '</a>';
                     }
                  }
               ?>
            </div>

            <div class="dh-author-box-description">
               <?php echo $description; ?>
            </div>

            <div class="dh-author-box-social-networks">
               <?php

                  $fasebook = get_user_meta( $author_id, 'facebook', true );
                  if ( $fasebook ) {
                     echo '<a class="dh-author-box-social-network dh-user-facebook" href="' . $fasebook . '" target="_blank"><i class="dh-icon dh-icon-facebook-f-brands"></i></a>';
                  }
                  $instagram = get_user_meta( $author_id, 'instagram', true );
                  if ( $instagram ) {
                     echo '<a class="dh-author-box-social-network dh-user-instagram" href="' . $instagram . '" target="_blank"><i class="dh-icon dh-icon-instagram-brands"></i></a>';
                  }
                  $linkedin = get_user_meta( $author_id, 'linkedin', true );
                  if ( $linkedin ) {
                     echo '<a class="dh-author-box-social-network dh-user-linkedin" href="' . $linkedin . '" target="_blank"><i class="dh-icon dh-icon-linkedin-in-brands"></i></a>';
                  }
                  $pinterest = get_user_meta( $author_id, 'pinterest', true );
                  if ( $pinterest ) {
                     echo '<a class="dh-author-box-social-network dh-user-pinterest" href="' . $pinterest . '" target="_blank"><i class="dh-icon dh-icon-pinterest-p-brands"></i></a>';
                  }
                  $twitter = get_user_meta( $author_id, 'twitter', true );
                  if ( $twitter ) {
                     echo '<a class="dh-author-box-social-network dh-user-twitter" href="' . $twitter . '" target="_blank"><i class="dh-icon dh-icon-twitter-brands"></i></a>';
                  }
                  $youtube = get_user_meta( $author_id, 'youtube', true );
                  if ( $youtube ) {
                     echo '<a class="dh-author-box-social-network dh-user-youtube" href="' . $youtube . '" target="_blank"><i class="dh-icon dh-icon-youtube-brands"></i></a>';
                  }
               ?>
            </div>
         </div>
      <?php
	}

	
}

// add link to name 
// repeater for admin only -
// logo as avatar fallback -