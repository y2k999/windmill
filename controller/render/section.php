<?php
/**
 * Core class/function as application root.
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
if(class_exists('_render_section') === FALSE) :
class _render_section
{
/**
 * [TOC]
 * 	__get_instance()
 * 	__construct()
 * 	set_property()
 * 	set_hook()
 * 	invoke_hook()
 * 	__the_masthead()
 * 	__the_content()
 * 	__the_colophone()
*/

	/**
		@access(private)
			Class properties.
		@var (string) $_class
			Name/Identifier with prefix.
		@var (string) $_index
			Name/Identifier without prefix.
		@var (array) $_property
			CSS properties.
		@var (array) $hook
			Collection of hooks that is being registered (that is, actions or filters).
	*/
	private static $_class = '';
	private static $_index = '';
	private static $_property = array();
	private $hook = array();

	/**
	 * Traits.
	*/
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
		*/

		// Init properties.
		self::$_class = __utility_get_class(get_class($this));
		self::$_index = __utility_get_index(self::$_class);
		self::$_property = $this->set_property();

		// Register hooks.
		$this->hook = $this->set_hook();
		$this->invoke_hook();

	}//Method


	/* Setter
	_________________________
	*/
	private function set_property()
	{
		/**
			@access (private)
				Set Uikit section css properties.
			@return (array)
				_filter[_render_section][property]
			@reference (Uikit)
				https://getuikit.com/docs/section
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
			'default' => array(
				'class' => 'uk-section-default'
			),
			'masthead' => array(
				'class' => 'uk-section-default uk-section-xsmall uk-padding-remove-top uk-margin-remove-top'
			),
			'content' => array(
				'class' => 'uk-section-default uk-section-xsmall uk-margin-remove-top'
			),
			'colophone' => array(
				'class' => 'uk-section-default uk-section-xsmall uk-margin-remove-top'
			),
		));

	}//Method


	/* Setter
	_________________________
	*/
	private function set_hook()
	{
		/**
			@access (private)
				The collection of hooks that is being registered (that is, actions or filters).
			@return (array)
				_filter[_render_section][hook]
			@reference
				[Parent]/inc/setup/constant.php
				[Parent]/inc/utility/general.php
				[Parent]/template/header/header.php
				[Parent]/template/content/404.php
				[Parent]/template/content/archive.php
				[Parent]/template/content/index.php
				[Parent]/template/content/singular.php
				[Parent]/template/footer/footer.php
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		/**
		 * @reference (Beans)
		 * 	Call the functions added to a filter hook.
		 * 	https://www.getbeans.io/code-reference/functions/beans_apply_filters/
		*/
		return beans_apply_filters("_filter[{$class}][{$function}]",array(
			'masthead' => array(
				'hook' => '_property[section][masthead]',
				'callback' => '__the_masthead',
				'priority' => PRIORITY['mid-low'],
			),
			'content' => array(
				'hook' => '_property[section][content]',
				'callback' => '__the_content',
				'priority' => PRIORITY['mid-low'],
			),
			'colophone' => array(
				'hook' => '_property[section][colophone]',
				'callback' => '__the_colophone',
				'priority' => PRIORITY['mid-low'],
			),
		));

	}//Method


	/* Method
	_________________________
	*/
	private function invoke_hook()
	{
		/**
			@access (private)
				Adds a callback function to a filter hook.
				https://developer.wordpress.org/reference/functions/add_filter/
			@return (bool)
				Will always return true(Validate action arguments?).
		*/
		if(empty($this->hook)){return;}

		foreach((array)$this->hook as $key => $value){
			/**
			 * @param (string) $hook_name
			 * 	The name of the filter to add the callback to.
			 * @param (callable) $callable
			 * 	The callback to be run when the filter is applied.
			 * @param (int) $priority
			 * 	Used to specify the order in which the functions associated with a particular filter are executed.
			*/
			// add_filter($value['hook'],array($this,$value['callback']),$value['priority']);
			add_filter($value['hook'],array(__CLASS__,$value['callback']),$value['priority']);
		}

	}// Method


	/**
		@access (public)
			Markup properties.
		@reference
			[Parent]/inc/utility/general.php
			[Parent]/template/header/header.php
	*/
	public static function __the_masthead()
	{
		$function = __utility_get_function(__FUNCTION__);
		echo ' ' . __utility_markup(self::$_property[$function]);

	}// Method


	/**
		@access (public)
			Markup properties.
		@reference
			[Parent]/inc/utility/general.php
			[Parent]/template/content/404.php
			[Parent]/template/content/archive.php
			[Parent]/template/content/index.php
			[Parent]/template/content/singular.php
	*/
	public static function __the_content()
	{
		$function = __utility_get_function(__FUNCTION__);
		echo ' ' . __utility_markup(self::$_property[$function]);

	}// Method


	/**
		@access (public)
			Markup properties.
		@reference
			[Parent]/inc/utility/general.php
			[Parent]/template/footer/footer.php
	*/
	public static function __the_colophone()
	{
		$function = __utility_get_function(__FUNCTION__);
		echo ' ' . __utility_markup(self::$_property[$function]);

	}// Method


	/* Method
	_________________________
	*/
	public static function __get_setting($needle = '')
	{
		/**
			@access (public)
				Returns the registerd values (properties/attributes).
			@param (string) $needle
				Accepts 
				 - masthead
				 - content
				 - colophone
			@return (array)
		*/
		if(isset($needle) && array_key_exists($needle,self::$_property)){
			return self::$_property[$needle];
		}
		else{
			return self::$_property;
		}

	}// Method


}// Class
endif;
// new _render_section();
_render_section::__get_instance();
