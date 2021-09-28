<?php 
/**
 * Configure the integration with third-party libraries.
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
if(class_exists('_windmill_google_analytics') === FALSE) :
class _windmill_google_analytics
{
/**
 * [TOC]
 * 	__get_instance()
 * 	__construct()
 * 	set_hook()
 * 	invoke_hook()
 * 	register()
 * 	is_enable()
*/

	/**
		@access (private)
			Class properties.
		@var (string) $_class
			Name/identifier with prefix.
		@var (string) $_index
			Name/identifier without prefix.
		@var (array) $hook
			Collection of hooks that is being registered (that is, actions or filters).
	*/
	private static $_class = '';
	private static $_index = '';
	private $hook = array();

	/**
	 * Traits.
	*/
	use _trait_hook;
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

		// Register hooks.
		$this->hook = $this->set_hook();
		$this->invoke_hook($this->hook);

	}// Method


	/* Setter
	_________________________
	*/
	private function set_hook()
	{
		/**
			@access (private)
				The collection of hooks that is being registered (that is, actions or filters).
			@return (array)
				_filter[_env_archive][hook]
			@reference
				[Parent]/inc/trait/hook.php
				[Parent]/inc/utility/general.php
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		/**
		 * @reference (WP)
		 * 	Calls the callback functions that have been added to a filter hook.
		 * 	https://developer.wordpress.org/reference/functions/apply_filters/
		*/
		return apply_filters("_filter[{$class}][{$function}]",$this->set_parameter_callback(array(
			'register' => array(
				'tag' => 'add_action',
				'hook' => 'wp_head'
			),
		)));

	}// Method


	/* Hook
	_________________________
	*/
	public function register()
	{
		/**
			@access (public)
				Returns the JSON representation of a value.
				https://www.php.net/manual/en/function.json-encode.php
			@return (void)
			@reference (WP)
				Prints scripts or data in the head tag on the front end.
				https://developer.wordpress.org/reference/hooks/wp_head/
			@reference
				[Parent]/inc/customizer/option.php
				[Parent]/inc/setup/constant.php
				[Parent]/inc/utility/general.php
				[Parent]/template-part/ga/xxx.php
		*/
		if(!$this->is_enable()){return;}

		$tracking_option = array();

		// Turn on output buffering
		ob_start();

		/**
		 * @reference (WP)
		 * 	Loads a template part into a template.
		 * 	https://developer.wordpress.org/reference/functions/get_template_part/
		*/
		get_template_part(SLUG['plugin'] . 'google/type-' . __utility_get_option('ga_tracking-type'),NULL,array(
			'ga_tracking_id' => __utility_get_option('ga_tracking-id'),
			'ga_tracking_option' => empty($tracking_option) ? '' : json_encode($tracking_option,JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT),
		));

		// Get current buffer contents and delete current output buffer.
		echo ob_get_clean();

	}// Method


	/**
		@access (private)
			Check if Google Analytics output.
		@return (bool)
		@reference
			[Parent]/inc/customizer/option.php
			[Parent]/inc/utility/general.php
			[Plugin]/amp/amp.php
	*/
	private function is_enable()
	{
		if(!__utility_get_option('ga_use')){
			return FALSE;
		}

		if(__utility_is_active_plugin('amp/amp.php')){
			if(amp_is_enabled()){
				// return FALSE;
			}
		}

		// if(!trim(get_option('ga_tracking_id',''))){
		if(__utility_get_option('ga_tracking-id') === ''){
			return FALSE;
		}

		if(__utility_get_option('ga_exclude-login')){
			/**
			 * @reference (WP)
			 * 	Determines whether the current visitor is a logged in user.
			 * 	https://developer.wordpress.org/reference/functions/is_user_logged_in/
			 * 	Returns whether the current user has the specified capability.
			 * 	https://developer.wordpress.org/reference/functions/current_user_can/
			*/
			if(is_user_logged_in() && current_user_can('edit_posts')){
				return FALSE;
			}
		}
		return TRUE;

	}// Method


}// Class
endif;
// new _windmill_google_analytics();
_windmill_google_analytics::__get_instance();
