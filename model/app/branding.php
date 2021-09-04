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
if(class_exists('_app_branding') === FALSE) :
class _app_branding
{
/**
 * [TOC]
 * 	__get_instance()
 * 	__construct()
 * 	set_param()
 * 	set_hook()
 * 	invoke_hook()
 * 	__the_template()
 * 	__the_custom_logo()
 * 	__the_title()
 * 	__the_description()
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
				_filter[_app_branding][hook]
			@reference
				[Parent]/inc/setup/constant.php
				[Parent]/inc/trait/hook.php
				[Parent]/inc/utility/general.php
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);
		$index = self::$_index;

		/**
		 * @reference (Beans)
		 * 	Call the functions added to a filter hook.
		 * 	https://www.getbeans.io/code-reference/functions/beans_apply_filters/
		*/
		return beans_apply_filters("_filter[{$class}][{$function}]",$this->set_parameter_callback(array(
			'__the_custom_logo' => array(
				'beans_id' => $class . '__the_custom_logo',
				'tag' => 'beans_add_action',
				'hook' => HOOK_POINT['model'][$index]['main']
			),
			'__the_title' => array(
				'beans_id' => $class . '__the_title',
				'tag' => 'beans_add_action',
				'hook' => HOOK_POINT['model'][$index]['main']
			),
			'__the_description' => array(
				'beans_id' => $class . '__the_description',
				'tag' => 'beans_add_action',
				'hook' => HOOK_POINT['model'][$index]['append']
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
				[Parent]/controller/structure/header.php
				[Parent]/inc/customizer/option.php
				[Parent]/inc/setup/constant.php
				[Parent]/inc/utility/general.php
				[Parent]/template/header/header.php
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

		/**
			@hooked
				__wrap_branding_header_prepend()
			@reference
				[Parent]/model/wrap/branding.php
		*/
		do_action(HOOK_POINT['model'][$index]['prepend']);

		/**
			@hooked
				_app_branding::__the_render()
			@reference
				[Parent]/model/app/branding.php
		*/
		do_action(HOOK_POINT['model'][$index]['main']);

		/**
			@hooked
				__wrap_branding_header_append()
			@reference
				[Parent]/model/wrap/branding.php
		*/
		do_action(HOOK_POINT['model'][$index]['append']);

	}// Method


	/* Hook
	_________________________
	*/
	public function __the_custom_logo()
	{
		/**
			@access (public)
				Echo the content of the application.
			@return (void)
			@hook (beans id)
				_app_branding__the_custom_logo
		*/
		if(!has_custom_logo()){return;}

		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		/**
		 * @reference (Beans)
		 * 	HTML markup.
		 * 	https://www.getbeans.io/code-reference/functions/beans_open_markup_e/
		 * 	https://www.getbeans.io/code-reference/functions/beans_close_markup_e/
		*/
		beans_open_markup_e("_logo[{$class}][{$function}]",'div',array(
			'class' => 'site-logo',
			'itemprop' => 'name about',
		));
			/**
			 * @reference (WP)
			 * 	Determines whether the site has a custom logo.
			 * 	https://developer.wordpress.org/reference/functions/has_custom_logo/
			 * 	Displays a custom logo, linked to home unless the theme supports removing the link on the home page.
			 * 	https://developer.wordpress.org/reference/functions/the_custom_logo/
			*/
			the_custom_logo();
		beans_close_markup_e("_logo[{$class}][{$function}]",'div');

	}// Method


	/* Hook
	_________________________
	*/
	public function __the_title()
	{
		/**
			@access (public)
				Echo the content of the application.
			@return (void)
			@hook (beans id)
				_app_branding__the_title
			@reference
				[Parent]/inc/customizer/option.php
				[Parent]/inc/utility/general.php
		*/

		/**
		 * @reference (WP)
		 * 	Determines whether the site has a custom logo.
		 * 	https://developer.wordpress.org/reference/functions/has_custom_logo/
		*/
		if(has_custom_logo()){return;}

		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		/**
		 * @reference (Beans)
		 * 	HTML markup.
		 * 	https://www.getbeans.io/code-reference/functions/beans_open_markup_e/
		 * 	https://www.getbeans.io/code-reference/functions/beans_output_e/
		 * 	https://www.getbeans.io/code-reference/functions/beans_close_markup_e/
		*/
		beans_open_markup_e("_tag[{$class}][{$function}]",__utility_get_option('tag_site-title'),array(
			'class' => 'uk-padding-remove-vertical uk-margin-remove-vertical site-title',
			'itemprop' => 'name about',
		));
			beans_open_markup_e("_link[{$class}][{$function}]",'a',array(
				/**
				 * @reference (WP)
				 * 	Retrieves the URL for the current site where the front end is accessible.
				 * 	https://developer.wordpress.org/reference/functions/home_url/
				*/
				'href' => esc_url(home_url()),
				'itemprop' => 'url',
				'rel' => 'home',
			));
				/**
				 * @reference (WP)
				 * 	Retrieves information about the current site.
				 * 	https://developer.wordpress.org/reference/functions/get_bloginfo/
				*/
				beans_output_e("_output[{$class}][{$function}]",get_bloginfo('name','display'));
			beans_close_markup_e("_link[{$class}][{$function}]",'a');
		beans_close_markup_e("_tag[{$class}][{$function}]",__utility_get_option('tag_site-title'));

	}// Method


	/* Hook
	_________________________
	*/
	public function __the_description()
	{
		/**
			@access (public)
				Echo the content of the application.
			@return (void)
			@hook (beans id)
				_app_branding__the_description
			@reference
				[Parent]/inc/utility/general.php
		*/

		/**
		 * @reference (WP)
		 * 	Retrieves information about the current site.
		 * 	https://developer.wordpress.org/reference/functions/get_bloginfo/
		*/
		$description = get_bloginfo('description','display');
		if(!$description){return;}

		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		/**
		 * @reference (Beans)
		 * 	HTML markup.
		 * 	https://www.getbeans.io/code-reference/functions/beans_open_markup_e/
		 * 	https://www.getbeans.io/code-reference/functions/beans_output_e/
		 * 	https://www.getbeans.io/code-reference/functions/beans_close_markup_e/
		*/
		beans_open_markup_e("_paragraph[{$class}][{$function}]",__utility_get_option('tag_site-description'),array(
			'class' => 'site-description',
			'itemprop' => 'alternativeHeadline',
		));
			beans_output_e("_output[{$class}][{$function}]",$description);
		beans_close_markup_e("_paragraph[{$class}][{$function}]",__utility_get_option('tag_site-description'));

	}// Method


}// Class
endif;
// new _app_branding();
_app_branding::__get_instance();
