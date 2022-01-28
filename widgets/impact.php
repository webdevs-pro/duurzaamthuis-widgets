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

		$vervuiling = $settings['dh_impact_vervuiling'] ?? '';
		$subsidie = $settings['dh_impact_subsidie'];
		$subsidie_type = $settings['dh_impact_subsidie_type'];
		$calculations_text = $settings['dh_impact_calculations_text'];

		if ( $milieuwinst || $prijs || $terugverdientijd || $gemak || $subsidie || $vervuiling ) : ?>


			<?php 
				$e = new Exception(); 
				$is_multiwidget = strpos( $e->getTrace()[2]['file'], 'multiwidgets.php' ) ? true : false;
				echo sprintf( '<div class="%s"%s>',
					( $is_multiwidget ? 'elementor-element elementor-widget elementor-widget-' . $this->get_name() : '' ) . ' dh-widget-' . $this->get_name() . DH_Widgets_Content_Controls::get_prefix_classes( $this, $settings ),
					$is_multiwidget ? ' data-widget_type="' . $this->get_name() . '.default" data-element_type="widget"' : ''
				); 
			?>

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
									<div class="dh-impact-feature-title"><i class="dh-icon dh-icon-euro-sign-solid"></i>Kosten</div>
									<div class="dh-impact-feature-value"><?php echo $prijs; ?></div>
								</div>
							<?php } ?>

							<?php if ( $terugverdientijd ) { ?>
								<div class="dh-impact-feature">
									<div class="dh-impact-feature-title"><i class="dh-icon dh-icon-clock-solid"></i>Terugverdientijd</div>
									<div class="dh-impact-feature-value"><?php echo $terugverdientijd; ?></div>
								</div>
							<?php } ?>

							<?php if ( $gemak ) { ?>
								<div class="dh-impact-feature">
									<div class="dh-impact-feature-title"><i class="dh-icon dh-icon-chevron-circle-down-solid"></i>Gemak</div>
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
									<div class="dh-impact-feature-title"><i class="dh-icon dh-icon-subsidy"></i>Subsidie<?php echo $subsidie_type == 'yes' ? '<i class="dh-icon dh-icon-info" data-dh-tooltip="' . esc_html( 'Zie toelichting, of de <a href="/subsidies">subsidiepagina</a>' ). '"></i>' : ''; ?></div>
									<div class="dh-impact-feature-value"><?php echo $subsidie_type == 'yes' ? 'Ja' : 'Nee'; ?></div>
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
				var subsidie_type = settings.dh_impact_subsidie_type;

				var calculations_text = settings.dh_impact_calculations_text;

				function escapeHTML(html) {
					var fn=function(tag) {
						var charsToReplace = {
								'&': '&amp;',
								'<': '&lt;',
								'>': '&gt;',
								'"': '&#34;'
						};
						return charsToReplace[tag] || tag;
					}
					return html.replace(/[&<>"]/g, fn);
				}

				if ( milieuwinst || prijs || terugverdientijd || gemak || subsidie || vervuiling ) {
			#>
			<# 
				var classes = [];
				jQuery.each( view.model.attributes.settings.controls, function( index, value ) {
					if ( value.prefix_class && settings[index] && value.section == 'dh_impact_content' ) {
						if ( value.condition ) {
							var condition = Object.entries(value.condition)[0];
							if ( settings[condition[0]] ) {
								classes.push( value.prefix_class + settings[index] );
							}
						} else {
							classes.push( value.prefix_class + settings[index] );
						}
					}
				} ); 
				classes = ' ' + classes.join( ' ' );
			#>
         <div class="<?php echo 'dh-widget-' . $this->get_name(); ?>{{{ classes }}}">
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
									<div class="dh-impact-feature-title"><i class="dh-icon dh-icon-subsidy"></i>Subsidie<# subsidie_type == 'yes' ? print('<i class="dh-icon dh-icon-info" data-dh-tooltip="Zie toelichting, of de ' + escapeHTML( '<a href="/subsidies">subsidiepagina</a>' ) + '"></i>') : print() #></div>
									<div class="dh-impact-feature-value"><# subsidie_type == 'yes' ? print('Ja') : print('Nee') #></div>
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
			<# } #>
		<?php
	}


	
}