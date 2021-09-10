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
if(class_exists('_app_follow') === FALSE) :
class _app_follow
{
/**
 * [TOC]
 * 	__get_instance()
 * 	__construct()
 * 	set_icon()
 * 	set_param()
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
		@var (array) $icon
			Icons for SNS services.
		@var (array) $hook
			Collection of hooks that is being registered (that is, actions or filters).
	*/
	private static $_class = '';
	private static $_index = '';
	private static $_param = array();
	private $icon = array();
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
		self::$_index = __utility_get_index(get_class($this));
		self::$_param = $this->set_param(self::$_index);

		$this->icon = $this->set_icon();

		// Register hooks.
		$this->hook = $this->set_hook();
		$this->invoke_hook($this->hook);

	}// Method


	/* Setter
	_________________________
	*/
	private function set_icon()
	{
		/**
			@access (private)
				Set icons for the SNS follow services.
			@return (array)
				_filter[_app_follow][icon]
			@reference
				[Parent]/inc/customizer/option.php
				[Parent]/inc/utility/general.php
				[Parent]/inc/utility/theme.php
				[Parent]/model/data/icon.php
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		$return = array();
		foreach(__utility_get_value(self::$_index) as $item){
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
				_filter[_app_credit][hook]
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
				[Parent]/asset/inline/follow.php
				[Parent]/inc/setup/constant.php
				[Parent]/model/widget/profile.php
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
		 * @reference (Beans)
		 * 	HTML markup.
		 * 	https://www.getbeans.io/code-reference/functions/beans_open_markup_e/
		 * 	https://www.getbeans.io/code-reference/functions/beans_close_markup_e/
		*/
		beans_open_markup_e("_wrapper[{$class}]",'div',array(
			'class' => self::$_index,
			'itemscope' => 'itemscope',
			'itemtype' => 'https://schema.org/Person',
		));
			beans_open_markup_e("_list[{$class}]",'div',array('class' => self::$_param['skin']));

				do_action(HOOK_POINT['model'][$index]['main']);

			beans_close_markup_e("_list[{$class}]",'div');
		beans_close_markup_e("_wrapper[{$class}]",'div');

		do_action(HOOK_POINT['model'][$index]['append']);

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
				_app_follow__the_render
			@reference
				[Parent]/inc/customizer/option.php
				[Parent]/inc/utility/general.php
		*/
		if(empty($this->icon)){return;}

		$class = self::$_class;

		/**
		 * @reference (Beans)
		 * 	HTML markup.
		 * 	https://www.getbeans.io/code-reference/functions/beans_open_markup_e/
		 * 	https://www.getbeans.io/code-reference/functions/beans_output_e/
		 * 	https://www.getbeans.io/code-reference/functions/beans_close_markup_e/
		*/
		foreach($this->icon as $key => $value){
			if($key === 'mail'){
				$href = get_bloginfo('admin_mail');
			}
			else{
				$href = __utility_get_option('url_' . $key);
			}
			beans_open_markup_e("_link[{$class}][{$key}]",'a',array(
				'class' => self::$_index . '-' . $key,
				'href' => $href,
				'target' => '_blank',
				'title' => $key,
				'aria-label' => ucfirst($key),
				'rel' => 'noopener noreferrer',
				'itemprop' => 'sameAs',
			));
				beans_output_e("_output[{$class}][{$key}]",$value);
			beans_close_markup_e("_link[{$class}][{$key}]",'a');
		}

	}// Method


}// Class
endif;
// new _app_follow();
_app_follow::__get_instance();
