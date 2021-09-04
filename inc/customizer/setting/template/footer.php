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
	 * 	_filter[customizer][template_footer]
	 * @reference
	 * 	[Parent]/inc/utility/general.php
	 * 	[Parent]/inc/setup/constant.php
	 * 	[Parent]/inc/customizer/default.php
	*/
	// if(function_exists('__get_customizer_template_footer') === FALSE) :
	function __get_customizer_template_footer()
	{
		$function = __utility_get_function(__FUNCTION__);
		$exploded = explode('_',$function);
		$section = end($exploded);

		$class = PREFIX['customizer'] . 'default';

		// Order priority to load the control in Customizer.
		$priority = array(
			'back2top' => 10,
			'breadcrumb' => 20,
			'credit' => 30,
		);

		/**
		 * @reference (WP)
		 * 	Calls the callback functions that have been added to a filter hook.
		 * 	https://developer.wordpress.org/reference/functions/apply_filters/
		*/
		return apply_filters("_filter[customizer][{$function}]",array(
/*
			array(
				'name' => 'fixed_footer',
				'label' => esc_html__('Static(Fixed) Footer','windmill'),
				'description' => esc_html__('Check here to activate Sticky footer.','windmill'),
				'control' => 'checkbox',
				'type' => 'control',
				'section' => $section,
				'default' => $class::__get_setting('fixed_footer'),
				'priority' => $priority['fixed_footer'],
			),
*/
			array(
				'name' => 'back2top',
				'label' => esc_html__('Back to Top Button','windmill'),
				'description' => esc_html__('Check here to display "Back to Top" Button.','windmill'),
				'control' => 'checkbox',
				'type' => 'control',
				'section' => $section,
				'default' => $class::__get_setting('back2top'),
				'priority' => $priority['back2top'],
			),
			array(
				'name' => 'breadcrumb',
				'label' => esc_html__('Breadcrumb','windmill'),
				'description' => esc_html__('Check here to display Breadcrumb Navigation.','windmill'),
				'control' => 'checkbox',
				'type' => 'control',
				'section' => $section,
				'default' => $class::__get_setting('breadcrumb'),
				'priority' => $priority['breadcrumb'],
			),
			array(
				'name' => 'credit',
				'label' => esc_html__('Blog info at the Bottom of Page','windmill'),
				'control' => 'text',
				'type' => 'control',
				'section' => $section,
				'default' => $class::__get_setting('credit'),
				'priority' => $priority['credit'],
			),
		));

	}// Method
	// endif;
