<?php
/**
 * Set environmental configurations which enhance the theme by hooking into WordPress.
 * @package Windmill
 * @license GPL3.0+
 * @since 1.0.1
*/

/**
 * Inspired by wp_head() cleaner WordPress Plugin
 * @link https://wordpress.org/plugins/wp-head-cleaner/
 * @author Jonathan Wilsson
 * 
 * Inspired by Luxeritas WordPress Theme
 * @link https://thk.kanzae.net/wp/
 * @author LunaNuko
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
if(class_exists('_env_head') === FALSE) :
class _env_head
{
/**
 * [TOC]
 * 	__get_instance()
 * 	__construct()
 * 	set_field()
 * 	set_hook()
 * 	cleanup()
 * 	staticize()
 * 	remove_dns_prefetch()
 * 	meta_format_detection()
 * 	meta_keywords()
 * 	meta_description()
 * 	__get_description()
 * 	canonical()
 * 	noindex()
*/

	/**
		@access (private)
			Class properties.
		@var (string) $_class
			Name/Identifier with prefix.
		@var (string) $_index
			Name/Identifier without prefix.
		@var (array) $field
			Custom fields for SEO.
		@var (array) $hook
			Collection of hooks that is being registered (that is, actions or filters).
	*/
	private static $_class = '';
	private static $_index = '';
	private static $_field = array();
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

		self::$_field = $this->set_field();

		$this->cleanup();
		$this->staticize();

		// Register hooks.
		$this->hook = $this->set_hook();
		$this->invoke_hook($this->hook);

	}// Method


	/* Setter
	_________________________
	*/
	private function set_field()
	{
		/**
			@access (private)
				Set Custom fields for SEO.
				https://ja.wordpress.org/plugins/all-in-one-seo-pack/
			@return (array)
				_filter[_env_head][field]
			@reference
				[Parent]/inc/plugin/aioseop.php
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
			'title' => '_aioseop_title',
			'keywords' => '_aioseop_keywords',
			'description' => '_aioseop_description',
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
				_filter[_env_head][hook]
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
			'admin_bar_bump_cb' => array(
				'tag' => 'add_action',
				'hook' => HOOK_POINT['head']['before']
			),
			'remove_dns_prefetch' => array(
				'tag' => 'add_action',
				'hook' => 'wp_resource_hints',
				'args' => 2
			),
/*
			'meta_keywords' => array(
				'tag' => 'add_action',
				'hook' => 'wp_head'
			),
*/
			'meta_description' => array(
				'tag' => 'add_action',
				'hook' => 'wp_head'
			),
			'meta_format_detection' => array(
				'tag' => 'add_action',
				'hook' => 'wp_head'
			),
			'canonical' => array(
				'tag' => 'add_action',
				'hook' => 'wp_head'
			),
			'noindex' => array(
				'tag' => 'add_action',
				'hook' => 'wp_head'
			),
		)));

	}// Method


	/* Method
	_________________________
	*/
	private function cleanup()
	{
		/**
			@access (private)
				Filters whether XML-RPC methods requiring authentication are enabled.
				https://developer.wordpress.org/reference/hooks/xmlrpc_enabled/
			@return (void)
		*/
		add_filter('xmlrpc_enabled','__return_false');

	}// Method


	/* Method
	_________________________
	*/
	private function staticize()
	{
		/**
			@access (private)
				Convert emoji to a static img element.
				https://developer.wordpress.org/reference/functions/wp_staticize_emoji/
				Convert emoji in emails into static images.
				https://developer.wordpress.org/reference/functions/wp_staticize_emoji_for_email/
			@return (void)
		*/
		remove_filter('the_content_feed','wp_staticize_emoji');
		remove_filter('comment_text_rss','wp_staticize_emoji');
		remove_filter('wp_mail','wp_staticize_emoji_for_email');

	}// Method


	/* Hook
	_________________________
	*/
	public function admin_bar_bump_cb()
	{
		/**
			@access (public)
				Default admin bar callback.
				https://developer.wordpress.org/reference/functions/_admin_bar_bump_cb/
			@return (void)
		*/

		/**
		 * @reference (WP)
		 * 	Checks if any action has been registered for a hook.
		 * 	https://developer.wordpress.org/reference/functions/has_action/
		*/
		if(has_action('wp_head','_admin_bar_bump_cb')){
			remove_action('wp_head','_admin_bar_bump_cb');
		}

	}// Method


	/* Hook
	_________________________
	*/
	public function remove_dns_prefetch($hints,$relation_type)
	{
		/**
			@access (public)
				Filters domains and URLs for resource hints of relation type.
				https://developer.wordpress.org/reference/hooks/wp_resource_hints/
				Retrieves a list of unique hosts of all enqueued scripts and styles.
				https://developer.wordpress.org/reference/functions/wp_dependencies_unique_hosts/
			@param (array)$urls
				Array of resources and their attributes, or URLs to print for resource hints.
			@param (string)$relation_type
				The relation type the URLs are printed for, e.g. 'preconnect' or 'prerender'.
			@return (string[])
				A list of unique hosts of enqueued scripts and styles.
		*/
		if('dns-prefetch' === $relation_type){
			return array_diff(wp_dependencies_unique_hosts(),$hints);
		}
		return $hints;

	}// Method


	/* Hook
	_________________________
	*/
	public function meta_format_detection()
	{
		/**
			@access (public)
				When running in a browser on a mobile phone,determines whether or not telephone numbers in the HTML content will appear as hypertext links.
				The user can click a link with a telephone number to initiate a phone call to that phone number.
				http://www.html-5.com/metatags/format-detection-meta-tag.html
			@return (void)
				_filter[_env_head][meta_format_detection]
			@reference
				[Parent]/inc/utility/general.php
		*/

		/**
		 * @reference (WP)
		 * 	Determines whether the current request is for an administrative interface page.
		 * 	https://developer.wordpress.org/reference/functions/is_admin/
		*/
		if(is_admin()){return;}

		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		$format_detection = 'telephone=no';

		/**
		 * @reference (WP)
		 * 	Calls the callback functions that have been added to a filter hook.
		 * 	https://developer.wordpress.org/reference/functions/apply_filters/
		*/
		echo apply_filters("_filter[{$class}][{$function}]",sprintf('<meta name="format-detection" value="%s" />',$format_detection));

	}// Method


	/* Hook
	_________________________
	*/
	public function meta_keywords()
	{
		/**
			@access (public)
				Generate the meta keywords for the current post.
			@global (WP_Post) $post
				https://codex.wordpress.org/Global_Variables
			@return (void)
				_filter[_env_head][meta_keywords]
			@reference
				[Parent]/inc/utility/general.php
		*/

		/**
		 * @reference (WP)
		 * 	Determines whether the current request is for an administrative interface page.
		 * 	https://developer.wordpress.org/reference/functions/is_admin/
		*/
		if(is_admin()){return;}

		// Get current post data.
		global $post;
		if(empty($post)){
			$post = __utility_get_post_object();
		}
		if(empty($post)){return;}

		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		$keywords = '';

		if(isset(self::$_field['keywords'])){
			$keywords = get_post_meta($post->ID,self::$_field['keywords'],TRUE);
		}

		/**
		 * @reference (WP)
		 * 	Calls the callback functions that have been added to a filter hook.
		 * 	https://developer.wordpress.org/reference/functions/apply_filters/
		*/
		echo apply_filters("_filter[{$class}][{$function}]",sprintf('<meta name="keywords" value="%s" />',esc_attr($keywords)));

	}// Method


	/* Hook
	_________________________
	*/
	public function meta_description()
	{
		/**
			@access (public)
				Generate the meta description for the current post.
				https://on-ze.com/archives/817
				https://service.plan-b.co.jp/blog/seo/8254/
			@global (WP_Post) $post
				https://developer.wordpress.org/reference/classes/wp_post/
			@return (string)
				_filter[_env_head][meta_description]
			@reference
				[Parent]/inc/utility/general.php
		*/

		/**
		 * @reference (WP)
		 * 	Determines whether the current request is for an administrative interface page.
		 * 	https://developer.wordpress.org/reference/functions/is_admin/
		*/
		if(is_admin()){return;}

		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		$description = self::__get_description();

		/**
		 * @reference (WP)
		 * 	Calls the callback functions that have been added to a filter hook.
		 * 	https://developer.wordpress.org/reference/functions/apply_filters/
		*/
		echo apply_filters("_filter[{$class}][{$function}]",sprintf('<meta name="description" content="%s" />',$description));

	}// Method


	/* Method
	_________________________
	*/
	public static function __get_description()
	{
		/**
			@access (public)
				Generate the meta description for the current post.
				https://on-ze.com/archives/817
				https://service.plan-b.co.jp/blog/seo/8254/
			@global (WP_Post) $post
				https://developer.wordpress.org/reference/classes/wp_post/
			@return (string)
				_filter[_env_head][meta_description]
			@reference
				[Parent]/inc/utility/general.php
		*/
		// Get current post data.
		global $post;
		if(empty($post)){
			$post = __utility_get_post_object();
		}
		if(empty($post)){return;}

		// Get current post data.
		$post_content = get_the_content();
		if(!$post_content){
			$post_content = $post->content;
		}
		$post_id = get_the_id();
		if(!$post_id){
			$post_id = $post->ID;
		}

		if(is_front_page() || is_home()){
			/**
			 * @reference (WP)
			 * 	Determines whether the query is for the front page of the site.
			 * 	https://developer.wordpress.org/reference/functions/is_front_page/
			 * 	Determines whether the query is for the blog homepage.
			 * 	https://developer.wordpress.org/reference/functions/is_home/
			 * 	Retrieves information about the current site.
			 * 	https://developer.wordpress.org/reference/functions/get_bloginfo/
			*/
			$description = get_bloginfo('description','display');

			$paged = (get_query_var('paged')) ? (int)get_query_var('paged') : 1;
			if($paged > 1){
				$description = __('Pages','windmill') . ' ' . $paged . ' | ' . $description;
			}
		}
		elseif(is_singular()){
			// Check the custom field.
			$description = get_post_meta($post_id,self::$_field['description'],TRUE);
			if(empty($description)){
				$description = str_replace(array("\r","\n","\t"),'',$post_content);

				if(stripos($post_content,'<!--nextpage-->') !== 0){
					$paged = (get_query_var('page')) ? (int)get_query_var('page') : 1;
					if($paged > 1){
						$post_content .= ' | ' . 'No.' . $paged;
					}
				}
			}
			$description = mb_strimwidth(strip_tags($post_content),0,140,'...');
		}
		elseif(is_category()){
			/**
			 * @reference (WP)
			 * 	Determines whether the query is for an existing category archive page.
			 * 	https://developer.wordpress.org/reference/functions/is_category/
			 * 	Retrieves category description.
			 * 	https://developer.wordpress.org/reference/functions/category_description/
			*/
			$description = category_description();
			if(empty($description)){
				$category = get_category(get_query_var('cat'),FALSE);
				if(!empty($category->description)){
					$description = $category->description;
				}
				else{
					$description = get_bloginfo('name') . ' | ' . single_cat_title(esc_html__('Category','windmill'));
				}
				$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
				if($paged > 1){
					$description .= ' | ' . 'No.' . $paged;
				}
			}
		}
		elseif(is_tag()){
			/**
			 * @reference (WP)
			 * 	Determines whether the query is for an existing tag archive page.
			 * 	https://developer.wordpress.org/reference/functions/is_tag/
			 * 	Retrieves tag description.
			 * 	https://developer.wordpress.org/reference/functions/tag_description/
			*/
			$description = tag_description();
			if(empty($description)){
				$tag = get_term(get_query_var('tag_id'),FALSE);
				if(!empty($tag->description)){
					$description = $tag->description;
				}
				else{
					$description = get_bloginfo('name') . ' | ' . single_tag_title(esc_html__('Tag','windmill'));
				}
				$paged = (get_query_var('paged')) ? (int)get_query_var('paged') : 1;
				if($paged > 1){
					$description .= ' | ' . 'No.' . $paged;
				}
			}
		}
		elseif(is_tax()){
			/**
			 * @reference (WP)
			 * 	Determines whether the query is for an existing custom taxonomy archive page.
			 * 	https://developer.wordpress.org/reference/functions/is_tax/
			 * 	Retrieves term description.
			 * 	https://developer.wordpress.org/reference/functions/term_description/
			*/
			$description = term_description();
			if(empty($description)){
				$description = get_bloginfo('name') . ' | ' . single_term_title(esc_html__('Term','windmill'));
			}
		}
		elseif(is_author()){
			$user_id = __utility_get_user_id();
			/**
			 * @reference (WP)
			 * 	Determines whether the query is for an existing author archive page.
			 * 	https://developer.wordpress.org/reference/functions/is_author/
			 * 	Retrieves the requested data of the author of the current post.
			 * 	https://developer.wordpress.org/reference/functions/get_the_author_meta/
			*/
			$description = get_the_author_meta('description',$user_id);
			if(empty($description)){
				$description = sprintf(
					esc_html__('Author','windmill') . ' : %s',
					get_the_author_meta('display_name',$user_id)
				);
			}
		}
		else{
			/**
				[NOTE]
					QM says "Trying to get property 'ID' of non-object".
			*/
			// if(!empty($post->content)){
				// $description = mb_strimwidth(strip_tags($post->content),0,140,'...');
			// }
			$description = get_bloginfo('name') . ' | ' . get_bloginfo('description','display');
			if(!empty($post_id)){
				$description .= ' | ' . 'No.' . $post_id;
			}
		}

		return $description;

	}// Method


	/* Hook
	_________________________
	*/
	public function canonical()
	{
		/**
			@access (public)
				Generate the canonical URL for the current page.
				https://techmemo.biz/wordpress/canonical/
				http://ystandard.net
				https://wemo.tech/1670
			@return (string)
				The canonical URL.
				_filter[_env_head][canonical]
			@reference
				[Parent]/inc/utility/general.php
		*/

		/**
		 * @reference (WP)
		 * 	Determines whether the current request is for an administrative interface page.
		 * 	https://developer.wordpress.org/reference/functions/is_admin/
		*/
		if(is_admin()){return;}

		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		$canonical = '';

		if(is_front_page()){
			/**
			 * @reference (WP)
			 * 	Determines whether the query is for the front page of the site.
			 * 	https://developer.wordpress.org/reference/functions/is_front_page/
			 * 	Retrieves the URL for the current site where the front end is accessible.
			 * 	https://developer.wordpress.org/reference/functions/home_url/
			*/
			$canonical = home_url();
		}
		elseif(is_singular()){
			/**
			 * @reference (WP)
			 * 	Determines whether the query is for an existing single post of any post type (post, attachment, page, custom post types)..
			 * 	https://developer.wordpress.org/reference/functions/is_singular/
			*/
			$canonical = get_permalink();
		}
		elseif(is_tax() || is_tag() || is_category()){
			/**
			 * @reference (WP)
			 * 	Determines whether the query is for an existing custom taxonomy archive page.
			 * 	https://developer.wordpress.org/reference/functions/is_tax/
			 * 	Determines whether the query is for an existing tag archive page.
			 * 	https://developer.wordpress.org/reference/functions/is_tag/
			 * 	Determines whether the query is for an existing category archive page.
			 * 	https://developer.wordpress.org/reference/functions/is_category/
			 * 	Retrieves the currently queried object.
			 * 	https://developer.wordpress.org/reference/functions/get_queried_object/
			*/
			$term = get_queried_object();

			/**
			 * @reference (WP)
			 * 	Generate a permalink for a taxonomy term archive.
			 * 	https://developer.wordpress.org/reference/functions/get_term_link/
			*/
			$term_link = get_term_link($term,$term->taxonomy);
			$canonical = (is_wp_error($term_link)) ? '' : $term_link;
		}
		elseif(is_post_type_archive()){
			/**
			 * @reference (WP)
			 * 	Determines whether the query is for an existing post type archive page.
			 * 	https://developer.wordpress.org/reference/functions/is_post_type_archive/
			 * 	Retrieves the value of a query variable in the WP_Query class.
			 * 	https://developer.wordpress.org/reference/functions/get_query_var/
			*/
			$post_type = get_query_var('post_type');
			$post_type = (is_array($post_type)) ? reset($post_type) : $post_type;

			/**
			 * @reference (WP)
			 * 	Retrieves the permalink for a post type archive.
			 * 	https://developer.wordpress.org/reference/functions/get_post_type_archive_link/
			*/
			$canonical = get_post_type_archive_link($post_type);
		}
		elseif(is_author()){
			/**
			 * @reference (WP)
			 * Determines whether the query is for an existing author archive page.
			 * 	https://developer.wordpress.org/reference/functions/is_author/
			 * Retrieve the URL to the author page for the user with the ID provided.
			 * 	https://developer.wordpress.org/reference/functions/get_author_posts_url/
			*/
			$canonical = get_author_posts_url(get_query_var('author'),get_query_var('author_name'));
		}
		elseif(is_date()){
			if(is_day()){
				/**
				 * @reference (WP)
				 * 	Determines whether the query is for an existing date archive.
				 * 	https://developer.wordpress.org/reference/functions/is_date/
				 * 	Determines whether the query is for an existing day archive.
				 * 	https://developer.wordpress.org/reference/functions/is_day/
				 * 	Retrieves the permalink for the day archives with year and month.
				 * 	https://developer.wordpress.org/reference/functions/get_day_link/
				*/
				$canonical = get_day_link(get_query_var('year'),get_query_var('monthnum'),get_query_var('day'));
			}
			elseif(is_month()){
				/**
				 * @reference (WP)
				 * 	Determines whether the query is for an existing month archive.
				 * 	https://developer.wordpress.org/reference/functions/is_month/
				 * 	Retrieves the permalink for the month archives with year.
				 * 	https://developer.wordpress.org/reference/functions/get_month_link/
				*/
				$canonical = get_month_link(get_query_var('year'),get_query_var('monthnum'));
			}
			elseif(is_year()){
				/**
				 * @reference (WP)
				 * 	Determines whether the query is for an existing year archive.
				 * 	https://developer.wordpress.org/reference/functions/is_year/
				 * 	Retrieves the permalink for the year archives.
				 * 	https://developer.wordpress.org/reference/functions/get_year_link/
				*/
				$canonical = get_year_link(get_query_var('year'));
			}
		}
		elseif(is_search()){
			/**
			 * @reference (WP)
			 * 	Determines whether the query is for a search.
			 * 	https://developer.wordpress.org/reference/functions/is_search/
			 * 	Retrieves the permalink for a search.
			 * 	https://developer.wordpress.org/reference/functions/get_search_link/
			*/
			$canonical = get_search_link();
		}
		elseif(is_404()){
			/**
			 * @reference (WP)
			 * 	Determines whether the query has resulted in a 404 (returns no results).
			 * 	https://developer.wordpress.org/reference/functions/is_404/
			 * 	Retrieves the URL for the current site where the front end is accessible.
			 * 	https://developer.wordpress.org/reference/functions/home_url/
			*/
			$canonical = trailingslashit(home_url()) . '404';
		}
		else{
			// is_home()
			$term = get_queried_object();
			if($term){
				$canonical = get_permalink($term->ID);
			}
		}

		/**
		 * @reference (WP)
		 * 	Calls the callback functions that have been added to a filter hook.
		 * 	https://developer.wordpress.org/reference/functions/apply_filters/
		*/
		echo apply_filters("_filter[{$class}][{$function}]",sprintf('<link rel="canonical" href="%s" />',$canonical));

	}// Method


	/* Hook
	_________________________
	*/
	public function noindex()
	{
		/**
			@access (public)
				Generate the meta:robots for the current page.
				https://fukuro-press.com/wordpress-set-noindex-meta-tag/
				http://ystandard.net
				https://wemo.tech/1670
			@return (void)
				The meta:robots.
				_filter[_env_head][noindex]
			@reference
				[Parent]/inc/utility/general.php
		*/

		/**
		 * @reference (WP)
		 * 	Determines whether the current request is for an administrative interface page.
		 * 	https://developer.wordpress.org/reference/functions/is_admin/
		*/
		if(is_admin()){return;}

		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		$noindex = FALSE;

		if(is_front_page()){
			/**
			 * @reference (WP)
			 * 	Determines whether the query is for the front page of the site.
			 * 	https://developer.wordpress.org/reference/functions/is_front_page/
			*/

		}
		elseif(is_singular() || is_home()){
			/**
			 * @reference (WP)
			 * 	Determines whether the query is for an existing single post of any post type (post, attachment, page, custom post types)..
			 * 	https://developer.wordpress.org/reference/functions/is_singular/
			 * 	Determines whether the query is for the blog homepage.
			 * 	https://developer.wordpress.org/reference/functions/is_home/
			*/

		}
		elseif(is_category()){
			/**
			 * @reference (WP)
			 * 	Determines whether the query is for an existing category archive page.
			 * 	https://developer.wordpress.org/reference/functions/is_category/
			*/
			$noindex = TRUE;
		}
		elseif(is_tag()){
			/**
			 * @reference (WP)
			 * 	Determines whether the query is for an existing tag archive page.
			 * 	https://developer.wordpress.org/reference/functions/is_tag/
			*/
			$noindex = TRUE;
		}
		elseif(is_tax()){
			/**
			 * @reference (WP)
			 * 	Determines whether the query is for an existing custom taxonomy archive page.
			 * 	https://developer.wordpress.org/reference/functions/is_tax/
			*/
			$noindex = TRUE;
		}
		elseif(is_post_type_archive()){
			/**
			 * @reference (WP)
			 * 	Determines whether the query is for an existing post type archive page.
			 * 	https://developer.wordpress.org/reference/functions/is_post_type_archive/
			*/
			$noindex = TRUE;
		}
		elseif(is_author()){
			/**
			 * @reference (WP)
			 * 	Determines whether the query is for an existing author archive page.
			 * 	https://developer.wordpress.org/reference/functions/is_author/
			*/
			$noindex = TRUE;
		}
		elseif(is_date()){
			/**
			 * @reference (WP)
			 * 	Determines whether the query is for an existing date archive.
			 * 	https://developer.wordpress.org/reference/functions/is_date/
			*/
			$noindex = TRUE;
		}
		elseif(is_search()){
			/**
			 * @reference (WP)
			 * 	Determines whether the query is for a search.
			 * 	https://developer.wordpress.org/reference/functions/is_search/
			*/
			$noindex = TRUE;
		}
		elseif(is_404()){
			/**
			 * @reference (WP)
			 * 	Determines whether the query has resulted in a 404 (returns no results).
			 * 	https://developer.wordpress.org/reference/functions/is_404/
			*/
			$noindex = TRUE;
		}
		else{

		}

		/**
		 * @reference (WP)
		 * 	Calls the callback functions that have been added to a filter hook.
		 * 	https://developer.wordpress.org/reference/functions/apply_filters/
		*/
		if($noindex){
			$robots = 'noindex,follow';
			echo apply_filters("_filter[{$class}][{$function}]",sprintf('<meta name="robots" content="%s" />',$robots));
		}

	}// Method


}// Class
endif;
// new _env_head();
_env_head::__get_instance();
