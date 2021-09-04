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
if(class_exists('_app_dynamic_sidebar') === FALSE) :
class _app_dynamic_sidebar
{
/**
 * [TOC]
 * 	__get_instance()
 * 	__construct()
 * 	set_param()
 * 	set_sidebar()
 * 	set_hook()
 * 	invoke_hook()
 * 	__the_template()
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
		@var (array) $sidebar
			Registerd sidebars.
		@var (array) $hook
			Collection of hooks that is being registered (that is, actions or filters).
	*/
	private static $_class = '';
	private static $_index = '';
	private static $_param = array();
	private $sidebar = array();
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
		$this->sidebar = $this->set_sidebar();

		// Register hooks.
		$this->hook = $this->set_hook();
		$this->invoke_hook($this->hook);

	}// Method


	/* Setter
	_________________________
	*/
	private function set_sidebar()
	{
		/**
			@access (private)
				Set registerd sidebar.
			@return (array)
				_filter[_app_dynamic_sidebar][sidebar]
			@reference
				[Parent]/inc/setup/widget-area.php
				[Parent]/inc/utility/general.php
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		$return = _setup_widget_area::__get_setting();

		/**
		 * @reference (Beans)
		 * 	Call the functions added to a filter hook.
		 * 	https://www.getbeans.io/code-reference/functions/beans_apply_filters/
		*/
		if(!empty($return)){
			return beans_apply_filters("_filter[{$class}][{$function}]",$return);
		}
		else{
			return beans_apply_filters("_filter[{$class}][{$function}]",array());
		}

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
				_filter[_app_dynamic_sidebar][hook]
			@reference
				[Parent]/inc/setup/constant.php
				[Parent]/inc/trait/hook.php
				[Parent]/inc/utility/general.php
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);
		$index = str_replace('_','-',self::$_index);

		$location = self::$_param['class'];

		/**
		 * @reference (Beans)
		 * 	Call the functions added to a filter hook.
		 * 	https://www.getbeans.io/code-reference/functions/beans_apply_filters/
		*/
		return beans_apply_filters("_filter[{$class}][{$function}]",$this->set_parameter_callback(array(
			'__the_render' => array(
				'beans_id' => $class . '__the_render',
				'tag' => 'beans_add_action',
				'hook' => "windmill/model/{$index}/{$location}/main"
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
				[Parent]/controller/structure/footer.php
				[Parent]/inc/setup/constant.php
				[Parent]/template/footer/footer.php
		*/
		$index = str_replace('_','-',self::$_index);

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

		$location = self::$_param['class'];

		do_action("windmill/model/{$index}/{$location}/prepend");

		/**
			@hooked
				_app_dynamic_sidebar::__the_render()
			@reference
				[Parent]/model/app/dynamic-sidebar.php
		*/
		do_action("windmill/model/{$index}/{$location}/main");

		do_action("windmill/model/{$index}/{$location}/append");

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
				_app_dynamic_sidebar__the_render
			@reference
				[Parent]/inc/utility/theme.php
		*/
		$class = self::$_class;
		$location = self::$_param['class'];

		/* phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped -- Echoes HTML output. */
		if(__utility_is_beans('widget')){
			foreach($this->sidebar[$location] as $key => $value){
				/**
				 * @reference (Beans)
				 * 	Check whether a widget area is registered.
				 * 	https://www.getbeans.io/code-reference/functions/beans_has_widget_area/
				 * 	Retrieve data from the current widget area in use.
				 * 	https://www.getbeans.io/code-reference/functions/beans_get_widget_area/
				*/
				if(beans_has_widget_area($key)){
					echo beans_get_widget_area_output($key);
				}
			}
		}
		else{
			foreach($this->sidebar[$location] as $key => $value){
				/**
				 * @reference (WP)
				 * 	Determines whether a sidebar contains widgets.
				 * 	https://developer.wordpress.org/reference/functions/is_active_sidebar/
				 * 	Display dynamic sidebar.
				 * 	https://developer.wordpress.org/reference/functions/dynamic_sidebar/
				*/
				if(is_active_sidebar($key)){
					dynamic_sidebar($key);
				}
			}
		}

	}// Method


}// Class
endif;
// new _app_dynamic_sidebar();
_app_dynamic_sidebar::__get_instance();
