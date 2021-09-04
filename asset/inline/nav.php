<?php
/**
 * Define inline styles for dynamically setting.
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
if(class_exists('_inline_nav') === FALSE) :
class _inline_nav
{
/**
 * [TOC]
 * 	__get_instance()
 * 	__construct()
 * 	set_color()
 * 	set_theme_mod()
 * 	set_style()
 * 	get_primary()
 * 	get_secondary()
 * 	__get_setting()
*/

	/**
		@access (private)
			Class properties.
		@var (string) $_class
			Name/Identifier with prefix.
		@var (string) $_index
			Name/Identifier without prefix.
		@var (array) $theme_mod
			Theme customizer settings.
		@var (array) $color
			Main colors for this theme.
		@var (null) $css
			Streams for the current css instance.
		@var (string) $exception
			CSS that PHP_CSS plugin can not handle.
		@var (string) $_style
			Dynamic/Iinline css of theme style components.
	*/
	private static $_class = '';
	private static $_index = '';
	private $color = array();
	private $theme_mod = array();
	private $css = NULL;
	private $exception = '';
	private static $_style = '';

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
				This is only called once, since the only way to instantiate this is with the get_instance() method in trait (singleton.php).
			@return (void)
			@reference
				[Parent]/inc/trait/singleton.php
				[Parent]/inc/utility/general.php
		*/

		// Init properties.
		self::$_class = __utility_get_class(get_class($this));
		self::$_index = __utility_get_index(self::$_class);
		$this->color = $this->set_color();

		// Customizer setting.
		$this->theme_mod = $this->set_theme_mod();

		// Invoke PHP_CSS plugin.
		if(class_exists('PHP_CSS') === FALSE) :
			get_template_part(SLUG['plugin'] . 'php-css/php-css');
		endif;
		$this->css = new PHP_CSS;

		self::$_style = $this->set_style();

	}// Method


	/* Setter
	_________________________
	*/
	private function set_theme_mod()
	{
		/**
			@access (private)
				Set hover effects from theme customizer settings.
			@return (array)
				_filter[_inline_nav][theme_mod]
			@reference
				[Parent]/inc/customizer/option.php
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
			__utility_get_option('skin_nav_primary'),
			__utility_get_option('skin_nav_secondary'),
		));

	}// Method


	/* Setter
	_________________________
	*/
	private function set_style()
	{
		/**
			@access (private)
				Set the inline css of theme button components.
			@return (string)
				_filter[_inline_nav][style]
			@reference
				[Parent]/inc/trait/theme.php
				[Parent]/inc/utility/general.php
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		// Topbar
		$this->get_primary();

		// Footer
		$this->get_secondary();

		/**
		 * @reference (Beans)
		 * 	Call the functions added to a filter hook.
		 * 	https://www.getbeans.io/code-reference/functions/beans_apply_filters/
		*/
		return beans_apply_filters("_filter[{$class}][{$function}]",$this->minify($this->exception . $this->css->css_output()));

	}// Method


	/**
		@access (public)
			The inline css for the primary navigation.
		@return (string)
			_filter[_inline_nav][primary]
		@reference
			[Parent]/inc/setup/constant.php
			[Parent]/inc/utility/general.php
			[Parent/inc/utility/theme.php
			[Parent]/model/app/nav.php
			[Parent]/template-part/nav/nav-primary.php
	*/
	private function get_primary()
	{
		if(__utility_is_uikit()){return;}

	}// Method


	/**
		@access (private)
			The inline css for the secondary navigation.
		@return (string)
			_filter[_inline_nav][secondary]
		@reference
			https://www.acky.info/tips/css/00011.html
			[Parent]/inc/utility/general.php
			[Parent]/inc/utility/theme.php
			[Parent]/model/app/nav.php
			[Parent]/template-part/nav/nav-secondary.php
	*/
	private function get_secondary()
	{
		if(__utility_is_uikit()){return;}

	}// Method


	/* Method
	_________________________
	*/
	public static function __get_setting()
	{
		/**
			@access (public)
			@return (string)
			@reference
				[Parent]/model/app/nav.php
		*/
		return self::$_style;

	}// Method


}// Class
endif;
// new _inline_nav();
_inline_nav::__get_instance();
