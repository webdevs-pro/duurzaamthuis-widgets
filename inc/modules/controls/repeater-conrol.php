<?php

class DH_Repeater_Control extends \Elementor\Base_Data_Control {

	public function get_type() {
		return 'dh-repeater-conrol';
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

               <div class="elementor-button-wrapper">
                  <button class="elementor-button elementor-button-default dh-control-popup-open" type="button">{{{ data.buton_title }}}</button>
               </div>

               <div class="dh-control-popup-wrapper">
                  <div class="dh-control-popup">
                     <div class="dh-control-popup-header">
                        <div class="dh-control-popup-title">{{{ data.buton_title }}}</div>
                        <div class="dh-control-popup-close">
                           <i aria-hidden="true" class="far fa-times-circle"></i>
                        </div>
                     </div>
                     <div class="dh-control-popup-content">
                        <?php $table_id = str_replace( 'elementor-control-default-', '', $control_uid ); ?>
                        <table class="dh-table-<?php echo $table_id; ?>" data-table-id="<?php echo $table_id; ?>"></table>
                        <button class="dh-add-row"><i class="fas fa-plus"></i>Add row</button>
                        <button class="dh-add-column"><i class="fas fa-plus"></i>Add column</button>
                        <br>&nbsp;
                     </div>
                  </div>
               </div>


            </div>



         </div>
         <# if ( data.description ) { #>
            <div class="elementor-control-field-description">{{{ data.description }}}</div>
         <# } #>
		<?php
	}

   

}




