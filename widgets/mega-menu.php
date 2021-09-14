<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


class DH_Mega_Menu extends \Elementor\Widget_Base {

	public function get_name() {
		return 'dh-mega-menu';
	}

	public function get_title() {
		return __( 'Mega Menu', 'duurzaamthuis' );
	}

	public function get_icon() {
		return 'dh-icon dh-icon-impact';
	}

	public function get_categories() {
		return [ 'dh-widgets' ];
	}

	public function get_script_depends() {
		return [ 'duurzaamthuis-widgets' ];
	}

	private function get_available_menus() {
		$menus = wp_get_nav_menus();
		$options = [];
		foreach ( $menus as $menu ) {
			$options[$menu->slug] = $menu->name;
		}
		return $options;
	}

	protected function register_controls() {

		// SECTION CONTENT
		$this->start_controls_section( 'section_content', [
         'label' => __( 'Content', 'duurzaamthuis' ),
         'tab' => Elementor\Controls_Manager::TAB_CONTENT,
      ] );

			$menus = $this->get_available_menus();

			$this->add_control( 'menu', [
				'label' => __( 'Menu', 'duurzaamthuis' ),
				'type' => Elementor\Controls_Manager::SELECT,
				'options' => $menus,
				'default' => array_keys( $menus )[0],
			] );
			$this->add_control( 'mobile_menu', [
				'label' => __( 'Mobile Menu', 'duurzaamthuis' ),
				'type' => Elementor\Controls_Manager::SELECT,
				'default' => array_keys( $menus )[0],
				'options' => $menus,
			] );

		$this->end_controls_section(); 

		// SECTION STYLE DESKTOP
		$this->start_controls_section( 'section_style', [
         'label' => __( 'Desktop Menu', 'duurzaamthuis' ),
         'tab' => Elementor\Controls_Manager::TAB_STYLE,
      ] );
			$this->add_control( 'align_items', [
				'label' => __( 'Align', 'elementor-pro' ),
				'type' => Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'elementor-pro' ),
						'icon' => 'eicon-h-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'elementor-pro' ),
						'icon' => 'eicon-h-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'elementor-pro' ),
						'icon' => 'eicon-h-align-right',
					],
					'justify' => [
						'title' => __( 'Stretch', 'elementor-pro' ),
						'icon' => 'eicon-h-align-stretch',
					],
				],
				'toggle' => false,
				'default' => 'justify',
				'prefix_class' => 'dh-menu-align-',
			] );
			$this->add_control( 'space_between', [
				'label' => __( 'Space Between', 'duurzaamthuis' ),
				'type' => Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 10,
				],
				'condition' => [
					'align_items!' => 'justify',
				],
				'selectors' => [
					'{{WRAPPER}} .dh-menu-top-item:not(:last-child)' => 'margin-right: {{SIZE}}{{UNIT}};',
				],
			] );
			$this->add_control( 'icon_spacing', [
				'label' => __( 'Icon Spacing', 'duurzaamthuis' ),
				'type' => Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 5,
				],
				'selectors' => [
					'{{WRAPPER}} .dh-menu-top-item i' => 'margin-right: {{SIZE}}{{UNIT}};',
				],
			] );
			$this->add_control( 'offset', [
				'label' => __( 'Dropdown Offset', 'duurzaamthuis' ),
				'type' => Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 5,
				],
				'selectors' => [
					'{{WRAPPER}} .dh-megamenu .elementor-container' => 'top: {{SIZE}}{{UNIT}};',
				],
			] );
			$this->add_control( 'color', [
            'label' => __( 'Color', 'duurzaamthuis' ),
            'type' => Elementor\Controls_Manager::COLOR,
            'default' => '#515F70',
            'selectors' => [
               '{{WRAPPER}} .dh-menu-top-item' => 'color: {{VALUE}}',
            ],
				'separator' => 'after',
         ] );

		$this->end_controls_section(); 


		// SECTION STYLE MOBILE
		$this->start_controls_section( 'section_style_mobile', [
         'label' => __( 'Mobile Menu', 'duurzaamthuis' ),
         'tab' => Elementor\Controls_Manager::TAB_STYLE,
      ] );
			$this->add_control( 'align_toggle', [
				'label' => __( 'Align Toggle', 'elementor-pro' ),
				'type' => Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'elementor-pro' ),
						'icon' => 'eicon-h-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'elementor-pro' ),
						'icon' => 'eicon-h-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'elementor-pro' ),
						'icon' => 'eicon-h-align-right',
					],
				],
				'toggle' => false,
				'default' => 'right',
				'prefix_class' => 'dh-mobile-toggle-align-',
			] );
			$this->add_control( 'offset_mobile', [
				'label' => __( 'Dropdown Offset', 'duurzaamthuis' ),
				'type' => Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 30,
				],
				'selectors' => [
					'{{WRAPPER}} .dh-mobile-menu' => 'top: {{SIZE}}{{UNIT}};',
				],
			] );
		$this->end_controls_section(); 
	}


	public function build_menu_tree( array &$items, $parent_id = 0 ) {
		$branch = [];

		foreach ( $items as &$item ) {
			if ( $item->menu_item_parent == $parent_id ) {
				$children = $this->build_menu_tree( $items, $item->ID );
				if( $children ) {
					$item->children = $children;
				}
				$branch[$item->menu_order] = $item;
				unset( $item );
			}
		}

		return $branch;
  }


  protected function render() {

		$settings = $this->get_settings_for_display();

		if ( ! $settings['menu'] ) {
			return;
		}

		$items = wp_get_nav_menu_items( $settings['menu'] );
		if ( $items ) {
			$items_tree = $this->build_menu_tree( $items );  
			error_log( "items_tree\n" . print_r($items_tree, true) . "\n" );    

			echo '<nav><ul class="dh-menu">';
				foreach ( $items_tree as $top_level_item ) {
					echo '<li class="dh-menu-item dh-menu-top-item menu-item menu-item-' . $top_level_item->ID . ' ' . implode( " ", $top_level_item->classes ) . '">';
						echo '<a href="' . $top_level_item->url . '" class="">';
							$icon_classes = get_post_meta( $top_level_item->ID, '_menu_item_icon_classes', true );
							if ( $icon_classes ) {
								echo '<i class="' . $icon_classes . '"></i>';
							}
							echo $top_level_item->title;
							if ( ! empty( $top_level_item->children ) ) {
								echo '<i class="dh-dropdown-indicator dh-icon dh-icon-arrow-down"></i>';
							}
						echo '</a>';

						// dropdown
						if ( ! empty( $top_level_item->children ) ) {

							echo '<ul class="dh-megamenu elementor-section elementor-section-boxed">';
								echo '<div class="elementor-container">';
									foreach ( $top_level_item->children as $second_level_item ) {
										echo '<li class="dh-menu-item dh-second-level-item menu-item menu-item-' . $second_level_item->ID . ' ' . implode( " ", $second_level_item->classes ) . '">';
											echo '<a href="' . ( $second_level_item->url != '#' ? $second_level_item->url : '' ) . '" class="dh-menu-second-level-heading">' . $second_level_item->title . '</a>';
											echo '<ul class="dh-megamenu-second-level-item">';
												if ( ! empty( $second_level_item->children ) ) {
													foreach ( $second_level_item->children as $third_level_item ) {
														echo '<li class="dh-menu-item dh-third-level-item menu-item menu-item-' . $third_level_item->ID . ' ' . implode( " ", $third_level_item->classes ) . '">';
															echo '<a href="' . $third_level_item->url . '" class="dh-menu-third-item">' . $third_level_item->title . '</a>';
														echo '</li>';
													}
												}
											echo '</ul>';
											if ( $second_level_item->url != '#' ) {
												echo '<a href="' . $second_level_item->url . '" class="dh-menu-second-level-more">Lees Verder <i class="dh-icon dh-icon-arrow-right"></i></a>';
											}
										echo '</li>';
									}
							echo '</div>';
							echo '</ul>';

						}
					echo '</li>';
				}
			echo '</ul></nav>';  
		}

		$mobile_items = wp_get_nav_menu_items( $settings['mobile_menu'] ?: $settings['menu'] );
		if ( $mobile_items ) {
			$mobile_items_tree = $this->build_menu_tree( $mobile_items );      

			echo '<div class="dh-mobile-menu-toggle"><i class="dh-icon dh-icon-menu"></i></div>';
			echo '<nav><ul class="dh-mobile-menu">';

				foreach ( $mobile_items_tree as $top_level_item ) {
					echo '<li class="dh-menu-item dh-menu-top-item menu-item menu-item-' . $top_level_item->ID . ' ' . implode( " ", $top_level_item->classes ) . '">';
						$icon_classes = get_post_meta( $top_level_item->ID, '_menu_item_icon_classes', true );
						if ( empty( $top_level_item->children ) ) {
							echo '<a class="dh-mobile-submenu-toggle">';
								if ( $icon_classes ) {
									echo '<i class="' . $icon_classes . '"></i>';
								}
								echo $top_level_item->title;
							echo '</a>';
						} else {
							echo '<a class="dh-mobile-submenu-toggle">';
								if ( $icon_classes ) {
									echo '<i class="' . $icon_classes . '"></i>';
								}
								echo $top_level_item->title;
								echo '<i class="dh-dropdown-indicator dh-icon dh-icon-arrow-right"></i>';
							echo '</a>';
							echo '<ul class="dh-submenu">';
								foreach ( $top_level_item->children as $second_level_item ) {
									echo '<li class="dh-menu-item dh-second-level-item menu-item menu-item-' . $second_level_item->ID . ' ' . implode( " ", $second_level_item->classes ) . '">';
										if ( empty( $second_level_item->children ) ) {
											echo '<a href="' . $second_level_item->url . '">' . $second_level_item->title . '</a>';
										} else {
											echo '<a class="dh-mobile-submenu-toggle">';
												echo $second_level_item->title;
												echo '<i class="dh-dropdown-indicator dh-icon dh-icon-arrow-right"></i>';
											echo '</a>';
											echo '<ul class="dh-submenu">';
												foreach ( $second_level_item->children as $third_level_item ) {
													echo '<li class="dh-menu-item dh-third-level-item menu-item menu-item-' . $third_level_item->ID . ' ' . implode( " ", $third_level_item->classes ) . '">';
														echo '<a href="' . $third_level_item->url . '">' . $third_level_item->title . '</a>';
													echo '</li>';
												}
												echo '<li class="dh-menu-item dh-third-level-item menu-item menu-item-all ' . implode( " ", $third_level_item->classes ) . '">';
													echo '<a href="' . $second_level_item->url . '">Alles in ' . $second_level_item->title . '</a>';
											echo '</li>';
											echo '</ul>';
										}

									echo '</li>';
								}
								echo '<li class="dh-menu-item dh-second-level-item menu-item menu-item-all ' . implode( " ", $second_level_item->classes ) . '">';
										echo '<a href="' . $top_level_item->url . '">Alles in ' . $top_level_item->title . '</a>';
								echo '</li>';
							echo '</ul>';
						}
					echo '</li>';
				}


			echo '</ul></nav>';  
		}


	}

}