<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class DH_Company_Offer extends \Elementor\Widget_Base {

   public $price;
   public $last_updated;

	public function get_name() {
		return 'dh-company-offer';
	}

	public function get_title() {
		return __( 'Company offer', 'duurzaamthuis' );
	}

	public function get_icon() {
		return 'eicon-price-table';
	}

	public function get_categories() {
		return [ 'dh-widgets' ];
	}

   public function get_script_depends() {
		return [ 'duurzaamthuis-widgets' ];
	}

	protected function register_controls() {
      DH_Widgets_Content_Controls::get_dh_company_offer_controls( $this );
	}


   
   protected function render_rating( $rating ) {
      $rating = $rating * 10;
      ob_start();
      echo '<div class="dh-rating">';
         echo '<div class="dh-rating-bg">';
            for ( $stars = 1; $stars <= 5; $stars++ ) {
               echo '<i class="dh-icon dh-icon-benefit"></i>';
            }
         echo '</div>';
         echo '<div class="dh-rating-fg" style="width: ' . $rating . '%">';
            for ( $stars = 1; $stars <= 5; $stars++ ) {
               echo '<i class="dh-icon dh-icon-benefit"></i>';
            }
         echo '</div>';
      echo '</div>';
      return ob_get_clean();
   }

   public static function get_site_logo() {
      $logo = wp_get_attachment_image_src( get_theme_mod( 'custom_logo' ), 'full' );
      if ( $logo ) {
         $logo_url = $logo[0];
      } else {
         $logo_url = Elementor\Utils::get_placeholder_image_src();
      }
      return $logo_url;
   }


   public function is_number( $string ) {
      $string = str_replace( ',', '.', $string );
      if ( is_numeric( $string ) ) return true;
      return false;
   }
   

	protected function render() { // php template
		$settings = $this->get_settings_for_display();
      
		if ( $settings['dh_company_offer_products'] ) :
         ?><div class="<?php echo 'dh-widget-' . $this->get_name() . DH_Widgets_Content_Controls::get_prefix_classes( $this, $settings ); ?>" data-form-id="<?php echo $settings['dh_company_offer_form_id']; ?>" data-hidden-form-field-id="<?php echo $settings['dh_company_offer_hidden_form_field_id']; ?>"><?php
            echo '<div class="dh-products-score-grid dh-products-' . $settings['dh_company_offer_skin'] . '-skin">';
               foreach ( $settings['dh_company_offer_products'] as $index => $item ) :
                  echo '<div class="dh-product dh-product-' . $item['_id'] . '">';
                     echo '<div class="dh-product-wrapper">';
                        echo '<div class="dh-product-column">';
                           echo '<h3 class="dh-product-heading">';
                              echo '<div class="dh-number">' . ( $index + 1 ) . '</div>';
                              echo '<div class="dh-heading">' . $item['dh_company_offer_title'] . '</div>';
                           echo '</h3>'; // dh-product-heading
                           echo '<div class="dh-product-image">';
                              if ( $item['dh_company_offer_badge'] ) {
                                 switch ( $item['dh_company_offer_badge'] ) {
                                    case 'best_price':
                                       echo '<div class="dh-product-badge dh-product-price-badge">Beste prijs</div>';
                                       break;
                                    case 'best_quality':
                                       echo '<div class="dh-product-badge dh-product-quality-badge">Beste kwaliteit</div>';
                                       break;
                                    case 'our_choice':
                                       echo '<div class="dh-product-badge dh-product-our-badge">Onze keuze</div>';
                                       break;
                                    case 'eco_choice':
                                       echo '<div class="dh-product-badge dh-product-eco-badge">Beste eco keuze</div>';
                                       break;
                                 }
                              }
                              echo '<div class="dh-product-image-wrapper">';
                                 if ( $item['dh_company_offer_image']['id'] ) {
                                    echo wp_get_attachment_image( $item['dh_company_offer_image']['id'], 'medium' );
                                 } else {
                                    echo '<img src="' . Elementor\Utils::get_placeholder_image_src() . '">';
                                 }
                              echo '</div>'; // dh-product-image-wrapper
                           echo '</div>'; // dh-product-image
                           // if ( $item['dh_company_offer_quality'] ) {
                           //    echo '<div class="dh-product-quality">';
                           //       echo '<div>Kwaliteit</div>';
                           //       echo '<div>';
                           //       echo $item['dh_company_offer_quality'];
                           //       if ( $item['dh_company_offer_quality_tooltip'] ) {
                           //          echo '<i class="dh-icon dh-icon-info" data-dh-tooltip="' . esc_html( $item['dh_company_offer_quality_tooltip'] ) . '"></i>';
                           //       } else {
                           //          if ( $item['dh_company_offer_quality_amount1'] && $item['dh_company_offer_quality_source1'] ) {
                           //             $quality_tooltip = 'Gebaseerd op ' . $item['dh_company_offer_quality_amount1'] . ' reviews op ' . $item['dh_company_offer_quality_source1'];
                           //             if ( $item['dh_company_offer_quality_amount2'] && $item['dh_company_offer_quality_source2'] ) {
                           //                $quality_tooltip .= ' en ' . $item['dh_company_offer_quality_amount2'] . ' op ' . $item['dh_company_offer_quality_source2'];
                           //             }
                           //             echo '<i class="dh-icon dh-icon-info" data-dh-tooltip="' . esc_html( $quality_tooltip ) . '"></i>';
                           //          }
                           //       }
                           //       echo '</div>';
                           //    echo '</div>';
                           // }
                           // if ( $item['dh_company_offer_co2'] || $item['dh_company_offer_co2_custom_label'] ) {
                           //    echo '<div class="dh-product-co2">';
                           //       echo '<div>' . ( $item['dh_company_offer_co2_custom_label'] ?: 'CO<sub>2</sub>-afdruk' ) . '</div>';
                           //       echo '<div>';
                           //          $co2 = $item['dh_company_offer_co2'];
                           //          if ( ! $item['dh_company_offer_co2_custom_label'] && $this->is_number( $co2 ) ) {
                           //             $co2 = $co2 . 'kg CO<sub>2</sub> p/j';
                           //          } 
                           //          echo $co2;
                           //          if ( $item['dh_company_offer_co2_tooltip'] ) {
                           //             echo '<i class="dh-icon dh-icon-info" data-dh-tooltip="' . esc_html( $item['dh_company_offer_co2_tooltip'] ) . '"></i>';
                           //          }
                           //       echo '</div>';
                           //    echo '</div>'; // dh-product-co2
                           // }
                           // $price = $item['dh_company_offer_price'] ? '€' . $item['dh_company_offer_price'] : ( $dfrcs_set_cache['price'] ?? '' );
                           // $last_updated = $item['dh_company_offer_price_tooltip'] ?: ( isset( $dfrcs_set_cache['last_updated'] ) ? 'Laatste update: ' . $dfrcs_set_cache['last_updated'] : '' );
                           // if ( $price ) {
                           //    echo '<div class="dh-product-price">';
                           //       echo '<div>Prijs</div>';
                           //       echo '<div>';
                           //       echo $price;
                           //       if ( $last_updated ) {
                           //          echo '<i class="dh-icon dh-icon-info" data-dh-tooltip="' . esc_html( $last_updated ) . '"></i>';
                           //       }
                           //       echo '</div>';
                           //    echo '</div>';
                           // }
                           // if ( $item['dh_company_offer_rating'] ) {
                           //    echo '<div class="dh-product-score">';
                           //       echo '<img src="' . $settings['dh_company_offer_logo_url'] . '">';
                           //       echo '<div>';
                           //          echo '<div class="dh-product-rating-heading">';
                           //             echo 'Duurzaam Thuis Score';
                           //             if ( $item['dh_company_offer_rating_tooltip'] ) {
                           //                echo '<i class="dh-icon dh-icon-info" data-dh-tooltip="' . esc_html( $item['dh_company_offer_rating_tooltip'] ) . '"></i>';
                           //             }
                           //          echo '</div>';
                           //          echo '<div class="dh-product-rating">';
                           //             echo '<div class="dh-text-rating">' . $item['dh_company_offer_rating'] .'/10</div>';
                           //             echo '<div class="dh-list-rating">';
                           //                echo $this->render_rating( $item['dh_company_offer_rating'] );
                           //             echo '</div>';
                           //          echo '</div>';
                           //       echo '</div>';
                           //    echo '</div>';
                           // }
                        echo '</div>'; // dh-product-column
                        echo '<div class="dh-product-column">';
                           $pros = json_decode( $item['dh_company_offer_pros'] );
                           if ( ! empty( $pros ) ) {
                              echo '<div class="dh-product-pros">';
                                 echo '<div class="dh-product-pros-heading">Voordelen</div>';
                                 foreach ( $pros as $pros_item ) {
                                    echo '<div class="dh-product-pros-item">';
                                       echo '<i class="dh-icon dh-icon-check"></i>';
                                       echo '<div class="dh-product-pros-item-text">' . esc_html( $pros_item[0] ) . '</div>';
                                    echo '</div>';
                                 }
                              echo '</div>';
                           }
                           $cons = json_decode( $item['dh_company_offer_cons'] );
                           if ( ! empty( $cons ) ) {
                              echo '<div class="dh-product-cons">';
                                 echo '<div class="dh-product-cons-heading">Nadelen</div>';
                                 foreach ( $cons as $cons_item ) {
                                    echo '<div class="dh-product-cons-item">';
                                       echo '<i class="dh-icon dh-icon-times"></i>';
                                       echo '<div class="dh-product-cons-item-text">' . esc_html( $cons_item[0] ) . '</div>';
                                    echo '</div>';
                                 }
                              echo '</div>';
                           }
                        echo '</div>';  // dh-product-column

                        echo '<div class="dh-product-column">';
                           if ( $item['dh_company_offer_description'] ) {
                              echo '<div class="dh-product-description-heading">Omschrijving</div>';
                              echo '<div class="dh-product-description">';
                                 echo '<div class="dh-product-description-content">' . $item['dh_company_offer_description'] . '</div>';
                                 echo '<div class="dh-product-description-toggle">';
                                    echo '<div class="dh-open">... Meer<i class="dh-icon dh-icon-arrow-down"></i></div>';
                                    echo '<div class="dh-close">Minder<i class="dh-icon dh-icon-arrow-up"></i></div>';
                                 echo '</div>';
                              echo '</div>';
                           }
                           // if ( $item['dh_company_offer_button_text'] ) {
                           //    echo '<div class="dh-product-checkbox-button-wrapper">';
                           //       echo '<div class="dh-product-checkbox-button active" data-email="' . esc_html( $item['dh_company_offer_email'] ) . '">Selecteer</div>';
                           //       echo '<div class="dh-product-checkbox-scroll-to-form">Offerte aanvragen</div>';
                           //    echo '</div>';
                           // }
                        echo '</div>'; // dh-product-column
                     echo '</div>'; // dh-product-wrapper

                  echo '</div>'; // dh-product
               endforeach;
            echo '</div>'; // dh-products-score-grid
         ?></div><?php
      endif;
	}


   protected function content_template() {
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
            function renderRating( rating ) {
               var starsHtml = '';
               rating = rating * 10;

               starsHtml += '<div class="dh-rating">';
                  starsHtml += '<div class="dh-rating-bg">';
                     for ( var stars = 1; stars <= 5; stars++ ) {
                        starsHtml += '<i class="dh-icon dh-icon-benefit"></i>';
                     }
                  starsHtml += '</div>';
                  starsHtml += '<div class="dh-rating-fg" style="width: ' + rating + '%">';
                     for ( var stars = 1; stars <= 5; stars++ ) {
                        starsHtml += '<i class="dh-icon dh-icon-benefit"></i>';
                     }
                  starsHtml += '</div>';
               starsHtml += '</div>';
               return starsHtml;
            }
            function check_and_parse_json( json ) {
               function is_json( str  ) {
                  try {
                     JSON.parse( str );
                  } catch ( e ) {
                     return false;
                  }
                  return true;
               }
               if ( is_json( json ) ) {
                  return JSON.parse( json );
               } else {
                  return [];
               }
            }
         #>

         <# if ( settings.dh_company_offer_products.length ) { #>
            <# 
               var classes = [];
               jQuery.each( view.model.attributes.settings.controls, function( index, value ) {
                  if ( value.prefix_class && settings[index] && value.section == 'dh_company_offer_section_content' ) {
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
            <div class="<?php echo 'dh-widget-' . $this->get_name(); ?>{{ classes }}">
               <div class="dh-products-score-grid dh-products-{{ settings.dh_company_offer_skin }}-skin">
                  <# _.each( settings.dh_company_offer_products, function( item, index ) { #>
                     <div class="dh-product dh-product-{{ item.dh_company_offer__id }}">
                        <div class="dh-product-wrapper">
                           <div class="dh-product-column">
                              <h3 class="dh-product-heading dh-number-heading">
                                 <div class="dh-number">{{ index + 1 }}</div>
                                 <div class="dh-heading">{{ item.dh_company_offer_title }}</div>
                              </h3>
                              <div class="dh-product-image">
                                 <#
                                    if(item.dh_company_offer_badge) {
                                       switch(item.dh_company_offer_badge) {
                                          case 'best_price': #>
                                             <div class="dh-product-badge dh-product-price-badge">Beste prijs</div>
                                             <# break;
                                          case 'best_quality': #>
                                             <div class="dh-product-badge dh-product-quality-badge">Beste kwaliteit</div>
                                             <# break;
                                          case 'our_choice': #>
                                             <div class="dh-product-badge dh-product-our-badge">Onze keuze</div>
                                             <# break;
                                          case 'eco_choice': #>
                                             <div class="dh-product-badge dh-product-eco-badge">Beste eco keuze</div>
                                             <# break;
                                       }
                                    }
                                 #>
                                 <div class="dh-product-image-wrapper">
                                       <img src="{{ item.dh_company_offer_image.url }}">
                                 </div>
                              </div>
                              <!-- <# if ( item.dh_company_offer_quality ) { #>
                                 <div class="dh-product-quality">
                                    <div>Kwaliteit</div>
                                    <div>
                                    {{ item.dh_company_offer_quality }}
                                    <# if ( item.dh_company_offer_quality_tooltip ) { #>
                                       <i class="dh-icon dh-icon-info" data-dh-tooltip="{{ item.dh_company_offer_quality_tooltip }}"></i>
                                    <# } else {
                                       var quality_tooltip;
                                       if ( item.dh_company_offer_quality_amount1 && item.dh_company_offer_quality_source1 ) {
                                          quality_tooltip = 'Gebaseerd op ' + item.dh_company_offer_quality_amount1 + ' reviews op ' + item.dh_company_offer_quality_source1;
                                          if ( item.dh_company_offer_quality_amount2 && item.dh_company_offer_quality_source2 ) {
                                             quality_tooltip += ' en ' + item.dh_company_offer_quality_amount2 + ' op ' + item.dh_company_offer_quality_source2;
                                          }
                                          #><i class="dh-icon dh-icon-info" data-dh-tooltip="{{ quality_tooltip }}"></i><#
                                       }
                                    } #> 
                                    </div>
                                 </div>
                              <# } #> -->
                              <!-- <# if ( item.dh_company_offer_co2 || item.dh_company_offer_co2_custom_label ) { #>
                                 <div class="dh-product-co2">
                                    <div>
                                    <# if ( item.dh_company_offer_co2_custom_label ) { #>
                                       {{ item.dh_company_offer_co2_custom_label }}
                                    <# } else { #>
                                       CO<sub>2</sub>-afdruk
                                    <# } #>
                                    </div>
                                    <div>
                                       <# var co2 = item.dh_company_offer_co2; 
                                       if ( ! item.dh_company_offer_co2_custom_label && is_number( co2 ) ) {
                                          co2 = co2 + 'kg CO<sub>2</sub> p/j';
                                       } #>
                                       {{{ co2 }}}
                                       <# if ( item.dh_company_offer_co2_tooltip ) { #>
                                          <i class="dh-icon dh-icon-info" data-dh-tooltip="{{ item.dh_company_offer_co2_tooltip }}"></i>
                                       <# } #>
                                    </div>
                                 </div>
                              <# } #> -->
                              <!-- <# if ( item.dh_company_offer_price ) { #>
                                 <div class="dh-product-price">
                                    <div>Prijs</div>
                                    <div>
                                       €{{ item.dh_company_offer_price }}
                                       <# if ( item.dh_company_offer_price_tooltip ) { #>
                                          <i class="dh-icon dh-icon-info" data-dh-tooltip="{{ item.dh_company_offer_price_tooltip }}"></i>
                                       <# } #>
                                    </div>
                                 </div>
                              <# } #> -->

                              <!-- <# if ( item.dh_company_offer_rating ) { #>
                                 <div class="dh-product-score">
                                    <img src="{{ settings.dh_company_offer_logo_url }}">
                                    <div>
                                       <div class="dh-product-rating-heading">
                                          Duurzaam Thuis Score
                                          <# if ( item.dh_company_offer_rating_tooltip ) { #>
                                             <i class="dh-icon dh-icon-info" data-dh-tooltip="{{ item.dh_company_offer_rating_tooltip }}"></i>
                                          <# } #>
                                       </div>
                                       <div class="dh-product-rating">
                                          <div class="dh-text-rating">{{ item.dh_company_offer_rating }}/10</div>
                                          <div class="dh-list-rating">
                                          {{{ renderRating( item.dh_company_offer_rating ) }}}
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              <# } #> -->
                           </div>
                           <div class="dh-product-column">
                              <# var pros = check_and_parse_json( item.dh_company_offer_pros );  #>
                              <# if ( pros.length ) { #>
                                 <div class="dh-product-pros">
                                    <div class="dh-product-pros-heading">Voordelen</div>
                                    <# _.each( pros, function(pros_item) { #>
                                       <div class="dh-product-pros-item">
                                          <i class="dh-icon dh-icon-check"></i>
                                          <div class="dh-product-pros-item-text">{{ pros_item[0] }}</div>
                                       </div>
                                    <# } ); #>
                                 </div>
                              <# } #>
                              <# var cons = check_and_parse_json( item.dh_company_offer_cons );  #>
                              <# if ( cons.length ) { #>
                                 <div class="dh-product-cons">
                                    <div class="dh-product-cons-heading">Nadelen</div>
                                    <# _.each( cons, function( cons_item ) { #>
                                       <div class="dh-product-cons-item">
                                          <i class="dh-icon dh-icon-times"></i>
                                          <div class="dh-product-cons-item-text">{{ cons_item[0] }}</div>
                                       </div>
                                    <# } ); #>
                                 </div>
                              <# } #>
                           </div>
                           <div class="dh-product-column">
                              <# if ( item.dh_company_offer_description ) { #>
                                 <div class="dh-product-description-heading">Omschrijving</div>
                                 <div class="dh-product-description">
                                    <div class="dh-product-description-content">{{ item.dh_company_offer_description }}</div>
                                       <div class="dh-product-description-toggle">
                                       <div class="dh-open">... Meer<i class="dh-icon dh-icon-arrow-down"></i></div>
                                       <div class="dh-close">Minder<i class="dh-icon dh-icon-arrow-up"></i></div>
                                    </div>
                                 </div>
                              <# } #>
                              <!-- <# if ( item.dh_company_offer_button_text ) { #>
                                 <a target="_blank" class="dh-product-button" href="{{ item.dh_company_offer_button_link }}">{{ item.dh_company_offer_button_text }}</a>
                              <# } #> -->
                           </div>
                        </div>
                     </div>
                  <# } ); #>
               </div>
            </div>
         <# } #>
		<?php
	}
}