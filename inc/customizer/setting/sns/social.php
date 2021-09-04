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
 * 
 * Inspired by WeCodeArt WordPress Theme
 * @link https://www.wecodeart.com/
 * @author Bican Marian Valeriu
 * 
 * Inspired by f(x) Share WordPress Plugin
 * @link http://genbu.me/plugins/fx-share/
 * @author David Chandra Purnama
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
	 * 	_filter[customizer][sns_social]
	 * @reference
	 * 	[Parent]/inc/utility/general.php
	 * 	[Parent]/inc/setup/constant.php
	 * 	[Parent]/inc/customizer/default.php
	*/
	// if(function_exists('__get_customizer_sns_social') === FALSE) :
	function __get_customizer_sns_social()
	{
		$function = __utility_get_function(__FUNCTION__);
		$exploded = explode('_',$function);
		$section = end($exploded);

		$class = PREFIX['customizer'] . 'default';

		// Order priority to load the control in Customizer.
		$priority = array(
			'social_share' => 10,
			'social_follow' => 20,
		);

		/**
		 * @reference (WP)
		 * 	Calls the callback functions that have been added to a filter hook.
		 * 	https://developer.wordpress.org/reference/functions/apply_filters/
		*/
		return apply_filters("_filter[customizer][{$function}]",array(
			array(
				'name' => 'social_share',
				'label' => esc_html__('Share Button','windmill'),
				'description' => esc_html__('Enable and Reorder SNS Share Buttons.','windmill'),
				'control' => 'sortable',
				'type' => 'control',
				'section' => $section,
				'default' => $class::__get_setting('social_share'),
				'priority' => $priority['social_share'],
			),
			array(
				'name' => 'social_follow',
				'label' => esc_html__('Follow Button','windmill'),
				'description' => esc_html__('Enable and Reorder SNS Follow Buttons.','windmill'),
				'control' => 'sortable',
				'type' => 'control',
				'section' => $section,
				'default' => $class::__get_setting('social_follow'),
				'priority' => $priority['social_follow'],
			),
		));

	}// Method
	// endif;
