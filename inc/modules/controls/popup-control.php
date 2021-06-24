<?php

class DH_Popup_Control extends \Elementor\Base_Data_Control {

	public function get_type() {
		return 'dh-table-control';
	}

	protected function get_default_settings() {
		return [
			'label_block' => true,
		];
	}

	public function content_template() {
		$control_uid = $this->get_control_uid();
		?>
         <div class="elementor-control-field">
            <# if ( data.label ) {#>
               <div class="elementor-control-title">{{{ data.label }}}</div>
            <# } #>

            <div class="elementor-control-input-wrapper">

               <input id="<?php echo $control_uid; ?>" type="hidden" data-setting="{{{ data.name }}}" />

               <# var json = JSON.stringify(data); #>
               <div class="elementor-button-wrapper">
                  <button class="elementor-button elementor-button-default dh-control-popup-open" data-settings="{{ json }}" type="button">{{{ data.button_title }}}</button>
               </div>

            </div>



         </div>
         <# if ( data.description ) { #>
            <div class="elementor-control-field-description">{{{ data.description }}}</div>
         <# } #>

		<?php
	}

   

}

// enqueue editor assets
add_action( 'elementor/editor/after_enqueue_scripts', function() {
   wp_register_script( 'dh-editor', plugins_url( '/assets/editor.js', __FILE__ ), array( 'jquery' ), time() );
   wp_enqueue_script( 'dh-editor' );
   wp_enqueue_style( 'dh-editor', plugins_url( '/assets/editor.css', __FILE__ ), array(), time() ); 
});


add_action( 'elementor/editor/footer', function() {
   ?>

      
      <script type="text/html" id="tmpl-my-template">
         <div class="dh-control-popup-wrapper">
            <div class="dh-control-popup">
               <div class="dh-control-popup-header">
                  <div class="dh-control-popup-title">{{{ data.button_title }}}</div>
                  <div class="dh-control-popup-close">
                     <i aria-hidden="true" class="far fa-times-circle"></i>
                  </div>
               </div>
               <div class="dh-control-popup-content">
         
                  <table class="dh-table-{{{ data._cid }}} {{{ data.table_classes }}}" data-table-id="{{{ data._cid }}}"></table>
                  <button class="dh-add-row"><i class="fas fa-plus"></i>{{{ data.add_row_title }}}</button>
                  <# if ( data.allow_columns ) {#>
                     <button class="dh-add-column"><i class="fas fa-plus"></i>{{{ data.add_column_title }}}</button>
                  <# } else { #>
                     <style>.dh-col-control { display: none !important; }</style>
                  <# } #>

                  <br>&nbsp;
               </div>
            </div>
         </div>
      </script>

   <?php
});
