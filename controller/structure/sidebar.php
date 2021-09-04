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
if(class_exists('_structure_sidebar') === FALSE) :
class _structure_sidebar
{
/**
 * [TOC]
 * 	__get_instance()
 * 	__construct()
 * 	set_param()
 * 	set_sidebar()
 * 	set_hook()
 * 	invoke_hook()
 * 	__the_dynamic_sidebar()
 * 	__the_profile()
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
				_filter[_structure_sidebar][param]
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
				_filter[_structure_sidebar][sidebar]
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
		return beans_apply_filters("_filter[{$class}][{$function}]",_setup_widget_area::__get_setting(self::$_index));

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
				_filter[_structure_sidebar][hook]
			@reference
				[Parent]/inc/setup/constant.php
				[Parent]/inc/utility/general.php
				[Parent]/template/sidebar/sidebar.php
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		/**
		 * @reference (Beans)
		 * 	Call the functions added to a filter hook.
		 * 	https://www.getbeans.io/code-reference/functions/beans_apply_filters/
		*/
		return beans_apply_filters("_filter[{$class}][{$function}]",array(
			'open_sticky' => array(
				'beans_id' => $class . '__the_open_sticky',
				'hook' => HOOK_POINT['secondary']['prepend'],
				'callback' => '__the_open_sticky',
				'priority' => PRIORITY['mid-low'],
			),
			'dynamic_sidebar' => array(
				'beans_id' => $class . '__the_dynamic_sidebar',
				'hook' => HOOK_POINT['secondary']['main'],
				'callback' => '__the_dynamic_sidebar',
				'priority' => PRIORITY['default'],
			),
			'profile' => array(
				'beans_id' => $class . '__the_profile',
				'hook' => HOOK_POINT['secondary']['main'],
				'callback' => '__the_profile',
				'priority' => PRIORITY['default'],
			),
			'close_sticky' => array(
				'beans_id' => $class . '__the_close_sticky',
				'hook' => HOOK_POINT['secondary']['append'],
				'callback' => '__the_close_sticky',
				'priority' => PRIORITY['mid-high'],
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
			Echo open markup and attributes of fixed sidebar.
		@hook (beans id)
			_structure_sidebar__the_open_sticky
		@reference
			[Parent]/inc/customizer/option.php
			[Parent]/inc/setup/constant.php
			[Parent]/inc/utility/general.php
	*/
	public function __the_open_sticky()
	{
		if(__utility_is_one_column()){return;}
		if(!__utility_get_option('fixed_sidebar')){return;}

		$class = self::$_class;
		// $function = __utility_get_function(__FUNCTION__);

		/**
		 * @reference (Beans)
		 * 	HTML markup.
		 * 	https://www.getbeans.io/code-reference/functions/beans_open_markup_e/
		 * 
		 * @reference (Uikit)
		 * 	https://getuikit.com/docs/scrollspy
		 * 	https://getuikit.com/docs/sticky
		*/
		beans_open_markup_e("_wrap[{$class}][sticky]",'div',array('uk-sticky' => 'offset: 40; bottom: #primary;'));
			beans_open_markup_e("_wrap[{$class}]scrollspy]",'div',array('uk-scrollspy-nav' => 'closest: a; scroll: true; offset: 40;'));

	}// Method


	/**
		@access (public)
			Echo close markup and attributes of fixed sidebar.
		@hook (beans id)
			_structure_sidebar__the_open_sticky
		@reference
			[Parent]/inc/customizer/option.php
			[Parent]/inc/setup/constant.php
			[Parent]/inc/utility/general.php
	*/
	public function __the_close_sticky()
	{
		if(__utility_is_one_column()){return;}
		if(!__utility_get_option('fixed_sidebar')){return;}

		$class = self::$_class;
		// $function = __utility_get_function(__FUNCTION__);

		/**
		 * @reference (Beans)
		 * 	HTML markup.
		 * 	https://www.getbeans.io/code-reference/functions/beans_close_markup_e/
		*/
			beans_close_markup_e("_wrap[{$class}][scrollspy]",'div');
		beans_close_markup_e("_wrap[{$class}][sticky]",'div');

	}// Method


	/**
		@access (public)
			Display dynamic sidebar.
		@hook (beans id)
			_structure_sidebar__the_dynamic_sidebar
		@reference
			[Parent]/inc/setup/constant.php
			[Parent]/inc/trait/theme.php
			[Parent]/inc/utility/general.php
	*/
	public function __the_dynamic_sidebar()
	{
		if(__utility_is_one_column()){return;}
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
			Display the author profile.
		@hook (beans id)
			_structure_sidebar__the_profile
		@note
			This is specific setting for this theme.
		@reference
			[Parent]/inc/setup/constant.php
			[Parent]/inc/trait/theme.php
			[Parent]/inc/utility/general.php
	*/
	public function __the_profile()
	{
		if(__utility_is_one_column()){return;}
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
// new _structure_sidebar();
_structure_sidebar::__get_instance();
