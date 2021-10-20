<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class DH_Product_Comparition_Sustainability_Score extends \Elementor\Widget_Base {

   public $price;
   public $last_updated;

	public function get_name() {
		return 'dh-product-comparition-sustainability-score';
	}

	public function get_title() {
		return __( 'Product Comparison Sustainability Score', 'duurzaamthuis' );
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
      DH_Widgets_Content_Controls::get_dh_product_comparition_sustainability_score_controls( $this );
	}


   
   protected function render_rating( $rating ) {
      $rating = (float) $rating / 2;
      $floored_rating = floor( $rating );
      $stars_html = '';

      for ( $stars = 1.0; $stars <= 5; $stars++ ) {
         if ( $stars <= $floored_rating ) {
            $stars_html .= '<i class="dh-list-full">&#xe901;</i>';
         } elseif ( $floored_rating + 1 === $stars && $rating !== $floored_rating ) {
            $stars_html .= '<i class="dh-list-' . ( $rating - $floored_rating ) * 10 . '">&#xe901;</i>';
         } else {
            $stars_html .= '<i class="dh-list-empty">&#xe901;</i>';
         }
      }

      return $stars_html;
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
      
		if ( $settings['dh_product_comparition_sustainability_score_products'] ) :
         ?><div class="<?php echo 'dh-widget-' . $this->get_name() . DH_Widgets_Content_Controls::get_prefix_classes( $this, $settings ); ?>"><?php
            echo '<div class="dh-products-score-grid dh-products-' . $settings['dh_product_comparition_sustainability_score_skin'] . '-skin">';
               foreach ( $settings['dh_product_comparition_sustainability_score_products'] as $index => $item ) :
                  $shortcode = $this->render_shortcode( $item['dh_product_comparition_sustainability_score_shortcode'] );
                  echo '<div class="dh-product dh-product-' . $item['_id'] . '">';
                     echo '<div class="dh-product-wrapper">';
                        echo '<div class="dh-product-column">';
                           echo '<h3 class="dh-product-heading">';
                              echo '<div class="dh-number">' . ( $index + 1 ) . '</div>';
                              echo '<div class="dh-heading">' . $item['dh_product_comparition_sustainability_score_title'] . '</div>';
                           echo '</h3>'; // dh-product-heading
                           echo '<div class="dh-product-image">';
                              if ( $item['dh_product_comparition_sustainability_score_badge'] ) {
                                 switch ( $item['dh_product_comparition_sustainability_score_badge'] ) {
                                    case 'best_price':
                                       echo '<div class="dh-product-badge dh-product-price-badge">Beste prijs</div>';
                                       break;
                                    case 'best_quality':
                                       echo '<div class="dh-product-badge dh-product-quality-badge">Beste kwaliteit</div>';
                                       break;
                                    case 'eco_choice':
                                       echo '<div class="dh-product-badge dh-product-eco-badge">Beste eco keuze</div>';
                                       break;
                                 }
                              }
                              echo '<div class="dh-product-image-wrapper">';
                                 if ( $item['dh_product_comparition_sustainability_score_image']['id'] ) {
                                    echo wp_get_attachment_image( $item['dh_product_comparition_sustainability_score_image']['id'], 'medium' );
                                 } else {
                                    echo '<img src="' . Elementor\Utils::get_placeholder_image_src() . '">';
                                 }
                              echo '</div>'; // dh-product-image-wrapper
                           echo '</div>'; // dh-product-image
                           if ( $item['dh_product_comparition_sustainability_score_quality'] ) {
                              echo '<div class="dh-product-quality">';
                                 echo '<div>Kwaliteit</div>';
                                 echo '<div>';
                                    echo $item['dh_product_comparition_sustainability_score_quality'];
                                    if ( $item['dh_product_comparition_sustainability_score_quality_tooltip'] ) {
                                       echo '<i class="dh-icon dh-icon-info" data-dh-tooltip="' . $item['dh_product_comparition_sustainability_score_quality_tooltip'] . '"></i>';
                                    }
                                 echo '</div>';
                              echo '</div>';
                           }
                           if ( $item['dh_product_comparition_sustainability_score_co2'] || $item['dh_product_comparition_sustainability_score_co2_custom_label'] ) {
                              echo '<div class="dh-product-co2">';
                                 echo '<div>' . ( $item['dh_product_comparition_sustainability_score_co2_custom_label'] ?: 'CO<sub>2</sub>-afdruk' ) . '</div>';
                                 echo '<div>';
                                    $co2 = $item['dh_product_comparition_sustainability_score_co2'];
                                    if ( ! $item['dh_product_comparition_sustainability_score_co2_custom_label'] && $this->is_number( $co2 ) ) {
                                       $co2 = $co2 . 'kg CO<sub>2</sub> p/j';
                                    } 
                                    echo $co2;
                                    if ( $item['dh_product_comparition_sustainability_score_co2_tooltip'] ) {
                                       echo '<i class="dh-icon dh-icon-info" data-dh-tooltip="' . $item['dh_product_comparition_sustainability_score_co2_tooltip'] . '"></i>';
                                    }
                                 echo '</div>';
                              echo '</div>'; // dh-product-co2
                           }
                           $price = $item['dh_product_comparition_sustainability_score_price'] ?: $this->price;
                           echo '<div class="dh-product-price">';
                              if ( $price ) {

                                 echo '<div>Prijs</div>';
                                 echo '<div>';
                                 echo '€' . $price;
                                 $last_updated = $item['dh_product_comparition_sustainability_score_price_tooltip'] ?: 'Laatste update: ' . $this->last_updated;
                                 if ( $last_updated ) {
                                    echo '<i class="dh-icon dh-icon-info" data-dh-tooltip="' . $last_updated . '"></i>';
                                 }
                                 echo '</div>';
                              }
                           echo '</div>';
                           echo '<div class="dh-product-score">';
                              echo '<img src="' . $settings['dh_product_comparition_sustainability_score_logo_url'] . '">';
                              echo '<div>';
                                 echo '<div class="dh-product-rating-heading">';
                                    echo 'Duurzaam Thuis Score';
                                    if ( $item['dh_product_comparition_sustainability_score_rating_tooltip'] ) {
                                       echo '<i class="dh-icon dh-icon-info" data-dh-tooltip="' . $item['dh_product_comparition_sustainability_score_rating_tooltip'] . '"></i>';
                                    }
                                 echo '</div>';
                                 echo '<div class="dh-product-rating">';
                                    echo '<div class="dh-text-rating">' . $item['dh_product_comparition_sustainability_score_rating'] .'/10</div>';
                                    echo '<div class="dh-list-rating">';
                                       echo $this->render_rating( $item['dh_product_comparition_sustainability_score_rating'] );
                                    echo '</div>';
                                 echo '</div>';
                              echo '</div>';
                           echo '</div>';
                        echo '</div>'; // dh-product-column
                        echo '<div class="dh-product-column">';
                           $pros = json_decode( $item['dh_product_comparition_sustainability_score_pros'] );
                           if ( ! empty( $pros ) ) {
                              echo '<div class="dh-product-pros">';
                                 echo '<div class="dh-product-pros-heading">Voordelen</div>';
                                 foreach ( $pros as $pros_item ) {
                                    echo '<div class="dh-product-pros-item">';
                                       echo '<i class="dh-icon dh-icon-check"></i>';
                                       echo '<div class="dh-product-pros-item-text">' . $pros_item[0] . '</div>';
                                    echo '</div>';
                                 }
                              echo '</div>';
                           }
                           $cons = json_decode( $item['dh_product_comparition_sustainability_score_cons'] );
                           if ( ! empty( $cons ) ) {
                              echo '<div class="dh-product-cons">';
                                 echo '<div class="dh-product-cons-heading">Nadelen</div>';
                                 foreach ( $cons as $cons_item ) {
                                    echo '<div class="dh-product-cons-item">';
                                       echo '<i class="dh-icon dh-icon-times"></i>';
                                       echo '<div class="dh-product-cons-item-text">' . $cons_item[0] . '</div>';
                                    echo '</div>';
                                 }
                              echo '</div>';
                           }
                           echo '<div class="dh-product-description-heading">Omschrijving</div>';
                           echo '<div class="dh-product-description">';
                              echo '<div class="dh-product-description-content">' . $item['dh_product_comparition_sustainability_score_description'] . '</div>';
                              echo '<div class="dh-product-description-toggle">';
                                 echo '<div class="dh-open">... Meer<i class="dh-icon dh-icon-arrow-down"></i></div>';
                                 echo '<div class="dh-close">Minder<i class="dh-icon dh-icon-arrow-up"></i></div>';
                              echo '</div>';
                           echo '</div>';
                        echo '</div>';  // dh-product-column
                        echo '<div class="dh-product-column">';
                           echo '<div class="dh-product-shortcode-heading">Beste prijs</div>';
                           echo '<div class="dh-product-shortcode">' . $shortcode . '</div>';
                           $last_updated_text = $item['dh_product_comparition_sustainability_score_last_updated_text'] ?: 'Laatste update: ' . $this->last_updated;
                           echo '<div class="dh-product-last-updated-text">' . $last_updated_text . '</div>';
                           if ( $item['dh_product_comparition_sustainability_score_button_text'] ) {
                              $rel = isset( $item['dh_product_comparition_sustainability_score_sponsored'] ) ? ' rel="sponsored"' : '';
                              echo '<a target="_blank" class="dh-product-button" href="' . $item['dh_product_comparition_sustainability_score_button_link'] . '"' . $rel . '>' . $item['dh_product_comparition_sustainability_score_button_text'] . '</a>';
                           }
                        echo '</div>'; // dh-product-column
                     echo '</div>'; // dh-product-wrapper
                  echo '</div>'; // dh-product
               endforeach;
            echo '</div>'; // dh-products-score-grid
         ?></div><?php
      endif;
	}


   public function filter_products( $products ) {
	   $products = array_slice( $products, 0, 15 );
      foreach ( $products as $index => $product ) {
         if ( $products[$index]['finalprice'] < 90 ) {
            unset( $products[$index] );
         }
      }
	   $products = array_slice( $products, 0, 5 );
      $key = array_key_first( $products );
      $this->price = number_format( ( $products[$key]['finalprice'] / 100 ), 2, ',', '.' );
      return $products;
   }


   public function last_updated( $text, $instance ) {
      $this->last_updated = $instance->date_updated;
      return $text;
   }


   public function render_shortcode( $shorcode ) {
      add_filter( 'dfrcs_products', [ $this, 'filter_products'], 100);
      add_filter( 'dfrcs_last_updated_text', [ $this, 'last_updated' ], 100, 2 );
      $content = do_shortcode( shortcode_unautop( $shorcode ) );
      remove_filter( 'dfrcs_last_updated_text', [ $this, 'last_updated' ], 100 );
      remove_filter( 'dfrcs_products', [ $this, 'filter_products'], 100 );
      return $content;
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
               rating = rating / 2;
               var starsHtml = '';
               var flooredRating = Math.floor( rating );
               for ( var stars = 1; stars <= 5; stars++ ) {
                  if ( stars <= flooredRating  ) {
                     starsHtml += '<i class="dh-list-full">&#xe901;</i>';
                  } else if ( flooredRating + 1 === stars && rating !== flooredRating ) {
                     starsHtml += '<i class="dh-list-' + ( rating - flooredRating ).toFixed( 1 ) * 10 + '">&#xe901;</i>';
                  } else {
                     starsHtml += '<i class="dh-list-empty">&#xe901;</i>';
                  }
               }
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

         <# if ( settings.dh_product_comparition_sustainability_score_products.length ) { #>
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
               <div class="dh-products-score-grid dh-products-{{{ settings.dh_product_comparition_sustainability_score_skin }}}-skin">
                  <# _.each( settings.dh_product_comparition_sustainability_score_products, function( item, index ) { #>
                     <div class="dh-product dh-product-{{ item.dh_product_comparition_sustainability_score__id }}">
                        <div class="dh-product-wrapper">
                           <div class="dh-product-column">
                              <h3 class="dh-product-heading dh-number-heading">
                                 <div class="dh-number">{{{ index + 1 }}}</div>
                                 <div class="dh-heading">{{{ item.dh_product_comparition_sustainability_score_title }}}</div>
                              </h3>
                              <div class="dh-product-image">
                                 <#
                                    if(item.dh_product_comparition_sustainability_score_badge) {
                                       switch(item.dh_product_comparition_sustainability_score_badge) {
                                          case 'best_price': #>
                                             <div class="dh-product-badge dh-product-price-badge">Beste prijs</div>
                                             <# break;
                                          case 'best_quality': #>
                                             <div class="dh-product-badge dh-product-quality-badge">Beste kwaliteit</div>
                                             <# break;
                                          case 'eco_choice': #>
                                             <div class="dh-product-badge dh-product-eco-badge">Beste eco keuze</div>
                                             <# break;
                                       }
                                    }
                                 #>
                                 <div class="dh-product-image-wrapper">
                                       <img src="{{ item.dh_product_comparition_sustainability_score_image.url }}">
                                 </div>
                              </div>
                              <# if ( item.dh_product_comparition_sustainability_score_quality ) { #>
                                 <div class="dh-product-quality">
                                    <div>Kwaliteit</div>
                                    <div>
                                       {{{ item.dh_product_comparition_sustainability_score_quality }}}
                                       <# if ( item.dh_product_comparition_sustainability_score_quality_tooltip ) { #>
                                          <i class="dh-icon dh-icon-info" data-dh-tooltip="{{{ item.dh_product_comparition_sustainability_score_quality_tooltip }}}"></i>
                                       <# } #>
                                    </div>
                                 </div>
                              <# } #>
                              <# if ( item.dh_product_comparition_sustainability_score_co2 || item.dh_product_comparition_sustainability_score_co2_custom_label ) { #>
                                 <div class="dh-product-co2">
                                    <div>
                                    <# if ( item.dh_product_comparition_sustainability_score_co2_custom_label ) { #>
                                       {{{ item.dh_product_comparition_sustainability_score_co2_custom_label }}}
                                    <# } else { #>
                                       CO<sub>2</sub>-afdruk
                                    <# } #>
                                    </div>
                                    <div>
                                       <# var co2 = item.dh_product_comparition_sustainability_score_co2; 
                                       if ( ! item.dh_product_comparition_sustainability_score_co2_custom_label && is_number( co2 ) ) {
                                          co2 = co2 + 'kg CO<sub>2</sub>';
                                       } #>
                                       {{{ co2 }}}
                                       <# if ( item.dh_product_comparition_sustainability_score_co2_tooltip ) { #>
                                          <i class="dh-icon dh-icon-info" data-dh-tooltip="{{{ item.dh_product_comparition_sustainability_score_co2_tooltip }}}"></i>
                                       <# } #>
                                    </div>
                                 </div>
                              <# } #>
                              <# if ( item.dh_product_comparition_sustainability_score_price ) { #>
                                 <div class="dh-product-price">
                                    <div>Prijs</div>
                                    <div>
                                       €{{{ item.dh_product_comparition_sustainability_score_price }}}
                                       <# if ( item.dh_product_comparition_sustainability_score_price_tooltip ) { #>
                                          <i class="dh-icon dh-icon-info" data-dh-tooltip="{{{ item.dh_product_comparition_sustainability_score_price_tooltip }}}"></i>
                                       <# } #>
                                    </div>
                                 </div>
                              <# } #>
                              <div class="dh-product-score">
                                 <img src="{{{ settings.dh_product_comparition_sustainability_score_logo_url }}}">
                                 <div>
                                    <div class="dh-product-rating-heading">
                                       Duurzaam Thuis Score
                                       <# if ( item.dh_product_comparition_sustainability_score_rating_tooltip ) { #>
                                          <i class="dh-icon dh-icon-info" data-dh-tooltip="{{{ item.dh_product_comparition_sustainability_score_rating_tooltip }}}"></i>
                                       <# } #>
                                    </div>
                                    <div class="dh-product-rating">
                                       <div class="dh-text-rating">{{{ item.dh_product_comparition_sustainability_score_rating }}}/10</div>
                                       <div class="dh-list-rating">
                                       {{{ renderRating( item.dh_product_comparition_sustainability_score_rating ) }}}
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="dh-product-column">
                              <# var pros = check_and_parse_json( item.dh_product_comparition_sustainability_score_pros );  #>
                              <# if ( pros.length ) { #>
                                 <div class="dh-product-pros">
                                    <div class="dh-product-pros-heading">Voordelen</div>
                                    <# _.each( pros, function(pros_item) { #>
                                       <div class="dh-product-pros-item">
                                          <i class="dh-icon dh-icon-check"></i>
                                          <div class="dh-product-pros-item-text">{{{ pros_item[0] }}}</div>
                                       </div>
                                    <# } ); #>
                                 </div>
                              <# } #>
                              <# var cons = check_and_parse_json( item.dh_product_comparition_sustainability_score_cons );  #>
                              <# if ( cons.length ) { #>
                                 <div class="dh-product-cons">
                                    <div class="dh-product-cons-heading">Nadelen</div>
                                    <# _.each( cons, function( cons_item ) { #>
                                       <div class="dh-product-cons-item">
                                          <i class="dh-icon dh-icon-times"></i>
                                          <div class="dh-product-cons-item-text">{{{ cons_item[0] }}}</div>
                                       </div>
                                    <# } ); #>
                                 </div>
                              <# } #>
                              <div class="dh-product-description-heading">Omschrijving</div>
                              <div class="dh-product-description">
                                 <div class="dh-product-description-content">{{{ item.dh_product_comparition_sustainability_score_description }}}</div>
                                    <div class="dh-product-description-toggle">
                                    <div class="dh-open">... Meer<i class="dh-icon dh-icon-arrow-down"></i></div>
                                    <div class="dh-close">Minder<i class="dh-icon dh-icon-arrow-up"></i></div>
                                 </div>
                              </div>
                           </div>
                           <div class="dh-product-column">
                              <div class="dh-product-shortcode-heading">Beste prijs</div>
                              <div class="dh-product-shortcode">{{{ item.dh_product_comparition_sustainability_score_shortcode }}}</div>
                              <# if ( item.dh_product_comparition_sustainability_score_button_text ) { #>
                                 <a target="_blank" class="dh-product-button" href="{{{ item.dh_product_comparition_sustainability_score_button_link }}}">{{{ item.dh_product_comparition_sustainability_score_button_text }}}</a>
                              <# } #>
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