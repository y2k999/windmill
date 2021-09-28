<?php
/**
 * Setup theme customizer.
 * @package Windmill
 * @license GPL3.0+
 * @since 1.0.1
*/

/**
 * Inspired by Beans Framework WordPress Theme
 * @link https://www.getbeans.io
 * @author Thierry Muller
*/


/* Prepare
______________________________
*/

// If this file is called directly,abort.
if(!defined('WPINC')){die;}

// Set identifiers for this template.
// $index = basename(__FILE__,'.php');


/* Exec
______________________________
*/

	/**
	 * @access (public)
	 * 	Return theme customizer setting/control parameters.
	 * 	https://developer.wordpress.org/reference/classes/wp_customize_control/
	 * @return (array)
	 * 	_filter[customizer][seo_ga]
	 * @reference
	 * 	[Parent]/inc/utility/general.php
	 * 	[Parent]/inc/setup/constant.php
	 * 	[Parent]/inc/customizer/default.php
	*/
	// if(function_exists('__get_customizer_seo_ga') === FALSE) :
	function __get_customizer_seo_ga()
	{
		$function = __utility_get_function(__FUNCTION__);
		$exploded = explode('_',$function);
		$section = end($exploded);

		$class = PREFIX['customizer'] . 'default';

		// Order priority to load the control in Customizer.
		$priority = array(
			'ga_use' => 10,
			'ga_tracking-id' => 20,
			'ga_tracking-type' => 30,
			'ga_exclude-login' => 40,
		);

		/**
		 * @reference (WP)
		 * 	Calls the callback functions that have been added to a filter hook.
		 * 	https://developer.wordpress.org/reference/functions/apply_filters/
		*/
		return apply_filters("_filter[customizer][{$function}]",array(
			array(
				'name' => 'ga_use',
				'label' => esc_html__('Use Google Analytic','windmill'),
				'control' => 'checkbox',
				'type' => 'control',
				'section' => $section,
				'default' => $class::__get_setting('ga_use'),
				'priority' => $priority['ga_use'],
			),
			array(
				'name' => 'ga_tracking-id',
				'label' => esc_html('Tracking ID'),
				'description' => 'G-ID or UA-ID',
				'control' => 'text',
				'type' => 'control',
				'section' => $section,
				'default' => $class::__get_setting('ga_tracking-id'),
				'input_attrs' => array(
					'placeholder' => 'G-0000000000',
				),
				'priority' => $priority['ga_tracking-id'],
			),
			array(
				'name' => 'ga_tracking-type',
				'label' => esc_html('Tracking Code Type'),
				'description' => 'If you use GA4, select gtag.js.',
				'control' => 'select',
				'type' => 'control',
				'section' => $section,
				'default' => $class::__get_setting('ga_tracking-type'),
				'priority' => $priority['ga_tracking-type'],
			),
			array(
				'name' => 'ga_exclude-login',
				'label' => esc_html__('Exclude Logged-in-Users','windmill'),
				'control' => 'checkbox',
				'type' => 'control',
				'section' => $section,
				'default' => $class::__get_setting('ga_exclude-login'),
				'priority' => $priority['ga_exclude-login'],
			),
		));

	}// Method
	// endif;
