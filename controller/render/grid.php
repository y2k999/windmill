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
if(class_exists('_render_grid') === FALSE) :
class _render_grid
{
/**
 * [TOC]
 * 	__get_instance()
 * 	__construct()
 * 	set_property()
 * 	set_attribute()
 * 	set_hook()
 * 	invoke_hook()
 * 	__the_property_default()
 * 	__the_property_prepend_masthead()
 * 	__the_property_main_masthead()
 * 	__the_property_append_masthead()
 * 	__the_property_prepend_colophone()
 * 	__the_property_main_colophone()
 * 	__the_property_append_colophone()
 * 	__the_attribute()
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
				Set Uikit grid css properties.
			@return (array)
				_filter[_render_grid][property]
			@reference (Uikit)
				https://getuikit.com/docs/flex
				https://getuikit.com/docs/grid
			@reference
				[Parent]/inc/customizer/option.php
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
				'class' => 'uk-grid-small'
			),
			'even' => array(
				'class' => 'uk-grid-small uk-grid-match uk-child-width-expand'
			),
			'quarter' => array(
				'class' => 'uk-grid-small uk-grid-match uk-child-width-1-2@s uk-child-width-1-4@m'
			),
			'third' => array(
				'class' => 'uk-grid-small uk-grid-match uk-child-width-auto@s uk-child-width-1-3@m'
			),
			'half' => array(
				'class' => 'uk-grid-small uk-grid-match uk-child-width-auto@s uk-child-width-1-2@m'
			),
			'masthead' => array(
				// 'class' => 'uk-grid-small uk-grid-match uk-flex uk-flex-wrap-around'
				'class' => 'uk-grid-small uk-grid-match uk-flex'
			),
			'colophone' => array(
				'class' => 'uk-grid-small uk-grid-match uk-flex'
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
				Set css attributes for grid.
			@return (array)
				_filter[_render_grid][attribute]
			@reference (Uikit)
				https://getuikit.com/docs/grid
			@reference
				[Parent]/inc/utility/general.php
				[Parent]/inc/utility/theme.php
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		/**
		 * @reference (Beans)
		 * 	Call the functions added to a filter hook.
		 * 	https://www.getbeans.io/code-reference/functions/beans_apply_filters/
		*/
		if(__utility_is_uikit()){
			return beans_apply_filters("_filter[{$class}][{$function}]",array(
				'uk-grid' => 'uk-grid'
			));
		}
		else{
			return beans_apply_filters("_filter[{$class}][{$function}]",array());
		}

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
				_filter[_render_grid][hook]
			@reference
				[Parent]/inc/setup/constant.php
				[Parent]/inc/utility/general.php
				[Parent]/template/header/header.php
				[Parent]/template/content/404.php
				[Parent]/template/content/archive.php
				[Parent]/template/content/index.php
				[Parent]/template/content/singular.php
				[Parent]/template/sidebar/sidebar.php
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
				'default' => array(
					'hook' => '_property[grid][default]',
					'callback' => '__the_property_default',
					'priority' => PRIORITY['mid-low'],
				),
				'masthead_prepend' => array(
					'hook' => '_property[grid][masthead][prepend]',
					'callback' => '__the_property_prepend_masthead',
					'priority' => PRIORITY['mid-low'],
				),
				'masthead_main' => array(
					'hook' => '_property[grid][masthead][main]',
					'callback' => '__the_property_main_masthead',
					'priority' => PRIORITY['mid-low'],
				),
				'masthead_append' => array(
					'hook' => '_property[grid][masthead][append]',
					'callback' => '__the_property_append_masthead',
					'priority' => PRIORITY['mid-low'],
				),
				'colophone_prepend' => array(
					'hook' => '_property[grid][colophone][prepend]',
					'callback' => '__the_property_prepend_colophone',
					'priority' => PRIORITY['mid-low'],
				),
				'colophone_main' => array(
					'hook' => '_property[grid][colophone][main]',
					'callback' => '__the_property_main_colophone',
					'priority' => PRIORITY['mid-low'],
				),
				'colophone_append' => array(
					'hook' => '_property[grid][colophone][append]',
					'callback' => '__the_property_append_colophone',
					'priority' => PRIORITY['mid-low'],
				),
			),
			'attribute' => array(
				'default' => array(
					'hook' => '_attribute[grid]',
					'callback' => '__the_attribute',
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
			[Parent]/template/content/archive.php
	*/
	public static function __the_property_default()
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
			[Parent]/template/header/header.php
	*/
	public static function __the_property_prepend_masthead()
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
			[Parent]/template/header/header.php
	*/
	public static function __the_property_main_masthead()
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
			[Parent]/template/header/header.php
	*/
	public static function __the_property_append_masthead()
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
	public static function __the_property_prepend_colophone()
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
	public static function __the_property_main_colophone()
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
	public static function __the_property_append_colophone()
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
			[Parent]/template/content/404.php
			[Parent]/template/content/archive.php
			[Parent]/template/content/index.php
			[Parent]/template/content/singular.php
			[Parent]/template/footer/footer.php
	*/
	public static function __the_attribute()
	{
		// $function = __utility_get_function(__FUNCTION__);
		echo ' ' . __utility_markup(self::$_attribute);

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
				 - colophone
				 - secondary
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
				return self::$_attribute;
				break;
		}

	}// Method


}// Class
endif;
// new _render_grid();
_render_grid::__get_instance();
