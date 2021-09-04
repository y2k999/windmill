<?php
/**
 * Functions and definitions.
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
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
 * [NOTE]
 * 	This theme requires the Beans Extension plugin.
 * 	https://github.com/y2k999/beans-extension
 * 
 * It is recommended to configure the plugin in the "Uikit Version" section of the first tab ("Preview" panel).
 * 	1. For the "Range of Uikit2 components to use" setting, select "Load only normalize.css" option.
 * 	2. For the "Use Uikit3 via CDN" setting, check the checkbox.
 * 	3. Submit the save button.
*/


	/**
	 * @since 1.0.1
	 * 	Initialize Beans theme framework.
	 * @reference (Beans)
	 * 	https://www.getbeans.io
	 * @reference (WP)
	 * 	Retrieves template directory path for current theme.
	 * 	https://developer.wordpress.org/reference/functions/get_template_directory/
	*/
	require_once (trailingslashit(get_template_directory()) . 'inc/init.php');


	/**
	 * @since 1.0.1
	 * 	Auto logout time (60 * 60 * 24 * 60 = 60 days).
	 * 	https://techmemo.biz/wordpress/auto-logout-time-change/
	 * @reference (WP)
	 * 	Filters the duration of the authentication cookie expiration period.
	 * 	https://developer.wordpress.org/reference/hooks/auth_cookie_expiration/
	*/
	add_action('auth_cookie_expiration',function()
	{
		return 2592000;
	});


	/**
	 * @since 1.0.1
	 * 	Fix https error on class-wp-image-editor-imagick.php.
	 * 	https://natural.arthhuman.com/upload-error/
	 * @reference (WP)
	 * 	Filters the list of image editing library classes.
	 * 	https://developer.wordpress.org/reference/hooks/wp_image_editors/
	*/
	add_filter('wp_image_editors',function($array)
	{
		/**
		 * @reference (WP)
		 * 	WordPress Image Editor Class for Image Manipulation through GD
		 * 	https://developer.wordpress.org/reference/classes/wp_image_editor_gd/
		 * 	WordPress Image Editor Class for Image Manipulation through Imagick PHP Module
		 * 	https://developer.wordpress.org/reference/classes/wp_image_editor_imagick/
		*/
		return array(
			'WP_Image_Editor_GD',
			'WP_Image_Editor_Imagick'
		);

	});
