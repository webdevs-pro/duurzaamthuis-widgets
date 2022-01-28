<?php

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

	protected function register_controls() {
      DH_Widgets_Content_Controls::get_dh_page_header_controls( $this );
	}


   public function is_number( $string ) {
      $string = str_replace( ',', '.', $string );
      if ( is_numeric( $string ) ) return true;
      return false;
   }


	protected function render() { // php template

		$settings = $this->get_settings_for_display();
      $post_id = get_the_ID();
      $featured_image_url = get_the_post_thumbnail_url( $post_id, 'full' );
      $tags = wp_get_post_terms( $post_id, 'post_tag', array('fields' => 'ids') );

      ?>
         <!-- Impact section -->
         <?php 
				$e = new Exception(); 
				$is_multiwidget = strpos( $e->getTrace()[2]['file'], 'multiwidgets.php' ) ? true : false;
				echo sprintf( '<div class="%s"%s>',
					( $is_multiwidget ? 'elementor-element elementor-widget elementor-widget-' . $this->get_name() : '' ) . ' dh-widget-' . $this->get_name() . DH_Widgets_Content_Controls::get_prefix_classes( $this, $settings ),
					$is_multiwidget ? ' data-widget_type="' . $this->get_name() . '.default" data-element_type="widget"' : ''
				); 
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
                        $milieuwinst = $milieuwinst . ' kilo СО<sub>2</sub> p/j';
                     } 

                     $prijs = get_post_meta( $post_id, 'prijs', true );
                     if ( $this->is_number( $prijs ) ) {
                        $prijs = $prijs . ' euro';
                     } 

                     $terugverdientijd = get_post_meta( $post_id, 'terugverdientijd', true );
                     if ( $this->is_number( $terugverdientijd ) ) {
                        $terugverdientijd = $terugverdientijd . ' jaar';
                     } 

                     $gemak = get_post_meta( $post_id, 'gemak', true );
                     if ( $this->is_number( $gemak ) ) {
                        $gemak = $gemak . ' uur';
                     } 

                     $vervuiling = get_post_meta( $post_id, 'vervuiling', true );
                     
                     $advies = get_post_meta( $post_id, 'advies', true );

                     $subsidie = get_post_meta( $post_id, 'subsidie', true );
                     $subsidie_type = get_post_meta( $post_id, 'subsidie_type', true );

                     $calculations_text = get_post_meta( $post_id, 'calculations-text', true );

                     $intro_text = get_post_meta( $post_id, 'intro-text', true );
                  ?>
                     
                  <?php if ( $milieuwinst || $prijs || $terugverdientijd || $gemak || $subsidie || $vervuiling || $advies ) : ?>
                     <div class="dh-page-header-impact">
                        <div class="dh-page-header-features-section">
                           <div class="dh-page-header-features-title">Impact</div>
                           <div class="dh-page-header-features">
                              <?php if ( $milieuwinst ) { ?>
                                 <div class="dh-page-header-feature">
                                    <div class="dh-page-header-feature-title"><i class="dh-icon dh-icon-benefit"></i>Milieuwinst</div>
                                    <div class="dh-page-header-feature-value milieuwinst"><?php echo $milieuwinst; ?></div>
                                 </div>
                              <?php } ?>

                              <?php if ( $prijs ) { ?>
                                 <div class="dh-page-header-feature">
                                    <div class="dh-page-header-feature-title"><i class="dh-icon dh-icon-euro-sign-solid"></i>Kosten</div>
                                    <div class="dh-page-header-feature-value"><?php echo $prijs; ?></div>
                                 </div>
                              <?php } ?>

                              <?php if ( $terugverdientijd ) { ?>
                                 <div class="dh-page-header-feature">
                                    <div class="dh-page-header-feature-title"><i class="dh-icon dh-icon-clock-solid"></i>Terugverdientijd</div>
                                    <div class="dh-page-header-feature-value"><?php echo $terugverdientijd; ?></div>
                                 </div>
                              <?php } ?>

                              <?php if ( $gemak ) { ?>
                                 <div class="dh-page-header-feature">
                                    <div class="dh-page-header-feature-title"><i class="dh-icon dh-icon-chevron-circle-down-solid"></i>Gemak</div>
                                    <div class="dh-page-header-feature-value"><?php echo $gemak; ?></div>
                                 </div>
                              <?php } ?>

                              <!-- <?php if ( $vervuiling ) { ?>
                                 <div class="dh-page-header-feature">
                                    <div class="dh-page-header-feature-title"><i class="dh-icon dh-icon-convenience"></i>Vervuiling</div>
                                    <div class="dh-page-header-feature-value"><?php echo $vervuiling; ?></div>
                                 </div>
                              <?php } ?> -->

                              <?php if ( $advies ) { ?>
                                 <div class="dh-page-header-feature">
                                    <div class="dh-page-header-feature-title"><i class="dh-icon dh-icon-convenience"></i>Advies</div>
                                    <div class="dh-page-header-feature-value"><?php echo $advies; ?></div>
                                 </div>
                              <?php } ?>

                              <?php if ( $subsidie ) { ?>
                                 <div class="dh-page-header-feature">
                                    <div class="dh-page-header-feature-title"><i class="dh-icon dh-icon-subsidy"></i>Subsidie<?php echo $subsidie_type == 'yes2' ? '<i class="dh-icon dh-icon-info dh-has-tooltip" data-dh-tooltip="' . esc_html( 'Zie toelichting, of de <a href="/subsidies">subsidiepagina</a>' ). '"></i>' : ''; ?></div>
                                    <div class="dh-page-header-feature-value"><?php echo $subsidie_type == 'yes2' ? 'Ja' : 'Nee'; ?></div>
                                 </div>
                              <?php } ?>
                           </div>
                        </div>


                        <?php if ( $calculations_text ) { ?>
                           <div class="dh-page-header-calc">
                              <div class="dh-page-header-calc-toggle">
                                 <div class="dh-close">Sluiten<i class="dh-icon dh-icon-arrow-up"></i></div>
                                 <div class="dh-open">Toelichting<i class="dh-icon dh-icon-arrow-down"></i></div>
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
                        <?php if ( get_post_modified_time( 'U', $post_id ) > strtotime('-1 year') ) { ?>
                           <div class="dh-page-header-meta-item">
                              <i class="dh-icon dh-icon-convenience"></i>
                              <div class="dh-page-header-meta dh-page-header-meta-last-updated"><?php echo human_time_diff( get_post_modified_time( 'U', false, $post_id ), current_time( 'timestamp' ) ) . ' geleden'; ?></div>
                           </div>
                        <?php } ?>
                     </div>
                     <?php if ( function_exists('yoast_breadcrumb') ) { ?>
                        <div class="dh-page-header-meta dh-page-header-meta-item dh-page-header-breadcrumbs">
                              <?php yoast_breadcrumb( '<nav class="yoast-breadcrumbs">', '</nav>' ); ?>
                        </div>
                     <?php } ?>
                  </div>

               </div>

            </div>
            
            
            <!-- Intro section -->
            <?php if ( $intro_text ) { ?>
               <div class="elementor-section elementor-section-boxed">
                  <div class="dh-page-intro elementor-container">
                     <?php echo $intro_text; ?>
                  </div>
               </div>
            <?php } ?>
               
         </div>
      <?php


	}
	
}


