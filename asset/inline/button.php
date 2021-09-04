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
if(class_exists('_inline_button') === FALSE) :
class _inline_button
{
/**
 * [TOC]
 * 	__get_instance()
 * 	__construct()
 * 	set_effect()
 * 	set_color()
 * 	set_theme_mod()
 * 	set_skin()
 * 	get_common()
 * 	get_fade_background()
 * 	get_split_horizonal()
 * 	get_split_vertical()
 * 	get_horizonal_flip()
 * 	get_vertical_flip()
 * 	get_cover_close()
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
		@var (string) $exception
			CSS that PHP_CSS plugin can not handle.
		@var (string) $_style
			Dynamic/Iinline css of theme style components.
	*/
	private static $_class = '';
	private static $_index = '';
	private $effect = array();
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
	private function set_effect()
	{
		/**
			@access (private)
				Set several hover effect for button.
				https://www.nxworld.net/tips/css-only-button-design-and-hover-effects.html
			@return (array)
				_filter[_inline_button][effect]
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
			'fade-background' => 'fade_background',
			'split-horizonal' => 'split_horizonal',
			'split-vertical' => 'split_vertical',
			'flip-horizonal' => 'flip_horizonal',
			'flip-vertical'	 => 'flip_vertical',
			'cover-close' => 'cover_close',
			'is-reflection' => 'is_reflection',
		));

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
				_filter[_inline_button][theme_mod]
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
			__utility_get_option('skin_button_primary'),
			__utility_get_option('skin_button_secondary'),
			__utility_get_option('skin_button_tertiary'),
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
				_filter[_inline_button][style]
			@reference
				[Parent]/inc/trait/theme.php
				[Parent]/inc/utility/general.php
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		// $this->get_common();

		foreach((array)$this->theme_mod as $key){
			if(array_key_exists($key,$this->effect)){
				$method = 'get_' . $this->effect[$key];
				if(is_callable([$this,$method])){
				call_user_func([$this,$method]);
				}
			}
		}

		/**
		 * @reference (Beans)
		 * 	Call the functions added to a filter hook.
		 * 	https://www.getbeans.io/code-reference/functions/beans_apply_filters/
		*/
		return beans_apply_filters("_filter[{$class}][{$function}]",$this->minify($this->exception . $this->css->css_output()));

	}// Method


	/**
		@access (private)
			The inline css for the button base.
		@return (string)
			_filter[_inline_button][common]
		@reference
			[Parent]/inc/utility/general.php
			[Parent]/inc/utility/theme.php
	*/
	private function get_common()
	{
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		// Add multiple properties at once.
		$this->css->set_selector('a.button');
		$this->css->add_properties(array(
			'margin' => '1rem auto',
			'position' => 'absolute',
			'bottom' => '0',
			'right' => '0',
		));

	}// Method


	/**
		@access (private)
			The inline css for the "Fade Background" effect.
			https://tamatuf.net/html-css/css-hover-button/
		@return (string)
			_filter[_inline_button][fade_background]
		@reference
			[Parent]/inc/setup/constant.php
			[Parent]/inc/utility/general.php
	*/
	private function get_fade_background()
	{
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		if(!in_array(str_replace('_','-',$function),$this->theme_mod)){return;}

		// Add multiple properties at once.
		$this->css->set_selector('.fade-background');
		$this->css->add_properties(array(
			'color' => COLOR['white'],
			'background' => $this->color['link'],
			'padding' => '0.25rem 2.5rem',
			'transition' => '0.3s',
		));

		// Add multiple properties at once.
		$this->css->set_selector('.fade-background:hover');
		$this->css->add_properties(array(
			'color' => COLOR['white'],
			'background' => COLOR['hover'],
			'opacity' => '0.9',
		));

	}// Method


	/**
		@access (private)
			The inline css for the "'Sprit Horizonal" effect.
			https://tamatuf.net/html-css/css-hover-button/
		@return (string)
			_filter[_inline_button][split_horizonal]
		@reference
			[Parent]/inc/setup/constant.php
			[Parent]/inc/utility/general.php
	*/
	private function get_split_horizonal()
	{
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		if(!in_array(str_replace('_','-',$function),$this->theme_mod)){return;}

		// Add multiple properties at once.
		$this->css->set_selector('.split-horizonal');
		$this->css->add_properties(array(
			'color' => $this->color['link'],
			'background' => 'transparent',
			'width' => '10rem',
			'height' => '3rem',
			'text-align' => 'center',
			'line-height' => '3rem',
			'border' => '1px solid ' . $this->color['link'],
			'position' => 'relative',
			'z-index' => '1',
			'display' => 'block',
			'overflow' => 'hidden',
			'transition' => '0.3s',
		));

		// Add multiple properties at once.
		$this->css->set_selector('.split-horizonal::before,.split-horizonal::after');
		$this->css->add_properties(array(
			'content' => '""',
			'width' => '100%',
			'position' => 'absolute',
			'top' => '0',
			'z-index' => '-1',
			'transition' => 'transform ease 0.3s',
		));

		// Add multiple properties at once.
		$this->css->set_selector('.split-horizonal::before');
		$this->css->add_properties(array(
			'right' => '-3rem',
			'border-right' => '3rem solid transparent',
			'border-bottom' => '3rem solid ' . $this->color['link'],
			'transform' => 'translateX(-100%)',
		));

		// Add multiple properties at once.
		$this->css->set_selector('.split-horizonal::after');
		$this->css->add_properties(array(
			'left' => '-3rem',
			'border-left' => '3rem solid transparent',
			'border-top' => '3rem solid ' . $this->color['link'],
			'transform' => 'translateX(100%)',
		));

		// Add a single property.
		$this->css->set_selector('.split-horizonal:hover');
		$this->css->add_property('color',COLOR['white']);

		// Add a single property.
		$this->css->set_selector('.split-horizonal:hover::before');
		$this->css->add_property('transform','translateX(-49%)');

		// Add a single property.
		$this->css->set_selector('.split-horizonal:hover::after');
		$this->css->add_property('transform','translateX(49%)');

	}// Method


	/**
		@access (public)
			The inline css for the "'Sprit Vertical" effect.
			https://tamatuf.net/html-css/css-hover-button/
		@return (string)
			_filter[_inline_button][split_vertical]
		@reference
			[Parent]/inc/setup/constant.php
			[Parent]/inc/utility/general.php
	*/
	private function get_split_vertical()
	{
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		if(!in_array(str_replace('_','-',$function),$this->theme_mod)){return;}

		// Add multiple properties at once.
		$this->css->set_selector('.split-vertical');
		$this->css->add_properties(array(
			'color' => $this->color['link'],
			'background' => 'transparent',
			'width' => '10rem',
			'height' => '3rem',
			'text-align' => 'center',
			'line-height' => '3rem',
			'border' => '1px solid ' . $this->color['link'],
			'position' => 'relative',
			'z-index' => '1',
			'display' => 'block',
			'overflow' => 'hidden',
			'transition' => '0.3s',
		));

		// Add multiple properties at once.
		$this->css->set_selector('.split-vertical::before');
		$this->css->add_properties(array(
			'content' => '""',
			'width' => '100%',
			'position' => 'absolute',
			'top' => '0',
			'right' => '-3rem',
			'z-index' => '-1',
			'border-right' => '3rem solid transparent',
			'border-bottom' => '3rem solid ' . $this->color['link'],
			'transform' => 'translateX(-100%)',
			'transition' => 'transform ease 0.3s',
		));

		// Add a single property.
		$this->css->set_selector('.split-vertical:hover');
		$this->css->add_property('color',COLOR['white']);

		// Add a single property.
		$this->css->set_selector('.split-vertical:hover::before');
		$this->css->add_property('transform','translateX(0)');

	}// Method


	/**
		@access (public)
			The inline css for the "'Flip Horizonal" effect.
			https://tamatuf.net/html-css/css-hover-button/
		@return (string)
			_filter[_inline_button][flip_horizonal]
		@reference
			[Parent]/inc/setup/constant.php
			[Parent]/inc/utility/general.php
	*/
	private function get_flip_horizonal()
	{
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		if(!in_array(str_replace('_','-',$function),$this->theme_mod)){return;}

		// Add multiple properties at once.
		$this->css->set_selector('.flip-horizonal');
		$this->css->add_properties(array(
			'color' => $this->color['link'],
			'background' => 'transparent',
			'padding' => '0.25rem 2.5rem',
			'border' => '1px solid ' . $this->color['link'],
			'position' => 'relative',
			'z-index' => '1',
			'transition' => '0.3s',
		));

		// Add a single property.
		$this->css->set_selector('.flip-horizonal:hover');
		$this->css->add_property('color',COLOR['white']);

		// Add multiple properties at once.
		$this->css->set_selector('.flip-horizonal::before');
		$this->css->add_properties(array(
			'content' => '""',
			'width' => '100%',
			'height' => '100%',
			'position' => 'absolute',
			'top' => '0',
			'left' => '0',
			'z-index' => '-1',
			'background' => $this->color['link'],
			'transform-origin' => '100% 50%',
			'transform' => 'scaleX(0)',
			'transition' => 'transform ease 0.3s',
		));

		// Add multiple properties at once.
		$this->css->set_selector('.flip-horizonal:hover::before');
		$this->css->add_properties(array(
			'transform-origin' => '0% 50%',
			'transform' => 'scaleX(1)',
		));

	}// Method


	/**
		@access (public)
			The inline css for the "'Frip Vertical" effect.
			https://tamatuf.net/html-css/css-hover-button/
		@return (string)
			_filter[_inline_button][flip_vertical]
		@reference
			[Parent]/inc/setup/constant.php
			[Parent]/inc/utility/general.php
	*/
	private function get_flip_vertical()
	{
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		if(!in_array(str_replace('_','-',$function),$this->theme_mod)){return;}

		// Add multiple properties at once.
		$this->css->set_selector('.flip-vertical');
		$this->css->add_properties(array(
			'color' => $this->color['link'],
			'background' => 'transparent',
			'padding' => '0.25rem 2.5rem',
			'border' => '1px solid ' . $this->color['link'],
			'position' => 'relative',
			'z-index' => '1',
			'transition' => '0.3s',
		));

		// Add a single property.
		$this->css->set_selector('.flip-vertical:hover');
		$this->css->add_property('color',COLOR['white']);

		// Add multiple properties at once.
		$this->css->set_selector('.flip-vertical::before');
		$this->css->add_properties(array(
			'content' => '""',
			'width' => '100%',
			'height' => '100%',
			'position' => 'absolute',
			'top' => '0',
			'left' => '0',
			'z-index' => '-1',
			'background' => $this->color['link'],
			'transform-origin' => '50% 0%',
			'transform' => 'scaleY(0)',
			'transition' => 'transform ease 0.3s',
		));

		// Add multiple properties at once.
		$this->css->set_selector('.flip-vertical:hover::before');
		$this->css->add_properties(array(
			'transform-origin' => '50% 100%',
			'transform' => 'scaleY(1)',
		));

	}// Method


	/**
		@access (public)
			The inline css for the "'Cover Close" effect.
			https://tamatuf.net/html-css/css-hover-button/
		@return (string)
			_filter[_inline_button][cover_close]
		@reference
			[Parent]/inc/setup/constant.php
			[Parent]/inc/utility/general.php
	*/
	private function get_cover_close()
	{
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		if(!in_array(str_replace('_','-',$function),$this->theme_mod)){return;}

		// Add multiple properties at once.
		$this->css->set_selector('.cover-close');
		$this->css->add_properties(array(
			'color' => COLOR['white'],
			'background' => 'transparent',
			'padding' => '0.25rem 2.5rem',
			'border' => '1px solid ' . $this->color['link'],
			'box-sizing' => 'border-box',
			'position' => 'relative',
			'z-index' => '1',
			'display' => 'inline-block',
			'transition' => '0.3s',
		));

		// Add multiple properties at once.
		$this->css->set_selector('.cover-close::before,.cover-close::after');
		$this->css->add_properties(array(
			'content' => '""',
			'width' => '100%',
			'height' => '100%',
			'position' => 'absolute',
			'top' => '0',
			'left' => '0',
		));

		// Add multiple properties at once.
		$this->css->set_selector('.cover-close::before');
		$this->css->add_properties(array(
			'background' => $this->color['link'],
			'z-index' => '-1',
			'transition' => 'transform ease 0.3s',
			'opacity' => '0.3s',
		));

		// Add multiple properties at once.
		$this->css->set_selector('.cover-close::after');
		$this->css->add_properties(array(
			'border' => '1px solid ' . $this->color['link'],
			'box-sizing' => 'border-box',
		));

		// Add a single property.
		$this->css->set_selector('.cover-close:hover');
		$this->css->add_property('color',$this->color['link']);

		// Add multiple properties at once.
		$this->css->set_selector('.cover-close:hover::before');
		$this->css->add_properties(array(
			'transform' => 'scale(0)',
			'opacity' => '0',
		));

	}// Method


	/**
		@access (private)
			The inline css for the "'Reflection" effect.
		@return (string)
			_filter[_inline_button][is_reflection]
		@reference
			[Parent]/inc/setup/constant.php
			[Parent]/inc/utility/general.php
	*/
	private function get_is_reflection()
	{
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		if(!in_array(str_replace('_','-',$function),$this->theme_mod)){return;}

		$return = '';
		$return .= '.is-reflection{position: relative;display: block;width: 100%;height: 3rem;line-height: 3rem;text-align: center;	text-decoration: none;color: ' . COLOR['white'] . ';background: ' . $this->color['link'] . ';overflow: hidden;}';
		$return .= '.is-reflection::after{content: "";position: absolute;top: -8rem;left: -8rem;width: 4rem;height: 4rem;background-image: linear-gradient(100deg,  rgba(255, 255, 255, 0) 10%, rgba(255, 255, 255, 1) 100%, rgba(255, 255, 255, 0) 0%);animation-name: shine;animation-duration: 3s;animation-timing-function: ease-in-out;animation-iteration-count: infinite;}';
		$return .= '@keyframes shine{';
		$return .= '0%{transform: scale(0) rotate(25deg);opacity: 0;}';
		$return .= '50%{transform: scale(1) rotate(25deg);opacity: 1;}';
		$return .= '100%{transform: scale(50) rotate(25deg);opacity: 0;}';
		$return .= '}';

		/**
		 * @reference (Beans)
		 * 	Call the functions added to a filter hook.
		 * 	https://www.getbeans.io/code-reference/functions/beans_apply_filters/
		*/
		$this->exception = beans_apply_filters("_filter[{$class}][{$function}]",$return);

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
				[Parent]/controller/fragment/excerpt.php
				[Parent]/model/app/excerpt.php
				[Parent]/inc/env/excerpt.php
		*/
		return self::$_style;

	}// Method


}// Class
endif;
// new _inline_button();
_inline_button::__get_instance();
