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
if(class_exists('_app_excerpt') === FALSE) :
class _app_excerpt
{
/**
 * [TOC]
 * 	__get_instance()
 * 	__construct()
 * 	set_param()
 * 	set_hook()
 * 	invoke_hook()
 * 	__the_template()
 * 	__the_render()
 * 	__the_readmore()
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
	*/
	private static $_class = '';
	private static $_index = '';
	private static $_param = array();
	private $hook = array();

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
				_filter[_app_excerpt][hook]
			@reference
				[Parent]/inc/setup/constant.php
				[Parent]/inc/trait/hook.php
				[Parent]/inc/utility/general.php
		*/
		$class = self::$_class;
		$index = self::$_index;
		$function = __utility_get_function(__FUNCTION__);

		/**
		 * @reference (Beans)
		 * 	Call the functions added to a filter hook.
		 * 	https://www.getbeans.io/code-reference/functions/beans_apply_filters/
		*/
		return beans_apply_filters("_filter[{$class}][{$function}]",$this->set_parameter_callback(array(
			'__the_render' => array(
				'beans_id' => $class . '__the_render',
				'tag' => 'beans_add_action',
				'hook' => HOOK_POINT['model'][$index]['main']
			),
			'__the_readmore' => array(
				'beans_id' => $class . '__the_readmore',
				'tag' => 'beans_add_action',
				'hook' => '_paragraph[_app_excerpt]_after_markup'
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
				[Parent]/controller/fragment/excerpt.php
				[Parent]/inc/customizer/option.php
				[Parent]/inc/setup/constant.php
				[Parent]/inc/utility/general.php
		*/
		$class = self::$_class;
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
		 * @reference (Beans)
		 * 	HTML markup.
		 * 	https://www.getbeans.io/code-reference/functions/beans_open_markup_e/
		 * 	https://www.getbeans.io/code-reference/functions/beans_close_markup_e/
		*/
		// beans_open_markup_e("_paragraph[{$class}]",__utility_get_option('tag_site-description'),array('class' =>'uk-padding-small'));
		beans_open_markup_e("_paragraph[{$class}]",__utility_get_option('tag_site-description'));

			/**
				@hooked
					_app_excerpt::__the_render()
				@reference
					[Parent]/model/app/excerpt.php
			*/
			do_action(HOOK_POINT['model'][$index]['main']);

		beans_close_markup_e("_paragraph[{$class}]",__utility_get_option('tag_site-description'));

		do_action(HOOK_POINT['model'][$index]['append']);

	}// Method


	/* Hook
	_________________________
	*/
	public function __the_render()
	{
		/**
			@access (public)
				Echo the content of the application.
			@return (void)
			@hook (beans id)
				_app_excerpt__the_render
			@reference
				[Parent]/inc/utility/general.php
		*/

		// Get current post data.
		global $post;
		if(!$post){
			$post = __utility_get_post_object();
		}
		$content = $post->post_content;

		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		/**
		 * @reference (WP)
		 * 	Properly strip all HTML tags including script and style.
		 * 	https://developer.wordpress.org/reference/functions/wp_strip_all_tags/
		*/
		$content = wp_strip_all_tags($content,TRUE);

		/**
		 * @reference (WP)
		 * 	Remove all shortcode tags from the given content.
		 * 	https://developer.wordpress.org/reference/functions/strip_shortcodes/
		*/
		$content = strip_shortcodes($content);

		// Strip HTML and PHP tags from a string.
		$content = strip_tags($content);

		// Removes special chars.
		$content = str_replace('&nbsp;','',$content);

		// Get part of string.
		if(mb_strlen($content) > self::$_param['length']){
			$content = mb_substr($content,0,self::$_param['length']);
		}

		/**
		 * @reference (Beans)
		 * 	Echo output registered by ID.
		 * 	https://www.getbeans.io/code-reference/functions/beans_output_e/
		*/
		beans_output_e("_output[{$class}][{$function}]",$content);

	}// Method


	/* Hook
	_________________________
	*/
	public function __the_readmore()
	{
		/**
			@access (public)
				Echo the readmore button.
			@return (void)
			@hook (beans id)
				_app_excerpt__the_readmore
			@reference
				[Parent]/inc/utility/general.php
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		// Get current post data.
		global $post;
		if(!$post){
			$post = __utility_get_post_object();
		}

		/**
		 * @reference (Beans)
		 * 	HTML markup.
		 * 	https://www.getbeans.io/code-reference/functions/beans_open_markup_e/
		 * 	https://www.getbeans.io/code-reference/functions/beans_output_e/
		 * 	https://www.getbeans.io/code-reference/functions/beans_close_markup_e/
		 * @reference (Uikit)
		 * 	https://getuikit.com/docs/button
		 * 	https://getuikit.com/docs/position
		*/
		beans_open_markup_e("_link[{$class}][{$function}]", 'a',array(
			'class' => 'uk-button uk-position-bottom-right ' . self::$_param['skin'],
			'href' => get_permalink($post->ID),
			'aria-label' => self::$_param['readmore'],
			'itemprop' => 'url',
		));
			// beans_output_e("_output[{$class}][{$function}]",self::$_param['readmore'] . $icon . mb_strimwidth(strip_tags(get_the_title($post->ID)),0,10,'...'));
			beans_output_e("_output[{$class}][{$function}]",self::$_param['readmore'] . get_the_title($post->ID));
		beans_close_markup_e("_link[{$class}][{$function}]",'a');

	}// Method


}// Class
endif;
// new _app_excerpt();
_app_excerpt::__get_instance();
