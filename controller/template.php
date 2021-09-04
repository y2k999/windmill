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
if(class_exists('_controller_template') === FALSE) :
class _controller_template
{
/**
 * [TOC]
 * 	__get_instance()
 * 	__construct()
 * 	set_layout()
 * 	__render_content()
 * 	__render_header()
 * 	__render_sidebar()
 * 	__render_footer()
*/

	/**
		@access(private)
			Class properties.
		@var (string) $_class
			Name/Identifier with prefix.
		@var (string) $_index
			Name/Identifier without prefix.
		@var (array) $_layout
			Archive grid layout settings.
	*/
	private static $_class = '';
	private static $_index = '';
	private static $_layout = array();

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
		self::$_layout = $this->set_layout();

	}// Method


	/* Setter
	_________________________
	*/
	private function set_layout()
	{
		/**
			@access (private)
				Set archive grid layout settings from the Beans Extension plugin.
			@return (array)
				_filter[_controller_template][layout]
			@reference
				[Parent]/inc/utility/general.php
				[Plugin]/beans_extension/admin/tab/layout.php
				[Plugin]/beans_extension/utility/theme.php
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		$home = beans_get_layout_setting('home');
		$archive = beans_get_layout_setting('archive');

		$return = array();
		switch($home){
			case 'card' :
				$return['home'] = 'card';
				$return['search'] = 'card';
				break;
			case 'list' :
			default :
				$return['home'] = 'list';
				$return['search'] = 'list';
		}

		switch($archive){
			case 'list' :
				$return['archive'] = 'list';
				break;
			case 'card' :
			default :
				$return['archive'] = 'card';
		}

		/**
		 * @reference (Beans)
		 * 	Call the functions added to a filter hook.
		 * 	https://www.getbeans.io/code-reference/functions/beans_apply_filters/
		*/
		return beans_apply_filters("_filter[{$class}][{$function}]",$return);

	}// Method


	/* Method
	_________________________
	*/
	public static function __render_content($file = '')
	{
		/**
			[Shortcut]
				__utility_template_content()
			@access (public)
				Loads the requested template file.
				https://developer.wordpress.org/reference/functions/get_template_part/
			@param (string) $file
				File to load.
			@return (void)|(false)
				Void on success,false if the template does not exist.
			@reference
				[Parent]/404.php
				[Parent]/index.php
				[Parent]/inc/setup/constant.php
				[Parent]/inc/utility/general.php
				[Parent]/inc/utility/theme.php
				[Parent]/template/content/xxx.php
		*/
		if(isset($file) && file_exists($file)){
			require_once $file;
			return TRUE;
		}
		else{
			// $function = __utility_get_function(__FUNCTION__);

			if(is_404()){
				/**
				 * @reference (WP)
				 * 	Determines whether the query has resulted in a 404 (returns no results).
				 * 	https://developer.wordpress.org/reference/functions/is_404/
				*/
				get_template_part(SLUG['template'] . 'content/404');
			}
			elseif(is_singular()){
				/**
				 * @reference (WP)
				 * 	Determines whether the query is for an existing single post of any post type (post,attachment,page,custom post types).
				 * 	https://developer.wordpress.org/reference/functions/is_singular/
				*/
				get_template_part(SLUG['template'] . 'content/singular');
			}
			// elseif(is_home() || is_front_page() && (get_option('show_on_front') === 'posts')){
			elseif(is_home()){
				// Configure the parameter for the template.
				$args['layout'] = self::$_layout['home'];
				/**
				 * @reference (WP)
				 * 	Determines whether the query is for the blog homepage.
				 * 	https://developer.wordpress.org/reference/functions/is_home/
				*/
				get_template_part(SLUG['template'] . 'content/home',NULL,$args);
			}
			elseif(is_search()){
				// Configure the parameter for the template.
				$args['layout'] = self::$_layout['search'];
				/**
				 * @reference (WP)
				 * 	Determines whether the query is for the blog homepage.
				 * 	https://developer.wordpress.org/reference/functions/is_home/
				*/
				get_template_part(SLUG['template'] . 'content/search',NULL,$args);
			}
			elseif(is_archive() || is_post_type_archive()){
				// Configure the parameter for the template.
				$args['layout'] = self::$_layout['archive'];
				/**
				 * @reference (WP)
				 * 	Determines whether the query is for an existing archive page.
				 * 	https://developer.wordpress.org/reference/functions/is_archive/
				 * 	Determines whether the query is for an existing post type archive page.
				 * 	https://developer.wordpress.org/reference/functions/is_post_type_archive/
				*/
				get_template_part(SLUG['template'] . 'content/archive',NULL,$args);
			}
			else{
				get_template_part(SLUG['template'] . 'content/index');
			}
			return TRUE;
		}

	}// Method


	/* Method
	_________________________
	*/
	public static function __render_header($file = '')
	{
		/**
			[Shortcut]
				__utility_template_header()
			@access (public)
				Loads the requested template file.
				https://developer.wordpress.org/reference/functions/get_template_part/
			@param (string) $file
				File to load.
			@return (void)|(false)
				Void on success,false if the template does not exist.
			@reference
				[Parent]/header.php
				[Parent]/inc/setup/constant.php
				[Parent]/inc/utility/general.php
				[Parent]/inc/utility/theme.php
				[Parent]/template/header/xxx.php
		*/
		if(isset($file) && file_exists($file)){
			require_once $file;
			return TRUE;
		}
		else{
			// $function = __utility_get_function(__FUNCTION__);
			get_template_part(SLUG['template'] . 'header/header');
			return TRUE;
		}

	}// Method


	/* Method
	_________________________
	*/
	public static function __render_sidebar($file = '')
	{
		/**
			[Shortcut]
				__utility_template_sidebar()
			@access (public)
				Loads the requested template file.
				https://developer.wordpress.org/reference/functions/get_template_part/
			@param (string) $file
				File to load.
			@return (void)|(false)
				Void on success,false if the template does not exist.
			@reference
				[Parent]/sidebar.php
				[Parent]/inc/setup/constant.php
				[Parent]/inc/utility/general.php
				[Parent]/inc/utility/theme.php
				[Parent]/template/sidebar/xxx.php
		*/
		if(isset($file) && file_exists($file)){
			require_once $file;
			return TRUE;
		}
		else{
			// $function = __utility_get_function(__FUNCTION__);
			get_template_part(SLUG['template'] . 'sidebar/sidebar');
			return TRUE;
		}

	}// Method


	/* Method
	_________________________
	*/
	public static function __render_footer($file = '')
	{
		/**
			[Shortcut]
				__utility_template_footer()
			@access (public)
				Loads the requested template file.
				https://developer.wordpress.org/reference/functions/get_template_part/
			@param (string) $file
				File to load.
			@return (void)|(false)
				Void on success,false if the template does not exist.
			@reference
				[Parent]/footer.php
				[Parent]/inc/setup/constant.php
				[Parent]/inc/utility/general.php
				[Parent]/inc/utility/theme.php
				[Parent]/template/footer/xxx.php
		*/
		if(isset($file) && file_exists($file)){
			require_once $file;
			return TRUE;
		}
		else{
			// $function = __utility_get_function(__FUNCTION__);
			get_template_part(SLUG['template'] . 'footer/footer');
			return TRUE;
		}

	}// Method


}// Class
endif;
// new _controller_template();
_controller_template::__get_instance();
