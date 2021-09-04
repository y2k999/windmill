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
	 * 	_filter[customizer][skin_heading]
	 * @reference
	 * 	[Parent]/inc/utility/general.php
	 * 	[Parent]/inc/setup/constant.php
	 * 	[Parent]/inc/customizer/default.php
	*/
	// if(function_exists('__get_customizer_skin_heading') === FALSE) :
	function __get_customizer_skin_heading()
	{
		$function = __utility_get_function(__FUNCTION__);
		$exploded = explode('_',$function);
		$section = end($exploded);

		$class = PREFIX['customizer'] . 'default';

		// Order priority to load the control in Customizer.
		$priority = array(
			'skin_heading_site-title' => 10,
			'skin_heading_site-description' => 20,
			'skin_heading_page-title' => 30,
			'skin_heading_post-title' => 40,
			'skin_heading_list-title' => 50,
			'skin_heading_widget-title' => 60,
		);

		/**
		 * @reference (WP)
		 * 	Calls the callback functions that have been added to a filter hook.
		 * 	https://developer.wordpress.org/reference/functions/apply_filters/
		*/
		return apply_filters("_filter[customizer][{$function}]",array(
			array(
				'name' => 'skin_heading_site-title',
				'label' => esc_html__('Site Title','windmill'),
				'control' => 'select',
				'type' => 'control',
				'section' => $section,
				'default' => $class::__get_setting('skin_heading_site-title'),
				'priority' => $priority['skin_heading_site-title'],
			),
			array(
				'name' => 'skin_heading_site-description',
				'label' => esc_html__('Site Description','windmill'),
				'control' => 'select',
				'type' => 'control',
				'section' => $section,
				'default' => $class::__get_setting('skin_heading_site-description'),
				'priority' => $priority['skin_heading_site-description'],
			),
			array(
				'name' => 'skin_heading_page-title',
				'label' => esc_html__('Page Title','windmill'),
				'control' => 'select',
				'type' => 'control',
				'section' => $section,
				'default' => $class::__get_setting('skin_heading_page-title'),
				'priority' => $priority['skin_heading_page-title'],
			),
			array(
				'name' => 'skin_heading_post-title',
				'label' => esc_html__('Post Title','windmill'),
				'control' => 'select',
				'type' => 'control',
				'section' => $section,
				'default' => $class::__get_setting('skin_heading_post-title'),
				'priority' => $priority['skin_heading_post-title'],
			),
			array(
				'name' => 'skin_heading_list-title',
				'label' => esc_html__('Archive List Title','windmill'),
				'control' => 'select',
				'type' => 'control',
				'section' => $section,
				'default' => $class::__get_setting('skin_heading_list-title'),
				'priority' => $priority['skin_heading_list-title'],
			),
			array(
				'name' => 'skin_heading_widget-title',
				'label' => esc_html__('Widget Title','windmill'),
				'control' => 'select',
				'type' => 'control',
				'section' => $section,
				'default' => $class::__get_setting('skin_heading_widget-title'),
				'priority' => $priority['skin_heading_widget-title'],
			),
		));

	}// Method
	// endif;
