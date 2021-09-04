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
if(class_exists('_structure_single') === FALSE) :
class _structure_single
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
 * 	__the_wp_link_pages()
 * 	__set_post_view()
 * 	__the_post_link()
 * 	__the_relation()
 * 	__the_comments()
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
				_filter[_structure_single][param]
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
				_filter[_structure_single][sidebar]
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
				_filter[_structure_single][hook]
			@reference
				[Parent]/inc/setup/constant.php
				[Parent]/inc/utility/general.php
				[Parent]/template/content/singular.php
				[Parent]/template-part/content/content.php
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		/**
		 * @reference (Beans)
		 * 	Call the functions added to a filter hook.
		 * 	https://www.getbeans.io/code-reference/functions/beans_apply_filters/
		*/
		return beans_apply_filters("_filter[{$class}][{$function}]",array(
			'the_content' => array(
				'beans_id' => $class . '__the_content',
				'hook' => HOOK_POINT['single']['body']['main'],
				'callback' => '__the_content',
				'priority' => PRIORITY['default'],
				// 'priority' => PRIORITY['mid-low'],
			),
			'dynamic_sidebar' => array(
				'beans_id' => $class . '__the_dynamic_sidebar',
				'hook' => HOOK_POINT['single']['body']['main'],
				'callback' => '__the_dynamic_sidebar',
				'priority' => PRIORITY['default'],
			),
			'wp_link_pages' => array(
				'beans_id' => $class . '__the_wp_link_pages',
				'hook' => HOOK_POINT['single']['body']['main'],
				'callback' => '__the_wp_link_pages',
				'priority' => PRIORITY['default'],
			),
			'set_post_view' => array(
				'beans_id' => $class . '__set_post_view',
				'hook' => HOOK_POINT['single']['body']['main'],
				'callback' => '__set_post_view',
				'priority' => PRIORITY['default'],
			),
			'post_link' => array(
				'beans_id' => $class . '__the_post_link',
				'hook' => HOOK_POINT['single']['footer']['after'],
				'callback' => '__the_post_link',
				'priority' => PRIORITY['default'],
			),
			'relation' => array(
				'beans_id' => $class . '__the_relation',
				'hook' => HOOK_POINT['single']['footer']['after'],
				'callback' => '__the_relation',
				'priority' => PRIORITY['default'],
			),
			'comments' => array(
				'beans_id' => $class . '__the_comments',
				'hook' => HOOK_POINT['single']['footer']['after'],
				'callback' => '__the_comments',
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
			Display the post content in the post.php.
		@global (WP_Post) $post
			https://codex.wordpress.org/Global_Variables
		@hook (beans id)
			_structure_single__the_content
		@reference
			[Parent]/template-part/content/content.php
	*/
	public function __the_content()
	{
		/**
		 * @reference (WP)
		 * 	Determines whether the query is for an existing single post of any post type (post, attachment, page, custom post types).
		 * 	https://developer.wordpress.org/reference/functions/is_singular/
		*/
		if(!is_singular('post')){return;}

		// WP global.
		// global $post;

		/**
		 * @reference (WP)
		 * 	Display the post content in the post.php.
		 * 	https://developer.wordpress.org/reference/functions/the_content/
		*/
		the_content();

		/**
		 * @reference (WP)
		 * 	The formatted output of a list of pages.
		 * 	https://developer.wordpress.org/reference/functions/wp_link_pages/
		*/
		// wp_link_pages();
/*
		wp_link_pages(array(
			'before' => '<div class="page-links uk-text-center"><span class="page-links-title">' . __('Pages:','windmill') . '</span>',
			'after' => '</div>',
			'separator ' => '  ',
			'link_before' => '<span class="uk-badge uk-padding-small">',
			'link_after' => '</span>',
		));
*/

		/**
		 * @since 1.0.1
		 * 	Call access counter of Beans Extension plugin.
		 * @reference
		 * 	[Plugin]/beans_extension/include/utility/tag-external.php
		*/
		// beans_set_post_view($post->ID);

	}// Method


	/**
		@access (public)
		@hook (beans id)
			_structure_single__the_wp_link_pages
	*/
	public function __the_wp_link_pages()
	{
		/**
		 * @reference (WP)
		 * 	Determines whether the query is for an existing single post of any post type (post, attachment, page, custom post types).
		 * 	https://developer.wordpress.org/reference/functions/is_singular/
		 * 	Determines whether the query is for a paged result and not for the first page.
		 * 	https://developer.wordpress.org/reference/functions/is_paged/
		*/
		if(!is_singular('post')){return;}
		// if(!is_paged()){return;}

		/**
		 * @reference (WP)
		 * 	The formatted output of a list of pages.
		 * 	https://developer.wordpress.org/reference/functions/wp_link_pages/
		*/
		wp_link_pages();
/*
		wp_link_pages(array(
			'before' => '<div class="page-links uk-text-center"><span class="page-links-title">' . __('Pages:','windmill') . '</span>',
			'after' => '</div>',
			'separator ' => '  ',
			'link_before' => '<span>',
			'link_after' => '</span>',
		));
*/

	}// Method


	/**
		@access (public)
		@hook (beans id)
			_structure_single__the_wp_link_pages
	*/
	public function __set_post_view()
	{
		/**
		 * @reference (WP)
		 * 	Determines whether the query is for an existing single post of any post type (post, attachment, page, custom post types).
		 * 	https://developer.wordpress.org/reference/functions/is_singular/
		 * 	Determines whether the query is for a paged result and not for the first page.
		 * 	https://developer.wordpress.org/reference/functions/is_paged/
		*/
		if(!is_singular('post')){return;}

		// WP global.
		global $post;

		/**
		 * @since 1.0.1
		 * 	Call access counter of Beans Extension plugin.
		 * @reference
		 * 	[Plugin]/beans_extension/include/utility/tag-external.php
		*/
		beans_set_post_view($post->ID);

	}// Method


	/**
		@access (public)
			Display dynamic sidebar.
		@hook (beans id)
			_structure_single__the_dynamic_sidebar
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
		if(!is_singular('post')){return;}
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
			Display the related posts.
		@hook (beans id)
			_structure_single__the_relation
		@reference
			[Parent]/inc/setup/constant.php
			[Parent]/inc/trait/theme.php
			[Parent]/inc/utility/general.php
	*/
	public function __the_relation()
	{
		/**
		 * @reference (WP)
		 * 	Determines whether the query is for an existing single post of any post type (post, attachment, page, custom post types).
		 * 	https://developer.wordpress.org/reference/functions/is_singular/
		*/
		if(!is_singular('post')){return;}
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
			Display comment template.
		@hook (beans id)
			_structure_single__the_comments
		@reference
			[Parent]/inc/setup/constant.php
			[Parent]/inc/trait/theme.php
			[Parent]/inc/utility/general.php
	*/
	public function __the_comments()
	{
		/**
		 * @reference (WP)
		 * 	Determines whether the query is for an existing single post of any post type (post, attachment, page, custom post types).
		 * 	https://developer.wordpress.org/reference/functions/is_singular/
		 * 	Determines whether the current post is open for comments.
		 * 	https://developer.wordpress.org/reference/functions/comments_open/
		*/
		if(!is_singular('post') || !comments_open() || !get_option('thread_comments')){return;}
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
			Display the adjacent post.
		@hook (beans id)
			_structure_single__the_post_link
		@reference
			[Parent]/inc/setup/constant.php
			[Parent]/inc/trait/theme.php
			[Parent]/inc/utility/general.php
	*/
	public function __the_post_link()
	{
		/**
		 * @reference (WP)
		 * 	Determines whether the query is for an existing single post of any post type (post, attachment, page, custom post types).
		 * 	https://developer.wordpress.org/reference/functions/is_singular/
		*/
		if(!is_singular('post')){return;}
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
// new _structure_single();
_structure_single::__get_instance();
