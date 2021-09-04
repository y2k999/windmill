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
	 * 	_filter[customizer][sns_url]
	 * @reference
	 * 	[Parent]/inc/utility/general.php
	 * 	[Parent]/inc/setup/constant.php
	 * 	[Parent]/inc/customizer/default.php
	*/
	// if(function_exists('__get_customizer_sns_url') === FALSE) :
	function __get_customizer_sns_url()
	{
		$function = __utility_get_function(__FUNCTION__);
		$exploded = explode('_',$function);
		$section = end($exploded);

		$class = PREFIX['customizer'] . 'default';

		// Order priority to load the control in Customizer.
		$priority = array(
			'url_twitter' => 10,
			'url_facebook' => 20,
			'url_instagram' => 30,
			'url_github' => 40,
			'url_youtube' => 50,
		);

		/**
		 * @reference (WP)
		 * 	Calls the callback functions that have been added to a filter hook.
		 * 	https://developer.wordpress.org/reference/functions/apply_filters/
		*/
		return apply_filters("_filter[customizer][{$function}]",array(
			array(
				'name' => 'url_twitter',
				'label' => esc_html('Twitter'),
				'control' => 'text',
				'type' => 'control',
				'section' => $section,
				'default' => $class::__get_setting('url_twitter'),
				'priority' => $priority['url_twitter'],
			),
			array(
				'name' => 'url_facebook',
				'label' => esc_html('Facebook'),
				'control' => 'text',
				'type' => 'control',
				'section' => $section,
				'default' => $class::__get_setting('url_facebook'),
				'priority' => $priority['url_facebook'],
			),
			array(
				'name' => 'url_instagram',
				'label' => esc_html('Instagram'),
				'control' => 'text',
				'type' => 'control',
				'section' => $section,
				'default' => $class::__get_setting('url_instagram'),
				'priority' => $priority['url_instagram'],
			),
			array(
				'name' => 'url_github',
				'label' => esc_html('Github'),
				'control' => 'text',
				'type' => 'control',
				'section' => $section,
				'default' => $class::__get_setting('url_github'),
				'priority' => $priority['url_github'],
			),
			array(
				'name' => 'url_youtube',
				'label' => esc_html('YouTube'),
				'control' => 'text',
				'type' => 'control',
				'section' => $section,
				'default' => $class::__get_setting('url_youtube'),
				'priority' => $priority['url_youtube'],
			),
		));

	}// Method
	// endif;
