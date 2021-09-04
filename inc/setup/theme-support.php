<?php
/**
 * Setup theme.
 * @package Windmill
 * @license GPL3.0+
 * @since 1.0.1
*/

/**
 * Inspired by Beans Framework WordPress Theme
 * @link https://www.getbeans.io
 * @author Thierry Muller
 * 
 * Inspired by Celtis Speedy WordPress Theme
 * @link https://celtislab.net/wordpress-theme-celtis-speedy/
 * @author enomoto@celtislab
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
if(class_exists('_setup_theme_support') === FALSE) :
class _setup_theme_support
{
/**
 * [TOC]
 * 	__get_instance()
 * 	__construct()
 * 	set_image_size()
 * 	set_theme_location()
 * 	set_hook()
 * 	invoke_hook()
 * 	load_theme_textdomain()
 * 	content_width()
 * 	common()
 * 	post_format()
 * 	custom_background()
 * 	custom_header()
 * 	custom_logo()
 * 	add_image_size()
 * 	register_nav_menus()
 * 	do_shortcode()
 * 	__get_image_size()
 * 	__get_theme_location()
*/

	/**
		@access (private)
			Class properties.
		@var (string) $_class
			Name/Identifier with prefix.
		@var (string) $_index
			Name/Identifier without prefix.
		@var (array) $_image_size
			Registerd image sizes.
		@var (array) $_theme_location
			Registerd theme locations.
		@var 	(array) $hook
			Collection of hooks that is being registered (that is, actions or filters).
	*/
	private static $_class = '';
	private static $_index = '';
	private static $_image_size = array();
	private static $_theme_location = array();
	private $hook = array();

	/**
	 * Traits.
	*/
	use _trait_hook;
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
		self::$_image_size = $this->set_image_size();
		self::$_theme_location = $this->set_theme_location();

		// Register hooks.
		$this->hook = $this->set_hook();
		$this->invoke_hook($this->hook);

	}// Method


	/* Setter
	_________________________
	*/
	private function set_image_size()
	{
		/**
			@access (private)
				Register a new image size.
				https://developer.wordpress.org/reference/functions/add_image_size/
			@return (array)
				_filter[_setup_theme_support][size]
			@reference
				[Parent]/inc/utility/general.php
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		$return = __utility_get_image_size();

		/**
		 * @reference (WP)
		 * 	Calls the callback functions that have been added to a filter hook.
		 * 	https://developer.wordpress.org/reference/functions/apply_filters/
		*/
		if(!empty($return)){
			$return['small'] = array(
				'width' => 180,
				'height' => 120,
				'crop' => TRUE,
			);
			$return['xsmall'] = array(
				'width' => 120,
				'height' => 80,
				'crop' => TRUE,
			);
			$return['avatar'] = array(
				'width' => 96,
				'height' => 96,
				'crop' => TRUE,
			);
			return apply_filters("_filter[{$class}][{$function}]",$return);
		}
		else{
			return apply_filters("_filter[{$class}][{$function}]",array(
				'thumbnail' => array(
					'width' => 240,
					'height' => 160,
					'crop' => TRUE,
				),
				'medium' => array(
					'width' => 360,
					'height' => 240,
					'crop' => TRUE,
				),
				'medium_large' => array(
					'width' => 1024,
					'height' => 1024,
					'crop' => TRUE,
				),
				'large' => array(
					'width' => 0,
					'height' => 0,
					'crop' => TRUE,
				),
				'small' => array(
					'width' => 180,
					'height' => 120,
					'crop' => TRUE,
				),
				'xsmall' => array(
					'width' => 120,
					'height' => 80,
					'crop' => TRUE,
				),
				'avatar' => array(
					'width' => 96,
					'height' => 96,
					'crop' => TRUE,
				),
			));
		}

	}//Method


	/* Setter
	_________________________
	*/
	private function set_theme_location()
	{
		/**
			@access (private)
				Set theme location to be used.
				Must be registered with register_nav_menu() in order to be selectable by the user.
			@return (array)
				_filter[_setup_theme_support][theme_location]
			@reference
				[Parent]/inc/utility/general.php
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		/**
		 * @reference (WP)
		 * 	Calls the callback functions that have been added to a filter hook.
		 * 	https://developer.wordpress.org/reference/functions/apply_filters/
		*/
		return apply_filters("_filter[{$class}][{$function}]",array(
			'primary_navigation' => esc_html('[Windmill] Primary Navigation'),
			'secondary_navigation' => esc_html('[Windmill] Secondary Navigation'),
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
				_filter[_setup_theme_support][hook]
			@reference
				[Parent]/inc/trait/hook.php
				[Parent]/inc/utility/general.php
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		/**
		 * @reference (WP)
		 * 	Calls the callback functions that have been added to a filter hook.
		 * 	https://developer.wordpress.org/reference/functions/apply_filters/
		*/
		return apply_filters("_filter[{$class}][{$function}]",$this->set_parameter_callback(array(
			'load_theme_textdomain' => array(
				'tag' => 'add_action',
				'hook' => 'after_setup_theme'
			),
			'content_width' => array(
				'tag' => 'add_action',
				'hook' => 'after_setup_theme'
			),
			'common' => array(
				'tag' => 'add_action',
				'hook' => 'after_setup_theme'
			),
			'post_format' => array(
				'tag' => 'add_action',
				'hook' => 'after_setup_theme'
			),
			'custom_background' => array(
				'tag' => 'add_action',
				'hook' => 'after_setup_theme'
			),
			'custom_header' => array(
				'tag' => 'add_action',
				'hook' => 'after_setup_theme'
			),
			'custom_logo' => array(
				'tag' => 'add_action',
				'hook' => 'after_setup_theme'
			),
			'add_image_size' => array(
				'tag' => 'add_action',
				'hook' => 'after_setup_theme'
			),
			'register_nav_menus' => array(
				'tag' => 'add_action',
				'hook' => 'after_setup_theme'
			),
			'do_shortcode' => array(
				'tag' => 'add_action',
				'hook' => 'after_setup_theme'
			),
		)));

	}// Method


	/* Hook
	_________________________
	*/
	public function load_theme_textdomain()
	{
		/**
			@access (public)
				Make theme available for translation.
			@return (void)
			@reference (WP)
				Retrieves name of the current theme.
				https://developer.wordpress.org/reference/functions/get_template/
				Translations can be filed in the /languages/ directory.
				If you're building a theme based on this theme,use a find and replace to change 'windmill' to the name of your theme in all the template files.
				https://developer.wordpress.org/reference/functions/load_theme_textdomain/
		*/
		load_theme_textdomain(get_template(),trailingslashit(get_template_directory()) . 'languages');

	}// Method


	/* Hook
	_________________________
	*/
	public function content_width()
	{
		/**
			@access (public)
				Set the content width in pixels,based on the theme's design and stylesheet.
				Priority 0 to make it available to lower priority callbacks.
			@global (int) $content_width
				This variable is intended to be overruled from themes.
				https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043
			@return (void)
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		/* phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound. */
		$GLOBALS['content_width'] = apply_filters("_filter[{$class}][{$function}]",960);

	}// Method


	/* Hook
	_________________________
	*/
	public function common()
	{
		/**
			@access (public)
				Sets up theme defaults and registers support for various WordPress features.
				Note that this function is hooked into the after_setup_theme hook, which runs before the init hook.
				The init hook is too late for some features, such as indicating support for post thumbnails.
				https://developer.wordpress.org/reference/functions/add_theme_support/
			@return (void)
		*/
		$class = self::$_class;

		/**
		 * @reference (WP)
		 * 	Let WordPress manage the document title.
		 * 	By adding theme support,we declare that this theme does not use a hard-coded <title> tag in the document head,and expect WordPress to provide it for us.
		 * 	https://codex.wordpress.org/Title_Tag
		*/
		add_theme_support('title-tag');

		/**
		 * @reference (WP)
		 * 	Add default posts and comments RSS feed links to head.
		 * 	https://codex.wordpress.org/Automatic_Feed_Links
		*/
		add_theme_support('automatic-feed-links');

		/**
		 * @since 1.0.2
		 * 	WP5.5 'navigation-widgets' list <nav role="navigation" aria-label="Archives"> wrap
		 * 	https://celtislab.net/wordpress-theme-celtis-speedy/
		 * @reference (WP)
		 * 	Switch default core markup for search form,comment form,and comments to output valid HTML5.
		 * 	https://codex.wordpress.org/Theme_Markup
		*/
		add_theme_support('html5',apply_filters("_filter[{$class}][html5]",array(
			'navigation-widgets',
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			// 'widgets',
			// 'script',
			// 'style'
		)));

		/**
		 * @reference (WP)
		 * 	Enable support for Post Thumbnails on posts and pages.
		 * 	https://codex.wordpress.org/Post_Thumbnails
		*/
		add_theme_support('post-thumbnails');

		/**
		 * @reference (WP)
		 * 	Activate Selective Refresh Widgets
		 * 	https://make.wordpress.org/core/2016/03/22/implementing-selective-refresh-support-for-widgets/
		*/
		add_theme_support('customize-selective-refresh-widgets');

		/**
		 * @reference (Uikit)
		 * 	Sets up theme defaults and registers support for uikit offcanvas menu.
		 * 	https://getuikit.com/docs/offcanvas
		 * 
		 * @reference
		 * 	[Parent]/inc/utility/theme.php
		*/
		if(__utility_is_uikit()){
			add_theme_support('offcanvas-menu');
		}

	}// Method


	/* Hook
	_________________________
	*/
	public function post_format()
	{
		/**
			@access (public)
				Enable support for Post Formats.
				https://codex.wordpress.org/Post_Formats
			@return (void)
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		add_theme_support('post-formats',apply_filters("_filter[{$class}][{$function}]",array(
			'aside',
			'gallery',
			'link',
			'image',
			'quote',
			'status',
			'video',
			'audio',
			'chat',
		)));

	}// Method


	/* Hook
	_________________________
	*/
	public function custom_background()
	{
		/**
			@access (public)
				Set up the WordPress core custom background feature.
				https://codex.wordpress.org/Custom_Backgrounds
			@return (void)
		*/
		add_theme_support('custom-background');

	}// Method


	/* Hook
	_________________________
	*/
	public function custom_header()
	{
		/**
			@access (public)
				Activate Custom Header
				https://codex.wordpress.org/Custom_Headers
			@return (void)
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		add_theme_support('custom-header',apply_filters("_filter[{$class}][{$function}]",array(
			'default-image' => '',
			'width' => 0,
			'height' => 0,
			'flex-width' => FALSE,
			'flex-height' => TRUE,
			'random-default' => FALSE,
			'default-text-color' => '',
			//'video' => FALSE,
			'uploads' => TRUE,
			'header-text' => FALSE,
			// 'wp-head-callback' => 'simona_header_style',
			'admin-head-callback' => '',
			'admin-preview-callback' => '',
		)));

	}// Method


	/* Hook
	_________________________
	*/
	public function custom_logo()
	{
		/**
			@access (public)
				Activate Custom Logo
				https://codex.wordpress.org/Theme_Logo
			@return (void)
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		if(version_compare($GLOBALS['wp_version'],'4.5-alpha','<')){
			add_theme_support('site-logo',
				apply_filters("_filter[{$class}][site_logo]",array(
					'size' => 'full'
				)));
		}
		else{
			// Otherwise use new call.
			add_theme_support('custom-logo',apply_filters("_filter[{$class}][{$function}]",array(
				// Allow full flexibility if no size is specified.
				'height' => NULL,
				// Allow full flexibility if no size is specified.
				'width' => NULL,
				'flex-height' => TRUE,
				'flex-width' => TRUE,
			)));
		}

	}// Method


	/* Hook
	_________________________
	*/
	public function add_image_size()
	{
		/**
			@access (public)
				Register a new image size.
				https://developer.wordpress.org/reference/functions/add_image_size/
			@return (void)
		*/
		if(empty(self::$_image_size)){return;}

		foreach(self::$_image_size as $key => $value){
			switch($key){
				case 'thumbnail' :
				case 'medium' :
				case 'medium_large' :
				case 'large' :
					update_option($key . '_size_w',$value['width']);
					update_option($key . '_size_h',$value['height']);
					update_option($key . '_crop',$value['crop']);
					break;
				case 'avatar' :
				case 'small' :
				case 'xsmall' :
				default :
					add_image_size($key,$value['width'],$value['height'],TRUE);
					update_option($key . '_size_w',$value['width']);
					update_option($key . '_size_h',$value['height']);
					update_option($key . '_crop',$value['crop']);
			}
		}

	}// Method


	/* Hook
	_________________________
	*/
	public function register_nav_menus()
	{
		/**
			@access (public)
				Registers multiple custom navigation menus in the new custom menu editor of WordPress 3.0. 
				This allows for the creation of custom menus in the dashboard for use in your theme.
			@return (void)
			@reference (WP)
				You don't need to call add_theme_support( 'menus' ).
				An associative array of menu location slugs (key) and descriptions (according value).
				https://codex.wordpress.org/Function_Reference/register_nav_menus
		*/
		if(empty(self::$_theme_location)){return;}
		register_nav_menus(self::$_theme_location);

	}// Method


	/* Hook
	_________________________
	*/
	public function do_shortcode()
	{
		/**
			@access (public)
				By default,shortcodes are only supported in the body content of posts,pages and custom post types.
			@return (void)
			@reference (WP)
				https://developer.wordpress.org/reference/functions/do_shortcode/
				https://wpscholar.com/presentations/wordpress-shortcodes/
		*/
		add_filter('the_content','do_shortcode',11);
		// add_filter( 'the_content','do_shortcode' );
		// add_filter('widget_text','do_shortcode');

	}// Method


	/* Method
	_________________________
	*/
	public static function __get_image_size($needle = '')
	{
		/**
			@access (public)
				Returns the registerd image sizes.
			@param (string) $needle
				Image size identifier.
			@return (array)
			@reference
				[Parent]/model/data/param.php
		*/
		if(isset($needle) && array_key_exists($needle,self::$_image_size)){
			return self::$_image_size[$needle];
		}
		else{
			return self::$_image_size;
		}

	}//Method


	/* Method
	_________________________
	*/
	public static function __get_theme_location($needle = '')
	{
		/**
			@access (public)
				Returns the registerd nav locations.
			@param (string) $needle
				Image size identifier.
			@return (string)|(array)
		*/
		if(isset($needle) && array_key_exists($needle,self::$_theme_location)){
			return self::$_theme_location[$needle];
		}
		else{
			return self::$_theme_location;
		}

	}//Method


}// Class
endif;
// new _setup_theme_support();
_setup_theme_support::__get_instance();
