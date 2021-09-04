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
 * 
 * Inspired by yStandard WordPress Theme
 * @link https://wp-ystandard.com
 * @author yosiakatsuki
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
if(class_exists('_env_xml_sitemap') === FALSE) :
class _env_xml_sitemap
{
/**
 * [TOC]
 * 	__get_instance()
 * 	__construct()
 * 	set_post_type()
 * 	set_taxonomy()
 * 	set_hook()
 * 	invoke_hook()
 * 	wp_sitemaps_enabled()
 * 	wp_sitemaps_add_provider()
 * 	wp_sitemaps_post_types()
 * 	wp_sitemaps_taxonomies()
*/

	/**
		@access (private)
			Class properties.
		@var (string) $_class
			Name/Identifier with prefix.
		@var (string) $_index
			Name/Identifier without prefix.
		@var(array) $post_type
			Array of registered post type objects.
		@var(array) $taxonomy
			Array of registered taxonomy objects.
		@var(array) $hook
			Collection of hooks that is being registered (that is, actions or filters).
	*/
	private static $_class = '';
	private static $_index = '';
	private $post_type = array();
	private $taxonomy = array();
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

		/**
		 * @reference (WP)
		 * 	Retrieves the current Sitemaps server instance.
		 * 	https://developer.wordpress.org/reference/functions/wp_sitemaps_get_server/
		 * @return (WP_Sitemaps)
		 * 	Sitemaps instance.
		*/
		if(!function_exists('wp_sitemaps_get_server')){return;}

		// Init properties.
		self::$_class = __utility_get_class(get_class($this));
		self::$_index = __utility_get_index(self::$_class);

		$this->post_type = $this->set_post_type();
		$this->taxonomy = $this->set_taxonomy();

		// Register hooks.
		$this->hook = $this->set_hook();
		$this->invoke_hook($this->hook);

	}// Method


	/* Setter
	_________________________
	*/
	private function set_post_type($args = array(),$output = 'name',$operator = 'and')
	{
		/**
			@access (private)
				Set the post type for the post ID.
			@param (array)|(string) $args
				An array of key => value arguments to match against the post type objects.
				Default value: array()
			@param (string) $output
				The type of output to return. Accepts post type 'names' or 'objects'.
				Default value: 'names'
			@param (string) $operator
				The logical operation to perform.
				 - 'or' means only one element from the array needs to match;
				 - 'and' means all elements must match;
				 - 'not' means no elements may match.
				Default value: 'and'
			@return (string[])|(WP_Post_Type[])
				An array of post type names or objects.
				_filter[_env_xml_sitemap][post_type]
			@reference
				[Parent]/inc/trait/hook.php
				[Parent]/inc/utility/general.php
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		$return = array(
			'post',
			'page',
		);

		/**
		 * @since 1.0.1
		 * 	bbPress.
		 * 	https://ja.wordpress.org/plugins/bbpress/
		*/
		if(__utility_is_active_plugin('bbpress/bbpress.php')){
			$return['forum'] = 1;
			$return['topic'] = 1;
		}

		/**
		 * @since 1.0.1
		 * 	WooCommerce
		 * 	https://ja.wordpress.org/plugins/woocommerce/
		*/
		if(!__utility_is_active_plugin('woocommerce/woocommerce.php')){
			$return['product'] = 1;
			$return['shop_order'] = 1;
			$return['shop_coupon'] = 1;
			$return['shop_webhook'] = 1;
		}

		/**
		 * @reference (WP)
		 * 	Calls the callback functions that have been added to a filter hook.
		 * 	https://developer.wordpress.org/reference/functions/apply_filters/
		*/
		return apply_filters("_filter[{$class}][{$function}]",$return);

	}// Method


	/* Setter
	_________________________
	*/
	private function set_taxonomy()
	{
		/**
			@access (private)
				Set the taxonomy object of $taxonomy.
			@return (array)
				_filter[_env_xml_sitemap][taxonomy]
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
		return apply_filters("_filter[{$class}][{$function}]",__utility_get_categories());

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
				_filter[_env_xml_sitemap][hook]
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
			'wp_sitemaps_enabled' => array(
				'tag' => 'add_filter',
				'hook' => 'wp_sitemaps_enabled'
			),
			'wp_sitemaps_add_provider' => array(
				'tag' => 'add_filter',
				'hook' => 'wp_sitemaps_add_provider',
				'args' => 2
			),
			'wp_sitemaps_post_types' => array(
				'tag' => 'add_filter',
				'hook' => 'wp_sitemaps_post_types'
			),
			'wp_sitemaps_taxonomies' => array(
				'tag' => 'add_filter',
				'hook' => 'wp_sitemaps_taxonomies'
			),
		)));

	}// Method


	/* Hook
	_________________________
	*/
	public function wp_sitemaps_enabled($is_enabled)
	{
		/**
			@access (public)
				Filters the maximum number of words in a post excerpt.
				https://developer.wordpress.org/reference/hooks/excerpt_length/
			@param (bool) $is_enabled
				The maximum number of words.
				[Default] 55.
			@return (mixed)
				_filter[_env_xml_sitemap][wp_sitemaps_enabled]
			@reference
				[Parent]/inc/customizer/option.php
				[Parent]/inc/utility/general.php
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		/**
		 * @reference (WP)
		 * 	Calls the callback functions that have been added to a filter hook.
		 * 	https://developer.wordpress.org/reference/functions/apply_filters/
		*/
		return apply_filters("_filter[{$class}][{$function}]",FALSE);

	}// Method


	/* Hook
	_________________________
	*/
	public function wp_sitemaps_add_provider($provider,$name)
	{
		/**
			@access (public)
				投稿者別サイトマップの有効・無効
				Filters the sitemap provider before it is added.
				https://developer.wordpress.org/reference/hooks/wp_sitemaps_add_provider/
			@param (WP_Sitemaps_Provider) $provider
				Instance of a WP_Sitemaps_Provider.
			@param (string) $name
				Name of the sitemap provider.
			@return (mixed)
				_filter[_env_xml_sitemap][wp_sitemaps_add_provider]
			@reference
				[Parent]/inc/customizer/option.php
				[Parent]/inc/utility/general.php
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		/**
		 * @reference (WP)
		 * 	Calls the callback functions that have been added to a filter hook.
		 * 	https://developer.wordpress.org/reference/functions/apply_filters/
		*/
		// if('users' === $name && !Option::get_option_by_bool('ys_sitemap_enable_author',false)){
		if('users' === $name){
			return apply_filters("_filter[{$class}][{$function}]",FALSE);
		}
		return apply_filters("_filter[{$class}][{$function}]",$provider);

	}// Method


	/* Hook
	_________________________
	*/
	public function wp_sitemaps_post_types($post_types)
	{
		/**
			@access (public)
				Filters the list of post object sub types available within the sitemap.
				https://developer.wordpress.org/reference/hooks/wp_sitemaps_post_types/
			@param (WP_Post_Type[]) $post_types
				Array of registered post type objects keyed by their name.
			@return (mixed)
				_filter[_env_xml_sitemap][wp_sitemaps_post_types]
			@reference
				[Parent]/inc/customizer/option.php
				[Parent]/inc/utility/general.php
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		unset($post_types['attachment']);
		unset($post_types['revision']);
		unset($post_types['nav_menu_item']);

		/**
		 * @reference (WP)
		 * 	Calls the callback functions that have been added to a filter hook.
		 * 	https://developer.wordpress.org/reference/functions/apply_filters/
		*/
		return apply_filters("_filter[{$class}][{$function}]",$post_types);

	}// Method


	/* Hook
	_________________________
	*/
	public function wp_sitemaps_taxonomies($taxonomies)
	{
		/**
			@access (public)
				Filters the list of taxonomy object subtypes available within the sitemap.
				https://developer.wordpress.org/reference/hooks/wp_sitemaps_taxonomies/
			@param (WP_Taxonomy[]) $taxonomies
				Array of registered taxonomy objects keyed by their name.
			@return (mixed)
				_filter[_env_xml_sitemap][wp_sitemaps_taxonomies]
			@reference
				[Parent]/inc/customizer/option.php
				[Parent]/inc/utility/general.php
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		// unset($taxonomies['category']);
		// unset($taxonomies['post_tag']);
		// unset($taxonomies['custom_taxonomy']);

		/**
		 * @reference (WP)
		 * 	Calls the callback functions that have been added to a filter hook.
		 * 	https://developer.wordpress.org/reference/functions/apply_filters/
		*/
		return apply_filters("_filter[{$class}][{$function}]",$taxonomies);

	}// Method


}// Class
endif;
// new _env_xml_sitemap();
_env_xml_sitemap::__get_instance();
