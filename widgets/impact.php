<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


class DH_Impact extends \Elementor\Widget_Base {

	public function get_name() {
		return 'dh-impact';
	}

	public function get_title() {
		return __( 'Impact', 'duurzaamthuis' );
	}

	public function get_icon() {
		return 'dh-icon dh-icon-impact';
	}

	public function get_categories() {
		return [ 'dh-widgets' ];
	}

	protected function register_controls() {

	}

	public function is_number( $string ) {
      $string = str_replace( ',', '.', $string );
      if ( is_numeric( $string ) ) return true;
      return false;
   }

	protected function render() { // php template

		$settings = $this->get_settings_for_display();

      $post_id = get_the_ID();

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

		$vervuiling = get_post_meta( $post_id, 'vervuiling', true );
		
		$advies = get_post_meta( $post_id, 'advies', true );

		$subsidie = get_post_meta( $post_id, 'subsidie', true );

		if ( $milieuwinst || $prijs || $terugverdientijd || $gemak || $subsidie || $vervuiling || $advies ) : ?>
			<div class="dh-impact">
				<div class="dh-impact-features-section">
					<div class="dh-impact-features-title">Impact</div>
					<div class="dh-impact-features">
						<?php if ( $milieuwinst ) { ?>
							<div class="dh-impact-feature">
								<div class="dh-impact-feature-title"><i class="dh-icon dh-icon-benefit"></i>Milieuwinst</div>
								<div class="dh-impact-feature-value milieuwinst"><?php echo $milieuwinst; ?></div>
							</div>
						<?php } ?>

						<?php if ( $prijs ) { ?>
							<div class="dh-impact-feature">
								<div class="dh-impact-feature-title"><i class="dh-icon dh-icon-price"></i>Kosten</div>
								<div class="dh-impact-feature-value"><?php echo $prijs; ?></div>
							</div>
						<?php } ?>

						<?php if ( $terugverdientijd ) { ?>
							<div class="dh-impact-feature">
								<div class="dh-impact-feature-title"><i class="dh-icon dh-icon-payback"></i>Terugverdientijd</div>
								<div class="dh-impact-feature-value"><?php echo $terugverdientijd; ?></div>
							</div>
						<?php } ?>

						<?php if ( $gemak ) { ?>
							<div class="dh-impact-feature">
								<div class="dh-impact-feature-title"><i class="dh-icon dh-icon-convenience"></i>Gemak</div>
								<div class="dh-impact-feature-value"><?php echo $gemak; ?></div>
							</div>
						<?php } ?>

						<?php if ( $vervuiling ) { ?>
							<div class="dh-impact-feature">
								<div class="dh-impact-feature-title"><i class="dh-icon dh-icon-convenience"></i>Vervuiling</div>
								<div class="dh-impact-feature-value"><?php echo $vervuiling; ?></div>
							</div>
						<?php } ?>

						<?php if ( $advies ) { ?>
							<div class="dh-impact-feature">
								<div class="dh-impact-feature-title"><i class="dh-icon dh-icon-convenience"></i>Advies</div>
								<div class="dh-impact-feature-value"><?php echo $advies; ?></div>
							</div>
						<?php } ?>

						<?php if ( $subsidie ) { ?>
							<div class="dh-impact-feature">
								<div class="dh-impact-feature-title"><i class="dh-icon dh-icon-subsidy"></i>Subsidie</div>
								<div class="dh-impact-feature-value"><?php echo $subsidie; ?></div>
							</div>
						<?php } ?>
					</div>
				</div>

			</div>
		<?php endif; 

	}


	
}