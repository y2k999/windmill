<?php
/**
 * Setup theme.
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
if(class_exists('_setup_widget_area') === FALSE) :
class _setup_widget_area
{
/**
 * [TOC]
 * 	__get_instance()
 * 	__construct()
 * 	set_args()
 * 	set_sidebar()
 * 	set_hook()
 * 	invoke_hook()
 * 	register()
 * 	reset()
 * 	dynamic_sidebar_params()
 * 	__get_setting()
*/

	/**
		@access (private)
			Class properties.
		@var (string) $_class
			Name/Identifier with prefix.
		@var (string) $_index
			Name/Identifier without prefix.
		@var (array) $_sidebar
			Registerd sidebars.
		@var (array) $args
			Parameters passed to a widget’s display callback.
		@var 	(array) $hook
			Collection of hooks that is being registered (that is, actions or filters).
	*/
	private static $_class = '';
	private static $_index = '';
	private static $_sidebar = array();
	private $args = array();
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
				[Parent]/inc/utility/theme.php
		*/

		// Init properties.
		self::$_class = __utility_get_class(get_class($this));
		self::$_index = __utility_get_index(self::$_class);
		self::$_sidebar = $this->set_sidebar();
		$this->args = $this->set_args();

		// Register hooks.
		$this->hook = $this->set_hook();
		$this->invoke_hook($this->hook);

		/**
		 * @description
		 * 	Call register sidebar.
		 * 	Because the WordPress.org checker doesn't understand that we are using register_sidebar properly,
		 * 	we have to add this useless call which only has to be declared once.
		 * 
		 * @reference (WP)
		 * 	Fires after all default WordPress widgets have been registered.
		 * 	https://developer.wordpress.org/reference/hooks/widgets_init/
		*/
		if(__utility_is_beans('widget')){
			add_action('widgets_init','beans_register_widget_area');
		}

	}// Method


	/* Setter
	_________________________
	*/
	private function set_sidebar()
	{
		/**
			@access (private)
				Defines the array for creating and displaying the widgetized areas in the WP-Admin and front-end of the site.
			@return (array)
				_filter[_setup_widget_area][sidebar]
			@reference
				[Parent]/inc/utility/general.php
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		/**
		 * @reference (WP)
		 * 	Calls the callback functions that have been added to a filter hook.
		 * 	https://developer.wordpress.org/reference/functions/apply_filters/
		*/
		return apply_filters("_filter[{$class}][{$function}]",array(
			/**
			 * @since 1.0.1
			 * 	Sidebar Area
			 * 	Keep primary sidebar first for default widget asignment.
			 * @reference
			 * 	[Parent]/inc/utility/theme.php
			*/
			'sidebar' => array(
				'sidebar_primary' => array(
					'name' => __utility_is_beans('widget') ? esc_html('[Beans] Primary Sidebar') : esc_html('Primary Sidebar'),
					'description' => esc_html__('The primary widget area, most often used as "sidebar".','windmill'),
				),
				'sidebar_secondary' => array(
					'name' => __utility_is_beans('widget') ? esc_html('[Beans] Secondary Sidebar') : esc_html('Secondary Sidebar'),
					'description' => esc_html__('The secondary widget area, most often used as "sidebar".','windmill'),
				),
			),

			/**
			 * @since 1.0.1
			 * 	Footer Area
			 * @reference
			 * 	[Parent]/inc/utility/theme.php
			*/
			'footer' => array(
				'footer_primary' => array(
					'name' => __utility_is_beans('widget') ? esc_html('[Beans] Primary Footer') : esc_html('Primary Footer'),
					'description' => esc_html__('The primary widget area, most often used in footer.','windmill'),
				),
				'footer_secondary' => array(
					'name' => __utility_is_beans('widget') ? esc_html('[Beans] Secondary Footer') : esc_html('Secondary Footer'),
					'description' => esc_html__('The secondary widget area, most often used in footer.','windmill'),
				),
			),

			/**
			 * @since 1.0.1
			 * 	Header Area
			 * @reference
			 * 	[Parent]/inc/utility/theme.php
			*/
			'header' => array(
				'header_primary' => array(
					'name' => __utility_is_beans('widget') ? esc_html('[Beans] Primary Header') : esc_html('Primary Header'),
					'description' => esc_html__('The primary widget area, most often used in header.','windmill'),
				),
				'header_secondary' => array(
					'name' => __utility_is_beans('widget') ? esc_html('[Beans] Secondary Header') : esc_html('Secondary Header'),
					'description' => esc_html__('The secondary widget area, most often used in header.','windmill'),
				),
			),

			/**
			 * @since 1.0.1
			 * 	Content Area
			 * @reference
			 * 	[Parent]/inc/utility/theme.php
			*/
			'content' => array(
				'content_primary' => array(
					'name' => __utility_is_beans('widget') ? esc_html('[Beans] Primary Content') : esc_html('Primary Content'),
					'description' => esc_html__('The primary widget area, most often used in main content.','windmill'),
				),
				'content_secondary' => array(
					'name' => __utility_is_beans('widget') ? esc_html('[Beans] Secondary Content') : esc_html('Secondary Content'),
					'description' => esc_html__('The secondary widget area, most often used in main content.','windmill'),
				),
			),
		));

	}// Method


	/* Setter
	_________________________
	*/
	private function set_args()
	{
		/**
			@access (private)
				Filters the parameters passed to a widget’s display callback.
				https://developer.wordpress.org/reference/hooks/dynamic_sidebar_params/
			@return (array)
				_filter[_setup_widget_area][args]
			@reference
				[Parent]/inc/customizer/option.php
				[Parent]/inc/utility/general.php
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		$tag = __utility_get_option('tag_widget-title') ? __utility_get_option('tag_widget-title') : 'h4';

		/**
		 * @reference (WP)
		 * 	Calls the callback functions that have been added to a filter hook.
		 * 	https://developer.wordpress.org/reference/functions/apply_filters/
		 * @reference
		 * 	[Parent]/inc/utility/theme.php
		*/
		return apply_filters("_filter[{$class}][{$function}]",array(
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<' . $tag . ' class="widget-title">',
			'after_title' => '</' . $tag . '>',
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
				_filter[_setup_widget_area][hook]
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
			'register' => array(
				'tag' => 'beans_add_smart_action',
				'hook' => 'widgets_init',
				'priority' => PRIORITY['low']
			),
			'reset' => array(
				'tag' => 'beans_add_smart_action',
				'hook' => 'after_switch_theme'
			),
/*
			'dynamic_sidebar_params' => array(
				'tag' => 'add_filter',
				'hook' => 'dynamic_sidebar_params'
			),
*/
		)));

	}// Method


	/* Hook
	_________________________
	*/
	public function dynamic_sidebar_params($params)
	{
		/**
			[ATTENTION]
				This hook conflicts with Beans widget API.
			@access(public)
				Filters the parameters passed to a widget’s display callback.
				https://developer.wordpress.org/reference/hooks/dynamic_sidebar_params/
			@return (array)
		*/
		$params[0]['before_widget'] = $this->args['before_widget'];
		$params[0]['after_widget'] = $this->args['after_widget'];
		$params[0]['before_title'] = $this->args['before_title'];
		$params[0]['after_title'] = $this->args['after_title'];

		return $params;

	}// Method


	/* Hook
	_________________________
	*/
	public function register()
	{
		/**
			@access (public)
				Register widget area.
				Keep primary sidebar first for default widget asignment.
			@link
				Fires after all default WordPress widgets have been registered.
				https://developer.wordpress.org/reference/hooks/widgets_init/
			@return (void)
			@reference
				[Parent]/inc/utility/theme.php
		*/
		if(__utility_is_beans('widget')){
			foreach(self::$_sidebar as $needle => $attr){
				foreach($attr as $key => $value){
					/**
					 * @reference (WP)
					 * 	Register a widget area.
					 * 	https://www.getbeans.io/code-reference/functions/beans_register_widget_area/
					*/
					beans_register_widget_area(array(
						'id' => $key,
						'name' => $value['name'],
					));
				}
			}
		}
		else{
			foreach(self::$_sidebar as $needle => $attr){
				foreach($attr as $key => $value){
					/**
					 * @reference (WP)
					 * 	Builds the definition for a single sidebar and returns the ID. Call on widgets_init action.
					 * 	https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
					*/
					register_sidebar(array(
						'id' => $key,
						'name' => $value['name'],
						'before_widget' => $this->args['before_widget'],
						'after_widget' => $this->args['after_widget'],
						'before_title' => $this->args['before_title'],
						'after_title' => $this->args['after_title'],
					));
				}
			}
		}

	}// Method


	/* Hook
	_________________________
	*/
	public function reset()
	{
		/**
			@access (public)
				Pre-set default widgets on each sidebars.
			@return (void)
		*/
		$default = array(
			/**
			 * @since 1.0.1
			 * 	Unset default preset widgets from sidebar.
			*/

			// 'widget_search' => array(1 => array('_multiwidget' => 1)),
			'widget_recent-comments' => array(1 => array('_multiwidget' => 1)),
			// 'widget_archives' => array(1 => array('_multiwidget' => 1)),
			// 'widget_meta' => array(1 => array('_multiwidget' => 1)),

			/**
			 * @since 1.0.1
			 * 	Decide widgets to be preset.
			*/

			// 'widget_meta' => array(2 => array('title' => esc_html__('Meta','windmill')),'_multiwidget' => 1),
			'widget_search' => array(2 => array('title' => esc_html__('Search Widget','windmill')),'_multiwidget' => 1),
			'widget_recent-posts' => array(2 => array('title' => esc_html__('Recent Posts Widget','windmill'),'number' => 5),'_multiwidget' => 1),
			'widget_categories' => array(2 => array('title' => esc_html__('Categories Widget','windmill'),'count' => 0,'hierarchical' => 0,'dropdown' => 0),'_multiwidget' => 1),
			// 'widget_tag_cloud' => array(2 => array('title' => '','taxonomy' => 'post_tag'),'_multiwidget' => 1),
			// 'widget_text' => array(2 => array('title' => '','text' => '','filter' => 0),'_multiwidget' => 1),

			/**
			 * @since 1.0.1
			 * 	Ordering.
			*/
			'sidebars_widgets' => array(
				'wp_inactive_widgets' => array(),
				'sidebar_primary' => array(
					// 0 => 'meta-2',
					// 1 => 'search-2',
					0 => 'search-2',
				),
				'sidebar_secondary' => array(
					0 => 'recent-posts-2',
					1 => 'categories-2',
				),
				'footer_primary' => array(),
				'footer_secondary' => array(),
				'header_primary' => array(),
				'header_secondary' => array(),
				'content_primary' => array(),
				'content_secondary' => array(),
				'array_version' => 3
			),
		);
		foreach($default as $key => $value){
			update_option($key,$value);
		}

	}// Method


	/* Method
	_________________________
	*/
	public static function __get_setting($needle = '')
	{
		/**
			@access (public)
				Returns the registerd sidebar.
			@param (string) $needle
				Widget area location.
			@return (string)|(array)
		*/
		if(isset($needle) && array_key_exists($needle,self::$_sidebar)){
			return self::$_sidebar[$needle];
		}
		else{
			return self::$_sidebar;
		}

	}//Method


}// Class
endif;
// new _setup_widget_area();
_setup_widget_area::__get_instance();
