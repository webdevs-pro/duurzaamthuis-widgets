<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class DH_Product_Comparition_Sustainability_Score extends \Elementor\Widget_Base {

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

	protected function _register_controls() {

		// SECTION CONTENT
		$this->start_controls_section( 'section_content', [
         'label' => __( 'Content', 'duurzaamthuis' ),
         'tab' => Elementor\Controls_Manager::TAB_CONTENT,
      ] );
         $this->add_control( 'skin', [
            'label' => __( 'Skin', 'duurzaamthuis' ),
            'type' => Elementor\Controls_Manager::SELECT,
            'default' => 'horizontal',
            'options' => [
               'horizontal'  => __( 'Horizontal', 'duurzaamthuis' ),
               'vertical' => __( 'Vertical', 'duurzaamthuis' ),
            ],
         ] );
         $this->add_responsive_control( 'columns_count', [
				'label' => __( 'Columns', 'duurzaamthuis' ),
				'type' => Elementor\Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 6,
				'step' => 1,
				'default' => 3,
				'tablet_default' => 2,
				'mobile_default' => 1,
				'selectors' => [
					'{{WRAPPER}} .dh-products-grid' => 'grid-template-columns: repeat({{VALUE}}, 1fr);',
				],   
            'condition' => [
               'skin' => 'vertical',
            ]      
			] );
         $this->add_control( 'logo_url', [
            'type' => Elementor\Controls_Manager::HIDDEN,
            'default' => $this->get_site_logo(),
         ] );
         $repeater = new \Elementor\Repeater();
            $repeater->add_control( 'title', [
               'label' => __( 'Title', 'duurzaamthuis' ),
               'type' => Elementor\Controls_Manager::TEXT,
               'default' => __( 'Product title' , 'duurzaamthuis' ),
               'label_block' => true,
            ] );
            $repeater->add_control( 'image', [
               'label' => __( 'Image', 'duurzaamthuis' ),
               'type' => Elementor\Controls_Manager::MEDIA,
               'default' => [
                  'url' => Elementor\Utils::get_placeholder_image_src(),
               ],
            ] );
            $repeater->add_control( 'quality', [
               'label' => __( 'Quality', 'duurzaamthuis' ),
               'type' => Elementor\Controls_Manager::TEXT,
               'default' => '9,6',
            ] );
            $repeater->add_control( 'quality_tooltip', [
               'label' => __( 'Tooltip', 'duurzaamthuis' ),
               'type' => Elementor\Controls_Manager::TEXT,
               'default' => '',
               'separator' => 'after',
            ] );
            $repeater->add_control( 'co2', [
               'label' => __( 'CO<sub>2</sub> Print', 'duurzaamthuis' ),
               'type' => Elementor\Controls_Manager::TEXT,
               'default' => '150',
            ] );
            $repeater->add_control( 'co2_tooltip', [
               'label' => __( 'Tooltip', 'duurzaamthuis' ),
               'type' => Elementor\Controls_Manager::TEXT,
               'default' => '',
               'separator' => 'after',
            ] );
            $repeater->add_control( 'price', [
               'label' => __( 'Price', 'duurzaamthuis' ),
               'type' => Elementor\Controls_Manager::TEXT,
               'default' => '26,50',
            ] );
            $repeater->add_control( 'price_tooltip', [
               'label' => __( 'Tooltip', 'duurzaamthuis' ),
               'type' => Elementor\Controls_Manager::TEXT,
               'default' => '',
               'separator' => 'after',
            ] );
            $repeater->add_control( 'rating', [
               'label' => __( 'Rating', 'elementor' ),
               'type' => Elementor\Controls_Manager::NUMBER,
               'min' => 0,
               'max' => 10,
               'step' => 1,
               'default' => 8,
            ] );
            $repeater->add_control( 'rating_tooltip', [
               'label' => __( 'Tooltip', 'duurzaamthuis' ),
               'type' => Elementor\Controls_Manager::TEXT,
               'default' => '',
               'separator' => 'after',
            ] );
            $repeater->add_control( 'pros', [
               'label' => 'Pros',
               'label_block' => false,
               'button_title' => __( 'Edit Pros', 'duurzaamthuis' ),
               'type' => 'dh-table-control',
               'separator' => 'before',
               'allow_columns' => false,
               'table_classes' => 'repeater',
               'add_row_title' => __( 'Add Item', 'duurzaamthuis' ),
               'max' => 5,
               'default' => '[["Advantage 1"],["Advantage 2"]]',
               ] );
            $repeater->add_control( 'cons', [
               'label' => 'Cons',
               'type' => 'dh-table-control',
               'label_block' => false,
               'button_title' => __( 'Edit Cons', 'duurzaamthuis' ),
               'allow_columns' => false,
               'table_classes' => 'repeater',
               'add_row_title' => __( 'Add Item', 'duurzaamthuis' ),
               'max' => 3,
               'default' => '[["Disadvantage 1"],["Disadvantage 2"]]',
            ] );
            $repeater->add_control( 'description', [
               'label' => __( 'Description', 'duurzaamthuis' ),
               'type' => Elementor\Controls_Manager::TEXTAREA,
               'rows' => 10,
               'default' => __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. ', 'duurzaamthuis' ),
               'placeholder' => __( 'Type your description here', 'duurzaamthuis' ),
            ] );
            $repeater->add_control(
               'shortcode',
               [
                  'label' => esc_html__( 'Enter your shortcode', 'elementor' ),
                  'type' => Elementor\Controls_Manager::TEXTAREA,
                  'dynamic' => [
                     'active' => true,
                  ],
                  'placeholder' => '[dfrcs name="Euphoria 110 Mono" filters="currency=EUR"]',
                  'description' => 'Find more shortcode parameters here <a target="_blank" href="https://wordpress.org/plugins/datafeedr-comparison-sets/">https://wordpress.org/plugins/datafeedr-comparison-sets/</a>',
                  'default' => '',
               ]
            );
         $this->add_control( 'products', [
            'label' => __( 'Products', 'duurzaamthuis' ),
            'type' => Elementor\Controls_Manager::REPEATER,
            'fields' => $repeater->get_controls(),
            'default' => [
               [
                  'title' => __( 'Product title', 'duurzaamthuis' ),
               ],
            ],
            'title_field' => '{{{ title }}}',
         ] );
		$this->end_controls_section(); 



		// SECTION STYLE
		$this->start_controls_section( 'section_style', [
         'label' => __( 'Style', 'duurzaamthuis' ),
         'tab' => Elementor\Controls_Manager::TAB_STYLE,
      ] );



		$this->end_controls_section(); 

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

   private function get_site_logo() {
      $logo = wp_get_attachment_image_src( get_theme_mod( 'custom_logo' ), 'full' );
      if ( $logo ) {
         $logo_url = $logo[0];
      } else {
         $logo_url = Elementor\Utils::get_placeholder_image_src();
      }
      return $logo_url;
   }

   

	protected function render() { // php template
      
		$settings = $this->get_settings_for_display();
      
		if ( $settings['products'] ) :
         echo '<div class="dh-products-grid dh-products-' . $settings['skin'] . '-skin">';
            foreach ( $settings['products'] as $index => $item ) :
               echo '<div class="dh-product dh-product-' . $item['_id'] . '">';
                  echo '<div class="dh-product-wrapper">';
                     echo '<div class="dh-product-column">';
                        echo '<h3 class="dh-product-heading">';
                           echo '<div class="dh-number">' . ( $index + 1 ) . '</div>';
                           echo '<div class="dh-heading">' . $item['title'] . '</div>';
                        echo '</h3>'; // dh-product-heading
                        echo '<div class="dh-product-image">';
                           echo '<div class="dh-product-image-wrapper">';
                              if ( $item['image']['id'] ) {
                                 echo wp_get_attachment_image( $item['image']['id'], 'medium' );
                              } else {
                                 echo '<img src="' . Elementor\Utils::get_placeholder_image_src() . '">';
                              }
                           echo '</div>'; // dh-product-image-wrapper
                        echo '</div>'; // dh-product-image
                        if ( $item['quality'] ) {
                           echo '<div class="dh-product-quality">';
                              echo '<div>Kwaliteit</div>';
                              echo '<div>';
                                 echo $item['quality'];
                                 if ( $item['quality_tooltip'] ) {
                                    echo '<i class="dh-icon dh-icon-info" data-dh-tooltip="' . $item['quality_tooltip'] . '"></i>';
                                 }
                              echo '</div>';
                           echo '</div>';
                        }
                        if ( $item['co2'] ) {
                           echo '<div class="dh-product-co2">';
                              echo '<div>CO<sub>2</sub> Afdruk</div>';
                              echo '<div>';
                                 echo $item['co2'] . 'kg CO<sub>2</sub>';
                                 if ( $item['co2_tooltip'] ) {
                                    echo '<i class="dh-icon dh-icon-info" data-dh-tooltip="' . $item['co2_tooltip'] . '"></i>';
                                 }
                                 echo '</div>';
                                 echo '</div>';
                              }
                              if ( $item['price'] ) {
                                 echo '<div class="dh-product-price">';
                                 echo '<div>Prijs</div>';
                                 echo '<div>';
                                 echo $item['price'];
                                 if ( $item['price_tooltip'] ) {
                                    echo '<i class="dh-icon dh-icon-info" data-dh-tooltip="' . $item['price_tooltip'] . '"></i>';
                                 }
                              echo '</div>';
                           echo '</div>';
                        }
                        echo '<div class="dh-product-score">';
                           echo '<img src="' . $settings['logo_url'] . '">';
                           echo '<div>';
                              echo '<div class="dh-product-rating-heading">';
                                 echo 'Duurzaam Thuis Score';
                                 if ( $item['rating_tooltip'] ) {
                                    echo '<i class="dh-icon dh-icon-info" data-dh-tooltip="' . $item['rating_tooltip'] . '"></i>';
                                 }
                              echo '</div>';
                              echo '<div class="dh-product-rating">';
                                 echo '<div class="dh-text-rating">' . $item['rating'] .'/10</div>';
                                 echo '<div class="dh-list-rating">';
                                    echo $this->render_rating( $item['rating'] );
                                 echo '</div>';
                              echo '</div>';
                           echo '</div>';
                        echo '</div>';
                     echo '</div>'; // dh-product-column
                     echo '<div class="dh-product-column">';
                        $pros = json_decode( $item['pros'] );
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
                        $cons = json_decode( $item['cons'] );
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
                        echo '<div class="dh-product-description">';
                           echo '<div class="dh-product-description-toggle">';
                              echo '<div class="dh-open">Omschrijving<i class="dh-icon dh-icon-arrow-down"></i></div>';
                           echo '</div>';
                           echo '<div class="dh-product-description-content">' . $item['description'] . '</div>';
                        echo '</div>';
                     echo '</div>';  // dh-product-column
                     echo '<div class="dh-product-column">';
                        $shortcode = do_shortcode( shortcode_unautop( $item['shortcode'] ) );
                        echo '<div class="dh-product-shortcode-heading">Beste prijs</div>';
                        echo '<div class="dh-product-shortcode">' . $shortcode . '</div>';
                     echo '</div>'; // dh-product-column
                  echo '</div>'; // dh-product-wrapper
               echo '</div>'; // dh-product
            endforeach;
         echo '</div>'; // dh-products-grid
      endif;
	}




   protected function content_template() {
		?>
         <#
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

         <# if ( settings.products.length ) { #>
            <div class="dh-products-grid dh-products-{{{ settings.skin }}}-skin">
               <# _.each( settings.products, function( item, index ) { #>
                  <div class="dh-product dh-product-{{ item._id }}">
                     <div class="dh-product-wrapper">
                        <div class="dh-product-column">
                           <div class="dh-product-heading dh-number-heading">
                              <div class="dh-number">{{{ index + 1 }}}</div>
                              <h3 class="dh-heading">{{{ item.title }}}</h3>
                           </div>
                           <div class="dh-product-image">
                              <div class="dh-product-image-wrapper">
                                    <img src="{{ item.image.url }}">
                              </div>
                           </div>
                           <# if ( item.quality ) { #>
                              <div class="dh-product-quality">
                                 <div>Kwaliteit</div>
                                 <div>
                                    {{{ item.quality }}}
                                    <# if ( item.quality_tooltip ) { #>
                                       <i class="dh-icon dh-icon-info" data-dh-tooltip="{{{ item.quality_tooltip }}}"></i>
                                    <# } #>
                                 </div>
                              </div>
                           <# } #>
                           <# if ( item.co2 ) { #>
                              <div class="dh-product-co2">
                                 <div>CO<sub>2</sub> Afdruk</div>
                                 <div>
                                    {{{ item.co2 }}}kg CO<sub>2</sub>
                                    <# if ( item.co2_tooltip ) { #>
                                       <i class="dh-icon dh-icon-info" data-dh-tooltip="{{{ item.co2_tooltip }}}"></i>
                                    <# } #>
                                 </div>
                              </div>
                           <# } #>
                           <# if ( item.price ) { #>
                              <div class="dh-product-price">
                                 <div>Prijs</div>
                                 <div>
                                    {{{ item.price }}}
                                    <# if ( item.price_tooltip ) { #>
                                       <i class="dh-icon dh-icon-info" data-dh-tooltip="{{{ item.price_tooltip }}}"></i>
                                    <# } #>
                                 </div>
                              </div>
                           <# } #>
                           <div class="dh-product-score">
                              <img src="{{{ settings.logo_url }}}">
                              <div>
                                 <div class="dh-product-rating-heading">
                                    Duurzaam Thuis Score
                                    <# if ( item.rating_tooltip ) { #>
                                       <i class="dh-icon dh-icon-info" data-dh-tooltip="{{{ item.rating_tooltip }}}"></i>
                                    <# } #>
                                 </div>
                                 <div class="dh-product-rating">
                                    <div class="dh-text-rating">{{{ item.rating }}}/10</div>
                                    <div class="dh-list-rating">
                                    {{{ renderRating( item.rating ) }}}
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="dh-product-column">
                           <# var pros = check_and_parse_json( item.pros );  #>
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
                           <# var cons = check_and_parse_json( item.cons );  #>
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
                           <div class="dh-product-description">
                              <div class="dh-product-description-toggle">
                                 <div class="dh-open">Omschrijving<i class="dh-icon dh-icon-arrow-down"></i></div>
                              </div>
                              <div class="dh-product-description-content">{{{ item.description }}}</div>
                           </div>
                        </div>
                        <div class="dh-product-column">
                           <div class="dh-product-shortcode-heading">Beste prijs</div>
                           <div class="dh-product-shortcode">{{{ item.shortcode }}}</div>
                        </div>
                     </div>
                  </div>
               <# } ); #>
            </div>
         <# } #>
		<?php
	}
}