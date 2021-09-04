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
	 * 	_filter[customizer][template_singular]
	 * @reference
	 * 	[Parent]/inc/utility/general.php
	 * 	[Parent]/inc/setup/constant.php
	 * 	[Parent]/inc/customizer/default.php
	*/
	// if(function_exists('__get_customizer_template_singular') === FALSE) :
	function __get_customizer_template_singular()
	{
		$function = __utility_get_function(__FUNCTION__);
		$exploded = explode('_',$function);
		$section = end($exploded);

		$class = PREFIX['customizer'] . 'default';

		// Order priority to load the control in Customizer.
		$priority = array(
			'blogcard_post' => 10,
			'blogcard_type' => 20,
			'blogcard_tag' => 30,
			'page_html-sitemap' => 40,
		);

		/**
		 * @reference (WP)
		 * 	Calls the callback functions that have been added to a filter hook.
		 * 	https://developer.wordpress.org/reference/functions/apply_filters/
		*/
		return apply_filters("_filter[customizer][{$function}]",array(
			array(
				'name' => 'blogcard_post',
				'label' => esc_html__('Blogcard','windmill'),
				'description' => esc_html__('Check here to activate blogcard shortcode on posts.','windmill'),
				'control' => 'checkbox',
				'type' => 'control',
				'section' => $section,
				'default' => $class::__get_setting('blogcard_post'),
				'priority' => $priority['blogcard_post'],
			),
			array(
				'name' => 'blogcard_type',
				'label' => esc_html__('Type','windmill'),
				'description' => 'Hatena service or OpenGraph library.',
				'control' => 'select',
				'type' => 'control',
				'section' => $section,
				'default' => $class::__get_setting('blogcard_type'),
				'priority' => $priority['blogcard_type'],
			),
			array(
				'name' => 'blogcard_tag',
				'label' => esc_html__('Shortcode','windmill'),
				'control' => 'text',
				'type' => 'control',
				'section' => $section,
				'default' => $class::__get_setting('blogcard_tag'),
				'input_attrs' => array(
					'placeholder' => 'blogcard',
				),
				'priority' => $priority['blogcard_tag'],
			),
			array(
				'name' => 'page_html-sitemap',
				'label' => esc_html__('HTML Sitemap Page','windmill'),
				'description' => esc_html__('Select page to display html sitemap.','windmill'),
				'control' => 'dropdown-pages',
				'type' => 'control',
				'section' => $section,
				'default' => $class::__get_setting('page_html-sitemap'),
				'priority' => $priority['page_html-sitemap'],
			),
		));

	}// Method
	// endif;
