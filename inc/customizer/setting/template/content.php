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
	 * 	_filter[customizer][template_content]
	 * @reference
	 * 	[Parent]/inc/utility/general.php
	 * 	[Parent]/inc/setup/constant.php
	 * 	[Parent]/inc/customizer/default.php
	*/
	// if(function_exists('__get_customizer_template_content') === FALSE) :
	function __get_customizer_template_content()
	{
		$function = __utility_get_function(__FUNCTION__);
		$exploded = explode('_',$function);
		$section = end($exploded);

		$class = PREFIX['customizer'] . 'default';

		// Order priority to load the control in Customizer.
		$priority = array(
			'media_profile' => 10,
			'media_nopost' => 20,
			'message_nopost' => 30,
		);

		/**
		 * @reference (WP)
		 * 	Calls the callback functions that have been added to a filter hook.
		 * 	https://developer.wordpress.org/reference/functions/apply_filters/
		*/
		return apply_filters("_filter[customizer][{$function}]",array(
			array(
				'name' => 'media_profile',
				'label' => esc_html__('Upload Image File','windmill'),
				'control' => 'image',
				'type' => 'control',
				'section' => $section,
				'default' => $class::__get_setting('media_profile'),
				'priority' => $priority['media_profile'],
			),
			array(
				'name' => 'media_nopost',
				'label' => esc_html__('Upload Image File','windmill'),
				'control' => 'image',
				'type' => 'control',
				'section' => $section,
				'default' => $class::__get_setting('media_nopost'),
				'priority' => $priority['media_nopost'],
			),
			array(
				'name' => 'message_nopost',
				'label' => esc_html__('Not Found Message','windmill'),
				'control' => 'text',
				'type' => 'control',
				'section' => $section,
				'default' => $class::__get_setting('message_nopost'),
				'priority' => $priority['message_nopost'],
			),
		));

	}// Method
	// endif;
