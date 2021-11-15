<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


class DH_How_To_Faq extends \Elementor\Widget_Base {

	public function get_name() {
		return 'dh-how-to-faq';
	}

	public function get_title() {
		return __( 'How to/FAQ list', 'duurzaamthuis' );
	}

	public function get_icon() {
		return 'dh-icon dh-icon-numbered-list';
	}

	public function get_categories() {
		return [ 'dh-widgets' ];
	}

	protected function register_controls() {
      DH_Widgets_Content_Controls::get_dh_how_to_faq_controls( $this );
	}

	protected function render() { // php template
		$settings = $this->get_settings_for_display();

		if ( $settings['dh_how_to_faq_items'] ) {
         ?><div class="<?php echo 'dh-widget-' . $this->get_name() . DH_Widgets_Content_Controls::get_prefix_classes( $this, $settings ); ?>"><?php

         echo '<div class="dh-how-to-faq">';
            foreach (  $settings['dh_how_to_faq_items'] as $index => $item ) {
					echo '<div class="dh-how-to-faq-item">';
						echo '<div class="dh-how-to-faq-item-number">' . ( $index + 1 ) . '</div>';
						echo '<div class="dh-how-to-faq-item-content">';
							echo '<div class="dh-how-to-faq-item-heading">' . $item['dh_how_to_faq_item_heading']. '</div>';
							echo '<div class="dh-how-to-faq-item-text">' . $item['dh_how_to_faq_item_text']. '</div>';
						echo '</div>';
					echo '</div>';
				}
         echo '</div>';

			?></div><?php 

			if ( $settings['dh_how_to_faq_schema_type'] == 'how_to' ) {
				?>
					<script type="application/ld+json">
						{
							"@context": "https://schema.org/",
							"@type": "HowTo",
							"name": "<?php echo esc_html( $settings['dh_how_to_faq_name'] ); ?>",
							"step": [
								<?php foreach ( $settings['dh_how_to_faq_items'] as $index => $item ) { ?>
								{
									"@type": "HowToStep",
									"name": "<?php echo esc_html( $item['dh_how_to_faq_item_heading'] ); ?>",
									"text": "<?php echo esc_html( $item['dh_how_to_faq_item_text'] ); ?>"
								}<?php echo $index < count( $settings['dh_how_to_faq_items'] ) - 1 ? ',' : ''; ?>
								<?php } ?>
							]
						}
					</script>
				<?php
			} else if ( $settings['dh_how_to_faq_schema_type'] == 'faq' ) {
				?>
					<script type="application/ld+json">
						{
							"@context": "https://schema.org/",
							"@type": "FAQPage",
							"mainEntity": [
								<?php foreach ( $settings['dh_how_to_faq_items'] as $index => $item ) { ?>
								{
									"@type": "Question",
									"name": "<?php echo esc_html( $item['dh_how_to_faq_item_heading'] ); ?>",
									"acceptedAnswer": {
										"@type": "Answer",
										"text": "<?php echo esc_html( $item['dh_how_to_faq_item_text'] ); ?>"
									}
								}<?php echo $index < count( $settings['dh_how_to_faq_items'] ) - 1 ? ',' : ''; ?>
								<?php } ?>
							]
						}
					</script>
				<?php
			}
		}

	}

	protected function content_template() { // php template
      ?>
		<# if ( settings.dh_how_to_faq_items ) { #>
			<# 
				var classes = [];
				jQuery.each( view.model.attributes.settings.controls, function( index, value ) {
					if ( value.prefix_class && settings[index] && value.section == 'dh_how_to_faq_section_content' ) {
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
				<div class="dh-how-to-faq">
					<# _.each( settings.dh_how_to_faq_items, function( item, index ) { #>
						<div class="dh-how-to-faq-item">
							<div class="dh-how-to-faq-item-number">{{{ index + 1 }}}</div>
							<div class="dh-how-to-faq-item-content">
								<div class="dh-how-to-faq-item-heading">{{{ item.dh_how_to_faq_item_heading }}}</div>
								<div class="dh-how-to-faq-item-text">{{{ item.dh_how_to_faq_item_text }}}</div>
							</div>
						</div>
					<# }); #>
				</div>
			</div>
		<# } #>
      <?php

	}
	
}