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
	 * 	_filter[customizer][skin_sns]
	 * @reference
	 * 	[Parent]/inc/utility/general.php
	 * 	[Parent]/inc/setup/constant.php
	 * 	[Parent]/inc/customizer/default.php
	*/
	// if(function_exists('__get_customizer_skin_sns') === FALSE) :
	function __get_customizer_skin_sns()
	{
		$function = __utility_get_function(__FUNCTION__);
		$exploded = explode('_',$function);
		$section = end($exploded);

		$class = PREFIX['customizer'] . 'default';

		// Order priority to load the control in Customizer.
		$priority = array(
			'skin_sns_follow' => 10,
			'skin_sns_share' => 20,
		);

		/**
		 * @reference (WP)
		 * 	Calls the callback functions that have been added to a filter hook.
		 * 	https://developer.wordpress.org/reference/functions/apply_filters/
		*/
		return apply_filters("_filter[customizer][{$function}]",array(
			array(
				'name' => 'skin_sns_follow',
				'label' => esc_html__('Follow Button','windmill'),
				'control' => 'select',
				'type' => 'control',
				'section' => $section,
				'default' => $class::__get_setting('skin_sns_follow'),
				'priority' => $priority['skin_sns_follow'],
			),
			array(
				'name' => 'skin_sns_share',
				'label' => esc_html__('Share Button','windmill'),
				'control' => 'select',
				'type' => 'control',
				'section' => $section,
				'default' => $class::__get_setting('skin_sns_share'),
				'priority' => $priority['skin_sns_share'],
			),
		));

	}// Method
	// endif;
