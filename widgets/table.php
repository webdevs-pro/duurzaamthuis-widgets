<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}



class DH_Table extends \Elementor\Widget_Base {

	public function get_name() {
		return 'dh-table';
	}

	public function get_title() {
		return __( 'Table', 'duurzaamthuis' );
	}

	public function get_icon() {
		return 'eicon-table';
	}

	public function get_categories() {
		return [ 'dh-widgets' ];
	}

	protected function register_controls() {
      DH_Widgets_Content_Controls::get_dh_table_controls( $this );
	}

	protected function render() { // php template
		$settings = $this->get_settings_for_display();

		$rows = json_decode( $settings['dh_table_table'] ) ?: array();
      if ( empty( $rows ) ) return;
      ?><?php 
				$e = new Exception(); 
				$is_multiwidget = strpos( $e->getTrace()[2]['file'], 'multiwidgets.php' ) ? true : false;
				echo sprintf( '<div class="%s"%s>',
					( $is_multiwidget ? 'elementor-element elementor-widget elementor-widget-' . $this->get_name() : '' ) . ' dh-widget-' . $this->get_name() . DH_Widgets_Content_Controls::get_prefix_classes( $this, $settings ),
					$is_multiwidget ? ' data-widget_type="' . $this->get_name() . '.default" data-element_type="widget"' : ''
				); 
			?><?php

         $html = '<div class="dh-table-wrapper"><table>';
         foreach ( $rows as $index => $row ) {
            if ( $index == 0 ) {
               $tag = 'th';
            } else {
               $tag = 'td';
            }
            $html .= '<tr>';
            foreach ( $row as $cell ) {
               $html .= '<' . $tag . '>' . $cell . '</' . $tag . '>';
            }
            $html .= '</tr>';
         }
         $html .= '</table></div>';
         echo $html;
		?></div><?php
	}
	
}