<?php

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Modules\DynamicTags\Module as TagsModule;


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}



class DH_Page_Header extends \Elementor\Widget_Base {

	public function get_name() {
		return 'dh-page-header';
	}

	public function get_title() {
		return __( 'Page Header', 'duurzaamthuis' );
	}

	public function get_icon() {
		return 'dh-icon dh-icon-post-header';
	}

	public function get_categories() {
		return [ 'dh-widgets' ];
	}

   public function get_script_depends() {
		return [ 'duurzaamthuis-widgets' ];
	}

	protected function _register_controls() {

		// SECTION CONTENT
		$this->start_controls_section( 'section_content', [
         'label' => __( 'Content', 'duurzaamthuis' ),
         'tab' => Controls_Manager::TAB_CONTENT,
      ]);

         $this->add_control( 'show_infobar', [
            'label' => __( 'Show Infobar', 'duurzaamthuis' ),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => __( 'Show', 'your-plugin' ),
            'label_off' => __( 'Hide', 'your-plugin' ),
            'return_value' => 'yes',
            'default' => '',
         ]);

		$this->end_controls_section(); 


		// SECTION STYLE
		$this->start_controls_section( 'section_style', [
         'label' => __( 'Style', 'duurzaamthuis' ),
         'tab' => Controls_Manager::TAB_STYLE,
      ]);

         $this->add_control( 'text_color', [
            'label' => __( 'Text Color', 'duurzaamthuis' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#FFFFFF',
            'selectors' => [
               '{{WRAPPER}} .dh-page-header-title' => 'color: {{VALUE}}',
               '{{WRAPPER}} .dh-page-header-features-title' => 'color: {{VALUE}}',
               '{{WRAPPER}} .dh-page-header-feature-title' => 'color: {{VALUE}}',
               '{{WRAPPER}} .dh-page-header-feature-value' => 'color: {{VALUE}}',
               '{{WRAPPER}} .dh-page-header-meta' => 'color: {{VALUE}}',
               '{{WRAPPER}} .dh-page-header-calc-toggle .open' => 'color: {{VALUE}}',
               '{{WRAPPER}} .dh-page-header-calc-toggle .close' => 'color: {{VALUE}}',
               '{{WRAPPER}} .dh-page-header-calc-text' => 'color: {{VALUE}}',
               '{{WRAPPER}} .dh-page-header-tag a' => 'color: {{VALUE}}',
               '{{WRAPPER}} ..dh-page-header-breadcrumbs i' => 'color: {{VALUE}}',

            ],
         ]);
         $this->add_control( 'first_tag_background_color', [
            'label' => __( 'First Tag Background Color', 'duurzaamthuis' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#769179',
            'selectors' => [
               '{{WRAPPER}} .dh-page-header-tag:first-child' => 'color: {{VALUE}}',
            ],
         ]);
         $this->add_control( 'impact_icons_color', [
            'label' => __( 'Impact Icons Color', 'duurzaamthuis' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#54CC8B',
            'selectors' => [
               '{{WRAPPER}} .dh-page-header-feature-title i' => 'color: {{VALUE}}',
            ],
         ]);
         $this->add_control( 'meta_icons_color', [
            'label' => __( 'Meta Icons Color', 'duurzaamthuis' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#769179',
            'selectors' => [
               '{{WRAPPER}} .dh-page-header-meta-item i' => 'color: {{VALUE}}',
            ],
         ]);

		$this->end_controls_section(); 





	}


   public function is_number( $string ) {
      $string = str_replace( ',', '.', $string );
      error_log( "string\n" . print_r($string, true) . "\n" );
      if ( is_numeric( $string ) ) return true;
      return false;
   }

	protected function render() { // php template

		$settings = $this->get_settings_for_display();
      $post_id = get_the_ID();
      $featured_image_url = get_the_post_thumbnail_url( $post_id, 'full' );
      $tags = wp_get_post_terms( $post_id, 'post_tag', array('fields' => 'ids') );

      ?>
         <div class="elementor-section elementor-section-boxed" style="background-image: url(<?php echo $featured_image_url; ?>);">

            <div class="dh-overlay"></div>

            <div class="dh-page-header elementor-container">

               <ul class="dh-page-header-tags">
                  <?php foreach ( $tags as $tag_id ) {
                     $tag_name = get_term( $tag_id ) -> name;
                     $tag_link = get_term_link( $tag_id, 'post_tag' );
                     ?>
                        <li class="dh-page-header-tag">
                           <a href="<?php echo $tag_link; ?>"><?php echo $tag_name; ?></a>
                        </li>
                     <?php
                  } ?>
               </ul>

               <h1 class="dh-page-header-title"><?php echo get_the_title( $post_id ); ?></h1>


               
               <?php
                  $milieuwinst = get_post_meta( $post_id, 'milieuwinst', true );
                  if ( $this->is_number( $milieuwinst ) ) {
                     $milieuwinst = $milieuwinst . ' kilo СО<sub>2</sub>';
                  } 

                  $prijs = get_post_meta( $post_id, 'prijs', true );
                  if ( $this->is_number( $prijs ) ) {
                     $prijs = $prijs . ' euro p/j';
                  } 

                  $terugverdientijd = get_post_meta( $post_id, 'terugverdientijd', true );
                  if ( $this->is_number( $terugverdientijd ) ) {
                     $terugverdientijd = $terugverdientijd . ' jaar';
                  } 

                  $gemak = get_post_meta( $post_id, 'gemak', true );
                  if ( $this->is_number( $gemak ) ) {
                     $gemak = $gemak . ' uur';
                  } 

                  $subsidie = get_post_meta( $post_id, 'subsidie', true );
                  $calculations_text = get_post_meta( $post_id, 'calculations-text', true );
               ?>
                  
               <?php if ( $settings['show_infobar'] && ( $milieuwinst || $prijs || $terugverdientijd || $gemak || $subsidie ) ) : ?>
                  <div class="dh-page-header-impact">
                     <div class="dh-page-header-features">
                        <div class="dh-page-header-features-title">Impact</div>
                        <?php if ( $milieuwinst ) { ?>
                           <div class="dh-page-header-feature">
                              <div class="dh-page-header-feature-title"><i class="dh-icon dh-icon-benefit"></i>Milieuwinst</div>
                              <div class="dh-page-header-feature-value milieuwinst"><?php echo $milieuwinst; ?></div>
                           </div>
                        <?php } ?>

                        <?php if ( $prijs ) { ?>
                           <div class="dh-page-header-feature">
                              <div class="dh-page-header-feature-title"><i class="dh-icon dh-icon-price"></i>Kosten</div>
                              <div class="dh-page-header-feature-value"><?php echo $prijs; ?></div>
                           </div>
                        <?php } ?>

                        <?php if ( $terugverdientijd ) { ?>
                           <div class="dh-page-header-feature">
                              <div class="dh-page-header-feature-title"><i class="dh-icon dh-icon-payback"></i>Terugverdientijd</div>
                              <div class="dh-page-header-feature-value"><?php echo $terugverdientijd; ?></div>
                           </div>
                        <?php } ?>

                        <?php if ( $gemak ) { ?>
                           <div class="dh-page-header-feature">
                              <div class="dh-page-header-feature-title"><i class="dh-icon dh-icon-convenience"></i>Gemak</div>
                              <div class="dh-page-header-feature-value"><?php echo $gemak; ?></div>
                           </div>
                        <?php } ?>

                        <?php if ( $subsidie ) { ?>
                           <div class="dh-page-header-feature">
                              <div class="dh-page-header-feature-title"><i class="dh-icon dh-icon-subsidy"></i>Subsidie</div>
                              <div class="dh-page-header-feature-value"><?php echo $subsidie; ?></div>
                           </div>
                        <?php } ?>
                     </div>


                     <?php if ( $calculations_text ) { ?>
                        <div class="dh-page-header-calc">
                           <div class="dh-page-header-calc-toggle">
                              <div class="close">Close Calculation<i class="dh-icon dh-icon-arrow-up"></i></div>
                              <div class="open">Open Calculation<i class="dh-icon dh-icon-arrow-down"></i></div>
                           </div>
                           <div class="dh-page-header-calc-text"><?php echo $calculations_text; ?></div>
                        </div>
                     <?php } ?>
                  </div>
               <?php endif; ?>



               <div class="dh-page-header-footer">
                  <div class="dh-page-header-meta-items">
                     <div class="dh-page-header-meta-item">
                        <i class="dh-icon dh-icon-user"></i>
                        <a class="dh-page-header-meta dh-page-header-meta-author-name" href="<?php echo get_author_posts_url( get_the_author_meta('ID') ); ?>"><?php echo get_the_author(); ?></a>
                     </div>
                     <div class="dh-page-header-meta-item">
                        <i class="dh-icon dh-icon-comments"></i>
                        <div class="dh-page-header-meta dh-page-header-meta-comments-count"><?php echo get_comments_number(); ?></div>
                     </div>
                     <div class="dh-page-header-meta-item">
                        <i class="dh-icon dh-icon-clock"></i>
                        <div class="dh-page-header-meta dh-page-header-meta-reading-time"><?php echo post_read_time( $post_id ); ?> min leestijd</div>
                     </div>
                  </div>
                  <?php if ( function_exists('yoast_breadcrumb') ) { ?>
                     <div class="dh-page-header-meta dh-page-header-meta-item dh-page-header-breadcrumbs">
                           <?php yoast_breadcrumb( '<nav class="yoast-breadcrumbs">', '</nav>' ); ?>
                     </div>
                  <?php } ?>
               </div>


            </div>

         </div>

      <?php


	}
	
}
