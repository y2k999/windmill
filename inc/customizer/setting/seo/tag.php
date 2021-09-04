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
	 * 	_filter[customizer][seo_tag]
	 * @reference
	 * 	[Parent]/inc/utility/general.php
	 * 	[Parent]/inc/setup/constant.php
	 * 	[Parent]/inc/customizer/default.php
	*/
	// if(function_exists('__get_customizer_seo_tag') === FALSE) :
	function __get_customizer_seo_tag()
	{
		$function = __utility_get_function(__FUNCTION__);
		$exploded = explode('_',$function);
		$section = end($exploded);

		$class = PREFIX['customizer'] . 'default';

		// Order priority to load the control in Customizer.
		$priority = array(
			'tag_site-title' => 10,
			'tag_site-description' => 20,
			'tag_page-title' => 30,
			'tag_post-title' => 40,
			'tag_item-title' => 50,
			'tag_widget-title' => 60,
		);

		/**
		 * @reference (WP)
		 * 	Calls the callback functions that have been added to a filter hook.
		 * 	https://developer.wordpress.org/reference/functions/apply_filters/
		*/
		return apply_filters("_filter[customizer][{$function}]",array(
			array(
				'name' => 'tag_site-title',
				'label' => esc_html__('Site Title','windmill'),
				'control' => 'select',
				'type' => 'control',
				'section' => $section,
				'default' => $class::__get_setting('tag_site-title'),
				'priority' => $priority['tag_site-title'],
			),
			array(
				'name' => 'tag_site-description',
				'label' => esc_html__('Site Description','windmill'),
				'control' => 'select',
				'type' => 'control',
				'section' => $section,
				'default' => $class::__get_setting('tag_site-description'),
				'priority' => $priority['tag_site-description'],
			),
			array(
				'name' => 'tag_page-title',
				'label' => esc_html__('Page Title','windmill'),
				'control' => 'select',
				'type' => 'control',
				'section' => $section,
				'default' => $class::__get_setting('tag_page-title'),
				'priority' => $priority['tag_page-title'],
			),
			array(
				'name' => 'tag_post-title',
				'label' => esc_html__('Post Title (Single)','windmill'),
				'control' => 'select',
				'type' => 'control',
				'section' => $section,
				'default' => $class::__get_setting('tag_post-title'),
				'priority' => $priority['tag_post-title'],
			),
			array(
				'name' => 'tag_item-title',
				'label' => esc_html__('Post Title (Archive)','windmill'),
				'control' => 'select',
				'type' => 'control',
				'section' => $section,
				'default' => $class::__get_setting('tag_item-title'),
				'priority' => $priority['tag_item-title'],
			),
			array(
				'name' => 'tag_widget-title',
				'label' => esc_html__('Widget Title','windmill'),
				'control' => 'select',
				'type' => 'control',
				'section' => $section,
				'default' => $class::__get_setting('tag_widget-title'),
				'priority' => $priority['tag_widget-title'],
			),
		));

	}// Method
	// endif;
