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
	 * 	Return theme customizer section parameters.
	 * 	https://developer.wordpress.org/reference/classes/wp_customize_section/
	 * @return (array)
	 * 	_filter[customizer][panel_sns]
	 * @reference
	 * 	[Parent]/inc/utility/general.php
	*/
	// if(function_exists('__get_customizer_panel_sns') === FALSE) :
	function __get_customizer_panel_sns()
	{
		$function = __utility_get_function(__FUNCTION__);
		$exploded = explode('_',$function);
		$panel = end($exploded);

		// Priority of the section which informs load order of sections.
		$priority = array(
			'social' => 10,
			'url' => 20,
		);

		/**
		 * @reference (WP)
		 * 	Calls the callback functions that have been added to a filter hook.
		 * 	https://developer.wordpress.org/reference/functions/apply_filters/
		*/
		return apply_filters("_filter[customizer][{$function}]",array(
			array(
				'name' => 'social',
				'title' => esc_html__('Settings','windmill'),
				'type' => 'section',
				'panel' => $panel,
				'priority' => $priority['social'],
			),
			array(
				'name' => 'url',
				'title' => esc_html('URL'),
				'type' => 'section',
				'panel' => $panel,
				'priority' => $priority['url'],
			),
		));

	}// Method
	// endif;
