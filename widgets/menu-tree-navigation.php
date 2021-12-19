<?php

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Text_Shadow;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}



class DH_Menu_Tree_Navigation extends \Elementor\Widget_Base {

	public function get_name() {
		return 'dh-menu-tree-navigation';
	}

	public function get_title() {
		return __( 'Menu tree navigation', 'duurzaamthuis' );
	}

	public function get_icon() {
		return 'eicon-bullet-list';
	}

	public function get_categories() {
		return [ 'dh-widgets' ];
	}

   public function get_available_menus() {
		$menus = wp_get_nav_menus();

		$options = [];
      $options['dh_acf_page_menu'] = 'Automatic from page field';

		foreach ( $menus as $menu ) {
			$options[$menu->slug] = $menu->name;
		}

		return $options;
	}

	protected function register_controls() {
      $this->start_controls_section( 'section_content', [
         'label' => __( 'Settings', 'advanced-elementor-widgets' ),
      ] );
         $menus = $this->get_available_menus();

			$this->add_control( 'dh_menu_tree_heading', [
				'label' => __( 'Heading', 'duurzaamthuis' ),
				'type' => Elementor\Controls_Manager::TEXT,
				'default' => __( 'In deze categorie:' , 'duurzaamthuis' ),
				'label_block' => true,
			] );

         $this->add_control( 'dh_menu_tree_name', [
            'label' => 'Menu',
            'type' => \Elementor\Controls_Manager::SELECT,
            'options' => $menus,
            'default' => ! empty( $menus ) ? array_keys( $menus )[0] : '',
         ] );

         $this->add_control( 'dh_menu_tree_fallback', [
            'label' => 'Menu Fallback',
            'type' => \Elementor\Controls_Manager::SELECT,
            'options' => $menus,
            'default' => ! empty( $menus ) ? array_keys( $menus )[0] : '',
            'condition' => [
               'dh_menu_tree_name' => 'dh_acf_page_menu'
            ]
         ] );

      $this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

      global $post;
		$menu_id = false;
      if ( $settings['dh_menu_tree_name'] == 'dh_acf_page_menu' ) {
         $menu_id = get_field( 'dh_page_menu', $post->ID );
         if ( ! $menu_id ) {
            $menu_id = get_field( 'dh_page_menu', array_pop( get_post_ancestors( $post->ID ) ) );
         }
      }
      if ( ! $menu_id ) {
         $menu_obj = wp_get_nav_menu_object( $settings['dh_menu_tree_name'] );
         $menu_id  = $menu_obj ? $menu_obj->term_id : 0;
         if ( ! $menu_id ) {
            $menu_obj = wp_get_nav_menu_object( $settings['dh_menu_tree_fallback'] );
            $menu_id  = $menu_obj ? $menu_obj->term_id : 0;
         }
      }

      if ( ! $menu_id ) return;

      $menu_element_id = 'dh_menu_tree_' . $this->get_id();

		$args = [
			'echo' => false,
			'menu' => $menu_id,
			'container' => '',
			'menu_id' => $menu_element_id
		];
		$html = wp_nav_menu( $args );


		// DOM object to manipulate results of wp_list_categories()
		$DOM = new DOMDocument();
		$DOM->loadHTML( mb_convert_encoding( $html, 'HTML-ENTITIES', 'UTF-8' ) );
		$menu = $DOM->getElementById( $menu_element_id );

		$uls = $menu->getElementsByTagName( 'ul' );
		foreach( $uls as $ul ) {
			$parent = $ul->parentNode;
         $parent_classes = $parent->getAttribute('class');
			$firstChild = $parent->firstChild;

			$toggleSpan = $DOM->createDocumentFragment();

			if ( strpos( $parent_classes, 'current-menu-ancestor' ) !== false ) {
				$parent->setAttribute('class', $parent_classes . ' dh-opened dh-has-current-page dh-onload-opened');
			}

         $toggleSpan->appendXML('<span class="dh-subpages-toggle"><i class="eicon-chevron-right"></i></span>');
			$parent->insertBefore( $toggleSpan, $firstChild );
		}

      // remove link from current menu item
		$lis = $menu->getElementsByTagName( 'li' );
		foreach( $lis as $li ) {
         $classes = $li->getAttribute('class');
			if ( strpos( $classes, 'current-menu-item' ) !== false ) {
				$a = $li->getElementsByTagName( 'a' );
            $a[0]->removeAttribute( 'href' );
			}
		}

		$html=$DOM->saveHTML();

		echo '<h3 class="dh-menu-tree-heading">' . $settings['dh_menu_tree_heading'] . '</h3>';
		echo $html;	
	}

	
}