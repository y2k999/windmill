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
if(class_exists('_env_search') === FALSE) :
class _env_search
{
/**
 * [TOC]
 * 	__get_instance()
 * 	__construct()
 * 	set_hook()
 * 	invoke_hook()
 * 	where()
 * 	highlight()
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
				_filter[_env_search][hook]
			@reference
				[Parent]/inc/trait/hook.php
				[Parent]/inc/utility/general.php
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		/**
		 * @reference (WP)
		 * 	Determines whether the current request is for an administrative interface page.
		 * 	https://developer.wordpress.org/reference/functions/is_admin/
		 * 	Calls the callback functions that have been added to a filter hook.
		 * 	https://developer.wordpress.org/reference/functions/apply_filters/
		*/
		if(is_admin()){
			return apply_filters("_filter[{$class}][{$function}]",array());
		}
		else{
			return apply_filters("_filter[{$class}][{$function}]",$this->set_parameter_hook(array(
				// Search result highlight.
				'the_title' => array(
					'tag' => 'add_filter',
					'callback' => 'highlight',
					'priority' => PRIORITY['mid-high']
				),
				'the_content' => array(
					'tag' => 'add_filter',
					'callback' => 'highlight',
					'priority' => PRIORITY['mid-high']
				),
				'the_excerpt' => array(
					'tag' => 'add_filter',
					'callback' => 'highlight',
					'priority' => PRIORITY['mid-high']
				),
/*
				'posts_where' => array(
					'tag' => 'add_filter',
					'callback' => 'posts_where',
					'args' => 2
				),
*/
				'pre_get_posts' => array(
					'tag' => 'add_action',
					'callback' => 'pre_get_posts'
				),
			)));
		}

	}// Method


	/* Hook
	_________________________
	*/
	public function highlight($text){
		/**
			@access (public)
				Query heighlight
			@param (string) $text
			@return (string)
		*/

		/**
		 * @reference (WP)
		 * 	Determines whether the current request is for an administrative interface page.
		 * 	https://developer.wordpress.org/reference/functions/is_admin/
		*/
		if(is_admin()){return;}

		/**
		 * @reference (WP)
		 * 	Determines whether the query is for a search.
		 * 	https://developer.wordpress.org/reference/functions/is_search/
		*/
		if(is_search() && is_main_query()){
			/**
			 * @reference (WP)
			 * 	Retrieves the value of a query variable in the WP_Query class.
			 * 	https://developer.wordpress.org/reference/functions/get_query_var/
			*/
			$result = get_query_var('s');
			$key = explode(' ',$result);
			// $text = preg_replace('/(' . implode('|',$key) . ')/iu','<mark>' . $result . '</mark>',$text);
			$text = preg_replace('/(' . implode('|',$key) . ')/iu','<mark class="uk-text-bolder uk-text-danger">' . $result . '</mark>',$text);
		}
		return $text;

	}// Method



	/* Hook
	_________________________
	*/
	public function pre_get_posts($query){
		/**
			@access (public)
				Fires after the query variable object is created, but before the actual query is run.
				https://developer.wordpress.org/reference/hooks/pre_get_posts/
			@param (WP_Query) $query
				The WP_Query instance (passed by reference).
			@return (void)
		*/

		/**
		 * @reference (WP)
		 * 	Determines whether the current request is for an administrative interface page.
		 * 	https://developer.wordpress.org/reference/functions/is_admin/
		*/
		if(is_admin()){return;}

		if($query->is_main_query() && $query->is_search()){

			// $query->set('orderby','date');

			if(__utility_is_active_plugin('woocommerce/woocommerce.php') && __utility_is_active_plugin('bbpress/bbpress.php')){
				$post_type = array(
					'post',
					'page',
					'forum',
					'topic',
					'product',
				);
			}
			elseif(__utility_is_active_plugin('woocommerce/woocommerce.php') && !__utility_is_active_plugin('bbpress/bbpress.php')){
				$post_type = array(
					'post',
					'page',
					'product',
				);
			}
			elseif(!__utility_is_active_plugin('woocommerce/woocommerce.php') && __utility_is_active_plugin('bbpress/bbpress.php')){
				$post_type = array(
					'post',
					'page',
					'forum',
					'topic',
				);
			}
			else{
				$post_type = array(
					'post',
					'page',
				);
			}

			$query->set('post_type',$post_type);

		}

	}// Method


	/* Hook
	_________________________
	*/
	public function posts_where($where,$obj)
	{
		/**
			@access (public)
				Filters the WHERE clause of the query.
				https://developer.wordpress.org/reference/hooks/posts_where/
			@param (string) $where
				The WHERE clause of the query.
			@param (WP_Post) $obj
				The WP_Query instance (passed by reference).
			@return (string)
		*/

		/**
		 * @reference (WP)
		 * 	Determines whether the current request is for an administrative interface page.
		 * 	https://developer.wordpress.org/reference/functions/is_admin/
		*/
		if(is_admin()){return;}

		if($obj->is_search){
			$where = str_replace('.post_title','.post_title COLLATE utf8_unicode_ci',$where);
			$where = str_replace('.post_content','.post_content COLLATE utf8_unicode_ci',$where);
		}
		return $where;

	}// Method


}// Class
endif;
// new _env_search();
_env_search::__get_instance();
