<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}



class DH_Related_Posts extends \Elementor\Widget_Base {

	public function get_name() {
		return 'dh-related-posts';
	}

	public function get_title() {
		return __( 'Related Posts', 'duurzaamthuis' );
	}

	public function get_icon() {
		return 'eicon-gallery-grid';
	}

	public function get_categories() {
		return [ 'dh-widgets' ];
	}

	protected function register_controls() {
      
      ob_start(); ?>
      <# 
         (function($) { 
            var id = Math.floor(Math.random()*9000000) + 1000000; 
            print('<span id="dh-repeater-item-' + id + '"></span>'); 
            var counter = 0;
            var timer = setInterval(function() {
               var repeater_item = $('#dh-repeater-item-' + id).closest('.elementor-repeater-fields');
               if(repeater_item.length) {
                  var title = $(repeater_item).find('.select2-selection__rendered').attr('title');
                  if(title) {
                     clearInterval(timer);
                     $(repeater_item).find('.elementor-repeater-row-item-title').text(title);
                  } else {
                     counter++;
                     if(counter > 10) {
                        clearInterval(timer);
                        $(repeater_item).find('.elementor-repeater-row-item-title').text('');
                     }
                  }
               }
            }, 300);		
			})(jQuery);
      #>

	<?php $script = ob_get_clean();

		// SECTION CONTENT
		$this->start_controls_section( 'section_content', [
         'label' => __( 'Content', 'duurzaamthuis' ),
         'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
      ] );
         $this->add_control( 'type', [
            'label' => __( 'Query', 'duurzaamthuis' ),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'manual',
            'options' => [
               'manual'  => __( 'Simple', 'duurzaamthuis' ),
               'related' => __( 'Related', 'duurzaamthuis' ),
            ],
         ] );
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
               '{{WRAPPER}} .dh-related-posts-grid' => 'grid-template-columns: repeat({{VALUE}}, 1fr);',
            ],         
         ] );

         $repeater = new \Elementor\Repeater();
            $repeater->add_control( 'id', [
               'label' => __( 'Search & Select', 'elementor-pro' ),
               'type' => ElementorPro\Modules\QueryControl\Module::QUERY_CONTROL_ID,
               'options' => [],
               'label_block' => true,
               'multiple' => false,
               'autocomplete' => [
                  'object' => ElementorPro\Modules\QueryControl\Module::QUERY_OBJECT_POST,
                  'display' => 'ms_custom',
                  'query' => [
                     'post_type' => 'any',
                     'post_status' => 'publish',
                  ],
               ],
            ] );
         $this->add_control( 'posts', [
            'label' => __( 'Posts', 'duurzaamthuis' ),
            'type' => \Elementor\Controls_Manager::REPEATER,
            'fields' => $repeater->get_controls(),
				'title_field' => $script,
				'condition' => [
					'type' => 'manual',
				],
				'show_label' => false,
				'prevent_empty' => false,
				'description' => 'Press \'+ Add item\' button to select posts. You can change posts order by dragging repeater items',
         ] );



		$this->end_controls_section(); 



	}

	protected function render() { // php template

		$settings = $this->get_settings_for_display();



	}
	
}
// add_filter( 'elementor/query/query_args', function( $args, $widget ) {
// 	if ($widget->get_settings('posts_post_type') == 'by_id') {
// 		$posts = array_column($widget->get_settings('custom_ids'), 'id');
// 		if(!empty($posts)) {
// 			$args['post__in'] = $posts;
// 			$args['orderby'] = 'post__in';
// 			$args['posts_per_page'] = '-1';
// 			$args['post_type'] = 'any';
// 		}
// 	}
// 	return $args;
// }, 10, 2);
