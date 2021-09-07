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
if(class_exists('_fragment_image') === FALSE) :
class _fragment_image
{
/**
 * [TOC]
 * 	__get_instance()
 * 	__construct()
 * 	set_param()
 * 	set_hook()
 * 	invoke_hook()
 * 	__the_card()
 * 	__the_gallery()
 * 	__the_general()
 * 	__the_list()
 * 	__the_archive()
 * 	__the_home()
 * 	__the_search()
 * 	render()
*/

	/**
		@access(private)
			Class properties.
		@var (string) $_class
			Name/Identifier with prefix.
		@var (string) $_index
			Name/Identifier without prefix.
		@var (array) $_param
			Parameter for applications.
		@var (array) $hook
			Collection of hooks that is being registered (that is,actions or filters).
	*/
	private static $_class = '';
	private static $_index = '';
	private static $_param = array();
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
				This is only called once,since the only way to instantiate this is with the get_instance() method in trait (singleton.php).
			@return (void)
			@reference
				[Parent]/inc/trait/singleton.php
				[Parent]/inc/utility/general.php
		*/

		// Init properties.
		self::$_class = __utility_get_class(get_class($this));
		self::$_index = __utility_get_index(self::$_class);
		self::$_param = $this->set_param();

		// Register hooks.
		$this->hook = $this->set_hook();
		$this->invoke_hook();

	}// Method


	/* Setter
	_________________________
	*/
	private function set_param()
	{
		/**
			@access (private)
				Configure the parameter for applications.
			@return (array)
				_filter[_fragment_image][param]
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
			'gallery' => array(
				'needle' => 'gallery',
				'skin' => __utility_get_option('skin_image_gallery'),
				'size' => 'medium',
			),
			'general' => array(
				'needle' => 'general',
				'skin' => __utility_get_option('skin_image_general'),
				'size' => 'medium',
			),
			'card' => array(
				'needle' => 'card',
				'skin' => __utility_get_option('skin_image_card'),
				'size' => 'medium',
			),
			'list' => array(
				'needle' => 'list',
				'skin' => __utility_get_option('skin_image_list'),
				'size' => 'xsmall',
			),
			'archive' => array(
				'needle' => 'archive',
				'skin' => __utility_get_option('skin_image_card'),
				'size' => 'medium',
			),
			'home' => array(
				'needle' => 'home',
				'skin' => __utility_get_option('skin_image_general'),
				'size' => 'medium',
			),
			'search' => array(
				'needle' => 'search',
				'skin' => __utility_get_option('skin_image_general'),
				'size' => 'medium',
			),
		));

	}// Method


	/* Setter
	_________________________
	*/
	private function set_hook()
	{
		/**
			@access (private)
				The collection of hooks that is being registered (that is,actions or filters).
			@return (array)
				_filter[_fragment_image][hook]
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
			/**
			 * @since 1.0.1
			 * 	Echo thumbnail on the item template parts.
			 * @reference
			 * 	[Parent]/template-part/item/card.php
			 * 	[Parent]/template-part/item/gallery.php
			 * 	[Parent]/template-part/item/general.php
			 * 	[Parent]/template-part/item/list.php
			*/
			'gallery' => array(
				'beans_id' => $class . '__the_gallery',
				'hook'	 => HOOK_POINT['item']['gallery']['image'],
				'callback' => '__the_gallery',
				'priority' => PRIORITY['default'],
			),
			'general' => array(
				'beans_id' => $class . '__the_general',
				'hook'	 => HOOK_POINT['item']['general']['image'],
				'callback' => '__the_general',
				'priority' => PRIORITY['default'],
			),
			'card' => array(
				'beans_id' => $class . '__the_card',
				'hook'	 => HOOK_POINT['item']['card']['image'],
				'callback' => '__the_card',
				'priority' => PRIORITY['default'],
			),
			'list' => array(
				'beans_id' => $class . '__the_list',
				'hook'	 => HOOK_POINT['item']['list']['image'],
				'callback' => '__the_list',
				'priority' => PRIORITY['default'],
			),
			/**
			 * @since 1.0.1
			 * 	Echo thumbnail on archive pages.
			 * @reference
			 * 	[Parent]/template-part/content/content-archive.php
			 * 	[Parent]/template-part/content/content-home.php
			 * 	[Parent]/template-part/content/content-search.php
			*/
			'archive' => array(
				'beans_id' => $class . '__the_archive',
				'hook'	 => HOOK_POINT['archive']['body']['prepend'],
				'callback' => '__the_archive',
				'priority' => PRIORITY['default'],
			),
			'home' => array(
				'beans_id' => $class . '__the_home',
				'hook'	 => HOOK_POINT['home']['body']['prepend'],
				'callback' => '__the_home',
				'priority' => PRIORITY['default'],
			),
			'search' => array(
				'beans_id' => $class . '__the_search',
				'hook'	 => HOOK_POINT['search']['body']['prepend'],
				'callback' => '__the_search',
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

		foreach((array)$this->hook as $key => $value){
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
			Echo thumbnail for gallery format.
		@hook (beans id)
			_fragment_image__the_gallery
		@reference
			[Parent]/inc/utility/general.php
			[Parent]/template-part/item/gallery.php
	*/
	public function __the_gallery()
	{
		$function = __utility_get_function(__FUNCTION__);
		$this->render($function);

	}// Method


	/**
		@access (public)
			Echo thumbnail for general format.
		@hook (beans id)
			_fragment_image__the_general
		@reference
			[Parent]/inc/utility/general.php
			[Parent]/template-part/item/general.php
	*/
	public function __the_general()
	{
		$function = __utility_get_function(__FUNCTION__);
		$this->render($function);

	}// Method


	/**
		@access (public)
			Echo thumbnail for card format.
		@hook (beans id)
			_fragment_image__the_card
		@reference
			[Parent]/inc/utility/general.php
			[Parent]/template-part/item/card.php
	*/
	public function __the_card()
	{
		$function = __utility_get_function(__FUNCTION__);
		$this->render($function);

	}// Method


	/**
		@access (public)
			Echo thumbnail for list format.
		@hook (beans id)
			_fragment_image__the_list
		@reference
			[Parent]/inc/utility/general.php
			[Parent]/template-part/item/list.php
	*/
	public function __the_list()
	{
		$function = __utility_get_function(__FUNCTION__);
		$this->render($function);

	}// Method


	/**
		@access (public)
			Echo thumbnail for archive.php.
		@hook (beans id)
			_fragment_image__the_archive
		@reference
			[Parent]/inc/utility/general.php
			[Parent]/template-part/content/content-archive.php
	*/
	public function __the_archive()
	{
		if(!__utility_is_archive()){return;}
		$function = __utility_get_function(__FUNCTION__);
		$this->render($function);

	}// Method


	/**
		@access (public)
			Echo thumbnail for home.php.
		@hook (beans id)
			_fragment_image__the_home
		@reference
			[Parent]/inc/utility/general.php
			[Parent]/template-part/content/content-home.php
	*/
	public function __the_home()
	{
		/**
		 * @reference (WP)
		 * 	Determines whether the query is for the blog homepage.
		 * 	https://developer.wordpress.org/reference/functions/is_home/
		*/
		if(!is_home()){return;}
		$function = __utility_get_function(__FUNCTION__);
		$this->render($function);

	}// Method


	/**
		@access (public)
			Echo thumbnail for search.php.
		@hook (beans id)
			_fragment_image__the_search
		@reference
			[Parent]/inc/utility/general.php
			[Parent]/template-part/content/content-search.php
	*/
	public function __the_search()
	{
		/**
		 * @reference (WP)
		 * 	Determines whether the query is for the blog homepage.
		 * 	https://developer.wordpress.org/reference/functions/is_home/
		*/
		if(!is_search()){return;}
		$function = __utility_get_function(__FUNCTION__);
		$this->render($function);

	}// Method


	/* Method
	_________________________
	*/
	private function render($needle = '')
	{
		/**
			@access (private)
				Load and echo the designated application.
			@param (string) $needle
				Content type or Item format.
			@return (void)
			@reference
				[Parent]/inc/trait/theme.php
				[Parent]/inc/utility/general.php
		*/
		if(!isset($needle)){return;}

		$class = self::$_class;
		// $function = __utility_get_function(__FUNCTION__);

		switch($needle){
			case 'archive' :
				/**
				 * @reference (Beans)
				 * 	HTML markup.
				 * 	https://www.getbeans.io/code-reference/functions/beans_open_markup_e/
				 * 	https://www.getbeans.io/code-reference/functions/beans_close_markup_e/
				 * @reference (Uikit)
				 * 	https://getuikit.com/docs/card
				*/
				$layout = beans_get_layout_setting('archive');
				beans_open_markup_e("_image[{$class}][{$needle}]",'div',array(
					'class' => $layout === 'card' ? 'uk-card-media' : 'uk-card-media-left uk-width-auto'
				));
					self::__activate_application(self::$_index,self::$_param[$needle]);
				beans_close_markup_e("_image[{$class}][{$needle}]",'div');
				break;

			case 'home' :
			case 'search' :
				/**
				 * @reference (Beans)
				 * 	HTML markup.
				 * 	https://www.getbeans.io/code-reference/functions/beans_open_markup_e/
				 * 	https://www.getbeans.io/code-reference/functions/beans_close_markup_e/
				 * @reference (Uikit)
				 * 	https://getuikit.com/docs/card
				*/
				$layout = beans_get_layout_setting('home');
				beans_open_markup_e("_image[{$class}][{$needle}]",'div',array(
					'class' => $layout === 'list' ? 'uk-card-media-left uk-width-auto' : 'uk-card-media'
				));
					self::__activate_application(self::$_index,self::$_param[$needle]);
				beans_close_markup_e("_image[{$class}][{$needle}]",'div');
				break;

			case 'gallery' :
			case 'general' :
			case 'card' :
			case 'list' :
			default :
				self::__activate_application(self::$_index,self::$_param[$needle]);
				break;
		}

	}// Method


}// Class
endif;
// new _fragment_image();
_fragment_image::__get_instance();
