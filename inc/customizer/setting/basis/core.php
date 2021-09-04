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
	 * 	_filter[customizer][basis_core]
	 * @reference
	 * 	[Parent]/inc/utility/general.php
	 * 	[Parent]/inc/setup/constant.php
	 * 	[Parent]/inc/customizer/default.php
	*/
	// if(function_exists('__get_customizer_basis_core') === FALSE) :
	function __get_customizer_basis_core()
	{
		$function = __utility_get_function(__FUNCTION__);
		$exploded = explode('_',$function);
		$section = end($exploded);

		$class = PREFIX['customizer'] . 'default';

		// Order priority to load the control in Customizer.
		$priority = array(
			'jquery' => 10,
			'async' => 20,
			'js2footer' => 30,
		);

		/**
		 * @reference (WP)
		 * 	Calls the callback functions that have been added to a filter hook.
		 * 	https://developer.wordpress.org/reference/functions/apply_filters/
		*/
		return apply_filters("_filter[customizer][{$function}]",array(
			array(
				'name' => 'jquery',
				'label' => esc_html__('jQuery Version','windmill'),
				'description' => esc_html__('Use jQuery core via CDN.','windmill'),
				'control' => 'checkbox',
				'type' => 'control',
				'section' => $section,
				'default' => $class::__get_setting('jquery'),
				'priority' => $priority['jquery'],
			),
			array(
				'name' => 'async',
				'label' => esc_html__('Async and Defer','windmill'),
				'description' => esc_html__('Load scripts asyncronously.','windmill'),
				'control' => 'checkbox',
				'type' => 'control',
				'section' => $section,
				'default' => $class::__get_setting('async'),
				'priority' => $priority['async'],
			),
			array(
				'name' => 'js2footer',
				'label' => esc_html__('Load Scripts in Footer','windmill'),
				'description' => esc_html__('Move scripts to footer and improve page load times.','windmill'),
				'control' => 'checkbox',
				'type' => 'control',
				'section' => $section,
				'default' => $class::__get_setting('js2footer'),
				'priority' => $priority['js2footer'],
			),
		));

	}// Method
	// endif;
