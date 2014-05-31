<?php

if(function_exists("register_field_group")) {
	register_field_group(array (
		'id' => 'acf_analytics',
		'title' => 'Analytics',
		'fields' => array (
			array (
				'key' => 'field_52efaa1da0c96',
				'label' => 'Analytics Code',
				'name' => 'analytics_code',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_52efaa2ea0c97',
				'label' => 'Analytics SiteURL',
				'name' => 'analytics_siteurl',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'options_page',
					'operator' => '==',
					'value' => 'acf-options-sebwite-thema',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'default',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));
	register_field_group(array (
		'id' => 'acf_google-maps-instellingen',
		'title' => 'Google Maps Instellingen',
		'fields' => array (
			array (
				'key' => 'field_52efae1762307',
				'label' => 'API key',
				'name' => 'maps_api_key',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_52efa83f4528c',
				'label' => 'Latitude',
				'name' => 'maps_latitude',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_52efaab6e45ac',
				'label' => 'Longitude',
				'name' => 'maps_longitude',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_52efaadde45ad',
				'label' => 'Tooltip Inhoud',
				'name' => 'maps_tooltip_inhoud',
				'type' => 'wysiwyg',
				'default_value' => '',
				'toolbar' => 'full',
				'media_upload' => 'no',
			),
			array (
				'key' => 'field_52efb9a2e2fce',
				'label' => 'Marker Titel',
				'name' => 'maps_marker_titel',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'options_page',
					'operator' => '==',
					'value' => 'acf-options-sebwite-thema',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'default',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));
}

?>