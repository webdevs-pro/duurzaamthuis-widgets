<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class DH_Product_Comparison extends \Elementor\Widget_Base {

   public $price;
   public $last_updated;

	public function get_name() {
		return 'dh-product-comparition';
	}

	public function get_title() {
		return __( 'Product Comparison', 'duurzaamthuis' );
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
      DH_Widgets_Content_Controls::get_dh_product_comparition_controls( $this );
	}
   
   protected function render_stars( $rating ) {
      if ( ! $rating ) return '';
      $rating = intval( $rating ) * 20;
      ob_start();
      echo '<div class="dh-rating">';
         echo '<div class="dh-rating-bg">';
            for ( $stars = 1; $stars <= 5; $stars++ ) {
               echo '<i class="dh-icon dh-icon-star"></i>';
            }
         echo '</div>';
         echo '<div class="dh-rating-fg" style="width: ' . $rating . '%">';
            for ( $stars = 1; $stars <= 5; $stars++ ) {
               echo '<i class="dh-icon dh-icon-star"></i>';
            }
         echo '</div>';
      echo '</div>';
      return ob_get_clean();
   }

	protected function render() { // php template
		$settings = $this->get_settings_for_display();
      
		if ( $settings['dh_product_comparition_products'] ) :
         ?><?php 
				$e = new Exception(); 
				$is_multiwidget = strpos( $e->getTrace()[2]['file'], 'multiwidgets.php' ) ? true : false;
				echo sprintf( '<div class="%s"%s>',
					( $is_multiwidget ? 'elementor-element elementor-widget elementor-widget-' . $this->get_name() : '' ) . ' dh-widget-' . $this->get_name() . DH_Widgets_Content_Controls::get_prefix_classes( $this, $settings ),
					$is_multiwidget ? ' data-widget_type="' . $this->get_name() . '.default" data-element_type="widget"' : ''
				); 
			?><?php
            echo '<div class="dh-products-grid">';
               foreach (  $settings['dh_product_comparition_products'] as $item ) {
                  $dfrcs_get_cache = get_post_meta( get_the_ID(), 'dh-dfrcs-set-' . $this->get_id() . '-' . $item['_id'] . '-cache', true );
                  $price = dh_format_price( $item['dh_product_comparition_price'] ?: ( $dfrcs_get_cache['price'] ?? '' ) );
                  $last_updated = $item['dh_product_comparition_price_tooltip'] ?: ( isset( $dfrcs_set_cache['last_updated'] ) ? 'Laatste update: ' . $dfrcs_set_cache['last_updated'] : '' );
                  // $last_updated_text = $item['dh_product_comparition_last_updated_text'] ?: 'Laatste update: ' . $this->last_updated;

                  echo '<div class="dh-product dh-product-' . $item['_id'] . '">';
                     echo '<div class="dh-product-wrapper">';
                        echo '<div class="dh-product-image">';
                           echo '<div class="dh-product-image-wrapper">';
                              echo wp_get_attachment_image( $item['dh_product_comparition_image']['id'], 'medium' );
                           echo '</div>';
                        echo '</div>';
                        echo '<div class="dh-product-content">';
                           echo '<h3 class="dh-product-title">' . $item['dh_product_comparition_title'] . '</h3>';
                           echo '<div class="dh-product-star-rating">';
                              echo '<div class="dh-star-rating">';
                                 echo $this->render_stars( $item['dh_product_comparition_star_rating'] );
                              echo '</div>';
                           echo '</div>';

                           if ( $price ) {
                              echo '<div class="dh-product-price">';
                                 echo '€' . str_replace( ['€', '.'], ['', ','], $price );
                                 if ( $last_updated ) {
                                    echo '<i class="dh-icon dh-icon-info" data-dh-tooltip="' . esc_html( $last_updated ) . '"></i>';
                                 }
                              echo '</div>';
                           }

                           if ( $item['dh_product_comparition_description'] ) {
                              echo '<div class="dh-product-description">';
                                 echo $item['dh_product_comparition_description'];
                              echo '</div>';
                           }

                        echo '</div>';

                        if ( $item['dh_product_comparition_custom_type'] == 'ean' ) {
                           echo '<div class="dh-product-column dh-product-shortcode-column">';
                              echo '<div class="dh-product-shortcode">' . $this->render_shortcode( '[dfrcs ean="' . $item['dh_product_comparition_ean'] . '"]', $item['_id'] ) . '</div>';
                              // echo '<div class="dh-product-last-updated-text">' . $last_updated_text . '</div>';
                           echo '</div>'; // dh-product-column
                        }

                        if ( $item['dh_product_comparition_custom_type'] == 'shortcode' ) {
                           echo '<div class="dh-product-column dh-product-shortcode-column">';
                              echo '<div class="dh-product-shortcode">' . $this->render_shortcode( $item['dh_product_comparition_shortcode'], $item['_id'] ) . '</div>';
                              // echo '<div class="dh-product-last-updated-text">' . $last_updated_text . '</div>';
                           echo '</div>'; // dh-product-column
                        }

                        if ( $item['dh_product_comparition_custom_type'] == 'name' ) {
                           echo '<div class="dh-product-column dh-product-shortcode-column">';
                              echo '<div class="dh-product-shortcode-heading">Beste prijs</div>';
                              echo '<div class="dh-product-shortcode">' . $this->render_shortcode( '[dfrcs name="' . $item['dh_product_comparition_name'] . '" filters="currency=EUR"]', $item['_id'] ) . '</div>';
                              // echo '<div class="dh-product-last-updated-text">' . $last_updated_name_text . '</div>';
                           echo '</div>'; // dh-product-column
                        }

                        if ( $item['dh_product_comparition_custom_type'] == 'button' ) {
                           echo '<div class="dh-product-column dh-product-button-column">';
                              $rel = isset( $item['dh_product_comparition_sponsored'] ) ? ' rel="sponsored"' : '';
                              if ( $item['dh_product_comparition_button_image']['id'] ) {
                                 echo '<div class="dfrcs">';
                                    echo '<ul class="dfrcs_compset">';
                                       echo '<li class="widget-dh-product-comparition">';
                                          echo '<a target="_blank" href="' . $item['dh_product_comparition_button_link'] . '"' . $rel . '>';
                                             echo '<div class="item">';
                                                echo '<div class="dfrcs_logo">';
                                                   echo wp_get_attachment_image( $item['dh_product_comparition_button_image']['id'], 'medium' );
                                                echo '</div>';
                                                echo '<div class="dfrcs_link">';
                                                   echo '<span class="elementor-button elementor-size-sm">' . $item['dh_product_comparition_button_text'] . '</span>';
                                                echo '</div>';
                                             echo '</div>';
                                          echo '</a>';
                                       echo '</li>';
                                    echo '</ul>';
                                 echo '</div>'; 
                              } else {
                                 echo '<a target="_blank" href="' . $item['dh_product_comparition_button_link'] . '"' . $rel . '>';
                                    echo '<span class="elementor-button elementor-size-sm no-logo">' . $item['dh_product_comparition_button_text'] . '</span>';
                                 echo '</a>';
                              }
                           echo '</div>'; // dh-product-column
                        }

                     echo '</div>';
                  echo '</div>';


               }
            echo '</div>';
         ?></div><?php
      endif;
	}

   protected function content_template() {
		?>
         <#
            function renderStars( rating ) {
               var starsHtml = '';
               rating = rating * 20;

               starsHtml += '<div class="dh-rating">';
                  starsHtml += '<div class="dh-rating-bg">';
                     for ( var stars = 1; stars <= 5; stars++ ) {
                        starsHtml += '<i class="eicon-star"></i>';
                     }
                  starsHtml += '</div>';
                  starsHtml += '<div class="dh-rating-fg" style="width: ' + rating + '%">';
                     for ( var stars = 1; stars <= 5; stars++ ) {
                        starsHtml += '<i class="eicon-star"></i>';
                     }
                  starsHtml += '</div>';
               starsHtml += '</div>';
               return starsHtml;
            }

            function check_and_parse_json(json) {
               function is_json(str) {
                  try {
                     JSON.parse(str);
                  } catch (e) {
                     return false;
                  }
                  return true;
               }
               if(is_json(json)){
                  return JSON.parse(json);
               } else {
                  return [];
               }
            }
         #>

         <# if(settings.dh_product_comparition_products.length) { #>
            <# 
               var classes = [];
               jQuery.each( view.model.attributes.settings.controls, function( index, value ) {
                  if ( value.prefix_class && settings[index] && value.section == 'dh_product_comparition_content' ) {
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
               <div class="dh-products-grid">
                  <# _.each( settings.dh_product_comparition_products, function( item ) { #>

                     <div class="dh-product dh-product-{{ item._id }}">
                        <div class="dh-product-wrapper">
                           <div class="dh-product-image">
                              <div class="dh-product-image-wrapper">
                                 <img src="{{ item.dh_product_comparition_image.url }}">
                              </div>
                           </div>
                           <div class="dh-product-content">
                              <h3 class="dh-product-title">{{{ item.dh_product_comparition_title }}}</h3>
                              <div class="dh-product-star-rating">
                                 <div class="dh-star-rating">
                                    {{{ renderStars( item.dh_product_comparition_star_rating ) }}}
                                 </div>
                              </div>
                              <# if(item.dh_product_comparition_price && item.dh_product_comparition_custom_type == 'button') { #>
                                 <div class="dh-product-price">€{{{ item.dh_product_comparition_price }}}</div>
                                 
                              <# } #>
                              <# if(item.dh_product_comparition_description) { #>
                                 <div class="dh-product-description">{{{ item.dh_product_comparition_description }}}</div>
                              <# } #>
                           </div>

                           <# if ( item.dh_product_comparition_custom_type == 'ean' ) { #>
                              <div class="dh-product-column dh-product-shortcode-column">
                                 <# var shortcode = '[dfrcs ean="' + item.dh_product_comparition_ean + '"]'; #>
                                 <div class="dh-product-shortcode">{{ shortcode }}</div>
                              </div>
                           <# } #>

                           <# if ( item.dh_product_comparition_custom_type == 'shortcode' ) { #>
                              <div class="dh-product-column dh-product-shortcode-column">
                                 <# var shortcode = item.dh_product_comparition_shortcode; #>
                                 <div class="dh-product-shortcode">{{ shortcode }}</div>
                              </div>
                           <# } #>

                           <# if ( item.dh_product_comparition_custom_type == 'button' ) { #>
                              <div class="dh-product-column dh-product-button-column">
                                 <# if ( item.dh_product_comparition_button_image.url ) { #>
                                    <div class="dfrcs">
                                       <ul class="dfrcs_compset">
                                          <li class="widget-dh-product-comparition">
                                             <a target="_blank" href="{{ item.dh_product_comparition_button_link }}">
                                                <div class="item">
                                                   <div class="dfrcs_logo">
                                                      <img src="{{ item.dh_product_comparition_button_image.url }}">
                                                   </div>
                                                   <div class="dfrcs_link">
                                                      <span class="elementor-button elementor-size-sm">{{ item.dh_product_comparition_button_text }}</span>
                                                   </div>
                                                </div>
                                             </a>
                                          </li>
                                       </ul>
                                    </div>
                                 <# } else { #>
                                    <a target="_blank" href="{{ item.dh_product_comparition_button_link }}">
                                       <span class="elementor-button elementor-size-sm no-logo">{{ item.dh_product_comparition_button_text }}</span>
                                    </a>
                                 <# } #>
                              </div>
                           <# } #>

                        </div>
                     </div>


                  <# }); #>

               </div>
            </div>

         <# } #>

		<?php
	}

   public function render_shortcode( $shorcode, $item_id = 0 ) {
      // add_filter( 'dfrcs_products', [ $this, 'filter_products'], 100);
      // add_filter( 'dfrcs_last_updated_text', [ $this, 'last_updated' ], 100, 2 );
      $content = do_shortcode( shortcode_unautop( $shorcode ) );
      // remove_filter( 'dfrcs_last_updated_text', [ $this, 'last_updated' ], 100 );
      // remove_filter( 'dfrcs_products', [ $this, 'filter_products'], 100 );
      if ( ! $content ) return '';
      $DOM = new DOMDocument();
      @$DOM->loadHTML( mb_convert_encoding( $content, 'HTML-ENTITIES', 'UTF-8' ) );
      $divs = $DOM->getElementsByTagName( 'div' );
      if ( $divs->length == 0 ) return '';
      $data = $divs->item( 1 )->getAttribute( 'data-dfrcs' );
      $data = unserialize( base64_decode( $data ) );
      $data['widget'][$item_id] = $this->get_id();
      $data['widget']['name'] = $this->get_name();
      $data = base64_encode( serialize( $data ) );
      $DOM->getElementsByTagName( 'div' )->item( 1 )->setAttribute( 'data-dfrcs', $data );
      $content = $DOM->saveHTML();

      return $content;
   }
}