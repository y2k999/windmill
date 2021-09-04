<?php
/**
 * Render Application.
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
if(class_exists('_app_meta') === FALSE) :
class _app_meta
{
/**
 * [TOC]
 * 	__get_instance()
 * 	__construct()
 * 	set_icon()
 * 	set_param()
 * 	__the_template()
 * 	__the_on()
 * 	__the_updated()
 * 	__the_byline()
 * 	__the_cat_links()
 * 	__the_tags_links()
 * 	__the_comments_link()
*/

	/**
		@access (private)
			Class properties.
		@var (string) $_class
			Name/Identifier with prefix.
		@var (string) $_index
			Name/Identifier without prefix.
		@var (array) $_icon
			Icons for each post meta items.
		@var (array) $_param
			Parameter for the application.
	*/
	private static $_class = '';
	private static $_index = '';
	private static $_icon = array();
	private static $_param = array();

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
				This is only called once, since the only way to instantiate this is with the get_instance() method in trait (singleton.php).
			@return (void)
			@reference
				[Parent]/inc/trait/singleton.php
				[Parent]/inc/trait/theme.php
				[Parent]/inc/utility/general.php
		*/

		// Init properties.
		self::$_class = __utility_get_class(get_class($this));
		self::$_index = __utility_get_index(self::$_class);
		self::$_icon = $this->set_icon(self::$_index);
		self::$_param = $this->set_param(self::$_index);

	}// Method


	/* Method
	_________________________
	*/
	public static function __the_template($args = array())
	{
		/**
			@access (private)
				Load and echo this application.
			@param (array) $args
				Additional arguments passed to this application.
			@return (void)
			@reference
				[Parent]/controller/fragment/image.php
				[Parent]/controller/fragment/meta.php
				[Parent]/inc/setup/constant.php
				[Parent]/template-part/content/content.php
				[Parent]/template-part/content/content-archive.php
				[Parent]/template-part/item/card.php
				[Parent]/template-part/item/gallery.php
				[Parent]/template-part/item/general.php
				[Parent]/template-part/item/list.php
		*/

		/**
		 * @reference (WP)
		 * 	Merge user defined arguments into defaults array.
		 * 	https://developer.wordpress.org/reference/functions/wp_parse_args/
		 * @param (string)|(array)|(object) $args
		 * 	Value to merge with $defaults.
		 * @param (array) $defaults
		 * 	Array that serves as the defaults.
		*/
		self::$_param = wp_parse_args($args,self::$_param);

		$method = '__the_' . str_replace('-','_',self::$_param['type']);
		if(is_callable([__CLASS__,$method])){
			call_user_func([__CLASS__,$method]);
		}

	}// Method


	/* Method
	_________________________
	*/
	private static function __the_byline()
	{
		/**
			@access (private)
			@return (void)
			@reference
				[Parent]/inc/utility/general.php
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		/**
		 * @reference (Beans)
		 * 	HTML markup.
		 * 	https://www.getbeans.io/code-reference/functions/beans_open_markup_e/
		 * 	https://www.getbeans.io/code-reference/functions/beans_output_e/
		 * 	https://www.getbeans.io/code-reference/functions/beans_close_markup_e/
		*/
		beans_output_e("_icon[{$class}][{$function}]",self::$_icon[$function]);

		/* translators: %s: post author */
		beans_output_e("_accessibility[{$class}][{$function}]",sprintf(
			'<span class="screen-reader-text">%s </span>',
			esc_html__('Author','windmill')
		));

		/**
		 * @reference (WP)
		 * 	Retrieve the URL to the author page for the user with the ID provided.
		 * 	https://developer.wordpress.org/reference/functions/get_author_posts_url/
		 * 	Retrieves the requested data of the author of the current post.
		 * 	https://developer.wordpress.org/reference/functions/get_the_author_meta/
		 * 	Retrieve the author of the current post and prints html.
		 * 	https://developer.wordpress.org/reference/functions/get_the_author/
		*/
		beans_open_markup_e("_link[{$class}][{$function}]",'a',array(
			'class' => 'uk-margin-small-left',
			'href' => esc_url(get_author_posts_url(get_the_author_meta('ID',__utility_get_user_id()))),
			'aria-label' => esc_attr('Author','windmill'),
			'rel' => 'author',
			'itemscope' => 'itemscope',
			'itemprop' => 'editor author creator copyrightHolder',
			'itemtype' => 'https://schema.org/Person',
		));
			/* WPCS: XSS OK. */
			beans_output_e("_label[{$class}][{$function}]",sprintf(
				'<span class="byline vcard">%s</span>',
				get_the_author()
			));
		beans_close_markup_e("_link[{$class}][{$function}]",'a');

	}// Method


	/* Method
	_________________________
	*/
	private static function __the_on()
	{
		/**
			@access (private)
			@global (WP_Post) $post
			@global (WP_Query) $wp_query
				https://codex.wordpress.org/Global_Variables
			@return (void)
			@reference
				[Parent]/inc/utility/general.php
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		// Get current post data.
		global $post;
		if(!$post){
			$post = __utility_get_post_object();
		}

		/**
		 * @reference (Beans)
		 * 	HTML markup.
		 * 	https://www.getbeans.io/code-reference/functions/beans_open_markup_e/
		 * 	https://www.getbeans.io/code-reference/functions/beans_output_e/
		 * 	https://www.getbeans.io/code-reference/functions/beans_close_markup_e/
		*/
		beans_output_e("_icon[{$class}][{$function}]",self::$_icon[$function]);

		/* translators: %s: post date */
		beans_output_e("_accessibility[{$class}][{$function}]",sprintf(
			'<span class="screen-reader-text">%s </span>',
			esc_html__('Published','windmill')
		));

		/**
		 * @reference (WP)
		 * 	Retrieve the date on which the post was written and prints html.
		 * 	https://developer.wordpress.org/reference/functions/get_the_date/
		*/
		beans_open_markup_e("_link[{$class}][{$function}]",'a',array(
			'class' => 'uk-margin-small-left',
			'href' => esc_url(get_permalink($post->ID)),
			'aria-label' => esc_attr('Published','windmill'),
		));
			/* WPCS: XSS OK. */
			beans_output_e("_label[{$class}][{$function}]",sprintf(
				'<time class="published" datetime="%1$s" itemprop="datePublished">%2$s</time>',
				// esc_attr(get_the_date(get_option('date_format'))),
				get_the_date(DATE_W3C),
				get_the_date()
			));
		beans_close_markup_e("_link[{$class}][{$function}]",'a');

	}// Method


	/* Method
	_________________________
	*/
	private static function __the_updated()
	{
		/**
			@access (private)
			@global (WP_Post) $post
			@global (WP_Query) $wp_query
				https://codex.wordpress.org/Global_Variables
			@return (void)
			@reference
				[Parent]/inc/utility/general.php
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		// Get current post data.
		global $post;
		if(!$post){
			$post = __utility_get_post_object();
		}

		/**
		 * @reference (Beans)
		 * 	HTML markup.
		 * 	https://www.getbeans.io/code-reference/functions/beans_open_markup_e/
		 * 	https://www.getbeans.io/code-reference/functions/beans_output_e/
		 * 	https://www.getbeans.io/code-reference/functions/beans_close_markup_e/
		*/
		beans_output_e("_icon[{$class}][{$function}]",self::$_icon[$function]);

		/* translators: %s: post date */
		beans_output_e("_accessibility[{$class}][{$function}]",sprintf(
			'<span class="screen-reader-text">%s </span>',
			esc_html__('Updated','windmill')
		));

		/**
		 * @reference (WP)
		 * 	Retrieve the date on which the post was last modified and prints html.
		 * 	https://developer.wordpress.org/reference/functions/get_the_modified_date/
		*/
		beans_open_markup_e("_link[{$class}][{$function}]",'a',array(
			'class' => 'uk-margin-small-left',
			'href' => esc_url(get_permalink($post->ID)),
			'aria-label' => esc_attr('Updated','windmill'),
		));
			/* WPCS: XSS OK. */
			beans_output_e("_label[{$class}][{$function}]",sprintf(
				'<time class="updated" datetime="%1$s" itemprop="dateModified">%2$s</time>',
				// esc_attr(get_the_modified_date(get_option('date_format'))),
				get_the_modified_date(DATE_W3C),
				get_the_modified_date()
			));
		beans_close_markup_e("_link[{$class}][{$function}]",'a');

	}// Method


	/* Method
	_________________________
	*/
	private static function __the_cat_links()
	{
		/**
			@access (private)
			@return (void)
			@reference
				[Parent]/inc/utility/general.php
		*/

		// Get current post data.
		global $post;
		if(!$post){
			$post = __utility_get_post_object();
		}

		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		/**
		 * @reference (Beans)
		 * 	HTML markup.
		 * 	https://www.getbeans.io/code-reference/functions/beans_open_markup_e/
		 * 	https://www.getbeans.io/code-reference/functions/beans_output_e/
		 * 	https://www.getbeans.io/code-reference/functions/beans_close_markup_e/
		*/
		beans_output_e("_icon[{$class}][{$function}]",self::$_icon[$function]);

		/**
		 * @reference (WP)
		 * 	Retrieves post categories.
		 * 	https://developer.wordpress.org/reference/functions/get_the_category/
		*/
		$categories = get_the_category($post->ID);
		if(!$categories){return;}

		/* translators: %s: post date */
		beans_output_e("_accessibility[{$class}][{$function}]",sprintf(
			'<span class="screen-reader-text">%s </span>',
			esc_html__('Category Links','windmill')
		));

		$count = count($categories);
		if($count > 1){
			if(self::$_param['cat-all']){
				/**
				 * @reference (WP)
				 * 	Retrieves category list for a post in either HTML list or custom format.
				 * 	https://developer.wordpress.org/reference/functions/get_the_category_list/
				*/
				beans_output_e("_label[{$class}][{$function}]",get_the_category_list(', ',$post->ID));
			}
			else{
				/**
				 * @reference (WP)
				 * 	Retrieves category link URL and prints html.
				 * 	https://developer.wordpress.org/reference/functions/get_category_link/
				*/
				beans_open_markup_e("_link[{$class}][{$function}]",'a',array(
					'class' => 'uk-margin-small-left',
					'href' => esc_url(get_category_link($categories[0]->cat_ID)),
					'aria-label' => esc_attr('Category Links','windmill'),
					'itemprop' => 'keywords',
				));
					/* WPCS: XSS OK. */
					beans_output_e("_label[{$class}][{$function}]",sprintf(
						'<span class="cat-links"> %s</span>',
						$categories[0]->cat_name
					));
				beans_close_markup_e("_link[{$class}][{$function}]",'a');
			}
		}
		elseif($count === 1){
			beans_open_markup_e("_link[{$class}][{$function}]",'a',array(
				'class' => 'uk-margin-small-left',
				'href' => esc_url(get_category_link($categories[0]->cat_ID)),
				'aria-label' => esc_attr('Category Links','windmill'),
				'itemprop' => 'keywords',
			));
				/* WPCS: XSS OK. */
				beans_output_e("_label[{$class}][{$function}]",sprintf(
					'<span class="cat-links"> %s</span>',
					$categories[0]->cat_name
				));
			beans_close_markup_e("_link[{$class}][{$function}]",'a');
		}

	}// Method


	/* Method
	_________________________
	*/
	private static function __the_tags_links(){
		/**
			@access (private)
			@return (void)
			@reference
				[Parent]/inc/utility/general.php
		*/

		// Get current post data.
		global $post;
		if(!$post){
			$post = __utility_get_post_object();
		}

		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		/**
		 * @reference (Beans)
		 * 	HTML markup.
		 * 	https://www.getbeans.io/code-reference/functions/beans_open_markup_e/
		 * 	https://www.getbeans.io/code-reference/functions/beans_output_e/
		 * 	https://www.getbeans.io/code-reference/functions/beans_close_markup_e/
		*/
		beans_output_e("_icon[{$class}][{$function}]",self::$_icon[$function]);

		/**
		 * @reference (WP)
		 * 	Retrieves the tags for a post.
		 * 	https://developer.wordpress.org/reference/functions/get_the_tags/
		*/
		$posttags = get_the_tags($post->ID);
		if(!$posttags){return;}

		/* translators: %s: post date */
		beans_output_e("_accessibility[{$class}][{$function}]",sprintf(
			'<span class="screen-reader-text">%s </span>',
			esc_html__('Tag Links','windmill')
		));

		$count = count($posttags);
		if($count > 1){
			if(self::$_param['tags-all']){
				/**
				 * @reference (WP)
				 * 	Retrieves the tags for a post formatted as a string.
				 * 	https://developer.wordpress.org/reference/functions/get_the_tag_list/
				*/
				beans_output_e("_label[{$class}][{$function}]",get_the_tag_list('',' ','',$post->ID));
			}
			else{
				/**
				 * @reference (WP)
				 * 	Retrieves the link to the tag and prints html.
				 * 	https://developer.wordpress.org/reference/functions/get_tag_link/
				*/
				beans_open_markup_e("_link[{$class}][{$function}]",'a',array(
					'class' => 'uk-margin-small-left',
					'href' => esc_url(get_tag_link($posttags[0]->term_id)),
					'aria-label' => esc_attr('Tag Links','windmill'),
					'itemprop' => 'keywords',
				));
					/* WPCS: XSS OK. */
					beans_output_e("_label[{$class}][{$function}]",sprintf(
						'<span class="tags-links"> %s</span>',
						$posttags[0]->name
					));
				beans_close_markup_e("_link[{$class}][{$function}]",'a');
			}
		}
		elseif($count === 1){
			beans_open_markup_e("_link[{$class}][{$function}]",'a',array(
				'class' => 'uk-margin-small-left',
				'href' => esc_url(get_tag_link($posttags[0]->term_id)),
				'aria-label' => esc_attr('Tag Links','windmill'),
				'itemprop' => 'keywords',
			));
				/* WPCS: XSS OK. */
				beans_output_e("_label[{$class}][{$function}]",sprintf(
					'<span class="tags-links"> %s</span>',
					$posttags[0]->name
				));
			beans_close_markup_e("_link[{$class}][{$function}]",'a');
		}

	}// Method


	/* Method
	_________________________
	*/
	private static function __the_comments_link()
	{
		/**
			@access (public)
				Retrieves the link to the current post comments and prints html.
				https://developer.wordpress.org/reference/functions/get_comments_link/
			@return (void)
			@reference
				[Parent]/inc/utility/general.php
		*/

		// Get current post data.
		global $post;
		if(!$post){
			$post = __utility_get_post_object();
		}

		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		/**
		 * @reference (Beans)
		 * 	HTML markup.
		 * 	https://www.getbeans.io/code-reference/functions/beans_open_markup_e/
		 * 	https://www.getbeans.io/code-reference/functions/beans_output_e/
		 * 	https://www.getbeans.io/code-reference/functions/beans_close_markup_e/
		*/
		beans_output_e("_icon[{$class}][{$function}]",self::$_icon[$function]);

		/* translators: %s: post date */
		beans_output_e("_accessibility[{$class}][{$function}]",sprintf(
			'<span class="screen-reader-text">%s </span>',
			esc_html__('Comments Links','windmill')
		));

		/**
		 * @reference (WP)
		 * 	Retrieves the link to the current post comments and prints html.
		 * 	https://developer.wordpress.org/reference/functions/get_comments_link/
		*/
		beans_open_markup_e("_link[{$class}][{$function}]",'a',array(
			'class' => 'uk-margin-small-left',
			'href' => esc_url(get_comments_link($post->ID)),
			'aria-label' => esc_attr('Comments Links','windmill'),
		));
			/**
			 * @reference (WP)
			 * 	Retrieves the amount of comments a post has.
			 * 	https://developer.wordpress.org/reference/functions/get_comments_number/
			*/
			/* WPCS: XSS OK. */
			beans_output_e("_label[{$class}][{$function}]",sprintf(
				'<span class="comments-links"> Comments(%s)</span>',
				get_comments_number_text('0','1','%',$post->ID)
			));
		beans_close_markup_e("_link[{$class}][{$function}]",'a');

	}// Method


}// Class
endif;
// new _app_meta();
_app_meta::__get_instance();
