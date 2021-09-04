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
	 * 	_filter[customizer][seo_meta]
	 * @reference
	 * 	[Parent]/inc/utility/general.php
	 * 	[Parent]/inc/setup/constant.php
	 * 	[Parent]/inc/customizer/default.php
	*/
	// if(function_exists('__get_customizer_seo_meta') === FALSE) :
	function __get_customizer_seo_meta()
	{
		$function = __utility_get_function(__FUNCTION__);
		$exploded = explode('_',$function);
		$section = end($exploded);

		$class = PREFIX['customizer'] . 'default';

		// Order priority to load the control in Customizer.
		$priority = array(
			'meta_post' => 10,
			'meta_archive' => 20,
			'meta_figcaption' => 30,
		);

		/**
		 * @reference (WP)
		 * 	Calls the callback functions that have been added to a filter hook.
		 * 	https://developer.wordpress.org/reference/functions/apply_filters/
		*/
		return apply_filters("_filter[customizer][{$function}]",array(
			array(
				'name' => 'meta_post',
				'label' => esc_html__('Post Meta','windmill'),
				'description' => esc_html__('Prints meta on single posts.','windmill'),
				'control' => 'sortable',
				'type' => 'control',
				'section' => $section,
				'default' => $class::__get_setting('meta_post'),
				'priority' => $priority['meta_post'],
			),
			array(
				'name' => 'meta_archive',
				'label' => esc_html__('Archive Meta','windmill'),
				'description' => esc_html__('Prints meta on archive posts.','windmill'),
				'control' => 'sortable',
				'type' => 'control',
				'section' => $section,
				'default' => $class::__get_setting('meta_archive'),
				'priority' => $priority['meta_archive'],
			),
			array(
				'name' => 'meta_figcaption',
				'label' => esc_html__('Image Caption Meta','windmill'),
				'description' => esc_html__('Prints meta on image caption.','windmill'),
				'control' => 'select',
				'type' => 'control',
				'section' => $section,
				'default' => $class::__get_setting('meta_figcaption'),
				'priority' => $priority['meta_figcaption'],
			),
		));

	}// Method
	// endif;
