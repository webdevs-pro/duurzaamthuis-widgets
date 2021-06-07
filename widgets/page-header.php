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
		return 'dh-page-header';
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
         'label' => __( 'Content', 'magnific-addons' ),
         'tab' => Controls_Manager::TAB_CONTENT,
      ]);

         $this->add_control( 'show_infobar', [
            'label' => __( 'Show Infobar', 'plugin-domain' ),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => __( 'Show', 'your-plugin' ),
            'label_off' => __( 'Hide', 'your-plugin' ),
            'return_value' => 'yes',
            'default' => 'yes',
         ]);

		$this->end_controls_section(); 





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


               <?php if ( $settings['show_infobar'] ) { ?>
                  <?php
                     $milieuwinst = get_post_meta( $post_id, 'milieuwinst', true );
                     if ( is_numeric( $milieuwinst ) ) {
                        $milieuwinst = $milieuwinst . ' kilo CO2';
                     } 

                     $prijs = get_post_meta( $post_id, 'prijs', true );
                     if ( is_numeric( $prijs ) ) {
                        $prijs = $prijs . ' euro p/j';
                     } 

                     $terugverdientijd = get_post_meta( $post_id, 'terugverdientijd', true );
                     if ( is_numeric( $terugverdientijd ) ) {
                        $terugverdientijd = $terugverdientijd . ' jaar';
                     } 

                     $gemak = get_post_meta( $post_id, 'gemak', true );
                     if ( is_numeric( $gemak ) ) {
                        $gemak = $gemak . ' uur';
                     } 

                     $subsidie = get_post_meta( $post_id, 'subsidie', true );

                     $calculations_text = get_post_meta( $post_id, 'calculations-text', true );




                  ?>
                  <div class="dh-page-header-impact">
                     <div class="dh-page-header-features">
                        <div class="dh-page-header-features-title">Impact</div>
                        <?php if ( $milieuwinst ) { ?>
                           <div class="dh-page-header-feature">
                              <div class="dh-page-header-feature-title"><i class="dh-icon dh-icon-benefit"></i>Milieuwinst</div>
                              <div class="dh-page-header-feature-value"><?php echo $milieuwinst; ?></div>
                           </div>
                        <?php } ?>

                        <?php if ( $prijs ) { ?>
                           <div class="dh-page-header-feature">
                              <div class="dh-page-header-feature-title"><i class="dh-icon dh-icon-price"></i>Prijs</div>
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
               <?php } ?>



               <div class="dh-page-header-footer">
                  <div class="dh-page-header-meta">
                     <div class="dh-page-header-meta-item">
                        <i class="dh-icon dh-icon-user"></i>
                        <div class="dh-page-header-meta-author-name"><?php echo get_the_author(); ?></div>
                     </div>
                     <div class="dh-page-header-meta-item">
                        <i class="dh-icon dh-icon-comments"></i>
                        <div class="dh-page-header-meta-comments-count"><?php echo get_comments_number(); ?></div>
                     </div>
                     <div class="dh-page-header-meta-item">
                        <i class="dh-icon dh-icon-clock"></i>
                        <div class="dh-page-header-meta-comments-count"><?php echo post_read_time( $post_id ); ?> min leestijd</div>
                     </div>
                  </div>
                  <?php if ( function_exists('yoast_breadcrumb') ) { ?>
                     <div class="dh-page-header-meta-item dh-page-header-breadcrumbs">
                           <?php yoast_breadcrumb( '<nav class="yoast-breadcrumbs">', '</nav>' ); ?>
                     </div>
                  <?php } ?>
               </div>


            </div>

         </div>

      <?php


	}
	
}
