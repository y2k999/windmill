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
if(class_exists('_inline_base') === FALSE) :
class _inline_base
{
/**
 * [TOC]
 * 	__get_instance()
 * 	__construct()
 * 	set_component()
 * 	set_color()
 * 	get_transition()
 * 	get_typography()
 * 	get_list()
 * 	get_gutenberg()
 * 	get_header()
 * 	get_meta()
 * 	get_back2top()
 * 	get_wp_link_pages()
 * 	get_image()
 * 	get_search()
 * 	get_slider()
 * 	__get_setting()
*/

	/**
		@access (private)
			Class properties.
		@var (string) $_class
			Name/Identifier with prefix.
		@var (string) $_index
			Name/Identifier without prefix.
		@var (array) $component
			Components that need the inline css.
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
	private $component = array();
	private $color = array();
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
		$this->component = $this->set_component();
		$this->color = $this->set_color();

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
	private function set_component()
	{
		/**
			@access (private)
				Set theme style components that need the inline css.
			@return (array)
				Name of theme style components.
				_filter[_inline_base][component]
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
			'transition',
			'typography',
			'list',
			'gutenberg',
			'header',
			'meta',
			'back2top',
			'wp_link_pages',
			'image',
			'search',
			'slider',
		));

	}// Method


	/* Setter
	_________________________
	*/
	private function set_style()
	{
		/**
			@access (private)
				Build the inline css of theme style components.
			@return (string)
				_filter[_inline_base][style]
			@reference
				[Parent]/inc/trait/theme.php
				[Parent]/inc/utility/general.php
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		foreach($this->component as $item){
			$method = 'get_' . $item;
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
			Create smooth transitions between two states when hovering an element.
		@return (string)
			_filter[_inline_base][transition]
		@reference
			[Parent]/inc/utility/general.php
	*/
	private function get_transition()
	{
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		$return = '';
		$return .= 'body{animation: fadeIn 1.5s ease 0s 1 normal; -webkit-animation: fadeIn 1.5s ease 0s 1 normal;}';
		$return .= '@keyframes fadeIn{0%{opacity: 0;}100%{opacity: 1;}}';
		// Smooth scroll for back2top
		$return .= 'html{scroll-behavior: smooth;@media (prefers-reduced-motion: reduce){scroll-behavior: auto;}}';

		/**
		 * @reference (Beans)
		 * 	Call the functions added to a filter hook.
		 * 	https://www.getbeans.io/code-reference/functions/beans_apply_filters/
		*/
		$this->exception = beans_apply_filters("_filter[{$class}][{$function}]",$return);

	}// Method


	/**
		@access (private)
			A collection of utility classes to style text.
		@return (string)
			_filter[_inline_base][typography]
		@reference
			[Parent]/inc/customizer/option.php
			[Parent]/inc/setup/constant.php
			[Parent]/inc/utility/general.php
	*/
	private function get_typography()
	{
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		// Add multiple properties at once.
		$this->css->set_selector('body');
		$this->css->add_properties(array(
			'color' => $this->color['text'],
			'font-family' => __utility_get_value('font_primary'),
			'font-size' => FONT['medium'],
		));

		// Add a single property.
		$this->css->set_selector('a');
		$this->css->add_property('color',$this->color['link']);

		// Add multiple properties at once.
		$this->css->set_selector('a:focus, a:active, a:hover');
		$this->css->add_properties(array(
			'color' => $this->color['hover'],
			'opacity' => '0.7',
			'transition' => '0.8s',
		));

		// Add a single property.
		$this->css->set_selector('h1, h2, h3, h4, h5, h6');
		$this->css->add_property('font-family',__utility_get_value('font_secondary'));

		// Add a single property.
		$this->css->set_selector('p');
		$this->css->add_property('line-height','1.75');

		// Add a single property.
		$this->css->set_selector('.post-title');
		$this->css->add_property('font-size',FONT['large']);

		// Add a single property.
		$this->css->set_selector('.item-title');
		$this->css->add_property('font-size',FONT['large']);

		// Add a single property.
		$this->css->set_selector('.post .widget-title, .page .widget-title');
		$this->css->add_property('font-size',FONT['large']);

	}// Method


	/**
		@access (private)
			A collection of utility classes to style list.
		@return (string)
			_filter[_inline_base][list]
		@reference
			[Parent]/inc/setup/constant.php
			[Parent]/inc/utility/general.php
	*/
	private function get_list()
	{
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		// Add multiple properties at once.
		$this->css->set_selector('ul');
		$this->css->add_properties(array(
			'line-height' => '1.75',
			'list-style-type' => 'none',
		));

		// Add a single property.
		$this->css->set_selector('li');
		$this->css->add_property('line-height','2');

	}// Method


	/**
		@access (private)
			The inline css for the Gutenberg block styling.
		@return (string)
			_filter[_inline_base][gutenberg]
		@reference (Uikit)
			https://getuikit.com/docs/article
		@reference
			[Parent]/inc/setup/constant.php
			[Parent]/inc/utility/general.php
	*/
	private function get_gutenberg()
	{
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		// Add multiple properties at once.
		$this->css->set_selector('.uk-article .entry-content h2:not(.post-title):not(.item-title):not(.widget-title)');
		$this->css->add_properties(array(
			'border-left' => '0.5rem solid ' . $this->color['link'],
			'border-bottom' => '1px solid ' . $this->color['link'],
		));

		// Add multiple properties at once.
		$this->css->set_selector('.uk-article .entry-content h3:not(.post-title):not(.item-title):not(.widget-title)');
		$this->css->add_properties(array(
			'background' => $this->color['link'],
			'border-bottom' => '1px solid ' . COLOR['border'],
		));

		// Add multiple properties at once.
		$this->css->set_selector('.uk-article .entry-content h4:not(.post-title):not(.item-title):not(.widget-title)::after');
		$this->css->add_properties(array(
			'border-bottom' => '2px solid ' . COLOR['link'],
		));

		// Add multiple properties at once.
		$this->css->set_selector('.uk-article .entry-content h5:not(.post-title):not(.item-title):not(.widget-title)');
		$this->css->add_properties(array(
			'background' => 'linear-gradient(transparent 90%,' . COLOR['bright-yellow'] . ' 70%)',
		));

		// Add multiple properties at once.
		$this->css->set_selector('.uk-article .entry-content h6:not(.post-title):not(.item-title):not(.widget-title)');
		$this->css->add_properties(array(
			'border-top' => '1px solid ' . COLOR['border'],
			'border-bottom' => '1px solid ' . COLOR['border'],
		));

	}// Method


	/**
		@access (private)
			The inline css for the site title in masthead.
		@return (string)
			_filter[_inline_base][header]
		@reference
			[Parent]/controller/structure/header.php
			[Parent]/inc/customizer/option.php
			[Parent]/inc/setup/constant.php
			[Parent]/inc/utility/general.php
			[Parent]/template/header/header.php
	*/
	private function get_header()
	{
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		// Add a single property.
		$this->css->set_selector('.site-header a');
		$this->css->add_property('color',$this->color['link']);

		// Start a media query.
		$this->css->start_media_query('(max-width: ' . BREAK_POINT['medium'] . ')');
		$this->css->set_selector('.site-title')->add_property('font-size',FONT['medium']);
		// Stop the media query.
		$this->css->stop_media_query();

		// Add multiple properties at once.
		$this->css->set_selector('.site-title');
		$this->css->add_properties(array(
			'font-family' => __utility_get_value('font_secondary'),
			'font-size' => FONT['large'],
		));

	}// Method


	/**
		@access (private)
			The inline css for the post meta.
		@return (string)
			_filter[_inline_base][back2top]
		@reference
			[Parent]/inc/setup/constant.php
			[Parent]/inc/utility/general.php
			[Parent]/model/app/meta.php
	*/
	private function get_meta()
	{
		// if(!is_singular('post')){return;}

		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		// Add a single property.
		$this->css->set_selector('.entry-header ul li a');
		$this->css->add_property('color',$this->color['link']);

		// Add a single property.
		$this->css->set_selector('.entry-meta');
		$this->css->add_property('font-size',FONT['small']);

	}// Method


	/**
		@access (private)
			The inline css for the back to top button.
		@return (string)
			_filter[_inline_base][back2top]
		@reference
			[Parent]/inc/setup/constant.php
			[Parent]/inc/utility/general.php
			[Parent]/model/app/back2top.php
	*/
	private function get_back2top()
	{
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		// Add multiple properties at once.
		$this->css->set_selector('#back2top');
		$this->css->add_properties(array(
			'background' => $this->color['link'],
			'color' => COLOR['white'],
		));

		// Add a single property.
		$this->css->set_selector('#back2top:hover');
		$this->css->add_property('background',$this->color['hover']);

	}// Method


	/**
		@access (private)
			The inline css for the wp_link_pages().
		@return (string)
			_filter[_inline_base][back2top]
		@reference
			[Parent]/inc/setup/constant.php
			[Parent]/inc/utility/general.php
			[Parent]/controller/structure/singular.php
	*/
	private function get_wp_link_pages()
	{
		if(!is_singular('post')){return;}

		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		// Add multiple properties at once.
		$this->css->set_selector('#post-nav-links .nav-links li');
		$this->css->add_properties(array(
			'margin' => '0 0.2rem',
			'color' => $this->color['link'],
			'background' => COLOR['white'],
		));

		// Add multiple properties at once.
		$this->css->set_selector('#post-nav-links .nav-links li.active');
		$this->css->add_properties(array(
			'color' => $this->color['link'],
			'border' => 'border: 1px solid ' . $this->color['link'],
		));

		// Add multiple properties at once.
		$this->css->set_selector('#post-nav-links .nav-links li.active:hover');
		$this->css->add_properties(array(
			'color' => $this->color['hover'],
			'border' => 'border: 1px solid ' . $this->color['hover'],
		));

		// Add multiple properties at once.
		$this->css->set_selector('#post-nav-links .nav-links li a');
		$this->css->add_properties(array(
			'color' => COLOR['white'],
			'border' => 'border: 1px solid ' . $this->color['link'],
			'background' => $this->color['link'],
		));

		// Add multiple properties at once.
		$this->css->set_selector('#post-nav-links .nav-links li a:hover');
		$this->css->add_properties(array(
			'color' => COLOR['white'],
			'background' => $this->color['hover'],
		));

	}// Method


	/**
		@access (private)
			The inline css for the post thumbnail.
		@return (string)
			_filter[_inline_base][image]
		@reference (Uikit)
			https://getuikit.com/docs/overlay
		@reference
			[Parent]/inc/setup/constant.php
			[Parent]/inc/utility/general.php
			[Parent]/model/app/image.php
	*/
	private function get_image()
	{
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		// Add multiple properties at once.
		$this->css->set_selector('.image-overlay');
		$this->css->add_properties(array(
			'background' => COLOR['footer'],
			'opacity' => '0.1',
		));

		// Add a single property.
		$this->css->set_selector('.image-overlay:hover');
		$this->css->add_property('opacity','0.8');

	}// Method


	/**
		@access (private)
			The inline css for the overlay search.
		@return (string)
			_filter[_inline_base][search]
		@reference (Uikit)
			https://getuikit.com/docs/overlay
		@reference
			[Parent]/inc/setup/constant.php
			[Parent]/inc/utility/general.php
			[Parent]/model/app/search.php
	*/
	private function get_search()
	{
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		// Add multiple properties at once.
		$this->css->set_selector('.search-overlay');
		$this->css->add_properties(array(
			'background' => COLOR['footer'],
			'opacity' => '0.95',
		));

	}// Method


	/**
		@access (private)
			The inline css for the Uikit slidenav component.
		@return (string)
			_filter[_inline_base][slider]
		@reference (Uikit)
			https://getuikit.com/docs/overlay
		@reference
			[Parent]/inc/utility/general.php
			[Parent]/model/widget/relation.php
	*/
	private function get_slider()
	{
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		// Add a single property.
		$this->css->set_selector('.uk-slidenav-large');
		$this->css->add_property('color',$this->color['link']);

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
				[Parent]/inc/env/gutenberg.php
				[Parent]/model/app/back2top.php
				[Parent]/model/app/search.php
				[Parent]/template/header/header.php
				[Parent]/template/sidebar/sidebar.php
				[Parent]/template-part/content/content.php
				[Parent]/template-part/content/content-archive.php
				[Parent]/template-part/content/content-home.php
				[Parent]/template-part/content/content-page.php
		*/
		return self::$_style;

	}// Method


}// Class
endif;
// new _inline_base();
_inline_base::__get_instance();
