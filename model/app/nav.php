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
if(class_exists('_app_nav') === FALSE) :
class _app_nav
{
/**
 * [TOC]
 * 	__get_instance()
 * 	__construct()
 * 	set_param()
 * 	set_theme_location()
 * 	set_hook()
 * 	invoke_hook()
 * 	__the_template()
 * 	__the_render()
 * 	__the_icon()
 * 	the_offcanvas()
 * 	the_primary()
 * 	the_secondary()
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
		@var (array) $theme_location
			Theme location to be used.
		@var (array) $hook
			Collection of hooks that is being registered (that is, actions or filters).
	*/
	private static $_class = '';
	private static $_index = '';
	private static $_param = array();
	private $theme_location = array();
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
		$this->theme_location = $this->set_theme_location();

		// Register hooks.
		$this->hook = $this->set_hook();
		$this->invoke_hook($this->hook);

	}// Method


	/* Setter
	_________________________
	*/
	private function set_theme_location()
	{
		/**
			@access (private)
				Set theme location to be used.
				Must be registered with register_nav_menu() in order to be selectable by the user.
			@return (array)
				_filter[_app_nav][theme_location]
			@reference
				[Parent]/inc/setup/theme-support.php
				[Parent]/inc/utility/general.php
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		/**
		 * @reference (Beans)
		 * 	Call the functions added to a filter hook.
		 * 	https://www.getbeans.io/code-reference/functions/beans_apply_filters/
		*/
		return beans_apply_filters("_filter[{$class}][{$function}]",_setup_theme_support::__get_theme_location());

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
				_filter[_app_nav][hook]
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
				'hook' => HOOK_POINT[$index]['offcanvas']['prepend']
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
				[Parent]/controller/structure/footer.php
				[Parent]/controller/structure/header.php
				[Parent]/inc/env/menu.php
				[Parent]/inc/setup/constant.php
				[Parent]/template/footer/footer.php
				[Parent]/template/header/header.php
		*/
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
				__wrap_nav_secondary_prepend()
			@reference
				[Parent]/model/wrap/nav.php
		*/
		do_action(HOOK_POINT['model'][$index]['prepend']);

		/**
			@hooked
				_app_nav::__the_render()
			@reference
				[Parent]/model/app/nav.php
		*/
		do_action(HOOK_POINT['model'][$index]['main']);

		/**
			@hooked
				__wrap_nav_secondary_append()
			@reference
				[Parent]/model/wrap/nav.php
		*/
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
				_app_nav__the_render
			@reference
				[Parent]/inc/utility/theme.php
		*/
		$class = self::$_class;

		switch(self::$_param['class']){
			case 'header' :
				if(__utility_is_uikit()){
					$this->the_offcanvas();
				}
				else{
					$this->the_primary();
				}
				break;

			case 'footer' :
				$this->the_secondary();
				break;

			default :
				break;
		}

	}// Method


	/* Hook
	_________________________
	*/
	public function __the_icon()
	{
		/**
			@access (public)
				Render offcanvas toggle (icon).
			@return (void)
			@hook (beans id)
				_app_nav__the_icon
			@reference
				[Parent]/inc/utility/general.php
				[Parent]/inc/utility/theme.php
		*/
		if(self::$_param['class'] !== 'header'){return;}
		if(!__utility_is_uikit()){return;}

		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		/**
		 * @reference (Beans)
		 * 	HTML markup.
		 * 	https://www.getbeans.io/code-reference/functions/beans_output_e/
		 * @reference (Uikit)
		 * 	https://getuikit.com/docs/navbar
		 * 	https://getuikit.com/docs/toggle
		*/
		beans_output_e("_output[{$class}][{$function}]",sprintf(
			'<a href="%1$s" title="%2$s" class="uk-navbar-toggle uk-padding-remove uk-margin-remove" uk-toggle uk-navbar-toggle-icon></a>',
			$href = '#offcanvas-nav',
			$title = esc_attr('Navbar Toggle Icon'),
		));

	}// Method


	/**
		@access (private)
			Echo the Uikit offcanvas navigation.
		@return (void)
		@reference
			[Parent]/inc/plugin/walker/offcanvas.php
			[Parent]/inc/setup/constant.php
			[Parent]/inc/utility/general.php
			[Parent]/inc/utility/theme.php
			[Parent]/template-part/navwalker/navwalker-offcanvas.php
	*/
	private function the_offcanvas()
	{
		if(self::$_param['class'] !== 'header'){return;}
		if(!__utility_is_uikit()){return;}

		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		// Load navwalker.
		get_template_part(SLUG['plugin'] . 'navwalker/navwalker-offcanvas');

		do_action(HOOK_POINT[self::$_index][$function]['prepend']);

		/**
		 * @reference (Beans)
		 * 	HTML markup.
		 * 	https://www.getbeans.io/code-reference/functions/beans_open_markup_e/
		 * 	https://www.getbeans.io/code-reference/functions/beans_close_markup_e/
		 * @reference (Uikit)
		 * 	https://getuikit.com/docs/icon
		 * 	https://getuikit.com/docs/offcanvas
		*/
		beans_open_markup_e("_effect[{$class}][{$function}]",'div',array(
			'id' => 'offcanvas-nav',
			'uk-offcanvas' => 'flip: true; overlay: false',
		));
			beans_open_markup_e("_wrapper[{$class}][{$function}]",'div',array('class' => 'uk-offcanvas-bar uk-offcanvas-bar-animation uk-offcanvas-slide'));

				beans_open_markup_e("_button[{$class}][{$function}]",'button',array(
					'type' => 'button',
					'class' => 'uk-offcanvas-close uk-close uk-icon',
					'uk-close' => '',
				));
				beans_close_markup_e("_button[{$class}][{$function}]",'button');

				/**
				 * @reference (WP)
				 * 	Loads a template part into a template.
				 * 	https://developer.wordpress.org/reference/functions/get_template_part/
				*/
				get_template_part(SLUG[self::$_index] . 'nav-' . $function);

			beans_close_markup_e("_wrapper[{$class}][{$function}]",'div');

		beans_close_markup_e("_effect[{$class}][{$function}]",'div');

		do_action(HOOK_POINT[self::$_index][$function]['append']);

	}// Method


	/**
		@access (private)
			Echo the primary navigation.
		@return (void)
		@reference
			[Parent]/inc/setup/constant.php
			[Parent]/inc/utility/general.php
			[Parent]/inc/utility/theme.php
			[Parent]/template-part/nav/primary.php
	*/
	private function the_primary()
	{
		if(self::$_param['class'] !== 'header'){return;}
		if(__utility_is_uikit()){return;}

		$function = __utility_get_function(__FUNCTION__);

		// Load navwalker.
		get_template_part(SLUG['plugin'] . 'navwalker/navwalker-primary');

		do_action(HOOK_POINT[self::$_index][$function]['prepend']);

		/**
		 * @reference (WP)
		 * 	Loads a template part into a template.
		 * 	https://developer.wordpress.org/reference/functions/get_template_part/
		*/
		get_template_part(SLUG[self::$_index] . 'nav-' . $function);

		do_action(HOOK_POINT[self::$_index][$function]['append']);

	}// Method


	/**
		@access (private)
			Echo the secondary navigation.
		@return (void)
		@reference
			[Parent]/inc/setup/constant.php
			[Parent]/inc/utility/general.php
			[Parent]/template-part/nav/secondary.php
	*/
	private function the_secondary()
	{
		if(self::$_param['class'] !== 'footer'){return;}
		if(wp_is_mobile()){return;}
		if(__utility_is_mobile()){return;}

		$function = __utility_get_function(__FUNCTION__);

		do_action(HOOK_POINT[self::$_index][$function]['prepend']);

		/**
		 * @reference (WP)
		 * 	Loads a template part into a template.
		 * 	https://developer.wordpress.org/reference/functions/get_template_part/
		*/
		get_template_part(SLUG[self::$_index] . 'nav-' . $function);

		do_action(HOOK_POINT[self::$_index][$function]['append']);

	}// Method


}// Class
endif;
// new _app_nav();
_app_nav::__get_instance();
