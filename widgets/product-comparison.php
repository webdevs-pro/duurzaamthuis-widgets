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

	protected function _register_controls() {

		// SECTION CONTENT
		$this->start_controls_section( 'section_content', [
         'label' => __( 'Content', 'duurzaamthuis' ),
         'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
      ]);

         $this->add_control( 'skin', [
            'label' => __( 'Skin', 'duurzaamthuis' ),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'simple',
            'options' => [
               'simple'  => __( 'Simple', 'duurzaamthuis' ),
               'extended' => __( 'Extended', 'duurzaamthuis' ),
            ],
            'classes' => "dh-skin-control",
         ] );

         $this->add_control(
            'controls_conditions',
            [
               'type' => \Elementor\Controls_Manager::RAW_HTML,
               'raw' => $this->get_controls_conditions_script(),            
            ]
         );

         $this->add_responsive_control( 'columns_count', [
				'label' => __( 'Columns', 'duurzaamthuis' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 6,
				'step' => 1,
				'default' => 3,
				'tablet_default' => 2,
				'mobile_default' => 1,
				'selectors' => [
					'{{WRAPPER}} .dh-products-grid' => 'grid-template-columns: repeat({{VALUE}}, 1fr);',
				],         
			]);

         $repeater = new \Elementor\Repeater();

            $repeater->add_control( 'title', [
               'label' => __( 'Title', 'duurzaamthuis' ),
               'type' => \Elementor\Controls_Manager::TEXT,
               'default' => __( 'Product title' , 'duurzaamthuis' ),
               'label_block' => true,
            ] );
            $repeater->add_control( 'badge', [
               'label' => __( 'Badge', 'duurzaamthuis' ),
               'type' => \Elementor\Controls_Manager::SELECT,
               'default' => 'none',
               'options' => [
                  'none'  => __( 'None', 'duurzaamthuis' ),
                  'best_price' => __( 'Beste Prijs', 'duurzaamthuis' ),
                  'best_quality' => __( 'Beste Kwaliteit', 'duurzaamthuis' ),
                  'eco_choice' => __( 'Environmental choice', 'duurzaamthuis' ),
               ],
               'classes' => "extended-skin-control",
            ] );
            $repeater->add_control( 'image', [
               'label' => __( 'Image', 'duurzaamthuis' ),
               'type' => \Elementor\Controls_Manager::MEDIA,
               'default' => [
                  'url' => \Elementor\Utils::get_placeholder_image_src(),
               ],
            ] );
            $repeater->add_control( 'star_rating', [
               'label' => __( 'Rating', 'elementor' ),
               'type' => \Elementor\Controls_Manager::NUMBER,
               'min' => 0,
               'max' => 5,
               'step' => 0.1,
               'default' => 5,
            ] );
            $repeater->add_control( 'product_text_rating', [
               'label' => __( 'Text Rating', 'duurzaamthuis' ),
               'type' => \Elementor\Controls_Manager::TEXT,
               'classes' => "extended-skin-control",
               'label_block' => true,
               'default' => '9.5/10 van 26 reviews op cooiblue en Bol.com',
            ] );
            $repeater->add_control( 'price', [
               'label' => __( 'Price', 'duurzaamthuis' ),
               'type' => \Elementor\Controls_Manager::TEXT,
               'default' => '10',
               ] );
            $repeater->add_control( 'order_by', [
               'label' => __( 'Order By', 'duurzaamthuis' ),
               'type' => \Elementor\Controls_Manager::TEXT,
               'default' => 'Voor 23:59 besteld',
            ] );
            $repeater->add_control( 'button_text', [
               'label' => __( 'Button Text', 'duurzaamthuis' ),
               'type' => \Elementor\Controls_Manager::TEXT,
               'separator' => 'before',
               'default' => 'Button text',
               'label_block' => true,
            ] );
            $repeater->add_control( 'button_link', [
               'label' => __( 'Button Link', 'duurzaamthuis' ),
               'type' => \Elementor\Controls_Manager::TEXT,
               'default' => '#',
               'label_block' => true,
            ] );
            $repeater->add_control( 'sponsored',[
               'label' => __( 'Sponsored', 'duurzaamthuis' ),
               'type' => \Elementor\Controls_Manager::SWITCHER,
               'label_on' => __( 'Yes', 'your-plugin' ),
               'label_off' => __( 'No', 'your-plugin' ),
               'return_value' => 'yes',
               'default' => 'yes',
               'render_type' => 'ui',
            ]);
            $repeater->add_control( 'pros', [
               'label' => 'Pros',
               'label_block' => false,
               'button_title' => __( 'Edit Pros', 'duurzaamthuis' ),
               'type' => 'dh-table-control',
               'separator' => 'before',
               'allow_columns' => false,
               'table_classes' => 'repeater',
               'add_row_title' => __( 'Add Item', 'duurzaamthuis' ),
               'default' => '[["Pros 1"],["Pros 2"]]',
               'classes' => "extended-skin-control",
            ]);
            $repeater->add_control( 'cons', [
               'label' => 'Cons',
               'type' => 'dh-table-control',
               'label_block' => false,
               'button_title' => __( 'Edit Cons', 'duurzaamthuis' ),
               'allow_columns' => false,
               'table_classes' => 'repeater',
               'add_row_title' => __( 'Add Item', 'duurzaamthuis' ),
               'default' => '[["Cons 1"],["Cons 2"]]',
               'classes' => "extended-skin-control",
            ]);
            $repeater->add_control( 'description', [
               'label' => __( 'Description', 'duurzaamthuis' ),
               'type' => \Elementor\Controls_Manager::TEXTAREA,
               'rows' => 10,
               'default' => __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. ', 'duurzaamthuis' ),
               'placeholder' => __( 'Type your description here', 'duurzaamthuis' ),
               'classes' => "extended-skin-control",
            ]);



         $this->add_control( 'products', [
            'label' => __( 'Products', 'duurzaamthuis' ),
            'type' => \Elementor\Controls_Manager::REPEATER,
            'fields' => $repeater->get_controls(),
            'default' => [
               [
                  'title' => __( 'Product title', 'duurzaamthuis' ),
               ],
            ],
            'title_field' => '{{{ title }}}',
         ] );

         // $this->add_control( 'pros', [
         //    'label' => 'Pros',
         //    'label_block' => false,
         //    'button_title' => __( 'Edit Pros', 'duurzaamthuis' ),
         //    'type' => 'dh-table-control',
         //    'separator' => 'before',
         //    'allow_columns' => false,
         //    'add_row_title' => __( 'Add Item', 'duurzaamthuis' ),
         //    'default' => '[["Pros 1"],["Pros 2"]]',
         //    'classes' => "extended-skin-control",
         // ]);
         // $this->add_control( 'cons', [
         //    'label' => 'Cons',
         //    'type' => 'dh-table-control',
         //    'label_block' => false,
         //    'button_title' => __( 'Edit Cons', 'duurzaamthuis' ),
         //    'allow_columns' => false,
         //    'add_row_title' => __( 'Add Item', 'duurzaamthuis' ),
         //    'default' => '[["Cons 1"],["Cons 2"]]',
         //    'classes' => "extended-skin-control",
         // ]);

		$this->end_controls_section(); 



		// SECTION STYLE
		$this->start_controls_section( 'section_style', [
         'label' => __( 'Style', 'duurzaamthuis' ),
         'tab' => \Elementor\Controls_Manager::TAB_STYLE,
      ]);



		$this->end_controls_section(); 

	}

   protected function get_controls_conditions_script() {
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
                     jQuery('#dh-controls-conditions').html('');
                  }
               }
            #>
         <?php
      return ob_get_clean();
   }


   // protected function register_skins() {
   //    require_once( DH_PLUGIN_DIR . '/widgets/product-comparison-extended-skin.php' );
	// 	$this->add_skin( new DH_Product_Comparison_Extended_Skin( $this ) );
	// }
   
   
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
      
      
		if ( $settings['products'] ) :

         echo '<div class="dh-products-grid dh-products-' . $settings['skin'] . '-skin">';
            foreach (  $settings['products'] as $item ) :

               // simple skin
               if ( $settings['skin'] == 'simple' ) :
                  echo '<div class="dh-product dh-product-' . $item['_id'] . '">';
                     echo '<div class="dh-product-image">';
                        if ( $item['image']['id'] ) {
                           echo wp_get_attachment_image( $item['image']['id'], 'medium' );
                        } else {
                           echo '<img src="' . \Elementor\Utils::get_placeholder_image_src() . '">';
                        }
                        
                     echo '</div>';
                     echo '<div class="dh-product-content">';
                        echo '<h3 class="dh-product-title">' . $item['title'] . '</h3>';
                        echo '<div class="dh-product-star-rating">';
                           echo '<div class="elementor-star-rating">';
                              echo $this->render_stars( $item['star_rating'] );
                           echo '</div>';
                        echo '</div>';
                        echo '<div class="dh-product-price">€ ' . $item['price'] . '</div>';
                        echo '<div class="dh-product-order-by"> ' . $item['order_by'] . '</div>';
                     echo '</div>';
                     $rel = isset( $item['sponsored'] ) ? ' rel="sponsored"' : '';
                     echo '<a class="dh-product-button" href="' . $item['button_link'] . '"' . $rel . '>' . $item['button_text'] . '</a>';
                  echo '</div>';
               endif;



               // extended skin
               if ( $settings['skin'] == 'extended' ) :
                  echo '<div class="dh-product dh-product-' . $item['_id'] . '">';
                     echo '<div class="dh-product-image">';
                        if ( $item['badge'] ) {
                           switch ( $item['badge'] ) {
                              case 'best_price':
                                 echo '<div class="dh-product-badge dh-product-price-badge">Beste Prijs</div>';
                                 break;
                              case 'best_quality':
                                 echo '<div class="dh-product-badge dh-product-quality-badge">Beste kwaliteit</div>';
                                 break;
                              case 'eco_choice':
                                 echo '<div class="dh-product-badge dh-product-eco-badge">Environmental choice</div>';
                                 break;
                           }
                        }
                        if ( $item['image']['id'] ) {
                           echo wp_get_attachment_image( $item['image']['id'], 'medium' );
                        } else {
                           echo '<img src="' . \Elementor\Utils::get_placeholder_image_src() . '">';
                        }
                     echo '</div>';
                     echo '<div class="dh-product-content">';
                        echo '<div class="dh-product-star-rating">';
                           echo '<div class="dh-product-star-rating-heading">Beoordeling</div>';
                           echo '<div class="elementor-star-rating">';
                              echo $this->render_stars( $item['star_rating'] );
                           echo '</div>';
                        echo '</div>';
                        echo '<div class="dh-product-rating">' . $item['product_text_rating'] . '</div>';
                        echo '<div class="dh-product-price">Price: <span>€ ' . $item['price'] . '</span></div>';
                        echo '<h3 class="dh-product-title">' . $item['title'] . '</h3>';

                        $pros = json_decode( $item['pros'] );
                        echo '<div class="dh-product-pros">';
                        foreach ( $pros as $pros_item ) {
                           echo '<div class="dh-product-pros-item">';
                              echo '<i class=""></i>';
                              echo '<div class="dh-product-pros-item-text">' . $pros_item[0] . '</div>';
                           echo '</div>';
                        }
                        echo '</div>';
                     echo '</div>';
                     $rel = isset( $item['sponsored'] ) ? ' rel="sponsored"' : '';
                     echo '<a class="dh-product-button" href="' . $item['button_link'] . '"' . $rel . '>' . $item['button_text'] . '</a>';
                  echo '</div>';
               endif;

            endforeach;
         echo '</div>';
      endif;
      

	}




   protected function content_template() {
		?>
         <#
            renderStars = function( rating ) {
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
         #>

         <!-- simple skin -->
         <# if(settings.products.length) { #>
            <div class="dh-products-grid dh-products-{{{ settings.skin }}}-skin">
               <# _.each( settings.products, function( item ) { #>

                  <!-- simple skin -->
                  <# if(settings.skin == 'simple') { #>
                     <div class="dh-product dh-product-{{ item._id }}">
                        <div class="dh-product-image">
                           <img src="{{ item.image.url }}">
                        </div>
                        <div class="dh-product-content">
                           <h3 class="dh-product-title">{{{ item.title }}}</h3>
                           <div class="dh-product-star-rating">
                              <div class="elementor-star-rating">
                                 {{{ renderStars( item.star_rating ) }}}
                              </div>
                           </div>
                           <div class="dh-product-price">€ {{{ item.price }}}</div>
                           <div class="dh-product-order-by">{{{ item.order_by }}}</div>

                        </div>
                        <a class="dh-product-button" href="{{{ item.button_link }}}">{{{ item.button_text }}}</a>
                     </div>
                  <# } #>

                  <!-- extended skin -->
                  <# if(settings.skin == 'extended') { #>
                     <div class="dh-product dh-product-{{ item._id }}">
                        <#
                           if(item.badge) {
                              switch(item.badge) {
                                 case 'best_price': #>
                                    <div class="dh-product-badge dh-product-price-badge">Beste Prijs</div>
                                    <# break;
                                 case 'best_quality': #>
                                    <div class="dh-product-badge dh-product-quality-badge">Beste kwaliteit</div>
                                    <# break;
                                 case 'eco_choice': #>
                                    <div class="dh-product-badge dh-product-eco-badge">Environmental choice</div>
                                    <# break;
                              }
                           }
                        #>
                        <div class="dh-product-image">
                           <img src="{{ item.image.url }}">
                        </div>
                        <div class="dh-product-content">
                           <div class="dh-product-star-rating">
                              <div class="dh-product-star-rating-heading">Beoordeling</div>
                              <div class="elementor-star-rating">
                                 {{{ renderStars( item.star_rating ) }}}
                              </div>
                           </div>
                           <div class="dh-product-rating">{{{ item.product_text_rating }}}</div>
                           <div class="dh-product-price">€ {{{ item.price }}}</div>
                           <h3 class="dh-product-title">{{{ item.title }}}</h3>
                        </div>
                        <a class="dh-product-button" href="{{{ item.button_link }}}">{{{ item.button_text }}}</a>
                     </div>
                  <# } #>

               <# }); #>

            </div>


         <# } #>


		<?php
	}
}