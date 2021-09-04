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
if(class_exists('_fragment_meta') === FALSE) :
class _fragment_meta
{
/**
 * [TOC]
 * 	__get_instance()
 * 	__construct()
 * 	set_param()
 * 	set_theme_mod()
 * 	set_hook()
 * 	invoke_hook()
 * 	__the_archive()
 * 	__the_single()
 * 	__the_card()
 * 	__the_gallery()
 * 	__the_general()
 * 	__the_list()
 * 	render()
 * 	the_content()
 * 	the_item()
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
		@var (array) $theme_mod
			Meta items for each templates/parts/applications.
		@var (array) $hook
			Collection of hooks that is being registered (that is,actions or filters).
	*/
	private static $_class = '';
	private static $_index = '';
	private static $_param = array();
	private $theme_mod = array();
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
				This is only called once,since the only way to instantiate this is with the get_instance() method in trait (singleton.php).
			@return (void)
			@reference
				[Parent]/inc/trait/singleton.php
				[Parent]/inc/utility/general.php
		*/

		// Init properties.
		self::$_class = __utility_get_class(get_class($this));
		self::$_index = __utility_get_index(self::$_class);
		self::$_param = $this->set_param();
		$this->theme_mod = $this->set_theme_mod();

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
				_filter[_fragment_meta][param]
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
			'archive' => array(
				'cat-all' => FALSE,
				'tags-all' => FALSE,
			),
			'home' => array(
				'cat-all' => TRUE,
				'tags-all' => TRUE,
			),
			'search' => array(
				'cat-all' => TRUE,
				'tags-all' => TRUE,
			),
			'single' => array(
				'cat-all' => TRUE,
				'tags-all' => TRUE,
			),
			'card' => array(
				'cat-all' => FALSE,
				'tags-all' => FALSE,
			),
			'gallery' => array(
				'cat-all' => FALSE,
				'tags-all' => FALSE,
			),
			'general' => array(
				'cat-all' => FALSE,
				'tags-all' => FALSE,
			),
			'list' => array(
				'cat-all' => FALSE,
				'tags-all' => FALSE,
			),
			'figcaption' => array(
				'type' => __utility_get_option('meta_figcaption'),
				'cat-all' => TRUE,
				'tags-all' => TRUE,
			),
		));

	}// Method


	/* Setter
	_________________________
	*/
	private function set_theme_mod()
	{
		/**
			@access (private)
				Meta items for each pattern from theme customizer settings.
			@return (array)
				_filter[_fragment_meta][theme_mod]
			@reference
				[Parent]/inc/customizer/option.php
				[Parent]/inc/utility/general.php
				[Plugin]/utility/theme.php
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		$home = beans_get_layout_setting('home');
		$archive = beans_get_layout_setting('archive');

		/**
		 * @reference (Beans)
		 * 	Call the functions added to a filter hook.
		 * 	https://www.getbeans.io/code-reference/functions/beans_apply_filters/
		*/
		return beans_apply_filters("_filter[{$class}][{$function}]",array(
			'archive' => beans_get_layout_setting('archive') === 'card' ? __utility_get_value('meta_archive') : __utility_get_value('meta_post'),
			'home' => beans_get_layout_setting('home') === 'list' ? __utility_get_value('meta_post') : __utility_get_value('meta_archive'),
			'search' => beans_get_layout_setting('home') === 'list' ? __utility_get_value('meta_post') : __utility_get_value('meta_archive'),
			'single' => __utility_get_value('meta_post'),
			'card' => array(
				'updated',
				'cat-links'
			),
			'gallery' => array(
				'updated',
				'cat-links'
			),
			'general' => array(
				'updated',
				'cat-links'
			),
			'list' => array(
				'updated',
				'cat-links'
			),
			'figcaption' => array(
				'cat-links'
			),
		));

	}// Method


	/* Setter
	_________________________
	*/
	private function set_hook()
	{
		/**
			@access (private)
				The collection of hooks that is being registered (that is,actions or filters).
			@return (array)
				_filter[_fragment_meta][hook]
			@reference
				[Parent]/inc/setup/constant.php
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
			/**
			 * @since 1.0.1
			 * 	Echo on contents.
			 * @reference
			 * 	[Parent]/template-part/content/content.php
			 * 	[Parent]/template-part/content/content-archive.php
			 * 	[Parent]/template-part/content/content-home.php
			*/
			'archive' => array(
				'beans_id' => $class . '__the_archive',
				'hook' => HOOK_POINT['archive']['header']['append'],
				'callback' => '__the_archive',
				'priority' => PRIORITY['default'],
			),
			'home' => array(
				'beans_id' => $class . '__the_home',
				'hook' => HOOK_POINT['home']['header']['append'],
				'callback' => '__the_home',
				'priority' => PRIORITY['default'],
			),
			'search' => array(
				'beans_id' => $class . '__the_search',
				'hook' => HOOK_POINT['search']['header']['append'],
				'callback' => '__the_search',
				'priority' => PRIORITY['default'],
			),
			'single' => array(
				'beans_id' => $class . '__the_single',
				'hook' => HOOK_POINT['single']['header']['append'],
				'callback' => '__the_single',
				'priority' => PRIORITY['default'],
			),
			'footer' => array(
				'beans_id' => $class . '__the_footer',
				'hook' => HOOK_POINT['single']['footer']['main'],
				'callback' => '__the_footer',
				'priority' => PRIORITY['default'],
			),
			/**
			 * @since 1.0.1
			 * 	Echo on items.
			 * @reference
			 * 	[Parent]/template-part/item/card.php
			 * 	[Parent]/template-part/item/gallery.php
			 * 	[Parent]/template-part/item/general.php
			 * 	[Parent]/template-part/item/list.php
			*/
			'card' => array(
				'beans_id' => $class . '__the_card',
				'hook' => HOOK_POINT['item']['card']['header'],
				'callback' => '__the_card',
				'priority' => PRIORITY['default'],
			),
			'gallery' => array(
				'beans_id' => $class . '__the_gallery',
				'hook' => HOOK_POINT['item']['gallery']['header'],
				'callback' => '__the_gallery',
				'priority' => PRIORITY['default'],
			),
			'general' => array(
				'beans_id' => $class . '__the_general',
				'hook' => HOOK_POINT['item']['general']['header'],
				'callback' => '__the_general',
				'priority' => PRIORITY['default'],
			),
			'list' => array(
				'beans_id' => $class . '__the_list',
				'hook' => HOOK_POINT['item']['list']['header'],
				'callback' => '__the_list',
				'priority' => PRIORITY['default'],
			),
			/**
			 * @since 1.0.1
			 * 	Echo on thumbnails.
			 * @reference
			 * 	[Parent]/controller/fragment/image.php
			*/
			'figcaption' => array(
				'beans_id' => $class . '__the_figcaption',
				'hook' => HOOK_POINT['figure']['meta'],
				'callback' => '__the_figcaption',
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

		foreach($this->hook as $key => $value){
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
			Display post meta for archive template.
		@hook (beans id)
			_fragment_meta__the_archive
		@reference
			[Parent]/inc/utility/general.php
			[Parent]/template-part/content/content-archive.php
	*/
	public function __the_archive()
	{
		if(!__utility_is_archive()){return;}
		$function = __utility_get_function(__FUNCTION__);
		$this->render($function);
	}// Method


	/**
		@access (public)
			Display post meta for index template.
		@hook (beans id)
			_fragment_meta__the_home
		@reference
			[Parent]/inc/utility/general.php
			[Parent]/template-part/content/content-home.php
	*/
	public function __the_home()
	{
		/**
		 * @reference (WP)
		 * 	Determines whether the query is for the blog homepage.
		 * 	https://developer.wordpress.org/reference/functions/is_home/
		*/
		if(!is_home()){return;}
		$function = __utility_get_function(__FUNCTION__);
		$this->render($function);
	}// Method


	/**
		@access (public)
			Display post meta for search template.
		@hook (beans id)
			_fragment_meta__the_search
		@reference
			[Parent]/inc/utility/general.php
			[Parent]/template-part/content/content-search.php
	*/
	public function __the_search()
	{
		/**
		 * @reference (WP)
		 * 	Determines whether the query is for the blog homepage.
		 * 	https://developer.wordpress.org/reference/functions/is_home/
		*/
		if(!is_search()){return;}
		$function = __utility_get_function(__FUNCTION__);
		$this->render($function);
	}// Method

	/**
		@access (public)
			Display post meta for single template.
		@hook (beans id)
			_fragment_meta__the_single
		@reference
			[Parent]/inc/utility/general.php
			[Parent]/template-part/content/content.php
	*/
	public function __the_single()
	{
		/**
		 * @reference (WP)
		 * 	Determines whether the query is for an existing single post of any post type (post,attachment,page,custom post types).
		 * 	https://developer.wordpress.org/reference/functions/is_singular/
		*/
		if(!is_singular('post')){return;}
		$function = __utility_get_function(__FUNCTION__);
		$this->render($function);
	}// Method


	/**
		@access (public)
			Display post meta for card format.
		@hook (beans id)
			_fragment_meta__the_card
		@reference
			[Parent]/inc/utility/general.php
			[Parent]/template-part/item/card.php
	*/
	public function __the_card()
	{
		$function = __utility_get_function(__FUNCTION__);
		$this->render($function);
	}// Method


	/**
		@access (public)
			Display post meta for gallery format.
		@hook (beans id)
			_fragment_meta__the_gallery
		@reference
			[Parent]/inc/utility/general.php
			[Parent]/template-part/item/gallery.php
	*/
	public function __the_gallery()
	{
		$function = __utility_get_function(__FUNCTION__);
		$this->render($function);
	}// Method


	/**
		@access (public)
			Display post meta for general format.
		@hook (beans id)
			_fragment_meta__the_general
		@reference
			[Parent]/inc/utility/general.php
			[Parent]/template-part/item/general.php
	*/
	public function __the_general()
	{
		$function = __utility_get_function(__FUNCTION__);
		$this->render($function);
	}// Method


	/**
		@access (public)
			Display post meta for list format.
		@hook (beans id)
			_fragment_meta__the_list
		@reference
			[Parent]/inc/utility/general.php
			[Parent]/template-part/item/list.php
	*/
	public function __the_list()
	{
		$function = __utility_get_function(__FUNCTION__);
		$this->render($function);
	}// Method


	/**
		@access (public)
			Display post meta within <entry-footer> area of single template.
		@hook (beans id)
			_fragment_meta__the_footer
		@reference
			[Parent]/inc/utility/general.php
			[Parent]/template-part/content/content.php
	*/
	public function __the_footer()
	{
		/**
		 * @reference (WP)
		 * 	Determines whether the query is for an existing single post of any post type (post,attachment,page,custom post types).
		 * 	https://developer.wordpress.org/reference/functions/is_singular/
		*/
		if(!is_singular('post')){return;}

		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		/**
		 * @reference
		 * 	[Parent]/inc/trait/theme.php
		 * 	[Parent]/model/app/meta.php
		*/
		beans_open_markup_e("_list[{$class}][{$function}][tags-links]",'div',array('class' => 'uk-padding-small uk-flex uk-flex-right'));
			self::__activate_application(self::$_index,array(
				'type' => 'tags-links',
				'tags-all' => FALSE,
			));
		beans_close_markup_e("_list[{$class}][{$function}][tags-links]",'div');

		beans_open_markup_e("_list[{$class}][{$function}][byline]",'div',array('class' => 'uk-padding-small uk-flex uk-flex-right'));

			beans_open_markup_e("_label[{$class}][{$function}][byline]",'span',array('class' => 'uk-margin-small-right'));
				beans_output_e("_output[{$class}][{$function}][byline]",esc_html('Posted By '));
			beans_close_markup_e("_label[{$class}][{$function}][byline]",'span');
			self::__activate_application(self::$_index,array(
				'type' => 'byline',
			));
		beans_close_markup_e("_list[{$class}][{$function}][byline]",'div');

	}// Method


	/**
		@access (public)
			Display post meta on thumbnail.
		@hook (beans id)
			_fragment_meta__the_figcaption
		@reference
			[Parent]/controller/fragment/image.php
			[Parent]/inc/trait/theme.php
			[Parent]/inc/utility/general.php
			[Parent]/model/app/meta.php
	*/
	public function __the_figcaption()
	{
		$function = __utility_get_function(__FUNCTION__);
		self::__activate_application(self::$_index,self::$_param[$function]);
	}// Method


	/* Method
	_________________________
	*/
	private function render($needle = '')
	{
		/**
			@access (private)
				Load and echo the designated application.
			@param (string) $needle
				Content type of Item format.
			@return (void)
		*/
		if(!isset($needle)){return;}

		switch($needle){
			case 'archive' :
			case 'home' :
			case 'search' :
			case 'single' :
				$this->the_content($needle);
				break;

			case 'card' :
			case 'gallery' :
			case 'general' :
			case 'list' :
			default :
				$this->the_item($needle);
				break;
		}

	}// Method


	/**
		@access (private)
			Display meta items on content template parts.
		@param (string) $needle
			Content type of Item format.
		@return (void)
		@reference
			[Parent]/inc/trait/theme.php
			[Parent]/inc/utility/general.php
	*/
	private function the_content($needle = '')
	{
		if(!isset($needle)){return;}

		$class = self::$_class;

		/**
		 * @reference (Beans)
		 * 	HTML markup.
		 * 	https://www.getbeans.io/code-reference/functions/beans_open_markup_e/
		 * 	https://www.getbeans.io/code-reference/functions/beans_close_markup_e/
		 * @reference (Uikit)
		 * 	https://getuikit.com/docs/article
		 * 	https://getuikit.com/docs/grid
		 * 	https://getuikit.com/docs/width
		*/
		beans_open_markup_e("_list[{$class}][{$needle}]",'ul',array('class' => 'uk-list uk-flex uk-flex-wrap uk-flex-wrap-around uk-flex-bottom entry-meta'));
			foreach($this->theme_mod[$needle] as $item){
				// Configure the parameter for the application.
				self::$_param[$needle]['type'] = $item;
				beans_open_markup_e("_item[{$class}][{$needle}][{$item}]",'li',array('class' => 'uk-margin-small-left'));
					/**
					 * @reference
					 * 	[Parent]/model/app/meta.php
					*/
					self::__activate_application(self::$_index,self::$_param[$needle]);
				beans_close_markup_e("_item[{$class}][{$needle}][{$item}]",'li');
			}
		beans_close_markup_e("_list[{$class}][{$needle}]",'ul');

	}// Method


	/**
		@access (private)
			Echo archive page title.
		@param (string) $needle
			Content type of Item format.
		@return (void)
		@reference
			[Parent]/inc/trait/theme.php
			[Parent]/inc/utility/general.php
			[Parent]/model/app/meta.php
	*/
	private function the_item($needle)
	{
		if(!isset($needle)){return;}

		$class = self::$_class;

		beans_open_markup_e("_list[{$class}][{$needle}]",'div',array('class' => 'entry-meta'));
		foreach($this->theme_mod[$needle] as $item){
			// Configure the parameter for the application.
			self::$_param[$needle]['type'] = $item;
			self::__activate_application(self::$_index,self::$_param[$needle]);
		}
		beans_close_markup_e("_list[{$class}][{$needle}]",'div');

	}// Method


}// Class
endif;
// new _fragment_meta();
_fragment_meta::__get_instance();
