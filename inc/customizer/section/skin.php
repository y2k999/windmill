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
	 * 	_filter[customizer][panel_skin]
	 * @reference
	 * 	[Parent]/inc/utility/general.php
	*/
	// if(function_exists('__get_customizer_panel_skin') === FALSE) :
	function __get_customizer_panel_skin()
	{
		$function = __utility_get_function(__FUNCTION__);
		$exploded = explode('_',$function);
		$panel = end($exploded);

		// Priority of the section which informs load order of sections.
		$priority = array(
			'button' => 10,
			'heading' => 20,
			'image' => 30,
			'nav' => 40,
			'sns' => 50,
		);

		/**
		 * @reference (WP)
		 * 	Calls the callback functions that have been added to a filter hook.
		 * 	https://developer.wordpress.org/reference/functions/apply_filters/
		*/
		return apply_filters("_filter[customizer][{$function}]",array(
			array(
				'name' => 'button',
				'title' => esc_html__('Button','windmill'),
				'type' => 'section',
				'panel' => $panel,
				'priority' => $priority['button'],
			),
			array(
				'name' => 'heading',
				'title' => esc_html__('Heading','windmill'),
				'type' => 'section',
				'panel' => $panel,
				'priority' => $priority['heading'],
			),
			array(
				'name' => 'image',
				'title' => esc_html__('Image','windmill'),
				'type' => 'section',
				'panel' => $panel,
				'priority' => $priority['image'],
			),
			array(
				'name' => 'nav',
				'title' => esc_html__('Navigation','windmill'),
				'type' => 'section',
				'panel' => $panel,
				'priority' => $priority['nav'],
			),
			array(
				'name' => 'sns',
				'title' => esc_html__('SNS','windmill'),
				'type' => 'section',
				'panel' => $panel,
				'priority' => $priority['sns'],
			),
		));

	}// Method
	// endif;
