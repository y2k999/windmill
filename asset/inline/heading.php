+<?php
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
if(class_exists('_inline_heading') === FALSE) :
class _inline_heading
{
/**
 * [TOC]
 * 	__get_instance()
 * 	__construct()
 * 	set_type()
 * 	set_color()
 * 	set_theme_mod()
 * 	set_style()
 * 	get_page_title()
 * 	get_post_title()
 * 	get_item_title()
 * 	get_widget_title()
 * 	get_site_origin()
 * 	get_border_bottom_1()
 * 	get_border_left_bottom()
 * 	get_left_mark_1()
 * 	get_fill_1()
 * 	get_maker_1()
 * 	get_fade_1()
 * 	__get_setting()
*/

	/**
		@access (private)
			Class properties.
		@var (string) $_class
			Name/Identifier with prefix.
		@var (string) $_index
			Name/Identifier without prefix.
		@var (array) $type
			Type of titles/headings.
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
	private $type = array();
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
		$this->type = $this->set_type();
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
	private function set_type()
	{
		/**
			@access (private)
				Set the type of titles/headings that need the inline css.
			@return (array)
				_filter[_inline_heading][type]
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
			'page_title' => 'page-title',
			'post_title' => 'post-title',
			'item_title' => 'item-title',
			'widget_title' => 'widget-title',
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
				https://www.nxworld.net/50-css-heading-styling.html
			@return (array)
				_filter[_inline_heading][theme_mod]
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
			'page_title' => __utility_get_option('skin_heading_page-title'),
			'post_title' => __utility_get_option('skin_heading_post-title'),
			'item_title' => __utility_get_option('skin_heading_item-title'),
			'widget_title' => __utility_get_option('skin_heading_widget-title'),
		));

	}// Method


	/* Setter
	_________________________
	*/
	private function set_style()
	{
		/**
			@access (private)
				Set the inline css of theme titles/headings.
			@return (string)
				_filter[_inline_heading][style]
			@reference
				[Parent]/inc/trait/theme.php
				[Parent]/inc/utility/general.php
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		foreach($this->type as $key => $value){
			$method = 'get_' . $key;
			if(is_callable([$this,$method])){
				call_user_func([$this,$method]);
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
			The inline css for the page title.
		@return (string)
			_filter[_inline_heading][page_title]
		@reference
			[Parent]/inc/utility/general.php
	*/
	private function get_page_title()
	{
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		$method = 'get_' . str_replace('-','_',$this->theme_mod[$function]);
		if(is_callable([$this,$method])){
			call_user_func([$this,$method],$this->type[$function]);
		}

	}// Method


	/**
		@access (private)
			The inline css for the post title.
		@return (string)
			_filter[_inline_heading][post_title]
		@reference
			[Parent]/inc/utility/general.php
	*/
	private function get_post_title()
	{
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		$method = 'get_' . str_replace('-','_',$this->theme_mod[$function]);
		if(is_callable([$this,$method])){
			call_user_func([$this,$method],$this->type[$function]);
		}

	}// Method


	/**
		@access (public)
			The inline css for the item title (archive list title).
		@return (string)
			_filter[_inline_heading][item_title]
		@reference
			[Parent]/inc/utility/general.php
	*/
	private function get_item_title()
	{
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		$method = 'get_' . str_replace('-','_',$this->theme_mod[$function]);
		if(is_callable([$this,$method])){
			call_user_func([$this,$method],$this->type[$function]);
		}

	}// Method


	/**
		@access (public)
			The inline css for the widget title.
		@return (string)
			_filter[_inline_heading][widget_title]
	*/
	private function get_widget_title()
	{
		$class = self::$_class;
		// $function = __utility_get_function(__FUNCTION__);
		$function = 'widget_title';

		$method = 'get_' . str_replace('-','_',$this->theme_mod[$function]);
		if(is_callable([$this,$method])){
			call_user_func([$this,$method],$this->type[$function]);
		}

	}// Method


	/**
		@access (private)
			The inline css for the "Site Origin" style.
			https://siteorigin.com/theme/
		@param (string) $type
		@return (string)
			_filter[_inline_heading][site_origin]
		@reference
			[Parent]/inc/utility/general.php
	*/
	private function get_site_origin($type)
	{
		if(!isset($type)){return;}

		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		if(!in_array(str_replace('_','-',$function),$this->theme_mod)){return;}

		$param = '.' . $type;

		// Add multiple properties at once.
		$this->css->set_selector($param);
		$this->css->add_properties(array(
			'position' => 'relative',
			'margin' => '1rem auto',
			'padding' => '1rem',
			'text-indent' => '3rem',
			'color' => $this->color['link'],
			'border-bottom' => 'solid 1px ' . $this->color['link'],
			'max-width' => '100%',
		));

		// Add a single property.
		$this->css->set_selector($param . ' a');
		$this->css->add_property('color',$this->color['link']);

		// Add multiple properties at once.
		$this->css->set_selector($param . '::before');
		$this->css->add_properties(array(
			'content' => '"□"',
			'padding' => '0.5rem',
			'position' => 'absolute',
			'left' => '-2.5rem',
			'top' => '0.15rem',
			'color' => $this->color['link'],
		));

		// Add multiple properties at once.
		$this->css->set_selector($param . '::after');
		$this->css->add_properties(array(
			'content' => '"□"',
			'padding' => '0.5rem',
			'position' => 'absolute',
			'left' => '-2rem',
			'top' => '0.65rem',
			'color' => $this->color['link'],
		));

		// Add multiple properties at once.
		$this->css->set_selector($param . ':hover');
		$this->css->add_properties(array(
			'color' => $this->color['link'],
			'opacity' => '0.7',
			'transition' => '0.8s',
		));

	}// Method


	/**
		@access (private)
			The inline css for the "Underline" style.
		@param (string) $type
		@return (string)
			_filter[_inline_heading][border_bottom_1]
		@reference
			[Parent]/inc/setup/constant.php
			[Parent]/inc/utility/general.php
	*/
	private function get_border_bottom_1($type)
	{
		if(!isset($type)){return;}

		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		if(!in_array(str_replace('_','-',$function),$this->theme_mod)){return;}

		$param = '.' . $type;

		// Add multiple properties at once.
		$this->css->set_selector($param);
		$this->css->add_properties(array(
			'margin' => '0.5rem auto',
			'padding' => '0.5rem',
			'border-bottom' => '1px solid ' . COLOR['border'],
		));

	}// Method


	/**
		@access (private)
			The inline css for the "Left border and Underline" style.
		@param (string) $type
		@return (string)
			_filter[_inline_heading][border_left_bottom]
		@reference
			[Parent]/inc/setup/constant.php
			[Parent]/inc/utility/general.php
	*/
	private function get_border_left_bottom($type)
	{
		if(!isset($type)){return;}

		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		if(!in_array(str_replace('_','-',$function),$this->theme_mod)){return;}

		$param = '.' . $type;

		// Add multiple properties at once.
		$this->css->set_selector($param);
		$this->css->add_properties(array(
			'position' => 'relative',
			'padding' => '0.25em 0 0.5em 0.75em',
			'border-left' => '0.6rem solid ' . $this->color['hover'],
		));

		// Add multiple properties at once.
		$this->css->set_selector($param . '::after');
		$this->css->add_properties(array(
			'position' => 'absolute',
			'left' => '0',
			'bottom' => '0',
			'content' => '""',
			'width' => '100%',
			'height' => '0',
			'border-bottom' => '1px solid ' . COLOR['hover'],
		));

	}// Method


	/**
		@access (private)
			The inline css for the "Symbol" style.
		@param (string) $type
		@return (string)
			_filter[_inline_heading][left_mark_1]
		@reference
			[Parent]/inc/utility/general.php
	*/
	private function get_left_mark_1($type)
	{
		if(!isset($type)){return;}

		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		if(!in_array(str_replace('_','-',$function),$this->theme_mod)){return;}

		$param = '.' . $type;

		// Add multiple properties at once.
		$this->css->set_selector($param);
		$this->css->add_properties(array(
			'position' => 'relative',
			'padding' => '0 .5em 0.5em 1.7em',
			'border-bottom' => '1px solid ' . $this->color['hover'],
		));

		// Add multiple properties at once.
		$this->css->set_selector($param . '::after');
		$this->css->add_properties(array(
			'position' => 'absolute',
			'top' => '0.4rem',
			'left' => '0.4rem',
			'z-index' => '2',
			'content' => '""',
			'width' => '1.2rem',
			'height' => '1.2rem',
			'background' => $this->color['hover'],
			'transform' => 'rotate(45deg)',
		));

	}// Method


	/**
		@access (private)
			The inline css for the "Fill" style.
		@param (string) $type
		@return (string)
			_filter[_inline_heading][fill_1]
		@reference
			[Parent]/inc/setup/constant.php
			[Parent]/inc/utility/general.php
	*/
	private function get_fill_1($type)
	{
		if(!isset($type)){return;}

		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		if(!in_array(str_replace('_','-',$function),$this->theme_mod)){return;}

		$param = '.' . $type;

		// Add multiple properties at once.
		$this->css->set_selector($param);
		$this->css->add_properties(array(
			'padding' => '0.5em 0.75em',
			'color' => COLOR['white'],
			'background' => $this->color['link'],
		));

	}// Method


	/**
		@access (private)
			The inline css for the "Highlighter" style.
		@param (string) $type
		@return (string)
			_filter[_inline_heading][maker_1]
		@reference
			[Parent]/inc/setup/constant.php
			[Parent]/inc/utility/general.php
	*/
	private function get_maker_1($type)
	{
		if(!isset($type)){return;}

		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		if(!in_array(str_replace('_','-',$function),$this->theme_mod)){return;}

		$param = '.' . $type;

		// Add multiple properties at once.
		$this->css->set_selector($param);
		$this->css->add_properties(array(
			'padding' => '0.2em',
			'background' => 'linear-gradient(transparent 70%,' . COLOR['white'] . '100/70%)',
		));

	}// Method


	/**
		@access (private)
			The inline css for the "Fade" style.
		@param (string) $type
		@return (string)
			_filter[_inline_heading][fade_1]
		@reference
			[Parent]/inc/customizer/option.php
			[Parent]/inc/utility/general.php
	*/
	private function get_fade_1($type)
	{
		if(!isset($type)){return;}

		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		if(!in_array(str_replace('_','-',$function),$this->theme_mod)){return;}

		$param = '.' . $type;

		// Add multiple properties at once.
		$this->css->set_selector($param);
		$this->css->add_properties(array(
			'position' => 'relative',
			'width' => '100%',
			'margin' => '1rem auto',
			'padding' => '1rem 0',
			'color' => $this->color['link'],
			'text-align' => 'center',
			'font-family' => __utility_get_value('font_primary'),
		));

		// Add multiple properties at once.
		$this->css->set_selector($param . ':hover');
		$this->css->add_properties(array(
			'color' => $this->color['hover'],
			'opacity' => '0.7',
			'transition' => '0.8s',
		));

		$return = '';
		$return .= $param . '::before{content: ""; position: absolute; bottom: 0; left: 0; right: 0; width: 100%; height: 1px; margin: 0 auto; text-align: center; background-image: linear-gradient(to right, transparent,' . $this->color['link'] . ' 25%,' . $this->color['link'] . ' 75%,transparent); background-position: center; background-repeat: no-repeat;}';

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
				[Parent]/controller/fragment/title.php
				[Parent]/inc/trait/theme.php
				[Parent]/model/app/title.php
		*/
		return self::$_style;

	}// Method


}// Class
endif;
// new _inline_heading();
_inline_heading::__get_instance();
