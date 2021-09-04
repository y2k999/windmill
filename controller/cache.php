<?php
/**
 * Core class/function as application root.
 * @package Windmill
 * @license GPL3.0+
 * @since 1.0.1
*/

/**
 * Inspired by Beans Framework WordPress Theme
 * @link https://www.getbeans.io
 * @author Thierry Muller
 * 
 * Inspired by yStandard WordPress Theme
 * @link https://wp-ystandard.com
 * @author yosiakatsuki
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
if(class_exists('_controller_cache') === FALSE) :
class _controller_cache
{
/**
 * [TOC]
 * 	__get_instance()
 * 	__construct()
 * 	__get_data()
 * 	__delete_data()
 * 	__set_data()
 * 	__get_key()
 * 	__get_prefix()
 * 	__get_query()
 * 	__get_transient()
 * 	__get_expiration()
 * 	__is_active()
*/

	/**
		@access(private)
			Class properties.
		@var (string) $_class
			Name/Identifier with prefix.
		@var (string) $_index
			Name/Identifier without prefix.
		@var (string) $_prefix
	*/
	private static $_class = '';
	private static $_index = '';
	private static $_prefix = '';


	/**
	 * Traits.
	*/
	use _trait_singleton;
	use _trait_theme;


	/* Constructor
	_________________________
	*/
	private function __construct()
	{
		/**
			@access (private)
				Class constructor.
				This is only called once,since the only way to instantiate this is with the get_instance() method in trait (singleton.php).
			@return (void)
			@reference (WP)
				Retrieves name of the current theme.
				https://developer.wordpress.org/reference/functions/get_template/
			@reference
				[Parent]/inc/trait/singleton.php
				[Parent]/inc/utility/general.php
		*/

		// Init properties.
		self::$_class = __utility_get_class(get_class($this));
		self::$_index = __utility_get_index(self::$_class);
		// self::$_prefix = 'windmill-cache';
		self::$_prefix = self::__make_handle(self::$_index);

	}// Method


	/* Method
	_________________________
	*/
	public static function __get_data($needle,$param)
	{
		/**
			[Shortcut]
				__utility_get_cache()
			@access (public)
				Get cache data.
			@param (string) $needle
				Transient name.
				Expected to not be SQL-escaped.
			@param (array) $param
			@return (mixed)
				Value of transient.
		*/
		$key = self::__get_key($needle,$param);

		/**
		 * @reference (WP)
		 * 	Retrieves the value of a transient.
		 * 	https://developer.wordpress.org/reference/functions/get_transient/
		*/
		return get_transient($key);

	}// Method


	/* Method
	_________________________
	*/
	public static function __delete_data($needle,$param)
	{
		/**
			[Shortcut]
				__utility_delete_cache()
			@access (public)
				Delete cache.
			@param (string) $needle
				Transient name.
				Expected to not be SQL-escaped.
			@param (array) $param
			@return (bool)
				True if the transient was deleted,false otherwise.
		*/
		$key = self::__get_key($needle,$param);

		/**
		 * @reference (WP)
		 * 	Deletes a transient.
		 * 	https://developer.wordpress.org/reference/functions/delete_transient/
		*/
		return delete_transient($key);

	}// Method


	/* Method
	_________________________
	*/
	public static function __set_data($needle,$obj,$param,$expiration,$force = FALSE)
	{
		/**
			[Shortcut]
				__utility_set_cache()
			@access (public)
				Set query cache.
			@param (string) $needle
				Transient name.
				Expected to not be SQL-escaped.
				Must be 172 characters or fewer in length.
			@param (mixed) $obj
				Transient value.
				Must be serializable if non-scalar.
				Expected to not be SQL-escaped.
			@param (array) $param
			@param (int) $expiration
				Time until expiration in seconds.
				[Default]
				0 (no expiration).
			@param (bool) $force
			@return (bool)
				True if the value was set,false otherwise.
		*/
		if(!is_numeric($expiration)){
			return FALSE;
		}

		// キャッシュNGユーザーの場合、削除して抜ける.
		if(!self::__is_active()){
			self::__delete_data($needle,$param);

			// 強制的にキャッシュ作成する場合は抜けない.
			if(FALSE === $force){
				return FALSE;
			}
		}
		$expiration = self::__get_expiration((int) $expiration);
		$key = self::__get_key($needle,$param);

		/**
		 * @reference (WP)
		 * 	Sets/updates the value of a transient.
		 * 	https://developer.wordpress.org/reference/functions/set_transient/
		*/
		return set_transient($key,$obj,$expiration);

	}// Method


	/**
		@access (private)
			Generate cache key.
		@param (string) $needle
			Transient name.
			Expected to not be SQL-escaped.
			Must be 172 characters or fewer in length.
		@param (array) $param
		@return (bool)|(string)
			the extracted part of string; or false on failure,or an empty string.
			_filter[_env_cache][key]
		@reference
			[Parent]/inc/utility/general.php
	*/
	private static function __get_key($needle,$param)
	{
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		/**
		 * @since 1.0.1
		 * 	Generate the string for key.
		 * @reference (Beans)
		 * 	Call the functions added to a filter hook.
		 * 	https://www.getbeans.io/code-reference/functions/beans_apply_filters/
		*/
		$key = self::__get_prefix($needle,$param) . md5(serialize($param));
		$key = beans_apply_filters("_filter[{$class}][{$function}]",$key,$needle,$param);

		// Trim the string for transient.
		return substr($key,0,45);

	}// Method


	/**
		@access (private)
			Generate prefix for cache key.
		@param (string) $needle
			Transient name.
			Expected to not be SQL-escaped.
			Must be 172 characters or fewer in length.
		@param (array) $param
		@return (string)
			_filter[_env_cache][prefix]
		@reference
			[Parent]/inc/utility/general.php
	*/
	private static function __get_prefix($needle,$param)
	{
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		/**
		 * @reference (Beans)
		 * 	Call the functions added to a filter hook.
		 * 	https://www.getbeans.io/code-reference/functions/beans_apply_filters/
		*/
		return beans_apply_filters("_filter[{$class}][{$function}]",self::$_prefix . $needle,$needle,$param);

	}// Method


	/**
		@access (private)
			Get query from cache.
		@param (string) $needle
			Transient name.
			Expected to not be SQL-escaped.
			Must be 172 characters or fewer in length.
		@param (array) $param
		@param (int) $expiration
			Time until expiration in seconds.
			[Default]
			0 (no expiration).
		@return (mixed)
			Value of transient.
	*/
	private static function __get_query($needle,$param,$expiration)
	{
		// Try to get the cache if the cache is active.
		if(is_numeric($expiration) && self::__is_active()){
			$key = self::__get_key($needle,$param);
			$data = self::__get_transient($key);
			if(FALSE !== $data){
				return $data;
			}
		}

		/**
		 * @reference (WP)
		 * 	The WordPress Query class.
		 * 	https://developer.wordpress.org/reference/classes/wp_query/
		*/
		$query = new WP_Query($param);

		// Generate the cache.
		self::__set_data($needle,$query,$param,$expiration);

		return $query;

	}// Method


	/**
		@access (private)
			Geta cache transient.
		@param (string) $transient
			Transient name.
			Expected to not be SQL-escaped.
		@return (mixed)
			Value of transient.
	*/
	private static function __get_transient($transient)
	{
		/**
		 * @reference (WP)
		 * 	Retrieves the value of a transient.
		 * 	https://developer.wordpress.org/reference/functions/get_transient/
		*/
		return get_transient($transient);

	}// Method


	/**
		@access (private)
			Get cache expiration
		@param (int) $day
		@return (float)|(int)
	*/
	private static function __get_expiration($day = 1)
	{
		return $day * 60 * 60 * 24;

	}// Method


	/**
		@access (private)
		@return (bool)
	*/
	private static function __is_active()
	{
		/**
		 * @reference (WP)
		 * 	Determines whether the current visitor is a logged in user.
		 * 	https://developer.wordpress.org/reference/functions/is_user_logged_in/
		*/
		if(!is_user_logged_in()){
			return TRUE;
		}

		/**
		 * @reference (WP)
		 * 	Returns whether the current user has the specified capability.
		 * 	https://developer.wordpress.org/reference/functions/current_user_can/
		*/
		if(!current_user_can('edit_posts')){
			return TRUE;
		}
		return FALSE;

	}// Method


}// Class
endif;
// new _controller_cache();
_controller_cache::__get_instance();
