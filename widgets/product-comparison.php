<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class DH_Product_Comparison extends \Elementor\Widget_Base {

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

   // Elementor not support controls conditions inside repeater control so we made our own conditions based on css classes and JS
   public function get_controls_conditions_script() {
      ob_start();
         ?>
            <style id="dh-controls-conditions"></style>
            <#
               setTimeout(function(){
                  var skin_control = jQuery('.dh-skin-control').find('select');
                  dh_show_hide_controls(jQuery(skin_control).val());
                  jQuery(skin_control).on('change', function(){
                     dh_show_hide_controls(jQuery(this).val());
                  });
               }, 100);
               function dh_show_hide_controls(val) {
                  if(val == 'simple') {
                     jQuery('#dh-controls-conditions').html('.extended-skin-control { display: none; }');
                  } else {
                     jQuery('#dh-controls-conditions').html('.simple-skin-control { display: none; }');
                  }
               }
            #>
         <?php
      return ob_get_clean();
   }
   
   protected function render_stars( $rating ) {
      $rating = (float) $rating;
      $floored_rating = floor( $rating );
      $stars_html = '';

      for ( $stars = 1.0; $stars <= 5; $stars++ ) {
         if ( $stars <= $floored_rating ) {
            $stars_html .= '<i class="elementor-star-full">&#xE934;</i>';
         } elseif ( $floored_rating + 1 === $stars && $rating !== $floored_rating ) {
            $stars_html .= '<i class="elementor-star-' . ( $rating - $floored_rating ) * 10 . '">&#xE934;</i>';
         } else {
            $stars_html .= '<i class="elementor-star-empty">&#xE934;</i>';
         }
      }

      return $stars_html;
   }

	protected function render() { // php template
		$settings = $this->get_settings_for_display();
      
		if ( $settings['dh_product_comparition_products'] ) :
         ?><div class="<?php echo 'dh-widget-' . $this->get_name() . DH_Widgets_Content_Controls::get_prefix_classes( $this, $settings ); ?>"><?php
            echo '<div class="dh-products-grid dh-products-' . $settings['dh_product_comparition_skin'] . '-skin">';
               foreach (  $settings['dh_product_comparition_products'] as $item ) :

                  // simple skin
                  if ( $settings['dh_product_comparition_skin'] == 'simple' ) :
                     echo '<div class="dh-product dh-product-' . $item['_id'] . '">';
                        echo '<div class="dh-product-wrapper">';
                           echo '<div class="dh-product-image">';
                              echo '<div class="dh-product-image-wrapper">';
                                 if ( $item['dh_product_comparition_image']['id'] ) {
                                    echo wp_get_attachment_image( $item['dh_product_comparition_image']['id'], 'medium' );
                                 } else {
                                    echo '<img src="' . \Elementor\Utils::get_placeholder_image_src() . '">';
                                 }
                              echo '</div>';
                           echo '</div>';
                           echo '<div class="dh-product-content">';
                              echo '<h3 class="dh-product-title">' . $item['dh_product_comparition_title'] . '</h3>';
                              echo '<div class="dh-product-star-rating">';
                                 echo '<div class="elementor-star-rating">';
                                    echo $this->render_stars( $item['dh_product_comparition_star_rating'] );
                                 echo '</div>';
                              echo '</div>';
                              if ( $item['dh_product_comparition_price'] ) {
                                 echo '<div class="dh-product-price">€' . $item['dh_product_comparition_price'] . '</div>';
                              }
                              if ( $item['dh_product_comparition_order_by'] ) {
                                 echo '<div class="dh-product-order-by">' . $item['dh_product_comparition_order_by'] . '</div>';
                              }
                           echo '</div>';
                           $rel = isset( $item['dh_product_comparition_sponsored'] ) ? ' rel="sponsored"' : '';
                           echo '<a target="_blank" class="dh-product-button" href="' . $item['dh_product_comparition_button_link'] . '"' . $rel . '>' . $item['dh_product_comparition_button_text'] . '</a>';
                        echo '</div>';
                     echo '</div>';
                  endif;



                  // extended skin
                  if ( $settings['dh_product_comparition_skin'] == 'extended' ) :
                     echo '<div class="dh-product dh-product-' . $item['_id'] . '">';
                        echo '<div class="dh-product-wrapper">';
                           if ( $item['dh_product_comparition_badge'] ) {
                              switch ( $item['dh_product_comparition_badge'] ) {
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
                           echo '<div class="dh-product-image">';
                              echo '<div class="dh-product-image-wrapper">';
                                 if ( $item['dh_product_comparition_image']['id'] ) {
                                    echo wp_get_attachment_image( $item['dh_product_comparition_image']['id'], 'medium' );
                                 } else {
                                    echo '<img src="' . \Elementor\Utils::get_placeholder_image_src() . '">';
                                 }
                              echo '</div>';
                           echo '</div>';
                           echo '<div class="dh-product-content">';
                              echo '<div class="dh-product-star-rating">';
                                 echo '<div class="dh-product-star-rating-heading">Beoordeling</div>';
                                 echo '<div class="elementor-star-rating">';
                                    echo $this->render_stars( $item['dh_product_comparition_star_rating'] );
                                 echo '</div>';
                              echo '</div>';
                              echo '<div class="dh-product-rating">' . $item['dh_product_comparition_product_text_rating'] . '</div>';
                              if ( $item['dh_product_comparition_price'] ) {
                                 echo '<div class="dh-product-price">Prijs: <span>€' . $item['dh_product_comparition_price'] . '</span></div>';
                              }
                              echo '<h3 class="dh-product-title">' . $item['dh_product_comparition_title'] . '</h3>';
                              echo '<div class="dh-product-description">';
                                 echo '<div class="dh-product-description-content">' . $item['dh_product_comparition_description'] . '</div>';
                                 echo '<div class="dh-product-description-toggle">';
                                    echo '<div class="dh-open">... Meer<i class="dh-icon dh-icon-arrow-down"></i></div>';
                                    echo '<div class="dh-close">Minder<i class="dh-icon dh-icon-arrow-up"></i></div>';
                                 echo '</div>';
                              echo '</div>';
                              $pros = json_decode( $item['dh_product_comparition_pros'] );
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

                              $cons = json_decode( $item['dh_product_comparition_cons'] );
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
                           echo '</div>';
                           $rel = isset( $item['dh_product_comparition_sponsored'] ) ? ' rel="sponsored"' : '';
                           echo '<a class="dh-product-button" href="' . $item['dh_product_comparition_button_link'] . '"' . $rel . '>' . $item['dh_product_comparition_button_text'] . '</a>';
                        echo '</div>';
                     echo '</div>';
                  endif;

               endforeach;
            echo '</div>';
         ?></div><?php
      endif;
	}

   protected function content_template() {
		?>
         <#
            function renderStars( rating ) {
               var starsHtml = '';
               var flooredRating = Math.floor( rating );

               for ( var stars = 1; stars <= 5; stars++ ) {
                  if ( stars <= flooredRating  ) {
                     starsHtml += '<i class="elementor-star-full">&#xE934;</i>';
                  } else if ( flooredRating + 1 === stars && rating !== flooredRating ) {
                     starsHtml += '<i class="elementor-star-' + ( rating - flooredRating ).toFixed( 1 ) * 10 + '">&#xE934;</i>';
                  } else {
                     starsHtml += '<i class="elementor-star-empty">&#xE934;</i>';
                  }
               }

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
               <div class="dh-products-grid dh-products-{{{ settings.dh_product_comparition_skin }}}-skin">
                  <# _.each( settings.dh_product_comparition_products, function( item ) { #>

                     <!-- simple skin -->
                     <# if(settings.dh_product_comparition_skin == 'simple') { #>
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
                                    <div class="elementor-star-rating">
                                       {{{ renderStars( item.dh_product_comparition_star_rating ) }}}
                                    </div>
                                 </div>
                                 <# if(item.dh_product_comparition_price) { #>
                                    <div class="dh-product-price">€{{{ item.dh_product_comparition_price }}}</div>
                                 <# } #>
                                 <# if(item.dh_product_comparition_order_by) { #>
                                    <div class="dh-product-order-by">{{{ item.dh_product_comparition_order_by }}}</div>
                                 <# } #>
                              </div>
                              <a class="dh-product-button" href="{{{ item.dh_product_comparition_button_link }}}">{{{ item.dh_product_comparition_button_text }}}</a>
                           </div>
                        </div>
                     <# } #>

                     <!-- extended skin -->
                     <# if(settings.dh_product_comparition_skin == 'extended') { #>
                        <div class="dh-product dh-product-{{ item._id }}">
                           <div class="dh-product-wrapper">
                              <#
                                 if(item.dh_product_comparition_badge) {
                                    switch(item.dh_product_comparition_badge) {
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
                              <div class="dh-product-image">
                                 <div class="dh-product-image-wrapper">
                                    <img src="{{ item.dh_product_comparition_image.url }}">
                                 </div>
                              </div>
                              <div class="dh-product-content">
                                 <div class="dh-product-star-rating">
                                    <div class="dh-product-star-rating-heading">Beoordeling</div>
                                    <div class="elementor-star-rating">
                                       {{{ renderStars(item.dh_product_comparition_star_rating) }}}
                                    </div>
                                 </div>
                                 <div class="dh-product-rating">{{{ item.dh_product_comparition_product_text_rating }}}</div>
                                 <# if(item.dh_product_comparition_price) { #>
                                    <div class="dh-product-price">Prijs: <span>€{{{ item.dh_product_comparition_price }}}</span></div>
                                 <# } #>
                                 <h3 class="dh-product-title">{{{ item.dh_product_comparition_title }}}</h3>
                                 <div class="dh-product-description">
                                    <div class="dh-product-description-content">{{{ item.dh_product_comparition_description }}}</div>
                                       <div class="dh-product-description-toggle">
                                       <div class="dh-open">... Meer<i class="dh-icon dh-icon-arrow-down"></i></div>
                                       <div class="dh-close">Minder<i class="dh-icon dh-icon-arrow-up"></i></div>
                                    </div>
                                 </div>
                                 <# var pros = check_and_parse_json(item.dh_product_comparition_pros);  #>
                                 <# if(pros.length) { #>
                                    <div class="dh-product-pros">
                                       <div class="dh-product-pros-heading">Voordelen</div>
                                       <# _.each( pros, function(pros_item) { #>
                                          <div class="dh-product-pros-item">
                                             <i class="dh-icon dh-icon-check"></i>
                                             <div class="dh-product-pros-item-text">{{{ pros_item[0] }}}</div>
                                          </div>
                                       <# }); #>
                                    </div>
                                 <# } #>
                                 <# var cons = check_and_parse_json(item.dh_product_comparition_cons);  #>
                                 <# if(cons.length) { #>
                                 <div class="dh-product-cons">
                                    <div class="dh-product-cons-heading">Nadelen</div>
                                    <# _.each( cons, function(cons_item) { #>
                                       <div class="dh-product-cons-item">
                                          <i class="dh-icon dh-icon-times"></i>
                                          <div class="dh-product-cons-item-text">{{{ cons_item[0] }}}</div>
                                       </div>
                                    <# }); #>
                                 </div>
                              <# } #>
                              </div>
                              <a class="dh-product-button" href="{{{ item.dh_product_comparition_button_link }}}">{{{ item.dh_product_comparition_button_text }}}</a>
                           </div>
                        </div>
                     <# } #>

                  <# }); #>

               </div>
            </div>

         <# } #>

		<?php
	}
}