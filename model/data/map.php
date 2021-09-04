<?php
/**
 * Stores data for applications.
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
if(class_exists('_data_map') === FALSE) :
class _data_map
{
/**
 * [TOC]
 * 	__get_instance()
 * 	__construct()
 * 	set_application()
 * 	__get_setting()
*/

	/**
		@access (private)
			Class properties.
		@var (string) $_class
			Name/Identifier with prefix.
		@var (string) $_index
			Name/Identifier without prefix.
		@var (array) $_application
			Name/Id of applications.
	*/
	private static $_class = '';
	private static $_index = '';
	private static $_application = array();

	/**
	 * Traits.
	*/
	use _trait_singleton;


	/* Constructor
	_________________________
	*/
	private function __construct()
	{
		/**
			@access (private)
				Class constructor.
				This is only called once, since the only way to instantiate this is with the get_instance() method in trait (singleton.php).
			@return (void)
			@reference
				[Parent]/inc/trait/singleton.php
				[Parent]/inc/utility/general.php
		*/

		// Init properties.
		self::$_class = __utility_get_class(get_class($this));
		self::$_index = __utility_get_index(self::$_class);
		self::$_application = $this->set_application();

	}// Method


	/* Setter
	_________________________
	*/
	private function set_application()
	{
		/**
			@access (private)
				Set application class map.
			@return (array)
				_filter[_data_map][application]
			@reference
				[Parent]/inc/utility/general.php
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		/**
		 * @reference (Beans)
		 * 	Call the functions added to a filter hook.
		 * 	https://www.getbeans.io/code-reference/functions/beans_apply_filters/
		*/
		return beans_apply_filters("_filter[{$class}][{$function}]",array(
			// application
			'amp' => 'app',
			'back2top' => 'app',
			'branding' => 'app',
			'breadcrumb' => 'app',
			'comments' => 'app',
			'credit' => 'app',
			'dynamic-sidebar' => 'app',
			'excerpt' => 'app',
			'follow' => 'app',
			'html-sitemap' => 'app',
			'image' => 'app',
			'meta' => 'app',
			'nav' => 'app',
			'pagination' => 'app',
			'post-link' => 'app',
			'search' => 'app',
			'share' => 'app',
			'title' => 'app',
			// shortcode
			'embed-card' => 'shortcode',
			'hatena-card' => 'shortcode',
			'ogp-card' => 'shortcode',
			'toc' => 'shortcode',
			// widget
			'adsence' => 'widget',
			'profile' => 'widget',
			'recent' => 'widget',
			'relation' => 'widget',
		));

	}// Method


	/* Method
	_________________________
	*/
	public static function __get_setting($needle = '')
	{
		/**
			@access (public)
				Returns class mapping of applications and return the appropriate type.
			@param (string) $needle
				The name of the specialised application map.
				 - widget
				 - app
			@return (string[])|(bool)
			@reference
				[Parent]/inc/trait/theme.php
		*/
		if(!$needle){return;}

		if(self::$_application[$needle]){
			return self::$_application[$needle];
		}
		else{
			return FALSE;
		}

	}// Method


}// Class
endif;
// new _data_map();
_data_map::__get_instance();
