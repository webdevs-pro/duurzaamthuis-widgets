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
		return 'eicon-menu-bar';
	}

	public function get_categories() {
		return [ 'dh-widgets' ];
	}

	public function get_script_depends() {
		return [ 'duurzaamthuis-widgets' ];
	}

	public static function get_available_menus() {
		$menus = wp_get_nav_menus();
		$options = [];
		foreach ( $menus as $menu ) {
			$options[$menu->slug] = $menu->name;
		}
		return $options;
	}

	protected function register_controls() {
      DH_Widgets_Content_Controls::get_dh_mega_menu_controls( $this );
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

		if ( ! $settings['dh_mega_menu_menu'] ) {
			return;
		}

		?><?php 
				$e = new Exception(); 
				$is_multiwidget = strpos( $e->getTrace()[2]['file'], 'multiwidgets.php' ) ? true : false;
				echo sprintf( '<div class="%s"%s>',
					( $is_multiwidget ? 'elementor-element elementor-widget elementor-widget-' . $this->get_name() : '' ) . ' dh-widget-' . $this->get_name() . DH_Widgets_Content_Controls::get_prefix_classes( $this, $settings ),
					$is_multiwidget ? ' data-widget_type="' . $this->get_name() . '.default" data-element_type="widget"' : ''
				); 
			?><?php
		$items = wp_get_nav_menu_items( $settings['dh_mega_menu_menu'] );


		echo '<div class="dh-mobile-menu-toggle"><i class="dh-icon dh-icon-menu"></i></div>';

		if ( $items ) {
			$items_tree = $this->build_menu_tree( $items );  
			error_log( "items_tree\n" . print_r($items_tree, true) . "\n" );    

			echo '<nav class="dh-menu"><ul class="dh-menu-wrapper">';
				foreach ( $items_tree as $top_level_item ) {
					echo '<li class="dh-menu-item dh-menu-top-item menu-item menu-item-' . $top_level_item->ID . ' ' . implode( " ", $top_level_item->classes ) . '">';
						echo '<a href="' . $top_level_item->url . '" class="">';
							$icon_svg = get_post_meta( $top_level_item->ID, '_menu_item_icon_svg', true );
							if ( $icon_svg ) {
								echo $icon_svg;
							} else {
								$icon_classes = get_post_meta( $top_level_item->ID, '_menu_item_icon_classes', true );
								if ( $icon_classes ) {
									echo '<i class="' . $icon_classes . '"></i>';
								}
							}
							echo $top_level_item->title;
							if ( ! empty( $top_level_item->children ) ) {
								echo '<span class="top-level-toggle"><svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M7.52867 10.8047C7.78901 11.0651 8.21114 11.0651 8.47148 10.8047L13.1381 6.13807C13.3985 5.87773 13.3985 5.4556 13.1381 5.19526C12.8778 4.93491 12.4557 4.93491 12.1954 5.19526L8.00009 9.39049L3.80482 5.19526C3.54448 4.93491 3.12235 4.93491 2.86201 5.19526C2.60166 5.4556 2.60166 5.87773 2.86201 6.13807L7.52868 10.8047H7.52867Z" fill="black"/></svg></span>';
							}
						echo '</a>';

						// dropdown
						if ( ! empty( $top_level_item->children ) ) {

							echo '<ul class="dh-megamenu elementor-section elementor-section-boxed" style="visibility: hidden;">';
								echo '<div class="elementor-container">';
									foreach ( $top_level_item->children as $second_level_item ) {
										echo '<li class="dh-menu-item dh-second-level-item menu-item menu-item-' . $second_level_item->ID . ' ' . implode( " ", $second_level_item->classes ) . '">';
											echo '<a href="' . $second_level_item->url . '" class="dh-menu-second-level-heading">' . $second_level_item->title;
												if ( ! empty( $second_level_item->children ) ) {
													echo '<span class="top-level-toggle second"><svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M7.52867 10.8047C7.78901 11.0651 8.21114 11.0651 8.47148 10.8047L13.1381 6.13807C13.3985 5.87773 13.3985 5.4556 13.1381 5.19526C12.8778 4.93491 12.4557 4.93491 12.1954 5.19526L8.00009 9.39049L3.80482 5.19526C3.54448 4.93491 3.12235 4.93491 2.86201 5.19526C2.60166 5.4556 2.60166 5.87773 2.86201 6.13807L7.52868 10.8047H7.52867Z" fill="black"/></svg></span>';
												}
											echo '</a>';
											echo '<ul class="dh-megamenu-second-level-item">';
												if ( ! empty( $second_level_item->children ) ) {
													foreach ( $second_level_item->children as $third_level_item ) {
														echo '<li class="dh-menu-item dh-third-level-item menu-item menu-item-' . $third_level_item->ID . ' ' . implode( " ", $third_level_item->classes ) . '">';
															echo '<a href="' . $third_level_item->url . '" class="dh-menu-third-item">' . $third_level_item->title . '</a>';
														echo '</li>';
													}
												}
											echo '</ul>';


										echo '</li>';
									}
							echo '</div>';
							echo '</ul>';

						}
					echo '</li>';
				}
			echo '</ul></nav>';  
		}

		?></div><?php
	}

}