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
	 * 	_filter[customizer][panel_template]
	 * @reference
	 * 	[Parent]/inc/utility/general.php
	*/
	// if(function_exists('__get_customizer_panel_template') === FALSE) :
	function __get_customizer_panel_template()
	{
		$function = __utility_get_function(__FUNCTION__);
		$exploded = explode('_',$function);
		$panel = end($exploded);

		// Priority of the section which informs load order of sections.
		$priority = array(
			'header' => 10,
			'content' => 20,
			'archive' => 30,
			'singular' => 40,
			'404' => 50,
			'sidebar' => 60,
			'footer' => 70,
		);

		/**
		 * @reference (WP)
		 * 	Calls the callback functions that have been added to a filter hook.
		 * 	https://developer.wordpress.org/reference/functions/apply_filters/
		*/
		return apply_filters("_filter[customizer][{$function}]",array(
			array(
				'name' => 'header',
				'title' => esc_html__('Header','windmill'),
				'type' => 'section',
				'panel' => $panel,
				'priority' => $priority['header'],
			),
			array(
				'name' => 'content',
				'title' => esc_html__('Content (Common)','windmill'),
				'type' => 'section',
				'panel' => $panel,
				'priority' => $priority['content'],
			),
			array(
				'name' => 'archive',
				'title' => esc_html__('Archive','windmill'),
				'type' => 'section',
				'panel' => $panel,
				'priority' => $priority['archive'],
			),
			array(
				'name' => 'singular',
				'title' => esc_html__('Single Posts/Pages','windmill'),
				'type' => 'section',
				'panel' => $panel,
				'priority' => $priority['singular'],
			),
			array(
				'name' => '404',
				'title' => esc_html__('404 Page','windmill'),
				'type' => 'section',
				'panel' => $panel,
				'priority' => $priority['404'],
			),
			array(
				'name' => 'sidebar',
				'title' => esc_html__('Sidebar','windmill'),
				'type' => 'section',
				'panel' => $panel,
				'priority' => $priority['sidebar'],
			),
			array(
				'name' => 'footer',
				'title' => esc_html__('Footer','windmill'),
				'type' => 'section',
				'panel' => $panel,
				'priority' => $priority['footer'],
			),
		));

	}// Method
	// endif;
