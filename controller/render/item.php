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
if(class_exists('_render_item') === FALSE) :
class _render_item
{
/**
 * [TOC]
 * 	__get_instance()
 * 	__construct()
 * 	set_header()
 * 	set_image()
 * 	set_body()
 * 	set_hook()
 * 	invoke_hook()
 * 	__the_header_card()
 * 	__the_header_gallery()
 * 	__the_header_general()
 * 	__the_header_list()
 * 	__the_body_card()
 * 	__the_body_general()
 * 	__the_image_card()
 * 	__the_image_gallery()
 * 	__the_image_general()
 * 	__the_image_list()
 * 	__get_header()
 * 	__get_image()
 * 	__get_body()
 * 
 * @reference
 * 	[Parent]/templare-part/item/card.php
 * 	[Parent]/templare-part/item/gallery.php
 * 	[Parent]/templare-part/item/general.php
 * 	[Parent]/templare-part/item/list.php
*/

	/**
		@access (private)
			Class properties.
		@var (string) $_class
			Name/Identifier with prefix.
		@var (string) $_index
			Name/Identifier without prefix.
		@var (string) $_header
			CSS properties of item header.
		@var (array) $_image
			CSS properties of item image.
		@var (array) $_body
			CSS properties of item body.
		@var (array) $hook
			Collection of hooks that is being registered (that is, actions or filters).
	*/
	private static $_class = '';
	private static $_index = '';
	private static $_header = '';
	private static $_image = array();
	private static $_body = array();
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
		self::$_header = $this->set_header();
		self::$_image = $this->set_image();
		self::$_body = $this->set_body();

		// Register hooks.
		$this->hook = $this->set_hook();
		$this->invoke_hook();

	}// Method


	/* Setter
	_________________________
	*/
	public function set_header()
	{
		/**
			@access (public)
				Set css properties of item header.
			@return (string)
				_filter[_render_item][header]
			@reference (Uikit)
				https://getuikit.com/docs/card
			@reference
				[Parent]/inc/utility/general.php
				[Parent]/template-part/item/card.php
				[Parent]/template-part/item/gallery.php
				[Parent]/template-part/item/general.php
				[Parent]/template-part/item/list.php
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		/**
		 * @reference (Beans)
		 * 	Call the functions added to a filter hook.
		 * 	https://www.getbeans.io/code-reference/functions/beans_apply_filters/
		*/
		return beans_apply_filters("_filter[{$class}][{$function}]",array(
			'card' => 'uk-card-header uk-padding-small uk-padding-remove-vertical',
			'gallery' => 'uk-card-header uk-padding-small uk-padding-remove-vertical',
			'general' => 'uk-card-header uk-padding-small uk-padding-remove-vertical',
			'list' => 'uk-card-header uk-width-expand uk-padding-small uk-padding-remove-horizonal',
		));

	}// Method


	/* Setter
	_________________________
	*/
	public function set_image()
	{
		/**
			@access (public)
				Set css properties of item image.
			@return (array)
				_filter[_render_item][image]
			@reference (Uikit)
				https://getuikit.com/docs/article
			@reference
				[Parent]/inc/utility/general.php
				[Parent]/template-part/item/card.php
				[Parent]/template-part/item/gallery.php
				[Parent]/template-part/item/general.php
				[Parent]/template-part/item/list.php
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		/**
		 * @reference (Beans)
		 * 	Call the functions added to a filter hook.
		 * 	https://www.getbeans.io/code-reference/functions/beans_apply_filters/
		*/
		return beans_apply_filters("_filter[{$class}][{$function}]",array(
			'card' => 'uk-card-media-top uk-padding-small uk-padding-remove-horizonal',
			'gallery' => 'uk-card-media uk-padding-small uk-padding-remove-horizonal',
			'general' => 'uk-card-media-left uk-padding-small uk-padding-remove-horizonal',
			'list' => 'uk-card-media-left uk-width-auto uk-padding-small uk-padding-remove-horizonal',
		));

	}// Method


	/* Setter
	_________________________
	*/
	public function set_body()
	{
		/**
			@access (public)
				Set css properties of item body.
			@return (array)
				_filter[_render_item][body]
			@reference (Uikit)
				https://getuikit.com/docs/article
			@reference
				[Parent]/inc/utility/general.php
				[Parent]/template-part/item/card.php
				[Parent]/template-part/item/gallery.php
				[Parent]/template-part/item/general.php
				[Parent]/template-part/item/list.php
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		/**
		 * @reference (Beans)
		 * 	Call the functions added to a filter hook.
		 * 	https://www.getbeans.io/code-reference/functions/beans_apply_filters/
		*/
		return beans_apply_filters("_filter[{$class}][{$function}]",array(
			'card' => 'uk-card-body uk-padding-small uk-padding-remove-vertical uk-height-small',
			'general' => 'uk-card-body uk-padding-small uk-padding-remove-vertical',
		));

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
				_filter[_render_item][hook]
			@reference
				[Parent]/inc/setup/constant.php
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
			'card' => array(
				'header' => array(
					'hook' => '_class[card][item][header]',
					'callback' => '__the_header_card',
					'priority' => PRIORITY['mid-low'],
				),
				'image' => array(
					'hook' => '_class[card][item][image]',
					'callback' => '__the_image_card',
					'priority' => PRIORITY['mid-low'],
				),
				'body' => array(
					'hook' => '_class[card][item][body]',
					'callback' => '__the_body_card',
					'priority' => PRIORITY['mid-low'],
				),
			),
			'gallery' => array(
				'header' => array(
					'hook' => '_class[gallery][item][header]',
					'callback' => '__the_header_gallery',
					'priority' => PRIORITY['mid-low'],
				),
				'image' => array(
					'hook' => '_class[gallery][item][image]',
					'callback' => '__the_image_gallery',
					'priority' => PRIORITY['mid-low'],
				),
			),
			'general' => array(
				'header' => array(
					'hook' => '_class[general][item][header]',
					'callback' => '__the_header_general',
					'priority' => PRIORITY['mid-low'],
				),
				'image' => array(
					'hook' => '_class[general][item][image]',
					'callback' => '__the_image_general',
					'priority' => PRIORITY['mid-low'],
				),
				'body' => array(
					'hook' => '_class[general][item][body]',
					'callback' => '__the_body_general',
					'priority' => PRIORITY['mid-low'],
				),
			),
			'list' => array(
				'header' => array(
					'hook' => '_class[list][item][header]',
					'callback' => '__the_header_list',
					'priority' => PRIORITY['mid-low'],
				),
				'image' => array(
					'hook' => '_class[list][item][image]',
					'callback' => '__the_image_list',
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
			Markup item header.
		@reference
			[Parent]/inc/utility/general.php
			[Parent]/template-part/item/card.php
			[Parent]/template-part/item/general.php
	*/
	public static function __the_header_card()
	{
		$function = __utility_get_function(__FUNCTION__);
		$exploded = explode('_',$function);
		$end = end($exploded);
		echo self::$_header[$end];
	}// Method

	public static function __the_header_gallery()
	{
		$function = __utility_get_function(__FUNCTION__);
		$exploded = explode('_',$function);
		$end = end($exploded);
		echo self::$_header[$end];
	}// Method

	public static function __the_header_general()
	{
		$function = __utility_get_function(__FUNCTION__);
		$exploded = explode('_',$function);
		$end = end($exploded);
		echo self::$_header[$end];
	}// Method

	public static function __the_header_list()
	{
		$function = __utility_get_function(__FUNCTION__);
		$exploded = explode('_',$function);
		$end = end($exploded);
		echo self::$_header[$end];
	}// Method


	/**
		@access (public)
			Markup item body.
		@reference
			[Parent]/inc/utility/general.php
			[Parent]/template-part/item/card.php
			[Parent]/template-part/item/general.php
	*/
	public static function __the_body_card()
	{
		$function = __utility_get_function(__FUNCTION__);
		$exploded = explode('_',$function);
		$end = end($exploded);
		echo self::$_body[$end];
	}// Method

	public static function __the_body_general()
	{
		$function = __utility_get_function(__FUNCTION__);
		$exploded = explode('_',$function);
		$end = end($exploded);
		echo self::$_body[$end];
	}// Method


	/**
		@access (public)
			Markup item image.
		@reference
			[Parent]/inc/utility/general.php
			[Parent]/template-part/item/card.php
			[Parent]/template-part/item/gallery.php
			[Parent]/template-part/item/general.php
			[Parent]/template-part/item/list.php
	*/
	public static function __the_image_card()
	{
		$function = __utility_get_function(__FUNCTION__);
		$exploded = explode('_',$function);
		$end = end($exploded);
		echo self::$_image[$end];
	}// Method

	public static function __the_image_gallery()
	{
		$function = __utility_get_function(__FUNCTION__);
		$exploded = explode('_',$function);
		$end = end($exploded);
		echo self::$_image[$end];
	}// Method

	public static function __the_image_general()
	{
		$function = __utility_get_function(__FUNCTION__);
		$exploded = explode('_',$function);
		$end = end($exploded);
		echo self::$_image[$end];
	}// Method

	public static function __the_image_list()
	{
		$function = __utility_get_function(__FUNCTION__);
		$exploded = explode('_',$function);
		$end = end($exploded);
		echo self::$_image[$end];
	}// Method


	/* Method
	_________________________
	*/
	public static function __get_header($needle = '')
	{
		/**
			@access (private)
				Returns the registerd values (properties).
			@param (string) $needle
				The type of article.
				 - card
				 - gallery
				 - general
				 - list
			@return (string[])
		*/
		if(!isset($needle) || !array_key_exists($needle,self::$_header)){
			return self::$_header;
		}
		else{
			return self::$_header[$needle];
		}

	}// Method


	/* Method
	_________________________
	*/
	public static function __get_body($needle = '')
	{
		/**
			@access (private)
				Returns the registerd values (properties).
			@param (string) $needle
				The type of article.
				 - card
				 - gallery
				 - general
				 - list
			@return (string[])
		*/
		if(!isset($needle) || !array_key_exists($needle,self::$_body)){
			return self::$_body;
		}
		else{
			return self::$_body[$needle];
		}

	}// Method


	/* Method
	_________________________
	*/
	public static function __get_image($needle = '')
	{
		/**
			@access (private)
				Returns the registerd values (properties).
			@param (string) $needle
				The type of article.
				 - card
				 - gallery
				 - general
				 - list
			@return (string[])
		*/
		if(!isset($needle) || !array_key_exists($needle,self::$_image)){
			return self::$_image;
		}
		else{
			return self::$_image[$needle];
		}

	}// Method


}// Class
endif;
// new _render_item();
_render_item::__get_instance();
