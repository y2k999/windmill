<?php
/**
 * Render Application.
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
if(class_exists('_app_search') === FALSE) :
class _app_search
{
/**
 * [TOC]
 * 	__get_instance()
 * 	__construct()
 * 	set_param()
 * 	set_hook()
 * 	invoke_hook()
 * 	__the_template()
 * 	__the_icon()
 * 	__the_overlay()
 * 	__the_form()
*/

	/**
		@access (private)
			Class properties.
		@var (string) $_class
			Name/Identifier with prefix.
		@var (string) $_index
			Name/Identifier without prefix.
		@var (array) $_param
			Parameter for the application.
		@var (array) $hook
			Collection of hooks that is being registered (that is, actions or filters).
		@var (int) $z_index
			Property specifies the stack order of an element.
		@var (string) $toggle_target
			Hide, switch or change the appearance of different contents through a toggle.
	*/
	private static $_class = '';
	private static $_index = '';
	private static $_param = array();
	private $hook = array();
	private $z_index = 0;
	private $toggle_target = '';

	/**
	 * Traits.
	*/
	use _trait_hook;
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
				This is only called once, since the only way to instantiate this is with the get_instance() method in trait (singleton.php).
			@return (void)
			@reference
				[Parent]/inc/trait/singleton.php
				[Parent]/inc/trait/theme.php
				[Parent]/inc/utility/general.php
		*/

		// Init properties.
		self::$_class = __utility_get_class(get_class($this));
		self::$_index = __utility_get_index(self::$_class);
		self::$_param = $this->set_param(self::$_index);

		$this->z_index = 999;
		$this->toggle_target = 'search-overlay';

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
				_filter[_app_search][hook]
			@reference
				[Parent]/inc/setup/constant.php
				[Parent]/inc/trait/hook.php
				[Parent]/inc/utility/general.php
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);
		$index = self::$_index;

		/**
		 * @reference (Beans)
		 * 	Call the functions added to a filter hook.
		 * 	https://www.getbeans.io/code-reference/functions/beans_apply_filters/
		*/
		return beans_apply_filters("_filter[{$class}][{$function}]",$this->set_parameter_callback(array(
			'__the_icon' => array(
				'beans_id' => $class . '__the_render',
				'tag' => 'beans_add_action',
				'hook' => 'windmill/search/overlay/prepend'
			),
			'__the_overlay' => array(
				'beans_id' => $class . '__the_overlay',
				'tag' => 'beans_add_action',
				'hook' => HOOK_POINT['model'][$index]['main']
			),
			'__the_form' => array(
				'beans_id' => $class . '__the_form',
				'tag' => 'beans_add_action',
				'hook' => HOOK_POINT['model'][$index]['main']
			),
		)));

	}// Method


	/* Method
	_________________________
	*/
	public static function __the_template($args = array())
	{
		/**
			@access (private)
				Load and echo this application.
			@param (array) $args
				Additional arguments passed to this application.
			@return (void)
			@reference
				[Parent]/searchform.php
				[Parent]/controller/structure/header.php
				[Parent]/inc/env/search.php
				[Parent]/inc/setup/constant.php
		*/
		$index = self::$_index;

		/**
		 * @reference (WP)
		 * 	Merge user defined arguments into defaults array.
		 * 	https://developer.wordpress.org/reference/functions/wp_parse_args/
		 * @param (string)|(array)|(object) $args
		 * 	Value to merge with $defaults.
		 * @param (array) $defaults
		 * 	Array that serves as the defaults.
		*/
		self::$_param = wp_parse_args($args,self::$_param);

		do_action(HOOK_POINT['model'][$index]['prepend']);

		/**
			@hooked
				_app_search::__the_render()
			@reference
				[Parent]/model/app/search.php
		*/
		do_action(HOOK_POINT['model'][$index]['main']);

		do_action(HOOK_POINT['model'][$index]['append']);

	}// Method


	/* Hook
	_________________________
	*/
	public function __the_icon()
	{
		/**
			@access (public)
				Render search toggle (icon).
			@return (void)
			@hook (beans id)
				_app_search__the_render
			@reference
				[Parent]/inc/utility/general.php
		*/
		if((self::$_param['class'] !== 'header') && (!self::$_param['overlay'])){return;}

		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		/**
		 * @reference (Beans)
		 * 	Echo output registered by ID.
		 * 	https://www.getbeans.io/code-reference/functions/beans_output_e/
		 * @reference (Uikit)
		 * 	https://getuikit.com/docs/navbar
		 * 	https://getuikit.com/docs/search
		 * 	https://getuikit.com/docs/toggle
		*/
		beans_output_e("_output[{$class}][{$function}]",sprintf(
			'<a href="%1$s" class="uk-navbar-toggle uk-visible@m" rel="search" itemprop="url" uk-toggle="target: .%2$s; animation: uk-animation-fade" uk-search-icon></a>',
			$href = '#',
			$this->toggle_target
		));

	}// Method


	/* Hook
	_________________________
	*/
	public function __the_overlay()
	{
		/**
			@access (public)
				Echo overlay search.
			@return (void)
			@hook (beans id)
				_app_search__the_overlay
			@reference
				[Parent]/inc/setup/constant.php
				[Parent]/template-part/nav/search.php
				[Parent]/inc/utility/general.php
		*/
		if((self::$_param['class'] !== 'header') && (!self::$_param['overlay'])){return;}

		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);
		$index = self::$_index;

		do_action('windmill/search/overlay/prepend');

		/**
		 * @reference (Beans)
		 * 	HTML markup.
		 * 	https://www.getbeans.io/code-reference/functions/beans_open_markup_e/
		 * 	https://www.getbeans.io/code-reference/functions/beans_close_markup_e/
		 * @reference (Uikit)
		 * 	https://getuikit.com/docs/search
		 * 	https://getuikit.com/docs/overlay
		*/
		beans_open_markup_e("_effect[{$class}][{$function}]",'div',array(
			'class' => 'uk-overlay uk-overlay-primary uk-position-cover uk-flex ' . $this->toggle_target,
			'style' => 'z-index: ' . $this->z_index = 999 . ';',
			'hidden' => 'hidden',
		));
			/**
			 * @reference (WP)
			 * 	Loads a template part into a template.
			 * 	https://developer.wordpress.org/reference/functions/get_template_part/
			*/
			get_template_part(SLUG['nav'] . 'search-overlay',NULL,array('toggle-target' => $this->toggle_target));

		beans_close_markup_e("_effect[{$class}][{$function}]",'div');

		do_action('windmill/search/overlay/append');

	}// Method


	/* Hook
	_________________________
	*/
	public function __the_form()
	{
		/**
			@access (public)
				Display WP default search form.
			@return (void)
			@hook (beans id)
				_app_search__the_form
			@reference
				[Parent]/searchform.php
				[Parent]/inc/utility/general.php
		*/
		if((self::$_param['class'] === 'header') || (self::$_param['overlay'])){return;}

		/**
		 * @reference (WP)
		 * 	Display search form.
		 * 	https://developer.wordpress.org/reference/functions/get_search_form/
		*/
		get_search_form(TRUE);

	}// Method


}// Class
endif;
// new _app_search();
_app_search::__get_instance();
