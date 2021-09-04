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
if(class_exists('_env_json_ld') === FALSE) :
class _env_json_ld
{
/**
 * [TOC]
 * 	__get_instance()
 * 	__construct()
 * 	set_hook()
 * 	invoke_hook()
 * 	__the_website()
 * 	__the_organization()
 * 	__the_article()
 * 	get_image_object()
 * 	get_publisher()
 * 	get_publisher_image()
 * 	get_custom_logo_id()
 * 	output()
*/

	/**
		@access (private)
			Class properties.
		@var (string) $_class
			Name/Identifier with prefix.
		@var (string) $_index
			Name/Identifier without prefix.
		@var(array) $default
			Array of structured data.
		@var(array) $hook
			Collection of hooks that is being registered (that is, actions or filters).
	*/
	private static $_class = '';
	private static $_index = '';
	private $default = array();
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

		$this->default = array(
			'@context' => 'https://schema.org',
		);

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
				_filter[_env_json_ld][hook]
			@reference (WP)
				Prints scripts or data before the closing body tag on the front end.
				https://developer.wordpress.org/reference/hooks/wp_footer/
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
			'__the_article' => array(
				'tag' => 'add_action',
				'hook' => 'wp_footer'
			),
			'__the_website' => array(
				'tag' => 'add_action',
				'hook' => 'wp_footer'
			),
			'__the_organization' => array(
				'tag' => 'add_action',
				'hook' => 'wp_footer'
			),
		)));

	}// Method


	/* Hook
	_________________________
	*/
	public function __the_website()
	{
		/**
			@access (public)
				Schema.org type WebSite.
				https://schema.org/WebSite
				https://schema.org/SearchAction
				https://developers.google.com/search/docs/data-types/sitelinks-searchbox
			@return (void)
			@reference
				[Parent]/inc/utility/general.php
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		$this->default['@type'] = 'Website';

		/**
		 * @reference (WP)
		 * 	Retrieves the URL for the current site where the front end is accessible.
		 * 	https://developer.wordpress.org/reference/functions/home_url/
		 * 	Retrieves information about the current site.
		 * 	https://developer.wordpress.org/reference/functions/get_bloginfo/
		*/
		$this->default['url'] = home_url('/');
		$this->default['name'] = get_bloginfo('name','display');
		$this->default['alternateName'] = get_bloginfo('name','display');
		if(__utility_is_top_page()){
			$this->default['potentialAction'] = array(
				'@type' => 'SearchAction',
				'target' => home_url('/?s={search_term_string}'),
				'query-input' => 'required name=search_term_string',
			);
		}
		$this->output($this->default);

	}// Method


	/* Hook
	_________________________
	*/
	public function __the_organization()
	{
		/**
			@access (public)
				Schema.org type Organization
				https://schema.org/Organization
				https://developers.google.com/search/docs/data-types/logo
				https://developers.google.com/search/docs/data-types/corporate-contact
				https://developers.google.com/search/docs/data-types/social-profile
			@return (void)
			@reference
				[Parent]/inc/utility/general.php
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		$this->default['@type'] = 'Organization';
		/**
		 * @reference (WP)
		 * 	Retrieves the URL for the current site where the front end is accessible.
		 * 	https://developer.wordpress.org/reference/functions/home_url/
		*/
		$this->default['url'] = home_url('/');

		/**
		 * @reference (WP)
		 * 	Determines whether the site has a custom logo.
		 * 	https://developer.wordpress.org/reference/functions/has_custom_logo/
		*/
		if(has_custom_logo()){
			$logo_id = $this->get_custom_logo_id();
			/**
			 * @reference (WP)
			 * 	Retrieves an image to represent an attachment.
			 * 	https://developer.wordpress.org/reference/functions/wp_get_attachment_image_src/
			*/
			$logo = wp_get_attachment_image_src($logo_id,'full');
			if($logo){
				$this->default['logo'] = array(
					'@type' => 'ImageObject',
					'url' => $logo[0],
					'width' => $logo[1],
					'height' => $logo[2],
				);
			}
		}
		else{
			$this->default['logo'] = array(
				'@type' => 'ImageObject',
				'url' => trailingslashit(get_template_directory_uri()) . 'screenshot.png',
				'width' => 600,
				'height' => 60,
			);
		}
		$this->output($this->default);

	}// Method


	/* Hook
	_________________________
	*/
	public function __the_article()
	{
		/**
			@access (public)
				Schema.org type Article.
				https://schema.org/Article
				https://pending.schema.org/speakable
				https://developers.google.com/search/docs/data-types/articles
				https://developers.google.com/search/docs/data-types/speakable
			@global (WP_Post) $post
				Post object.
				https://codex.wordpress.org/Global_Variables
			@return (void)
			@reference
				[Parent]/inc/utility/general.php
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		/**
		 * @reference (WP)
		 * 	Determines whether the query is for the front page of the site.
		 * 	https://developer.wordpress.org/reference/functions/is_front_page/
		 * 	Determines whether the query has resulted in a 404 (returns no results).
		 * 	https://developer.wordpress.org/reference/functions/is_404/
		*/
		if(is_front_page() || is_404()){return;}

		$article = array();

		// WP global.
		global $posts;
		if(!empty($posts)){
			foreach($posts as $post){

				if(!$post){
					// Get current post data.
					$post = __utility_get_post_object();
				}

				/**
				 * @since 1.0.1
				 * 	Prepare structured data.
				 * 
				 * @reference (WP)
				 * 	Retrieves the full permalink for the current post or post ID.
				 * 	https://developer.wordpress.org/reference/functions/get_the_permalink/
				 * 	Retrieve post title.
				 * 	https://developer.wordpress.org/reference/functions/get_the_title/
				*/
				$url = esc_url_raw(get_the_permalink($post->ID));
				$title = esc_attr(get_the_title($post->ID));

				// Build structured data.
				$this->default['@type'] = 'Article';
				$this->default['mainEntityOfPage'] = array(
					'@type' => 'WebPage',
					'@id' => $url,
				);
				$this->default['url'] = $url;
				$this->default['name'] = $title;
				$this->default['headline'] = mb_substr($title,0,110);

				/**
				 * @reference (WP)
				 * 	Retrieves the post excerpt.
				 * 	https://developer.wordpress.org/reference/functions/get_the_excerpt/
				 * 	Retrieve the post content.
				 * 	https://developer.wordpress.org/reference/functions/get_the_content/
				*/
				$this->default['description'] = esc_attr(get_the_excerpt($post->ID));
				$this->default['articleBody'] = esc_attr(get_the_content($post->ID));

				/**
				 * @reference (WP)
				 * 	Retrieves the requested data of the author of the current post.
				 * 	https://developer.wordpress.org/reference/functions/get_the_author_meta/
				 * 	Retrieve the date on which the post was written.
				 * 	https://developer.wordpress.org/reference/functions/get_the_date/
				 * 	Retrieve the time at which the post was last modified.
				 * 	https://developer.wordpress.org/reference/functions/get_post_modified_time/
				*/
				$this->default['author'] = array(
					'@type' => 'Person',
					'name' => get_the_author_meta('display_name',$post->post_author),
				);
				$this->default['datePublished'] = get_the_date(DATE_ATOM,$post->ID);
				$this->default['dateModified'] = get_post_modified_time(DATE_ATOM,FALSE,$post->ID);

				/**
				 * @reference (WP)
				 * 	Retrieves post categories.
				 * 	https://developer.wordpress.org/reference/functions/get_the_category/
				*/
				$category = get_the_category($post->ID);
				if($category){
					if(1 < count($category)){
						$section = array();
						foreach($category as $item){
							$section[] = $item->name;
						}
						$this->default['articleSection'] = $section;
					}
					else{
						$this->default['articleSection'] = esc_attr($category[0]->name);
					}
				}

				// Merge structured data.
				$article[] = array_merge(
					$this->default,
					$this->get_image_object(),
					$this->get_publisher()
				);
			}
		}
		$this->output($article);

	}// Method


	/**
		@access (private)
			Build ImageObject.
		@param (int) $post_id
			Post ID.
		@return (array)
	*/
	private function get_image_object($post_id = 0)
	{
		$data = array();

		if($post_id == 0){
			// Get current post data.
			$post = __utility_get_post_object();
			$post_id = $post->ID;
		}

		/**
		 * @reference (WP)
		 * 	Retrieve post thumbnail ID.
		 * 	https://developer.wordpress.org/reference/functions/get_post_thumbnail_id/
		*/
		$post_thumbnail_id = get_post_thumbnail_id($post_id);
		if($post_thumbnail_id != '' && $post_thumbnail_id !== FALSE){

			/**
			 * @reference (WP)
			 * 	Retrieves an image to represent an attachment.
			 * 	https://developer.wordpress.org/reference/functions/wp_get_attachment_image_src/
			*/
			$image = wp_get_attachment_image_src($post_thumbnail_id,'full');

			if($image == FALSE){
				$image = wp_get_attachment_image_src($post_thumbnail_id,'full');
			}

			if($image !== FALSE){
				/**
				 * @reference (WP)
				 * 	Retrieves a post meta field for the given post ID.
				 * 	https://developer.wordpress.org/reference/functions/get_post_meta/
				*/
				$image[] = trim(strip_tags(get_post_meta($post_thumbnail_id,'_wp_attachment_image_alt',TRUE)));
			}

			if($image){
				$data['image'] = [
					'@type' => 'ImageObject',
					'url' => $image[0],
					'width' => $image[1],
					'height' => $image[2],
				];
			}
		}

		return $data;

	}// Method


	/**
		@access (private)
			Publisher.
		@return (array)
	*/
	private function get_publisher()
	{
		$data = array();

		/**
		 * @reference (WP)
		 * 	Retrieves information about the current site.
		 * 	https://developer.wordpress.org/reference/functions/get_bloginfo/
		*/
		$data['publisher'] = [
			'@type' => 'Organization',
			'name' => get_bloginfo('name','display'),
		];
		$publisher_img = $this->get_publisher_image();
		if($publisher_img){
			$data['publisher']['logo'] = [
				'@type' => 'ImageObject',
				'url' => $publisher_img[0],
				'width' => $publisher_img[1],
				'height' => $publisher_img[2],
			];
		}
		return $data;

	}// Method


	/**
		@access (private)
			Publisher Image.
		@return (array)
	*/
	private function get_publisher_image()
	{
		/**
		 * @since 1.0.1
		 * 	Default image.
		 * 
		 * @reference (WP)
		 * 	Retrieves template directory URI for current theme.
		 * 	https://developer.wordpress.org/reference/functions/get_template_directory_uri/
		*/
		$image = array(
			trailingslashit(get_template_directory_uri()) . 'screenshot.png',
			600,
			60,
		);

		/**
		 * @since 1.0.1
		 * 	Get the custom log settings.
		 * 
		 * @reference (WP)
		 * 	Retrieves an image to represent an attachment.
		 * 	https://developer.wordpress.org/reference/functions/wp_get_attachment_image_src/
		*/
		$logo_id = $this->get_custom_logo_id();
		if($logo_id){
			$image = wp_get_attachment_image_src($logo_id,'full');
		}
		return $image;

	}// Method


	/**
		@access (private)
			Get the id of the custom logo.
		@param (int) $blog_id
			[Optional].
			ID of the blog in question.
			Default is the ID of the current blog.
		@return (int)
	*/
	private function get_custom_logo_id($blog_id = 0)
	{
		$switched_blog = FALSE;

		/**
		 * @reference (WP)
		 * 	If Multisite is enabled.
		 * 	https://developer.wordpress.org/reference/functions/is_multisite/
		 * 	Retrieve the current site ID.
		 * 	https://developer.wordpress.org/reference/functions/get_current_blog_id/
		*/
		if(is_multisite() && !empty($blog_id) && get_current_blog_id() !== (int) $blog_id){
			/**
			 * @reference (WP)
			 * 	Switch the current blog.
			 * 	https://developer.wordpress.org/reference/functions/switch_to_blog/
			*/
			switch_to_blog($blog_id);
			$switched_blog = TRUE;
		}

		/**
		 * @reference (WP)
		 * 	Retrieves theme modification value for the current theme.
		 * 	https://developer.wordpress.org/reference/functions/get_theme_mod/
		*/
		$custom_logo_id = get_theme_mod('custom_logo');
		if($switched_blog){
			/**
			 * @reference (WP)
			 * 	Restore the current blog, after calling switch_to_blog().
			 * 	https://developer.wordpress.org/reference/functions/restore_current_blog/
			*/
			restore_current_blog();
		}

		return $custom_logo_id;

	}// Method


	/* Method
	_________________________
	*/
	private function output($data = array())
	{
		/**
			@access (private)
				EchoStructured Data of "JSON-LD" to your WebSite.schema type that you can use is "Article","Organization" and "WebSite".
			@param (array) $data
				Data.
			@return (void)
		*/
		if(!is_array($data) || empty($data)){return;}

		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		beans_output_e("_output[{$class}][{$function}]",'<script type="application/ld+json">' . json_encode($data,JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . '</script>');

	}// Method


}// Class
endif;
// new _env_json_ld();
_env_json_ld::__get_instance();
