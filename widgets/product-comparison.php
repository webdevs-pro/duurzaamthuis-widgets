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
         ] );

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
            $repeater->add_control( 'product_price', [
               'label' => __( 'Price', 'plugin-domain' ),
               'type' => \Elementor\Controls_Manager::TEXT,
               'default' => '10',
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
      
      
		if ( $settings['products'] ) {
         echo '<div class="dh-products-grid">';
            foreach (  $settings['products'] as $item ) {
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
                  echo '</div>';
                  echo '<a class="dh-product-button" href="' . $item['product_button_link'] . '">' . $item['product_button_text'] . '</a>';
               echo '</div>';
            }
			echo '</div>';
		}
      

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


      <# if ( settings.products.length ) { #>
		   <div class="dh-products-grid">
            <# _.each( settings.products, function( item ) { #>
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
            <# }); #>
			</div>
		<# } #>

		<?php
	}
}