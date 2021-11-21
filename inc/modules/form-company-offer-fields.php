<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class DH_Companies_Offer_Emails_Field extends ElementorPro\Modules\Forms\Fields\Field_Base {

	public function get_type() {
		return 'dh-companies-offer-emails';
	}

	public function get_name() {
		return 'Companies offer emails';
	}

	public function update_controls( $widget ) {
		$widgetor = ElementorPro\Plugin::elementor();

		$control_data = $widgetor->controls_manager->get_control_from_stack( $widget->get_unique_name(), 'form_fields' );

		if (is_wp_error($control_data)) {
			 return;
		}


		$control_data['fields']['dh_min_companies_offer_emails'] = [
			'name' => 'dh_min_companies_offer_emails',
			'label' => 'Minimum Emails',
			'type' => Elementor\Controls_Manager::NUMBER,
			'condition' => [
				'field_type' => $this->get_type(),
			],
			'default' => 1,
			'min' => 0,
			'max' => 6,
			"tabs_wrapper" => "form_fields_tabs",
			"inner_tab" => "form_fields_content_tab",
			"tab" => "content",
		];

		$control_data['fields']['required']['conditions']['terms'][0]['value'][] = $this->get_type();
		$control_data['fields']['width']['conditions']['terms'][0]['value'][] = $this->get_type();
		$widget->update_control( 'form_fields', $control_data );
	}

	public function render( $item, $item_index, $form ) {
		$form->add_render_attribute( 'input' . $item_index, 'class', 'hidden' );

		?>
			<input <?php $form->print_render_attribute_string( 'input' . $item_index ); ?> >
		<?php
	}

}

class DH_Companies_Offer_Titles_Field extends ElementorPro\Modules\Forms\Fields\Field_Base {

	public function get_type() {
		return 'dh-companies-offer-titles';
	}

	public function get_name() {
		return 'Companies offer names';
	}

	public function update_controls($widget) {
		$widgetor = ElementorPro\Plugin::elementor();

		$control_data = $widgetor->controls_manager->get_control_from_stack( $widget->get_unique_name(), 'form_fields' );

		if (is_wp_error($control_data)) {
			 return;
		}

		$control_data['fields']['required']['conditions']['terms'][0]['value'][] = $this->get_type();
		$control_data['fields']['width']['conditions']['terms'][0]['value'][] = $this->get_type();
		$widget->update_control( 'form_fields', $control_data );
	}

	public function render( $item, $item_index, $form ) {
		$form->add_render_attribute( 'input' . $item_index, 'class', 'hidden' );

		?>
			<input <?php $form->print_render_attribute_string( 'input' . $item_index ); ?> >
			<div class="dh-selected-companies-badges"></div>
		<?php
	}

}