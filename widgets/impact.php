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
		// SECTION CONTENT
		$this->start_controls_section( 'section_content', [
         'label' => __( 'Content', 'duurzaamthuis' ),
         'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
      ] );
			$this->add_control( 'milieuwinst', [
				'label' => __( 'Milieuwinst', 'duurzaamthuis' ),
				'type' => \Elementor\Controls_Manager::TEXT,
			] );
			$this->add_control( 'prijs', [
				'label' => __( 'Prijs', 'duurzaamthuis' ),
				'type' => \Elementor\Controls_Manager::TEXT,
			] );
			$this->add_control( 'terugverdientijd', [
				'label' => __( 'Terugverdientijd', 'duurzaamthuis' ),
				'type' => \Elementor\Controls_Manager::TEXT,
			] );
			$this->add_control( 'gemak', [
				'label' => __( 'Gemak', 'duurzaamthuis' ),
				'type' => \Elementor\Controls_Manager::TEXT,
			] );
			$this->add_control( 'subsidie', [
				'label' => __( 'Subsidie', 'duurzaamthuis' ),
				'type' => \Elementor\Controls_Manager::TEXT,
			] );
			$this->add_control( 'vervuiling', [
				'label' => __( 'Vervuiling', 'duurzaamthuis' ),
				'type' => \Elementor\Controls_Manager::TEXT,
			] );
			$this->add_control( 'advies', [
				'label' => __( 'Advies', 'duurzaamthuis' ),
				'type' => \Elementor\Controls_Manager::TEXT,
			] );
			$this->add_control( 'calculations_text', [
				'label' => __( 'Calculations', 'duurzaamthuis' ),
				'type' => \Elementor\Controls_Manager::WYSIWYG,
			] );
		$this->end_controls_section(); 
	}

	public function is_number( $string ) {
      $string = str_replace( ',', '.', $string );
      if ( is_numeric( $string ) ) return true;
      return false;
   }

	protected function render() { // php template

		$settings = $this->get_settings_for_display();

		$milieuwinst = $settings['milieuwinst'];
		if ( $this->is_number( $milieuwinst ) ) {
			$milieuwinst = $milieuwinst . ' kilo СО<sub>2</sub>';
		} 

		$prijs = $settings['prijs'];
		if ( $this->is_number( $prijs ) ) {
			$prijs = $prijs . ' euro p/j';
		} 

		$terugverdientijd = $settings['terugverdientijd'];
		if ( $this->is_number( $terugverdientijd ) ) {
			$terugverdientijd = $terugverdientijd . ' jaar';
		} 

		$gemak = $settings['gemak'];
		if ( $this->is_number( $gemak ) ) {
			$gemak = $gemak . ' uur';
		} 

		$vervuiling = $settings['vervuiling'];
		
		$advies = $settings['advies'];

		$subsidie = $settings['subsidie'];

		$calculations_text = $settings['calculations_text'];


		if ( $milieuwinst || $prijs || $terugverdientijd || $gemak || $subsidie || $vervuiling || $advies || \Elementor\Plugin::$instance->editor->is_edit_mode() ) : ?>
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
		 		var milieuwinst = settings.milieuwinst;
				if(is_number(milieuwinst)) {
					milieuwinst = milieuwinst + ' kilo СО<sub>2</sub>';
				} 
		 		var prijs = settings.prijs;
				if(is_number(prijs)) {
					prijs = prijs + ' euro p/j';
				} 
		 		var terugverdientijd = settings.terugverdientijd;
				if(is_number(terugverdientijd)) {
					terugverdientijd = terugverdientijd + ' jaar';
				} 
		 		var gemak = settings.gemak;
				if(is_number(gemak)) {
					gemak = gemak + ' uur';
				} 

				var vervuiling = settings.vervuiling;
				
				var advies = settings.advies;

				var subsidie = settings.subsidie;

				var calculations_text = settings.calculations_text;
			#>
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
								<div class="dh-impact-feature-title"><i class="dh-icon dh-icon-subsidy"></i>Subsidie</div>
								<div class="dh-impact-feature-value">{{{ subsidie }}}</div>
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
		<?php
	}


	
}