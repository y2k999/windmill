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
	 * 	_filter[customizer][skin_image]
	 * @reference
	 * 	[Parent]/inc/utility/general.php
	 * 	[Parent]/inc/setup/constant.php
	 * 	[Parent]/inc/customizer/default.php
	*/
	// if(function_exists('__get_customizer_skin_image') === FALSE) :
	function __get_customizer_skin_image()
	{
		$function = __utility_get_function(__FUNCTION__);
		$exploded = explode('_',$function);
		$section = end($exploded);

		$class = PREFIX['customizer'] . 'default';

		// Order priority to load the control in Customizer.
		$priority = array(
			'skin_image_general' => 10,
			'skin_image_list' => 20,
			'skin_image_gallery' => 30,
			'skin_image_card' => 40,
		);

		/**
		 * @reference (WP)
		 * 	Calls the callback functions that have been added to a filter hook.
		 * 	https://developer.wordpress.org/reference/functions/apply_filters/
		*/
		return apply_filters("_filter[customizer][{$function}]",array(
			array(
				'name' => 'skin_image_general',
				'label' => esc_html__('General','windmill'),
				'control' => 'select',
				'type' => 'control',
				'section' => $section,
				'default' => $class::__get_setting('skin_image_general'),
				'priority' => $priority['skin_image_general'],
			),
			array(
				'name' => 'skin_image_list',
				'label' => esc_html__('List','windmill'),
				'control' => 'select',
				'type' => 'control',
				'section' => $section,
				'default' => $class::__get_setting('skin_image_list'),
				'priority' => $priority['skin_image_list'],
			),
			array(
				'name' => 'skin_image_gallery',
				'label' => esc_html__('Gallery','windmill'),
				'control' => 'select',
				'type' => 'control',
				'section' => $section,
				'default' => $class::__get_setting('skin_image_gallery'),
				'priority' => $priority['skin_image_gallery'],
			),
			array(
				'name' => 'skin_image_card',
				'label' => esc_html__('Card','windmill'),
				'control' => 'select',
				'type' => 'control',
				'section' => $section,
				'default' => $class::__get_setting('skin_image_card'),
				'priority' => $priority['skin_image_card'],
			),
		));

	}// Method
	// endif;
