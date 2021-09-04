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
	// if(function_exists('__get_customizer_template_archive') === FALSE) :
	function __get_customizer_template_archive()
	{
		$function = __utility_get_function(__FUNCTION__);
		$exploded = explode('_',$function);
		$section = end($exploded);

		$class = PREFIX['customizer'] . 'default';

		// Order priority to load the control in Customizer.
		$priority = array(
			'excerpt_more' => 10,
			'excerpt_length' => 20,
		);

		/**
		 * @reference (WP)
		 * 	Calls the callback functions that have been added to a filter hook.
		 * 	https://developer.wordpress.org/reference/functions/apply_filters/
		*/
		return apply_filters("_filter[customizer][{$function}]",array(
			array(
				'name' => 'excerpt_more',
				'label' => esc_html__('Readmore Text','windmill'),
				'description' => esc_html__('String in the "more" link displayed after a trimmed excerpt.','windmill'),
				'control' => 'text',
				'type' => 'control',
				'section' => $section,
				'default' => $class::__get_setting('excerpt_more'),
				'priority' => $priority['excerpt_more'],
			),
			array(
				'name' => 'excerpt_length',
				'label' => esc_html__('Excerpt Length','windmill'),
				'description' => esc_html__('Maximum number of words in a post excerpt.','windmill'),
				'control' => 'number',
				'type' => 'control',
				'section' => $section,
				'default' => $class::__get_setting('excerpt_length'),
				'priority' => $priority['excerpt_length'],
			),
		));

	}// Method
	// endif;
