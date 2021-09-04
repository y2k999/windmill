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
if(class_exists('_inline_share') === FALSE) :
class _inline_share
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
 * 	get_shape_1()
 * 	get_shape_2()
 * 	get_stylish_1()
 * 	get_stylish_2()
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
			SNS share services.
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
	private function set_sns()
	{
		/**
			@access (private)
				Set SNS share service that need the inline css.
			@return (array)
				_filter[_inline_share][sns]
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
				Set several styles/effects for SNS share button.
			@return (array)
				_filter[_inline_share][effect]
			@reference
				 - Stinger
				 - Circle
				 - Monotone
				 - Postit
				 - Cube
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
			'shape-1' => 'shape_1',
			'shape-2' => 'shape_2',
			'stylish-1' => 'stylish_1',
			'stylish-2' => 'stylish_2',
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
				_filter[_inline_share][theme_mod]
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
		return beans_apply_filters("_filter[{$class}][{$function}]",__utility_get_option('skin_sns_share'));

	}// Method


	/* Setter
	_________________________
	*/
	private function set_style()
	{
		/**
			@access (private)
				Set the inline css of theme SNS share button.
			@return (string)
				_filter[_inline_share][style]
			@reference
				[Parent]/inc/trait/theme.php
				[Parent]/inc/utility/general.php
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

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
			The inline css for the "Square" style.
		@return (string)
			_filter[_inline_share][shape_1]
		@reference
			[Parent]/controller/fragment/share.php
			[Parent]/inc/setup/constant.php
			[Parent]/inc/utility/general.php
			[Parent]/inc/utility/theme.php
			[Parent]/model/app/share.php
	*/
	private function get_shape_1()
	{
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		if($this->theme_mod !== str_replace('_','-',$function)){return;}

		// Add multiple properties at once.
		$this->css->set_selector('.share .shape-1 a');
		$this->css->add_properties(array(
			'display' => 'inline-block',
			'color' => COLOR['white'],
			'font-size' => FONT['xlarge'],
			'height' => '2.5em',
			'width' => '2.5em',
			'position' => 'relative',
			'border-radius' => '0.3125em',
			'box-shadow' => '0 0.1875em 0.3125em 0 rgba(0,0,0,0.35)',
			'margin' => '0.2em',
			'transition' => 'all 0.2s',
			'overflow' => 'hidden',
		));

		// Add multiple properties at once.
		$this->css->set_selector('.share .shape-1 .icon');
		$this->css->add_properties(array(
			'position' => 'absolute',
			'top' => '40%',
			'left' => '50%',
			'transform' => 'translateX(-50%)',
		));

		// Add multiple properties at once.
		$this->css->set_selector('.share .shape-1 a:hover');
		$this->css->add_properties(array(
			'transform' => 'scale(1.2)',
			'box-shadow' => '0 0.3125em 0.9375em 0 rgba(0,0,0,0.4)',
		));

		// Add multiple properties at once.
		$this->css->set_selector('.share .shape-1 a:active');
		$this->css->add_properties(array(
			'transform' => 'scale(0.9)',
			'box-shadow' => '0 0.125em 0.1875em 0 rgba(0,0,0,0.4)',
		));

		// Add a single property.
		$this->css->set_selector('.share .shape-1 .label');
		$this->css->add_property('display','none');

		foreach($this->sns as $item){
			// Add multiple properties at once.
			$this->css->set_selector('.share .shape-1 ul li .share-' . $item);
			$this->css->add_properties(array(
				'color' => COLOR['white'],
				'background' => COLOR[$item],
			));

			// Add multiple properties at once.
			$this->css->set_selector('.share .shape-1 ul li .share-' . $item . ':hover');
			$this->css->add_properties(array(
				'color' => COLOR[$item . '-hover'],
				'background' => COLOR['white'],
			));
		}

	}// Method


	/**
		@access (private)
			The inline css for the "Circle" style.
			http://weboook.blog22.fc2.com/blog-entry-354.html
		@return (string)
			_filter[_inline_share][shape_2]
		@reference
			[Parent]/controller/fragment/share.php
			[Parent]/inc/setup/constant.php
			[Parent]/inc/utility/general.php
			[Parent]/inc/utility/theme.php
			[Parent]/model/app/share.php
	*/
	private function get_shape_2()
	{
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		if($this->theme_mod !== str_replace('_','-',$function)){return;}

		// Add multiple properties at once.
		$this->css->set_selector('.share .shape-2 ul');
		$this->css->add_properties(array(
			'display' => 'flex',
			'margin' => '0 auto',
		));

		// Add multiple properties at once.
		$this->css->set_selector('.share .shape-2 ul li');
		$this->css->add_properties(array(
			'text-align' => 'center',
			'transition' => 'all 0.5s ease',
			'font-size' => FONT['small'],
			'overflow' => 'hidden',
		));

		// Add a single property.
		$this->css->set_selector('.share .shape-2 ul li:hover');
		$this->css->add_property('transform','scale(1.5,1.5)');

		// Add multiple properties at once.
		$this->css->set_selector('.share .shape-2 ul li a');
		$this->css->add_properties(array(
			'color' => COLOR['white'],
			'display' => 'table-cell',
			'border-radius' => '50%',
			'vertical-align' => 'middle',
			'text-align' => 'center',
			'width' => '6rem',
			'height' => '6rem',
			'transition' => '0.5s',
		));

		// Add a single property.
		$this->css->set_selector('.share .shape-2 ul li a:hover');
		$this->css->add_property('opacity','0.6');

		// Add multiple properties at once.
		$this->css->set_selector('.share .shape-2 ul li .icon');
		$this->css->add_properties(array(
			'display' => 'block',
			'margin' => '0 auto',
		));

		foreach($this->sns as $item){
			// Add multiple properties at once.
			$this->css->set_selector('.share .shape-2 ul li .share-' . $item);
			$this->css->add_properties(array(
				'background' => COLOR[$item],
				'background' => COLOR[$item . '-hover'],
			));
		}

	}// Method


	/**
		@access (private)
			The inline css for the "Postit" style.
		@return (string)
			_filter[_inline_share][stylish_1]
		@reference
			[Parent]/controller/fragment/share.php
			[Parent]/inc/setup/constant.php
			[Parent]/inc/utility/general.php
			[Parent]/inc/utility/theme.php
			[Parent]/model/app/share.php
	*/
	private function get_stylish_1()
	{
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		if($this->theme_mod !== str_replace('_','-',$function)){return;}

		// Start a media query.
		$this->css->start_media_query('(max-width: ' . BREAK_POINT['small'] . ')');
		$this->css->set_selector('.share .stylish-1 ul li')->add_property('max-width','100%');
		// Stop the media query
		$this->css->stop_media_query();

		// Add a single property.
		$this->css->set_selector('.share .stylish-1 ul li');
		$this->css->add_property('max-width','24.5%');

		// Add multiple properties at once.
		$this->css->set_selector('.share .stylish-1 ul li');
		$this->css->add_properties(array(
			'display' => 'inline-block',
			'line-height' => '1.25',
			'margin' => '0.2rem 1px',
			'padding' => '0 1rem 0 0',
			'font-family' => __utility_get_value('font_secondary'),
			'text-transform' => 'uppercase',
			'border-radius' => '0.2rem',
			'box-shadow' => '1px 0.3rem 0 rgba(0,0,0,0.35)',
			'transition' => 'all 0.5s',
			'font-size' => FONT['small'],
			'overflow' => 'hidden',
			'white-space' => 'nowrap',
		));

		// Add a single property.
		$this->css->set_selector('.share .stylish-1 ul li a');
		$this->css->add_property('color',COLOR['white']);

		// Add a single property.
		$this->css->set_selector('.share .stylish-1 ul li a:hover');
		$this->css->add_property('color',$this->color['link']);

		// Add a single property.
		$this->css->set_selector('.share .stylish-1 ul li:hover');
		$this->css->add_property('box-shadow','0 0.5rem 1.5rem 0 rgba(0,0,0,0.45)');

		// Add a single property.
		$this->css->set_selector('.share .stylish-1 ul li:focus');
		$this->css->add_property('box-shadow','0 0.3rem 1rem 0 rgba(0,0,0,0.4)');

		// Add a single property.
		$this->css->set_selector('.share .stylish-1 ul li');
		$this->css->add_property('text-indent','0');

		// Add multiple properties at once.
		$this->css->set_selector('.share .stylish-1 .icon');
		$this->css->add_properties(array(
			'display' => 'inline-block',
			'width' => '2.25rem',
			'height' => '2.25rem',
			'line-height' => '1.25',
			'text-align' => 'center',
			'padding' => '0.75rem 0.25rem 0',
			'color' => COLOR['white'],
			'background' => COLOR['footer'],
		));

		// Add a single property.
		$this->css->set_selector('.share .stylish-1 .icon:before');
		$this->css->add_property('margin','0');

		foreach($this->sns as $item){
			// Add a single property.
			$this->css->set_selector('.share .stylish-1 .share-' . $item);
			$this->css->add_property('background',COLOR[$item]);

			// Add a single property.
			$this->css->set_selector('.share .stylish-1 .share-' . $item . ':hover');
			$this->css->add_property('background',COLOR[$item . '-hover']);
		}

	}// Method


	/**
		@access (private)
			The inline css for the "Cube" style.
		@return (string)
			_filter[_inline_share][stylish_2]
		@reference
			[Parent]/controller/fragment/share.php
			[Parent]/inc/setup/constant.php
			[Parent]/inc/utility/general.php
			[Parent]/inc/utility/theme.php
			[Parent]/model/app/share.php
	*/
	private function get_stylish_2()
	{
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		if($this->theme_mod !== str_replace('_','-',$function)){return;}

		// Add a single property.
		$this->css->set_selector('.share .stylish-2 ul');
		$this->css->add_property('margin','0 auto');

		// Add multiple properties at once.
		$this->css->set_selector('.share .stylish-2 ul li');
		$this->css->add_properties(array(
			'display' => 'inline-block',
			'text-indent' => '0',
			'padding' => '0.25rem',
			'background' => COLOR['white'],
		));

		// Add multiple properties at once.
		$this->css->set_selector('.share .stylish-2 a');
		$this->css->add_properties(array(
			'display' => 'inline-block',
			'font-size' => FONT['medium'],
			'height' => '3.3rem',
			'text-align' => 'center',
			'text-decoration' => 'none',
			'line-height' => '3.3rem',
			'outline' => 'none',
			'border' => 'none',
			'width' => '100%',
			'position' => 'relative',
			'perspective' => '100%',
		));

		// Add multiple properties at once.
		$this->css->set_selector('.share .stylish-2 a::before, .share .stylish-2 a::after');
		$this->css->add_properties(array(
			'position' => 'absolute',
			'z-index' => '-1',
			'display' => 'block',
			'content' => '""',
		));

		// Add multiple properties at once.
		$this->css->set_selector('.share .stylish-2 a, .share .stylish-2 a::before, .share .stylish-2 a::after');
		$this->css->add_properties(array(
			'box-sizing' => 'border-box',
			'transition' => 'all 0.3s',
		));

		// Add multiple properties at once.
		$this->css->set_selector('.share .stylish-2 .label, .share .stylish-2 .icon');
		$this->css->add_properties(array(
			'display' => 'block',
			'position' => 'absolute',
			'height' => '3.63rem',
			'border' => '1px solid ' . COLOR['white'],
			'text-align' => 'center',
			'line-height' => '3.41rem',
			'box-sizing' => 'border-box',
			'transition' => 'all 0.3s',
			'pointer-events' => 'none',
		));

		// Start a media query.
		$this->css->start_media_query('(max-width: ' . BREAK_POINT['medium'] . ')');
		$this->css->set_selector('.share .stylish-2 .label')->add_property('width','50%');
		$this->css->set_selector('.share .stylish-2 .icon')->add_property('width','50%');
		// Stop the media query
		$this->css->stop_media_query();

		// Add a single property.
		$this->css->set_selector('.share .stylish-2 .label');
		$this->css->add_property('width','100%');

		// Add a single property.
		$this->css->set_selector('.share .stylish-2 .icon');
		$this->css->add_property('width','100%');

		// Add multiple properties at once.
		$this->css->set_selector('.share .stylish-2 .icon');
		$this->css->add_properties(array(
			'background' => COLOR['white'],
			'color' => COLOR['white'] . ' !important',
			'transform' => 'rotateX(90deg)',
			'transform-origin' => '50% 50% -1.666rem',
		));

		// Add a single property.
		$this->css->set_selector('.share .stylish-2 a:hover .icon');
		$this->css->add_property('transform','rotateX(0deg)');

		// Add multiple properties at once.
		$this->css->set_selector('.share .stylish-2 .label');
		$this->css->add_properties(array(
			'background' => COLOR['white'],
			'color' => $this->color['text'],
			'transform' => 'rotateX(0deg)',
			'transform-origin' => '50% 50% -1.666rem',
		));

		foreach($this->sns as $item){
			// Add multiple properties at once.
			$this->css->set_selector('.share .stylish-2 .share-' . $item . ' .icon');
			$this->css->add_properties(array(
				'color' => COLOR['white'],
				'background' => COLOR[$item],
			));
			// Add multiple properties at once.
			$this->css->set_selector('.share .stylish-2 .share-' . $item . ' .label');
			$this->css->add_properties(array(
				'color' => COLOR['white'],
				'background' => COLOR[$item],
			));
			// Add multiple properties at once.
			$this->css->set_selector('.share .stylish-2 .share-' . $item . ':hover .label');
			$this->css->add_properties(array(
				'background' => COLOR[$item . '-hover'],
				'transform' => 'rotateX(-90deg)',
			));
		}

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
				[Parent]/controller/fragment/share.php
				[Parent]/model/app/share.php
		*/
		return self::$_style;

	}// Method


}// Class
endif;
// new _inline_share();
_inline_share::__get_instance();
