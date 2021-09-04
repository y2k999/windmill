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
if(class_exists('_inline_follow') === FALSE) :
class _inline_follow
{
/**
 * [TOC]
 * 	__get_instance()
 * 	__construct()
 * 	set_sns()
 * 	set_effect()
 * 	set_color()
 * 	set_theme_mod()
 * 	set_style()
 * 	get_common()
 * 	get_rectangle_1()
 * 	get_square_1()
 * 	get_circle_1()
 * 	get_flat_1()
 * 	__get_setting()
*/

	/**
		@access (private)
			Class properties.
		@var (string) $_class
			Name/Identifier with prefix.
		@var (string) $_index
			Name/Identifier without prefix.
		@var (array) $sns
			SNS follow services.
		@var (array) $effect
			Styles and hover effects.
		@var (array) $theme_mod
			Theme customizer settings.
		@var (array) $color
			Main colors for this theme.
		@var (null) $css
			Streams for the current css instance.
		@var (string) $_style
			Iinline css of theme style components.
	*/
	private static $_class = '';
	private static $_index = '';
	private $sns = array();
	private $effect = array();
	private $color = array();
	private $theme_mod = '';
	private $css = NULL;
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
		$this->sns = $this->set_sns();
		$this->effect = $this->set_effect();
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
	private function set_sns()
	{
		/**
			@access (private)
				Set SNS follow service that need the inline css.
				https://fit-jp.com/sharebtn/
			@return (array)
				_filter[_inline_follow][sns]
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
		return beans_apply_filters("_filter[{$class}][{$function}]",__utility_get_value(self::$_index));

	}// Method


	/* Setter
	_________________________
	*/
	private function set_effect()
	{
		/**
			@access (private)
				Set several styles/effects for SNS follow button.
			@return (array)
				_filter[_inline_follow][effect]
			@reference
				[Parent]/inc/customizer/callback.php
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
			'rectangle-1' => 'rectangle_1',
			'square-1' => 'square_1',
			'circle-1' => 'circle_1',
			'flat-1' => 'flat_1',
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
				_filter[_inline_follow][theme_mod]
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
		return beans_apply_filters("_filter[{$class}][{$function}]",__utility_get_option('skin_sns_follow'));

	}// Method


	/* Setter
	_________________________
	*/
	private function set_style()
	{
		/**
			@access (private)
				Set the inline css of theme SNS follow button.
			@return (string)
				_filter[_inline_follow][style]
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
		@access (public)
			The inline css for the SNS follow button base.
		@return (string)
			_filter[_inline_follow][common]
		@reference
			[Parent]/inc/setup/constant.php
			[Parent]/inc/utility/general.php
	*/
	private function get_common()
	{
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		$return = '';
		foreach($this->sns as $item){
			// Add a single property.
			$this->css->set_selector('.follow .follow-' . $item);
			$this->css->add_property('background',COLOR[$item]);

			// Add a single property.
			$this->css->set_selector('.follow .follow-' . $item . ':hover');
			$this->css->add_property('background',COLOR[$item . '-hover']);
		}

	}// Method


	/**
		@access (private)
			The inline css for the "Rectangle" style.
			https://www.foxism.jp/entry/2017/04/23/204104
		@return (string)
			_filter[_inline_follow][rectangle_1]
		@reference
			[Parent]/inc/setup/constant.php
			[Parent]/inc/utility/general.php
	*/
	private function get_rectangle_1()
	{
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		if($this->theme_mod !== str_replace('_','-',$function)){return;}

		// Add multiple properties at once.
		$this->css->set_selector('.follow .rectangle-1');
		$this->css->add_properties(array(
			'display' => 'flex',
			'justify-content' => 'space-between',
			'margin' => '1rem auto',
			'margin-right' => '1px',
		));

		// Add multiple properties at once.
		$this->css->set_selector('.follow .rectangle-1 a');
		$this->css->add_properties(array(
			'display' => 'block',
			'width' => '22.5%',
			'line-height' => '2',
			'text-align' => 'center',
			'font-size' => FONT['xsmall'],
			'border-radius' => '1.5rem',
			'position' => 'relative',
			'transition' => '0.3s',
			'padding' => '0.25rem',
			'vertical-align' => 'middle',
		));

		// Add multiple properties at once.
		$this->css->set_selector('.follow .rectangle-1 a .icon');
		$this->css->add_properties(array(
			'display' => 'inline-block',
			'vertical-align' => 'middle',
			'color' => COLOR['white'] . ' !important',
		));

		// Add a single property.
		$this->css->set_selector('.follow .rectangle-1 a .icon::before');
		$this->css->add_property('margin','0');

	}// Method


	/**
		@access (public)
			The inline css for the "Square" style.
		@return (string)
			_filter[_inline_follow][square_1]
		@reference
			[Parent]/inc/setup/constant.php
			[Parent]/inc/utility/general.php
			[Parent]/inc/utility/theme.php
	*/
	private function get_square_1()
	{
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		if($this->theme_mod !== str_replace('_','-',$function)){return;}

		// Add multiple properties at once.
		$this->css->set_selector('.follow .square-1');
		$this->css->add_properties(array(
			'margin' => '1rem auto',
			'text-align' => 'center',
		));

		// Add multiple properties at once.
		$this->css->set_selector('.follow .square-1 a');
		$this->css->add_properties(array(
			'display' => 'inline-block',
			'width' => '3.6rem',
			'height' => '3.6rem',
			'margin' => '0 0.4rem 0 0',
			'line-height' => '3.6rem',
			'text-align' => 'center',
			'box-shadow' => '0.3rem 0.4rem rgba(0,0,0,0.1)',
			'transition' => '0.3s',
			'position' => 'relative',
		));

		// Add multiple properties at once.
		$this->css->set_selector('.follow .square-1 .icon:before');
		$this->css->add_properties(array(
			'margin' => '0',
			'display' => 'inline-block',
			'font-size' => FONT['xsmall'],
			'line-height' => '3.6rem',
		));

		// Add multiple properties at once.
		$this->css->set_selector('.follow .square-1 .icon');
		$this->css->add_properties(array(
			'vertical-align' => 'middle',
			'color' => COLOR['white'] . '!important',
		));

		// Add multiple properties at once.
		$this->css->set_selector('.follow .square-1 a:hover');
		$this->css->add_properties(array(
			'box-shadow' => '0.4rem 0.4rem rgba(0,0,0,0.2)',
			'margin' => '0 0.5rem 0 -1px',
		));

	}// Method


	/**
		@access (public)
			The inline css for the "Circle" style.
		@return (string)
			_filter[_inline_follow][circle_1]
		@reference
			[Parent]/inc/setup/constant.php
			[Parent]/inc/utility/general.php
			[Parent]/inc/utility/theme.php
	*/
	private function get_circle_1()
	{
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		if($this->theme_mod !== str_replace('_','-',$function)){return;}

		// Add multiple properties at once.
		$this->css->set_selector('.follow .circle-1');
		$this->css->add_properties(array(
			'color' => $this->color['hover'],
			'margin' => '1rem auto',
			'text-align' => 'center',
		));

		// Add multiple properties at once.
		$this->css->set_selector('.follow .circle-1 a');
		$this->css->add_properties(array(
			'display' => 'inline-block',
			'width' => '3.6rem',
			'height' => '3.6rem',
			'margin' => '0 0.2rem 0 0',
			'line-height' => '3.6rem',
			'text-align' => 'center',
			'border-radius' => '50%',
		));

		// Add multiple properties at once.
		$this->css->set_selector('.follow .circle-1 .icon');
		$this->css->add_properties(array(
			'vertical-align' => 'middle',
			'color' => COLOR['white'] . ' !important',
		));

	}// Method


	/**
		@access (public)
			The inline css for the "Flat" style.
		@return (string)
			_filter[_inline_follow][flat_1]
		@reference
			[Parent]/inc/setup/constant.php
			[Parent]/inc/utility/general.php
			[Parent]/inc/utility/theme.php
	*/
	private function get_flat_1()
	{
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		if($this->theme_mod !== str_replace('_','-',$function)){return;}

		// Add multiple properties at once.
		$this->css->set_selector('.follow .flat-1');
		$this->css->add_properties(array(
			'margin' => '1rem auto',
			'text-align' => 'center',
		));

		// Add multiple properties at once.
		$this->css->set_selector('.follow .flat-1 a');
		$this->css->add_properties(array(
			'display' => 'inline-block',
			'width' => '3rem',
			'height' => '3rem',
			'font-size' => FONT['xsmall'],
			'position' => 'relative',
			'border-radius' => '0.5rem',
			'box-shadow' => '0.3rem 0.5rem 0 rgba(0,0,0,0.35)',
			'margin' => '0.2rem',
			'transition' => 'all 0.2s',
			'overflow' => 'hidden',
		));

		// Add multiple properties at once.
		$this->css->set_selector('.follow .flat-1 a .icon');
		$this->css->add_properties(array(
			'position' => 'absolute',
			'top' => '30%',
			'left' => '50%',
			'transform' => 'translateX(-50%)',
			'color' => COLOR['white'] . ' !important',
		));

		// Add multiple properties at once.
		$this->css->set_selector('.follow .flat-1 a:hover');
		$this->css->add_properties(array(
			'transform' => 'scale(1.2)',
			'box-shadow' => '0 0.3125em 0.9375em 0 rgba(0,0,0,0.4)',
		));

		// Add multiple properties at once.
		$this->css->set_selector('.follow .flat-1 a:active');
		$this->css->add_properties(array(
			'transform' => 'scale(0.9)',
			'box-shadow' => '0 0.125em 0.1875em 0 rgba(0,0,0,0.4)',
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
				[Parent]/model/app/follow.php
				[Parent]/model/widget/profile.php
		*/
		return self::$_style;

	}// Method


}// Class
endif;
// new _inline_follow();
_inline_follow::__get_instance();
