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
	 * 	_filter[customizer][seo_toc]
	 * @reference
	 * 	[Parent]/inc/utility/general.php
	 * 	[Parent]/inc/setup/constant.php
	 * 	[Parent]/inc/customizer/default.php
	*/
	// if(function_exists('__get_customizer_seo_toc') === FALSE) :
	function __get_customizer_seo_toc()
	{
		$function = __utility_get_function(__FUNCTION__);
		$exploded = explode('_',$function);
		$section = end($exploded);

		$class = PREFIX['customizer'] . 'default';

		// Order priority to load the control in Customizer.
		$priority = array(
			'toc_post' => 10,
			'toc_tag' => 20,
			'toc_min' => 30,
		);

		/**
		 * @reference (WP)
		 * 	Calls the callback functions that have been added to a filter hook.
		 * 	https://developer.wordpress.org/reference/functions/apply_filters/
		*/
		return apply_filters("_filter[customizer][{$function}]",array(
			array(
				'name' => 'toc_post',
				'label' => esc_html__('Table of Contents','windmill'),
				'description' => esc_html__('Check here to display TOC on posts.','windmill'),
				'control' => 'checkbox',
				'type' => 'control',
				'section' => $section,
				'default' => $class::__get_setting('toc_post'),
				'priority' => $priority['toc_post'],
			),
			array(
				'name' => 'toc_tag',
				'label' => esc_html__('Shortcode Tag','windmill'),
				'description' => esc_html__('Tag (Literal) to be searched in post.','windmill'),
				'control' => 'text',
				'type' => 'control',
				'section' => $section,
				'default' => $class::__get_setting('toc_tag'),
				'input_attrs' => array(
					'placeholder' => 'toc',
				),
				'priority' => $priority['toc_tag'],
			),
			array(
				'name' => 'toc_min',
				'label' => esc_html__('Minimum Headings Counts','windmill'),
				'description' => esc_html__('TOC will not be displayed if the number of headings of the current post is below this number.','windmill'),
				'control' => 'number',
				'type' => 'control',
				'section' => $section,
				'default' => $class::__get_setting('toc_min'),
				'priority' => $priority['toc_min'],
			),
		));

	}// Method
	// endif;
