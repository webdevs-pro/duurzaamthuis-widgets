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
		return 'eicon-header';
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

            <div class="elementor-section elementor-section-boxed">

               <div class="dh-page-header-thumbnail-wrapper" style="min-width: 100%;">
                  <?php echo get_the_post_thumbnail( $post_id, 'full' ); ?>
               </div>

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

                     $subsidie = get_post_meta( $post_id, 'subsidie', true );
                     $subsidie_type = get_post_meta( $post_id, 'subsidie_type', true );
                     $subsidie_tooltip = get_post_meta( $post_id, 'subsidie_tooltip', true ) ?: 'Zie toelichting, of de <a href="/subsidies">subsidiepagina</a>';

                     $calculations_text = get_post_meta( $post_id, 'calculations-text', true );

                     $intro_text = get_post_meta( $post_id, 'intro-text', true );
                  ?>
                     
                  <?php if ( $milieuwinst || $prijs || $terugverdientijd || $gemak || $subsidie || $vervuiling ) : ?>
                     <div class="dh-page-header-impact">
                        <div class="dh-page-header-features-section">
                           <div class="dh-page-header-features-title">Impact</div>
                           <div class="dh-page-header-features">
                              <?php if ( $milieuwinst ) { ?>
                                 <div class="dh-page-header-feature">
                                    <div class="dh-page-header-feature-title">
                                       <i class="dh-icon dh-icon-benefit"></i>
                                       <!-- <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M13.9759 0.196643C13.9269 0.0776563 13.8104 0 13.6819 0C1.33321 0 0 5.11764 0 7.31817C0 8.10981 0.175643 8.84931 0.522471 9.51553C0.575928 9.6186 0.681557 9.68414 0.797385 9.68677C0.906828 9.68353 1.02203 9.62884 1.07993 9.5276C1.91357 8.0869 4.27447 4.53089 8.1735 2.64154C8.33324 2.56519 8.52414 2.63071 8.59986 2.78793C8.67623 2.94638 8.61003 3.13729 8.45224 3.21366C8.15824 3.35621 7.8757 3.51148 7.59887 3.67246C7.49325 3.73419 7.39078 3.79974 7.28707 3.864C7.13115 3.96074 6.97717 4.05936 6.82698 4.1612C6.67744 4.26176 6.52978 4.36484 6.3847 4.47047C6.33951 4.50354 6.29627 4.53729 6.25168 4.57103C2.37113 7.46264 4.10156e-05 12.0756 4.10156e-05 13.6819C4.10156e-05 13.8575 0.142598 14 0.318227 14C0.493855 14 0.636412 13.8575 0.636412 13.6819C0.636412 13.1689 0.985783 12.1292 1.64694 10.8889C2.60658 11.6735 3.89777 12.0909 5.40914 12.0909C9.49525 12.0909 10.3512 8.20274 10.8106 6.11357C11.4291 3.3021 12.7903 1.65966 13.9065 0.542842C13.9982 0.451828 14.0249 0.315629 13.9759 0.196643H13.9759Z" fill="black"/></svg> -->
                                       Milieuwinst
                                    </div>
                                    <div class="dh-page-header-feature-value milieuwinst"><?php echo $milieuwinst; ?></div>
                                 </div>
                              <?php } ?>

                              <?php if ( $prijs ) { ?>
                                 <div class="dh-page-header-feature">
                                    <div class="dh-page-header-feature-title">
                                       <i class="dh-icon dh-icon-euro-sign-solid"></i>
                                       <!-- <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12.0215 13.3044L11.6734 11.7236C11.6536 11.6306 11.6039 11.561 11.5242 11.5148C11.438 11.4683 11.3519 11.4618 11.2657 11.495L11.216 11.5148L11.0965 11.5445C11.0434 11.5577 10.9821 11.5727 10.9125 11.5892C10.8429 11.6058 10.7618 11.6222 10.6689 11.6389C10.5764 11.6555 10.4782 11.6705 10.3757 11.6837C10.273 11.6968 10.1621 11.7085 10.0427 11.7186C9.92326 11.7284 9.80407 11.7334 9.68466 11.7334C8.84274 11.7334 8.08533 11.5064 7.41258 11.0523C6.73972 10.5981 6.2442 9.98328 5.92606 9.20785H9.77396C9.84703 9.20785 9.91329 9.18299 9.97275 9.13321C10.0326 9.0836 10.0691 9.02235 10.0821 8.9492L10.3207 7.83552C10.3407 7.73637 10.3207 7.64675 10.2612 7.56714C10.1949 7.48753 10.1119 7.44769 10.0126 7.44769H5.44884C5.42895 6.99696 5.42895 6.64897 5.44884 6.40365H10.3011C10.4803 6.40365 10.5862 6.31755 10.6194 6.1452L10.858 5.01165C10.8778 4.91886 10.8548 4.83277 10.7883 4.75317C10.7289 4.67363 10.6461 4.63368 10.54 4.63368H5.88638C6.21783 3.89128 6.71496 3.30796 7.37792 2.8837C8.04082 2.45934 8.78987 2.24727 9.6251 2.24727C9.65171 2.23404 9.74941 2.23739 9.91831 2.25724C10.0873 2.27701 10.1836 2.28537 10.2067 2.28203C10.2296 2.27876 10.3161 2.28875 10.4651 2.31182C10.6143 2.335 10.6889 2.34664 10.6889 2.34664L10.863 2.38139C10.9128 2.39141 10.9509 2.39958 10.9773 2.40629L11.0172 2.41617C11.1033 2.44282 11.1826 2.43447 11.2558 2.39141C11.3287 2.3482 11.3752 2.28367 11.3952 2.19749L11.8228 0.616533C11.8425 0.530332 11.8325 0.450789 11.793 0.377904C11.7333 0.298224 11.6668 0.248527 11.594 0.228703C10.9842 0.0762616 10.3409 0 9.66492 0C8.17986 0 6.85259 0.424361 5.68253 1.27274C4.51252 2.1212 3.70541 3.24158 3.26125 4.63357H2.2869C2.19405 4.63357 2.11788 4.66336 2.05819 4.72301C1.99868 4.78259 1.96875 4.85887 1.96875 4.95172V6.08526C1.96875 6.17805 1.99857 6.25432 2.05819 6.31384C2.11792 6.37358 2.19419 6.40327 2.2869 6.40327H2.95314C2.93311 6.72155 2.92994 7.06938 2.94312 7.44742H2.28691C2.20075 7.44742 2.12618 7.47886 2.06321 7.54184C2.00028 7.60478 1.96876 7.67937 1.96876 7.76543V8.8891C1.96876 8.97537 2.00028 9.04975 2.06321 9.11292C2.12621 9.17584 2.20074 9.20707 2.28691 9.20707H3.23156C3.64917 10.6721 4.43808 11.8372 5.59812 12.7022C6.75825 13.5675 8.11387 13.9999 9.66493 13.9999C9.791 13.9999 9.91854 13.9968 10.0479 13.9899C10.1774 13.9833 10.2982 13.9732 10.4109 13.9601C10.5235 13.947 10.6346 13.9322 10.744 13.9155C10.8533 13.8989 10.9528 13.8825 11.0422 13.8657C11.1317 13.8493 11.2162 13.8327 11.2957 13.8162C11.3753 13.7995 11.4465 13.7815 11.5096 13.7614C11.5726 13.7418 11.6254 13.7268 11.6686 13.717C11.7118 13.707 11.7466 13.6952 11.7729 13.6822L11.8228 13.6722C11.8957 13.6457 11.952 13.5976 11.9918 13.5278C12.0316 13.4587 12.0414 13.384 12.0215 13.3044L12.0215 13.3044Z" fill="black"/></svg> -->
                                       Kosten
                                    </div>
                                    <div class="dh-page-header-feature-value"><?php echo esc_html( $prijs ); ?></div>
                                 </div>
                              <?php } ?>

                              <?php if ( $terugverdientijd ) { ?>
                                 <div class="dh-page-header-feature">
                                    <div class="dh-page-header-feature-title">
                                       <i class="dh-icon dh-icon-clock-solid"></i>
                                       <!-- <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M7 0.21875C3.25391 0.21875 0.21875 3.25391 0.21875 7C0.21875 10.7461 3.25391 13.7812 7 13.7812C10.7461 13.7812 13.7812 10.7461 13.7812 7C13.7812 3.25391 10.7461 0.21875 7 0.21875ZM9.52902 8.77734L8.98215 9.46094C8.90129 9.56141 8.77834 9.62516 8.64049 9.62516C8.53669 9.62516 8.44134 9.58902 8.36634 9.52864L8.36719 9.5293L6.53516 8.16977C6.28421 7.96764 6.125 7.66039 6.125 7.31596C6.125 7.3159 6.125 7.31586 6.125 7.31581V7.31582V3.0625C6.125 2.82088 6.32088 2.625 6.5625 2.625H7.4375C7.67912 2.625 7.875 2.82088 7.875 3.0625V7L9.46094 8.16211C9.5614 8.24296 9.62514 8.3659 9.62514 8.50374C9.62514 8.60766 9.58891 8.70313 9.52837 8.77818L9.52902 8.77734V8.77734Z" fill="black"/></svg> -->
                                       Terugverdientijd
                                    </div>
                                    <div class="dh-page-header-feature-value"><?php echo esc_html( $terugverdientijd ); ?></div>
                                 </div>
                              <?php } ?>

                              <?php if ( $gemak ) { ?>
                                 <div class="dh-page-header-feature">
                                    <div class="dh-page-header-feature-title">
                                       <i class="dh-icon dh-icon-chevron-circle-down-solid"></i>
                                       <!-- <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M13.7812 7C13.7812 10.7461 10.7461 13.7812 7 13.7812C3.25391 13.7812 0.21875 10.7461 0.21875 7C0.21875 3.25391 3.25391 0.21875 7 0.21875C10.7461 0.21875 13.7812 3.25391 13.7812 7ZM7.46484 10.1145L11.1699 6.40937C11.427 6.15234 11.427 5.73672 11.1699 5.48242L10.7051 5.01758C10.448 4.76055 10.0324 4.76055 9.77813 5.01758L7 7.7957L4.22187 5.01758C3.96484 4.76055 3.54922 4.76055 3.29492 5.01758L2.83008 5.48242C2.57305 5.73945 2.57305 6.15508 2.83008 6.40937L6.53516 10.1145C6.79219 10.3715 7.20781 10.3715 7.46484 10.1145Z" fill="black"/></svg> -->
                                       Gemak
                                    </div>
                                    <div class="dh-page-header-feature-value"><?php echo esc_html( $gemak ); ?></div>
                                 </div>
                              <?php } ?>

                              <?php if ( $subsidie ) { ?>
                                 <div class="dh-page-header-feature">
                                    <div class="dh-page-header-feature-title">
                                       <i class="dh-icon dh-icon-subsidy"></i>
                                       Subsidie<?php echo $subsidie_type == 'yes2' ? '<i class="dh-icon dh-icon-info dh-has-tooltip" data-dh-tooltip="' . esc_html( $subsidie_tooltip ) . '"></i>' : ''; ?>
                                    </div>
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
                           <!-- <svg width="10" height="12" viewBox="0 0 10 12" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M9.65934 9.64192C9.66807 9.15284 9.47593 8.68121 9.13533 8.33188C8.81219 8.00873 8.4017 7.77293 7.96503 7.64193C7.48468 7.49345 6.9956 7.38865 6.50652 7.34498C5.94757 7.29258 5.38862 7.26639 4.82967 7.26639C4.27945 7.26639 3.7205 7.29259 3.17028 7.34498C2.67247 7.38865 2.18339 7.48472 1.71177 7.6332C1.26636 7.7642 0.864618 8 0.532744 8.32315C0.192128 8.6725 0 9.13537 0 9.62446C0 10.1135 0.19214 10.5764 0.524014 10.9345C0.855887 11.2489 1.25764 11.4934 1.70304 11.6244C2.17466 11.7729 2.66374 11.869 3.16155 11.9214C3.7205 11.9738 4.27945 12 4.82967 12C5.38861 12 5.94756 11.9738 6.49778 11.9214C6.99559 11.8777 7.48467 11.7817 7.95629 11.6244C8.4017 11.5022 8.80344 11.2664 9.14406 10.9345C9.47593 10.5851 9.66807 10.1223 9.65934 9.64192V9.64192ZM8.3493 9.64192C8.35803 9.78165 8.29689 9.9214 8.20082 10.0262C8.02615 10.1834 7.80781 10.3057 7.57201 10.3755C7.18773 10.4978 6.78599 10.5764 6.3755 10.6114C5.86022 10.6638 5.34494 10.6899 4.82965 10.6899C4.31437 10.6899 3.79909 10.6637 3.29255 10.6114C2.88206 10.5764 2.48032 10.4978 2.08731 10.3668C1.85151 10.2969 1.63317 10.1747 1.4585 10.0087C1.36243 9.90393 1.31002 9.76418 1.31002 9.62445C1.31002 9.48471 1.36243 9.35371 1.4585 9.24889C1.64191 9.08296 1.85151 8.96068 2.08731 8.89082C2.48032 8.76854 2.88207 8.68121 3.29255 8.64627C3.80783 8.59386 4.32311 8.5764 4.82965 8.5764C5.34494 8.5764 5.86022 8.59388 6.3755 8.64627C6.78599 8.68993 7.18773 8.76854 7.58074 8.89955C7.81654 8.96068 8.02615 9.08296 8.20955 9.25763C8.30562 9.36243 8.35803 9.49343 8.34928 9.64191L8.3493 9.64192ZM4.81219 6.60263H4.82967C5.71176 6.60263 6.55018 6.25328 7.17027 5.63319C7.78162 5.01311 8.13097 4.17468 8.13097 3.30131C8.13097 2.42795 7.78162 1.58952 7.17027 0.969434C6.55018 0.349348 5.71176 0 4.82967 0C3.95631 0 3.11788 0.349348 2.4978 0.969434C1.87771 1.58952 1.5371 2.42795 1.5371 3.30131V3.31004C1.5371 4.18341 1.87771 5.01311 2.48905 5.63319C3.10914 6.25328 3.93883 6.59389 4.81219 6.60263V6.60263ZM2.77727 3.31004V3.30131C2.77727 2.75982 2.99562 2.23581 3.3799 1.85153C3.76418 1.46725 4.28819 1.2489 4.82968 1.2489C5.37989 1.2489 5.89518 1.46725 6.28819 1.85153C6.67247 2.23581 6.88207 2.75982 6.88207 3.30131C6.88207 3.8428 6.67247 4.36682 6.28819 4.7511C5.89518 5.13538 5.37989 5.35372 4.82968 5.35372H4.8122C4.27946 5.35372 3.75543 5.13538 3.3799 4.7511C2.99562 4.36682 2.77727 3.85153 2.77727 3.31005V3.31004Z" fill="black"/></svg> -->
                           <a class="dh-page-header-meta dh-page-header-meta-author-name" href="<?php echo get_author_posts_url( get_the_author_meta('ID') ); ?>"><?php echo get_the_author(); ?></a>
                        </div>
                        <div class="dh-page-header-meta-item">
                           <i class="dh-icon dh-icon-comments"></i>
                           <!-- <svg width="14" height="12" viewBox="0 0 14 12" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M11.9496 2.21062C11.9496 1.72124 11.5531 1.32566 11.0646 1.32566H2.21505C1.72568 1.32566 1.3301 1.72124 1.3301 2.21062V10.5805C1.3301 10.6549 1.41506 10.6965 1.47347 10.6496L3.5425 8.9947H11.0646C11.5531 8.9947 11.9496 8.59824 11.9496 8.10974V2.21062H11.9496ZM13.2743 2.21239V8.1062C13.2743 8.69913 13.0442 9.25665 12.6283 9.67258C12.2124 10.0885 11.6549 10.3186 11.0619 10.3186H4.00884L2.13274 11.823L1.86725 11.9204C1.72566 11.9735 1.57522 12 1.42478 12C1.04425 12 0.68141 11.8496 0.415934 11.5841C0.150457 11.3186 0 10.9558 0 10.5841V2.2124C0 1.61948 0.238934 1.06196 0.64602 0.646021C1.06195 0.230086 1.62832 0 2.21239 0H11.0619C11.6549 0 12.2124 0.230086 12.6283 0.646021C13.0443 1.06196 13.2743 1.61948 13.2743 2.2124L13.2743 2.21239Z" fill="black"/></svg> -->
                           <div class="dh-page-header-meta dh-page-header-meta-comments-count"><?php echo get_comments_number(); ?></div>
                        </div>
                        <div class="dh-page-header-meta-item">
                           <i class="dh-icon dh-icon-clock"></i>
                           <!-- <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M5.99987 1.35741C3.43549 1.35741 1.357 3.43589 1.357 6.00028C1.357 8.56465 3.43548 10.6432 5.99987 10.6432C8.56426 10.6432 10.6427 8.56464 10.6427 6.00028C10.6427 3.4359 8.56424 1.35741 5.99987 1.35741V1.35741ZM0.0712891 6.00027C0.0712891 2.72579 2.7254 0.0716858 5.99987 0.0716858C9.27431 0.0716858 11.9285 2.72579 11.9285 6.00027C11.9285 9.27472 9.27431 11.9289 5.99987 11.9289C2.7254 11.9289 0.0712891 9.27472 0.0712891 6.00027V6.00027Z" fill="black"/><path d="M5.80644 2.98395C6.16148 2.98395 6.4493 3.27177 6.4493 3.6268V6.03145L8.29006 7.12956C8.59499 7.31146 8.69468 7.70608 8.51279 8.01098C8.33091 8.31588 7.93627 8.41562 7.63136 8.23372L5.47709 6.94859C5.28266 6.8326 5.16357 6.6229 5.16357 6.39651V3.62681C5.16357 3.27177 5.4514 2.98396 5.80643 2.98396L5.80644 2.98395Z" fill="black"/></svg> -->
                           <div class="dh-page-header-meta dh-page-header-meta-reading-time"><?php echo post_read_time( $post_id ); ?> min leestijd</div>
                        </div>
                        <?php if ( get_post_modified_time( 'U', $post_id ) > strtotime('-1 year') ) { ?>
                           <div class="dh-page-header-meta-item">
                              <i class="dh-icon dh-icon-convenience"></i>
                              <!-- <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M10.4999 1.5H9.99998V0.499969C9.99998 0.224027 9.77595 0 9.49988 0H8.99994C8.72394 0 8.5 0.224027 8.5 0.499969V1.5H3.49994V0.499969C3.49994 0.224027 3.276 0 2.99998 0H2.50001C2.22397 0 1.99996 0.224027 1.99996 0.499969V1.5H1.49999C0.673005 1.5 0 2.17301 0 3V10.5C0 11.327 0.673005 12 1.49999 12H10.5C11.327 12 11.9999 11.327 11.9999 10.5V3C11.9999 2.17301 11.327 1.5 10.5 1.5H10.4999ZM10.9999 10.5C10.9999 10.7755 10.7754 10.9999 10.4999 10.9999H1.49996C1.22448 10.9999 0.999992 10.7755 0.999992 10.5V5.02002H10.9999V10.5H10.9999Z" fill="black"/><path d="M8.83407 6.13829C9.04557 6.33145 9.05629 6.65505 8.858 6.86108L6.233 9.58833C6.13374 9.69146 5.99511 9.74996 5.84999 9.74996C5.70486 9.74996 5.56623 9.69146 5.46697 9.58833L3.89199 7.952C3.69369 7.74597 3.7044 7.42235 3.91592 7.22919C4.12745 7.03603 4.45969 7.04647 4.658 7.25251L5.84998 8.49095L8.09193 6.16162C8.29024 5.95558 8.62249 5.94515 8.83406 6.1383L8.83407 6.13829Z" fill="black"/></svg> -->
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


