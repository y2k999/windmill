<?php 
/**
 * Set environmental configurations which enhance the theme by hooking into WordPress.
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
if(class_exists('_env_excerpt') === FALSE) :
class _env_excerpt
{
/**
 * [TOC]
 * 	__get_instance()
 * 	__construct()
 * 	set_hook()
 * 	invoke_hook()
 * 	length()
 * 	readmore()
*/

	/**
		@access (private)
			Class properties.
		@var (string) $_class
			Name/Identifier with prefix.
		@var (string) $_index
			Name/Identifier without prefix.
		@var(array) $hook
			The collection of hooks that is being registered (that is, actions or filters).
	*/
	private static $_class = '';
	private static $_index = '';
	private $hook = array();

	/**
	 * Traits.
	*/
	use _trait_hook;
	use _trait_singleton;


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
				_filter[_env_excerpt][hook]
			@reference
				[Parent]/inc/trait/hook.php
				[Parent]/inc/utility/general.php
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		/**
		 * @reference (WP)
		 * 	Calls the callback functions that have been added to a filter hook.
		 * 	https://developer.wordpress.org/reference/functions/apply_filters/
		*/
		return apply_filters("_filter[{$class}][{$function}]",$this->set_parameter_callback(array(
			'excerpt_length' => array(
				'tag' => 'add_filter',
				'hook' => 'excerpt_length'
			),
			'excerpt_more' => array(
				'tag' => 'add_filter',
				'hook' => 'excerpt_more'
			),
		)));

	}// Method


	/* Hook
	_________________________
	*/
	public function excerpt_length($number)
	{
		/**
			@access (public)
				Filters the maximum number of words in a post excerpt.
				https://developer.wordpress.org/reference/hooks/excerpt_length/
			@param (int) $number
				The maximum number of words. Default 55.
			@return (int)
				_filter[_env_excerpt][excerpt_length]
			@reference
				[Parent]/inc/customizer/option.php
				[Parent]/inc/utility/general.php
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		/**
		 * @reference (WP)
		 * 	Calls the callback functions that have been added to a filter hook.
		 * 	https://developer.wordpress.org/reference/functions/apply_filters/
		*/
		return apply_filters("_filter[{$class}][{$function}]",$number = __utility_get_option($function));

	}// Method


	/* Hook
	_________________________
	*/
	public function excerpt_more($more_string)
	{
		/**
			@access (public)
				Filters the string in the “more” link displayed after a trimmed excerpt.
				https://developer.wordpress.org/reference/hooks/excerpt_more/
			@param (string) $more_string
				The string shown within the more link.
			@return (string)
				_filter[_env_excerpt][excerpt_more]
			@reference
				[Parent]/inc/customizer/option.php
				[Parent]/inc/utility/general.php
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		/**
		 * @since 1.0.1
		 * 	Icon for prefix.
		 * @reference (Beans)
		 * 	Call the functions added to a filter hook.
		 * 	https://www.getbeans.io/code-reference/functions/beans_apply_filters/
		*/
		$icon = beans_apply_filters("_icon[{$class}][{$function}]",sprintf(' <span uk-icon="icon: %s"></span> ',' chevron-double-right'));

		// Get current post data.
		global $post;
		if(!$post){
			$post = __utility_get_post_object();
		}
		$more_string = '';
		/**
		 * @reference (Beans)
		 * 	HTML markup.
		 * 	https://www.getbeans.io/code-reference/functions/beans_open_markup/
		 * 	https://www.getbeans.io/code-reference/functions/beans_close_markup/
		*/
		$more_string .= beans_open_markup("_link[{$class}][{$function}]", 'a',array(
			'class' => 'uk-button uk-position-bottom-right ' . __utility_get_option('skin_button_primary'),
			'href' => get_permalink($post->ID),
			'aria-label' => esc_attr('Read More'),
			'itemprop' => 'url',
		));
			$more_string .= beans_output("_output[{$class}][{$function}]",__utility_get_option($function) . $icon . get_the_title($post->ID));
		$more_string .= beans_close_markup("_link[{$class}][{$function}]",'a');

		/**
		 * @reference (WP)
		 * 	Calls the callback functions that have been added to a filter hook.
		 * 	https://developer.wordpress.org/reference/functions/apply_filters/
		*/
		return apply_filters("_filter[{$class}][{$function}]",$more_string,'…');

	}// Method


}// Class
endif;
// new _env_excerpt();
_env_excerpt::__get_instance();
