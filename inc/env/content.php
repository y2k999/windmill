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
 * Inspired by Web Design Leaves WordPress Site
 * @link https://www.webdesignleaves.com/pr/wp/wp_func_pager.html
 * @author Web Design Leaves
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
if(class_exists('_env_content') === FALSE) :
class _env_content
{
/**
 * [TOC]
 * 	__get_instance()
 * 	__construct()
 * 	set_hook()
 * 	invoke_hook()
 * 	cleanup()
 * 	cache_meta()
 * 	post_class()
 * 	body_class()
 * 	wp_link_pages_args()
 * 	wp_link_pages()
 * 	wp_list_pages()
 * 	replace_page_item()
 * 	strip_empty_classes()
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

		$this->cleanup();

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
				_filter[_env_content][hook]
			@reference
				[Parent]/inc/setup/constant.php
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
/*
			'cache_meta' => array(
				'tag' => 'add_filter',
				'hook' => 'posts_results',
				'args' => 2
			),
*/
			'post_class' => array(
				'tag' => 'add_filter',
				'hook' => 'post_class',
				'args' => 3
			),
			'body_class' => array(
				'tag' => 'add_filter',
				'hook' => 'body_class'
			),
			'wp_link_pages_args' => array(
				'tag' => 'add_filter',
				'hook' => 'wp_link_pages_args',
			),
			'wp_link_pages' => array(
				'tag' => 'add_filter',
				'hook' => 'wp_link_pages',
			),
			'wp_list_pages' => array(
				'tag' => 'add_filter',
				'hook' => 'wp_list_pages',
			),
			// Action
			'replace_page_item' => array(
				'tag' => 'add_action',
				'hook' => 'page_css_class',
				'priority' => PRIORITY['mid-high']
			),
			'strip_empty_classes' => array(
				'tag' => 'add_action',
				'hook' => 'wp_list_pages'
			),
		)));

	}// Method


	/* Hook
	_________________________
	*/
	public function wp_link_pages_args($parsed_args)
	{
		/**
			@access (public)
				Filters the arguments used in retrieving page links for paginated posts.
				https://developer.wordpress.org/reference/hooks/wp_link_pages_args/
			@param (array) $parsed_args
				An array of page link arguments.
				See wp_link_pages() for information on accepted arguments.
			@return (array)
			@reference
				https://www.webdesignleaves.com/pr/wp/wp_func_pager.html
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		/**
		 * @reference (WP)
		 * 	Calls the callback functions that have been added to a filter hook.
		 * 	https://developer.wordpress.org/reference/functions/apply_filters/
		*/
		return apply_filters("_filter[{$class}][{$function}]",array(
			'before' => '<nav id="post-nav-links" aria-label="' . esc_attr__('Page Nav Links','windmill') . '"><ul class="uk-pagination uk-flex-center uk-padding nav-links">'. "\n",			'after' => '</ul></nav>',
			'link_before' => '',
			'link_after' => '',
			'aria_current' => $parsed_args['aria_current'],
			'next_or_number' => 'number',
			'separator' => '  ',
			'nextpagelink' => esc_html__('Next','windmill'),
			'previouspagelink' => esc_html__('Previous','windmill'),
			'pagelink' => '%',
			'echo' => TRUE,
		));

	}// Method


	/* Hook
	_________________________
	*/
	public function wp_link_pages($output)
	{
		/**
			@access (public)
				Filters the HTML output of page links for paginated posts.
				https://developer.wordpress.org/reference/hooks/wp_link_pages/
			@param (string) $output
				HTML output of paginated posts' page links.
			@param (array) $args
				An array of arguments.
				See wp_link_pages() for information on accepted arguments.
			@return (string)
			@reference
				https://www.webdesignleaves.com/pr/wp/wp_func_pager.html
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		/**
		 * @reference (WP)
		 * 	Calls the callback functions that have been added to a filter hook.
		 * 	https://developer.wordpress.org/reference/functions/apply_filters/
		*/
		$pattern = apply_filters("_filter[{$class}][{$function}][pattern]",array(
			'#<a ([^>]*) class=([\'\"]([^\'\"]*)[\'\"])>(\d*)</a>#', 
			'#<span class=([\'\"]([^\'\"]*)[\'\"])\s?([^>]*)>(\d*)</span>#',
		));

		$replacement = apply_filters("_filter[{$class}][{$function}][replacement]",array(
			'<li><a $1 class="$3 page-link">$4</a></li>'. "\n",
			'<li class="uk-active active"><span class="$2 page-link" $3>$4</span></li>'. "\n",
		));

		ksort($pattern);
		ksort($replacement);

		return preg_replace($pattern,$replacement,$output);
		
	}// Method


	/* Hook
	_________________________
	*/
	public function wp_list_pages($output)
	{
		/**
			@access (public)
				Filters the HTML output of the pages to list.
				https://developer.wordpress.org/reference/hooks/wp_list_pages/
			@param (string) $output
				HTML output of the pages list.
			@param (array) $args
				An array of page-listing arguments.
				See wp_list_pages() for information on accepted arguments.
			@param (WP_Post[]) $pages
				Array of the page objects.
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		$pattern = '<li>';
		$replacement = '<li class="uk-padding-small">';

		return str_replace($pattern,$replacement,$output);

	}// Method


	/* Method
	_________________________
	*/
	private function cleanup()
	{
		/**
			@access (private)
				Filters the post content.
				https://developer.wordpress.org/reference/hooks/the_content/
				Filters the displayed post excerpt.
				https://developer.wordpress.org/reference/hooks/the_excerpt/
			@return (void)
			@reference
				[Parent]/inc/setup/constant.php
		*/

		/**
		 * @reference (WP)
		 * 	Replaces double line breaks with paragraph elements.
		 * 	https://developer.wordpress.org/reference/functions/wpautop/
		*/
		remove_filter('the_content','wpautop',PRIORITY['mid-high']);
		remove_filter('the_excerpt','wpautop',PRIORITY['mid-high']);

		/**
		 * @reference (WP)
		 * 	Converts lone & characters into &#038; (a.k.a. &amp;)
		 * 	https://developer.wordpress.org/reference/functions/convert_chars/
		*/
		remove_filter('the_content','convert_chars',PRIORITY['mid-high']);
		remove_filter('the_excerpt','convert_chars',PRIORITY['mid-high']);

		/**
		 * @reference (WP)
		 * 	Replaces common plain text characters with formatted entities.
		 * 	https://developer.wordpress.org/reference/functions/wptexturize/
		*/
		remove_filter('the_title','wptexturize');
		remove_filter('the_content','wptexturize');

		/**
		 * @reference (WP)
		 * 	Filters the text of a comment to be displayed.
		 * 	https://developer.wordpress.org/reference/hooks/comment_text/
		 * 	Removes the filter called “make_clickable,” which parses comments and makes all URLs clickable.
		*/
		remove_filter('comment_text','make_clickable',PRIORITY['mid-low']);

	}// Method


	/* Hook
	_________________________
	*/
	public function cache_meta($posts,$query)
	{
		/**
			@access (public)
				Filters the raw post results array, prior to status checks.
				https://developer.wordpress.org/reference/hooks/posts_results/
			@param (WP_Post[]) $posts
				Array of post objects.
				https://developer.wordpress.org/reference/classes/wp_post/
			@param (WP_Query) $query
				The WP_Query instance(passed by reference).
				https://developer.wordpress.org/reference/classes/wp_query/
			@return (WP_Post)
		*/

		/**
		 * @reference (WP)
		 * 	Checks whether the given variable is a WordPress Error.
		 * 	https://developer.wordpress.org/reference/functions/is_wp_error/
		 * 	Determines whether the query is for an existing single post.
		 * 	https://developer.wordpress.org/reference/functions/is_single/
		 * 	Determines whether the query is for an existing single page.
		 * 	https://developer.wordpress.org/reference/functions/is_page/
		*/
		if(empty($posts) || is_wp_error($posts) || is_single() || is_page() || count($posts) < 3){
			return $posts;
		}

		$posts_to_cache = array();
		foreach($posts as $post){
			if(isset($post->ID) && isset($post->post_type)){
				$posts_to_cache[$post->ID] = 1;
			}
		}

		if(empty($posts_to_cache)){
			return $posts;
		}

		/**
		 * @reference (WP)
		 * 	Updates the metadata cache for the specified objects.
		 * 	https://developer.wordpress.org/reference/functions/update_meta_cache/
		*/
		update_meta_cache('post',array_keys($posts_to_cache));

		unset($posts_to_cache);

		return $posts;

	}// Method


	/* Hook
	_________________________
	*/
	public function post_class($classes,$class,$post_id)
	{
		/**
			@access (public)
				By default, the class ‘hentry’ is always added to each post.
				https://developer.wordpress.org/reference/functions/get_post_class/
			@param (string)|(string[]) $classes
				Space-separated string or array of class names to add to the class list.
			@return (string)|(string[])
			@reference (Uikit)
				https://getuikit.com/docs/article
			@reference
				[Parent]/inc/utility/theme.php
		*/
		if(__utility_is_uikit()){
			if(is_singular()){
				$classes[] = 'uk-article';
			}
		}

		/**
		 * @reference (WP)
		 * 	Determines whether the query is for an existing single post of any post type (post, attachment, page, custom post types).
		 * 	https://developer.wordpress.org/reference/functions/is_singular/
		*/
		if(!is_singular('post')){
			$classes = array_diff($classes,['hentry']);
		}
		return $classes;

	}// Method


	/* Hook
	_________________________
	*/
	public function body_class($classes)
	{
		/**
			@access (public)
				Filters the list of CSS body class names for the current post or page.
				https://developer.wordpress.org/reference/hooks/body_class/
			@param (string)|(string[]) $classes
				Space-separated string or array of class names to add to the class list.
			@return (string)|(string[])
		*/

		/**
		 * @reference (WP)
		 * 	Whether the site is being previewed in the Customizer.
		 * 	https://developer.wordpress.org/reference/functions/is_customize_preview/
		*/
		if(is_customize_preview()){
			$classes[] = 'is-customize-preview';
		}
		return $classes;

	}// Method


	/* Hook
	_________________________
	*/
	public function replace_page_item($css_class)
	{
		/**
			@access (public)
				Filters the list of CSS classes to include with each page item in the list.
				https://developer.wordpress.org/reference/hooks/page_css_class/
			@param (string[]) $css_class
				An array of CSS classes to be applied to each list item.
			@return (array)
		*/
		if(is_array($css_class)){
			$varci = array_intersect($css_class,array('current_page_item'));
			$cmeni = array('current_page_item');
			$selava = array('on');
			$selavaend = array();
			$selavaend = str_replace($cmeni,$selava,$varci);
		}
		else{
			$selavaend = '';
		}
		return $selavaend;

	}// Method


	/* Hook
	_________________________
	*/
	public function strip_empty_classes($menu)
	{
		/**
			@access (public)
				Filters the HTML output of the pages to list.
				https://developer.wordpress.org/reference/hooks/wp_list_pages/
			@param (array) $menu
			@return (array)
		*/
		$menu = preg_replace('/ class=(["\'])(?!on).*?\1/','',$menu);
		return $menu;

	}// Method


}// Class
endif;
// new _env_content();
_env_content::__get_instance();
