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
if(class_exists('_render_container') === FALSE) :
class _render_container
{
/**
 * [TOC]
 * 	__get_instance()
 * 	__construct()
 * 	set_property()
 * 	set_attribute()
 * 	set_hook()
 * 	invoke_hook()
 * 	__the_property_masthead()
 * 	__the_property_content()
 * 	__the_property_colophone()
 * 	__the_attribute_masthead()
 * 	__the_attribute_content()
 * 	__the_attribute_colophone()
 * 	__get_setting()
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
		@var (array) $_attribute
			CSS data attributes.
		@var (array) $hook
			Collection of hooks that is being registered (that is, actions or filters).
	*/
	private static $_class = '';
	private static $_index = '';
	private static $_property = array();
	private static $_attribute = array();
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
		self::$_attribute = $this->set_attribute();

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
				Set Uikit container css properties.
			@return (array)
				_filter[_render_container][property]
			@reference (Uikit)
				https://getuikit.com/docs/container
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
				'class' => 'uk-container'
			),
			'masthead' => array(
				'class' => 'uk-container uk-container-expand site-header'
			),
			'content' => array(
				'class' => 'uk-container uk-container-expand site-content'
			),
			'colophone' => array(
				'class' => 'uk-container uk-container-expand site-footer'
			),
		));

	}//Method


	/* Setter
	_________________________
	*/
	private function set_attribute()
	{
		/**
			@access (private)
				Set css attributes for container.
			@return (array)
				_filter[_render_container][attribute]
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
			'masthead' => array(
				'role' => 'banner',
				'itemscope' => 'itemscope',
				'itemtype' => 'https://schema.org/WPHeader',
				'itemprop' => 'publisher',
				'uk-sticky' => 'uk-sticky'
			),
			'content' => array(
				'itemscope' => 'itemscope',
				'itemtype' => 'https://schema.org/WebPage',
			),
			'colophone' => array(
				'role' => 'contentinfo',
				'itemscope' => 'itemscope',
				'itemtype' => 'https://schema.org/WPFooter',
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
				_filter[_render_container][hook]
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
			'property' => array(
				'masthead' => array(
					'hook' => '_property[container][masthead]',
					'callback' => '__the_property_masthead',
					'priority' => PRIORITY['mid-low'],
				),
				'content' => array(
					'hook' => '_property[container][content]',
					'callback' => '__the_property_content',
					'priority' => PRIORITY['mid-low'],
				),
				'colophone' => array(
					'hook' => '_property[container][colophone]',
					'callback' => '__the_property_colophone',
					'priority' => PRIORITY['mid-low'],
				),
			),
			'attribute' => array(
				'masthead' => array(
					'hook' => '_attribute[container][masthead]',
					'callback' => '__the_attribute_masthead',
					'priority' => PRIORITY['mid-low'],
				),
				'content' => array(
					'hook' => '_attribute[container][content]',
					'callback' => '__the_attribute_content',
					'priority' => PRIORITY['mid-low'],
				),
				'colophone' => array(
					'hook' => '_attribute[container][colophone]',
					'callback' => '__the_attribute_colophone',
					'priority' => PRIORITY['mid-low'],
				),
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

		foreach((array)$this->hook as $needle => $array){
			foreach($array as $key => $value){
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
		}

	}// Method


	/**
		@access (public)
			Markup properties.
		@reference
			[Parent]/inc/utility/general.php
			[Parent]/template/header/header.php
	*/
	public static function __the_property_masthead()
	{
		$function = __utility_get_function(__FUNCTION__);
		$exploded = explode('_',$function);
		$end = end($exploded);
		echo ' ' . __utility_markup(self::$_property[$end]);

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
	public static function __the_property_content()
	{
		$function = __utility_get_function(__FUNCTION__);
		$exploded = explode('_',$function);
		$end = end($exploded);
		echo ' ' . __utility_markup(self::$_property[$end]);

	}// Method


	/**
		@access (public)
			Markup properties.
		@reference
			[Parent]/inc/utility/general.php
			[Parent]/template/footer/footer.php
	*/
	public static function __the_property_colophone()
	{
		$function = __utility_get_function(__FUNCTION__);
		$exploded = explode('_',$function);
		$end = end($exploded);
		echo ' ' . __utility_markup(self::$_property[$end]);

	}// Method


	/**
		@access (public)
			Markup attributes.
		@reference
			[Parent]/inc/utility/general.php
			[Parent]/template/header/header.php
	*/
	public static function __the_attribute_masthead()
	{
		$function = __utility_get_function(__FUNCTION__);
		$exploded = explode('_',$function);
		$end = end($exploded);
		echo ' ' . __utility_markup(self::$_attribute[$end]);

	}// Method


	/**
		@access (public)
			Markup attributes.
		@reference
			[Parent]/inc/utility/general.php
			[Parent]/template/content/404.php
			[Parent]/template/content/archive.php
			[Parent]/template/content/index.php
			[Parent]/template/content/singular.php
	*/
	public static function __the_attribute_content()
	{
		$function = __utility_get_function(__FUNCTION__);
		$exploded = explode('_',$function);
		$end = end($exploded);
		echo ' ' . __utility_markup(self::$_attribute[$end]);

	}// Method


	/**
		@access (public)
			Markup attributes.
		@reference
			[Parent]/inc/utility/general.php
			[Parent]/template/footer/footer.php
	*/
	public static function __the_attribute_colophone()
	{
		$function = __utility_get_function(__FUNCTION__);
		$exploded = explode('_',$function);
		$end = end($exploded);
		echo ' ' . __utility_markup(self::$_attribute[$end]);

	}// Method


	/* Method
	_________________________
	*/
	public static function __get_setting($type = '',$needle = '')
	{
		/**
			@access (public)
				Returns the registerd values (properties/attributes).
			@param (string) $type
				Accepts 
				 - property
				 - attribute
			@param (string) $needle
				Accepts 
				 - masthead
				 - content
				 - colophone
			@return (array)
		*/
		if(!isset($type)){return;}

		switch($type){
			case 'property' :
				if(isset($needle) && array_key_exists($needle,self::$_property)){
					return self::$_property[$needle];
				}
				else{
					return self::$_property;
				}
				break;

			case 'attribute' :
				if(isset($needle) && array_key_exists($needle,self::$_attribute)){
					return self::$_attribute[$needle];
				}
				else{
					return self::$_attribute;
				}
				break;
		}

	}// Method


}// Class
endif;
// new _render_container();
_render_container::__get_instance();
