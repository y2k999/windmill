<?php
/**
 * Set environmental configurations which enhance the theme by hooking into WordPress.
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
if(class_exists('_env_script_loader') === FALSE) :
class _env_script_loader
{
/**
 * [TOC]
 * 	__get_instance()
 * 	__construct()
 * 	set_async_defer()
 * 	set_hook()
 * 	invoke_hook()
 * 	async_defer()
 * 	script_loader_src()
 * 	style_loader_src()
 * 	script_type_attribute()
 * 	style_type_attribute()
*/

	/**
		@access (private)
			Class properties.
		@var (string) $_class
			Name/Identifier with prefix.
		@var (string) $_index
			Name/Identifier without prefix.
		@var (array) $async_defer
			Scripts for async/defer.
		@var (array) $hook
			Collection of hooks that is being registered (that is, actions or filters).
	*/
	private static $_class = '';
	private static $_index = '';
	private $async_defer = array();
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

		$this->async_defer = $this->set_async_defer();

		/**
		 * Register hooks.
		 * wp_print_styles() and wp_print_scripts() are not recommended since WP 3.3.
		*/
		$this->hook = $this->set_hook();
		$this->invoke_hook($this->hook);

	}// Method


	/* Setter
	_________________________
	*/
	private function set_async_defer()
	{
		/**
			@access (private)
				Set the scripts for async/defer.
			@return (array)
				_filter[_env_script_loader][async_defer]
			@reference
				[Parent]/inc/utility/general.php
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		/**
		 * @reference (WP)
		 * 	Calls the callback functions that have been added to a filter hook.
		 * 	https://developer.wordpress.org/reference/functions/apply_filters/
		*/
		return apply_filters("_filter[{$class}][{$function}]",array(
			'async_defer' => array(
				//'jquery',
			),
			'async' => array(
				'comment-reply',
				// 'wp-embed',
			),
			'defer' => array(
				'admin-bar',
			),
		));

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
				_filter[_env_script_loader][hook]
			@reference
				[Parent]/inc/trait/hook.php
				[Parent]/inc/utility/general.php
		*/

		/**
		 * @reference (WP)
		 * 	Determines whether the current request is for an administrative interface page.
		 * 	https://developer.wordpress.org/reference/functions/is_admin/
		*/
		if(is_admin()){return;}

		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		/**
		 * @reference (WP)
		 * 	Calls the callback functions that have been added to a filter hook.
		 * 	https://developer.wordpress.org/reference/functions/apply_filters/
		*/
		return apply_filters("_filter[{$class}][{$function}]",$this->set_parameter_callback(array(
			// Action
			'async_defer' => array(
				'tag' => 'add_action',
				'hook' => 'script_loader_tag',
				'args' => 3
			),
/*
			'script_type_attribute' => array(
				'tag' => 'add_action',
				'hook' => 'script_loader_tag'
			),
			'style_type_attribute' => array(
				'tag' => 'add_action',
				'hook' => 'style_loader_tag'
			),
*/
			// Filter
			'style_loader_src' => array(
				'tag' => 'add_filter',
				'hook' => 'style_loader_src'
			),
			'script_loader_src' => array(
				'tag' => 'add_filter',
				'hook' => 'script_loader_src'
			),
		)));

	}// Method


	/* Hook
	_________________________
	*/
	public function async_defer($tag,$handle,$src)
	{
		/**
			@access (public)
				Filters the HTML script tag of an enqueued script.
				https://developer.wordpress.org/reference/hooks/script_loader_tag/
			@param (string) $tag
				The <script> tag for the enqueued script.
			@param (string) $handle
				The script's registered handle.
			@param (string) $src
				The script's source URL.
			@return (string)
				_filter[_env_script_loader][async_defer]
			@reference
				[Parent]/inc/customizr/option.php
				[Parent]/inc/utility/general.php
		*/

		// Check the theme customizer settings.
		if(!__utility_get_option('async')){return;}

		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		/**
		 * @reference (WP)
		 * 	Calls the callback functions that have been added to a filter hook.
		 * 	https://developer.wordpress.org/reference/functions/apply_filters/
		*/
		if(in_array($handle,$this->async_defer['async_defer'],TRUE)){
			return apply_filters("_filter[{$class}][{$function}]",sprintf('<script src="%s" async defer></script>',$src));
		}

		if(in_array($handle,$this->async_defer['async'],TRUE)){
			return apply_filters("_filter[{$class}][{$function}]",sprintf('<script src="%s" async></script>',$src));
		}

		if(in_array($handle,$this->async_defer['defer'],TRUE)){
			return apply_filters("_filter[{$class}][{$function}]",sprintf('<script src="%s" defer></script>',$src));
		}

		return $tag;

	}// Method


	/* Hook
	_________________________
	*/
	public function script_loader_src($src)
	{
		/**
			@access (public)
				Filters the HTML script tag of an enqueued script.
				https://developer.wordpress.org/reference/hooks/script_loader_tag/
			@param (string) $src
				The script's source URL.
			@return (void)
		*/
		if(strpos($src,'ver=')){
			/**
			 * @reference (WP)
			 * 	Removes an item or items from a query string.
			 * 	https://developer.wordpress.org/reference/functions/remove_query_arg/
			*/
			$src = remove_query_arg('ver',$src);
		}
		return $src;

	}// Method


	/* Hook
	_________________________
	*/
	public function style_loader_src($src)
	{
		/**
			@access (public)
				Filters the HTML link tag of an enqueued style.
				https://developer.wordpress.org/reference/hooks/style_loader_tag/
			@param (string) $src
				The stylesheet's media attribute.
			@return (void)
		*/
		if(strpos($src,'ver=')){
			/**
			 * @reference (WP)
			 * 	Removes an item or items from a query string.
			 * 	https://developer.wordpress.org/reference/functions/remove_query_arg/
			*/
			$src = remove_query_arg('ver',$src);
		}
		return $src;

	}// Method


	/* Hook
	_________________________
	*/
	public function script_type_attribute($tag){
		/**
			@access(public)
				Filters the HTML script tag of an enqueued script.
				https://developer.wordpress.org/reference/hooks/script_loader_tag/
			@param (string) $tag
				The <script> tag for the enqueued script.
			@return (string)
		*/
		return str_replace("type='text/javascript' ",'',$tag);

	}// Method


	/* Hook
	_________________________
	*/
	public function style_type_attribute($tag)
	{
		/**
			@access (public)
				Filters the HTML link tag of an enqueued style.
				https://developer.wordpress.org/reference/hooks/style_loader_tag/
			@param (string) $tag
				The link tag for the enqueued style.
			@return (string)
		*/
		return preg_replace(["| type='.+?'s*|","| id='.+?'s*|",'| />|'],[' ',' ','>'],$tag);

	}// Method


}// Class
endif;
// new _env_script_loader();
_env_script_loader::__get_instance();
