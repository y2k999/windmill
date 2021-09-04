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
if(class_exists('_controller_layout') === FALSE) :
class _controller_layout
{
/**
 * [TOC]
 * 	__get_instance()
 * 	__construct()
 * 	set_section()
 * 	set_container()
 * 	set_grid()
 * 	set_column()
 * 	__set_configuration()
 * 	__get_section()
 * 	__get_container()
 * 	__get_grid()
 * 	__get_column()
 * 
 * @reference
 * 	[Parent]/template/header/header.php
 * 	[Parent]/template/content/404.php
 * 	[Parent]/template/content/archive.php
 * 	[Parent]/template/content/index.php
 * 	[Parent]/template/content/singular.php
 * 	[Parent]/template/footer/footer.php
*/

	/**
		@access(private)
			Class properties.
		@var (string) $_class
			Name/Identifier with prefix.
		@var (string) $_index
			Name/Identifier without prefix.
		@var (array) $_section
			Create horizontal layout sections with different background colors and styles.
		@var (array) $_container
			This component allows you to align and center your page content.
		@var (array) $_grid
			Create a fully responsive,fluid and nestable grid layout.
		@var (array) $_column
			Display your content in multiple text columns without having to split it in several containers.
	*/
	private static $_class = '';
	private static $_index = '';
	private static $_section = array();
	private static $_container = array();
	private static $_grid = array();
	private static $_column = array();

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
				This is only called once,since the only way to instantiate this is with the get_instance() method in trait (singleton.php).
			@return (void)
			@reference
				[Parent]/inc/trait/singleton.php
				[Parent]/inc/utility/general.php
		*/

		// Init properties.
		self::$_class = __utility_get_class(get_class($this));
		self::$_index = __utility_get_index(self::$_class);
		self::$_section = $this->set_section();
		self::$_container = $this->set_container();
		self::$_grid = $this->set_grid();
		self::$_column = $this->set_column();

	}//Method


	/* Setter
	_________________________
	*/
	private function set_section()
	{
		/**
			@access (private)
				Set Uikit section css properties.
			@return (array)
				_filter[_controller_layout][section]
			@reference (Uikit)
				https://getuikit.com/docs/section
			@reference
				[Parent]/controller/render/section.php
				[Parent]/inc/utility/general.php
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		/**
		 * @reference (Beans)
		 * 	Call the functions added to a filter hook.
		 * 	https://www.getbeans.io/code-reference/functions/beans_apply_filters/
		*/
		return beans_apply_filters("_filter[{$class}][{$function}]",_render_section::__get_setting());

	}//Method


	/* Setter
	_________________________
	*/
	private function set_container()
	{
		/**
			@access (private)
				Set Uikit container css properties.
			@return (array)
				_filter[_controller_layout][container]
			@reference (Uikit)
				https://getuikit.com/docs/container
			@reference
				[Parent]/controller/render/container.php
				[Parent]/inc/utility/general.php
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		/**
		 * @reference (Beans)
		 * 	Call the functions added to a filter hook.
		 * 	https://www.getbeans.io/code-reference/functions/beans_apply_filters/
		*/
		return beans_apply_filters("_filter[{$class}][{$function}]",_render_container::__get_setting('property'));

	}//Method


	/* Setter
	_________________________
	*/
	private function set_grid()
	{
		/**
			@access (private)
				Set Uikit grid css properties.
			@return (array)
				_filter[_controller_layout][grid]
			@reference (Uikit)
				https://getuikit.com/docs/grid
			@reference
				[Parent]/controller/render/grid.php
				[Parent]/inc/utility/general.php
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		/**
		 * @reference (Beans)
		 * 	Call the functions added to a filter hook.
		 * 	https://www.getbeans.io/code-reference/functions/beans_apply_filters/
		*/
		return beans_apply_filters("_filter[{$class}][{$function}]",_render_grid::__get_setting('property'));

	}//Method


	/* Setter
	_________________________
	*/
	private function set_column()
	{
		/**
			@access (private)
				Set Uikit column/width css properties.
			@return (array)
				_filter[_controller_layout][column]
			@reference (Uikit)
				https://getuikit.com/docs/column
				https://getuikit.com/docs/width
			@reference
				[Parent]/controller/render/column.php
				[Parent]/inc/utility/general.php
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		/**
		 * @reference (Beans)
		 * 	Call the functions added to a filter hook.
		 * 	https://www.getbeans.io/code-reference/functions/beans_apply_filters/
		*/
		return beans_apply_filters("_filter[{$class}][{$function}]",_render_column::__get_setting('property'));

	}//Method


	/* Method
	_________________________
	*/
	private static function __set_configuration($original = array(),$additinal = array())
	{
		/**
			@access (public)
				Configure the CSS properties.
			@param (array) $original
				Original array of properties.
			@param (array) $additinal
				Additinal array of properties.
			@return (array) $array
				Merged array of properties.
		*/
		if(!empty($additinal)){
			if(isset($additinal['id']) && ($additinal['id'] !== '')){
				$original['id'] = $additinal['id'];
			}
			if(isset($additinal['class']) && ($additinal['class'] !== '')){
				$original['class'] .= ' ' . $additinal['class'];
			}
		}
		return $original;

	}//Method


	/* Method
	_________________________
	*/
	public static function __get_section($needle = '',$additinal = array())
	{
		/**
			@access (public)
				Returns the registerd values (properties/attributes).
			@param (string) $needle
				The name of the specialised section.
				 - masthead
				 - content
				 - colophone
			@param (array) $additinal
				Additional arguments passed to the layout controller.
			@return (array)
				Array of properties.
				The array key defines the property name and the array value defines the property value.
			@reference
				[Parent]/inc/utility/theme.php
		*/
		if(!__utility_is_uikit()){return;}

		if(!isset($needle) || !array_key_exists($needle,self::$_section)){
			$return = self::$_section['default'];
		}
		else{
			$return = self::$_section[$needle];
		}

		// Check if user custom properties.
		if(empty($additinal)){
			return $return;
		}
		else{
			return self::__set_configuration($return,$additinal);
		}

	}//Method


	/* Method
	_________________________
	*/
	public static function __get_container($needle = '',$additinal = array())
	{
		/**
			@access (public)
				Returns the registerd values (properties/attributes).
			@param (string) $needle
				The name of the specialised container.
				 - masthead
				 - content
				 - colophone
			@param (array) $additinal
				Additional arguments passed to the layout controller.
			@return (array)
				Array of properties.
				The array key defines the property name and the array value defines the property value.
		*/
		if(!isset($needle) || !array_key_exists($needle,self::$_container)){
			$return = self::$_container['default'];
		}
		else{
			$return = self::$_container[$needle];
		}

		// Check if user custom properties.
		if(empty($additinal)){
			return $return;
		}
		else{
			return self::__set_configuration($return,$additinal);
		}

	}//Method


	/* Method
	_________________________
	 */
	public static function __get_grid($needle = '',$additinal = array())
	{
		/**
			@access (public)
				Returns the registerd values (properties/attributes).
			@param (string) $needle
				The name of the specialised grid.
				 - general
				 - masthead
				 - colophone
				 - secondary
			@param (array) $additinal
				Additional arguments passed to the layout controller.
			@return (array)
				Array of properties.
				The array key defines the property name and the array value defines the property value.
			@reference
				[Parent]/inc/utility/theme.php
		*/
		if(!isset($needle) || !array_key_exists($needle,self::$_grid)){
			$return = self::$_grid['default'];
		}
		else{
			$return = self::$_grid[$needle];
		}

		if(__utility_is_uikit()){
			$return['uk-grid'] = 'uk-grid';
		}

		// Check if user custom properties.
		if(empty($additinal)){
			return $return;
		}
		else{
			return self::__set_configuration($return,$additinal);
		}

	}//Method


	/* Method
	_________________________
	*/
	public static function __get_column($needle = '',$additinal = array())
	{
		/**
			@access (public)
				Returns the registerd values (properties/attributes).
			@param (string) $needle
				The name of the specialised column/width.
				 - default
				 - full
				 - half
				 - widget
				 - image
				 - description
				 - card
				 - button
				 - primary
				 - secondary
			@param (array) $additinal
				Additional arguments passed to the layout controller.
			@return (array)
				Array of properties.
				The array key defines the property name and the array value defines the property value.
		*/
		if(!isset($needle) || !array_key_exists($needle,self::$_column)){
			$return = self::$_column['default'];
		}
		else{
			$return = self::$_column[$needle];
		}

		// Check if user custom properties.
		if(empty($additinal)){
			return $return;
		}
		else{
			return self::__set_configuration($return,$additinal);
		}

	}//Method


}// Class
endif;
// new _controller_layout();
_controller_layout::__get_instance();
