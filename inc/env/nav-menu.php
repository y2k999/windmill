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
if(class_exists('_env_nav_menu') === FALSE) :
class _env_nav_menu
{
/**
 * [TOC]
 * 	__get_instance()
 * 	__construct()
 * 	set_hook()
 * 	invoke_hook()
 * 	nav_menu_item_id()
 * 	nav_menu_css_class()
*/

	/**
		@access (private)
			Class properties.
		@var (string) $_class
			Name/Identifier with prefix.
		@var (string) $_index
			Name/Identifier without prefix.
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
				_filter[_env_nav_menu][hook]
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
			'nav_menu_item_id' => array(
				'tag' => 'add_filter',
				'hook' => 'nav_menu_item_id'
			),
			'nav_menu_css_class' => array(
				'tag' => 'add_filter',
				'hook' => 'nav_menu_css_class',
				'args' => 2
			),
		)));

	}// Method


	/* Hook
	_________________________
	*/
	public function nav_menu_item_id($menu_id)
	{
		/**
			@access (public)
				Filters the ID applied to a menu item’s list item element.
				https://developer.wordpress.org/reference/hooks/nav_menu_item_id/
			@param (array) $menu_id
				The ID that is applied to the menu item's <li> element.
			@return (array)
				_filter[_env_nav_menu][nav_menu_item_id]
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
		return $menu_id = apply_filters("_filter[{$class}][{$function}]",'');

	}// Method


	/* Hook
	_________________________
	*/
	public function nav_menu_css_class($classes,$item)
	{
		/**
			@access (public)
				Filters the CSS classes applied to a menu item’s list item element.
				https://developer.wordpress.org/reference/hooks/nav_menu_css_class/
			@param (string[]) $classes
				Array of the CSS classes that are applied to the menu item's <li> element.
			@param (WP_Post) $item
				The current menu item.
			@return (array)
				_filter[_env_nav_menu][nav_menu_css_class]
			@reference
				[Parent]/inc/utility/general.php
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		if(isset($classes[0])){
			array_splice($classes,1);
		}
		else{
			$classes = array();
		}

		if($item -> current == TRUE){
			$classes[] = 'current';
		}

		/**
		 * @reference (WP)
		 * 	Calls the callback functions that have been added to a filter hook.
		 * 	https://developer.wordpress.org/reference/functions/apply_filters/
		*/
		return apply_filters("_filter[{$class}][{$function}]",$classes);

	}// Method


}// Class
endif;
// new _env_nav_menu();
_env_nav_menu::__get_instance();
