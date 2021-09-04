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
	 * 	_filter[customizer][skin_button]
	 * @reference
	 * 	[Parent]/inc/utility/general.php
	 * 	[Parent]/inc/setup/constant.php
	 * 	[Parent]/inc/customizer/default.php
	*/
	// if(function_exists('__get_customizer_skin_button') === FALSE) :
	function __get_customizer_skin_button()
	{
		$function = __utility_get_function(__FUNCTION__);
		$exploded = explode('_',$function);
		$section = end($exploded);

		$class = PREFIX['customizer'] . 'default';

		// Order priority to load the control in Customizer.
		$priority = array(
			'skin_button_primary' => 10,
			'skin_button_secondary' => 20,
			'skin_button_tertiary' => 30,
		);

		/**
		 * @reference (WP)
		 * 	Calls the callback functions that have been added to a filter hook.
		 * 	https://developer.wordpress.org/reference/functions/apply_filters/
		*/
		return apply_filters("_filter[customizer][{$function}]",array(
			array(
				'name' => 'skin_button_primary',
				'label' => esc_html__('Primary','windmill'),
				'control' => 'select',
				'type' => 'control',
				'section' => $section,
				'default' => $class::__get_setting('skin_button_primary'),
				'priority' => $priority['skin_button_primary'],
			),
			array(
				'name' => 'skin_button_secondary',
				'label' => esc_html__('Secondary','windmill'),
				'control' => 'select',
				'type' => 'control',
				'section' => $section,
				'default' => $class::__get_setting('skin_button_secondary'),
				'priority' => $priority['skin_button_secondary'],
			),
			array(
				'name' => 'skin_button_tertiary',
				'label' => esc_html__('Tertiary','windmill'),
				'control' => 'select',
				'type' => 'control',
				'section' => $section,
				'default' => $class::__get_setting('skin_button_tertiary'),
				'priority' => $priority['skin_button_tertiary'],
			),
		));

	}// Method
	// endif;
