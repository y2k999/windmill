<?php 
/**
 * Configure the integration with third-party libraries.
 * @link https://jetpack.com/
 * @package Windmill
 * @license GPL3.0+
 * @since 1.0.1
*/

/**
 * Inspired by Beans Framework WordPress Theme
 * @link https://www.getbeans.io
 * @author Thierry Muller
 * 
 * Inspired by Luxeritas WordPress Theme
 * @link https://thk.kanzae.net/wp/
 * @author LunaNuko
 * 
 * Inspired by KANSO General WordPress Theme
 * @link http://kansowp.toiee.jp/
 * @author toiee Lab
 * 
 * Inspired by Jetpack WordPress Plugin
 * @link https://jetpack.com/
 * @author Automattic
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
if(class_exists('_windmill_jetpack') === FALSE) :
class _windmill_jetpack
{
/**
 * [TOC]
 * 	__get_instance()
 * 	__construct()
 * 	set_hook()
 * 	hook_hook()
 * 	add_theme_support()
 * 	__render_infinite_scroll()
*/

	/**
		@access (private)
			Class properties.
		@var (string) $_class
			Name/identifier with prefix.
		@var (string) $_index
			Name/identifier without prefix.
		@var (array) $hook
			Collection of hooks that is being registered (that is, actions or filters).
		@var (bool) $open_graph
		@var (bool) $lazyload
	*/
	private static $_class = '';
	private static $_index = '';
	private $hook = array();

	private $open_graph = FALSE;
	private $lazyload = FALSE;

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

		// Run
		$this->open_graph();
		$this->lazyload();

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
			'add_theme_support' => array(
				'tag' => 'add_action',
				'hook' => 'init'
			),
		)));

	}// Method


	/* Method
	_________________________
	*/
	private function open_graph()
	{
		/**
			@access (private)
				Jetpack og tags
				https://thk.kanzae.net/wp/
			@return (void)
		*/
		if($this->open_graph){
			if(has_filter('wp_head','jetpack_og_tags') !== FALSE){
				remove_action('wp_head','jetpack_og_tags',10000);
			}
			add_filter('jetpack_enable_open_graph','__return_false',99);
		}

	}// Method


	/* Method
	_________________________
	*/
	private function lazyload()
	{
		/**
			@access (private)
				Jetpack lazy image
				https://thk.kanzae.net/wp/
			@return (void)
		*/
		if($this->lazyload){
			if(class_exists('Jetpack_Lazy_Images') === TRUE){
				add_action('wp_head',function(){
					$instance = Jetpack_Lazy_Images::instance();
					$instance->remove_filters();
				},10000);
			}
			add_filter('lazyload_is_enabled','__return_false',99);
		}

	}// Method


	/* Hook
	_________________________
	*/
	public function add_theme_support()
	{
		/**
			@access (public)
				Jetpack setup function.
			@return (void)
			@reference (WP)
				Fires after WordPress has finished loading but before any headers are sent.
				https://developer.wordpress.org/reference/hooks/init/
				Registers theme support for a given feature.
				https://developer.wordpress.org/reference/functions/add_theme_support/
		*/

		/**
		 * @since 1.0.1
		 * 	Add theme support for Infinite Scroll.
		 * @reference (JP)
		 * 	By providing a few key pieces of information when calling add_theme_support(), Infinite Scroll will seamlessly integrate with your theme.
		 * 	https://jetpack.com/support/infinite-scroll/
		*/
		add_theme_support('infinite-scroll',array(
			'container' => 'main',
			'render' => [$this,'__render_infinite_scroll'],
			'footer' => 'page',
		));

		/**
		 * @since 1.0.1
		 * 	Add theme support for Responsive Videos.
		 * @reference (JP)
		 * 	Jetpack includes an option to add responsive video support to your theme, and thus make sure that all videos display just as nicely on mobile devices as they do on your largest display.
		 * 	https://jetpack.com/support/responsive-videos/
		*/
		add_theme_support('jetpack-responsive-videos');

		/**
		 * @since 1.0.1
		 * 	Add theme support for Content Options.
		 * @reference (JP)
		 * 	Content Options allows site owners to make small visual modifications across their site, like hiding the post date or displaying an excerpt instead of a full post.
		 * 	https://jetpack.com/support/content-options/
		*/
		add_theme_support('jetpack-content-options',array(
			/**
			 * @since 1.0.1
			 * 	Lets users show or hide the post date, tags, categories, or author.
			*/
			'post-details' => array(
				// Name of the theme's stylesheet.
				'stylesheet' => 'style',
				// a CSS selector matching the elements that display the post date.
				'date' => '.posted-on',
				// a CSS selector matching the elements that display the post categories.
				'categories' => '.cat-links',
				// a CSS selector matching the elements that display the post tags.
				'tags' => '.tags-links',
				// a CSS selector matching the elements that display the post author.
				'author' => '.byline',
				// a CSS selector matching the elements that display the comment link.
				'comment' => '.comments-link',
			),

			/**
			 * @since 1.0.1
			 * 	Lets users display featured images on blog and archive pages, single posts, and pages.
			*/
			'featured-images' => array(
				// Enable or not the featured image check for archive pages: true or false.
				'archive' => TRUE,
				// Enable or not the featured image check for single posts: true or false.
				'post' => TRUE,
				// Enable or not the featured image check for single pages: true or false.
				'page' => TRUE,
			),
		));

	}// Method


	/**
		@access (public)
			Custom render function for Infinite Scroll.
		@return (void)
		@reference (JP)
			Infinite Scroll uses a standard WordPress loop to render the additional posts it appends, and utilizes template parts in the content-{post format}.php form.
			If a theme includes at least content.php, then the render argument can be omitted.
			https://jetpack.com/support/infinite-scroll/
		@reference
			[Parent]/inc/setup/constant.php
			[Parent]/template-part/content/content.php
			[Parent]/template-part/content/content-home.php
	*/
	public function __render_infinite_scroll()
	{
		/**
		 * @reference (WP)
		 * 	Determines whether current WordPress query has posts to loop over.
		 * 	https://developer.wordpress.org/reference/functions/have_posts/
		 * 	Iterate the post index in the loop.
		 * 	https://developer.wordpress.org/reference/functions/the_post/
		*/
		while(have_posts()) :	the_post();
			/**
			 * @reference (WP)
			 * 	Determines whether the query is for a search.
			 * 	https://developer.wordpress.org/reference/functions/is_search/
			*/
			if(is_search()) :
				get_template_part(SLUG['content'] . 'content','home');
			else :
				/**
				 * @reference (WP)
				 * 	Retrieve the format slug for a post
				 * 	https://developer.wordpress.org/reference/functions/get_post_format/
				 * @reference
				 * 	[Parent]/inc/setup/theme-support.php
				*/
				get_template_part(SLUG['content'] . 'content',get_post_format());
			endif;
		endwhile;

	}// Method


}// Class
endif;
// new _windmill_jetpack();
_windmill_jetpack::__get_instance();
