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
			$classes = DH_Widgets_Content_Controls::get_prefix_classes( $this, $settings );
			if ( $settings['dh_how_to_faq_schema_type'] == 'how_to' && ! $settings['dh_how_to_faq_duration_days'] && ! $settings['dh_how_to_faq_duration_hours'] && ! $settings['dh_how_to_faq_duration_minutes'] ) {
				$classes .= ' dh-how-to-widget-notice';
				if ( ! Elementor\Plugin::$instance->preview->is_preview_mode() ) {
					return;
				}
			}
         ?><div class="<?php echo 'dh-widget-' . $this->get_name() . $classes; ?>"><?php



         echo '<div class="dh-how-to-faq">';
				echo '<h2 class="dh-how-to-faq-heading">' . esc_html( $settings['dh_how_to_faq_name'] ) . '</h2>';
            foreach (  $settings['dh_how_to_faq_items'] as $index => $item ) {
					echo '<div class="dh-how-to-faq-item">';
						echo '<div class="dh-how-to-faq-item-number">' . ( $index + ( $settings['dh_how_to_faq_start'] ?? 1 ) ) . '</div>';
						echo '<div class="dh-how-to-faq-item-content">';
							echo '<div class="dh-how-to-faq-item-heading">' . $item['dh_how_to_faq_item_heading'] . '</div>';
							$video_id = $this->get_youtube_video_id( $item['dh_how_to_faq_item_video_url']['url'] );
							if ( $video_id ) {
								echo '<div class="dh-youtube-video"><iframe style="position: absolute; left: 0; top: 0; width: 100%; height: 100%;" width="1280" height="720" src="https://www.youtube.com/embed/' . $video_id . '" frameborder="0" allowfullscreen></iframe></div>';
							}
							echo '<div class="dh-how-to-faq-item-text">' . wp_get_attachment_image( $item['dh_how_to_faq_item_image']['id'], 'medium'  ) . $item['dh_how_to_faq_item_text']. '</div>';
						echo '</div>';
					echo '</div>';
				}
         echo '</div>';

			?></div><?php 

			$schema = array();

			if ( $settings['dh_how_to_faq_schema_type'] == 'how_to' ) {
			
				$schema['@context'] = "https://schema.org/";
				$schema['@type'] = "HowTo";
				$schema['name'] = (string) $settings['dh_how_to_faq_name'];

				if ( $settings['dh_how_to_faq_items'] ) {
					foreach ( $settings['dh_how_to_faq_items'] as $item ) { 
						$step = [];

						$step['@type'] = "HowToStep";
						$step['name'] = $item['dh_how_to_faq_item_heading'];
						$step['text'] = $item['dh_how_to_faq_item_text'];
						if ( $item['dh_how_to_faq_item_image']['url'] ) {
							$step['image'] = $item['dh_how_to_faq_item_image']['url'];
						}
						// if ( $item['dh_how_to_faq_item_video_url']['url'] ) {
						// 	$step['video']['@type'] = "VideoObject";
						// 	$step['video']['contentUrl'] = $item['dh_how_to_faq_item_video_url']['url'];
						// }

						$schema['step'][] = $step;
					}
				}

				$days = $settings['dh_how_to_faq_duration_days'] ?? 0;
				$hours = $settings['dh_how_to_faq_duration_hours'] ?? 0;
				$minutes = $settings['dh_how_to_faq_duration_minutes'] ?? 0;
				$duration = '';
				if ( $days || $hours || $minutes ) {
					$duration = 'P';
					if ( $days ) {
						$duration .= $days . 'D';
					}
					if ( $hours || $minutes ) {
						$duration .= 'T';
					}
					if ( $hours ) {
						$duration .= $hours . 'H';
					}
					if ( $minutes ) {
						$duration .= $minutes . 'M';
					}
					$schema['totalTime'] = $duration;
				}
			} else if ( $settings['dh_how_to_faq_schema_type'] == 'faq' ) {
				$schema['@context'] = "https://schema.org/";
				$schema['@type'] = "FAQPage";
				$schema['name'] = (string) $settings['dh_product_review_title'];

				if ( $settings['dh_how_to_faq_items'] ) {
					foreach ( $settings['dh_how_to_faq_items'] as $item ) { 
						$answer = [];

						$answer['@type'] = "Question";
						$answer['name'] = $item['dh_how_to_faq_item_heading'];
						$answer['acceptedAnswer']['@type'] = "Answer";
						$answer['acceptedAnswer']['text'] = $item['dh_how_to_faq_item_text'];

						$schema['mainEntity'][] = $answer;
					}
				}

			}
			if ( ! empty( $schema ) ) {
				$schema_json = json_encode( $schema, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
				echo '<script type="application/ld+json">' . $schema_json . '</script>';
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
			<#
				if ( settings.dh_how_to_faq_schema_type == 'how_to' && ! settings.dh_how_to_faq_duration_days && ! settings.dh_how_to_faq_duration_hours && ! settings.dh_how_to_faq_duration_minutes ) {
					classes = classes + ' dh-how-to-widget-notice';
				}
			#>
			<div class="<?php echo 'dh-widget-' . $this->get_name(); ?>{{{ classes }}}">
				<div class="dh-how-to-faq">
					<h2 class="dh-how-to-faq-heading">{{ settings.dh_how_to_faq_name }}</h2>
					<# _.each( settings.dh_how_to_faq_items, function( item, index ) { #>
						<div class="dh-how-to-faq-item">
							<div class="dh-how-to-faq-item-number">{{{ index + ( settings.dh_how_to_faq_start ?? 1 ) }}}</div>
							<div class="dh-how-to-faq-item-content">
								<div class="dh-how-to-faq-item-heading">{{{ item.dh_how_to_faq_item_heading }}}</div>
								<# if ( item.dh_how_to_faq_item_video_url.url ) { #>
									<div class="dh-youtube-video"><div style="position: absolute; left: 0; top: 0; width: 100%; height: 100%; background: #ccc; display: flex; justify-content: center; align-items: center;">VIDEO AVAILABLE ONLY ON FRONTEND</div></div>
								<# } #>
								<div class="dh-how-to-faq-item-text">
									<# if ( item.dh_how_to_faq_item_image.url ) { #>
										<img src="{{{ item.dh_how_to_faq_item_image.url }}}">
									<# } #>
									{{{ item.dh_how_to_faq_item_text }}}
								</div>
							</div>
						</div>
					<# }); #>
				</div>
			</div>
		<# } #>
      <?php

	}

	public function get_youtube_video_id( $url ) {
		$pattern = '%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i';
		if ( preg_match( $pattern, $url, $match ) ) {
			return $match[1];
		} else {
			return '';
		}
	}
	
}