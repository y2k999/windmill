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
if(class_exists('_app_back2top') === FALSE) :
class _app_back2top
{
/**
 * [TOC]
 * 	__get_instance()
 * 	__construct()
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
		@var (array) $hook
			Collection of hooks that is being registered (that is, actions or filters).
	*/
	private static $_class = '';
	private static $_index = '';
	private static $_param = array();
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

		// Register hooks.
		$this->hook = $this->set_hook();
		$this->invoke_hook($this->hook);

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
				_filter[_app_back2top][hook]
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
				[Parent]/controller/structure/footer.php
				[Parent]/inc/setup/constant.php
				[Parent]/template/footer/footer.php
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
				__wrap_back2top_prepend()
			@reference
				[Parent]/model/wrap/back2top.php
		*/
		do_action(HOOK_POINT['model'][$index]['prepend']);

		/**
			@hooked
				_app_back2top::__the_render()
			@reference
				[Parent]/model/app/back2top.php
		*/
		do_action(HOOK_POINT['model'][$index]['main']);

		/**
			@hooked
				__wrap_back2top_append()
			@reference
				[Parent]/model/wrap/back2top.php
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
				Echo the content of the application.
			@return (void)
			@hook (beans id)
				_app_back2top__the_render
			@reference
				[Parent]/inc/utility/theme.php
		*/
		$class = self::$_class;

		/**
		 * @reference (Beans)
		 * 	Echo output registered by ID.
		 * 	https://www.getbeans.io/code-reference/functions/beans_output_e/
		 * @reference (Uikit)
		 * 	https://getuikit.com/docs/position
		 * 	https://getuikit.com/docs/visibility
		*/
		// beans_open_markup_e("_effect[{$class}]",'div',array('uk-scrollspy' => 'target: > .back2top; cls: uk-animation-fade; hidden: true; delay: 1500'));

		beans_open_markup_e("_link[{$class}]",'a',array(
			'href' => '',
			'id' => 'back2top',
			'class' => 'back2top uk-padding-small',
			'uk-totop' => '',
			'uk-scroll' => '',
			'uk-scrollspy' => 'cls: uk-animation-fade; hidden: true; delay: 1500',
		));
		beans_close_markup_e("_link[{$class}]",'a');

		// beans_close_markup_e("_effect[{$class}]",'div');

		// beans_output_e("_output[{$class}]",'<a href="" id="back2top" class="uk-padding-small" uk-totop uk-scroll></a>');

	}// Method


}// Class
endif;
// new _app_back2top();
_app_back2top::__get_instance();
