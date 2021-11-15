<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class DH_Product_Review extends \Elementor\Widget_Base {

   public $price;
   public $last_updated;

	public function get_name() {
		return 'dh-product-review';
	}

	public function get_title() {
		return __( 'Product Review', 'duurzaamthuis' );
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
      DH_Widgets_Content_Controls::get_dh_product_review_controls( $this );
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
      $dfrcs_set_cache = get_post_meta( get_the_ID(), 'dh-dfrcs-set-' . $this->get_id() . '-0-cache', true );
      
      ?><div class="<?php echo 'dh-widget-' . $this->get_name() . DH_Widgets_Content_Controls::get_prefix_classes( $this, $settings ); ?>"><?php
         echo '<div class="dh-products-review-grid dh-products-' . $settings['dh_product_review_skin'] . '-skin">';

            echo '<div class="dh-product">';

               echo '<h3 class="dh-product-review-title">' . $settings['dh_product_review_title'] . '</h3>';
               echo '<div class="dh-product-review-content">' . $settings['dh_product_review_content'] . '</div>';

               echo '<div class="dh-product-wrapper">';
                  echo '<div class="dh-product-column">';
                     echo '<div class="dh-product-score-heading">Duurzaam Thuis Score</div>';
                     if ( $settings['dh_product_review_quality'] ) {
                        echo '<div class="dh-product-quality">';
                           echo '<div>Kwaliteit</div>';
                           echo '<div>';
                              echo $settings['dh_product_review_quality'];
                              if ( $settings['dh_product_review_quality_tooltip'] ) {
                                 echo '<i class="dh-icon dh-icon-info" data-dh-tooltip="' . esc_html( $settings['dh_product_review_quality_tooltip'] ) . '"></i>';
                              } else {
                                 if ( $settings['dh_product_review_quality_amount1'] && $settings['dh_product_review_quality_source1'] ) {
                                    $quality_tooltip = 'Gebaseerd op ' . $settings['dh_product_review_quality_amount1'] . ' reviews op ' . $settings['dh_product_review_quality_source1'];
                                    if ( $settings['dh_product_review_quality_amount2'] && $settings['dh_product_review_quality_source2'] ) {
                                       $quality_tooltip .= ' en ' . $settings['dh_product_review_quality_amount2'] . ' op ' . $settings['dh_product_review_quality_source2'];
                                    }
                                    echo '<i class="dh-icon dh-icon-info" data-dh-tooltip="' . esc_html( $quality_tooltip ) . '"></i>';
                                 }
                              }
                           echo '</div>';
                        echo '</div>';
                     }
                     if ( $settings['dh_product_review_co2'] || $settings['dh_product_review_co2_custom_label'] ) {
                        echo '<div class="dh-product-co2">';
                           echo '<div>' . ( $settings['dh_product_review_co2_custom_label'] ?: 'CO<sub>2</sub>-afdruk' ) . '</div>';
                           echo '<div>';
                              $co2 = $settings['dh_product_review_co2'];
                              if ( ! $settings['dh_product_review_co2_custom_label'] && $this->is_number( $co2 ) ) {
                                 $co2 = $co2 . 'kg CO<sub>2</sub> p/j';
                              } 
                              echo $co2;
                              if ( $settings['dh_product_review_co2_tooltip'] ) {
                                 echo '<i class="dh-icon dh-icon-info" data-dh-tooltip="' . esc_html( $settings['dh_product_review_co2_tooltip'] ) . '"></i>';
                              }
                           echo '</div>';
                        echo '</div>'; // dh-product-co2
                     }
                     $price = $settings['dh_product_review_price'] ? '€' . $settings['dh_product_review_price'] : ( $dfrcs_set_cache['price'] ?? '' );
                     if ( $price ) {
                        echo '<div class="dh-product-price">';

                           echo '<div>Prijs</div>';
                           echo '<div>';
                           echo $price;
                           $last_updated = $settings['dh_product_review_price_tooltip'];
                           if ( $last_updated ) {
                              echo '<i class="dh-icon dh-icon-info" data-dh-tooltip="' . esc_html( $last_updated ) . '"></i>';
                           }
                           echo '</div>';
                        echo '</div>';
                     }
                     echo '<div class="dh-product-score">';
                        echo '<img src="' . $settings['dh_product_review_logo_url'] . '">';
                        echo '<div>';
                           echo '<div class="dh-product-rating-heading">';
                              echo 'Duurzaam Thuis Score';
                              if ( $settings['dh_product_review_rating_tooltip'] ) {
                                 echo '<i class="dh-icon dh-icon-info" data-dh-tooltip="' . esc_html( $settings['dh_product_review_rating_tooltip'] ) . '"></i>';
                              }
                           echo '</div>';
                           echo '<div class="dh-product-rating">';
                              echo '<div class="dh-text-rating">' . $settings['dh_product_review_rating'] .'/10</div>';
                              echo '<div class="dh-list-rating">';
                                 echo $this->render_rating( $settings['dh_product_review_rating'] );
                              echo '</div>';
                           echo '</div>';
                        echo '</div>';
                     echo '</div>';
                  echo '</div>'; // dh-product-column
                  echo '<div class="dh-product-column">';
                     $pros = json_decode( $settings['dh_product_review_pros'] );
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
                  echo '</div>';  // dh-product-column

                  echo '<div class="dh-product-column">';
                     $cons = json_decode( $settings['dh_product_review_cons'] );
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
                  echo '</div>'; // dh-product-column

                  echo '<div class="dh-product-column dh-product-fullwidth-column">';
                     echo '<div class="dh-product-description">';
                        echo '<div class="dh-product-description-content">' . $settings['dh_product_review_description'] . '</div>';
                        echo '<div class="dh-product-description-toggle">';
                           echo '<div class="dh-open">... Meer<i class="dh-icon dh-icon-arrow-down"></i></div>';
                           echo '<div class="dh-close">Minder<i class="dh-icon dh-icon-arrow-up"></i></div>';
                        echo '</div>';
                     echo '</div>';
                  echo '</div>';  // dh-product-column

               echo '</div>'; // dh-product-wrapper
            

               echo '<div class="dh-product-review-row">';

                  echo '<div class="dh-product-review-column">';
                     echo '<div class="dh-product-image-wrapper">';
                        if ( $settings['dh_product_review_image']['id'] ) {
                           echo wp_get_attachment_image( $settings['dh_product_review_image']['id'], 'medium' );
                        } else {
                           echo '<img src="' . Elementor\Utils::get_placeholder_image_src() . '">';
                        }
                     echo '</div>'; // dh-product-image-wrapper
                  echo '</div>'; // dh-product-review-column

                  echo '<div class="dh-product-review-column">';
                     echo '<div class="dh-product-review-shortcode-heading">Beste prijs</div>';
                     $shortcode = $this->render_shortcode( $settings['dh_product_review_shortcode'] );
                     echo '<div class="dh-product-review-shortcode">' . $shortcode . '</div>';
                     $last_updated_text = $settings['dh_product_review_last_updated_text'] ?: 'Laatste update: ' . $this->last_updated;
                     echo '<div class="dh-product-last-updated-text">' . $last_updated_text . '</div>';
                     if ( $settings['dh_product_review_button_text'] ) {
                        $rel = isset( $settings['dh_product_review_sponsored'] ) ? ' rel="sponsored"' : '';
                        echo '<a target="_blank" class="dh-product-button" href="' . $settings['dh_product_review_button_link'] . '"' . $rel . '>' . $settings['dh_product_review_button_text'] . '</a>';
                     }
                  echo '</div>'; // dh-product-review-column

               echo '</div>'; // dh-product-review-row

               $page_author_id = get_the_author_meta( 'ID' );
               $review_author_name = get_the_author_meta( 'first_name', $page_author_id ) . ' ' . get_the_author_meta( 'last_name', $page_author_id );

               ?><script type="application/ld+json">
               {
                  "@context": "https://schema.org/",
                  "@type": "Product",
                  "brand": {
                     "@type": "Brand",
                     "name": "<?php echo $settings['dh_product_review_brand']; ?>"
                  },
                  "gtin13": "<?php echo $settings['dh_product_review_ean'] ?: ''; ?>",
                  "description": "<?php echo $settings['dh_product_review_description']; ?>",
                  "image": "<?php echo $settings['dh_product_review_image']['url']; ?>",
                  "name": "<?php echo $settings['dh_product_review_title']; ?>",
                  "price": "<?php echo $settings['dh_product_review_price']; ?>",
                  "aggregateRating": {
                     "@type": "AggregateRating",
                     "ratingValue": "<?php echo $settings['dh_product_review_quality']; ?>",
                     "ratingCount": "<?php echo intval( $settings['dh_product_review_quality_amount1'] ?? '' ) + intval( $settings['dh_product_review_quality_amount2'] ?? '' ); ?>",
                     "bestRating": "10"
                  },
                  "review": [{
                     "@type": "Review",
                     "reviewRating": {
                        "@type": "Rating",
                        "ratingValue": "<?php echo $settings['dh_product_review_rating']; ?>",
                        "bestRating": "10"
                     },
                     "reviewBody": "<?php echo $settings['dh_product_review_content']; ?>",
                     "author": {
                        "@type": "Person",
                        "name": "<?php echo $review_author_name; ?>"
                     },
                     <?php
                        $cons = json_decode( $settings['dh_product_review_pros'] );
                        if ( ! empty( $pros ) ) {
                           echo '"positiveNotes": [';
                              echo '"' . implode( '","', array_column( $pros, 0 ) ) . '"';
                           echo '],';
                        }
                        $cons = json_decode( $settings['dh_product_review_cons'] );
                        if ( ! empty( $cons ) ) {
                           echo '"negativeNotes": [';
                              echo '"' . implode( '","', array_column( $cons, 0 ) ) . '"';
                           echo ']';
                        }
                     ?>
                  }]
               }
               </script><?php

            echo '</div>'; // dh-product

         echo '</div>'; // dh-products-review-grid
      ?></div><?php

	}

   // public function filter_products( $products ) {
	//    $products = array_slice( $products, 0, 15 );
   //    foreach ( $products as $index => $product ) {
   //       if ( $products[$index]['finalprice'] < 90 ) {
   //          unset( $products[$index] );
   //       }
   //    }
	//    $products = array_slice( $products, 0, 5 );
   //    $key = array_key_first( $products );
   //    $this->price = number_format( ( $products[$key]['finalprice'] / 100 ), 2, ',', '.' );
   //    return $products;
   // }


   public function last_updated( $text, $instance ) {
      $this->last_updated = $instance->date_updated;
      return $text;
   }

   public function modify_dfrcs_context( $context, $instance ) {
      return $context . ' widget-' . $this->get_id();
   }


   public function render_shortcode( $shorcode, $item_id = 0 ) {
      // add_filter( 'dfrcs_products', [ $this, 'filter_products'], 100);
      add_filter( 'dfrcs_last_updated_text', [ $this, 'last_updated' ], 100, 2 );
      $content = do_shortcode( shortcode_unautop( $shorcode ) );
      remove_filter( 'dfrcs_last_updated_text', [ $this, 'last_updated' ], 100 );
      // remove_filter( 'dfrcs_products', [ $this, 'filter_products'], 100 );

      if ( ! $content ) return '';
      $DOM = new DOMDocument();
      @$DOM->loadHTML( mb_convert_encoding( $content, 'HTML-ENTITIES', 'UTF-8' ) );
      $data = $DOM->getElementsByTagName( 'div' )->item( 1 )->getAttribute( 'data-dfrcs' );
      $data = unserialize( base64_decode( $data ) );
      $data['widget'][$item_id] = $this->get_id();
      $data = base64_encode( serialize( $data ) );
      $DOM->getElementsByTagName( 'div' )->item( 1 )->setAttribute( 'data-dfrcs', $data );
      $content = $DOM->saveHTML();

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


         <# 
            var classes = [];
            jQuery.each( view.model.attributes.settings.controls, function( index, value ) {
               if ( value.prefix_class && settings[index] && value.section == 'dh_product_review_section_content' ) {
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

            var width;
				var height;
				var img_dimensions = sessionStorage.getItem(id);
				if ( img_dimensions !== null ) {
					img_dimensions = JSON.parse( img_dimensions );
					width = img_dimensions.width;
					height = img_dimensions.height;
				} 

         #>
         <div class="<?php echo 'dh-widget-' . $this->get_name(); ?>{{ classes }}">
            <div class="dh-products-review-grid dh-products-{{ settings.dh_product_review_skin }}-skin">

               <div class="dh-product">

                  <h3 class="dh-product-review-title">{{ settings.dh_product_review_title }}</h3>
                  <div class="dh-product-review-content">{{ settings.dh_product_review_content }}</div>
               
                  <div class="dh-product-wrapper">
                     <div class="dh-product-column">
                        <div class="dh-product-score-heading">Duurzaam Thuis Score</div>
                        <# if ( settings.dh_product_review_quality ) { #>
                           <div class="dh-product-quality">
                              <div>Kwaliteit</div>
                              <div>
                                 {{ settings.dh_product_review_quality }}
                                 <# if ( settings.dh_product_review_quality_tooltip ) { #>
                                    <i class="dh-icon dh-icon-info" data-dh-tooltip="{{{ settings.dh_product_review_quality_tooltip }}}"></i>
                                 <# } else {
                                    var quality_tooltip;
                                    if ( settings.dh_product_review_quality_amount1 && settings.dh_product_review_quality_source1 ) {
                                       quality_tooltip = 'Gebaseerd op ' + settings.dh_product_review_quality_amount1 + ' reviews op ' + settings.dh_product_review_quality_source1;
                                       if ( settings.dh_product_review_quality_amount2 && settings.dh_product_review_quality_source2 ) {
                                          quality_tooltip += ' en ' + settings.dh_product_review_quality_amount2 + ' op ' + settings.dh_product_review_quality_source2;
                                       }
                                       #><i class="dh-icon dh-icon-info" data-dh-tooltip="{{ quality_tooltip }}"></i><#
                                    }
                                 } #> 
                              </div>
                           </div>
                        <# } #>
                        <# if ( settings.dh_product_review_co2 || settings.dh_product_review_co2_custom_label ) { #>
                           <div class="dh-product-co2">
                              <div>
                              <# if ( settings.dh_product_review_co2_custom_label ) { #>
                                 {{ settings.dh_product_review_co2_custom_label }}
                              <# } else { #>
                                 CO<sub>2</sub>-afdruk
                              <# } #>
                              </div>
                              <div>
                                 <# var co2 = settings.dh_product_review_co2; 
                                 if ( ! settings.dh_product_review_co2_custom_label && is_number( co2 ) ) {
                                    co2 = co2 + 'kg CO<sub>2</sub> p/j';
                                 } #>
                                 {{ co2 }}
                                 <# if ( settings.dh_product_review_co2_tooltip ) { #>
                                    <i class="dh-icon dh-icon-info" data-dh-tooltip="{{ settings.dh_product_review_co2_tooltip }}"></i>
                                 <# } #>
                              </div>
                           </div>
                        <# } #>
                        <# if ( settings.dh_product_review_price ) { #>
                           <div class="dh-product-price">
                              <div>Prijs</div>
                              <div>
                                 €{{ settings.dh_product_review_price }}
                                 <# if ( settings.dh_product_review_price_tooltip ) { #>
                                    <i class="dh-icon dh-icon-info" data-dh-tooltip="{{ settings.dh_product_review_price_tooltip }}"></i>
                                 <# } #>
                              </div>
                           </div>
                        <# } #>
                        <div class="dh-product-score">
                           <img src="{{ settings.dh_product_review_logo_url }}">
                           <div>
                              <div class="dh-product-rating-heading">
                                 Duurzaam Thuis Score
                                 <# if ( settings.dh_product_review_rating_tooltip ) { #>
                                    <i class="dh-icon dh-icon-info" data-dh-tooltip="{{ settings.dh_product_review_rating_tooltip }}"></i>
                                 <# } #>
                              </div>
                              <div class="dh-product-rating">
                                 <div class="dh-text-rating">{{ settings.dh_product_review_rating }}/10</div>
                                 <div class="dh-list-rating">
                                 {{{ renderRating( settings.dh_product_review_rating ) }}}
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="dh-product-column">
                        <# var pros = check_and_parse_json( settings.dh_product_review_pros );  #>
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
                     </div>

                     <div class="dh-product-column">
                        <# var cons = check_and_parse_json( settings.dh_product_review_cons );  #>
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

                     <div class="dh-product-column dh-product-fullwidth-column">
                        <div class="dh-product-description">
                           <div class="dh-product-description-content">{{ settings.dh_product_review_description }}</div>
                              <div class="dh-product-description-toggle">
                              <div class="dh-open">... Meer<i class="dh-icon dh-icon-arrow-down"></i></div>
                              <div class="dh-close">Minder<i class="dh-icon dh-icon-arrow-up"></i></div>
                           </div>
                        </div>
                     </div>
                     
                  </div>

                  <div class="dh-product-review-row">

                     <div class="dh-product-review-column">
                        <div class="dh-product-image-wrapper">
							      <img src="{{ settings.dh_product_review_image.url }}" width="{{{width}}}" height="{{{height}}}" onload="javascript: sessionStorage.setItem('{{{id}}}', JSON.stringify({ 'width': this.naturalWidth, 'height': this.naturalHeight }));">
                        </div>
                     </div>

                     <div class="dh-product-review-column">
                        <div class="dh-product-shortcode-heading">Beste prijs</div>
                        <div class="dh-product-shortcode">{{ settings.dh_product_review_shortcode }}</div>
                        <# if ( settings.dh_product_review_button_text ) { #>
                           <a target="_blank" class="dh-product-button" href="{{ settings.dh_product_review_button_link }}">{{ settings.dh_product_review_button_text }}</a>
                        <# } #>
                     </div>
                  </div>
               </div>
            </div>
         </div>
		<?php
	}
}