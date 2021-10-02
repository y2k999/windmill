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
if(class_exists('_windmill_google') === FALSE) :
class _windmill_google
{
/**
 * [TOC]
 * 	__get_instance()
 * 	__construct()
 * 	set_hook()
 * 	invoke_hook()
 * 	search_console()
 * 	analytics()
 * 	is_gsc_enable()
 * 	is_ga_enable()
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
			'search_console' => array(
				'tag' => 'add_action',
				'hook' => 'wp_head'
			),
			'analytics' => array(
				'tag' => 'add_action',
				'hook' => 'wp_enqueue_scripts'
				// 'hook' => 'wp_head'
			),
		)));

	}// Method


	/* Hook
	_________________________
	*/
	public function search_console()
	{
		/**
			@access (public)
				Print google-siete-verification meta.
			@return (void)
			@reference
				[Parent]/inc/customizer/option.php
				[Parent]/inc/utility/general.php
		*/
		if(__utility_is_active_plugin('google-site-kit/google-site-kit.php')){return;}

		// if(!$this->is_gsc_enable()){return;}

		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		$site_verification = NULL;
		$site_verification = __utility_get_option('gsc_meta-tag');
		if(!$site_verification){return;}

		/**
		 * @reference (WP)
		 * 	Calls the callback functions that have been added to a filter hook.
		 * 	https://developer.wordpress.org/reference/functions/apply_filters/
		*/
		echo apply_filters("_filter[{$class}][{$function}]",sprintf('<meta name="google-site-verification" content="%s" />',esc_attr($site_verification)));

	}// Method


	/* Hook
	_________________________
	*/
	public function analytics()
	{
		/**
			@access (public)
				Print Google Analytics script.
			@return (void)
			@reference
				[Parent]/inc/customizer/option.php
				[Parent]/inc/utility/general.php
		*/
		if(__utility_is_active_plugin('google-site-kit/google-site-kit.php')){return;}

		// if(!$this->is_ga_enable()){return;}

		$tracking_id = NULL;
		$tracking_id = __utility_get_option('ga_tracking-id');
		if(!$tracking_id){return;}
		// if(!preg_match('/^UA-\d+-\d+$/',$tracking_id)){return;}

		/**
		 * @reference (WP)
		 * 	Enqueue a script.
		 * 	https://developer.wordpress.org/reference/functions/wp_enqueue_script/
		*/
		wp_enqueue_script(
			__utility_make_handle('google-analytics'),
			esc_url('https://www.googletagmanager.com/gtag/js?id=' . $tracking_id),
			array(),
			__utility_get_theme_version(),
			TRUE
		);

		/**
		 * @reference (WP)
		 * 	Adds extra code to a registered script.
		 * 	https://developer.wordpress.org/reference/functions/wp_add_inline_script/
		*/
		wp_add_inline_script(
			__utility_make_handle('google-analytics'),
			"window.dataLayer = window.dataLayer || []; function gtag(){dataLayer.push(arguments)}; gtag('js', new Date()); gtag('config', '{$tracking_id}');",
			'after'
		);

	}// Method


	/**
		@access (private)
			Check if Google Search Console is available.
		@return (bool)
		@reference
			[Parent]/inc/customizer/option.php
			[Parent]/inc/utility/general.php
	*/
	private function is_gsc_enable()
	{
		if(__utility_get_option('gsc_use') === 0){
			return FALSE;
		}
		return TRUE;

	}// Method


	/**
		@access (private)
			Check if Google Analytics is available.
		@return (bool)
		@reference
			[Parent]/inc/customizer/option.php
			[Parent]/inc/utility/general.php
			[Plugin]/amp/amp.php
	*/
	private function is_ga_enable()
	{
		if(__utility_get_option('ga_use') === 0){
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
// new _windmill_google();
_windmill_google::__get_instance();
