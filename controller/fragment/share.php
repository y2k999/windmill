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
if(class_exists('_fragment_share') === FALSE) :
class _fragment_share
{
/**
 * [TOC]
 * 	__get_instance()
 * 	__construct()
 * 	set_hook()
 * 	invoke_hook()
 * 	__the_page()
 * 	__the_single()
 * 	render()
*/

	/**
		@access(private)
			Class properties.
		@var (string) $_class
			Name/Identifier with prefix.
		@var (string) $_index
			Name/Identifier without prefix.
		@var (array) $hook
			Collection of hooks that is being registered (that is, actions or filters).
	*/
	private static $_class = '';
	private static $_index = '';
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

		// Register hooks.
		$this->hook = $this->set_hook();
		$this->invoke_hook();

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
				_filter[_fragment_share][hook]
			@reference
				[Parent]/inc/setup/constant.php
				[Parent]/inc/utility/general.php
				[Parent]/template-part/content/content.php
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
			'page' => array(
				'beans_id' => $class . '__the_page',
				'hook' => HOOK_POINT['page']['header']['before'],
				'callback' => '__the_page',
				'priority' => PRIORITY['default'],
			),
			'single' => array(
				'beans_id' => $class . '__the_single',
				'hook' => HOOK_POINT['single']['header']['before'],
				'callback' => '__the_single',
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
			Display the share buttons on single pages.
		@hook (beans id)
			_fragment_share__the_page
		@reference
			[Parent]/template-part/content/content-page.php
	*/
	public function __the_page()
	{
		/**
		 * @reference (WP)
		 * 	Determines whether the query is for an existing single post of any post type (post, attachment, page, custom post types).
		 * 	https://developer.wordpress.org/reference/functions/is_singular/
		*/
		if(!is_singular('page')){return;}
		$this->render();

	}// Method


	/**
		@access (public)
			Display the share buttons on single posts.
		@hook (beans id)
			_fragment_share__the_single
		@reference
			[Parent]/template-part/content/content.php
	*/
	public function __the_single()
	{
		/**
		 * @reference (WP)
		 * 	Determines whether the query is for an existing single post of any post type (post, attachment, page, custom post types).
		 * 	https://developer.wordpress.org/reference/functions/is_singular/
		*/
		if(!is_singular('post')){return;}
		$this->render();

	}// Method


	/* Method
	_________________________
	*/
	private function render()
	{
		/**
			@access (private)
				Load and echo the designated application.
			@param (string) $needle
				Content type of Item format.
			@return (void)
			@reference
				[Parent]/customizer/option.php
				[Parent]/inc/trait/theme.php
				[Parent]/inc/utility/general.php
				[Parent]/moduel/app/share.php
		*/
		if(__utility_is_archive()){return;}
		if(empty(__utility_get_value(self::$_index))){return;}

		self::__activate_application(self::$_index);

	}// Method


}// Class
endif;
// new _fragment_share();
_fragment_share::__get_instance();
