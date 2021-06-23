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
            'label' => __( 'Skin', 'plugin-domain' ),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'simple',
            'options' => [
               'simple'  => __( 'Simple', 'plugin-domain' ),
               'extended' => __( 'Extended', 'plugin-domain' ),
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
				'label' => __( 'Columns', 'plugin-domain' ),
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

            $repeater->add_control( 'product_title', [
               'label' => __( 'Title', 'plugin-domain' ),
               'type' => \Elementor\Controls_Manager::TEXT,
               'default' => __( 'Product title' , 'plugin-domain' ),
               'label_block' => true,
            ] );
            $repeater->add_control( 'product_badge', [
               'label' => __( 'Badge', 'plugin-domain' ),
               'type' => \Elementor\Controls_Manager::SELECT,
               'default' => 'none',
               'options' => [
                  'none'  => __( 'None', 'plugin-domain' ),
                  'best_price' => __( 'Beste Prijs', 'plugin-domain' ),
                  'best_quality' => __( 'Beste Kwaliteit', 'plugin-domain' ),
                  'eco_choice' => __( 'Environmental choice', 'plugin-domain' ),
               ],
               'classes' => "extended-skin-control",
            ] );
            $repeater->add_control( 'product_image', [
               'label' => __( 'Image', 'plugin-domain' ),
               'type' => \Elementor\Controls_Manager::MEDIA,
               'default' => [
                  'url' => \Elementor\Utils::get_placeholder_image_src(),
               ],
            ] );
            $repeater->add_control( 'product_rating', [
               'label' => __( 'Rating', 'elementor' ),
               'type' => \Elementor\Controls_Manager::NUMBER,
               'min' => 0,
               'max' => 5,
               'step' => 0.1,
               'default' => 5,
            ] );
            $repeater->add_control( 'product_text_rating', [
               'label' => __( 'Text Rating', 'plugin-domain' ),
               'type' => \Elementor\Controls_Manager::TEXT,
               'classes' => "extended-skin-control",
            ] );
            $repeater->add_control( 'product_price', [
               'label' => __( 'Price', 'plugin-domain' ),
               'type' => \Elementor\Controls_Manager::TEXT,
               'default' => '10',
               ] );
            $repeater->add_control( 'product_order_by', [
               'label' => __( 'Order By', 'plugin-domain' ),
               'type' => \Elementor\Controls_Manager::TEXT,
               'classes' => "extended-skin-control",
               'label_block' => true,
               'default' => 'Voor 23:59 besteld',
            ] );
            $repeater->add_control( 'product_button_text', [
               'label' => __( 'Button Text', 'plugin-domain' ),
               'type' => \Elementor\Controls_Manager::TEXT,
               'separator' => 'before',
               'default' => 'Button text',
               'label_block' => true,
            ] );
            $repeater->add_control( 'product_button_link', [
               'label' => __( 'Button Link', 'plugin-domain' ),
               'type' => \Elementor\Controls_Manager::TEXT,
               'default' => '#',
               'label_block' => true,
            ] );
            $repeater->add_control(
               'sponsored',
               [
                  'label' => __( 'Sponsored', 'plugin-domain' ),
                  'type' => \Elementor\Controls_Manager::SWITCHER,
                  'label_on' => __( 'Yes', 'your-plugin' ),
                  'label_off' => __( 'No', 'your-plugin' ),
                  'return_value' => 'yes',
                  'default' => 'yes',
                  'render_type' => 'ui',
               ]
            );
            $repeater->add_control( 'pros', [
               'label' => 'Pros',
               'label_block' => false,
               'buton_title' => __( 'Edit Pros', 'plugin-domain' ),
               'type' => 'dh-table-control',
               'separator' => 'before',
               'allow_columns' => false,
               'add_row_title' => __( 'Add Item', 'plugin-domain' ),
               'default' => '[["Pros 1"],["Pros 2"]]',
               'classes' => "extended-skin-control",
            ]);
            $repeater->add_control( 'cons', [
               'label' => 'Cons',
               'type' => 'dh-table-control',
               'label_block' => false,
               'buton_title' => __( 'Edit Cons', 'plugin-domain' ),
               'allow_columns' => false,
               'add_row_title' => __( 'Add Item', 'plugin-domain' ),
               'default' => '[["Cons 1"],["Cons 2"]]',
               'classes' => "extended-skin-control",
            ]);



         $this->add_control( 'products', [
            'label' => __( 'Products', 'plugin-domain' ),
            'type' => \Elementor\Controls_Manager::REPEATER,
            'fields' => $repeater->get_controls(),
            'default' => [
               [
                  'product_title' => __( 'Product title', 'plugin-domain' ),
               ],
            ],
            'title_field' => '{{{ product_title }}}',
         ] );

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
                        if ( $item['product_image']['id'] ) {
                           echo wp_get_attachment_image( $item['product_image']['id'], 'medium' );
                        } else {
                           echo '<img src="' . \Elementor\Utils::get_placeholder_image_src() . '">';
                        }
                        
                     echo '</div>';
                     echo '<div class="dh-product-content">';
                        echo '<h3 class="dh-product-title">' . $item['product_title'] . '</h3>';
                        echo '<div class="elementor-star-rating">';
                           echo $this->render_stars( $item['product_rating'] );
                        echo '</div>';
                        echo '<div class="dh-product-price">€ ' . $item['product_price'] . '</div>';
                        echo '<div class="dh-product-order-by"> ' . $item['product_order_by'] . '</div>';
                     echo '</div>';
                     echo '<a class="dh-product-button" href="' . $item['product_button_link'] . '">' . $item['product_button_text'] . '</a>';
                  echo '</div>';
               endif;



               // extended skin
               if ( $settings['skin'] == 'extended' ) :
                  echo '<div class="dh-product dh-product-' . $item['_id'] . '">';
                     echo '<div class="dh-product-image">';
                        if ( $item['product_badge'] ) {
                           switch ( $item['product_badge'] ) {
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
                        if ( $item['product_image']['id'] ) {
                           echo wp_get_attachment_image( $item['product_image']['id'], 'medium' );
                        } else {
                           echo '<img src="' . \Elementor\Utils::get_placeholder_image_src() . '">';
                        }
                        
                     echo '</div>';
                     echo '<div class="dh-product-content">';
                        echo '<h3 class="dh-product-title">' . $item['product_title'] . '</h3>';
                        echo '<div class="elementor-star-rating">';
                           echo $this->render_stars( $item['product_rating'] );
                        echo '</div>';
                        echo '<div class="dh-product-price">€ ' . $item['product_price'] . '</div>';
                        echo '<div class="dh-product-order-by"> ' . $item['product_order_by'] . '</div>';
                     echo '</div>';
                     echo '<a class="dh-product-button" href="' . $item['product_button_link'] . '">' . $item['product_button_text'] . '</a>';
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
                           <img src="{{ item.product_image.url }}">
                        </div>
                        <div class="dh-product-content">
                           <h3 class="dh-product-title">{{{ item.product_title }}}</h3>
                           <div class="elementor-star-rating">
                              {{{ renderStars( item.product_rating ) }}}
                           </div>
                           <div class="dh-product-price">€ {{{ item.product_price }}}</div>
                        </div>
                        <a class="dh-product-button" href="{{{ item.product_button_link }}}">{{{ item.product_button_text }}}</a>
                     </div>
                  <# } #>

                  <!-- extended skin -->
                  <# if(settings.skin == 'extended') { #>
                     <div class="dh-product dh-product-{{ item._id }}">
                        <#
                           if(item.product_badge) {
                              switch(item.product_badge) {
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
                           <img src="{{ item.product_image.url }}">
                        </div>
                        <div class="dh-product-content">
                           <h3 class="dh-product-title">{{{ item.product_title }}}</h3>
                           <div class="elementor-star-rating">
                              {{{ renderStars( item.product_rating ) }}}
                           </div>
                           <div class="dh-product-price">€ {{{ item.product_price }}}</div>
                        </div>
                        <a class="dh-product-button" href="{{{ item.product_button_link }}}">{{{ item.product_button_text }}}</a>
                     </div>
                  <# } #>

               <# }); #>

            </div>


         <# } #>


		<?php
	}
}