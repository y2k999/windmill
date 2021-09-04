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
if(class_exists('_render_column') === FALSE) :
class _render_column
{
/**
 * [TOC]
 * 	__get_instance()
 * 	__construct()
 * 	set_layout()
 * 	set_property()
 * 	set_attribute()
 * 	set_hook()
 * 	invoke_hook()
 * 	__the_property_primary()
 * 	__the_property_secondary()
 * 	__the_attribute_primary()
 * 	__the_attribute_secondary()
 * 	__get_setting()
*/

	/**
		@access(private)
			Class properties.
		@var (string) $_class
			Name/Identifier with prefix.
		@var (string) $_index
			Name/Identifier without prefix.
		@var (array) $_layout
			Page layout settings.
		@var (array) $_property
			CSS properties.
		@var (array) $_attribute
			CSS data attributes.
		@var (array) $hook
			Collection of hooks that is being registered (that is, actions or filters).
	*/
	private static $_class = '';
	private static $_index = '';
	private static $_layout = array();
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
		self::$_layout = $this->set_layout();
		self::$_property = $this->set_property();
		self::$_attribute = $this->set_attribute();

		// Register hooks.
		$this->hook = $this->set_hook();
		$this->invoke_hook();

	}//Method


	/* Setter
	_________________________
	*/
	private function set_layout()
	{
		/**
			@access (private)
				Set page layout settings from the Beans Extension plugin.
			@return (array)
				_filter[_render_column][layout]
			@reference
				[Parent]/inc/utility/general.php
				[Plugin]/beans_extension/admin/tab/layout.php
				[Plugin]/beans_extension/api/layout/beans.php
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		$single = beans_get_layout_setting('single');
		$page = beans_get_layout_setting('page');

		$return = array();

		$return['single'] = isset($single) && ($single === 'c') ? 'c' : 'c_sp';
		$return['page'] = isset($page) && ($page === 'c') ? 'c' : 'c_sp';

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
	private function set_property()
	{
		/**
			@access (private)
				Set Uikit column/width css properties.
			@return (array)
				_filter[_render_column][property]
			@reference (Uikit)
				https://getuikit.com/docs/button
				https://getuikit.com/docs/card
				https://getuikit.com/docs/image
				https://getuikit.com/docs/text
				https://getuikit.com/docs/width
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
				'class' => 'uk-width-auto'
			),
			'full'	 => array(
				'class' => 'uk-width-1-1'
			),
			'half' => array(
				'class' => 'uk-width-auto@s uk-width-1-2@m'
			),
			'widget' => array(
				'class' => 'widget uk-width-auto'
			),
			'image' => array(
				'class' => 'uk-image uk-width-auto'
			),
			'description' => array(
				'class' => 'uk-text-lead uk-width-auto'
			),
			'card' => array(
				'class' => 'uk-card uk-width-auto'
			),
			'button' => array(
				'class' => 'uk-button uk-width-auto'
			),
			'primary' => self::$_layout['single'] === 'c' ? array('class' => 'uk-width-1-1 site-main') : array('class' => 'uk-width-1-1@s uk-width-2-3@m site-main'),
			'secondary' => self::$_layout['single'] === 'c' ? array('class' => 'uk-width-1-1 sidebar') : array('class' => 'uk-width-1-1@s uk-width-1-3@m sidebar'),
		));

	}//Method


	/* Setter
	_________________________
	*/
	private function set_attribute()
	{
		/**
			@access (private)
				Set css attributes for column/width.
			@return (array)
				_filter[_render_column][attribute]
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
			'primary' => array(
				'role' => 'main',
				'itemscope' => 'itemscope',
				'itemtype' => 'https://schema.org/Blog',
				'itemprop' => 'mainEntityOfPage',
				'tabindex' => '-1',
			),
			'secondary' => array(
				'role' => 'complementary',
				'itemscope' => 'itemscope',
				'itemtype' => 'https://schema.org/WPSideBar',
				'tabindex' => '-1',
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
				_filter[_render_column][hook]
			@reference
				[Parent]/inc/setup/constant.php
				[Parent]/inc/utility/general.php
				[Parent]/template/content/404.php
				[Parent]/template/content/archive.php
				[Parent]/template/content/index.php
				[Parent]/template/content/singular.php
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
			'property' => array(
				'default' => array(
					'hook' => '_property[column][default]',
					'callback' => '__the_property_default',
					'priority' => PRIORITY['mid-low'],
				),
				'half' => array(
					'hook' => '_property[column][half]',
					'callback' => '__the_property_half',
					'priority' => PRIORITY['mid-low'],
				),
				'primary' => array(
					'hook' => '_property[column][primary]',
					'callback' => '__the_property_primary',
					'priority' => PRIORITY['mid-low'],
				),
				'secondary' => array(
					'hook' => '_property[column][secondary]',
					'callback' => '__the_property_secondary',
					'priority' => PRIORITY['mid-low'],
				),
			),
			'attribute' => array(
				'primary' => array(
					'hook' => '_attribute[column][primary]',
					'callback' => '__the_attribute_primary',
					'priority' => PRIORITY['mid-low'],
				),
				'secondary' => array(
					'hook' => '_attribute[column][secondary]',
					'callback' => '__the_attribute_secondary',
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
			[Parent]/template/content/404.php
			[Parent]/template/content/archive.php
			[Parent]/template/content/index.php
			[Parent]/template/content/singular.php
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
			[Parent]/template/content/404.php
			[Parent]/template/content/archive.php
			[Parent]/template/content/index.php
			[Parent]/template/content/singular.php
	*/
	public static function __the_property_half()
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
	public static function __the_property_primary()
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
			[Parent]/template/sidebar/sidebar.php
	*/
	public static function __the_property_secondary()
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
			[Parent]/template/content/404.php
			[Parent]/template/content/archive.php
			[Parent]/template/content/index.php
			[Parent]/template/content/singular.php
	*/
	public static function __the_attribute_primary()
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
			[Parent]/template/sidebar/sidebar.php
	*/
	public static function __the_attribute_secondary()
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
				 - primary
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
// new _render_column();
_render_column::__get_instance();
