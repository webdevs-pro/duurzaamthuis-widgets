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

            </div>
            <div class="elementor-button-wrapper">
                  <button class="elementor-button elementor-button-default run-sortable" type="button">{{{ data.button_title }}}</button>
            </div>


         </div>

         <# if ( data.description ) { #>
            <div class="elementor-control-field-description">{{{ data.description }}}</div>
         <# } #>
		<?php
	}

   

}




