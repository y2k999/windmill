<?php
/**
 * Set environmental configurations which enhance the theme by hooking into WordPress.
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
if(class_exists('_env_archive') === FALSE) :
class _env_archive
{
/**
 * [TOC]
 * 	__get_instance()
 * 	__construct()
 * 	set_hook()
 * 	invoke_hook()
 * 	wp_list_categories()
 * 	get_archives_link()
 * 	getarchives_where()
*/

	/**
		@access (private)
			Class properties.
		@var (string) $_class
			Name/Identifier with prefix.
		@var (string) $_index
			Name/Identifier without prefix.
		@var (array) $hook
			Collection of hooks that is being registered (that is, actions or filters).
	*/
	private static $_class = '';
	private static $_index = '';
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

		// Register hooks.
		$this->hook = $this->set_hook();
		$this->invoke_hook($this->hook);

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
				_filter[_env_archive][hook]
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
			// Filter
			'widget_categories_args' => array(
				'tag' => 'add_filter',
				'hook' => 'widget_categories_args'
			),
			'wp_list_categories' => array(
				'tag' => 'add_filter',
				'hook' => 'wp_list_categories',
				'args' => 2
			),
			'get_archives_link' => array(
				'tag' => 'add_filter',
				'hook' => 'get_archives_link'
			),
			// Action
			'getarchives_where' => array(
				'tag' => 'add_action',
				'hook' => 'getarchives_where'
			),
		)));

	}// Method


	/* Hook
	_________________________
	*/
	public function widget_categories_args($cat_args)
	{
		/**
			@access (public)
				Filters the arguments for the Categories widget.
				https://developer.wordpress.org/reference/hooks/widget_categories_args/
			@param (array) $cat_args
				An array of Categories widget options.
			@param (array) $instance
				Array of settings for the current widget.
			@return (array)
		*/
		$cat_args['number'] = 10;
		return $cat_args;

	}// Method


	/* Hook
	_________________________
	*/
	public function wp_list_categories($output,$args)
	{
		/**
			@access (public)
				Displays or retrieves the HTML list of categories.
				https://developer.wordpress.org/reference/hooks/wp_list_categories/
			@param (string) $output
				HTML output.
			@param (array) $args
				An array of taxonomy-listing arguments.
				See wp_list_categories() for information on accepted arguments.
			@return (string)
		*/
		$output = preg_replace('/<\/a>\s*\((\d+)\)/',' ($1)</a>',$output);
		return $output;

	}// Method


	/* Hook
	_________________________
	*/
	public function get_archives_link($link_html)
	{
		/**
			@access (public)
				Retrieve archive link content based on predefined or custom code.
				https://developer.wordpress.org/reference/functions/get_archives_link/
			@param (string) $link_html
				HTML link content for archive.
			@return (string)
		*/
		$regex = '/^\t<(link |option |li>)/';

		if(preg_match($regex,$link_html,$m)){
			switch($m[1]){
				case 'option ' :
					$search = '<option';
					$replace = '<option selected = "selected"';
					$regex = "/^\t<option value = '([^']+)'>[^<]+<\/option>/";
					break;

				case 'li>' :
					$search = '<li>';
					$replace = '<li class = "current-arichive-item">';
					$regex = "/^\t<li><a href = '([^']+)' title = '[^']+'>[^<]+<\/a><\/li>/";
					break;

				default :
					$search = '';
					$replace = '';
					$regex = '';
			}
		}

		/**
		 * @reference (WP)
		 * 	Determines whether the query is for an existing month archive.
		 * 	https://developer.wordpress.org/reference/functions/is_month/
		*/
		if(is_month() && $regex && preg_match($regex,$link_html,$m)){
			if(preg_match('/' . preg_quote($_SERVER['REQUEST_URI'],'/') . '$/',$m[1])){
				$link_html = str_replace($search,$replace,$link_html);
			}
		}
		return $link_html;

	}// Method


	/* Hook
	_________________________
	*/
	public function getarchives_where($where)
	{
		/**
			@access (public)
				Filters the SQL WHERE clause for retrieving archives.
				https://developer.wordpress.org/reference/hooks/getarchives_where/
			@param (string) $where
				Portion of SQL query containing the WHERE clause.
			@return (string)
			@reference
				[Parent]/inc/utility/general.php
		*/
		if(__utility_is_active_plugin('woocommerce/woocommerce.php') && __utility_is_active_plugin('bbpress/bbpress.php')){
			$where = "WHERE (post_type='post' OR post_type='forum' OR post_type='topic' OR post_type='product') AND post_status='publish'";
		}
		elseif(__utility_is_active_plugin('woocommerce/woocommerce.php')){
			$where = "WHERE (post_type='post' OR post_type='product') AND post_status='publish'";
		}
		elseif(__utility_is_active_plugin('bbpress/bbpress.php')){
			$where = "WHERE (post_type='post' OR post_type='forum' OR post_type='topic') AND post_status='publish'";
		}
		return $where;

	}// Method


}// Class
endif;
// new _env_archive();
_env_archive::__get_instance();
