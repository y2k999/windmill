<?php
/**
 * Core class/function as application root.
 * @package Windmill
 * @license GPL3.0+
 * @since 1.0.1
*/

/**
 * Inspired by Beans Framework WordPress Theme
 * @link https://www.getbeans.io
 * @author Thierry Muller
 * 
 * Inspired by Cocoon WordPress Theme
 * @link https://wp-cocoon.com/
 * @author https://nelog.jp/
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
if(class_exists('_controller_shortcode') === FALSE) :
class _controller_shortcode
{
/**
 * [TOC]
 * 	__get_instance()
 * 	__construct()
 * 	set_registered()
 * 	render()
*/

	/**
		@access(private)
			Class properties.
		@var (string) $_class
			Name/Identifier with prefix.
		@var (string) $_index
			Name/Identifier without prefix.
		@var (array) $registered
			The shortcodes stored in array.
	*/
	private static $_class = '';
	private static $_index = '';
	private $registered = array();

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
				This is only called once,since the only way to instantiate this is with the get_instance() method in trait (singleton.php).
			@return (void)
			@reference
				[Parent]/inc/trait/singleton.php
				[Parent]/inc/utility/general.php
		*/

		// Init properties.
		self::$_class = __utility_get_class(get_class($this));
		self::$_index = __utility_get_index(self::$_class);

		// Call shortcode files.
		$this->registered = $this->set_registered();
		$this->render();

	}// Method


	/* Setter
	_________________________
	*/
	private function set_registered()
	{
		/**
			@access (private)
				Registered shortcodes registerd in setup file.
			@return (array)
				_filter[_controller_shortcode][registered]
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
			'blogcard',
			'toc',
		));

	}//Method


	/* Method
	_________________________
	*/
	private function render()
	{
		/**
			@access (private)
				Call the registerd shortcode files.
			@return (bool)
				Will always return true(Validate action arguments?).
		*/
		if(empty($this->registered)){return;}

		foreach($this->registered as $tag){
			$method = 'get_' . $tag;
			if(is_callable([$this,$method])){
				call_user_func([$this,$method]);
			}
		}

	}// Method


	/**
		@access (private)
			Activate the blogcard shortcode on posts.
		@return (void)
		@reference
			[Parent]/inc/trait/theme.php
			[Parent]/inc/utility/general.php
			[Parent]/model/shortcode/blogcard.php
	*/
	private function get_blogcard()
	{
		/**
		 * @reference (WP)
		 * 	Determines whether the query is for an existing single post of any post type (post,attachment,page,custom post types).
		 * 	https://developer.wordpress.org/reference/functions/is_singular/
		*/
		// if(!__utility_check_post_type()){return;}
		// $function = __utility_get_function(__FUNCTION__);

		if(__utility_get_option('blogcard_post')){
			switch(__utility_get_option('blogcard_type')){
				case 'embed' :
					self::__activate_application('embed-card');
					break;
				case 'ogp' :
					self::__activate_application('ogp-card');
					break;
				case 'hatena' :
				default :
					self::__activate_application('hatena-card');
					break;
			}
		}

	}// Method


	/**
		@access (private)
			Activate the toc shortcode on posts.
		@return (void)
		@reference
			[Parent]/inc/trait/theme.php
			[Parent]/inc/utility/general.php
			[Parent]/model/shortcode/toc.php
	*/
	private function get_toc()
	{
		/**
		 * @reference (WP)
		 * 	Determines whether the query is for an existing single post of any post type (post,attachment,page,custom post types).
		 * 	https://developer.wordpress.org/reference/functions/is_singular/
		*/
		// if(!__utility_check_post_type()){return;}
		$function = __utility_get_function(__FUNCTION__);

		if(__utility_get_option('toc_post')){
			self::__activate_application($function);
		}

	}// Method



}// Class
endif;
// new _controller_shortcode();
_controller_shortcode::__get_instance();
