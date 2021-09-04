<?php
/**
 * Helper and utility functions.
 * @package Windmill
 * @license GPL3.0+
 * @since 1.0.1
*/

/**
 * Inspired by Magazine Plus WordPress Theme
 * @link https://wenthemes.com/item/wordpress-themes/magazine-plus/
 * @author WEN Themes
 * 
 * Inspired by NovelLite WordPress Theme
 * @link http://www.themehunk.com/product/novellite-one-page-wordpress-theme/
 * @author ThemeHunk Team
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
 * [TOC]
 * 	__utility_sanitize_text()
 * 	__utility_sanitize_textarea()
 * 	__utility_sanitize_textarea_html()
 * 	__utility_sanitize_color_hex()
 * 	__utility_sanitize_color_alpha()
 * 	__utility_sanitize_upload()
 * 	__utility_sanitize_integer()
 * 	__utility_sanitize_checkbox()
 * 	__utility_sanitize_email()
 * 	__utility_sanitize_url()
 * 	__utility_sanitize_path()
 * 	__utility_sanitize_sortable()
 * 	__utility_sanitize_select()
 * 	__utility_sanitize_image()
 * 	__utility_sanitize_number()
*/


	/* Method
	_________________________
	*/
	if(function_exists('__utility_sanitize_text') === FALSE) :
	function __utility_sanitize_text($input)
	{
		/**
			@access (public)
				Sanitize text content.
			@param (string) $input
				Content to be sanitized.
			@return (string)
				Sanitized content.
			@reference
				[Parent]/inc/customizer/setup.php
				[Parent]/model/widget/base.php
		*/

		/**
		 * @reference (WP)
		 * 	Sanitizes content for allowed HTML tags for post content.
		 * 	https://developer.wordpress.org/reference/functions/wp_kses_post/
		 * 	Balances tags if forced to, or if the ‘use_balanceTags’ option is set to true.
		 * 	https://developer.wordpress.org/reference/functions/balancetags/
		*/
		return wp_kses_post(balanceTags($input));

	}// Method
	endif;


	/* Method
	_________________________
	*/
	if(function_exists('__utility_sanitize_textarea') === FALSE) :
	function __utility_sanitize_textarea($input)
	{
		/**
			@access (public)
				Sanitize textarea content.
			@global (array) $allowedposttags
				https://codex.wordpress.org/Global_Variables
			@param (string) $input
				Content to be sanitized.
			@return (string)
				Sanitized content.
			@reference
				[Parent]/inc/customizer/setup.php
				[Parent]/model/widget/base.php
		*/

		// WP global.
		global $allowedposttags;

		/**
		 * @reference (WP)
		 * 	Filters text content and strips out disallowed HTML.
		 * 	https://developer.wordpress.org/reference/functions/wp_kses/
		*/
		$output = wp_kses($input,$allowedposttags);

		return $output;

	}// Method
	endif;


	/* Method
	_________________________
	*/
	if(function_exists('__utility_sanitize_textarea_html') === FALSE) :
	function __utility_sanitize_textarea_html($input)
	{
		/**
			@access (public)
				Escaping for HTML blocks.
				https://developer.wordpress.org/reference/functions/esc_html/
			@param (string) $input
				Content to be sanitized.
			@return (string)
				Sanitized content.
			@reference
				[Parent]/inc/customizer/setup.php
				[Parent]/model/widget/base.php
		*/
		$output = esc_html($input);
		return $output;

	}// Method
	endif;


	/* Method
	_________________________
	*/
	if(function_exists('__utility_sanitize_color_hex') === FALSE) :
	function __utility_sanitize_color_hex($input)
	{
		/**
			@access (public)
				color
			@param (string) $input
			@return (string[])
			@reference
				[Parent]/inc/customizer/setup.php
				[Parent]/model/widget/base.php
		*/
		if('' === $input){
			return '';
		}

		// 3 or 6 hex digits,or the empty string.
		if(preg_match('|^#([A-Fa-f0-9]{3}){1,2}$|',$input)){
			return $input;
		}

	}// Method
	endif;


	/* Method
	_________________________
	*/
	if(function_exists('__utility_sanitize_color_alpha') === FALSE) :
	function __utility_sanitize_color_alpha($color)
	{
		/**
			@access (public)
				alfa-color
			@param (string) $input
			@return (string[])
			@reference
				[Parent]/inc/customizer/setup.php
				[Parent]/model/widget/base.php
		*/
		$color = str_replace('#','',$color);
		if('' === $color){
			return '';
		}

		// 3 or 6 hex digits,or the empty string.
		if(preg_match('|^#([A-Fa-f0-9]{3}){1,2}$|','#' . $color)){
			// convert to rgb
			$colour = $color;
			if(strlen($colour) == 6){
				list($r,$g,$b) = array($colour[0] . $colour[1],$colour[2] . $colour[3],$colour[4] . $colour[5]);
			}
			elseif (strlen($colour) == 3){
				list($r,$g,$b) = array($colour[0] . $colour[0],$colour[1] . $colour[1],$colour[2] . $colour[2]);
			}
			else{
				return FALSE;
			}

			$r = hexdec($r);
			$g = hexdec($g);
			$b = hexdec($b);

			return 'rgba('.join(',',array('r' => $r,'g' => $g,'b' => $b,'a' => 1)) . ')';
		}
		return strpos(trim($color),'rgb') !== FALSE ? $color : FALSE;

	}// Method
	endif;


	/* Method
	_________________________
	*/
	if(function_exists('__utility_sanitize_upload') === FALSE) :
	function __utility_sanitize_upload($input)
	{
		/**
			@access (public)
			@param (string) $input
				File name or path.
			@return (string[])
				Array of allowed mime types keyed by their file extension regex.
			@reference
				[Parent]/inc/customizer/setup.php
				[Parent]/model/widget/base.php
		*/
		$return = '';

		/**
		 * @since 1.0.1
		 * 	Return an array with file extension and mime_type.
		 * @reference (WP)
		 * 	Retrieve the file type from the file name.
		 * 	https://developer.wordpress.org/reference/functions/wp_check_filetype/
		*/
		$fype = wp_check_filetype($input);

		if($fype['ext']){
			/**
			 * @since 1.0.1
			 * 	If $image has a valid mime_type, return it; otherwise, return the default.
			 * @reference (WP)
			 * 	Performs esc_url() for database usage.
			 * 	https://developer.wordpress.org/reference/functions/esc_url_raw/
			*/
			$return = esc_url_raw($input);
		}
		return $return;

	}// Method
	endif;


	/* Method
	_________________________
	*/
	if(function_exists('__utility_sanitize_integer') === FALSE) :
	function __utility_sanitize_integer($input)
	{
		/**
			@access (public)
				Data you wish to have converted to a non-negative integer.
			@param (mixed) $input
			@return (int)
				A non-negative integer.
			@reference
				[Parent]/inc/customizer/setup.php
				[Parent]/model/widget/base.php
		*/

		/**
		 * @reference (WP)
		 * 	Convert a value to non-negative integer.
		 * 	https://developer.wordpress.org/reference/functions/absint/
		*/
		return absint($input);

	}// Method
	endif;


	/* Method
	_________________________
	*/
	if(function_exists('__utility_sanitize_checkbox') === FALSE) :
	function __utility_sanitize_checkbox($checked)
	{
		/**
			@access (public)
				Sanitize checkbox.
			@param (bool) $checked
				Whether the checkbox is checked.
			@return (bool)
				Whether the checkbox is checked.
			@reference
				[Parent]/inc/customizer/setup.php
				[Parent]/model/widget/base.php
		*/
		if($checked == 1){
			return 1;
		}
		else{
			return 0;
		}

	}// Method
	endif;


	/* Method
	_________________________
	*/
	if(function_exists('__utility_sanitize_email') === FALSE) :
	function __utility_sanitize_email($input)
	{
		/**
			@access (public)
				Allowed character regular expression: /[^a-z0-9+_.@-]/i.
			@param (string) $input
				Email address to filter.
			@return (string)
				Filtered email address.
			@reference
				[Parent]/inc/customizer/setup.php
				[Parent]/model/widget/base.php
		*/

		/**
		 * @reference (WP)
		 * 	Strips out all characters that are not allowable in an email.
		 * 	https://developer.wordpress.org/reference/functions/sanitize_email/
		*/
		return sanitize_email($input);

	}// Method
	endif;


	/* Method
	_________________________
	*/
	if(function_exists('__utility_sanitize_url') === FALSE) :
	function __utility_sanitize_url($input)
	{
		/**
			@access (public)
			@param (string) $input
				The URL to be cleaned.
			@return (string)
				The cleaned URL after esc_url() is run with the 'db' context.
			@reference
				[Parent]/inc/customizer/setup.php
				[Parent]/model/widget/base.php
		*/

		/**
		 * @reference (WP)
		 * 	Performs esc_url() for database usage.
		 * 	https://developer.wordpress.org/reference/functions/esc_url_raw/
		*/
		return esc_url_raw($input);

	}// Method
	endif;


	/* Method
	_________________________
	*/
	if(function_exists('__utility_sanitize_path') === FALSE) :
	function __utility_sanitize_path($input)
	{
		/**
			@access (public)
			@param (string) $path 
				Path to be sanitize. 
				Accepts absolute and relative internal paths.
			@return (string) 
				Normalized path.
			@reference
				[Parent]/inc/customizer/setup.php
				[Parent]/model/widget/base.php
		*/
		if(FALSE !== realpath($input)){
			$input = realpath($input);
		}

		// Remove Windows drive for local installs if the root isn't cached yet.
		$input = preg_replace('#^[A-Z]\:#i','',$input);

		/**
		 * @reference (WP)
		 * 	Normalize a filesystem path.
		 * 	https://developer.wordpress.org/reference/functions/wp_normalize_path/
		*/
		return wp_normalize_path($input);

	}// Method
	endif;


	/* Method
	_________________________
	*/
	if(function_exists('__utility_sanitize_sortable') === FALSE) :
	function __utility_sanitize_sortable($input)
	{
		/**
			[NOTE]
				This function is provided ONLY for this theme (sortable item control).
			@access (public)
				Sanitize sortable items (SNS services) of this theme .
			@param (string)
			@return (string)
			@reference
				[Parent]/inc/customizer/setup.php
				[Parent]/model/widget/base.php
		*/
		$output = array();

		// Get valid services
		$valid = array(
			'twitter',
			'line',
			'facebook',
			'getpocket',
			'hatena',
			'pinterest',
			'instagram',
			'github',
			'youtube',
		);

		// Make array
		$list = explode(',',$input);
		if(!$list){
			return NULL;
		}

		// Loop and verify
		foreach($list as $item){

			// Separate service and status
			$item = explode(':',$item);

			if(isset($item[0]) && isset($item[1])){
				// if(array_key_exists($item[0],$valid)) :
				// if(in_array($item[0],$valid)) :
				$status = $item[1] ? '1' : '0';
				$output[] = trim($item[0] . ':' . $status);
				// endif;
			}
		}

		/**
		 * @reference (WP)
		 * 	Escaping for HTML attributes.
		 * 	https://developer.wordpress.org/reference/functions/esc_attr/
		*/
		return trim(esc_attr(implode(',',$output)));

	}// Method
	endif;


	/* Method
	_________________________
	*/
	if(function_exists('__utility_sanitize_select') === FALSE) :
	function __utility_sanitize_select($input,$setting)
	{
		/**
			[NOTE]
				This function is provided for theme customizer.
			@access(public)
			@param (mixed) $input
				The value to sanitize.
			@param (WP_Customize_Setting) $setting
				Handles saving and sanitizing of settings.
				https://developer.wordpress.org/reference/classes/wp_customize_setting/
			@return (mixed)
				Sanitized value.
			@reference
				[Parent]/inc/customizer/setup.php
		*/

		/**
		 * @since 1.0.1
		 * 	Ensure input is a slug.
		 * @reference (WP)
		 * 	Sanitizes a string key.
		 * 	https://developer.wordpress.org/reference/functions/sanitize_key/
		*/
		$input = sanitize_key($input);

		// Get list of choices from the control associated with the setting.
		$choices = $setting->manager->get_control($setting->id)->choices;

		// If the input is a valid key, return it; otherwise, return the default.
		return (array_key_exists($input,$choices) ? $input : $setting->default);

	}// Method
	endif;


	/* Method
	_________________________
	*/
	if(function_exists('__utility_sanitize_image') === FALSE) :
	function __utility_sanitize_image($input,$setting)
	{
		/**
			[NOTE]
				This function is provided for theme customizer.
			@access(public)
				Sanitize image.
			@param (string) $input
				Image filename or path.
			@param (WP_Customize_Setting) $setting
				Handles saving and sanitizing of settings.
				https://developer.wordpress.org/reference/classes/wp_customize_setting/
			@return (string)
				The image filename if the extension is allowed; otherwise, the setting default.
			@reference
				[Parent]/inc/customizer/setup.php
		*/

		/**
		 * @since 1.0.1
		 * 	Array of valid image file types.
		 * 	The array includes image mime types that are included in wp_get_mime_types().
		 * @reference (WP)
		 * 	Retrieve list of mime types and file extensions.
		 * 	https://developer.wordpress.org/reference/functions/wp_get_mime_types/
		*/
		$mimes = array(
			'jpg|jpeg|jpe' => 'image/jpeg',
			'gif' => 'image/gif',
			'png' => 'image/png',
			'bmp' => 'image/bmp',
			'tif|tiff' => 'image/tiff',
			'ico' => 'image/x-icon',
		);

		/**
		 * @since 1.0.1
		 * 	Return an array with file extension and mime_type.
		 * @reference (WP)
		 * 	Retrieve the file type from the file name.
		 * 	https://developer.wordpress.org/reference/functions/wp_check_filetype/
		*/
		$file = wp_check_filetype($input,$mimes);

		// If $image has a valid mime_type, return it; otherwise, return the default.
		return ($file['ext'] ? $input : $setting->default);

	}// Method
	endif;


	/* Method
	_________________________
	*/
	if(!function_exists('__utility_sanitize_number')) :
	function __utility_sanitize_number($input,$setting)
	{
		/**
			[NOTE]
				This function is provided for theme customizer.
			@access (public)
				Sanitize number range.
			@param (mixed) $input
				Number to check within the numeric range defined by the setting.
			@param (WP_Customize_Setting) $setting
				Handles saving and sanitizing of settings.
				https://developer.wordpress.org/reference/classes/wp_customize_setting/
			@return (int)
				The number, if it is zero or greater and falls within the defined range; otherwise, the setting default.
			@reference
				[Parent]/inc/customizer/setup.php
		*/

		/**
		 * @since 1.0.1
		 * 	Ensure input is an absolute integer.
		 * @reference (WP)
		 * 	Convert a value to non-negative integer.
		 * 	https://developer.wordpress.org/reference/functions/absint/
		*/
		$input = absint($input);

		// Get the input attributes associated with the setting.
		$atts = $setting->manager->get_control($setting->id)->input_attrs;

		// Get min.
		$min = isset($atts['min']) ? $atts['min'] : $input;

		// Get max.
		$max = isset($atts['max']) ? $atts['max'] : $input;

		// Get Step.
		$step = isset($atts['step']) ? $atts['step'] : 1;

		// If the input is within the valid range, return it; otherwise, return the default.
		return ($min <= $input && $input <= $max && is_int($input / $step) ? $input : $setting->default);

	}// Method
	endif;
