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
if(class_exists('_app_html_sitemap') === FALSE) :
class _app_html_sitemap
{
/**
 * [TOC]
 * 	__get_instance()
 * 	__construct()
 * 	set_param()
 * 	set_args()
 * 	set_hook()
 * 	invoke_hook()
 * 	__the_template()
 * 	__the_icon()
 * 	__the_render()
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
		@var (array) $args
			Parameter of wp_list_pages().
		@var (array) $hook
			Collection of hooks that is being registered (that is, actions or filters).
	*/
	private static $_class = '';
	private static $_index = '';
	private static $_param = array();
	private $args = array();
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
		$this->args = $this->set_args();

		// Register hooks.
		$this->hook = $this->set_hook();
		$this->invoke_hook($this->hook);

	}// Method


	/* Setter
	_________________________
	*/
	private function set_args()
	{
		/**
			@access (private)
				Array or string of arguments to generate a list of pages. 
				https://developer.wordpress.org/reference/functions/wp_list_pages/
			@return (array)
				_filter[_app_html_sitemap][args]
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
			'title' => esc_html__('Static Pages','windmill'),
			'title_li' => '',
			'link_before' => '',
			'link_after' => '',
			'sort_column' => 'menu_order',
			'depth' => 0,
		));

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
				_filter[_app_html_sitemap][hook]
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
			'__the_icon' => array(
				'beans_id' => $class . '__the_icon',
				'tag' => 'beans_add_action',
				'hook' => HOOK_POINT['model'][$index]['main']
			),
			'__the_render' => array(
				'beans_id' => $class . '__the_render',
				'tag' => 'beans_add_action',
				'hook' => HOOK_POINT['model'][$index]['main']
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
				[Parent]/inc/setup/constant.php
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
			@hooked
				_app_sitemap::__the_icon()
				_app_sitemap::__the_render()
			@reference
				[Parent]/model/app/sitemap.php
		*/
		do_action(HOOK_POINT['model'][$index]['main']);

		do_action(HOOK_POINT['model'][$index]['append']);

	}// Method


	/* Hook
	_________________________
	*/
	public function __the_render()
	{
		/**
			@access (public)
			@return (void)
			@hook (beans id)
				_app_html_sitemap__the_render
			@reference
				[Parent]/controller/structure/header.php
				[Parent]/inc/utility/general.php
				[Parent]/inc/utility/theme.php
		*/
		if((self::$_param['class'] === 'header')){return;}

		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		/**
		 * @reference (Beans)
		 * 	HTML markup.
		 * 	https://www.getbeans.io/code-reference/functions/beans_open_markup_e/
		 * 	https://www.getbeans.io/code-reference/functions/beans_close_markup_e/
		*/
		beans_open_markup_e("_section[{$class}]",'section',__utility_get_column('widget',array('class' => self::$_index)));
			/**
				@since 1.0.1
					Widget title.
				@reference
					[Parent]/inc/trait/theme.php
			*/
			if(isset($this->args['title'])){
				self::__the_title($this->args['title']);
			}

			beans_open_markup_e("_list[{$class}]",'ul',beans_apply_filters("_property[{$class}][list]",array()));
				/**
				 * @reference (WP)
				 * 	Retrieve or display a list of pages (or hierarchical post type items) in list (li) format.
				 * 	https://developer.wordpress.org/reference/functions/wp_list_pages/
				*/
				wp_list_pages($this->args);
			beans_close_markup_e("_list[{$class}]",'ul');

		beans_close_markup_e("_section[{$class}]",'section');

	}// Method


	/* Hook
	_________________________
	*/
	public function __the_icon()
	{
		/**
			@access (public)
				Render the html sitemap in icon format.
			@return (void)
			@hook (beans id)
				_app_html_sitemap__the_icon
			@reference
				[Parent]/inc/utility/general.php
		*/
		if((self::$_param['class'] !== 'header')){return;}

		$class = self::$_class;
		$index = self::$_index;
		$function = __utility_get_function(__FUNCTION__);

		if(!empty(self::$_param['href'])){
			$page = get_post(self::$_param['href']);
			if(isset($page->post_name) && is_page($page->post_name)){
				$href = get_page_link(self::$_param['href']);
			}
		}
		else{
			$href = home_url('/html-sitemap/');
		}

		/**
		 * @reference (Beans)
		 * 	HTML markup.
		 * 	https://www.getbeans.io/code-reference/functions/beans_output_e/
		 * @reference (Uikit)
		 * 	https://getuikit.com/docs/icon
		*/
		beans_output_e("_output[{$class}][{$function}]",sprintf(
			'<a href="%1$s" title="%2$s" uk-icon="icon: %3$s"></a>',
			/**
			 * @reference (WP)
			 * 	Retrieves the permalink for the current page or page ID.
			 * 	https://developer.wordpress.org/reference/functions/get_page_link/
			*/
			$href,
			esc_attr($index),
			self::$_param['icon']
		));

	}// Method


}// Class
endif;
// new _app_html_sitemap();
_app_html_sitemap::__get_instance();
