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
if(class_exists('_inline_pagination') === FALSE) :
class _inline_pagination
{
/**
 * [TOC]
 * 	__get_instance()
 * 	__construct()
 * 	set_effect()
 * 	set_color()
 * 	set_theme_mod()
 * 	set_style()
 * 	get_common()
 * 	get_square()
 * 	get_circle()
 * 	__get_setting()
*/

	/**
		@access (private)
			Class properties.
		@var (string) $_class
			Name/Identifier with prefix.
		@var (string) $_index
			Name/Identifier without prefix.
		@var (array) $effect
			Styles and hover effects.
		@var (array) $theme_mod
			Theme customizer settings.
		@var (array) $color
			Main colors for this theme.
		@var (null) $css
			Streams for the current css instance.
		@var (string) $_style
			Dynamic/Iinline css of theme style components.
	*/
	private static $_class = '';
	private static $_index = '';
	private $effect = array();
	private $color = array();
	private $theme_mod = '';
	private $css = NULL;
	private static $_style = '';

	/**
	 * Traits
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
		$this->effect = $this->set_effect();
		$this->color = $this->set_color();

		// Customizer settings.
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
	private function set_effect()
	{
		/**
			@access (private)
				Set several hover effect for pagination.
			@return (array)
				_filter[_inline_pagination][effect]
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
			'square' => 'square',
			'circle' => 'circle',
		));

	}// Method


	/* Setter
	_________________________
	*/
	private function set_theme_mod()
	{
		/**
			@access (private)
				Set styles/effects from theme customizer settings.
			@return (string)
				_filter[_inline_pagination][theme_mod]
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
		return beans_apply_filters("_filter[{$class}][{$function}]",__utility_get_option('skin_nav_pagination'));

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
				_filter[_inline_pagination][style]
			@reference
				[Parent]/inc/trait/theme.php
				[Parent]/inc/utility/general.php
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		$this->get_common();

		if(array_key_exists($this->theme_mod,$this->effect)){
			$method = 'get_' . $this->effect[$this->theme_mod];
			if(is_callable([$this,$method])){
				call_user_func([$this,$method]);
			}
		}

		/**
		 * @reference (Beans)
		 * 	Call the functions added to a filter hook.
		 * 	https://www.getbeans.io/code-reference/functions/beans_apply_filters/
		*/
		return beans_apply_filters("_filter[{$class}][{$function}]",$this->minify($this->css->css_output()));

	}// Method


	/**
		@access (private)
			The inline css for the pagination base.
		@return (string)
			_filter[_inline_pagination][common]
		@reference
			[Parent]/inc/utility/general.php
			[Parent]/model/app/pagination.php
	*/
	private function get_common()
	{
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		// Add a single property.
		$this->css->set_selector('#pagination .nav-links li');
		$this->css->add_property('margin','1px');

	}// Method


	/**
		@access (private)
			The inline css for the "Square" style.
		@return (string)
			_filter[_inline_pagination][square]
		@reference
			[Parent]/inc/setup/constant.php
			[Parent]/inc/utility/general.php
			[Parent]/model/app/pagination.php
	*/
	private function get_square()
	{
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		// Add multiple properties at once.
		$this->css->set_selector('#pagination .nav-links .active');
		$this->css->add_properties(array(
			'color' => $this->color['link'],
			'border' => '1px solid ' . $this->color['link'],
		));

		// Add multiple properties at once.
		$this->css->set_selector('#pagination .nav-links .active:hover');
		$this->css->add_properties(array(
			'color' => $this->color['hover'],
			'border' => '1px solid ' . $this->color['hover'],
		));

		// Add multiple properties at once.
		$this->css->set_selector('#pagination .nav-links a');
		$this->css->add_properties(array(
			'color' => COLOR['white'],
			'border' => '1px solid ' . $this->color['link'],
			'background' => $this->color['link'],
		));

		// Add multiple properties at once.
		$this->css->set_selector('#pagination .nav-links a:hover');
		$this->css->add_properties(array(
			'color' => COLOR['white'],
			'background' => $this->color['hover'],
		));

		// Add multiple properties at once.
		$this->css->set_selector('#pagination .nav-links .current');
		$this->css->add_properties(array(
			'color' => $this->color['link'],
			'background' => $this->color['hover'],
		));

	}// Method


	/**
		@access (private)
			The inline css for the "Circle" style.
		@return (string)
			_filter[_inline_pagination][circle]
		@reference
			[Parent]/inc/setup/constant.php
			[Parent]/inc/utility/general.php
			[Parent]/model/app/pagination.php
	*/
	private function get_circle()
	{
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		// Add a single property.
		// $this->css->set_selector('#pagination .nav-links li');
		// $this->css->add_property('border-radius','50%');

		// Add multiple properties at once.
		$this->css->set_selector('#pagination .nav-links .active');
		$this->css->add_properties(array(
			'color' => COLOR['white'],
			'border' => '1px solid ' . $this->color['link'],
		));

		// Add multiple properties at once.
		$this->css->set_selector('#pagination .nav-links .active:hover');
		$this->css->add_properties(array(
			'color' => $this->color['hover'],
			'border' => '1px solid ' . $this->color['hover'],
		));

		// Add multiple properties at once.
		$this->css->set_selector('#pagination .nav-links a');
		$this->css->add_properties(array(
			'color' => COLOR['white'],
			'border' => '1px solid ' . $this->color['link'],
			'border-radius' => '50%',
			'background' => $this->color['link'],
		));

		// Add multiple properties at once.
		$this->css->set_selector('#pagination .nav-links a:hover');
		$this->css->add_properties(array(
			'color' => COLOR['white'],
			'background' => $this->color['hover'],
		));

		// Add multiple properties at once.
		$this->css->set_selector('#pagination .nav-links .current');
		$this->css->add_properties(array(
			'color' => $this->color['link'],
			'background' => $this->color['hover'],
		));

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
				[Parent]/model/app/pagination.php
		*/
		return self::$_style;

	}// Method


}// Class
endif;
// new _inline_pagination();
_inline_pagination::__get_instance();
