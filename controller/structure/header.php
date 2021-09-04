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
if(class_exists('_structure_header') === FALSE) :
class _structure_header
{
/**
 * [TOC]
 * 	__get_instance()
 * 	__construct()
 * 	set_icon()
 * 	set_param()
 * 	set_sidebar()
 * 	set_hook()
 * 	invoke_hook()
 * 	__the_dynamic_sidebar()
 * 	__the_loader()
 * 	__the_branding()
 * 	__the_icon()
*/

	/**
		@access(private)
			Class properties.
		@var (string) $_class
			Name/Identifier with prefix.
		@var (string) $_index
			Name/Identifier without prefix.
		@var (array) $icon
			The icons on Topbar.
		@var (array) $_param
			Parameter for applications.
		@var (array) $sidebar
			Sidebars stored in array by sidebar ID.
		@var (array) $hook
			Collection of hooks that is being registered (that is, actions or filters).
	*/
	private static $_class = '';
	private static $_index = '';
	private $icon = array();
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
		$this->icon = $this->set_icon();
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
				_filter[_structure_header][param]
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
				_filter[_structure_header][sidebar]
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
	private function set_icon()
	{
		/**
			@access (private)
				Set the icons for the topbar.
			@return (array)
				_filter[_structure_header][icon]
			@reference
				[Parent]/inc/customizer/option.php
				[Parent]/inc/utility/general.php
				[Parent]/inc/utility/theme.php
				[Parent]/model/data/icon.php
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		$return = array();
		foreach(__utility_get_value('icon_header') as $item){
			$return[$item] = __utility_get_icon($item);
		}

		/**
		 * @reference (Beans)
		 * 	Call the functions added to a filter hook.
		 * 	https://www.getbeans.io/code-reference/functions/beans_apply_filters/
		*/
		return beans_apply_filters("_filter[{$class}][{$function}]",$return);

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
				_filter[_structure_header][hook]
			@reference
				[Parent]/inc/setup/constant.php
				[Parent]/inc/utility/general.php
				[Parent]/template/header/header.php
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		/**
		 * @reference (Beans)
		 * 	Call the functions added to a filter hook.
		 * 	https://www.getbeans.io/code-reference/functions/beans_apply_filters/
		*/
		return beans_apply_filters("_filter[{$class}][{$function}]",array(
			'dynamic_sidebar' => array(
				'beans_id' => $class . '__the_dynamic_sidebar',
				'hook' => HOOK_POINT['masthead']['main'],
				'callback' => '__the_dynamic_sidebar',
				'priority' => PRIORITY['default'],
			),
			'branding' => array(
				'beans_id' => $class . '__the_branding',
				'hook' => HOOK_POINT['masthead']['main'],
				'callback' => '__the_branding',
				'priority' => PRIORITY['default'],
			),
			'icon' => array(
				'beans_id' => $class . '__the_icon',
				'hook' => HOOK_POINT['masthead']['main'],
				'callback' => '__the_icon',
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
			Display the sidebar containing the widget area.
		@hook (beans id)
			_structure_header__the_dynamic_sidebar
		@reference
			[Parent]/inc/setup/constant.php
			[Parent]/inc/trait/theme.php
			[Parent]/inc/utility/general.php
	*/
	public function __the_dynamic_sidebar()
	{
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
			Display header site branding.
		@hook (beans id)
			_structure_header__the_branding
		@reference
			[Parent]/inc/setup/constant.php
			[Parent]/inc/trait/theme.php
			[Parent]/inc/utility/general.php
	*/
	public function __the_branding()
	{
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
			Display header icon.
		@hook (beans id)
			_structure_header__the_icon
		@reference (Uikit)
			https://getuikit.com/docs/navbar
			https://getuikit.com/docs/list
		@reference
			[Parent]/inc/customizer/option.php
			[Parent]/inc/trait/theme.php
			[Parent]/inc/utility/general.php
	*/
	public function __the_icon()
	{
		if(!__utility_get_value('icon_header')){return;}
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		/**
		 * @reference (Beans)
		 * 	HTML markup.
		 * 	https://www.getbeans.io/code-reference/functions/beans_open_markup_e/
		 * 	https://www.getbeans.io/code-reference/functions/beans_close_markup_e/
		 * 
		 * @reference (Uikit)
		 * 	https://getuikit.com/docs/flex
		 * 	https://getuikit.com/docs/list
		 * 	https://getuikit.com/docs/navbar
		*/

		// Navbar Right.
		beans_open_markup_e("_column[{$class}][{$function}]",'div',__utility_get_column('default',array('class' => 'uk-navbar-right uk-visible@m')));
			beans_open_markup_e("_list[{$class}][{$function}]",'ul',array('class' => 'uk-list uk-flex uk-flex-middle ' . $function));

				foreach($this->icon as $key => $value){
					beans_open_markup_e("_item[{$class}][{$function}][{$key}]",'li',array('class' => 'uk-padding-small uk-padding-remove-vertical uk-margin-remove-vertical ' . $key));
						self::__activate_application($key,$this->param);
					beans_close_markup_e("_item[{$class}][{$function}][{$key}]",'li');
				}

			beans_close_markup_e("_list[{$class}][{$function}]",'ul');
		beans_close_markup_e("_column[{$class}][{$function}]",'div');

	}// Method


}// Class
endif;
// new _structure_header();
_structure_header::__get_instance();
