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
if(class_exists('_render_article') === FALSE) :
class _render_article
{
/**
 * [TOC]
 * 	__get_instance()
 * 	__construct()
 * 	set_header()
 * 	set_content()
 * 	set_footer()
 * 	set_hook()
 * 	invoke_hook()
 * 	__the_header()
 * 	__the_footer()
 * 	__the_content_archive()
 * 	__the_content_home()
 * 	__the_content_none()
 * 	__the_conten_paget()
 * 	__the_content_single()
 * 	__get_header()
 * 	__get_footer()
 * 	__get_content()
 * 
 * @reference
 * 	[Parent]/templare-part/content/content.php
 * 	[Parent]/templare-part/content/content-archive.php
 * 	[Parent]/templare-part/content/content-home.php
 * 	[Parent]/templare-part/content/content-none.php
 * 	[Parent]/templare-part/content/content-single.php
*/

	/**
		@access (private)
			Class properties.
		@var (string) $_class
			Name/Identifier with prefix.
		@var (string) $_index
			Name/Identifier without prefix.
		@var (string) $_header
			CSS properties of article header.
		@var (string) $_footer
			CSS properties of article footer.
		@var (array) $_content
			CSS properties of article content.
		@var (array) $hook
			Collection of hooks that is being registered (that is, actions or filters).
	*/
	private static $_class = '';
	private static $_index = '';
	private static $_header = '';
	private static $_footer = '';
	private static $_content = array();
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
		self::$_footer = $this->set_footer();
		self::$_content = $this->set_content();

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
				Set css properties of article header.
			@return (string)
				_filter[_render_article][header]
			@reference (Uikit)
				https://getuikit.com/docs/article
			@reference
				[Parent]/inc/utility/general.php
				[Parent]/template-part/content/content.php
				[Parent]/template-part/content/content-archive.php
				[Parent]/template-part/content/content-home.php
				[Parent]/template-part/content/content-none.php
				[Parent]/template-part/content/content-page.php
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		/**
		 * @reference (Beans)
		 * 	Call the functions added to a filter hook.
		 * 	https://www.getbeans.io/code-reference/functions/beans_apply_filters/
		*/
		return beans_apply_filters("_filter[{$class}][{$function}]",'uk-padding-small uk-padding-remove-vertical entry-header');

	}// Method


	/* Setter
	_________________________
	*/
	public function set_footer()
	{
		/**
			@access (public)
				Set css properties of article footer.
			@return (string)
				_filter[_render_article][footer]
			@reference (Uikit)
				https://getuikit.com/docs/article
			@reference
				[Parent]/inc/utility/general.php
				[Parent]/template-part/content/content.php
				[Parent]/template-part/content/content-archive.php
				[Parent]/template-part/content/content-home.php
				[Parent]/template-part/content/content-none.php
				[Parent]/template-part/content/content-page.php
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		/**
		 * @reference (Beans)
		 * 	Call the functions added to a filter hook.
		 * 	https://www.getbeans.io/code-reference/functions/beans_apply_filters/
		*/
		return beans_apply_filters("_filter[{$class}][{$function}]",'uk-padding-small entry-footer');

	}// Method


	/* Setter
	_________________________
	*/
	public function set_content()
	{
		/**
			@access (public)
				Set css properties of article content.
			@return (array)
				_filter[_render_article][content]
			@reference (Uikit)
				https://getuikit.com/docs/article
			@reference
				[Parent]/inc/utility/general.php
				[Parent]/template-part/content/content.php
				[Parent]/template-part/content/content-archive.php
				[Parent]/template-part/content/content-home.php
				[Parent]/template-part/content/content-none.php
				[Parent]/template-part/content/content-page.php
				[Parent]/template-part/content/content-search.php
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		/**
		 * @reference (Beans)
		 * 	Call the functions added to a filter hook.
		 * 	https://www.getbeans.io/code-reference/functions/beans_apply_filters/
		*/
		return beans_apply_filters("_filter[{$class}][{$function}]",array(
			'archive' => 'uk-padding-small uk-position-relative entry-content',
			'home' => 'uk-padding-small uk-position-relative entry-content',
			'none' => 'uk-padding-small uk-position-relative entry-content',
			'page' => 'uk-padding-small uk-position-relative entry-content',
			'search' => 'uk-padding-small uk-position-relative entry-content',
			'single' => 'uk-padding-small uk-position-relative entry-content',
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
				_filter[_render_article][hook]
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
			'archive' => array(
				'header' => array(
					'hook' => '_class[archive][article][header]',
					'callback' => '__the_header',
					'priority' => PRIORITY['mid-low'],
				),
				'content' => array(
					'hook' => '_class[archive][article][content]',
					'callback' => '__the_content_archive',
					'priority' => PRIORITY['mid-low'],
				),
				'footer' => array(
					'hook' => '_class[archive][article][footer]',
					'callback' => '__the_footer',
					'priority' => PRIORITY['mid-low'],
				),
			),
			'home' => array(
				'header' => array(
					'hook' => '_class[home][article][header]',
					'callback' => '__the_header',
					'priority' => PRIORITY['mid-low'],
				),
				'content' => array(
					'hook' => '_class[home][article][content]',
					'callback' => '__the_content_home',
					'priority' => PRIORITY['mid-low'],
				),
				'footer' => array(
					'hook' => '_class[home][article][footer]',
					'callback' => '__the_footer',
					'priority' => PRIORITY['mid-low'],
				),
			),
			'search' => array(
				'header' => array(
					'hook' => '_class[search][article][header]',
					'callback' => '__the_header',
					'priority' => PRIORITY['mid-low'],
				),
				'content' => array(
					'hook' => '_class[search][article][content]',
					'callback' => '__the_content_search',
					'priority' => PRIORITY['mid-low'],
				),
				'footer' => array(
					'hook' => '_class[search][article][footer]',
					'callback' => '__the_footer',
					'priority' => PRIORITY['mid-low'],
				),
			),
			'none' => array(
				'header' => array(
					'hook' => '_class[none][article][header]',
					'callback' => '__the_header',
					'priority' => PRIORITY['mid-low'],
				),
				'content' => array(
					'hook' => '_class[none][article][content]',
					'callback' => '__the_content_none',
					'priority' => PRIORITY['mid-low'],
				),
				'footer' => array(
					'hook' => '_class[none][article][footer]',
					'callback' => '__the_footer',
					'priority' => PRIORITY['mid-low'],
				),
			),
			'page' => array(
				'header' => array(
					'hook' => '_class[page][article][header]',
					'callback' => '__the_header',
					'priority' => PRIORITY['mid-low'],
				),
				'content' => array(
					'hook' => '_class[page][article][content]',
					'callback' => '__the_content_page',
					'priority' => PRIORITY['mid-low'],
				),
				'footer' => array(
					'hook' => '_class[page][article][footer]',
					'callback' => '__the_footer',
					'priority' => PRIORITY['mid-low'],
				),
			),
			'single' => array(
				'header' => array(
					'hook' => '_class[single][article][header]',
					'callback' => '__the_header',
					'priority' => PRIORITY['mid-low'],
				),
				'content' => array(
					'hook' => '_class[single][article][content]',
					'callback' => '__the_content_single',
					'priority' => PRIORITY['mid-low'],
				),
				'footer' => array(
					'hook' => '_class[single][article][footer]',
					'callback' => '__the_footer',
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
			Markup article header.
	*/
	public static function __the_header()
	{
		// $function = __utility_get_function(__FUNCTION__);
		echo self::$_header;
	}// Method


	/**
		@access (public)
			Markup article footer.
	*/
	public static function __the_footer()
	{
		// $function = __utility_get_function(__FUNCTION__);
		echo self::$_footer;
	}// Method


	/**
		@access (public)
			Markup article content.
		@reference
			[Parent]/inc/utility/general.php
			[Parent]/template-part/content/content-archive.php
	*/
	public static function __the_content_archive()
	{
		$function = __utility_get_function(__FUNCTION__);
		$exploded = explode('_',$function);
		$end = end($exploded);
		echo self::$_content[$end];
	}// Method


	/**
		@access (public)
			Markup article content.
		@reference
			[Parent]/inc/utility/general.php
			[Parent]/template-part/content/content-home.php
	*/
	public static function __the_content_home()
	{
		$function = __utility_get_function(__FUNCTION__);
		$exploded = explode('_',$function);
		$end = end($exploded);
		echo self::$_content[$end];
	}// Method


	/**
		@access (public)
			Markup article content.
		@reference
			[Parent]/inc/utility/general.php
			[Parent]/template-part/content/content-search.php
	*/
	public static function __the_content_search()
	{
		$function = __utility_get_function(__FUNCTION__);
		$exploded = explode('_',$function);
		$end = end($exploded);
		echo self::$_content[$end];
	}// Method


	/**
		@access (public)
			Markup article content.
		@reference
			[Parent]/inc/utility/general.php
			[Parent]/template-part/content/content-none.php
	*/
	public static function __the_content_none()
	{
		$function = __utility_get_function(__FUNCTION__);
		$exploded = explode('_',$function);
		$end = end($exploded);
		echo self::$_content[$end];
	}// Method


	/**
		@access (public)
			Markup article content.
		@reference
			[Parent]/inc/utility/general.php
			[Parent]/template-part/content/content-page.php
	*/
	public static function __the_content_page()
	{
		$function = __utility_get_function(__FUNCTION__);
		$exploded = explode('_',$function);
		$end = end($exploded);
		echo self::$_content[$end];
	}// Method


	/**
		@access (public)
			Markup article content.
		@reference
			[Parent]/inc/utility/general.php
			[Parent]/template-part/content/content.php
	*/
	public static function __the_content_single()
	{
		$function = __utility_get_function(__FUNCTION__);
		$exploded = explode('_',$function);
		$end = end($exploded);
		echo self::$_content[$end];
	}// Method


	/* Method
	_________________________
	*/
	public static function __get_header()
	{
		/**
			@access (private)
				Returns the registerd values (properties).
			@return (string[])
		*/
		return self::$_header;

	}// Method


	/* Method
	_________________________
	*/
	public static function __get_footer()
	{
		/**
			@access (private)
				Returns the registerd values (properties).
			@return (string[])
		*/
		return self::$_footer;

	}// Method


	/* Method
	_________________________
	*/
	public static function __get_content($needle = '')
	{
		/**
			@access (private)
				Returns the registerd values (properties).
			@param (string) $needle
				The type of article.
				 - archive
				 - home
				 - none
				 - page
				 - single
				 - search
			@return (string[])
		*/
		if(!isset($needle) || !array_key_exists($needle,self::$_content)){
			return self::$_content;
		}
		else{
			return self::$_content[$needle];
		}

	}// Method


}// Class
endif;
// new _render_article();
_render_article::__get_instance();
