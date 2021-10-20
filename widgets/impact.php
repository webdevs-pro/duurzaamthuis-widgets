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

	public function get_script_depends() {
		return [ 'duurzaamthuis-widgets' ];
	}

	protected function register_controls() {
      DH_Widgets_Content_Controls::get_dh_impact_controls( $this );
	}

	public function is_number( $string ) {
      $string = str_replace( ',', '.', $string );
      if ( is_numeric( $string ) ) return true;
      return false;
   }

	protected function render() { // php template
		$settings = $this->get_settings_for_display();

		$milieuwinst = $settings['dh_impact_milieuwinst'];
		if ( $this->is_number( $milieuwinst ) ) {
			$milieuwinst = $milieuwinst . ' kilo СО<sub>2</sub> p/j';
		} 

		$prijs = $settings['dh_impact_prijs'];
		if ( $this->is_number( $prijs ) ) {
			$prijs = $prijs . ' euro';
		} 

		$terugverdientijd = $settings['dh_impact_terugverdientijd'];
		if ( $this->is_number( $terugverdientijd ) ) {
			$terugverdientijd = $terugverdientijd . ' jaar';
		} 

		$gemak = $settings['dh_impact_gemak'];
		if ( $this->is_number( $gemak ) ) {
			$gemak = $gemak . ' uur';
		} 

		$vervuiling = $settings['dh_impact_vervuiling'];
		$subsidie = $settings['dh_impact_subsidie'];
		$calculations_text = $settings['dh_impact_calculations_text'];

		if ( $milieuwinst || $prijs || $terugverdientijd || $gemak || $subsidie || $vervuiling || \Elementor\Plugin::$instance->editor->is_edit_mode() ) : ?>
         <div class="<?php echo 'dh-widget-' . $this->get_name() . DH_Widgets_Content_Controls::get_prefix_classes( $this, $settings ); ?>">
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

							<?php if ( $subsidie ) { ?>
								<div class="dh-impact-feature">
									<div class="dh-impact-feature-title"><i class="dh-icon dh-icon-subsidy"></i>Subsidie<i class="dh-icon dh-icon-info" data-dh-tooltip="Zie toelichting"></i></div>
									<div class="dh-impact-feature-value">Ja</div>
								</div>
							<?php } ?>
						</div>
					</div>
					<?php if ( $calculations_text ) { ?>
						<div class="dh-impact-calc">
							<div class="dh-impact-calc-toggle">
								<div class="dh-close">Sluiten<i class="dh-icon dh-icon-arrow-up"></i></div>
								<div class="dh-open">Toelichting<i class="dh-icon dh-icon-arrow-down"></i></div>
							</div>
							<div class="dh-impact-calc-text"><?php echo $calculations_text; ?></div>
						</div>
					<?php } ?>
				</div>
			</div>
		<?php endif; 

	}

	protected function content_template() { // js template
		?>
			<#
				function is_numeric( mixed_var ) {
					return (mixed_var == '') ? false : !isNaN(mixed_var);
				}
				function is_number(str) {
					str = str.replace(',', '.');
					if(is_numeric(str)) return true;
					return false;
				}
		 		var milieuwinst = settings.dh_impact_milieuwinst;
				if(is_number(milieuwinst)) {
					milieuwinst = milieuwinst + ' kilo СО<sub>2</sub> p/j';
				} 
		 		var prijs = settings.dh_impact_prijs;
				if(is_number(prijs)) {
					prijs = prijs + ' euro';
				} 
		 		var terugverdientijd = settings.dh_impact_terugverdientijd;
				if(is_number(terugverdientijd)) {
					terugverdientijd = terugverdientijd + ' jaar';
				} 
		 		var gemak = settings.dh_impact_gemak;
				if(is_number(gemak)) {
					gemak = gemak + ' uur';
				} 

				var vervuiling = settings.dh_impact_vervuiling;
				
				var advies = settings.dh_impact_advies;

				var subsidie = settings.dh_impact_subsidie;

				var calculations_text = settings.dh_impact_calculations_text;
			#>
			<# 
				setTimeout(function() {
					var classes = [];
					jQuery.each( view.el.classList, function( index, value ) {
						if ( value.startsWith('dh-') ) {	
							classes.push( value );
						}
					} );
					classes = ' ' + classes.join( ' ' );
					view.$el.find( '.<?php echo 'dh-widget-' . $this->get_name(); ?>' ).addClass(classes);
				}, 10 );
			#>
         <div class="<?php echo 'dh-widget-' . $this->get_name(); ?>">
				<div class="dh-impact">
					<div class="dh-impact-features-section">
						<div class="dh-impact-features-title">Impact</div>
						<div class="dh-impact-features">
							<# if(milieuwinst) { #>
								<div class="dh-impact-feature">
									<div class="dh-impact-feature-title"><i class="dh-icon dh-icon-benefit"></i>Milieuwinst</div>
									<div class="dh-impact-feature-value milieuwinst">{{{ milieuwinst }}}</div>
								</div>
							<# } #>

							<# if(prijs) { #>
								<div class="dh-impact-feature">
									<div class="dh-impact-feature-title"><i class="dh-icon dh-icon-price"></i>Kosten</div>
									<div class="dh-impact-feature-value">{{{ prijs }}}</div>
								</div>
							<# } #>

							<# if(terugverdientijd) { #>
								<div class="dh-impact-feature">
									<div class="dh-impact-feature-title"><i class="dh-icon dh-icon-payback"></i>Terugverdientijd</div>
									<div class="dh-impact-feature-value">{{{ terugverdientijd }}}</div>
								</div>
							<# } #>

							<# if(gemak) { #>
								<div class="dh-impact-feature">
									<div class="dh-impact-feature-title"><i class="dh-icon dh-icon-convenience"></i>Gemak</div>
									<div class="dh-impact-feature-value">{{{ gemak }}}</div>
								</div>
							<# } #>

							<# if(vervuiling) { #>
								<div class="dh-impact-feature">
									<div class="dh-impact-feature-title"><i class="dh-icon dh-icon-convenience"></i>Vervuiling</div>
									<div class="dh-impact-feature-value">{{{ vervuiling }}}</div>
								</div>
							<# } #>

							<# if(advies) { #>
								<div class="dh-impact-feature">
									<div class="dh-impact-feature-title"><i class="dh-icon dh-icon-convenience"></i>Advies</div>
									<div class="dh-impact-feature-value">{{{ advies }}}</div>
								</div>
							<# } #>

							<# if(subsidie) { #>
								<div class="dh-impact-feature">
									<div class="dh-impact-feature-title"><i class="dh-icon dh-icon-subsidy"></i>Subsidie<i class="dh-icon dh-icon-info" data-dh-tooltip="Zie toelichting"></i></div>
									<div class="dh-impact-feature-value">Ja</div>
								</div>
							<# } #>
						</div>
					</div>
					<# if(calculations_text) { #>
						<div class="dh-impact-calc">
							<div class="dh-impact-calc-toggle">
								<div class="dh-close">Sluiten<i class="dh-icon dh-icon-arrow-up"></i></div>
								<div class="dh-open">Toelichting<i class="dh-icon dh-icon-arrow-down"></i></div>
							</div>
							<div class="dh-impact-calc-text">{{{ calculations_text }}}</div>
						</div>
					<# } #>
				</div>
			</div>
		<?php
	}


	
}