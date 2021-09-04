<?php
/**
 * Load applications according to the settings and conditions.
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
if(class_exists('_structure_page') === FALSE) :
class _structure_page
{
/**
 * [TOC]
 * 	__get_instance()
 * 	__construct()
 * 	set_param()
 * 	set_sidebar()
 * 	set_hook()
 * 	invoke_hook()
 * 	__the_content()
 * 	__the_dynamic_sidebar()
 * 	__the_html_sitemap()
*/

	/**
		@access(private)
			Class properties.
		@var (string) $_class
			Name/Identifier with prefix.
		@var (string) $_index
			Name/Identifier without prefix.
		@var (array) $_param
			Parameter for applications.
		@var (array) $sidebar
			Sidebars stored in array by sidebar ID.
		@var (array) $hook
			Collection of hooks that is being registered (that is, actions or filters).
	*/
	private static $_class = '';
	private static $_index = '';
	private $param = array();
	private $sidebar = array();
	private $hook = array();

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
		$this->param = $this->set_param();
		$this->sidebar = $this->set_sidebar();

		// Register hooks.
		$this->hook = $this->set_hook();
		$this->invoke_hook();

	}// Method


	/* Setter
	_________________________
	*/
	private function set_param()
	{
		/**
			@access (private)
				Configure the parameter for applications.
			@return (array)
				_filter[_structure_page][param]
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
			'class' => self::$_index
		));

	}// Method


	/* Setter
	_________________________
	*/
	private function set_sidebar()
	{
		/**
			@access (private)
				Set the registerd widget areas (WP sidebars).
			@return (array)
				_filter[_structure_page][sidebar]
			@reference
				[Parent]/inc/setup/widget-area.php
				[Parent]/inc/utility/general.php
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		/**
		 * @reference (Beans)
		 * 	Call the functions added to a filter hook.
		 * 	https://www.getbeans.io/code-reference/functions/beans_apply_filters/
		*/
		return beans_apply_filters("_filter[{$class}][{$function}]",_setup_widget_area::__get_setting('content'));

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
				_filter[_structure_page][hook]
			@reference
				[Parent]/inc/setup/constant.php
				[Parent]/inc/utility/general.php
				[Parent]/template/content/singular.php
				[Parent]/template-part/content/content-page.php
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		/**
		 * @reference (Beans)
		 * 	Call the functions added to a filter hook.
		 * 	https://www.getbeans.io/code-reference/functions/beans_apply_filters/
		*/
		return beans_apply_filters("_filter[{$class}][{$function}]",array(
			'content' => array(
				'beans_id' => $class . '__the_content',
				'hook' => HOOK_POINT['page']['body']['main'],
				'callback' => '__the_content',
				'priority' => PRIORITY['default'],
			),
			'dynamic_sidebar' => array(
				'beans_id' => $class . '__the_dynamic_sidebar',
				'hook' => HOOK_POINT['page']['body']['main'],
				'callback' => '__the_dynamic_sidebar',
				'priority' => PRIORITY['default'],
			),
			'html_sitemap' => array(
				'beans_id' => $class . '__the_html_sitemap',
				'hook' => HOOK_POINT['page']['body']['append'],
				'callback' => '__the_html_sitemap',
				'priority' => PRIORITY['default'],
			),
		));

	}// Method


	/* Method
	_________________________
	 */
	private function invoke_hook()
	{
		/**
			@access (private)
				Hooks a function on to a specific action.
				https://www.getbeans.io/code-reference/functions/beans_add_action/
			@return (bool)
				Will always return true(Validate action arguments?).
		*/
		if(empty($this->hook)){return;}

		foreach((array)$this->hook as $key => $value){
			/**
			 * @param (string) $id
			 * 	The action's Beans ID,a unique string(ID) tracked within Beans for this action.
			 * @param (string) $hook
			 * 	The name of the action to which the `$callback` is hooked.
			 * @param (callable) $callable
			 * 	The name of the function|method you wish to be called when the action event fires.
			 * @param (int) $priority
			 * 	Used to specify the order in which the functions associated with a particular action are executed.
			*/
			beans_add_action($value['beans_id'],$value['hook'],array($this,$value['callback']),$value['priority']);
		}

	}// Method


	/**
		@access (public)
			Display the post content in the page.php.
		@hook (beans id)
			_structure_page__the_content
		@reference
			[Parent]/template-part/content/content-page.php
	*/
	public function __the_content()
	{
		/**
		 * @reference (WP)
		 * 	Determines whether the query is for an existing single post of any post type (post, attachment, page, custom post types).
		 * 	https://developer.wordpress.org/reference/functions/is_singular/
		*/
		// if(!is_singular('page')){return;}

		/**
		 * @reference (WP)
		 * 	Display the post content in the page.php.
		 * 	https://developer.wordpress.org/reference/functions/the_content/
		*/
		the_content();

	}// Method


	/**
		@access (public)
			Display dynamic sidebar.
		@hook (beans id)
			_structure_page__the_dynamic_sidebar
		@reference
			[Parent]/inc/setup/constant.php
			[Parent]/inc/trait/theme.php
			[Parent]/inc/utility/general.php
	*/
	public function __the_dynamic_sidebar()
	{
		/**
		 * @reference (WP)
		 * 	Determines whether the query is for an existing single post of any post type (post, attachment, page, custom post types).
		 * 	https://developer.wordpress.org/reference/functions/is_singular/
		*/
		// if(!is_singular('page')){return;}
		$function = __utility_get_function(__FUNCTION__);

		if(file_exists(PATH['wrap'] . $function . '.php')){
			/**
			 * @since 1.0.1
			 * 	Render wrapper around the model (application).
			 * @reference (WP)
			 * 	Loads a template part into a template.
			 * 	https://developer.wordpress.org/reference/functions/get_template_part/
			*/
			get_template_part(SLUG['wrap'] . $function,NULL,$this->param);
		}
		self::__activate_application($function,$this->param);

	}// Method


	/**
		@access (public)
			Display html sitemap.
		@hook (beans id)
			_structure_page__the_html_sitemap
		@note
			This is specific setting for this theme.
		@reference
			[Parent]/inc/setup/constant.php
			[Parent]/inc/trait/theme.php
			[Parent]/inc/utility/general.php
	*/
	public function __the_html_sitemap()
	{
		/**
		 * @reference (WP)
		 * 	Determines whether the query is for an existing single post of any post type (post, attachment, page, custom post types).
		 * 	https://developer.wordpress.org/reference/functions/is_singular/
		 * 	Determines whether the query is for an existing single page.
		 * 	https://developer.wordpress.org/reference/functions/is_page/
		*/
		// if(!is_singular('page')){return;}
		if(empty(__utility_get_option('page_html-sitemap'))){return;}

		if(is_page_template('page-template/template-html-sitemap.php')){return;}

		$page = get_post(__utility_get_option('page_html-sitemap'));
		if(empty($page->post_name)){return;}
		if(!is_page($page->post_name)){return;}

		$function = __utility_get_function(__FUNCTION__);

		if(file_exists(PATH['wrap'] . $function . '.php')){
			/**
			 * @since 1.0.1
			 * 	Render wrapper around the model (application).
			 * @reference (WP)
			 * 	Loads a template part into a template.
			 * 	https://developer.wordpress.org/reference/functions/get_template_part/
			*/
			get_template_part(SLUG['wrap'] . $function,NULL,$this->param);
		}
		self::__activate_application($function,$this->param);

	}// Method


}// Class
endif;
// new _structure_page();
_structure_page::__get_instance();
